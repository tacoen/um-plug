<?php
defined('ABSPATH') or die('Huh?');

function um_option_update($where="umo",$what="key",$val) {
	if (isset($val)) { 
		$um_options = get_option($where);
		$um_options[$what] = $val;
		update_option($where, $um_options);
	}
}

function um_readme() {
	um_adminpage_wrap("UM-Plug - ".um_ver(),"umplug_readme",array()); 
}

function umplug_readme() {
	echo '<div class="um-feat">';
	echo join('',file(UMPLUG_DIR."prop/doc/readme.html"));
	$readme = get_stylesheet_directory()."/readme.txt";
	echo "</div>\n";
}

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

function remove_gravatar ($avatar, $id_or_email, $size, $default, $alt) {
	if ( file_exists( get_template_directory_uri() .'/noavatar.png')) {
		$default = get_template_directory_uri() .'/noavatar.png?junk=';
	} else {
		$default = UMPLUG_URL .'prop/noavatar.png?junk=';
	}

	return "<img alt='{$alt}' src='{$default}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";
}

function um_user_contactmethods($user_contactmethods){
	//unset($user_contactmethods['jabber']);
	$user_contactmethods['twitter'] = 'Twitter Username';
	$user_contactmethods['facebook'] = 'Facebook Username';
	$user_contactmethods['photo_url'] = 'Photo URL';
	return $user_contactmethods;
}

function stylesheet_directory_shorten_url() {
	$a = str_replace(home_url()."/",'',get_stylesheet_directory_uri()."/");
	$b = um_getoption('style')."/";
	$str = str_replace($a,$b, get_stylesheet_directory_uri()."/");
	return $str;
}

function um_style_nover($u) {
	$u = preg_replace("/(.+)\?ver=(.+)$/","\\1",$u); // versioning remover
	return $u;
}

function um_script_nover($u) {
	$u = preg_replace("/(.+)\?ver=(.+)$/","\\1",$u); // versioning remover
	return $u;
}

function um_disable_feed() {
	wp_die( __('Goto: <a href="'. get_bloginfo('url') .'">'.get_bloginfo('url').'</a>!','um') );
}

/* wp-login tweaks */

function um_login_logo_url() { return home_url()."?tick=".time(); }
function um_login_logo_url_title() { return get_option('blogname'); }
function um_login_css() { ?><style type="text/css"><?php echo um_getoption('logincss')?></style><?php }

/* hp = hidden page */

function um_hp_init() {
	global $um_hp;
	global $_registered_pages; 
	if (!empty($um_hp)) :
	foreach ($um_hp as $hook) {
		// This WordPress variable is essential: it stores which admin pages are registered to WordPress
		$hookname = get_plugin_page_hookname($hook, 'admin.php');
		if (!empty($hookname)) { add_action($hookname, $hook); }
		$_registered_pages[$hookname] = true;
	}
	endif;
}
