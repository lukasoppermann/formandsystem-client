/*
 * Navigation scroll state
 */
(function(window){
window.scrollTopOffset = function(offset, callbackTrue, callbackFalse, parameter){
    window.addEventListener('scroll', function(f){
        clearTimeout(f);
        f = setTimeout(function(){
            if((document && document.documentElement.scrollTop  || document.body && document.body.scrollTop  || 0 ) > offset ){
                callbackTrue.call(window, parameter)
            }else{
                callbackFalse.call(window, parameter)
            }
        },10);
    });
}
})(window);
