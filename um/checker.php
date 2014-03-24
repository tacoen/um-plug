<?php
defined('ABSPATH') or die('Huh?');
array_push($undressme,array('title' => "UM Debug and Test",'stitle' => "Checklist",'slug' => "um_debug"));
function um_debug() { um_admin_header("Checklist","um_debug_html",array()); }
function um_debug_html($div="",$js=0) {
	$nonce=wp_create_nonce('um_textedit'); ?>
	<div class="um-debug"><?php
	echo "<p><label>Plugins Dir:</label><code>". UMPLUG_DIR ."</code><br/>".UMPLUG_URL."</p>";
	if (get_stylesheet_directory()==get_template_directory()) {
		echo "<p><label>Template Dir:</label><code>".get_template_directory() ."</code><br/>".get_template_directory_uri() ."</p>";
	} else {
		if (file_exists(get_template_directory()."/um-core.txt")) {
			echo "<p><label>Template Dir(Parent):</label><code>".get_template_directory() ."</code><br/>".get_template_directory_uri() ." &mdash; its has um-core tag</p>";
		}
		echo "<p><label>Theme Dir(Child):</label><code>".get_stylesheet_directory() ."</code><br/>".get_stylesheet_uri()."</p>";
	}?>
	<?php echo "<p><label>ABSPATH:</label><code>".ABSPATH."</code><br/>".home_url()."</p>";?>
	</div>
	<div class="postbox"><h3 class="inside">Checklist</h3><ul class='inside um-list' data-dir="debug"><?php
	umplug_checklist();
	?></ul></div><div id="toucher"><?php echo $div; ?>&nbsp; </div><?php
	if ($js== 1) { ?><script type="text/javascript">umlist_function_init('.um-frame-box')</script><?php }
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