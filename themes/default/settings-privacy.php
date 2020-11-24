<?php
$admin_mode = false;
if( $profile->admin == '1' || CheckPermission($profile->permission, "manage-users") ){
    $admin_mode = true;
}

$target_user = route(2);
if($target_user !== ''){
    $_user = LoadEndPointResource('users');
    if( $_user ){
        if( $target_user !== '' ){
            $user = $_user->get_user_profile(Secure($target_user));
            if( !$user ){
                echo '<script>window.location = window.site_url;</script>';
                exit();
            }else{
                if( $user->admin == '1' ){
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
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M21,11C21,16.55 17.16,21.74 12,23C6.84,21.74 3,16.55 3,11V5L12,1L21,5V11M12,21C15.75,20 19,15.54 19,11.22V6.3L12,3.18V21Z" /></svg>
        </div>
        <div class="sett_navbar valign-wrapper">
            <ul class="tabs">
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings/<?php echo $user->username;?>" data-ajax="/settings/<?php echo $user->username;?>" target="_self"><?php echo __( 'General' );?></a></li>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-profile/<?php echo $user->username;?>" data-ajax="/settings-profile/<?php echo $user->username;?>" target="_self"><?php echo __( 'Profile' );?></a></li>
                <li class="tab col s3"><a class="active" href="<?php echo $site_url;?>/settings-privacy/<?php echo $user->username;?>" data-ajax="/settings-privacy/<?php echo $user->username;?>" target="_self"><?php echo __( 'Privacy' );?></a></li>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-password/<?php echo $user->username;?>" data-ajax="/settings-password/<?php echo $user->username;?>" target="_self"><?php echo __( 'Password' );?></a></li>
                <?php if( $config->social_media_links == 'on' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-social/<?php echo $user->username;?>" data-ajax="/settings-social/<?php echo $user->username;?>" target="_self"><?php echo __( 'Social Links' );?></a></li><?php }?>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-blocked/<?php echo $user->username;?>" data-ajax="/settings-blocked/<?php echo $user->username;?>" target="_self"><?php echo __( 'Blocked Users' );?></a></li>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-sessions/<?php echo $user->username;?>" data-ajax="/settings-sessions/<?php echo $user->username;?>" target="_self"><?php echo __( 'Manage Sessions' );?></a></li>
                <?php if( $config->affiliate_system == '1' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-affiliate/<?php echo $user->username;?>" data-ajax="/settings-affiliate/<?php echo $user->username;?>" target="_self"><?php echo __( 'My affiliates' );?></a></li><?php } ?>
                <?php if( $config->two_factor == '1' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-twofactor/<?php echo $user->username;?>" data-ajax="/settings-twofactor/<?php echo $user->username;?>" target="_self"><?php echo __( 'Two-factor authentication' );?></a></li><?php } ?>
                <?php if( $config->emailNotification == '1' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-email/<?php echo $user->username;?>" data-ajax="/settings-email/<?php echo $user->username;?>" target="_self"><?php echo __( 'Manage Notifications' );?></a></li><?php } ?>
                <?php if( $admin_mode == false && $config->deleteAccount == '1' ) {?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-delete/<?php echo $user->username;?>" data-ajax="/settings-delete/<?php echo $user->username;?>" target="_self"><?php echo __( 'Delete Account' );?></a></li><?php } ?>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="dt_settings row">
        <div class="col s12 m3"></div>
        <form method="post" action="/profile/save_privacy_setting" class="col s12 m6">

            <div class="alert alert-success" role="alert" style="display:none;"></div>
			<div class="alert alert-danger" role="alert" style="display:none;"></div>

            <div class="row">
                <div class="input-field col s12 no_margin">
                    <p class="switch">
                        <label>
                            <?php echo __( 'Show my profile on Google' );?>
                            <input type="checkbox" name="privacy_show_profile_on_google" <?php echo ( ( $user->privacy_show_profile_on_google == 1 ) ? 'checked' : '' );?>>
                            <span class="lever"></span>
                        </label>
                    </p>
                </div>
                <div class="input-field col s12 no_margin">
                    <p class="switch">
                        <label>
                            <?php echo __( 'Show my profile in random users' );?>
                            <input type="checkbox" name="privacy_show_profile_random_users" <?php echo ( ( $user->privacy_show_profile_random_users == 1 ) ? 'checked' : '' );?>>
                            <span class="lever"></span>
                        </label>
                    </p>
                </div>
                <div class="input-field col s12 no_margin">
                    <p class="switch">
                        <label>
                            <?php echo __( 'Show my profile in match profiles' );?>
                            <input type="checkbox"  name="privacy_show_profile_match_profiles" <?php echo ( ( $user->privacy_show_profile_match_profiles == 1 ) ? 'checked' : '' );?>>
                            <span class="lever"></span>
                        </label>
                    </p>
                </div>
                <?php if($config->connectivitySystem == "1") { ?>
                <div class="input-field col s12 no_margin">
                    <p class="switch">
                        <label>
                            <?php echo __( 'Confirm request when someone request friend you ?' );?>
                            <input type="checkbox"  name="confirm_followers" <?php echo ( ( $user->confirm_followers == 1 ) ? 'checked' : '' );?>>
                            <span class="lever"></span>
                        </label>
                    </p>
                </div>
                <?php } ?>


            </div>
            <div class="dt_sett_footer valign-wrapper">
                <button class="btn btn-large waves-effect waves-light bold btn_primary btn_round" type="submit" name="action"><span><?php echo __( 'Save' );?></span> <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path></svg></button>
            </div>
            <?php if( $admin_mode == true ){?>
                <input type="hidden" name="targetuid" value="<?php echo strrev( str_replace( '==', '', base64_encode($user->id) ) );?>">
            <?php }?>
        </form>
        <div class="col s12 m3"></div>
    </div>
</div>
<!-- End Settings  -->
