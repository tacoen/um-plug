<?php
defined('ABSPATH') or die('Huh?');
if (um_getoption('ajaxwpl')) {
	require UMPLUG_DIR . 'um/ajax-wplogin.php';
}
if (um_getoption('urlrw')) {
	require UMPLUG_DIR . 'um/rewrites.php';
}
/* The Setup start here */
add_action('admin_print_styles','um_register_admin_scripts');
function um_register_admin_scripts() {
	wp_enqueue_style('um-backend',UMPLUG_URL."prop/css/um-backend.css",array('wp-admin'),um_ver(),'all');
	wp_enqueue_script('um-backend-js',UMPLUG_URL . 'prop/js/um-backend.js',array('jquery'),um_ver(),true);
}
add_action('wp_enqueue_scripts','um_register_scripts');
add_action('wp_enqueue_scripts','um_register_styles');

if (um_getoption('skejs')) { add_action('wp_head','um_iehtml5'); }

function um_iehtml5() {
	$output = '<!--[if lte IE 9]><link rel="stylesheet" href="' . UMPLUG_URL . 'prop/css/ie9.css" /><![endif]-->'."\n";
	$output .= '<!--[if lte IE 8]><script src="' . UMPLUG_URL . 'prop/js/html5shiv.js"></script><![endif]-->'."\n";
	echo $output;
}
function um_register_scripts() {
	if (um_getoption('skejs')) {
		wp_enqueue_script('um-skel-init',um_tool_which('skel-init.js'),array('jquery'),um_ver(),false);
		wp_enqueue_script('um-skel-lib',UMPLUG_URL . 'prop/js/skel.min.js',array('um-skel-init'),um_ver(),false);
	}
	if (um_getoption('umgui')) {
		wp_enqueue_script('um-gui-lib',UMPLUG_URL . 'prop/js/um-gui-lib.js',array(),um_ver(),true);
		wp_enqueue_script('um-gui',um_tool_which('um-gui.js'),array('um-gui-lib'),um_ver(),true);
	}
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}

function um_register_styles() {

	if ((file_exists(get_stylesheet_directory()."/static.css")) && (um_getoption('cssstatic'))) {
		$dep = array();
		if (um_getoption('cssrd')) {
			$dep = array('um-reset');
			if (file_exists(UMPLUG_DIR."prop/css/um-reset.php")) { wp_enqueue_style('um-reset',UMPLUG_URL. 'prop/css/um-reset.php' ,false,time(),'all'); }
		}
		
		wp_register_style(get_template().'-style',get_stylesheet_directory_uri()."/static.css",$dep,um_ver(),'all');
		wp_enqueue_style(get_template().'-style');

	} else {
	
	$css_static = array();
	if (um_getoption('umcss')) {
		$dep = array('um-reset');
		if (um_getoption('cssrd')) {
			if (file_exists(UMPLUG_DIR."prop/css/um-reset.php")) { wp_enqueue_style('um-reset',UMPLUG_URL. 'prop/css/um-reset.php' ,false,time(),'all'); }
		} else {
			array_push($css_static,UMPLUG_URL. 'prop/css/um-reset.css');
			wp_enqueue_style('um-reset',UMPLUG_URL. 'prop/css/um-reset.css' ,false,um_ver(),'all');
		}
	} else {
		$dep = false;
	}
	if (um_getoption('umgui')) {
		array_push($css_static,UMPLUG_URL. 'prop/css/um-gui-lib.css');
		wp_enqueue_style('um-gui', UMPLUG_URL . 'prop/css/um-gui-lib.css',$dep,um_ver(),'all');
	}
	
	if (!is_admin()) { // not avaliable in customize
		if (um_getoption('schcss')) {
			array_push($css_static,um_tool_which('um-scheme.css'));
			wp_enqueue_style(get_template().'-scheme',um_tool_which('um-scheme.css'),$dep,um_ver(),'all');
			wp_register_style(get_template().'-style',get_stylesheet_uri(),array(get_template().'-scheme',),um_ver(),'all');
		} else {
			wp_register_style(get_template().'-style',get_stylesheet_uri(),$dep,um_ver(),'all');
		}
	} else {
		wp_register_style(get_template().'-style',get_stylesheet_uri(),$dep,um_ver(),'all');
	}

	if (um_getoption('navcss')) {
		array_push($css_static,um_tool_which('um-navui.css'));
		wp_enqueue_style(get_template().'-navi',um_tool_which('um-navui.css'),$dep,um_ver(),'all');
	}

	array_push($css_static,get_stylesheet_uri());
	
	wp_enqueue_style(get_template().'-style');

	$layout=um_getoption('layout'); if ($layout !="none") {
		array_push($css_static,get_stylesheet_directory_uri()."/layouts/$layout");
		wp_enqueue_style(get_template().'-layout', get_stylesheet_directory_uri()."/layouts/$layout", array(get_template().'-style'),um_ver(),'all'); 
	}
	
	um_makestatic($css_static);
	
	} /*static? */
}