
$('.OwlCarouselType2-shopPage').each(function(){
    let id = $(this).attr('id');
    $('#'+id).OwlCarouselType2({
        OwlCarousel: {
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
            btnSwfitchEvent: function() {
                imageObserver.observe();
                gtmEecProductObserver.observe();
            }
        },
        grid: {
            columnClass: 'col-12 col-sm-6 col-md-2 gridItem',
            btnSwfitchEvent: function() {
                imageObserver.observe();
                gtmEecProductObserver.observe();
            }
        },
        defaultView: 'grid', // OwlCarousel or grid
        childCountHideOwlCarousel: 4
    });
});
