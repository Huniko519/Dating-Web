<div class="dt_sections home_short_links">
	<ul class="home_usr_sct">
		<li>
            <div class="user_popularity_icn" data-value="<?php echo GetUserPopularity($profile->id,true);?>">
                <svg width="90px" height="90px" viewBox="0 0 80 80">
                    <path class="load-bg cir1" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"></path>
                    <path id="load-line1" class="load-circle" style="stroke-dashoffset: 192.6168975830078px; stroke-dasharray: 192.6168975830078px;stroke:<?php echo GetUserPopularity($profile->id,false,true);?>" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z" ></path></svg>
                <a class="avatar" href="<?php echo $site_url;?>/@<?php echo $profile->username;?>" data-ajax="/@<?php echo $profile->username;?>"><img src="<?php echo $profile->avater->avater;?>" class="circle" alt="<?php echo $profile->full_name;?>" /></a>
            </div>
			<span>
				<h3><a href="<?php echo $site_url;?>/@<?php echo $profile->username;?>" data-ajax="/@<?php echo $profile->username;?>"><?php echo $profile->full_name;?></a></h3>
				<p><a href="<?php echo $site_url;?>/popularity" data-ajax="/popularity"><?php echo __( 'Popularity' );?>: <b><?php echo GetUserPopularity($profile->id);?></b></a></p>
			</span>
		</li>
		<li>
			<a href="<?php echo $site_url;?>/popularity" data-ajax="/popularity" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M13,20H11V8L5.5,13.5L4.08,12.08L12,4.16L19.92,12.08L18.5,13.5L13,8V20Z" /></svg> <?php echo __( 'Increase' );?> <?php echo __( 'Popularity' );?></a>
		</li>
	</ul>
	<ul class="home_usr_link">
		<li class="dt_lside_extra_menu">
			<a href="<?php echo $site_url;?>/credit" data-ajax="/credit" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M11,17V16H9V14H13V13H10A1,1 0 0,1 9,12V9A1,1 0 0,1 10,8H11V7H13V8H15V10H11V11H14A1,1 0 0,1 15,12V15A1,1 0 0,1 14,16H13V17H11Z"></path></svg> <?php echo (int)$profile->balance;?> <?php echo __( 'Credits' );?></a>
		</li>
		<?php if( $profile->is_pro <> 1 ) { ?>
			<li class="dt_lside_extra_menu">
				<a href="<?php echo $site_url;?>/pro" data-ajax="/pro" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M16,9H19L14,16M10,9H14L12,17M5,9H8L10,16M15,4H17L19,7H16M11,4H13L14,7H10M7,4H9L8,7H5M6,2L2,8L12,22L22,8L18,2H6Z" /></svg> <?php echo __( 'Premium' );?></a>
			</li>
		<?php } ?>
		<li class="divider dt_lside_extra_menu" tabindex="-1"></li>
		<li class="fnd <?php if($data['name'] == 'find-matches'){ echo 'active';}?>">
			<a href="<?php echo $site_url;?>/find-matches" data-ajax="/find-matches"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M15.6,8.34C16.67,8.34 17.53,9.2 17.53,10.27C17.53,11.34 16.67,12.2 15.6,12.2A1.93,1.93 0 0,1 13.67,10.27C13.66,9.2 14.53,8.34 15.6,8.34M9.6,6.76C10.9,6.76 11.96,7.82 11.96,9.12C11.96,10.42 10.9,11.5 9.6,11.5C8.3,11.5 7.24,10.42 7.24,9.12C7.24,7.81 8.29,6.76 9.6,6.76M9.6,15.89V19.64C7.2,18.89 5.3,17.04 4.46,14.68C5.5,13.56 8.13,13 9.6,13C10.13,13 10.8,13.07 11.5,13.21C9.86,14.08 9.6,15.23 9.6,15.89M12,20C11.72,20 11.46,20 11.2,19.96V15.89C11.2,14.47 14.14,13.76 15.6,13.76C16.67,13.76 18.5,14.15 19.44,14.91C18.27,17.88 15.38,20 12,20Z" /></svg> <?php echo __( 'Find Matches' );?></a>
		</li>
		<li class="mch <?php if($data['name'] == 'matches'){ echo 'active';}?>">
			<a href="<?php echo $site_url;?>/matches" data-ajax="/matches"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M22.59,7.92L23.75,9.33L19,14.08L16.25,11.08L17.41,9.92L19,11.5L22.59,7.92M6,5A3,3 0 0,1 9,8A3,3 0 0,1 6,11A3,3 0 0,1 3,8A3,3 0 0,1 6,5M11,5A3,3 0 0,1 14,8A3,3 0 0,1 11,11C10.68,11 10.37,10.95 10.08,10.85C10.65,10.04 11,9.06 11,8C11,6.94 10.65,5.95 10.08,5.14C10.37,5.05 10.68,5 11,5M6,13C8,13 12,14 12,16V18H0V16C0,14 4,13 6,13M12.62,13.16C14.63,13.5 17,14.46 17,16V18H14V16C14,14.82 13.45,13.88 12.62,13.16Z" /></svg> <?php echo __( 'Matches' );?></a>
		</li>
		<li class="vis <?php if($data['name'] == 'visits'){ echo 'active';}?>">
			<a href="<?php echo $site_url;?>/visits" data-ajax="/visits"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z" /></svg> <?php echo __( 'Visits' );?></a>
		</li>
        <?php if( $config->connectivitySystem == '1' ){?>
        <li class="pli <?php if($data['name'] == 'friends'){ echo 'active';}?>">
            <a href="<?php echo $site_url;?>/friends" data-ajax="/friends"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M16.5,12A2.5,2.5 0 0,0 19,9.5A2.5,2.5 0 0,0 16.5,7A2.5,2.5 0 0,0 14,9.5A2.5,2.5 0 0,0 16.5,12M9,11A3,3 0 0,0 12,8A3,3 0 0,0 9,5A3,3 0 0,0 6,8A3,3 0 0,0 9,11M16.5,14C14.67,14 11,14.92 11,16.75V19H22V16.75C22,14.92 18.33,14 16.5,14M9,13C6.67,13 2,14.17 2,16.5V19H9V16.75C9,15.9 9.33,14.41 11.37,13.28C10.5,13.1 9.66,13 9,13Z" /></svg> <?php echo __( 'Friends' );?></a>
        </li>
        <?php } ?>
		<li class="divider" tabindex="-1"></li>
        <li class="lik <?php if($data['name'] == 'gifts'){ echo 'active';}?>">
            <a href="<?php echo $site_url;?>/gifts" data-ajax="/gifts"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9.06,1.93C7.17,1.92 5.33,3.74 6.17,6H3A2,2 0 0,0 1,8V10A1,1 0 0,0 2,11H11V8H13V11H22A1,1 0 0,0 23,10V8A2,2 0 0,0 21,6H17.83C19,2.73 14.6,0.42 12.57,3.24L12,4L11.43,3.22C10.8,2.33 9.93,1.94 9.06,1.93M9,4C9.89,4 10.34,5.08 9.71,5.71C9.08,6.34 8,5.89 8,5A1,1 0 0,1 9,4M15,4C15.89,4 16.34,5.08 15.71,5.71C15.08,6.34 14,5.89 14,5A1,1 0 0,1 15,4M2,12V20A2,2 0 0,0 4,22H20A2,2 0 0,0 22,20V12H13V20H11V12H2Z"></path></svg> <?php echo __( 'Gifts' );?></a>
        </li>
		<li class="lik <?php if($data['name'] == 'likes'){ echo 'active';}?>">
			<a href="<?php echo $site_url;?>/likes" data-ajax="/likes"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" /></svg> <?php echo __( 'Likes' );?></a>
		</li>
		<li class="pli <?php if($data['name'] == 'liked'){ echo 'active';}?>">
			<a href="<?php echo $site_url;?>/liked" data-ajax="/liked"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15,14C12.3,14 7,15.3 7,18V20H23V18C23,15.3 17.7,14 15,14M15,12A4,4 0 0,0 19,8A4,4 0 0,0 15,4A4,4 0 0,0 11,8A4,4 0 0,0 15,12M5,15L4.4,14.5C2.4,12.6 1,11.4 1,9.9C1,8.7 2,7.7 3.2,7.7C3.9,7.7 4.6,8 5,8.5C5.4,8 6.1,7.7 6.8,7.7C8,7.7 9,8.6 9,9.9C9,11.4 7.6,12.6 5.6,14.5L5,15Z" /></svg> <?php echo __( 'People i liked' );?></a>
		</li>
		<li class="dis <?php if($data['name'] == 'disliked'){ echo 'active';}?>">
			<a href="<?php echo $site_url;?>/disliked" data-ajax="/disliked"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19,15H23V3H19M15,3H6C5.17,3 4.46,3.5 4.16,4.22L1.14,11.27C1.05,11.5 1,11.74 1,12V14A2,2 0 0,0 3,16H9.31L8.36,20.57C8.34,20.67 8.33,20.77 8.33,20.88C8.33,21.3 8.5,21.67 8.77,21.94L9.83,23L16.41,16.41C16.78,16.05 17,15.55 17,15V5C17,3.89 16.1,3 15,3Z" /></svg> <?php echo __( 'People i disliked' );?></a>
		</li>
        <?php if( $config->connectivitySystem == '1' ){?>
        <li class="pli <?php if($data['name'] == 'friend-requests'){ echo 'active';}?>">
            <a href="<?php echo $site_url;?>/friend-requests" data-ajax="/friend-requests"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15,14C12.33,14 7,15.33 7,18V20H23V18C23,15.33 17.67,14 15,14M6,10V7H4V10H1V12H4V15H6V12H9V10M15,12A4,4 0 0,0 19,8A4,4 0 0,0 15,4A4,4 0 0,0 11,8A4,4 0 0,0 15,12Z" /></svg> <?php echo __( 'Friend requests' );?></a>
        </li>
        <?php } ?>
		<li class="lik <?php if($data['name'] == 'hot'){ echo 'active';}?>">
			<a href="<?php echo $site_url;?>/hot" data-ajax="/hot">
                <?php if( $config->is_rtl === true ){?>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="width: 20px;height: 20px;"><path fill="currentColor" d="M17.55,11.2C17.32,10.9 17.05,10.64 16.79,10.38C16.14,9.78 15.39,9.35 14.76,8.72C13.3,7.26 13,4.85 13.91,3C13,3.23 12.16,3.75 11.46,4.32C8.92,6.4 7.92,10.07 9.12,13.22C9.16,13.32 9.2,13.42 9.2,13.55C9.2,13.77 9.05,13.97 8.85,14.05C8.63,14.15 8.39,14.09 8.21,13.93C8.15,13.88 8.11,13.83 8.06,13.76C6.96,12.33 6.78,10.28 7.53,8.64C5.89,10 5,12.3 5.14,14.47C5.18,14.97 5.24,15.47 5.41,15.97C5.55,16.57 5.81,17.17 6.13,17.7C7.17,19.43 9,20.67 10.97,20.92C13.07,21.19 15.32,20.8 16.93,19.32C18.73,17.66 19.38,15 18.43,12.72L18.3,12.46C18.1,12 17.83,11.59 17.5,11.21L17.55,11.2M14.45,17.5C14.17,17.74 13.72,18 13.37,18.1C12.27,18.5 11.17,17.94 10.5,17.28C11.69,17 12.39,16.12 12.59,15.23C12.76,14.43 12.45,13.77 12.32,13C12.2,12.26 12.22,11.63 12.5,10.94C12.67,11.32 12.87,11.7 13.1,12C13.86,13 15.05,13.44 15.3,14.8C15.34,14.94 15.36,15.08 15.36,15.23C15.39,16.05 15.04,16.95 14.44,17.5H14.45Z" /></svg>
                <?php } else { ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="width: 20px;height: 20px;margin: auto 12px 0 -1px;"><path fill="currentColor" d="M17.55,11.2C17.32,10.9 17.05,10.64 16.79,10.38C16.14,9.78 15.39,9.35 14.76,8.72C13.3,7.26 13,4.85 13.91,3C13,3.23 12.16,3.75 11.46,4.32C8.92,6.4 7.92,10.07 9.12,13.22C9.16,13.32 9.2,13.42 9.2,13.55C9.2,13.77 9.05,13.97 8.85,14.05C8.63,14.15 8.39,14.09 8.21,13.93C8.15,13.88 8.11,13.83 8.06,13.76C6.96,12.33 6.78,10.28 7.53,8.64C5.89,10 5,12.3 5.14,14.47C5.18,14.97 5.24,15.47 5.41,15.97C5.55,16.57 5.81,17.17 6.13,17.7C7.17,19.43 9,20.67 10.97,20.92C13.07,21.19 15.32,20.8 16.93,19.32C18.73,17.66 19.38,15 18.43,12.72L18.3,12.46C18.1,12 17.83,11.59 17.5,11.21L17.55,11.2M14.45,17.5C14.17,17.74 13.72,18 13.37,18.1C12.27,18.5 11.17,17.94 10.5,17.28C11.69,17 12.39,16.12 12.59,15.23C12.76,14.43 12.45,13.77 12.32,13C12.2,12.26 12.22,11.63 12.5,10.94C12.67,11.32 12.87,11.7 13.1,12C13.86,13 15.05,13.44 15.3,14.8C15.34,14.94 15.36,15.08 15.36,15.23C15.39,16.05 15.04,16.95 14.44,17.5H14.45Z" /></svg>
                <?php } ?>
                <?php echo __( 'HOT OR NOT' );?>
            </a>
		</li>
		<li class="divider dt_lside_extra_menu" tabindex="-1"></li>
		<li class="dt_lside_extra_menu">
			<a href="<?php echo $site_url;?>/settings/<?php echo $profile->username;?>" data-ajax="/settings/<?php echo $profile->username;?>" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,15.5A3.5,3.5 0 0,1 8.5,12A3.5,3.5 0 0,1 12,8.5A3.5,3.5 0 0,1 15.5,12A3.5,3.5 0 0,1 12,15.5M19.43,12.97C19.47,12.65 19.5,12.33 19.5,12C19.5,11.67 19.47,11.34 19.43,11L21.54,9.37C21.73,9.22 21.78,8.95 21.66,8.73L19.66,5.27C19.54,5.05 19.27,4.96 19.05,5.05L16.56,6.05C16.04,5.66 15.5,5.32 14.87,5.07L14.5,2.42C14.46,2.18 14.25,2 14,2H10C9.75,2 9.54,2.18 9.5,2.42L9.13,5.07C8.5,5.32 7.96,5.66 7.44,6.05L4.95,5.05C4.73,4.96 4.46,5.05 4.34,5.27L2.34,8.73C2.21,8.95 2.27,9.22 2.46,9.37L4.57,11C4.53,11.34 4.5,11.67 4.5,12C4.5,12.33 4.53,12.65 4.57,12.97L2.46,14.63C2.27,14.78 2.21,15.05 2.34,15.27L4.34,18.73C4.46,18.95 4.73,19.03 4.95,18.95L7.44,17.94C7.96,18.34 8.5,18.68 9.13,18.93L9.5,21.58C9.54,21.82 9.75,22 10,22H14C14.25,22 14.46,21.82 14.5,21.58L14.87,18.93C15.5,18.67 16.04,18.34 16.56,17.94L19.05,18.95C19.27,19.03 19.54,18.95 19.66,18.73L21.66,15.27C21.78,15.05 21.73,14.78 21.54,14.63L19.43,12.97Z" /></svg> <?php echo __( 'Settings' );?></a>
		</li>
		<li class="dt_lside_extra_menu">
			<a href="<?php echo $site_url;?>/transactions" data-ajax="/transactions" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15,14V11H18V9L22,12.5L18,16V14H15M14,7.7V9H2V7.7L8,4L14,7.7M7,10H9V15H7V10M3,10H5V15H3V10M13,10V12.5L11,14.3V10H13M9.1,16L8.5,16.5L10.2,18H2V16H9.1M17,15V18H14V20L10,16.5L14,13V15H17Z" /></svg> <?php echo __( 'Transactions' );?></a>
		</li>
		<?php if( $profile->admin == 1 ){ ?>
			<li class="divider dt_lside_extra_menu" tabindex="-1"></li>
			<li class="dt_lside_extra_menu">
				<a href="<?php echo $site_url;?>/admin-panel" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z" /></svg> <?php echo __( 'Admin Panel' );?></a>
			</li>
		<?php } ?>
		<li class="divider dt_lside_extra_menu" tabindex="-1"></li>
		<li class="dt_lside_extra_menu">
			<a href="javascript:void(0);" onclick="logout()" class="waves-effect"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#F44336" d="M16.56,5.44L15.11,6.89C16.84,7.94 18,9.83 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12C6,9.83 7.16,7.94 8.88,6.88L7.44,5.44C5.36,6.88 4,9.28 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12C20,9.28 18.64,6.88 16.56,5.44M13,3H11V13H13" /></svg> <?php echo __( 'Log Out' );?></a>
		</li>
		<li class="divider dt_lside_extra_menu" tabindex="-1"></li>
		<li class="dt_lside_extra_menu">
			<a href="javascript:void(0);" id="night_mode_toggle_sidebar" data-night-text="<?php echo __('Night mode');?>" data-light-text="<?php echo __('Day mode');?>" data-mode='<?php echo Secure($config->nextmode) ?>'>
				<span><?php echo $config->nextmode_text;?></span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17.75,4.09L15.22,6.03L16.13,9.09L13.5,7.28L10.87,9.09L11.78,6.03L9.25,4.09L12.44,4L13.5,1L14.56,4L17.75,4.09M21.25,11L19.61,12.25L20.2,14.23L18.5,13.06L16.8,14.23L17.39,12.25L15.75,11L17.81,10.95L18.5,9L19.19,10.95L21.25,11M18.97,15.95C19.8,15.87 20.69,17.05 20.16,17.8C19.84,18.25 19.5,18.67 19.08,19.07C15.17,23 8.84,23 4.94,19.07C1.03,15.17 1.03,8.83 4.94,4.93C5.34,4.53 5.76,4.17 6.21,3.85C6.96,3.32 8.14,4.21 8.06,5.04C7.79,7.9 8.75,10.87 10.95,13.06C13.14,15.26 16.1,16.22 18.97,15.95M17.33,17.97C14.5,17.81 11.7,16.64 9.53,14.5C7.36,12.31 6.2,9.5 6.04,6.68C3.23,9.82 3.34,14.64 6.35,17.66C9.37,20.67 14.19,20.78 17.33,17.97Z" /></svg>
			</a>
		</li>
	</ul>
</div>

<?php if( $config->pro_system == 1 ){ ?>
<div class="dt_sections">
	<?php
		$pro_users = ProUsers();
		if( count((array)$pro_users) > 0){
	?>
		<div class="dt_home_pro_usr">
			<h4 class="bold">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" /></svg>

                <?php if( $config->pro_system == 1 ) { ?>
                    <?php echo __( 'Premium Users' );?>
                <?php } else{ ?>
                    <?php echo __( 'Latest Users' );?>
                <?php } ?>
            </h4>
			<div>
				<div class="pro_usrs_container">
					<?php if( $profile->is_pro == 0 && isGenderFree($profile->gender) === false ){?>
						<div class="pro_usr add_me">
							<a href="<?php echo $site_url;?>/pro" data-ajax="/pro" class="pulse">
								<img src="<?php echo $profile->avater->avater;?>" alt="<?php echo $profile->full_name;?>" />
								<span class="add_icon" tooltip="<?php echo __( 'Add Me' );?>" flow="down">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" /></svg>
								</span>
							</a>
						</div>
					<?php } ?>
					<?php
						if( $pro_users ){
							foreach ($pro_users as $key => $pro_user ){
					?>
						<div class="pro_usr">
							<a href="<?php echo $site_url;?>/@<?php echo $pro_user->username;?>" data-ajax="/@<?php echo $pro_user->username;?>" tooltip="<?php echo $pro_user->username;?>" flow="down">
								<img src="<?php echo GetMedia( $pro_user->avater );?>" alt="<?php echo $pro_user->username;?>" />
							</a>
						</div>
					<?php } } ?>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="dt_home_pro_usr">
			<h4 class="bold">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" /></svg>

                <?php if( $config->pro_system == 1 ) { ?>
                    <?php echo __( 'Premium Users' );?>
                <?php } else { ?>
                    <?php echo __( 'Latest Users' );?>
                <?php } ?>
            </h4>
			<div class="pro_usrs_container">
				<?php if( $profile->is_pro == 0){?>
					<div class="pro_usr add_me">
						<a href="<?php echo $site_url;?>/pro" data-ajax="/pro" class="pulse">
							<img src="<?php echo $profile->avater->avater;?>" alt="<?php echo $profile->full_name;?>" />
							<span class="add_icon" tooltip="<?php echo __( 'Add Me' );?>" flow="down">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" /></svg>
							</span>
						</a>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
</div>
<?php } ?>
<?php echo GetAd('home_side_bar');?>