<?php
defined('ABSPATH') or die('Huh?');

function DebugArray($args) { echo "<pre>"; print_r($args); echo "</pre>"; }

require_once(ABSPATH . 'wp-admin/includes/file.php');

function umo_register(array $args) {
	global $umo; if (!isset($umo)) { $umo = array(); }
	$umo = array_merge($umo,$args);
}

function um_theme_dircheck($w) {
	$res = false;
	if (file_exists(get_stylesheet_directory()."/$w")) { $res=true; }
	if (!is_dir(get_stylesheet_directory()."/$w")) { $res=false; }
	return $res;
}

function um_adminpage_wrap($title,$func='',$args=array()) {
		echo "<div class='wrap'>\n";
		umplug_headers($title, "<strong>Theme: </strong>". wp_get_theme());
		echo '<div class="umplugs">';
		if ($func!='') { call_user_func_array($func,$args); }
		echo "</div><div id='toucher'></div></div><!--warp-->\n";
}

function get_mtime($fn) {
	if (file_exists($fn)) { 
		//$fmtime = gmdate ( 'D, d M Y H:i:s', filemtime ( $fn ) ) );
		return date("Y-M-d H:i:s",filemtime($fn)); 
	} else { return "n/a"; }
}

function filesystem_init($key='um_textedit') {
	global $wp_filesystem;
	WP_Filesystem();
	$url=wp_nonce_url(admin_url('admin-ajax.php'),$key);
	$creds=request_filesystem_credentials($url,'',false,false,null);
	if ($creds== false) {
		$url=wp_nonce_url(admin_url('customize.php'),$key);
		$creds=request_filesystem_credentials($url,'',false,false,null);
	}
	return $creds;
//	if (false===($creds=request_filesystem_credentials($url,'',false,false,null))) { return; }
//	echo $creds;
//	var_dump($wp_filesystem);
//	die();
}
function um_file_putcontents($filename,$txt) {
	global $wp_filesystem;
	filesystem_init();
	$wp_filesystem->put_contents($filename,stripslashes($txt),FS_CHMOD_FILE);
	// file_put_contents($filename,$txt);
}

function um_file_putcontents_nos($filename,$stxt) {
	global $wp_filesystem; 
	filesystem_init();
	$wp_filesystem->put_contents($filename,$stxt,FS_CHMOD_FILE);
	//file_put_contents($filename,$txt);
}

function um_file_getcontents($filename,$nonce='') {
	/*
	 * global $wp_filesystem;
	 * filesystem_init();
	 * return $wp_filesystem->get_contents($filename);
	 * return file_get_contents($filename);
	 */
	$txt = join('',file($filename));
	return stripslashes($txt);
}

function css_include($f,$c=1) {
	if (file_exists($f)) {
		$fnice = preg_replace("/(.+)\/(.+)/","\\2",$f);
		return "/* $fnice */\n\n".css_compress(join('',file($f)),$c)."\n";
	}
}

function js_include($f,$c=1) {
	if (file_exists($f)) {
		$fnice = preg_replace("/(.+)\/(.+)/","\\2",$f);
		return "\n/* $fnice */\n".js_compress(join('',file($f)),$c)."\n";
	}
}


function safe_str($str) { return preg_replace('#\W|\s#','',strtolower($str)); }

function umplug_role_check() {
	if ( !current_user_can( 'manage_options' ) ) {
		wp_die( __( 'Sorry, has no options ', 'um' ) );
	}
}

function umplug_headers($title='UM: Untitled',$txt='') {
	umplug_role_check();
	echo "<div class='um-header'><h2>$title</h2><div>$txt</div></div>";
}

function um_get_layout_option($where) {
	$layout_options['none']="none"; $n=0;
	$layout_css=glob($where."/*.css");
	foreach ($layout_css as $lf) {
		$f=basename($lf); $F=explode(".",$f); $n++;
		$layout_options[$F[0]]=$f;
	}
	return $layout_options;
}

/* ---------------------------------------------------- umoos args: --------------
 *
 * 0 - id,type,label,text,defaults,mods - 5
 */

 function umoos_selectfile($args,$saved) {
 			$sotxt='';
			foreach(um_get_layout_option($args[4]) as $label=> $value) {
				$sotxt .="<option value='$value' ";
				if ($saved === $value) { $sotxt .="selected"; }
				$sotxt .=" >$label</option>";
			}
			printf(
				'<select data-check="%5$s" name="%6$s[%2$s]"/>%7$s</select> %3$s',
				$args[4],$args[0],$args[3],$args[5],$args[6],$args[7],$sotxt
			);
}

function umoos_check($args,$saved) {
	printf(
		'<input type="checkbox" data-check="%5$s" name="%6$s[%2$s]" %1$s value="1" /> %3$s',
		($saved!='') ? esc_attr("checked") : $args[4],
		$args[0],$args[3],$args[5],$args[6],$args[7]
	);
}
function umoos_num_big($args,$saved) {
	printf(
		'<input type="number" min="0" max="99" data-check="%5$s" name="%6$s[%2$s]" value="%1$s" /> %3$s',
		($saved!='') ? $saved : $args[4],
		$args[0],$args[3],$args[5],$args[6],$args[7]
	);
}

function umoos_num_small($args,$saved) {
	printf(
		'<input type="number" min="0" max="9" data-check="%5$s" name="%6$s[%2$s]" value="%1$s" /> %3$s',
		($saved!='') ? $saved : $args[4],
		$args[0],$args[3],$args[5],$args[6],$args[7]
	);
}

function umoos_text($args,$saved) {
	printf(
		'<input type="text" name="%6$s[%2$s]" data-check="%5$s" size="%4$s" value="%1$s" /> %3$s',
		($saved!='') ? $saved : $args[4],
		$args[0],$args[3],$args[5],$args[6],$args[7]
	);
}

function umoos_textarea($args,$saved) {
	printf(
		'<textarea name="%6$s[%2$s]" data-check="%5$s" cols="60" rows="%4$s"/>%1$s</textarea><br/>%3$s',
		($saved!='') ? $saved : $args[4],
		$args[0],$args[3],$args[5],$args[6],$args[7]
	);
}

function um_check_referer($ref) {
	$n = 0;
	if  (preg_match("#".site_url()."#",$ref)) { $n=$n+1; }
	if  (preg_match("#wp-admin/customize.php$#",$ref)) { $n=$n+2; }
	return $n;
}

/* ---------------------------------------- um_set ------------------ */

class um_set {

	protected $stub;
	protected $umo = array();
	private $options;

	public function __construct($stub,$umo) {
		$umo['stub'] = $stub; $this->umo = $umo;
		add_action('admin_menu',array($this,'um_add_pages'));
		add_action('admin_init',array($this,'um_page_init'));
	}

	public function um_add_pages() {
		$umo = $this->umo;
		if (isset($umo['option'])) {
			add_submenu_page('undressme',$umo['title'],$umo['title'],'edit_theme_options',$umo['stub'],array($this,$umo['func']) );
		} else {
			add_submenu_page('undressme',$umo['title'],$umo['title'],'edit_theme_options',$umo['stub'],$umo['func'] );
		}
	}

	public function um_page_init() {
		$umo = $this->umo;
		if (isset($umo['option'])) {
			register_setting($umo['stub'],$umo['stub'], array($this,'umo_sanitize'));
			$sections = array_keys($umo['option']); $hh = array();
				foreach ($sections as $section) {
					$hh[ safe_str($umo['option'][$section]['text']) ] = $umo['option'][$section]['note']; $this->note = $hh;
					add_settings_section($umo['stub'], $umo['option'][$section]['text'], array($this,'umo_sectionhead'),$section);
					$fields = $umo['option'][$section]['field'];
					$items = array_keys($fields);
					foreach($items as $item) {
						$fields[$item][7] = $umo['stub'];
						$item_args=array(); array_push($item_args,$item); $item_args = array_merge($item_args,$fields[$item]);
						add_settings_field($item, $item_args[2],array($this,'umo_option_set'),$section,$umo['stub'],$item_args);
					}
				}
		}
	}

	public function um_optionpages() {
		$umo = $this->umo;
		$this->options=get_option($umo['stub']);
		echo "<div class='wrap'>";
		umplug_headers($umo['title'], "<strong>Theme: </strong>". wp_get_theme());
		echo '<ul id="umtab" class=""><li class="span">&nbsp;</li></ul>';
		echo '<form method="post" class="maketab umplugs" action="options.php">'."\n";
		settings_fields($umo['stub']);
		$sections = array_keys($umo['option']);
		foreach ($sections as $section) {
			echo "<div>";
			do_settings_sections($section);
			echo "</div>";
		}
		submit_button('Change');
		echo "\n".'</form></div>';
		echo "<script>jQuery(document).ready( function($) { um_datacheck('".$umo['stub']."'); });</script>";
	}

	public function umo_option_set(array $args) {

		if (isset($this->options[$args[0]])) {
			$saved = $this->options[$args[0]];
		} else {
			$saved ='';
		}

		switch ($args[1]) {

			case "number-small":
				umoos_num_small($args,$saved); break;
			case "number-big":
				umoos_num_big($args,$saved); break;
			case "text":
				umoos_text($args,$saved); break;
			case "textarea":
				umoos_textarea($args,$saved); break;
			case "check":
				umoos_check($args,$saved); break;
			case "selectfile":
				umoos_selectfile($args,$saved); break;
			default:
				umoos_check($args,$saved); break;

		}
	}

	public function umo_sectionhead ($args) {
		$hh = safe_str($args['title']);$umo = $this->note;
		echo "<p class='note'>".$umo[$hh]."</p>";
	}

	public function umo_sanitize($input) {
		$new_input=array();
		//DebugArray($input);die();
		//$sections = array_keys( $umo['option'] );
		foreach (array_keys($input) as $item) {
			if (is_numeric($input[$item])) {
				$new_input[$item]=absint($input[$item]);
			} else {
				if ( $input[$item] != "none" ) {
					$new_input[$item]=sanitize_text_field($input[$item]);
				}
			}
		}
		return $new_input;
	}

} // -- um_set -------------------------------- //
