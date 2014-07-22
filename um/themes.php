<?php
defined('ABSPATH') or die('Huh?');

umo_register(
	array( 'umt'
		=> array(
		'func' => "um_optionpages",
		'title' => "Theme Options",
		'option' => array (
			'base'=> array(
				'text'=> 'WP Base',
				'note'	=> 'Base on underscore.me(_s)',
				'field'	=> array(
					// id => array (type,label,text,defaults,mods,required);
					'noopsf' => array ('check','OpenSans','Unload Open-Sans Webfont.','','',''),
					'umcss'	=> array ('check','reset.css','Use reset.css (normalize)','','',''),
					'sfunc' => array ('check','base.css','Load Wordpress _s styles','','',''),
					'sfuncjs' => array ('check','base.js','Load Wordpress _s scripts','','',''),
					'snav' => array ('check','nav.css','Load Wordpress _s navigations styles','','',''),
					'layout'=> array ('selectfile','Layout','.css as layout',get_stylesheet_directory()."/layouts",'default',''),
				)
			),
			'umgui'=> array(
				'text'=> 'um-gui',
				'note'	=> 'um-gui Framework for Wordpress Templates',
				'field'	=> array(
					'umfont'=> array ('text','UM-GUI Webfont','<br/><small>Blank to unload</small>',um_tool_which('css/webfont.css'),'72',''),
					'umgui'	=> array ('check','um-gui','load UM-GUI-framework for WP(js + css)','','',''),
					'ajaxwpl'=> array ('check','um-login.js','Use Ajax WP-Login','','','umgui'),
					'ajredir'=> array ('text','Login Redirect','<br><small>Relative Path will be nice<small>','wp-admin/','30','ajaxwpl'),
					'schcss'=> array ('check','Colour Schemes','Enable/Load customable colour schemes','','',''),
					'iehtml5'=> array ('check','IE html5','Include html5 hack for IE9 and IE8','','',''),
				)
			),

		))
));

if(is_admin() && (isset( $umo["umt"])) ) { 

	$um_settings_page=new umplug_set( "umt", $umo["umt"] ); 

}

function um_instant() {
	if (file_exists(get_stylesheet_directory().'/css/reset.css')) { um_option_update('umt','umcss',1); }
	if (file_exists(get_stylesheet_directory().'/css/base.css')) { um_option_update('umt','sfunc',1);}
	if (file_exists(get_stylesheet_directory().'/css/nav.css')) { um_option_update('umt','snav',1);}
	if (file_exists(get_stylesheet_directory().'/css/webfont.css')) { um_option_update('umt','umfont',get_stylesheet_directory_uri().'/css/webfont.css');}
	if (file_exists(get_stylesheet_directory().'/um-scheme.css')) {um_option_update('umt','schcss',1); }
	if (file_exists(get_stylesheet_directory().'/js/base.js')) { um_option_update('umt','sfuncjs',1);}
	if (file_exists(get_stylesheet_directory().'/layouts/default.css')) { um_option_update('umt','layout','default.css'); }
	if (file_exists(get_stylesheet_directory().'/um-gui.js')) { um_option_update('umt','umgui',1); }
	unlink( get_stylesheet_directory().'/no-umplug.txt'); // needed for run-once
}

function um_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}

function um_iehtml5() {
	$output = '<!--[if lte IE 9]><link rel="stylesheet" href="' . um_tool_which('css/ie9.css').'" /><![endif]-->'."\n";
	$output .= '<!--[if lte IE 8]><script src="' . um_tool_which('js/html5shiv.js').'"></script><![endif]-->'."\n";
	echo $output;
}

function um_enqueue_style($deps) {
	wp_register_style(get_template().'-style',get_stylesheet_uri(),$deps,um_ver(),'all');
	wp_enqueue_style(get_template().'-style');
}

$um_static_css_already = false;
$um_static_js_already = false;

function umplug_register_styles() {

	$deps = array();
	
	if ( (!is_admin()) && ( um_getoption('noopsf','umt')) ) { 
		wp_deregister_style('open-sans'); 
	} else {
		wp_enqueue_style("open-sans"); 
	}

	if (um_getoption('umcss','umt')) {
		$deps = array('reset');
		wp_register_style('reset', um_tool_which('css/reset.css'),false,um_ver(),'all');
		wp_enqueue_style('reset');
	}

	if (um_getoption('sfunc','umt')) {
		wp_enqueue_style("base",um_tool_which('css/base.css'),$deps,um_ver(),'all');
	}

	if (um_getoption('snav','umt')) {
		wp_enqueue_style("base-nav",um_tool_which('css/nav.css'),$deps,um_ver(),'all');
	}

	if (um_getoption('umfont','umt')) {
		wp_enqueue_style('um-font', um_getoption('umfont','umt'),$deps,um_ver(),'all');
	}
		
	if (um_getoption('umgui','umt')) {
		wp_enqueue_style('um-gui', um_tool_which('css/um-gui-lib.css'),$deps,um_ver(),'all');
	}

	um_enqueue_style($deps);

	if (um_getoption('sfunc','umt')) {
		$layout = um_getoption('layout','umt');
		if ( ($layout !="none") && ($layout !='' ) && (file_exists(get_stylesheet_directory()."/layouts")) ) {
			wp_enqueue_style(get_template().'-layout', get_stylesheet_directory_uri()."/layouts/$layout", array(get_template().'-style'),um_ver(),'all');
		}
	}

	if ( (!is_admin()) && (um_getoption('schcss','umt')) ) {
		wp_enqueue_style(get_template().'-scheme',um_tool_which('um-scheme.css'),$deps,um_ver(),'all');
	}
	
	// Only if child theme
	if (file_exists(get_stylesheet_directory().'/child.css')) {
		wp_enqueue_style(get_stylesheet()."-child",get_stylesheet_directory_uri().'/child.css',false,um_tcore_ver(),'all');
	}

	wp_enqueue_style( get_stylesheet().'-print', um_tool_which('print.css'), $deps, um_ver() ,"print" );
	
	$mq_m = um_getoption('dmqmed');
	$mq_s = um_getoption('dmqsml');
			
	if (um_getoption('dmqmed')) { $mq_m = um_getoption('dmqmed'); } else { $mq_m = "800"; }
	if (um_getoption('dmqsml')) { $mq_s = um_getoption('dmqsml'); } else { $mq_s = "540"; }

	
	if ($mq_m) {
		wp_enqueue_style( get_stylesheet().'-medium', um_tool_which('medium.css'), $deps, um_ver() ,"screen and (max-width: ".$mq_m."px)" );
	}

	if ($mq_s) {
		wp_enqueue_style( get_stylesheet().'-small', um_tool_which('small.css'), $deps, um_ver() ,"screen and (max-width: ".$mq_s."px)" );
	}

}

function umplug_register_scripts() {

	if (um_getoption('umgui','umt')) {
		wp_enqueue_script(get_template().'-gui-lib',um_tool_which('js/um-gui-lib.js'),array('jquery'),um_ver(),false);
		wp_enqueue_script(get_template().'-gui',um_tool_which('um-gui.js'),array('um-gui-lib'),um_ver(),true);

		if (um_getoption('dmqmed')) { $mq_m = um_getoption('dmqmed'); } else { $mq_m = "800"; }
		if (um_getoption('dmqsml')) { $mq_s = um_getoption('dmqsml'); } else { $mq_s = "540"; }

		wp_localize_script(get_template().'-gui-lib','umgui_var',array(
			'small'=> $mq_s,
			'medium'=> $mq_m,
		));
	}

	if (um_getoption('sfuncjs','umt')) {
		wp_enqueue_script( get_template().'-base', um_tool_which('js/base.js'), array(), um_ver(), true );
	}

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

}

add_action('widgets_init', 'um_remove_recent_comments_style');
add_action('wp_enqueue_scripts','umplug_register_scripts',PHP_INT_MAX);
add_action('wp_enqueue_scripts','umplug_register_styles',PHP_INT_MAX);

if (um_getoption('iehtml5','umt')) { add_action('wp_head','um_iehtml5'); }
if (um_getoption('ajaxwpl','umt')) { require(UMPLUG_DIR.'um/ajax-wplogin.php'); }