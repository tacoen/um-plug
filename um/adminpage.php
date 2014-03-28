<?php
defined('ABSPATH') or die('Huh?');

function dome($i) { 
		global $undressme;
		um_admin_header($undressme[$i]['stitle'],$undressme[$i]['function'],array()); 
		echo "see dome?\n\n";
		print_r($undressme[$i]);
}

class um_is_undressme {

	public $undressme;

	private $options;
		public function __construct() {
		add_action('admin_menu',array($this,'um_add_menu_slug'));
		add_action('admin_menu',array($this,'um_add_pages'));
		add_action('admin_init',array($this,'um_page_init'));
	}
	public function um_add_menu_slug() {
		add_menu_page("Undress Me","UM Tools",'edit_theme_options','undressme',array($this,'um_readme'),'dashicons-editor-underline',61);
		add_submenu_page('undressme','UM Readme','Readme','edit_theme_options','undressme',array($this,'um_readme'));
	}

	public function um_add_pages() {

		global $undressme; $m = 0;
		$M = count( array_keys($undressme));
		for ($m; $m<$M; $m++) {
			$this->dome[$m] = array($undressme[$m]['function'],$undressme[$m]['stitle']);
			add_submenu_page('undressme',
				$undressme[$m]['title'],
				$undressme[$m]['stitle'],
				'edit_theme_options',
				$undressme[$m]['slug'],
				$undressme[$m]['slug'] 
			);
		}

		add_submenu_page('undressme','UM Options','Options','edit_theme_options','um-options',array($this,'um_themeoption'));

	}

	public function um_readme() { um_admin_header("Readme","um_readme_html",array()); }
	public function um_themeoption() {
		umplug_role_check();
		$umo=umo_args();
		$this->options=get_option('umo');
		echo '<div class="wrap"><div class="um-head-set"><h2>UM: Options</h2></div>';
		echo '<ul id="umtab" class=""><li class="span">&nbsp;</li></ul><div class="um-frame-box dress">';
		echo '<form method="post" class="maketab" action="options.php">'."\n";
			settings_fields("umo_group");
			$S=array_keys($umo); foreach($S as $section) {
				echo "<div>";
				do_settings_sections("umo-$section");
				echo "</div>";
			}
			echo '<div class="clear"></div>';
			submit_button('Change');
		echo "\n".'</form></div></div><!--warp-->';
	}				
	public function um_page_init() {
		$umo=umo_args();
		register_setting("umo_group","umo",array($this,'umo_sanitize'));
		$S=array_keys($umo);
		foreach($S as $se) {
			$n=0; add_settings_section("$se",$umo[$se]['text'],array($this,'umo_option_print_section'),"umo-$se");
			foreach ($umo[$se]['field'] as $fi) {
				$F=array_keys($umo[$se]['field']); $m=count($F);
				if ($n < $m) {
					$args=array(
						'type'=> $umo[$se]['field'][$F[$n]][0],
						'id'=> $F[$n],
						'note'=> $umo[$se]['field'][$F[$n]][2],
						'var'=> $umo[$se]['field'][$F[$n]][3]
					);
					add_settings_field($F[$n],$umo[$se]['field'][$F[$n]][1],array($this,'umo_option_print'),"umo-$se","$se",$args);
					$n++;
				}
			}
		}
	}
	public function umo_option_print_section (array $args) { $umo=umo_args();	print $umo[$args['id']]['note']; }
	public function umo_option_print(array $args) {
		if ($args['type']== "check") {
			printf(
				'<input type="checkbox" name="umo[%2$s]" %1$s value="1" /> %3$s',
				isset($this->options[$args['id']]) ? esc_attr("checked") : '',
				$args['id'],$args['note']
			);
		} else if ($args['type']== "number") {
			printf(
				'<input type="number" min="0" max="16" name="umo[%2$s]" value="%1$s" /> %3$s',
				$this->options[$args['id']],$args['id'],$args['note']
			);
		} else if ($args['type']== "text") {
			$def = um_rwvar_default();
			printf(
				'<input type="text" name="umo[%2$s]" size="%4$s" value="%1$s" /> %3$s',
				isset($this->options[$args['id']]) ? $this->options[$args['id']] : $def[$args['id']],
				$args['id'],$args['note'],$args['var']
			);
		} else if ($args['type']== "selectfile") {
			$sotxt="";
			foreach(um_get_layout_option($args['var']) as $label=> $value) {
				$sotxt .="<option value='$value' ";
				if ($this->options[$args['id']]== $value) { $sotxt .="selected"; }
				$sotxt .=" >$label</option>";
			}
			printf(
				'<select name="umo[%1$s]"/>%3$s</select> %2$s',
				$args['id'],$args['note'],$sotxt
			);
		}
	}	
	public function umo_sanitize($input) {
		$new_input=array();
		$umo=umo_args();
		$S=array_keys($umo);
		foreach($S as $se) {
			$n=0;
			foreach ($umo[$se]['field'] as $fi) {
				$F=array_keys($umo[$se]['field']); $m=count($F);
				if ($n < $m) {
					if(isset($input[ $F[$n] ])) {
						$type=$umo[$se]['field'][$F[$n]][0];
						if (($type== "check") || ($type== "number")) {
							$new_input[ $F[$n] ]=absint($input[ $F[$n] ]);
						} else {
							$new_input[ $F[$n] ]=sanitize_text_field($input[ $F[$n] ]);
						}
					}
				$n++;
				}
			}
		}
	return $new_input;
	}	
}
if(is_admin()) { $my_settings_page=new um_is_undressme(); }

function um_readme_html() {?>
	<div class="um-readme">
	<ul id="umtab"><li class="span">&nbsp;</li></ul>
	<div class="maketab">
	<div><h3 class="tab">About UM-PLUG</h3><?php
	if (file_exists(UMPLUG_DIR."prop/doc/readme.html")) {
		echo um_file_getcontents(UMPLUG_DIR."prop/doc/readme.html");
	} else {
		echo "Well, UM /prop/doc/readme.html is missing. It suppose to tell that you can <a href='/wp-admin/customize.php'>customize your theme</a>.";
	}?></div>

	<div><h3 class="tab">Readme</h3><?php
	if (file_exists(get_stylesheet_directory()."/readme.txt")) {
		echo "<pre><h3>".wp_get_theme()." - readme.txt</h3>".um_file_getcontents(get_stylesheet_directory()."/readme.txt")."</pre>";
	} else {
		echo "Well, child theme readme.txt is missing or there is no activated child theme.";
	} ?></div>

	<div><h3 class="tab">Credits</h3><?php
	if (file_exists(UMPLUG_DIR."prop/doc/feat.html")) {
		echo um_file_getcontents(UMPLUG_DIR."prop/doc/feat.html");
	} else {
		echo "Well, UM /prop/doc/feat.html is missing.";
	}?></div>

	</div>
	
	<h5>UM-Plug Ver. <?php echo um_ver(); ?></h5>
	
	<?php
}
