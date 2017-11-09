/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {

        // Lightbox
        $('.parent-container').magnificPopup({
          delegate: 'a',
          type: 'image',
          gallery: {
            enabled: true,
            preload: [1, 3],
            tCounter: ''
          },
          mainClass: 'mfp-zoom-in',
          tLoading: '',
          removalDelay: 500, //delay removal by X to allow out-animation
          callbacks: {
            change: function() {
              console.log('SHow Loader');
            },
            imageLoadComplete: function() {
              var self = this;
              setTimeout(function() {
                self.wrap.addClass('mfp-image-loaded');
              }, 16);
            },
            close: function() {
              this.wrap.removeClass('mfp-image-loaded');
            }
          },
          closeBtnInside: false,
          closeOnContentClick: true,
          midClick: true
        });

        // Init news ticker
        $('#marquee').marquee({
          duration: 10000,
          pauseOnHover: true,
          duplicated: true
        });

        // Display the mobile navigation
        $("#nav-primary-mobile").mmenu({
          // options
          navbars: [{
            content: ['close']
          }],
          autoHeight: "default",
          offCanvas: {
            position: "top",
            zposition: "front"
          },
          slidingSubmenus: false
        }, {
          // configuration
        });

        // Custom mobile nav functionality for sub menus
        $(".mm-listview li.menu-item-has-children>a").on("click", function(event) {
          if (!$(this).hasClass("mm-next")) {
            event.preventDefault();
            event.stopPropagation();
            $(this).prev().click();
          }
        });

        // Add dropdown classes to the header navigation on hover
        $('.dropdown').hover(function() {
            $(this).addClass('open');
          },
          function() {
            $(this).removeClass('open');
          });

        $('#search-btn').on('click', function(e) {
          e.preventDefault();
          // toggle the search field
          $(this).next().animate({ width: 'toggle' });
          // move the cursor to the search field
          var input = $('.search-field');
          input[0].selectionStart = input[0].selectionEnd = input.val().length;
        });

      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {

        // Gets the actual window width, not counting scrollbar
        function getWindowWidth() {
          var windowWidth = 0;
          if (typeof(window.innerWidth) == 'number') {
            windowWidth = window.innerWidth;
          } else {
            if (document.documentElement && document.documentElement.clientWidth) {
              windowWidth = document.documentElement.clientWidth;
            } else {
              if (document.body && document.body.clientWidth) {
                windowWidth = document.body.clientWidth;
              }
            }
          }
          return windowWidth;
        }

        // Construct the featured news slider
        var projectSlider = $('.latest-news').bxSlider({
          auto: true,
          mode: 'fade',
          pause: 6000,
          pager: true,
          pagerSelector: $('#news-pager'),
          adaptiveHeight: true,
          nextSelector: $('.news-next'),
          nextText: '<i class="fa fa-chevron-circle-right"></i>',
          prevSelector: $('.news-prev'),
          prevText: '<i class="fa fa-chevron-circle-left"></i>',
          preloadImages: 'all',
          onSliderLoad: function(currentIndex) {
            var currentSlide = $('[data-slide-count="' + currentIndex + '"]');
            $('#news-title').text($(currentSlide).data('title'));
            $('#news-location').text($(currentSlide).data('location'));
            // $('#news-link').attr('href', $(currentSlide).data('link'));
            $('.loading').hide();
            $(".bxsliderWrapper").css("visibility", "visible");
          },
          onSlideBefore: function($slideElement, oldIndex, newIndex) {
            var currentSlide = $('[data-slide-count="' + newIndex + '"]');
            $('#news-title').text($(currentSlide).data('title'));
            $('#news-location').text($(currentSlide).data('location'));
            // $('#news-link').attr('href', $(currentSlide).data('link'));
          }
        });

        // Make the recent news info have the same padding and margin as header
        $('.latest-news-info').css('margin-right',
          $('.banner .container').css("margin-right").replace("px", "") +
          $('.banner .container').css("padding-right").replace("px", ""));

        function addMarginNews() {
          if (getWindowWidth() < 768) {
            $('.latest-news-info').css('margin-right', 0);
          } else {
            var bannerContainer = $('.banner .container');
            var bannerColumn = $(bannerContainer).children();

            var a = parseInt($(bannerContainer).offset().left);
            var b = parseInt($(bannerContainer).css("padding-right").replace("px", ""));
            var c = parseInt($(bannerColumn).css("padding-right").replace("px", ""));
            $('.latest-news-info').css('margin-right', a + b + c);
          }
        }

        addMarginNews();

        $(window).resize(function() {
          addMarginNews();
        });

      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
