<?php global $db,$_LIBS; ?>
<div class="container page-margin find_matches_cont">
    <div class="row r_margin">
        <div class="col l3">
            <?php require( $theme_path . 'main' . $_DS . 'sidebar.php' );?>
        </div>

        <div class="col l9">
            <!-- People i liked  -->
            <div class="container-fluid dt_ltst_users">
                <div class="dt_home_rand_user">
                    <h4 class="bold"><div style="background: #f25e4e;"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z"></path></svg></div> <?php echo __( 'Likes' );?></h4>
                    <div class="row" id="likes_users_container">
                    <?php if( ( (int)auth()->is_pro == 1 || $config->pro_system == 0 ) || isGenderFree((int)auth()->gender) === true){?>
                        <?php
                        if(empty($data['likes'])){
                            echo '<h5 id="_load_more" class="empty_state"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9,4A4,4 0 0,1 13,8A4,4 0 0,1 9,12A4,4 0 0,1 5,8A4,4 0 0,1 9,4M9,6A2,2 0 0,0 7,8A2,2 0 0,0 9,10A2,2 0 0,0 11,8A2,2 0 0,0 9,6M9,13C11.67,13 17,14.34 17,17V20H1V17C1,14.34 6.33,13 9,13M9,14.9C6.03,14.9 2.9,16.36 2.9,17V18.1H15.1V17C15.1,16.36 11.97,14.9 9,14.9M15,4A4,4 0 0,1 19,8A4,4 0 0,1 15,12C14.53,12 14.08,11.92 13.67,11.77C14.5,10.74 15,9.43 15,8C15,6.57 14.5,5.26 13.67,4.23C14.08,4.08 14.53,4 15,4M23,17V20H19V16.5C19,15.25 18.24,14.1 16.97,13.18C19.68,13.62 23,14.9 23,17Z"></path></svg>'.__('No more users to show.') .'</h5>';
                        }else {
                            echo $data['likes'];
                        }
                        ?>
                    </div>

                    <?php if(!empty($data['likes'])){ ?>
                        <a href="javascript:void(0);" id="btn_load_more_likes_users" data-lang-nomore="<?php echo __('No more users to show.');?>" data-ajax-post="/loadmore/likes_users" data-ajax-params="page=2" data-ajax-callback="callback_load_more_likes_users" class="btn waves-effect load_more"><?php echo __('Load more...');?></a>
                    <?php }?>


                    <?php }else{ ?>
                        <h5 id="_load_more" class="empty_state">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9,4A4,4 0 0,1 13,8A4,4 0 0,1 9,12A4,4 0 0,1 5,8A4,4 0 0,1 9,4M9,6A2,2 0 0,0 7,8A2,2 0 0,0 9,10A2,2 0 0,0 11,8A2,2 0 0,0 9,6M9,13C11.67,13 17,14.34 17,17V20H1V17C1,14.34 6.33,13 9,13M9,14.9C6.03,14.9 2.9,16.36 2.9,17V18.1H15.1V17C15.1,16.36 11.97,14.9 9,14.9M15,4A4,4 0 0,1 19,8A4,4 0 0,1 15,12C14.53,12 14.08,11.92 13.67,11.77C14.5,10.74 15,9.43 15,8C15,6.57 14.5,5.26 13.67,4.23C14.08,4.08 14.53,4 15,4M23,17V20H19V16.5C19,15.25 18.24,14.1 16.97,13.18C19.68,13.62 23,14.9 23,17Z"></path></svg>
                            <?php echo __('Get premium to view who liked you!');?>
                            <br><br><br>
                            <a href="<?php echo $site_url;?>/pro" data-ajax="/pro" class="prema"><span><?php echo __( 'Premium' );?></span></a>
                        </h5>
                    <?php }?>
                </div>
            </div>
            <!-- People i liked -->
        </div>
    </div>
</div>