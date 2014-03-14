function um_getlogout() {
	var obj = jQuery('div.um_login_div');
	//console.log(obj.html());
	document.location.href = obj.attr('href');
}

jQuery(document).ready(function($) {

	var autologin = document.URL.split('#')[1]

 $('a#show_login').on('click', function(e){ e.preventDefault(); um_loginoverlay($('form#um-login')); });

	var logout_url = $('div.um_login_div a.logout').attr('href');
	if ($('.menu-item a[href="/wp-login"]').length>0) { $('div.um_login_div').remove(); }

	if((typeof UM_GUI_WPUSER == 'undefined')) { return; }

 if (UM_GUI_WPUSER<1) {
		$('.menu-item a[href="/wp-login"]').on('click', function(e){ e.preventDefault(); um_loginoverlay($('form#um-login')); });
	} else {
		var m = $('.menu-item a[href="/wp-login"]').parent(); var ma = m.children('a');
		ma.attr('href','#logout'); ma.text('Logout');
		//console.log(logout_url);
		$('.menu-item a[href="#logout"]').on('click', function(e) { e.preventDefault(); document.location.href = logout_url; });
	}

	if (autologin == "wplogin") { um_loginoverlay($('form#um-login')); }

	//console.log(um_login_object.redirecturl);
 $('form#um-login').on('submit', function(e){
 $('form#um-login p.status').show().text(um_login_object.loadingmessage);
		//console.log(um_login_object.ajaxurl);
		$.ajax({
 type: 'POST',
 dataType: 'json',
 url: um_login_object.ajaxurl,
 data: {
 'action': 'um_ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
 'username': $('form#um-login #username').val(),
 'password': $('form#um-login #password').val(),
 'security': $('form#um-login #security').val() },
 success: function(data){
 $('form#um-login p.status').text(data.message);
 if (data.loggedin == true){
 document.location.href = um_login_object.redirecturl;
 }
 }
 });
 e.preventDefault();
 });


});