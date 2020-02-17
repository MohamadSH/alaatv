var mLayout = function() {
    var asideMenu;
    var asideMenuOffcanvas;
    var horMenuOffcanvas;
    var asideLeftToggle;
    var quicksearch;
    var mainPortlet;

    //== Hor menu
    var initHorMenu = function() {
        $(document).on('click', '.m-aside-menu .m-menu__item.m-menu__item--submenu', function (e) {
            if ($(this).hasClass('m-menu__item--open')) {
                $(this).removeClass('m-menu__item--open');
                $(this).find('.m-menu__submenu').fadeOut();
            } else {
                $(this).addClass('m-menu__item--open');
                $(this).find('>.m-menu__submenu').fadeIn();
            }
            e.stopPropagation();
        });
    };

    //== Aside menu
    var initLeftAsideMenu = function() {
        //== Init aside menu
        var menu = mUtil.get('m_ver_menu');
        var menuDesktopMode = (mUtil.attr(menu, 'm-menu-dropdown') === '1' ? 'dropdown' : 'accordion');

        var scroll;
        if ( mUtil.attr(menu, 'm-menu-scrollable') === '1' ) {
            scroll = {
                height: function() {
                    if (mUtil.isInResponsiveRange('desktop')) {
                        return mUtil.getViewPort().height - parseInt(mUtil.css('m_header', 'height'));
                    }
                }
            };
        }
    };

    //== Aside
    var initLeftAside = function() {
        // init aside left offcanvas
        var body = mUtil.get('body');
        var asideLeft = mUtil.get('m_aside_left');

        //== Handle minimzied aside hover
        if (mUtil.hasClass(body, 'm-aside-left--fixed')) {
            var insideTm;
            var outsideTm;

            mUtil.addEvent(asideLeft, 'mouseenter', function() {
                if (outsideTm) {
                    clearTimeout(outsideTm);
                    outsideTm = null;
                }

                insideTm = setTimeout(function() {
                    if (mUtil.hasClass(body, 'm-aside-left--minimize') && mUtil.isInResponsiveRange('desktop')) {
                        mUtil.removeClass(body, 'm-aside-left--minimize');
                        mUtil.addClass(body, 'm-aside-left--minimize-hover');
                        asideMenu.scrollerUpdate();
                        asideMenu.scrollerTop();
                    }
                }, 300);
            });

            mUtil.addEvent(asideLeft, 'mouseleave', function() {
                if (insideTm) {
                    clearTimeout(insideTm);
                    insideTm = null;
                }

                outsideTm = setTimeout(function() {
                    if (mUtil.hasClass(body, 'm-aside-left--minimize-hover') && mUtil.isInResponsiveRange('desktop')) {
                        mUtil.removeClass(body, 'm-aside-left--minimize-hover');
                        mUtil.addClass(body, 'm-aside-left--minimize');
                        asideMenu.scrollerUpdate();
                        asideMenu.scrollerTop();
                    }
                }, 500);
            });
        }
    };

    //== Sidebar toggle
    var initLeftAsideToggle = function() {
        $(document).on('click', '#m_aside_left_hide_toggle', function () {
            if ($('body').hasClass('m-aside-left--hide') && !mUtil.isMobileDevice()) {
                $(this).removeClass('m-brand__toggler--active');
                $('body').removeClass('m-aside-left--hide');
            } else {
                $(this).addClass('m-brand__toggler--active');
                $('body').addClass('m-aside-left--hide');
            }
        });
        $(document).on('click', '#m_aside_left_offcanvas_toggle', function () {
            if ($('body').hasClass('m-aside-left--on')) {
                $(this).removeClass('m-brand__toggler--active');
                $('body').removeClass('m-aside-left--on');
                $('#m_aside_left').css({'right': '-300px'});
            } else {
                $(this).addClass('m-brand__toggler--active');
                $('body').addClass('m-aside-left--on');
                $('#m_aside_left').css({'right': '0'});
            }
        });
        $(document).click(function(event) {
            var $target = $(event.target);

            if($target.closest('#m_aside_left').length === 0 && $target[0].id !== 'm_aside_left_offcanvas_toggle' && mUtil.isMobileDevice()) {
                $(this).removeClass('m-brand__toggler--active');
                $('body').removeClass('m-aside-left--on');
                $('#m_aside_left').css({'right': '-300px'});
            }
        });
    };

    //== Sidebar hide
    var initLeftAsideHide = function() {
        $(this).addClass('m-brand__toggler--active');
        $('body').removeClass('m-aside-left--on');
    };

    //== Topbar
    var initTopbar = function() {
        $('#m_aside_header_topbar_mobile_toggle').click(function() {
            $('body').toggleClass('m-topbar--on');
        });
    };

    //== Quicksearch
    var initQuicksearch = function() {
        if ($('#m_quicksearch').length === 0 ) {
            return;
        }

        quicksearch = new mQuicksearch('m_quicksearch', {
            mode: mUtil.attr( 'm_quicksearch', 'm-quicksearch-mode' ), // quick search type
            minLength: 1
        });

        quicksearch.on('search', function(the) {
            if ($('#m_quicksearch_input').val().trim().length < 3) {
                showDataOnQuickSearchResultPannel('');
                return false;
            }
            showDataOnQuickSearchResultPannel('کمی صبر کنید ...');
            the.showProgress();

            $.ajax({
                url: '/c?q=' + $('#m_quicksearch_input').val(),
                data: {},
                dataType: 'json',
                success: function(res) {
                    the.hideProgress();
                    the.showResult(res);

                    showResultForQuickSearch(res);
                },
                error: function(res) {
                    the.hideProgress();
                    the.showError('مشکلی پیش آمده است. لطفا بعدا امتحان کنید.');
                }
            });
        });

        $(document).on('click', '#m_quicksearch_close', function () {
            showDataOnQuickSearchResultPannel('');
        });
    };

    function showDataOnQuickSearchResultPannel(html) {
        $('.a-quick-search .m-dropdown__content').html('');
        $('.a-quick-search .m-dropdown__content').append('<dvi class="a-dropdown__search-result">'+html+'</dvi>');
    }

    function showResultForQuickSearch(res) {
        var maxRecordOfEachCategory = 3;
        var article = res.result.article;
        var pamphlet = res.result.pamphlet;
        var product = res.result.product;
        var set = res.result.set;
        var video = res.result.video;

        var html = '';

        html += gteQuickSearchResultCategory('article', 'مقالات', article, maxRecordOfEachCategory);
        html += gteQuickSearchResultCategory('pamphlet', 'جزوات', pamphlet, maxRecordOfEachCategory);
        html += gteQuickSearchResultCategory('product', 'محصولات', product, maxRecordOfEachCategory);
        html += gteQuickSearchResultCategory('set', 'دسته ها', set, maxRecordOfEachCategory);
        html += gteQuickSearchResultCategory('video', 'ویدیوها', video, maxRecordOfEachCategory);
        showDataOnQuickSearchResultPannel(html);
    }

    function getQuickSearchResultItem(data) {
        return '    <!--begin::Widget 14 Item-->\n' +
            '    <div class="m-widget4__item">\n' +
            '        <div class="m-widget4__img m-widget4__img--pic">\n' +
            '            <img src="'+data.photo+'" alt="">\n' +
            '        </div>\n' +
            '        <div class="m-widget4__info">\n' +
            '            <span class="m-widget4__title">\n' +
            '                '+data.title+'\n' +
            '            </span>' +
            '            <br>\n' +
            '            <span class="m-widget4__sub">\n' +
            '                '+data.subtitle+'\n' +
            '            </span>\n' +
            '        </div>\n' +
            '        <div class="m-widget4__ext">\n' +
            '            <a href="'+data.link+'" class="m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">مشاهده</a>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <!--end::Widget 14 Item-->\n';
    }

    function gteQuickSearchResultCategory(categoryType, categoryName, data, maxRecordOfCategory) {
        var html = '';
        if (data !== null && data.total > 0) {
            html += '<div class="kt-quick-search__category">'+categoryName+'</div>';
            html += '<div class="m-widget4">';
            for (var index in data.data) {
                if(isNaN(index)) {
                    continue;
                }
                if(index > maxRecordOfCategory) {
                    break;
                }
                var dataItem = data.data[index];
                var inputData = getInputDataForQuickSearchShowResult(categoryType, dataItem);
                html += getQuickSearchResultItem(inputData);
            }
            html += '</div>';
        }
        return html;
    }

    function getInputDataForQuickSearchShowResult(categoryType, data) {
        if (categoryType === 'video') {
            return {
                title: data.author.full_name,
                subtitle: data.name,
                photo: data.thumbnail,
                link: data.url,
            };
        } else if (categoryType === 'set') {
            return {
                title: data.shortName,
                subtitle: data.name,
                photo: data.photo,
                link: data.url,
            };
        } else if (categoryType === 'product') {
            return {
                title: data.name,
                subtitle: '',
                photo: data.photo,
                link: data.url,
            };
        } else if (categoryType === 'pamphlet') {
            return {
                title: data.author.full_name,
                subtitle: data.name,
                photo: data.thumbnail,
                link: data.url,
            };
        } else if (categoryType === 'article') {
            return {
                title: data.author.full_name,
                subtitle: data.name,
                photo: data.thumbnail,
                link: data.url,
            };
        }
    }

    //== Scrolltop
    var initScrollTop = function() {

        var handleShownTopScroll = function() {
            if (window.pageYOffset > window.screen.height) {
                $('body').addClass('m-scroll-top--shown');
            } else {
                $('body').removeClass('m-scroll-top--shown');
            }
        };

        $(document).on('click', '#m_scroll_top', function () {
            $([document.documentElement, document.body]).animate({
                scrollTop: $('body').offset().top
            }, 300);
        });


        // handle window scroll
        if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {
            window.addEventListener('touchend', function() {
                handleShownTopScroll();
            });

            window.addEventListener('touchcancel', function() {
                handleShownTopScroll();
            });

            window.addEventListener('touchleave', function() {
                handleShownTopScroll();
            });
        } else {
            window.addEventListener('scroll', function() {
                handleShownTopScroll();
            });
        }
    };

    //== Main portlet(sticky portlet)
    var createMainPortlet = function() {
        return new mPortlet('main_portlet', {
            sticky: {
                offset: parseInt(mUtil.css( mUtil.get('m_header'), 'height')) + parseInt(mUtil.css( mUtil.get('a_top_section'), 'height')),
                zIndex: 90,
                position: {
                    top: function() {
                        return parseInt(mUtil.css( mUtil.get('m_header'), 'height') );
                    },
                    left: function() {
                        var left = parseInt(mUtil.css( mUtil.getByClass('m-content'), 'paddingLeft'));

                        if (mUtil.isInResponsiveRange('desktop')) {
                            //left += parseInt(mUtil.css(mUtil.get('m_aside_left'), 'width') );
                            if (mUtil.hasClass(mUtil.get('body'), 'm-aside-left--minimize')) {
                                left += 78; // need to use hardcoded width of the minimize aside
                            } else {
                                left += 255; // need to use hardcoded width of the aside
                            }
                        }

                        return left;
                    },
                    right: function() {
                        return parseInt(mUtil.css( mUtil.getByClass('m-content'), 'paddingRight') );
                    }
                }
            }
        });
    };

    return {

        init: function() {
            this.initHeader();
            this.initAside();
        },

        initMainPortlet: function() {
            if (!mUtil.get('main_portlet')) {
                return;
            }
        },

        resetMainPortlet: function() {
            mainPortlet.destroySticky();
            mainPortlet = createMainPortlet();
            mainPortlet.initSticky();
        },

        initHeader: function() {
            initHorMenu();
            initTopbar();
            initQuicksearch();
            initScrollTop();
        },

        initAside: function() {
            initLeftAside();
            initLeftAsideMenu();
            initLeftAsideToggle();
            initLeftAsideHide();
        },

        getAsideMenu: function() {
            return asideMenu;
        },

        onLeftSidebarToggle: function(handler) {
            if (asideLeftToggle) {
                asideLeftToggle.on('toggle', handler);
            }
        },

        closeMobileAsideMenuOffcanvas: function() {
            if (mUtil.isMobileDevice()) {
                asideMenuOffcanvas.hide();
            }
        },

        closeMobileHorMenuOffcanvas: function() {
            if (mUtil.isMobileDevice()) {
                horMenuOffcanvas.hide();
            }
        }
    };
}();

$(document).ready(function() {
    mLayout.init();
});
