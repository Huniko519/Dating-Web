<?php
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
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,6A3,3 0 0,0 9,9A3,3 0 0,0 12,12A3,3 0 0,0 15,9A3,3 0 0,0 12,6M6,8.17A2.5,2.5 0 0,0 3.5,10.67A2.5,2.5 0 0,0 6,13.17C6.88,13.17 7.65,12.71 8.09,12.03C7.42,11.18 7,10.15 7,9C7,8.8 7,8.6 7.04,8.4C6.72,8.25 6.37,8.17 6,8.17M18,8.17C17.63,8.17 17.28,8.25 16.96,8.4C17,8.6 17,8.8 17,9C17,10.15 16.58,11.18 15.91,12.03C16.35,12.71 17.12,13.17 18,13.17A2.5,2.5 0 0,0 20.5,10.67A2.5,2.5 0 0,0 18,8.17M12,14C10,14 6,15 6,17V19H18V17C18,15 14,14 12,14M4.67,14.97C3,15.26 1,16.04 1,17.33V19H4V17C4,16.22 4.29,15.53 4.67,14.97M19.33,14.97C19.71,15.53 20,16.22 20,17V19H23V17.33C23,16.04 21,15.26 19.33,14.97Z"></path></svg>
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
                <?php if( $config->affiliate_system == '1' ){ ?><li class="tab col s3"><a class="active" href="<?php echo $site_url;?>/settings-affiliate/<?php echo $profile->username;?>" data-ajax="/settings-affiliate/<?php echo $profile->username;?>" target="_self"><?php echo __( 'My affiliates' );?></a></li><?php } ?>
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
        <div class="col s12 m6">
			<div class="dt_usr_pmnt_cont">
			<div class="dt_usr_affl">
				<h2 class="valign-wrapper">
					<span><?php echo __('My balance');?>: <?php echo $config->currency_symbol;?><?php echo number_format($profile->aff_balance, 2);?></span>
				</h2>
			</div>
			<?php if( (float)$profile->aff_balance < (float)$config->m_withdrawal ){ ?>
            <div class="alert alert-info"><?php echo __('Your balance is');?> <?php echo $config->currency_symbol;?><?php echo number_format($profile->aff_balance, 2);?> <?php echo __(', minimum withdrawal request is');?>	<?php echo $config->currency_symbol;?><?php echo number_format($config->m_withdrawal, 2);?></div>
            <?php }?>
			<?php if( (float)$profile->aff_balance >= (float)$config->m_withdrawal ){ ?>
            <form method="post" action="/profile/request_payment">
                <div class="alert alert-success" role="alert" style="display:none;"></div>
                <div class="alert alert-danger" role="alert" style="display:none;"></div>
                <div class="row">
                    <div class="input-field col s6 xs12">
                        <input id="paypal_email" name="paypal_email" type="text" maxlength="30" class="validate valid" value="<?php echo $profile->paypal_email;?>" autofocus="">
                        <label for="paypal_email" class="active"><?php echo __('PayPal email');?></label>
                    </div>
                    <div class="input-field col s6 xs12">
                        <input id="amount" name="amount" type="text" maxlength="30" class="validate" value="0">
                        <label for="amount" class="active"><?php echo __('Amount');?></label>
                    </div>
                </div>
				<div class="dt_sett_footer valign-wrapper">
					<button class="btn btn-large waves-effect waves-light bold btn_primary btn_round" type="submit" name="action"><span><?php echo __( 'Request withdrawal' );?></span> <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path></svg></button>
				</div>
            </form>
            <?php }?>
			</div>
			<div class="dt_usr_pmnt_cont">
            <div class="dt_usr_pmnt_hstry">
                <h5><?php echo __('Payment history'); ?></h5>
                <div class="table-responsive">
                    <table class="table table-condensed dt_usr_pmnt_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo __('amount'); ?></th>
                            <th><?php echo __('requested'); ?></th>
                            <th><?php echo __('status'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $get_payment = Wo_GetPaymentsHistory($profile->id);
                        if (count($get_payment) > 0) {
                            foreach ($get_payment as $wo['key'] => $wo['payment']) {
                                $wo['key'] = ($wo['key'] + 1);
                                $wo['html_class'] = 'label-warning';
                                $wo['html_text'] = $wo['lang']['pending'];
                                if ($wo['payment']['status'] == '1') {
                                    $wo['html_class'] = 'label-success';
                                    $wo['html_text'] = __('approved');
                                } else if ($wo['payment']['status'] == '2') {
                                    $wo['html_class'] = 'label-danger';
                                    $wo['html_text'] = __('declined');
                                } else if ($wo['payment']['status'] == '0') {
                                    $wo['html_class'] = 'label-danger';
                                    $wo['html_text'] = __('pending review');
                                }
                                ?>
                                <tr>
                                    <td><?php echo $wo['key']?></td>
                                    <td><?php echo $config->currency_symbol . $wo['payment']['amount']?></td>
                                    <td><?php echo $wo['payment']['time_text']?></td>
                                    <td><span class="label label-status <?php echo $wo['html_class']?>"><?php echo $wo['html_text'];?></span></td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
			</div>
        </div>
        <div class="col s12 m3"></div>
    </div>
</div>
<!-- End Settings  -->