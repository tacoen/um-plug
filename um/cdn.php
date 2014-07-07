<?php

defined('ABSPATH') or die('Huh?');

add_action('wp_enqueue_scripts','um_register_cdn_scripts');
add_action('wp_enqueue_scripts','um_register_cdn_styles');
add_action('admin_print_styles','um_register_cdn_styles');
add_action('login_enqueue_scripts','um_register_cdn_styles'); //not working?
add_action('customize_controls_print_styles','um_register_cdn_styles');

if (!is_admin()) {
	add_action('after_setup_theme','cdn_takeover');
}

function um_register_cdn_styles() {

	// Replace wp-includes styles link with your CDN,watch the ID

	$cdn = um_getoption('opsfcdn');
	if ( (isset($cdn)) && (!empty($cdn)) ) {
		wp_deregister_style('open-sans');
		wp_register_style('open-sans',$cdn,false,false);
		wp_enqueue_style('open-sans');
	}
}

function um_register_cdn_scripts() {

	// Replace wp-includes scripts link with your CDN,watch the ID
	$cdn = um_getoption('jqcdn');
	if ( (isset($cdn)) && (!empty($cdn)) ) {
		wp_deregister_script('jquery');
		wp_register_script('jquery',$cdn,false,'2.0.3');
		wp_enqueue_script('jquery');
	}
}

function cdn_takeover() {

	$cdn = um_getoption('gamirr');
	if ( (isset($cdn)) && (!empty($cdn)) ) {
		add_filter('script_loader_src','cdn_replace');
		add_filter('style_loader_src','cdn_replace');
	}
}

function cdn_replace($a) {
	// Replace all ajax.googleapis.com with your own cdn ($mycdn) as googleapis mirror
	$cdn = um_getoption('gamirr');
	if (preg_match("#ajax\.googleapis\.com#",$a)) { return str_replace("ajax.googleapis.com",$cdn,$a);}
	else { return $a; }
}

?>