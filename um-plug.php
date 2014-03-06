<?php
/*
Plugin Name: UM-Core
Plugin URI: http://tacoen.github.com/um-plug
Description: UM Core
Author: tacoen
Author URI: http://tacoen.github.com/
Version: 0.1
Text Domain: um
*/

DEFINE ('UMPLUG_DIR',  plugin_dir_path( __FILE__ ) );
DEFINE ('UMPLUG_URL',  plugin_dir_url(__FILE__) );

//require UMPLUG_DIR . 'um/cdn.php';

require UMPLUG_DIR . 'um/_common.php';
require UMPLUG_DIR . 'um/options.php';
require UMPLUG_DIR . 'um/chunks.php';
require UMPLUG_DIR . 'um/adminpage.php';
require UMPLUG_DIR . 'um/ajax-adminpage.php';
require UMPLUG_DIR . 'um/toucher.php';
require UMPLUG_DIR . 'um/etc.php';
require UMPLUG_DIR . 'um/customizer-scheme.php';
require UMPLUG_DIR . 'um/um-setup.php';

add_action( 'admin_init', 'tc_i18n' );

function tc_i18n() {
	load_plugin_textdomain( 'um', false, 'um-plug/lang' );
}

function umplug_role_check() {
	if ( !current_user_can( 'edit_theme_options' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.', 'um' ) );
	}
}

