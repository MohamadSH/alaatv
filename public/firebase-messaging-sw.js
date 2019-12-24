// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
    apiKey: "AIzaSyBMSKsBzEFtfBHkudjHuLr9brCuRUJQYX4",
    authDomain: "alaa-office.firebaseapp.com",
    databaseURL: "https://alaa-office.firebaseio.com",
    projectId: "alaa-office",
    storageBucket: "alaa-office.appspot.com",
    messagingSenderId: "300754869233",
    appId: "1:300754869233:web:c730b68385257132ed8250",
    measurementId: "G-V614DM1FRK"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

// navigator.serviceWorker.register('https://alaatv.test/firebase-messaging-sw.js').then((registration) => {
//     messaging.useServiceWorker(registration);
//
//     // Request permission and get token.....
// });

// Handle incoming messages. Called when:
// - a message is received while the app has focus
// - the user clicks on an app notification created by a service worker
//   `messaging.setBackgroundMessageHandler` handler.
messaging.onMessage((payload) => {
    console.log('Message received. ', payload);
    // ...
});

messaging.getToken().then((currentToken) => {
    if (currentToken) {
        console.log(currentToken);
        // sendTokenToServer(currentToken);
        // updateUIForPushEnabled(currentToken);
    } else {
        // Show permission request.
        console.log('No Instance ID token available. Request permission to generate one.');
        // Show permission UI.
        // updateUIForPushPermissionRequired();
        // setTokenSentToServer(false);
    }
}).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
    // showToken('Error retrieving Instance ID token. ', err);
    // setTokenSentToServer(false);
});

// const firebaseConfig = {
//     apiKey: "AIzaSyBMSKsBzEFtfBHkudjHuLr9brCuRUJQYX4",
//     authDomain: "alaa-office.firebaseapp.com",
//     databaseURL: "https://alaa-office.firebaseio.com",
//     projectId: "alaa-office",
//     storageBucket: "alaa-office.appspot.com",
//     messagingSenderId: "300754869233",
//     appId: "1:300754869233:web:c730b68385257132ed8250",
//     measurementId: "G-V614DM1FRK"
// };
//
// // Initialize Firebase
// firebase.initializeApp(firebaseConfig);
// // Retrieve Firebase Messaging object.
// const messaging = firebase.messaging();
// // Add the public key generated from the console here.
// messaging.usePublicVapidKey("BKagOny0KF_2pCJQ3m....moL0ewzQ8rZu");
//
// Notification.requestPermission().then((permission) => {
//     if (permission === 'granted') {
//         console.log('Notification permission granted.---------------------------------------');
//         // TODO(developer): Retrieve an Instance ID token for use with FCM.
//         // ...
//     } else {
//         console.log('Unable to get permission to notify.---------------------------------------');
//     }
// });
//
// // Get Instance ID token. Initially this makes a network call, once retrieved
// // subsequent calls to getToken will return from cache.
// messaging.getToken().then((currentToken) => {
//     if (currentToken) {
//         console.log('===>sendTokenToServer(currentToken);');
//         console.log('===>updateUIForPushEnabled(currentToken);');
//     } else {
//         // Show permission request.
//         console.log('No Instance ID token available. Request permission to generate one.');
//         // Show permission UI.
//         console.log('===>updateUIForPushPermissionRequired();');
//         console.log('===>setTokenSentToServer(false);');
//     }
// }).catch((err) => {
//     console.log('An error occurred while retrieving token. ', err);
//     console.log('===>showToken("Error retrieving Instance ID token. ", err);');
//     console.log('===>setTokenSentToServer(false);');
// });
//
// // Callback fired if Instance ID token is updated.
// messaging.onTokenRefresh(() => {
//     messaging.getToken().then((refreshedToken) => {
//         console.log('Token refreshed.');
//         // Indicate that the new Instance ID token has not yet been sent to the
//         // app server.
//         console.log('===>setTokenSentToServer(false);');
//         // Send Instance ID token to app server.
//         console.log('===>sendTokenToServer(refreshedToken);');
//         // ...
//     }).catch((err) => {
//         console.log('Unable to retrieve refreshed token ', err);
//         console.log('===>showToken("Unable to retrieve refreshed token ", err);');
//     });
// });

