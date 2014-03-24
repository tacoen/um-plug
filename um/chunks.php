<?php
defined('ABSPATH') or die('Huh?');

array_push($undressme,array('title' => "UM Chunks",'stitle' => "Chunks",'slug' => "um_chunks"));
function um_chunks() { um_admin_header("Chunks","um_chunks_html",array()); }

/* --------------------------------------------------------------------- */

Class um_chunks_widget extends WP_Widget {
	function __construct() {
		parent::__construct('um_chunks_widget',__('Chunks','um'),array('description'=> __('Chunks Widget','um'),));
	}
	public function widget($args,$instance) {
		$title=apply_filters('widget_title',$instance['title']);
		$chunk=apply_filters('widget_chunk',$instance['chunk']);
		echo $args['before_widget'];
		if (! empty($title)) { echo $args['before_title'] . $title . $args['after_title']; }
		if (! empty($chunk)) { um_chunk($chunk); }
		echo $args['after_widget'];
	}
	public function form($instance) {
		if (isset($instance[ 'title' ])) { $title=$instance[ 'title' ]; } else { $title=__('Chunk title','um'); }
		$chunk_selected=$instance[ 'chunk' ];
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','um'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
		type="text" value="<?php echo esc_attr($title); ?>"></p>
		<p><label for="<?php echo $this->get_field_id('chunk'); ?>"><?php _e('Chunk:','um'); ?></label>
		<select name="<?php echo $this->get_field_name('chunk'); ?>">
		<?php
		$chunks=glob(get_stylesheet_directory()."/chunks/*.txt");
		foreach ($chunks as $c) {
			if ($c== $chunk_selected) { $str=" selected"; } else { $str=""; }
			$fn=explode("/",$c); $fnc=$fn[count($fn)-1]; $fn=explode(".",$fnc);
			echo "<option $str value='".$fn[0]."'>$fn[0]</option>\n";
		}?>
		</select></p><?php
	}
	public function update($new_instance,$old_instance) {
		$instance=array();
		$instance['title']=(! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['chunk']=(! empty($new_instance['chunk'])) ? strip_tags($new_instance['chunk']) : '';
		return $instance;
	}
} // class um_chunks_Widget

function register_um_chunks_widget() {
	register_widget('um_chunks_widget');
}
add_action('widgets_init','register_um_chunks_widget');
/* ------------------------------------------------------------------ */
function um_textedit($title,$file) {?>
	<form id="template" class="um-editor">
	<h3>Chunk: <?php echo $title; ?></h3>
	<?php wp_nonce_field('um_textedit'); ?>
	<textarea data-file="<?php echo $title; ?>" data-dir="chunk" ><?php echo join("",file($file,FILE_SKIP_EMPTY_LINES)); ?></textarea>
	<p><input type="submit" name="submit" id="submit" data-act="save" class="button button-primary" value="Save">
	</form>
	<script>
	umeditor_init('.um-frame-box')
	</script>
<?php }
function um_chunk_insert($f) {
	$file=get_stylesheet_directory()."/chunks/".$f.".txt";
	return join ("",file($file,FILE_SKIP_EMPTY_LINES));
}
function undressme_insert_chunk_func($atts) {
	return um_chunk_insert($atts['file']);
}
add_shortcode('chunk','undressme_insert_chunk_func');
function um_chunk($w) {
	echo do_shortcode('[chunk file='.$w.']');
}
function get_sniff($f) {
	$sniff=strip_tags(join("",file($f,FILE_SKIP_EMPTY_LINES)));
	if (strlen($sniff)>96) { return substr($sniff,0,96)." ..."; } else { return $sniff; }
}
function um_chunks_html($div="",$js=0) {
	$chunk_dir=get_stylesheet_directory()."/chunks";
	if (!file_exists($chunk_dir) and !is_dir($chunk_dir)) { mkdir($chunk_dir); }?>
	<div id="toucher" style="margin-bottom: .5em"><?php echo $div; ?>&nbsp; </div><?php
	echo "<div class='postbox'><h3 class='inside'>Chunks</h3><ul data-dir='chunk' class='um-list inside'>\n";
	$chunks=glob($chunk_dir."/*.txt");
	foreach ($chunks as $c) {
		$fn=explode("/",$c); $fnc=$fn[count($fn)-1]; $fn=explode(".",$fnc);
		$sniff=get_sniff($c);
		echo "<li data-file='$fnc'>";
			echo "<i class='dashicons-format-aside um-dashicons icons'></i>";
			echo "<strong><a href='#' data-act='edit'>$fn[0]</a></strong>";
			echo "<span class='last'><a href='#' class='del' data-act='del'><i class='dashicons-no um-dashicons'></i></a></span>";
			echo "<span><small>".date('d-m-Y H:i',filemtime($c))."</small></span>";
			echo "<span class='shortcode'>[chunk file=$fn[0]]</span>";
			echo "<span class='shortcode php'>um_chunk(\"$fn[0]\"); </span>";
			echo "<div class='view'><small>$sniff</small></div>";
		echo "</li>";
	}
	echo "</ul></div>"; ?>
	<h4>Create New Chunks</h4>
	<p><input type="text" name="new_chunk_name" id='new_chunk'
	value="" size="18" /><button class='nchunk button'>touch</button>
	<br><small>.txt extension will be added to file</small></p>
	</div>
	<?php if ($js== 1) { ?><script type="text/javascript">umlist_function_init('.um-frame-box')</script><?php }
}