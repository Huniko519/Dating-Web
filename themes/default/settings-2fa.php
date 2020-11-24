<?php
if( $config->two_factor == '0' ){
    echo '<script>window.location = window.site_url;</script>';
    exit();
}
$admin_mode = false;
if( $profile->admin == '1' || CheckPermission($profile->permission, "manage-users")){
    $target_user = route(2);
    $_user = LoadEndPointResource('users');
    if( $_user ){
        if( $target_user !== '' ){
            $profile = $_user->get_user_profile(Secure($target_user));
            if( !$profile ){
                echo '<script>window.location = window.site_url;</script>';
                exit();
            }else{
                $user = $profile;
                if( $profile->admin == '1' ){
                    $admin_mode = true;
                }
            }
        }
    }
}else{
    $user = auth();
}
?>
<?php //$user = auth();?>
<style>
    .dt_settings_header {margin-top: -3px;display: inline-block;}
    @media (max-width: 1024px){
        .dt_slide_menu {
            display: none;
        }
        nav .header_user {
            display: block;
        }
    }
</style>
<!-- Settings  -->
<div class="dt_settings_header bg_gradient">
    <div class="dt_settings_circle-1"></div>
    <div class="dt_settings_circle-2"></div>
    <div class="dt_settings_circle-3"></div>
    <div class="container">
        <div class="sett_active_svg">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,12H19C18.47,16.11 15.72,19.78 12,20.92V12H5V6.3L12,3.19M12,1L3,5V11C3,16.55 6.84,21.73 12,23C17.16,21.73 21,16.55 21,11V5L12,1Z"></path></svg>
        </div>
        <div class="sett_navbar valign-wrapper">
            <ul class="tabs">
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings/<?php echo $profile->username;?>" data-ajax="/settings/<?php echo $profile->username;?>" target="_self"><?php echo __( 'General' );?></a></li>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-profile/<?php echo $profile->username;?>" data-ajax="/settings-profile/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Profile' );?></a></li>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-privacy/<?php echo $profile->username;?>" data-ajax="/settings-privacy/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Privacy' );?></a></li>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-password/<?php echo $profile->username;?>" data-ajax="/settings-password/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Password' );?></a></li>
                <?php if( $config->social_media_links == 'on' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-social/<?php echo $profile->username;?>" data-ajax="/settings-social/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Social Links' );?></a></li><?php }?>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-blocked/<?php echo $profile->username;?>" data-ajax="/settings-blocked/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Blocked Users' );?></a></li>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-sessions/<?php echo $profile->username;?>" data-ajax="/settings-sessions/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Manage Sessions' );?></a></li>
                <?php if( $config->affiliate_system == '1' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-affiliate/<?php echo $profile->username;?>" data-ajax="/settings-affiliate/<?php echo $profile->username;?>" target="_self"><?php echo __( 'My affiliates' );?></a></li><?php } ?>
                <?php if( $config->two_factor == '1' ){ ?><li class="tab col s3"><a class="active" href="<?php echo $site_url;?>/settings-twofactor/<?php echo $profile->username;?>" data-ajax="/settings-twofactor/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Two-factor authentication' );?></a></li><?php } ?>
                <?php if( $config->emailNotification == '1' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-email/<?php echo $profile->username;?>" data-ajax="/settings-email/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Manage Notifications' );?></a></li><?php } ?>
                <?php if( $admin_mode == false && $config->deleteAccount == '1' ) {?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-delete/<?php echo $profile->username;?>" data-ajax="/settings-delete/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Delete Account' );?></a></li><?php } ?>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="dt_settings row">
        <div class="col s12 m3"></div>
        <form method="post" action="/profile/save_twofactor_setting" class="col s12 m6" id="twofactor_settings">

            <div class="alert alert-success" role="alert" style="display:none;"></div>
            <div class="alert alert-danger" role="alert" style="display:none;"></div>
			<div><?php echo __("Turn on 2-step login to level-up your account's security, Once turned on, you'll use both your password and a 6-digit security code sent to your phone or email to log in.");?></div>
			<br>
            <?php if ($config->two_factor_type == 'both' || $config->two_factor_type == 'phone') { ?>
                <div class="row">
                    <div class="input-field col s12">
                        <label class="col-md-12" for="phone_number"><?php echo __('Phone');?></label>
                        <input name="phone_number" id="phone_number" type="text" class="form-control input-md" autocomplete="off" placeholder="+15417543010" value="<?php echo $profile->phone_number?>">
                    </div>
                </div>
            <?php } ?>
            <?php if ($config->two_factor_type == 'both' || $config->two_factor_type == 'email') { ?>
                <div class="row">
                    <div class="input-field col s12">
                        <label class="col-md-12" for="new_email"><?php echo __('Email');?></label>
                        <input name="new_email" id="new_email" type="text" class="form-control input-md" autocomplete="off" value="<?php echo $profile->email?>">
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <div class="switch">
                        <label>
                            <?php echo __( 'Disable' );?>
                            <input type="checkbox" name="two_factor" id="two_factor"  <?php echo ( ( $profile->two_factor == 1 ) ? 'checked' : '' );?> >
                            <span class="lever"></span>
                            <?php echo __( 'Enable' );?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="dt_sett_footer valign-wrapper">
                <button class="btn btn-large waves-effect waves-light bold btn_primary btn_round" type="button" name="action" id="save_form"><span><?php echo __( 'Save' );?></span> <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path></svg></button>
            </div>
            <?php if( $admin_mode == true ){?>
                <input type="hidden" name="targetuid" value="<?php echo strrev( str_replace( '==', '', base64_encode($profile->id) ) );?>">
            <?php }?>
        </form>
        <div class="col s12 m3"></div>
    </div>
</div>
<!-- End Settings  -->

<div id="modal_confirmation" class="modal">
    <div class="modal-content">
        <h6 class="bold" style="margin-top: 0px;"><?php echo __( 'A confirmation email has been sent.' );?></h6>
        <br>
        <?php echo __( 'We have sent an email that contains the confirmation code to enable Two-factor authentication.' );?>
        <br><br>
        <input type="text" class="form-control" name="code" id="twofactor_confirmationcode" placeholder="<?php echo __( 'Confirmation code' );?>">
    </div>
    <div class="modal-footer">
        <button id="send_confirmation_btn" data-userid="<?php echo $profile->id;?>" class="waves-effect waves-light btn-flat btn_primary white-text"><?php echo __( 'Confirm' );?></button>
    </div>
</div>

<script>

    $(function () {
        $('#save_form').click(function(e){
            e.preventDefault();
            let formData = new FormData();
                if($('#phone_number').length > 0 ){
                    formData.append("phone_number", $('#phone_number').val());
                }
                if($('#new_email').length > 0 ){
                    formData.append("new_email", $('#new_email').val());
                }
                if( typeof $('#two_factor:checked').val() !== "undefined") {
                    formData.append("two_factor", $('#two_factor').val());
                }

            $.ajax({
                type: 'POST',
                url: window.ajax + 'profile/save_twofactor_setting',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 200) {
                        $('#twofactor_settings').find( '.alert-danger' ).html( '' ).hide();
                        $('#twofactor_settings').find( '.alert-success' ).html( data.message ).fadeIn( "fast" );
                        setTimeout(function() {
                            $('#twofactor_settings').find( '.alert-success' ).fadeOut( "fast" );
                        }, 3000);
                        if( typeof $('#two_factor:checked').val() !== "undefined") {
                            $('#modal_confirmation').modal('open');
                        }
                    } else {
                        console.log(data);
                        $('#twofactor_settings').find( '.alert-danger' ).html( '' ).hide();
                        $('#twofactor_settings').find( '.alert-success' ).html( data.message ).fadeIn( "fast" );
                        setTimeout(function() {
                            $('#twofactor_settings').find( '.alert-success' ).fadeOut( "fast" );
                        }, 3000);
                    }
                },
                error: function(data){
                    console.log(data.responseJSON);
                    $('#twofactor_settings').find( '.alert-success' ).html( '' ).hide();
                    $('#twofactor_settings').find( '.alert-danger' ).html( data.responseJSON.message ).fadeIn( "fast" );
                    setTimeout(function() {
                        $('#twofactor_settings').find( '.alert-danger' ).fadeOut( "fast" );
                    }, 3000);
                }
            });
        });
    });


    $(document).ready(function(){
        $('#send_confirmation_btn').click(function(e){
            e.preventDefault();
            let formData = new FormData();
                formData.append("twofactor_confirmationcode", $('#twofactor_confirmationcode').val());

            $.ajax({
                type: 'POST',
                url: window.ajax + 'profile/verify_twofactor_setting',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 200) {
                        $('#twofactor_settings').find( '.alert-danger' ).html( '' ).hide();
                        $('#twofactor_settings').find( '.alert-success' ).html( data.message ).fadeIn( "fast" );
                        setTimeout(function() {
                            $('#twofactor_settings').find( '.alert-success' ).fadeOut( "fast" );
                        }, 3000);
                        $('#modal_confirmation').modal('close');
                        location.reload();
                    } else {
                        $('#twofactor_settings').find( '.alert-danger' ).html( '' ).hide();
                        $('#twofactor_settings').find( '.alert-success' ).html( data.message ).fadeIn( "fast" );
                        setTimeout(function() {
                            $('#twofactor_settings').find( '.alert-success' ).fadeOut( "fast" );
                        }, 3000);
                    }
                }
            });
        });
    });

</script>

