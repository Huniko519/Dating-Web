<?php if( $profile->is_pro == 1 ){?><script>window.location = window.site_url;</script><?php } ?>
<?php if( $config->pro_system == 0 ){?><script>window.location = window.site_url;</script><?php } ?>
<?php if( isGenderFree($profile->gender) === true ){?><script>window.location = window.site_url;</script><?php } ?>
<!-- Premium  -->
<div class="container page-margin find_matches_cont">
	<div class="row r_margin">
		<div class="col l3">
			<?php require( $theme_path . 'main' . $_DS . 'sidebar.php' );?>
		</div>
		
		<div class="col l9">
			<div class="dt_premium dt_sections dt_pro_pg">
				<?php if (file_exists($theme_path . 'third-party-payment.php')) { ?>
					<?php require( $theme_path . 'third-party-payment.php' );?>
			    <?php } ?>
				<div class="dt_p_head center">
					<h2 class="light gold-text"><?php echo __( 'Amazing' );?> <?php echo ucfirst( $config->site_name );?> <?php echo __( 'features you can’t live without' );?>.</h2>
					<p class="bold"><?php echo __( 'Activating Premium will help you meet more people, faster.' );?></p>
				</div>
				<div class="row dt_prem_row">
					<div class="col s12 m7 l5">
						<div class="dt_choose_pro">
							<h2><?php echo __( 'Choose a Plan' );?></h2>
							<p>
								<label>
									<input class="with-gap" name="pro_plan" type="radio" value="<?php echo __( 'Weekly' );?>" data-price="<?php echo (float)$config->weekly_pro_plan;?>"/>
									<span class="pln_name">
										<span class="duration"><?php echo __( 'Weekly' );?></span>
										<span class="price"><?php echo $config->currency_symbol . (float)$config->weekly_pro_plan;?></span>
									</span>
								</label>
							</p>
							<p>
								<label>
									<input class="with-gap" name="pro_plan" type="radio" value="<?php echo __( 'Monthly' );?>" data-price="<?php echo (float)$config->monthly_pro_plan;?>" checked />
									<span class="pln_name">
										<span class="pln_popular"><span><?php echo __( 'Most popular' );?></span><span class="pln_popular_tail"></span></span>
										<span class="duration"><?php echo __( 'Monthly' );?></span>
										<span class="price"><?php echo $config->currency_symbol . (float)$config->monthly_pro_plan;?></span>
									</span>
								</label>
							</p>
							<p>
								<label>
									<input class="with-gap" name="pro_plan" type="radio" value="<?php echo __( 'Yearly' );?>" data-price="<?php echo (float)$config->yearly_pro_plan;?>"/>
									<span class="pln_name">
										<span class="duration"><?php echo __( 'Yearly' );?></span>
										<span class="price"><?php echo $config->currency_symbol . (float)$config->yearly_pro_plan;?></span>
									</span>
								</label>
							</p>
							<p>
								<label>
									<input class="with-gap" name="pro_plan" type="radio" value="<?php echo __( 'Lifetime' );?>" data-price="<?php echo (float)$config->lifetime_pro_plan;?>"/>
									<span class="pln_name">
										<span class="duration"><?php echo __( 'Lifetime' );?></span>
										<span class="price"><?php echo $config->currency_symbol . (float)$config->lifetime_pro_plan;?></span>
									</span>
								</label>
							</p>
							<div class="pay_using center">
								<p class="bold"><?php echo __( 'Pay Using' );?></p>
								<div class="pay_u_btns valign-wrapper">
									<button id="paypal" onclick="clickAndDisable(this);" class="btn paypal valign-wrapper">
										<span><?php echo __( 'PayPal' );?></span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M8.32,21.97C8.21,21.92 8.08,21.76 8.06,21.65C8.03,21.5 8,21.76 8.66,17.56C9.26,13.76 9.25,13.82 9.33,13.71C9.46,13.54 9.44,13.54 10.94,13.53C12.26,13.5 12.54,13.5 13.13,13.41C16.38,12.96 18.39,11.05 19.09,7.75C19.13,7.53 19.17,7.34 19.18,7.34C19.18,7.33 19.25,7.38 19.33,7.44C20.36,8.22 20.71,9.66 20.32,11.58C19.86,13.87 18.64,15.39 16.74,16.04C15.93,16.32 15.25,16.43 14.05,16.46C13.25,16.5 13.23,16.5 13,16.65C12.83,16.82 12.84,16.79 12.45,19.2C12.18,20.9 12.08,21.45 12.04,21.55C11.97,21.71 11.83,21.85 11.67,21.93L11.56,22H10C8.71,22 8.38,22 8.32,21.97V21.97M3.82,19.74C3.63,19.64 3.5,19.47 3.5,19.27C3.5,19 6.11,2.68 6.18,2.5C6.27,2.32 6.5,2.13 6.68,2.06L6.83,2H10.36C14.27,2 14.12,2 15,2.2C17.62,2.75 18.82,4.5 18.37,7.13C17.87,10.06 16.39,11.8 13.87,12.43C13,12.64 12.39,12.7 10.73,12.7C9.42,12.7 9.32,12.71 9.06,12.85C8.8,13 8.59,13.27 8.5,13.6C8.46,13.67 8.23,15.07 7.97,16.7C7.71,18.33 7.5,19.69 7.5,19.72L7.47,19.78H5.69C4.11,19.78 3.89,19.78 3.82,19.74V19.74Z"></path></svg>
										<svg class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="spinner__path" fill="none" stroke-width="7" stroke-linecap="round" cx="33" cy="33" r="29"></circle></svg>
									</button>
									<button id="stripe_pro_new" class="btn stripe valign-wrapper"><?php echo __( 'Card' );?> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M20,8H4V6H20M20,18H4V12H20M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"></path></svg></button>
<!--									<button id="stripe_pro_btn" class="hide"></button>-->
                                    <?php if(!empty($config->bank_description)){?>
                                        <button id="bank_transfer" class="btn valign-wrapper bank"><?php echo __( 'Bank Transfer' );?> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15,14V11H18V9L22,12.5L18,16V14H15M14,7.7V9H2V7.7L8,4L14,7.7M7,10H9V15H7V10M3,10H5V15H3V10M13,10V12.5L11,14.3V10H13M9.1,16L8.5,16.5L10.2,18H2V16H9.1M17,15V18H14V20L10,16.5L14,13V15H17Z"></path></svg></button>
                                    <?php } ?>

                                    <?php if(!empty($config->paysera_password)){?>
                                        <button id="sms_payment" onclick="PayProViaSms();" class="btn valign-wrapper sms"><?php echo __( 'SMS' );?> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17,19V5H7V19H17M17,1A2,2 0 0,1 19,3V21A2,2 0 0,1 17,23H7C5.89,23 5,22.1 5,21V3C5,1.89 5.89,1 7,1H17M9,7H15V9H9V7M9,11H13V13H9V11Z"></path></svg></button>
                                    <?php } ?>
                                </div>

							</div>
						</div>
					</div>
					<div class="col s12 m5 l7">
						<div class="dt_pro_features">
							<h2><?php echo __( 'Why Choose Premium Membership' );?></h2>
							<div class="row">
								<div class="col s12 m12 l4 center">
									<span class="red darken-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5.5,2C3.56,2 2,3.56 2,5.5V18.5C2,20.44 3.56,22 5.5,22H16L22,16V5.5C22,3.56 20.44,2 18.5,2H5.5M5.75,4H18.25A1.75,1.75 0 0,1 20,5.75V15H18.5C16.56,15 15,16.56 15,18.5V20H5.75A1.75,1.75 0 0,1 4,18.25V5.75A1.75,1.75 0 0,1 5.75,4M14.44,6.77C14.28,6.77 14.12,6.79 13.97,6.83C13.03,7.09 12.5,8.05 12.74,9C12.79,9.15 12.86,9.3 12.95,9.44L16.18,8.56C16.18,8.39 16.16,8.22 16.12,8.05C15.91,7.3 15.22,6.77 14.44,6.77M8.17,8.5C8,8.5 7.85,8.5 7.7,8.55C6.77,8.81 6.22,9.77 6.47,10.7C6.5,10.86 6.59,11 6.68,11.16L9.91,10.28C9.91,10.11 9.89,9.94 9.85,9.78C9.64,9 8.95,8.5 8.17,8.5M16.72,11.26L7.59,13.77C8.91,15.3 11,15.94 12.95,15.41C14.9,14.87 16.36,13.25 16.72,11.26Z" /></svg>
									</span>
									<p><?php echo __( 'See more stickers on chat' );?></p>
								</div>
								<div class="col s12 m12 l4 center">
									<span class="pink darken-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" /></svg>
									</span>
									<p><?php echo __( 'Show in Premium bar' );?></p>
								</div>
								<div class="col s12 m12 l4 center">
									<span class="purple darken-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21M19.75,3.19L18.33,4.61C20.04,6.3 21,8.6 21,11H23C23,8.07 21.84,5.25 19.75,3.19M1,11H3C3,8.6 3.96,6.3 5.67,4.61L4.25,3.19C2.16,5.25 1,8.07 1,11Z" /></svg>
									</span>
									<p><?php echo __( 'See likes notifications' );?></p>
								</div>
							</div>
							<div class="row">
								<div class="col s12 m12 l4 center">
									<span class="green darken-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M18.65,2.85L19.26,6.71L22.77,8.5L21,12L22.78,15.5L19.24,17.29L18.63,21.15L14.74,20.54L11.97,23.3L9.19,20.5L5.33,21.14L4.71,17.25L1.22,15.47L3,11.97L1.23,8.5L4.74,6.69L5.35,2.86L9.22,3.5L12,0.69L14.77,3.46L18.65,2.85M9.5,7A1.5,1.5 0 0,0 8,8.5A1.5,1.5 0 0,0 9.5,10A1.5,1.5 0 0,0 11,8.5A1.5,1.5 0 0,0 9.5,7M14.5,14A1.5,1.5 0 0,0 13,15.5A1.5,1.5 0 0,0 14.5,17A1.5,1.5 0 0,0 16,15.5A1.5,1.5 0 0,0 14.5,14M8.41,17L17,8.41L15.59,7L7,15.59L8.41,17Z" /></svg>
									</span>
									<p><?php echo __( 'Get discount when buy boost me' );?></p>
								</div>
								<div class="col s12 m12 l4 center">
									<span class="blue darken-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,16L19.36,10.27L21,9L12,2L3,9L4.63,10.27M12,18.54L4.62,12.81L3,14.07L12,21.07L21,14.07L19.37,12.8L12,18.54Z" /></svg>
									</span>
									<p><?php echo __( 'Display first in find matches' );?></p>
								</div>
								<div class="col s12 m12 l4 center">
									<span class="teal darken-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M13,15L15.5,17.5L16.92,16.08L12,11.16L7.08,16.08L8.5,17.5L11,15V21H13V15M3,3H21V5H3V3M3,7H13V9H3V7Z" /></svg>
									</span>
									<p><?php echo __( 'Display on top in random users' );?></p>
								</div>
							</div>
							<div class="row">
                                <?php if($config->video_chat == 1 && $config->audio_chat == 1){ ?>
                                    <div class="col s12 m12 l4 center">
                                        <span class="pink darken-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17,10.5L21,6.5V17.5L17,13.5V17A1,1 0 0,1 16,18H4A1,1 0 0,1 3,17V7A1,1 0 0,1 4,6H16A1,1 0 0,1 17,7V10.5M14,16V15C14,13.67 11.33,13 10,13C8.67,13 6,13.67 6,15V16H14M10,8A2,2 0 0,0 8,10A2,2 0 0,0 10,12A2,2 0 0,0 12,10A2,2 0 0,0 10,8Z"></path></svg>
                                        </span>
                                        <p><?php echo __( 'Video and Audio calls to all users' );?></p>
                                    </div>
                                <?php } ?>

                                <div class="col s12 m12 l4 center">
									<span class="indigo darken-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,2C15.31,2 18,4.66 18,7.95C18,12.41 12,19 12,19C12,19 6,12.41 6,7.95C6,4.66 8.69,2 12,2M12,6A2,2 0 0,0 10,8A2,2 0 0,0 12,10A2,2 0 0,0 14,8A2,2 0 0,0 12,6M20,19C20,21.21 16.42,23 12,23C7.58,23 4,21.21 4,19C4,17.71 5.22,16.56 7.11,15.83L7.75,16.74C6.67,17.19 6,17.81 6,18.5C6,19.88 8.69,21 12,21C15.31,21 18,19.88 18,18.5C18,17.81 17.33,17.19 16.25,16.74L16.89,15.83C18.78,16.56 20,17.71 20,19Z"></path></svg>
									</span>
                                    <p><?php echo __( 'Find potential matches by country' );?></p>
                                </div>
								<div class="col s12 m12 l4 center"></div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Premium  -->
<a href="javascript:void(0);" id="btnProSuccess" style="visibility: hidden;display: none;"></a>

<div class="bank_transfer_modal modal modal-fixed-footer">
	<div class="modal-dialog">
    <div class="modal-content dt_bank_trans_modal">
		<div class="modal-header">
			<h5 class="modal-title"><?php echo __( 'Bank Transfer' );?></h5>
		</div>
        <div class="modal-body">
            <div class="bank_info"><?php echo htmlspecialchars_decode($config->bank_description);?></div>
			<div class="dt_user_profile hide_alert_info_bank_trans">
                <span class="valign-wrapper">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M13,13H11V7H13M13,17H11V15H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"></path></svg> <?php echo __( 'Note' );?>:
                </span>
				<ul class="browser-default dt_prof_vrfy">
					<li><?php echo __( 'Please transfer the amount of' );?> <b><span id="bank_transfer_price"></span></b> <?php echo __( 'to this bank account to buy' );?> <b>"<span id="bank_transfer_description"></span>"</b> <?php echo __( 'Plan Premium Membership' );?></li>
					<li><?php echo $config->bank_transfer_note;?></li>
				</ul>
            </div>
			<p class="dt_bank_trans_upl_rec"><a href="javascript:void(0);" onclick="$('.bank_transfer_modal').addClass('up_rec_active'); return false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M13.5,16V19H10.5V16H8L12,12L16,16H13.5M13,9V3.5L18.5,9H13Z"></path></svg> <?php echo __( 'Upload Receipt' );?></a></p>
            <div class="upload_bank_receipts">
                <div onclick="document.getElementById('receipt_img').click(); return false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M13.5,16V19H10.5V16H8L12,12L16,16H13.5M13,9V3.5L18.5,9H13Z"></path></svg>
                    <p><?php echo __( 'Upload Receipt' );?></p>
					<img id="receipt_img_preview" src="">
                </div>
            </div>
            <input type="file" id="receipt_img" class="hide" accept="image/x-png, image/gif, image/jpeg" name="receipt_img">
        </div>
        <!--<span style="display: block;text-align: center;" id="receipt_img_path"></span>-->
    </div>
    <div class="modal-footer">
		<div class="bank_transfr_progress hide" id="img_upload_progress">
			<div class="progress">
				<div id="img_upload_progress_bar" class="determinate progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
			</div>
		</div>
		<button class="modal-close waves-effect btn-flat"><?php echo __( 'Close' );?></button>
        <button class="waves-effect waves-green btn btn-flat bold" disabled id="btn-upload-receipt" data-selected=""><?php echo __( 'Confirm' );?></button>
    </div>
	</div>
</div>

<div class="modal fade" id="stripe_modal_pro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content add_money_modal add_address_modal">
            <h5 class="modal-title text-center">Stripe</h5>
            <div class="modal-body">
                <div id="stripe_alert" style="    color: red;"></div>
                <form id="stripe_form" method="post">
                    <div class="form-group">
                        <input class="form-control shop_input" type="text" placeholder="<?php echo __( 'Name' );?>"  value="<?php echo $profile->full_name;?>" id="stripe_name">
                    </div>
                    <div class="form-group">
                        <input class="form-control shop_input" type="email" placeholder="<?php echo __( 'Email' );?>" value="" data-email="<?php echo base64_encode($profile->email);?>" id="stripe_email">
                    </div>
                    <div class="form-group">
                        <input id="stripe_number" class="form-control shop_input" type="text" placeholder="<?php echo __( 'Card Number' );?>">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="stripe_month" type="text" class="form-control shop_input" autocomplete="off" placeholder="<?php echo __( 'Month' );?> (01)">
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
                                <select id="stripe_year" type="text" class="form-control shop_input" autocomplete="off" placeholder="<?php echo __( 'Year' );?> (2019)">
                                    <?php for ($i=date('Y'); $i <= date('Y')+15; $i++) {  ?>
                                        <option value="<?php echo($i) ?>"><?php echo($i) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input id="stripe_cvc" type="text" class="form-control shop_input" autocomplete="off" placeholder="CVC" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-main" onclick="SH_StripeRequestPro()" id="stripe_button_pro"><?php echo __( 'Pay' );?></button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?php echo __( 'Cancel' );?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    document.getElementById('stripe_pro_new').addEventListener('click', function(e) {
        $('#stripe_email').val(atob($('#stripe_email').attr('data-email')));
        $('#stripe_number').val('');
        $('#stripe_cvc').val('');
        $('#stripe_modal_pro').removeClass('up_rec_img_ready, up_rec_active');
        $('#stripe_modal_pro').modal('open');
    });


    function PayProViaSms() {
        window.location = window.ajax + 'sms/generate_pro_link?price=' + getPrice() + '00';
    }

    function getDescription() {
        var plans = document.getElementsByName('pro_plan');
        for (index=0; index < plans.length; index++) {
            if (plans[index].checked) {
                return plans[index].value;
                break;
            }
        }
    }

    function getPrice() {
        var plans = document.getElementsByName('pro_plan');
        for (index=0; index < plans.length; index++) {
            if (plans[index].checked) {
                return plans[index].getAttribute('data-price');
                break;
            }
        }
    }

    document.getElementById('paypal').addEventListener('click', function(e) {
        $.post(window.ajax + 'paypal/generate_link', {description:getDescription(), amount:getPrice(), mode: "premium-membarship"}, function (data) {
            if (data.status == 200) {
                window.location.href = data.location;
            } else {
                $('.modal-body').html('<i class="fa fa-spin fa-spinner"></i> Payment declined ');
            }
        });

        e.preventDefault();
    });


    document.getElementById('bank_transfer').addEventListener('click', function(e) {
        $('#bank_transfer_price').text('<?php echo $config->currency_symbol;?>' + getPrice());
        $('#bank_transfer_description').text(getDescription());
        $('#receipt_img_path').html('');
        $('#receipt_img_preview').attr('src', '');
		$('.bank_transfer_modal').removeClass('up_rec_img_ready, up_rec_active');
        $('.bank_transfer_modal').modal('open');
    });

    document.getElementById('receipt_img').addEventListener('change', function(e) {
        let imgPath = $(this)[0].files[0].name;
        if (typeof(FileReader) != "undefined") {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#receipt_img_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
        $('#receipt_img_path').html(imgPath);
		$('.bank_transfer_modal').addClass('up_rec_img_ready');
        $('#btn-upload-receipt').removeAttr('disabled');
        $('#btn-upload-receipt').removeClass('btn-flat').addClass('btn-success');
    });

    document.getElementById('btn-upload-receipt').addEventListener('click', function(e) {
        e.preventDefault();
        let bar = $('#img_upload_progress');
        let percent = $('#img_upload_progress_bar');

        let formData = new FormData();
        formData.append("description", getDescription());
        formData.append("price", getPrice());
        formData.append("mode", 'membership');
        formData.append("receipt_img", $("#receipt_img")[0].files[0], $("#receipt_img")[0].files[0].value);
        bar.removeClass('hide');
        $.ajax({
            xhr: function() {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt){
                    if (evt.lengthComputable) {
                        let percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        //status.html( percentComplete + "%");
                        percent.width(percentComplete + '%');
                        percent.html(percentComplete + '%');
                        if (percentComplete === 100) {
                            bar.addClass('hide');
                            percent.width('0%');
                            percent.html('0%');
                        }
                    }
                }, false);
                return xhr;
            },
            url: window.ajax + 'profile/upload_receipt',
            type: "POST",
            async: true,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000,
            dataType: false,
            data: formData,
            success: function(result) {
                if( result.status == 200 ){
                    $('.bank_transfer_modal').modal('close');
                    M.toast({html: '<?php echo __('Your receipt uploaded successfully.');?>'});
                    return false;
                }
            }
        });
    });
</script>