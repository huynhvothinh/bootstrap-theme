jQuery(document).ready(function(){ 
    jQuery(window).scroll(function(){ 
        var body = jQuery('#body');
        var scroll = jQuery(window).scrollTop();
        var height = jQuery('#header').height();
        var menuHeight = jQuery('#header .lw-menu').height();

        if (scroll >= height){
            jQuery(body).addClass('fixed');
            jQuery(body).css('padding-top', menuHeight + 'px');
        }else{
            jQuery(body).removeClass('fixed');
            jQuery(body).css('padding-top', '');
        }
    });
});