(function($) {

console.log('scheme customize ready');

function escapeRegExp(str) {
 return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
}

function replaceAll(find, replace, str) {
 return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}

function css_change(name,from,to) {
	$obj = $('head #um_color_css_preview');
	$css = $obj.text();
	var nto = to+"/*"+name+"*/" /* fokus pokus */
	$from = escapeRegExp(from);
	$new = $css.replace(new RegExp($from,'gi'),nto);
	$obj.text($new)
	//console.log($('head #um_color_css_preview').text ());
	//console.log(from+"-->"+$from+"-->"+nto);
	return nto
}

wp.customize('umto[color1]', function(value){value.bind(function(to){um_c1 = css_change('um-title',um_c1,to);});});
wp.customize('umto[color2]', function(value){value.bind(function(to){um_c2 = css_change('um-text',um_c2,to);});});
wp.customize('umto[color3]', function(value){value.bind(function(to){um_c3 = css_change('um-page',um_c3,to);});});
wp.customize('umto[color4]', function(value){value.bind(function(to){um_c4 = css_change('um-line',um_c4,to);});});
wp.customize('umto[color5]', function(value){value.bind(function(to){um_c5 = css_change('um-hot',um_c5,to);});});
wp.customize('umto[color6]', function(value){value.bind(function(to){um_c6 = css_change('um-confirm',um_c6,to);});});
wp.customize('umto[color7]', function(value){value.bind(function(to){um_c7 = css_change('um-cool',um_c7,to);});});
wp.customize('umto[color8]', function(value){value.bind(function(to){um_c8 = css_change('um-prompt',um_c8,to);});});
wp.customize('umto[color9]', function(value){value.bind(function(to){um_c9 = css_change('um-link',um_c9,to);});});

})(jQuery);