
  if ('serviceWorker' in navigator && 'PushManager' in window) {
    console.log('Service Worker and Push is supported');
    navigator.serviceWorker.register('https://zmsys.com.br/pediucerto/empresas/15/sw.js')
      .then(function(swReg){
        //console.log('Service Worker is registered', swReg);
        console.log('Service Worker is registered');
        //swRegistration = swReg;
      }).catch(function(err) {
        //console.error('Service Worker Error', err);
        console.error('Service Worker Error');
      });
  }else{
    console.warn('Push messaging is not supported');
    //pushButton.textContent = 'Push Not Supported';
  }