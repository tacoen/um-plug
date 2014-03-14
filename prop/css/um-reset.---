<?php 
require("build/heredoc.php");
header("content-type: text/css; charset: UTF-8");
$css = "/**\n * um - reset.css\n * Rev. ".date('Ymd.H')."\n *\n */\n";
$css .= css_include("build/necolas-normalize.css",1);
$css .= css_include("build/tacoen-reset-ui.css",1);
$css .= css_include("build/wp-reset.css",1);
$css .= "/* heredoc */\n";
$css .= css_compress( heredocs(),1)."\n";
$css .= css_include("build/style.css",1);
$css .= css_include("build/navmenus.css",1);

file_put_contents("um-reset.css",css_compress($css,0)); 
echo $css;
exit;

function css_include($f,$c=1) {
	if (file_exists($f)) {
		return "\n/* $f */\n".css_compress(file_get_contents($f),$c)."\n";
	}
}

function css_compress($buffer,$readable=0) {
	if ($readable != 1) { $readable = 0; }
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
	$buffer = preg_replace('#\"#','\'', $buffer);
	$buffer = preg_replace('#,{#','{', $buffer);
	$buffer = preg_replace('#[\r|\n|\t]#i', '', $buffer);
	if ($readable==1) $buffer = preg_replace('/}/', "}\n", $buffer);
	return $buffer;
}

?>