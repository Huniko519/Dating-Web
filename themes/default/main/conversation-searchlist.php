<li data-online="<?php echo $conversation->user->online;?>">
    <a href="javascript:void(0);" data-ajax-post="/chat/open_conversation" data-ajax-params="from=<?php echo $conversation->user->id;?>" data-ajax-callback="callback_open_conversation">
        <div class="m_con_item <?php if( $conversation->seen == 0 && $conversation->owner != self::ActiveUser()->id) { echo 'active';}else{ echo '';} ?>">
            <div class="m_c_item_avatar">
                <img src="<?php echo $conversation->user->avater;?>" alt="<?php echo $conversation->user->full_name;?>" title="<?php echo $conversation->user->full_name;?>">
                <?php if($conversation->user->online == 1) { echo '<div class="online_dot"></div>'; }else{ echo ''; }?>
            </div>
            <div class="m_c_item_name">
                <span><?php echo $conversation->user->full_name?></span>
                    <?php if($conversation->user->verified) { echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#2196F3" d="M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1Z"></path></svg>'; } else { echo '';}?>
            </div>
            <div class="m_c_item_time right">
                <span class="time ajax-time" title="<?php echo $conversation->created_at;?>">
                    <?php echo $conversation->lmtime;?>
                </span>
            </div>
            <div class="m_c_item_msg">
                <p class="m_c_item_snippet"><?php echo $conversation->text;?></p>
            </div>
        </div>
    </a>
</li>
