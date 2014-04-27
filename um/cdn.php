<?php

defined('ABSPATH') or die('Huh?');

add_action('wp_enqueue_scripts','um_register_cdn_scripts');
add_action('wp_enqueue_scripts','um_register_cdn_styles');
add_action('admin_print_styles','um_register_cdn_styles');
add_action('login_enqueue_scripts','um_register_cdn_styles'); //not working?
add_action('customize_controls_print_styles','um_register_cdn_styles');
// if you copies the stucture of google cdn
add_action('after_setup_theme','cdn_takeover');


function um_register_cdn_styles() {
/* > Replace wp-includes styles link with your CDN,watch the ID
*/
$cdn = um_getoption('opsfcdn');
if ($cdn!='') {
wp_deregister_style('open-sans');
wp_register_style('open-sans',$cdn,false,'3.8.1','all');
wp_enqueue_style('open-sans');
}
}

function um_register_cdn_scripts() {
/* > Replace wp-includes scripts link with your CDN,watch the ID
*/
$cdn = um_getoption('jqcdn');
if ($cdn=='') { $cdn = um_rwvar_default('jqcdn'); }
wp_deregister_script('jquery');
wp_register_script('jquery',$cdn,false,'2.0.3');
wp_enqueue_script('jquery');
}

function cdn_takeover() {
if ( (!is_admin()) && (um_getoption('qamirr')!='') ) {
add_filter('script_loader_src','cdn_replace');
add_filter('style_loader_src','cdn_replace');
}
}

function cdn_replace($a) {
/* > Replace all ajax.googleapis.com with your own cdn ($mycdn) as googleapis mirror
*/
$cdn = um_getoption('qamirr');
if (preg_match("#ajax\.googleapis\.com#",$a)) { return str_replace("ajax.googleapis.com",$cdn,$a);}
else { return $a; }
}
?>