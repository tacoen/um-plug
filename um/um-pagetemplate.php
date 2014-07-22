<?php

um_hp_register("um_ptemplate"); // wp-admin/admin.php?page=um_sync

function um_ptemplate() {
	um_adminpage_wrap("Page Templates","umplug_pagetemplate_lib",array()); 
}

function umplug_pagetemplate_lib() {
	$PTS = array();
	$upload_dir = wp_upload_dir(); $cpath = $upload_dir['basedir']."/page-templates";
	$cpts=glob("$cpath/*.php");
	$pts=glob(UMPLUG_DIR."prop/page-templates/*.php");
	$PTS = array_merge($cpts,$pts);
	echo "<p>Page Template for the theme, $cpath</p>";
	echo "<div class='postbox'>";
	echo "<ul class='um-list inside ptlist' data-dir='page-templates'>\n";
	foreach ($PTS as $pt) {
		$st=explode("/",$pt); $pt_fn=$st[count($st)-1];
		$sniff = get_sniff($pt);
		echo "<li class='no-icon' data-file='$pt'><i class='dashicons-format-aside um-dashicons icons'></i><strong>$pt_fn</strong>";
		if (file_exists(get_stylesheet_directory()."/$pt_fn")) { 
			echo "<span class='last'><button class='secondary' data='copy-ptemplate'>Rewrite</button></span><span>Exists</span>";
		} else { 
			echo "<span class='last'><button class='secondary' data='copy-ptemplate'>Copy</button></span><span>---</span>";
		}
		echo "<div class='view'><small>content:$sniff</small></div>";
		echo "</li>\n";
	}
	echo "</ul>\n";
	echo "</div>";
}