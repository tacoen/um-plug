<?php
defined('ABSPATH') or die('Huh?');

function um_add_pagetemplate($n,$f) {
	$n=preg_replace("#.php#",'',$n); $n=ucfirst($n);
	um_file_putcontents($f,"<?php\n/*\n * Template Name: $n\n */\n\nget_header(); ?>\n\n<!-- contents -->\n\n<?php get_footer(); ?>");
}

function um_propcopy($f) {
	um_checktarget();
	copy(UMPLUG_DIR."/prop/".$f,get_stylesheet_directory()."/".$f);
	return "$f copied from UM-PLUG";
}

function um_newdir($d,$path) {
	if ($d == "parent") { $dir = get_template_directory(); }
	else { $dir = get_stylesheet_directory(); }
	mkdir($dir."/$path");
	return "$path created on $d";
}

function um_checktarget() {
	/* Always on child */
	if (!is_dir(get_stylesheet_directory()."/css")) { mkdir (get_stylesheet_directory()."/css"); }
	if (!is_dir(get_stylesheet_directory()."/js")) { mkdir (get_stylesheet_directory()."/js"); }
	if (!is_dir(get_stylesheet_directory()."/layouts")) { mkdir (get_stylesheet_directory()."/layouts"); }
}

function um_fodalink($type, $where, $f) {
	if ($type == "dir") { $act = "debug-touchdir"; } else { $act="debug-touch"; }
	$link = "<a href='#' data-act='$act' data-f='$f' data-d='debug-$where'>create</a>";
	return $link;
}

function um_foda_callback() {
	global $wpdb;
	$foda=$_POST['v']; $txt='';

	if ($foda['d']== 'chunk') {
		$upload_dir = wp_upload_dir();
		$file=$upload_dir['basedir']."/chunks/".$foda['f'];
		$dir=$upload_dir['basedir']. "/chunks";
		if (!file_exists($upload_dir['basedir']) and !is_dir($upload_dir['basedir'])) { mkdir($upload_dir['basedir']); }
		if (!file_exists($dir) and !is_dir($dir)) { mkdir($dir); }

	} else if ($foda['d']== 'page-templates') {

		$file=get_stylesheet_directory()."/page-templates/".$foda['f'];
		$dir=get_stylesheet_directory(). "/page-templates";
		if (!file_exists($dir) and !is_dir($dir)) { mkdir($dir); }

	} else if ($foda['d']== 'template-part') {

		$file=get_stylesheet_directory()."/template-part/".$foda['f'];
		$dir=get_stylesheet_directory(). "/template-part";
		if (!file_exists($dir) and !is_dir($dir)) { mkdir($dir); }

	} else if ($foda['d']== 'debug-core') {
		$dir=get_template_directory();
	} else if ($foda['d']== 'debug-child') {
		$dir=get_stylesheet_directory();
	} else {
		$file=get_stylesheet_directory()."/".$foda['f'];
	}

	if ($foda['a'] == 'ums-file') {
		
		
		if ($foda['f'] == "um-gui.js") { $txt .= um_propcopy('um-gui.js'); }
		if ($foda['f'] == "um-scheme.css") { $txt .= um_propcopy('um-scheme.css'); }
		if ($foda['f'] == "css/reset.css") { $txt .= um_propcopy('css/reset.css'); }
		if ($foda['f'] == "css/base.css") { $txt .= um_propcopy('css/base.css'); $txt .="<br/>". um_propcopy('css/nav.css'); }
		if ($foda['f'] == "css/um-gui-lib.css"){ $txt .= um_propcopy('css/um-gui-lib.css'); }
		if ($foda['f'] == "js/um-gui-lib.js"){ $txt .= um_propcopy('js/um-gui-lib.js'); }
		if ($foda['f'] == "js/base.js") { $txt .= um_propcopy('js/base.js'); }
		if ($foda['f'] == "inc/umplug-setup.php") { $txt .= um_propcopy('inc/umplug-setup.php'); }

	} else if ($foda['a']== 'ums-dir') {

		if ($foda['f'] == "layouts") { $txt .= um_newdir($foda['d'],"layouts"); }
		if ($foda['f'] == "page-templates") { $txt .= um_newdir($foda['d'],"page-templates"); }
		if ($foda['f'] == "template-part") { $txt .= um_newdir($foda['d'],"template-part"); }
		if ($foda['f'] == "umtag") { $txt .= um_newdir($foda['d'],"umtag"); }

	} else if ($foda['a']== 'del') {
		unlink($file); $txt="$file &mdash; Deleted";
	} else if ($foda['a']== 'edit') {
		um_textedit($foda['f'],$file);
		die;
	} else if ($foda['a']== 'newchunk') {
		um_textedit($foda['f'],$file);
		die;
	} else if ($foda['a']== 'save-chunk') {
		um_file_putcontents($file,$foda['text']);
		um_chunks_html($file." &mdash; saved",1);
		die();
	} else if ($foda['a']== 'touch') {
		if (!file_exists($file)) {
			touch($file); $txt="$file &mdash; touched";
		} else {
			$txt="$file &mdash; found,touch canceled";
		}
	} else if ($foda['a']== 'page-touch') {
		if (!file_exists($file)) {
			um_add_pagetemplate($foda['f'],$file);
			$txt="$file &mdash; created";
		} else {
			$txt="$file &mdash; found,touch canceled";
		}
	} else if ($foda['a']== 'addon') {
		update_option( "um_addonfor_".$foda['d'], $foda['f'] );
	}

	else { $txt=''; }

	/*
	//check_admin_referer('um_textedit');

	*/
	// Return page
	if ($foda['a']== 'page-touch') { um_toucher_html($txt,1); }
	else if ($foda['a']== 'touch') { um_toucher_html($txt,1); }
	else if ($foda['a']== 'addon') { um_pagetemplate_html($txt,1); }
	else if ($foda['a']== 'ums-file') { umplug_theme_checklist($txt,1); }
	else if ($foda['a']== 'ums-dir') { umplug_theme_checklist($txt,1); }
	else {
		if ($foda['d']== 'chunk') { um_chunks_html($txt,1); die(); }
		if ($foda['d']== 'debug') { um_debug_html($txt,1); die(); }
		if ($foda['d']== 'debug-child') { um_debug_html($txt,1); die(); }
		if ($foda['d']== 'debug-core') { um_debug_html($txt,1); die(); }
		else { um_toucher_html($txt,1); }

	}
/*
	else if ($foda['d']== 'debug') { um_debug_html($txt,1); }
	else if ($foda['d']== 'page-templates') { um_toucher_html($txt,1); }
	else { um_toucher_html($txt,1); }
*/

	die(); // ajax call ended
}

add_action('wp_ajax_foda','um_foda_callback');

?>