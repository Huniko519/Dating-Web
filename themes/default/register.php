<style>#nav-not-logged-in,.page-footer{display: none !important;visibility: hidden !important;}</style>
<!-- Header  -->
	<nav role="navigation">
        <div class="nav-wrapper container">
            <div class="left header_logo">
                <a id="logo-container" href="<?php echo $site_url;?>/" class="brand-logo"><img src="<?php echo $theme_url;?>assets/img/logo.png" /></a>
            </div>
            <ul class="right not_usr_nav">
                <li class="hide-on-med-and-down black-text"><?php echo __( 'Already have an account?' );?></li>
				<li class="hide_mobi_login"><a href="<?php echo $site_url;?>/login" data-ajax="/login" class="btn-flat btn bold white waves-effect black-text"><?php echo __( 'Login' );?></a></li>
                <div class="show_mobi_login">
                    <a class="dropdown-trigger" href="#" data-target="log_in_dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#222" d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z" /></svg></a>
                    <ul id="log_in_dropdown" class="dropdown-content">
                        <li><a href="<?php echo $site_url;?>/login" data-ajax="/login"><?php echo __( 'Login' );?></a></li>
                        <li><a href="<?php echo $site_url;?>/register" data-ajax="/register"><?php echo __( 'Register' );?></a></li>
                    </ul>
                </div>
            </ul>
        </div>
    </nav>
<!-- End Header  -->
<!-- Login  -->
	<div class="container-fluid auth_bg_img">
		<div class="usr_circle sml" style="background-image: url(<?php echo $theme_url;?>assets/img/login-sm.jpg);"></div>
		<div class="usr_circle mdm" style="background-image: url(<?php echo $theme_url;?>assets/img/login-md.jpg);"></div>
		<div class="usr_circle mlr" style="background-image: url(<?php echo $theme_url;?>assets/img/login-ml.jpg);"></div>
		<div class="usr_circle lrg" style="background-image: url(<?php echo $theme_url;?>assets/img/register.jpg);"></div>
		<div class="container dt_login_bg">
			<div class="section">
				<div class="dt_login_con">
					<div class="row dt_login">
						<form method="POST" action="/Useractions/register" class="register">
							<p><span class="bold"><?php echo __( 'Get started,' );?></span> <?php echo __( 'please signup to continue your account.' );?></p>
							<div class="alert alert-success" role="alert" style="display:none;"></div>
							<div class="alert alert-danger" role="alert" style="display:none;"></div>
							<div class="row">
								<div class="input-field col s6">
									<input name="first_name" id="first_name" type="text" class="validate" value="" autofocus>
									<label for="first_name"><?php echo __( 'First Name' );?></label>
								</div>
								<div class="input-field col s6">
									<input name="last_name" id="last_name" type="text" class="validate" value="">
									<label for="last_name"><?php echo __( 'Last Name' );?></label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s6">
									<input name="username" id="username" type="text" class="validate" value="" required>
									<label for="username"><?php echo __( 'Username' );?></label>
								</div>
								<div class="input-field col s6">
									<input name="email" id="email" type="email" class="validate" value="" required>
									<label for="email"><?php echo __( 'Email' );?></label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s6">
									<input name="password" id="password" type="password" class="validate" value="" required>
									<label for="password"><?php echo __( 'Password' );?></label>
								</div>
								<div class="input-field col s6">
									<input name="c_password" id="c_password" type="password" class="validate" value="" required>
									<label for="c_password"><?php echo __( 'Confirm Password' );?></label>
								</div>
							</div>
							<label class="terms_check">
								<input class="filled-in" type="checkbox" onchange="activateButton(this)" />
								<span>By creating your account, you agree to our <a href="<?php echo $site_url;?>/terms" data-ajax="/terms">Terms of Use</a> & <a href="<?php echo $site_url;?>/privacy" data-ajax="/privacy">Privacy Policy</a></span>
							</label>
							<div class="dt_login_footer valign-wrapper">
								<button class="btn btn-large waves-effect waves-light bold btn_primary btn_round" id="sign_submit" type="submit" disabled><span><?php echo __( 'Register' );?></span> <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path></svg></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- End Login  -->

<!--  Scripts-->
<script>
var password = document.getElementById("password"), confirm_password = document.getElementById("c_password");

function validatePassword(){
	if(password.value != confirm_password.value) {
		confirm_password.setCustomValidity("Passwords Don't Match");
	} else {
		confirm_password.setCustomValidity('');
	}
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

function activateButton(element) {
	if(element.checked) {
		document.getElementById("sign_submit").disabled = false;
	}
	else  {
		document.getElementById("sign_submit").disabled = true;
	}
};
</script>