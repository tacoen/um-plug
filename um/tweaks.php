<?php

$um_login_css = 
	"body { background: #124; }\n".
	"body.login div#login h1 a { background: none; text-indent:0; width: 64px; line-height: 64px; height: 64px; }\n".
	"body.login div#login h1 a:before { font-weight: 400;content:'\\f120'; font-family: 'dashicons'; font-size: 64px; }\n";

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
					// id => array (type,label,text,defaults,@mods,required);
					'noautosave'=> array ('check','No AutoSave',"Disable Wordpress Autosave",'','',''),
					'noavatar'=> array ('check','No Gravatar','Disable Gravatar for faster development process','','',''),
					'nodash' => array ('check','Minimize Dashboard Load','Remove NewsFeed and other stuff from WP-Admin Dashboard','','',''),
					'nofeed' => array ('check','No Feed','Disable RSS/Atom Feed','','',''),
					'novers' => array ('check','No Version','Remove styles and scripts versioning','','',''),
					'nowpabar'=> array ('check','No WP Toolbar',"Disable WP Toolbar for all",'','',''),
					'nowphead'=> array ('check','Minimize WP Header','Remove unnecessary code from header','','',''),
					'noxmlrpc' => array ('check','No XMLRPC','Disable XMLRPC Functions','','',''),
					'pback'	 => array ('check','Pingback','Allow Pingback','','',''),
					'wpzlib' => array ('check','ZLib','Enable GZIP output compression, only if your host hasn\'t','','',''),
				)
			),
			'wpvar'=> array(
				'text'=> 'Variables',
				'note'	=> 'Custom options Variables',
				'field'	=> array(
					'wdtma'	 => array ('number','Widget','Item(s)','0',
										array( 'min'=>0,'max'=>9),
										''),
					'exclen' => array ('number','Post Excerpt','Word(s)','55',
										array( 'min'=>0,'max'=>99),
										''),
					'dmqmed'=> array ('text','Medium Device Width','px &mdash; Media Queries max-width for medium/tablet device (medium.css)','800',
										array( 'pattern'=>'[0-9]{1,5}','size'=>5),
										''),
					'dmqsml'=> array ('text','Small Device Width','px &mdash; Media Queries max-width for small device (small.css)','540',
										array( 'pattern'=>'[0-9]{1,5}','size'=>5),
										''),
					'logincss'=> array ('textarea','WP-Login Page CSS','',$um_login_css,
										array( 'cols'=>90,'rows'=>5),					
										''),					
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

function disableAutoSave(){ wp_deregister_script('autosave'); }

if (um_getoption('owncdn')) { require(UMPLUG_DIR.'um/cdn.php'); }
if (um_getoption('urlrw')) { require(UMPLUG_DIR.'um/rewrites.php'); }
if (um_getoption('nowpabar')) { show_admin_bar(false); }
if (um_getoption('wdtma')) { add_action('widgets_init','um_elwidgets_init'); }
if (um_getoption('nowphead')) { add_action('after_setup_theme' ,'um_wpheadtrim'); }
if (um_getoption('nodash')) { add_action('wp_dashboard_setup','um_nodashboard_widgets'); }
if (um_getoption('pback')) { add_action('wp_head','um_pingback'); }
if (um_getoption('noavatar')) { add_filter('get_avatar', 'remove_gravatar', 1, 5); }
if (um_getoption('noautosave')) { add_action( 'wp_print_scripts', 'disableAutoSave' ); }



