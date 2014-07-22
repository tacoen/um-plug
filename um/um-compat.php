<?php

if ( ! function_exists('glob_recursive')) {
	// Does not support flag GLOB_BRACE
	function glob_recursive($pattern, $flags = 0) {
		$files = glob($pattern, $flags);
		foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
			$files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
		}
		return $files;
	}
}

if ( ! function_exists('umtag')) {

	function umtag($func,$args=array()) {
		if (! function_exists($func)) {
			$ttdir=get_template_directory()."/umtag/";
			if (file_exists($ttdir.$func.".php")) {
				require $ttdir.$func.".php"; call_user_func_array("umtag_".$func,array($args));
			} else {
				echo "<!-- umtag: $func not exist --->";
			}
		} else {
			call_user_func_array("umtag_".$func,array($args));
		}
	}

	function umtag_func( $atts ) {
		if (isset($atts)) { umtag( $atts['func'], $atts['args'] ); }
	}


}
// [umtag func="bar"], umtag as shortcode
add_shortcode('umtag', 'umtag_func');

if ( ! function_exists('um_getoption')) :

	function um_getoption($w,$o="umo") {
		$umo = new stdClass();
		$umo->options=get_option($o);
		if (isset($umo->options[$w])) { return $umo->options[$w]; } else { return false; }
	}

endif;

if ( ! function_exists('um_tool_which')) :

function um_tool_which($file) {
	if (file_exists(get_stylesheet_directory()."/".$file)) {
		return get_stylesheet_directory_uri()."/".$file;
	} else if (file_exists(get_template_directory()."/".$file)) {
		return get_template_directory_uri()."/".$file;
	} else {
		return UMPLUG_URL."prop/".$file;
	}
}

endif;

if ( ! function_exists('um_which_php')) :

	function um_which_php($file) {
		if ( file_exists( get_stylesheet_directory().$file )) { require get_stylesheet_directory().$file;} 
		else { require get_template_directory().$file; }
	}
endif;