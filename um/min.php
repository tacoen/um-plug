<?php

umo_register(
	array( 'umr'
		=> array(
		'func' => "um_optionpages",
		'title' => "Minified Options",
		'option' => array (
			'devel'=> array(
				'text'=> 'Minify',
				'note'	=> 'Minified your style and javascripts, and make them static',
				'field'	=> array(
					// id => array (type,label,text,defaults,mods,required);
					'makes'	=> array ('check', 'Minify', 'Generated static-minified-unpretty css and js.','','',''),
					'zlevel'    => array ('number','CSS Compress level','Level, <small>0 - unreadable, >1 - readable</small>','0',
										array( 'min'=>0,'max'=>3),
										'makes'),					
					'cssstatic'	=> array (
						'check', 'CSS', 'Static file &mdash;Last Generated: '.
						get_mtime( get_stylesheet_directory()."/static.css") .
						" [<a href='".get_stylesheet_directory_uri()."/static.css'>View</a>]"
						,'','','makes'),
					'jsstatic'	=> array ('check','JS','Static file &mdash;Last Generated: '.
						get_mtime( get_stylesheet_directory()."/static.js") .
						" [<a href='".get_stylesheet_directory_uri()."/static.js'>View</a>]" .
						" and [<a href='".get_stylesheet_directory_uri()."/static-footer.js'>View</a>]"
						,'','','makes'),
				)
			),
		))
));

if(is_admin() && (isset( $umo["umr"])) ) { 

	$um_settings_page=new umplug_set( "umr", $umo["umr"] ); 

}

/* Will create the static file, unless option is unchecked */

$static_js_is_registered = false;
$static_css_is_registered = false;

function um_minify_js_notice() {
	echo "<!-- um_minify_js is running --!>\n";
}
function um_minify_css_notice() {
	echo "\n<!-- um_minify_css is running --!>\n";
}

function um_minify_disable_notice() {
	echo "\n<!-- um_minify disabled in this referer --!>\n";
}

function um_minify_js() {
	add_action('wp_enqueue_scripts', 'um_register_static_js');
	add_filter('print_scripts_array', 'um_wpscripts_unique', PHP_INT_MAX/2); // remove dupes, if any
	add_filter('print_scripts_array', 'um_static_query_js', PHP_INT_MAX/2);
}
function um_minify_css() {
	add_action('wp_enqueue_scripts', 'um_register_static_css');
	add_filter('print_styles_array', 'um_wpstyles_unique', PHP_INT_MAX/2); // remove dupes, if any
	add_filter('print_styles_array', 'um_static_query_css', PHP_INT_MAX/2);
}

function um_register_static_js() {
	global $static_js_is_registered;
	// get_option of static_use
	if (file_exists(get_stylesheet_directory()."/static.js")) { 
		$static_js_is_registered=true;
		wp_register_script(get_stylesheet().'-hgen-js',get_stylesheet_directory_uri()."/static.js",false,um_ver()); 
	}
	if (file_exists(get_stylesheet_directory()."/static-footer.js")) { 
		$static_js_is_registered=true;
		wp_register_script(get_stylesheet().'-fgen-js',get_stylesheet_directory_uri()."/static-footer.js",false,um_ver()); 
	}
}

function um_static_query_js($handles) {

	$level= um_getoption('zlevel','umr'); if ($level=='') { $level=0; }


	global $wp_scripts; 
	
	$js[0] = array(); $js[1]=array(); $pre_head = "";
	$ojs[0] = array(); $ojs[1]=array(); $pre_foot = "";

	//print_r ($wp_scripts);
	foreach ($handles as $handle) {

		$url = $wp_scripts->registered[$handle]->src;

		//echo "<pre>"; print_r($wp_scripts->registered[$handle]); echo "</pre>";
		
		if (preg_match("#static.js$#",$url)) { continue; }
		if (preg_match("#static-footer.js$#",$url)) { continue; }

		if ( $wp_scripts->groups[$handle] == 0) {

			if (isset($wp_scripts->registered[$handle]->extra)) {
				if (isset($wp_scripts->registered[$handle]->extra['data'])) { 
					$pre_head .= $wp_scripts->registered[$handle]->extra['data']; 
				}
			}
			
			if (preg_match("#".home_url()."#",$url)) {
				if (!empty($url)) { array_push($js[0],$handle); } // header
				
			} else {
				array_push($ojs[0],$handle);
			}
		} else {	

			if (isset($wp_scripts->registered[$handle]->extra)) {
				if (isset($wp_scripts->registered[$handle]->extra['data'])) { 
					$pre_foot .= $wp_scripts->registered[$handle]->extra['data']; 
				}
			}

			if (preg_match("#".home_url()."#",$url)) {
				if (!empty($url)) { array_push($js[1],$handle); } // footer
			} else {
				array_push($ojs[1],$handle);
			}
		}
	}

	if ( (!um_getoption('jsstatic','umr')) || (!file_exists(get_stylesheet_directory()."/static-footer.js")) ) { 

		if (!empty($js[0])) { $header_static_js = um_makestatic_js($js[0],$level); } else { $header_static_js=""; }
		if (!empty($js[1])) { $footer_static_js = um_makestatic_js($js[1],$level); } else { $footer_static_js=""; }
		if (strlen($pre_head)>1) { $pre_head = $pre_head."\n"; }
		if (strlen($pre_foot)>1) { $pre_foot = $pre_foot."\n"; }
		if (strlen($header_static_js)>1) { 
			um_file_putcontents_nos( get_stylesheet_directory()."/static.js", $pre_head.$header_static_js);
		}
		if (strlen($footer_static_js)>1) {
			um_file_putcontents_nos( get_stylesheet_directory()."/static-footer.js", $pre_foot.$footer_static_js); 
		}
		
		add_action('wp_head','um_minify_js_notice'); 

	}
	
	global $static_js_is_registered;

	if ($static_js_is_registered) {
		$wp_scripts->groups[get_stylesheet().'-hgen-js'] =0;
		// if (strlen($pre_head)>1) { $wp_scripts->registered[get_stylesheet().'-hgen-js']->extra['data'] = $pre_head; }
		array_push($ojs[0], get_stylesheet().'-hgen-js' );
		
		if (file_exists(get_stylesheet_directory()."/static-footer.js")) { 
			$wp_scripts->groups[get_stylesheet().'-fgen-js'] =1;
			// if (strlen($pre_foot)>1) { $wp_scripts->registered[get_stylesheet().'-fgen-js']->extra['data'] = $pre_foot; }
			array_push($ojs[1],get_stylesheet().'-fgen-js');
		}
	
		// script doesn't had head or foot
		if (empty($wp_scripts->done)) {
			return $ojs[0];
		} else { 
			return $ojs[1];
		}
		
	} else { 
		return $handles; 
	}
	
}

function um_makestatic_js($js,$level=1) {
	global $wp_scripts; $static_js = "";

	foreach ($js as $handle) {
		$url = $wp_scripts->registered[$handle]->src;
		$src = preg_replace("#".home_url()."/#",ABSPATH,$url);
		$static_js .= um_load_js($src,$level);
		$static_js .= "\n";
	}

	if ($level< 1) { return um_js_compress( $static_js, $level); } 
	else { return $static_js; }
	
}

function um_wpscripts_unique($handles) {
	$handles = array_unique($handles);
	global $wp_scripts; $js = array();$new_handles = array();
	foreach ($handles as $handle) {
		$src = $wp_scripts->registered[$handle]->src;
		if (array_search($src,$js)<1) {
			array_push($js,$src); array_push ($new_handles, $handle);
		} // else { wp_deregister_script( $handle ); }
	}
	return $new_handles;
}

function um_js_compress($buffer,$readable=0) {
	require_once( UMPLUG_DIR ."min/lib/JSMin.php"); 
	return JSMin::minify($buffer);
}

function um_load_js($filename,$level=1) {
	$sf = explode('/',$filename); $fn = $sf[count($sf)-1]; $text = "";
	if (file_exists($filename)) :
		if ($level>2) { $text .= join('',file($filename))."\n"; } 
		else { $text .= um_js_compress( join('',file($filename)),0 ); }
	endif;
	return $text;
}

/*-------------------------------- CSS ------------------------------ */

function um_css_url_care($txt,$f) {
	$safe_abspath = str_replace("\\","/",ABSPATH);
	$safe_f = str_replace("\\","/",$f);
	$url = preg_replace('#'.$safe_abspath."#",site_url()."/",$safe_f);
	$url_path = preg_replace('/(.+\/).+/','\\1',$url);
	$dot_url = preg_replace('/(.+\/).+/','\\1',$url_path);	
	$txt = preg_replace('/(\s|,|:)url/',"\n".'\\1url',$txt);
	$dot_url = preg_replace('/(.+\/).+/','\\1',$url);
	$txt = preg_replace('/\.\.\//',$dot_url,$txt);
	$txt = preg_replace('/(\s|,|:)url(.+)http/','\\1--void--url\\2http',$txt);
	$txt = preg_replace('/(\s|,|:)url(\W+)/','\\1url\\2'.$url_path,$txt);
	$txt = preg_replace('/--void--/','',$txt);
	return $txt;
}

function um_register_static_css() {
	global $static_css_is_registered;
	// get_option of static_use
	if (file_exists(get_stylesheet_directory()."/static.css")) { 
		$static_css_is_registered=true;
		wp_register_style(get_stylesheet().'-hgen',get_stylesheet_directory_uri()."/static.css",false,um_ver(),'all'); 
	}
	if (file_exists(get_stylesheet_directory()."/static-footer.css")) { 
		$static_css_is_registered=true;
		wp_register_style(get_stylesheet().'-fgen',get_stylesheet_directory_uri()."/static-footer.css",false,um_ver(),'all'); 
	}
}

function um_static_query_css($handles) {

	$level= um_getoption('zlevel','umr'); if ($level=='') { $level=0; }

	global $wp_styles; 
	
	$css[0] = array(); $css[1]=array(); 
	$ocss[0] = array(); $ocss[1]=array();
	
	foreach($handles as $handle) {

		$url = $wp_styles->registered[$handle]->src;
		
		if (preg_match("#static.css$#",$url)) { continue; }
		if (preg_match("#static-footer.css$#",$url)) { continue; }

		if ( $wp_styles->groups[$handle] == 0) {
			if (preg_match("#".home_url()."#",$url)) {
				if (!empty($url)) { array_push($css[0],$handle); } // header
			} else {
				array_push($ocss[0],$handle);
			}
		} else {	
			if (preg_match("#".home_url()."#",$url)) {
				if (!empty($url)) { array_push($css[1],$handle); } // footer
			} else {
				array_push($ocss[1],$handle);
			}
		}
	}
	
	if ( (!um_getoption('cssstatic','umr')) || (!file_exists(get_stylesheet_directory()."/static.css")) ) { 
	
		if (!empty($css[0])) { $header_static_css = um_makestatic_css($css[0],$level); } else { $header_static_css=""; }
		if (!empty($css[1])) { $footer_static_css = um_makestatic_css($css[1],$level); } else { $footer_static_css=""; }
	
		if (strlen($header_static_css)>1) {	
			um_file_putcontents_nos( get_stylesheet_directory()."/static.css", $header_static_css); 
		}
		if (strlen($footer_static_css)>1) {	
			um_file_putcontents_nos( get_stylesheet_directory()."/static-footer.css", $footer_static_css); 
		}

		add_action('wp_head','um_minify_css_notice'); 

	}
	
	global $static_css_is_registered;

	if ($static_css_is_registered) {
		array_push($ocss[0],get_stylesheet().'-hgen');
		if (file_exists(get_stylesheet_directory()."/static-footer.css")) { 
			array_push($ocss[1],get_stylesheet().'-fgen');
		}
		return array_merge($ocss[0],$ocss[1]); // Style doesn't had head or foot
	} else { 
		return $handles; 
	}
	
}

function um_makestatic_css($css,$level=1) {
	global $wp_styles; $static_css = "";
	foreach ($css as $handle) {
		$url = $wp_styles->registered[$handle]->src;
		$src = preg_replace("#".home_url()."/#",ABSPATH,$url);
		if ($handle == "um-medium") {
			$static_css .= "@media (max-width: 800px) {\n";
			$static_css .= um_load_css($src,$level);
			$static_css .= "\n}\n";
		} else if ($handle == "um-small") { 
			$static_css .= "@media (max-width: 540px) {\n";
			$static_css .= um_load_css($src,$level);
			$static_css .= "\n}\n";
		} else if ($handle == "um-print") { 
			$static_css .= "@media print {\n";
			$static_css .= um_load_css($src,$level);
			$static_css .= "\n}\n";
		} else {
			$static_css .= um_load_css($src,$level);
			$static_css .= "\n";
		}
	}

	if ($level< 1) { return um_css_compress( $static_css, $level); } 
	else { return $static_css; }
	
}

function um_wpstyles_unique($handles) {
	$handles = array_unique($handles);
	global $wp_styles; $css = array();$new_handles = array();
	foreach ($handles as $handle) {
		$src = $wp_styles->registered[$handle]->src;
		if (array_search($src,$css)<1) {
			array_push($css,$src); array_push ($new_handles, $handle);
		} // else { wp_deregister_style( $handle ); }
	}
	return $new_handles;
}

function um_css_compress($buffer,$readable=0) {

	$buffer = str_replace("\\", 'UM_TT', $buffer);
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	$buffer = preg_replace('#\s\s+#','', $buffer);
	$buffer = preg_replace('#([>|:|;|\{|\}|=|\(|\)|\,])\s#', '\\1', $buffer);
	$buffer = preg_replace('#\s([>|:|;|\{|\}|=|\(|\)|\,|\'])#', '\\1', $buffer);
	$buffer = preg_replace('#;\}#','}', $buffer);
	$buffer = preg_replace('#^\s+#','', $buffer);
	//$buffer = preg_replace('#\@media#',"\n@media", $buffer);
	if ($readable>0) $buffer = preg_replace('/}/', "}\n", $buffer);
	$buffer = str_replace("UM_TT", "\\", $buffer);
	$buffer = str_replace('UM_QOUTE', '\"\'\"', $buffer);
	return $buffer;
}

function um_css_minify($buffer) {
	require_once( UMPLUG_DIR ."min/lib/CSSmin.php"); 
	$C = new CSSmin;
	return $C->minify($buffer,2000);
}

function um_load_css($filename,$level=1) {
	$sf = explode('/',$filename); $fn = $sf[count($sf)-1]; $text = "";
	if (file_exists($filename)) :
		$src = um_css_url_care(join('',file($filename)),$filename);
		if ($level>1) { $text = "/* source: $fn */\n"; } else { $text = ""; }
		if ($level>2) { $text .= $src."\n"; } 
		else { $text .= um_css_compress( $src,1 ); }
	endif;
	return $text;
}


/* ------------------- */

if (!is_admin()) :

	if (um_getoption('makes','umr')) {
		if (isset($_SERVER['HTTP_REFERER'])) { $ref = $_SERVER['HTTP_REFERER']; } else { $ref =""; }
		if (um_check_referer($ref) < 2) {
			um_minify_js();
			um_minify_css();
		} else {
			add_action('wp_head','um_minify_disable_notice');
		}
	}

endif;
