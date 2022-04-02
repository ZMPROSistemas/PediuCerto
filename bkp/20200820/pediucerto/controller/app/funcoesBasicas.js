

let scroll = new SmoothScroll('a[href*="#"]', {
    
    ignore: '[data-scroll-header]',
    header: null, 
    topOnEmptyHash: true,
    speed: 300,
    speedAsDuration: true,
  
    updateURL: true, 
    popstate: true,
   

});
scroll.animateScroll(750);
scroll.destroy();