class Certificate {

    constructor() {
        $('.alaaAlert').fadeOut(0);
        $('.hightschoolAlert').fadeOut(0);
        this.initCertificatesItemsHeight();
        this.defineEvents();
    }

    initCertificatesItemsHeight() {
        let A = ($('.certificates-col').height()/2);
        let B = ($('.certificates-items').height()/2);
        let calcTop = A-B;
        $('.certificates-items').css({'position':'absolute', 'top':calcTop+'px'});
    }

    defineEvents() {
        $(document).on('click', '.certificatesLogo', function(){
            let logoName = $(this).data('name');
            if (logoName === 'alaa') {
                $('.hightschoolAlert').fadeOut(0);
                $('.alaaAlert').slideDown();
            } else if (logoName === 'sharif-school') {
                $('.alaaAlert').fadeOut(0);
                $('.hightschoolAlert').slideDown();
            } else {
                $('.alaaAlert').fadeOut(0);
                $('.hightschoolAlert').fadeOut(0);
            }
        });

        $( window ).resize(function() {
            new Certificate();
        });

        let that = this;
        let lazyLoadCallback = function (obj) {
            that.initCertificatesItemsHeight();
        };
        LazyLoad.loadObject($('.certificates-row'), lazyLoadCallback);
    }
}

$(document).ready(function () {
    new Certificate();
});