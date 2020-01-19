var Firebase = function () {

    // Retrieve Firebase Messaging object.
    var messaging,
        firebaseConfig,
        VapidKey,
        showMessageCallback,
        sendTokenToServerCallback,
        updateUIForPushEnabledCallback,
        updateUIForPushPermissionRequiredCallback,
        ConsoleReport = true;

    function setPublicVapidKey(VapidKey) {
        // Add the public key generated from the console here.
        messaging.usePublicVapidKey(VapidKey);
    }

    function addEvents() {
        // Callback fired if Instance ID token is updated.
        messaging.onTokenRefresh(function() {
            messaging.getToken().then(function(refreshedToken) {
                if (ConsoleReport) {
                    console.log('Token refreshed.');
                }
                // Indicate that the new Instance ID token has not yet been sent to the
                // app server.
                setTokenSentToServer(false);
                // Send Instance ID token to app server.
                sendTokenToServer(sendTokenToServerCallback, refreshedToken);
                // Display new Instance ID token and clear UI of all previous messages.
                getToken();
            }).catch(function(err) {
                if (ConsoleReport) {
                    console.log('Unable to retrieve refreshed token ', err);
                }
            });
        });

        // Handle incoming messages. Called when:
        // - a message is received while the app has focus
        // - the user clicks on an app notification created by a service worker
        //   `messaging.setBackgroundMessageHandler` handler.
        messaging.onMessage(function(payload) {
            if (ConsoleReport) {
                console.log('Message received. ', payload);
            }
            // Update the UI to include the received message.
            showMessageCallback(payload);
        });
    }

    function getToken() {
        // Get Instance ID token. Initially this makes a network call, once retrieved
        // subsequent calls to getToken will return from cache.
        messaging.getToken().then(function(currentToken) {
            if (currentToken) {
                sendTokenToServer(sendTokenToServerCallback, currentToken);
                updateUIForPushEnabledCallback(currentToken);
            } else {
                if (ConsoleReport) {
                    console.log('No Instance ID token available. Request permission to generate one.');
                }
                // Show permission request.
                // Show permission UI.
                updateUIForPushPermissionRequiredCallback();
                setTokenSentToServer(false);
            }
        }).catch(function(err) {
            if (ConsoleReport) {
                console.log('An error occurred while retrieving token. ', err);
            }
            setTokenSentToServer(false);
        });
    }

    function isTokenSentToServer() {
        return window.localStorage.getItem('sentToServer') === '1';
    }

    function setTokenSentToServer(sent) {
        window.localStorage.setItem('sentToServer', sent ? '1' : '0');
    }

    // Send the Instance ID token your application server, so that it can:
    // - send messages back to this app
    // - subscribe/unsubscribe the token from topics
    function sendTokenToServer(sendTokenToServerCallback, currentToken) {
        if (!isTokenSentToServer()) {

            if (ConsoleReport) {
                console.log('Sending token to server...');
                console.log('currentToken: ', currentToken);
            }

            sendTokenToServerCallback(currentToken);
            setTokenSentToServer(true);
        } else {

            if (ConsoleReport) {
                console.log('currentToken: ', currentToken);
                console.log('Token already sent to server so won\'t send it again ' +
                    'unless it changes');
            }
        }

    }

    function deleteToken(data) {
        initVars(data);
        // Delete Instance ID token.
        messaging.getToken().then(function(currentToken) {
            messaging.deleteToken(currentToken).then(function() {
                if (ConsoleReport) {
                    console.log('Token deleted.');
                }
                setTokenSentToServer(false);
                // Once token is deleted update UI.
                getToken();
            }).catch(function(err) {
                if (ConsoleReport) {
                    console.log('Unable to delete token. ', err);
                }
            });
        }).catch(function(err) {
            if (ConsoleReport) {
                console.log('Error retrieving Instance ID token. ', err);
            }
        });
    }

    function requestPermission(data) {
        initVars(data);

        if (ConsoleReport) {
            console.log('Requesting permission...');
        }
        Notification.requestPermission().then(function() {
            if (ConsoleReport) {
                console.log('Notification permission granted.');
            }
            // TODO(developer): Retrieve an Instance ID token for use with FCM.
            // In many cases once an app has been granted notification permission, it
            // should update its UI reflecting this.
            getToken();
        }).catch(function(err) {
            if (ConsoleReport) {
                console.log('Unable to get permission to notify.', err);
            }
        });
    }

    function initFirebaseConfigAndVapidKey(data) {
        firebaseConfig = (typeof data.firebaseConfig !== 'undefined') ? data.firebaseConfig : {};
        VapidKey = (typeof data.VapidKey !== 'undefined') ? data.VapidKey : '';
    }

    function initCallbacks(data) {
        showMessageCallback = (typeof data.showMessage !== 'undefined') ? data.showMessage : defaultShowMessage;
        sendTokenToServerCallback = (typeof data.sendTokenToServer !== 'undefined') ? data.sendTokenToServer : defaultsendTokenToServer;
        updateUIForPushEnabledCallback = (typeof data.updateUIForPushEnabled !== 'undefined') ? data.updateUIForPushEnabled : defaultUpdateUIForPushEnabled;
        updateUIForPushPermissionRequiredCallback = (typeof data.updateUIForPushPermissionRequired !== 'undefined') ? data.updateUIForPushPermissionRequired : defaultUpdateUIForPushPermissionRequired;
    }

    function initFirebaseObjects(data) {
        if (typeof data.messaging !== 'undefined') {
            messaging = data.messaging;
        }
    }

    function initVars(data) {
        initFirebaseConfigAndVapidKey(data);
        initCallbacks(data);
        initFirebaseObjects(data);
        if (typeof data.ConsoleReport !== 'undefined') {
            ConsoleReport = data.ConsoleReport;
        }
    }

    function init(data) {
        initVars(data);
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        messaging = firebase.messaging();
        setPublicVapidKey(VapidKey);
        addEvents();
        getToken();
        return {
            messaging: messaging
        };
    }

    function defaultShowMessage(payload) {

    }

    function defaultsendTokenToServer(currentToken) {

    }

    function defaultUpdateUIForPushEnabled(currentToken) {
        // showHideDiv(tokenDivId, true);
        // showHideDiv(permissionDivId, false);
    }

    function defaultUpdateUIForPushPermissionRequired() {
        // showHideDiv(tokenDivId, false);
        // showHideDiv(permissionDivId, true);
    }


    return {
        init: init,
        requestPermission: requestPermission,
        deleteToken: deleteToken,
    };
}();
