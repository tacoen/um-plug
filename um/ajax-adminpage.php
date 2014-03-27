<?php
defined('ABSPATH') or die('Huh?');
function um_foda_callback() {
	global $wpdb;
	//check_admin_referer('um_textedit');
	$foda=$_POST['v']; $txt="";
	if ($foda['d']== 'chunk') {
		$file=get_stylesheet_directory()."/chunks/".$foda['f'];
	} else if ($foda['d']== 'page') {
		$file=get_stylesheet_directory()."/page-templates/".$foda['f'];
		$dir=get_stylesheet_directory(). "/page-templates";
		if (!file_exists($dir) and !is_dir($dir)) { mkdir($dir); }
	} else {
		$file=get_stylesheet_directory()."/".$foda['f'];
	}
	if ($foda['a']== 'del') {
		unlink($file); $txt="$file &mdash; Deleted";
	} else if ($foda['a']== 'edit') {
		um_textedit($foda['f'],$file);
		die;
	} else if ($foda['a']== 'newchunk') {
		um_textedit($foda['f'],$file);
		die;
	} else if ($foda['a']== 'save') {
		um_file_putcontents($file,$foda['text']);
	} else if ($foda['a']== 'touch') {
		if (!file_exists($file)) {
			touch($file); $txt="$file &mdash; touched";
		} else {
			$txt="$file &mdash; found,touch canceled";
		}
	} else if ($foda['a']== 'ptouch') {
		if (!file_exists($file)) {
			um_add_pagetemplate($foda['f'],$file);
			$txt="$file &mdash; created";
		} else {
			$txt="$file &mdash; found,touch canceled";
		}
	} else if ($foda['a']== 'dtouch') {
		$txt = "dtouch!";
		if ($foda['f'] == "um-gui.js") { $txt .= um_new_umguijs(); }
		if ($foda['f'] == "um-scheme.css") { $txt .= um_new_umschemecss(); }
		if ($foda['f'] == "layouts") { $txt .= um_new_layoutdir(); }
	} else { $txt=''; }
	if ($foda['d']== 'chunk') { um_chunks_html($txt,1); }
	else if ($foda['d']== 'debug') { um_debug_html($txt,1); }
	else { um_toucher_html($txt,1); }
	die(); // ajax call ended
}
add_action('wp_ajax_foda','um_foda_callback');
?>