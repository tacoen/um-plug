(function($) {

var window_height = $(window).innerHeight();

$(document).ready(function(){

	um_content_height($('#content'), window_height );
	um_fx_init();

	um_onscroll_fixed($('#um-top'),$('.site-navigation'),32);

/*
	um_onscroll_fixed($('.single-post .entry-header'),$('.main-navigation'),0,$('.site-header').outerHeight());
	um_onscroll_fixed($('aside#meta'),$('#um-top'),48,$('.site-side').outerHeight());
	um_tab($('div.maketab'));
	um_toc($('div.maketoc'),'h4',"Table of Contents")
*/

});

$(window).on('resize', function(){

	um_content_height($('#content'), window_height );

});

})(jQuery);