    <?php if(IS_LOGGED == true){ ?>
        <?php if($config->credit_earn_system == 1){?>
        <div class="payment_modal modal" id="reward_daily_credit_modal">
            <div class="modal-dialog">
                <div class="modal-content dt_bank_trans_modal">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo __( 'Credit Reward' );?></h5>
                    </div>
                    <div class="modal-body  credit_pln">
                        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"></circle><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path></svg>
                        <p><?php echo __( 'Congratulation!. you login to our site for' );?> <?php echo (int)$config->credit_earn_max_days;?> <?php echo __( 'days' );?>, <?php echo __( 'and you earn' );?> <?php echo (int)$config->credit_earn_max_days * (int)$config->credit_earn_day_amount;?> <?php echo __( 'credits' );?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php if($config->isDailyCredit){ ?>
            <script>
                $(document).ready(function() {
                    $('#reward_daily_credit_modal').modal({
                        onCloseEnd: function(){
                            window.location.href = window.site_url+'/credit';
                        }
                    }).modal("open");

                });
            </script>
        <?php }} ?>
        <div class="payment_modalx modal">
            <div class="modal-dialog">
                <div class="modal-content dt_bank_trans_modal">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo __( 'Unlock Private Photo Payment' );?></h5>
                    </div>
                    <div class="modal-body  credit_pln">
                        <br>
                        <h6><?php echo __( 'To unlock private photo feature in your account, you have to pay' );?> <?php echo $config->currency_symbol . (int)$config->lock_private_photo_fee;?>.</h6>

                        <p class="bold"><?php echo __( 'Pay Using' );?></p>
                        <div class="pay_using">
                            <div class="pay_u_btns valign-wrapper">
                            <?php if(!empty($config->paypal_id)){?>
                            <button id="unlock_photo_private_paypal" onclick="clickAndDisable(this);" class="btn paypal valign-wrapper">
                                <span><?php echo __( 'PayPal' );?></span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M8.32,21.97C8.21,21.92 8.08,21.76 8.06,21.65C8.03,21.5 8,21.76 8.66,17.56C9.26,13.76 9.25,13.82 9.33,13.71C9.46,13.54 9.44,13.54 10.94,13.53C12.26,13.5 12.54,13.5 13.13,13.41C16.38,12.96 18.39,11.05 19.09,7.75C19.13,7.53 19.17,7.34 19.18,7.34C19.18,7.33 19.25,7.38 19.33,7.44C20.36,8.22 20.71,9.66 20.32,11.58C19.86,13.87 18.64,15.39 16.74,16.04C15.93,16.32 15.25,16.43 14.05,16.46C13.25,16.5 13.23,16.5 13,16.65C12.83,16.82 12.84,16.79 12.45,19.2C12.18,20.9 12.08,21.45 12.04,21.55C11.97,21.71 11.83,21.85 11.67,21.93L11.56,22H10C8.71,22 8.38,22 8.32,21.97V21.97M3.82,19.74C3.63,19.64 3.5,19.47 3.5,19.27C3.5,19 6.11,2.68 6.18,2.5C6.27,2.32 6.5,2.13 6.68,2.06L6.83,2H10.36C14.27,2 14.12,2 15,2.2C17.62,2.75 18.82,4.5 18.37,7.13C17.87,10.06 16.39,11.8 13.87,12.43C13,12.64 12.39,12.7 10.73,12.7C9.42,12.7 9.32,12.71 9.06,12.85C8.8,13 8.59,13.27 8.5,13.6C8.46,13.67 8.23,15.07 7.97,16.7C7.71,18.33 7.5,19.69 7.5,19.72L7.47,19.78H5.69C4.11,19.78 3.89,19.78 3.82,19.74V19.74Z" /></svg>
                                <svg class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="spinner__path" fill="none" stroke-width="7" stroke-linecap="round" cx="33" cy="33" r="29"></circle></svg>
                            </button>
                            <?php } ?>
                            <?php if(!empty($config->stripe_secret)){?>
                            <button id="unlock_photo_private_stripe" class="btn stripe valign-wrapper"><?php echo __( 'Card' );?> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M20,8H4V6H20M20,18H4V12H20M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z" /></svg></button>
                            <?php } ?>
                            <?php if(!empty($config->paysera_password)){?>
                                <button id="unlock_photo_private_sms_payment" onclick="unlock_photo_private_pay_via_sms();" class="btn valign-wrapper sms"><?php echo __( 'SMS' );?> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17,19V5H7V19H17M17,1A2,2 0 0,1 19,3V21A2,2 0 0,1 17,23H7C5.89,23 5,22.1 5,21V3C5,1.89 5.89,1 7,1H17M9,7H15V9H9V7M9,11H13V13H9V11Z"></path></svg></button>
                            <?php } ?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function unlock_photo_private_pay_via_sms() {
                window.location = window.ajax + 'sms/generate_unlock_private_photo_link';
            }
            document.getElementById('unlock_photo_private_paypal').addEventListener('click', function(e) {
                $.post(window.ajax + 'paypal/generate_link', {description:'<?php echo __( "Unlock Private photo feature");?>', amount:<?php echo (int)$config->lock_private_photo_fee;?>, mode: "unlock_private_photo"}, function (data) {
                    if (data.status == 200) {
                        window.location.href = data.location;
                    } else {
                        $('.modal-body').html('<i class="fa fa-spin fa-spinner"></i> <?php echo __( 'Payment declined' );?> ');
                    }
                });

                e.preventDefault();
            });
            document.getElementById('unlock_photo_private_stripe').addEventListener('click', function(e) {
                $('#unlock_photo_private_stripe_email').val(atob($('#unlock_photo_private_stripe_email').attr('data-email')));
                $('#unlock_photo_private_stripe_number').val('');
                $('#unlock_photo_private_stripe_cvc').val('');
                $('#unlock_photo_private_stripe_modal').removeClass('up_rec_img_ready, up_rec_active');
                $('#unlock_photo_private_stripe_modal').modal('open');
            });


            function lock_pro_video_pay_via_sms() {
                window.location = window.ajax + 'sms/generate_lock_pro_video_link';
            }
            document.getElementById('lock_pro_video_paypal').addEventListener('click', function(e) {
                $.post(window.ajax + 'paypal/generate_link', {description:'<?php echo __( "Unlock Upload video feature");?>', amount:<?php echo (int)$config->lock_pro_video_fee;?>, mode: "lock_pro_video"}, function (data) {
                    if (data.status == 200) {
                        window.location.href = data.location;
                    } else {
                        $('.modal-body').html('<i class="fa fa-spin fa-spinner"></i> <?php echo __( 'Payment declined' );?> ');
                    }
                });

                e.preventDefault();
            });
            document.getElementById('lock_pro_video_stripe').addEventListener('click', function(e) {
                $('#lock_pro_video_stripe_email').val(atob($('#lock_pro_video_stripe_email').attr('data-email')));
                $('#lock_pro_video_stripe_number').val('');
                $('#lock_pro_video_stripe_cvc').val('');
                $('#lock_pro_video_stripe_modal').removeClass('up_rec_img_ready, up_rec_active');
                $('#lock_pro_video_stripe_modal').modal('open');
            });

        </script>

        <div class="modal fade" id="lock_pro_video_stripe_modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content add_money_modal add_address_modal">
                    <h5 class="modal-title text-center">Stripe</h5>
                    <div class="modal-body">
                        <div id="lock_pro_video_stripe_alert" style="    color: red;"></div>
                        <form id="stripe_form" method="post">
                            <div class="form-group">
                                <input class="form-control shop_input" type="text" placeholder="<?php echo __( 'Name' );?>"  value="<?php echo $profile->full_name;?>" id="lock_pro_video_stripe_name">
                            </div>
                            <div class="form-group">
                                <input class="form-control shop_input" type="email" placeholder="<?php echo __( 'Email' );?>" value="" data-email="<?php echo base64_encode($profile->email);?>" id="lock_pro_video_stripe_email">
                            </div>
                            <div class="form-group">
                                <input id="lock_pro_video_stripe_number" class="form-control shop_input" type="text" placeholder="<?php echo __( 'Card Number' );?>">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="lock_pro_video_stripe_month" type="text" class="form-control shop_input" autocomplete="off" placeholder="<?php echo __( 'Month' );?> (01)">
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="lock_pro_video_stripe_year" type="text" class="form-control shop_input" autocomplete="off" placeholder="<?php echo __( 'Year' );?> (2019)">
                                            <?php for ($i=date('Y'); $i <= date('Y')+15; $i++) {  ?>
                                                <option value="<?php echo($i) ?>"><?php echo($i) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input id="lock_pro_video_stripe_cvc" type="text" class="form-control shop_input" autocomplete="off" placeholder="CVC" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-main" onclick="SH_lock_pro_video_StripeRequest()" id="lock_pro_video_stripe_button"><?php echo __( 'Pay' );?></button>
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?php echo __( 'Cancel' );?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="unlock_photo_private_stripe_modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content add_money_modal add_address_modal">
                    <h5 class="modal-title text-center">Stripe</h5>
                    <div class="modal-body">
                        <div id="unlock_photo_private_stripe_alert" style="    color: red;"></div>
                        <form id="stripe_form" method="post">
                            <div class="form-group">
                                <input class="form-control shop_input" type="text" placeholder="<?php echo __( 'Name' );?>"  value="<?php echo $profile->full_name;?>" id="unlock_photo_private_stripe_name">
                            </div>
                            <div class="form-group">
                                <input class="form-control shop_input" type="email" placeholder="<?php echo __( 'Email' );?>" value="" data-email="<?php echo base64_encode($profile->email);?>" id="unlock_photo_private_stripe_email">
                            </div>
                            <div class="form-group">
                                <input id="unlock_photo_private_stripe_number" class="form-control shop_input" type="text" placeholder="<?php echo __( 'Card Number' );?>">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="unlock_photo_private_stripe_month" type="text" class="form-control shop_input" autocomplete="off" placeholder="<?php echo __( 'Month' );?> (01)">
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="unlock_photo_private_stripe_year" type="text" class="form-control shop_input" autocomplete="off" placeholder="<?php echo __( 'Year' );?> (2019)">
                                            <?php for ($i=date('Y'); $i <= date('Y')+15; $i++) {  ?>
                                                <option value="<?php echo($i) ?>"><?php echo($i) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input id="unlock_photo_private_stripe_cvc" type="text" class="form-control shop_input" autocomplete="off" placeholder="CVC" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-main" onclick="SH_unlock_photo_private_StripeRequest()" id="unlock_photo_private_stripe_button"><?php echo __( 'Pay' );?></button>
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?php echo __( 'Cancel' );?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Boost Modal -->
		<div id="modal_boost" class="modal modal-sm">
			<div class="modal-content">
				<?php
					$_cost = 0;
					if( $profile->is_pro == "1" ){
						$_cost = $config->pro_boost_me_credits_price;
					}else{
						$_cost = $config->normal_boost_me_credits_price;
					}
                    if ( isGenderFree($profile->gender) === true ) {
                        $_cost = 0;
                    }
				?>
				<h6 class="bold"><?php echo __('Boost me!');?></h6>
				<p><?php echo __('Get seen more by people around you in find match.');?></p>
				<p><?php
                    if ( isGenderFree($profile->gender) === true ) {
                        echo __('Boost your profile for free for') . ' ' . $config->boost_expire_time . ' ' . __('miuntes') . '.';
                    }else {
                        echo __('This service costs you') . ' ' . $_cost . ' ' . __('credits and will last for') . ' ' . $config->boost_expire_time . ' ' . __('miuntes') . '.';
                    }
                    ?></p>
				<div class="modal-footer">
					<button type="button" class="btn-flat waves-effect modal-close"><?php echo __( 'Cancel' );?></button>
					<?php if($profile->balance >= $_cost ){?>
						<button data-userid="<?php echo $profile->id;?>" id="btn_boostme" class="modal-close waves-effect waves-light btn-flat btn_primary white-text"><?php
                            if ( isGenderFree($profile->gender) === true ) {
                                echo __( 'Boost For Free' );
                            }else{
                                echo __( 'Boost Now' );
                            }


                            ?></button>
					<?php }else{ ?>
						<a href="<?php echo $site_url;?>/credit" data-ajax="/credit" class="modal-close waves-effect waves-light btn-flat btn_primary white-text"><?php echo __( 'Buy Credits' );?></a>
					<?php } ?>
				</div>
			</div>
		</div>
		<!-- End Boost Modal -->
		
		<div class="sidenav_overlay" onclick="javascript:$('body').removeClass('side_open');"></div>
	<?php } ?>
		
	<!-- Scroll to top  -->
    <a href="javascript:void(0);" class="btn-floating btn-large waves-effect waves-light dt_to_top bg_gradient"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M7.41,15.41L12,10.83L16.59,15.41L18,14L12,8L6,14L7.41,15.41Z"></path></svg></a>
    <!-- End Scroll to top  -->

	<?php require( $theme_path . 'main' . $_DS . 'geolocation.php' );?>
    <?php require( $theme_path . 'main' . $_DS . 'custom-footer-js.php' );?>
    <?php //write_console();?>
	
	<script type="text/javascript">
		$(document).on('click', '.find_matches_cont > .row > .col.l3 .dt_sections [data-ajax]', function() {
			$('body').removeClass('side_open');
		});
		</script>

    <?php if( IS_LOGGED == true ){ ?>
        <div style="display:none">
            <audio id="notification-sound" class="sound-controls" preload="auto" style="visibility: hidden;">
                <source src="<?php echo $theme_url; ?>assets/mp3/New-notification.mp3" type="audio/mpeg">
            </audio>
            <audio id="message-sound" class="sound-controls" preload="auto" style="visibility: hidden;">
                <source src="<?php echo $theme_url; ?>assets/mp3/New-message.mp3" type="audio/mpeg">
            </audio>
            <audio id="calling-sound" class="sound-controls" preload="auto">
                <source src="<?php echo $theme_url; ?>assets/mp3/calling.mp3" type="audio/mpeg">
            </audio>
            <audio id="video-calling-sound" class="sound-controls" preload="auto">
                <source src="<?php echo $theme_url; ?>assets/mp3/video_call.mp3" type="audio/mpeg">
            </audio>
        </div>
    <?php } ?>

    <?php if(route( 1 ) !== 'find-matches'){ ?>
    <script>
        window.addEventListener("load", function(){
            window.cookieconsent.initialise({
                "palette": {
                    "popup": {
                        "background": "#ffffff",
                        "text": "#afafaf"
                    },
                    "button": {
                        "background": "#c649b8"
                    }
                },
                "theme": "edgeless",
                "position": "bottom-left",
                "content": {
                    "message": "<?php echo __('This website uses cookies to ensure you get the best experience on our website.');?>",
                    "dismiss": "<?php echo __('Got It!');?>",
                    "link": "<?php echo __('Learn More');?>",
                    "href": "<?php echo $site_url;?>/privacy"
                }
            });
        });
    </script>
    <?php } ?>


</body>
</html>