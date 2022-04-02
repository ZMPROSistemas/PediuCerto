

let scroll = new SmoothScroll('a[href*="#"]', {
    
    header: '[data-scroll-header]',
    
    topOnEmptyHash: true,
    speed: 300,
    speedAsDuration: true,
  
    updateURL: true, 
    popstate: true,
   

});

scroll.destroy();

function mascaraCelular(o,f){
  v_obj=o
  v_fun=f
  setTimeout("execmascaraCelular()",1)
}
function execmascaraCelular(){
  v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
  v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
  v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
  v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
  return v;
}

function onlynumber(evt) {
   var theEvent = evt || window.event;
   var key = theEvent.keyCode || theEvent.which;
   key = String.fromCharCode( key );
   //var regex = /^[0-9.,]+$/;
   var regex = /^[0-9.]+$/;
   if( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
   }
}