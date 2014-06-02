/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referring to this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'umi-wp-font\'">' + entity + '</span>' + html;
	}
	var icons = {
		'umi-point-up': '&#x261d;',
		'umi-point-right': '&#x261e;',
		'umi-point-down': '&#x261f;',
		'umi-point-left': '&#x261c;',
		'umi-googleplus': '&#xe612;',
		'umi-googleplus2': '&#xe613;',
		'umi-googleplus3': '&#xe614;',
		'umi-facebook': '&#xe615;',
		'umi-facebook2': '&#xe616;',
		'umi-facebook3': '&#xe617;',
		'umi-twitter': '&#xe618;',
		'umi-twitter2': '&#xe619;',
		'umi-twitter3': '&#xe61a;',
		'umi-feed': '&#xe61b;',
		'umi-vimeo': '&#xe61c;',
		'umi-vimeo2': '&#xe61d;',
		'umi-vimeo3': '&#xe61e;',
		'umi-github': '&#xe61f;',
		'umi-github2': '&#xe620;',
		'umi-wordpress': '&#xe63f;',
		'umi-tumblr': '&#xe621;',
		'umi-file-pdf': '&#xe622;',
		'umi-file-word': '&#xe623;',
		'umi-file-excel': '&#xe624;',
		'umi-file-zip': '&#xe625;',
		'umi-file-powerpoint': '&#xe626;',
		'umi-file-css': '&#xe627;',
		'umi-search': '&#x27a0;',
		'umi-envelope-o': '&#x2709;',
		'umi-heart': '&#x2665;',
		'umi-star': '&#x2605;',
		'umi-star-o': '&#x2606;',
		'umi-th': '&#x2637;',
		'umi-check': '&#x2713;',
		'umi-times': '&#xd7;',
		'umi-edit': '&#x270f;',
		'umi-arrow-left': '&#x2190;',
		'umi-arrow-right': '&#x2192;',
		'umi-arrow-up': '&#x2191;',
		'umi-arrow-down': '&#x2193;',
		'umi-caret-down': '&#x25bc;',
		'umi-caret-up': '&#x25b2;',
		'umi-caret-left': '&#x25c0;',
		'umi-caret-right': '&#x25b6;',
		'umi-angle-double-left': '&#xab;',
		'umi-angle-double-right': '&#xbb;',
		'umi-angle-double-up': '&#xf102;',
		'umi-angle-double-down': '&#xf103;',
		'umi-angle-left': '&#x2039;',
		'umi-angle-right': '&#x203a;',
		'umi-angle-up': '&#x5e;',
		'umi-angle-down': '&#x76;',
		'umi-desktop': '&#x31;',
		'umi-laptop': '&#x32;',
		'umi-tablet': '&#x33;',
		'umi-mobile-phone': '&#x34;',
		'umi-ellipsis-h': '&#x22ef;',
		'umi-ellipsis-v': '&#x22ee;',
		'umi-paperclip': '&#xe600;',
		'umi-user': '&#xe601;',
		'umi-vcard': '&#xe602;',
		'umi-location': '&#xe603;',
		'umi-map': '&#xe644;',
		'umi-chat': '&#xe604;',
		'umi-comment': '&#xe641;',
		'umi-house': '&#xe640;',
		'umi-printer': '&#xe645;',
		'umi-link': '&#xe605;',
		'umi-cog': '&#xe628;',
		'umi-tools': '&#xe629;',
		'umi-tag': '&#xe606;',
		'umi-camera': '&#xe607;',
		'umi-book': '&#xe608;',
		'umi-newspaper': '&#xe609;',
		'umi-clock': '&#x231a;',
		'umi-calendar': '&#xe63c;',
		'umi-key': '&#x26bf;',
		'umi-earth': '&#xe60a;',
		'umi-code': '&#xe63e;',
		'umi-cart': '&#xe62a;',
		'umi-rss': '&#xe60b;',
		'umi-lock': '&#xe62b;',
		'umi-lock-open': '&#xe62c;',
		'umi-logout': '&#xe63a;',
		'umi-login': '&#xe63b;',
		'umi-minus': '&#xe62d;',
		'umi-plus': '&#xe62e;',
		'umi-cross': '&#x22a0;',
		'umi-cross2': '&#x2297;',
		'umi-help': '&#xe630;',
		'umi-warning': '&#xe631;',
		'umi-list': '&#x39e;',
		'umi-pictures': '&#xe60c;',
		'umi-video': '&#xe60d;',
		'umi-music': '&#xe60e;',
		'umi-folder': '&#xe60f;',
		'umi-bookmark': '&#xe610;',
		'umi-bookmarks': '&#xe611;',
		'umi-play': '&#xe632;',
		'umi-pause': '&#xe633;',
		'umi-record': '&#xe634;',
		'umi-stop': '&#xe635;',
		'umi-next': '&#xe636;',
		'umi-previous': '&#xe637;',
		'umi-first': '&#xe638;',
		'umi-last': '&#xe639;',
		'umi-arrow-left2': '&#x21a4;',
		'umi-arrow-down2': '&#x21a7;',
		'umi-arrow-up2': '&#x21a5;',
		'umi-arrow-right2': '&#x21a6;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/umi-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
