var InitPage = function () {

    var players = [];

    function loadVideos(videosId) {

        for (var i = 0; (typeof videosId[i] !== 'undefined'); i++) {
            var player = null;
            player = videojs(videosId[i], {language: 'fa'});
            player.nuevo({
                // logotitle:"آموزش مجازی آلاء",
                // logo:"https://sanatisharif.ir/image/11/135/67/logo-150x22_20180430222256.png",
                logocontrolbar: 'https://cdn.alaatv.com/upload/alaa-logo-small.png',
                // logoposition:"RT", // logo position (LT - top left, RT - top right)
                logourl:'//alaatv.com',

                // shareTitle: contentDisplayName,
                // shareUrl: contentUrl,
                // shareEmbed: '<iframe src="' + contentEmbedUrl + '" width="640" height="360" frameborder="0" allowfullscreen></iframe>',



                videoInfo: true,
                // infoSize: 18,
                // infoIcon: "https://sanatisharif.ir/image/11/150/150/favicon_32_20180819090313.png",


                relatedMenu: false,
                zoomMenu: true,
                // related: related_videos,
                mirrorButton: false,

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

            player.hotkeys({
                enableVolumeScroll: false,
                volumeStep: 0.1,
                seekStep: 5
            });

            player.pic2pic();
            player.on('play', function (data) {
                pauseAllPlayers(data.target.id)
            });

            players.push(player);
        }
    }

    function pauseAllPlayers(exceptPlayerId) {
        for (var i = 0; (typeof players[i] !== 'undefined'); i++) {
            if (typeof exceptPlayerId === 'undefined' || (typeof exceptPlayerId !== 'undefined' && exceptPlayerId !== players[i].id())) {
                players[i].pause();
            }
        }
    }

    function init(videosId) {
        loadVideos(videosId);
    }

    return {
        init: init
    }
}();

jQuery(document).ready( function() {
    InitPage.init(videosId);
});
