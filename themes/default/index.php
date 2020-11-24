
		<!-- Top Hero  -->
		<div class="parallax-container header_bg parallax_bg">
			<div class="section">
				<div class="container">
					<h1 class="header center"><?php echo __( 'Meet new and interesting people.' );?></h1>
					<div class="row center">
						<h5 class="header col s12 light"><?php echo __( 'Join' );?> <?php echo ucfirst( $config->site_name );?>, <?php echo __( 'where you could meet anyone, anywhere!' );?></h5>
					</div>
					<div class="row center">
						<a href="<?php echo $site_url;?>/register" class="btn-large waves-effect waves-light btn_primary lighten-1 bold btn_round"><?php echo __( 'Get Started' );?></a>&nbsp;&nbsp;&nbsp;
						<a href="#how_it_work" class="smooth btn-large btn-flat bold"><?php echo __( 'Know More' );?></a>
					</div>
				</div>
			</div>
			<div class="parallax"><img src="<?php echo $theme_url;?>assets/img/dating.jpg" alt="<?php echo ucfirst( $config->site_name );?>"></div>
		</div>
		<!-- End Top Hero  -->

        <!-- Filters  -->
		<div class="container">
			<div class="section dt_filters bg_gradient">
				<div class="row">
					<div class="input-field col s2">
						<select>
						<?php
							$all_gender = array();
							$gender = Dataset::load('gender');
							$iz = 0;
							if (isset($gender) && !empty($gender)) {
								foreach ($gender as $key => $val) {
									$_checked = '';
									if($iz === 1){
										$_checked = 'selected';
									}
									echo '<option value="' . $key . '" '.$_checked.'>' . $val . '</option>';
									$iz++;
								}
							}							
						?>
						</select>
						<label class="bold"><?php echo __( 'I am a' );?>:</label>
					</div>
					<div class="input-field col s2">
						<select>
						<?php
							$all_gender = array();
							$gender = Dataset::load('gender');
							$ix = 0;
							if (isset($gender) && !empty($gender)) {
								foreach ($gender as $key => $val) {
									$_checked = '';
									if($ix === 0){
										$_checked = 'selected';
									}
									echo '<option value="' . $key . '" '.$_checked.'>' . $val . '</option>';
									$ix++;
								}
							}							
						?>
						</select>
						<label class="bold"><?php echo __( 'I\'m looking for a' );?>:</label>
					</div>
					<div class="input-field col s2">
						<select>
						<?php for($i = 18 ; $i < 51 ; $i++ ){?>
							<option value="<?php echo $i;?>" <?php if( $i == 20){ echo 'selected';}?> ><?php echo $i;?></option>
						<?php }?>
						</select>
						<label class="bold"><?php echo __( 'Between ages' );?></label>
					</div>
					<div class="input-field col s2">
						<select>
						<?php for($i = 51 ; $i < 99 ; $i++ ){?>
							<option value="<?php echo $i;?>" <?php if( $i == 55){ echo 'selected';}?>><?php echo $i;?></option>
						<?php }?>
						</select>
						<label class="bold"><?php echo __( 'and' );?></label>
					</div>
					<div class="col">
						<a href="<?php echo $site_url;?>/login" class="waves-effect waves-light btn-flat btn-large bold btn_glossy"><?php echo __( 'Let\'s Begin' );?></a>
					</div>
				</div>
			</div>
		</div>
		<!-- End Filters  -->

        <!-- How it Works  -->
		<div class="container">
			<div class="section dt_how_work" id="how_it_work">
				<div class="row">
					<div class="col s12">
						<div class="dt_heading_top_line"></div>
						<h3 class="center-align"><?php echo __( 'How' );?> <?php echo ucfirst( $config->site_name );?> <?php echo __( 'Works' );?> </h3>
					</div>
					<div class="col s12 m4">
						<div class="icon-block center">
							<h2 class="valign-wrapper"><img src="<?php echo $theme_url;?>assets/img/how/create.svg" alt="<?php echo __( 'Create Account' );?>"></h2>
							<h5 class="bold"><?php echo __( 'Create Account' );?><div class="bg_number">1</div></h5>
							<p><?php echo __( 'Register for free & create up your good looking Profile.' );?></p>
						</div>
					</div>
					<div class="col s12 m4">
						<div class="icon-block center">
							<h2 class="valign-wrapper"><img src="<?php echo $theme_url;?>assets/img/how/match.svg" alt="<?php echo __( 'Find Matches' );?>"></h2>
							<h5 class="bold"><?php echo __( 'Find Matches' );?><div class="bg_number">2</div></h5>
							<p><?php echo __( 'Search & Connect with Matches which are perfect for you.' );?></p>
						</div>
					</div>
					<div class="col s12 m4">
						<div class="icon-block center">
							<h2 class="valign-wrapper"><img src="<?php echo $theme_url;?>assets/img/how/dating.svg" alt="<?php echo __( 'Start Dating' );?>"></h2>
							<h5 class="bold"><?php echo __( 'Start Dating' );?><div class="bg_number">3</div></h5>
							<p><?php echo __( 'Start doing conversations and date your best match.' );?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End How it Works  -->

        <?php if( $config->show_user_on_homepage == '1'){
            $siteUsers = GetSiteUsers();
            if( !empty($siteUsers) ){
            ?>
            <!-- Latest users  -->
            <div class="container-fluid bg_gradient">
                <div class="container">
                    <div class="section">
                        <div class="row">
                            <div class="col s12 center-align dt_get_start">
                                <h4 class="white-text light"><?php echo str_replace('{0}', ucfirst( $config->site_name ) , __( 'Latest {0} users.' ) );?></h4>
                                <div class="center">
                                    <?php
                                    foreach ($siteUsers as $key => $user){ ?>
                                        <a href="<?php echo $site_url;?>/@<?php echo $user->username;?>" data-ajax="/@<?php echo $user->username;?>">
                                            <img src="<?php echo $user->avater->avater;?>" alt="<?php echo $user->full_name;?>" class="circle xuser">
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Latest users  -->
        <?php }} ?>


        <?php
        $stories = GetStories();
        if( !empty($stories) ){
        ?>
		<!-- Testimonials  -->
		<div class="parallax-container valign-wrapper parallax_bg">
			<div class="section">
				<div class="container">
					<div class="row dt_tstm_usr">
						<div class="col s12 dt_test_title">
							<div class="dt_heading_top_line"></div>
							<h3 class="center-align"><?php echo __( 'Success Stories' );?></h3>
						</div>
						<div class="carousel carousel-slider">
                            <?php foreach ($stories as $key => $story){ ?>
                                <div class="carousel-item valign-wrapper" href="#one!">
                                    <div class="dt_testimonial_slide">
                                        <div class="slide_head">
                                            <img src="<?php echo $story['user1Data']->avater->avater;?>" alt="<?php echo $story['user1Data']->full_name;?>" class="circle" />
                                            <img src="<?php echo $story['user2Data']->avater->avater;?>" alt="<?php echo $story['user2Data']->full_name;?>" class="circle story2" />
                                            <h5><?php echo $story['quote'];?></h5>
                                        </div>
                                        <p><?php echo substr( strip_tags (br2nl( html_entity_decode( $story['description'] )) ) , 0 , 250);?>...</p>
                                    </div>
                                </div>
                            <?php } ?>
  						</div>
					</div>
				</div>
			</div>
			<div class="parallax"><img src="<?php echo $theme_url;?>assets/img/testimonial_bg.jpg" alt="Testimonials Background"></div>
		</div>
		<!-- End Testimonials  -->
        <?php } ?>

        <!-- Features  -->
		<div class="container">
			<div class="section dt_features">
				<div class="row">
					<div class="col s12">
						<div class="dt_heading_top_line"></div>
						<h3 class="center-align"><?php echo str_replace('{0}', ucfirst( $config->site_name ) ,__( 'Why {0} is Best' ) );?></h3>
					</div>
					<div class="col s12 m4 feature_block_first">
						<div class="icon-block center">
							<h2 class="valign-wrapper"><span class="icon_wrapper"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12,10L8,4.4L9.6,2H14.4L16,4.4L12,10M15.5,6.8L14.3,8.5C16.5,9.4 18,11.5 18,14A6,6 0 0,1 12,20A6,6 0 0,1 6,14C6,11.5 7.5,9.4 9.7,8.5L8.5,6.8C5.8,8.1 4,10.8 4,14A8,8 0 0,0 12,22A8,8 0 0,0 20,14C20,10.8 18.2,8.1 15.5,6.8Z" /></svg></span></h2>
							<h5 class="bold"><?php echo __( 'Best Match' );?></h5>
							<p><?php echo __( 'Based on your location, we find best and suitable matches for you.' );?></p>
						</div>
					</div>
					<div class="col s12 m4 feature_block_second">
						<div class="icon-block center">
							<h2 class="valign-wrapper"><span class="icon_wrapper"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M12,5A3,3 0 0,1 15,8A3,3 0 0,1 12,11A3,3 0 0,1 9,8A3,3 0 0,1 12,5M17.13,17C15.92,18.85 14.11,20.24 12,20.92C9.89,20.24 8.08,18.85 6.87,17C6.53,16.5 6.24,16 6,15.47C6,13.82 8.71,12.47 12,12.47C15.29,12.47 18,13.79 18,15.47C17.76,16 17.47,16.5 17.13,17Z" /></svg></span></h2>
							<h5 class="bold"><?php echo __( 'Fully Secure' );?></h5>
							<p><?php echo str_replace('{0}', ucfirst( $config->site_name ) , __( 'Your account is Safe on {0}. We never share your data with third party.' ) );?></p>
						</div>
					</div>
					<div class="col s12 m4 feature_block_third">
						<div class="icon-block center">
							<h2 class="valign-wrapper"><span class="icon_wrapper"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" /></svg></span></h2>
							<h5 class="bold"><?php echo __( '100% Privacy' );?></h5>
							<p><?php echo __( 'You have full control over your personal information that you share.' );?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Features  -->

        		<!-- Get Started  -->
		<div class="container-fluid bg_gradient">
			<div class="container">
				<div class="section">
					<div class="row">
						<div class="col s12 center-align dt_get_start">
							<h4 class="white-text light"><?php echo str_replace('{0}', ucfirst( $config->site_name ) , __( 'Connect with your perfect Soulmate here, on {0}.' ) );?></h4>
							<a href="<?php echo $site_url;?>/register" class="waves-effect waves-light btn-flat btn-large bold btn_glossy"><?php echo __( 'Get Started' );?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Get Started  -->