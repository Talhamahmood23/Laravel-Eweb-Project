/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    apiKey: "AIz-------------------tGc",
    authDomain: "eca----------------.com",
    projectId: "ec----------ev",
    storageBucket: "ecar---------------.com",
    messagingSenderId: "29-----------7",
    appId: "1:29--------------------87c",
    measurementId: "G---------8B"
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
  console.log(
    "[firebase-messaging-sw.js] Received background message111 ",
    payload,
  );

        const string = payload.data.data;

var obj = jQuery.parseJSON( payload.data.data );

        const noteTitle = obj.title;
  /* Customize notification here */
  const notificationTitle =obj.title;
  const notificationOptions = {
            body: obj.message,
            icon: obj.image,
            data:{
            time: new Date(Date.now()).toString(),
            click_action: ""
        }

        };

  return self.registration.showNotification(
    notificationTitle,
    notificationOptions,
  );
});
self.addEventListener('notificationclick', function(event) {

   var action_click=event.notification.data.click_action;
  event.notification.close();

  event.waitUntil(
    clients.openWindow(action_click)
  );
});
