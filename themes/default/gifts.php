<?php global $db,$_LIBS; ?>
<div class="container page-margin find_matches_cont">
    <div class="row r_margin">
        <div class="col l3">
            <?php require( $theme_path . 'main' . $_DS . 'sidebar.php' );?>
        </div>

        <div class="col l9">
            <!-- People i liked  -->
            <div class="container-fluid">
                <div class="dt_home_rand_user">
                    <h4 class="bold"><div style="background: #f25e4e;"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M9.06,1.93C7.17,1.92 5.33,3.74 6.17,6H3A2,2 0 0,0 1,8V10A1,1 0 0,0 2,11H11V8H13V11H22A1,1 0 0,0 23,10V8A2,2 0 0,0 21,6H17.83C19,2.73 14.6,0.42 12.57,3.24L12,4L11.43,3.22C10.8,2.33 9.93,1.94 9.06,1.93M9,4C9.89,4 10.34,5.08 9.71,5.71C9.08,6.34 8,5.89 8,5A1,1 0 0,1 9,4M15,4C15.89,4 16.34,5.08 15.71,5.71C15.08,6.34 14,5.89 14,5A1,1 0 0,1 15,4M2,12V20A2,2 0 0,0 4,22H20A2,2 0 0,0 22,20V12H13V20H11V12H2Z"></path></svg></div> <?php echo __( 'Gifts' );?></h4>
                    <div class="row" id="likes_users_container">
                        <?php
                        if(empty($data['gifts'])){
                            echo '<h5 id="_load_more" class="empty_state"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9.06,1.93C7.17,1.92 5.33,3.74 6.17,6H3A2,2 0 0,0 1,8V10A1,1 0 0,0 2,11H11V8H13V11H22A1,1 0 0,0 23,10V8A2,2 0 0,0 21,6H17.83C19,2.73 14.6,0.42 12.57,3.24L12,4L11.43,3.22C10.8,2.33 9.93,1.94 9.06,1.93M9,4C9.89,4 10.34,5.08 9.71,5.71C9.08,6.34 8,5.89 8,5A1,1 0 0,1 9,4M15,4C15.89,4 16.34,5.08 15.71,5.71C15.08,6.34 14,5.89 14,5A1,1 0 0,1 15,4M2,12V20A2,2 0 0,0 4,22H20A2,2 0 0,0 22,20V12H13V20H11V12H2Z"></path></svg>'.__('No more gifts to show.') .'</h5>';
                        }else {
                            echo $data['gifts'];
                        }
                        ?>
                    </div>
                    <?php if(!empty($data['gifts'])){ ?>
                        <a href="javascript:void(0);" id="btn_load_more_gifts_users" data-lang-nomore="<?php echo __('No more gifts to show.');?>" data-ajax-post="/loadmore/gifts_users" data-ajax-params="page=2" data-ajax-callback="callback_load_more_gifts_users" class="btn waves-effect load_more"><?php echo __('Load more...');?></a>
                    <?php } ?>
                </div>
            </div>
            <!-- People i liked -->
        </div>
    </div>
</div>