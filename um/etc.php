<?php
defined('ABSPATH') or die('Huh?');
function none() {} //stupid solution!
if (um_getoption('nodash')) { add_action('wp_dashboard_setup','um_nodashboard_widgets'); }
if (um_getoption('nowphead')) { add_action('after_setup_theme' ,'um_wpheadtrim'); }
if (um_getoption('wdtma')) { add_action('widgets_init','um_elwidgets_init'); }
if (um_getoption('pback')) { add_action('wp_head','um_pingback'); }
if (file_exists(get_stylesheet_directory()."/favicon.ico")) { add_action('wp_head','um_favicon'); }
add_filter('admin_footer_text','um_footeradmin');
function um_nodashboard_widgets() {
	global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	//unset($wp_meta_boxes['dashboard']['side']['high']['dashboard_browsernag']);
}
function um_favicon() { echo '<link rel="shortcut icon" type="image/x-icon" href="' .get_stylesheet_directory_uri(). '/favicon.ico" />' . "\n"; }
function um_pingback() { echo '<link rel="pingback" href="'.site_url().'/xmlrpc.php">' . "\n"; }
function um_wpheadtrim() {
	remove_action('wp_head','wlwmanifest_link');
	remove_action('wp_head','rsd_link');
	remove_action('wp_head','wp_shortlink_wp_head');
	remove_action('wp_head','wp_generator');
	remove_action('wp_head','start_post_rel_link',10,0);
	remove_action('wp_head','adjacent_posts_rel_link',10,0);
	remove_action('wp_head','index_rel_link');
	remove_action('wp_head','adjacent_posts_rel_link');
}
function um_elwidgets_init() {
		$m=um_getoption('wdtma');
		for ($i=1; $i <=$m; $i++) {
		register_sidebar(array(
			'name'		=> 'Element-'.$i,
			'id'			=> 'element-'.$i,
			'before_widget'=> '<aside id="%1$s" class="widget %2$s">',
			'after_widget'=> '</aside>',
			'before_title'=> '<h1 class="widget-title">',
			'after_title'=> '</h1>',
		));
	}
}
function um_footeradmin () { 
	$credit = array(
		'Actualy <a href="http://www.wordpress.org">WordPress</a>, instead <a href="http://tacoen.github.io/UndressMe">UM</a>',
		'Hi <a href="http://www.wordpress.org">WordPress</a>! Hello <a href="http://tacoen.github.io/UndressMe">UM</a>!',
		'This <a href="http://www.wordpress.org">WordPress</a> with <a href="http://tacoen.github.io/UndressMe">UM</a>',
		'<a href="http://www.wordpress.org">WordPress</a> and <a href="http://tacoen.github.io/UndressMe">UM</a>',
		'Core: <a href="http://www.wordpress.org">WordPress</a>, Plugin: <a href="http://tacoen.github.io/UndressMe">UM</a>',
		'Much about <a href="http://www.wordpress.org">WordPress</a> than <a href="http://tacoen.github.io/UndressMe">UM</a>',
		'This <a href="http://www.wordpress.org">WordPress</a> with <a href="http://tacoen.github.io/UndressMe">UM</a>',
		'There were <a href="http://www.wordpress.org">WordPress</a> programmer whom <a href="http://tacoen.github.io/UndressMe">UM</a>',
	);
	shuffle($credit); echo $credit[0];
}

/* recent comment hardcode are move into wp-reset.css (um-reset.css) */

function my_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
add_action('widgets_init', 'my_remove_recent_comments_style');


/* ----------------------------------------------------------------------------------
 * Why I delete readme.html and license.txt? 
 * because we meant to fix it :D
 *
 */
 
if (file_exists(ABSPATH."readme.html")) { unlink (ABSPATH."readme.html"); }
if (file_exists(ABSPATH."license.txt")) { unlink (ABSPATH."license.txt"); }

