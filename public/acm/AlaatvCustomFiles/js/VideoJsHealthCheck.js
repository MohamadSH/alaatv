var VideoJsHealthCheck = function () {

    var checkInterval = 1, // seconds
        error = null,
        errorCounter = 0,
        lastPlayedTime = 0,
        readyStateOneDuration = 0,
        readyStateTwoDuration = 0;

    function play(player) {
        readyStateOneDuration = 0;
        readyStateTwoDuration = 0;

        player.load();

        player.currentTime(lastPlayedTime);
        var promise = player.play();
        if (promise !== undefined) {
            promise.then(function () {
                // Autoplay started!
                player.currentTime(lastPlayedTime);
                player.play();
            }).catch(function (error) {
                // Autoplay was prevented
                //... Code that shows big play button
            });
        }
        else {
            //... Code that shows big play button
        }
    }

    function waiting(player) {
        player.pause();
        player.addClass('vjs-waiting');
        player.trigger('waiting');
        player.one('timeupdate', function () {
            player.removeClass('vjs-waiting');
        });
    }

    function check(player) {

        error = player.error();
        if (error) {
            errorCounter++;
            $(player.el()).find('.vjs-grid').addClass('vjs-hidden');
        }

        if ((lastPlayedTime === 0 || player.currentTime() !== 0) && player.currentTime() !== player.duration()) {
            lastPlayedTime = player.currentTime();
        }


        if (error && errorCounter < 10) {
            waiting(player);
        } else if (errorCounter > 0 && player.paused()) {
            play(player);
        } else if(error && errorCounter > 0) {
            errorCounter = 0;
        }
    }

    function handle(player) {

        var checkHealthInterval = null;

        player.on('error', function () {
            checkHealthInterval = setInterval(function() {
                check(player);
            }, checkInterval * 1000);
        });

        player.on('timeupdate', function () {
            errorCounter = 0;
        });

        player.on('seeking', function (event) {
            lastPlayedTime = player.currentTime();
        });

    }

    return {
        handle: handle
    };
}();
