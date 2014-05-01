<?php

/* ----------------------------------------------------------------------------------
 * Why I delete readme.html and license.txt?
 * because we meant to fix it :D
 *
 */
if (file_exists(ABSPATH."readme.html")) { unlink (ABSPATH."readme.html"); }
if (file_exists(ABSPATH."license.txt")) { unlink (ABSPATH."license.txt"); }

add_filter('admin_footer_text','um_footeradmin');

function um_i18n() { load_plugin_textdomain( 'um', false, 'lang' ); }
add_action( 'admin_init', 'um_i18n' );

require UMPLUG_DIR . 'um/um-touch.php';
require UMPLUG_DIR . 'um/um-chunks.php';

/* conditional, enable them using um-setup */

if (um_theme_dircheck("page-templates")) { require UMPLUG_DIR . 'um/um-addon.php'; }

if (function_exists('um_addon_setup')) { add_action('wp_enqueue_scripts','um_addon_setup'); }
if (file_exists(get_stylesheet_directory()."/favicon.ico")) { add_action('wp_head','um_favicon'); }

if ( (um_getoption('schcss','umt')) && (file_exists(get_stylesheet_directory()."/um-scheme.css")) ) {
	require UMPLUG_DIR . 'um/custom-scheme.php';
}

if ( file_exists(get_stylesheet_directory()."/layouts")) {
	require UMPLUG_DIR . 'um/custom-layout.php';
}

if (!is_admin()) {
	//remove duplicated script and styles, cause themes and plugins.
	$UM=array();$UM['css']=array();$UM['js']=array();
	add_filter('script_loader_src','um_script_unique');
	add_filter('style_loader_src','um_style_unique');
}

add_filter('user_contactmethods', 'um_user_contactmethods'); // echo get_user_meta(1, 'twitter', true);
