<?php
defined('ABSPATH') or die('Huh?');

function um_option_update($where="umo",$what="key",$val) {
	if (isset($val)) { 
		$my_options = get_option($where);
		$my_options[$what] = $val;
		update_option($where, $my_options);
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

function um_help($contextual_help, $screen_id) {

	$um_help = UMPLUG_DIR."prop/doc/help/".$screen_id.".html";
	// echo "<!--- $screen_id --->";

	if (file_exists($um_help) ){
		$debugres =
			"<h3>Site Information</h3><div class='um-debug'>".
			"<p><label>Site Root:</label>".ABSPATH."</p>".
			"<p><label>Theme:</label>".wp_get_theme()."</p>".
			"<p><label>Template Directory:</label><span title='URL:".get_template_directory_uri()."'>".get_template_directory()."</span></p>";
		if (get_template_directory() != get_stylesheet_directory()) {
			$debugres .="<p><label>Style Sheet Directory (child):</label><span title='URL:".get_stylesheet_directory_uri()."'>".get_stylesheet_directory()."</span></p>";
		}
		$debugres .=
			"<p><label>UM-Plug Directory</label>".UMPLUG_DIR."</p>".
			"";

		$debugres .="</div>";
		
		$umch_credit = "<h4>UM PLUG - ".um_ver()."</h4>".
			"<p><a href='//github.com/tacoen/um-plug'>Plugins Site</a></p>".
			"<p><a href='//github.com/tacoen/um-plug/wiki'>Wiki</a></p>".
			"<p><a href='//github.com/tacoen/um-plug/issues'>Issues</a></p>".
			"<p><a href='//github.com/tacoen/um-theme-core'>UM Core Themes</a></p>".
			"<p>&nbsp;</p>";

		$icontextual_help = '<p>';
		$icontextual_help .= __( umch_overview($screen_id) );
		$icontextual_help .= '</p>';
		
		$webfont_ref = "<p><label>UM-GUI Icons</label><a href='".UMPLUG_URL."prop/css/fonts/demo.html"."'>Icons References</a></p>";
		$umref = "<h3>Links</h3><div class='um-debug'>" . 
			join('',file( 	UMPLUG_DIR."prop/doc/feat.html" )) . 
			$webfont_ref .
			"</div>";

		$umch_help = array('id'=> 'umch-help','title'=> __('Overview' ),'content'=> __($icontextual_help));
		$umch_debug = array('id'=> 'umch-debug','title'=> __('Site Info' ),'content'=> __($debugres));
		$umch_ref = array('id'=> 'umch-ref','title'=> __('Links' ),'content'=> __($umref));
		
		get_current_screen()->set_help_sidebar(__($umch_credit));
		get_current_screen()->add_help_tab($umch_help);
		get_current_screen()->add_help_tab($umch_debug);
		get_current_screen()->add_help_tab($umch_ref);
		return $contextual_help;
	}
}

function umch_overview($id) {
	$text = "--N/A--"; $str = "";
	$um_help = UMPLUG_DIR."prop/doc/help/".$id.".html";
	$text = join('',file($um_help));
	$str .="<div>$text</div>";
	return $str;
}

add_filter('contextual_help', 'um_help', 10, 2);

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

function um_register_admin_scripts() {
	wp_enqueue_style('um-backend',UMPLUG_URL."prop/css/um-backend.css",array('wp-admin'),um_ver(),'all');
	wp_enqueue_script('um-backend-js',UMPLUG_URL . 'prop/js/um-backend.js',array('jquery'),um_ver(),true);
}

function umplug_init_slug() {
	add_menu_page("Undress Me","UM Plug",'edit_theme_options','undressme','um_readme','dashicons-editor-underline',61);
	add_submenu_page('undressme','UM Readme','Readme','edit_theme_options','undressme','um_readme');
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

add_action('admin_print_styles','um_register_admin_scripts');
add_action('admin_menu','umplug_init_slug');

function um_disable_feed() {
	wp_die( __('Goto: <a href="'. get_bloginfo('url') .'">'.get_bloginfo('url').'</a>!','um') );
}

function um_login_logo_url() {
    return home_url()."?tick=".time();
}
add_filter( 'login_headerurl', 'um_login_logo_url' );

function um_login_logo_url_title() {
    return get_option('blogname');
}
add_filter( 'login_headertitle', 'um_login_logo_url_title' );

function um_login_logo() { ?>
<style type="text/css"><?php echo um_getoption('logincss')?></style>
<?php }

if (um_getoption('logincss')) {
	add_action( 'login_enqueue_scripts', 'um_login_logo' );
}