<?php

function um_add_pagetemplate($n,$f) {
	$n=preg_replace("#.php#",'',$n); $n=ucfirst($n);
	um_file_putcontents($f,"<?php\n/*\n * Template Name: $n\n */\n\nget_header(); ?>\n\n<!-- contents -->\n\n<?php get_footer(); ?>");
}
function um_new_umguijs() {
	/* always to child lah*/
	um_file_putcontents(get_stylesheet_directory()."/um-gui.js", "(function($) {\n\n})(jQuery);");
	return get_stylesheet_directory()."/um-gui.js";
}

function um_blankcss($w) {
	$css = um_file_getcontents(UMPLUG_DIR."/prop/css/$w.css");
	/* always to child lah*/
	um_file_putcontents(get_stylesheet_directory()."/$w",$css);
	return get_stylesheet_directory()."/$w.css";
}

function um_new_layoutdir() {
	mkdir(get_stylesheet_directory()."/layouts");
}

?>