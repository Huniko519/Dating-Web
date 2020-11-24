<!-- Footer  -->
    <?php if ($data['name'] !== 'login' && $data['name'] !== 'contact' && $data['name'] !== 'register' && $data['name'] !== 'forgot' && $data['name'] !== 'reset' && $data['name'] !== 'verifymail') { ?>
    <div class="container " style="transform: none;"><?php echo GetAd('footer');?></div>
<?php } ?>
    <footer id="footer" class="page_footer">
        <div class="footer-copyright">
            <div class="container valign-wrapper">
                <span><?php echo __( 'Copyright' );?> © <?php echo date( "Y" ) . " " . ucfirst( $config->site_name );?>. <?php echo __( 'All rights reserved' );?>.</span>
				<span class="dt_fotr_spn">
				<ul class="dt_footer_links">
                    <li><a href="<?php echo $site_url;?>/blog" data-ajax="/blog"><?php echo __( 'Blog' );?></a></li>
                    &nbsp;-&nbsp;<li><a href="<?php echo $site_url;?>/stories" data-ajax="/stories"><?php echo __( 'Success stories' );?></a></li>
					&nbsp;-&nbsp;<li><a href="<?php echo $site_url;?>/about" data-ajax="/about"><?php echo __( 'About Us' );?></a></li>
					&nbsp;-&nbsp;<li><a href="<?php echo $site_url;?>/terms" data-ajax="/terms"><?php echo __( 'Terms' );?></a></li>
                    &nbsp;-&nbsp;<li><a href="<?php echo $site_url;?>/privacy" data-ajax="/privacy"><?php echo __( 'Privacy Policy' );?></a></li>
					&nbsp;-&nbsp;<li><a href="<?php echo $site_url;?>/contact" data-ajax="/contact"><?php echo __( 'Contact' );?></a></li>
				</ul>
                <?php require( $theme_path . 'main' . $_DS . 'custom-page.php' );?>
                <?php require( $theme_path . 'main' . $_DS . 'language.php' );?>
				</span>
            </div>
        </div>
    </footer>
<!-- End Footer  -->