document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('a--fullcalendar');

    var calendar = new FullCalendar.Calendar(calendarEl,



        {
            locale: 'fa',
            plugins: [ 'timeGrid' ],
            // timeZone: 'UTC',
            timeZone: 'Iran/Tehran',
            defaultView: 'timeGridWeek',


            // viewSkeletonRender: function( info ) {
            //
            //     let element = info.view.header.thead.children[0].children,
            //         elementLength = element.length;
            //     console.log('element: ', element);
            //     console.log('elementLength: ', elementLength);
            //
            //     for (let i = 0; i < elementLength; i++) {
            //         console.log('innerHTML: ', element[i].innerHTML);
            //         element[i].innerHTML = element[i].innerText.replace(' ', '<br>');
            //     }
            //
            // },

            editable: false,
            // aspectRatio: 1,
            nowIndicator: true,
            allDaySlot: false,
            contentHeight: 'auto',
            header: {
                left: '',
                // left: 'prev,next today',
                // center: 'title',
                // right: 'timeGridWeek,timeGridDay'
                right: ''
            },
            eventRender: function(info) {
                // var tooltip = new Tooltip(info.el, {
                //     title: info.event.extendedProps.description,
                //     placement: 'top',
                //     trigger: 'hover',
                //     container: 'body'
                // });
            },

            eventClick: function(info) {
                alert(info.event.title);
                // console.log(info.event.title);
                // console.log(info.event._instance.range);
                // console.log(info.event._instance.range.start);
                // alert('Event: ' + info.event.title);
                // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                // alert('View: ' + info.view.type);

                // change the border color just for fun
                // info.el.style.borderColor = 'red';
            },

            events: formatData(liveData),

            minTime: "07:00:00",
            maxTime: "13:00:00",

        }

    //
    //     {
    //     locale: 'fa',
    //     plugins: [ 'interaction', 'resourceTimeline' ],
    //     timeZone: 'UTC',
    //     header: {
    //         // left: 'today prev,next',
    //         center: 'title',
    //         // right: 'resourceTimelineDay,resourceTimelineTenDay,resourceTimelineWeek,resourceTimelineMonth,resourceTimelineYear'
    //     },
    //     defaultView: 'resourceTimelineWeek',
    //     scrollTime: '08:00',
    //     // aspectRatio: 1.5,
    //     views: {
    //         // resourceTimelineDay: {
    //         //     buttonText: ':15 slots',
    //         //     slotDuration: '00:15'
    //         // },
    //         // resourceTimelineTenDay: {
    //         //     type: 'resourceTimeline',
    //         //     duration: { days: 10 },
    //         //     buttonText: '10 days'
    //         // }
    //     },
    //     editable: false,
    //     resourceLabelText: 'Rooms',
    //     resources: 'https://fullcalendar.io/demo-resources.json?with-nesting&with-colors',
    //     events: 'https://fullcalendar.io/demo-events.json?single-day&for-resource-timeline'
    // }





    );

    calendar.render();

});

function formatData(data) {
    let dataLength = data.length,
        newData = [];
    for(let i = 0; i < dataLength; i++) {
        let title = data[i].title,
            start = data[i].date+' '+data[i].start_time,
            end = data[i].date+' '+data[i].finish_time,
            color = '#ff9000',
            allDay = false;
        newData.push({
                title  : title,
                start  : start,
                end    : end,
                color  : color,
                allDay : allDay
            });
    }
    return newData;
}

if ($('#video-0').length > 0) {

    player = videojs('video-0', {
        language: 'fa',
        liveui: true,
        autoplay: true
    });

    var lastDuration = Infinity;
    player.on('timeupdate', function() {
        var duration = player.duration();
        if(!isFinite(duration)) {
            var start = player.seekable().start(0);
            var end = player.seekable().end(0);
            if(start !== end) {
                // 1 seconds offset to prevent freeze when seeking all the way to left
                duration = end - start - 1;
                if(duration >= 0 && duration !== lastDuration) {
                    player.duration(duration);
                    lastDuration = duration;
                } else if(isFinite(lastDuration)) {
                    player.duration(lastDuration);
                }
            }
        }
    });

    player.nuevo({
        // logotitle:"آموزش مجازی آلاء",
        // logo:"https://sanatisharif.ir/image/11/135/67/logo-150x22_20180430222256.png",
        logocontrolbar: '/acm/extra/Alaa-logo.gif',
        // logoposition:"RT", // logo position (LT - top left, RT - top right)
        logourl:'//sanatisharif.ir',

        shareTitle: contentDisplayName,
        shareUrl: contentUrl,
        // shareEmbed: '<iframe src="' + contentEmbedUrl + '" width="640" height="360" frameborder="0" allowfullscreen></iframe>',



        videoInfo: true,
        // infoSize: 18,
        // infoIcon: "https://sanatisharif.ir/image/11/150/150/favicon_32_20180819090313.png",


        relatedMenu: true,
        zoomMenu: true,
        // related: related_videos,
        // mirrorButton: true,

        closeallow:false,
        mute:true,
        rateMenu:true,
        resume:true, // (false) enable/disable resume option to start video playback from last time position it was left
        // theaterButton: true,
        timetooltip: true,
        mousedisplay: true,
        endAction: 'related', // (undefined) If defined (share/related) either sharing panel or related panel will display when video ends.
        container: "inline",


        // limit: 20,
        // limiturl: "http://localdev.alaatv.com/videojs/examples/basic.html",
        // limitimage : "//cdn.nuevolab.com/media/limit.png", // limitimage or limitmessage
        // limitmessage: "اگه می خوای بقیه اش رو ببینی باید پول بدی :)",


        // overlay: "//domain.com/overlay.html" //(undefined) - overlay URL to display html on each pause event example: https://www.nuevolab.com/videojs/tryit/overlay

    });

    player.hotkeys({
        enableVolumeScroll: false,
        volumeStep: 0.1,
        seekStep: 5
    });

    player.pic2pic();
}

$(document).ready(function () {
    function ajaxLive(ajaxUrl) {
        $.ajax({
            type: 'POST',
            url : ajaxUrl,
            data: {},
            dataType: 'json',

            success: function (data) {
                window.location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('خطای سیستمی رخ داده است.');
            }
        });
    }
    $(document).on('click', '.btnPlayLive', function () {
        ajaxLive(playLiveAjaxUrl);
    });
    $(document).on('click', '.btnStopLive', function () {
        ajaxLive(stopLiveAjaxUrl);
    });
});