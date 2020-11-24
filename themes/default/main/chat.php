<?php
    $OnlineUsers = 0;
?>
<input type="hidden" id="time" name="time" value="0">
<input type="hidden" id="last_decline_message" name="last_decline_message" value="">
<input type="hidden" id="timestamp" name="timestamp" value="0">
<input type="hidden" id="rts_vsdhjh98" name="rts_vsdhjh98" value="0">
<input type="hidden" id="vxd" name="vx" value="">
<input type="hidden" id="dfgetevxd" name="vbnrx" value="">
<!-- Messages  -->
<div id="message_box" class="hide dt_msg_box open_list">
    <div class="modal-content">
        <div class="msg_list"> <!-- Message List  -->
            <div class="msg_header valign-wrapper">
                <h2>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17,12V3A1,1 0 0,0 16,2H3A1,1 0 0,0 2,3V17L6,13H16A1,1 0 0,0 17,12M21,6H19V15H6V17A1,1 0 0,0 7,18H18L22,22V7A1,1 0 0,0 21,6Z" /></svg> <?php echo __( 'Messenger' );?>
                    <?php
                    if( $OnlineUsers > 0 ){
                        echo '<div class="chat_count">'.$OnlineUsers.'</div>';
                    }else{
                        echo '<div class="chat_count hide">0</div>';
                    }
                    ?>
                </h2>
                <div class="msg_toolbar">
					<button type="button" class="dropdown-trigger chat_stts_dropd btn btn-flat close waves-effect" class="btn btn-flat close waves-effect" data-target="cht_sts_dropdown" title="<?php echo __( 'Active Status' );?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M10.63,14.1C12.23,10.58 16.38,9.03 19.9,10.63C23.42,12.23 24.97,16.38 23.37,19.9C22.24,22.4 19.75,24 17,24C14.3,24 11.83,22.44 10.67,20H1V18C1.06,16.86 1.84,15.93 3.34,15.18C4.84,14.43 6.72,14.04 9,14C9.57,14 10.11,14.05 10.63,14.1V14.1M9,4C10.12,4.03 11.06,4.42 11.81,5.17C12.56,5.92 12.93,6.86 12.93,8C12.93,9.14 12.56,10.08 11.81,10.83C11.06,11.58 10.12,11.95 9,11.95C7.88,11.95 6.94,11.58 6.19,10.83C5.44,10.08 5.07,9.14 5.07,8C5.07,6.86 5.44,5.92 6.19,5.17C6.94,4.42 7.88,4.03 9,4M17,22A5,5 0 0,0 22,17A5,5 0 0,0 17,12A5,5 0 0,0 12,17A5,5 0 0,0 17,22M16,14H17.5V16.82L19.94,18.23L19.19,19.53L16,17.69V14Z" /></svg></button>
					<ul id="cht_sts_dropdown" class="dropdown-content">
						<div class="chat_change_online switch center">
							<p><?php echo __( 'Active Status' );?></p>
							<label>
								<?php echo __( 'Offline' );?>
								<input type="checkbox" id="chat_go_online" <?php if( $profile->online == 1 ){ echo 'checked'; }?>>
								<span class="lever"></span>
								<?php echo __( 'Online' );?>
							</label>
						</div>
					</ul>
                    <button type="button" class="btn btn-flat mark_read waves-effect" onclick="remove_conversationlist_active();" data-ajax-post="/chat/mark_all_messages_as_read" data-ajax-params="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M14,10H2V12H14V10M14,6H2V8H14V6M2,16H10V14H2V16M21.5,11.5L23,13L16,20L11.5,15.5L13,14L16,17L21.5,11.5Z" /></svg> <span class="hide-on-small-only"><?php echo __( 'Mark all as read' );?></span>
                    </button>
                    <button type="button" class="btn btn-flat close waves-effect modal-close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" /></svg>
                    </button>
                </div>
            </div>
            <div class="msg_container">
                <div class="m_search">
					<div class="dt_srch_msg_progress hide" id="search-loader">
						<div class="progress">
							<div class="indeterminate"></div>
						</div>
					</div>
                    <div class="search_input">
                        <input type="search" class="browser-default" id="chat_search" name="search" placeholder="<?php echo __( 'Search for Chats' );?>" autofocus />
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" /></svg>
						<div class="srch_filter hide" id="reset_chat_search">
							<button type="button" id="btn_reset_chat_search" class="btn btn-flat mark_read waves-effect" data-ajax-post="/chat/mark_all_messages_as_read" data-ajax-params="" title="<?php echo __( 'Reset' );?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,2C17.53,2 22,6.47 22,12C22,17.53 17.53,22 12,22C6.47,22 2,17.53 2,12C2,6.47 6.47,2 12,2M15.59,7L12,10.59L8.41,7L7,8.41L10.59,12L7,15.59L8.41,17L12,13.41L15.59,17L17,15.59L13.41,12L17,8.41L15.59,7Z" /></svg>
							</button>
						</div>
                    </div>
                    <div class="chat_filter switch">
                        <label>
                            <?php echo __( 'All' );?>
                            <input type="checkbox" id="chat_search_online">
                            <span class="lever"></span>
                            <?php echo __( 'Online' );?>
                        </label>
                    </div>
                </div>
				
				<?php if($config->message_request_system == 'on'){ ?>
                    <button type="button" class="btn btn-flat msg_requests" data-ajax-post="/chat/get_messages_requests" data-ajax-params="" data-accepted="requests" data-ajax-callback="callback_msg_request" data-text-msg-request='<span class="active"><?php echo __( 'All conversations' );?></span><span><b id="requests_count"></b> <?php echo __( 'Message requests' );?></span>' data-text-all-conversation='<span><?php echo __( 'All conversations' );?></span><span class="active"><b id="requests_count"></b> <?php echo __( 'Message requests' );?></span>'>
						<span class="active"><?php echo __( 'All conversations' );?></span>
						<span><b id="requests_count"></b> <?php echo __( 'Message requests' );?></span>
                    </button>
                <?php }?>
				
                <div class="m_body">
                    <div class="m_body_content">
                        <ul class="m_conversation" id="m_conversation_search"></ul>
                        <ul class="m_conversation" id="m_conversation"></ul>
                    </div>
                </div>
            </div>
        </div> <!-- End Message List  -->

        <div class="msg_chat"> <!-- Message Chat  -->
            <div class="chat_conversations">
                <div class="chat_header valign-wrapper">
                    <div class="chat_navigation">
                        <button type="button" class="btn btn-flat back waves-effect" id="navigateBack">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path></svg>
                        </button>
                    </div>
                    <div class="chat_participant">
                        <div class="c_avatar">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA=" alt="User">
                        </div>
                        <div class="c_name">
                            <a href="" target="_blank" id="chatfromuser"><span class="name"></span></a>
                            <span class="time ajax-time last_seen" title=""></span>
                        </div>
                    </div>
                    <div class="chat_toolbar">
						<div>
						<button type="button" class="dropdown-trigger btn btn-flat close waves-effect" data-target="cht_more_opts_dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z" /></svg></button>
						<ul id="cht_more_opts_dropdown" class="dropdown-content">
							<li><a href="javascript:void(0);" id="deletechatconversations"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"></path></svg> <?php echo __('Delete chat');?></a></li>

                            <?php
                                $video_link = false;
                                $audio_link = false;

                                //$config->pro_system            ( 0,1 ) -> check if Pro system enabled
                                //$config->avcall_pro            ( 0,1 ) -> check if Video & Audio Call for pro users only
                                //$config->video_chat            ( 0,1 ) -> check if Video Call enabled
                                //$config->audio_chat            ( 0,1 ) -> check if Audio Call enabled
                                //$profile->is_pro
                                if ((int)$config->pro_system == 1) {
                                    // pro system enabled
                                    if ((int)$config->avcall_pro == 1) {
                                        // Video & Audio Call for pro users only enabled
                                        if( $profile->is_pro == 1 ) {
                                            // if user is pro
                                            if ((int)$config->video_chat == 1) {
                                                //Video Call enabled
                                                $video_link = true;
                                            }
                                            if ((int)$config->audio_chat == 1) {
                                                //Audio Call enabled
                                                $audio_link = true;
                                            }
                                        }
                                    }else{
                                        // Video & Audio Call for pro users only disabled
                                        if ((int)$config->video_chat == 1) {
                                            //Video Call enabled
                                            $video_link = true;
                                        }
                                        if ((int)$config->audio_chat == 1) {
                                            //Audio Call enabled
                                            $audio_link = true;
                                        }
                                    }
                                }else{
                                    // pro system disabled
                                    if ((int)$config->video_chat == 1) {
                                        //Video Call enabled
                                        $video_link = true;
                                    }
                                    if ((int)$config->audio_chat == 1) {
                                        //Audio Call enabled
                                        $audio_link = true;
                                    }
                                }
                            ?>

                            <?php if ($video_link == true) { ?>
                                <li><a href="javascript:void(0);" onclick="Wo_GenerateVideoCall(<?php echo auth()->id;?>)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17,10.5V7A1,1 0 0,0 16,6H4A1,1 0 0,0 3,7V17A1,1 0 0,0 4,18H16A1,1 0 0,0 17,17V13.5L21,17.5V6.5L17,10.5Z"></path></svg> <?php echo __('Video call');?></a></li>
                            <?php } ?>
                            <?php if ($audio_link == true) { ?>
                                <li><a href="javascript:void(0);" onclick="Wo_GenerateVoiceCall(<?php echo auth()->id;?>)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z"></path></svg> <?php echo __('Audio call');?></a></li>
                            <?php } ?>

						</ul>
						</div>
                        <button type="button" class="btn btn-flat close waves-effect modal-close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"></path></svg>
                        </button>
                    </div>
                </div>

                <a href="javascript:void(0);" id="btn_load_prev_chat_message" data-lang-nomore="<?php echo __('No more messages to show.');?>" class="btn waves-effect dt_chat_lod_more hide"><?php echo __('Load more...');?></a>

                <div class="chat_container">
                    <div class="chat_body">
                        <div class="chat_body_content"></div>
                    </div>
                    <div class="chat_foot">
                        <div class="chat_f_text">
                            <div class="hide dt_acc_dec_msg" id="chat_request_btns">
                                <button type="button" data-route1="<?php echo '@'.$profile->username;?>" data-route2="chat_request" id="btn_chat_accept_message" class="btn btn-flat waves-effect acc_msg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" /></svg> <?php echo __('Accept');?>
                                </button>
                                <button type="button" data-route1="<?php echo '@'.$profile->username;?>" data-route2="chat_request" id="btn_chat_decline_message" class="btn btn-flat waves-effect dec_msg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" /></svg> <?php echo __('Decline');?>
                                </button>
                            </div>
							<div class="chat_message_upload_media_imgprogress hide">
								<div class="progress">
									<div class="chat_message_upload_media_imgdeterminate determinate" style="width: 0%;"></div>
								</div>
							</div>
                            <form method="POST" action="/chat/send_message" class="valign-wrapper" id="chat_message_form">
                                <input type="hidden" name="to" value="" id="to_message"/>
                                <div class="chat_f_textarea">
                                    <div class="chat_f_write">
                                        <textarea placeholder="<?php echo __('Type a message');?>" id="dt_emoji" name="text" class="hide"></textarea>
                                    </div>
                                    <div class="chat_f_attach">
                                    <span id="chat_message_gify">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17,12V3A1,1 0 0,0 16,2H3A1,1 0 0,0 2,3V17L6,13H16A1,1 0 0,0 17,12M21,6H19V15H6V17A1,1 0 0,0 7,18H18L22,22V7A1,1 0 0,0 21,6Z"></path></svg>
                                    </span>
                                        <span id="chat_message_upload_stiker">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5.5,2C3.56,2 2,3.56 2,5.5V18.5C2,20.44 3.56,22 5.5,22H16L22,16V5.5C22,3.56 20.44,2 18.5,2H5.5M5.75,4H18.25A1.75,1.75 0 0,1 20,5.75V15H18.5C16.56,15 15,16.56 15,18.5V20H5.75A1.75,1.75 0 0,1 4,18.25V5.75A1.75,1.75 0 0,1 5.75,4M14.44,6.77C14.28,6.77 14.12,6.79 13.97,6.83C13.03,7.09 12.5,8.05 12.74,9C12.79,9.15 12.86,9.3 12.95,9.44L16.18,8.56C16.18,8.39 16.16,8.22 16.12,8.05C15.91,7.3 15.22,6.77 14.44,6.77M8.17,8.5C8,8.5 7.85,8.5 7.7,8.55C6.77,8.81 6.22,9.77 6.47,10.7C6.5,10.86 6.59,11 6.68,11.16L9.91,10.28C9.91,10.11 9.89,9.94 9.85,9.78C9.64,9 8.95,8.5 8.17,8.5M16.72,11.26L7.59,13.77C8.91,15.3 11,15.94 12.95,15.41C14.9,14.87 16.36,13.25 16.72,11.26Z" /></svg>
                                    </span>
                                        <span id="chat_message_upload_media" style="cursor: pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M8.5,13.5L11,16.5L14.5,12L19,18H5M21,19V5C21,3.89 20.1,3 19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19Z" /></svg>
                                    </span>
                                    </div>
                                </div>
                                <input type="file" id="chat_message_upload_media_file" class="hide" accept="image/x-png, image/gif, image/jpeg" name="avatar">
                                <div class="chat_f_send">
                                    <button type="button" id="btn_chat_f_send" class="btn-floating btn-large waves-effect waves-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M2,21L23,12L2,3V10L17,12L2,14V21Z" /></svg>
                                    </button>
                                    <div class="lds-facebook hide"><div></div><div></div><div></div></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Message Chat  -->
    </div>
</div>
<!-- End Messages  -->

<!-- Stickers -->
<div id="stiker_box" class="hide bottom-sheet">
    <div class="modal-content">
        <h5><div><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M5.5,2C3.56,2 2,3.56 2,5.5V18.5C2,20.44 3.56,22 5.5,22H16L22,16V5.5C22,3.56 20.44,2 18.5,2H5.5M5.75,4H18.25A1.75,1.75 0 0,1 20,5.75V15H18.5C16.56,15 15,16.56 15,18.5V20H5.75A1.75,1.75 0 0,1 4,18.25V5.75A1.75,1.75 0 0,1 5.75,4M14.44,6.77C14.28,6.77 14.12,6.79 13.97,6.83C13.03,7.09 12.5,8.05 12.74,9C12.79,9.15 12.86,9.3 12.95,9.44L16.18,8.56C16.18,8.39 16.16,8.22 16.12,8.05C15.91,7.3 15.22,6.77 14.44,6.77M8.17,8.5C8,8.5 7.85,8.5 7.7,8.55C6.77,8.81 6.22,9.77 6.47,10.7C6.5,10.86 6.59,11 6.68,11.16L9.91,10.28C9.91,10.11 9.89,9.94 9.85,9.78C9.64,9 8.95,8.5 8.17,8.5M16.72,11.26L7.59,13.77C8.91,15.3 11,15.94 12.95,15.41C14.9,14.87 16.36,13.25 16.72,11.26Z"></path></svg></div> <?php echo __('Stickers');?></h5>
		<div class="stiker_imgprogress hide">
			<div class="progress">
				<div class="stiker_imgdeterminate determinate" style="width: 0%"></div >
			</div>
		</div>
        <div id="stikerlist"></div>
    </div>
</div>

<!-- Gifybox -->
<div id="gify_box" class="hide bottom-sheet">
    <div class="modal-content">
        <h5>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M5.5,2C3.56,2 2,3.56 2,5.5V18.5C2,20.44 3.56,22 5.5,22H16L22,16V5.5C22,3.56 20.44,2 18.5,2H5.5M5.75,4H18.25A1.75,1.75 0 0,1 20,5.75V15H18.5C16.56,15 15,16.56 15,18.5V20H5.75A1.75,1.75 0 0,1 4,18.25V5.75A1.75,1.75 0 0,1 5.75,4M14.44,6.77C14.28,6.77 14.12,6.79 13.97,6.83C13.03,7.09 12.5,8.05 12.74,9C12.79,9.15 12.86,9.3 12.95,9.44L16.18,8.56C16.18,8.39 16.16,8.22 16.12,8.05C15.91,7.3 15.22,6.77 14.44,6.77M8.17,8.5C8,8.5 7.85,8.5 7.7,8.55C6.77,8.81 6.22,9.77 6.47,10.7C6.5,10.86 6.59,11 6.68,11.16L9.91,10.28C9.91,10.11 9.89,9.94 9.85,9.78C9.64,9 8.95,8.5 8.17,8.5M16.72,11.26L7.59,13.77C8.91,15.3 11,15.94 12.95,15.41C14.9,14.87 16.36,13.25 16.72,11.26Z"></path>
                </svg>
            </div> <?php echo __('Send Gif');?>
            <input type="text" id="gify_search" name="gify_search" style="width: 70%;float: right;display: block;text-align: left;margin-left: 50px;" placeholder="<?php echo __('Search GIFs');?>">
            <button type="button" id="reload_gifs" class="btn-floating btn-large waves-effect waves-light green" style="width: 47px;height: 35px;margin: 0 auto;    border-radius: 7%;">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 20 60"><path fill="currentColor" d="M2,21L23,12L2,3V10L17,12L2,14V21Z"></path></svg>
            </button>
        </h5>
        <div class="stiker_imgprogress hide">
            <div class="progress">
                <div class="stiker_imgdeterminate determinate" style="width: 0%"></div >
            </div>
        </div>
        <hr>
        <div id="gifylist"></div>
    </div>
</div>