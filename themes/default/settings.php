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
            $profile = $_user->get_user_profile(Secure($target_user));
            if( !$profile ){
                echo '<script>window.location = window.site_url;</script>';
                exit();
            }else{
                if( $profile->admin == '1' ){
                    $admin_mode = true;
                }
            }
        }
    }
}
?>
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
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,15.5A3.5,3.5 0 0,1 8.5,12A3.5,3.5 0 0,1 12,8.5A3.5,3.5 0 0,1 15.5,12A3.5,3.5 0 0,1 12,15.5M19.43,12.97C19.47,12.65 19.5,12.33 19.5,12C19.5,11.67 19.47,11.34 19.43,11L21.54,9.37C21.73,9.22 21.78,8.95 21.66,8.73L19.66,5.27C19.54,5.05 19.27,4.96 19.05,5.05L16.56,6.05C16.04,5.66 15.5,5.32 14.87,5.07L14.5,2.42C14.46,2.18 14.25,2 14,2H10C9.75,2 9.54,2.18 9.5,2.42L9.13,5.07C8.5,5.32 7.96,5.66 7.44,6.05L4.95,5.05C4.73,4.96 4.46,5.05 4.34,5.27L2.34,8.73C2.21,8.95 2.27,9.22 2.46,9.37L4.57,11C4.53,11.34 4.5,11.67 4.5,12C4.5,12.33 4.53,12.65 4.57,12.97L2.46,14.63C2.27,14.78 2.21,15.05 2.34,15.27L4.34,18.73C4.46,18.95 4.73,19.03 4.95,18.95L7.44,17.94C7.96,18.34 8.5,18.68 9.13,18.93L9.5,21.58C9.54,21.82 9.75,22 10,22H14C14.25,22 14.46,21.82 14.5,21.58L14.87,18.93C15.5,18.67 16.04,18.34 16.56,17.94L19.05,18.95C19.27,19.03 19.54,18.95 19.66,18.73L21.66,15.27C21.78,15.05 21.73,14.78 21.54,14.63L19.43,12.97Z" /></svg>
        </div>
        <div class="sett_navbar valign-wrapper">
            <ul class="tabs">
                <li class="tab col s3"><a class="active" href="<?php echo $site_url;?>/settings/<?php echo $profile->username;?>" data-ajax="/settings/<?php echo $profile->username;?>" target="_self"><?php echo __( 'General' );?></a></li>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-profile/<?php echo $profile->username;?>" data-ajax="/settings-profile/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Profile' );?></a></li>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-privacy/<?php echo $profile->username;?>" data-ajax="/settings-privacy/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Privacy' );?></a></li>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-password/<?php echo $profile->username;?>" data-ajax="/settings-password/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Password' );?></a></li>
                <?php if( $config->social_media_links == 'on' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-social/<?php echo $profile->username;?>" data-ajax="/settings-social/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Social Links' );?></a></li><?php }?>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-blocked/<?php echo $profile->username;?>" data-ajax="/settings-blocked/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Blocked Users' );?></a></li>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-sessions/<?php echo $profile->username;?>" data-ajax="/settings-sessions/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Manage Sessions' );?></a></li>
                <?php if( $config->affiliate_system == '1' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-affiliate/<?php echo $profile->username;?>" data-ajax="/settings-affiliate/<?php echo $profile->username;?>" target="_self"><?php echo __( 'My affiliates' );?></a></li><?php } ?>
                <?php if( $config->two_factor == '1' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-twofactor/<?php echo $profile->username;?>" data-ajax="/settings-twofactor/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Two-factor authentication' );?></a></li><?php } ?>
                <?php if( $config->emailNotification == '1' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-email/<?php echo $profile->username;?>" data-ajax="/settings-email/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Manage Notifications' );?></a></li><?php } ?>
                <?php if( $admin_mode == false && $config->deleteAccount == '1' ) {?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-delete/<?php echo $profile->username;?>" data-ajax="/settings-delete/<?php echo $profile->username;?>" target="_self"><?php echo __( 'Delete Account' );?></a></li><?php } ?>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="dt_settings row">
        <div class="col s12 m3"></div>
        <form method="POST" action="/profile/save_general_setting" class="col s12 m6">

            <div class="alert alert-success" role="alert" style="display:none;"></div>
			<div class="alert alert-danger" role="alert" style="display:none;"></div>

            <div class="row">
                <div class="input-field col s6 xs12">
                    <input id="first_name" name="first_name" type="text" maxlength="30" class="validate" value="<?php echo $profile->first_name;?>" autofocus>
                    <label for="first_name"><?php echo __( 'First Name' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <input id="last_name" name="last_name" type="text" maxlength="30" class="validate" value="<?php echo $profile->last_name;?>">
                    <label for="last_name"><?php echo __( 'Last Name' );?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <input id="username" name="username" type="text" class="validate" value="<?php echo $profile->username;?>">
                    <label for="username"><?php echo __( 'Username' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <input id="email" name="email" type="text" class="validate" value="<?php echo $profile->email;?>" readonly>
                    <label for="email"><?php echo __( 'Email' );?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <select id="country" name="country">
                        <option value="" disabled selected><?php echo __( 'Choose your country' );?></option>
                        <?php
                            foreach( Dataset::load('countries') as $key => $val ){
                                echo '<option value="'. $key .'" data-code="'. $val['isd'] .'"  '. ( ( $profile->country == $key ) ? 'selected' : '' ) .'>'. $val['name'] .'</option>';
                            }
                        ?>
                    </select>
                    <label for="country"><?php echo __( 'Country' );?></label>
                </div>
                <?php if( $config->disable_phone_field == 'on' ){ ?>
                <div class="input-field col s6 xs12">
                    <input id="mobile" type="tel" class="validate" name="phone_number" value="<?php echo $profile->phone_number;?>" title="Field must be a number."  >
                    <label for="mobile"><?php echo __( 'Mobile Number' );?></label>
                </div>
                <?php } ?>
            </div>
            <div class="row">
                <?php if(can_change_gender($profile->gender)){ ?>
                <div class="input-field col s6 xs12">
                    <select id="gender" name="gender">
                        <?php echo DatasetGetSelect( $profile->gender, "gender", "Choose your Gender" );?>
                    </select>
                    <label for="gender"><?php echo __( 'Gender' );?></label>
                </div>
                <?php } ?>
                <div class="input-field col s6 xs12">
                    <input id="birthday" name="birthday" type="text" value="<?php echo $profile->birthday;?>" class="datepicker user_bday">
                    <label for="birthday"><?php echo __( 'Birth date' );?></label>
                </div>
            </div>

            <?php
            $fields = GetProfileFields('general');
            $custom_data = UserFieldsData($profile->id);
            $template = $theme_path . 'partails' . $_DS . 'profile-fields.php';
            $html = '';
            if (count($fields) > 0) {
                foreach ($fields as $key => $field) {
                    ob_start();
                    require($template);
                    $html .= ob_get_contents();
                    ob_end_clean();
                }
                echo '<div class="row">' . $html . '</div>';
                echo '<input name="custom_fields" type="hidden" value="1">';
            }
            ?>
            <?php if( $admin_mode == true ){?>
            <div class="row">
                <?php //if( $profile->admin !== '1' ){?>
                <div class="input-field col s12 m6">
                    <div class="switch">
                        <label>
                            <?php echo __( 'User' );?>
                            <input type="hidden" name="admin" value="off" />
                            <input type="checkbox" name="admin" <?php echo ( ( $profile->admin == 1 ) ? 'checked' : '' );?> >
                            <span class="lever"></span>
                            <?php echo __( 'Admin' );?>
                        </label>
                    </div>
                </div>
                <?php //}?>

                <?php if( $config->pro_system == 1 ) {?>
                <div class="input-field col s12 m6">
                    <div class="switch">
                        <label>
                            <?php echo __( 'Free Member' );?>
                            <input type="checkbox" name="is_pro" <?php echo ( ( $profile->is_pro == 1 ) ? 'checked' : '' );?>>
                            <span class="lever"></span>
                            <?php echo __( 'Pro Member' );?>
                        </label>
                    </div>
                </div>
                <?php }?>

            </div>
            <?php }?>
            <br>
            <?php if( $admin_mode == true ){?>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input id="balance" type="number" class="validate" name="balance" value="<?php echo (int)$profile->balance;?>" pattern="\d*" title="Field must be a number." onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                        <label for="balance"><?php echo __( 'Credits' );?></label>
                    </div>
                </div>
            <?php }?>
            <br>
            <div class="dt_sett_footer valign-wrapper">
                <button class="btn btn-large waves-effect waves-light bold btn_primary btn_round" type="submit" name="action"><span><?php echo __( 'Save' );?></span> <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path></svg></button>
            </div>
            <?php if( $admin_mode == true ){?>
                <input type="hidden" name="targetuid" value="<?php echo strrev( str_replace( '==', '', base64_encode($profile->id) ) );?>">
            <?php }?>
        </form>
        <div class="col s12 m3"></div>
    </div>
</div>
<!-- End Settings  -->
<script>
    $(document).ready(function(){
        /***phone number format***/
        $(".phone-format").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
            var curchr = this.value.length;
            var curval = $(this).val();
            if (curchr == 3 && curval.indexOf("(") <= -1) {
                $(this).val("(" + curval + ")" + "-");
            } else if (curchr == 4 && curval.indexOf("(") > -1) {
                $(this).val(curval + ")-");
            } else if (curchr == 5 && curval.indexOf(")") > -1) {
                $(this).val(curval + "-");
            } else if (curchr == 9) {
                $(this).val(curval + "-");
                $(this).attr('maxlength', '14');
            }
        });
    });
</script>