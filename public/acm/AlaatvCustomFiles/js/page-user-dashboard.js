var owlCarouselType2 = function () {
    let owlCarouselType2Options = {
        center: true,
        rtl: true,
        loop: true,
        nav: true,
        margin: 10,
        responsive:{
            0:{
                items:1
            },
            400:{
                items:2
            },
            600:{
                items:3
            },
            800:{
                items:4
            },
            1000:{
                items:5
            }
        },
        // onDragged: callback,
        onTranslated : callback
    };
    let owlCarouselIdString = '';

    function showAlaaOwlCarouselItemDetail(owlCarouselId) {
        let alaaOwlCarouselItemDetailClass = 'a--owl-carousel-type-2-slide-iteDetail-' + $('#' + owlCarouselId + ' .a--owl-carousel-type-2 .owl-item.active.center .carousel').data('position');
        $('#' + owlCarouselId + ' .subCategoryWarper').fadeOut();
        let aOwlCarouselSlideDetailes = $('#' + owlCarouselId + ' .a--owl-carousel-type-2-slide-detailes');
        let alaaOwlCarouselItemDetailObject = $('#' + owlCarouselId + ' .'+alaaOwlCarouselItemDetailClass);
        aOwlCarouselSlideDetailes.slideUp();
        if (alaaOwlCarouselItemDetailObject.length>0) {
            aOwlCarouselSlideDetailes.fadeIn();
            alaaOwlCarouselItemDetailObject.slideDown();
        }
    }

    function callback(event) {
        showAlaaOwlCarouselItemDetail(owlCarouselIdString);
    }

    return {
        init: function (owlCarouselId) {
            owlCarouselIdString = owlCarouselId;
            $('#' + owlCarouselId + ' .a--owl-carousel-type-2').owlCarousel(owlCarouselType2Options);
            showAlaaOwlCarouselItemDetail(owlCarouselId);
            $(document).on('click', '#' + owlCarouselId + ' .carousel', function () {
                let position = $(this).data('position');
                $('#' + owlCarouselId + ' .a--owl-carousel-type-2').trigger('to.owl.carousel', position);
            });
            $(document).on('click', '.btn-viewGrid', function (event) {
                event.preventDefault();
                let itemId = $(this).data('item-id');

                let gridViewWarper = $('#gridViewWarper-' + itemId);

                if(gridViewWarper.length === 0) {
                    $('#' + itemId + ' .a--owl-carousel-type-2').after('<div class="m-widget_head-owlcarousel-items a--owl-carousel-type-2 owl-carousel row" id="gridViewWarper-' + owlCarouselId + '"></div>');
                }

                $('#' + itemId + ' .subCategoryWarper').fadeOut(0);
                $('#' + itemId + ' .a--owl-carousel-type-2-slide-detailes').slideUp(0);
                $('.btn-viewGrid[data-item-id="' + itemId + '"]').css('cssText', 'display: none !important;');
                $('.btn-viewOwlCarousel[data-item-id="' + itemId + '"]').fadeIn(0);

                gridViewWarper.html('');
                $('#' + itemId + ' .a--owl-carousel-type-2').owlCarousel('destroy');
                $('#' + itemId + ' .carousel').each(function() {
                    $('#gridViewWarper-' + itemId).append('<div class="col-12 col-sm-6 col-md-3">' + $(this)[0].outerHTML + '</div>');
                });
                $('#' + itemId + ' .a--owl-carousel-type-2').fadeOut();
                $('#gridViewWarper-' + itemId).fadeIn();

                $([document.documentElement, document.body]).animate({
                    scrollTop: $('#' + itemId - $('#m_header').height()).offset().top
                }, 100);
            });
            $(document).on('click', '.btn-viewOwlCarousel', function (event) {
                event.preventDefault();

                let itemId = $(this).data('item-id');

                $('#gridViewWarper-' + itemId).html('');

                $('.btn-viewGrid[data-item-id="' + itemId + '"]').fadeIn(0);
                $('.btn-viewOwlCarousel[data-item-id="' + itemId + '"]').fadeOut(0);

                $('#' + itemId + ' .m-portlet.a--owl-carousel-type-2-slide-detailes').css({
                    'display': 'block',
                    'position': 'relative',
                    'width': 'auto',
                    'top': '0'
                });

                $('#' + itemId + ' .subCategoryWarper').fadeOut(0);
                $('#' + itemId + ' .a--owl-carousel-type-2-slide-detailes').slideUp(0);

                $('#' + itemId + ' .detailesWarperPointerStyle').html('');

                let itemClass = $(this).data('itemclass');
                $('#' + itemId + ' .a--owl-carousel-type-2').owlCarousel(owlCarouselType2Options);
                let gridView = $('.gridView-' + itemClass);
                gridView.fadeOut(0);
                $('#' + itemId + ' .a--owl-carousel-type-2').fadeIn();

                showAlaaOwlCarouselItemDetail(itemId);

                $([document.documentElement, document.body]).animate({
                    scrollTop: $('#' + itemId - $('#m_header').height()).offset().top
                }, 100);

            });
            $(document).on('click', '#' + owlCarouselId + ' .a--owl-carousel-type-2-hide-detailes', function () {
                $('#' + owlCarouselId + ' .a--owl-carousel-type-2-slide-detailes').slideUp();
                $('#' + owlCarouselId + ' .subCategoryWarper').fadeOut();
                $('#gridViewWarper-' + owlCarouselId + ' > div').css({
                    'margin-bottom': '0px'
                });
            });
            $(document).on('click', '#gridViewWarper-' + owlCarouselId + ' .a--owl-carousel-type-2-show-detailes', function () {
                $('#gridViewWarper-' + owlCarouselId + ' > div').css({
                    'margin-bottom': '0px'
                });

                let parent = $(this).parent('#' + owlCarouselId + ' .m-widget_head-owlcarousel-item.carousel');
                let position = parent.data('position');


                let alaaOwlCarouselItemDetailClass = 'a--owl-carousel-type-2-slide-iteDetail-' + position;
                $.when($('#' + owlCarouselId + ' .subCategoryWarper').fadeOut(0)).done(function() {

                    let aOwlCarouselSlideDetailes = $('#' + owlCarouselId + ' .a--owl-carousel-type-2-slide-detailes');
                    let alaaOwlCarouselItemDetailObject = $('#' + owlCarouselId + ' .'+alaaOwlCarouselItemDetailClass);
                    $.when(aOwlCarouselSlideDetailes.slideUp(0)).done(function() {

                        if (alaaOwlCarouselItemDetailObject.length>0) {
                            aOwlCarouselSlideDetailes.fadeIn();
                            alaaOwlCarouselItemDetailObject.slideDown();
                        }


                        let detailesWarper = $('#' + owlCarouselId + ' .m-portlet.a--owl-carousel-type-2-slide-detailes');
                        let target = $('#gridViewWarper-' + owlCarouselId + ' .carousel[data-position="' + position + '"]');
                        let targetCol = target.parent();
                        targetCol.css({
                            'margin-bottom': parseInt(detailesWarper.outerHeight()) + 'px'
                        });
                        // let positionTop = parseInt(target.outerHeight()) + parseInt(target.css('margin-bottom')) + parseInt(target.css('padding-bottom')) + 35;
                        let positionTop = parseInt(targetCol.outerHeight()) + parseInt(targetCol.position().top);
                        let positionLeftOfPointer = parseInt(targetCol.position().left) + (parseInt(targetCol.outerWidth()) / 2) - 5;
                        console.log(targetCol);
                        detailesWarper.css({
                            'display': 'block',
                            'position': 'absolute',
                            'width': '100%',
                            'z-index': '1',
                            'top': positionTop + 'px'
                        });
                        let detailesWarperPointerStyle = $('#' + owlCarouselId + ' .detailesWarperPointerStyle');
                        if (detailesWarperPointerStyle.length===0) {
                            detailesWarper.append('<div class="detailesWarperPointerStyle"></div>');
                        }
                        $('#' + owlCarouselId + ' .detailesWarperPointerStyle').html('<style>.a--owl-carousel-type-2-slide-detailes::before { right: auto; left: ' + positionLeftOfPointer + 'px; }</style>');
                    });
                });
            });
        },

    };
}();


$(document).ready(function () {
    owlCarouselType2.init('owlCarouselMyProduct');
    owlCarouselType2.init('owlCarouselMyFavoritSet');



    return false;

    var myProductAlaaOwlCarouselOptions = {
        center: true,
        rtl: true,
        // loop: false,
        nav: true,
        margin: 10,
        responsive:{
            0:{
                items:1
            },
            400:{
                items:2
            },
            600:{
                items:3
            },
            800:{
                items:4
            },
            1000:{
                items:5
            }
        },
        // onDragged: callback,
        onTranslated : callback
    };
    let myProductAlaaOwlCarousel = $('.a--owl-carousel-type-2.myProduct');
    let myFavoritSetAlaaOwlCarousel = $('.a--owl-carousel-type-2.myFavoritSet');
    let myFavoritContentAlaaOwlCarousel = $('.a--owl-carousel-type-2.myFavoriteContent');
    let myProductsContentAlaaOwlCarousel = $('.a--owl-carousel-type-2.myFavoriteProducts');

    // a--owl-carousel-type-2.owlCarousel('destroy');
    myProductAlaaOwlCarousel.owlCarousel(myProductAlaaOwlCarouselOptions);
    myFavoritSetAlaaOwlCarousel.owlCarousel({
        center: true,
        rtl: true,
        loop: true,
        nav: true,
        margin: 10,
        responsive:{
            0:{
                items:1
            },
            400:{
                items:2
            },
            600:{
                items:3
            },
            800:{
                items:4
            },
            1000:{
                items:5
            }
        }
    });
    myFavoritContentAlaaOwlCarousel.owlCarousel({
        center: true,
        rtl: true,
        loop: true,
        nav: true,
        margin: 10,
        responsive:{
            0:{
                items:1
            },
            400:{
                items:2
            },
            600:{
                items:3
            },
            800:{
                items:4
            },
            1000:{
                items:5
            }
        }
    });
    myProductsContentAlaaOwlCarousel.owlCarousel({
        center: true,
        rtl: true,
        loop: true,
        nav: true,
        margin: 10,
        responsive:{
            0:{
                items:1
            },
            400:{
                items:2
            },
            600:{
                items:3
            },
            800:{
                items:4
            },
            1000:{
                items:5
            }
        }
    });
    showAlaaOwlCarouselItemDetail();

    function callback(event) {
        showAlaaOwlCarouselItemDetail();
    }

    function showAlaaOwlCarouselItemDetail() {
        let alaaOwlCarouselItemDetailClass = 'a--owl-carousel-type-2-slide-iteDetail-' + $('.a--owl-carousel-type-2 .owl-item.active.center .carousel').data('position');
        $('.subCategoryWarper').fadeOut();
        let aOwlCarouselSlideDetailes = $('.a--owl-carousel-type-2-slide-detailes');
        let alaaOwlCarouselItemDetailObject = $('.'+alaaOwlCarouselItemDetailClass);
        aOwlCarouselSlideDetailes.slideUp();
        if (alaaOwlCarouselItemDetailObject.length>0) {
            aOwlCarouselSlideDetailes.fadeIn();
            alaaOwlCarouselItemDetailObject.slideDown();
        }
    }

    $(document).on('click', '.carousel', function () {
        let position = $(this).data('position');
        let parents = $(this).parents();
        let owlCarousel = null;

        if (parents.hasClass('myProduct')) {
            owlCarousel = myProductAlaaOwlCarousel;
        } else if (parents.hasClass('myFavoritSet')) {
            owlCarousel = myFavoritSetAlaaOwlCarousel;
        } else if (parents.hasClass('myFavoriteContent')) {
            owlCarousel = myFavoritContentAlaaOwlCarousel;
        } else if (parents.hasClass('myFavoriteProducts')) {
            owlCarousel = myProductsContentAlaaOwlCarousel;
        }
        if (owlCarousel!==null) {
            $('#' + owlCarouselId).trigger('to.owl.carousel', position);
        }
    });
    $(document).on('click', '.btn-viewGrid', function () {
        $('.gridView-myProduct').html('');

        $('.subCategoryWarper').fadeOut(0);
        $('.a--owl-carousel-type-2-slide-detailes').slideUp(0);
        $('.btn-viewGrid').fadeOut(0);
        $('.btn-viewGrid').css('cssText', 'display: none !important;');
        $('.btn-viewOwlCarousel').fadeIn(0);

        let itemClass = $(this).data('itemclass');
        $('.a--owl-carousel-type-2.' + itemClass).owlCarousel('destroy');
        let gridView = $('.gridView-' + itemClass);
        $('.' + itemClass + ' .carousel').each(function() {
            gridView.append('<div class="col-12 col-sm-6 col-md-3">' + $(this)[0].outerHTML + '</div>');
        });
        $('.' + itemClass).fadeOut();
        gridView.fadeIn();
    });
    $(document).on('click', '.btn-viewOwlCarousel', function () {
        $('.gridView-myProduct').html('');

        $('.subCategoryWarper').fadeOut(0);
        $('.a--owl-carousel-type-2-slide-detailes').slideUp(0);
        $('.btn-viewGrid').fadeIn(0);
        $('.btn-viewOwlCarousel').fadeOut(0);


        $('.m-portlet.a--owl-carousel-type-2-slide-detailes').css({
            'display': 'block',
            'position': 'relative',
            'width': 'auto',
            'top': '0'
        });
        $('#detailesWarperPointerStyle').html('');



        let itemClass = $(this).data('itemclass');
        $('.a--owl-carousel-type-2.' + itemClass).owlCarousel(myProductAlaaOwlCarouselOptions);
        let gridView = $('.gridView-' + itemClass);
        gridView.fadeOut(0);
        $('.' + itemClass).fadeIn();

        showAlaaOwlCarouselItemDetail();
    });
    $(document).on('click', '.a--owl-carousel-type-2-hide-detailes', function () {
        $('.a--owl-carousel-type-2-slide-detailes').slideUp();
        $('.subCategoryWarper').fadeOut();
        $('.gridView-myProduct > div').css({
            'margin-bottom': '0px'
        });
    });
    $(document).on('click', '.gridView-myProduct .a--owl-carousel-type-2-show-detailes', function () {
        $('.gridView-myProduct > div').css({
            'margin-bottom': '0px'
        });

        let parent = $(this).parent('.m-widget_head-owlcarousel-item.carousel');
        let position = parent.data('position');


        let alaaOwlCarouselItemDetailClass = 'a--owl-carousel-type-2-slide-iteDetail-' + position;
        $.when($('.subCategoryWarper').fadeOut(0)).done(function() {

            let aOwlCarouselSlideDetailes = $('.a--owl-carousel-type-2-slide-detailes');
            let alaaOwlCarouselItemDetailObject = $('.'+alaaOwlCarouselItemDetailClass);
            $.when(aOwlCarouselSlideDetailes.slideUp(0)).done(function() {

                if (alaaOwlCarouselItemDetailObject.length>0) {
                    aOwlCarouselSlideDetailes.fadeIn();
                    alaaOwlCarouselItemDetailObject.slideDown();
                }


                let detailesWarper = $('.m-portlet.a--owl-carousel-type-2-slide-detailes');
                let target = $('.gridView-myProduct .carousel[data-position="' + position + '"]');
                let targetCol = target.parent();
                targetCol.css({
                    'margin-bottom': parseInt(detailesWarper.outerHeight()) + 'px'
                });
                // let positionTop = parseInt(target.outerHeight()) + parseInt(target.css('margin-bottom')) + parseInt(target.css('padding-bottom')) + 35;
                let positionTop = parseInt(targetCol.outerHeight()) + parseInt(targetCol.position().top);
                let positionLeftOfPointer = parseInt(targetCol.position().left) + (parseInt(targetCol.outerWidth()) / 2) - 5;
                console.log(targetCol);
                detailesWarper.css({
                    'display': 'block',
                    'position': 'absolute',
                    'width': '100%',
                    'z-index': '1',
                    'top': positionTop + 'px'
                });
                let detailesWarperPointerStyle = $('#detailesWarperPointerStyle');
                if (detailesWarperPointerStyle.length===0) {
                    detailesWarper.append('<div id="detailesWarperPointerStyle"></div>');
                }
                $('#detailesWarperPointerStyle').html('<style>.a--owl-carousel-type-2-slide-detailes::before { right: auto; left: ' + positionLeftOfPointer + 'px; }</style>');


            });
        });
    });

    $(document).on('click', '.btn.btn-warning', function () {
        $('#m_modal_1').modal('show');
    });
    $(document).on('click', '.btn.btn-success', function () {
        $('#m_modal_2').modal('show');
    });


});