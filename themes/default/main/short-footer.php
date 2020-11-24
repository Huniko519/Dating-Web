<div class="login_footer">
    <div class="dt_login_foot_innr grey-text text-darken-2">
        <ul class="dt_footer_links">
            <li><a href="<?php echo $site_url;?>/about" data-ajax="/about" class="grey-text text-darken-2"><?php echo __( 'About Us' );?></a></li>
            <li><a href="<?php echo $site_url;?>/terms" data-ajax="/terms" class="grey-text text-darken-2"><?php echo __( 'Terms' );?></a></li>
            <li><a href="<?php echo $site_url;?>/contact" data-ajax="/contact" class="grey-text text-darken-2"><?php echo __( 'Contact' );?></a></li>
            <li><a href="<?php echo $site_url;?>/privacy" data-ajax="/privacy" class="grey-text text-darken-2"><?php echo __( 'Privacy Policy' );?></a></li>
        </ul>
        <div class="valign-wrapper">
        <span><?php echo __( 'Copyright' );?> © <?php echo date( "Y" ) . " " . ucfirst( $config->site_name );?>. <?php echo __( 'All rights reserved' );?>.</span>
        <?php require( $theme_path . 'main' . $_DS . 'language.php' );?>
        </div>
    </div>
</div>