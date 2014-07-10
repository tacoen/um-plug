<?php

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
	"js/um-gui-lib.js"
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
?>