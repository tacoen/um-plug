<?php
/*
 * nothing but hardcore hash array
 *
 */

function umo_args() {
	return array(
		'opt'=> array(
			'text'=> 'Custom Options',
			'note' 	=> 'Several Customize Options',
			'field'	=> array(
				'nodash'=> array ('check','Dashboard','Remove NewsFeed from Dashboard',''),
				'nowphead'=> array ('check','WP Header','Remove unnecessary code from header',''),
				'wdtma'	=> array ('number','Widget','How Many Dynamic Widget',''),
				'layout'=> array ('selectfile','Layout','Layout Selections',get_stylesheet_directory()."/layouts"),
				'pback'	=> array ('check','Pingback','Allow Pingback',''),
			),
		),
		'feat'=> array(
			'text'=> 'Features',
			'note' 	=> 'Several Features',
			'field'	=> array(
				'umgui'	=> array ('check','JS','Load um-gui JS Libraries <small> &mdash; um-gui-lib.js</small>',''),
				'cssrd'	=> array ('check','CSS','Still Evaluate Normalize <small> &mdash; um-reset.css</small>',''),
				'ajaxwpl'=> array ('check','WP-Login','Use Ajax WP-Login <small> &mdash; require: um-gui-lib.js</small>',''),
				'umtag'	=> array ('check','Template Tag','Enable dynamic UM Template Tags',''),
			)
		),
		'umrw'=> array(
			'text'=> 'URL Rewrites',
			'note' 	=> 'Please revise your permalink after you make changes',
			'field'	=> array(
				'urlrw'	=> array ('check','URL Rewrite','Use ShortURL for resources',''),
				'wpinc'	=> array ('text','Use',' for WP-Includes URL','8'),
				'wplug'	=> array ('text','Use',' for Plugins URL','8'),
				'style'	=> array ('text','Use',' for Style sheet/Child URL','8'),
				'templ'	=> array ('text','Use',' for Template/Parent URL','8'),

			)
		)
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

function  um_postformat_args() {
	$a = array('aside','gallery','link','image','quote','status','video','audio','chat');
	sort($a); return $a;

}

function um_templatepart_args() {
	$a = array("post-header","post-footer","single-header","single-footer","archive","content");
	sort($a); return $a;
}

