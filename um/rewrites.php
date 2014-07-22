<?php
defined('ABSPATH') or die('Huh?');
/*
if (get_option('permalink_structure') == '') {
 global $wp_rewrite;
 $wp_rewrite->set_permalink_structure('/%postname%/');
}
*/

function um_flush_rewrite_rules() { flush_rewrite_rules(); }
add_action( 'after_switch_theme', 'um_flush_rewrite_rules' );

function um_urlrewrite_is() {
	return array (
		0 => array (
			'tag' => str_replace(home_url()."/",'',plugins_url()."/um-plug/prop/"),
			'mod' => um_getoption('umplug')."/"
		),
		1 => array (
			'tag' => str_replace(home_url()."/",'',includes_url()),
			'mod' => um_getoption('wpinc')."/"
		),
		2 => array (
			'tag' => str_replace(home_url()."/",'',get_stylesheet_directory_uri()."/"),
			'mod' => um_getoption('style')."/"
		),
		3 => array (
			'tag' => str_replace(home_url()."/",'',get_template_directory_uri()."/"),
			'mod' => um_getoption('templ')."/"
		),
		4 => array (
			'tag' => str_replace(home_url()."/",'',plugins_url()."/"),
			'mod' => um_getoption('wplug')."/"
		),

	);
}

function um_rewrites() {
	global $wp_rewrite;
	$um_url = um_urlrewrite_is(); $count = count(array_keys($um_url));$n=0;
	$um_rwrule = array();
	for ($n; $n < $count; $n++) {
		$um_rwrule[ $um_url[$n]['mod'].'(.*)' ] = $um_url[$n]['tag']."$1";
	}
	
	$wp_rewrite->non_wp_rules=array_merge($wp_rewrite->non_wp_rules,$um_rwrule);

	if (!is_admin()) {
		add_filter('print_styles_array', 'um_short_styles', PHP_INT_MAX);
		add_filter('print_scripts_array', 'um_short_scripts', PHP_INT_MAX);
	}
}

function um_short_styles($handles) {
	global $wp_styles; $styles= array();
	$um_url = um_urlrewrite_is(); 
	foreach ($handles as $handle) {
		$src = $wp_styles->registered[$handle]->src; 
		if (preg_match("#".home_url()."#",$src)) { 	
			foreach (array_keys($um_url) as $n) {
				$src = str_replace($um_url[$n]['tag'] ,$um_url[$n]['mod'], $src); 
			}		
		}
		$wp_styles->registered[$handle]->src = $src;
	}

	return $handles;
}

function um_short_scripts($handles) {
	global $wp_scripts; $styles= array();
	$um_url = um_urlrewrite_is(); 
	foreach ($handles as $handle) {
		$src = $wp_scripts->registered[$handle]->src; 
		if (preg_match("#".home_url()."#",$src)) { 	
			foreach (array_keys($um_url) as $n) {
				$src = str_replace($um_url[$n]['tag'] ,$um_url[$n]['mod'], $src); 
			}		
		}
		$wp_scripts->registered[$handle]->src = $src;
	}
	return $handles;
}

if (get_option('permalink_structure')) {
	add_action('after_setup_theme','um_rewrites',PHP_INT_MAX);
}