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
/*
	$htmlfile = glob_recursive(	UMPLUG_DIR."prop/doc/help/*.html");
	arsort($htmlfile);
	
	foreach ($htmlfile as $html) { echo "<div>".join('',file($html))."</div>"; }
	if (file_exists($readme)) { 
		echo '<div><h3>Theme Readme</h3><div class="postbox inside"><pre>';
		echo join('',file($readme)); 
		echo '</div></div>';
	}
	*/
	echo "</div>\n";
}

function um_help($contextual_help, $screen_id) {

	$um_help = UMPLUG_DIR."prop/doc/help/".$screen_id.".html";
	echo "<!--- $screen_id --->";

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
			"<p><a href='//github.com/tacoen/um-theme/'>UM Themes</a></p>".
			"<p><a href='//github.com/tacoen/um-plug/wiki'>Wiki</a></p>".
			"<p><a href='//github.com/tacoen/um-plug/issues'>Issues</a></p>".
			"<p>&nbsp;</p>";

		$icontextual_help = '<p>';
		$icontextual_help .= __( umch_overview($screen_id) );
		$icontextual_help .= '</p>';
		
		$webfont_ref = "<p><label>UM-GUI Icons</label><a href='".UMPLUG_URL."prop/css/icons-reference.html"."'>Icons References</a></p>";
		$umref = "<h3>Links</h3><div class='um-debug'>" . 
			join('',file( 	UMPLUG_DIR."prop/doc/feat.html" )) . 
			$webfont_ref .
			"</div>";

		$umch_help  = array('id'=> 'umch-help','title'=> __('Overview' ),'content'=> __($icontextual_help));
		$umch_debug = array('id'=> 'umch-debug','title'=> __('Site Info' ),'content'=> __($debugres));
		$umch_ref   = array('id'=> 'umch-ref','title'=> __('Links' ),'content'=> __($umref));
		
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

function print_them_globals() {

	ksort( $GLOBALS );
	echo '<ol>';
	echo '<li>'. implode( '</li><li>', array_keys( $GLOBALS ) ) . '</li>';
	echo '</ol>';
}

function stylesheet_directory_shorten_url() {
	$a = str_replace(home_url()."/",'',get_stylesheet_directory_uri()."/");
	$b = um_getoption('style')."/";
	$str = str_replace($a,$b, get_stylesheet_directory_uri()."/");
	return $str;
}

function um_style_unique($u) {
	global $UM; global $um_static_css_already;
	$u = preg_replace("/(.+)\?(.+)/","\\1",$u); // versioning remover
	
	if (!$um_static_css_already) {
		if (array_search($u,$UM['css'])<1) {
			array_push($UM['css'],$u); return "$u?ver=".um_ver();
		} else { return;}
	} else {
		if (preg_match("#".home_url()."#",$u)) {
			if ( ( $u == get_stylesheet_directory()."static.css") || ( $u == stylesheet_directory_shorten_url()."static.css")) {
					//return "$u?ver=".um_ver();
					return "$u";
				} else { return; }
		} else { return $u; }
	}
}

function um_script_unique($u) {
	global $UM; global $um_static_js_already;
	$u = preg_replace("/(.+)\?(.+)/","\\1",$u); // versioning remover
	
	if (!$um_static_js_already) {
		if (array_search($u,$UM['js'])<1) {
			array_push($UM['js'],$u); return "$u?ver=".um_ver();
		} else { return;}
	} else {
		if (preg_match("#".home_url()."#",$u)) {
			if ( ( $u == get_stylesheet_directory()."static.js") ||
				 ( $u == get_stylesheet_directory()."static-foot.js") ||			
				 ( $u == stylesheet_directory_shorten_url()."static-foot.js") ||			
			 ( $u == stylesheet_directory_shorten_url()."static.js")
			 ) {
					//return "$u?ver=".um_ver();
					return "$u";
				} else { return; }
		} else { return $u; }
	}
}

function um_style_makestatic($handles) {

	global $wp_styles; $static = array();
	if (count($handles)>0) {
		foreach ($handles as $handle) {
			$src = $wp_styles->registered[$handle]->src; 
			if (preg_match("#".home_url()."#",$src)) { array_push($static,$src); }		
		}
		if (count($static)>0) { um_makestatic($static,"css"); }
	}
	return $handles;
}

function um_script_makestatic($handles) {
	global $wp_scripts; $static_foot = array(); $static_head = array(); $moved = array();
	$pre_head = ""; $pre_foot = "";
	
	if (count($wp_scripts->done) < 1) {

		//print_r($wp_scripts); 
		$group = $wp_scripts->groups;
	
		foreach($handles as $handle) {
			$src = $wp_scripts->registered[$handle]->src;
		
			if ( $group[$handle] == 0 ) { 
				if (preg_match("#".home_url()."#",$src)) { 
					array_push($static_head,$src);
					if ($wp_scripts->registered[$handle]->extra) {
					if ($wp_scripts->registered[$handle]->extra['data']) { $pre_head .= $wp_scripts->registered[$handle]->extra['data'] . "\n"; }
					}
				} 
			}
		
			if ( $group[$handle] == 1 ) { 
				if (preg_match("#".home_url()."#",$src)) { 
					array_push($static_foot,$src); 
					if ($wp_scripts->registered[$handle]->extra) {
					if (isset($wp_scripts->registered[$handle]->extra['data'])) { $pre_foot .= $wp_scripts->registered[$handle]->extra['data'] . "\n"; }
					}
				}
			}
		}

		if (count($static_head)>0) { um_makestatic($static_head,"js","",$pre_head); }
		if (count($static_foot)>0) { um_makestatic($static_foot,"js","foot",$pre_foot); }

	}
	
	return $handles;

}

function um_makestatic($files,$type="js",$ext="",$pre="") {

	require_once(ABSPATH . 'wp-admin/includes/file.php');
	$level = um_getoption('zlevel','umt');
	$static =''; $files = array_unique($files);
	$head="/*\n"; $res ="/*begin*/";
	foreach ($files as $f) {
		$fn = preg_replace("#".site_url()."/#",'',$f);
		$head .=" * $type - /$fn\n";
		if ($type == "css") {
			$static .= css_url_care( css_include(ABSPATH.$fn,1), $f);
		} else {
			$static .= js_include(ABSPATH.$fn,1);
		}
	}

	$head .=" */\n\n";

	if ($level == 0) {
		if ($type == "css") { $res = css_compress($static,0); $res = $pre.$res;} 
		else { $res = js_compress($static,0); $res = $pre.$res; }
	} else {
		$res = $head.$pre.$static;
	}
	if ($ext!="") { $ext = "-".$ext; }
	$target = get_stylesheet_directory()."/static$ext.$type";
	
	um_file_putcontents_nos($target,$res);

}

add_action('admin_print_styles','um_register_admin_scripts');
add_action('admin_menu','umplug_init_slug');
