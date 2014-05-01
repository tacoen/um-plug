(function($) {



function set_preview_frame(w) {
	//console.log(w);
	var d  = $(window.parent.document).find('#customize-preview'); var i = d.children('iframe');
	i.css('width',w);
}

function um_layout_pane() {
	var d  = $(window.parent.document).find('#customize-controls');
	var $pane = "<div id='um_layout_pane'>" 
		+"<div><a href='#' data-width='100%' title='fluid-width'><i class='dashicons dashicons-desktop'></i></a></div>"
		+"<div><a href='#' data-width='800px' title='Max: 800px'><i class='dashicons dashicons-tablet'></i></a></div>"
		+"<div><a href='#' data-width='540px' title='Max: 540px'><i class='dashicons dashicons-smartphone'></i></a></div>"
		+"<div class='label'>Media Queries</div>";
		+"</div>";
	d.append($pane);
	//console.log('um-layout ready');
	var p = d.find('#um_layout_pane');
	p.find('a').click( function(e) {
		e.preventDefault();
		set_preview_frame( $(this).data('width') );
	});

}

$(document).ready(function(){
	um_layout_pane();
});


})(jQuery);