<div class="container page-margin find_matches_cont">
	<div class="row r_margin">
		<div class="col l3">
			<?php require( $theme_path . 'main' . $_DS . 'sidebar.php' );?>
		</div>
	
		<div class="col l9">
			<!-- Popularity  -->
			<div class="container-fluid">
				<div class="dt_sections dt_premium">
					<div class="dt_p_head center">
						<h2 class="light"><?php echo __('Your Popularity:');?> <b><?php echo GetUserPopularity($profile->id);?></b></h2>
						<p class="bold"><?php echo __('Increase your Popularity with Credits and enjoy the features.');?></p>
					</div>
					<div class="dt_pro_features dt_popular">
						<h2 class="center"><?php echo str_replace('{{sitename}}', $config->site_name, __('Meet more People with {{sitename}} Credits'));?></h2>
						<div class="row">
							<div class="col s12 m6 l4 center" id="buy_more_visits">
								<div class="dt_poplrity_cont visits">
									<div class="dt_pop_hdr">
										<h3><?php echo __('Increase');?> <?php echo __('visits');?></h3>
										<div class="dt_pop_icn">
											<span>
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12C22,10.84 21.79,9.69 21.39,8.61L19.79,10.21C19.93,10.8 20,11.4 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4C12.6,4 13.2,4.07 13.79,4.21L15.4,2.6C14.31,2.21 13.16,2 12,2M19,2L15,6V7.5L12.45,10.05C12.3,10 12.15,10 12,10A2,2 0 0,0 10,12A2,2 0 0,0 12,14A2,2 0 0,0 14,12C14,11.85 14,11.7 13.95,11.55L16.5,9H18L22,5H19V2M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12H16A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8V6Z" /></svg>
											</span>
										</div>
									</div>
									<div class="dt_pop_mdl">
										<h2>x10</h2>
										<p><?php echo __('visits');?></p>
									</div>
									<div class="dt_pop_ftr">
										<?php if( $profile->user_buy_xvisits == '1' ){
											$xvisits_duration = 0;
											if( $profile->xvisits_created_at > 0 ) {
												$xvisits_duration = ( time() - $profile->xvisits_created_at ) / 60;
											}else{
												$xvisits_duration = $config->xvisits_expire_time;
											}
											$xvisits_duration = $config->xvisits_expire_time - $xvisits_duration;
										?>
											<div class="boosted_message_expire" data-message-expire="<button data-target='buy_xvisits' class='btn modal-trigger'><?php echo __('Increase');?></button>"><?php echo __('Your x10 visits will expire in');?> <span class="boosted_time" data-boosted-time="<?php echo $xvisits_duration;?>"></span> <?php echo __( 'minutes');?></div>
										<?php }else{ ?>
											<button data-target="buy_xvisits" class="btn modal-trigger"><?php echo __('Increase');?></button>
										<?php } ?>
									</div>
								</div>
                            </div>
							<div class="col s12 m6 l4 center" id="buy_more_matches">
								<div class="dt_poplrity_cont matches">
									<div class="dt_pop_hdr">
										<h3><?php echo __('Increase');?> <?php echo __('matches');?></h3>
										<div class="dt_pop_icn">
											<span>
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,16L19.36,10.27L21,9L12,2L3,9L4.63,10.27M12,18.54L4.62,12.81L3,14.07L12,21.07L21,14.07L19.37,12.8L12,18.54Z" /></svg>
											</span>
										</div>
									</div>
									<div class="dt_pop_mdl">
										<h2>x3</h2>
										<p><?php echo __('matches');?></p>
									</div>
									<div class="dt_pop_ftr">
										<?php if( $profile->is_boosted == '1' ){
											$xmatches_duration = 0;
											if( $profile->boosted_time > 0 ) {
												$xmatches_duration = ( time() - $profile->boosted_time ) / 60;
											}else{
												$xmatches_duration = $config->boosted_time;
											}
											$xmatches_duration = $config->boost_expire_time - $xmatches_duration;
										?>
											<div class="boosted_message_expire" data-message-expire="<button data-target='buy_xmatches' class='btn modal-trigger'><?php echo __('Increase');?></button>"><?php echo __('Your x3 matches will expire in');?> <span class="boosted_time" data-boosted-time="<?php echo $xmatches_duration;?>"></span> <?php echo __( 'minutes');?></div>
										<?php }else{ ?>
											<button data-target="buy_xmatches" class="btn modal-trigger"><?php echo __('Increase');?></button>
										<?php } ?>
									</div>
								</div>
                            </div>
							<div class="col s12 m6 l4 center" id="buy_more_likes">
								<div class="dt_poplrity_cont likes">
									<div class="dt_pop_hdr">
										<h3><?php echo __('Increase');?> <?php echo __('likes');?></h3>
										<div class="dt_pop_icn">
											<span>
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" /></svg>
											</span>
										</div>
									</div>
									<div class="dt_pop_mdl">
										<h2>x4</h2>
										<p><?php echo __('likes');?></p>
									</div>
									<div class="dt_pop_ftr">
										<?php if( $profile->user_buy_xlikes == '1' ){
											$xlikes_duration = 0;
											if( $profile->xlikes_created_at > 0 ) {
												$xlikes_duration = ( time() - $profile->xlikes_created_at ) / 60;
											}else{
												$xlikes_duration = $config->xlike_expire_time;
											}
											$xlikes_duration = $config->xlike_expire_time - $xlikes_duration;
										?>
											<div class="boosted_message_expire" data-message-expire="<button data-target='buy_xlikes' class='btn modal-trigger'><?php echo __('Increase');?></button>"><?php echo __('Your x4 likes will expire in');?> <span class="boosted_time" data-boosted-time="<?php echo $xlikes_duration;?>"></span> <?php echo __( 'minutes');?></div>
										<?php }else{ ?>
											<button data-target="buy_xlikes" class="btn modal-trigger"><?php echo __('Increase');?></button>
										<?php } ?>
									</div>
								</div>
                            </div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Popularity  -->

			<!-- Buy XVisits Modal -->
			<div id="buy_xvisits" class="modal">
				<div class="modal-content">
					<h6 class="bold">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12C22,10.84 21.79,9.69 21.39,8.61L19.79,10.21C19.93,10.8 20,11.4 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4C12.6,4 13.2,4.07 13.79,4.21L15.4,2.6C14.31,2.21 13.16,2 12,2M19,2L15,6V7.5L12.45,10.05C12.3,10 12.15,10 12,10A2,2 0 0,0 10,12A2,2 0 0,0 12,14A2,2 0 0,0 14,12C14,11.85 14,11.7 13.95,11.55L16.5,9H18L22,5H19V2M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12H16A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8V6Z" /></svg> <?php echo __('x10 Visits');?>
					</h6>

                    <?php
                    $___cost = (int)$config->cost_per_xvisits;
                    if( isGenderFree($profile->gender) === true ){
                        $___cost = 0;
                    }
                    ?>
					<p><?php echo __("Promote your profile by get more visits") . ', '. __("this service will cost you") . ' ' . ' <span style="color:#a33596;font-weight: bold;">' . $___cost . '</span> ' . __( 'Credits') . ' ' . __('For') . ' ' . ' <span style="color:#a33596;font-weight: bold;">' . (int)$config->xvisits_expire_time . '</span> '. ' ' . __('Minutes');?></p>
					<div class="modal-footer">
						<button type="button" class="btn-flat waves-effect modal-close"><?php echo __( 'Cancel' );?></button>
						<?php if((int)$profile->balance >= $___cost ){?>
							<button data-userid="<?php echo $profile->id;?>" id="btn_buymore_xvisits" class="modal-close waves-effect waves-light btn-flat btn_primary white-text"><?php echo __( 'Buy Now' );?></button>
						<?php }else{ ?>
							<a href="<?php echo $site_url;?>/credit" data-ajax="/credit" class="modal-close waves-effect waves-light btn-flat btn_primary white-text"><?php echo __( 'Buy Credits' );?></a>
						<?php } ?>
					</div>
				</div>
			</div>
			<!-- End Buy XVisits Modal -->

			<!-- Buy XMatches Modal -->
			<div id="buy_xmatches" class="modal">
				<div class="modal-content">
					<h6 class="bold">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,16L19.36,10.27L21,9L12,2L3,9L4.63,10.27M12,18.54L4.62,12.81L3,14.07L12,21.07L21,14.07L19.37,12.8L12,18.54Z" /></svg> <?php echo __('x3 Matches');?>
					</h6>
					<?php
						$__cost = 0;
						if( $profile->is_pro == "1" ){
							$__cost = $config->pro_boost_me_credits_price;
						}else{
							$__cost = $config->normal_boost_me_credits_price;
						}
                        if( isGenderFree($profile->gender) === true ){
                            $__cost = 0;
                        }
					?>
					<p><?php echo __("Shown more and rise up at the same time") . ', '. __("this service will cost you") . ' ' . ' <span style="color:#a33596;font-weight: bold;">' . (int)$__cost . '</span> ' . __( 'Credits') . ' ' . __('For') . ' ' . ' <span style="color:#a33596;font-weight: bold;">' . (int)$config->boost_expire_time . '</span> '. ' ' . __('Minutes');?></p>
					<div class="modal-footer">
						<button type="button" class="btn-flat waves-effect modal-close"><?php echo __( 'Cancel' );?></button>
						<?php if((int)$profile->balance >= (int)$__cost ){?>
							<button data-userid="<?php echo $profile->id;?>" id="btn_boostme" class="modal-close waves-effect waves-light btn-flat btn_primary white-text"><?php echo __( 'Buy Now' );?></button>
						<?php }else{ ?>
							<a href="<?php echo $site_url;?>/credit" data-ajax="/credit" class="modal-close waves-effect waves-light btn-flat btn_primary white-text"><?php echo __( 'Buy Credits' );?></a>
						<?php } ?>
					</div>
				</div>
			</div>
			<!-- End Buy XMatches Modal -->

			<!-- Buy Xlikes Modal -->
			<div id="buy_xlikes" class="modal">
				<div class="modal-content">
					<h6 class="bold">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" /></svg> <?php echo __('x4 Likes');?>
					</h6>

                    <?php
                    $___cost__ = (int)$config->cost_per_xlike;
                    if( isGenderFree($profile->gender) === true ){
                        $___cost__ = 0;
                    }
                    ?>

					<p><?php echo __("Tell everyone you're online and be seen by users who want to chat") . ', '. __("this service will cost you") . ' ' . ' <span style="color:#a33596;font-weight: bold;">' . $___cost__ . '</span> ' . __( 'Credits') . ' ' . __('For') . ' ' . ' <span style="color:#a33596;font-weight: bold;">' . (int)$config->xlike_expire_time . '</span> '. ' ' . __('Minutes');?></p>
					<div class="modal-footer">
						<button type="button" class="btn-flat waves-effect modal-close"><?php echo __( 'Cancel' );?></button>
						<?php if((int)$profile->balance >= $___cost__ ){?>
							<button data-userid="<?php echo $profile->id;?>" id="btn_buymore_xlikes" class="modal-close waves-effect waves-light btn-flat btn_primary white-text"><?php echo __( 'Buy Now' );?></button>
						<?php }else{ ?>
							<a href="<?php echo $site_url;?>/credit" data-ajax="/credit" class="modal-close waves-effect waves-light btn-flat btn_primary white-text"><?php echo __( 'Buy Credits' );?></a>
						<?php } ?>
					</div>
				</div>
			</div>
			<!-- End Buy XMatches Modal -->
		</div>
	</div>
</div>