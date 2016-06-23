var elements = document.querySelectorAll('[data-click]');
Array.prototype.forEach.call(elements, function(el, i){
    el.addEventListener('click', function(){
        project[el.getAttribute('data-click')]();
    });
});
