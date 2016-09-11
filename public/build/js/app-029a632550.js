/**
 * search for dom elements on your page
 * @module holmes
 */
(function(root, factory) {
  'use strict';

  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define([], function() {
      return (root.holmes = factory(document));
    });
  } else if (typeof exports === 'object') {
    // Node. Does not work with strict CommonJS, but
    // only CommonJS-like environments that support module.exports,
    // like Node.
    module.exports = factory(document);
  } else {
    // Browser globals
    root.holmes = factory(document);
  }
})(this, function(document) {
  // UMD Definition above, do not remove this line

  // To get to know more about the Universal Module Definition
  // visit: https://github.com/umdjs/umd

  'use strict';

  /**
   * search for dom elements on your page
   * @alias module:holmes
   * @param {string} [options.input='input[type=search]']
   *   A <code>querySelector</code> to find the <code>input</code>
   * @param {string} options.find
   *   A <code>querySelectorAll</code> rule to find each of the find terms
   * @param {string=} options.placeholder
   *   Text to show when there are no results (<code>innerHTML</code>)
   * @param {string} [options.class.visible=false]
   *   class to add to matched items
   * @param {string} [options.class.hidden='hidden']
   *   class to add to non-matched items
   * @param {boolean} [options.dynamic=false]
   *   Whether to query for the content of the elements on every input.
   *   If this is <code>false</code>, then only when initializing the script will
   *   fetch the content of the elements to search in. If this is <code>true</code>
   *   then it will refresh on every <code>input</code> event.
   * @param {boolean} [options.contenteditable=false]
   *   whether the input is a contenteditable or not. By default it's
   *   assumed that it's <code>&lt;input&gt;</code>, <code>true</code> here
   *   will use <code>&lt;div contenteditable&gt;</code>
   * @param {boolean} [options.instant=false]
   *   By default Holmes waits for the <code>DOMContentLoaded</code> event to fire
   *   before listening. This is to make sure that all content is available. However
   *   if you exactly know when all your content is available (ajax, your own event or
   *   other situations), you can put this option on <code>true</code>.
   * @param {number} [minCharacters=0] The minimum amount of characters to be typed before
   *   Holmes starts searching. Beware that this also counts when backspacing.
   * @param {onChange} [options.onHidden]
   *   Callback for when an item is hidden.
   * @param {onChange} [options.onVisible]
   *   Callback for when an item is visible again.
   * @param {onChange} [options.onEmpty]
   *   Callback for when no items were found.
   * @param {onChange} [options.onFound]
   *   Callback for when items are found after being empty.
   */
  function holmes(options) {

    var empty = false;

    if (typeof options != 'object') {
      throw new Error('The options need to be given inside an object like this:\nholmes({\n\tfind:".result",\n\tdynamic:false\n});\n see also https://haroen.me/holmes/doc/module-holmes.html');
    }

    // if options.find is missing, the searching won't work so we'll thrown an exceptions
    if (typeof options.find == 'undefined') {
      throw new Error('A find argument is needed. That should be a querySelectorAll for each of the items you want to match individually. You should have something like: \nholmes({\n\tfind:".result"\n});\nsee also https://haroen.me/holmes/doc/module-holmes.html');
    }

    // whether to start immediately or wait on the load of DOMContent
    if (typeof options.instant == 'undefined') {
      options.instant = false;
    }

    if (options.instant) {
      start();
    } else {
      window.addEventListener('DOMContentLoaded', start);
    }

    // start listening
    function start() {

      // setting default values
      if (typeof options.input == 'undefined') {
        options.input = 'input[type=search]';
      }
      if (typeof options.placeholder == 'undefined') {
        options.placeholder = false;
      }
      if (typeof options.class == 'undefined') {
        options.class = {};
      }
      if (typeof options.class.visible == 'undefined') {
        options.class.visible = false;
      }
      if (typeof options.class.hidden == 'undefined') {
        options.class.hidden = 'hidden';
      }
      if (typeof options.dynamic == 'undefined') {
        options.dynamic = false;
      }
      if (typeof options.contenteditable == 'undefined') {
        options.contenteditable = false;
      }
      if (typeof options.minCharacters == 'undefined') {
        options.minCharacters = 0;
      }

      // find the search and the elements
      var search = document.querySelector(options.input);
      var elements = document.querySelectorAll(options.find);
      var elementsLength = elements.length;

      /**
       * The amount of elements that are hidden
       * @type {Number}
       */
      holmes.prototype.hidden = 0;

      // create a container for a placeholder
      if (options.placeholder) {
        var placeholder = document.createElement('div');
        placeholder.id = "holmes-placeholder";
        placeholder.classList.add(options.class.hidden);
        placeholder.innerHTML = options.placeholder;
        elements[0].parentNode.appendChild(placeholder);
      }

      // if a visible class is given, give it to everything
      if (options.class.visible) {
        var i;
        for (i = 0; i < elementsLength; i++) {
          elements[i].classList.add(options.class.visible);
        }
      }

      // listen for input
      search.addEventListener('input', function() {

        // by default the value isn't found
        var found = false;

        // if a minimum of characters is required
        // check if that limit has been reached
        if (options.minCharacters) {
          if (options.minCharacters > search.value.length && search.value.length !== 0) {
            return;
          }
        }

        // search in lowercase
        var searchString;
        if (options.contenteditable) {
          searchString = search.textContent.toLowerCase();
        } else {
          searchString = search.value.toLowerCase();
        }

        // if the dynamic option is enabled, then we should query
        // for the contents of `elements` on every input
        if (options.dynamic) {
          elements = document.querySelectorAll(options.find);
          elementsLength = elements.length;
        }

        // loop over all the elements
        // in case this should become dynamic, query for the elements here
        var i;
        for (i = 0; i < elementsLength; i++) {

          // if the current element doesn't contain the search string
          // add the hidden class and remove the visbible class
          if (elements[i].textContent.toLowerCase().indexOf(searchString) === -1) {
            if (options.class.visible) {
              elements[i].classList.remove(options.class.visible);
            }
            if (!elements[i].classList.contains(options.class.hidden)) {
              elements[i].classList.add(options.class.hidden);
              holmes.prototype.hidden++;

              if (typeof options.onHidden === 'function') {
                options.onHidden(elements[i]);
              }
            }
          // else
          // remove the hidden class and add the visible
          } else {
            if (options.class.visible) {
              elements[i].classList.add(options.class.visible);
            }
            if (elements[i].classList.contains(options.class.hidden)) {
              elements[i].classList.remove(options.class.hidden);
              holmes.prototype.hidden--;

              if (empty && typeof options.onFound === 'function') {
                options.onFound(placeholder);
              }
              if (typeof options.onVisible === 'function') {
                options.onVisible(elements[i]);
              }
              empty = false;
            }

            // the element is now found at least once
            found = true;
          }
        };

        // No results were found and last time we checked it wasn't empty
        if (!found && !empty) {
          empty = true;

          if (options.placeholder) {
            placeholder.classList.remove(options.class.hidden);
          }
          if (typeof options.onEmpty === 'function') {
            options.onEmpty(placeholder);
          }
        } else if(!empty) {
          if (options.placeholder) {
            placeholder.classList.add(options.class.hidden);
          }
        }
      });
    };

    /**
     * empty the search string programmatically.
     * This avoids having to send a new `input` event
     */
    holmes.prototype.clear = function() {
      var search = document.querySelector(options.input);
      if (options.contenteditable) {
        search.textContent = '';
      } else {
        search.value = '';
      }
      // if a visible class is given, give it to everything
      if (options.class.visible) {
        var i,
          elements = document.querySelectorAll(options.find),
          elementsLength = elements.length;
        for (i = 0; i < elementsLength; i++) {
          elements[i].classList.remove(options.class.hidden);
          elements[i].classList.add(options.class.visible);
        }
      }
      if (options.placeholder) {
        var placeholder = document.getElementById('holmes-placeholder');
        placeholder.classList.add(options.class.hidden);
        if (options.class.visible) {
          placeholder.classList.remove(options.class.visible);
        }
      }
    };

    /**
     * Show the amount of elements, and those hidden and visible
     * @return {object} all matching elements, the amount of hidden and the amount of visible elements
     */
    holmes.prototype.count = function() {
      var find = document.querySelectorAll(options.find);
      var all = find.length;
      var hidden = holmes.prototype.hidden;
      var visible = all - hidden;
      return {
        all,
        hidden,
        visible
      };
    }

  };

  /**
   * Callback used for changes in item en list states.
   * @callback onChange
   * @param {object} [element]
   *   Element affected by the event. This is the item found by
   *   <code>onVisible</code> and <code>onHidden</code> and the placeholder
   *   (or <code>undefined</code>) for <code>onEmpty</code> and
   *   <code>onFound</code>.
   */

  return holmes;

});

(function(window){
    var elements = document.querySelectorAll('[data-click]');
    Array.prototype.forEach.call(elements, function(el, i){
        el.addEventListener('click', function(){
            project[el.getAttribute('data-click')]();
        });
    });
})(window);

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

(function (root, smoothScroll) {
  'use strict';

  // Support RequireJS and CommonJS/NodeJS module formats.
  // Attach smoothScroll to the `window` when executed as a <script>.

  // RequireJS
  if (typeof define === 'function' && define.amd) {
    define(smoothScroll);

  // CommonJS
  } else if (typeof exports === 'object' && typeof module === 'object') {
    module.exports = smoothScroll();

  } else {
    root.smoothScroll = smoothScroll();
  }

})(this, function(){
'use strict';

// Do not initialize smoothScroll when running server side, handle it in client:
if (typeof window !== 'object') return;

// We do not want this script to be applied in browsers that do not support those
// That means no smoothscroll on IE9 and below.
if(document.querySelectorAll === void 0 || window.pageYOffset === void 0 || history.pushState === void 0) { return; }

// Get the top position of an element in the document
var getTop = function(element) {
    // return value of html.getBoundingClientRect().top ... IE : 0, other browsers : -pageYOffset
    if(element.nodeName === 'HTML') return -window.pageYOffset
    return element.getBoundingClientRect().top + window.pageYOffset;
}
// ease in out function thanks to:
// http://blog.greweb.fr/2012/02/bezier-curve-based-easing-functions-from-concept-to-implementation/
var easeInOutCubic = function (t) { return t<.5 ? 4*t*t*t : (t-1)*(2*t-2)*(2*t-2)+1 }

// calculate the scroll position we should be in
// given the start and end point of the scroll
// the time elapsed from the beginning of the scroll
// and the total duration of the scroll (default 500ms)
var position = function(start, end, elapsed, duration) {
    if (elapsed > duration) return end;
    return start + (end - start) * easeInOutCubic(elapsed / duration); // <-- you can change the easing funtion there
    // return start + (end - start) * (elapsed / duration); // <-- this would give a linear scroll
}

// we use requestAnimationFrame to be called by the browser before every repaint
// if the first argument is an element then scroll to the top of this element
// if the first argument is numeric then scroll to this location
// if the callback exist, it is called when the scrolling is finished
// if context is set then scroll that element, else scroll window 
var smoothScroll = function(el, duration, callback, context){
    duration = duration || 500;
    context = context || window;
    var start = window.pageYOffset;

    if (typeof el === 'number') {
      var end = parseInt(el);
    } else {
      var end = getTop(el);
    }

    var clock = Date.now();
    var requestAnimationFrame = window.requestAnimationFrame ||
        window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame ||
        function(fn){window.setTimeout(fn, 15);};

    var step = function(){
        var elapsed = Date.now() - clock;
        if (context !== window) {
        	context.scrollTop = position(start, end, elapsed, duration);
        }
        else {
        	window.scroll(0, position(start, end, elapsed, duration));
        }

        if (elapsed > duration) {
            if (typeof callback === 'function') {
                callback(el);
            }
        } else {
            requestAnimationFrame(step);
        }
    }
    step();
}

var linkHandler = function(ev) {
    ev.preventDefault();

    if (location.hash !== this.hash) window.history.pushState(null, null, this.hash)
    // using the history api to solve issue #1 - back doesn't work
    // most browser don't update :target when the history api is used:
    // THIS IS A BUG FROM THE BROWSERS.
    // change the scrolling duration in this call
    smoothScroll(document.getElementById(this.hash.substring(1)), 500, function(el) {
        location.replace('#' + el.id)
        // this will cause the :target to be activated.
    });
}

// We look for all the internal links in the documents and attach the smoothscroll function
document.addEventListener("DOMContentLoaded", function () {
    var internal = document.querySelectorAll('a[href^="#"]:not([href="#"])'), a;
    for(var i=internal.length; a=internal[--i];){
        a.addEventListener("click", linkHandler, false);
    }
});

// return smoothscroll API
return smoothScroll;

});

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

        var links = menu.querySelectorAll('.js-section-menu-link a');
        Array.prototype.forEach.call(links, function(item){
            item.addEventListener('click', function(e){
                e.preventDefault();
                smoothScroll(document.querySelector(item.getAttribute('href')));
            });
        });
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
    var references = document.querySelectorAll('.o-reference');
    Array.prototype.forEach.call(references, function(item, i){
        item.querySelector('.js-card-details').addEventListener('click', function(e){
            Array.prototype.forEach.call(document.querySelectorAll('.is-turned'), function(item, i){
                item.classList.remove('is-turned');
            });
            item.classList.add('is-turned');
        });
        item.querySelector('.js-close').addEventListener('click', function(){
            item.classList.remove('is-turned');
        });
    });
    // ---------------------------
    // Search
    //
    if(document.querySelector('.js-collection-search') !== null){
        var searchInput = document.querySelector('.js-collection-search input');
        var countDisplay = document.querySelector('.js-searchable-itemCount');
        var h = new holmes({
          input: '.js-collection-search input',
          find: '.js-collection-with-search .o-fragment',
          minCharacters: 3,
          placeholder: '<div class="stream-emptyState">keine Ergebnisse</div>',
        });

    var updateCount = function(holmes, countDisplay){
        setTimeout(function(){
            count = holmes.count().visible;
            var suffix = count == 1 ? ' Ergebnis' : ' Ergebnisse';
            countDisplay.innerHTML =  count + suffix;
        },100);
    }
    updateCount(h, countDisplay);

    searchInput.addEventListener('input', function(){
        updateCount(h, countDisplay);
    });
}

//# sourceMappingURL=app.js.map
