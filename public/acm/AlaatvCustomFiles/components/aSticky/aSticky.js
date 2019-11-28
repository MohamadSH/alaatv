// Sticky Plugin v1.0.4 for jQuery
// =============
// Author: Anthony Garand
// Improvements by German M. Bravo (Kronuz) and Ruud Kamphuis (ruudk)
// Improvements by Leonardo C. Daronco (daronco)
// Created: 02/14/2011
// Date: 07/20/2015
// Website: http://stickyjs.com/
// Description: Makes an element on the page stick on the screen as you scroll
//              It will only set the 'top' and 'position' of your element, you
//              might need to adjust the width in some cases.

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node/CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {
    var slice = Array.prototype.slice; // save ref to original slice()
    var splice = Array.prototype.splice; // save ref to original slice()

    var defaults = {
            topSpacing: 0,
            bottomSpacing: 0,
            scrollDirectionSensitive: false,
            unstickUnder: false,
            className: 'is-sticky',
            wrapperClassName: 'sticky-wrapper',
            center: false,
            container: '',
            hidePosition: {
                element: '',
                topSpace: 0
            },
            getWidthFrom: '',
            widthFromWrapper: true, // works only when .getWidthFrom is empty
            responsiveWidth: false,
            zIndex: 'auto'
        },
        extendedOptions = {},
        $window = $(window),
        $document = $(document),
        sticked = [],
        windowHeight = $window.height(),
        scroller = function () {

            // detect scroll direction
            var st = $(this).scrollTop(),
                scrollDirection = 'down';
            if (st > lastScrollTop) {
                scrollDirection = 'down';
            } else {
                scrollDirection = 'up';
            }
            lastScrollTop = st;

            var scrollTop = $window.scrollTop(),
                documentHeight = $document.height(),
                dwh = documentHeight - windowHeight,
                extra = (scrollTop > dwh) ? dwh - scrollTop : 0,
                stickedLength = sticked.length;

            for (var i = 0, l = stickedLength; i < l; i++) {
                var s = sticked[i],
                    elementTop = s.stickyWrapper.offset().top,
                    etse = elementTop - s.topSpacing - extra,
                    containerScrollPosition = false,
                    hidePositionTarget = false;

                if (s.unstickUnder!==false && $window.width()<s.unstickUnder) {
                    s.stickyElement
                        .css({
                            'width': '',
                            'position': '',
                            'top': '',
                            'z-index': ''
                        });
                    s.stickyElement.parent().css('height', 'auto');
                } else {

                    if (s.container !== '' && $(s.container).length > 0) {
                        var containerTop = $(s.container).offset().top,
                            containerHeight = $(s.container).height(),
                            stickyWrapperHeight = s.stickyWrapper.height();
                        containerScrollPosition = containerTop + containerHeight - stickyWrapperHeight * 2;
                    }

                    //update height in case of dynamic content
                    s.stickyWrapper.css('height', s.stickyElement.outerHeight());


                    if (s.hidePosition.element !== '' && $(s.hidePosition.element).length > 0) {
                        var hidePositionTop = $(s.hidePosition.element).offset().top,
                            hidePositionTopSpace = s.hidePosition.topSpace;
                        hidePositionTarget = hidePositionTop - hidePositionTopSpace;
                    }


                    var newTop,
                        newWidth;

                    if (!s.scrollDirectionSensitive) {
                        if (scrollTop <= etse) {
                            if (s.currentTop !== null) {
                                s.stickyElement
                                    .css({
                                        'width': '',
                                        'position': '',
                                        'top': '',
                                        'z-index': ''
                                    });
                                s.stickyElement.parent().removeClass(s.className);
                                s.stickyElement.trigger('sticky-end', [s]);
                                s.currentTop = null;
                            }
                        } else {

                            newTop = documentHeight - s.stickyElement.outerHeight()
                                - s.topSpacing - s.bottomSpacing - scrollTop - extra;
                            if (newTop < 0) {
                                newTop = newTop + s.topSpacing;
                            } else {
                                newTop = s.topSpacing;
                            }
                            if (s.currentTop !== newTop) {
                                if (s.getWidthFrom) {
                                    newWidth = $(s.getWidthFrom).width() || null;
                                } else if (s.widthFromWrapper) {
                                    newWidth = s.stickyWrapper.width();
                                }
                                if (newWidth == null) {
                                    newWidth = s.stickyElement.width();
                                }
                                s.stickyElement
                                    .css('width', newWidth)
                                    .css('position', 'fixed')
                                    .css('top', newTop)
                                    .css('z-index', s.zIndex);

                                s.stickyElement.parent().addClass(s.className);

                                if (s.currentTop === null) {
                                    s.stickyElement.trigger('sticky-start', [s]);
                                } else {
                                    // sticky is started but it have to be repositioned
                                    s.stickyElement.trigger('sticky-update', [s]);
                                }

                                if (s.currentTop === s.topSpacing && s.currentTop > newTop || s.currentTop === null && newTop < s.topSpacing) {
                                    // just reached bottom || just started to stick but bottom is already reached
                                    s.stickyElement.trigger('sticky-bottom-reached', [s]);
                                } else if (s.currentTop !== null && newTop === s.topSpacing && s.currentTop < newTop) {
                                    // sticky is started && sticked at topSpacing && overflowing from top just finished
                                    s.stickyElement.trigger('sticky-bottom-unreached', [s]);
                                }

                                s.currentTop = newTop;
                            }

                            // Check if sticky has reached end of container and stop sticking
                            var stickyWrapperContainer = s.stickyWrapper.parent();
                            var unstick =
                                (
                                    (
                                        s.stickyElement.offset().top + s.stickyElement.outerHeight() >= stickyWrapperContainer.offset().top + stickyWrapperContainer.outerHeight()
                                    ) &&
                                    (
                                        s.stickyElement.offset().top <= s.topSpacing
                                    )
                                ) ||
                                (
                                    (
                                        containerScrollPosition !== false &&
                                        scrollTop > containerScrollPosition
                                    ) ||
                                    (
                                        hidePositionTarget !== false &&
                                        scrollTop >= hidePositionTarget
                                    )
                                );

                            if (unstick) {
                                s.stickyElement
                                    .css('position', 'absolute')
                                    .css('top', '')
                                    .css('bottom', 0)
                                    .css('z-index', '');
                            } else {
                                s.stickyElement
                                    .css('position', 'fixed')
                                    .css('top', newTop)
                                    .css('bottom', '')
                                    .css('z-index', s.zIndex);
                            }
                        }
                    } else {

                        var elementHeight = s.stickyElement.height(),
                            scrollBottom = scrollTop + windowHeight,
                            elementBottom = elementTop + elementHeight + s.bottomSpacing;


                        // <div class="scrollReport"></div>
                        //
                        //         <style>
                        // .scrollReport {
                        //         position: fixed;
                        //         left: 10px;
                        //         top: 90px;
                        //         text-align: left;
                        //         direction: ltr;
                        //         background: white;
                        //         z-index: 99;
                        //         width: 500px;
                        //         border: solid 1px red;
                        //         padding: 10px;
                        //         height: auto;
                        //     }
                        // </style>

                        var newTop1 = (oldOffset - scrollTop) + elementTop; // dynamic top
                        var newTop2 = (windowHeight - elementHeight); // fixed to bottom


                        // detect scroll direction change
                        if (scrollDirection !== lastScrollDirection) {
                            lastScrollDirection = scrollDirection;
                            oldOffset = s.stickyElement.offset().top;
                        }

                        // calc new width
                        if (s.getWidthFrom) {
                            newWidth = $(s.getWidthFrom).width() || null;
                        } else if (s.widthFromWrapper) {
                            newWidth = s.stickyWrapper.width();
                        }
                        if (newWidth == null) {
                            newWidth = s.stickyElement.width();
                        }

                        if (scrollDirection === 'up') {
                            // element must stick on top
                            newTop = newTop1;

                            if (newTop < elementTop) {
                                // $('.scrollReport').html(
                                //     'scrollBottom: '+scrollBottom+
                                //     '<br>scrollTop: '+scrollTop+
                                //     '<br>elementTop: '+elementTop+
                                //     '<br>elementBottom: '+elementBottom+
                                //     '<br>scrollDirection: '+scrollDirection+
                                //     '<br>elementHeight: '+elementHeight +
                                //     '<br>windowHeight: '+windowHeight+
                                //     '<br>documentHeight: '+documentHeight+
                                //     '<br>(newTop1+elementHeight): '+(newTop1+elementHeight)+
                                //     '<br>new offset: '+s.stickyElement.offset().top+
                                //     '<br>old offset: '+(oldOffset)+
                                //     '<br>newTop1'+ newTop1+
                                //     '<br>newTop2'+ newTop2+
                                //     '<br>up1'
                                // );
                                s.stickyElement
                                    .css('width', newWidth)
                                    .css('position', 'fixed')
                                    .css('top', newTop)
                                    .css('z-index', s.zIndex);
                            } else {
                                // $('.scrollReport').html(
                                //     'scrollBottom: '+scrollBottom+
                                //     '<br>scrollTop: '+scrollTop+
                                //     '<br>elementTop: '+elementTop+
                                //     '<br>elementBottom: '+elementBottom+
                                //     '<br>scrollDirection: '+scrollDirection+
                                //     '<br>elementHeight: '+elementHeight +
                                //     '<br>windowHeight: '+windowHeight+
                                //     '<br>documentHeight: '+documentHeight+
                                //     '<br>(newTop1+elementHeight): '+(newTop1+elementHeight)+
                                //     '<br>new offset: '+s.stickyElement.offset().top+
                                //     '<br>old offset: '+(oldOffset)+
                                //     '<br>newTop1'+ newTop1+
                                //     '<br>newTop2'+ newTop2+
                                //     '<br>up2'
                                // );
                                s.stickyElement
                                    .css('width', newWidth)
                                    .css('position', 'fixed')
                                    .css('top', elementTop)
                                    .css('z-index', s.zIndex);
                            }

                        } else if (scrollDirection === 'down') {
                            var newOffset = s.stickyElement.offset().top;
                            var newTopPosition = s.stickyElement.position().top;
                            if (windowHeight < elementHeight) {
                                if ( ((newOffset + elementHeight) > scrollBottom + 1) && (scrollBottom < ($(document).height()-elementTop))) {
                                    // $('.scrollReport').html(
                                    //     'scrollBottom: '+scrollBottom+
                                    //     '<br>scrollTop: '+scrollTop+
                                    //     '<br>elementTop: '+elementTop+
                                    //     '<br>elementBottom: '+elementBottom+
                                    //     '<br>scrollDirection: '+scrollDirection+
                                    //     '<br>elementHeight: '+elementHeight +
                                    //     '<br>windowHeight: '+windowHeight+
                                    //     '<br>documentHeight: '+documentHeight+
                                    //     '<br>(newTop1+elementHeight): '+(newTop1+elementHeight)+
                                    //     '<br>new TopPosition: '+newTopPosition+
                                    //     '<br>new offset: '+newOffset+
                                    //     '<br>old offset: '+(oldOffset)+
                                    //     '<br>newTop1'+ newTop1+
                                    //     '<br>newTop2'+ newTop2+
                                    //     '<br>(newOffset + elementHeight)'+ (newOffset + elementHeight)+
                                    //     '<br>down1'
                                    // );
                                    s.stickyElement
                                        .css('position', 'fixed')
                                        .css('top', newTop1 - elementTop)
                                        .css('bottom', '')
                                        .css('z-index', '');
                                } else {
                                    // $('.scrollReport').html(
                                    //     'scrollBottom: '+scrollBottom+
                                    //     '<br>scrollTop: '+scrollTop+
                                    //     '<br>elementTop: '+elementTop+
                                    //     '<br>elementBottom: '+elementBottom+
                                    //     '<br>scrollDirection: '+scrollDirection+
                                    //     '<br>elementHeight: '+elementHeight +
                                    //     '<br>windowHeight: '+windowHeight+
                                    //     '<br>documentHeight: '+documentHeight+
                                    //     '<br>(newTop1+elementHeight): '+(newTop1+elementHeight)+
                                    //     '<br>new offset: '+newOffset+
                                    //     '<br>old offset: '+(oldOffset)+
                                    //     '<br>newTop1'+ newTop1+
                                    //     '<br>newTop2'+ newTop2+
                                    //     '<br>(bottomSpacing)'+ s.bottomSpacing+
                                    //     '<br>down2'
                                    // );
                                    s.stickyElement
                                        .css('position', 'fixed')
                                        .css('top', newTop2 - s.bottomSpacing)
                                        .css('bottom', '')
                                        .css('z-index', '');
                                }
                            } else {
                                // $('.scrollReport').html(
                                //     'scrollBottom: ' + scrollBottom +
                                //     '<br>scrollTop: ' + scrollTop +
                                //     '<br>elementTop: ' + elementTop +
                                //     '<br>elementBottom: ' + elementBottom +
                                //     '<br>scrollDirection: ' + scrollDirection +
                                //     '<br>elementHeight: ' + elementHeight +
                                //     '<br>windowHeight: ' + windowHeight +
                                //     '<br>documentHeight: ' + documentHeight +
                                //     '<br>(newTop1+elementHeight): ' + (newTop1 + elementHeight) +
                                //     '<br>new offset: ' + s.stickyElement.offset().top +
                                //     '<br>old offset: ' + (oldOffset) +
                                //     '<br>newTop1' + newTop1 +
                                //     '<br>newTop2' + newTop2 +
                                //     '<br>down3'
                                // );
                            }

                        }

                        s.stickyElement.parent().addClass(s.className);

                        if (s.currentTop === null) {
                            s.stickyElement.trigger('sticky-start', [s]);
                        } else {
                            // sticky is started but it have to be repositioned
                            s.stickyElement.trigger('sticky-update', [s]);
                        }

                    }
                }
            }
        },
        resizer = function () {

            windowHeight = $window.height();
            var stickedLength = sticked.length;

            for (var i = 0, l = stickedLength; i < l; i++) {
                var s = sticked[i];
                var newWidth = null;
                if (s.unstickUnder!==false && $window.width()<s.unstickUnder) {
                    s.stickyElement
                        .css({
                            'width': '',
                            'position': '',
                            'top': '',
                            'z-index': ''
                        });
                    s.stickyElement.parent().css('height', 'auto');
                } else {
                    if (s.getWidthFrom) {
                        if (s.responsiveWidth) {
                            newWidth = $(s.getWidthFrom).width();
                        }
                    } else if (s.widthFromWrapper) {
                        newWidth = s.stickyWrapper.width();
                    }
                    if (newWidth != null) {
                        s.stickyElement.css('width', newWidth);
                    }
                }
            }

        },
        methods = {
            init: function (options) {
                var o = $.extend({}, defaults, options);
                extendedOptions = o;
                return this.each(function () {
                    var stickyElement = $(this);

                    var stickyId = stickyElement.attr('id');
                    var wrapperId = stickyId ? stickyId + '-' + defaults.wrapperClassName : defaults.wrapperClassName;
                    while (document.getElementById(wrapperId) !== null) {
                        wrapperId = wrapperId + '1';
                    }
                    var wrapper = $('<div></div>')
                        .attr('id', wrapperId)
                        .addClass(o.wrapperClassName);

                    stickyElement.wrapAll(wrapper);

                    var stickyWrapper = stickyElement.parent();

                    if (o.center) {
                        stickyWrapper.css({width: stickyElement.outerWidth(), marginLeft: "auto", marginRight: "auto"});
                    }

                    if (stickyElement.css("float") === "right") {
                        stickyElement.css({"float": "none"}).parent().css({"float": "right"});
                    }

                    o.stickyElement = stickyElement;
                    o.stickyWrapper = stickyWrapper;
                    o.currentTop = null;

                    sticked.push(o);

                    methods.setWrapperHeight(this);
                    methods.setupChangeListeners(this);
                });
            },

            setWrapperHeight: function (stickyElement) {
                var element = $(stickyElement);
                var stickyWrapper = element.parent();
                if (stickyWrapper) {
                    stickyWrapper.css('height', element.outerHeight());
                }
            },

            setupChangeListeners: function (stickyElement) {
                if (window.MutationObserver) {
                    var mutationObserver = new window.MutationObserver(function (mutations) {
                        if (mutations[0].addedNodes.length || mutations[0].removedNodes.length) {
                            methods.setWrapperHeight(stickyElement);
                        }
                    });
                    mutationObserver.observe(stickyElement, {subtree: true, childList: true});
                } else {
                    stickyElement.addEventListener('DOMNodeInserted', function () {
                        methods.setWrapperHeight(stickyElement);
                    }, false);
                    stickyElement.addEventListener('DOMNodeRemoved', function () {
                        methods.setWrapperHeight(stickyElement);
                    }, false);
                }
            },
            update: scroller,
            unstick: function (options) {
                return this.each(function () {
                    var that = this;
                    var unstickyElement = $(that);

                    var removeIdx = -1;
                    var i = sticked.length;
                    while (i-- > 0) {
                        if (sticked[i].stickyElement.get(0) === that) {
                            splice.call(sticked, i, 1);
                            removeIdx = i;
                        }
                    }
                    if (removeIdx !== -1) {
                        unstickyElement.unwrap();
                        unstickyElement
                            .css({
                                'width': '',
                                'position': '',
                                'top': '',
                                'float': '',
                                'z-index': ''
                            })
                        ;
                    }
                });
            }
        };
    var lastScrollTop = 0,
        oldOffset = 0,
        lastScrollDirection = 'down';
    // // should be more efficient than using $window.scroll(scroller) and $window.resize(resizer):
    // if (window.addEventListener) {
    //     window.addEventListener('scroll', scroller, false);
    //     window.addEventListener('resize', resizer, false);
    // } else if (window.attachEvent) {
    //     window.attachEvent('onscroll', scroller);
    //     window.attachEvent('onresize', resizer);
    // }
    $(window).resize(function(){
        scroller();
        resizer();
    });


    $.fn.sticky = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.sticky');
        }
    };

    $.fn.unstick = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.unstick.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.sticky');
        }
    };

    $.fn.update = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.update.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.sticky');
        }
    };

    $(function () {
        setTimeout(scroller, 0);
    });
}));
