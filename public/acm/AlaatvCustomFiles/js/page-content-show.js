var SnippetContentShow = function(){
    var handlePlayerRelatedVideos = function (related_videos) {
        var contentId = $('#js-var-contentId').val();
        var contentUrl = $('#js-var-contentUrl').val();
        var contentEmbedUrl = $('#js-var-contentEmbedUrl').val();
        var contentDisplayName = $('#js-var-contentDName').val();

        var player = videojs('video-' + contentId, {language: 'fa'});
        player.nuevo({
            // logotitle:"آموزش مجازی آلاء",
            // logo:"https://sanatisharif.ir/image/11/135/67/logo-150x22_20180430222256.png",
            logocontrolbar: '/acm/extra/Alaa-logo.gif',
            // logoposition:"RT", // logo position (LT - top left, RT - top right)
            logourl:'//sanatisharif.ir',

            shareTitle: contentDisplayName,
            shareUrl: contentUrl,
            shareEmbed: '<iframe src="' + contentEmbedUrl + '" width="640" height="360" frameborder="0" allowfullscreen></iframe>',



            videoInfo: true,
            // infoSize: 18,
            // infoIcon: "https://sanatisharif.ir/image/11/150/150/favicon_32_20180819090313.png",


            relatedMenu: true,
            zoomMenu: true,
            related: related_videos,
            mirrorButton: true,

            closeallow:true,
            mute:true,
            rateMenu:true,
            resume:true, // (false) enable/disable resume option to start video playback from last time position it was left
            // theaterButton: true,
            timetooltip: true,
            mousedisplay: false,
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
        //
        // var player = videojs('video-' + contentId, {nuevo: true}, function () {
        //     this.nuevoPlugin({
        //         // plugin options here
        //         logocontrolbar: '/acm/extra/Alaa-logo.gif',
        //         logourl: '//sanatisharif.ir',
        //
        //         videoInfo: true,
        //         relatedMenu: true,
        //         zoomMenu: true,
        //         mirrorButton: true,
        //         related: related_videos,
        //         endAction: 'related',
        //
        //         shareTitle: contentDisplayName,
        //         shareUrl: contentUrl,
        //         shareEmbed: '<iframe src="' + contentEmbedUrl + '" width="640" height="360" frameborder="0" allowfullscreen></iframe>'
        //     });
        // });
        player.on('resolutionchange', function () {
            var last_resolution = param.label;
            console.log(last_resolution);
        });
    };
    var handleVideoPlayListScroll = function () {
        var contentId = $('#js-var-contentId').val();
        var container = $("#playListScroller"),
            scrollTo = $("#playlistItem_" + contentId);
        container.scrollTop(scrollTo.offset().top - 400);
    };
    return {
      init: function (related_videos) {
          handleVideoPlayListScroll();
          handlePlayerRelatedVideos(related_videos);
      }
    };
}();
jQuery(document).ready( function() {
    SnippetContentShow.init(related_videos);
});