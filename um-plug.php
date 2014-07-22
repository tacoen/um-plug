<?php
/*
Plugin Name: UM-Plug
Plugin URI: http://tacoen.github.io/um-plug/
Description: Themes core and tool-kits, a Wordpress developer Toolkit for creating/ maintaining/ optimizing a theme.
Author: tacoen
Author URI: http://github.com/tacoen
Version: 1.2.1
Text Domain: um
Network:true
*/

defined('ABSPATH') or die('um?');
DEFINE ('UMPLUG_DIR', plugin_dir_path( __FILE__ ) );
DEFINE ('UMPLUG_URL', plugin_dir_url(__FILE__) );
$umo = array();
$um_hp = array();
$umplug_can_active=0;
function um_ver() { return '1.2.1'; }
function um_req_role() { return 'edit_theme_options'; }

if (is_multisite()) {
    if ("um" == get_template()) {
	// umplug will only avaliable for UM theme, and doesn't mess
	// with other non-UM themes
	$umplug_can_active=1;
    }
} else {
    // Not multisite
    $umplug_can_active=1;
}

if ($umplug_can_active==1) :

    require(UMPLUG_DIR . 'um/_common.php');
    require(UMPLUG_DIR . 'um/um-compat.php');
    require(UMPLUG_DIR . 'um/_etc.php');
    require(UMPLUG_DIR . 'um/init.php');

    require(UMPLUG_DIR . 'um/ajax-adminpage.php');
    require(UMPLUG_DIR . 'um/um-setup.php');

    require_once(UMPLUG_DIR . 'um/tweaks.php');
    require_once(UMPLUG_DIR . 'um/themes.php');
    require_once(UMPLUG_DIR . 'um/min.php');
    require_once(UMPLUG_DIR . 'um/custom-layout.php');

    //---- Enable this to copy props from parent/core back to plugins props.
    require_once(UMPLUG_DIR."um/um-prop-sync.php");

    // -- apply them all
    require_once(UMPLUG_DIR . 'um/apply.php');

endif;
