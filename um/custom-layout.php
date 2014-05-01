<?php
/* ref: 
http://codex.wordpress.org/Plugin_API/Action_Reference/customize_register 
http://ottopress.com/2012/making-a-custom-control-for-the-theme-customizer/
*/

function um_layouts_register($wp_customize){

	$wp_customize->add_section('um_layouts', array(
		'title' => __('Layouts', 'um'),
		'priority' => 120,
	));
	
	$layout = um_getoption('layout','umt');
	
	$wp_customize->add_setting('um_layouts_set', array(
		'default' => $layout,
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));	

	$layouts = glob_recursive( get_stylesheet_directory()."/layouts/*.css" );
	$c = array();
	
	$c[''] = 'none';
	
	foreach($layouts as $f){
		$value = preg_replace("/(.+)\/(.+)/","\\2",$f);
		$choice = preg_replace("/(.+)\.(.+)/","\\1",$value);
		$c[$value] = $choice;
	}
		
	$wp_customize->add_control( 'layout_select', array(
		'section' => 'um_layouts',
		'settings' => 'um_layouts_set',
		'label' => "Layouts",
		'type' => 'select',
		'choices' => $c,
	));

	/* preview width */
/*	
	$wp_customize->add_section('um_lview', array(
		'title' => __('Live preview', 'um'),
		'priority' => 220,
		'description' => 'Test your layout againts Media Queries max-width'
	));
	
	$wp_customize->add_setting('um-preview-width', array(
		'default' => '100%',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));	
	
	$wp_customize->add_control( 'width_select', array(
		'section' => 'um_lview',
		'settings' => 'um-preview-width',
		'label' => "Media Queries",
		'type' => 'radio',
		'choices' => array(
			"100%" => "fluid-width (100%)",
			"1024px" => "medium desktop (1024)",
			"800px" => "tablet",
			"540px" => "handheld",
		),
	));
*/
}

function um_layouts_saveoption() {
	$value=get_option('um_layouts_set');
	$my_options = get_option('umt');
	$my_options['layout'] = $value;
	update_option('umt', $my_options);
}

function um_layouts_init() {
	wp_enqueue_script('um-layout-view',UMPLUG_URL . 'prop/js/um-layout.js',array('customize-preview'),time(),true);
}

add_action('customize_register', 'um_layouts_register');
add_action('customize_preview_init','um_layouts_init');
add_action('customize_save_after','um_layouts_saveoption');
