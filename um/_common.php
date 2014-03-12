<?php
/**
 * um functions libraries
 *
 * @package um
 */

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

function um_ver() { return "1.1-nr"; }

function um_tool_which($file) {
	if (file_exists(get_stylesheet_directory()."/".$file)) {
		return get_stylesheet_directory_uri()."/".$file;
	} else {
		return get_template_directory_uri()."/".$file;
	}
}

function um_get_layout_option($where) {
	$layout_options['none']="none";
	$layout_css=glob($where."/*.css");
	foreach ($layout_css as $lf) {
		$f=basename($lf); $F=explode(".",$f); $n++;
		$layout_options[$F[0]]=$f;
	}

	return $layout_options;
}

function um_getoption($w) {
		$umo->options=get_option('umo');
		if (in_array($w,array_keys($umo->options))) {
			return $umo->options[$w];
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
	#file_put_contents($filename,$txt);	
}

function um_file_getcontents($filename,$nonce="") {
	#
	# how wp_filesystem work????
	#
	#global $wp_filesystem;
	#filesystem_init();
	#return $wp_filesystem->get_contents($filename);
	#return file_get_contents($filename);
	$txt = join("",file($filename));
	return stripslashes($txt);
}

function um_add_pagetemplate($n,$f) {
	$n=preg_replace("#.php#",'',$n); $n=ucfirst($n);
	um_file_putcontents($f,"/*\n* Template "."Name: $n\n*/\n");
}

function um_new_umguijs() {
	um_file_putcontents(get_stylesheet_directory()."/um-gui.js", "(function($) {\n\n})(jQuery);");
	return get_stylesheet_directory()."/um-gui.js";
}

function um_new_umschemecss() {
	um_file_putcontents(get_stylesheet_directory()."/um-scheme.css","h1,h2,.um-title { color: #2D3E50/*um-title*/ ; }\n\rbody,.um-text { color: #5d6d7d/*um-text*/ ; }\n\r.um-page { color: #fcfcfc/*um-page*/ ; }\n\r#um-crumbs a, #um-crumbs,.um-line { color: #95a5a6/*um-line*/ ; }\n\r.um-hot { color: #C54134/*um-hot*/ ; }\n\r.um-confirm { color: #16A086/*um-confirm*/ ; }\n\r.um-cool { color: #5DADE2/*um-cool*/ ; }\n\r.um-prompt { color: #F39C11/*um-prompt*/ ; }\n\ra,.um-link { color: #111111/*um-link*/ ; }\n\r\n\r");
	return get_stylesheet_directory()."/um-scheme.css";
}

function um_new_layoutdir() {
	mkdir(get_stylesheet_directory()."/layouts");
}