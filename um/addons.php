<?php
defined('ABSPATH') or die('Huh?');

/* um_plug addon registering */

$um_addons = array();
$addons = glob_recursive(UMPLUG_DIR."addons/*.php");
foreach($addons as $addon){ 
	include $addon;
}

array_push($undressme, array('title' => "UM Page Addons",'stitle' => "Page Addons",'slug' => "um_pagetemplate"));
function um_pagetemplate() { um_admin_header("Page Template Addons","um_pagetemplate_html",array()); }

function um_pagetemplate_html($div="",$js=0) {

	global $um_addons;

	$template =  glob( get_stylesheet_directory()."/page-templates/*.php");
	
	echo "<div class='um-debug'>";
	echo "<p>Select page addons for your page template.</p>";

	foreach ($template as $t) {
		$f = explode("/",$t); $n = count($f)-1; 
		$sel = get_option( "um_addonfor_".$f[$n] );
		echo "<p data-d='".$f[$n]."'><label>".$f[$n]."</label>";
		um_addonselect($sel);
		echo "<button class='button set' data-act='addon'>Set</button></p>";

	}
	echo "</div>";
	
	um_addon_list(); 
	
}

function um_addon_list() {
	global $um_addons; $select ="";
	echo "<h2>Add ons</h2>\n";
	echo "<ul class='feat'>\n";
	$A = array_keys($um_addons);
	foreach ($A as $a) {
		echo "<li><div class='meta'><h3>$a</h3>";

		echo "<div class='feat'>";
			if ( $um_addons[$a]['js'] ) { echo "<span class='js'>JS</span> "; }
			if ( $um_addons[$a]['css'] ) { echo "<span class='css'>CSS</span> "; }
		echo "</div></div>";

		if (file_exists ($um_addons[$a]['dir']."readme.txt")) { echo "<p>".um_file_getcontents($um_addons[$a]['dir']."readme.txt")."</p>"; }
		echo "<p><strong>Info:</strong> <a href='".$um_addons[$a]['url']."'>".$um_addons[$a]['url']."</a></p>";
		echo "</li>\n";
		
	}
	echo "</ul>\n";
}

function um_addonselect($sel) {
	global $um_addons; $select ="";
	$A = array_keys($um_addons);
	echo "<select name=''>\n";
	echo "<option value='none'>none</option>";
	foreach ($A as $a) {
		if ($a===$sel) { $select = " selected"; } else { $select =""; }
		echo "<option value='$a' $select>".$a."</a>\n";
	}
	echo "</select>\n";

}

function um_addon_init($addon_name) {
	global $um_addons;
	if ($um_addons[$addon_name]['js']) {
		wp_enqueue_script( $addon_name, $um_addons[$addon_name]['path'].$um_addons[$addon_name]['js'],array('jquery'), um_ver(), true );
	}
	if ($um_addons[$addon_name]['css']) {
		wp_enqueue_style ( $addon_name, $um_addons[$addon_name]['path'].$um_addons[$addon_name]['css'],false,um_ver(),"screen");
	}
}

function um_addon_setup() {
	$template =  glob( get_stylesheet_directory()."/page-templates/*.php");
	$current_pt =  basename(get_page_template());
	foreach ($template as $t) {
		$f = explode("/",$t); $n = count($f)-1; 
		$sel = get_option( "um_addonfor_".$f[$n] );
		if (($sel) && ($sel != "none")) {
			if ( $current_pt == $f[$n] ) { 
				um_addon_init($sel); 
			}
		}
	}
}
/* after_setup_theme give wrong page template
add_action('after_setup_theme', 'um_addon_setup');
*/


?>