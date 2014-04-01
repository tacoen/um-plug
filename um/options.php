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
				'wdtma'	=> array ('number','Widget','How Many additional Dynamic Widget <small>(Element-x)</small>',''),
			),
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
		'cdnopt'=> array(
			'text'=> 'CDN',
			'note'	=> 'Use your prefered cdn',
			'field'	=> array(
				'owncdn'=> array ('check','Alter CDN','Use your own CDN resources (<a href="'.admin_url().'plugin-editor.php?file=um-plug%2Fum%2Fcdn.php&plugin=um-plug%2Fum-plug.php">cdn.php</a>)',''),
				'opsfcdn' => array ('text','Open Sans','<br/><small>Webfont used by Wordpress 3.8.1<br>Blank it to use Wordpress default</small>','60'),
				'jqcdn'	=> array ('text','Jquery','<br/><small>um-gui-lib using Jquery 2.0</small>','60'),
				'gamirr'=> array ('text','Google','<br/><small>ajax.googleapis.com mirror, address only do not add http://,<br/>Blank it to disable</small>','60'),
			)
		),
		'devopt'=> array(
			'text'=> 'Developer',
			'note'	=> 'Developer candies until productions state',
			'field'	=> array(
				'umtag'	=> array ('check','UM-Tag','Enable dynamic UM Template Tags',''),
				'cssrd'	=> array ('check','UM-reset.php','Evaluate um-reset.css <small>(Regenerate um-reset.css)</small>',''),
				'noavatar'=> array ('check','No Gravatar','Disable Gravatar for faster development process',''),
				'cssstatic'	=> array ('check','Static','Reduce load by use static generated stylesheet <small>(Last Generated:'.$static_mtime.')</small>',''),
			)
		),
		
	);
}


function um_rwvar_default() {
	return array(
		'wpinc' => 'i',
		'wplug' => 'g',
		'style' => 'c',
		'templ' => 'p',
		'jqcdn' => 'http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js',
		'opsfcdn' => 'http://cdn.dibiakcom.net/font/opensans/style.css',
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
	$a = array("post-header","post-footer","single-header","single-footer");
	sort($a); return $a;
}

function um_template_args() {
	$a = array("archive","content");
	sort($a); return $a;
}

$undressme=array();
