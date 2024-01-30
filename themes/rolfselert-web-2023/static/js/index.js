var Index = Index || {};

(function(window, $, APP) {

    // Easing
    // ---------------------------------------------
    $.extend(jQuery.easing,
        {
            easeOutExpo: function(x, t, b, c, d) {
                return (t == d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b;
            }
        });


    // Helpers
    // ---------------------------------------------
    APP.helpers = {
        initComponents: function($elem) {
            $elem.find('[data-js-component]').each(function() {
                var $this = $(this),
                    components = $this.data('js-component').split(' '),
                    componentName,
                    component,
                    i = 0, len = components.length;

                for (i, len; i < len; i++) {

                    componentName = components[i];

                    if (APP.pageComponents.hasOwnProperty(componentName)) {
                        component = APP.pageComponents[componentName];
                        if (typeof component === 'function') {
                            component($this, componentName);
                        } else if (typeof component === 'object') {
                            if (component.hasOwnProperty('init')) {
                                component.init($this, componentName);
                            } else {
                                console.log('Component: "' + componentName + '" must contain an init method.');
                            }
                        }
                    } else {
                        console.log('Component: "' + componentName + '" not found on the ' + APP + ' pageComponents object.');
                    }
                }
            });
        }
    };

    // Page Components
    // <elem data-js-component="<component name>">
    // ---------------------------------------------
    APP.pageComponents = {
        videoTrigger: function($elem, component) {
            var iframe = $('.js--' + component + '_iframe')[0],
                player = $f(iframe);

            $(iframe).hide();
            $elem.on('click', function(e) {
                e.preventDefault();
                $elem.hide();
                $(iframe).show().addClass('_is_playing');
                player.api('play');
            });
        },

        introModule: function($elem) {

            if ($('.page').hasClass('page--project')) {
                setTimeout(function() {
                    $('.introModule').addClass('is-overlay');
                }, 500);

            }
        },

        videoPopoutPlayer: function($elem) {

            var id = $elem.attr('data-id')
            var overlay = $('.popout_overlay')

            $elem.on('click', function() {
                console.log('trigger me on click')

                overlay.fadeIn();
                // // htmlVideo.pause();
                $('body').addClass('_video_playing');
                $($('.singlePage_video')[0]).attr('src', 'https://player.vimeo.com/video/' + id)
            })


            overlay.on('click', function() {
                overlay.fadeOut();
                var iframeVideo = new Vimeo.Player($('.singlePage_video')[0])
                iframeVideo.pause();
            })

        },

        heroVideo: function($elem, component) {
            var $splash = $elem.find('.js--' + component + '_splash'),
                $trigger = $elem.find('.js--' + component + '_trigger'),
                iframe = $('.js--' + component + '_iframe')[0],
                player = $f(iframe);

            $trigger.on('click', openPlayer);

            player.addEvent('ready', function() {
                player.addEvent('finish', function() {
                    $('.pageHero_video_mask').trigger('click');
                });
            });

            $elem.on('click', '.pageHero_video_mask', closePlayer);

            function openPlayer() {
                $splash.addClass('_is_paused');
                $splash[0].pause();
                $('.logo').addClass('_is_hidden');
            }

            function closePlayer(e) {
                if ((e.target === this) && $(iframe).hasClass('_is_playing')) {
                    $(iframe).hide().removeClass('_is_playing');
                    player.api('pause');
                    $splash.removeClass('_is_paused');
                    $splash[0].play();
                    $('.logo').removeClass('_is_hidden');
                    $trigger.show();
                }
            }
        },

        lightBox_new: function($elem) {
            lightbox.option({
                'resizeDuration': 300,
                'wrapAround': true
            })
        },

        lightBoxTrigger: function($elem) {
            $elem.on('click', function() {

                var lightBox = $elem.attr('data-trigger')
                $('*[data-lightbox="' + lightBox + '"]').eq(0).trigger('click');
            })
        },

        fadeImage: function($elem, component) {

            $elem.after('<div id="loader" class="invert"><div></div></div>');
            $elem.each(function(i) {

                if (this.complete) {
                    $(this).addClass('fadeIn');
                    $('#loader').remove();
                } else {
                    $(this).load(function() {
                        $(this).addClass('fadeIn');
                        $('#loader').remove();
                    });
                }
            });
        },

        wipCarousel: function() {
            var emblaNode = document.querySelector('.embla')
            var options = {
                loop: true,
                inViewThreshold: 1
            };
            var embla = EmblaCarousel(emblaNode, options, [EmblaCarouselClassNames()]);
        },

        // lightBoxTrigger: function($elem){
        //     console.log('...')
        //     $elem.on('click', function(){
        //       alert('im there')
        //     })
        // },

        stickyHeader: function($elem, component) {

            var stickIsRevealed = false;
            var lastScrollTop = 0;
            var offset = 0

            function checkPos(context) {

                var st = $(context).scrollTop();

                if (st < 50) {
                    $elem.removeClass('is_visible');
                    stickIsRevealed = false;
                } else {
                    if (st > lastScrollTop) {
                        if (st > offset) {
                            $elem.removeClass('is_visible');
                            stickIsRevealed = false;
                        }
                    } else {

                        if (!stickIsRevealed) {
                            offset = st - 75;
                        }
                        stickIsRevealed = true;
                        $elem.addClass('is_visible')
                    }
                }
                lastScrollTop = st;
            }


            $(window).scroll(function(event) {
                _raf(checkPos(this));
            });

        }
    };

    // Helpers
    var _raf = window.selfSelectuestAnimationFrame ||
        window.webkitselfSelectuestAnimationFrame ||
        window.mozselfSelectuestAnimationFrame ||
        window.msselfSelectuestAnimationFrame ||
        window.oselfSelectuestAnimationFrame ||
        // IE Fallback, you can even fallback to onscroll
        function(callback) {
            window.setTimeout(callback, 1000 / 60)
        };

    var _transitionEnd = 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',
        _animationEnd = 'webkitAnimationEnd oanimationend oAnimationEnd msAnimationEnd animationend';

    // Scroll Animations
    var winY = 0,
        docY = 0,
        buffer = -100,
        $blocks,
        $window,
        $body,
        $hero;

    function setVisible() {
        var scrollTop = $window.scrollTop(),
            delay = 0;

        $blocks.each(function(i) {
            var $this = $(this),
                offset = $this.offset().top,
                visible = ((winY - buffer) >= (offset - scrollTop)),
                delayBuffer = ($this.data('delay-buffer')) ? $this.data('delay-buffer') : 0;

            if (visible && (!$this.data('visible'))) {
                setTimeout(function() {
                    $this.addClass('_visible')
                        .data('visible', true);
                }, delay);
                delay += parseInt(delayBuffer, 10);
            }
        });

        // Run once more after scrolling
        setTimeout(function() {
            if (scrollTop !== $window.scrollTop()) {
                setVisible();
            }
        }, 10);
    }

    function handleResize() {
        winY = $window.height();
        setVisible();
    }

    function checkPageHero() {

        var winAspect = ($window.height() / $window.width()) * 100,
            targetAspect = (9 / 16) * 100;
        if ((Math.round(winAspect * 100) / 100) <= targetAspect) {
            return false;
        } else {
            $body
                .removeClass('_not_in_aspect')
                .removeClass('_hop_up')
                .removeClass('_drop_down');

            return true;

        }

    }

    function setLoadedClass() {
        $body.removeClass('_page_loading').addClass('_page_loaded');

        if ((!checkPageHero()) && ($window.scrollTop() == 0)) {
            $body.addClass('_hop_up');
            $window.on('scroll', function() {
                $body.addClass('_drop_down');
            });
        } else {
            $body
                .removeClass('_hop_up')
                .removeClass('_drop_down');
        }
    }

    function unsetLoadedClass() {
        $body
            .removeClass('_drop_down')
            .removeClass('_hop_up')
            .removeClass('_nav_open')
            .removeClass('_page_loaded')
            .addClass('_page_loading');
        $('.pageHero_video_mask').trigger('click');
    }

    // Document Ready
    // ---------------------------------------------
    $(function() {
        $window = $(window);
        $body = $('body');
        $hero = $('.pageHero');
        $blocks = $('*[data-fade]');
        winY = $(window).height();

        $('.globalNav_toggle').on('click', function() {
            $body.toggleClass('_nav_open');
            // $('.pageHero_video_mask').trigger('click');
        });
        $('.globalNav_link').on('click', function() {
            $body.toggleClass('_nav_open');
            // $('.pageHero_video_mask').trigger('click');
        });

        // Page Loaded for the first time
        $window.on('load', setLoadedClass);

        // Scroll Effects
        $window.on('load', handleResize)
            .on('scroll', function() {
                _raf(setVisible);
            })
            .on('resize', function() {
                _raf(setVisible);
            });

        // Page Hero
        $window.on('load', checkPageHero)
            .on('resize', function() {
                _raf(checkPageHero);
            });


        $(document).on('click', '.pageHero_more', function(e) {
            e.preventDefault();

            var scrollTo = $('.pageHero').outerHeight();

            $('html, body').animate({
                'scrollTop': scrollTo
            }, 1000, 'easeOutExpo');

            return false;
        });

        // Pinable
        $(document).on('click', '.js--pinable', function(e) {
            e.preventDefault();

            var permalink = $(this).data('url'),
                media = $(this).data('media'),
                description = $(this).data('description'),
                pinterestUrl = 'http://pinterest.com/pin/create/button/?url=' + permalink +
                    '&media=' + media +
                    '&description=' + description;

            window.open(pinterestUrl, '', 'menubar=no, width=700, height=300');
        });

        // Lightbox
        // initialize lightboxes
        var overlayOn = function() {
                $('<div id="imagelightbox-overlay"></div>').appendTo('body');
                $('#imagelightbox-overlay').addClass('_is_visible');
                $("body").css("overflow", "hidden");
            },
            overlayOff = function() {
                $('#imagelightbox-overlay').remove();
                $("body").css("overflow", "auto");
            },
            activityIndicatorOn = function() {
                $('<div id="loader"><div></div></div>').appendTo('body');
            },
            activityIndicatorOff = function() {
                $('#loader').remove();
            };

        $('a.js--lightboxLink').imageLightbox({
            onStart: function() {
                overlayOn();
            },
            onEnd: function() {
                overlayOff();
                activityIndicatorOff();
            },
            onLoadStart: function() {
                activityIndicatorOn();
            },
            onLoadEnd: function() {
                activityIndicatorOff();
            }
        });

        // Instantiate Page Components
        APP.helpers.initComponents($('body'));

    });
}(window, jQuery, Index, undefined));
