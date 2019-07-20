(function ($) { //an IIFE so safely alias jQuery to $

    $.fn.ABlock = function (customOptions) {  //Add the function
        $.fn.ABlock.options = $.extend(true, {}, $.fn.ABlock.defaultOptions, customOptions);

        return this.each(function () { //Loop over each element in the set and return them to keep the chain alive.
            let $this = $(this);
            $this.addClass('a--owl-carousel-Wraper');
            if ($.fn.ABlock.options.backgroundTransparent) {
                $this.addClass('background-transparent');
            }
            $this.html($.fn.ABlock.getBlock($.fn.ABlock.options.data));

            $this.OwlCarouselType2($.fn.ABlock.options.OwlCarouselType2Options);
        });
    };

    $.fn.ABlock.getBlock = function (items) {
        let hasProductClass = '';
        if ($.fn.ABlock.options.class === 'product') {
            hasProductClass = 'blockWraper-hasProduct';
        }
        return '\n' +
            '    <div class="row blockWraper a--owl-carousel-row blockId-'+$.fn.ABlock.options.id+' '+$.fn.ABlock.options.class+' '+hasProductClass+' scrollSensitiveOnScreen"\n' +
            '         id="'+$.fn.ABlock.options.id+'">\n' +
            '        <div class="col">\n' +
            '            <div class="m-portlet a--owl-carousel-mainContent" id="owlCarousel_'+$.fn.ABlock.options.id+'">\n' +
                            $.fn.ABlock.getHead()+
                            $.fn.ABlock.getBody($.fn.ABlock.getItems(items))+
            '            </div>\n' +
            '        </div>\n' +
            '    </div>';
    };

    $.fn.ABlock.getBody = function (items) {
        return '\n' +
            '    <div class="m-portlet__body m-portlet__body--no-padding">\n' +
            '        <div class="a--owl-carousel-init-loading">\n' +
            '            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>\n' +
            '        </div>\n' +
            '        <!--begin::Widget 30-->\n'+
            '        <div class="m-widget30">\n' +
            '            <div class="m-widget_head a--owl-carousel-body-content">\n' +
            '                <div class="m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2 carousel_block_'+$.fn.ABlock.options.id+'">\n' +
            items +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '        <!--end::Widget 30-->\n'+
            '    </div>';
    };

    $.fn.ABlock.getHead = function () {
        let headSquare = $.fn.ABlock.getBlockHeadSquare();
        return '<div class="m-portlet__head a--owl-carousel-head">\n' +
            '        <h3 class="a--block-title">\n' +
            headSquare +
            '            <a href="'+$.fn.ABlock.options.link+'" class="m-link">\n' +
            '                '+$.fn.ABlock.options.title+'\n' +
            '            </a>\n' +
            '            \n' +
            '        </h3>\n' +
            '        <div class="m-portlet__head-tools">\n' +
            '            <a href="#"\n' +
            '               class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewGrid">\n' +
            '                <i class="fa flaticon-shapes"></i>\n' +
            '            </a>\n' +
            '            <a href="#"\n' +
            '               class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewOwlCarousel">\n' +
            '                <i class="flaticon-more-v4"></i>\n' +
            '            </a>\n' +
            '        </div>\n' +
            '    </div>';
    };

    $.fn.ABlock.getBlockHeadSquare = function () {
        if($.fn.ABlock.options.type === 'product') {
            return '<span class="redSquare"></span>';
        }
        else if($.fn.ABlock.options.type === 'set') {
            return '<span class="blueSquare"></span>';
        }
        else if($.fn.ABlock.options.title === 'content') {
            return '<span class="blueSquare"></span>';
        }
        else if($.fn.ABlock.options.type === 'simple') {
            return '<span class="recomenderSquare"></span>';
        }
    };

    $.fn.ABlock.getItems = function (items) {
        let itemsHtml = '';
        $.each(items, function( index, value ) {
            itemsHtml += $.fn.ABlock.getItem(value, index);
        });

        return itemsHtml;
    };

    $.fn.ABlock.getItem = function (item, key) {
        if($.fn.ABlock.options.type === 'product') {
            return $.fn.ABlock.getItem_product(item, key);
        }
        else if($.fn.ABlock.options.type === 'set') {
            return '';
        }
        else if($.fn.ABlock.options.type === 'content') {
            return '';
        }
        else if($.fn.ABlock.options.type === 'simple') {
            return $.fn.ABlock.getItem_simple(item, key);
        }
    };

    $.fn.ABlock.getItem_simple = function (item, key) {
        return '\n' +
            '<div class="item carousel block-type-simple">\n' +
            '    <div class="item-image">\n' +
            '        <a href="'+item.link+'" class="m-link a--full-width">\n' +
            '            <img data-src="'+item.pic+'" alt="'+item.name+'" class="a--full-width owl-lazy lazy-image"/>\n' +
            '        </a>\n' +
            '        <div class="m-widget19__shadow"></div>\n' +
            '    </div>\n' +
            '    <div class="item-name">\n' +
            '        <a href="'+item.link+'" class="m-link">\n' +
            '            '+item.name+'\n' +
            '        </a>\n' +
            '    </div>\n' +
            '</div>';
    };

    $.fn.ABlock.getItem_productDiscountRibobn = function (item) {

        if (item.price.final !== item.price.base) {
            return ''+
                '        <div class="ribbon">\n' +
                '            <span>\n' +
                '                <div class="glow">&nbsp;</div>\n' +
                Math.round((item.price.final / item.price.base)*100) + '%\n' +
                '                <span>تخفیف</span>\n' +
                '            </span>\n' +
                '        </div>\n';
        }
        return '';
    };

    $.fn.ABlock.getItem_productPrice = function (item) {
        let priceHtml = '<span class="m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">';
        if (item.price.final !== item.price.base) {
            priceHtml += '    <span class="m-badge m-badge--warning a--productRealPrice">'+item.price.base+'</span>\n';
            priceHtml += '    <span class="m-badge m-badge--info a--productDiscount">'+Math.round((item.price.final / item.price.base)*100)+'%</span>\n';
        }
        priceHtml += item.price.final + 'تومان';
        priceHtml += '</span>';
        return priceHtml;
    };

    $.fn.ABlock.getItem_product = function (item, key) {
        return '<div class="m-widget_head-owlcarousel-item carousel noHoverEffect block-product-item"\n' +
            '     data-position="'+key+'"\n' +
            '     data-gtm-eec-product-id="'+item.id+'"\n' +
            '     data-gtm-eec-product-name="'+item.name+'"\n' +
            '     data-gtm-eec-product-price="'+item.price.final+'"\n' +
            '     data-gtm-eec-product-brand="آلاء"\n' +
            '     data-gtm-eec-product-category="-"\n' +
            '     data-gtm-eec-product-variant="-"\n' +
            '     data-gtm-eec-product-position="'+key+'"\n' +
            '     data-gtm-eec-product-list="'+item.title+'" >\n' +
            $.fn.ABlock.getItem_productDiscountRibobn(item) +
            '    <a href="'+item.url+'"\n' +
            '       class="gtm-eec-product-impression-click"\n' +
            '       data-gtm-eec-product-id="'+item.id+'"\n' +
            '       data-gtm-eec-product-name="'+item.name+'"\n' +
            '       data-gtm-eec-product-price="'+item.price.final+'"\n' +
            '       data-gtm-eec-product-brand="آلاء"\n' +
            '       data-gtm-eec-product-category="-"\n' +
            '       data-gtm-eec-product-variant="-"\n' +
            '       data-gtm-eec-product-position="'+key+'"\n' +
            '       data-gtm-eec-product-list="'+item.title+'">\n' +
            '        <img class="a--owl-carousel-type-2-item-image owl-lazy lazy-image main-photo-forLoading" data-src="'+item.price.photo+'?w=400&h=400" alt="'+item.name+'">\n' +
            '    </a>\n' +
            '    <div class="m--font-primary a--owl-carousel-type-2-item-title">\n' +
            $.fn.ABlock.getItem_productPrice(item) +
            '    </div>\n' +
            '    <a href="'+item.price.url+'"\n' +
            '       target="_blank"\n' +
            '       class="m-link a--owl-carousel-type-2-item-subtitle gtm-eec-product-impression-click"\n' +
            '       data-gtm-eec-product-id="'+item.id+'"\n' +
            '       data-gtm-eec-product-name="'+item.name+'"\n' +
            '       data-gtm-eec-product-price="'+item.price.final+'"\n' +
            '       data-gtm-eec-product-brand="آلاء"\n' +
            '       data-gtm-eec-product-category="-"\n' +
            '       data-gtm-eec-product-variant="-"\n' +
            '       data-gtm-eec-product-position="'+key+'"\n' +
            '       data-gtm-eec-product-list="'+item.title+'">\n' +
            '        '+item.name+'\n' +
            '    </a>\n' +
            '</div>\n';
    };

    $.fn.ABlock.addLoadingItem = function (owl) {
        var loadingHtml = '<div class="a--owlCarouselLoading"><div style="width: 30px; display: inline-block;" class="m-loader m-loader--primary m-loader--lg"></div></div>';
        owl.trigger('add.owl.carousel', [jQuery(loadingHtml)]);
    };

    $.fn.ABlock.defaultOptions = {
        type: 'product',
        id: 'blockId'+(new Date()).getTime(),
        class: '',
        title: '',
        link: '#',
        titleLinkDisable: false,
        backgroundTransparent: true,
        OwlCarouselType2Options: {},
        data: []
    };

    $.fn.ABlock.options = null;

}(jQuery));