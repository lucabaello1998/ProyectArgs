const messaging =firebase.messaging();

window.onload=function(){
  pedirPermiso();

  let enableForegroundNotification=true;
  messaging.onMessage(function(payload){
    if(enableForegroundNotification){
      const title = JSON.parse(payload.data.notification).title;
      const noti = {
        body: JSON.parse(payload.data.notification).body,
        icon: '/images/icon_noti.png',
        badge: '/images/badge.png',
        data: {
          link: JSON.parse(payload.data.notification).link
        },
      };
        navigator.serviceWorker.getRegistrations().then( registration =>{
        registration[0].showNotification(title, noti);
      });
      
    }
  });

  self.addEventListener('notificationclick', e => {
    const notification = e.notification;
    const action = e.action;
    if (action === 'close') {
      notification.close();
    } else if (notification.data) {
      clients.openWindow(notification.data.link); ///URL RUTA DEL SITIO
      notification.close();
    }
  });

  function pedirPermiso(){
    messaging.requestPermission()
    .then(function(){
      console.log("Se han haceptado las notificaciones");
      return messaging.getToken();
    }).then(function(token){
      guardarToken(token);
    }).catch(function(err){
      console.log('No se ha recibido el permiso'+err);
    });
  }
  function guardarToken(token){
    $.post('/Guardar/guardarToken.php', {
      "firebase": token,
    },function(data) {
      console.log('Token guardado', data);
  })
  .catch( e=>{
    console.log('Token no guardado');
    console.log(e);
  });
  }


  

  self.addEventListener('push', e => {
  const options = {
      body: 'body',
      icon: '/images/icon_noti.png',
      badge: '/images/badge.png',
      vibrate: [100, 50, 100, 100, 50, 100, 100, 50, 100, 100, 50, 100],
      data: {
          link: 'https://argentseal.online'
      },
      actions: [
          {action: 'explore', title: 'Ir al sitio',
              icon: '/images/pwa/check.png'},
          {action: 'close', title: 'Cerrar la notificación',
              icon: '/images/pwa/xmark.png'}
      ]
  };

  e.waitUntil(
      self.registration.showNotification('Argent', options)
    );
  });
}