<?php
global $db;
$views_count = 0;
$views = $db->objectBuilder()
    ->where('v.view_userid', $profile->id)
    ->groupBy('v.user_id')
    ->orderBy('v.created_at', 'DESC')
    ->get('views v', null, array('COUNT(DISTINCT v.user_id) AS views'));
if( $views !== null ){
    $views_count = COUNT($views);
}
$likes_count = $db->where('like_userid',$profile->id)->getOne('likes','count(id) as likes')['likes'];

?>

<div class="container dt_user_profile_parent find_matches_cont">
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

    <div class="row r_margin">
		<div class="col l3">
			<?php require( $theme_path . 'main' . $_DS . 'sidebar.php' );?>
		</div>
        <div class="col l9">
			<div class="valign-wrapper dt_home_rand_user qd_story_head">
				<h4 class="bold"><div style="background: #e935f8;"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M18,22A2,2 0 0,0 20,20V4C20,2.89 19.1,2 18,2H12V9L9.5,7.5L7,9V2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18Z"></path></svg></div> <?php echo __( 'success stories' );?></h4>
				<a class="btn btn_primary" href="<?php echo $site_url;?>/create-story/<?php echo $profile->username;?>" data-ajax="/create-story/<?php echo $profile->username;?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" /></svg> <?php echo __( 'Add New story' );?>
				</a>
			</div>
            <?php if(!empty($data['stories'])){ ?>
				<div class="row" id="success_stories_container">
					<?php echo $data['stories']; ?>
				</div>
				<?php if(!empty($data['stories'])){ ?>
					<a href="javascript:void(0);" id="btn_load_more_success_stories" data-lang-nomore="<?php echo __('No more stories to show.');?>" data-ajax-post="/loadmore/stories" data-ajax-params="page=2" data-ajax-callback="callback_load_more_success_stories" class="btn waves-effect load_more"><?php echo __('Load more...');?></a>
				<?php } ?>
            <?php }else{ ?>
                <div class="row" id="liked_users_container">
                    <h5 id="_load_more" class="empty_state">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15.5,12C18,12 20,14 20,16.5C20,17.38 19.75,18.21 19.31,18.9L22.39,22L21,23.39L17.88,20.32C17.19,20.75 16.37,21 15.5,21C13,21 11,19 11,16.5C11,14 13,12 15.5,12M15.5,14A2.5,2.5 0 0,0 13,16.5A2.5,2.5 0 0,0 15.5,19A2.5,2.5 0 0,0 18,16.5A2.5,2.5 0 0,0 15.5,14M6,22A2,2 0 0,1 4,20V4C4,2.89 4.9,2 6,2H7V9L9.5,7.5L12,9V2H18A2,2 0 0,1 20,4V11.81C18.83,10.69 17.25,10 15.5,10A6.5,6.5 0 0,0 9,16.5C9,18.81 10.21,20.85 12.03,22H6Z"></path></svg> <?php echo __('No more stories to show.');?>
                    </h5>
                </div>
            <?php }?>
        </div>
    </div>
</div>