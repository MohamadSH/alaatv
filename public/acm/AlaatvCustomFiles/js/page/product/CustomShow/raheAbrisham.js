var EntekhabeFarsang = function () {

    function showFarsang(setId) {
        showLoading();
        $('.selectEntekhabeFarsangVideoAndPamphlet').AnimateScrollTo();
        getAjaxContent('/set/'+setId, function (data) {
            $('#selectFarsang .select-selected').html(data.set.name).attr('data-option-value', setId);
            setLists(data.files);
            setBtnMoreLink(data.set.url.web);
            checkNoData();
            refreshScrollCarouselSwipIcons();
            showLists();
            imageObserver.observe();
            hideLoading();
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
                accept: "application/json; charset=utf-8",
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                statusCode: {
                    200: function (response) {
                        callback(response);
                    },
                    403: function (response) {
                        // responseMessage = response.responseJSON.message;
                    },
                    404: function (response) {
                    },
                    422: function (response) {
                    },
                    429: function (response) {
                    },
                    //The status for when there is error php code
                    500: function () {
                        removeLoadingItem(owl, type);
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
        for (i = 0; i < dataLength; i++) {
            htmlData += createVideoItem({
                src: data[i].thumbnail,
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
        for (i = 0; i < dataLength; i++) {
            htmlData += createPamphletItem({
                name: data[i].name,
                link: data[i].file.pamphlet[0].link
            });
        }
        return htmlData;
    }

    function createVideoItem(data) {
        return '' +
            '<div class="item w-55443211">\n' +
            '  <a href="'+data.link+'">' +
            '    <img class="lazy-image a--full-width"\n' +
            '         src="https://cdn.alaatv.com/loder.jpg?w=16&h=9"\n' +
            '         data-src="'+data.src+'"\n' +
            '         alt="samplePhoto"\n' +
            '         width="253" height="142">\n' +
            '  </a>' +
            '</div>';
    }

    function createPamphletItem(data) {
        return '' +
            '<div class="item w-55443211">\n' +
            '  <a href="'+data.link+'">' +
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
            '           '+data.name+'\n' +
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
        return '<div class="alert alert-info text-center" role="alert" style="width: 100%;margin: auto;">'+message+'</div>';
    }


    return {
        init: function() {
            checkNoData();
            refreshScrollCarouselSwipIcons();
        },
        showFarsang: function (setId) {
            showFarsang(setId);
        },
    };

}();

var InitAbrishamPage = function () {

    function makePageBoxedForLargScreen() {
        $('.m-body .m-content').addClass('boxed');
    }

    function getFarsangMapHeight() {
        return $('.productPicture').width()+'px';
    }

    function splitFarsangAndNonFarsang(productSets) {

        if (typeof productSets === 'undefined') {
            return false;
        }

        var publishedProductSetsLength = productSets.length,
            pileSetId = 604, // پیله راه ابریشم (ریاضیات مقدماتی) (نظام آموزشی جدید) (99-1398) محمد صادق ثابتی
            nonFarsangIds = [
                717, // پیش آزمون قلمچی راه ابریشم (نظام آموزشی جدید) (99-1398) محمد صادق ثابتی
                665, // بارانداز راه ابریشم ( پس آزمون)
                217, // صفر تا صد ریاضی تجربی کنکور (نظام آموزشی جدید) (98-1397) محمد صادق ثابتی
                pileSetId,
            ],
            freshFarsangs = [],
            freshNonFarsangs = [],
            pileObject;


        for(var i = 0; i < publishedProductSetsLength; i++) {
            var productSetItem = productSets[i];

            if (nonFarsangIds.indexOf(productSetItem.setId) === -1) {
                freshFarsangs.push(productSetItem);
            } else if(productSetItem.setId === pileSetId) {
                pileObject = productSetItem;
            } else {
                freshNonFarsangs.push(productSetItem);
            }
        }

        freshFarsangs.push(pileObject);

        return {
            farsangs: freshFarsangs.reverse(),
            nonFarsangs: freshNonFarsangs
        };
    }

    function getItemName(omIndex) {
        var omArray=[
                'پیله راه ابریشم',
                'اول',
                'دوم',
                'سوم',
                'چهارم',
                'پنجم',
                'ششم',
                'هفتم',
                'هشتم',
                'نهم',
                'دهم',
                'یازدهم',
                'دوازدهم',
                'سیزدهم',
                'چهاردهم',
                'پانزدهم',
                'شانزدهم',
                'هفدهم',
                'هجدهم',
                'نوزدهم',
                'بیستم'
            ],
            name = (omIndex===0)?omArray[omIndex]:'فرسنگ '+omArray[omIndex];
        return name;
    }

    function getHighchartPoints(productSets) {

        var splitedFarsangAndNonFarsang = splitFarsangAndNonFarsang(productSets),
            farsangs = splitedFarsangAndNonFarsang.farsangs,
            nonFarsangs = splitedFarsangAndNonFarsang.nonFarsangs,
            farsangsLength = farsangs.length,
            nonFarsangsLength = nonFarsangs.length,
            farsangPoints = [
                {
                    x: 0,
                    y: 0,
                },
                {
                    x: 10,
                    y: 15,
                },
                {
                    x: 20,
                    y: -5,
                },
                {
                    x: 30,
                    y: -10,
                },
                {
                    x: 40,
                    y: -2,
                },
                {
                    x: 50,
                    y: 22,
                },
                {
                    x: 60,
                    y: 12,
                },
                {
                    x: 70,
                    y: -8,
                },
                {
                    x: 80,
                    y: 7,
                },
                {
                    x: 90,
                    y: 20,
                },
                {
                    x: 100,
                    y: 30,
                },
            ],
            farsangPointsLength = farsangPoints.length,
            currentStep = farsangsLength - 1;

        for(var i = 0; i < farsangPointsLength; i++) {
            var footPrint = 'url(/acm/image/raheAbrisham/footPrint2.svg)',
                farsangItem = farsangs[i];

            if ( i < currentStep) {
                footPrint = 'url(/acm/image/raheAbrisham/footPrint1.svg)';

                // farsangPoints[i].drilldown = "FarsangItems";
                // farsangPoints[i].dataLabels = {color: 'white'};
                farsangPoints[i].set = {
                    id: farsangItem.setId,
                    name: farsangItem.name
                };
            } else if ( i === currentStep ) {

                footPrint = 'url(/acm/image/raheAbrisham/footPrint3.svg)';

                farsangPoints[i].set = {
                    id: farsangItem.setId,
                    name: farsangItem.name
                };
            }
            farsangPoints[i].marker = {
                // symbol: 'url(/acm/image/raheAbrisham/footPrint.svg)'
                symbol: footPrint,
            };
            farsangPoints[i].name = getItemName(i);
        }

        return {
            farsangs: farsangPoints,
            nonFarsangs: []
        };
    }

    function initFarsangMap(productSets) {

        if (typeof productSets === 'undefined') {
            return false;
        }

        var highchartPoints = getHighchartPoints(productSets),
            farsangPoints = highchartPoints.farsangs,
            mapRoadId = 'mapRoad';

        // setCustomEaseOutBounce();
        setHighchartOptions();
        var chart = initHighchart(mapRoadId, farsangPoints);

        setBackgroundForHighchart(mapRoadId);

        // feedMapPoints(chart, farsangPoints);
    }

    function setBackgroundForHighchart(mapRoadId) {
        $('#'+mapRoadId).prepend('<img class="background" src="/acm/image/raheAbrisham/mapbackground1.jpg">');
        $('#'+mapRoadId).find('.highcharts-container').css({'width': '100%'}).find('svg').css({'width': '100%'});
    }

    function initHighchart(mapRoadId, farsangPoints) {
        return new Highcharts.chart(mapRoadId, {
            chart: {
                type: 'spline',
                margin: [5, 20, 5, 20], // [up, right, down, left]
                // width: '100%',
                height: getFarsangMapHeight(),
                // inverted: true
            },
            credits: {
                enabled: false
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                visible: false,
                // reversed: true,
                // title: {
                //     enabled: true,
                //     text: ''
                // },
                // labels: {
                //     format: ''
                // },
                // maxPadding: 0.05,
                // showLastLabel: false
            },
            yAxis: {
                visible: false,
                // title: {
                //     text: ''
                // },
                // labels: {
                //     format: ''
                // },
                // lineWidth: 2
            },
            legend: {
                enabled: false
            },
            tooltip: {
                headerFormat: '',
                pointFormat: '{point.name}'
            },
            plotOptions: Highcharts_plotOptions(),

            exporting: {
                buttons: [{
                    text: 'custom button',
                    onclick: function () {
                        alert('clicked');
                    },
                    theme: {
                        'stroke-width': 1,
                        stroke: 'silver',
                        r: 0,
                        states: {
                            hover: {
                                fill: '#a4edba'
                            },
                            select: {
                                stroke: '#039',
                                fill: '#a4edba'
                            }
                        }
                    }
                }]
            },
            series: Highcharts_series(farsangPoints),
            // drilldown: Highcharts_drilldown()
        });
    }

    function setCustomEaseOutBounce() {
        Math.easeOutBounce = function (pos) {
            var res;
            res = (7.5625 * pos * pos);
            // if ((pos) < (1 / 2.75)) {
            //     res = (7.5625 * pos * pos);
            // } else if (pos < (2 / 2.75)) {
            //     res = (7.5625 * (pos -= (1.5 / 2.75)) * pos + 0.75);
            // } else if (pos < (2.5 / 2.75)) {
            //     res = (7.5625 * (pos -= (2.25 / 2.75)) * pos + 0.9375);
            // } else {
            //     res = (7.5625 * (pos -= (2.625 / 2.75)) * pos + 0.984375);
            // }
            res = 1 - res;
            return res;
        };
    }

    function setHighchartOptions() {
        Highcharts.setOptions({
            lang: {
                drillUpText: '<< بازگشت به {series.name}'
            }
        });
    }

    function Highcharts_series(farsangPoints) {
        return [{
            type: 'spline',
            name: 'مسیر راه ابریشم',
            data: farsangPoints,
            // data: [],
            color: '#da9d6c',
            // animation: false,
            animation: {
                duration: 2000,
                // Uses Math.easeOutBounce
                // easing: 'easeOutBounce'
            }
        }];
    }

    function Highcharts_plotOptions() {
        return {
            enableMouseTracking: false,
            // spline: {
            //     marker: {
            //         enable: false
            //     }
            // },
            series: {
                cursor: 'pointer',
                // allowPointSelect: true,
                dataLabels: {
                    enabled: true,
                    color: 'white',
                    style: {
                        fontSize: '16px',
                        textOutline: false ,
                    },
                    format: '{point.name}',
                    // useHTML: true,
                    // formatter: function () {
                    //     console.log(this)
                    //     return '<div>'+this.key+'</div>';
                    // }
                },
                point: {
                    events: {
                        click: function() {
                            var data = this.series.data[this.index];
                            EntekhabeFarsang.showFarsang(data.set.id)
                        }
                    }
                }
            },
        };
    }

    function Highcharts_drilldown() {
        return {
            drillUpButton: {
                position: {
                    align: 'left'
                }
            },
            activeDataLabelStyle: {
                color: 'white',
                textDecoration: 'none'
            },
            margin: [5, 50, 5, 50], // [up, right, down, left]
            series: [
                {
                    type: 'organization',
                    name: 'FarsangItems',
                    id: 'FarsangItems',
                    keys: ['from', 'to'],
                    enableMouseTracking: false,
                    hangingIndent: 100,
                    data: [
                        ['farsang1', 'CTO'],
                        ['farsang1', 'CPO'],
                        ['farsang1', 'CSO'],
                        ['farsang1', 'CMO'],
                    ],
                    levels: [{
                        level: 0,
                        color: 'silver',
                        dataLabels: {
                            color: 'black'
                        },
                        width: 250,
                        height: 250
                    }, {
                        level: 1,
                        color: 'silver',
                        dataLabels: {
                            color: 'black'
                        },
                        width: 250,
                        height: 250
                    }, {
                        level: 2,
                        color: '#980104'
                    }, {
                        level: 4,
                        color: '#359154'
                    }],
                    nodes: [{
                        id: 'farsang1',
                        title: 'فرسنگ اول',
                        name: 'فرسنگ اول',
                        image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132317/Grethe.jpg',
                        layout: 'hanging'
                    }, {
                        id: 'CTO',
                        title: 'CTO',
                        name: 'Christer Vasseng',
                        color: '#007ad0',
                        column: 4,
                        image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12140620/Christer.jpg',
                        layout: 'hanging'
                    }, {
                        id: 'CPO',
                        title: 'CPO',
                        name: 'Torstein Hønsi',
                        column: 4,
                        image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12131849/Torstein1.jpg',
                        layout: 'hanging'
                    }, {
                        id: 'CSO',
                        title: 'CSO',
                        name: 'Anita Nesse',
                        column: 4,
                        image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132313/Anita.jpg',
                        layout: 'hanging'
                    }, {
                        id: 'CMO',
                        title: 'CMO',
                        name: 'Vidar Brekke',
                        column: 4,
                        image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/13105551/Vidar.jpg',
                        layout: 'hanging'
                    }],
                    colorByPoint: false,
                    color: '#007ad0',
                    dataLabels: {
                        color: 'white'
                    },
                    borderColor: 'white',
                    nodeWidth: 90
                }
            ]
        };
    }


    function feedMapPoints(chart, farsangPoints) {
        var counter = 0,
            farsangPointsLength = farsangPoints.length;
        var i = setInterval(function(){

            chart.series[0].addPoint(farsangPoints[counter]);

            counter++;
            if(counter === farsangPointsLength) {
                clearInterval(i);
            }
        }, 400);
    }

    function initCustomDropDown() {
        $('.CustomDropDown').CustomDropDown({
            onChange: function (data) {
                EntekhabeFarsang.showFarsang(data.value);
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
    }

    function initLiveDescription() {
        $('.liveDescriptionRow .m-timeline-3 .m-timeline-3__items .m-timeline-3__item:not(:first-child)').fadeOut();
    }

    function initRepurchaseRowAndHelpMessageRow() {
        $('.helpMessageRow').fadeOut();
        $('.RepurchaseRow').fadeOut();
    }

    return {
        init: function (farsangs) {

            initRepurchaseRowAndHelpMessageRow();
            EntekhabeFarsang.init();
            makePageBoxedForLargScreen();
            initFarsangMap(farsangs);
            initCustomDropDown();
            initScrollCarousel();
            initLiveDescription();
            initEvents();
            imageObserver.observe();
        },
    };
}();


jQuery(document).ready(function () {


    InitAbrishamPage.init(farsangs);


    //
    // function setChart(options) {
    //     chart.series[0].remove(false);
    //     chart.addSeries({
    //         type: options.type,
    //         name: options.name,
    //         data: options.data,
    //         color: options.color || 'white'
    //     }, false);
    //     chart.xAxis[0].setCategories(options.categories, false);
    //     chart.redraw();
    // }


    // Highcharts.addEvent(
    //     Highcharts.Series,
    //     'afterSetOptions',
    //     function (e) {
    //         var colors = [
    //                 '#0AFF00',
    //                 '#55F000',
    //                 '#9AF100',
    //                 '#DFF000',
    //                 '#F0DB00',
    //                 '#FFCF00',
    //                 '#F0AB00',
    //                 '#F08F00',
    //                 '#FF7B00',
    //                 '#FF5900',
    //                 '#F03300',
    //                 '#F01300',
    //                 '#FF002E',
    //             ],
    //             i = 0,
    //             nodes = {},
    //             omArray=[
    //                 '',
    //                 'اول',
    //                 'دوم',
    //                 'سوم',
    //                 'چهارم',
    //                 'پنجم',
    //                 'ششم',
    //                 'هفتم',
    //                 'هشتم',
    //                 'نهم',
    //                 'دهم',
    //                 'یازدهم',
    //                 'دوازدهم',
    //                 'سیزدهم',
    //             ];
    //
    //         if (
    //             this instanceof Highcharts.seriesTypes.networkgraph &&
    //             e.options.id === 'raheAbrishamOption'
    //         ) {
    //             e.options.data.forEach(function (link) {
    //
    //                 nodes[link[0]] = {
    //                     id: link[0],
    //                     dataLabels: {
    //                         format: 'فرسنگ ' + omArray[link[0]]
    //                     },
    //                     color: colors[i]
    //                 };
    //                 nodes[link[1]] = {
    //                     id: link[1],
    //                     dataLabels: {
    //                         format: 'فرسنگ ' + omArray[link[1]]
    //                     },
    //                     color: colors[i++]
    //                 };
    //             });
    //
    //             e.options.nodes = Object.keys(nodes).map(function (id) {
    //                 return nodes[id];
    //             });
    //         }
    //     }
    // );
    //
    //
    // Highcharts.chart('mapRoad', {
    //     chart: {
    //         type: 'networkgraph',
    //         height: '300px'
    //     },
    //     title: {
    //         text: 'لیست محصولات شما'
    //     },
    //     subtitle: {
    //         text: 'لیست درختی محصولات شما'
    //     },
    //     plotOptions: {
    //         networkgraph: {
    //             keys: ['from', 'to'],
    //             layoutAlgorithm: {
    //                 enableSimulation: true,
    //                 integration: 'verlet', // euler - verlet
    //                 linkLength: 100,
    //                 friction: -0.99
    //             }
    //         }
    //     },
    //
    //
    //     series: [{
    //         id: 'raheAbrishamOption',
    //         dataLabels: {
    //             enabled: true,
    //             linkFormat: '',
    //             // linkFormat: '{point.fromNode.name} \u2192 {point.toNode.name}',
    //             // linkFormat: 'به سمت {point.toNode.name}',
    //             allowOverlap: true,
    //             textPath: {
    //                 enabled: false,
    //                 attributes: {
    //                     dy: 14,
    //                     startOffset: '45%',
    //                     textLength: 80
    //                 }
    //             },
    //             format: 'فرسنگ {point.name}'
    //
    //         },
    //         marker: {
    //             radius: 13
    //         },
    //         color: '#0AFF00',
    //         data: [
    //             ['13', '12'],
    //             ['12', '11'],
    //             ['11', '10'],
    //             ['10', '9'],
    //             ['9', '8'],
    //             ['8', '7'],
    //             ['7', '6'],
    //             ['6', '5'],
    //             ['5', '4'],
    //             ['4', '3'],
    //             ['3', '2'],
    //             ['2', '1'],
    //             // {
    //             //     id: '1',
    //             //     name: 'step1',
    //             //     from: 1,
    //             //     to: 2,
    //             //     color: '#FF002E',
    //             //     colorIndex: '#FF002E',
    //             //     selected: true,
    //             //     drilldown: 'step1'
    //             // }
    //         ]
    //     }],
    //
    //     drilldown: {
    //         series: [{
    //             id: '2',
    //             name: '2',
    //             data: [
    //                 ['Cats', 4],
    //                 ['Dogs', 2],
    //                 ['Cows', 1],
    //                 ['Sheep', 2],
    //                 ['Pigs', 1]
    //             ]
    //         }, {
    //             id: 'step1',
    //             name: 'step1',
    //             data: [
    //                 ['Apples', 4],
    //                 ['Oranges', 2]
    //             ]
    //         }]
    //     }
    //
    // });



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

    imageObserver.observe();
});
