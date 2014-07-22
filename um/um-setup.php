<?php
defined('ABSPATH') or die('Huh?');

umo_register(
	array( 'um_setup'
		=> array(
		'func' => 'um_themesetup',
		'title' => 'UM Theme Setup',
		),
));

if(is_admin() && (isset( $umo["um_setup"])) ) { $um_settings_page=new umplug_set( "um_setup", $umo["um_setup"] ); }

function um_themesetup() {
	um_adminpage_wrap("UM Theme Setup","umplug_theme_checklist",array()); 
}

function td_create($file,$dir,$type) {
	return "<td><a class='button' href='#' data-f='$file' data-act='ums-$type' data-d='$dir'>Create</a></td>";
}

function td_checktype($file,$type) {
	if ($type == "dir") { 
		if (is_dir($file)) { return "<td>Exist</td>"; } else { return td_create($c_item,$type); } 
	} else {
		if (file_exists($file)) { return "<td>Exist</td>"; }
	}
}

function td_which_theme($item,$method,$type='file') {
	$td = ""; $parent = 0; $child_item=false; 

	if ( get_stylesheet_directory() == get_template_directory() ) { $parent=1; }
	
	$c_item = get_stylesheet_directory()."/".$item; $c = file_exists($c_item); 
	$p_item = get_template_directory()."/".$item; $p = file_exists($p_item); 
	$u_item = UMPLUG_DIR."/prop/".$item; $u = file_exists($u_item); 
	
	if ($method == "fallback") {
	
		if ($parent==0) {
			if ($c) { $td = td_checktype($c_item, $type); } else { $td = td_create($item,"child",$type); } 
		} else {
			$td = "<td>---</td>";
		}
		
		if ($p) { $td .= td_checktype($p_item ,$type); } else { $td .= td_create($item,"parent",$type); }	
		if ($u) { $td .= td_checktype($u_item,$type); } else { $td .= "<td class='warn'>ERR</td>";}
		
	} else if ($method == "parent") {
	
		$td .= "<td>&nbsp;</td>";
		if ($p) { $td .= td_checktype($p_item ,$type); } else { $td .= td_create($item,"parent",$type); }	
		$td .= "<td>&nbsp;</td>";
		
	} else {
		if ($parent==0) {
			if ($c) { $td = td_checktype($c_item,$type); } else { $td = td_create($item,"child",$type); } 
		} else {
			$td = "<td>---</td>";
		}
		if ($p) { $td .= td_checktype($p_item,$type); } else { $td .= td_create($item,"parent",$type); }	
		$td .="<td>&nbsp;</td>";
	}
	
	return $td;
}

function umplug_theme_checklist($div="",$js=0) {

$checklist = array(
	'inc/umplug-setup.php' => array(
		'type' => 'file',
		'check' => 'file',
		'note' => 'To connect your themes to UM-PLUG, besure there is <br/><code>require get_template_directory() . "/inc/umplug-setup.php";</code><br>in theme function.php',
		'method' => 'parent'
	),
	'css/reset.css' => array(
		'type' => 'style',
		'check' => 'file',
		'note' => 'Reset/normalize css',
		'method' => 'fallback'
	),
	'css/base.css' => array(
		'type' => 'style',
		'check' => 'file',
		'note' => 'Wordpress _s Standard Styles',
		'method' => 'fallback'
	),
	'css/nav.css' => array(
		'type' => 'style',
		'check' => 'file',
		'note' => 'Wordpress _s Basic Navigation',
		'method' => 'fallback'
	),
	'js/base.js' => array(
		'type' => 'style',
		'check' => 'file',
		'note' => 'Wordpress _s Standard Scripts',
		'method' => 'fallback'
	),
	'layouts' => array(
		'type' => 'style',
		'check' => 'dir',
		'method' => 'theme',
		'note' => 'CSS Layout Directory'
	),
	'um-gui.js' => array(
		'type' => 'script',
		'check' => 'file',
		'note' => 'files that call um-gui-lib',
		'method' => 'fallback'
	),
	'css/um-gui-lib.css' => array(
		'type' => 'script',
		'check' => 'file',
		'note' => '',
		'method' => 'fallback'
	),
	'js/um-gui-lib.js' => array(
		'type' => 'script',
		'check' => 'file',
		'note' => '',
		'method' => 'fallback'
	),
	'um-scheme.css' => array(
		'type' => 'script',
		'check' => 'file',
		'note' => 'Your Colours Scheme',
		'method' => 'fallback'
	),
	'print.css' => array(
		'type' => 'script',
		'check' => 'file',
		'note' => 'Printer Device Media Queries',
		'method' => 'fallback'
	),
	'medium.css' => array(
		'type' => 'script',
		'check' => 'file',
		'note' => 'Medium Device Media Queries',
		'method' => 'fallback'
	),
	'small.css' => array(
		'type' => 'script',
		'check' => 'file',
		'note' => 'Small Device Media Queries',
		'method' => 'fallback'
	),
	'style.css' => array(
		'type' => 'script',
		'check' => 'file',
		'note' => 'Theme Default Stylesheet',
		'method' => 'theme'
	),
	'page-templates' => array(
		'type' => 'dir',
		'check' => 'dir',
		'method' => 'theme',
		'note' => 'Page Templates (OnePage Templates)'
	),
	'template-part' => array(
		'type' => 'dir',
		'check' => 'dir',
		'method' => 'theme',
		'note' => 'Template part breakdown (post-header.php, etc)'
	),
	'umtag' => array(
		'type' => 'dir',
		'check' => 'dir',
		'method' => 'parent',
		'note' => 'UM Plugable template tags'
	),

);

$tr_style =""; $tr_file = ""; $tr_script = ""; $tr_dir ="";

if ( get_stylesheet_directory() != get_template_directory() ) {
	echo "<p>Theme: ".wp_get_theme()." is a <strong>Child</strong> theme.</p>";
} else {
	echo "<p>Theme: ".wp_get_theme()." is a <u>Parent</u> theme.</p>";
}?>

<table class="um-list wp-list-table widefat fixed pages">
<thead>
<tr><th class='label'>Item(s)</th>
	<th title="Child Theme">Child</th>
	<th title="Parent Theme">Parent<br/><small>(Core)</small></th>
	<th title="UM-Plug">Plugins<br/><small>(Defaults)</small></th>
	<th class='note'>Notes:</th></tr>
</thead>
<tbody><?php
	//arsort($checklist);
	foreach(array_keys($checklist) as $item) {
		if ($checklist[$item]['type'] == 'style') {
			$tr_style .= "<tr><td class='label'><label>$item</label></td>";
			$tr_style .= td_which_theme($item, $checklist[$item]['method'], $checklist[$item]['check']);
			$tr_style .= "<td class='note'>".$checklist[$item]['note']."</td></tr>\n";
		}
		else if ($checklist[$item]['type'] == 'script') {
			$tr_script .= "<tr><td class='label'><label>$item</label></td>";
			$tr_script .= td_which_theme($item, $checklist[$item]['method'], $checklist[$item]['check']);
			$tr_script .= "<td class='note'>".$checklist[$item]['note']."</td></tr>\n";
		}
		else if ($checklist[$item]['type'] == 'dir') {
			$tr_dir .= "<tr><td class='label'><label>$item</label></td>";
			$tr_dir .= td_which_theme($item, $checklist[$item]['method'], $checklist[$item]['check']);
			$tr_dir .= "<td class='note'>".$checklist[$item]['note']."</td></tr>\n";
		}
		else {
			$tr_file .= "<tr><td class='label'><label>$item</label></td>";
			$tr_file .= td_which_theme($item, $checklist[$item]['method'], $checklist[$item]['check']);
			$tr_file .= "<td class='note'>".$checklist[$item]['note']."</td></tr>\n";
		}
	}?>
	<?php echo $tr_file; ?>
<!--	<tr class='sep'><th colspan="5"><strong>UM styles and scripts</strong></th></tr> -->
	<?php echo $tr_script; ?>
	<tr class='sep'><th colspan="5"><strong>Directories</strong></th></tr>
	<?php echo $tr_dir; ?>
	<tr class='sep'><th colspan="5"><strong>Wordpress defaults (Base on _s)</strong></th></tr>
	<?php echo $tr_style; ?>
	
</tbody>
</table>
<div id="toucher" style="margin-bottom: .5em"><?php echo $div; ?>&nbsp; </div>
<?php  if ($js== 1) { ?><script type="text/javascript">umlist_function_init('.umplugs')</script><?php } ?>
<p><a class='um_confirm' href='<?php echo admin_url()."admin.php?page=um_sync"; ?>'>Sync Theme prop to UM-Plug</a></p>
<?php } 