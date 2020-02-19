//== Global variables
window.mUtilElementDataStore = {};
window.mUtilElementDataStoreID = 0;
window.mUtilDelegatedEventHandlers = {};

var mUtil = function() {

    var resizeHandlers = [];

    /** @type {object} breakpoints The device width breakpoints **/
    var breakpoints = {
        sm: 544, // Small screen / phone
        md: 768, // Medium screen / tablet
        lg: 1024, // Large screen / desktop
        xl: 1200 // Extra large screen / wide desktop
    };

    /**
     * Handle window resize event with some
     * delay to attach event handlers upon resize complete
     */
    var _windowResizeHandler = function() {
        var _runResizeHandlers = function() {
            // reinitialize other subscribed elements
            for (var i = 0; i < resizeHandlers.length; i++) {
                var each = resizeHandlers[i];
                each.call();
            }
        };

        var timeout = false; // holder for timeout id
        var delay = 250; // delay after event is "complete" to run callback

        window.addEventListener('resize', function() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                _runResizeHandlers();
            }, delay); // wait 50ms until window resize finishes.
        });
    };

    return {
        /**
         * Class main initializer.
         * @param {object} options.
         * @returns null
         */
        //main function to initiate the theme
        init: function(options) {
            if (options && options.breakpoints) {
                breakpoints = options.breakpoints;
            }

            _windowResizeHandler();
        },

        /**
         * Adds window resize event handler.
         * @param {function} callback function.
         */
        addResizeHandler: function(callback) {
            resizeHandlers.push(callback);
        },

        /**
         * Removes window resize event handler.
         * @param {function} callback function.
         */
        removeResizeHandler: function(callback) {
            for (var i = 0; i < resizeHandlers.length; i++) {
                if (callback === resizeHandlers[i]) {
                    delete resizeHandlers[i];
                }
            }
        },

        /**
         * Trigger window resize handlers.
         */
        runResizeHandlers: function() {
            _runResizeHandlers();
        },

        resize: function() {
            if (typeof(Event) === 'function') {
                // modern browsers
                window.dispatchEvent(new Event('resize'));
            } else {
                // for IE and other old browsers
                // causes deprecation warning on modern browsers
                var evt = window.document.createEvent('UIEvents');
                evt.initUIEvent('resize', true, false, window, 0);
                window.dispatchEvent(evt);
            }
        },

        /**
         * Get GET parameter value from URL.
         * @param {string} paramName Parameter name.
         * @returns {string}
         */
        getURLParam: function(paramName) {
            var searchString = window.location.search.substring(1),
                i, val, params = searchString.split("&");

            for (i = 0; i < params.length; i++) {
                val = params[i].split("=");
                if (val[0] == paramName) {
                    return unescape(val[1]);
                }
            }

            return null;
        },

        /**
         * Checks whether current device is mobile touch.
         * @returns {boolean}
         */
        isMobileDevice: function() {
            return (this.getViewPort().width < this.getBreakpoint('lg') ? true : false);
        },

        /**
         * Checks whether current device is desktop.
         * @returns {boolean}
         */
        isDesktopDevice: function() {
            return mUtil.isMobileDevice() ? false : true;
        },

        /**
         * Gets browser window viewport size. Ref:
         * http://andylangton.co.uk/articles/javascript/get-viewport-size-javascript/
         * @returns {object}
         */
        getViewPort: function() {
            var e = window,
                a = 'inner';
            if (!('innerWidth' in window)) {
                a = 'client';
                e = document.documentElement || document.body;
            }

            return {
                width: e[a + 'Width'],
                height: e[a + 'Height']
            };
        },

        /**
         * Checks whether given device mode is currently activated.
         * @param {string} mode Responsive mode name(e.g: desktop,
         *     desktop-and-tablet, tablet, tablet-and-mobile, mobile)
         * @returns {boolean}
         */
        isInResponsiveRange: function(mode) {
            var breakpoint = this.getViewPort().width;

            if (mode == 'general') {
                return true;
            } else if (mode == 'desktop' && breakpoint >= (this.getBreakpoint('lg') + 1)) {
                return true;
            } else if (mode == 'tablet' && (breakpoint >= (this.getBreakpoint('md') + 1) && breakpoint < this.getBreakpoint('lg'))) {
                return true;
            } else if (mode == 'mobile' && breakpoint <= this.getBreakpoint('md')) {
                return true;
            } else if (mode == 'desktop-and-tablet' && breakpoint >= (this.getBreakpoint('md') + 1)) {
                return true;
            } else if (mode == 'tablet-and-mobile' && breakpoint <= this.getBreakpoint('lg')) {
                return true;
            } else if (mode == 'minimal-desktop-and-below' && breakpoint <= this.getBreakpoint('xl')) {
                return true;
            }

            return false;
        },

        /**
         * Generates unique ID for give prefix.
         * @param {string} prefix Prefix for generated ID
         * @returns {boolean}
         */
        getUniqueID: function(prefix) {
            return prefix + Math.floor(Math.random() * (new Date()).getTime());
        },

        /**
         * Gets window width for give breakpoint mode.
         * @param {string} mode Responsive mode name(e.g: xl, lg, md, sm)
         * @returns {number}
         */
        getBreakpoint: function(mode) {
            return breakpoints[mode];
        },

        /**
         * Checks whether object has property matchs given key path.
         * @param {object} obj Object contains values paired with given key path
         * @param {string} keys Keys path seperated with dots
         * @returns {object}
         */
        isset: function(obj, keys) {
            var stone;

            keys = keys || '';

            if (keys.indexOf('[') !== -1) {
                throw new Error('Unsupported object path notation.');
            }

            keys = keys.split('.');

            do {
                if (obj === undefined) {
                    return false;
                }

                stone = keys.shift();

                if (!obj.hasOwnProperty(stone)) {
                    return false;
                }

                obj = obj[stone];

            } while (keys.length);

            return true;
        },

        /**
         * Gets highest z-index of the given element parents
         * @param {object} el jQuery element object
         * @returns {number}
         */
        getHighestZindex: function(el) {
            var elem = mUtil.get(el),
                position, value;

            while (elem && elem !== document) {
                // Ignore z-index if position is set to a value where z-index is ignored by the browser
                // This makes behavior of this function consistent across browsers
                // WebKit always returns auto if the element is positioned
                position = mUtil.css(elem, 'position');

                if (position === "absolute" || position === "relative" || position === "fixed") {
                    // IE returns 0 when zIndex is not specified
                    // other browsers return a string
                    // we ignore the case of nested elements with an explicit value of 0
                    // <div style="z-index: -10;"><div style="z-index: 0;"></div></div>
                    value = parseInt(mUtil.css(elem, 'z-index'));

                    if (!isNaN(value) && value !== 0) {
                        return value;
                    }
                }

                elem = elem.parentNode;
            }

            return null;
        },

        /**
         * Checks whether the element has any parent with fixed positionfreg
         * @param {object} el jQuery element object
         * @returns {boolean}
         */
        hasFixedPositionedParent: function(el) {
            while (el && el !== document) {
                position = mUtil.css(el, 'position');

                if (position === "fixed") {
                    return true;
                }

                el = el.parentNode;
            }

            return false;
        },

        /**
         * Simulates delay
         */
        sleep: function(milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds) {
                    break;
                }
            }
        },

        /**
         * Gets randomly generated integer value within given min and max range
         * @param {number} min Range start value
         * @param {number} min Range end value
         * @returns {number}
         */
        getRandomInt: function(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        },

        /**
         * Checks whether Angular library is included
         * @returns {boolean}
         */
        isAngularVersion: function() {
            return window.Zone !== undefined ? true : false;
        },

        //== jQuery Workarounds

        //== Deep extend:  $.extend(true, {}, objA, objB);
        deepExtend: function(out) {
            out = out || {};

            for (var i = 1; i < arguments.length; i++) {
                var obj = arguments[i];

                if (!obj)
                    continue;

                for (var key in obj) {
                    if (obj.hasOwnProperty(key)) {
                        if (typeof obj[key] === 'object')
                            out[key] = mUtil.deepExtend(out[key], obj[key]);
                        else
                            out[key] = obj[key];
                    }
                }
            }

            return out;
        },

        //== extend:  $.extend({}, objA, objB);
        extend: function(out) {
            out = out || {};

            for (var i = 1; i < arguments.length; i++) {
                if (!arguments[i])
                    continue;

                for (var key in arguments[i]) {
                    if (arguments[i].hasOwnProperty(key))
                        out[key] = arguments[i][key];
                }
            }

            return out;
        },

        get: function(query) {
            var el;

            if (query === document) {
                return document;
            }

            if (!!(query && query.nodeType === 1)) {
                return query;
            }

            if (el = document.getElementById(query)) {
                return el;
            } else if (el = document.getElementsByTagName(query)) {
                return el[0];
            } else if (el = document.getElementsByClassName(query)) {
                return el[0];
            } else {
                return null;
            }
        },

        getByClass: function(query) {
            var el;

            if (el = document.getElementsByClassName(query)) {
                return el[0];
            } else {
                return null;
            }
        },

        /**
         * Checks whether the element has given classes
         * @param {object} el jQuery element object
         * @param {string} Classes string
         * @returns {boolean}
         */
        hasClasses: function(el, classes) {
            if (!el) {
                return;
            }

            var classesArr = classes.split(" ");

            for (var i = 0; i < classesArr.length; i++) {
                if (mUtil.hasClass(el, mUtil.trim(classesArr[i])) == false) {
                    return false;
                }
            }

            return true;
        },

        hasClass: function(el, className) {
            if (!el) {
                return;
            }

            return el.classList ? el.classList.contains(className) : new RegExp('\\b' + className + '\\b').test(el.className);
        },

        addClass: function(el, className) {
            if (!el || typeof className === 'undefined') {
                return;
            }

            var classNames = className.split(' ');

            if (el.classList) {
                for (var i = 0; i < classNames.length; i++) {
                    if (classNames[i] && classNames[i].length > 0) {
                        el.classList.add(mUtil.trim(classNames[i]));
                    }
                }
            } else if (!mUtil.hasClass(el, className)) {
                for (var i = 0; i < classNames.length; i++) {
                    el.className += ' ' + mUtil.trim(classNames[i]);
                }
            }
        },

        removeClass: function(el, className) {
            if (!el || typeof className === 'undefined') {
                return;
            }

            var classNames = className.split(' ');

            if (el.classList) {
                for (var i = 0; i < classNames.length; i++) {
                    el.classList.remove(mUtil.trim(classNames[i]));
                }
            } else if (mUtil.hasClass(el, className)) {
                for (var i = 0; i < classNames.length; i++) {
                    el.className = el.className.replace(new RegExp('\\b' + mUtil.trim(classNames[i]) + '\\b', 'g'), '');
                }
            }
        },

        triggerCustomEvent: function(el, eventName, data) {
            if (window.CustomEvent) {
                var event = new CustomEvent(eventName, {
                    detail: data
                });
            } else {
                var event = document.createEvent('CustomEvent');
                event.initCustomEvent(eventName, true, true, data);
            }

            el.dispatchEvent(event);
        },

        trim: function(string) {
            return string.trim();
        },

        eventTriggered: function(e) {
            if (e.currentTarget.dataset.triggered) {
                return true;
            } else {
                e.currentTarget.dataset.triggered = true;

                return false;
            }
        },

        remove: function(el) {
            if (el && el.parentNode) {
                el.parentNode.removeChild(el);
            }
        },

        find: function(parent, query) {
            parent = mUtil.get(parent);
            if (parent) {
                return parent.querySelector(query);
            }
        },

        findAll: function(parent, query) {
            parent = mUtil.get(parent);
            if (parent) {
                return parent.querySelectorAll(query);
            }
        },

        insertAfter: function(el, referenceNode) {
            return referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
        },

        parents: function(el, query) {
            function collectionHas(a, b) { //helper function (see below)
                for (var i = 0, len = a.length; i < len; i++) {
                    if (a[i] == b) return true;
                }

                return false;
            }

            function findParentBySelector(el, selector) {
                var all = document.querySelectorAll(selector);
                var cur = el.parentNode;

                while (cur && !collectionHas(all, cur)) { //keep going up until you find a match
                    cur = cur.parentNode; //go up
                }

                return cur; //will return null if not found
            }

            return findParentBySelector(el, query);
        },

        children: function(el, selector, log) {
            if (!el || !el.childNodes) {
                return;
            }

            var result = [],
                i = 0,
                l = el.childNodes.length;

            for (var i; i < l; ++i) {
                if (el.childNodes[i].nodeType == 1 && mUtil.matches(el.childNodes[i], selector, log)) {
                    result.push(el.childNodes[i]);
                }
            }

            return result;
        },

        child: function(el, selector, log) {
            var children = mUtil.children(el, selector, log);

            return children ? children[0] : null;
        },

        matches: function(el, selector, log) {
            var p = Element.prototype;
            var f = p.matches || p.webkitMatchesSelector || p.mozMatchesSelector || p.msMatchesSelector || function(s) {
                return [].indexOf.call(document.querySelectorAll(s), this) !== -1;
            };

            if (el && el.tagName) {
                return f.call(el, selector);
            } else {
                return false;
            }
        },

        data: function(element) {
            element = mUtil.get(element);

            return {
                set: function(name, data) {
                    if (element.customDataTag === undefined) {
                        mUtilElementDataStoreID++;
                        element.customDataTag = mUtilElementDataStoreID;
                    }

                    if (mUtilElementDataStore[element.customDataTag] === undefined) {
                        mUtilElementDataStore[element.customDataTag] = {};
                    }

                    mUtilElementDataStore[element.customDataTag][name] = data;
                },

                get: function(name) {
                    return this.has(name) ? mUtilElementDataStore[element.customDataTag][name] : null;
                },

                has: function(name) {
                    return (mUtilElementDataStore[element.customDataTag] && mUtilElementDataStore[element.customDataTag][name]) ? true : false;
                },

                remove: function(name) {
                    if (this.has(name)) {
                        delete mUtilElementDataStore[element.customDataTag][name];
                    }
                }
            };
        },

        outerWidth: function(el, margin) {
            var width;

            if (margin === true) {
                var width = parseFloat(el.offsetWidth);
                width += parseFloat(mUtil.css(el, 'margin-left')) + parseFloat(mUtil.css(el, 'margin-right'));

                return parseFloat(width);
            } else {
                var width = parseFloat(el.offsetWidth);

                return width;
            }
        },

        offset: function(elem) {
            var rect, win;
            elem = mUtil.get(elem);

            if ( !elem ) {
                return;
            }

            // Return zeros for disconnected and hidden (display: none) elements (gh-2310)
            // Support: IE <=11 only
            // Running getBoundingClientRect on a
            // disconnected node in IE throws an error

            if ( !elem.getClientRects().length ) {
                return { top: 0, left: 0 };
            }

            // Get document-relative position by adding viewport scroll to viewport-relative gBCR
            rect = elem.getBoundingClientRect();
            win = elem.ownerDocument.defaultView;

            return {
                top: rect.top + win.pageYOffset,
                left: rect.left + win.pageXOffset
            };
        },

        height: function(el) {
            return mUtil.css(el, 'height');
        },

        visible: function(el) {
            return !(el.offsetWidth === 0 && el.offsetHeight === 0);
        },

        attr: function(el, name, value) {
            el = mUtil.get(el);

            if (el == undefined) {
                return;
            }

            if (value !== undefined) {
                el.setAttribute(name, value);
            } else {
                return el.getAttribute(name);
            }
        },

        hasAttr: function(el, name) {
            el = mUtil.get(el);

            if (el == undefined) {
                return;
            }

            return el.getAttribute(name) ? true : false;
        },

        removeAttr: function(el, name) {
            el = mUtil.get(el);

            if (el == undefined) {
                return;
            }

            el.removeAttribute(name);
        },

        animate: function(from, to, duration, update, easing, done) {
            /**
             * TinyAnimate.easings
             *  Adapted from jQuery Easing
             */
            var easings = {};
            var easing;

            easings.linear = function(t, b, c, d) {
                return c * t / d + b;
            };

            easing = easings.linear;

            // Early bail out if called incorrectly
            if (typeof from !== 'number' ||
                typeof to !== 'number' ||
                typeof duration !== 'number' ||
                typeof update !== 'function') {
                return;
            }

            // Create mock done() function if necessary
            if (typeof done !== 'function') {
                done = function() {};
            }

            // Pick implementation (requestAnimationFrame | setTimeout)
            var rAF = window.requestAnimationFrame || function(callback) {
                window.setTimeout(callback, 1000 / 50);
            };

            // Animation loop
            var canceled = false;
            var change = to - from;

            function loop(timestamp) {
                var time = (timestamp || +new Date()) - start;

                if (time >= 0) {
                    update(easing(time, from, change, duration));
                }
                if (time >= 0 && time >= duration) {
                    update(to);
                    done();
                } else {
                    rAF(loop);
                }
            }

            update(from);

            // Start animation loop
            var start = window.performance && window.performance.now ? window.performance.now() : +new Date();

            rAF(loop);
        },

        actualCss: function(el, prop, cache) {
            if (el instanceof HTMLElement === false) {
                return;
            }

            if (!el.getAttribute('m-hidden-' + prop) || cache === false) {
                var value;

                // the element is hidden so:
                // making the el block so we can meassure its height but still be hidden
                el.style.cssText = 'position: absolute; visibility: hidden; display: block;';

                if (prop == 'width') {
                    value = el.offsetWidth;
                } else if (prop == 'height') {
                    value = el.offsetHeight;
                }

                el.style.cssText = '';

                // store it in cache
                el.setAttribute('m-hidden-' + prop, value);

                return parseFloat(value);
            } else {
                // store it in cache
                return parseFloat(el.getAttribute('m-hidden-' + prop));
            }
        },

        actualHeight: function(el, cache) {
            return mUtil.actualCss(el, 'height', cache);
        },

        actualWidth: function(el, cache) {
            return mUtil.actualCss(el, 'width', cache);
        },

        getScroll: function(element, method) {
            // The passed in `method` value should be 'Top' or 'Left'
            method = 'scroll' + method;
            return (element == window || element == document) ? (
                self[(method == 'scrollTop') ? 'pageYOffset' : 'pageXOffset'] ||
                (browserSupportsBoxModel && document.documentElement[method]) ||
                document.body[method]
            ) : element[method];
        },

        css: function(el, styleProp, value) {
            el = mUtil.get(el);

            if (!el) {
                return;
            }

            if (value !== undefined) {
                el.style[styleProp] = value;
            } else {
                var value, defaultView = (el.ownerDocument || document).defaultView;
                // W3C standard way:
                if (defaultView && defaultView.getComputedStyle) {
                    // sanitize property name to css notation
                    // (hyphen separated words eg. font-Size)
                    styleProp = styleProp.replace(/([A-Z])/g, "-$1").toLowerCase();
                    return defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
                } else if (el.currentStyle) { // IE
                    // sanitize property name to camelCase
                    styleProp = styleProp.replace(/\-(\w)/g, function(str, letter) {
                        return letter.toUpperCase();
                    });
                    value = el.currentStyle[styleProp];
                    // convert other units to pixels on IE
                    if (/^\d+(em|pt|%|ex)?$/i.test(value)) {
                        return (function(value) {
                            var oldLeft = el.style.left,
                                oldRsLeft = el.runtimeStyle.left;
                            el.runtimeStyle.left = el.currentStyle.left;
                            el.style.left = value || 0;
                            value = el.style.pixelLeft + "px";
                            el.style.left = oldLeft;
                            el.runtimeStyle.left = oldRsLeft;
                            return value;
                        })(value);
                    }
                    return value;
                }
            }
        },

        slide: function(el, dir, speed, callback, recalcMaxHeight) {
            if (!el || (dir == 'up' && mUtil.visible(el) === false) || (dir == 'down' && mUtil.visible(el) === true)) {
                return;
            }

            speed = (speed ? speed : 600);
            var calcHeight = mUtil.actualHeight(el);
            var calcPaddingTop = false;
            var calcPaddingBottom = false;

            if (mUtil.css(el, 'padding-top') && mUtil.data(el).has('slide-padding-top') !== true) {
                mUtil.data(el).set('slide-padding-top', mUtil.css(el, 'padding-top'));
            }

            if (mUtil.css(el, 'padding-bottom') && mUtil.data(el).has('slide-padding-bottom') !== true) {
                mUtil.data(el).set('slide-padding-bottom', mUtil.css(el, 'padding-bottom'));
            }

            if (mUtil.data(el).has('slide-padding-top')) {
                calcPaddingTop = parseInt(mUtil.data(el).get('slide-padding-top'));
            }

            if (mUtil.data(el).has('slide-padding-bottom')) {
                calcPaddingBottom = parseInt(mUtil.data(el).get('slide-padding-bottom'));
            }

            if (dir == 'up') { // up
                el.style.cssText = 'display: block; overflow: hidden;';

                if (calcPaddingTop) {
                    mUtil.animate(0, calcPaddingTop, speed, function(value) {
                        el.style.paddingTop = (calcPaddingTop - value) + 'px';
                    }, 'linear');
                }

                if (calcPaddingBottom) {
                    mUtil.animate(0, calcPaddingBottom, speed, function(value) {
                        el.style.paddingBottom = (calcPaddingBottom - value) + 'px';
                    }, 'linear');
                }

                mUtil.animate(0, calcHeight, speed, function(value) {
                    el.style.height = (calcHeight - value) + 'px';
                }, 'linear', function() {
                    callback();
                    el.style.height = '';
                    el.style.display = 'none';
                });


            } else if (dir == 'down') { // down
                el.style.cssText = 'display: block; overflow: hidden;';

                if (calcPaddingTop) {
                    mUtil.animate(0, calcPaddingTop, speed, function(value) {
                        el.style.paddingTop = value + 'px';
                    }, 'linear', function() {
                        el.style.paddingTop = '';
                    });
                }

                if (calcPaddingBottom) {
                    mUtil.animate(0, calcPaddingBottom, speed, function(value) {
                        el.style.paddingBottom = value + 'px';
                    }, 'linear', function() {
                        el.style.paddingBottom = '';
                    });
                }

                mUtil.animate(0, calcHeight, speed, function(value) {
                    el.style.height = value + 'px';
                }, 'linear', function() {
                    callback();
                    el.style.height = '';
                    el.style.display = '';
                    el.style.overflow = '';
                });
            }
        },

        slideUp: function(el, speed, callback) {
            mUtil.slide(el, 'up', speed, callback);
        },

        slideDown: function(el, speed, callback) {
            mUtil.slide(el, 'down', speed, callback);
        },

        show: function(el, display) {
            el.style.display = (display ? display : 'block');
        },

        hide: function(el) {
            el.style.display = 'none';
        },

        addEvent: function(el, type, handler, one) {
            el = mUtil.get(el);
            if (typeof el !== 'undefined') {
                el.addEventListener(type, handler);
            }
        },

        removeEvent: function(el, type, handler) {
            el = mUtil.get(el);
            el.removeEventListener(type, handler);
        },

        on: function(element, selector, event, handler) {
            if (!selector) {
                return;
            }

            var eventId = mUtil.getUniqueID('event');

            mUtilDelegatedEventHandlers[eventId] = function(e) {
                var targets = element.querySelectorAll(selector);
                var target = e.target;

                while (target && target !== element) {
                    for (var i = 0, j = targets.length; i < j; i++) {
                        if (target === targets[i]) {
                            handler.call(target, e);
                        }
                    }

                    target = target.parentNode;
                }
            };

            mUtil.addEvent(element, event, mUtilDelegatedEventHandlers[eventId]);

            return eventId;
        },

        off: function(element, event, eventId) {
            if (!element || !mUtilDelegatedEventHandlers[eventId]) {
                return;
            }

            mUtil.removeEvent(element, event, mUtilDelegatedEventHandlers[eventId]);

            delete mUtilDelegatedEventHandlers[eventId];
        },

        one: function onetime(el, type, callback) {
            el = mUtil.get(el);

            el.addEventListener(type, function(e) {
                // remove event
                e.target.removeEventListener(e.type, arguments.callee);
                // call handler
                return callback(e);
            });
        },

        hash: function(str) {
            var hash = 0,
                i, chr;

            if (str.length === 0) return hash;
            for (i = 0; i < str.length; i++) {
                chr = str.charCodeAt(i);
                hash = ((hash << 5) - hash) + chr;
                hash |= 0; // Convert to 32bit integer
            }

            return hash;
        },

        animateClass: function(el, animationName, callback) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

            mUtil.addClass(el, 'animated ' + animationName);

            mUtil.one(el, animationEnd, function() {
                mUtil.removeClass(el, 'animated ' + animationName);
            });

            if (callback) {
                mUtil.one(el.animationEnd, callback);
            }
        },

        animateDelay: function(el, value) {
            var vendors = ['webkit-', 'moz-', 'ms-', 'o-', ''];
            for (var i = 0; i < vendors.length; i++) {
                mUtil.css(el, vendors[i] + 'animation-delay', value);
            }
        },

        animateDuration: function(el, value) {
            var vendors = ['webkit-', 'moz-', 'ms-', 'o-', ''];
            for (var i = 0; i < vendors.length; i++) {
                mUtil.css(el, vendors[i] + 'animation-duration', value);
            }
        },

        scrollTo: function(target, offset, duration) {
            var duration = duration ? duration : 500;
            var target = mUtil.get(target);
            var targetPos = target ? mUtil.offset(target).top : 0;
            var scrollPos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
            var from, to;

            if (targetPos > scrollPos) {
                from = targetPos;
                to = scrollPos;
            } else {
                from = scrollPos;
                to = targetPos;
            }

            if (offset) {
                to += offset;
            }

            mUtil.animate(from, to, duration, function(value) {
                document.documentElement.scrollTop = value;
                document.body.parentNode.scrollTop = value;
                document.body.scrollTop = value;
            }); //, easing, done
        },

        scrollTop: function(offset, duration) {
            mUtil.scrollTo(null, offset, duration);
        },

        isArray: function(obj) {
            return obj && Array.isArray(obj);
        },

        ready: function(callback) {
            if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading") {
                callback();
            } else {
                document.addEventListener('DOMContentLoaded', callback);
            }
        },

        isEmpty: function(obj) {
            for (var prop in obj) {
                if (obj.hasOwnProperty(prop)) {
                    return false;
                }
            }

            return true;
        },

        numberString: function(nStr) {
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        },

        detectIE: function() {
            var ua = window.navigator.userAgent;

            // Test values; Uncomment to check result …

            // IE 10
            // ua = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';

            // IE 11
            // ua = 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko';

            // Edge 12 (Spartan)
            // ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0';

            // Edge 13
            // ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586';

            var msie = ua.indexOf('MSIE ');
            if (msie > 0) {
                // IE 10 or older => return version number
                return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
            }

            var trident = ua.indexOf('Trident/');
            if (trident > 0) {
                // IE 11 => return version number
                var rv = ua.indexOf('rv:');
                return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
            }

            var edge = ua.indexOf('Edge/');
            if (edge > 0) {
                // Edge (IE 12+) => return version number
                return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
            }

            // other browser
            return false;
        },

        isRTL: function() {
            return (mUtil.attr(mUtil.get('html'), 'direction') == 'rtl');
        },

        // //== Scroller
        // scrollerInit: function(element, options) {
        //     //== Define init function
        //     function init() {
        //         var ps;
        //         var height;
        //
        //         if (options.height instanceof Function) {
        //             height = parseInt(options.height.call());
        //         } else {
        //             height = parseInt(options.height);
        //         }
        //
        //         //== Destroy scroll on table and mobile modes
        //         if (options.disableForMobile && mUtil.isInResponsiveRange('tablet-and-mobile')) {
        //             if (ps = mUtil.data(element).get('ps')) {
        //                 if (options.resetHeightOnDestroy) {
        //                     mUtil.css(element, 'height', 'auto');
        //                 } else {
        //                     mUtil.css(element, 'overflow', 'auto');
        //                     if (height > 0) {
        //                         mUtil.css(element, 'height', height + 'px');
        //                     }
        //                 }
        //
        //                 ps.destroy();
        //                 ps = mUtil.data(element).remove('ps');
        //             } else if (height > 0){
        //                 mUtil.css(element, 'overflow', 'auto');
        //                 mUtil.css(element, 'height', height + 'px');
        //             }
        //
        //             return;
        //         }
        //
        //         if (height > 0) {
        //             mUtil.css(element, 'height', height + 'px');
        //         }
        //
        //         mUtil.css(element, 'overflow', 'hidden');
        //
        //         //== Init scroll
        //         if (ps = mUtil.data(element).get('ps')) {
        //             ps.update();
        //         } else {
        //             mUtil.addClass(element, 'm-scroller');
        //             ps = new PerfectScrollbar(element, {
        //                 wheelSpeed: 0.5,
        //                 swipeEasing: true,
        //                 wheelPropagation: false,
        //                 minScrollbarLength: 40,
        //                 suppressScrollX: mUtil.isRTL() ? false : true
        //             });
        //
        //             mUtil.data(element).set('ps', ps);
        //         }
        //     }
        //
        //     //== Init
        //     init();
        //
        //     //== Handle window resize
        //     if (options.handleWindowResize) {
        //         mUtil.addResizeHandler(function() {
        //             init();
        //         });
        //     }
        // },

        scrollerUpdate: function(element) {
            var ps;
            if (ps = mUtil.data(element).get('ps')) {
                ps.update();
            }
        },

        scrollersUpdate: function(parent) {
            var scrollers = mUtil.findAll(parent, '.ps');
            for (var i = 0, len = scrollers.length; i < len; i++) {
                mUtil.scrollerUpdate(scrollers[i]);
            }
        },

        scrollerTop: function(element) {
            var ps;
            if (ps = mUtil.data(element).get('ps')) {
                element.scrollTop = 0;
            }
        },

        scrollerDestroy: function(element) {
            var ps;
            if (ps = mUtil.data(element).get('ps')) {
                ps.destroy();
                ps = mUtil.data(element).remove('ps');
            }
        }
    }
}();

//== Initialize mUtil class on document ready
mUtil.ready(function() {
    mUtil.init();
});

/**
 * @class mApp  Metronic App class
 */

var mApp = function() {

    /** @type {object} colors State colors **/
    var colors = {
        brand:      '#716aca',
        metal:      '#c4c5d6',
        light:      '#ffffff',
        accent:     '#00c5dc',
        primary:    '#5867dd',
        success:    '#34bfa3',
        info:       '#36a3f7',
        warning:    '#ffb822',
        danger:     '#f4516c',
        focus:      '#9816f4'
    };

    /**
    * Initializes bootstrap tooltip
    */
    var initTooltip = function(el) {
        var skin = el.data('skin') ? 'm-tooltip--skin-' + el.data('skin') : '';
        var width = el.data('width') === 'auto' ? 'm-tooltop--auto-width' : '';
        var triggerValue = el.data('trigger') ? el.data('trigger') : 'hover';
        var placement = el.data('placement') ? el.data('placement') : 'left';

        el.tooltip({
            trigger: triggerValue,
            template: '<div class="m-tooltip ' + skin + ' ' + width + ' tooltip" role="tooltip">\
                <div class="arrow"></div>\
                <div class="tooltip-inner"></div>\
            </div>'
        });
    };

    /**
    * Initializes bootstrap tooltips
    */
    var initTooltips = function() {
        // init bootstrap tooltips
        $('[data-toggle="m-tooltip"]').each(function() {
            initTooltip($(this));
        });
    };

    /**
    * Initializes bootstrap alerts
    */
    var initAlerts = function() {
        // init bootstrap popover
        $('body').on('click', '[data-close=alert]', function() {
            $(this).closest('.alert').hide();
        });
    };

    return {
        /**
        * Main class initializer
        */
        init: function(options) {
            if (options && options.colors) {
                colors = options.colors;
            }
            mApp.initComponents();
        },

        /**
        * Initializes components
        */
        initComponents: function() {
            initTooltips();
            initAlerts();
        },

        /**
        *
        * @param {object} el jQuery element object
        */
        // wrJangoer function to scroll(focus) to an element
        initTooltips: function() {
            initTooltips();
        },

        /**
        *
        * @param {object} el jQuery element object
        */
        // wrJangoer function to scroll(focus) to an element
        initTooltip: function(el) {
            initTooltip(el);
        },

        /**
        * Blocks element with loading indiciator using http://malsup.com/jquery/block/
        * @param {object} target jQuery element object
        * @param {object} options
        */
        block: function(target, options) {
            var el = $(target);

            options = $.extend(true, {
                opacity: 0.03,
                overlayColor: '#000000',
                state: 'brand',
                type: 'loader',
                size: 'lg',
                centerX: true,
                centerY: true,
                message: '',
                shadow: true,
                width: 'auto'
            }, options);

            var skin;
            var state;
            var loading;

            if (options.type == 'spinner') {
                skin = options.skin ? 'm-spinner--skin-' + options.skin : '';
                state = options.state ? 'm-spinner--' + options.state : '';
                loading = '<div class="m-spinner ' + skin + ' ' + state + '"></div';
            } else {
                skin = options.skin ? 'm-loader--skin-' + options.skin : '';
                state = options.state ? 'm-loader--' + options.state : '';
                size = options.size ? 'm-loader--' + options.size : '';
                loading = '<div class="m-loader ' + skin + ' ' + state + ' ' + size + '"></div';
            }

            if (options.message && options.message.length > 0) {
                var classes = 'm-blockui ' + (options.shadow === false ? 'm-blockui-no-shadow' : '');

                html = '<div class="' + classes + '"><span>' + options.message + '</span><span>' + loading + '</span></div>';

                var el = document.createElement('div');
                mUtil.get('body').prepend(el);
                mUtil.addClass(el, classes);
                el.innerHTML = '<span>' + options.message + '</span><span>' + loading + '</span>';
                options.width = mUtil.actualWidth(el) + 10;
                mUtil.remove(el);

                if (target == 'body') {
                    html = '<div class="' + classes + '" style="margin-left:-'+ (options.width / 2) +'px;"><span>' + options.message + '</span><span>' + loading + '</span></div>';
                }
            } else {
                html = loading;
            }

            var params = {
                message: html,
                centerY: options.centerY,
                centerX: options.centerX,
                css: {
                    top: '30%',
                    left: '50%',
                    border: '0',
                    padding: '0',
                    backgroundColor: 'none',
                    width: options.width
                },
                overlayCSS: {
                    backgroundColor: options.overlayColor,
                    opacity: options.opacity,
                    cursor: 'wait',
                    zIndex: '10'
                },
                onUnblock: function() {
                    if (el && el[0]) {
                        mUtil.css(el[0], 'position', '');
                        mUtil.css(el[0], 'zoom', '');
                    }
                }
            };

            if (target == 'body') {
                params.css.top = '50%';
                $.blockUI(params);
            } else {
                var el = $(target);
                el.block(params);
            }
        },

        /**
        * Un-blocks the blocked element
        * @param {object} target jQuery element object
        */
        unblock: function(target) {
            if (target && target != 'body') {
                $(target).unblock();
            } else {
                $.unblockUI();
            }
        },

        /**
        * Gets state color's hex code by color name
        * @param {string} name Color name
        * @returns {string}
        */
        getColor: function(name) {
            return colors[name];
        }
    };
}();

//== Initialize mApp class on document ready
$(document).ready(function() {
    mApp.init({});
});

var mDropdown = function(elementId, options) {
    //== Main object
    var the = this;
    var init = false;

    //== Get element object
    var element = mUtil.get(elementId);
    var body = mUtil.get('body');

    if (!element) {
        return;
    }

    //== Default options
    var defaultOptions = {
        toggle: 'click',
        hoverTimeout: 300,
        skin: 'light',
        height: 'auto',
        maxHeight: false,
        minHeight: false,
        persistent: false,
        mobileOverlay: true
    };

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var Plugin = {
        /**
         * Run plugin
         * @returns {mdropdown}
         */
        construct: function(options) {
            if (mUtil.data(element).has('dropdown')) {
                the = mUtil.data(element).get('dropdown');
            } else {
                // reset dropdown
                Plugin.init(options);

                Plugin.setup();

                mUtil.data(element).set('dropdown', the);
            }

            return the;
        },

        /**
         * Handles subdropdown click toggle
         * @returns {mdropdown}
         */
        init: function(options) {
            // merge default and user defined options
            the.options = mUtil.deepExtend({}, defaultOptions, options);
            the.events = [];
            the.eventHandlers = {};
            the.open = false;
            
            the.layout = {};
            the.layout.close = mUtil.find(element, '.m-dropdown__close');
            the.layout.toggle = mUtil.find(element, '.m-dropdown__toggle');
            the.layout.arrow = mUtil.find(element, '.m-dropdown__arrow');
            the.layout.wrapper = mUtil.find(element, '.m-dropdown__wrapper');
            the.layout.defaultDropPos = mUtil.hasClass(element, 'm-dropdown--up') ? 'up' : 'down';
            the.layout.currentDropPos = the.layout.defaultDropPos;

            if (mUtil.attr(element, 'm-dropdown-toggle') == "hover") {
                the.options.toggle = 'hover';
            }
        },

        /**
         * Setup dropdown
         */
        setup: function() {
            if (the.options.placement) {
                mUtil.addClass(element, 'm-dropdown--' + the.options.placement);
            }

            if (the.options.align) {
                mUtil.addClass(element, 'm-dropdown--align-' + the.options.align);
            }

            if (the.options.width) {
                mUtil.css(the.layout.wrapper, 'width', the.options.width + 'px');
            }

            if (mUtil.attr(element, 'm-dropdown-persistent') == '1') {
                the.options.persistent = true;
            }

            if (the.options.toggle == 'hover') {    
                mUtil.addEvent(element, 'mouseout', Plugin.hideMouseout);
            } 

            // set zindex
            Plugin.setZindex();
        },

        /**
         * Toggle dropdown
         */
        toggle: function() {
            if (the.open) {
                return Plugin.hide();
            } else {
                return Plugin.show();
            }
        },

        /**
         * Set content
         */
        setContent: function(content) {
            var content = mUtil.find(element, '.m-dropdown__content').innerHTML = content;

            return the;
        },

        /**
         * Show dropdown
         */
        show: function() {
            if (the.options.toggle == 'hover' && mUtil.hasAttr(element, 'hover')) {
                Plugin.clearHovered();
                return the;
            }

            if (the.open) {
                return the;
            }

            if (the.layout.arrow) {
                Plugin.adjustArrowPos();
            }

            Plugin.eventTrigger('beforeShow');

            Plugin.hideOpened();

            mUtil.addClass(element, 'm-dropdown--open');

            if (mUtil.isMobileDevice() && the.options.mobileOverlay) {
                var zIndex = mUtil.css(element, 'z-index') - 1;

                var dropdownoff = mUtil.insertAfter(document.createElement('DIV'), element );

                mUtil.addClass(dropdownoff, 'm-dropdown__dropoff');
                mUtil.css(dropdownoff, 'z-index', zIndex);
                mUtil.data(dropdownoff).set('dropdown', element);
                mUtil.data(element).set('dropoff', dropdownoff);

                mUtil.addEvent(dropdownoff, 'click', function(e) {
                    Plugin.hide();
                    mUtil.remove(this);
                    e.preventDefault();
                });
            }

            element.focus();
            element.setAttribute('aria-expanded', 'true');
            the.open = true;

            //== Update scrollers
            mUtil.scrollersUpdate(element);

            Plugin.eventTrigger('afterShow');

            return the;
        },

        /**
         * Clear dropdown hover
         */
        clearHovered: function() {
            var timeout = mUtil.attr(element, 'timeout');

            mUtil.removeAttr(element, 'hover');            
            mUtil.removeAttr(element, 'timeout');

            clearTimeout(timeout);
        },

        /**
         * Hide hovered dropdown
         */
        hideHovered: function(force) {
            if (force === true) {
                if (Plugin.eventTrigger('beforeHide') === false) {
                    return;
                }

                Plugin.clearHovered();
                mUtil.removeClass(element, 'm-dropdown--open');
                the.open = false;
                Plugin.eventTrigger('afterHide');
            } else {
                if (mUtil.hasAttr(element, 'hover') === true) {
                    return;
                }

                if (Plugin.eventTrigger('beforeHide') === false) {
                    return;
                }

                var timeout = setTimeout(function() {
                    if (mUtil.attr(element, 'hover')) {
                        Plugin.clearHovered();
                        mUtil.removeClass(element, 'm-dropdown--open');
                        the.open = false;
                        Plugin.eventTrigger('afterHide');
                    }
                }, the.options.hoverTimeout);

                mUtil.attr(element, 'hover', '1');            
                mUtil.attr(element, 'timeout', timeout);
            }
        },

        /**
         * Hide clicked dropdown
         */
        hideClicked: function() {
            if (Plugin.eventTrigger('beforeHide') === false) {
                return;
            }

            mUtil.removeClass(element, 'm-dropdown--open');
            mUtil.data(element).remove('dropoff');
            the.open = false;
            Plugin.eventTrigger('afterHide');
        },

        /**
         * Hide dropdown
         */
        hide: function(force) {
            if (the.open === false) {
                return the;
            }

            if (mUtil.isDesktopDevice() && the.options.toggle == 'hover') {
                Plugin.hideHovered(force);
            } else {
                Plugin.hideClicked();
            }

            if (the.layout.defaultDropPos == 'down' && the.layout.currentDropPos == 'up') {
                mUtil.removeClass(element, 'm-dropdown--up');
                the.layout.arrow.prependTo(the.layout.wrapper);
                the.layout.currentDropPos = 'down';
            }

            return the;
        },

        /**
         * Hide on mouseout
         */
        hideMouseout: function() {
            if (mUtil.isDesktopDevice()) {
                Plugin.hide();
            }
        },

        /**
         * Hide opened dropdowns
         */
        hideOpened: function() {
            var query = mUtil.findAll(body, '.m-dropdown.m-dropdown--open');
            
            for (var i = 0, j = query.length; i < j; i++) {
                var dropdown = query[i];
                mUtil.data(dropdown).get('dropdown').hide(true);
            }
        },

        /**
         * Adjust dropdown arrow positions
         */
        adjustArrowPos: function() {
            var width = mUtil.outerWidth(element); // ?

            var alignment = mUtil.hasClass(the.layout.arrow, 'm-dropdown__arrow--right') ? 'right' : 'left';
            var pos = 0;

            if (the.layout.arrow) {
                if ( mUtil.isInResponsiveRange('mobile') && mUtil.hasClass(element, 'm-dropdown--mobile-full-width') ) {
                    pos = mUtil.offset(element).left + (width / 2) - Math.abs( parseInt(mUtil.css(the.layout.arrow, 'width')) / 2) - parseInt(mUtil.css(the.layout.wrapper, 'left'));
                    
                    mUtil.css(the.layout.arrow, 'right', 'auto');
                    mUtil.css(the.layout.arrow, 'left', pos + 'px');
                    
                    mUtil.css(the.layout.arrow, 'margin-left', 'auto');
                    mUtil.css(the.layout.arrow, 'margin-right', 'auto');
                } else if (mUtil.hasClass(the.layout.arrow, 'm-dropdown__arrow--adjust')) {
                    pos = width / 2 - Math.abs( parseInt(mUtil.css(the.layout.arrow, 'width')) / 2);
                    if (mUtil.hasClass(element, 'm-dropdown--align-push')) {
                        pos = pos + 20;
                    }

                    if (alignment == 'right') {
                        if (mUtil.isRTL()) {
                            mUtil.css(the.layout.arrow, 'right', 'auto');
                            mUtil.css(the.layout.arrow, 'left', pos + 'px');
                        } else {
                            mUtil.css(the.layout.arrow, 'left', 'auto');
                            mUtil.css(the.layout.arrow, 'right', pos + 'px');
                        }
                    } else {
                        if (mUtil.isRTL()) {
                            mUtil.css(the.layout.arrow, 'left', 'auto');
                            mUtil.css(the.layout.arrow, 'right', pos + 'px');
                        } else {
                            mUtil.css(the.layout.arrow, 'right', 'auto');
                            mUtil.css(the.layout.arrow, 'left', pos + 'px');
                        }                       
                    }
                }
            }
        },

        /**
         * Get zindex
         */
        setZindex: function() {
            var zIndex = 101; //mUtil.css(the.layout.wrapper, 'z-index');
            var newZindex = mUtil.getHighestZindex(element);
            if (newZindex >= zIndex) {
                zIndex = newZindex + 1;
            }
            
            mUtil.css(the.layout.wrapper, 'z-index', zIndex);
        },

        /**
         * Check persistent
         */
        isPersistent: function() {
            return the.options.persistent;
        },

        /**
         * Check persistent
         */
        isShown: function() {
            return the.open;
        },

        /**
         * Trigger events
         */
        eventTrigger: function(name, args) {
            for (var i = 0; i < the.events.length; i++) {
                var event = the.events[i];
                if (event.name == name) {
                    if (event.one == true) {
                        if (event.fired == false) {
                            the.events[i].fired = true;
                            event.handler.call(this, the, args);
                        }
                    } else {
                        event.handler.call(this, the, args);
                    }
                }
            }
        },

        addEvent: function(name, handler, one) {
            the.events.push({
                name: name,
                handler: handler,
                one: one,
                fired: false
            });
        }
    };

    //////////////////////////
    // ** Public Methods ** //
    //////////////////////////

    /**
     * Set default options 
     */

    the.setDefaults = function(options) {
        defaultOptions = options;
    };

    /**
     * Show dropdown
     * @returns {mDropdown}
     */
    the.show = function() {
        return Plugin.show();
    };

    /**
     * Hide dropdown
     * @returns {mDropdown}
     */
    the.hide = function() {
        return Plugin.hide();
    };

    /**
     * Toggle dropdown
     * @returns {mDropdown}
     */
    the.toggle = function() {
        return Plugin.toggle();
    };

    /**
     * Toggle dropdown
     * @returns {mDropdown}
     */
    the.isPersistent = function() {
        return Plugin.isPersistent();
    };

    /**
     * Check shown state
     * @returns {mDropdown}
     */
    the.isShown = function() {
        return Plugin.isShown();
    };

    /**
     * Set dropdown content
     * @returns {mDropdown}
     */
    the.setContent = function(content) {
        return Plugin.setContent(content);
    };

    /**
     * Register event
     */
    the.on = function(name, handler) {
        return Plugin.addEvent(name, handler);
    };

    /**
     * Register event
     */
    the.one = function(name, handler) {
        return Plugin.addEvent(name, handler, true);
    };

    ///////////////////////////////
    // ** Plugin Construction ** //
    ///////////////////////////////

    //== Run plugin
    Plugin.construct.apply(the, [options]);

    //== Init done
    init = true;

    // Return plugin instance
    return the;
};

//== Plugin global lazy initialization
mUtil.on(document, '[m-dropdown-toggle="click"] .m-dropdown__toggle', 'click', function(e) {
    var element = this.closest('.m-dropdown');  
    var dropdown;

    if (element) {
        if (mUtil.data(element).has('dropdown')) {
            dropdown = mUtil.data(element).get('dropdown');
        } else {                 
            dropdown = new mDropdown(element);
        }             

        dropdown.toggle();

        e.preventDefault();
    } 
});

mUtil.on(document, '[m-dropdown-toggle="hover"] .m-dropdown__toggle', 'click', function(e) {
    if (mUtil.isDesktopDevice()) {
        if (mUtil.attr(this, 'href') == '#') {
            e.preventDefault();
        }
    } else if (mUtil.isMobileDevice()) {
        var element = this.closest('.m-dropdown');
        var dropdown;

        if (element) {
            if (mUtil.data(element).has('dropdown')) {
                dropdown = mUtil.data(element).get('dropdown');
            } else {                        
                dropdown = new mDropdown(element);
            }  

            dropdown.toggle();

            e.preventDefault();
        }
    }
});

mUtil.on(document, '[m-dropdown-toggle="hover"]', 'mouseover', function(e) {
    if (mUtil.isDesktopDevice()) {
        var element = this;
        var dropdown;

        if (element) {
            if (mUtil.data(element).has('dropdown')) {
                dropdown = mUtil.data(element).get('dropdown');
            } else {                        
                dropdown = new mDropdown(element);
            }              

            dropdown.show();

            e.preventDefault();
        }
    }
});

document.addEventListener("click", function(e) {
    var query;
    var body = mUtil.get('body');
    var target = e.target;

    //== Handle dropdown close
    if (query = body.querySelectorAll('.m-dropdown.m-dropdown--open')) {
        for (var i = 0, len = query.length; i < len; i++) {
            var element = query[i];
            if (mUtil.data(element).has('dropdown') === false) {
                return;
            }

            var the = mUtil.data(element).get('dropdown');
            var toggle = mUtil.find(element, '.m-dropdown__toggle');

            if (mUtil.hasClass(element, 'm-dropdown--disable-close')) {
                e.preventDefault();
                e.stopPropagation();
                //return;
            }

            if (toggle && target !== toggle && toggle.contains(target) === false && target.contains(toggle) === false) {
                if (the.isPersistent() === false) {
                    the.hide();
                } 
            } else if (element.contains(target) === false) {
                the.hide();
            }
        }
    }
});
// plugin setup
var mQuicksearch = function(elementId, options) {
    //== Main object
    var the = this;
    var init = false;

    //== Get element object
    var element = mUtil.get(elementId);
    var body = mUtil.get('body');  

    if (!element) {
        return;
    }

    //== Default options
    var defaultOptions = {
        mode: 'default', //'default/dropdown'
        minLength: 1,
        maxHeight: 300,
        requestTimeout: 200, // ajax request fire timeout in milliseconds 
        inputTarget: 'm_quicksearch_input',
        iconCloseTarget: 'm_quicksearch_close',
        iconCancelTarget: 'm_quicksearch_cancel',
        iconSearchTarget: 'm_quicksearch_search',
        
        spinnerClass: 'm-loader m-loader--skin-light m-loader--right',
        hasResultClass: 'm-list-search--has-result',
        
        templates: {
            error: '<div class="m-search-results m-search-results--skin-light"><span class="m-search-result__message">{{message}}</div></div>'
        }
    };

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var Plugin = {
        /**
         * Construct
         */

        construct: function(options) {
            if (mUtil.data(element).has('quicksearch')) {
                the = mUtil.data(element).get('quicksearch');
            } else {
                // reset menu
                Plugin.init(options);

                // build menu
                Plugin.build();

                mUtil.data(element).set('quicksearch', the);
            }

            return the;
        },

        init: function(options) {
            the.element = element;
            the.events = [];

            // merge default and user defined options
            the.options = mUtil.deepExtend({}, defaultOptions, options);

            // search query
            the.query = '';

            // form
            the.form = mUtil.find(element, 'form');

            // input element
            the.input = mUtil.get(the.options.inputTarget);

            // close icon
            the.iconClose = mUtil.get(the.options.iconCloseTarget);

            if (the.options.mode == 'default') {
                // search icon
                the.iconSearch = mUtil.get(the.options.iconSearchTarget);

                // cancel icon
                the.iconCancel = mUtil.get(the.options.iconCancelTarget);
            }

            // dropdown
            the.dropdown = new mDropdown(element, {
                mobileOverlay: false
            });

            // cancel search timeout
            the.cancelTimeout;

            // ajax processing state
            the.processing = false;

            // ajax request fire timeout
            the.requestTimeout = false;
        },

        /**
         * Build plugin
         */
        build: function() {
            // attach input keyup handler
            mUtil.addEvent(the.input, 'keyup', Plugin.search);

            // Prevent enter click
            mUtil.find(element, "form").onkeypress = function(e) {
                var key = e.charCode || e.keyCode || 0;     
                if (key == 13) {
                    e.preventDefault();
                }
            };

            if (the.options.mode == 'default') {
                mUtil.addEvent(the.input, 'focus', Plugin.showDropdown);
                mUtil.addEvent(the.iconCancel, 'click', Plugin.handleCancel);

                mUtil.addEvent(the.iconSearch, 'click', function() {
                    if (mUtil.isInResponsiveRange('tablet-and-mobile')) {
                        mUtil.addClass(body, 'm-header-search--mobile-expanded');
                        the.input.focus();
                    }
                });

                mUtil.addEvent(the.iconClose, 'click', function() {
                    if (mUtil.isInResponsiveRange('tablet-and-mobile')) {
                        mUtil.removeClass(body, 'm-header-search--mobile-expanded');
                        Plugin.closeDropdown();
                    }
                });
            } else if (the.options.mode == 'dropdown') {
                the.dropdown.on('afterShow', function() {
                    the.input.focus();
                });

                mUtil.addEvent(the.iconClose, 'click', Plugin.closeDropdown);
            }
        },

        showProgress: function() {
            the.processing = true;
            mUtil.addClass(the.form, the.options.spinnerClass);
            Plugin.handleCancelIconVisibility('off');

            return the;
        },

        hideProgress: function() {
            the.processing = false;
            mUtil.removeClass(the.form, the.options.spinnerClass);
            Plugin.handleCancelIconVisibility('on');
            mUtil.addClass(element, the.options.hasResultClass);

            return the;
        },

        /**
         * Search handler
         */
        search: function(e) {
            the.query = the.input.value;

            if (the.query.length === 0) {
                Plugin.handleCancelIconVisibility('on');
                mUtil.removeClass(element, the.options.hasResultClass);
                mUtil.removeClass(the.form, the.options.spinnerClass);
            }

            if (the.query.length < the.options.minLength || the.processing == true) {
                return;
            }

            if (the.requestTimeout) {
                clearTimeout(the.requestTimeout);
            }

            the.requestTimeout = false;

            the.requestTimeout = setTimeout(function() {
                Plugin.eventTrigger('search');
            }, the.options.requestTimeout);            

            return the;
        },

        /**
         * Handle cancel icon visibility
         */
        handleCancelIconVisibility: function(status) {
            if (status == 'on') {
                if (the.input.value.length === 0) {
                    if (the.iconCancel) mUtil.css(the.iconCancel, 'visibility', 'hidden');
                    if (the.iconClose) mUtil.css(the.iconClose, 'visibility', 'visible');
                } else {
                    clearTimeout(the.cancelTimeout);
                    the.cancelTimeout = setTimeout(function() {
                        if (the.iconCancel) mUtil.css(the.iconCancel, 'visibility', 'visible');
                        if (the.iconClose) mUtil.css(the.iconClose, 'visibility', 'visible');
                    }, 500);
                }
            } else {
                if (the.iconCancel) mUtil.css(the.iconCancel, 'visibility', 'hidden');
                if (the.iconClose) mUtil.css(the.iconClose, 'visibility', 'hidden');
            }
        },

        /**
         * Cancel handler
         */
        handleCancel: function(e) {
            the.input.value = '';
            mUtil.css(the.iconCancel, 'visibility', 'hidden');
            mUtil.removeClass(element, the.options.hasResultClass);

            Plugin.closeDropdown();
        },

        /**
         * Cancel handler
         */
        closeDropdown: function() {
            the.dropdown.hide();
        },

        /**
         * Show dropdown
         */
        showDropdown: function(e) {
            if (the.dropdown.isShown() == false && the.input.value.length > the.options.minLength && the.processing == false) {
                console.log('show!!!');
                the.dropdown.show();
                if (e) {
                    e.preventDefault();
                    e.stopPropagation();
                }                
            }
        },

        /**
         * Trigger events
         */
        eventTrigger: function(name) {
            //mUtil.triggerCustomEvent(name);
            for (i = 0; i < the.events.length; i++) {
                var event = the.events[i];
                if (event.name == name) {
                    if (event.one == true) {
                        if (event.fired == false) {
                            the.events[i].fired = true;
                            event.handler.call(this, the);
                        }
                    } else {
                        event.handler.call(this, the);
                    }
                }
            }
        },

        addEvent: function(name, handler, one) {
            the.events.push({
                name: name,
                handler: handler,
                one: one,
                fired: false
            });

            return the;
        }
    };

    //////////////////////////
    // ** Public Methods ** //
    //////////////////////////

    /**
     * Set default options 
     */

    the.setDefaults = function(options) {
        defaultOptions = options;
    };

    /**
     * quicksearch off 
     */
    the.search = function() {
        return Plugin.handleSearch();
    };

    the.showResult = function(res) {
        the.dropdown.setContent(res);
        Plugin.showDropdown();

        return the;
    };

    the.showError = function(text) {
        var msg = the.options.templates.error.replace('{{message}}', text);
        the.dropdown.setContent(msg);
        Plugin.showDropdown();

        return the;
    };

    /**
     *  
     */
    the.showProgress = function() {
        return Plugin.showProgress();
    };

    the.hideProgress = function() {
        return Plugin.hideProgress();
    };

    /**
     * quicksearch off 
     */
    the.search = function() {
        return Plugin.search();
    };

    /**
     * Attach event
     * @returns {mQuicksearch}
     */
    the.on = function(name, handler) {
        return Plugin.addEvent(name, handler);
    };

    /**
     * Attach event that will be fired once
     * @returns {mQuicksearch}
     */
    the.one = function(name, handler) {
        return Plugin.addEvent(name, handler, true);
    };

    //== Construct plugin
    Plugin.construct.apply(the, [options]);

    return the;
};
var mLayout = function() {
    var asideMenu;
    var asideMenuOffcanvas;
    var horMenuOffcanvas;
    var asideLeftToggle;
    var quicksearch;
    var mainPortlet;

    //== Hor menu
    var initHorMenu = function() {
        $(document).on('click', '.m-aside-menu .m-menu__item.m-menu__item--submenu', function (e) {
            if ($(this).hasClass('m-menu__item--open')) {
                $(this).removeClass('m-menu__item--open');
                $(this).find('.m-menu__submenu').fadeOut();
            } else {
                $(this).addClass('m-menu__item--open');
                $(this).find('>.m-menu__submenu').fadeIn();
            }
            e.stopPropagation();
        });
    };

    //== Aside menu
    var initLeftAsideMenu = function() {
        //== Init aside menu
        var menu = mUtil.get('m_ver_menu');
        var menuDesktopMode = (mUtil.attr(menu, 'm-menu-dropdown') === '1' ? 'dropdown' : 'accordion');

        var scroll;
        if ( mUtil.attr(menu, 'm-menu-scrollable') === '1' ) {
            scroll = {
                height: function() {
                    if (mUtil.isInResponsiveRange('desktop')) {
                        return mUtil.getViewPort().height - parseInt(mUtil.css('m_header', 'height'));
                    }
                }
            };
        }
    };

    //== Aside
    var initLeftAside = function() {
        // init aside left offcanvas
        var body = mUtil.get('body');
        var asideLeft = mUtil.get('m_aside_left');

        //== Handle minimzied aside hover
        if (mUtil.hasClass(body, 'm-aside-left--fixed')) {
            var insideTm;
            var outsideTm;

            mUtil.addEvent(asideLeft, 'mouseenter', function() {
                if (outsideTm) {
                    clearTimeout(outsideTm);
                    outsideTm = null;
                }

                insideTm = setTimeout(function() {
                    if (mUtil.hasClass(body, 'm-aside-left--minimize') && mUtil.isInResponsiveRange('desktop')) {
                        mUtil.removeClass(body, 'm-aside-left--minimize');
                        mUtil.addClass(body, 'm-aside-left--minimize-hover');
                        asideMenu.scrollerUpdate();
                        asideMenu.scrollerTop();
                    }
                }, 300);
            });

            mUtil.addEvent(asideLeft, 'mouseleave', function() {
                if (insideTm) {
                    clearTimeout(insideTm);
                    insideTm = null;
                }

                outsideTm = setTimeout(function() {
                    if (mUtil.hasClass(body, 'm-aside-left--minimize-hover') && mUtil.isInResponsiveRange('desktop')) {
                        mUtil.removeClass(body, 'm-aside-left--minimize-hover');
                        mUtil.addClass(body, 'm-aside-left--minimize');
                        asideMenu.scrollerUpdate();
                        asideMenu.scrollerTop();
                    }
                }, 500);
            });
        }
    };

    //== Sidebar toggle
    var initLeftAsideToggle = function() {
        $(document).on('click', '#m_aside_left_hide_toggle', function () {
            if ($('body').hasClass('m-aside-left--hide') && !mUtil.isMobileDevice()) {
                $(this).removeClass('m-brand__toggler--active');
                $('body').removeClass('m-aside-left--hide');
            } else {
                $(this).addClass('m-brand__toggler--active');
                $('body').addClass('m-aside-left--hide');
            }
        });
        $(document).on('click', '#m_aside_left_offcanvas_toggle', function () {
            if ($('body').hasClass('m-aside-left--on')) {
                $(this).removeClass('m-brand__toggler--active');
                $('body').removeClass('m-aside-left--on');
                $('#m_aside_left').css({'right': '-300px'});
            } else {
                $(this).addClass('m-brand__toggler--active');
                $('body').addClass('m-aside-left--on');
                $('#m_aside_left').css({'right': '0'});
            }
        });
        $(document).click(function(event) {
            var $target = $(event.target);

            if($target.closest('#m_aside_left').length === 0 && $target[0].id !== 'm_aside_left_offcanvas_toggle' && mUtil.isMobileDevice()) {
                $(this).removeClass('m-brand__toggler--active');
                $('body').removeClass('m-aside-left--on');
                $('#m_aside_left').css({'right': '-300px'});
            }
        });
    };

    //== Sidebar hide
    var initLeftAsideHide = function() {
        $(this).addClass('m-brand__toggler--active');
        $('body').removeClass('m-aside-left--on');
    };

    //== Topbar
    var initTopbar = function() {
        $('#m_aside_header_topbar_mobile_toggle').click(function() {
            $('body').toggleClass('m-topbar--on');
        });
    };

    //== Quicksearch
    var initQuicksearch = function(quickSearchEvents) {
        if ($('#m_quicksearch').length === 0 ) {
            return;
        }

        quicksearch = new mQuicksearch('m_quicksearch', {
            mode: mUtil.attr( 'm_quicksearch', 'm-quicksearch-mode' ), // quick search type
            minLength: 1
        });

        quicksearch.on('search', quickSearchEvents.onKeyUp);

        $(document).on('click', '#m_quicksearch_close', function () {
            quickSearchEvents.onClose();
        });
    };

    //== Scrolltop
    var initScrollTop = function() {

        var handleShownTopScroll = function() {
            if (window.pageYOffset > window.screen.height) {
                $('body').addClass('m-scroll-top--shown');
            } else {
                $('body').removeClass('m-scroll-top--shown');
            }
        };

        $(document).on('click', '#m_scroll_top', function () {
            $([document.documentElement, document.body]).animate({
                scrollTop: $('body').offset().top
            }, 300);
        });


        // handle window scroll
        if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {
            window.addEventListener('touchend', function() {
                handleShownTopScroll();
            });

            window.addEventListener('touchcancel', function() {
                handleShownTopScroll();
            });

            window.addEventListener('touchleave', function() {
                handleShownTopScroll();
            });
        } else {
            window.addEventListener('scroll', function() {
                handleShownTopScroll();
            });
        }
    };

    //== Main portlet(sticky portlet)
    var createMainPortlet = function() {
        return new mPortlet('main_portlet', {
            sticky: {
                offset: parseInt(mUtil.css( mUtil.get('m_header'), 'height')) + parseInt(mUtil.css( mUtil.get('a_top_section'), 'height')),
                zIndex: 90,
                position: {
                    top: function() {
                        return parseInt(mUtil.css( mUtil.get('m_header'), 'height') );
                    },
                    left: function() {
                        var left = parseInt(mUtil.css( mUtil.getByClass('m-content'), 'paddingLeft'));

                        if (mUtil.isInResponsiveRange('desktop')) {
                            //left += parseInt(mUtil.css(mUtil.get('m_aside_left'), 'width') );
                            if (mUtil.hasClass(mUtil.get('body'), 'm-aside-left--minimize')) {
                                left += 78; // need to use hardcoded width of the minimize aside
                            } else {
                                left += 255; // need to use hardcoded width of the aside
                            }
                        }

                        return left;
                    },
                    right: function() {
                        return parseInt(mUtil.css( mUtil.getByClass('m-content'), 'paddingRight') );
                    }
                }
            }
        });
    };

    return {

        init: function() {
            this.initHeader();
            this.initAside();
        },

        initMainPortlet: function() {
            if (!mUtil.get('main_portlet')) {
                return;
            }
        },

        resetMainPortlet: function() {
            mainPortlet.destroySticky();
            mainPortlet = createMainPortlet();
            mainPortlet.initSticky();
        },

        initHeader: function() {
            initHorMenu();
            initTopbar();
            initScrollTop();
        },

        initAside: function() {
            initLeftAside();
            initLeftAsideMenu();
            initLeftAsideToggle();
            initLeftAsideHide();
        },

        getAsideMenu: function() {
            return asideMenu;
        },

        onLeftSidebarToggle: function(handler) {
            if (asideLeftToggle) {
                asideLeftToggle.on('toggle', handler);
            }
        },

        closeMobileAsideMenuOffcanvas: function() {
            if (mUtil.isMobileDevice()) {
                asideMenuOffcanvas.hide();
            }
        },

        closeMobileHorMenuOffcanvas: function() {
            if (mUtil.isMobileDevice()) {
                horMenuOffcanvas.hide();
            }
        },

        initQuicksearch: initQuicksearch
    };
}();

$(document).ready(function() {
    mLayout.init();
});
