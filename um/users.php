<?php

add_filter('user_contactmethods', 'my_user_contactmethods');

// echo get_user_meta(1, 'twitter', true);             

function my_user_contactmethods($user_contactmethods){
//unset($user_contactmethods['jabber']);
 
  $user_contactmethods['twitter'] = 'Twitter Username';
  $user_contactmethods['facebook'] = 'Facebook Username';
 
  return $user_contactmethods;
}

function remove_gravatar ($avatar, $id_or_email, $size, $default, $alt) {
	if ( file_exists( get_template_directory_uri() .'/noavatar.png')) {
		$default = get_template_directory_uri() .'/noavatar.png?junk=';
	} else {
		$default = UMPLUG_URL .'prop/noavatar.png?junk=';
	}
	
	return "<img alt='{$alt}' src='{$default}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";
}
if (um_getoption('noavatar')) { add_filter('get_avatar', 'remove_gravatar', 1, 5); }

if (um_getoption('nowpabar')) { show_admin_bar(false); }

?>