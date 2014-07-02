var fluid_width = "100%";
var tablet_width = um_layout_viewobject['dmqmed']+"px";
var hand_width = um_layout_viewobject['dmqsml']+"px";

(function($) {

function set_preview_frame(w) {
	var d  = $(window.parent.document).find('#customize-preview'); var i = d.children('iframe');
	i.css('width',w);
}

function um_layout_pane() {
	var d  = $(window.parent.document).find('#customize-controls');
	var $pane = "<div id='um_layout_pane'>" 
		+"<div><a href='#' data-width='"+fluid_width+"'  title='Max: "+fluid_width+"'>"
			+ "<i class='dashicons dashicons-desktop'></i></a></div>"
		+"<div><a href='#' data-width='"+tablet_width+"' title='Max: "+tablet_width+"'>"
			+ "<i class='dashicons dashicons-tablet'></i></a></div>"
		+"<div><a href='#' data-width='"+hand_width+"'   title='Max: "+hand_width+"'>"
			+"<i class='dashicons dashicons-smartphone'></i></a></div>"
		+"</div>";
	d.append($pane);
	var p = d.find('#um_layout_pane');
	p.find('a').click( function(e) {
		e.preventDefault();
		set_preview_frame( $(this).data('width') );
	});

}

$(document).ready(function(){
	um_layout_pane();
	console.log(um_layout_viewobject);
});


})(jQuery);