
(function(root,factory){'use strict';if(typeof define==='function'&&define.amd){define([],function(){return(root.holmes=factory(document));});}else if(typeof exports==='object'){module.exports=factory(document);}else{root.holmes=factory(document);}})(this,function(document){'use strict';function holmes(options){var empty=false;if(typeof options!='object'){throw new Error('The options need to be given inside an object like this:\nholmes({\n\tfind:".result",\n\tdynamic:false\n});\n see also https://haroen.me/holmes/doc/module-holmes.html');}
if(typeof options.find=='undefined'){throw new Error('A find argument is needed. That should be a querySelectorAll for each of the items you want to match individually. You should have something like: \nholmes({\n\tfind:".result"\n});\nsee also https://haroen.me/holmes/doc/module-holmes.html');}
if(typeof options.instant=='undefined'){options.instant=false;}
if(options.instant){start();}else{window.addEventListener('DOMContentLoaded',start);}
function start(){if(typeof options.input=='undefined'){options.input='input[type=search]';}
if(typeof options.placeholder=='undefined'){options.placeholder=false;}
if(typeof options.class=='undefined'){options.class={};}
if(typeof options.class.visible=='undefined'){options.class.visible=false;}
if(typeof options.class.hidden=='undefined'){options.class.hidden='hidden';}
if(typeof options.dynamic=='undefined'){options.dynamic=false;}
if(typeof options.contenteditable=='undefined'){options.contenteditable=false;}
if(typeof options.minCharacters=='undefined'){options.minCharacters=0;}
var search=document.querySelector(options.input);var elements=document.querySelectorAll(options.find);var elementsLength=elements.length;if(options.placeholder){var placeholder=document.createElement('div');placeholder.id="holmes-placeholder";placeholder.classList.add(options.class.hidden);placeholder.innerHTML=options.placeholder;elements[0].parentNode.appendChild(placeholder);}
if(options.class.visible){var i;for(i=0;i<elementsLength;i++){elements[i].classList.add(options.class.visible);}}
search.addEventListener('input',function(){var found=false;if(options.minCharacters){if(options.minCharacters>search.value.length){return;}}
var searchString;if(options.contenteditable){searchString=search.textContent.toLowerCase();}else{searchString=search.value.toLowerCase();}
if(options.dynamic){elements=document.querySelectorAll(options.find);elementsLength=elements.length;}
var i;for(i=0;i<elementsLength;i++){if(elements[i].textContent.toLowerCase().indexOf(searchString)===-1){if(options.class.visible){elements[i].classList.remove(options.class.visible);}
if(!elements[i].classList.contains(options.class.hidden)){elements[i].classList.add(options.class.hidden);if(typeof options.onHidden==='function'){options.onHidden(elements[i]);}}}else{if(options.class.visible){elements[i].classList.add(options.class.visible);}
if(elements[i].classList.contains(options.class.hidden)){elements[i].classList.remove(options.class.hidden);if(empty&&typeof options.onFound==='function'){options.onFound(placeholder);}
if(typeof options.onVisible==='function'){options.onVisible(elements[i]);}
empty=false;}
found=true;}};if(!found&&!empty){empty=true;if(options.placeholder){placeholder.classList.remove(options.class.hidden);}
if(typeof options.onEmpty==='function'){options.onEmpty(placeholder);}}else if(!empty){if(options.placeholder){placeholder.classList.add(options.class.hidden);}}});};holmes.prototype.clear=function(){var search=document.querySelector(options.input);if(options.contenteditable){search.textContent='';}else{search.value='';}
if(options.class.visible){var i,elements=document.querySelectorAll(options.find),elementsLength=elements.length;for(i=0;i<elementsLength;i++){elements[i].classList.remove(options.class.hidden);elements[i].classList.add(options.class.visible);}}
if(options.placeholder){var placeholder=document.getElementById('holmes-placeholder');placeholder.classList.add(options.class.hidden);if(options.class.visible){placeholder.classList.remove(options.class.visible);}}};};return holmes;});var elements=document.querySelectorAll('[data-click]');Array.prototype.forEach.call(elements,function(el,i){el.addEventListener('click',function(){project[el.getAttribute('data-click')]();});});var scrollTopOffset=function(offset,callbackTrue,callbackFalse,parameter){window.addEventListener('scroll',function(f){clearTimeout(f);f=setTimeout(function(){if((document&&document.documentElement.scrollTop||document.body&&document.body.scrollTop||0)>offset){callbackTrue.call(window,parameter)}else{callbackFalse.call(window,parameter)}},10);});}
var project={};function ready(fn){if(document.readyState!='loading'){fn();}else{document.addEventListener('DOMContentLoaded',fn);}}
ready(function(window){scrollTopOffset(100,function(el){el.classList.add('is-scrolled');},function(el){el.classList.remove('is-scrolled');},document.querySelector('.o-header'));}(window));project.toggle_mobile_menu=function(){document.querySelector('.c-nav--pages').classList.toggle('is-active');}
var positionSectionMenu=function(){var menu=document.querySelector('.js-section-menu');if(menu!==null){var winWidth=parseInt(window.innerWidth||document.documentElement.clientWidth||document.body.clientWidth);var substract=((winWidth-1200)/6);if(winWidth>1150&&substract>0){menu.style.right=substract+'px';}
else
{menu.style.right="";}}};positionSectionMenu();window.addEventListener('resize',function(f){window.clearTimeout(f);f=window.setTimeout(function(){positionSectionMenu();},100);});var references=document.querySelectorAll('.o-reference');Array.prototype.forEach.call(references,function(item,i){item.querySelector('.js-card-details').addEventListener('click',function(e){Array.prototype.forEach.call(document.querySelectorAll('.is-turned'),function(item,i){item.classList.remove('is-turned');});item.classList.add('is-turned');});item.querySelector('.js-close').addEventListener('click',function(){item.classList.remove('is-turned');});});if(document.querySelector('.js-collection-search')!==null){var searchInput=document.querySelector('.js-collection-search input');var countDisplay=document.querySelector('.js-searchable-itemCount');var h=new holmes({input:'.js-collection-search input',find:'.js-collection-with-search .o-fragment',placeholder:'<div class="stream-emptyState">keine Ergebnisse</div>',});var updateCount=function(countDisplay){setTimeout(function(){var count=document.querySelectorAll('.js-collection-with-search .o-fragment:not(.hidden)').length;var suffix=count==1?' Ergebnis':' Ergebnisse';countDisplay.innerHTML=count+suffix;},100);}
updateCount(countDisplay);searchInput.addEventListener('input',function(){updateCount(countDisplay);});}
//# sourceMappingURL=app.js.map
