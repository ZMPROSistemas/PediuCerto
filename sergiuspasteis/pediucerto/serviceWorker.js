  if ('serviceWorker' in navigator && 'PushManager' in window) {
    console.log('Service Worker and Push is supported');
    navigator.serviceWorker.register('https://zmsys.com.br/sergiuspasteis/pediucerto/sw.js')
      .then(function(swReg){
        console.log('Service Worker is registered');
      }).catch(function(err) {
        console.error('Service Worker Error');
      });
  }else{
    console.warn('Push messaging is not supported');
  }
