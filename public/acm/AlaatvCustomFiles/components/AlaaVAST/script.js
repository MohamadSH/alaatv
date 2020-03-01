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
                    name: '',
                    creative: '',
                    position: ''
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
            mediaFiles: [{}],
            isPlayed: false,
            isSkipButtonShown: false,
            isSkipTimerShown: false
        },
        defaultMediaFilesItem = {
            id: '',
            type: 'video/mp4',
            width: '1280',
            height: '720',
            src: '',
            res: '',
            label: '',
            default: false
        },
        data = [],
        reponsive = {
            breakPoint: 600
        };

    var XMLService = function () {

        function getXml(address, successCallback, failedCallback) {
            var x = new XMLHttpRequest();
            x.open('GET', address, true);
            x.onreadystatechange = function () {
                if (x.readyState === 4 && x.status === 200) {
                    var responseXML = x.responseXML;
                    if (responseXML) {
                        successCallback(responseXML);
                    }
                } else {
                    failedCallback();
                }
            };
            x.send(null);
        }

        function getMediaFiles(xmlDoc) {
            var node = getNode(xmlDoc, 'MediaFiles');
            if (node === null) {
                return [];
            }

            var mediaFiles = node.children,
                mediaFilesArray = [];

            for (var i = 0; (typeof mediaFiles[i] !== 'undefined'); i++) {
                if (mediaFiles[i].nodeName === 'MediaFile') {
                    mediaFilesArray.push(getMediaFile(mediaFiles[i]));
                }
            }

            return mediaFilesArray;
        }

        function getClickThrough(xmlDoc) {
            var node = getNode(xmlDoc, 'ClickThrough');
            if (node) {
                return node.textContent.trim();
            }
            return null;
        }

        function getMediaFile(mediaFile) {
            var attributes = mediaFile.attributes;

            return $.extend(true, {}, getMediaAttributes(attributes, ['id', 'type', 'width', 'height', 'res', 'label', 'default']), {src: mediaFile.textContent.trim()});
        }

        function getMediaAttributes(attributes, attributesKey) {
            var data = {};
            for (var i = 0; (typeof attributesKey[i] !== 'undefined'); i++) {
                if (attributes.getNamedItem(attributesKey[i])) {
                    data[attributesKey[i]] = attributes.getNamedItem(attributesKey[i]).nodeValue;
                }
            }

            return data;
        }

        function getSkipoffset(xmlDoc) {
            var skipoffset = getNodeAttribute(xmlDoc, 'Linear', 'skipoffset');
            if (skipoffset !== null) {
                return convertTime(skipoffset);
            }

            return convertTime('99:99:99');
        }

        function getStartoffset(xmlDoc) {
            var skipoffset = getNodeAttribute(xmlDoc, 'Linear', 'startoffset');
            if (skipoffset !== null) {
                return convertTime(skipoffset);
            }

            return convertTime('00:00:00');
        }

        function convertTime(string) {
            var timeArray = string.split(':');
            return parseInt(timeArray[0]*3600)+parseInt(timeArray[1]*60)+parseInt(timeArray[2]);
        }

        function getNodeAttribute(xmlDoc, nodeName, attributeName) {
            var node = getNode(xmlDoc, nodeName);
            if(node !== null && node.attributes.getNamedItem(attributeName)) {
                return node.attributes.getNamedItem(attributeName).nodeValue
            }
            return null;
        }

        function getNode(xmlDoc, nodeName) {
            if(xmlDoc.getElementsByTagName(nodeName).length > 0) {
                return xmlDoc.getElementsByTagName(nodeName)[0];
            }
            return null;
        }

        function xmlAdapter(xmlDoc) {
            return {
                mediaFiles: getMediaFiles(xmlDoc),
                ClickThrough: {
                    attr: {
                        id: '',
                    },
                    val: getClickThrough(xmlDoc)
                },
                startAfter: getStartoffset(xmlDoc),
                canSkipAfter: getSkipoffset(xmlDoc)
            }
        }

        return {
            getXml: getXml,
            xmlAdapter: xmlAdapter,
        };

    }();

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

        showReadMoreButton(player, adPlayer, adIndex);

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
            for (var j = 0; (typeof customData[i].mediaFiles[j] !== 'undefined'); j++) {
                customData[i].mediaFiles[j] = $.extend(true, {}, defaultMediaFilesItem, customData[i].mediaFiles[j]);
            }
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
            '<div class="AlaaVastBtn AlaaVastSkipBtn" data-adplayer-id="'+getAdPlayerId(player, adIndex)+'">' +
            'رد کن' +
            '</div>');
        $(document).on('click', '.AlaaVastSkipBtn[data-adplayer-id="'+getAdPlayerId(player, adIndex)+'"]', function () {
            playPlayer(player, adPlayer, adIndex);
        });
    }

    function addReadMoreButton(player, adPlayer, adIndex) {
        var gtmEEC = '';
        if (
            data[adIndex].ClickThrough.attr.id.trim().length > 0 &&
            data[adIndex].ClickThrough.attr.name.trim().length > 0 &&
            data[adIndex].ClickThrough.attr.creative.trim().length > 0 &&
            data[adIndex].ClickThrough.attr.position.trim().length > 0
        ) {
            gtmEEC = '   class="a--gtm-eec-advertisement a--gtm-eec-advertisement-click"\n' +
                '   data-gtm-eec-promotion-id="'+ data[adIndex].ClickThrough.attr.id +'"\n' +
                '   data-gtm-eec-promotion-name="'+ data[adIndex].ClickThrough.attr.name +'"\n' +
                '   data-gtm-eec-promotion-creative="'+ data[adIndex].ClickThrough.attr.creative +'"\n' +
                '   data-gtm-eec-promotion-position="'+ data[adIndex].ClickThrough.attr.position +'"';
        }

        $('#'+getAdPlayerId(player, adIndex)).prepend('' +
            '<a href="'+ data[adIndex].ClickThrough.val +'"' + gtmEEC + '>' +
            '    <div class="AlaaVastBtn AlaaVastReadMoreBtn" data-adplayer-id="'+getAdPlayerId(player, adIndex)+'">' +
            'اطلاعات بیشتر    ' +
            '    </div>' +
            '</a>');
        // $(document).on('click', '.AlaaVastReadMoreBtn[data-adplayer-id="'+getAdPlayerId(player, adIndex)+'"]', function () {
        // });
    }

    function addSkipTimer(player, adPlayer, adIndex) {
        $('#'+getAdPlayerId(player, adIndex)).prepend('' +
            '<div class="AlaaVastBtn AlaaVastSkipTimer" data-adplayer-id="'+getAdPlayerId(player, adIndex)+'"></div>');
    }

    function showReadMoreButton(player, adPlayer, adIndex) {
        if (data[adIndex].ClickThrough.val.trim().length === 0) {
            return;
        }
        addReadMoreButton(player, adPlayer, adIndex);
        $('#'+getAdPlayerId(player, adIndex)).find('.AlaaVastReadMoreBtn').animate({width:'35%'},350);
    }

    function showSkipButton(player, adPlayer, adIndex) {
        addSkipButton(player, adPlayer, adIndex);
        $('#'+getAdPlayerId(player, adIndex)).find('.AlaaVastSkipBtn').animate({width:'30%'},350);
        data[adIndex].isSkipButtonShown = true;
    }

    function showSkipTimer(player, adPlayer, adIndex) {
        addSkipTimer(player, adPlayer, adIndex);
        $('#'+getAdPlayerId(player, adIndex)).find('.AlaaVastSkipTimer').animate({width:'15%'},350);
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

        addCss();

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

    function addLoading(player) {
        $('#'+player.id()).prepend('<div class="playerLoading-'+player.id()+'" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;background: #808080d4;z-index: 98;cursor: wait;"></div>');
    }

    function removeLoading(player) {
        $('.playerLoading-'+player.id()).remove();
    }

    function addCss() {
        $('body').append('' +
            '<style>' +
            '.AlaaVastBtn {\n' +
            '  position: absolute;\n' +
            '  z-index: 9;\n' +
            '  border: 2px solid rgb(255, 144, 0);\n' +
            '  background: rgba(0, 0, 0, 0.38) none repeat scroll 0% 0%;\n' +
            '  bottom: 140px;\n' +
            '  right: 0;\n' +
            '  width: 0;\n' +
            '  height: 20%;\n' +
            '  max-height: 40px;\n' +
            '  display: flex;\n' +
            '  align-items: center;\n' +
            '  justify-content: center;\n' +
            'color: white;' +
            '}\n' +
            '.AlaaVastBtn.AlaaVastSkipTimer {\n' +
            '  max-width: 80px;\n' +
            '}\n' +
            '.AlaaVastBtn.AlaaVastSkipBtn {\n' +
            'max-width: 200px;\n' +
            'cursor: pointer;\n' +
            '}' +
            '.AlaaVastBtn.AlaaVastReadMoreBtn {\n' +
            '    bottom: 60px;\n' +
            '    cursor: pointer;\n' +
            '    left: 0;' +
            '    right: auto;' +
            '}' +
            '@media only screen and (max-width: '+reponsive.breakPoint+'px) {\n' +
            '    .AlaaVastBtn {\n' +
            '        bottom: 60px;\n' +
            '        right: auto;\n' +
            '        left: 0;\n' +
            '    }\n' +
            '    .AlaaVastBtn.AlaaVastReadMoreBtn {\n' +
            '        bottom: calc( 20% + 60px );\n' +
            '    }' +
            '}' +
            '</style>');
    }

    function initXml(player, address) {
        player.pause();
        addLoading(player);
        XMLService.getXml(address, function (xmlDoc) {
            init(player, [XMLService.xmlAdapter(xmlDoc)]);
            removeLoading(player);
        }, function () {
            removeLoading(player);
        });
    }

    return {
        init: init,
        initXml: initXml,
        adPlayers: []
    }
}();
