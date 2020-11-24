<!-- About  -->
<style>
@media (max-width: 1024px){
.dt_slide_menu {
	display: none;
}
nav .header_user {
	display: block;
}
}
</style>
<div class="container dt_terms">
    <div class="row">
        <div class="col s12 m4 l3">
            <div class="dt_terms_sidebar">
                <ul>
                    <li class=""><a href="<?php echo $site_url;?>/terms" data-ajax="/terms"><?php echo __( 'Terms of use' );?></a></li>
                    <li class=""><a href="<?php echo $site_url;?>/privacy" data-ajax="/privacy"><?php echo __( 'Privacy Policy' );?></a></li>
                    <li class="active"><a href="<?php echo $site_url;?>/about" data-ajax="/about"><?php echo __( 'About us' );?></a></li>
                    <hr>
                    <li><a href="<?php echo $site_url;?>/contact" data-ajax="/contact"><?php echo __( 'Contact us' );?></a></li>
                </ul>
            </div>
        </div>
        <div class="col s12 m8 l9">
            <h2 class="bold"><?php echo __( 'About us' );?></h2>
            <div class="dt_terms_content_body">
                <?php echo $config->about; ?>
            </div>
        </div>
    </div>
</div>
<!-- End About  -->