<?php
/*
Plugin Name: UM-Plug
Plugin URI: http://tacoen.github.io/um-plug/
Description: Themes core and tool kits, a Wordpress developer Toolkit for creating/ maintaining/ optimizing a theme.
Author: tacoen
Author URI: http://github.com/tacoen
Version: 1.1.7
Text Domain: um
*/

defined('ABSPATH') or die('um?');

DEFINE ('UMPLUG_DIR', plugin_dir_path( __FILE__ ) );
DEFINE ('UMPLUG_URL', plugin_dir_url(__FILE__) );

function um_ver() { return '1.1.7'; }

$umo = array();

require UMPLUG_DIR . 'um/_common.php';
require UMPLUG_DIR . 'um/um-compat.php';
require UMPLUG_DIR . 'um/_etc.php';
require UMPLUG_DIR . 'um/ajax-adminpage.php';

require UMPLUG_DIR . 'um/um-setup.php';
require UMPLUG_DIR . 'um/tweaks.php';
require UMPLUG_DIR . 'um/themes.php';

require UMPLUG_DIR . 'um/apply.php';
