<?php
defined('ABSPATH') or die('Huh?');
array_push($undressme,array('title' => "UM Debug and Test",'stitle' => "Checklist",'slug' => "um_debug"));
function um_debug() { um_admin_header("Checklist","um_debug_html",array()); }

function um_debug_html($div="",$js=0) {?>
	<p>Check Themes compability againts UM-PLUG.</p>
	<div class="postbox"><h3 class="inside">Checklist</h3>
	<ul class='inside um-list' data-dir="debug"><?php

	$checklist = array (
		1 => array('dir','template-tags','core','back','nocreate'),
		2 => array('dir','page-templates','child','back','nocreate'),
		3 => array('dir','template-part','child','back','nocreate'),
		4 => array('dir','css','core','back','nocreate'),
		5 => array('file','css/um-reset.css','core','','nocreate'),
		6 => array('file','css/um-reset.php','core','back','nocreate'),
		7 => array('file','um-scheme.css','child','',''),
		8 => array('file','um-navui.css','child','',''),
		9 => array('file','um-gui.js','child','',''),
		10 => array('dir','layouts','child','',''),
		11 => array('file','static.css','child','back','nocreate'),
		0 => array('file','favicon.ico','child','back','nocreate'),

	);
	
	if ( get_stylesheet_directory() == get_template_directory() ) {
		echo "<li class='noicon'><em class='err'>Warning!</em> &mdash; You are using parent theme";
		if ( ! file_exists(get_template_directory()."/um-core.txt")) {
			echo " and the parents wasn't UM-Core.";
		}
		echo ". </li>\n";
	}

	$w=count(array_keys($checklist)); $i=0;
	for ($i; $i<$w; $i++) {
		$item = $checklist[$i];

		echo "<li class='noicon'>";
		echo "<label class='".$item[0]."'>".$item[1]."</label>";
		
		if ( ( get_stylesheet_directory() == get_template_directory() ) && ( $item[2] == "child" ) ) {
			echo "<span class='res'><i class='dashicons dim dashicons-wordpress-alt' title='Better on child theme'></i></span>";
		} else {
			echo "<span class='res'><i class='dashicons dim dashicons-wordpress'></i></span>";
		}

		echo "<span class='res'>$item[0]</span><span class='res'>$item[2]</span>";

		if ($item[2]!="core") { 
			$res = um_childcheck( $item[1], $item[0], $item[4],$item[3] ); 
		} else { 
			$res = um_corecheck( $item[1], $item[0], $item[4],$item[3] ); 
		}

		echo "<span class='res'>$res</span>";

		if ($item[3]!="back") { echo "<span class='uri'><code>". um_tool_which($item[1]) ."</code></span>"; }

		echo "</li>\n";
	}

	?></ul></div><div id="toucher"><?php echo $div; ?>&nbsp; </div><?php
	if ($js== 1) { ?><script type="text/javascript">umlist_function_init('.um-frame-box')</script><?php }
	
}

function um_childcheck($item,$type,$check,$m) {
	$res = "";
	if ($type == "dir") {
		if ( is_dir(get_stylesheet_directory()."/".$item ) ) {
			$res = "<i class='dashicons dashicons-yes' title='ok'></i>";
		} else {
			if ($check!="nocreate") { $res = um_fodalink('dir','child',$item); } else { $res="<i title='Use Template Tools to create' class='dashicons dashicons-info'></i>"; }
		}
	} else {

		if ( file_exists(get_stylesheet_directory()."/".$item) ) {
				$res = "<i class='dashicons dashicons-yes' title='ok'></i>";
		} else {
			if ($check!="nocreate") { $res = um_fodalink('file','child',$item); } else { $res="<i title='Use Template Tools to create' class='dashicons dashicons-info'></i>"; }
			if ($m == "back") { $res="<i title='N/A &mdash; Must create manually' class='dashicons dashicons-no'></i>"; }
		}
	}
	return $res;
}

function um_corecheck($item,$type,$check,$m) {
	$res = "";
	if ($type == "dir") {
		if ( is_dir(get_template_directory()."/".$item ) ) {
			$res = "<i class='dashicons dashicons-yes' title='ok'></i>";
		} else {
			if ($check!="nocreate") { $res = um_fodalink('dir','core',$item); } else { $res="<i title='Are you using um-core?' class='dashicons dashicons-editor-help'></i>"; }
		}
	} else {

		if ( file_exists(get_template_directory()."/".$item) ) {
				$res = "<i class='dashicons dashicons-yes' title='ok'></i>";
		} else {
			if ($check!="nocreate") { $res = um_fodalink('file','core',$item); } else { 
				if ($item != "css/um-reset.php") {
					$res="<i title='Are you using um-core?' class='dashicons dashicons-editor-help'></i>"; 
				}
			}
		}
	}
	return $res;
}
