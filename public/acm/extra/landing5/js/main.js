
function clearBtnSelectReshteShadow() {
    $('.btnShowAllReshte').removeClass('btnAllReshteShadow');
    $('.btnShowRiazi').removeClass('btnRiaziReshteShadow');
    $('.btnShowTajrobi').removeClass('btnTajrobiReshteShadow');
}


$(document).on('click', '.btnShowTajrobi', function () {
    clearBtnSelectReshteShadow();
    $(this).addClass('btnTajrobiReshteShadow');
    $('.riazi, .tajrobi').fadeOut(0);
    $('.tajrobi').fadeIn(500);
    $('.warperOfFirstAndSecondSection').css('background-image', 'linear-gradient(to right top, #04002e, #093061, #0b5f97, #0092cc, #00c8ff)');
});
$(document).on('click', '.btnShowRiazi', function () {
    clearBtnSelectReshteShadow();
    $(this).addClass('btnRiaziReshteShadow');
    $('.riazi, .tajrobi').fadeOut(0);
    $('.riazi').fadeIn(500);
    $('.warperOfFirstAndSecondSection').css('background-image', 'linear-gradient(to right top, #2e0000, #5e0012, #930017, #c90014, #ff0000)');
});
$(document).on('click', '.btnShowAllReshte', function () {
    clearBtnSelectReshteShadow();
    $(this).addClass('btnAllReshteShadow');
    $('.riazi, .tajrobi').fadeOut(0);
    $('.tajrobi').fadeIn(500);
    $('.riazi').fadeIn(500);
    $('.warperOfFirstAndSecondSection').css('background-image', 'linear-gradient(to right top, #041800, #114913, #17821a, #22bf19, #37ff00)');
});
$(document).on('click', '.btnGoToProductSection', function () {
    $([document.documentElement, document.body]).animate({
        scrollTop: $('#section2').offset().top
    }, 500, function () {
        // $('.navbar-nav a').removeClass('current');
        // $('a.navItem2').addClass('current');
    });
});


var h = document.documentElement,
    b = document.body,
    st = 'scrollTop',
    sh = 'scrollHeight',
    progress = document.querySelector('.progress'),
    scroll;

document.addEventListener('scroll', function() {
    scroll = (h[st]||b[st]) / ((h[sh]||b[sh]) - h.clientHeight) * 100;
    // progress.style.setProperty('--scroll', scroll + '%');
    $('.progress').css('width', scroll + '%');
});

(function($) {

	"use strict";

	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
			BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
			iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
			Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
			Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
			any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};

	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
    fullHeight();

	// loader
	var loader = function() {
		setTimeout(function() { 
			if($('#ftco-loader').length > 0) {
				$('#ftco-loader').removeClass('show');
			}
		}, 1);
	};
	loader();

	var contentWayPoint = function() {
		var i = 0;
		$('.ftco-animate').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {

				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function(){

					$('body .ftco-animate.item-animate').each(function(k){
						var el = $(this);
						setTimeout( function () {
							var effect = el.data('animate-effect');
							if ( effect === 'fadeIn') {
								el.addClass('fadeIn ftco-animated');
							} else if ( effect === 'fadeInLeft') {
								el.addClass('fadeInLeft ftco-animated');
							} else if ( effect === 'fadeInRight') {
								el.addClass('fadeInRight ftco-animated');
							} else {
								el.addClass('fadeInUp ftco-animated');
							}
							el.removeClass('item-animate');
						},  k * 50, 'easeInOutExpo' );
					});

				}, 100);

			}

		} , { offset: '95%' } );
	};
	contentWayPoint();


})(jQuery);

window.onload = function() {
    Particles.init(
        {
            'selector': '.particles-js',
            // color: ['#DA0463', '#404B69', '#DBEDF3'],
            color: ['#100006', '#093061', '#0b5f97', '#0092cc', '#00c8ff', '#5e0012', '#930017', '#c90014', '#ff0000', '#041800', '#17821a', '#22bf19', '#37ff00'],
            connectParticles: true,
            maxParticles: 300,
            sizeVariations: 6,
            speed: 0.7,
            minDistance: 100
        });
};