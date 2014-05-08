function um_toc(obj,ele,titleText) {
	obj.prepend("<ol></ol>");
	$toc = obj.children('ol');
	obj.find(ele).each(function(i) {
		title = jQuery(this).text(); safeid = title.replace(/[\s|\W]/g,'');
		jQuery(this).prepend("<a id='"+safeid+"'></a>");
		$toc.append("<li><a href='#"+safeid+"'>"+title+"</a></li>");
	});
	$toc.wrap('<div class="um_toc"></div>');
	obj.children('.um_toc').prepend("<h5>"+titleText+"</h5>");
	
}

function um_tab_init(obj) {
		obj.find('a.tabmenu').click(function(e) {
			e.preventDefault();
			jQuery(this).addClass('active');
			target = jQuery(this).attr('href'); 
			tab = jQuery(target); tab.show();
			tab.siblings('.um_tab_content').hide();
			jQuery(this).parent().siblings().children('a').removeClass('active');
	});
}

function um_tab(obj) {
	obj.prepend("<ul id='um_tab'></ul>");
	$tab = obj.children('#um_tab');
	obj.find('h3').each(function(i) {
		act = ''; title = jQuery(this).text(); safeid = title.replace(/[\s|\W]/g,'');
		jQuery(this).parent().wrap("<div class='um_tab_content hide' id='tab-"+safeid+"'></div>");
		if (i === 0) { jQuery('#tab-'+safeid).show(); act=' active'; }
		$tab.append("<li><a class='tabmenu "+act+"' href='#tab-"+safeid+"'>"+title+"</a></li>");
	});
	um_tab_init($tab);
}

function um_content_height(target,min) {
	// Make target fit its windows
	var h = jQuery(window).innerHeight()-jQuery('#colophon').outerHeight()-jQuery('#masthead').outerHeight();
	if (h < 0 ) { h = min }
	target.css('min-height',h+'px');
}

function um_fx_init() {
	jQuery('.um-msg').each( function(e) {
		$this = jQuery(this);
		console.log($this.html());
		$this.append('<i class="close umi-no"></i>');
		$this.click(function(e) { jQuery(this).remove(); });
	});
}

function um_fit_img(target) {
	// Make images fit it's ratio
	target.each( function(e) {
		var iw = jQuery(this).attr('width'); var ih = jQuery(this).attr('height');
		var w = jQuery(this).width(); jQuery(this).height(h = (ih/iw)*w);
	});
}

function um_onscroll_fixed(target,dockto,adjustment) {
	// Make target stop scoll at its dock position
	var w = jQuery(window);
	if (target.length > 0) {
		console.log('ready');
		var offset = target.offset();
		var top = offset.top; target.data('original-y',top);
		var margin = jQuery('.site-header').outerHeight();
		if (dockto) {
			var docktoY = dockto.outerHeight();
		} else {
			var docktoY = jQuery('.main-navigation').outerHeight();
		}
		w.on( "scroll", function(e) {
			var scroll = w.scrollTop();
			if (scroll > margin) { 
				var fix = adjustment+docktoY;
				target.css('position','fixed'); 
				target.css('top',fix+"px"); 
				target.css('z-index',99970);
			} else {
				target.css('position','static');
				target.css('top',target.data('original-y')+"px");
			}
		});
	} else {
		console.log("um_onscroll_fixed: target not found");
	}
	
}

/* ---------------------------------------------------------------------------- 
 *
 */

function um_overlay_badge_fx() {
	jQuery('.um-badge').each(function(e) {
		w = jQuery(this).width(); if (w<40) { w = 40;jQuery(this).width(w) }
		x = jQuery(this).parent().outerWidth()-w-5;
		y = -42;

		jQuery(this).css({
			'margin' : 0,
			'padding' : 0,
			'top' : y,
			'left': x,
			'position':'absolute'
		})
	});
}

function um_loginoverlay(obj) {
	jQuery('body').prepend('<div class="um-dark-overlay"></div>');
	um_overlay_badge_fx();
	obj.fadeIn(250);
	jQuery('div.login_overlay, form#um-login a.close').on('click', function(){
		jQuery('div.login_overlay').remove(); obj.hide();
	});

	title = obj.children('h1'); $title = title.html();
	//title.remove();
	title.toggleClass("um-overlay-fx");
	title.css({
		'margin' : 0,
		'padding' : 0,
		'top' : -42,
		'left': 0,
		'position':'absolute'
	});
}

/* ---------------------------------------------------------------------------- 
 * css colours manipulations 
 *
 */

function um_hexToRgb(hex) {
	var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
	hex = hex.replace(shorthandRegex, function(m, r, g, b) {
		return r + r + g + g + b + b;
	});
	var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	return result ? {
		r: parseInt(result[1], 16),
		g: parseInt(result[2], 16),
		b: parseInt(result[3], 16)
	} : null;
}

function um_rgbToHex(rgb) {
	return "#" + ((1 << 24) + (rgb['r'] << 16) + (rgb['g'] << 8) + rgb['b']).toString(16).slice(1);
}

function um_modcolor(rgb,n) {
	rgb['r'] = rgb['r']+n; if (rgb['r']>255) { rgb['r']=255; } if (rgb['r']<0) { rgb['r']=0 }
	rgb['g'] = rgb['g']+n; if (rgb['g']>255) { rgb['g']=255; } if (rgb['g']<0) { rgb['g']=0 }
	rgb['b'] = rgb['b']+n; if (rgb['b']>255) { rgb['b']=255; } if (rgb['b']<0) { rgb['b']=0 }
	return rgb;
}

function get_elementColor(id,what) {
	var rgba = id.css(what);
	if((typeof rgba != 'undefined') && (rgba != "rgba(0, 0, 0, 0)")) {
		if (rgba.split("(")[0] == "rgba") {
			rgba = rgba.match(/^rgba\((\d+),\s*(\d+),\s*(\d+),\s*(.+)\)$/);
			return {r: parseInt(rgba[1]),g: parseInt(rgba[2]),b: parseInt(rgba[3]),a: parseInt(rgba[4]) }

		} else {
			rgba = rgba.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
			return {r: parseInt(rgba[1]),g: parseInt(rgba[2]),b: parseInt(rgba[3]) }
		}

	} else {
		return {r:192,g:192,b:192}
	}

}

function um_getrgbof(id,what,alpha) {
	var rgb = get_elementColor(id,what);
	var a = "rgba("+rgb['r']+","+rgb['g']+","+rgb['b']+","+alpha+")";
	return a;
}

function um_getmodcolor (id,what,v) {
	var rgb = get_elementColor(id,what);
	var rgb = um_modcolor(rgb,v);
	return um_rgbToHex(rgb);
}

