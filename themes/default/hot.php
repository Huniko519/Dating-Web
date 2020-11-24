<?php global $db,$_LIBS; ?>
<!-- Pro Users  -->
<div class="container page-margin find_matches_cont">
    <div class="row r_margin">
		<div class="col l3">
			<?php require( $theme_path . 'main' . $_DS . 'sidebar.php' );?>
		</div>
        <div class="col l9">
			<?php
				if (IsThereAnnouncement() === true) {
				$announcement = GetHomeAnnouncements();
			?>
				<div class="home-announcement">
					<div class="alert alert-success" style="background-color: white;">
						<span class="close announcements-option" data-toggle="tooltip" onclick="Wo_ViewAnnouncement(<?php echo $announcement['id']; ?>);" title="<?php echo __('Hide');?>" style="float: right;cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"></path></svg></span>
						<?php echo $announcement['text']; ?>
					</div>
				</div>
				<!-- .home-announcement -->
			<?php } ?>

			<div class="dt_home_rand_user">
				<h4 class="bold"><div style="background: #f25e4e;"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M17.55,11.2C17.32,10.9 17.05,10.64 16.79,10.38C16.14,9.78 15.39,9.35 14.76,8.72C13.3,7.26 13,4.85 13.91,3C13,3.23 12.16,3.75 11.46,4.32C8.92,6.4 7.92,10.07 9.12,13.22C9.16,13.32 9.2,13.42 9.2,13.55C9.2,13.77 9.05,13.97 8.85,14.05C8.63,14.15 8.39,14.09 8.21,13.93C8.15,13.88 8.11,13.83 8.06,13.76C6.96,12.33 6.78,10.28 7.53,8.64C5.89,10 5,12.3 5.14,14.47C5.18,14.97 5.24,15.47 5.41,15.97C5.55,16.57 5.81,17.17 6.13,17.7C7.17,19.43 9,20.67 10.97,20.92C13.07,21.19 15.32,20.8 16.93,19.32C18.73,17.66 19.38,15 18.43,12.72L18.3,12.46C18.1,12 17.83,11.59 17.5,11.21L17.55,11.2M14.45,17.5C14.17,17.74 13.72,18 13.37,18.1C12.27,18.5 11.17,17.94 10.5,17.28C11.69,17 12.39,16.12 12.59,15.23C12.76,14.43 12.45,13.77 12.32,13C12.2,12.26 12.22,11.63 12.5,10.94C12.67,11.32 12.87,11.7 13.1,12C13.86,13 15.05,13.44 15.3,14.8C15.34,14.94 15.36,15.08 15.36,15.23C15.39,16.05 15.04,16.95 14.44,17.5H14.45Z"></path></svg></div> <?php echo __( 'HOT OR NOT' );?></h4>
			</div>
			
            <?php
                $warning_style='';
                $match_style='';
            ?>
            <!-- Match Users  -->
            <div id="section_match_users" class="<?php echo $match_style;?>">
                <?php
                if (empty($data['matches'])) {
                    echo '<h5 id="_load_more" class="empty_state"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9,4A4,4 0 0,1 13,8A4,4 0 0,1 9,12A4,4 0 0,1 5,8A4,4 0 0,1 9,4M9,6A2,2 0 0,0 7,8A2,2 0 0,0 9,10A2,2 0 0,0 11,8A2,2 0 0,0 9,6M9,13C11.67,13 17,14.34 17,17V20H1V17C1,14.34 6.33,13 9,13M9,14.9C6.03,14.9 2.9,16.36 2.9,17V18.1H15.1V17C15.1,16.36 11.97,14.9 9,14.9M15,4A4,4 0 0,1 19,8A4,4 0 0,1 15,12C14.53,12 14.08,11.92 13.67,11.77C14.5,10.74 15,9.43 15,8C15,6.57 14.5,5.26 13.67,4.23C14.08,4.08 14.53,4 15,4M23,17V20H19V16.5C19,15.25 18.24,14.1 16.97,13.18C19.68,13.62 23,14.9 23,17Z"></path></svg>' . __('No more users to show.') . '</h5>';
                } else {
                    ?>
                    <div class="valign-wrapper dt_home_match_user qd_hot_not">
                        <div class="mtc_usr_avtr" id="avaters_item_container">
                            <?php echo $data['matches_img']; ?>
                        </div>
                        <div class="mtc_usr_details" id="match_item_container">
                            <?php echo $data['matches']; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <a href="javascript:void(0);" style="display: none;" id="btn_load_more_match_users" data-lang-loadmore="<?php echo __('Load more...');?>" data-lang-nomore="<?php echo __('No more users to show.');?>" data-ajax-post="/loadmore/match_users" data-ajax-params="page=2" data-ajax-callback="callback_load_more_match_users" class="btn waves-effect load_more"><?php echo __('Load more...');?></a>
            <!-- End Match Users  -->
        </div>
        <!-- End Search Users  -->
    </div>
</div>
<a href="javascript:void(0);" id="btnHotRedirect" data-ajax="/hot" style="visibility: hidden;display: none;"></a>
<script>
    function Wo_ViewAnnouncement(id) {
        var announcement_container = $('.home-announcement');
        $.get(window.ajax + 'useractions/UpdateAnnouncementViews', {id:id}, function (data) {
            if (data.status == 200) {
                announcement_container.slideUp(200, function () {
                    $(this).remove();
                });
            }
        });
    }
</script>