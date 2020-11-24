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
<script src="<?php echo $config->uri . '/admin-panel/plugins/tinymce/js/tinymce/tinymce.min.js'; ?>"></script>
<div class="container dt_user_profile_parent">
    <!-- display gps not enable message - see header js -->
    <div class="alert alert-warning hide" role="alert" id="gps_not_enabled">
        <p><?php echo __( 'Please Enable Location Services on your browser.' );?></p>
    </div>
    <script>
        var gps_not_enabled = document.querySelector('#gps_not_enabled');
        if( window.gps_is_not_enabled == true ){
            gps_not_enabled.classList.remove('hide');
        }
    </script>

    <div class="row">
		<div class="col m2"></div>
        <div class="col m8">
			<div class="center">
				<div class="qd_rstroy_thumbs">
                    <div class="avatar">
						<img src="<?php echo $data['story']['user1Data']->avater->avater;?>" alt="<?php echo $data['story']['user1Data']->full_name;?>" />
                    </div>
					<h5 class="truncate"><?php echo $data['story']['user1Data']->full_name;?></h5>
                </div>
				<div class="qd_rstroy_with"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" /></svg> <?php echo __('With');?></div>
				<div class="qd_rstroy_thumbs">
                    <div class="avatar">
						<img src="<?php echo $data['story']['user2Data']->avater->avater;?>" alt="<?php echo $data['story']['user2Data']->full_name;?>" />
                    </div>
					<h5 class="truncate"><?php echo $data['story']['user2Data']->full_name;?></h5>
                </div>
			</div>
			<div class="center qd_rstroy_quote">
				<h2><?php echo $data['story']['quote'];?></h2>
				<time><?php echo $data['story']['story_date'] ;?></time>
			</div>
            <div class="dt_sections qd_rstroy_content">
				<?php echo br2nl( html_entity_decode( $data['story']['description'] ));?>
			</div>
        </div>
		<div class="col m2"></div>
    </div>
</div>