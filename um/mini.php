<?php
defined('ABSPATH') or die('Huh?');

function um_makestatic($csses) {

	require_once(ABSPATH . 'wp-admin/includes/file.php');

	$ncss = array();$static ="";
	foreach ($csses as $css) {
		$css = preg_replace("#".site_url()."/#","",$css);
		$static .= css_include(ABSPATH.$css,1);
		//array_push($ncss,$css_file);
	}

	um_file_putcontents_nos(get_stylesheet_directory()."/static.css",css_compress($static,0)); 	

}

function um_makestaticJS($jses) {


	require_once(ABSPATH . 'wp-admin/includes/file.php');
	$ncss = array();$static ="";
	foreach ($jses as $js) {
		$js = preg_replace("#".site_url()."/#","",$js);
		$static .= js_include(ABSPATH.$js,1);
	}

	um_file_putcontents_nos(get_stylesheet_directory()."/static.js",js_compress($static,0)); 	

}

function css_include($f,$c=1) {
	if (file_exists($f)) {
		return "\n/* $f */\n".css_compress(join("",file($f)),$c)."\n";
	}
}

function js_include($f,$c=1) {
	if (file_exists($f)) {
		return "\n/* $f */\n".js_compress(join("",file($f)),$c)."\n";
	}
}

function js_compress($buffer,$cl=0) {
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		$buffer = preg_replace("/\/\/(.+)$/m",'', $buffer);
		$buffer = preg_replace('#\t#', '', $buffer);
		$buffer = preg_replace('/^\s+$/', '', $buffer);
		$buffer = preg_replace('#\s\s+#', '', $buffer);
		$buffer = preg_replace("/(\s+)?(=|:|;|,|\}|\{|\)|\(|\+)(\s+)?/m", '\\2', $buffer);
	return $buffer;
}

function css_compress($buffer,$readable=0) {
	if ($readable != 1) { $readable = 0; }
	$buffer = str_replace("\\", 'UM_TT', $buffer);
	$buffer = preg_replace('#\"#','\'', $buffer);
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	$buffer = preg_replace('#\s\s+#',' ', $buffer);
	$buffer = preg_replace('#^\s+#','', $buffer);
	$buffer = preg_replace('#(\s+>\s+)|(\s?>\s?)#', '>', $buffer);
	$buffer = preg_replace('#(\s+;\s+)|(\s?;\s?)#', ';', $buffer);
	$buffer = preg_replace('#(\s+:\s+)|(\s?:\s?)#', ':', $buffer);
	$buffer = preg_replace('#(\s+{\s+)|(\s?{\s?)#', '{', $buffer);
	$buffer = preg_replace('#(\s+}\s+)|(\s?}\s?)#', '}', $buffer);
	$buffer = preg_replace('#(\s+,\s+)|(\s?,\s?)#', ',', $buffer);
	$buffer = preg_replace('#;}#','}', $buffer);
	$buffer = preg_replace('#,{#','{', $buffer);
	$buffer = preg_replace('#[\r|\n|\t]#i', '', $buffer);
	if ($readable==1) $buffer = preg_replace('/}/', "}\n", $buffer);
	$buffer = str_replace("UM_TT", "\\", $buffer);
	return $buffer;
}
