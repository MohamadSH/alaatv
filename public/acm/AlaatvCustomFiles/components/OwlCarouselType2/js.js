(function ($) { //an IIFE so safely alias jQuery to $

    $.fn.OwlCarouselType2 = function (customOptions) {  //Add the function
        $.fn.OwlCarouselType2.owlCarouselOptions = $.extend({}, $.fn.OwlCarouselType2.owlCarouseldefaultOptions, customOptions);

        return this.each(function () { //Loop over each element in the set and return them to keep the chain alive.
            let $this = $(this);
            $.fn.OwlCarouselType2.carouselElement = $this;
            let countOfChild = $this.find('.carousel').length;
            $this.find('.a--owl-carousel-type-2').owlCarousel($.fn.OwlCarouselType2.owlCarouselOptions);

            $.fn.OwlCarouselType2.showAlaaOwlCarouselItemDetail();

            $this.find('.carousel').attr('data-owlcarousel-type-2-id', $this.attr('id'));
            $this.find('.btn-viewGrid').attr('data-owlcarousel-type-2-id', $this.attr('id'));
            $this.find('.btn-viewOwlCarousel').attr('data-owlcarousel-type-2-id', $this.attr('id')).fadeOut(0);
            $this.find('.a--owl-carousel-type-2-hide-detailes').attr('data-owlcarousel-type-2-id', $this.attr('id'));
            $this.find('.a--owl-carousel-type-2-show-detailes').attr('data-owlcarousel-type-2-id', $this.attr('id'));

            $($this).on('click', '.carousel', function () {
                let $this = $('#' + $(this).attr('data-owlcarousel-type-2-id'));
                let position = $(this).data('position');
                $this.find('.a--owl-carousel-type-2').trigger('to.owl.carousel', position);
            });
            $($this).on('click', '.btn-viewGrid', function (event) {
                let $this = $('#' + $(this).attr('data-owlcarousel-type-2-id'));
                event.preventDefault();

                if ($.fn.OwlCarouselType2.getGridViewWarper($this).length === 0) {
                    $this.find('.a--owl-carousel-type-2').after('<div class="m-widget_head-owlcarousel-items a--owl-carousel-type-2 owl-carousel row a--owl-carousel-type-2-gridViewWarper"></div>');
                }
                $.fn.OwlCarouselType2.getGridViewWarper($this).fadeOut(0);

                $this.find('.subCategoryWarper').fadeOut(0);
                $this.find('.a--owl-carousel-type-2-slide-detailes').slideUp(0);
                $this.find('.btn-viewGrid').css('cssText', 'display: none !important;');
                $this.find('.btn-viewOwlCarousel').fadeIn(0);

                $.fn.OwlCarouselType2.getGridViewWarper($this).html('');
                $this.find('.a--owl-carousel-type-2').owlCarousel('destroy');
                $this.find('.carousel').each(function () {
                    $.fn.OwlCarouselType2.getGridViewWarper($this).append('<div class="col-12 col-sm-6 col-md-3">' + $(this)[0].outerHTML + '</div>');
                });
                $this.find('.a--owl-carousel-type-2').fadeOut();
                $.fn.OwlCarouselType2.getGridViewWarper($this).fadeIn();

                $([document.documentElement, document.body]).animate({
                    scrollTop: $this.offset().top - $('#m_header').height()
                }, 300);
            });
            $($this).on('click', '.btn-viewOwlCarousel', function (event) {
                let $this = $('#' + $(this).attr('data-owlcarousel-type-2-id'));
                event.preventDefault();

                $.fn.OwlCarouselType2.getGridViewWarper($this).html('');

                $this.find('.btn-viewGrid').fadeIn(0);
                $this.find('.btn-viewOwlCarousel').fadeOut(0);

                $this.find('.m-portlet.a--owl-carousel-type-2-slide-detailes').css({
                    'display': 'block',
                    'position': 'relative',
                    'width': 'auto',
                    'top': '0'
                });

                $this.find('.subCategoryWarper').fadeOut(0);
                $this.find('.a--owl-carousel-type-2-slide-detailes').slideUp(0);

                $this.find('.detailesWarperPointerStyle').html('');

                $this.find('.a--owl-carousel-type-2').owlCarousel($.fn.OwlCarouselType2.owlCarouselOptions);
                $.fn.OwlCarouselType2.getGridViewWarper($this).fadeOut(0);
                $this.find('.a--owl-carousel-type-2').fadeIn();

                $.fn.OwlCarouselType2.showAlaaOwlCarouselItemDetail();

                $([document.documentElement, document.body]).animate({
                    scrollTop: $this.offset().top - $('#m_header').height()
                }, 300);

            });
            $($this).on('click', '.a--owl-carousel-type-2-hide-detailes', function () {
                let $this = $('#' + $(this).attr('data-owlcarousel-type-2-id'));
                $this.find('.a--owl-carousel-type-2-slide-detailes').slideUp();
                $this.find('.subCategoryWarper').fadeOut();
                $.fn.OwlCarouselType2.getGridViewWarper($this).find(' > div').css({
                    'margin-bottom': '0px'
                });
                // $('#gridViewWarper-' + this.owlCarouselId + ' > div').css({
                //     'margin-bottom': '0px'
                // });
            });
            $($this).on('click', '.a--owl-carousel-type-2-gridViewWarper .a--owl-carousel-type-2-show-detailes', function () {
                let $this = $('#' + $(this).attr('data-owlcarousel-type-2-id'));
                $.fn.OwlCarouselType2.getGridViewWarper($this).find(' > div').css({
                    'margin-bottom': '0px'
                });

                let parent = $(this).parent('#' + $this.attr('id') + ' .m-widget_head-owlcarousel-item.carousel');
                let position = parent.data('position');


                let alaaOwlCarouselItemDetailClass = 'a--owl-carousel-type-2-slide-iteDetail-' + position;
                // let localOwlCarouselId = this.owlCarouselId;
                $.when($this.find('.subCategoryWarper').fadeOut(0)).done(function () {

                    let aOwlCarouselSlideDetailes = $this.find('.a--owl-carousel-type-2-slide-detailes');
                    let alaaOwlCarouselItemDetailObject = $this.find('.' + alaaOwlCarouselItemDetailClass);
                    $.when(aOwlCarouselSlideDetailes.slideUp(0)).done(function () {

                        if (alaaOwlCarouselItemDetailObject.length > 0) {
                            aOwlCarouselSlideDetailes.fadeIn();
                            alaaOwlCarouselItemDetailObject.slideDown();
                        }

                        let detailesWarper = $this.find('.m-portlet.a--owl-carousel-type-2-slide-detailes');
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
                        $this.find('.detailesWarperPointerStyle').html('<style>.a--owl-carousel-type-2-slide-detailes::before { right: auto; left: ' + positionLeftOfPointer + 'px; }</style>');
                    });
                });
            });

            if (countOfChild < 5) {
                $this.find('.btn-viewGrid').trigger('click');
                $this.find('.btn-viewOwlCarousel').fadeOut();
            }
        });
    };

    $.fn.OwlCarouselType2.getGridViewWarper = function ($this) {
        return $this.find('.a--owl-carousel-type-2-gridViewWarper');
    };

    $.fn.OwlCarouselType2.showAlaaOwlCarouselItemDetail = function (event) {
        let elementId = '';
        if (typeof event !== 'undefined') {
            elementId = $(event.target).find('.carousel').attr('data-owlcarousel-type-2-id');
        } else {
            elementId = this.carouselElement.attr('id');
        }
        let $this = $('#' + elementId);

        let alaaOwlCarouselItemDetailClass = 'a--owl-carousel-type-2-slide-iteDetail-' + $this.find('.a--owl-carousel-type-2 .owl-item.active.center .carousel').data('position');
        $this.find('.subCategoryWarper').fadeOut();
        let aOwlCarouselSlideDetailes = $this.find('.a--owl-carousel-type-2-slide-detailes');
        let alaaOwlCarouselItemDetailObject = $this.find('.' + alaaOwlCarouselItemDetailClass);
        aOwlCarouselSlideDetailes.slideUp();
        if (alaaOwlCarouselItemDetailObject.length > 0) {
            aOwlCarouselSlideDetailes.fadeIn();
            alaaOwlCarouselItemDetailObject.slideDown();
        }
    };

    $.fn.OwlCarouselType2.owlCarouseldefaultOptions = {
        center: true,
        rtl: true,
        loop: true,
        nav: true,
        margin: 10,
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
        onTranslated: $.fn.OwlCarouselType2.showAlaaOwlCarouselItemDetail
    };
    $.fn.OwlCarouselType2.owlCarouselOptions = null;
    $.fn.OwlCarouselType2.carouselElement = null;


}(jQuery));