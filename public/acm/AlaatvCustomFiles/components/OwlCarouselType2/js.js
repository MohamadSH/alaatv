(function ($) { //an IIFE so safely alias jQuery to $

    $.fn.OwlCarouselType2 = function (customOptions) {  //Add the function
        $.fn.OwlCarouselType2.owlCarouselOptions = $.extend(true, {}, $.fn.OwlCarouselType2.owlCarouseldefaultOptions, customOptions);

        return this.each(function () { //Loop over each element in the set and return them to keep the chain alive.
            let $this = $(this);
            $.fn.OwlCarouselType2.carouselElement = $this;
            let countOfChild = $this.find('.carousel').length;
            $this.find('.a--owl-carousel-type-2').owlCarousel($.fn.OwlCarouselType2.owlCarouselOptions.OwlCarousel);
            $this.find('.a--owl-carousel-init-loading').fadeOut();

            $.fn.OwlCarouselType2.showAlaaOwlCarouselItemDetail();

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

                $.fn.OwlCarouselType2.switchToGridView($this);

                // $([document.documentElement, document.body]).animate({
                //     scrollTop: $this.offset().top - $('#m_header').height()
                // }, 300);
            });
            $($this).on('click', '.btn-viewOwlCarousel', function (event) {
                let $this = $('#' + $(this).attr('data-owlcarousel-id'));
                event.preventDefault();

                $.fn.OwlCarouselType2.getGridViewWarper($this).html('');

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

                $this.find('.a--owl-carousel-type-2').owlCarousel($.fn.OwlCarouselType2.owlCarouselOptions.OwlCarousel);
                $.fn.OwlCarouselType2.getGridViewWarper($this).fadeOut(0);
                $this.find('.a--owl-carousel-type-2').fadeIn();

                $.fn.OwlCarouselType2.showAlaaOwlCarouselItemDetail();

                // $([document.documentElement, document.body]).animate({
                //     scrollTop: $this.offset().top - $('#m_header').height()
                // }, 300);
            });
            $($this).on('click', '.a--owl-carousel-hide-detailes', function () {
                let $this = $('#' + $(this).attr('data-owlcarousel-id'));
                $this.find('.a--owl-carousel-slide-detailes').slideUp();
                $this.find('.subCategoryWarper').fadeOut();
                $.fn.OwlCarouselType2.getGridViewWarper($this).find(' > div').css({
                    'margin-bottom': '0px'
                });
            });
            $($this).on('click', '.a--owl-carousel-gridViewWarper .a--owl-carousel-show-detailes', function () {
                let $this = $('#' + $(this).attr('data-owlcarousel-id'));
                $.fn.OwlCarouselType2.getGridViewWarper($this).find(' > div').css({
                    'margin-bottom': '0px'
                });

                let parent = $(this).parent('#' + $this.attr('id') + ' .m-widget_head-owlcarousel-item.carousel');
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

                        let detailesWarper = $this.find('.m-portlet.a--owl-carousel-slide-detailes');
                        let target = $.fn.OwlCarouselType2.getGridViewWarper($this).find('.carousel[data-position="' + position + '"]');
                        let targetCol = target.parent();
                        targetCol.css({
                            'margin-bottom': parseInt(detailesWarper.outerHeight()) + 'px'
                        });
                        let positionTop = parseInt(targetCol.outerHeight()) + parseInt(targetCol.position().top);
                        let positionLeftOfPointer = parseInt(targetCol.position().left) + (parseInt(targetCol.outerWidth()) / 2) - 5;
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
                        $this.find('.detailesWarperPointerStyle').html('<style>.a--owl-carousel-slide-detailes::before { right: auto; left: ' + positionLeftOfPointer + 'px; }</style>');
                    });
                });
            });

            if (countOfChild < $.fn.OwlCarouselType2.owlCarouselOptions.childCountHideOwlCarousel) {
                $.fn.OwlCarouselType2.switchToGridView($this);
                $this.find('.btn-viewOwlCarousel').fadeOut();
            } else if ($.fn.OwlCarouselType2.owlCarouselOptions.defaultView === 'grid') {
                $.fn.OwlCarouselType2.switchToGridView($this);
            }
        });
    };

    $.fn.OwlCarouselType2.switchToGridView = function ($OwlCarouselType2) {
        if ($.fn.OwlCarouselType2.getGridViewWarper($OwlCarouselType2).length > 0) {
            $.fn.OwlCarouselType2.getGridViewWarper($OwlCarouselType2).css("display", "flex")
                .hide()
                .fadeIn();
        }
        if ($.fn.OwlCarouselType2.getGridViewWarper($OwlCarouselType2).length === 0) {
            $OwlCarouselType2.find('.a--owl-carousel-type-2').after('<div class="m-widget_head-owlcarousel-items a--owl-carousel-type-2 owl-carousel row a--owl-carousel-gridViewWarper"></div>');
        }
        $.fn.OwlCarouselType2.getGridViewWarper($OwlCarouselType2).fadeOut(0);

        $OwlCarouselType2.find('.subCategoryWarper').fadeOut(0);
        $OwlCarouselType2.find('.a--owl-carousel-slide-detailes').slideUp(0);
        $OwlCarouselType2.find('.btn-viewGrid').css('cssText', 'display: none !important;');
        $OwlCarouselType2.find('.btn-viewOwlCarousel').fadeIn(0);

        $.fn.OwlCarouselType2.getGridViewWarper($OwlCarouselType2).html('');
        $OwlCarouselType2.find('.a--owl-carousel-type-2').owlCarousel('destroy');
        $OwlCarouselType2.find('.carousel').each(function () {
            $.fn.OwlCarouselType2.getGridViewWarper($OwlCarouselType2).append('<div class="'+$.fn.OwlCarouselType2.owlCarouselOptions.grid.columnClass+'">' + $(this)[0].outerHTML + '</div>');
        });


        $OwlCarouselType2.find('.a--owl-carousel-type-2').fadeOut();
        $.fn.OwlCarouselType2.getGridViewWarper($OwlCarouselType2).css("display", "flex")
            .hide()
            .fadeIn();


        $.fn.OwlCarouselType2.owlCarouselOptions.grid.btnSwfitchEvent();
    };

    $.fn.OwlCarouselType2.getGridViewWarper = function ($this) {
        return $this.find('.a--owl-carousel-gridViewWarper');
    };

    $.fn.OwlCarouselType2.showAlaaOwlCarouselItemDetail = function (event) {
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

        $.fn.OwlCarouselType2.owlCarouselOptions.OwlCarousel.onTranslatedEvent(event);

        $.fn.OwlCarouselType2.owlCarouselOptions.OwlCarousel.btnSwfitchEvent();
    };

    $.fn.OwlCarouselType2.owlCarouseldefaultOptions = {
        OwlCarousel: {
            stagePadding: 0,
            center: true,
            rtl: true,
            loop: true,
            nav: true,
            margin: 10,
            lazyLoad:true,
            responsive: {
                0: {
                    items: 1
                },
                400: {
                    items: 2
                },
                600: {
                    items: 3
                },
                800: {
                    items: 4
                },
                1000: {
                    items: 5
                }
            },
            // onDragged: this.callback,
            onTranslated: $.fn.OwlCarouselType2.showAlaaOwlCarouselItemDetail,
            btnSwfitchEvent: function() {},
            onTranslatedEvent: function() {},
        },
        grid: {
            btnSwfitchEvent: function() {},
            columnClass: 'col-12 col-sm-6 col-md-3'
        },
        defaultView: 'OwlCarousel', // or grid
        childCountHideOwlCarousel: 5
    };
    $.fn.OwlCarouselType2.owlCarouselOptions = null;
    $.fn.OwlCarouselType2.carouselElement = null;

}(jQuery));