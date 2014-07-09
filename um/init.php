<?php

function um_footeradmin () {
	$credit = array(
		'Actualy <a href="http://www.wordpress.org">WordPress</a>, instead <a href="http://tacoen.github.io/um_plug">UM</a>',
		'Hi <a href="http://www.wordpress.org">WordPress</a>! Hello <a href="http://tacoen.github.io/um_plug">UM</a>!',
		'This <a href="http://www.wordpress.org">WordPress</a> with <a href="http://tacoen.github.io/um_plug">UM</a>',
		'<a href="http://www.wordpress.org">WordPress</a> and <a href="http://tacoen.github.io/um_plug">UM</a>',
		'Core: <a href="http://www.wordpress.org">WordPress</a>, Plugin: <a href="http://tacoen.github.io/um_plug">UM</a>',
		'Much about <a href="http://www.wordpress.org">WordPress</a> than <a href="http://tacoen.github.io/um_plug">UM</a>',
		'This <a href="http://www.wordpress.org">WordPress</a> with <a href="http://tacoen.github.io/um_plug">UM</a>',
		'There were <a href="http://www.wordpress.org">WordPress</a> programmer whom <a href="http://tacoen.github.io/um_plug">UM</a>',
	);
	shuffle($credit); echo $credit[0];
}

function umplug_i18n() { load_plugin_textdomain( 'um', false, 'lang' ); }

function umplug_register_admin_scripts() {
	wp_enqueue_style('um-backend',UMPLUG_URL."prop/css/um-backend.css",array('wp-admin'),um_ver(),'all');
	wp_enqueue_script('um-backend',UMPLUG_URL . 'prop/js/um-backend.js',array('jquery'),um_ver(),true);
}

function umplug_init_slug() {
	add_menu_page("Undress Me","UM Plug",um_req_role(),'um_plug','um_readme','dashicons-editor-underline',61);
	add_submenu_page('um_plug','UM Readme','Readme',um_req_role(),'um_plug','um_readme');
}

function umplug_help($contextual_help, $screen_id) {

	$um_help= UMPLUG_DIR."prop/doc/help/".$screen_id.".html";
	// echo "<!--- $screen_id --->";

	if (file_exists($um_help) ){
		$debugres =
			"<h3>Site Information</h3><div class='um-debug'>".
			"<p><label>Site Root:</label>".ABSPATH."</p>".
			"<p><label>Theme:</label>".wp_get_theme()."</p>".
			"<p><label>Template Directory:</label><span title='URL:".get_template_directory_uri()."'>".get_template_directory()."</span></p>";
		if (get_template_directory() != get_stylesheet_directory()) {
			$debugres .="<p><label>Style Sheet Directory (child):</label><span title='URL:".get_stylesheet_directory_uri()."'>".get_stylesheet_directory()."</span></p>";
		}
		$debugres .=
			"<p><label>UM-Plug Directory</label>".UMPLUG_DIR."</p>".
			"";

		$debugres .="</div>";
		
		$umch_credit = "<h4>UM PLUG - ".um_ver()."</h4>".
			"<p><a href='//github.com/tacoen/um-plug'>Plugins Site</a></p>".
			"<p><a href='//github.com/tacoen/um-plug/wiki'>Wiki</a></p>".
			"<p><a href='//github.com/tacoen/um-plug/issues'>Issues</a></p>".
			"<p><a href='//github.com/tacoen/um-theme-core'>UM Core Themes</a></p>".
			"<p>&nbsp;</p>";

		$icontextual_help = '<p>';
		$icontextual_help .= __( umch_overview($screen_id) );
		$icontextual_help .= '</p>';
		
		$webfont_ref = "<p><label>UM-GUI Icons</label><a href='".UMPLUG_URL."prop/css/fonts/demo.html"."'>Icons References</a></p>";
		$umref = "<h3>Links</h3><div class='um-debug'>" . 
			join('',file( 	UMPLUG_DIR."prop/doc/feat.html" )) . 
			$webfont_ref .
			"</div>";

		$umch_help = array('id'=> 'umch-help','title'=> __('Overview' ),'content'=> __($icontextual_help));
		$umch_debug = array('id'=> 'umch-debug','title'=> __('Site Info' ),'content'=> __($debugres));
		$umch_ref = array('id'=> 'umch-ref','title'=> __('Links' ),'content'=> __($umref));
		
		get_current_screen()->set_help_sidebar(__($umch_credit));
		get_current_screen()->add_help_tab($umch_help);
		get_current_screen()->add_help_tab($umch_debug);
		get_current_screen()->add_help_tab($umch_ref);
		return $contextual_help;
	}
}

function umch_overview($id) {
	$text = "--N/A--"; $str = "";
	$um_help= UMPLUG_DIR."prop/doc/help/".$id.".html";
	$text = join('',file($um_help));
	$str .="<div>$text</div>";
	return $str;
}


add_action('admin_init','umplug_i18n');
add_action('admin_menu','umplug_init_slug');
add_filter('admin_footer_text','um_footeradmin');
add_action('admin_print_styles','umplug_register_admin_scripts');
add_filter('contextual_help', 'umplug_help', 10, 2);

