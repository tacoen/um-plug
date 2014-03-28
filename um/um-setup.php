<?php
defined('ABSPATH') or die('Huh?');

if (um_getoption('urlrw')) {
	require UMPLUG_DIR . 'um/rewrites.php';
}

/* The Setup start here */
function um_register_admin_scripts() {
	wp_enqueue_style('um-backend',UMPLUG_URL."prop/css/um-backend.css",array('wp-admin'),um_ver(),'all');
	wp_enqueue_script('um-backend-js',UMPLUG_URL . 'prop/js/um-backend.js',array('jquery'),um_ver(),true);
}

add_action('admin_print_styles','um_register_admin_scripts');

function um_register_scripts() {
}

function um_register_styles() {
}

//add_action('wp_enqueue_scripts','um_register_scripts');
//add_action('wp_enqueue_scripts','um_register_styles');

/*
if ( is_page_template('custom-page.php') ) {
	add_action('wp_enqueue_scripts','umadd_fullpagejs');
}
*/