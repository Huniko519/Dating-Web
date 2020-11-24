<?php global $site_url;?>
<div class="col l3 m4 s6 xs12 random_user_item" data-uid="<?php echo $random_user->id;?>">
    <div class="card center">
        <div class="card-image">
            <a href="<?php echo $site_url;?>/@<?php echo $random_user->username;?>" data-ajax="/@<?php echo $random_user->username;?>">
                <img src="<?php echo GetMedia('',false) . $random_user->avater;?>" alt="<?php echo $random_user->username;?>">
                <?php if((int)abs(((strtotime(date('Y-m-d H:i:s')) - $random_user->lastseen))) < 60 && (int)$random_user->online == 1) { echo '<div class="useronline"></div>'; }?>
            </a>
        </div>
        <div class="card-content">
            <a href="<?php echo $site_url;?>/@<?php echo $random_user->username;?>" data-ajax="/@<?php echo $random_user->username;?>"><span class="card-title"><?php echo ($random_user->first_name !== '' ) ? $random_user->first_name . ' ' . $random_user->last_name : $random_user->username;?></span></a>
            <p><?php echo udetails($random_user);?></p>
            <?php echo '&nbsp;&nbsp;' . __($random_user->gender);?>

            <?php
            if( (int)$random_user->id !== (int)auth()->id ){ ?>
            <div class="rand_bottom_bar">
                <button class="btn waves-effect like" id="like_btn" data-userid="<?php echo $random_user->id;?>" data-ajax-post="/useractions/like" data-ajax-params="userid=<?php echo $random_user->id;?>&username=<?php echo $random_user->username;?>" data-ajax-callback="callback_like">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z"/></svg>
                </button>
                <button class="btn waves-effect dislike _dislike_text<?php echo $random_user->id;?>" data-userid="<?php echo $random_user->id;?>" id="dislike_btn" data-ajax-post="/useractions/dislike" data-ajax-params="userid=<?php echo $random_user->id;?>" data-ajax-callback="callback_dislike">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/></svg>
                </button>
            </div>
            <?php } ?>

        </div>
    </div>
</div>