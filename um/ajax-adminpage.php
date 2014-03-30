<?php
defined('ABSPATH') or die('Huh?');

function um_fodalink($type, $where, $f) {
	if ($type == "dir") { $act = "debug-touchdir"; } else { $act="debug-touch"; }
	$link = "<a href='#' data-act='$act' data-f='$f' data-d='debug-$where'>create</a>";
	return $link;
}

function um_foda_callback() {
	global $wpdb;
	$foda=$_POST['v']; $txt="";

	if ($foda['d']== 'chunk') {
	
		$file=get_stylesheet_directory()."/chunks/".$foda['f'];
		$dir=get_stylesheet_directory(). "/chunks";
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

	if ($foda['a'] == 'debug-touch') {

		if ($foda['f'] == "um-gui.js")     { $txt .= um_new_umguijs(); }
		if ($foda['f'] == "um-scheme.css") { $txt .= um_blankcss('um-scheme.css'); }
		if ($foda['f'] == "um-navui.css")  { $txt .= um_blankcss('um-navui.css'); }

	} else if ($foda['a']== 'debug-touchdir') {
		
		if ($foda['f'] == "layouts") { $txt .= um_new_layoutdir(); }
	
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
		um_chunks_html($file."&mdash saved",1);
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
	if ($foda['a']== 'page-touch') { um_toucher_html($txt,1);  }
	else if ($foda['a']== 'touch') { um_toucher_html($txt,1);  }
	else if ($foda['a']== 'addon') { um_pagetemplate_html($txt,1); }
	else { 
		if ($foda['d']== 'chunk') { um_chunks_html($txt,1); die(); } 
		if ($foda['d']== 'debug')        { um_debug_html($txt,1); die(); } 
		if ($foda['d']== 'debug-child')  { um_debug_html($txt,1); die(); } 
		if ($foda['d']== 'debug-core')   { um_debug_html($txt,1); die(); } 
		
		else { um_toucher_html($txt,1);  }
	
	}
/*
	else if ($foda['d']== 'debug') { um_debug_html($txt,1);  }
	else if ($foda['d']== 'page-templates') { um_toucher_html($txt,1);  }
	else  { um_toucher_html($txt,1);  }
*/
	
	die(); // ajax call ended
}
add_action('wp_ajax_foda','um_foda_callback');
?>