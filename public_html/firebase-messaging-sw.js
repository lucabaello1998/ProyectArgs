// This is the "Offline copy of assets" service worker

const CACHE = "Argentseal-offline";
const QUEUE_NAME = "bgSyncQueue";

importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.1.2/workbox-sw.js');

self.addEventListener("message", (event) => {
  if (event.data && event.data.type === "SKIP_WAITING") {
    self.skipWaiting();
  }
});

const bgSyncPlugin = new workbox.backgroundSync.BackgroundSyncPlugin(QUEUE_NAME, {
  maxRetentionTime: 24 * 60 // Retry for max of 24 Hours (specified in minutes)
});

workbox.routing.registerRoute(
  new RegExp('/*'),
  new workbox.strategies.NetworkFirst({
    cacheName: CACHE,
    plugins: [
      bgSyncPlugin
    ]
  })
);

importScripts('https://www.gstatic.com/firebasejs/8.4.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.4.1/firebase-messaging.js');

// Firebase confing
var firebaseConfig = {
  apiKey: "AIzaSyAIqpfF6mAf-uCHz61-cUx5IArZ96k5W4Y",
  authDomain: "argentseal-49a9e.firebaseapp.com",
  projectId: "argentseal-49a9e",
  storageBucket: "argentseal-49a9e.appspot.com",
  messagingSenderId: "757909991303",
  appId: "1:757909991303:web:2f8895fb99294fb4f6ed22",
  measurementId: "G-QTVR370KQT"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
messaging.onBackgroundMessage(function(payload)
{
  const notificationTitle = JSON.parse(payload.data.notification).title;
  const notificationOptions = {
    body: JSON.parse(payload.data.notification).body,
    icon: './images/icon_noti.png',
    badge: './images/badge.png',
    data: {
            link: JSON.parse(payload.data.notification).link
          }
    }
    self.registration.showNotification(notificationTitle, notificationOptions);
});




self.addEventListener('notificationclick', e => {
  const notification = e.notification;
  const action = e.action;
  if (action === 'close')
  {
    notification.close();
  } else if (notification.data)
  {
    const primaryKey = notification.data.link;
    clients.openWindow(primaryKey); ///URL RUTA DEL SITIO
    notification.close();
  }
});
