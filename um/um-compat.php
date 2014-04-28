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
		if (um_getoption('umtag')) {
			if (! function_exists($func)) {
				$ttdir=get_template_directory()."/template-tags/";
				if (file_exists($ttdir.$func.".php")) {
					require $ttdir.$func.".php"; call_user_func_array("umtag_".$func,array($args));
				} else {
					echo "<!-- umtag: $func not exist --->";
				}
			} else {
				call_user_func_array("umtag_".$func,array($args));
			}
		} else {
			echo "<!-- umtag: disable --->";
		}
	}

}

if ( ! function_exists('um_getoption')) {

	function um_getoption($w,$o="umo") {
		$umo->options=get_option($o);
		if (isset($umo->options[$w])) {
			return $umo->options[$w];
		}
	}
}
