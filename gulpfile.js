// Imports
var gulp = require('gulp');
var mainBowerFiles = require('main-bower-files');
var rename = require('gulp-rename');
var rev = require('gulp-rev');
var del = require('del');
var postcss = require('gulp-postcss');
var concat = require('gulp-concat');
var jsmin = require('gulp-jsmin');
var plumber = require('gulp-plumber');
var svgmin = require('gulp-svgmin');
var svgstore = require('gulp-svgstore');
var cheerio = require('gulp-cheerio');
var notify = require('gulp-notify');
var sourcemaps = require('gulp-sourcemaps');
// actions
gulp.task('clean-build', function(done){
    del(['public/build']).then(function(){
        done();
    });
});
gulp.task('delete-build-files', ['rev'], function(done){
    del([
        'public/build/css/app.css',
        'public/build/js/app.js',
        'public/build/js/external.js',
        'public/build/svgs/svg-sprite.svg'
    ]).then(function(){
        done();
    });
});

gulp.task('build-js', ['clean-build'], function(){
    var files = [];
    var files = mainBowerFiles(['**/*.js'],{
        paths: {
            bowerDirectory: 'resources/bower_components',
            bowerJson: 'bower.json'
        }
    });
    // push includes
    files.push('resources/js/includes/*.js');
    // push other files
    files.push(
        'resources/js/app.js'
    );
    // push rest of js files

    return gulp.src(files)
    .pipe(sourcemaps.init())
    .pipe(concat('app.js'))
    .pipe(jsmin())
    .pipe(sourcemaps.write('/'))
    .pipe(gulp.dest('public/build/js'));
});
// rev
gulp.task('rev', ['build-js', 'css','svgsprite'], function(){
    return gulp.src([
        'public/build/css/app.css',
        'public/build/js/app.js',
        'public/build/js/external.js',
        'public/build/svgs/svg-sprite.svg'
    ], {base: 'public/build'})
        .pipe(rev())
        .pipe(gulp.dest('public/build'))
        .pipe(rev.manifest())
        .pipe(gulp.dest('public/build'));
});
/* ---------- */
/* svg */
gulp.task('svgsprite', ['clean-build'], function() {
  gulp.src('resources/svgs/*.svg')
  .pipe(svgmin({
      plugins: [{
          removeAttrs: {
              attrs: 'fill=[^url]*'
          }
      }]
  }))
  .pipe(rename({prefix: 'svg-icon--'}))
  .pipe(svgstore({inlineSvg: true }))
  .pipe(rename('svg-sprite.svg'))
  .pipe(cheerio({
    run: function ($) {
      $('svg').attr({ style: 'display:none' });
    }
  }))
  .pipe(gulp.dest('public/build/svgs'));
});

// gulp watch
gulp.task('asset-watch', function(){
    gulp.watch([
        'resources/css/*',
        'resources/css/**/*',
        'resources/js/*',
        'resources/js/**/*',
        'resources/svg/*'
    ], ['delete-build-files']);
});

// gulp tasks
gulp.task('default', ['delete-build-files','asset-watch']);

//-----------------------
// POST CSS
gulp.task('css', ['clean-build'], function(){
    return gulp.src([
            'resources/css/includes/*.css',
            'resources/css/*.css',
            'resources/css/pages/*.css'
        ])
        .pipe(sourcemaps.init())
        .pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
        .pipe(concat('app.css'))
        .pipe(postcss([
            require("postcss-import")(),
            require("postcss-url")(),
            require('postcss-will-change'),
            require("cssnano")({
                autoprefixer: false,
                discardComments: {
                    removeAll: true
                },
                zindex: false
            }),
            require("postcss-cssnext")({
                browsers: ['last 2 versions']
            }),
            require("postcss-color-function"),
            require("postcss-reporter")({
                plugins: [
                    "postcss-color-function"
                ]
            }),
        ]))
        .pipe(sourcemaps.write('/'))
        // .pipe(rev())
        .pipe(gulp.dest('public/build/css'));
});
