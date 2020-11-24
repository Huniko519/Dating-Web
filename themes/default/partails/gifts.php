<?php global $site_url;?>
<div class="col l4 m6 s12" data-likes-uid="<?php echo $row->id?>">
    <div class="card qd_gift_data">
		<div class="qd_gift_img">
			<img src="<?php echo GetMedia($row->gift_media_file);?>">
		</div>
		<div class="valign-wrapper qd_gift_data_foot">
			<a href="<?php echo $site_url;?>/@<?php echo $row->username?>" data-ajax="/@<?php echo $row->username?>" class="avatar">
				<img src="<?php echo GetMedia('',false); ?><?php echo $row->avater?>" alt="<?php echo $row->username?>">
			</a>
			<div class="info">
				<p><a href="<?php echo $site_url;?>/@<?php echo $row->username?>" data-ajax="/@<?php echo $row->username?>"><?php echo ($row->first_name !== '' ) ? $row->first_name . ' ' . $row->last_name : $row->username;?></a> <?php echo __( 'Send to you' );?></p>
				<?php if($row->time> 0){?>
					<div class="time ajax-time age" title="<?php echo date('c',$row->time);?>"><?php echo get_time_ago( $row->time );?></div>
				<?php } ?>
			</div>
		</div>
    </div>
</div>
