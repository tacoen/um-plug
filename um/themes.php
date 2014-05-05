<?php
defined('ABSPATH') or die('Huh?');

umo_register(
	array( 'umt'
		=> array(
		'func' => "um_optionpages",
		'title' => "Theme Options",
		'option' => array (
			'feat'=> array(
				'text'=> 'Features',
				'note'	=> 'Theme Features',

				'field'	=> array(
					// id => array (type,label,text,defaults,mods,required);
					'noopsf' => array ('check','OpenSans','Unload Open-Sans Webfont.','','',''),
					'umcss'	=> array ('check','reset.css','Use reset.css (normalize)','','',''),
					'sfunc' => array ('check','default.css','Load Wordpress Default-styles (base on _s)','','',''),
					'layout'=> array ('selectfile','Layout','.css as layout',get_stylesheet_directory()."/layouts",'','sfunc'),
					'schcss'=> array ('check','Colour Schemes','Enable/Load customable colour schemes','','',''),
					'iehtml5'=> array ('check','IE html5','Include html5 hack for IE9 and IE8','','',''),
				)
			),
			'umgui'=> array(
				'text'=> 'um-gui',
				'note'	=> 'um-gui Framework for Wordpress, Require um-gui',
				'field'	=> array(
					'umgui'	=> array ('check','um-gui','load UM-GUI-framework for WP(js + css)','','',''),
					'ajaxwpl'=> array ('check','um-login.js','Use Ajax WP-Login','','','umgui'),
					'ajredir'=> array ('text','Login Redirect','<br><small>Relative Path will be nice<small>','wp-admin/','30','ajaxwpl'),
				)
			),
			'devel'=> array(
				'text'=> 'Min',
				'note'	=> 'Minified your style and javascripts, and make them static',
				'field'	=> array(
					// id => array (type,label,text,defaults,mods,required);
					'makes'	=> array ('check', 'Makes', 'Generated static-minified-unpretty css and js.','','','umcss'),
					'zlevel'	=> array ('number', 'compress level', 'CSS Compress level, <small>0 - unreadable, 1 - readable</small>','0','','makes'),
					'cssstatic'	=> array (
						'check', 'use static.css', 'Last Generated: '.
						get_mtime( get_stylesheet_directory()."/static.css") .
						" [<a href='".get_stylesheet_directory_uri()."/static.css'>View</a>]",'','','makes'),
					'jsstatic'	=> array ('check','use static.js','Last Generated: '.
						get_mtime( get_stylesheet_directory()."/static.js") .
						" [<a href='".get_stylesheet_directory_uri()."/static.js'>View</a>]" .
						" and [<a href='".get_stylesheet_directory_uri()."/static-foot.js'>View</a>]"
						,'','','makes'),
				)
			),
		))
));

if(is_admin() && (isset( $umo["umt"])) ) { $my_settings_page=new um_set( "umt", $umo["umt"] ); }

function um_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}

function um_iehtml5() {
	$output = '<!--[if lte IE 9]><link rel="stylesheet" href="' . um_tool_which('css/ie9.css').'" /><![endif]-->'."\n";
	$output .= '<!--[if lte IE 8]><script src="' . um_tool_which('js/html5shiv.js').'"></script><![endif]-->'."\n";
	echo $output;
}

function css_url_care($txt,$f) {
	$url = preg_replace('/(.+\/).+/','\\1',$f);
	$txt = preg_replace('/(\s|,|:)url(\W+)/','\\1url\\2'.$url,$txt);
	return $txt;
}

function um_enqueue_style($deps) {
	wp_register_style(get_template().'-style',get_stylesheet_uri(),$deps,um_ver(),'all');
	wp_enqueue_style(get_template().'-style');
}

$um_static_css_already = false;
$um_static_js_already = false;

function umplug_register_styles() {

	$deps = array();
	global $um_static_css_already;
	$theme_style_enqueue = false;
	
	if ( (!is_admin()) && (um_getoption('noopsf','umt')) ) { wp_deregister_style('open-sans'); }

	if ( (!is_admin()) && 
	     (file_exists(get_stylesheet_directory()."/static.css")) && 
		 (um_getoption('cssstatic','umt'))
		) {

		$um_static_css_already = true;

		wp_register_style(get_template().'-style',get_stylesheet_directory_uri()."/static.css",$deps,um_ver(),'all');
		wp_enqueue_style(get_template().'-style');

	} else {

		if (um_getoption('umcss','umt')) {
			$deps = array('um-reset');
			wp_register_style('um-reset', um_tool_which('reset.css'),false,um_ver(),'all');
			wp_enqueue_style('um-reset');
		}

		if (um_getoption('sfunc','umt')) {
			wp_enqueue_style("default",um_tool_which('css/default.css'),$deps,um_ver(),'all');
			wp_enqueue_style("default-nav",um_tool_which('css/default-nav.css'),$deps,um_ver(),'all');
		}

		if (um_getoption('umgui','umt')) {
			wp_enqueue_style('um-font', um_tool_which('css/webfont.css'),$deps,um_ver(),'all');
			wp_enqueue_style('um-gui', um_tool_which('css/um-gui-lib.css'),$deps,um_ver(),'all');
		}

		if (!$theme_style_enqueue) {
			um_enqueue_style($deps);
		}

		if (um_getoption('sfunc','umt')) {
			$layout = um_getoption('layout','umt');
			if ( ($layout !="none") && ($layout !='' ) && (file_exists(get_stylesheet_directory()."/layouts")) ) {
				wp_enqueue_style(get_template().'-layout', get_stylesheet_directory_uri()."/layouts/$layout", array(get_template().'-style'),um_ver(),'all');
			}
		}

		if ( (!is_admin()) && (um_getoption('schcss','umt')) ) {
			wp_enqueue_style(get_template().'-scheme',um_tool_which('um-scheme.css'),$deps,um_ver(),'all');
		}

	}

}

function umplug_register_scripts() {

	global $um_static_js_already;
	
	if ((file_exists(get_stylesheet_directory()."/static.js")) && (um_getoption('jsstatic','umt'))) {

		wp_enqueue_script(get_template().'-js',get_stylesheet_directory_uri()."/static.js",false,um_ver(),false );
		wp_enqueue_script(get_template().'-foot-js',get_stylesheet_directory_uri()."/static-foot.js",false,um_ver(),true );
		$um_static_js_already=true;

	} else {

		if (um_getoption('umgui','umt')) {
			wp_enqueue_script('um-gui-lib',um_tool_which('js/um-gui-lib.js'),array('jquery'),um_ver(),false);
			wp_enqueue_script('um-gui',um_tool_which('um-gui.js'),array('um-gui-lib'),um_ver(),true);
		}

		if (um_getoption('sfunc','umt')) {
			wp_enqueue_script( '_s', um_tool_which('js/default.js'), array(), um_ver(), true );
		}

		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}

	}
}

add_action('widgets_init', 'um_remove_recent_comments_style');
add_action('wp_enqueue_scripts','umplug_register_scripts');
add_action('wp_enqueue_scripts','umplug_register_styles');

if (um_getoption('iehtml5','umt')) { add_action('wp_head','um_iehtml5'); }
if (um_getoption('ajaxwpl','umt')) { require(UMPLUG_DIR.'um/ajax-wplogin.php'); }

if ((um_getoption('makes','umt')) && (!is_admin()) ) {

	//force create - condition: option checked, but file not existed
	if ( (um_getoption('cssstatic','umt')==1) && (!file_exists(get_stylesheet_directory()."/static.css")) ) {
		add_filter('print_styles_array', 'um_style_makestatic');
	}

	if ( (um_getoption('jsstatic','umt')==1) && (!file_exists(get_stylesheet_directory()."/static.js")) ) {
		add_filter('print_scripts_array', 'um_script_makestatic');
	}

	//dont create - condition: option checked, marked the static is used.
	
	if (um_getoption('cssstatic','umt')!=1) { add_filter('print_styles_array', 'um_style_makestatic'); }
	if (um_getoption('jsstatic','umt')!=1) { add_filter('print_scripts_array', 'um_script_makestatic'); }

}

