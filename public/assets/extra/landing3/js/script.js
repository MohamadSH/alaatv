(function ($) {
  "use strict";

  $('.navbar-header .menu-item-has-children').on('click', function () {
    $(this).toggleClass('open');
  });

  /*-------------------------------------
        </> @author Mohammadreza pazani
     </> MTabs
     </> @version 1.0
     </> @version 1.0.1 Initial tab
     </> @version 1.0.2 Default tab
     </> @version 1.0.3 Navigation arrows
     </> @version 1.0.4 Initial default tab if it isn't initialed
    ------------------------------------*/
  $('[data-tabindex]').each(function () {
    var index = $(this).attr('data-tabindex');
    var active = false;
    $('[data-tabindex="' + index + '"] [data-tabc]').hide();
    $('[data-tabindex="' + index + '"] .tab-title [data-tab]').each(function () {
      if ($(this).hasClass('active')) {
        var i = $(this).attr('data-tab');
        $('[data-tabindex="' + index + '"] [data-tabc="' + i + '"]').fadeIn();
        active = true;
        return false;
      }
    });
    if (active === false) {
      $('[data-tabindex="' + index + '"] [data-tabc]:first-of-type').fadeIn();
      $('[data-tabindex="' + index + '"] [data-tab]:first-of-type').addClass('active');
    }
    $('[data-tabindex="' + index + '"] .tab-title [data-tab]')
      .on('click', function () {
        var t = $(this).attr('data-tab');
        $('[data-tabindex="' + index + '"] .tab-title [data-tab]').removeClass('active');
        $(this).addClass('active');
        $('[data-tabindex="' + index + '"] [data-tabc]').hide();
        $('[data-tabindex="' + index + '"] [data-tabc="' + t + '"]').fadeIn();
      });
    $('[data-tabindex="' + index + '"]  nav .prev').on('click', function () {
      var t = parseInt($('[data-tabindex="' + index + '"]  .tab-title [data-tab].active').attr('data-tab')) - 1;
      if (t == 0)
        return false;
      $('[data-tabindex="' + index + '"] .tab-title [data-tab].active').removeClass('active');
      $('[data-tabindex="' + index + '"] [data-tabc]').hide();
      $('[data-tabindex="' + index + '"] [data-tab="' + t + '"]').addClass('active');
      $('[data-tabindex="' + index + '"] [data-tabc="' + t + '"]').fadeIn();
    });
    $('[data-tabindex="' + index + '"] nav .next').on('click', function () {
      var t = parseInt($('[data-tabindex="' + index + '"] .tab-title [data-tab].active').attr('data-tab'));
      var list = $('[data-tabindex="' + index + '"] .tab-title [data-tab]').length;
      if (t == list)
        return false;
      t++;
      $('[data-tabindex="' + index + '"] .tab-title [data-tab].active').removeClass('active');
      $('[data-tabindex="' + index + '"] [data-tabc]').hide();
      $('[data-tabindex="' + index + '"] [data-tab="' + t + '"]').addClass('active');
      $('[data-tabindex="' + index + '"] [data-tabc="' + t + '"]').fadeIn();
    });
  });

  /*-------------------------------------
     </> Swipers
     </> introduction
    ------------------------------------*/
  var swiper_content_field = new Swiper('.swiper-content-field-all', {
    slidesPerView: 'auto',
    spaceBetween: 14,
    grabCursor: true,
    noSwiping: false,
    navigation: {
      nextEl: '.i-all-next',
      prevEl: '.i-all-prev',
    },
    // autoplay: {
    //   delay: 6000,
    //   disableOnInteraction: false,
    // },

  });
  var nenu_res = new Swiper('.menu-res', {
    slidesPerView: 'auto',
    spaceBetween: 85,
    autoplay: {
      delay: 9000,
      disableOnInteraction: false,
    },

  });
  var swiper_content_field_experiential = new Swiper('.swiper-content-field-experiential', {
    slidesPerView: 'auto',
    spaceBetween: 14,
    grabCursor: true,
    noSwiping: false,
    navigation: {
      nextEl: '.i-experiential-next',
      prevEl: '.i-experiential-prev',
    },
    // autoplay: {
    //   delay: 6000,
    //   disableOnInteraction: false,
    // },

  });
  var swiper_content_field_math = new Swiper('.swiper-content-field-math', {
    slidesPerView: 'auto',
    spaceBetween: 14,
    grabCursor: true,
    noSwiping: false,
    navigation: {
      nextEl: '.i-math-next',
      prevEl: '.i-math-prev',
    },
    // autoplay: {
    //   delay: 6000,
    //   disableOnInteraction: false,
    // },

  });


  /*-------------------------------------
     </> mmenu
    ------------------------------------*/
  // var $menu = $('#menu').mmenu({
  //   extensions: [
  //     'pagedim-black',
  //     'border-offset',
  //     'fx-menu-slide',
  //     'fx-panels-none'
  //   ],
  //   navbar: {
  //     add: false,
  //     title: 'منو',
  //     titleLink: 'parent'
  //   },
  //   slidingSubmenus: false,
  //   offCanvas: {
  //     position: 'right',
  //     zposition: 'back'
  //   },
  //   keyboardNavigation: {
  //     enable: 'default',
  //     enhance: true
  //   },
  //   lazySubmenus: {
  //     load: true
  //   },
  //   setSelected: {
  //     current: 'detect',
  //     hover: true,
  //     parent: true
  //   }
  // }, {
  //   transitionDuration: 500,
  //   offCanvas: {
  //     pageSelector: '#main-page'
  //   },
  //   screenReader: {
  //     text: {
  //       closeMenu: 'بستن منو',
  //       closeSubmenu: 'بستن زیر منو',
  //       openSubmenu: 'بازکردن زیر منو',
  //       toggleSubmenu: 'باز و بسته کردن منو'
  //     }
  //   }
  // });
  // var API = $menu.data('mmenu');
  // $('#navbar-toggler').on('click', function () {
  //   API.open();
  // });
  $('#menu .menu-item-has-children').on('click', function () {
    $(this).find('> div.mm-panel.mm-vertical').slideToggle();
    $(this).toggleClass('active');
  });

    $('.checkout').click(function() {
        var id = $(this).data('role');
        $.ajax({
            url: storeOrderUrl,
            type: 'POST',
            // contentType: 'application/json; charset=UTF-8',
            // dataType: 'json',
            // timeout: 10000,
            data: {
            product_id: id
        },
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                if(response.redirectUrl!= null && response.redirectUrl!="undefined")
                    window.location.replace(response.redirectUrl);
            },
            //The status for when the user is not authorized for making the request
            403: function (response) {
                console.log("response 403");
            },
            //The status for when the user is not authorized for making the request
            401: function (response) {
                console.log("response 401");
            },
            404: function (response) {
                console.log("response 404");
            },
            //The status for when form data is not valid
            422: function (response) {
                console.log(response);
            },
            //The status for when there is error php code
            500: function (response) {
                console.log("response 500");
                console.log(response.responseText);
            },
            //The status for when there is error php code
            503: function (response) {
                response = $.parseJSON(response.responseText);
                console.log(response.message);
            }
        }
    });
        return false;
    });

})(jQuery);