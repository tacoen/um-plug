<?php
//defined('ABSPATH') or die('Huh?');
//function um_disable_unused_ts() { remove_theme_support('custom-background'); }
//add_action('after_setup_theme','um_disable_unused_ts');

/* scheme default and structures */
function um_scheme_binding() {

	$upload_dir = wp_upload_dir();
	$cus_scheme = $upload_dir['basedir']."/scheme.php";

	if (file_exists($cus_scheme)) { 
		include($cus_scheme); 
	} else {
		$scheme = array(
			'color1'=> array ('value'=> '#2D3E50','name'=> 'title',),
			'color2'=> array ('value'=> '#5D6D7D','name'=> 'text',),
			'color3'=> array ('value'=> '#FCFCFC','name'=> 'page',),
			'color4'=> array ('value'=> '#95A5A6','name'=> 'line',),
			'color5'=> array ('value'=> '#C54134','name'=> 'hot',),
			'color6'=> array ('value'=> '#16A086','name'=> 'confirm',),
			'color7'=> array ('value'=> '#5DADE2','name'=> 'cool',),
			'color8'=> array ('value'=> '#F39C11','name'=> 'prompt',),
			'color9'=> array ('value'=> '#111111','name'=> 'link',),
		);
	}
	
	return $scheme;

}
/* Add postMessage support for site title and description for the Theme Customizer. */
function um_make_customize_scripts_save() {
	um_make_customize_scripts('save_after');
}
function um_make_customize_scripts($add='') {
	$um_css=um_file_getcontents(get_stylesheet_directory()."/um-scheme.css");
	$um_scheme=um_scheme_binding();
	$um_custome=get_theme_mod('umto'); $um_var='';
	//preparing
	#$um_css=preg_replace("/:/i",": ",$um_css,-1);
	#$um_css=preg_replace("/:(\s+)/i",": ",$um_css,-1);
	foreach (array_keys($um_scheme) as $color) {
		if ($um_custome[$color]) {
			$um_scheme[$color]['value']=$um_custome[$color]."/*um-".$um_scheme[$color]['name']."*/";
		} else {
			$um_scheme[$color]['value']="&".$um_scheme[$color]['value']."; um-".$um_scheme[$color]['name'];
		}
		// #([0-9a-f]+)(\s+|)(\/\*um-page\*\/)
		$regex="/#([0-9a-f]+)(\s+|)(\/\*um-" .$um_scheme[$color]['name']. "\*\/)/i";
		$um_css=preg_replace($regex,$um_scheme[$color]['value'],$um_css,-1);
		//$um_var .=$regex ." -->". $um_scheme[$color]['value'] . "\n";
	}
	um_file_putcontents(get_stylesheet_directory()."/um-scheme.css",$um_css);
}

function um_css_bind() {
	$nonce=wp_create_nonce('um_textedit');
	?><style type="text/css" id="um_color_css_preview"><?php echo um_file_getcontents(get_stylesheet_directory()."/um-scheme.css",$nonce); ?></style><?php
}

function um_js_bind() {
	$um_scheme=um_scheme_binding();
	$um_custome=get_theme_mod('umto');
	$um_js=''; $n=0;
	foreach (array_keys($um_scheme) as $color) {
		if ($um_custome[$color]) {
			$um_scheme[$color]['value']=$um_custome[$color]."/*um-".$um_scheme[$color]['name']."*/";
		} else {
			$um_scheme[$color]['value']="&".$um_scheme[$color]['name'];
		}
		$n=$n+1; $um_js .="var um_c$n='". $um_scheme[$color]['value']. "'; ";
	}
	?><script id="um_color_jsbind"><?php echo $um_js; ?></script><?php
}
function um_make_schemecss($um_scheme) {
	$css="/* scheme ".time()." */\n\n";
	foreach (array_keys($um_scheme) as $color) {
			if ($um_scheme[$color]['name']== "text") { $body="body,\n"; } else { $body=''; }
			$css .=$body.".um-".$um_scheme[$color]['name']. " { color: ".$um_scheme[$color]['value']."/*um-".$um_scheme[$color]['name']."*/; }\n";
	}
	um_file_putcontents(get_stylesheet_directory()."/um-scheme.css",$css);
}

function um_scheme_register($wp_customize) {
	$wp_customize->add_section('um_scheme',array(
		'title'	=> __('Scheme','um'),
		'priority'=> 10,
	));
	// load scheme default
	$um_scheme=um_scheme_binding();
	// create if not exist
	if (! file_exists(get_stylesheet_directory()."/um-scheme.css")) { um_make_schemecss($um_scheme); }
	foreach (array_keys($um_scheme) as $color) {
		$wp_customize->add_setting('umto['.$color.']',array('default'=>$um_scheme[$color]['value'],'sanitize_callback'=> 'sanitize_hex_color','capability'=> um_req_role(),'transport'=> 'postMessage'));
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,$color,array('label'=>ucfirst($um_scheme[$color]['name']),'section'=> 'um_scheme','settings'=> 'umto['.$color.']')));
	}
	//remove default colour sections
	$wp_customize->remove_section('colors');
}

function um_scheme_init() {
	/* Binds JS handlers to make Theme Customizer preview reload changes asynchronously. Live Preview*/
	wp_enqueue_script('um-cssjs-view',UMPLUG_URL . 'prop/js/um-css-preview.js',array('customize-preview'),'20140301',true);
	add_action('wp_head','um_css_bind');
	add_action('wp_head','um_js_bind');
}
add_action('customize_register','um_scheme_register');
add_action('customize_preview_init','um_scheme_init');
//add_action('admin_init','um_scheme_init');
add_action('customize_save_after','um_make_customize_scripts_save');