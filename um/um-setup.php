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
function um_register_scripts() {
	if (um_getoption('umgui')) {
		wp_enqueue_script('um-gui-lib',UMPLUG_URL . 'prop/js/um-gui-lib.js',array(),um_ver(),true);
		wp_enqueue_script('um-gui',um_tool_which('um-gui.js'),array('um-gui-lib'),um_ver(),true);
	}
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
function um_register_styles() {
	if (um_getoption('umcss')) {
		$dep = array('um-reset');
		if (um_getoption('cssrd')) {
			if (file_exists(UMPLUG_DIR."prop/css/um-reset.php")) { wp_enqueue_style('um-reset',UMPLUG_URL. 'prop/css/um-reset.php' ,false,time(),'all'); }
		} else {
			wp_enqueue_style('um-reset',UMPLUG_URL. 'prop/css/um-reset.css' ,false,um_ver(),'all');
		}
	} else {
		$dep = false;
	}
	if (um_getoption('umgui')) {
		wp_enqueue_style('um-gui', UMPLUG_URL . 'prop/css/um-gui-lib.css',$dep,um_ver(),'all');
	}
	if (!is_admin()) { // not avaliable in customize
		if (um_getoption('schcss')) {
			wp_enqueue_style(get_template().'-scheme',um_tool_which('um-scheme.css'),$dep,um_ver(),'all');
			wp_register_style(get_template().'-style',get_stylesheet_uri(),array(get_template().'-scheme',),um_ver(),'all');
		} else {
			wp_register_style(get_template().'-style',get_stylesheet_uri(),$dep,um_ver(),'all');
		}
	} else {
		wp_register_style(get_template().'-style',get_stylesheet_uri(),$dep,um_ver(),'all');
	}
	wp_enqueue_style(get_template().'-style');
	$layout=um_getoption('layout'); if ($layout !="none") {
		wp_enqueue_style(get_template().'-layout', get_stylesheet_directory_uri()."/layouts/$layout", array(get_template().'-style'),um_ver(),'all'); 
	}
}