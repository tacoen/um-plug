<?php

um_hp_register("um_sync"); // wp-admin/admin.php?page=um_sync

function um_sync() {
	um_adminpage_wrap("UM Theme Sync","umplug_theme_sync",array()); 
}

function umplug_theme_sync() {

	$template = get_template_directory();
	$files = array(
		"css/reset.css",
		"css/base.css",
		"css/nav.css",
		"print.css",
		"small.css",
		"medium.css",
		"um-scheme.css",
		"um-gui.js",
		"js/base.js",
		"js/um-gui-lib.js",
		"inc/umplug-setup.php"
	);

	echo "<pre>";

	foreach ($files as $f) {
		$res = "copied";
		if (file_exists( get_template_directory() ."/". $f )):
		if (file_exists( UMPLUG_DIR. "prop/$f" )) { $res = "overwrited"; }
			echo "<code>".get_template_directory() . "/$f" . "</code> -> $res <br/><code>". UMPLUG_DIR ."prop/$f"."</code><br/>\n";
			copy(get_template_directory() . "/$f", UMPLUG_DIR ."prop/$f");
		endif;
	}

	echo "</pre>";
}
?>