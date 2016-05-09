<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('imageables')->truncate();
        // create images
        // factory('Tests\Models\Image', 50)->create();

        Tests\Models\Fragment::where('type', 'image')->get()->each(function($fragment) {
            // connect this section to 1 to 5 pages
            for( $i = rand(0,5); $i > 0; $i--) {
                Tests\Models\Image::all()->random()->ownedByFragments()->save($fragment);
            }
        });
        Tests\Models\Image::all()->each(function($image) {
            // connect this section to 1 to 5 pages
            for( $i = rand(0,5); $i > 0; $i--) {
                Tests\Models\Image::all()->random()->images()->save($image);
            }
        });
    }
}
