<?php

umo_register(
	array( 'umo'
		=> array(
		'func' => "um_optionpages",
		'title' => "Tweaks Options",
		'option' => array (
			'wp_opt' => array (
				'text'=> 'Custom Options',
				'note'	=> 'Because sometimes we hate being default',
				'field'	=> array(
					// id => array (type,label,text,defaults,mods);
					'nodash' => array ('check','Minimize Dashboard Load','Remove NewsFeed and other stuff from WP-Admin Dashboard','','',''),
					'nowphead'=> array ('check','Minimize WP Header','Remove unnecessary code from header','','',''),
					'nowpabar'=> array ('check','WP Toolbar',"Disable WP Toolbar for all",'','',''),
					'pback'	 => array ('check','Pingback','Allow Pingback','','',''),
					'noavatar'=> array ('check','No Gravatar','Disable Gravatar for faster development process','','',''),
					'wdtma'	 => array ('number','Widget','','1','',''),
					'umtag'	=> array ('check','um-tag','Enable dynamic UM Template-Tags for your themes','yes','',''),

				)
			),
			'cdnopt'=> array(
				'text'=> 'CDN',
				'note'	=> 'Use your prefered cdn',
				'field'	=> array(
					// id => array (type,label,text,defaults,mods,required);
					'owncdn'=> array ('check','Alter CDN','Use your own CDN resources','','',''),
					'opsfcdn' => array ('text','Open Sans','<br/><small>Webfont used by Wordpress 3.8.1<br>Blank it to use Wordpress default</small>','','60','owncdn'),
					'jqcdn'	=> array ('text','Jquery','<br/><small>um-gui-lib using Jquery 2.0</small>','http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js','60','owncdn'),
					'gamirr'=> array ('text','Google Apis Mirror','<br/><small>ajax.googleapis.com mirror, address only do not add http://,<br/>Blank it to disable</small>','','60','owncdn'),
				)
			),
			'umrw'=> array(
				'text'=> 'URL Rewrites',
				'note'	=> 'Please <a href="options-permalink.php">revise your permalink</a> after you make changes',
				'field'	=> array(
					// id => array (type,label,text,defaults,mods,required);
					'urlrw'	=> array ('check','URL Rewrite','Use ShortURL for resources','','',''),
					'umplug'=> array ('text','um-plug','','um','8','urlrw'),
					'wpinc'	=> array ('text','WP Includes','','i','8','urlrw'),
					'wplug'	=> array ('text','Plugins','','g','8','urlrw'),
					'templ'	=> array ('text','Template(Parent)','','t','8','urlrw'),
					'style'	=> array ('text','Stylesheet(Child)','','s','8','urlrw'),
				)
			),
		))
	)
);

if(is_admin() && (isset( $umo["umo"])) ) { $my_settings_page=new um_set( "umo", $umo["umo"] ); }

function um_elwidgets_init() {

	//require(UMPLUG_DIR.'um/widgets.php');
	//register_widget( 'um_elWidget' );

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

if (um_getoption('owncdn')) { require(UMPLUG_DIR.'um/cdn.php'); }
if (um_getoption('wdtma')) { add_action('widgets_init','um_elwidgets_init'); }
if (um_getoption('urlrw')) { require(UMPLUG_DIR.'um/rewrites.php'); }
if (um_getoption('nowphead')) { add_action('after_setup_theme' ,'um_wpheadtrim'); }
if (um_getoption('nodash')) { add_action('wp_dashboard_setup','um_nodashboard_widgets'); }
if (um_getoption('pback')) { add_action('wp_head','um_pingback'); }
if (um_getoption('nowpabar')) { show_admin_bar(false); }
if (um_getoption('noavatar')) { add_filter('get_avatar', 'remove_gravatar', 1, 5); }

