function AlaaListLazyLoad() {

    var $list,
        items = [],
        defaultOptions = {
            items: [],
            listSelector: null,
            perLoad: 5,
            lazyLoadFunction: function (callback) {},
            loadCallback: function () {},
            renderItem: function (data) {}
        },
        options = {};


    function initData(customOptions) {
        options = $.extend(true, {}, defaultOptions, customOptions);
        if (options.listSelector === null) {
            return false;
        }
        $list = $(options.listSelector);
        if ($list.length === 0) {
            return false;
        }
        items = options.items;

        return true;
    }

    function loadMoreItem(loadAll) {
        for (var i = 0; ((loadAll || i < options.perLoad) && (typeof items[0] !== 'undefined')); i++) {
            loadNewItem(items[0]);
            items.splice(0, 1);
        }
    }

    function loadNewItem(data) {
        var itemHtmlData = options.renderItem(data);
        appendNewItem(itemHtmlData);
    }

    function appendNewItem(item) {
        $list.append(item);
    }

    function addSensorItem() {
        var itemSensor = '' +
            '<div class="itemSensor">\n' +
            '  <div style="width: 30px; display: inline-block;" class="m-loader m-loader--primary m-loader--lg"></div>\n' +
            '</div>';
        appendNewItem(itemSensor);
    }

    function removeSensorItem() {
        $list.find('.itemSensor').remove();
    }

    function lazyLoadSensorItem() {
        options.lazyLoadFunction(options.listSelector + ' .itemSensor', function () {
            removeSensorItem();
            loadMoreItem(false);
            options.loadCallback();
            // imageObserver.observe();
            if ((typeof items[0] !== 'undefined')) {
                addSensorItem();
                lazyLoadSensorItem();
            }
        });

        // LazyLoad.loadElementByQuerySelector('.setVideo .itemSensor', function () {
        //     removeSensorItem('video');
        //     loadMoreItem(videos, 'video', false);
        //     imageObserver.observe();
        //     if ((typeof videos[0] !== 'undefined')) {
        //         addSensorItem('video');
        //         lazyLoadSensorItem(videos);
        //     }
        // });
    }

    function init(customOptions) {

        if (!initData(customOptions)) {
            return;
        }

        addSensorItem();
        lazyLoadSensorItem();
    }

    function showAll(customOptions) {

        if (!initData(customOptions)) {
            return;
        }

        if ((typeof items[0] !== 'undefined')) {
            removeSensorItem();
            loadMoreItem(true);
            options.loadCallback();
            // imageObserver.observe();
        }
    }

    return {
        init: init,
        showAll: showAll,
    };

};
