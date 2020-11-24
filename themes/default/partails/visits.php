<?php global $site_url;?>
<div class="col l3 m4 s6 xs12" data-likes-uid="<?php echo $row->id?>">
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
                <span class="time ajax-time age" title="<?php echo $row->created_at;?>"><?php echo get_time_ago( strtotime($row->created_at) );?></span>
                <?php echo $row->country_txt?>
            </p>
        </div>
    </div>
</div>