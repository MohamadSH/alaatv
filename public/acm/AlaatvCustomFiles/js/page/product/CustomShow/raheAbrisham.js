var MapSVG = function () {

    var farsaneSetIdArray = [],
        marker = true,
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

    function getTotalMapSteps() {
        return Object.assign({}, getMapStepLevel1(), getMapStepLevel2());
    }

    function getsetDataFromId(setId) {
        var totalMapSteps = getTotalMapSteps();
        for (var key in totalMapSteps){
            if (parseInt(totalMapSteps[key].contentId) === parseInt(setId)) {
                totalMapSteps[key].elementId = key;
                return totalMapSteps[key];
            }
        }
        return null;
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
            'Pile': {
                contentId: 604,
                tooltipName: 'پیله'
            },
        };
    }

    function getUnfarsangSetIdArray() {
        return [
            getMajorStep()['pishAzmoon'].contentId,
            getMajorStep()['SefrTaSad'].contentId,
            getMajorStep()['BarAndaz'].contentId,
            getMajorStep()['Pile'].contentId,
            getMapStepLevel2()['Gift-Godar'].contentId,
        ];
    }

    function setFarsangSetIdArray() {
        var allSets = allSetsOfRaheAbrisham;

        farsaneSetIdArray = [];

        var allSetsOfRaheAbrishamLength = allSets.length,
            unfarsaneSetIdArray = getUnfarsangSetIdArray();

        for (var i = 0; i < allSetsOfRaheAbrishamLength; i++) {
            if (!unfarsaneSetIdArray.includes(allSets[i].setId)) {
                farsaneSetIdArray.push(allSets[i]);
            }
        }

        farsaneSetIdArray.reverse();
    }

    function getFarsangStep(index) {
        if (typeof farsaneSetIdArray[index] === 'undefined') {
            return {
                name: '',
                setId: null
            };
        } else {
            return farsaneSetIdArray[index];
        }
    }

    function getMapStepLevel1() {
        return Object.assign({}, getMajorStep(), {
            'farsang-step-1': {
                contentId: getFarsangStep(0).setId,
                tooltipName: 'فرسنگ اول'
            },
            'farsang-step-2': {
                contentId: getFarsangStep(1).setId,
                tooltipName: 'فرسنگ دوم'
            },
            'farsang-step-3': {
                contentId: getFarsangStep(2).setId,
                tooltipName: 'فرسنگ سوم'
            },
            'farsang-step-4': {
                contentId: getFarsangStep(3).setId,
                tooltipName: 'فرسنگ چهارم'
            },
            'farsang-step-5': {
                contentId: getFarsangStep(4).setId,
                tooltipName: 'فرسنگ پنجم'
            },
            'farsang-step-6': {
                contentId: getFarsangStep(5).setId,
                tooltipName: 'فرسنگ ششم'
            },
            'farsang-step-7': {
                contentId: getFarsangStep(6).setId,
                tooltipName: 'فرسنگ هفتم'
            },
            'farsang-step-8': {
                contentId: getFarsangStep(7).setId,
                tooltipName: 'فرسنگ هشتم'
            },
            'farsang-step-9': {
                contentId: getFarsangStep(8).setId,
                tooltipName: 'فرسنگ نهم'
            },
            'farsang-step-10': {
                contentId: getFarsangStep(9).setId,
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
            'Gift-Godar': {
                contentId: 747,
                tooltipName: 'گدار'
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
                const timeAfterPanzoomend = Date.now() - window.RaheAbrishamPanZoom.panzoomLastPanTime;
                if (timeAfterPanzoomend < 500) {
                    return false;
                }
                var itemId = $(this).attr('id'),
                    contentId = getSetIdFromElementId(itemId);
                if (typeof contentId !== 'undefined' && contentId.trim().length>0) {
                    PreviewSets.showContentOfSetFromServer(contentId);
                } else {
                    toastr.info('این فرسنگ هنوز منتشر نشده است.');
                }
            });
            $(document).on('touchend', '.farsangStep, .MajorStep', function () {
                const timeAfterPanzoomend = Date.now() - window.RaheAbrishamPanZoom.panzoomLastPanTime;
                if (timeAfterPanzoomend < 500) {
                    return false;
                }
                var itemId = $(this).attr('id'),
                    contentId = getSetIdFromElementId(itemId);
                if (typeof contentId !== 'undefined' && contentId.trim().length>0) {
                    PreviewSets.showContentOfSetFromServer(contentId);
                } else {
                    toastr.info('این فرسنگ هنوز منتشر نشده است.');
                }
            });
        } else if (zoomLevel === 2) {
            $(document).on('click', '.farsangStep-cityItem, .MajorStep', function () {
                const timeAfterPanzoomend = Date.now() - window.RaheAbrishamPanZoom.panzoomLastPanTime;
                if (timeAfterPanzoomend < 500) {
                    return false;
                }
                var itemId = $(this).attr('id'),
                    sectionId = $(this).attr('data-section-id'),
                    setId = getSetIdFromElementId(itemId);
                if (typeof setId !== 'undefined' && setId.trim().length>0) {
                    PreviewSets.showContentOfSetFromServer(setId, sectionId);
                } else {
                    toastr.info('این فرسنگ هنوز منتشر نشده است.');
                }
            });
            $(document).on('touchend', '.farsangStep-cityItem, .MajorStep', function () {
                const timeAfterPanzoomend = Date.now() - window.RaheAbrishamPanZoom.panzoomLastPanTime;
                if (timeAfterPanzoomend < 500) {
                    return false;
                }
                var itemId = $(this).attr('id'),
                    sectionId = $(this).attr('data-section-id'),
                    setId = getSetIdFromElementId(itemId);
                if (typeof setId !== 'undefined' && setId.trim().length>0) {
                    PreviewSets.showContentOfSetFromServer(setId, sectionId);
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
        // if (window.RaheAbrishamPanZoom.getScale() > 1.7) {
        if ( $('#farsang-step-1')[0].getBoundingClientRect().width > 180) {
            return 2;
        } else {
            return 1;
        }
    }

    function setStepsTooltip() {

        var mapSteps = getMapSteps(),
            selectorString = '';

        for (var key in mapSteps){
            addTooltip($('#'+key), mapSteps[key].tooltipName);
        }
    }

    function setStepsDataAttributes() {
        var mapSteps =  Object.assign({}, getMapStepLevel1(), getMapStepLevel2()),
            selectorString = '';

        for (var key in mapSteps){
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

    function getHeightOfMapSvg() {
        return $('#farsangMapSvg').height();
    }

    function calculateMapZoomForInit() {
        var farsangMapHeight = getFarsangMapHeight(),
            heightOfMapOnInit = getHeightOfMapSvg(),
            zoom = farsangMapHeight/heightOfMapOnInit;
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
        var panY = (getMapContainerBoundingClientRect().height - $(getSvgMapElement()).height())/2;
        // https://github.com/timmywil/panzoom#documentation
        window.RaheAbrishamPanZoom = Panzoom(svgMapElement, {
            // contain: 'outside',
            // panOnlyWhenZoomed: false,
            startX: 0,
            startY: panY,
            step: 0.6, // The step affects zoom calculation when zooming with a mouse wheel, when pinch zooming, or when using zoomIn/zoomOut
            startScale: 1, // Scale used to set the beginning transform
            maxScale: 15, // The maximum scale when zooming
            minScale: 1 // The minimum scale when zooming
        });

        // window.RaheAbrishamPanZoom.zoom(startScale, {
        //     disableZoom: false,
        //     step: 1.5,
        //     focal: {
        //         x: 0,
        //         y: 0
        //     },
        //     maxScale: 2000,
        //     minScale: 1,
        // });
        // window.RaheAbrishamPanZoom.pan(0, panY);
        addEventListener();
    }

    function setHeightOfMap() {
        $('#mapContainer').css({'height': getFarsangMapHeight() + 'px'});
        // $('#mapContainer').css({'height': $('#mapContainer').width() + 'px'});
    }

    function getSvgMapElement() {
        return document.getElementById('farsangMapSvg');
    }

    function addEventListener() {
        var svgMapElement = getSvgMapElement();
        const parent = svgMapElement.parentElement;
        parent.addEventListener('wheel',wheelEvent);

        document.addEventListener('scroll',function () {
            hideAllTooltip();
        });
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
            // showAllTooltip();
        });
        svgMapElement.addEventListener('panzoompan', (event) => {
            window.RaheAbrishamPanZoom.panzoomLastPanTime = Date.now();
            hideAllTooltip();
            checkPanzoomEnd(function () {
                showAllTooltip();
            });
        });

        $(document).on('AnimateScrollTo.beforeScroll', function () {
            hideAllTooltip();
        });
        setClickOnStepsEvent();
    }

    function checkPanzoomEnd(callback) {
        var checkPanzoomEndInterval = setInterval(function(){
            if (Date.now() - window.RaheAbrishamPanZoom.panzoomLastPanTime > 200) {
                clearInterval(checkPanzoomEndInterval);
                callback();
            }
        },1);
    }

    function wheelEvent(e){
        if (!e.shiftKey) {
            window.RaheAbrishamPanZoom.zoomWithWheel(e);
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

    function panzoomPanErorrOnZoom(scale) {
        // return 0;
        const screenWidth = screen.width;
        if (screenWidth > 1900) {
            return 372.1671+((-101753.767)/(1+Math.pow((scale/0.0037076), 1.001775))); // 1900
        } else if (screenWidth > 1700 && screenWidth <= 1900) {
            return 339.1056 + (-3179.989 - 339.1056)/(1 + Math.pow((scale/0.1320686), 1.105657)); // 1800
        } else if (screenWidth > 1600 && screenWidth <= 1700) {
            return 317.7049 + (-3033.846 - 317.7049)/(1 + Math.pow((scale/0.1251884), 1.085904)); // 1700
        } else if (screenWidth > 1500 && screenWidth <= 1600) {
            return 359.1944 + (-6248.578 - 359.1944)/(1 + Math.pow((scale/0.06776716), 1.061137)); // 1600
        } else if (screenWidth > 1400 && screenWidth <= 1500) {
            return 339.2789 + (-69161210 - 339.2789)/(1 + Math.pow((scale/0.000004864994), 0.9993379)); // 1500
        } else if (screenWidth > 1300 && screenWidth <= 1400) {
            return 310.4541 + (-9540.703 - 310.4541)/(1 + Math.pow((scale/0.0370381), 1.039291)); // 1400
        } else if (screenWidth > 1200 && screenWidth <= 1300) {
            return 294.3495 + (-65479400 - 294.3495)/(1 + Math.pow((scale/0.000008558685), 1.0552)); // 1300
        } else if (screenWidth > 1100 && screenWidth <= 1200) {
            return 262.7934 + (-15562.99 - 262.7934)/(1 + Math.pow((scale/0.01820427), 1.018768)); // 1200
        } else if (screenWidth > 1000 && screenWidth <= 1100) {
            return 236.3133 + (-3230.551 - 236.3133)/(1 + Math.pow((scale/0.08768135), 1.074454)); // 1100
        } else if (screenWidth > 991 && screenWidth <= 1000) {
            return 213.6003 + (-28119400 - 213.6003)/(1 + Math.pow((scale/0.000007497526), 0.9989063)); // 1000
        } else if (screenWidth <= 991) {
            return 0;
        }
    }

    function getLeftElementRelativeToMap(elementId) {
        return $('#'+elementId)[0].getBoundingClientRect().left - $('#farsangMapSvg')[0].getBoundingClientRect().left;
    }
    function getTopElementRelativeToMap(elementId) {
        return $('#'+elementId)[0].getBoundingClientRect().top - $('#farsangMapSvg')[0].getBoundingClientRect().top;
    }

    function getPanLeftToFocus(elementId) {
        const halfElementWidth = ($('#' + elementId)[0].getBoundingClientRect().width / 2),
            halfMapWidth = ($('#farsangMapSvg')[0].getBoundingClientRect().width / 2),
            leftElementRelativeToMap = getLeftElementRelativeToMap(elementId);
        return (leftElementRelativeToMap - halfMapWidth + halfElementWidth)*-1;
    }

    function getPanTopToFocus(elementId) {
        const mapSvgHeight = $('#farsangMapSvg')[0].getBoundingClientRect().height,
            halfElementHeight = ($('#' + elementId)[0].getBoundingClientRect().height / 2),
            halfMapHeight = (mapSvgHeight / 2),
            absTopMapContainerRelativeToSvgMap = Math.abs(getTopElementRelativeToMap('mapContainer')),
            topMapContainerRelativeToSvgMapGap = (absTopMapContainerRelativeToSvgMap > 0) ? absTopMapContainerRelativeToSvgMap : 0,
            topElementRelativeToMap = getTopElementRelativeToMap(elementId);

        return (halfMapHeight - topElementRelativeToMap - halfElementHeight) - topMapContainerRelativeToSvgMapGap;
    }

    function panAndZoomTo(x, y, scale) {
        hideAllTooltip();
        window.RaheAbrishamPanZoom.pan(x, y);
        window.RaheAbrishamPanZoom.zoom(scale, { animate: true });
        showAllTooltip();
    }

    function panToObject(elementId) {
        if (elementId === null) {
            return;
        }
        window.RaheAbrishamPanZoom.reset();
        setTimeout(function () {
            const scale = calculateDynamicScale(elementId);
            panAndZoomTo(getPanLeftToFocus(elementId), getPanTopToFocus(elementId), scale);
            setTimeout(function () {
                refreshAllTooltip();
            }, 1000);
        }, 500);
    }

    function calculateDynamicScale(elementId) {
        return (0.6*$('#mapContainer')[0].getBoundingClientRect().height)/$('#'+elementId)[0].getBoundingClientRect().height;
    }

    return {
        init: function () {
            setFarsangSetIdArray();
            initPanZoom();
            setStepsDataAttributes();
            setStepPointer();
            // setStepsTooltip();
            hideAllTooltip();
        },
        getFarsangSteps: function () {
            setFarsangSetIdArray();
            return farsaneSetIdArray;
        },
        getsetDataFromId: function (setId) {
            setFarsangSetIdArray();
            return getsetDataFromId(setId);
        },
        panToObject: function (elementId) {
            panToObject(elementId)
        }
    }
}();

var EntekhabeFarsang = function () {

    function farsangStepUpdate(setId) {

        var farsangLength = 10,
            farsangSteps = MapSVG.getFarsangSteps(),
            setStepProgressBarHtml = '';

        for (var i = 0; i < farsangLength; i++) {
            var itemIcon = '<i class="fa fa-ban"></i>',
                tooltipName = 'فرسنگ ' + getOmArray(i),
                orginalSetId = (typeof farsangSteps[i] !== 'undefined') ? farsangSteps[i].setId : null,
                dataContentId = 'data-content-id="'+orginalSetId+'"';

            if (orginalSetId !== null && orginalSetId.toString() === setId.toString()) {
                tooltipName += ' (انتخاب شما)';
                itemIcon = '<i class="fa fa-check-circle"></i>';
            } else if (orginalSetId !== null) {
                itemIcon = '<i class="fa fa-circle"></i>';
            } else {
                tooltipName += ' (منتشر نشده)';
            }
            setStepProgressBarHtml += '<div class="setStepProgressBar-step" '+dataContentId+' data-toggle="m-tooltip" data-placement="top" data-original-title="'+tooltipName+'">'+itemIcon+'</div>';
        }
        $('.setStepProgressBar').html(setStepProgressBarHtml);
        $('[data-toggle="m-tooltip"]').tooltip();
    }

    function getOmArray(index) {
        if (index === 0) {
            return 'اول';
        } else if (index === 1) {
            return 'دوم';
        } else  if (index === 2) {
            return 'سوم';
        } else  if (index === 3) {
            return 'چهارم';
        } else  if (index === 4) {
            return 'پنجم';
        } else  if (index === 5) {
            return 'ششم';
        } else  if (index === 6) {
            return 'هفتم';
        } else  if (index === 7) {
            return 'هشتم';
        } else  if (index === 8) {
            return 'نهم';
        } else  if (index === 9) {
            return 'دهم';
        }
    }

    return {
        farsangStepUpdate: farsangStepUpdate
    };

}();

var InitAbrishamPage = function () {

    function makePageBoxedForLargScreen() {
        $('.m-body .m-content').addClass('boxed');
    }

    function initScrollCarousel() {
        ScrollCarousel.addSwipeIcons($('.ScrollCarousel'));
    }

    function initEvents() {
        $(document).on('click', '.showMoreLiveDescriptions', function () {
            var $moreLiveDescriptions = $('.liveDescriptionRow .m-timeline-3 .m-timeline-3__items .m-timeline-3__item:not(:first-child)');
            if ($moreLiveDescriptions.is(":visible")) {
                $moreLiveDescriptions.fadeOut();
                $(this).html($(this).attr('data-read-more-text'));
            } else {
                $moreLiveDescriptions.fadeIn();
                $(this).html('بستن');
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
            if ($(this).parents('.descriptionBox').find('.content').hasClass('compact')) {
                $(this).html('بستن')
                    .parents('.descriptionBox')
                    .find('.content')
                    .removeClass('compact')
                    .addClass('collapsed');
            } else {
                $(this).html($(this).attr('data-read-more-text'))
                    .parents('.descriptionBox')
                    .find('.content')
                    .removeClass('collapsed')
                    .addClass('compact');
            }
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

    function initShowPreviewSetDataCallback(lastSetData) {
        window.showPreviewSetDataCallback = function(data, sectionId) {
            EntekhabeFarsang.farsangStepUpdate(data.set.id);
            MapSVG.panToObject(MapSVG.getsetDataFromId(data.set.id).elementId);
        };
        EntekhabeFarsang.farsangStepUpdate(lastSetData.set.id);
        MapSVG.panToObject(MapSVG.getsetDataFromId(lastSetData.set.id).elementId);
    }

    function init(lastSetData, allSetsOfRaheAbrisham, hasUserPurchasedRaheAbrisham) {
        makePageBoxedForLargScreen();
        MapSVG.init(allSetsOfRaheAbrisham);
        initShowPreviewSetDataCallback(lastSetData);
        initRepurchaseRowAndHelpMessageRow();
        initScrollCarousel();
        initLiveDescription();
        initEvents();
        imageObserver.observe();
        if (!hasUserPurchasedRaheAbrisham) {
            $('.helpMessageRow').fadeOut(0);
            $('.RepurchaseRow').fadeIn();
            $('.RepurchaseRow').AnimateScrollTo();
        }
    }

    return {
        init: init,
    };
}();

jQuery(document).ready(function () {
    if (typeof lastSetData !== 'undefined') {
        InitAbrishamPage.init(lastSetData, allSetsOfRaheAbrisham, hasUserPurchasedRaheAbrisham);
    }
});
