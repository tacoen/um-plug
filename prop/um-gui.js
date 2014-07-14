/* 

	UM-GUI-JS 
	---------
	
	https://github.com/tacoen/um-plug/wiki/UM-GUI-JS 

	um_onscroll_fixed($('.single-post .entry-header'),$('.main-navigation'),0,200);
	um_onscroll_fixed($('aside#meta'),$('#um-top'),48,$('.site-side').outerHeight());
	um_tab($('div.maketab'));
	um_toc($('div.maketoc'),'h4',"Table of Contents")

*/

var window_height = jQuery(window).innerHeight();

function um_fx_init() {
	var cl=  um_getrgbof($('.site-footer'),'background-color','.2')
	$('.widget-area aside').css('background-color',cl);
	$('.widget-area aside h1').css('background-color',cl);

	um_content_height(jQuery('#content'), window_height );
	um_msg();
	um_vpToBody();
	umi_navhover_click();
	$('#um-top').click( function(e) { jQuery(window).scrollTop(0); } )
	
}

(function($) {

$(document).ready(function(){

	um_fx_init();
	um_onscroll_fixed($('#um-top'),$('#site-navigation'),0);

});

jQuery(window).on('resize', function(){
	um_fx_init();
	um_onscroll_fixed($('#um-top'),$('#site-navigation'),0);

});

})( jQuery );