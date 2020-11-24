    <!-- Header not-logged-in -->
    <nav role="navigation" id="nav-not-logged-in">
        <div class="nav-wrapper container">
            <div class="left header_logo">
                <a id="logo-container" href="<?php echo $site_url;?>/" class="brand-logo"><img src="<?php echo $config->sitelogo;?>" /></a>
            </div>
            <ul class="right">
                <li class="hide_mobi_login"><a href="<?php echo $site_url;?>/login" data-ajax="/login" class="btn-flat waves-effect text-main qdt_hdr_auth_btns"><?php echo __( 'Login' );?></a></li>
                <li class="hide_mobi_login"><a href="<?php echo $site_url;?>/register" data-ajax="/register" class="btn-flat btn btn_primary waves-effect waves-light white-text qdt_hdr_auth_btns"><?php echo __( 'Register' );?></a></li>
                <div class="show_mobi_login">
                    <a class="dropdown-trigger" href="#" data-target="log_in_dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="#222" d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z" /></svg></a>
                    <ul id="log_in_dropdown" class="dropdown-content">
                        <li><a href="<?php echo $site_url;?>/login" data-ajax="/login"><?php echo __( 'Login' );?></a></li>
                        <li><a href="<?php echo $site_url;?>/register" data-ajax="/register"><?php echo __( 'Register' );?></a></li>
                    </ul>
                </div>
            </ul>
        </div>
    </nav>
    <!-- End Header not-logged-in -->