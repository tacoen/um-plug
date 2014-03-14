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
			//console.log("rgba="+rgba+"//");
			rgba = rgba.match(/^rgba\((\d+),\s*(\d+),\s*(\d+),\s*(.+)\)$/);
			//console.log(rgba);
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
	var rgb = get_elementColor(id,what)
	var a = "rgba("+rgb['r']+","+rgb['g']+","+rgb['b']+","+alpha+")";
	return a;
}

function um_getmodcolor (id,what,v) {
	var rgb = get_elementColor(id,what)
	var rgb = um_modcolor(rgb,v);
	return um_rgbToHex(rgb);
}

