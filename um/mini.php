<?php
defined('ABSPATH') or die('Huh?');

function um_makestatic($csses) {

	require_once(ABSPATH . 'wp-admin/includes/file.php');

	$ncss = array();$static ="";
	foreach ($csses as $css) {
		$css = preg_replace("#".site_url()."/#","",$css);
		$static .= css_include(ABSPATH.$css,1);
		array_push($ncss,$css_file);
	}

	um_file_putcontents_nos(get_stylesheet_directory()."/static.css",css_compress($static,0)); 	
	
}