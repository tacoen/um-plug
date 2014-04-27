<?php

if (!function_exists('um_getoption')) { /* um-compat.php */

	function um_get_layout_option($where) {
		$layout_options['none']="none"; $n=0;
		$layout_css=glob($where."/*.css");
		foreach ($layout_css as $lf) {
			$f=basename($lf); $F=explode(".",$f); $n++;
			$layout_options[$F[0]]=$f;
		}
		return $layout_options;
	}

	function um_getoption($w) {
		$umo->options=get_option('umo');
		if (isset($umo->options)) {
		//if (in_array($w,array_keys($umo->options))) {
			return $umo->options[$w];
		}
	}

	function um_get_themeoption($w) {
		$umt->options=get_option('umt');
		if (isset($umt->options)) {
		//if (in_array($w,array_keys($umt->options))) {
			return $umt->options[$w];
		}
	}

	function um_ver() { return "1.0.5"; }

	function umtag($func,$args=array()) {
		if (um_getoption('umtag')) {
			if (! function_exists($func)) {
				$ttdir=get_template_directory()."/template-tags/";
				if (file_exists($ttdir.$func.".php")) {
					require $ttdir.$func.".php"; call_user_func_array($func,array($args));
				} else {
					echo "<!-- umtag: $func not exist --->";
				}
			} else {
				call_user_func_array($func,array($args));
			}
		} else {
			echo "<!-- umtag: disable --->";
		}
	}

	function um_tool_which($file) {
		if (file_exists(get_stylesheet_directory()."/".$file)) {
			return get_stylesheet_directory_uri()."/".$file;
		} else {
			return get_template_directory_uri()."/".$file;
		}
	}

}

function um_admin_header($title,$func="",$arny=array()) {
		echo '<div class="wrap"><div class="um-head-set"><h2>UM: '.$title.'</h2><h3>Theme: '. wp_get_theme() .'</h3></div>';
		echo '<div class="um-frame-box dress">';
		if ($func!="") { call_user_func_array($func,$arny); }
		echo '</div></div><!--warp-->';
}
function filesystem_init($key='um_textedit') {
	global $wp_filesystem;
	WP_Filesystem();
	$url=wp_nonce_url(admin_url('admin-ajax.php'),$key);
	$creds=request_filesystem_credentials($url,'',false,false,null);
	if ($creds== false) {
		$url=wp_nonce_url(admin_url('customize.php'),$key);
		$creds=request_filesystem_credentials($url,'',false,false,null);
	}
	return $creds;
//	if (false===($creds=request_filesystem_credentials($url,'',false,false,null))) { return; }
//	echo $creds;
//	var_dump($wp_filesystem);
//	die();
}	
function um_file_putcontents($filename,$txt) {
	global $wp_filesystem;
	filesystem_init();
	$wp_filesystem->put_contents($filename,stripslashes($txt),FS_CHMOD_FILE);
	// file_put_contents($filename,$txt);	
}

function um_file_putcontents_nos($filename,$txt) {
	global $wp_filesystem;
	filesystem_init();
	$wp_filesystem->put_contents($filename,$txt,FS_CHMOD_FILE);
	// file_put_contents($filename,$txt);	
}

function um_file_getcontents($filename,$nonce="") {
	/*
	 * global $wp_filesystem;
	 * filesystem_init();
	 * return $wp_filesystem->get_contents($filename);
	 * return file_get_contents($filename);
	 */
	$txt = join("",file($filename));
	return stripslashes($txt);
}

if ( ! function_exists('glob_recursive')) {
    // Does not support flag GLOB_BRACE
    function glob_recursive($pattern, $flags = 0)    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)        {
            $files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
        }
        return $files;
    }
}
