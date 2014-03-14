function toucher_collector(obj) { return { a : obj.data('a'), f : obj.data('f'), t : obj.data('t') } }
function safephpNameof(name) { name.replace(/\.php/g, ''); name.replace(/\W/g, ''); return name+".php"; }
function safetxtNameof(name) { name.replace(/\.txt/g, ''); name.replace(/\W/g, ''); return name+".txt"; }

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
//	console.log('umeditor_init');

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
		jQuery.post(ajaxurl, { action: 'foda', v: fodavar }, function(res) { $umdiv.html(res); });

	})
}

function umlist_function_init(obj) {

	var $umdiv = jQuery(obj);

	jQuery('.um-list li a').click(function(e) {
		e.preventDefault();
		var fodavar = {
		'f':jQuery(this).parents('li').data('file'),
		'd':jQuery(this).closest('ul').data('dir'),
		'a':jQuery(this).data('act'),
		}

		//fallback
		if (!fodavar['d']) { fodavar['d'] = jQuery(this).data('dir'); }
		if (fodavar['a']=="wpedit") { window.location = jQuery(this).attr('href'); }
		jQuery.post(ajaxurl, { action: 'foda', v: fodavar }, function(res) { $umdiv.html(res); });
	})

	jQuery('button.nchunk').click (function(e) {
		e.preventDefault();
		var fodavar = {
			'f': safetxtNameof (jQuery('#new_chunk').val()),
			'a': 'touch',
			'd': 'chunk',
		}
		console.log(fodavar['a'], fodavar['d'], fodavar['f']);
		jQuery.post(ajaxurl, { action: 'foda', v: fodavar }, function(res) { $umdiv.html(res); });
	});

	jQuery('button.touch').click (function(e) {
		e.preventDefault();
		var fodavar = {
			'f': jQuery('div.udtmd #undressme-tm-file').val(),
			'a': 'touch',
			'd': jQuery('div.udtmd #undressme-tm-file').data('d')
		}

		jQuery.post(ajaxurl, { action: 'foda', v: fodavar }, function(res) { $umdiv.html(res); });
	});

	jQuery('button.ptouch').click (function(e) {
		e.preventDefault();
		var fodavar = {
			'f': safephpNameof(jQuery('div.udptf input[type=text]').val()),
			'a': 'ptouch',
			'd': jQuery('div.udptf input[type=text]').data('d')
		}
		//console.log (fodavar['f'],fodavar['a'],fodavar['d']);
		jQuery.post(ajaxurl, { action: 'foda', v: fodavar }, function(res) { $umdiv.html(res); });
	});
}



jQuery(document).ready(function($) {

	umlist_function_init('.um-frame-box');
	umtab();

});
