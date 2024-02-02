/*! For license information please see bundle.js.LICENSE.txt */
(()=>{var __webpack_modules__={"./static/js/index.js":()=>{eval("var Index = Index || {};\n(function (window, $, APP) {\n  // Easing\n  // ---------------------------------------------\n  $.extend(jQuery.easing, {\n    easeOutExpo: function (x, t, b, c, d) {\n      return t == d ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b;\n    }\n  });\n\n  // Helpers\n  // ---------------------------------------------\n  APP.helpers = {\n    initComponents: function ($elem) {\n      $elem.find('[data-js-component]').each(function () {\n        var $this = $(this),\n          components = $this.data('js-component').split(' '),\n          componentName,\n          component,\n          i = 0,\n          len = components.length;\n        for (i, len; i < len; i++) {\n          componentName = components[i];\n          if (APP.pageComponents.hasOwnProperty(componentName)) {\n            component = APP.pageComponents[componentName];\n            if (typeof component === 'function') {\n              component($this, componentName);\n            } else if (typeof component === 'object') {\n              if (component.hasOwnProperty('init')) {\n                component.init($this, componentName);\n              } else {\n                console.log('Component: \"' + componentName + '\" must contain an init method.');\n              }\n            }\n          } else {\n            console.log('Component: \"' + componentName + '\" not found on the ' + APP + ' pageComponents object.');\n          }\n        }\n      });\n    }\n  };\n\n  // Page Components\n  // <elem data-js-component=\"<component name>\">\n  // ---------------------------------------------\n  APP.pageComponents = {\n    videoTrigger: function ($elem, component) {\n      var iframe = $('.js--' + component + '_iframe')[0],\n        player = $f(iframe);\n      $(iframe).hide();\n      $elem.on('click', function (e) {\n        e.preventDefault();\n        $elem.hide();\n        $(iframe).show().addClass('_is_playing');\n        player.api('play');\n      });\n    },\n    introModule: function ($elem) {\n      if ($('.page').hasClass('page--project')) {\n        setTimeout(function () {\n          $('.introModule').addClass('is-overlay');\n        }, 500);\n      }\n    },\n    videoPopoutPlayer: function ($elem) {\n      var id = $elem.attr('data-id');\n      var overlay = $('.popout_overlay');\n      $elem.on('click', function () {\n        console.log('trigger me on click');\n        overlay.fadeIn();\n        // // htmlVideo.pause();\n        $('body').addClass('_video_playing');\n        $($('.singlePage_video')[0]).attr('src', 'https://player.vimeo.com/video/' + id);\n      });\n      overlay.on('click', function () {\n        overlay.fadeOut();\n        var iframeVideo = new Vimeo.Player($('.singlePage_video')[0]);\n        iframeVideo.pause();\n      });\n    },\n    heroVideo: function ($elem, component) {\n      var $splash = $elem.find('.js--' + component + '_splash'),\n        $trigger = $elem.find('.js--' + component + '_trigger'),\n        iframe = $('.js--' + component + '_iframe')[0],\n        player = $f(iframe);\n      $trigger.on('click', openPlayer);\n      player.addEvent('ready', function () {\n        player.addEvent('finish', function () {\n          $('.pageHero_video_mask').trigger('click');\n        });\n      });\n      $elem.on('click', '.pageHero_video_mask', closePlayer);\n      function openPlayer() {\n        $splash.addClass('_is_paused');\n        $splash[0].pause();\n        $('.logo').addClass('_is_hidden');\n      }\n      function closePlayer(e) {\n        if (e.target === this && $(iframe).hasClass('_is_playing')) {\n          $(iframe).hide().removeClass('_is_playing');\n          player.api('pause');\n          $splash.removeClass('_is_paused');\n          $splash[0].play();\n          $('.logo').removeClass('_is_hidden');\n          $trigger.show();\n        }\n      }\n    },\n    lightBox_new: function ($elem) {\n      lightbox.option({\n        'resizeDuration': 300,\n        'wrapAround': true\n      });\n    },\n    lightBoxTrigger: function ($elem) {\n      $elem.on('click', function () {\n        var lightBox = $elem.attr('data-trigger');\n        $('*[data-lightbox=\"' + lightBox + '\"]').eq(0).trigger('click');\n      });\n    },\n    fadeImage: function ($elem, component) {\n      $elem.after('<div id=\"loader\" class=\"invert\"><div></div></div>');\n      $elem.each(function (i) {\n        if (this.complete) {\n          $(this).addClass('fadeIn');\n          $('#loader').remove();\n        } else {\n          $(this).load(function () {\n            $(this).addClass('fadeIn');\n            $('#loader').remove();\n          });\n        }\n      });\n    },\n    wipCarousel: function () {\n      var emblaNode = document.querySelector('.embla');\n      var options = {\n        loop: true,\n        inViewThreshold: 1\n      };\n      var embla = EmblaCarousel(emblaNode, options, [EmblaCarouselClassNames()]);\n    },\n    // lightBoxTrigger: function($elem){\n    //     console.log('...')\n    //     $elem.on('click', function(){\n    //       alert('im there')\n    //     })\n    // },\n\n    stickyHeader: function ($elem, component) {\n      var stickIsRevealed = false;\n      var lastScrollTop = 0;\n      var offset = 0;\n      function checkPos(context) {\n        var st = $(context).scrollTop();\n        if (st < 50) {\n          $elem.removeClass('is_visible');\n          stickIsRevealed = false;\n        } else {\n          if (st > lastScrollTop) {\n            if (st > offset) {\n              $elem.removeClass('is_visible');\n              stickIsRevealed = false;\n            }\n          } else {\n            if (!stickIsRevealed) {\n              offset = st - 75;\n            }\n            stickIsRevealed = true;\n            $elem.addClass('is_visible');\n          }\n        }\n        lastScrollTop = st;\n      }\n      $(window).scroll(function (event) {\n        _raf(checkPos(this));\n      });\n    }\n  };\n\n  // Helpers\n  var _raf = window.selfSelectuestAnimationFrame || window.webkitselfSelectuestAnimationFrame || window.mozselfSelectuestAnimationFrame || window.msselfSelectuestAnimationFrame || window.oselfSelectuestAnimationFrame ||\n  // IE Fallback, you can even fallback to onscroll\n  function (callback) {\n    window.setTimeout(callback, 1000 / 60);\n  };\n  var _transitionEnd = 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',\n    _animationEnd = 'webkitAnimationEnd oanimationend oAnimationEnd msAnimationEnd animationend';\n\n  // Scroll Animations\n  var winY = 0,\n    docY = 0,\n    buffer = -100,\n    $blocks,\n    $window,\n    $body,\n    $hero;\n  function setVisible() {\n    var scrollTop = $window.scrollTop(),\n      delay = 0;\n    $blocks.each(function (i) {\n      var $this = $(this),\n        offset = $this.offset().top,\n        visible = winY - buffer >= offset - scrollTop,\n        delayBuffer = $this.data('delay-buffer') ? $this.data('delay-buffer') : 0;\n      if (visible && !$this.data('visible')) {\n        setTimeout(function () {\n          $this.addClass('_visible').data('visible', true);\n        }, delay);\n        delay += parseInt(delayBuffer, 10);\n      }\n    });\n\n    // Run once more after scrolling\n    setTimeout(function () {\n      if (scrollTop !== $window.scrollTop()) {\n        setVisible();\n      }\n    }, 10);\n  }\n  function handleResize() {\n    winY = $window.height();\n    setVisible();\n  }\n  function checkPageHero() {\n    var winAspect = $window.height() / $window.width() * 100,\n      targetAspect = 9 / 16 * 100;\n    if (Math.round(winAspect * 100) / 100 <= targetAspect) {\n      return false;\n    } else {\n      $body.removeClass('_not_in_aspect').removeClass('_hop_up').removeClass('_drop_down');\n      return true;\n    }\n  }\n  function setLoadedClass() {\n    $body.removeClass('_page_loading').addClass('_page_loaded');\n    if (!checkPageHero() && $window.scrollTop() == 0) {\n      $body.addClass('_hop_up');\n      $window.on('scroll', function () {\n        $body.addClass('_drop_down');\n      });\n    } else {\n      $body.removeClass('_hop_up').removeClass('_drop_down');\n    }\n  }\n  function unsetLoadedClass() {\n    $body.removeClass('_drop_down').removeClass('_hop_up').removeClass('_nav_open').removeClass('_page_loaded').addClass('_page_loading');\n    $('.pageHero_video_mask').trigger('click');\n  }\n\n  // Document Ready\n  // ---------------------------------------------\n  $(function () {\n    $window = $(window);\n    $body = $('body');\n    $hero = $('.pageHero');\n    $blocks = $('*[data-fade]');\n    winY = $(window).height();\n    $('.globalNav_toggle').on('click', function () {\n      $body.toggleClass('_nav_open');\n      $('.pageHero_video_mask').trigger('click');\n    });\n    $('.globalNav_link').on('click', function () {\n      $body.toggleClass('_nav_open');\n      $('.pageHero_video_mask').trigger('click');\n    });\n\n    // Page Loaded for the first time\n    $window.on('load', setLoadedClass);\n\n    // Scroll Effects\n    $window.on('load', handleResize).on('scroll', function () {\n      _raf(setVisible);\n    }).on('resize', function () {\n      _raf(setVisible);\n    });\n\n    // Page Hero\n    $window.on('load', checkPageHero).on('resize', function () {\n      _raf(checkPageHero);\n    });\n    $(document).on('click', '.pageHero_more', function (e) {\n      e.preventDefault();\n      var scrollTo = $('.pageHero').outerHeight();\n      $('html, body').animate({\n        'scrollTop': scrollTo\n      }, 1000, 'easeOutExpo');\n      return false;\n    });\n\n    // Pinable\n    $(document).on('click', '.js--pinable', function (e) {\n      e.preventDefault();\n      var permalink = $(this).data('url'),\n        media = $(this).data('media'),\n        description = $(this).data('description'),\n        pinterestUrl = 'http://pinterest.com/pin/create/button/?url=' + permalink + '&media=' + media + '&description=' + description;\n      window.open(pinterestUrl, '', 'menubar=no, width=700, height=300');\n    });\n\n    // Lightbox\n    // initialize lightboxes\n    var overlayOn = function () {\n        $('<div id=\"imagelightbox-overlay\"></div>').appendTo('body');\n        $('#imagelightbox-overlay').addClass('_is_visible');\n        $(\"body\").css(\"overflow\", \"hidden\");\n      },\n      overlayOff = function () {\n        $('#imagelightbox-overlay').remove();\n        $(\"body\").css(\"overflow\", \"auto\");\n      },\n      activityIndicatorOn = function () {\n        $('<div id=\"loader\"><div></div></div>').appendTo('body');\n      },\n      activityIndicatorOff = function () {\n        $('#loader').remove();\n      };\n    $('a.js--lightboxLink').imageLightbox({\n      onStart: function () {\n        overlayOn();\n      },\n      onEnd: function () {\n        overlayOff();\n        activityIndicatorOff();\n      },\n      onLoadStart: function () {\n        activityIndicatorOn();\n      },\n      onLoadEnd: function () {\n        activityIndicatorOff();\n      }\n    });\n\n    // Instantiate Page Components\n    APP.helpers.initComponents($('body'));\n  });\n})(window, jQuery, Index, undefined);\n\n//# sourceURL=webpack://rolfs-elert-office/./static/js/index.js?")}},__webpack_exports__={};__webpack_modules__["./static/js/index.js"]()})();
//# sourceMappingURL=bundle.js.map
