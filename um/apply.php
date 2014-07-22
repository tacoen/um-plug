<?php

/* intergrating um themes */

if (file_exists(get_stylesheet_directory().'/no-umplug.txt')) { um_instant(); 	}

/* features */

require UMPLUG_DIR . 'um/um-touch.php';
require UMPLUG_DIR . 'um/um-chunks.php';

/* conditional, enable them using um-setup */

if (um_theme_dircheck("page-templates")) { require UMPLUG_DIR . 'um/um-addon.php'; }

if (function_exists('um_addon_setup')) { add_action('wp_enqueue_scripts','um_addon_setup'); }
if (file_exists(get_stylesheet_directory()."/favicon.ico")) { add_action('wp_head','um_favicon'); }

if ( (um_getoption('schcss','umt')) && (file_exists(get_stylesheet_directory()."/um-scheme.css")) ) {
	require UMPLUG_DIR . 'um/custom-scheme.php';
}

function new_excerpt_length($length) { 
 if (um_getoption('exclen','umo')) { return um_getoption('exclen','umo'); } else { return $length; }
}

add_filter('excerpt_length', 'new_excerpt_length');

if ( (!is_admin()) && (um_getoption('novers','umo')) ) {
	//remove duplicated script and styles, cause themes and plugins.
	add_filter('script_loader_src','um_script_nover');
	add_filter('style_loader_src','um_style_nover');
}

add_filter('user_contactmethods', 'um_user_contactmethods'); // echo get_user_meta(1, 'twitter', true);

if (um_getoption('wpzlib','umo')) {
	if(extension_loaded("zlib") && (ini_get("output_handler") != "ob_gzhandler")) {
		add_action('wp', create_function('', '@ob_end_clean();@ini_set("zlib.output_compression", 1);'));
	}
}

if (um_getoption('nofeed','umo')) {
	add_action('do_feed', 'um_disable_feed', 1);
	add_action('do_feed_rdf', 'um_disable_feed', 1);
	add_action('do_feed_rss', 'um_disable_feed', 1);
	add_action('do_feed_rss2', 'um_disable_feed', 1);
	add_action('do_feed_atom', 'um_disable_feed', 1);
	add_action('do_feed_rss2_comments', 'um_disable_feed', 1);
	add_action('do_feed_atom_comments', 'um_disable_feed', 1);
}

if (um_getoption('noxmlrpc','umo')) {
	add_filter( 'xmlrpc_enabled', '__return_false' );
}

if (um_getoption('logincss')) {
	add_action( 'login_enqueue_scripts', 'um_login_css' );
}

add_action('admin_menu', 'um_hp_init');

/* ----------------------------------------------------------------------------------
 * Why I delete readme.html and license.txt?
 * because we meant to fix it :D
 *
 */

if (file_exists(ABSPATH."readme.html")) { unlink (ABSPATH."readme.html"); }
if (file_exists(ABSPATH."license.txt")) { unlink (ABSPATH."license.txt"); }

if (um_getoption('nowpabar')) { 
    // show_admin_bar(false); 
    add_filter('show_admin_bar','__return_false');
    }
if (um_getoption('wdtma')) { add_action('widgets_init','um_elwidgets_init'); }
if (um_getoption('nowphead')) { add_action('after_setup_theme' ,'um_wpheadtrim'); }
if (um_getoption('nodash')) { add_action('wp_dashboard_setup','um_nodashboard_widgets'); }
if (um_getoption('pback')) { add_action('wp_head','um_pingback'); }

if (um_getoption('noavatar')) { 
    add_filter('get_avatar', 'um_remove_gravatar', 1, 5); 
}
if (um_getoption('noautosave')) {  add_action( 'admin_init', 'um_disableAutoSave' ); }
