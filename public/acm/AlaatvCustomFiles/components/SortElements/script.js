(function($) {
    $.fn.Sort = function(customOptions) {


        if (this.length > 1) {
            this.each(function() { $(this).Sort(options) });
            return this;
        }

        // private variables
        var defaultOptions = {
                order: 'asc', // asc - des
                sortAttribute: 'data-sort'
            },
            options = null;

        // private methods
        var normalizeData = function(customOptions) {
            options = $.extend(true, {}, defaultOptions, customOptions);
        };

        var getItems = function($itemsList) {
            return $itemsList.children('.SortItemsList-item');
        };

        var sortListAscending = function ( a, b ) {
            // Cache inner content from the first element (a) and the next sibling (b)
            var sorta = parseInt(a.getAttribute(options.sortAttribute));
            var sortb = parseInt(b.getAttribute(options.sortAttribute));

            // Returning -1 will place element `a` before element `b`
            if (sorta < sortb) {
                return -1;
            }

            // Returning 1 will do the opposite
            if (sorta > sortb) {
                return 1;
            }

            // Returning 0 leaves them as-is
            return 0;
        };

        var sortListDescending = function ( a, b ) {
            // Cache inner content from the first element (a) and the next sibling (b)
            var sorta = parseInt(a.getAttribute(options.sortAttribute));
            var sortb = parseInt(b.getAttribute(options.sortAttribute));

            // Returning -1 will place element `a` before element `b`
            if (sorta > sortb) {
                return -1;
            }

            // Returning 1 will do the opposite
            if (sorta < sortb) {
                return 1;
            }

            // Returning 0 leaves them as-is
            return 0;
        };

        var sortListShuffle = function ( a, b ) {
            // Cache inner content from the first element (a) and the next sibling (b)
            // var sorta = parseInt(a.getAttribute(options.sortAttribute));
            // var sortb = parseInt(b.getAttribute(options.sortAttribute));

            // Returning -1 will place element `a` before element `b`
            if ((Math.random() > 0.5)) {
                return -1;
            } else {
                return 1;
            }
        };

        var getSortFunction = function () {
            if (options.order === 'asc') {
                return sortListAscending;
            } else if (options.order === 'des') {
                return sortListDescending;
            } else if (options.order === 'shu') {
                return sortListShuffle;
            }
        };

        // public methods
        this.init = function(customOptions) {
            normalizeData(customOptions);

            var $itemsList = $(this),
                $items = getItems($itemsList);

            if ($items.length === 0) {
                return this;
            }

            var sortList = Array.prototype.sort.bind($items);

            // sortList(getSortFunction);

            if (options.order === 'asc') {
                sortList(sortListAscending);
            } else if (options.order === 'des') {
                sortList(sortListDescending);
            } else if (options.order === 'shu') {
                sortList(sortListShuffle);
            }

            $itemsList.append($items);
            return this;
        };

        return this.init(customOptions);
    };
})(jQuery);
