<?php
defined('ABSPATH') or die('Huh?');
array_push($undressme,array('title' => "UM Debug and Test",'stitle' => "Checklist",'slug' => "um_debug"));
function um_debug() { um_admin_header("Checklist","um_debug_html",array()); }

function um_debug_html($div="",$js=0) {?>
	<div class="postbox"><h3 class="inside">Checklist</h3><ul class='inside um-list' data-dir="debug"><?php

	$checklist = array (
		1 => array('dir','template-tags','core','back',''),
		2 => array('dir','page-templates','child','back',''),
		3 => array('dir','template-part','child','back',''),
		4 => array('file','css/um-reset.css','core','','nocreate'),
		5 => array('file','css/um-reset.php','core','back','nocreate'),
		6 => array('file','um-scheme.css','child','',''),
		7 => array('file','um-navui.css','child','',''),
		8 => array('file','um-gui.js','child','',''),
		9 => array('dir','layouts','child','',''),
		10 => array('file','static.css','child','nocreate'),
		0 => array('file','favicon.ico','child','back','nocreate'),

	);

	$w=count(array_keys($checklist)); $i=0;
	for ($i; $i<$w; $i++) {
		$item = $checklist[$i];
			if ($item[2]!="core") { $res = um_childcheck( $item[1], $item[0], $item[4] ); } else { $res = um_corecheck( $item[1], $item[0], $item[4] ); }
			echo "<li class='noicon'><label class='".$item[0]."'>".$item[1]."</label> <span class='res'>$res</span> <span class='res'>$item[2]</span>";
			if ($item[3]!="back") { echo "<span class='uri'><code>". um_tool_which($item[1]) ."</code></span>"; }
			echo "</li>\n";
	}

	?></ul></div><div id="toucher"><?php echo $div; ?>&nbsp; </div><?php
	if ($js== 1) { ?><script type="text/javascript">umlist_function_init('.um-frame-box')</script><?php }
}

function um_childcheck($item,$type,$check) {
	$res = "";
	if ($type == "dir") {
		if ( is_dir(get_stylesheet_directory()."/".$item ) ) {
			$res = "<i class='dashicons dashicons-yes'></i>";
		} else {
			if ($check!="nocreate") { $res = "create-dir"; } else { $res="<i class='dashicons dashicons-info'></i>"; }
		}
	} else {

		if ( file_exists(get_stylesheet_directory()."/".$item) ) {
				$res = "<i class='dashicons dashicons-yes'></i>";
		} else {
			if ($check!="nocreate") { $res = "create"; } else { $res="<i class='dashicons dashicons-info'></i>"; }
		}
	}
	return $res;
}

function um_corecheck($item,$type,$check) {
	$res = "";
	if ($type == "dir") {
		if ( is_dir(get_template_directory()."/".$item ) ) {
			$res = "<i class='dashicons dashicons-yes'></i>";
		} else {
			if ($check!="nocreate") { $res = "create-dir"; } else { $res="<i class='dashicons dashicons-info'></i>"; }
		}
	} else {

		if ( file_exists(get_template_directory()."/".$item) ) {
				$res = "<i class='dashicons dashicons-yes'></i>";
		} else {
			if ($check!="nocreate") { $res = "create"; } else { $res="<i class='dashicons dashicons-info'></i>"; }
		}
	}
	return $res;
}


function umplug_checklist() {
	$checklist = array (
		0 => array('file','um-scheme.css'),
		1 => array('file','um-gui.js'),
		2 => array('dir','layouts'),
		3 => array('dir','template-tags'),
	);
	$w=count(array_keys($checklist)); $i=0;

	if (get_template_directory() != get_stylesheet_directory()) {
		echo "<li class='noicon'><i class='dashicons dashicons-yes'></i> <b>Child Theme</b></li>";
	}

	for ($i; $i<$w; $i++) {
		$item = $checklist[$i];
		$mc =""; 
		if ($item[0]=="dir") {
			if ((file_exists(get_stylesheet_directory()."/".$item[1])) 
				&& (is_dir(get_stylesheet_directory()."/".$item[1]))) { 
					$ce = "Exist"; $di="yes"; 
			} else { 
					$di="no"; $ce="Not Found (".um_toucher_link($item[0],$item[1]) .") "; 
			}
			if ($item[1]=="template-tags") {
			if ((file_exists(get_template_directory()."/".$item[1])) 
				&& (is_dir(get_template_directory()."/".$item[1]))) { 
					$ce = "Exist (in Parent directory) "; $di="yes"; 
			} else { 
					$di="no"; $ce="Not Found(in Parent directory) (".um_toucher_link($item[0],$item[1]."-parent") .")"; 
			}
			}
		} else {
			if (file_exists(get_stylesheet_directory()."/".$item[1])) { 
				$ce = "Exist"; $di="yes"; 
			} else { 
				$di="no"; $ce="Not Found (".um_toucher_link($item[0],$item[1]) ."  or fall-back to parent)"; 
			}
		}
		echo "<li class='noicon' data-file='$item[1]'><i class='dashicons dashicons-$di'></i> <b>$item[1]</b> &mdash; $item[0]: $ce</li>";
	}
	if (file_exists(get_stylesheet_directory()."/favicon")) {
		echo "<li class='noicon'><i class='dashicons dashicons-yes'></i> <b>favicon.ico</b> found, included in WP Header</li>";
	} else {
		echo "<li class='noicon'><i class='dashicons dashicons-no'></i> <b>favicon.ico</b> not found in Theme Directory";
	}
}

/*	
	<table class="wp-list-table widefat plugins" cellspacing="0">
	<thead>
	<tr>
		<th scope="col" id="compond" class="manage-column column-name">&nbsp;</th>
		<th scope="col" id="name" class="manage-column column-description">Plugins</th>
		<th scope="col" id="name" class="manage-column column-description">Parent</th>
		<th scope="col" id="description" class="manage-column column-description">Child</th>
	</tr>
	</thead>

	<tfoot>
	<tr>
		<th scope="col" id="compond" class="manage-column column-name">&nbsp;</th>
		<th scope="col" id="name" class="manage-column column-description">Plugins</th>
		<th scope="col" id="name" class="manage-column column-description">Parent</th>
		<th scope="col" id="description" class="manage-column column-description">Child</th>
	</tr>
	</tfoot>
	
	<tbody class="um-table">
		<tr>
			<th scope="row">ID</th>
			<td><h4>UM-Plug</h4></td>
			<td><h4><?php echo get_template(); ?></h4></td>
			<td><h4><?php echo wp_get_theme(); ?></h4></td>
		</tr>
		<tr>
			<th scope="row">Path</th>
			<td><?php echo UMPLUG_DIR; ?></td>
			<td><?php echo get_template_directory(); ?></td>
			<td><?php echo get_stylesheet_directory(); ?></td>
		</tr>
		<tr>
			<th scope="row">URI</th>
			<td><?php echo UMPLUG_URL;?></td>
			<td><?php echo get_template_directory_uri();?></td>
			<td><?php echo get_stylesheet_uri();?></td>
		</tr>

	</tbody>
	</table>	
*/