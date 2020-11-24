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
					<h4 class="bold"><div style="background: #f25e4e;"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M14,10H2V12H14V10M14,6H2V8H14V6M2,16H10V14H2V16M21.5,11.5L23,13L16,20L11.5,15.5L13,14L16,17L21.5,11.5Z"></path></svg></div> <?php echo __( 'People who are interested in : ' ) . ' '. route(2);?></h4>
					<div class="row" id="interest_container">
                        <?php
                            if(empty($data['interest'])){
                                echo '<h5 id="_load_more" class="empty_state"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9,4A4,4 0 0,1 13,8A4,4 0 0,1 9,12A4,4 0 0,1 5,8A4,4 0 0,1 9,4M9,6A2,2 0 0,0 7,8A2,2 0 0,0 9,10A2,2 0 0,0 11,8A2,2 0 0,0 9,6M9,13C11.67,13 17,14.34 17,17V20H1V17C1,14.34 6.33,13 9,13M9,14.9C6.03,14.9 2.9,16.36 2.9,17V18.1H15.1V17C15.1,16.36 11.97,14.9 9,14.9M15,4A4,4 0 0,1 19,8A4,4 0 0,1 15,12C14.53,12 14.08,11.92 13.67,11.77C14.5,10.74 15,9.43 15,8C15,6.57 14.5,5.26 13.67,4.23C14.08,4.08 14.53,4 15,4M23,17V20H19V16.5C19,15.25 18.24,14.1 16.97,13.18C19.68,13.62 23,14.9 23,17Z"></path></svg>'.__('No interested people found.') .'</h5>';
                            }else {
                                echo $data['interest'];
                            }
                        ?>
					</div>
                    <?php if(!empty($data['interest'])){ ?>
                        <a href="javascript:void(0);" id="btn_load_more_interest" data-lang-nomore="<?php echo __('No interested people found.');?>" data-ajax-post="/loadmore/interest" data-ajax-params="page=2&tags=<?php echo route(2);?>" data-ajax-callback="callback_load_more_interest" class="btn waves-effect load_more"><?php echo __('Load more...');?></a>
                    <?php }?>
                </div>
            </div>
        </div>
<!-- Interest -->
    </div>
</div>