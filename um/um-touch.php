<?php

defined('ABSPATH') or die('Huh?');

umo_register(
	array( 'um_touch'
		=> array(
		'func' => 'um_toucher',
		'title' => 'Template Tool',
		),
));

if(is_admin() && (isset( $umo["um_touch"])) ) { $um_settings_page=new umplug_set( "um_touch", $umo["um_touch"] ); }

function um_postformat_args() {
	$a = array('aside','gallery','link','image','quote','status','video','audio','chat');
	sort($a); return $a;
}

function um_templatepart_args() {
	$a = array("post-header","post-footer","single-header","single-footer");
	sort($a); return $a;
}

function um_template_args() {
	$a = array("archive","content");
	sort($a); return $a;
}

function um_toucher() { um_adminpage_wrap("Template Tools","um_toucher_html",array()); }

function um_toucher_html($div='',$js=0) {

		$tdir=get_stylesheet_directory();
		$tp_dir=get_stylesheet_directory()."/template-part";
		$existed=array();
		$notexisted=array();
		$tp_notexisted=array();
		$st=explode("/",$tdir);
		$safe_tdir=$st[count($st)-1];
		$safe_tp_dir = $safe_tdir."/template-part";

		$g_postformat = um_postformat_args();
		$template = um_template_args();
		$template_part = um_templatepart_args();

		foreach($template as $t) {
			foreach($g_postformat as $g) {
				if (file_exists("$tdir/$t-$g.php")) {
					array_push($existed,"$t-$g.php");
				} else {
					array_push($notexisted,"$t-$g.php");
				}
			}
		}

		foreach($template_part as $t) {
			foreach($g_postformat as $g) {
				if (file_exists("$tp_dir/$t-$g.php")) {
					array_push($existed,"template-part/$t-$g.php");
				} else {
					array_push($tp_notexisted,"$t-$g.php");
				}
			}
		}

		$ptf=glob($tdir."/page-templates/*.php");

		foreach ($ptf as $f) {
			$f=preg_replace("#".preg_quote("$tdir/")."#",'',$f);
			array_push($existed,$f);
		}

		?><div class="um-col2">

		<div class='umdd'>
		<h4>Post Format Template</h4><p><select name='tf-file' id='um_plug-tf-file' data-d=''><?php
		foreach ($notexisted as $g) {
			echo "<option value='$g'>$g</option>\n";
		}
		?></select><button class='select-touch button-secondary' data-act='touch'>touch</button></p></div>

		<div class='umdd'>
		<h4>Template Part</h4><p>
		<select name='tp-file' id='um_plug-tp-file' data-d='template-part'><?php
		foreach ($tp_notexisted as $tg) {
			echo "<option value='$tg'>$tg</option>\n";
		}
		?></select><button class='select-touch button-secondary' data-act='touch'>touch</button></p></div>

		<div class="umdd">
		<h4>Page-Template</h4>
		<p><input data-d='page-templates' type="text" name="udpt" />
		<button class='input-touch button-secondary' data-act='page-touch'>touch</button>
		<br><small>.php extension will be added</small></p></div>

		</div>

		<div class="um-col2 right">

		<div class="postbox">
		<h3 class="inside">Existed in "<?php echo $safe_tdir; ?>"</h3><ul class="um-list inside"><?php
		foreach ($existed as $g) {
			$dl="<span class='last'><a class='del' href='#' data-act='del' data-d='part'><i class='dashicons-no um-dashicons'></i></a><span>".
				 "<span>".round(filesize("$tdir/$g")/1000)."k</span>";
			echo "<li class='noicon' data-file='$g'><a data-act='wpedit' href='".admin_url()."theme-editor.php?file=$g&theme=".$safe_tdir,"'>$g</a>$dl</li>\n";
		}
		?></ul></div></div>
		<div class="clear"></div>
<!--		<p><a href="?page=um_ptemplate">Page Template</a></p>-->
<div id="toucher"><?php echo $div; ?>&nbsp; </div><?php
		if ($js== 1) { ?><script type="text/javascript">umlist_function_init('.umplugs')</script>
		<?php }

}