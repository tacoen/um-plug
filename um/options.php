<?php
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
				'nodash'=> array ('check','Dashboard','Remove NewsFeed from Dashboard',''),
				'umcss'	=> array ('check','CSS','Use um-reset.css',''),
				'umgui'	=> array ('check','JS','Load um-gui JS Libraries <small> &mdash; um-gui-lib.js</small>',''),
				'urlrw'	=> array ('check','URL Rewrite','Use ShortURL for resources',''),
				'owncdn'=> array ('check','Alter CDN','Use your own CDN resources (cdn.php)',''),
			),
		),
		'ttag'=> array(
			'text'=> 'Templates',
			'note'	=> 'Templates Options',
			'field'	=> array(
				'umtag'	=> array ('check','Template Tag','Enable dynamic UM Template Tags',''),
				'nowphead'=> array ('check','WP Header','Remove unnecessary code from header',''),
				'wdtma'	=> array ('number','Widget','How Many Dynamic Widget',''),
				'pback'	=> array ('check','Pingback','Allow Pingback',''),
			)
		),
		'feat'=> array(
			'text'=> 'JS/CSS',
			'note'	=> 'Javascript & Cascading Style Sheet',
			'field'	=> array(
				'layout'=> array ('selectfile','Layout','Layout Selections',get_stylesheet_directory()."/layouts"),
				'cssrd'	=> array ('check','Edit CSS Reset','Still Evaluate um-reset.css<small> &mdash; um-reset.php</small>',''),
				'ajaxwpl'=> array ('check','WP-Login','Use Ajax WP-Login <small> &mdash; require: um-gui-lib.js</small>',''),
				'ajredir'=> array ('text','WP-Login Redirect','','30'),
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

