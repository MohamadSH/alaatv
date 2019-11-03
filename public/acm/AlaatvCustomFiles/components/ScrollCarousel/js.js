(function ($) { //an IIFE so safely alias jQuery to $

    $.fn.ScrollCarousel = function (customOptions) {  //Add the function
        $.fn.ScrollCarousel.options = $.extend(true, {}, $.fn.ScrollCarousel.defaultOptions, customOptions);

        return this.each(function () { //Loop over each element in the set and return them to keep the chain alive.
            let $this = $(this);

            $.fn.ScrollCarousel.carouselElement = $this;
            let items = $this.find('.item');
            let itemsLength = itemsLength.length;

            $this.find('.a--owl-carousel-init-loading').fadeOut(500, function() {

                $this.find('.a--owl-carousel-type-2').owlCarousel($.fn.ScrollCarousel.options.OwlCarousel);

                $.fn.ScrollCarousel.showAlaaOwlCarouselItemDetail();

                $this.find('.carousel').attr('data-owlcarousel-id', $this.attr('id'));
                $this.find('.btn-viewGrid').attr('data-owlcarousel-id', $this.attr('id'));
                $this.find('.btn-viewOwlCarousel').attr('data-owlcarousel-id', $this.attr('id')).fadeOut(0);
                $this.find('.a--owl-carousel-hide-detailes').attr('data-owlcarousel-id', $this.attr('id'));
                $this.find('.a--owl-carousel-show-detailes').attr('data-owlcarousel-id', $this.attr('id'));

                $($this).on('click', '.carousel', function () {
                    let $this = $('#' + $(this).attr('data-owlcarousel-id'));
                    let position = $(this).data('position');
                    $this.find('.a--owl-carousel-type-2').trigger('to.owl.carousel', position);
                });
                $($this).on('click', '.btn-viewGrid', function (event) {
                    let $this = $('#' + $(this).attr('data-owlcarousel-id'));

                    event.preventDefault();

                    $.fn.ScrollCarousel.switchToGridView($this);

                    // $([document.documentElement, document.body]).animate({
                    //     scrollTop: $this.offset().top - $('#m_header').height()
                    // }, 300);
                });
                $($this).on('click', '.btn-viewOwlCarousel', function (event) {
                    let $this = $('#' + $(this).attr('data-owlcarousel-id'));
                    event.preventDefault();

                    $.fn.ScrollCarousel.getGridViewWarper($this).html('');

                    $this.find('.btn-viewGrid').fadeIn(0);
                    $this.find('.btn-viewOwlCarousel').fadeOut(0);

                    $this.find('.m-portlet.a--owl-carousel-slide-detailes').css({
                        'display': 'block',
                        'position': 'relative',
                        'width': 'auto',
                        'top': '0'
                    });

                    $this.find('.subCategoryWarper').fadeOut(0);
                    $this.find('.a--owl-carousel-slide-detailes').slideUp(0);

                    $this.find('.detailesWarperPointerStyle').html('');

                    $this.find('.a--owl-carousel-type-2').owlCarousel($.fn.ScrollCarousel.options.OwlCarousel);
                    $.fn.ScrollCarousel.getGridViewWarper($this).fadeOut(0);
                    $this.find('.a--owl-carousel-type-2').fadeIn();

                    $.fn.ScrollCarousel.showAlaaOwlCarouselItemDetail();

                    // $([document.documentElement, document.body]).animate({
                    //     scrollTop: $this.offset().top - $('#m_header').height()
                    // }, 300);
                });
                $($this).on('click', '.a--owl-carousel-hide-detailes', function () {
                    let $this = $('#' + $(this).attr('data-owlcarousel-id'));
                    $this.find('.a--owl-carousel-slide-detailes').slideUp();
                    $this.find('.subCategoryWarper').fadeOut();
                    $.fn.ScrollCarousel.getGridViewWarper($this).find(' > div').css({
                        'margin-bottom': '0px'
                    });
                });
                $($this).on('click', '.a--owl-carousel-gridViewWarper .a--owl-carousel-show-detailes', function () {
                    let $this = $('#' + $(this).attr('data-owlcarousel-id'));
                    $.fn.ScrollCarousel.getGridViewWarper($this).find(' > div').css({
                        'margin-bottom': '0px'
                    });

                    let parent = $(this).parents('#' + $this.attr('id') + ' .a--block-item');
                    let position = parent.data('position');


                    let alaaOwlCarouselItemDetailClass = 'a--owl-carousel-slide-iteDetail-' + position;
                    // let localOwlCarouselId = this.owlCarouselId;
                    $.when($this.find('.subCategoryWarper').fadeOut(0)).done(function () {

                        let aOwlCarouselSlideDetailes = $this.find('.a--owl-carousel-slide-detailes');
                        let alaaOwlCarouselItemDetailObject = $this.find('.' + alaaOwlCarouselItemDetailClass);
                        $.when(aOwlCarouselSlideDetailes.slideUp(0)).done(function () {

                            if (alaaOwlCarouselItemDetailObject.length > 0) {
                                aOwlCarouselSlideDetailes.fadeIn();
                                alaaOwlCarouselItemDetailObject.slideDown();
                            }

                            let detailesWarper = $this.find('.a--owl-carousel-slide-detailes');
                            let target = $.fn.ScrollCarousel.getGridViewWarper($this).find('.carousel[data-position="' + position + '"]');
                            let targetCol = target.parent();
                            targetCol.css({
                                'margin-bottom': parseInt(detailesWarper.outerHeight()) + 50 + 'px'
                            });

                            let positionTop = parseInt(targetCol[0].offsetTop) + parseInt(targetCol.outerHeight()) + 20;

                            let positionLeftOfPointer = parseInt(targetCol.position().left) + (parseInt(targetCol.outerWidth()) / 2) - 20;
                            detailesWarper.css({
                                'display': 'block',
                                'position': 'absolute',
                                'width': '100%',
                                'z-index': '1',
                                'top': positionTop + 'px'
                            });
                            let detailesWarperPointerStyle = $this.find('.detailesWarperPointerStyle');
                            if (detailesWarperPointerStyle.length === 0) {
                                detailesWarper.append('<div class="detailesWarperPointerStyle"></div>');
                            }
                            $this.find('.detailesWarperPointerStyle').html('<style>.a--owl-carousel-slide-detailes::before { right: auto; left: ' + positionLeftOfPointer + 'px !important; }</style>');
                        });
                    });
                });

                if (countOfChild < $.fn.ScrollCarousel.options.childCountHideOwlCarousel) {
                    $.fn.ScrollCarousel.switchToGridView($this);
                    $this.find('.btn-viewOwlCarousel').fadeOut();
                } else if ($.fn.ScrollCarousel.options.defaultView === 'grid') {
                    $.fn.ScrollCarousel.switchToGridView($this);
                }

            });
        });
    };


    $.fn.ScrollCarousel.createItem = function ($this, data) {
        return '\n' +
            '<div class="item">\n' +
            '    <div class="pic">\n' +
            '        <img data-src="'+data.pic.src+'" alt="" class="lazy-image" width="'+data.pic.w+'" height="'+data.pic.h+'">\n' +
            '    </div>\n' +
            '    <div class="content">\n' +
            '        <div class="title">\n' +
            '            <h2>' +
                            data.title +
            '            </h2>\n' +
            '        </div>\n' +
            '        <div class="detailes">\n' +
                         data.detailes +
            '        </div>\n' +
            '    </div>\n' +
            '</div>';
    };

    $.fn.ScrollCarousel.switchToGridView = function ($ScrollCarousel) {
        if ($.fn.ScrollCarousel.getGridViewWarper($ScrollCarousel).length > 0) {
            $.fn.ScrollCarousel.getGridViewWarper($ScrollCarousel).css("display", "flex")
                .hide()
                .fadeIn();
        }
        if ($.fn.ScrollCarousel.getGridViewWarper($ScrollCarousel).length === 0) {
            $ScrollCarousel.find('.a--owl-carousel-type-2').after('<div class="m-widget_head-owlcarousel-items a--owl-carousel-type-2 owl-carousel row a--owl-carousel-gridViewWarper"></div>');
        }
        $.fn.ScrollCarousel.getGridViewWarper($ScrollCarousel).fadeOut(0);

        $ScrollCarousel.find('.subCategoryWarper').fadeOut(0);
        $ScrollCarousel.find('.a--owl-carousel-slide-detailes').slideUp(0);
        $ScrollCarousel.find('.btn-viewGrid').css('cssText', 'display: none !important;');
        $ScrollCarousel.find('.btn-viewOwlCarousel').fadeIn(0);

        $.fn.ScrollCarousel.getGridViewWarper($ScrollCarousel).html('');
        $ScrollCarousel.find('.a--owl-carousel-type-2').owlCarousel('destroy');
        $ScrollCarousel.find('.carousel').each(function () {
            $.fn.ScrollCarousel.getGridViewWarper($ScrollCarousel).append('<div class="'+$.fn.ScrollCarousel.options.grid.columnClass+'">' + $(this)[0].outerHTML + '</div>');
        });


        $ScrollCarousel.find('.a--owl-carousel-type-2').fadeOut();
        $.fn.ScrollCarousel.getGridViewWarper($ScrollCarousel).css("display", "flex")
            .hide()
            .fadeIn();


        $.fn.ScrollCarousel.options.grid.btnSwfitchEvent();
    };

    $.fn.ScrollCarousel.getGridViewWarper = function ($this) {
        return $this.find('.a--owl-carousel-gridViewWarper');
    };

    $.fn.ScrollCarousel.showAlaaOwlCarouselItemDetail = function (event) {
        let elementId = '';
        if (typeof event !== 'undefined') {
            elementId = $(event.target).find('.carousel').attr('data-owlcarousel-id');
        } else {
            elementId = this.carouselElement.attr('id');
        }
        let $this = $('#' + elementId);

        let alaaOwlCarouselItemDetailClass = 'a--owl-carousel-slide-iteDetail-' + $this.find('.a--owl-carousel-type-2 .owl-item.active.center .carousel').data('position');
        $this.find('.subCategoryWarper').fadeOut();
        let aOwlCarouselSlideDetailes = $this.find('.a--owl-carousel-slide-detailes');
        let alaaOwlCarouselItemDetailObject = $this.find('.' + alaaOwlCarouselItemDetailClass);
        aOwlCarouselSlideDetailes.slideUp();
        if (alaaOwlCarouselItemDetailObject.length > 0) {
            aOwlCarouselSlideDetailes.fadeIn();
            alaaOwlCarouselItemDetailObject.slideDown();
            $([document.documentElement, document.body]).animate({
                scrollTop: aOwlCarouselSlideDetailes.offset().top
            }, 300);
        }

        $.fn.ScrollCarousel.options.OwlCarousel.onTranslatedEvent(event);

        $.fn.ScrollCarousel.options.OwlCarousel.btnSwfitchEvent();
    };

    $.fn.ScrollCarousel.defaultOptions = {
        data: [],
        carousel: {
            lazyLoad:true,
            // onDragged: this.callback,
            onTranslated: $.fn.ScrollCarousel.showAlaaOwlCarouselItemDetail,
            btnSwfitchEvent: function() {},
            onTranslatedEvent: function() {},
        },
        grid: {
            btnSwfitchEvent: function() {},
            columnClass: 'col-12 col-sm-6 col-md-3'
        },
        defaultView: 'carousel', // or grid
        childCountHideOwlCarousel: 5
    };
    $.fn.ScrollCarousel.options = null;
    $.fn.ScrollCarousel.carouselElement = null;

}(jQuery));