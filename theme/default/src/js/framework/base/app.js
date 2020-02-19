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
