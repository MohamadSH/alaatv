var AlaaVast = function () {

    var defaultAdItemData = {
            xml: '',
            Impression: {
                attr: {
                    id: ''
                },
                val: ''
            },
            Pricing: {
                attr: {
                    model: 'cpm',
                    currency: 'USD',
                },
                val: ''
            },
            AdServingId: {
                val: ''
            },
            AdTitle: {
                val: ''
            },
            Category: {
                attr: {
                    authority: '',
                },
                val: ''
            },
            ClickThrough: {
                attr: {
                    id: '',
                },
                val: ''
            },
            trackingEvents: {
                start: '',
                firstQuartile: '',
                midpoint: '',
                thirdQuartile: '',
                complete: '',
                pause: '',
                resume: '',
                skip: '',
                clickthrough: '',
            },
            startAfter: 0,
            canSkipAfter: 0,
            mediaFiles: [
                {
                    id: '',
                    type: 'video/mp4',
                    width: '1280',
                    height: '720',
                    src: '',
                    res: '',
                    label: '',
                    default: false
                }
            ],
            isPlayed: false,
            isSkipButtonShown: false,
            isSkipTimerShown: false

        },
        data = [];

    function getXml() {
        var address = 'http://localhost/acm/videojs/vast42.xml',
            xmlDoc;
        var x = new XMLHttpRequest();
        x.open('GET', address, true);
        x.onreadystatechange = function () {
            if (x.readyState === 4 && x.status === 200)
            {
                xmlDoc = x.responseXML;
                console.log(xmlDoc);
            }
        };
        x.send(null);
        console.log('sending...');
    }

    function xmlAdapter(xmlDoc) {
        xmlDoc.getElementsByTagName('AdSystem')[0].innerHTML
    }

    function feedAdItem() {

    }

    function initAdPlayer(player, adIndex) {
        var adPlayer = videojs(getAdPlayerId(player, adIndex), {
            language: 'fa'
        });
        adPlayer.nuevo({
            // logotitle:"آموزش مجازی آلاء",
            // logo:"https://sanatisharif.ir/image/11/135/67/logo-150x22_20180430222256.png",
            logocontrolbar: 'https://cdn.alaatv.com/upload/alaa-logo-small.png',
            // logoposition:"RT", // logo position (LT - top left, RT - top right)
            logourl:'//alaatv.com',

            // shareTitle: contentDisplayName,
            // shareUrl: contentUrl,
            // shareEmbed: '<iframe src="' + contentEmbedUrl + '" width="640" height="360" frameborder="0" allowfullscreen></iframe>',

            // videoInfo: true,
            // infoSize: 18,
            // infoIcon: "https://sanatisharif.ir/image/11/150/150/favicon_32_20180819090313.png",

            closeallow:false,
            mute:true,
            rateMenu:true,
            resume:true, // (false) enable/disable resume option to start video playback from last time position it was left
            // theaterButton: true,
            timetooltip: true,
            mousedisplay: true,
            // endAction: 'related', // (undefined) If defined (share/related) either sharing panel or related panel will display when video ends.
            container: "inline",


            // limit: 20,
            // limiturl: "http://localdev.alaatv.com/videojs/examples/basic.html",
            // limitimage : "//cdn.nuevolab.com/media/limit.png", // limitimage or limitmessage
            // limitmessage: "اگه می خوای بقیه اش رو ببینی باید پول بدی :)",


            // overlay: "//domain.com/overlay.html" //(undefined) - overlay URL to display html on each pause event example: https://www.nuevolab.com/videojs/tryit/overlay

        });

        adPlayer.on('ended', function() {
            playPlayer(player, adPlayer, adIndex);
        });

        adPlayer.on('click', function(event){
            event.preventDefault();

            if (
                !$(event.target).closest('.vjs-control-bar').length &&
                !$(event.target).closest('.vjs-big-play-button').length &&
                !$(event.target).closest('.AlaaVastSkipBtn').length &&
                !$(event.target).closest('.AlaaVastSkipTimer').length &&
                data[adIndex].ClickThrough.val.length > 0
            ) {
                window.location.href = data[adIndex].ClickThrough.val;
            }
        });

        disableProgressControlBar(adPlayer);

        return adPlayer;
    }

    function disableProgressControlBar(adPlayer) {
        $('#'+adPlayer.id()).find('.vjs-control-bar').prepend('<div style="position: absolute;height: 25px;width: 100%;top: -16px;left: 0;z-index: 10;"></div>');
    }

    function hiePlayer(player) {
        $('#'+player.id()).fadeOut(0);
    }

    function showPlayer(player) {
        $('#'+player.id()).fadeIn(0);
    }

    function playPlayer(player, adPlayer, adIndex) {
        hideAdPlayer(player, adIndex);
        adPlayer.pause();
        showPlayer(player);
        player.play();
    }

    function hideAdPlayer(player, adIndex) {
        $('#'+getAdPlayerId(player, adIndex)).fadeOut(0);
    }

    function setAdIsPlayed(adItem) {
        adItem.isPlayed = true;
    }

    function showAdPlayer(player, adIndex) {

        if (!hasSouce(adIndex)) {
            return;
        }

        player.pause();
        hiePlayer(player);
        createAdPlayer(player, adIndex);
        var adPlayer = initAdPlayer(player, adIndex);
        setAdIsPlayed(data[adIndex]);
        adPlayer.load();
        adPlayer.play();
        adPlayer.on('timeupdate', function() {
            if (canShowAdSkipButton(adPlayer, adIndex)) {
                hideSkipTimer(player, adIndex);
                showSkipButton(player, adPlayer, adIndex);
            } else if(!data[adIndex].isSkipTimerShown) {
                showSkipTimer(player, adPlayer, adIndex);
            } else {
                updateSkipTimer(player, adPlayer, adIndex);
            }
        });

    }

    function hasSouce(adIndex) {
        return data[adIndex].mediaFiles.length > 0;
    }

    function canShowAdSkipButton(adPlayer, adIndex) {
        return (adPlayer.currentTime() > data[adIndex].canSkipAfter && !data[adIndex].isSkipButtonShown);
    }

    function getAdPlayerId(player, adIndex) {
        return 'adOf-'+player.id()+'-'+adIndex;
    }

    function createAdPlayer(player, adIndex) {
        $(
            '<video id="'+getAdPlayerId(player, adIndex)+'"\n' +
            '       class="video-js vjs-fluid vjs-default-skin vjs-big-play-centered"\n' +
            '       preload="none" height="360" width="640" poster="'+player.poster()+'">\n' +
            getVideoSources(adIndex) +
            '    <p class="vjs-no-js">@lang(\'content.javascript is disables! we need it to play a video\')</p>\n' +
            '</video>').insertAfter('#'+player.id());
    }

    function getVideoSources(adIndex) {

        checkHasDefaultSrc(adIndex);

        var htmlData = '';
        for (var i = 0; (typeof data[adIndex].mediaFiles[i] !== 'undefined'); i++) {
            var source = data[adIndex].mediaFiles[i];
            htmlData += '  <source src="'+source.src+'" type="'+source.type+'" res="'+source.res+'" label="'+source.label+'" '+(source.default ? 'default' : '')+' />\n';
        }

        return htmlData;
    }

    function initData(customData) {
        for (var i = 0; (typeof customData[i] !== 'undefined'); i++) {
            data.push($.extend(true, {}, defaultAdItemData, customData[i]));
        }
    }

    function checkHasDefaultSrc(adIndex) {

        var hasDefaultSrc = data[adIndex].mediaFiles.find(function (item, index) {
            return item.default === true;
        });

        if (typeof hasDefaultSrc === 'undefined') {
            data[adIndex].mediaFiles[0].default = true;
        }
    }

    function getAdToStart(player) {
        var currentTime  = player.currentTime();
        for (var i = 0; (typeof data[i] !== 'undefined'); i++) {
            if (((data[i].startAfter === 0 || currentTime > data[i].startAfter) && !data[i].isPlayed)) {
                return i;
            }
        }

        return null;
    }

    function addSkipButton(player, adPlayer, adIndex) {
        $('#'+getAdPlayerId(player, adIndex)).prepend('' +
            '<div class="AlaaVastSkipBtn" data-adplayer-id="'+getAdPlayerId(player, adIndex)+'"' +
            'style="position: absolute;z-index: 9999;background: #00000061;bottom: 20%;right: 0;width: 0;height: 50px;display: flex;align-items: center;justify-content: center;border: solid 2px #ff9000; cursor: pointer;">' +
            'رد کن' +
            '</div>');
        $(document).on('click', '.AlaaVastSkipBtn[data-adplayer-id="'+getAdPlayerId(player, adIndex)+'"]', function () {
            playPlayer(player, adPlayer, adIndex);
        });
    }

    function addSkipTimer(player, adPlayer, adIndex) {
        $('#'+getAdPlayerId(player, adIndex)).prepend('' +
            '<div class="AlaaVastSkipTimer" data-adplayer-id="'+getAdPlayerId(player, adIndex)+'"' +
            'style="position: absolute;z-index: 9999;background: #00000061;bottom: 20%;right: 0;width: 0;height: 50px;display: flex;align-items: center;justify-content: center;border: solid 2px #ff9000;">' +
            '</div>');
    }

    function showSkipButton(player, adPlayer, adIndex) {
        addSkipButton(player, adPlayer, adIndex);
        $('#'+getAdPlayerId(player, adIndex)).find('.AlaaVastSkipBtn').animate({width:'200px'},350);
        data[adIndex].isSkipButtonShown = true;
    }

    function showSkipTimer(player, adPlayer, adIndex) {
        addSkipTimer(player, adPlayer, adIndex);
        $('#'+getAdPlayerId(player, adIndex)).find('.AlaaVastSkipTimer').animate({width:'80px'},350);
        data[adIndex].isSkipTimerShown = true;
    }

    function getTimerFormat(data, canSkipAfter) {
        return canSkipAfter - Math.floor(parseInt(data));
    }

    function hideSkipTimer(player, adIndex) {
        $('#'+getAdPlayerId(player, adIndex)).find('.AlaaVastSkipTimer').animate({width:'0px'},350).fadeOut();
    }

    function updateSkipTimer(player, adPlayer, adIndex) {
        var timerText = getTimerFormat(adPlayer.currentTime(), data[adIndex].canSkipAfter);
        $('#'+getAdPlayerId(player, adIndex)).find('.AlaaVastSkipTimer').html(timerText)
    }

    function init(player, customData) {

        initData(customData);

        player.on('play', function() {
            var addToStartindex = getAdToStart(player);
            if (addToStartindex !== null) {
                showAdPlayer(player, addToStartindex);
            }
        });

        player.on('timeupdate', function() {
            var addToStartindex = getAdToStart(player);
            if (addToStartindex !== null) {
                showAdPlayer(player, addToStartindex);
            }
        });
    }


    return {
        init: init,
        adPlayers: []
    }
}();
