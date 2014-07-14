function toucher_collector(obj) { return { a : obj.data('a'), f : obj.data('f'), t : obj.data('t') } }
function safephpNameof(name) { name.replace(/\.php/g, ''); name.replace(/\W/g, ''); return name+".php"; }
function safetxtNameof(name) { name.replace(/\.txt/g, ''); name.replace(/\W/g, ''); return name+".txt"; }

function um_confirm() {
	jQuery('a.um_confirm').click(function(e) {
		e.preventDefault();	
		$this = jQuery(this);
		$href = $this.attr('href')
		$text = $this.text();
		var r = confirm("Confirm to : "+$text);
		if (r == true) {
			window.location.assign($href)
		}
	});

}

function umtab () {
	jQuery('.maketab > div > h3').each(function(i) {
		$this = jQuery(this);
		$tab = jQuery('#umtab'); act = '';
		title = $this.text(); safeid = title.replace(/[\s|\W]/g,'');
		$this.parent().wrap("<div class='umtab hide' id='tab-"+safeid+"'></div>");
		if (i === 0) { jQuery('#tab-'+safeid).show(); act=' class="active" ';}
		$tab.append("<li><a "+act+" href='#tab-"+safeid+"'>"+title+"</a></li>");
	});

	umtab_init();
}

function um_datacheck(cstr) {
	jQuery('.umplugs *[data-check]').each(function(i) {
		$this = jQuery(this); what = cstr+"["+$this.data('check')+"]";
		//console.log($this.attr('name'), what);
		if ( what != cstr+"[]" ) {
			if (!jQuery('.umplugs input[name="'+what+'"]').attr('checked')) { 
				$this.attr('disabled','disabled')
				$this.closest('tr').css('opacity','.5');
			} 
		}
	});
}

function umtab_init() {
	jQuery('#umtab a').click(function(e) {
		e.preventDefault(); $this = jQuery(this); $this.addClass('active');
		target = $this.attr('href'); tab = jQuery(target)
		tab.show();
		tab.siblings('.umtab').hide();
		$this.parent().siblings().children('a').removeClass('active');

	})
}

function umeditor_init(obj) {
	var $umdiv = jQuery(obj);
	jQuery('.um-editor textarea').height (jQuery(window).innerHeight()-300);
	jQuery('.um-editor #submit').click(function(e) {
		e.preventDefault();
		var fodavar = {
		'f':jQuery('.um-editor textarea').data('file'),
		'd':jQuery('.um-editor textarea').data('dir'),
		'a':jQuery(this).data('act'),
		}
		fodavar['text'] = jQuery('.um-editor textarea').val();

		//console.log(fodavar['a'], fodavar['d'], fodavar['f']);
		jQuery.post(ajaxurl, { action: 'foda', v: fodavar }, function(res) { $umdiv.html(res); });

	})
}

function fodavar_check(foda) {
	if (foda['f'] =="") return false;
	if (foda['f'] ==".php") return false;
	if (foda['a'] =="") return false;
	return true
}

function umlist_function_init(obj) {

	var $umdiv = jQuery(obj);

	jQuery('button.set').click (function(e) {
		e.preventDefault();
		var obj = jQuery(this).parent();
		var fodavar = {
			'f': obj.children('select').val(),
			'a': jQuery(this).data('act'),
			'd': obj.data('d')
		}
		if (fodavar_check(fodavar)===true) {
			//console.log(fodavar['a'], fodavar['d'], fodavar['f']);
			jQuery.post(ajaxurl, { action: 'foda', v: fodavar }, function(res) { $umdiv.html(res); });
		}
	});

	jQuery('button.select-touch').click (function(e) {
		e.preventDefault();
		var obj = jQuery(this).parent();
		var fodavar = {
			'f': obj.children('select').val(),
			'a': jQuery(this).data('act'),
			'd': obj.children('select').data('d')
		}
		if (fodavar_check(fodavar)===true) {
			//console.log(fodavar['a'], fodavar['d'], fodavar['f']);
			jQuery.post(ajaxurl, { action: 'foda', v: fodavar }, function(res) { $umdiv.html(res); });
		}
	});
	
	jQuery('button.input-touch').click (function(e) {
		e.preventDefault();
		var obj = jQuery(this).parent();
		var d = obj.children('input[type=text]').data('d');

		if (d =="chunk") {
			var f = safetxtNameof( obj.children('input[type=text]').val() )
		} else {
			var f = safephpNameof( obj.children('input[type=text]').val() )
		}
		
		var fodavar = {
			'f': f,
			'a': jQuery(this).data('act'),
			'd': d
		}
		if (fodavar_check(fodavar)===true) {
			//console.log(fodavar['a'], fodavar['d'], fodavar['f']);
			jQuery.post(ajaxurl, { action: 'foda', v: fodavar }, function(res) { $umdiv.html(res); });
		}
	});	

	jQuery('.um-list a').click(function(e) {
		e.preventDefault();
		var fodavar = {
		'f':jQuery(this).parents('li').data('file'),
		'd':jQuery(this).closest('ul').data('dir'),
		'a':jQuery(this).data('act'),
		}

		//fallback
		if (!fodavar['d']) { fodavar['d'] = jQuery(this).data('d'); }
		if (fodavar['a']=="wpedit") { window.location = jQuery(this).attr('href'); }
		if (!fodavar['f']) { fodavar['f'] = jQuery(this).data('f'); }
		
		if (fodavar_check(fodavar)===true) {
			//console.log(fodavar['a'], fodavar['d'], fodavar['f']);
			jQuery.post(ajaxurl, { action: 'foda', v: fodavar }, function(res) { $umdiv.html(res); });
		}
	})

}
jQuery(document).ready(function($) {
	umlist_function_init('.umplugs');
	umtab();
	um_confirm();
});
