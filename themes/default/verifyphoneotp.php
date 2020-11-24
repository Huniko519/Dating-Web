<style>#nav-not-logged-in,.page-footer{display: none !important;visibility: hidden !important;}</style>

	<div class="container-fluid auth_bg_img">
		<div class="usr_circle sml" style="background-image: url(<?php echo $theme_url;?>assets/img/login-sm.jpg);"></div>
		<div class="usr_circle mdm" style="background-image: url(<?php echo $theme_url;?>assets/img/login-md.jpg);"></div>
		<div class="usr_circle mlr" style="background-image: url(<?php echo $theme_url;?>assets/img/login-ml.jpg);"></div>
		<div class="usr_circle lrg" style="background-image: url(<?php echo $theme_url;?>assets/img/forgot.jpg);"></div>
		<div class="container dt_login_bg">
			<div class="section">
				<div class="dt_login_con">
					<div class="row dt_login">
						<form method="POST" action="/Useractions/verifyphone_otp" class="register">
							<p><span class="bold"><?php echo __( 'Phone activiation,' );?></span> <?php echo __( 'Please enter the verification code sent to your phone' );?></p>
							<div class="alert alert-success" role="alert" style="display:none;"></div>
							<div class="alert alert-danger" role="alert" style="display:none;"></div>
							<div class="enter_otp_email" style="display: block;border: 0px;">
								<div id="otp_outer">
									<div id="otp_inner">
										<input id="otp_check_forget_phone" name="sms_code" type="text" maxlength="4" value="" pattern="\d*" title="Field must be a number." onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required  /><br><br>
										<input type="hidden" name="phone" value="<?php if( isset( $_COOKIE['verify_phone'] ) ) { echo Secure($_COOKIE['verify_phone']); }?>">
										<a href="javascript:void(0);" data-ajax="/verifyphone"><?php echo __( 'Resend' );?></a>
									</div>
								</div>
							</div><br>
							<div class="dt_login_footer valign-wrapper">
								<button class="btn btn-large waves-effect waves-light bold btn_primary btn_round" type="submit" name="action"><span><?php echo __( 'Proceed' );?></span> <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path></svg></button>
							</div>
						</form>
					</div>		
				</div>
			</div>
		</div>
	</div>