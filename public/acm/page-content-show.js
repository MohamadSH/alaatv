var SnippetContentShow = function(){
    var handlePlayerRelatedVideos = function (related_videos) {
        var contentId = $('#js-var-contentId').val();
        var contentUrl = $('#js-var-contentUrl').val();
        var contentEmbedUrl = $('#js-var-contentEmbedUrl').val();
        var contentDisplayName = $('#js-var-contentDName').val();
        var player = videojs('video-' + contentId, {nuevo: true}, function () {
            this.nuevoPlugin({
                // plugin options here
                logocontrolbar: '/acm/extra/Alaa-logo.gif',
                logourl: '//sanatisharif.ir',

                videoInfo: true,
                relatedMenu: true,
                zoomMenu: true,
                mirrorButton: true,
                related: related_videos,
                endAction: 'related',

                shareTitle: contentDisplayName,
                shareUrl: contentUrl,
                shareEmbed: '<iframe src="' + contentEmbedUrl + '" width="640" height="360" frameborder="0" allowfullscreen></iframe>'
            });
        });
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