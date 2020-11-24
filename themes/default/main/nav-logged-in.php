<?php
    if( !isset( $_SESSION['JWT'] ) ){
        exit();
    }
?>
    <?php //require( $theme_path . 'main' . $_DS . 'onesignal.php' );?>
    <!-- Header  -->
		<nav role="navigation" id="nav-logged-in">
            <div class="nav-wrapper container">
				
				<span class="left dt_slide_menu" id="open_slide">
					<svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z"></path></svg>
				</span>
				
                <div class="left header_logo">
                    <a id="logo-container" href="<?php echo $site_url;?>/<?php if( $profile->verified == 1 ){?>find-matches<?php }?>" class="brand-logo">
                        <img src="<?php echo $config->sitelogo;?>" alt="" data-default="" data-light="">
                    </a>
                </div>
                <?php if( $profile->verified == 1 ){?>
                    <ul class="left header_home_link hide-on-med-and-down">
                        <li>
                            <a href="<?php echo $site_url;?>/find-matches" data-ajax="/find-matches"><?php echo __( 'Find Matches' );?></a>
                        </li>

                        <?php if( $config->pro_system == 1 ) { ?>

                            <?php if( $profile->is_pro <> 1 ) { ?>

                                <?php if( isGenderFree($profile->gender) === false ){ ?>
                                    <li>
                                        <a href="<?php echo $site_url;?>/pro" data-ajax="/pro" class="prem"><span><?php echo __( 'Premium' );?></span></a>
                                    </li>
                                <?php }?>

                            <?php } ?>

                        <?php } ?>

                    </ul>
                    <ul class="right">
						<li>
							<div class="boost-div">
							<?php
								$boost_duration = 0;
								if( $profile->boosted_time > 0 ) {
									$boost_duration = ( time() - $profile->boosted_time ) / 60;
								}else{
									$boost_duration = $config->boost_expire_time;
								}
								$boost_duration = $config->boost_expire_time - $boost_duration;
							?>
							<?php if( $profile->is_boosted == '1' && $boost_duration <= $config->boost_expire_time ){?>
								<div class="boosted_message_expire" data-message-expire="<button title='<?php echo __('Boost me!');?>' id='boost_btn' class='btn boost-me'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 493.944 493.944'><path fill='currentColor' d='M367.468,175.996c-3.368-5.469-9.317-8.807-15.734-8.807h-84.958l45.919-143.098  c1.797-5.614,0.816-11.76-2.662-16.521c-3.464-4.748-9.014-7.57-14.9-7.57h-84.446c-8.02,0-15.125,5.18-17.563,12.814  l-68.487,213.465c-1.797,5.613-0.817,11.756,2.663,16.52c3.464,4.748,9.013,7.57,14.899,7.57h14.868h68.183l-22.006,235.037  c-0.352,3.736,2.004,7.185,5.614,8.227c3.593,1.045,7.427-0.608,9.126-3.961L368.19,194.01  C371.093,188.281,370.82,181.467,367.468,175.996z' /></svg></button>">
									<span class="global_boosted_time" data-show="no" data-boosted-time="<?php echo $boost_duration;?>"></span>
									<button title='<?php echo __('Your boost will expire in');?> <?php echo __('minutes');?>' class='btn boost-running'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 493.944 493.944"><path fill="currentColor" d="M367.468,175.996c-3.368-5.469-9.317-8.807-15.734-8.807h-84.958l45.919-143.098  c1.797-5.614,0.816-11.76-2.662-16.521c-3.464-4.748-9.014-7.57-14.9-7.57h-84.446c-8.02,0-15.125,5.18-17.563,12.814  l-68.487,213.465c-1.797,5.613-0.817,11.756,2.663,16.52c3.464,4.748,9.013,7.57,14.899,7.57h14.868h68.183l-22.006,235.037  c-0.352,3.736,2.004,7.185,5.614,8.227c3.593,1.045,7.427-0.608,9.126-3.961L368.19,194.01  C371.093,188.281,370.82,181.467,367.468,175.996z" /></svg></button>
								</div>
							<?php }else if( $profile->is_boosted == '0' || ( $profile->is_boosted == '1' && $boost_duration > $config->boost_expire_time ) ){ ?>
								<button title='<?php echo __('Boost me!');?>' id='boost_btn' class='btn boost-me'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 493.944 493.944"><path fill="currentColor" d="M367.468,175.996c-3.368-5.469-9.317-8.807-15.734-8.807h-84.958l45.919-143.098  c1.797-5.614,0.816-11.76-2.662-16.521c-3.464-4.748-9.014-7.57-14.9-7.57h-84.446c-8.02,0-15.125,5.18-17.563,12.814  l-68.487,213.465c-1.797,5.613-0.817,11.756,2.663,16.52c3.464,4.748,9.013,7.57,14.899,7.57h14.868h68.183l-22.006,235.037  c-0.352,3.736,2.004,7.185,5.614,8.227c3.593,1.045,7.427-0.608,9.126-3.961L368.19,194.01  C371.093,188.281,370.82,181.467,367.468,175.996z" /></svg></button>
							<?php } ?>
							</div>
						</li>
                        <li class="header_credits">
                            <?php if ( isGenderFree($profile->gender) === true ) {?>
                            <a href="javascript:void(0);" class="btn-flat" tooltip="<?php echo __('Credits');?>" flow="down">
                            <?php }else{ ?>
                            <a href="<?php echo $site_url;?>/credit" data-ajax="/credit" class="btn-flat" tooltip="<?php echo __('Credits');?>" flow="down">
                            <?php } ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#FF9800" d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M11,17V16H9V14H13V13H10A1,1 0 0,1 9,12V9A1,1 0 0,1 10,8H11V7H13V8H15V10H11V11H14A1,1 0 0,1 15,12V15A1,1 0 0,1 14,16H13V17H11Z"></path></svg>
                                 <span id="credit_amount">
                                     <?php
                                        if( isGenderFree($profile->gender) === true ){
                                            echo __('Free');
                                        }else{
                                            echo (int)$profile->balance;
                                        }
                                     ?>
                                 </span>
                            </a>
                        </li>
                        <li class="header_msg">
                            <a href="javascript:void(0);" id="messenger_opener" class="btn-flat waves-effect">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17,12V3A1,1 0 0,0 16,2H3A1,1 0 0,0 2,3V17L6,13H16A1,1 0 0,0 17,12M21,6H19V15H6V17A1,1 0 0,0 7,18H18L22,22V7A1,1 0 0,0 21,6Z" /></svg>
                                <?php
                                    $unread_messages = 0;// Message::getUnreadMessages();
                                    if( $unread_messages > 0 ){
                                        echo '<span class="badge red chat_badge" href="javascript:void(0);" id="messenger_opener">' . $unread_messages . '</span></a>';
                                    }else{
                                        echo '<span class="badge red chat_badge hide" href="javascript:void(0);" id="messenger_opener">0</span></a>';
                                    }
                                ?>
                            </a>
                        </li>
                        <li class="header_notifications">
                            <a href="javascript:void(0);" id="notificationbtn" data-ajax-post="/useractions/shownotifications" data-ajax-params="" data-ajax-callback="callback_show_notifications" data-target="notif_dropdown" class="dropdown-trigger btn-flat waves-effect">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21M19.75,3.19L18.33,4.61C20.04,6.3 21,8.6 21,11H23C23,8.07 21.84,5.25 19.75,3.19M1,11H3C3,8.6 3.96,6.3 5.67,4.61L4.25,3.19C2.16,5.25 1,8.07 1,11Z" /></svg>
								<span class="badge red notification_badge hide">0</span>
							</a>
                            <ul id="notif_dropdown" class="dropdown-content">
                                <div class="dt_notifis_prnt">
                                    <h5 class="empty_state">
                                        <div class="lds-facebook" style="display: block;margin: 0 auto;padding: 50px 0px;top: 20px;"><div style="background: #a33596;"></div><div style="background: #a33596;"></div><div style="background: #a33596;"></div></div>
                                    </h5>
                                </div>
                            </ul>
                        </li>
                        <li class="header_user">
                            <a href="javascript:void(0);" data-target="user_dropdown" class="dropdown-trigger btn-flat">
                                <img src="<?php echo $profile->avater->avater;?>" alt="<?php echo $profile->full_name;?>" />
                            </a>
                            <ul id="user_dropdown" class="dropdown-content">
                                <li class="header_credits_mobi">
                                    <a href="<?php echo $site_url;?>/credit" data-ajax="/credit" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#FF9800" d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M11,17V16H9V14H13V13H10A1,1 0 0,1 9,12V9A1,1 0 0,1 10,8H11V7H13V8H15V10H11V11H14A1,1 0 0,1 15,12V15A1,1 0 0,1 14,16H13V17H11Z"></path></svg> <?php echo (int)$profile->balance;?> <?php echo __( 'Credits' );?></a>
                                </li>
								<?php if( $profile->is_pro <> 1 ) { ?>
                                <li class="header_credits_mobi">
                                    <a href="<?php echo $site_url;?>/pro" data-ajax="/pro" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#2196f3" d="M16,9H19L14,16M10,9H14L12,17M5,9H8L10,16M15,4H17L19,7H16M11,4H13L14,7H10M7,4H9L8,7H5M6,2L2,8L12,22L22,8L18,2H6Z" /></svg> <?php echo __( 'Premium' );?></a>
                                </li>
								<?php } ?>
                                <li class="divider header_credits_mobi" tabindex="-1"></li>
                                <li>
                                    <a href="<?php echo $site_url;?>/@<?php echo $profile->username;?>" data-ajax="/@<?php echo $profile->username;?>" id="profile_link" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#3D8CFA" d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" /></svg> <?php echo __( 'Profile' );?></a>
                                </li>
                                <li>
                                    <a href="<?php echo $site_url;?>/matches" data-ajax="/matches" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#8bc34a" d="M22.59,7.92L23.75,9.33L19,14.08L16.25,11.08L17.41,9.92L19,11.5L22.59,7.92M6,5A3,3 0 0,1 9,8A3,3 0 0,1 6,11A3,3 0 0,1 3,8A3,3 0 0,1 6,5M11,5A3,3 0 0,1 14,8A3,3 0 0,1 11,11C10.68,11 10.37,10.95 10.08,10.85C10.65,10.04 11,9.06 11,8C11,6.94 10.65,5.95 10.08,5.14C10.37,5.05 10.68,5 11,5M6,13C8,13 12,14 12,16V18H0V16C0,14 4,13 6,13M12.62,13.16C14.63,13.5 17,14.46 17,16V18H14V16C14,14.82 13.45,13.88 12.62,13.16Z" /></svg> <?php echo __( 'Matches' );?></a>
                                </li>
                                <li>
                                    <a href="<?php echo $site_url;?>/visits" data-ajax="/visits" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#673ab7" d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z" /></svg> <?php echo __( 'Visits' );?></a>
                                </li>
                                <?php if( $config->connectivitySystem == '1' ){?>
                                <li>
                                    <a href="<?php echo $site_url;?>/friends" data-ajax="/friends"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#8BC34A" d="M16.5,12A2.5,2.5 0 0,0 19,9.5A2.5,2.5 0 0,0 16.5,7A2.5,2.5 0 0,0 14,9.5A2.5,2.5 0 0,0 16.5,12M9,11A3,3 0 0,0 12,8A3,3 0 0,0 9,5A3,3 0 0,0 6,8A3,3 0 0,0 9,11M16.5,14C14.67,14 11,14.92 11,16.75V19H22V16.75C22,14.92 18.33,14 16.5,14M9,13C6.67,13 2,14.17 2,16.5V19H9V16.75C9,15.9 9.33,14.41 11.37,13.28C10.5,13.1 9.66,13 9,13Z" /></svg> <?php echo __( 'Friends' );?></a>
                                </li>
                                <?php } ?>
								<li class="divider" tabindex="-1"></li>
                                <li>
                                    <a href="<?php echo $site_url;?>/likes" data-ajax="/likes" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#f25e4e" d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" /></svg> <?php echo __( 'Likes' );?></a>
                                </li>
                                <li>
                                    <a href="<?php echo $site_url;?>/liked" data-ajax="/liked" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#8BC34A" d="M15,14C12.3,14 7,15.3 7,18V20H23V18C23,15.3 17.7,14 15,14M15,12A4,4 0 0,0 19,8A4,4 0 0,0 15,4A4,4 0 0,0 11,8A4,4 0 0,0 15,12M5,15L4.4,14.5C2.4,12.6 1,11.4 1,9.9C1,8.7 2,7.7 3.2,7.7C3.9,7.7 4.6,8 5,8.5C5.4,8 6.1,7.7 6.8,7.7C8,7.7 9,8.6 9,9.9C9,11.4 7.6,12.6 5.6,14.5L5,15Z" /></svg> <?php echo __( 'People i liked' );?></a>
                                </li>
                                <li>
                                    <a href="<?php echo $site_url;?>/disliked" data-ajax="/disliked" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#f79f58" d="M19,15H23V3H19M15,3H6C5.17,3 4.46,3.5 4.16,4.22L1.14,11.27C1.05,11.5 1,11.74 1,12V14A2,2 0 0,0 3,16H9.31L8.36,20.57C8.34,20.67 8.33,20.77 8.33,20.88C8.33,21.3 8.5,21.67 8.77,21.94L9.83,23L16.41,16.41C16.78,16.05 17,15.55 17,15V5C17,3.89 16.1,3 15,3Z" /></svg> <?php echo __( 'People i disliked' );?></a>
                                </li>
                                <?php if( $config->connectivitySystem == '1' ){?>
                                <li>
                                    <a href="<?php echo $site_url;?>/friend-requests" data-ajax="/friend-requests"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#8BC34A" d="M15,14C12.33,14 7,15.33 7,18V20H23V18C23,15.33 17.67,14 15,14M6,10V7H4V10H1V12H4V15H6V12H9V10M15,12A4,4 0 0,0 19,8A4,4 0 0,0 15,4A4,4 0 0,0 11,8A4,4 0 0,0 15,12Z" /></svg> <?php echo __( 'Friend requests' );?></a>
                                </li>
                                <?php } ?>
								<li class="divider" tabindex="-1"></li>
								<li>
                                    <a href="<?php echo $site_url;?>/settings/<?php echo $profile->username;?>" data-ajax="/settings/<?php echo $profile->username;?>" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#009da0" d="M12,15.5A3.5,3.5 0 0,1 8.5,12A3.5,3.5 0 0,1 12,8.5A3.5,3.5 0 0,1 15.5,12A3.5,3.5 0 0,1 12,15.5M19.43,12.97C19.47,12.65 19.5,12.33 19.5,12C19.5,11.67 19.47,11.34 19.43,11L21.54,9.37C21.73,9.22 21.78,8.95 21.66,8.73L19.66,5.27C19.54,5.05 19.27,4.96 19.05,5.05L16.56,6.05C16.04,5.66 15.5,5.32 14.87,5.07L14.5,2.42C14.46,2.18 14.25,2 14,2H10C9.75,2 9.54,2.18 9.5,2.42L9.13,5.07C8.5,5.32 7.96,5.66 7.44,6.05L4.95,5.05C4.73,4.96 4.46,5.05 4.34,5.27L2.34,8.73C2.21,8.95 2.27,9.22 2.46,9.37L4.57,11C4.53,11.34 4.5,11.67 4.5,12C4.5,12.33 4.53,12.65 4.57,12.97L2.46,14.63C2.27,14.78 2.21,15.05 2.34,15.27L4.34,18.73C4.46,18.95 4.73,19.03 4.95,18.95L7.44,17.94C7.96,18.34 8.5,18.68 9.13,18.93L9.5,21.58C9.54,21.82 9.75,22 10,22H14C14.25,22 14.46,21.82 14.5,21.58L14.87,18.93C15.5,18.67 16.04,18.34 16.56,17.94L19.05,18.95C19.27,19.03 19.54,18.95 19.66,18.73L21.66,15.27C21.78,15.05 21.73,14.78 21.54,14.63L19.43,12.97Z" /></svg> <?php echo __( 'Settings' );?></a>
                                </li>
                                <li>
                                    <a href="<?php echo $site_url;?>/transactions" data-ajax="/transactions" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#795548" d="M15,14V11H18V9L22,12.5L18,16V14H15M14,7.7V9H2V7.7L8,4L14,7.7M7,10H9V15H7V10M3,10H5V15H3V10M13,10V12.5L11,14.3V10H13M9.1,16L8.5,16.5L10.2,18H2V16H9.1M17,15V18H14V20L10,16.5L14,13V15H17Z" /></svg> <?php echo __( 'Transactions' );?></a>
                                </li>
                                <?php if( $profile->admin == 1 || $profile->permission !== '' ){ ?>
								<li class="divider" tabindex="-1"></li>
                                <li>
                                    <a href="<?php echo $site_url;?>/admin-cp" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z" /></svg> <?php echo __( 'Admin Panel' );?></a>
                                </li>
                                <?php } ?>
                                <li class="divider" tabindex="-1"></li>
                                <li>
									<a href="javascript:void(0);" onclick="logout()" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#F44336" d="M16.56,5.44L15.11,6.89C16.84,7.94 18,9.83 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12C6,9.83 7.16,7.94 8.88,6.88L7.44,5.44C5.36,6.88 4,9.28 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12C20,9.28 18.64,6.88 16.56,5.44M13,3H11V13H13" /></svg> <?php echo __( 'Log Out' );?></a>
                                </li>
								<li class="divider" tabindex="-1"></li>
								<li>
									<a href="javascript:void(0);" id="night_mode_toggle" data-night-text="<?php echo __('Night mode');?>" data-light-text="<?php echo __('Day mode');?>" data-mode='<?php echo Secure($config->nextmode) ?>'>
										<span><?php echo $config->nextmode_text;?></span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17.75,4.09L15.22,6.03L16.13,9.09L13.5,7.28L10.87,9.09L11.78,6.03L9.25,4.09L12.44,4L13.5,1L14.56,4L17.75,4.09M21.25,11L19.61,12.25L20.2,14.23L18.5,13.06L16.8,14.23L17.39,12.25L15.75,11L17.81,10.95L18.5,9L19.19,10.95L21.25,11M18.97,15.95C19.8,15.87 20.69,17.05 20.16,17.8C19.84,18.25 19.5,18.67 19.08,19.07C15.17,23 8.84,23 4.94,19.07C1.03,15.17 1.03,8.83 4.94,4.93C5.34,4.53 5.76,4.17 6.21,3.85C6.96,3.32 8.14,4.21 8.06,5.04C7.79,7.9 8.75,10.87 10.95,13.06C13.14,15.26 16.1,16.22 18.97,15.95M17.33,17.97C14.5,17.81 11.7,16.64 9.53,14.5C7.36,12.31 6.2,9.5 6.04,6.68C3.23,9.82 3.34,14.64 6.35,17.66C9.37,20.67 14.19,20.78 17.33,17.97Z" /></svg>
									</a>
								</li>
                            </ul>
                        </li>
                    </ul>
                <?php }else{ ?>
                    <ul class="right">
                        <li class="header_user">
                            <a href="javascript:void(0);" data-target="user_dropdown" class="dropdown-trigger btn-flat">
                                <img src="<?php echo $profile->avater->avater;?>" alt="<?php echo $profile->full_name;?>" />
                            </a>
                            <ul id="user_dropdown" class="dropdown-content">
                                <li>
                                    <a href="javascript:void(0);" onclick="logout()" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#F44336" d="M16.56,5.44L15.11,6.89C16.84,7.94 18,9.83 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12C6,9.83 7.16,7.94 8.88,6.88L7.44,5.44C5.36,6.88 4,9.28 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12C20,9.28 18.64,6.88 16.56,5.44M13,3H11V13H13" /></svg> <?php echo __( 'Log Out' );?></a>
                                </li>
                                <li class="divider" tabindex="-1"></li>
                                <li>
                                    <a href="javascript:void(0);" id="night_mode_toggle" data-night-text="<?php echo __('Night mode');?>" data-light-text="<?php echo __('Day mode');?>" data-mode='<?php echo Secure($config->nextmode) ?>'>
                                        <span><?php echo $config->nextmode_text;?></span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17.75,4.09L15.22,6.03L16.13,9.09L13.5,7.28L10.87,9.09L11.78,6.03L9.25,4.09L12.44,4L13.5,1L14.56,4L17.75,4.09M21.25,11L19.61,12.25L20.2,14.23L18.5,13.06L16.8,14.23L17.39,12.25L15.75,11L17.81,10.95L18.5,9L19.19,10.95L21.25,11M18.97,15.95C19.8,15.87 20.69,17.05 20.16,17.8C19.84,18.25 19.5,18.67 19.08,19.07C15.17,23 8.84,23 4.94,19.07C1.03,15.17 1.03,8.83 4.94,4.93C5.34,4.53 5.76,4.17 6.21,3.85C6.96,3.32 8.14,4.21 8.06,5.04C7.79,7.9 8.75,10.87 10.95,13.06C13.14,15.26 16.1,16.22 18.97,15.95M17.33,17.97C14.5,17.81 11.7,16.64 9.53,14.5C7.36,12.31 6.2,9.5 6.04,6.68C3.23,9.82 3.34,14.64 6.35,17.66C9.37,20.67 14.19,20.78 17.33,17.97Z" /></svg>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <?php }?>
            </div>
        </nav>
        <!-- End Header  -->

        <?php require( $theme_path . 'main' . $_DS . 'chat.php' );?>
