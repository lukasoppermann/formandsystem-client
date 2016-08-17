var project = {};
/* --------------------------
 * Document ready function
*/
function ready(fn) {
  if (document.readyState != 'loading'){
    fn();
  } else {
    document.addEventListener('DOMContentLoaded', fn);
  }
}
/* --------------------------
 * MAIN SCRIPT
 */
ready(function(window){
    // document is ready
    // -------------
    // set menu is scrolled states
    scrollTopOffset(100, function(el){
        el.classList.add('is-scrolled');
    }, function(el){
        el.classList.remove('is-scrolled');
    }, document.querySelector('.o-header'));
// end document ready
}(window));
// -------------
// toggle mobile menu
project.toggle_mobile_menu = function(){
    document.querySelector('.c-nav--pages').classList.toggle('is-active');
}

var positionSectionMenu = function(){
    var menu = document.querySelector('.js-section-menu');
    if(menu !== null){
    	var winWidth = parseInt(window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth);
    	var substract = ((winWidth - 1200)/6);
    	if( winWidth > 1150 && substract > 0){
    		menu.style.right = substract + 'px';
    	}
    	else
    	{
    		menu.style.right = "";
    	}
    }
};
positionSectionMenu();

window.addEventListener('resize', function(f){
	window.clearTimeout(f);
	f = window.setTimeout(function(){
		positionSectionMenu();
	},100);
});


// ---------------------------
// Cards
//
// var findAncestor = function (el, cls) {
//     while ((el = el.parentElement) && !el.classList.contains(cls));
//     return el;
// };
    var references = document.querySelectorAll('.o-reference');
    Array.prototype.forEach.call(references, function(item, i){
        item.querySelector('.js-card-details').addEventListener('click', function(e){
            Array.prototype.forEach.call(document.querySelectorAll('.is-turned'), function(item, i){
                item.classList.remove('is-turned');
            });
            item.classList.add('is-turned');
            // $('.card-overlay').css({'width':$(window).width(),'height':$(window).height()}).addClass('is-active');
        });
        item.querySelector('.js-close').addEventListener('click', function(){
            item.classList.remove('is-turned');
        });
    });

    // $('.card').find('.js-close').on('click', function(){
		// $('.card').find('.js-close').on('click', function(){
		// 	$(this).parents('.card').removeClass('is-active');
		// 	$('.card-overlay').removeClass('is-active');
		// });
		// $('.card-overlay').on('click', function(){
		// 	$('.card.is-active').removeClass('is-active');
		// 	$('.card-overlay').removeClass('is-active');
		// });
