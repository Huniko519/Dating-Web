<style>#nav-not-logged-in,.page-footer{display: none !important;visibility: hidden !important;}</style>
<!-- Header  -->
<nav role="navigation">
    <div class="nav-wrapper container">
        <div class="left header_logo">
            <a id="logo-container" href="<?php echo $site_url;?>/" class="brand-logo"><img src="<?php echo $theme_url;?>assets/img/logo.png" /></a>
        </div>
        <ul class="right not_usr_nav">
            <li class="hide-on-med-and-down black-text"><?php echo __( 'Don\'t have an account?' ); ?></li>
            <li class="hide_mobi_login"><a href="<?php echo $site_url;?>/register" data-ajax="/register" class="btn-flat btn bold white waves-effect black-text"><?php echo __( 'Register' );?></a></li>
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
    <div class="usr_circle lrg" style="background-image: url(<?php echo $theme_url;?>assets/img/login.jpg);"></div>
    <div class="container dt_login_bg">
        <div class="section">
            <div class="dt_login_con">
                <div class="row dt_login login">
                    <form method="POST" action="/Useractions/login" class="login">
                        <p><span class="bold"><?php echo __( 'Two-factor authentication' );?></span> <?php echo __( 'To log in, you need to verify your identity.' );?></p>
                        <p>
                            <?php
                            if ($config->two_factor_type == 'both') {
                                echo __('We have sent you the confirmation code to your phone and to your email address.');
                            } else if ($config->two_factor_type == 'email') {
                                echo __('We have sent you the confirmation code to your email address.');
                            } else if ($config->two_factor_type == 'phone') {
                                echo __('We have sent you the confirmation code to your phone number.');
                            }
                            ?>
                        </p>
                        <div class="alert alert-success" role="alert" style="display:none;"></div>
                        <div class="alert alert-danger" role="alert" style="display:none;"></div>
                        <div class="row">
                            <div class="input-field">
                                <input name="confirm_code" id="confirm_code" placeholder="<?php echo __( 'Confirmation code' );?>" type="text" class="validate" required autofocus>
                                <label for="confirm_code"><?php echo __( 'Confirmation code' );?></label>
                            </div>
                        </div>
                        <div class="dt_login_footer valign-wrapper">
                            <button class="btn btn-large waves-effect waves-light bold btn_primary btn_round" type="button" id="btn_confirm" name="action"><span><?php echo __( 'Save' );?></span> <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path></svg></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class=""></div>
</div>
<!-- End Login  -->
<script>
$(function () {
    $('#btn_confirm').click(function(e){
        e.preventDefault();
        let confirm_code = $('#confirm_code').val();
        if(confirm_code === ''){
            alert('<?php echo __("Please enter confirmation code.");?>');
            return false;
        }
        let formData = new FormData();
        formData.append("confirm_code", confirm_code);

        $.ajax({
            type: 'POST',
            url: window.ajax + 'profile/confirm_two_factor_confirmation_code',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status == 200) {
                    var date = new Date();
                    date.setTime(date.getTime()+(10 * 365 * 24 * 60 * 60 * 1000 ) );
                    $.each(data.cookies, function(index, value) {
                        document.cookie = index + "=" + value + "; expires=" + date.toGMTString() + "; path=/";
                    });
                    setTimeout(function() {
                        window.location = data.url;
                    }, 2000);
                } else {
                    alert("<?php echo __('Error while login, please try again later.');?>");
                }
            }
        });

    });
});
</script>