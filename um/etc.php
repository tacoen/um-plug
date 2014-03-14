<?php
defined('ABSPATH') or die('Huh?');
function none() {} //stupid solution!
$cssrd_php = UMPLUG_DIR."prop/css/um-reset.php";
$cssrd_dis = UMPLUG_DIR."prop/css/um-reset.---";
if (um_getoption('cssrd')) {
	if (!file_exists($cssrd_php)) { rename($cssrd_dis, $cssrd_php); }
} else {
	if (!file_exists($cssrd_dis)) { rename($cssrd_php, $cssrd_dis); }
}
if (um_getoption('nodash')) { add_action('wp_dashboard_setup','um_nodashboard_widgets'); }
if (um_getoption('nowphead')) { add_action('after_setup_theme' ,'um_wpheadtrim'); }
if (um_getoption('wdtma')) { add_action('widgets_init','um_elwidgets_init'); }
if (um_getoption('pback')) { add_action('wp_head','um_pingback'); }
if (file_exists(get_stylesheet_directory()."/favicon.ico")) { add_action('wp_head','um_favicon'); }
add_filter('admin_footer_text','um_footeradmin');

function um_nodashboard_widgets() {
	global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	//unset($wp_meta_boxes['dashboard']['side']['high']['dashboard_browsernag']);
}
function um_favicon() { echo '<link rel="shortcut icon" type="image/x-icon" href="' .get_stylesheet_directory_uri(). '/favicon.ico" />' . "\n"; }
function um_pingback() { echo '<link rel="pingback" href="'.site_url().'/xmlrpc.php">' . "\n"; }
function um_wpheadtrim() {
	remove_action('wp_head','wlwmanifest_link');
	remove_action('wp_head','rsd_link');
	remove_action('wp_head','wp_shortlink_wp_head');
	remove_action('wp_head','wp_generator');
	remove_action('wp_head','start_post_rel_link',10,0);
	remove_action('wp_head','adjacent_posts_rel_link',10,0);
	remove_action('wp_head','index_rel_link');
	remove_action('wp_head','adjacent_posts_rel_link');
}
function um_elwidgets_init() {
		$m=um_getoption('wdtma');
		for ($i=1; $i <=$m; $i++) {
		register_sidebar(array(
			'name'		=> 'Element-'.$i,
			'id'			=> 'element-'.$i,
			'before_widget'=> '<aside id="%1$s" class="widget %2$s">',
			'after_widget'=> '</aside>',
			'before_title'=> '<h1 class="widget-title">',
			'after_title'=> '</h1>',
		));
	}
}
function um_readme_html() {?>
	<div class="um-readme">
	<ul id="umtab"><li class="span">&nbsp;</li></ul>
	<div class="maketab">
	<div><h3 class="tab">About UM-PLUG</h3><?php
	if (file_exists(UMPLUG_DIR."prop/doc/readme.html")) {
		echo um_file_getcontents(UMPLUG_DIR."prop/doc/readme.html");
	} else {
		echo "Well, UM /prop/doc/readme.html is missing. It suppose to tell that you can <a href='/wp-admin/customize.php'>customize your theme</a>.";
	}?></div>

	<div><h3 class="tab">Readme</h3><?php
	if (file_exists(get_stylesheet_directory()."/readme.txt")) {
		echo "<pre><h3>".wp_get_theme()." - readme.txt</h3>".um_file_getcontents(get_stylesheet_directory()."/readme.txt")."</pre>";
	} else {
		echo "Well, child theme readme.txt is missing or there is no activated child theme.";
	} ?></div>

	<div><h3 class="tab">Credits</h3><?php
	if (file_exists(UMPLUG_DIR."prop/doc/feat.html")) {
		echo um_file_getcontents(UMPLUG_DIR."prop/doc/feat.html");
	} else {
		echo "Well, UM /prop/doc/feat.html is missing.";
	}?></div>

	</div>
	
	<h5>UM-Plug Ver. <?php echo um_ver(); ?></h5>
	
	<?php
}

function um_footeradmin () { 
	$credit = array(
		'Actualy <a href="http://www.wordpress.org">WordPress</a>, instead <a href="http://tacoen.github.io/UndressMe">UM</a>',
		'Hi <a href="http://www.wordpress.org">WordPress</a>! Hello <a href="http://tacoen.github.io/UndressMe">UM</a>!',
		'This <a href="http://www.wordpress.org">WordPress</a> with <a href="http://tacoen.github.io/UndressMe">UM</a>',
		'<a href="http://www.wordpress.org">WordPress</a> and <a href="http://tacoen.github.io/UndressMe">UM</a>',
		'Core: <a href="http://www.wordpress.org">WordPress</a>, Plugin: <a href="http://tacoen.github.io/UndressMe">UM</a>',
		'Much about <a href="http://www.wordpress.org">WordPress</a> than <a href="http://tacoen.github.io/UndressMe">UM</a>',
		'This <a href="http://www.wordpress.org">WordPress</a> with <a href="http://tacoen.github.io/UndressMe">UM</a>',
		'There were <a href="http://www.wordpress.org">WordPress</a> programmer whom <a href="http://tacoen.github.io/UndressMe">UM</a>',
	);
	shuffle($credit); echo $credit[0];
}
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

// Why I delete readme.html and license.txt? 
if (file_exists(ABSPATH."readme.html")) { unlink (ABSPATH."readme.html"); }
if (file_exists(ABSPATH."license.txt")) { unlink (ABSPATH."license.txt"); }
