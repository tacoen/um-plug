<?php
defined('ABSPATH') or die('Huh?');
/*
 * nothing but hardcore hash array
 *
 */
function umo_args() {

	if (file_exists(get_stylesheet_directory()."/static.css")) {
		$static_mtime = date("Y-m-d H:i P",filemtime( get_stylesheet_directory()."/static.css"));
	} else {
		$static_mtime = "n/a";
	}
	
	return array(
		'opt'=> array(
			'text'=> 'Custom Options',
			'note'	=> 'Because sometimes we hate being default',
			'field'	=> array(
				'nodash'=> array ('check','Minimize Dashboard Load','Remove NewsFeed and other stuff from WP-Admin Dashboard',''),
				'nowphead'=> array ('check','Minimize WP Header','Remove unnecessary code from header',''),
				'nowpabar' => array('check','WP Toolbar',"Disable WP Toolbar for all",''),
				'pback'	=> array ('check','Pingback','Allow Pingback',''),
				'umtag'	=> array ('check','UM-Tag','Enable dynamic UM Template Tags',''),
				'wdtma'	=> array ('number','Widget','How Many Dynamic Widget',''),
			),
		),
		'featcss'=> array(
			'text'=> 'CSS',
			'note'	=> 'Cascading Style Sheet Options',
			'field'	=> array(
				'umcss'	=> array ('check','UM-reset','Makes browsers render all elements more consistently and in line with modern standards.<br/><small>Warning! might render your working theme differently.</small>',''),
				'layout'=> array ('selectfile','Layout','Layout Selections',get_stylesheet_directory()."/layouts"),
				'schcss'=> array ('check','UM-scheme.css','Load customable colour schemes',''),
				'navcss'=> array ('check','UM-navui.css','Load main-navigation menu styles',''),
			)
		),
		'featjs'=> array(
			'text'=> 'JS',
			'note'	=> 'Extending Javascript FX and Helper',
			'field'	=> array(
				'umgui'	=> array ('check','UM-gui-lib','Load um-gui jQuery Libraries for FX and layout fix.',''),
				'ajaxwpl'=> array ('check','UM-login.js','Use Ajax WP-Login <small> &mdash; require: um-gui-lib.js</small>',''),
				'ajredir'=> array ('text','UM Login Redirect','<br><small>Relative Path will be nice<small>','30'),
			)
		),
		'umrw'=> array(
			'text'=> 'URL Rewrites',
			'note'	=> 'Please <a href="options-permalink.php">revise your permalink</a> after you make changes',
			'field'	=> array(
				'urlrw'	=> array ('check','URL Rewrite','Use ShortURL for resources',''),
				'wpinc'	=> array ('text','WP Includes','','8'),
				'wplug'	=> array ('text','Plugins','','8'),
				'templ'	=> array ('text','Template(Parent)','','8'),
				'style'	=> array ('text','Stylesheet(Child)','','8'),
			)
		),
		'devopt'=> array(
			'text'=> 'Sandbox',
			'note'	=> 'Developer candies until productions state',
			'field'	=> array(
				'owncdn'=> array ('check','Alter CDN','Use your own CDN resources (<a href="/wp-admin/plugin-editor.php?file=um-plug%2Fum%2Fcdn.php&plugin=um-plug%2Fum-plug.php">cdn.php</a>)',''),
				'noavatar'=> array ('check','No Gravatar','Disable Gravatar for faster development process',''),
				'cssrd'	=> array ('check','UM-reset.php','Evaluate um-reset.css <small>(Regenerate um-reset.css)</small>',''),
				'cssstatic'	=> array ('check','Static','Reduce load by use static generated stylesheet <small>(Last Generated:'.$static_mtime.')</small>',''),
			)
		)

	);
}
function um_rwvar_default() {
	return array(
		'wpinc' => 'i',
		'wplug' => 'g',
		'style' => 'c',
		'templ' => 'p',
	);
}
function um_urlrewrite_is() {
	return array (
		0 => array (
			'tag' => str_replace(home_url()."/",'',includes_url()),
			'mod' => um_getoption('wpinc')."/"
		),
		1 => array (
			'tag' => str_replace(home_url()."/",'',get_stylesheet_directory_uri()."/"),
			'mod' => um_getoption('style')."/"
		),
		2 => array (
			'tag' => str_replace(home_url()."/",'',get_template_directory_uri()."/"),
			'mod' => um_getoption('templ')."/"
		),
		3 => array (
			'tag' => str_replace(home_url()."/",'',plugins_url()."/"),
			'mod' => um_getoption('wplug')."/"
		)
	);
}
function um_postformat_args() {
	$a = array('aside','gallery','link','image','quote','status','video','audio','chat');
	sort($a); return $a;
}
function um_templatepart_args() {
	$a = array("post-header","post-footer","single-header","single-footer","archive","content");
	sort($a); return $a;
}

$undressme=array();
