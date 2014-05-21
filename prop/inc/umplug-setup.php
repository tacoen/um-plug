<?php/* for UM themes compabilities */DEFINE('UMCORE_DIR', get_template_directory() );DEFINE('UMCORE_URL', get_template_directory_uri() );function um_check_umplug() {	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );	if(!is_plugin_active( 'um-plug/um-plug.php' )) {		add_action('admin_notices','um_adminnotes');		add_action('wp_head','um_suggest_umplug');		return false;	} else {		return true;	}}function um_adminnotes() {	echo '<div id="message" class="error">';	echo "<p>This theme requires <a href='". admin_url()."plugin-install.php?tab=search&s=um-plug&plugin-search-input=Search+Plugins'>UM-Plug</a> plugins.</p>";	echo '</div>';}function um_suggest_umplug() { echo "<!-- UM-PLUG N/A -->"; }$umplug_is = um_check_umplug();function um_theme_scripts() {	$pre_styles = array(		'css/reset.css',		'css/base.css',		'css/nav.css',		'css/um-gui-lib.css'	);		$suf_styles = array(		'um-scheme.css',		'layouts/theme-check.css'	);		$pre_scripts = array(		'js/um-gui-lib.js',	);		$suf_scripts = array(		'js/default.js',		'um-gui.js',	);	/* always use get_stylesheet_directory_uri(), 	 * instead get_template_directory_uri() so it will provide fallback	 */	$dep = array();	 	// pre_styles		foreach ($pre_styles as $style) {		$s_file = get_stylesheet_directory()."/". $style;		$s_url  = get_stylesheet_directory_uri()."/". $style;		$s_name = preg_replace("/\.(.*)|(.*)\/|\W/","",$style);		if (file_exists($s_file)) { wp_enqueue_style( $s_name, $s_url, false, "0.1" ,'all' ); }		$dep = array($s_name);	}		wp_enqueue_style( 'um-style', get_stylesheet_uri(), $dep, "0.1", 'all' );	foreach ($suf_styles as $style) {		$s_file = get_stylesheet_directory()."/". $style;		$s_url  = get_stylesheet_directory_uri()."/". $style;		$s_name = preg_replace("/\.(.*)|(.*)\/|\W/","",$style);		if (file_exists($s_file)) { wp_enqueue_style( $s_name, $s_url, false, "0.1" ,'all' ); }	}	$dep = array('jquery');		foreach ($pre_scripts as $style) {		$s_file = get_stylesheet_directory()."/". $style;		$s_url  = get_stylesheet_directory_uri()."/". $style;		$s_name = preg_replace("/\.(.*)|(.*)\/|\W/","",$style);		if (file_exists($s_file)) { wp_enqueue_script( $s_name, $s_url, $dep, "0.1" ,false ); }	}	foreach ($suf_scripts as $style) {		$s_file = get_stylesheet_directory()."/". $style;		$s_url  = get_stylesheet_directory_uri()."/". $style;		$s_name = preg_replace("/\.(.*)|(.*)\/|\W/","",$style);		if (file_exists($s_file)) { wp_enqueue_script( $s_name, $s_url, array(), "0.1" ,true ); }	}		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {		wp_enqueue_script( 'comment-reply' );	}	}if (!$umplug_is) {	// Only load this, when UM-PLUG plugins is not active;	add_action( 'wp_enqueue_scripts', 'um_theme_scripts' );}/* um-compat ----------------------------------------------------------------------- */if ( ! function_exists('glob_recursive')) {	// Does not support flag GLOB_BRACE	function glob_recursive($pattern, $flags = 0) {		$files = glob($pattern, $flags);		foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {			$files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));		}		return $files;	}}if ( ! function_exists('umtag')) {	function umtag($func,$args=array()) {		if (! function_exists($func)) {				$ttdir=get_template_directory()."/template-tags/";				if (file_exists($ttdir.$func.".php")) {					require $ttdir.$func.".php"; call_user_func_array("umtag_".$func,array($args));				} else {					echo "<!-- umtag: $func not exist --->";				}		} else {			call_user_func_array("umtag_".$func,array($args));		}	}	// [umtag func="bar"], umtag as shortcode	function umtag_func( $atts ) {		umtag( $atts['func'], $atts['args'] );	}	add_shortcode('umtag', 'umtag_func');}if ( ! function_exists('um_getoption')) {	function um_getoption($w,$o="umo") {		$umo->options=get_option($o);		if (isset($umo->options[$w])) {			return $umo->options[$w];		}	}}