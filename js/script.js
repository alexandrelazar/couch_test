var h_hght = 150; // высота шапки
var h_mrg = 0;    // отступ когда шапка уже не видна

                 
$(function(){
 
    var nav = $('.top-nav');
    var media = $('.media-container');
    var top = $(this).scrollTop();
     
   	if(top > h_hght){
   		nav.css('top', h_mrg);
    }           
     
    $(window).scroll(function(){
        top = $(this).scrollTop();
         
        if (top+h_mrg < h_hght) {
        	nav.css('top', (h_hght-top));
       	} else {
         	nav.css('top', h_mrg);
            media.css('top', (top-h_hght) / 2);
        }
   	});
 
});

