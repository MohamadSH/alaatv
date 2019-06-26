jQuery(document).ready( function() {

    $('#carouselMainSlideShow img').each(function () {
        let dataWidth = $(this).data('width');
        let dataHeight = $(this).data('height');
        if (typeof dataWidth !== 'undefined' && typeof dataHeight !== 'undefined') {
            let windowWidth = $( window ).width();
            let minHeight = (windowWidth * dataHeight) / dataWidth;
            $(this).css({'min-height':minHeight+'px'});
        }
    });

    /*
     * Google TagManager
     */
    window.dataLayer = window.dataLayer || [];
    var userIpDimensionValue = $('#js-var-userIp').val();
    var userIdDimensionValue = $('#js-var-userId').val();
    dataLayer.push(
        {
            'userIp': userIpDimensionValue,
            'dimension2': userIpDimensionValue,
            'userId': userIdDimensionValue,
            'user_id': userIdDimensionValue
        });

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-full-width",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };


    const images = document.querySelectorAll('.lazy-image');

    observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.intersectionRatio > 0) {
                // console.log('in the view', entry.target);
                $(entry.target).attr('src', $(this).data('src'));
                // entry.target.classList.add('fancy');
            } else {
                // entry.target.classList.remove('fancy');
            }
        });
    });

    images.forEach(image => {
        observer.observe(image);
    });
});