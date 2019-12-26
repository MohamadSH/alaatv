var MapSVG = function () {

    var marker = true,
        panzoom,
        delta,
        direction,
        interval = 1,
        counter1 = 0,
        counter2,
        counter3,
        counter4;

    function getMapSteps() {
        var zoomLevel = getZoomLevel();

        if (zoomLevel === 1) {
            return getMapStepLevel1();
        } else if (zoomLevel === 2) {
            return getMapStepLevel2();
        } else {
            return [];
        }
    }

    function getMajorStep() {
        return {
            'pishAzmoon': {
                contentId: 717,
                tooltipName: 'پیش آزمون'
            },
            'SefrTaSad': {
                contentId: 217,
                tooltipName: 'صفر تا صد'
            },
            'BarAndaz': {
                contentId: 665,
                tooltipName: 'بار انداز'
            },
            'Gift-Godar': {
                contentId: 747,
                tooltipName: 'گدار'
            },
            'Pile': {
                contentId: 604,
                tooltipName: 'پیله'
            },
        };
    }

    function getMapStepLevel1() {
        return Object.assign({}, getMajorStep(), {
            'farsang-step-1': {
                contentId: 617,
                tooltipName: 'فرسنگ اول'
            },
            'farsang-step-2': {
                contentId: 642,
                tooltipName: 'فرسنگ دوم'
            },
            'farsang-step-3': {
                contentId: 643,
                tooltipName: 'فرسنگ سوم'
            },
            'farsang-step-4': {
                contentId: 644,
                tooltipName: 'فرسنگ چهارم'
            },
            'farsang-step-5': {
                contentId: null,
                tooltipName: 'فرسنگ پنجم'
            },
            'farsang-step-6': {
                contentId: null,
                tooltipName: 'فرسنگ ششم'
            },
            'farsang-step-7': {
                contentId: null,
                tooltipName: 'فرسنگ هفتم'
            },
            'farsang-step-8': {
                contentId: null,
                tooltipName: 'فرسنگ هشتم'
            },
            'farsang-step-9': {
                contentId: null,
                tooltipName: 'فرسنگ نهم'
            },
            'farsang-step-10': {
                contentId: null,
                tooltipName: 'فرسنگ دهم'
            }
        });
    }

    function getMapStepLevel2() {
        var mapStepLevel1 = getMapStepLevel1();
        return Object.assign({}, getMajorStep(), {
            'farsang-step-1-Pish-Azmoon': {
                contentId: mapStepLevel1['farsang-step-1'].contentId,
                sectionId: 5,
                tooltipName: 'پیش آزمون'
            },
            'farsang-step-1-Konkorche': {
                contentId: mapStepLevel1['farsang-step-1'].contentId,
                sectionId: 4,
                tooltipName: 'کنکورچه'
            },
            'farsang-step-1-Hal-Test': {
                contentId: mapStepLevel1['farsang-step-1'].contentId,
                sectionId: 3,
                tooltipName: 'حل تست'
            },
            'farsang-step-1-Tavarogh': {
                contentId: mapStepLevel1['farsang-step-1'].contentId,
                sectionId: 2,
                tooltipName: 'تورق سریع'
            },
            'farsang-step-1-Tablo-Rahnama': {
                contentId: mapStepLevel1['farsang-step-1'].contentId,
                sectionId: 1,
                tooltipName: 'تابلو راهنما'
            },

            'farsang-step-2-Pish-Azmoon': {
                contentId: mapStepLevel1['farsang-step-2'].contentId,
                sectionId: 5,
                tooltipName: 'پیش آزمون'
            },
            'farsang-step-2-Konkorche': {
                contentId: mapStepLevel1['farsang-step-2'].contentId,
                sectionId: 4,
                tooltipName: 'کنکورچه'
            },
            'farsang-step-2-Hal-Test': {
                contentId: mapStepLevel1['farsang-step-2'].contentId,
                sectionId: 3,
                tooltipName: 'حل تست'
            },
            'farsang-step-2-Tavarogh': {
                contentId: mapStepLevel1['farsang-step-2'].contentId,
                sectionId: 2,
                tooltipName: 'تورق سریع'
            },
            'farsang-step-2-Tablo-Rahnama': {
                contentId: mapStepLevel1['farsang-step-2'].contentId,
                sectionId: 1,
                tooltipName: 'تابلو راهنما'
            },

            'farsang-step-3-Pish-Azmoon': {
                contentId: mapStepLevel1['farsang-step-3'].contentId,
                sectionId: 5,
                tooltipName: 'پیش آزمون'
            },
            'farsang-step-3-Konkorche': {
                contentId: mapStepLevel1['farsang-step-3'].contentId,
                sectionId: 4,
                tooltipName: 'کنکورچه'
            },
            'farsang-step-3-Hal-Test': {
                contentId: mapStepLevel1['farsang-step-3'].contentId,
                sectionId: 3,
                tooltipName: 'حل تست'
            },
            'farsang-step-3-Tavarogh': {
                contentId: mapStepLevel1['farsang-step-3'].contentId,
                sectionId: 2,
                tooltipName: 'تورق سریع'
            },
            'farsang-step-3-Tablo-Rahnama': {
                contentId: mapStepLevel1['farsang-step-3'].contentId,
                sectionId: 1,
                tooltipName: 'تابلو راهنما'
            },

            'farsang-step-4-Pish-Azmoon': {
                contentId: mapStepLevel1['farsang-step-4'].contentId,
                sectionId: 5,
                tooltipName: 'پیش آزمون'
            },
            'farsang-step-4-Konkorche': {
                contentId: mapStepLevel1['farsang-step-4'].contentId,
                sectionId: 4,
                tooltipName: 'کنکورچه'
            },
            'farsang-step-4-Hal-Test': {
                contentId: mapStepLevel1['farsang-step-4'].contentId,
                sectionId: 3,
                tooltipName: 'حل تست'
            },
            'farsang-step-4-Tavarogh': {
                contentId: mapStepLevel1['farsang-step-4'].contentId,
                sectionId: 2,
                tooltipName: 'تورق سریع'
            },
            'farsang-step-4-Tablo-Rahnama': {
                contentId: mapStepLevel1['farsang-step-4'].contentId,
                sectionId: 1,
                tooltipName: 'تابلو راهنما'
            },

            'farsang-step-5-Pish-Azmoon': {
                contentId: mapStepLevel1['farsang-step-5'].contentId,
                sectionId: 5,
                tooltipName: 'پیش آزمون'
            },
            'farsang-step-5-Konkorche': {
                contentId: mapStepLevel1['farsang-step-5'].contentId,
                sectionId: 4,
                tooltipName: 'کنکورچه'
            },
            'farsang-step-5-Hal-Test': {
                contentId: mapStepLevel1['farsang-step-5'].contentId,
                sectionId: 3,
                tooltipName: 'حل تست'
            },
            'farsang-step-5-Tavarogh': {
                contentId: mapStepLevel1['farsang-step-5'].contentId,
                sectionId: 2,
                tooltipName: 'تورق سریع'
            },
            'farsang-step-5-Tablo-Rahnama': {
                contentId: mapStepLevel1['farsang-step-5'].contentId,
                sectionId: 1,
                tooltipName: 'تابلو راهنما'
            },

            'farsang-step-6-Pish-Azmoon': {
                contentId: mapStepLevel1['farsang-step-6'].contentId,
                sectionId: 5,
                tooltipName: 'پیش آزمون'
            },
            'farsang-step-6-Konkorche': {
                contentId: mapStepLevel1['farsang-step-6'].contentId,
                sectionId: 4,
                tooltipName: 'کنکورچه'
            },
            'farsang-step-6-Hal-Test': {
                contentId: mapStepLevel1['farsang-step-6'].contentId,
                sectionId: 3,
                tooltipName: 'حل تست'
            },
            'farsang-step-6-Tavarogh': {
                contentId: mapStepLevel1['farsang-step-6'].contentId,
                sectionId: 2,
                tooltipName: 'تورق سریع'
            },
            'farsang-step-6-Tablo-Rahnama': {
                contentId: mapStepLevel1['farsang-step-6'].contentId,
                sectionId: 1,
                tooltipName: 'تابلو راهنما'
            },

            'farsang-step-7-Pish-Azmoon': {
                contentId: mapStepLevel1['farsang-step-7'].contentId,
                sectionId: 5,
                tooltipName: 'پیش آزمون'
            },
            'farsang-step-7-Konkorche': {
                contentId: mapStepLevel1['farsang-step-7'].contentId,
                sectionId: 4,
                tooltipName: 'کنکورچه'
            },
            'farsang-step-7-Hal-Test': {
                contentId: mapStepLevel1['farsang-step-7'].contentId,
                sectionId: 3,
                tooltipName: 'حل تست'
            },
            'farsang-step-7-Tavarogh': {
                contentId: mapStepLevel1['farsang-step-7'].contentId,
                sectionId: 2,
                tooltipName: 'تورق سریع'
            },
            'farsang-step-7-Tablo-Rahnama': {
                contentId: mapStepLevel1['farsang-step-7'].contentId,
                sectionId: 1,
                tooltipName: 'تابلو راهنما'
            },

            'farsang-step-8-Pish-Azmoon': {
                contentId: mapStepLevel1['farsang-step-8'].contentId,
                sectionId: 5,
                tooltipName: 'پیش آزمون'
            },
            'farsang-step-8-Konkorche': {
                contentId: mapStepLevel1['farsang-step-8'].contentId,
                sectionId: 4,
                tooltipName: 'کنکورچه'
            },
            'farsang-step-8-Hal-Test': {
                contentId: mapStepLevel1['farsang-step-8'].contentId,
                sectionId: 3,
                tooltipName: 'حل تست'
            },
            'farsang-step-8-Tavarogh': {
                contentId: mapStepLevel1['farsang-step-8'].contentId,
                sectionId: 2,
                tooltipName: 'تورق سریع'
            },
            'farsang-step-8-Tablo-Rahnama': {
                contentId: mapStepLevel1['farsang-step-8'].contentId,
                sectionId: 1,
                tooltipName: 'تابلو راهنما'
            },

            'farsang-step-9-Pish-Azmoon': {
                contentId: mapStepLevel1['farsang-step-9'].contentId,
                sectionId: 5,
                tooltipName: 'پیش آزمون'
            },
            'farsang-step-9-Konkorche': {
                contentId: mapStepLevel1['farsang-step-9'].contentId,
                sectionId: 4,
                tooltipName: 'کنکورچه'
            },
            'farsang-step-9-Hal-Test': {
                contentId: mapStepLevel1['farsang-step-9'].contentId,
                sectionId: 3,
                tooltipName: 'حل تست'
            },
            'farsang-step-9-Tavarogh': {
                contentId: mapStepLevel1['farsang-step-9'].contentId,
                sectionId: 2,
                tooltipName: 'تورق سریع'
            },
            'farsang-step-9-Tablo-Rahnama': {
                contentId: mapStepLevel1['farsang-step-9'].contentId,
                sectionId: 1,
                tooltipName: 'تابلو راهنما'
            },

            'farsang-step-10-Pish-Azmoon': {
                contentId: mapStepLevel1['farsang-step-10'].contentId,
                sectionId: 5,
                tooltipName: 'پیش آزمون'
            },
            'farsang-step-10-Konkorche': {
                contentId: mapStepLevel1['farsang-step-10'].contentId,
                sectionId: 4,
                tooltipName: 'کنکورچه'
            },
            'farsang-step-10-Hal-Test': {
                contentId: mapStepLevel1['farsang-step-10'].contentId,
                sectionId: 3,
                tooltipName: 'حل تست'
            },
            'farsang-step-10-Tavarogh': {
                contentId: mapStepLevel1['farsang-step-10'].contentId,
                sectionId: 2,
                tooltipName: 'تورق سریع'
            },
            'farsang-step-10-Tablo-Rahnama': {
                contentId: mapStepLevel1['farsang-step-10'].contentId,
                sectionId: 1,
                tooltipName: 'تابلو راهنما'
            },
        });
    }

    function getMapContainerBoundingClientRect() {
        return $('#mapContainer')[0].getBoundingClientRect();
    }

    function unsetClickOnStepsEvent() {
        $(document).off('click', '.farsangStep, .MajorStep');
        $(document).off('touchend', '.farsangStep, .MajorStep');
        $(document).off('click', '.farsangStep-cityItem, .MajorStep');
        $(document).off('touchend', '.farsangStep-cityItem, .MajorStep');
    }

    function setClickOnStepsEvent() {
        unsetClickOnStepsEvent();

        var zoomLevel = getZoomLevel();

        if (zoomLevel === 1) {
            $(document).on('click', '.farsangStep, .MajorStep', function () {
                var itemId = $(this).attr('id'),
                    contentId = getSetIdFromElementId(itemId);
                if (typeof contentId !== 'undefined' && contentId.trim().length>0) {
                    EntekhabeFarsang.showFarsangFromServer(contentId);
                } else {
                    toastr.info('این فرسنگ هنوز منتشر نشده است.');
                }
            });
            $(document).on('touchend', '.farsangStep, .MajorStep', function () {
                var itemId = $(this).attr('id'),
                    contentId = getSetIdFromElementId(itemId);
                if (typeof contentId !== 'undefined' && contentId.trim().length>0) {
                    EntekhabeFarsang.showFarsangFromServer(contentId);
                } else {
                    toastr.info('این فرسنگ هنوز منتشر نشده است.');
                }
            });
        } else if (zoomLevel === 2) {
            $(document).on('click', '.farsangStep-cityItem, .MajorStep', function () {
                var itemId = $(this).attr('id'),
                    sectionId = $(this).attr('data-section-id'),
                    setId = getSetIdFromElementId(itemId);
                if (typeof setId !== 'undefined' && setId.trim().length>0) {
                    EntekhabeFarsang.showFarsangFromServer(setId, sectionId);
                } else {
                    toastr.info('این فرسنگ هنوز منتشر نشده است.');
                }
            });
            $(document).on('touchend', '.farsangStep-cityItem, .MajorStep', function () {
                var itemId = $(this).attr('id'),
                    sectionId = $(this).attr('data-section-id'),
                    setId = getSetIdFromElementId(itemId);
                if (typeof setId !== 'undefined' && setId.trim().length>0) {
                    EntekhabeFarsang.showFarsangFromServer(setId, sectionId);
                } else {
                    toastr.info('این فرسنگ هنوز منتشر نشده است.');
                }
            });
        }
    }

    function setStepPointer() {
        var zoomLevel = getZoomLevel();

        $('.farsangStep-cityItem, .farsangStep, .MajorStep').css({'cursor': ''});

        if (zoomLevel === 1) {
            $('.farsangStep, .MajorStep').css({'cursor': 'pointer'});
        } else if (zoomLevel === 2) {
            $('.farsangStep-cityItem, .MajorStep').css({'cursor': 'pointer'});
        }


    }

    function getSetIdFromElementId(elementId) {
        return $('#'+elementId).attr('data-content-id');
    }

    function addTooltip($object, name) {
        // $object.attr('data-toggle', 'm-tooltip').attr('data-placement', 'top').attr('title', name);
        // $('[data-toggle="m-tooltip"]').tooltip();
        if (typeof $object === 'undefined' || typeof $object[0] === 'undefined') {
            return;
        }
        var element = $object[0].getBoundingClientRect(),
            mapContainerRect = getMapContainerBoundingClientRect(),
            tooltipWidth = 75,
            tooltipHeight = 25,
            width = element.width,
            top = element.top - tooltipHeight,
            left = element.left + (width / 2) - (tooltipWidth / 2);

        if (checkSvgElementIsVisible(element, mapContainerRect)) {
            var tooltipPosition = calculateTooltipPosition(element, mapContainerRect);
            $('#mapContainer').append(createTooltipHtml(tooltipPosition, name))
        }
    }

    function createTooltipHtml(tooltipPosition, name) {
        var cssLeftOrRight = (tooltipPosition.position === 'left') ? 'right' : 'left';
        return '<div class="MapStepLabel '+tooltipPosition.position+'" style="top: '+tooltipPosition.top+'px; '+cssLeftOrRight+': '+tooltipPosition.left+'px;">'+name+'</div>';
    }

    function calculateTooltipPosition(element, mapContainerRect) {
        var tooltipWidth = 75,
            tooltipHeight = 25,
            tooltipPointerHeight = 10,
            elementWidth = element.width,
            top = element.top - tooltipHeight,
            left = element.left + (elementWidth / 2) - (tooltipWidth / 2),
            direction = 'top',
            screenWidth =  screen.width;

        if (top < mapContainerRect.top) {
            top = element.bottom + tooltipPointerHeight;
            direction = 'bottom';
        } else {
            direction = 'top';
        }

        if (left < mapContainerRect.left) {
            left = element.right + tooltipPointerHeight;
            top = calculateTopOfTooltip(element, mapContainerRect);
            direction = 'right';
        } else if (element.right > mapContainerRect.right) {
            left = screenWidth -  element.left + tooltipPointerHeight;
            top = calculateTopOfTooltip(element, mapContainerRect);
            direction = 'left';
        }

        return {
            top: top,
            left: left,
            position: direction
        };
    }

    function calculateTopOfTooltip(element, mapContainerRect) {
        var top = 0;
        if (element.top < mapContainerRect.top) {
            top = element.bottom;
        } else if (element.bottom > mapContainerRect.bottom) {
            top = element.top;
        } else {
            top = element.top + (element.height / 2);
        }
        return top;
    }

    function checkSvgElementIsVisible(element, mapContainerRect) {
        return mapContainerRect.top < element.bottom &&
            mapContainerRect.bottom > element.top &&
            mapContainerRect.left < element.right &&
            mapContainerRect.right > element.left;
    }

    function getZoomLevel() {
        // if (panzoom.getScale() > 1.7) {
        if ( $('#farsang-step-5')[0].getBoundingClientRect().width > 100) {
            return 2;
        } else {
            return 1;
        }
    }

    function setStepsTooltip() {

        var mapSteps = getMapSteps(),
            selectorString = '';

        for (let key in mapSteps){
            addTooltip($('#'+key), mapSteps[key].tooltipName);
        }
    }

    function setStepsDataAttributes() {
        var mapSteps =  Object.assign({}, getMapStepLevel1(), getMapStepLevel2()),
            selectorString = '';

        for (let key in mapSteps){
            $('#'+key).attr('data-content-id', mapSteps[key].contentId);
            if (typeof mapSteps[key].sectionId !== 'undefined') {
                $('#'+key).attr('data-section-id', mapSteps[key].sectionId);
            }
            if (mapSteps[key].contentId === null) {
                $('#'+key+'-ground').attr('fill', '#ffc582');
            }
        }
    }

    function getFarsangMapHeight() {
        return $('.productPicture').width();
    }

    function getHeightOfMapOnInit() {
        return $('#farsangMappSvg').height();
    }

    function calculateMapZoomForInit() {
        var farsangMapHeight = getFarsangMapHeight(),
            heightOfMapOnInit = getHeightOfMapOnInit(),
            zoom = farsangMapHeight/heightOfMapOnInit;
        console.log('screen.width', screen.width);
        console.log('fwidth', $('#farsang-step-5')[0].getBoundingClientRect().width);
        return zoom;
    }

    function showAllTooltip() {
        // $('#mapContainer [data-toggle="m-tooltip"]:visible').tooltip().mouseover();
        setStepsTooltip();
    }

    function hideAllTooltip() {
        $('.MapStepLabel').remove();
        // $('#mapContainer [data-toggle="m-tooltip"]').tooltip('hide');
    }

    function refreshAllTooltip() {
        hideAllTooltip();
        showAllTooltip();
        // console.log('refreshAllTooltip');
        // setTimeout(function () {
        //     console.log('refreshAllTooltip-10');
        //     hideAllTooltip();
        //     showAllTooltip();
        // }, 10);
    }

    function initPanZoom() {
        setHeightOfMap();
        var svgMapElement = getSvgMapElement(),
            startScale = calculateMapZoomForInit();

        // https://github.com/timmywil/panzoom#documentation
        panzoom = Panzoom(svgMapElement, {
            contain: 'outside',
            // panOnlyWhenZoomed: false,
            step: 1.5, // The step affects zoom calculation when zooming with a mouse wheel, when pinch zooming, or when using zoomIn/zoomOut
            startScale: 1, // Scale used to set the beginning transform
            maxScale: 15, // The maximum scale when zooming
            minScale: startScale // The minimum scale when zooming
        });

        // panzoom.zoom(startScale, {
        //     disableZoom: false,
        //     step: 1.5,
        //     focal: {
        //         x: 0,
        //         y: 0
        //     },
        //     maxScale: 2000,
        //     minScale: 1,
        // });
        // panzoom.pan(5, 5);
        addEventListener();
    }

    function setHeightOfMap() {
        $('#mapContainer').css({'height': getFarsangMapHeight() + 'px'});
    }

    function getSvgMapElement() {
        return document.getElementById('farsangMappSvg');
    }

    function addEventListener() {
        var svgMapElement = getSvgMapElement();
        const parent = svgMapElement.parentElement;
        // parent.addEventListener('wheel', panzoom.zoomWithWheel)
        parent.addEventListener('wheel',wheelEvent);

        document.addEventListener('wheel',function () {
            hideAllTooltip();
        });
        document.addEventListener('touchstart',function () {
            hideAllTooltip();
        });
        svgMapElement.addEventListener('panzoomstart', (event) => {
            hideAllTooltip();
        });
        svgMapElement.addEventListener('panzoomend', (event) => {
            refreshMapEvents();
        });
        svgMapElement.addEventListener('panzoompan', (event) => {
            refreshMapEvents();
        });

        $(document).on('AnimateScrollTo.beforeScroll', function () {
            hideAllTooltip();
        });
        setClickOnStepsEvent();
    }

    function wheelEvent(e){
        if (!e.shiftKey) {
            panzoom.zoomWithWheel(e);
        }
        counter1 += 1;
        delta = e.deltaY;
        if (delta > 0) {direction = 'up'} else {direction = 'down'}
        if (marker) {wheelEventStart()}
        return false;
    }
    function wheelEventStart(){
        refreshMapEvents();
        hideAllTooltip();
        marker = false;
        wheelEventAct();
        counter3 = new Date();
        // info.innerHTML = 'Start event. Direction: ' + direction;
    }
    function wheelEventAct(){
        // refreshAllTooltip();
        counter2 = counter1;
        setTimeout(function(){
            if (counter2 === counter1) {
                wheelEventEnd();
            } else {
                // info.innerHTML = info.innerHTML + '<br>...';
                wheelEventAct();
            }
        },interval);
    }
    function wheelEventEnd(){
        refreshMapEvents();
        counter4 = new Date();
        // info.innerHTML = info.innerHTML + '<br>End event. Duration: ' + (counter4-counter3) + ' ms';
        marker = true;
        counter1 = 0;
        counter2 = false;
        counter3 = false;
        counter4 = false;
    }

    function refreshMapEvents() {
        refreshAllTooltip();
        setClickOnStepsEvent();
        setStepPointer();
    }

    return {
        init: function () {
            initPanZoom();
            setStepsDataAttributes();
            setStepPointer();
            setStepsTooltip();
        }
    }
}();

var EntekhabeFarsang = function () {

    function showFarsangFromServer(setId, sectionId) {
        $('.selectEntekhabeFarsangVideoAndPamphlet').AnimateScrollTo();
        getFarsangData(setId, sectionId, showFarsangData);
    }

    function showFarsangData(data, sectionId) {
        initSectionList(data.files);
        $('#selectFarsang .select-selected').html(data.set.short_title).attr('data-option-value', data.set.id);
        setLists(data.files);
        setBtnMoreLink(data.set.url.web);
        checkNoData();
        refreshScrollCarouselSwipIcons();
        showLists();
        imageObserver.observe();
        if (typeof sectionId !== 'undefined') {
            showSection(sectionId);
        }
        hideLoading();
    }

    function getFarsangData(setId, sectionId, callback) {
        showLoading();
        getAjaxContent('/set/' + setId, function (data) {
            callback(data, sectionId);
        })
    }

    function refreshScrollCarouselSwipIcons() {
        ScrollCarousel.checkSwipIcons($('.ScrollCarousel'));
    }

    function checkNoData() {
        checkNoVideo();
        checkNoPamphlet();
    }

    function checkNoVideo() {
        if (getVideoListHtml().trim().length === 0 && getVideoListHtml().trim() !== noDataMessage('فیلمی وجود ندارد.')) {
            setVideoMessage(noDataMessage('فیلمی وجود ندارد.'));
            getBtnMoreVideo().fadeOut();
        } else {
            setVideoMessage('');
            getBtnMoreVideo().fadeIn();
        }
    }

    function checkNoPamphlet() {
        if (getPamphletList().trim().length === 0 && getPamphletList().trim() !== noDataMessage('جزوه ای وجود ندارد.')) {
            setPamphletMessage(noDataMessage('جزوه ای وجود ندارد.'));
            getBtnMorePamphlet().fadeOut();
        } else {
            setPamphletMessage('');
            getBtnMorePamphlet().fadeIn();
        }
    }

    function ajaxSetup() {
        $.ajaxSetup({
            cache: true,
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken,
            }
        });
    }

    function getAjaxContent(action, callback) {
        ajaxSetup();

        $.ajax({
                type: "GET",
                url: action,
                data: {
                    raheAbrisham: true
                },
                accept: "application/json; charset=utf-8",
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                statusCode: {
                    200: function (response) {
                        callback(response);
                    },
                    403: function (response) {
                        // responseMessage = response.responseJSON.message;
                        hideLoading();
                        checkNoData();
                        toastr.warning('خطایی رخ داده است.');
                    },
                    404: function (response) {
                        hideLoading();
                        checkNoData();
                        toastr.warning('خطایی رخ داده است.');
                    },
                    422: function (response) {
                        hideLoading();
                        checkNoData();
                        toastr.warning('خطایی رخ داده است.');
                    },
                    429: function (response) {
                        hideLoading();
                        checkNoData();
                        toastr.warning('خطایی رخ داده است.');
                    },
                    //The status for when there is error php code
                    500: function () {
                        hideLoading();
                        checkNoData();
                        toastr.warning('خطایی رخ داده است.');
                    }
                }
            }
        );
    }

    function showLists() {
        $('.entekhabeFarsangVideoAndPamphlet').parents('.row').fadeIn();
    }

    function createVideoList(data) {
        if (typeof data === 'undefined') {
            return '';
        }
        var dataLength = data.length,
            htmlData = '';
        for (var i = 0; i < dataLength; i++) {
            htmlData += createVideoItem({
                section: (typeof data[i].section !== 'undefined') ? data[i].section : {id: '', name: ''},
                photo: data[i].photo,
                link: data[i].url.web
            });
        }
        return htmlData;
    }

    function createPamphletList(data) {
        if (typeof data === 'undefined') {
            return '';
        }
        var dataLength = data.length,
            htmlData = '';
        for (var i = 0; i < dataLength; i++) {
            htmlData += createPamphletItem({
                section: (typeof data[i].section !== 'undefined') ? data[i].section : {id: '', name: ''},
                title: data[i].title,
                link: data[i].file.pamphlet[0].link
            });
        }
        return htmlData;
    }

    function createVideoItem(data) {
        return '' +
            '<div class="item w-55443211" data-section-id="'+data.section.id+'" data-section-name="'+data.section.name+'">\n' +
            '  <a href="' + data.link + '">' +
            '    <img class="lazy-image a--full-width"\n' +
            '         src="https://cdn.alaatv.com/loder.jpg?w=16&h=9"\n' +
            '         data-src="' + data.photo + '"\n' +
            '         alt="samplePhoto"\n' +
            '         width="253" height="142">\n' +
            '  </a>' +
            '</div>';
    }

    function createPamphletItem(data) {
        return '' +
            '<div class="item w-55443211" data-section-id="'+data.section.id+'" data-section-name="'+data.section.name+'">\n' +
            '  <a href="' + data.link + '">' +
            '    <div class="pamphletItem">\n' +
            '        <div class="pamphletItem-thumbnail">\n' +
            '            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">\n' +
            '                <path style="fill:#F4A14E;" d="M512,256c0,19.508-2.184,38.494-6.311,56.738c-6.416,28.348-17.533,54.909-32.496,78.817  c-0.637,1.024-1.285,2.048-1.943,3.072C425.681,465.251,346.3,512,256,512S86.319,465.251,40.751,394.627  c-19.822-30.699-33.249-65.912-38.4-103.769c-1.191-8.735-1.933-17.617-2.215-26.624C0.042,261.496,0,258.759,0,256  c0-24.9,3.553-48.964,10.177-71.722c2.654-9.101,5.799-17.993,9.415-26.645c5.862-14.106,12.967-27.564,21.159-40.26  C86.319,46.749,165.7,0,256,0s169.681,46.749,215.249,117.373c10.365,16.06,18.986,33.353,25.59,51.618  c3.124,8.673,5.81,17.565,8.004,26.645c2.111,8.714,3.772,17.607,4.953,26.645c1.16,8.746,1.86,17.638,2.111,26.645  C511.969,251.277,512,253.628,512,256z"/>\n' +
            '                <path style="fill:#F9EED7;" d="M471.249,127.76v266.867C425.681,465.251,346.3,512,256,512S86.319,465.251,40.751,394.627V22.8  c0-12.591,10.209-22.8,22.8-22.8h279.939L471.249,127.76z"/>\n' +
            '                <path style="fill:#E8DBC4;" d="M343.489,104.958V0l127.76,127.76H366.291C353.698,127.76,343.489,117.551,343.489,104.958z"/>\n' +
            '                <path style="fill:#FF525D;" d="M471.249,330.961v63.666C425.681,465.251,346.3,512,256,512S86.319,465.251,40.751,394.627v-63.666  L471.249,330.961L471.249,330.961z"/>\n' +
            '                <path style="fill:#5C5E70;" d="M157.375,292.967c-3.474,0-6.921-0.547-10.187-1.678c-8.463-2.934-13.871-9.302-14.841-17.473  c-1.317-11.103,5.306-29.586,44.334-54.589c11.285-7.229,22.837-12.976,34.413-17.492c1.162-2.198,2.351-4.438,3.558-6.711  c8.945-16.848,19.331-36.411,27.596-55.402c-15.258-30.061-21.671-58.182-21.671-66.936c0-15.46,8.68-27.819,20.639-29.387  c4.811-0.632,21.117-0.425,28.887,28.714c4.785,17.942-1.38,41.91-11.673,66.958c2.814,5.151,5.964,10.429,9.479,15.702  c7.666,11.499,16.328,22.537,25.247,32.441c37.765,0.227,67.003,9.163,74.427,13.943c10.572,6.809,14.857,18.342,10.662,28.7  c-5.549,13.703-20.603,15.948-31.812,13.707c-16.191-3.238-34.248-17.427-46.544-28.758c-4.367-4.024-8.712-8.328-12.978-12.842  c-18.743,0.422-41.758,3.244-65.516,11.696c-1.971,3.754-3.836,7.355-5.553,10.76c-2.391,5.244-21.103,45.772-33.678,58.348  C175.52,289.313,166.357,292.967,157.375,292.967z M200.593,222.43c-5.368,2.695-10.724,5.722-16.02,9.116  c-37.601,24.088-38,38.004-37.699,40.549c0.296,2.493,2.014,4.302,5.105,5.373c5.426,1.88,13.981,0.718,19.841-5.141  C180.051,264.094,193.9,236.627,200.593,222.43z M308.038,202.364c15.452,14.531,30.458,24.596,41.264,26.756  c9.163,1.835,14.013-1.469,15.385-4.854c1.497-3.698-0.474-7.981-5.025-10.91C355.383,210.602,335.446,204.274,308.038,202.364z   M251.13,155.566c-6.247,13.416-13.238,26.834-19.949,39.513c14.801-4.077,29.376-6.35,43.204-7.348  c-6.683-8.035-12.988-16.454-18.647-24.943C254.142,160.395,252.605,157.983,251.13,155.566z M243.624,57.773  c-0.172,0-0.342,0.01-0.508,0.032c-3.806,0.498-7.911,6.33-7.911,14.881c0,3.494,2.029,14.9,7.474,30.631  c1.746,5.042,4.037,11.087,6.957,17.737c6.246-17.614,9.422-33.685,6.332-45.271C252.619,63.225,247.458,57.773,243.624,57.773z"/>\n' +
            '                <g>\n' +
            '                    <path style="fill:#F9EED7;" d="M135.128,366.165c0-3.319,3.053-6.239,7.7-6.239h27.479c17.523,0,31.328,8.231,31.328,30.532v0.664   c0,22.302-14.337,30.798-32.656,30.798h-13.142v28.673c0,4.248-5.177,6.372-10.355,6.372c-5.176,0-10.354-2.124-10.354-6.372   V366.165z M155.838,377.979v28.011h13.142c7.433,0,11.947-4.247,11.947-13.275v-1.46c0-9.027-4.513-13.275-11.947-13.275   L155.838,377.979L155.838,377.979z"/>\n' +
            '                    <path style="fill:#F9EED7;" d="M256.464,359.926c18.319,0,32.656,8.496,32.656,31.328v34.382c0,22.833-14.337,31.328-32.656,31.328   h-23.497c-5.442,0-9.027-2.921-9.027-6.239v-84.56c0-3.319,3.585-6.239,9.027-6.239L256.464,359.926L256.464,359.926z    M244.65,377.979v60.932h11.815c7.433,0,11.947-4.248,11.947-13.275v-34.382c0-9.027-4.513-13.275-11.947-13.275H244.65V377.979z"/>\n' +
            '                    <path style="fill:#F9EED7;" d="M315.541,366.297c0-4.247,4.513-6.372,9.027-6.372h46.064c4.38,0,6.239,4.646,6.239,8.894   c0,4.912-2.256,9.16-6.239,9.16h-34.381v22.435h20.045c3.983,0,6.239,3.85,6.239,8.098c0,3.584-1.858,7.833-6.239,7.833h-20.045   v34.249c0,4.247-5.177,6.372-10.355,6.372c-5.176,0-10.354-2.124-10.354-6.372v-84.296H315.541z"/>\n' +
            '                </g>\n' +
            '            </svg>\n' +
            '        </div>\n' +
            '        <div class="pamphletItem-name">\n' +
            '           ' + data.title + '\n' +
            '        </div>\n' +
            '    </div>\n' +
            '  </a>' +
            '</div>';
    }

    function setBtnMoreLink(link) {
        setBtnMoreVideoLink(link);
        setBtnMorePamphletLink(link);
    }

    function setBtnMoreVideoLink(link) {
        getBtnMoreVideo().parents('a').attr('href', link);
    }

    function setBtnMorePamphletLink(link) {
        getBtnMorePamphlet().parents('a').attr('href', link);
    }

    function setLists(data) {
        setVideoList(createVideoList(data.videos));
        setPamphletList(createPamphletList(data.pamphlets));
    }

    function setVideoList(html) {
        $('#m_tabs_video .ScrollCarousel .ScrollCarousel-Items').html(html);
    }

    function getVideoListHtml() {
        return $('#m_tabs_video .ScrollCarousel .ScrollCarousel-Items').html();
    }

    function setPamphletList(html) {
        $('#m_tabs_pamphlet .ScrollCarousel .ScrollCarousel-Items').html(html);
    }

    function getPamphletList() {
        return $('#m_tabs_pamphlet .ScrollCarousel .ScrollCarousel-Items').html();
    }

    function setPamphletMessage(html) {
        $('.showPamphletMessage').html(html);
    }

    function setVideoMessage(html) {
        $('.showVideoMessage').html(html);
    }

    function getBtnMoreVideo() {
        return $('.btnShowMoreVideo');
    }

    function getBtnMorePamphlet() {
        return $('.btnShowMorePamphlet');
    }

    function showLoading() {
        var loadingHtml = '<div class="m-loader m-loader--warning" style="width: 100px;height: 100px;margin: auto;"></div>';
        setVideoList('');
        setPamphletList('');
        setVideoMessage(loadingHtml);
        setPamphletMessage(loadingHtml);
        AlaaLoading.show();
    }

    function hideLoading() {
        AlaaLoading.hide();
    }

    function noDataMessage(message) {
        return '<div class="alert alert-info text-center" role="alert" style="width: 100%;margin: auto;">' + message + '</div>';
    }

    function getTotalSectionList() {
        return [
            {
                id: 1,
                enable: false,
                name: 'تابلو راهنما'
            },
            {
                id: 2,
                enable: false,
                name: 'تورق سریع'
            },
            {
                id: 3,
                enable: false,
                name: 'حل تست'
            },
            {
                id: 4,
                enable: false,
                name: 'کنکورچه'
            },
            {
                id: 5,
                enable: false,
                name: 'پیش آزمون'
            }
        ];
    }

    function getSectionListFromContent(data) {
        var dataLength = data.length,
            sections = [],
            totalSectionList = getTotalSectionList();

        checkSections(data.pamphlets, totalSectionList);
        checkSections(data.videos, totalSectionList);

        return totalSectionList;
    }

    function checkSections(data, totalSectionList) {
        if (typeof data === 'undefined') {
            return;
        }
        var dataLength = data.length;
        for (var i = 0; i < dataLength; i++) {
            if (typeof data[i].section !== 'undefined') {
                checkInTotalSectionList(data[i].section, totalSectionList);
            }
        }
    }

    function checkInTotalSectionList(itemSection, totalSectionList) {
        var totalSectionListLength = totalSectionList.length;
        for (var j = 0; j < totalSectionListLength; j++) {
            if (itemSection.id === totalSectionList[j].id) {
                totalSectionList[j].enable = true;
            }
        }
    }

    function initSectionList(data) {
        var listHtml = '',
            sectionList = getSectionListFromContent(data),
            sectionListLength = sectionList.length,
            activrSectionCount = 0;

        for (var i = 0; i < sectionListLength; i++) {
            if (sectionList[i].enable) {
                activrSectionCount++;
                listHtml += createSectionItem(sectionList[i]);
            }
        }

        if (activrSectionCount>0) {
            $('.entekhabeFarsangVideoAndPamphlet .tab-content').css({'padding-right':''});
        } else {
            $('.entekhabeFarsangVideoAndPamphlet .tab-content').css({'padding-right':'0'});
        }
        $('.sectionFilterCol').html(listHtml);
    }

    function createSectionItem(data) {
        return '<div class="sectionFilter-item" data-section-id="'+data.id+'" data-section-name="'+data.name+'">'+data.name+'</div>';
    }

    function showSection(sectionId) {
        var animateSpeed = 0;
        $('.sectionFilterCol .sectionFilter-item').removeClass('selected');
        $('.entekhabeFarsangVideoAndPamphlet .tab-content .ScrollCarousel .ScrollCarousel-Items .item').fadeIn(animateSpeed);
        if (typeof sectionId === 'undefined' || sectionId === 'all') {
        } else {
            $('.sectionFilterCol .sectionFilter-item[data-section-id="'+sectionId+'"]').addClass('selected');
            $('.entekhabeFarsangVideoAndPamphlet .tab-content .ScrollCarousel .ScrollCarousel-Items .item').each(function () {
                var thisSectionId = $(this).attr('data-section-id');
                if (parseInt(thisSectionId) !== parseInt(sectionId)) {
                    $(this).fadeOut(animateSpeed);
                }
            });
        }

        setTimeout(function () {
            refreshScrollCarouselSwipIcons();
        }, animateSpeed + 10);

    }

    function addClickEvents() {
        $(document).on('click', '.sectionFilterCol .sectionFilter-item', function () {
            var sectionId = $(this).attr('data-section-id');
            showSection(sectionId);
        });
    }

    return {
        init: function (data) {
            showFarsangData(data);
            addClickEvents();
            // checkNoData();
            // refreshScrollCarouselSwipIcons();
        },
        showFarsangFromServer: function (setId, sectionId) {
            showFarsangFromServer(setId, sectionId);
        },
        showFarsangData: function (data) {

        },
    };

}();

var InitAbrishamPage = function () {

    function initPeriodDescription() {
        $('.periodDescription').css({'min-height':'200px'});
    }

    function makePageBoxedForLargScreen() {
        $('.m-body .m-content').addClass('boxed');
    }

    function initCustomDropDown() {
        $('.CustomDropDown').CustomDropDown({
            onChange: function (data) {
                EntekhabeFarsang.showFarsangFromServer(data.value);
                // { index: 2, totalCount: 5, value: "3", text: "فرسنگ سوم" }
            }
        });
    }

    function initScrollCarousel() {
        ScrollCarousel.addSwipeIcons($('.ScrollCarousel'));
    }

    function initEvents() {
        $(document).on('click', '.showMoreLiveDescriptions', function () {
            var $target = $('.liveDescriptionRow .m-timeline-3 .m-timeline-3__items .m-timeline-3__item:not(:first-child)');
            if ($target.is(":visible")) {
                $target.fadeOut();
            } else {
                $target.fadeIn();
                $(this).fadeOut();
            }
        });
        $(document).on('click', '.btnShowRepurchase', function () {
            $('.helpMessageRow').fadeOut(0);
            $('.RepurchaseRow').fadeIn();
            $('.RepurchaseRow').AnimateScrollTo();
        });
        $(document).on('click', '.btnShowHelpMessage', function () {
            $('.RepurchaseRow').fadeOut(0);
            $('.helpMessageRow').fadeIn();
            $('.helpMessageRow').AnimateScrollTo();
        });
        $(document).on('click', '.btnShowLiveDescription', function () {
            $('.liveDescriptionRow').AnimateScrollTo();
        });
        $(document).on('click', '.descriptionBox .readMoreBtn', function () {
            $(this).fadeOut();
            $(this).parents('.descriptionBox').find('.content').removeClass('compact').addClass('collapsed');
        });
        $(document).on('click', '.descriptionBox .btnCloseDescriptionBox', function () {
            $(this).parents('.descriptionBox').fadeOut();
        });
        $(document).on('click', '.btnShowTotalPeriodDescription', function () {
            $('.periodDescription').removeClass('compact');
            $(this).fadeOut();
        });
    }

    function initLiveDescription() {
        $('.liveDescriptionRow .m-timeline-3 .m-timeline-3__items .m-timeline-3__item:not(:first-child)').fadeOut();
    }

    function initRepurchaseRowAndHelpMessageRow() {
        $('.helpMessageRow').fadeOut();
        $('.RepurchaseRow').fadeOut();
    }

    return {
        init: function (LastSetData) {

            initRepurchaseRowAndHelpMessageRow();
            EntekhabeFarsang.init(LastSetData);
            makePageBoxedForLargScreen();
            MapSVG.init();
            initCustomDropDown();
            initScrollCarousel();
            initLiveDescription();
            initEvents();
            imageObserver.observe();
        },
    };
}();

jQuery(document).ready(function () {

    if (typeof LastSetData !== 'undefined') {
        InitAbrishamPage.init(LastSetData);
    }

    // function renderNested(template_string, translate) {
    //     return function() {
    //         return function(text, render) {
    //             return Mustache.to_html(template_string, translate(render(text)));
    //         };
    //     };
    // }
    // var template = $("#ScrollCarousel_base").html();
    // var nested_template = $("#ScrollCarousel_item").html();
    // var model = {
    //     data: {
    //         names: [
    //             { name: "Foo" },
    //             { name: "Bar" }
    //         ],
    //         nested: renderNested(nested_template, function(text) {
    //             return { name: text };
    //         })
    //     }
    // };
    // var result = Mustache.to_html(template, model);
    // $("#mustacheTest").html( result );


    // function MustacheLoadUser(template, renderedData) {
    //     Mustache.parse(template);   // optional, speeds up future uses
    //     return Mustache.render(template, renderedData);
    // }
    //
    // $('#mustacheTest').html(MustacheLoadUser($('#ScrollCarousel_base').html(), {
    //     items: [
    //         {src:'https://cdn.alaatv.com/media/thumbnails/562/562000kfbv.jpg?w=210&h=118'},
    //         {src:'https://cdn.alaatv.com/media/thumbnails/580/580000moza.jpg?w=210&h=118'},
    //         {src:'https://cdn.alaatv.com/media/thumbnails/580/580001kmvz.jpg?w=210&h=118'},
    //         {src:'https://cdn.alaatv.com/media/thumbnails/586/586000zero.jpg?w=210&h=118'}
    //     ],
    //     item : function(text, render) {
    //         return Mustache.to_html($('#ScrollCarousel_item').html(), {
    //             src: this.src
    //         });
    //     }
    // }));

    // imageObserver.observe();

});
