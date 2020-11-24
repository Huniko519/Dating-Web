<?php global $site_url;?>
<div class="col s6 m4 xs12" id="blocked_user_<?php echo $row->id;?>">
    <div class="unblock_card">
        <span href="javascript:void(0);">
            <div class="avatar">
                <img src="<?php echo GetMedia($row->avater);?>" alt="<?php echo $row->full_name;?>" class="circle">
            </div>
        </span>
        <div class="info">
            <span href="javascript:void(0);">
                <span class="black-text truncate bold"><?php echo $row->full_name;?></span>
            </span>
            <a class="btn waves-effect btn_primary unblock" data-ajax-post="/useractions/unblock" data-ajax-params="userid=<?php echo $row->id;?><?php echo ( $admin_mode ? '&targetuid=' . strrev( str_replace( '==', '', base64_encode($profile->id) ) ) : '' );?>" data-ajax-callback="callback_unblock_hide" class="block_text"><?php echo __( 'Unblock' );?></a>
        </div>
    </div>
</div>