<?php
defined('ABSPATH') or die('Huh?');
/*
 * nothing but hardcore hash array
 *
 */
function umo_args() {
	return array(
		'opt'=> array(
			'text'=> 'Custom Options',
			'note'	=> 'Options that featuring you.',
			'field'	=> array(
				'owncdn'=> array ('check','Alter CDN','Use your own CDN resources (cdn.php)',''),
				'umcss'	=> array ('check','UM-reset','Makes browsers render all elements more consistently and in line with modern standards.<br/><small>Warning! might render your working theme differently.</small>',''),
				'umgui'	=> array ('check','UM-gui-lib','Load um-gui jQuery Libraries for FX and layout fix.',''),
				'urlrw'	=> array ('check','URL Rewrite','Use ShortURL for resources <small>You need to revise permalink after toggling this options</small>',''),
				'nodash'=> array ('check','Minimize Dashboard Load','Remove NewsFeed and other stuff from WP-Admin Dashboard',''),
			),
		),
		'ttag'=> array(
			'text'=> 'Templates',
			'note'	=> 'Templates Options',
			'field'	=> array(
				'umtag'	=> array ('check','Template Tag','Enable dynamic UM Template Tags',''),
				'nowphead'=> array ('check','Minimize WP Header','Remove unnecessary code from header',''),
				'wdtma'	=> array ('number','Widget','How Many Dynamic Widget',''),
				'pback'	=> array ('check','Pingback','Allow Pingback',''),
			)
		),
		'feat'=> array(
			'text'=> 'JS/CSS',
			'note'	=> 'Javascript & Cascading Style Sheet',
			'field'	=> array(
				'layout'=> array ('selectfile','Layout','Layout Selections',get_stylesheet_directory()."/layouts"),
				'cssrd'	=> array ('check','UM-reset.php','Evaluate um-reset.css <small>(Regenerate um-reset.css)</small>',''),
				'schcss'=> array ('check','UM-scheme.css','Use customable colour schemes',''),
				'ajaxwpl'=> array ('check','UM-login.js','Use Ajax WP-Login <small> &mdash; require: um-gui-lib.js</small>',''),
				'ajredir'=> array ('text','UM Login Redirect','<br><small>Relative Path will be nice<small>','30'),
			)
		),
		'umrw'=> array(
			'text'=> 'URL Rewrites',
			'note'	=> 'Please <a href="options-permalink.php">revise your permalink</a> after you make changes',
			'field'	=> array(
				'wpinc'	=> array ('text','Use',' for WP-Includes URL','8'),
				'wplug'	=> array ('text','Use',' for Plugins URL','8'),
				'style'	=> array ('text','Use',' for Style sheet/Child URL','8'),
				'templ'	=> array ('text','Use',' for Template/Parent URL','8'),
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