<?php global $site_url;?>
<div class="col l3 m4 s6 xs12" data-matches-uid="<?php echo $row->id?>">
    <div class="card center">
        <div class="card-image">
            <a href="<?php echo $site_url;?>/@<?php echo $row->username?>" data-ajax="/@<?php echo $row->username?>">
                <img src="<?php echo GetMedia('',false); ?><?php echo $row->avater?>" alt="<?php echo $row->username?>">
                <?php if((int)abs(((strtotime(date('Y-m-d H:i:s')) - $row->lastseen))) < 60 && (int)$row->online == 1) { echo '<div class="useronline"></div>'; }?>
            </a>
        </div>
        <div class="card-content">
            <a href="<?php echo $site_url;?>/@<?php echo $row->username?>" data-ajax="/@<?php echo $row->username?>"><span class="card-title"><?php echo ($row->first_name !== '' ) ? $row->first_name . ' ' . $row->last_name : $row->username;?></span></a>
            <p>
                <span class="time ajax-time age" title="<?php echo $row->created_at;?>"><?php echo get_time_ago( $row->created_at );?></span>
                <?php echo $row->country_txt?>
            </p>
            <div class="rand_bottom_bar">
                <?php if( (int)$row->id !== (int)auth()->id ){ ?>
                <button id="like_btn<?php echo $row->id;?>" data-userid="<?php echo $row->id;?>" class="btn waves-effect like" data-ajax-post="/useractions/unmatche" data-ajax-params="userid=<?php echo $row->id?>&username=<?php echo $row->username?>" data-ajax-callback="callback_unmatches">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M1,4.27L2.28,3L20,20.72L18.73,22L15.18,18.44L13.45,20.03L12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,7.55 2.23,6.67 2.63,5.9L1,4.27M7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,11.07 20.42,13.32 17.79,15.97L5.27,3.45C5.95,3.16 6.7,3 7.5,3Z"/></svg>
                </button>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
