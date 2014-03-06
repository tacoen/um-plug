<?php
/**
 * @package um
 */

add_action('wp_enqueue_scripts','um_register_cdn_scripts');
add_action('wp_enqueue_scripts','um_register_cdn_styles');
add_action('admin_print_styles','um_register_cdn_styles');
add_action('login_enqueue_scripts','um_register_cdn_styles'); //not working
add_action('customize_controls_print_styles','um_register_cdn_styles');

function um_register_cdn_styles() {

	/* > Replace wp-includes styles link with your CDN,watch the ID
	 */
	wp_deregister_style('open-sans');
	wp_register_style('open-sans',"http://cdn.dibiakcom.net/font/opensans/style.css",false,'3.8.1','all');
	wp_enqueue_style('open-sans');
}



function um_register_cdn_scripts() {

	/* > Replace wp-includes scripts link with your CDN,watch the ID
	 */

	wp_deregister_script('jquery');
	wp_register_script('jquery',"http://cdn.dibiakcom.net/jquery/jquery-latest.js",false,'2.0.3');
	wp_enqueue_script('jquery');

}

