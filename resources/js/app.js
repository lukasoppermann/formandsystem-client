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
