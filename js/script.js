var h_hght = 150; // высота шапки
var mc_hght = 200;
var h_mrg = 0;    // отступ когда шапка уже не видна
var mc_mrg = 50;
                 
$(function(){
 
    var nav = $('.top-nav');
    var media = $('.media-container');
    var top = $(this).scrollTop();
    var bottom = $(window).scrollTop() + $(window).height();
    var footer_top = $(document).outerHeight(true) - 310;

   	if(top > h_hght){
   		nav.css('top', h_mrg);
    }           
     
    $(window).scroll(function(){
        top = $(this).scrollTop();
        bottom = top + $(window).height();
        if (top + h_mrg < h_hght) {
        	nav.css('top', (h_hght-top));
       	} else {
         	nav.css('top', h_mrg);
        }

        if (top + mc_mrg < mc_hght) {
          media.css('top', (mc_hght-top));
        } else {
          if(bottom < footer_top){
            media.css('top', mc_mrg);
          }else{
            media.css('top', mc_mrg - (bottom - footer_top));
          }
        }
   	});
 
});

