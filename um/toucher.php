<?php
defined('ABSPATH') or die('Huh?');
array_push($undressme, array('title' => "UM Template Tools",'stitle' => "Template Tools",'slug' => "um_toucher"));
function um_toucher() { um_admin_header("Template Tools","um_toucher_html",array()); }
	
function um_toucher_link($t,$f) {
	$link = '<a href="#" data-act="dtouch">create</a>';
	return $link;
}
function um_toucher_html($div="",$js=0) {

		$g_postformat=um_postformat_args();
		$tdir=get_stylesheet_directory();
		$tp_dir=get_stylesheet_directory()."/template-part";
		$existed=array();
		$notexisted=array();
		$tpnotexisted=array();
		$st=explode("/",$tdir); 
		$safe_tdir=$st[count($st)-1];
		$safe_tp_dir = $safe_tdir."/template-part";

		$template      = um_template_args();
		$template_part = um_templatepart_args();

		foreach($template as $t) {
			foreach($g_postformat as $g) {
				if (file_exists("$tdir/$t-$g.php")) { 
					array_push($existed,"$t-$g.php"); 
				} else { 
					array_push($notexisted,"$t-$g.php"); 
				}
			}
		}?><div class="um-col2">
		<div class='udtmd'>
		<h4>Post Format Template</h4><p><select name='tf-file' id='undressme-tf-file' data-d='<?php echo $safe_tdir ?>'><?php
		foreach ($notexisted as $g) {
			echo "<option value='$g'>$g</option>\n";
		}
		?></select><button class='touch_tf button'>touch</button></p></div><?php

		foreach($template_part as $t) {
			foreach($g_postformat as $g) {
				if (file_exists("$tp_dir/$t-$g.php")) { 
					array_push($existed,"template-part/$t-$g.php"); 
				} else {
					array_push($tpnotexisted,"$t-$g.php"); 
				}
			}
		}
		?><div class='udtmd'>
		<h4>Template Part</h4><p>
		<select name='tp-file' id='undressme-tp-file' data-d='<?php echo $safe_tp_dir ?>'><?php
		foreach ($tpnotexisted as $tg) {
			echo "<option value='template-part/$tg'>$tg</option>\n";
		}
		?></select><button class='touch_tp button'>touch</button></p></div><?php

		$ptf=glob($tdir."/page-templates/*.php");
		foreach ($ptf as $f) {
			$f=preg_replace("#$tdir/#",'',$f);
			array_push($existed,$f);
		}?><div class="udptf">
		<h4>Page-Template</h4>
		<p><input data-d='page' type="text" name="udpt" /><button class='ptouch button'>touch</button>
		<br><small>.php extension will be added</small></p>
		</div>
		</div><div class="um-col2">
		<div class="postbox">
		<h3 class="inside">Existed in "<?php echo $safe_tdir; ?>"</h3><ul class="um-list inside"><?php
		foreach ($existed as $g) {
			$dl="<span class='last'><a class='del' href='#' data-act='del' data-dir='part'><i class='dashicons-no um-dashicons'></i></a><span>".
				 "<span>".round(filesize("$tdir/$g")/1000)."k</span>";
			echo "<li class='noicon' data-file='$g'><strong><a data-act='wpedit' href='/wp-admin/theme-editor.php?file=$g&theme=".$safe_tdir,"'>$g</a>$dl</li>\n";
		}
		?></ul></div></div>
		<div id="toucher"><?php echo $div; ?>&nbsp; </div><?php		
		if ($js== 1) { ?><script type="text/javascript">umlist_function_init('.um-frame-box')</script><?php }
		

}
?>