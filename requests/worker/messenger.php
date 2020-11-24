<?php
Class Messenger extends Worker {
	function get_conversation_list() {
        $data                   = array();
        $messages               = LoadEndPointResource('messages');
        $conversations          = $messages::getConversationList();
        $OnlineUsers            = 0;
        $conversations_html     = "";
        foreach ($conversations as $key => $msg) {
            if( $msg->user->online == 1 ){
                $OnlineUsers++;
            }
        }

        if( !empty( $conversations ) ){
            if( count( $conversations ) > 0 ){
                foreach ($conversations as $key => $conversation) {
                    if( $conversation->user->online == 1 ){
                        $conversations_html .= '<li><a href="javascript:void(0);" data-ajax-post="/chat/open_conversation" data-ajax-params="from='.$conversation->user->id.'" data-ajax-callback="callback_open_conversation">';
                        $conversations_html .= '<div class="m_con_item ' . ( ( $conversation->user->online == 1 || $conversation->seen == 0 ) ? 'active' : '' ) .'"><div class="m_c_item_avatar"><img src="'.$conversation->user->avater.'" alt="'.$conversation->user->full_name.'" title="'.$conversation->user->full_name.'">';
                        $conversations_html .= ( ( $conversation->user->online == 1 ) ? '<div class="online_dot"></div>' : '' ) .'</div><div class="m_c_item_name"><span>'. $conversation->user->full_name.'</span>';
                        $conversations_html .= ( ( $conversation->user->verified ) ? '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#2196F3" d="M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1Z"></path></svg>' : '' );
                        $conversations_html .= '</div><div class="m_c_item_time right"><span>'.$conversation->time.'</span></div><div class="m_c_item_msg"><p class="m_c_item_snippet">'.$conversation->text.'</p></div></div></a></li>';
                        unset( $conversations->{$key} );
                    }
                }
                foreach ($conversations as $key => $conversation) {
                    $conversations_html .= '<li><a href="javascript:void(0);" data-ajax-post="/chat/open_conversation" data-ajax-params="from='.$conversation->user->id.'" data-ajax-callback="callback_open_conversation">';
                    $conversations_html .= '<div class="m_con_item ' . ( ( $conversation->user->online == 1 || $conversation->seen == 0 ) ? 'active' : '' ) .'"><div class="m_c_item_avatar"><img src="'.$conversation->user->avater.'" alt="'.$conversation->user->full_name.'" title="'.$conversation->user->full_name.'">';
                    $conversations_html .= ( ( $conversation->user->online == 1 ) ? '<div class="online_dot"></div>' : '' ) .'</div><div class="m_c_item_name"><span>'. $conversation->user->full_name.'</span>';
                    $conversations_html .= ( ( $conversation->user->verified ) ? '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#2196F3" d="M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1Z"></path></svg>' : '' );
                    $conversations_html .= '</div><div class="m_c_item_time right"><span>'.$conversation->time.'</span></div><div class="m_c_item_msg"><p class="m_c_item_snippet">'.$conversation->text.'</p></div></div></a></li>';
                }
            }
        }
    
        $data['conversations'] = $conversations_html;
        $data['OnlineUsers'] = $OnlineUsers;
		return $data;
    }
    function get_chat_conversation(){
        $from = route(4);
//        $chat_conversation    = new ChatMessageParser($from, $_SESSION['userProfile']->id,false);
//        $conversationMessages = $chat_conversation->Parse();
        $conversationMessages = generate_chat_messages_convirsation((int)$_SESSION['userProfile']->id, (int)$from,0,false);//generate_chat_messages_convirsation($from, self::ActiveUser()->id,0,false);
        $data['conversations'] = $conversationMessages;
        $data['from'] = $from;
        $data['to'] = $_SESSION['userProfile']->id;
        // /$data['conversations'] = "message between " . $_SESSION['userProfile']->id . " and " . $to;
        return $data;
    }
}