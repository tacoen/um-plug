<?php
defined('ABSPATH') or die('Huh?');

// Uncomment line below to use cdn.php
// if (um_getoption('owncdn')) { um_cdn_registration(); }

function um_cdn_registration() {
 	add_action('wp_enqueue_scripts','um_register_cdn_scripts');
	add_action('wp_enqueue_scripts','um_register_cdn_styles');
	add_action('admin_print_styles','um_register_cdn_styles');
	add_action('login_enqueue_scripts','um_register_cdn_styles'); //not working?
	add_action('customize_controls_print_styles','um_register_cdn_styles');
	// if you copies the stucture of google cdn
	add_action('after_setup_theme','cdn_takeover');
}

/* there is no options for this in wp-admin, you might need to edit it manually */

function um_register_cdn_styles() {
	/* > Replace wp-includes styles link with your CDN,watch the ID
	 */
	wp_deregister_style('open-sans');
	wp_register_style('open-sans',"YOUROWN_CDN_URL.ORG/font/opensans/style.css",false,'3.8.1','all');
	wp_enqueue_style('open-sans');
}
function um_register_cdn_scripts() {
	/* > Replace wp-includes scripts link with your CDN,watch the ID
	 */
	wp_deregister_script('jquery');
	wp_register_script('jquery',"YOUROWN_CDN_URL.ORG/jquery/jquery-latest.js",false,'2.0.3');
	wp_enqueue_script('jquery');
}
function cdn_takeover() {
	if (!is_admin()) {
		add_filter('script_loader_src','cdn_replace');
		add_filter('style_loader_src','cdn_replace');		
	}
}
function cdn_replace($a) { 
	$mycdn = "YOUROWN_CDN_URL.ORG";
	if (preg_match("#ajax\.googleapis\.com#",$a)) { return str_replace("ajax.googleapis.com",$mycdn,$a);} 
	else { return $a; }	
}