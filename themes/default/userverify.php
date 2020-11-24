<div class="container dt_user_profile_parent">
    <?php if( $profile->verified == 0 ){?>

        <div class="alert alert-warning" role="alert">
            <p><?php echo __( 'Please verify your email address' );?>, <a href="<?php echo $site_url;?>/verifymail" data-ajax="/verifymail"><?php echo __( 'Verify Now' );?></a>.</p>
        </div>

    <?php } ?>

    <?php if( !empty( $profile->phone_number ) && $profile->phone_verified == 0 ){?>

        <div class="alert alert-warning" role="alert">
            <p><?php echo __( 'Please verify your phone number' );?>,<a href="<?php echo $site_url;?>/verifyphone" data-ajax="/verifyphone"><?php echo __( 'Verify Now' );?></a>.</p>
        </div>

    <?php } ?>

    <div class="login">
        <a class="btn waves-effect waves-light logout" onclick="logout()" style="display: block;width: 120px;font-weight: bold;background-color: #a33596;"><span style="color:#ffffff;"><?php echo __( 'Log Out' );?></span></a>
    </div>
    <br>
</div>