<?php global $db,$_LIBS; ?>
<div class="container page-margin find_matches_cont">
	<div class="row r_margin">
		<div class="col l3">
			<?php require( $theme_path . 'main' . $_DS . 'sidebar.php' );?>
		</div>
	
		<div class="col l9">
			<!-- Interest -->
			<div class="container-fluid dt_ltst_users">
				<div class="dt_home_rand_user">
					<h4 class="bold"><div style="background: #8bc34a;"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M22.59,7.92L23.75,9.33L19,14.08L16.25,11.08L17.41,9.92L19,11.5L22.59,7.92M6,5A3,3 0 0,1 9,8A3,3 0 0,1 6,11A3,3 0 0,1 3,8A3,3 0 0,1 6,5M11,5A3,3 0 0,1 14,8A3,3 0 0,1 11,11C10.68,11 10.37,10.95 10.08,10.85C10.65,10.04 11,9.06 11,8C11,6.94 10.65,5.95 10.08,5.14C10.37,5.05 10.68,5 11,5M6,13C8,13 12,14 12,16V18H0V16C0,14 4,13 6,13M12.62,13.16C14.63,13.5 17,14.46 17,16V18H14V16C14,14.82 13.45,13.88 12.62,13.16Z"></path></svg></div> <?php echo __( 'Matches' );?></h4>
					<div class="row" id="matches_container" data-nomore="<?php echo __('No more users to show.');?>">
                        <?php
                        if(empty($data['matches'])){
                            echo '<h5 id="_load_more" class="empty_state"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9,4A4,4 0 0,1 13,8A4,4 0 0,1 9,12A4,4 0 0,1 5,8A4,4 0 0,1 9,4M9,6A2,2 0 0,0 7,8A2,2 0 0,0 9,10A2,2 0 0,0 11,8A2,2 0 0,0 9,6M9,13C11.67,13 17,14.34 17,17V20H1V17C1,14.34 6.33,13 9,13M9,14.9C6.03,14.9 2.9,16.36 2.9,17V18.1H15.1V17C15.1,16.36 11.97,14.9 9,14.9M15,4A4,4 0 0,1 19,8A4,4 0 0,1 15,12C14.53,12 14.08,11.92 13.67,11.77C14.5,10.74 15,9.43 15,8C15,6.57 14.5,5.26 13.67,4.23C14.08,4.08 14.53,4 15,4M23,17V20H19V16.5C19,15.25 18.24,14.1 16.97,13.18C19.68,13.62 23,14.9 23,17Z"></path></svg>'.__('No more users to show.') .'</h5>';
                        }else {
                            echo $data['matches'];
                        }
                        ?>
					</div>
                    <?php if(!empty($data['matches'])){ ?>
                        <a href="javascript:void(0);" id="btn_load_more_matches" data-lang-nomore="<?php echo __('No more users to show.');?>" data-ajax-post="/loadmore/matches" data-ajax-params="page=2&tags=<?php echo route(2);?>" data-ajax-callback="callback_load_more_matches" class="btn waves-effect load_more"><?php echo __('Load more...');?></a>
                    <?php }?>
                </div>
			</div>
			<!-- Interest -->
		</div>
	</div>
</div>