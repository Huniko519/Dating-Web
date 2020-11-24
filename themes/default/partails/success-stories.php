<?php global $site_url;?>

<div class="col l4 m6 s12 success_story_item" data-uid="<?php echo $story->id;?>">
    <div class="card">
		<div class="qd_story_card_main_img">
			<img src="<?php echo $story->user->avater->avater;?>" alt="<?php echo $story->user->username;?>">
		</div>
        <div class="qd_story_card_usr_imgs">
            <a href="<?php echo $site_url;?>/story/<?php echo $story->id. '_'. url_slug($story->quote);?>" data-ajax="/story/<?php echo $story->id. '_'. url_slug($story->quote);?>">
                <img src="<?php echo $story->user->avater->avater;?>" alt="<?php echo $story->user->username;?>">
            </a>
            <a href="<?php echo $site_url;?>/story/<?php echo $story->id. '_'. url_slug($story->quote);?>" data-ajax="/story/<?php echo $story->id. '_'. url_slug($story->quote);?>">
                <img src="<?php echo $story->story_user->avater->avater;?>" alt="<?php echo $story->story_user->username;?>">
            </a>
        </div>
        <div class="qd_story_card_usr_info">
            <a href="<?php echo $site_url;?>/story/<?php echo $story->id. '_'. url_slug($story->quote);?>" data-ajax="/story/<?php echo $story->id . '_'. url_slug($story->quote);?>">
                <div class="qd_story_card_usr_name truncate"><?php echo ($story->user->first_name !== '' ) ? $story->user->first_name . ' ' . $story->user->last_name : $story->user->username;?></div>
                <div class="qd_story_card_usr_sep"></div>
                <div class="qd_story_card_usr_name truncate"><?php echo ($story->story_user->first_name !== '' ) ? $story->story_user->first_name . ' ' . $story->story_user->last_name : $story->story_user->username;?></div>
            </a>
            <!--<p><?php echo $story->quote;?></p>-->
        </div>
		<div class="valign-wrapper qd_story_card_usr_foot">
			<a class="btn" href="<?php echo $site_url;?>/story/<?php echo $story->id. '_'. url_slug($story->quote);?>" data-ajax="/story/<?php echo $story->id. '_'. url_slug($story->quote);?>"><?php echo __( 'READ MORE' );?></a>
			<time><?php echo $story->story_date;?></time>
		</div>
    </div>
</div>