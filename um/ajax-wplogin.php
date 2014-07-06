<?php
defined('ABSPATH') or die('Huh?');


add_action('wp_footer','um_loginbox');
add_action('wp_ajax_nopriv_um_ajaxlogin','um_ajaxlogin');
add_action('wp_enqueue_scripts','um_ajaxlogin_scripts');

function um_loginbox() {
	if (! is_user_logged_in()) { ?>
	<form id="um-login" action="login" method="post">
	<a class="close um-badge um-link-button" href=''>close</a>
	<h1><?php bloginfo('title'); ?></h1>
	<p class="status"></p>
	<p><label for="username">Username</label><input id="username" type="text" name="username"></p>
	<p><label for="password">Password</label><input id="password" type="password" name="password"></p>
	<p class="submit"><span class='label'><a class="lost" href="<?php echo wp_lostpassword_url(); ?>">Lost your password?</a></span>
	<?php wp_nonce_field('um_ajaxlogin-nonce','security'); ?>
	<input class="submit_button" type="submit" value="Login" name="submit"></p>
	</form><script type="text/javascript">/* <![CDATA[ */ var UM_GUI_WPUSER=0; /* ]]> */</script>
	<div class='um_login_div'><a class="login_button login" id="show_login" href=''>Login</a></div>
<?php } else { ?>
	<div class='um_login_div'><a class="login_button logout" href="<?php echo wp_logout_url(home_url()); ?>">Logout</a></div>
	<script type="text/javascript">/* <![CDATA[ */ var UM_GUI_WPUSER=1; /* ]]> */</script>
<?php }
}

function um_ajaxlogin_scripts() {
	wp_enqueue_script('um-login',um_tool_which('js/um-login.js'),array(),um_ver(),true);
	wp_localize_script('um-login','um_login_object',array(
			'ajaxurl'=> admin_url('admin-ajax.php'),
			'redirecturl'=> um_getoption('ajredir','umt'),
			'loadingmessage'=> __('Please wait...','um')
	));
}

function um_ajaxlogin() {
	check_ajax_referer('um_ajaxlogin-nonce','security');
	$info=array();
	$info['user_login']=$_POST['username'];
	$info['user_password']=$_POST['password'];
	$info['remember']=true;
	$user_signon=wp_signon($info,false);
	if (is_wp_error($user_signon)) {
		echo json_encode(array('loggedin'=>false,'message'=>__('Wrong username or password.')));
	} else {
		echo json_encode(array('loggedin'=>true,'message'=>__('Login successful,redirecting...')));
	}
	die();
}