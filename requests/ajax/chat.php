<?php
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

Class Chat extends Aj {
    function upload_media() {
        global $db, $_UPLOAD, $_DS;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (!isset($_FILES) && empty($_FILES)) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error = false;
        $to    = '';
        if (isset($_POST[ 'to' ]) && !empty($_POST[ 'to' ])) {
            $to = (int) str_replace('*-*!*~*#*$*%*', '', strrev(base64_decode($_POST[ 'to' ])));
        }
        if (!is_numeric($to)) {
            return array(
                'status' => 200,
                'message' => __('Hack attempt.')
            );
        }
        $file = '';
        if (!file_exists($_UPLOAD . 'chat' . $_DS . date('Y'))) {
            mkdir($_UPLOAD . 'chat' . $_DS . date('Y'), 0777, true);
        }
        if (!file_exists($_UPLOAD . 'chat' . $_DS . date('Y') . $_DS . date('m'))) {
            mkdir($_UPLOAD . 'chat' . $_DS . date('Y') . $_DS . date('m'), 0777, true);
        }
        $dir = $_UPLOAD . 'chat' . $_DS . date('Y') . $_DS . date('m');
        foreach ($_FILES as $file) {
            $ext      = pathinfo($file[ 'name' ], PATHINFO_EXTENSION);
            $key      = GenerateKey();
            $filename = $dir . $_DS . $key . '.' . $ext;
            if (move_uploaded_file($file[ 'tmp_name' ], $filename)) {
                $thumbfile = 'upload/chat/' . date('Y') . '/' . date('m') . '/' . $key . '_m.' . $ext;
                $thumbnail = new ImageThumbnail($filename);
                $thumbnail->save($thumbfile);
                @unlink($filename);
                if (is_file($thumbfile)) {
                    UploadToS3($thumbfile, array(
                        'amazon' => 0
                    ));
                }
                $msg                 = array();
                $msg[ 'from' ]       = self::ActiveUser()->id;
                $msg[ 'to' ]         = $to;
                $msg[ 'media' ]      = 'upload/chat/' . date('Y') . '/' . date('m') . '/' . $key . '_m.' . $ext;
                $msg[ 'seen' ]       = 0;
                $msg[ 'created_at' ] = date('Y-m-d H:i:s');
                $saved               = $db->insert('messages', $msg);
                if ($saved) {
                    $file = GetMedia('upload/chat/' . date('Y') . '/' . date('m') . '/' . $key . '_m.' . $ext);
                }
            } else {
                $error = true;
            }
        }
        if ($error) {
            return array(
                'status' => 403
            );
        } else {
            return array(
                'status' => 200,
                'file' => $file
            );
        }
    }
    function get_messages_requests(){
        return $this->get_conversation_list(0);
    }
    function open_private_conversation() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $from = 0;
        if (isset($_POST[ 'from' ]) && is_numeric($_POST[ 'from' ])) {
            $from = (int) Secure($_POST[ 'from' ]);
        } else {
            return array(
                'status' => 400,
                'message' => __('No from id found.')
            );
        }

        if( isChatBefore( self::ActiveUser()->id ,$from ) == false && isNonProBuyChatCredits(self::ActiveUser()->id , $from) == false){

            if ( isGenderFree(self::ActiveUser()->gender) === false ) {

                if (self::ActiveUser()->is_pro == '0') {
                    if( $config->not_pro_chat_limit_daily == 0 ){
                        return array(
                            'status' => 200,
                            'message' => __('please recharge your credits.'),
                            'mode' => 'credits'
                        );
                    }
                    if (GetNonProMaxUserChatsPerDay(self::ActiveUser()->id) > $config->not_pro_chat_limit_daily -1) {
                        if (isNonProCanChatWith(self::ActiveUser()->id, (int)$from) === false) {
                            return array(
                                'status' => 200,
                                'message' => __('please recharge your credits.'),
                                'mode' => 'credits'
                            );
                        }
                    }
                }

                if( self::Config()->spam_warning == '1' ) {
                    if ((int)self::ActiveUser()->spam_warning > 0) {
                        if (intval(self::ActiveUser()->spam_warning) > strtotime("-1 day")) {
                            $raminSpamhours = 24 - intval(date('H', time() - intval(self::ActiveUser()->spam_warning)));
                            if ($raminSpamhours <= 24) {
                                return array(
                                    'status' => 400,
                                    'spam' => true,
                                    'message' => __('You transmitting spam messages. the system automatically restricts chat for you, so you can chat again after') . ' ' . $raminSpamhours . ' ' . __('hours.'),
                                    'data' => self::ActiveUser()->spam_warning,
                                    'raminhours' => $raminSpamhours,
                                    'time' => time(),
                                    'hours' => date('H', time()),
                                    'r' => intval(self::ActiveUser()->spam_warning),
                                    'x' => intval(date('H', time() - intval(self::ActiveUser()->spam_warning)))
                                );
                            }
                        }
                    }else{
                        if( IsUserSpammer((int)self::ActiveUser()->id) ) {
                            $db->where('id', self::ActiveUser()->id)->update('users', array('spam_warning' => time()));
                            return array(
                                'spam' => true,
                                'status' => 400,
                                'message' => __('You transmitting spam messages. the system automatically restricts chat for you, so you can chat again after') . ' 24 ' . __('hours.'),
                            );
                        }
                    }
                }

            }

        }

        $_user = LoadEndPointResource('users');
        if ($_user) {
            $user_from            = $_user->get_user_profile($from);
            $conversationMessages = generate_chat_messages_convirsation((int) self::ActiveUser()->id, (int) $from, 0, true);

            $acc = CheckIfConversionAccepted((int) self::ActiveUser()->id, (int) $from);
            if(isset($acc['status']) && $acc['status'] === 0){
                $accepted = 0;
            }else if(isset($acc['status']) && $acc['status'] === 1){
                $accepted = 1;
            }else if(isset($acc['status']) && $acc['status'] === 2){
                $accepted = 2;
            }


            if($config->message_request_system == 'off' ) {
                $accepted = 1;
            }

            if($acc === false ){
                $accepted = 1;
            }

            $last_decline_message = '';
            $last_decline = 0;
            if($config->message_request_system == 'on') {
                $last_decline = CheckIfUserDeclinedBefore((int) self::ActiveUser()->id,  (int) $from);
                if(isset($last_decline->status) && $last_decline->status == '2' ){
                    $last_decline = (int)$last_decline->created_at;
                    $last_decline_message = __('This user decline your chat before so you can chat with this user after') . ' HH ' . __('hours.');
                }
            }

            return array(
                'declined' => IsConversationDeclined((int) self::ActiveUser()->id, (int) $from),
                's' => $db->where('sender_id',(int) self::ActiveUser()->id)->where('receiver_id',$user_from->id)->getOne('conversations','status'),
                'acc' => $acc,
                'last_decline' => $last_decline,
                'last_decline_message' => $last_decline_message,
                'status' => 200,
                'from' => self::ActiveUser()->id,
                //'self::ActiveUser()->id' => self::ActiveUser()->id,
                'to' => array(
                    'id' => $user_from->id,
                    'fullname' => $user_from->fullname,
                    'full_name' => $user_from->full_name,
                    'first_name' => $user_from->first_name,
                    'last_name' => $user_from->last_name,
                    'avater' => $user_from->avater,
                    'username' => $user_from->username,
                    'lastseen' => $user_from->lastseen,
                    'lastseen_date' => $user_from->lastseen_date,
                    'lastseen_txt' => $user_from->lastseen_txt,
                ),
                //'to' => $user_from,
                'messages' => $conversationMessages,
                'accepted' => $accepted,
                'mode' => 'chat',
                'receiver' => base64_encode(strrev('*-*!*~*#*$*%*' . $user_from->id . '*-*!*~*#*$*%*'))
            );
        } else {
            return false;
        }
    }
    function open_conversation() {
        global $db,$config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $from = 0;
        if (isset($_POST[ 'from' ]) && is_numeric($_POST[ 'from' ])) {
            $from = (int) Secure($_POST[ 'from' ]);
        } else {
            return array(
                'status' => 400,
                'message' => __('No from id found.')
            );
        }
        $_user = LoadEndPointResource('users');
        if ($_user) {
            $user_from            = $_user->get_user_profile($from);
            $conversationMessages = generate_chat_messages_convirsation((int) self::ActiveUser()->id, (int) $from, 0, true);

            $acc = CheckIfConversionAccepted((int) self::ActiveUser()->id, (int) $from);
            if(isset($acc['status']) && $acc['status'] === 1){
                $accepted = 1;
            }else{
                $accepted = 0;
            }

//            //if((int)self::ActiveUser()->id === (int) $user_from->id){
//                $accepted = 1;
//            //}

            if($config->message_request_system == 'off') {
                $accepted = 1;
            }
            return array(
                'status' => 200,
                'from' => self::ActiveUser()->id,
                'from_user' => self::ActiveUser()->username,
                //'to' => $user_from,
                'to' => array(
                    'id' => $user_from->id,
                    'fullname' => $user_from->fullname,
                    'full_name' => $user_from->full_name,
                    'first_name' => $user_from->first_name,
                    'last_name' => $user_from->last_name,
                    'avater' => $user_from->avater,
                    'username' => $user_from->username,
                    'lastseen' => $user_from->lastseen,
                    'lastseen_date' => $user_from->lastseen_date,
                    'lastseen_txt' => $user_from->lastseen_txt,
                ),
                'accepted' => $accepted,
                'messages' => $conversationMessages,
                'receiver' => base64_encode(strrev('*-*!*~*#*$*%*' . $user_from->id . '*-*!*~*#*$*%*'))
            );
        } else {
            return false;
        }
    }
    function chat_change_online() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $updated = $db->where('id', self::ActiveUser()->id)->update('users', array(
            'lastseen' => time(),
            'online' => ((self::ActiveUser()->online == 1) ? 0 : 1)
        ));
        if ($updated) {
            $_SESSION[ 'userEdited' ] = true;
            return array(
                'status' => 200
            );
        } else {
            return array(
                'status' => 400
            );
        }
    }
    function record_user_lastseen() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (self::ActiveUser()->online == 1) {
            $updated = $db->where('id', self::ActiveUser()->id)->update('users', array(
                'lastseen' => time()
            ));
            if ($updated) {
                $_SESSION[ 'userEdited' ] = true;
                return array(
                    'status' => 200
                );
            } else {
                return array(
                    'status' => 400
                );
            }
        } else {
            return array(
                'status' => 200
            );
        }
    }
    function mark_all_messages_as_read() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $updated = $db->where('`to`', self::ActiveUser()->id)->where('seen', 0)->update('messages', array(
            'seen' => time()
        ));
        if ($updated) {
            return array(
                'status' => 200
            );
        } else {
            return array(
                'status' => 204
            );
        }
    }
    function search() {
        global $db, $config, $_BASEPATH, $_DS;
        $site_url   = $config->uri;
        $theme_url  = $config->uri . '/themes/' . $config->theme . '/';
        $theme_path = $_BASEPATH . 'themes' . $_DS . $config->theme . $_DS;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $is_online = 0;
        if (isset($_POST[ 'is_online' ])) {
            if ($_POST[ 'is_online' ] == 'true') {
                $is_online = 1;
            } else {
                $is_online = 0;
            }
        }
        if (isset($_POST[ 'search_text' ]) && !empty($_POST[ 'search_text' ])) {
            $search_text = Secure($_POST[ 'search_text' ]);
        } else {
            return array(
                'status' => 200,
                'message' => ''
            );
        }
        $conversationHtml = '';
        $_msg             = LoadEndPointResource('messages');
        if ($_msg) {
            $conversations = $_msg->searchChat($search_text, $is_online);
            if (count($conversations) > 0) {
                foreach ($conversations as $key => $conversation) {
                    if (file_exists($theme_path . 'main' . $_DS . 'conversation-list.php')) {
                        ob_start();
                        require($theme_path . 'main' . $_DS . 'conversation-searchlist.php');
                        $conversationHtml .= ob_get_contents();
                        ob_end_clean();
                    }
                }
            }
            return array(
                'status' => 200,
                'message' => $conversationHtml
            );
        } else {
            return array(
                'status' => 204
            );
        }
    }
    function send_message() {
        global $db, $config;
        $html_return = '';
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $to = '';
        if (isset($_POST[ 'to' ]) && !empty($_POST[ 'to' ])) {
            $to = (int) str_replace('*-*!*~*#*$*%*', '', strrev(base64_decode($_POST[ 'to' ])));
        }
        if (!is_numeric($to)) {
            return array(
                'status' => 200,
                'message' => __('Hack attempt.')
            );
        }

        if($config->message_request_system == 'on') {
            $last_decline = CheckIfUserDeclinedBefore(self::ActiveUser()->id, $to);
            if (!empty($last_decline)) {
                if( $last_decline->status == "2" && intval($last_decline->created_at) > strtotime("-1 day")) {
                    $raminhours = 24 - intval(date('H', time() - intval($last_decline->created_at)));
                    if ($raminhours <= 24) {
                        return array(
                            'status' => 400,
                            'declined' => true,
                            'message' => __('This user decline your chat before so you can chat with this user after') . ' ' . $raminhours . ' ' . __('hours.'),
                            'data' => $last_decline,
                            'raminhours' => $raminhours,
                            'time' => time(),
                            'hours' => date('H', time()),
                            'r' => intval($last_decline->created_at),
                            'x' => intval(date('H', time() - intval($last_decline->created_at)))
                        );
                    }
                }

            }
        }

        if ( isGenderFree(self::ActiveUser()->gender) === false ) {
            if (self::ActiveUser()->is_pro == '0') {
                if( $config->not_pro_chat_limit_daily == 0 ){
                    return array(
                        'status' => 200,
                        'message' => __('please recharge your credits.'),
                        'mode' => 'credits'
                    );
                }
                if (GetNonProMaxUserChatsPerDay(self::ActiveUser()->id) > $config->not_pro_chat_limit_daily - 1 ) {
                    if (isNonProCanChatWith(self::ActiveUser()->id, (int)$to) === false) {
                        if( isNonProBuyChatCredits(self::ActiveUser()->id , (int)$to) === false ) {
                            return array(
                                'status' => 200,
                                'need_recharge' => true,
                                'message' => __('please recharge your credits.')
                            );
                        }
                    }
                }
            }
        }

        $text    = NULL;
        $sticker = NULL;
        $gify    = NULL;
        if (isset($_POST[ 'text' ]) && !empty($_POST[ 'text' ])) {
            $text = Secure($_POST[ 'text' ]);
        }
        if (isset($_POST[ 'sticker' ]) && !empty($_POST[ 'sticker' ])) {
            $sticker = Secure($_POST[ 'sticker' ]);
        }
        if (isset($_POST[ 'gifurl' ]) && !empty($_POST[ 'gifurl' ])) {
            $gify = Secure($_POST[ 'gifurl' ]);
        }
        if ($text === NULL && $sticker === NULL && $gify === NULL) {
            return array(
                'status' => 200,
                'message' => ''
            );
        }
        if ($text == '' && $sticker == '' && $gify == '') {
            return array(
                'status' => 200,
                'message' => ''
            );
        }
        if ((int) $to === (int) self::ActiveUser()->id) {
            return array(
                'status' => 200,
                'message' => ''
            );
        }

        if( isChatBefore( self::ActiveUser()->id ,$to ) == false ) {
            if (self::Config()->spam_warning == '1') {
                if ((int)self::ActiveUser()->spam_warning > 0) {
                    if (intval(self::ActiveUser()->spam_warning) > strtotime("-1 day")) {
                        $raminSpamhours = 24 - intval(date('H', time() - intval(self::ActiveUser()->spam_warning)));
                        if ($raminSpamhours <= 24) {
                            return array(
                                'status' => 400,
                                'spam' => true,
                                'message' => __('You transmitting spam messages. the system automatically restricts chat for you, so you can chat again after') . ' ' . $raminSpamhours . ' ' . __('hours.'),
                                'data' => self::ActiveUser()->spam_warning,
                                'raminhours' => $raminSpamhours,
                                'time' => time(),
                                'hours' => date('H', time()),
                                'r' => intval(self::ActiveUser()->spam_warning),
                                'x' => intval(date('H', time() - intval(self::ActiveUser()->spam_warning)))
                            );
                        }
                    }
                }
            }
            if ($text !== null && !empty($text)) {
                if (self::Config()->spam_warning == '1') {
                    //global $op;
                    //$spam_detect = $op->classify($text);
                    //if ('pos' === $spam_detect) {

                    //Detect here if user send messages requests more than 6 users within 10 mins.
                    if (IsUserSpammer((int)self::ActiveUser()->id)) {
                        $db->where('id', self::ActiveUser()->id)->update('users', array('spam_warning' => time()));
                        return array(
                            'spam' => true,
                            'status' => 400,
                            'message' => __('You transmitting spam messages. the system automatically restricts chat for you, so you can chat again after') . ' 24 ' . __('hours.'),
                        );
                    }
                    //}
                }
            }
        }
        if ($to > 0) {
            if (isUserInBlockList($to)) {
                return array(
                    'status' => 400,
                    'blacklist' => true,
                    'message' => ''
                );
            }
            if ($sticker > 0) {
                $text = NULL;
            }
            if ($text !== '' && $sticker === NULL) {
                $sticker = NULL;
            }
            $saved = $db->insert('messages', array(
                'from' => (int) self::ActiveUser()->id,
                'to' => (int) $to,
                'text' => html_entity_decode($text, ENT_QUOTES),
                'sticker' => $sticker,
                'media' => $gify,
                'seen' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ));
            if ($saved) {
                $_msg = LoadEndPointResource('messages');
                if ($_msg) {
                    $_msg->createNewConversation((int) $to);
                }
                return array(
                    'status' => 200,
                    'message' => __('Message sent'),
                    'to' => $to,
                    'msg' => $saved
                );
            }
        }
    }
    function get_stickers() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $db->objectBuilder()->orderBy('id', 'desc');

        $limit_stickers = 0;
        if (self::ActiveUser()->is_pro == '0') {
            $db->where('is_pro', '0');
            $limit_stickers = $config->not_pro_chat_stickers_limit - 1;
        }
        if (self::ActiveUser()->is_buy_stickers == '1') {
            $limit_stickers = 0;
        }
        if ( isGenderFree(self::ActiveUser()->gender) === true ) {
            $limit_stickers = 0;
        }
        $stickers_html = '';
        $stickers      = $db->get('stickers', null, array(
            'id',
            'file'
        ));
        $i             = 0;
        foreach ($stickers as $key => $value) {
            if ($limit_stickers > 0) {
                if ($i > $limit_stickers) {
                    continue;
                }
            }
            $stickers_html .= '<embed src="' . GetMedia($value->file) . '" data-id="' . $value->id . '" class="stiker_chat"></embed>';
            $i++;
        }
        if ($limit_stickers > 0) {
            if( $config->pro_system == 1 ) {
                $stickers_html .= '<hr><p>' . __('Wanna get more? get premium! OR get new stickers for') . ' ' . $config->not_pro_chat_stickers_credit . ' ' . __('credits') . '</p>';
            }else{
                $stickers_html .= '<hr><p>' . __('Wanna get more? get new stickers for') . ' ' . $config->not_pro_chat_stickers_credit . ' ' . __('credits') . '</p>';
            }
            if (self::ActiveUser()->balance >= $config->not_pro_chat_stickers_credit) {
                $stickers_html .= '<div class="dt_stk_buy_btn">';
                if( $config->pro_system == 1 ) {
                    $stickers_html .= '<a href="' . $config->uri . '/pro" data-ajax="/pro" class="btn btn-flat waves-effect prem">' . __('Get premium') . '</a>';
                }
                $stickers_html .= '<button data-userid="' . self::ActiveUser()->id . '" id="btn_buystikcers" class="btn btn-flat waves-effect stck_by">' . __('Buy Now!') . '</button></div>';
            } else {
                $stickers_html .= '<div class="dt_stk_buy_btn">';
                if( $config->pro_system == 1 ) {
                    $stickers_html .= '<a href="' . $config->uri . '/pro" data-ajax="/pro" class="btn btn-flat waves-effect prem">' . __('Get premium') . '</a>';
                }
                $stickers_html .= '<a href="' . $config->uri . '/credit" data-ajax="/credit" class="btn btn-flat waves-effect stck_by">' . __('Buy Credits') . '</a></div>';
            }
        }
        return array(
            'status' => 200,
            'stickers' => $stickers_html
        );
    }
    function delete_messages() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $from = self::ActiveUser()->id;
        $to   = '';
        if (isset($_POST[ 'to' ]) && !empty($_POST[ 'to' ])) {
            $to = (int) Secure(str_replace('*-*!*~*#*$*%*', '', strrev(base64_decode($_POST[ 'to' ]))));
        }
        if (!is_numeric($to)) {
            return array(
                'status' => 200,
                'message' => __('Hack attempt.')
            );
        }
        $db->where('`to`', $to)->where('`from`', $from)->update('messages', array(
            'from_delete' => '1'
        ));
        $db->where('`to`', $from)->where('`from`', $to)->update('messages', array(
            'to_delete' => '1'
        ));
        $db->where('sender_id', $to)->where('receiver_id', $from)->update('conversations', array(
            'from_delete' => '1'
        ));
        $db->where('sender_id', $from)->where('receiver_id', $to)->update('conversations', array(
            'to_delete' => '1'
        ));
        DeleteChatFiles($from,$to);
        $db->where('from_delete', '1')->where('to_delete', '1')->delete('messages');
        $db->where('from_delete', '1')->where('to_delete', '1')->delete('conversations');
        return array(
            'status' => 200
        );
    }
    function get_conversation_list($accepted = 1) {
        global $config;
        if(isset($_GET['accepted'])){
            if((int)$_GET['accepted'] === 0 || (int)$_GET['accepted'] === 1){
                $accepted = (int)$_GET['accepted'];
            }
        }
        global $db, $config, $_BASEPATH, $_DS;
        $site_url   = $config->uri;
        $theme_url  = $config->uri . '/themes/' . $config->theme . '/';
        $theme_path = $_BASEPATH . 'themes' . $_DS . $config->theme . $_DS;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $data               = array(
            'status' => 200,
            'requests' => 0,
            'conversation' => 1
        );
        $data['requests'] = GetChatRequestCount((int) self::ActiveUser()->id);

        $messages           = LoadEndPointResource('messages');
        $conversations      = ToObject($messages->getConversationList((int) self::ActiveUser()->id, 500));
        $OnlineUsers        = 0;
        $conversations_html = '';
        $mode               = route(4);
        foreach ($conversations as $key => $msg) {
            if((int)abs(((strtotime(date('Y-m-d H:i:s')) - $msg->user->lastseen))) < 60 && (int)$msg->user->online == 1){
                $OnlineUsers++;
            }
        }
        if (!empty($conversations)) {
            if (count((array) $conversations) > 0) {
                $is_online1 = 0;
                $is_online2 = 0;
                foreach ($conversations as $key => $conversation) {
//                    if($accepted === 1){
//                        $data['requests'] = 0;
//                    }else {
                        if($conversation->accepted === 0) {
                            if((int)$conversation->conversation_status === 1) {
                                //$data['requests'] = $data['requests'] + 1;
                            }
                        }
                    //}

                    if ((int)abs(((strtotime(date('Y-m-d H:i:s')) - $conversation->user->lastseen))) < 60 && (int)$conversation->user->online == 1) {
                        $is_online1 = 1;
                    } else {
                        $is_online1 = 0;
                    }

                    if($config->message_request_system == 'on') {

                        if( $accepted == 1 && (int)$conversation->conversation_status == 1 ){
                            if (file_exists($theme_path . 'main' . $_DS . 'conversation-list.php')) {
                                ob_start();
                                require($theme_path . 'main' . $_DS . 'conversation-list.php');
                                $conversations_html .= ob_get_contents();
                                ob_end_clean();
                            }
                        }

                        if( $accepted == 0 && ( (int)$conversation->conversation_status == 0 || (int)$conversation->conversation_status == 2 ) ){
                            if (file_exists($theme_path . 'main' . $_DS . 'conversation-list.php')) {
                                ob_start();
                                require($theme_path . 'main' . $_DS . 'conversation-list.php');
                                $conversations_html .= ob_get_contents();
                                ob_end_clean();
                            }
                        }
//                        if ($conversation->accepted === $accepted || (int)$conversation->conversation_status == 1 ) {
//
//
//
//                        }else{
//
//
//                        }


                    }else{

                        if (file_exists($theme_path . 'main' . $_DS . 'conversation-list.php')) {
                            ob_start();
                            require($theme_path . 'main' . $_DS . 'conversation-list.php');
                            $conversations_html .= ob_get_contents();
                            ob_end_clean();
                        }

                    }

                    unset($conversations->{$key});

                }
            }
        }
        $db->where('id', self::ActiveUser()->id)->update('users', array(
            'lastseen' => time()
        ));
        $_SESSION[ 'userEdited' ] = true;
        $data[ 'conversations' ]  = $conversations_html;
        $data[ 'OnlineUsers' ]    = $OnlineUsers;
        $data[ 'conversatio' ]    = $conversations;
        return $data;
    }
    function get_chat_conversation() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $data    = array(
            'status' => 200,
            'conversations' => ''
        );
        $from    = (int) route(4);
        $lastmsg = (int) route(5);
        if ($from > 0) {
            $lastseenid              = $db->objectBuilder()->where('`from`', (int) auth()->id)->where('`to`', (int) $from)->where('seen', '0', '>')->orderBy('id', 'DESC')->getValue('messages', 'id');
            $conversationMessages    = generate_chat_messages_convirsation((int) auth()->id, (int) $from, 0, false, (($lastmsg > 0) ? $lastmsg : 0));
            $data[ 'conversations' ] = $conversationMessages;
            $data[ 'from' ]          = $from;
            $data[ 'to' ]            = auth()->id;
            $data[ 'lastseenid' ]    = $lastseenid;
            $data[ 'time' ]          = time();
        }
        return $data;
    }
    function createNewConversation() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $receiver_id = '';
        if (isset($_GET[ 'receiver_id' ]) && !empty($_GET[ 'receiver_id' ])) {
            $receiver_id = (int) Secure($_GET[ 'receiver_id' ]);
        }
        if ($receiver_id == '') {
            return array(
                'status' => 400,
                'message' => __('Bad Request')
            );
        }
        $_msg = LoadEndPointResource('messages');
        if ($_msg) {
            $saved = $_msg->createNewConversation($receiver_id);
            if ($saved) {
                return array(
                    'status' => 200,
                    'message' => ''
                );
            } else {
                return array(
                    'status' => 400,
                    'message' => ''
                );
            }
        } else {
            return array(
                'status' => 400,
                'message' => ''
            );
        }
    }
    function get_prev_messages() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $_from = str_replace(' ', '+', route(4));
        $from  = 0;
        if (!empty($_from)) {
            $from = (int) Secure(str_replace('*-*!*~*#*$*%*', '', strrev(base64_decode($_from))));
        }
        if (!is_numeric($from)) {
            return array(
                'status' => 200,
                'message' => __('Hack attempt.')
            );
        }
        $lastmsg = (int) route(5);
        $data  = array(
            'status' => 200,
            'conversations' => '',
            'from' => $_from,
            'lastmsg' => $lastmsg
        );
        if ($from > 0) {
            $lastseenid              = $db->objectBuilder()->where('`from`', (int) auth()->id)->where('`to`', (int) $from)->where('seen', '0', '>')->orderBy('id', 'DESC')->getValue('messages', 'id');
            $conversationMessages    = generate_chat_messages_convirsation((int) auth()->id, (int) $from, 0, false, (($lastmsg > 0) ? $lastmsg : 0), true);
            $data[ 'conversations' ] = $conversationMessages;
            $data[ 'from' ]          = $from;
            $data[ 'to' ]            = auth()->id;
            $data[ 'lastseenid' ]    = $lastseenid;
        }
        return $data;
    }
    function buystickers() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $_cost  = 0;
        $userid = 0;
        $error  = '';
        if (isset($_POST[ 'uid' ]) && !empty($_POST[ 'uid' ])) {
            $userid = Secure($_POST[ 'uid' ]);
        }
        if ($userid == 0) {
            $error = '<p>• ' . __('No user ID found.') . '</p>';
        }
        $_cost = $config->not_pro_chat_stickers_credit;
        if (self::ActiveUser()->balance >= $_cost) {
        } else {
            $error = '<p>• ' . __('No credit available.') . '</p>';
        }
        if ($error == '') {
            $saved = $db->where('id', self::ActiveUser()->id)->update('users', array(
                'is_buy_stickers' => '1',
                'balance' => $db->dec($_cost)
            ));
            if ($saved) {
                $_SESSION[ 'userEdited' ] = true;
                return array(
                    'status' => 200,
                    'current_credit' => self::ActiveUser()->balance - $_cost,
                    'message' => __('User buy stickers successfully.')
                );
            } else {
                $error = '<p>• Error while buy stickers.';
            }
        }
        if ($error !== '') {
            return array(
                'status' => 400,
                'message' => __('Error while save like.')
            );
        }
    }
    function buymore_chat_credit() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $_cost    = 0;
        $userid   = 0;
        $chat_uid = 0;
        $error    = '';
        if (isset($_POST[ 'uid' ]) && !empty($_POST[ 'uid' ])) {
            $userid = Secure($_POST[ 'uid' ]);
        }
        if ($userid == 0) {
            $error = '<p>• ' . __('No user ID found.') . '</p>';
        }
        if (isset($_POST[ 'chat_uid' ]) && !empty($_POST[ 'chat_uid' ])) {
            $chat_uid = Secure($_POST[ 'chat_uid' ]);
        }
        if ($chat_uid == 0) {
            $error = '<p>• ' . __('No chat user ID found.') . '</p>';
        }
        $_cost = $config->not_pro_chat_credit;
        if (self::ActiveUser()->balance >= $_cost) {
        } else {
            $error = '<p>• ' . __('No credit available.') . '</p>';
        }
        if ($error == '') {
            $saved = $db->insert('user_chat_buy', array(
                'user_id' => self::ActiveUser()->id,
                'chat_user_id' => $chat_uid,
                'created_at' => date('Y-m-d H:i:s')
            ));
            if ($saved) {
                $db->where('id', self::ActiveUser()->id)->update('users', array(
                    'balance' => $db->dec($_cost)
                ));
                $_SESSION[ 'userEdited' ] = true;
                return array(
                    'status' => 200,
                    'current_credit' => self::ActiveUser()->balance - $_cost,
                    'message' => __('User buy new chat successfully.')
                );
            } else {
                $error = '<p>• ' . __('Error while buy more chat credit.') . '</p>';
            }
        }
        if ($error !== '') {
            return array(
                'status' => 400,
                'message' => __('Error while buy more chat credit.')
            );
        }
    }
    function accept_chat_request(){
        global $db, $config,$_BASEPATH,$_DS;
        if (self::ActiveUser() == NULL || !isset($_GET['route'])) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $route = Secure($_GET['route']);
        $notification = GetNotificationIdFromChatRequest($route);
        if($notification) {
            $from = $notification['notifier_id'];
            $to = $notification['recipient_id'];

            //delete notifications
            $status = $db->where('notifier_id', $from)->where('recipient_id', $to)->where('type', 'message')->where('url', $route)->delete('notifications');
            //update conversations
            $status = $db->where('sender_id', $to)->where('receiver_id', $from)->update('conversations',array('status' => '1'));
            $status = $db->where('sender_id', $from)->where('receiver_id', $to)->update('conversations',array('status' => '1'));

            if ($status == true) {

                $Notif = LoadEndPointResource('Notifications');
                if($Notif) {
                    $username = $db->where('id', $to)->getOne('users','username')['username'];
                    $Notif->createNotification(auth()->web_device_id, $to,$from, 'accept_chat_request', '', '/@' . $username . '/chat_request');
                }

                $html = '';
                $theme_path = $_BASEPATH . 'themes' . $_DS . self::Config()->theme . $_DS;
                $template   = $theme_path . 'main' . $_DS . 'chat-message-form.php';
                if (file_exists($template)) {
                        ob_start();
                        include $template;
                        $html .= ob_get_contents();
                        ob_end_clean();
                }

                return array(
                    'status' => 200,
                    'message' => __('Message sent'),
                    'notification' => $notification,
                    'form' => $html
                );
            }
        }else{
            return array(
                'status' => 400,
                'message' => __('Forbidden')
            );
        }

    }
    function decline_chat_request(){
        global $db, $config;
        if (self::ActiveUser() == NULL || !isset($_GET['route'])) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }

        $route = Secure($_GET['route']);
        $username = str_replace(array('/@','/chat_request'), '', $route);
        $uid = $db->where('username',$username)->getOne('users','id')['id'];
//        var_dump($route);
//        var_dump($username);
//        var_dump($uid);
//        var_dump(self::ActiveUser()->id);
//        exit();

        //$notification = GetNotificationIdFromChatRequest($route);
        //if($notification) {
        if( $uid > 0 ){
            $from = (int)self::ActiveUser()->id;//$notification['notifier_id'];
            $to = $uid;//$notification['recipient_id'];

            //delete notifications
            $status = $db->where('notifier_id', $from)->where('recipient_id', $to)->where('type', 'message')->where('url', $route)->delete('notifications');
            //update conversations
            $status = $db->where('sender_id', $to)->where('receiver_id', $from)->update('conversations',array('status' => '2'));
            $status = $db->where('sender_id', $from)->where('receiver_id', $to)->update('conversations',array('status' => '1'));
            //delete conversations
            //$status = $db->where('sender_id', $to)->where('receiver_id', $from)->delete('conversations');
            //$status = $db->where('sender_id', $from)->where('receiver_id', $to)->delete('conversations');
            //delete messages
            //$status = $db->where('`to`', $from)->where('`from`', $to)->delete('messages');
            //$status = $db->where('`to`', $to)->where('`from`', $from)->delete('messages');
            if ($status == true) {
                $Notif = LoadEndPointResource('Notifications');
                if($Notif) {
                    $username = $db->where('id', (int)self::ActiveUser()->id)->getOne('users','username')['username'];
                    $Notif->createNotification(auth()->web_device_id, (int)self::ActiveUser()->id, $to, 'decline_chat_request', '', '/@' . $username);
                }

                return array(
                    'status' => 200,
                    'message' => __('Message sent'),
                    //'notification' => $notification
                );
            }
        }else{
            return array(
                'status' => 400,
                'message' => __('Forbidden'),
                //'notification' => $notification
            );
        }
    }
    function create_new_video_call(){
        global $db, $config,$_LIBS,$_BASEPATH,$_DS;
        if (self::ActiveUser() == NULL || empty($_GET['user_id2']) || empty($_GET['user_id1']) || $_GET['user_id1'] != self::ActiveUser()->id ) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        require_once($_LIBS . 'twilio'.$_DS.'vendor'.$_DS.'autoload.php');
        $user_1       = userData($_GET['user_id1']);
        $user_2       = userData($_GET['user_id2']);
        $room_script  = sha1(rand(1111111, 9999999));
        $accountSid   = $config->video_accountSid;
        $apiKeySid    = $config->video_apiKeySid;
        $apiKeySecret = $config->video_apiKeySecret;
        $call_id      = substr(md5(microtime()), 0, 15);
        $call_id_2    = substr(md5(time()), 0, 15);
        $token        = new AccessToken($accountSid, $apiKeySid, $apiKeySecret, 3600, $call_id);
        $grant        = new VideoGrant();
        $grant->setRoom($room_script);
        $token->addGrant($grant);
        $token_ = $token->toJWT();
        $token2 = new AccessToken($accountSid, $apiKeySid, $apiKeySecret, 3600, $call_id_2);
        $grant2 = new VideoGrant();
        $grant2->setRoom($room_script);
        $token2->addGrant($grant2);
        $token_2    = $token2->toJWT();
        $insertData = CreateNewVideoCall(array(
            'access_token' => Secure($token_),
            'from_id' => Secure($_GET['user_id1']),
            'to_id' => Secure($_GET['user_id2']),
            'access_token_2' => Secure($token_2),
            'room_name' => $room_script
        ));
        if ($insertData > 0) {
            $wo['calling_user'] = userData($_GET['user_id2']);
//////            if (!empty($wo['calling_user']['ios_m_device_id']) && $wo['config']['ios_push_messages'] == 1) {
//////                $send_array = array(
//////                    'send_to' => array(
//////                        $wo['calling_user']['ios_m_device_id']
//////                    ),
//////                    'notification' => array(
//////                        'notification_content' => 'is calling you',
//////                        'notification_title' => $wo['calling_user']['name'],
//////                        'notification_image' => $wo['calling_user']['avatar'],
//////                        'notification_data' => array(
//////                            'call_type' => 'video',
//////                            'access_token_2' => $token_2,
//////                            'room_name' => $room_script,
//////                            'call_id' => $insertData
//////                        )
//////                    )
//////                );
//////                Wo_SendPushNotification($send_array,'ios_messenger');
//////            }
//////            if (!empty($wo['calling_user']['android_m_device_id']) && $wo['config']['android_push_messages'] == 1) {
//////                $send_array = array(
//////                    'send_to' => array(
//////                        $wo['calling_user']['android_m_device_id']
//////                    ),
//////                    'notification' => array(
//////                        'notification_content' => 'is calling you',
//////                        'notification_title' => $wo['calling_user']['name'],
//////                        'notification_image' => $wo['calling_user']['avatar'],
//////                        'notification_data' => array(
//////                            'call_type' => 'video',
//////                            'access_token_2' => $token_2,
//////                            'room_name' => $room_script,
//////                            'call_id' => $insertData
//////                        )
//////                    )
//////                );
//////                Wo_SendPushNotification($send_array,'android_messenger');
//////            }

            $html = '';
            $theme_path = $_BASEPATH . 'themes' . $_DS . $config->theme . $_DS;
            $template            = $theme_path . 'partails' . $_DS . 'calling.php';
            if (file_exists($template)) {
                ob_start();
                require($template);
                $html .= ob_get_contents();
                ob_end_clean();
            }

            $data = array(
                'status' => 200,
                'access_token' => $token_,
                'id' => $insertData,
                'url' => $config->uri . '/video-call/' . $insertData,
                'html' => $html,
                'text_no_answer' => __('No answer'),
                'text_please_try_again_later' => __('Please try again later.')
            );
        }
        header("Content-type: application/json");
        echo json_encode($data);
        exit();
    }
    function check_for_answer() {
        global $db, $config,$_LIBS,$_BASEPATH,$_DS;
        if (self::ActiveUser() == NULL || empty($_GET['id']) ) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $data = [];
        if (!empty($_GET['id'])) {
            $selectData = CheckCallAnswer($_GET['id']);
            if ($selectData !== false) {
                $data = ['idxxxx' => $selectData];
                $data = array(
                    'status' => 200,
                    'url' => $selectData['url'],
                    'text_answered' => __('Answered !'),
                    'text_please_wait' => __('Please wait..')
                );
            } else {
                $check_declined = CheckCallAnswerDeclined($_GET['id']);
                $data = ['id' => $check_declined];
                if ($check_declined) {
                    $data = array(
                        'status' => 400,
                        'text_call_declined' => __('Call declined'),
                        'text_call_declined_desc' => __('The recipient has declined the call, please try again later.')
                    );
                }
            }
        }
        header("Content-type: application/json");
        echo json_encode($data);
        exit();
    }
    function cancel_call(){
        global $conn;
        $user_id = Secure(self::ActiveUser()->id);
        $query   = mysqli_query($conn, "DELETE FROM `videocalles` WHERE `from_id` = '$user_id'");
        if ($query) {
            $data = array(
                'status' => 200
            );
        }
        header("Content-type: application/json");
        echo json_encode($data);
        exit();
    }
    function decline_call(){
        global $conn;
        if (!empty($_GET['id']) && !empty($_GET['type'])) {
            $id = Secure($_GET['id']);
            if ($_GET['type'] == 'video') {
                $query = mysqli_query($conn, "UPDATE `videocalles` SET `declined` = '1' WHERE `id` = '$id'");
            } else {
                $query = mysqli_query($conn, "UPDATE `audiocalls` SET `declined` = '1' WHERE `id` = '$id'");
            }
            if ($query) {
                $data = array(
                    'status' => 200
                );
            }
        }
        header("Content-type: application/json");
        echo json_encode($data);
        exit();
    }
    function answer_call(){
        global $conn,$_BASEPATH,$_DS,$config;
        if (!empty($_GET['id']) && !empty($_GET['type'])) {
            $id = Secure($_GET['id']);
            if ($_GET['type'] == 'audio') {
                $query = mysqli_query($conn, "UPDATE `audiocalls` SET `active` = 1 WHERE `id` = '$id'");
            } else {
                $query = mysqli_query($conn, "UPDATE `videocalles` SET `active` = 1 WHERE `id` = '$id'");
            }
            if ($query) {
                $data = array(
                    'status' => 200
                );
                if ($_GET['type'] == 'audio') {
                    $query = mysqli_query($conn, "SELECT * FROM `audiocalls` WHERE `id` = '{$id}'");
                    $sql   = mysqli_fetch_assoc($query);
                    if (!empty($sql) && is_array($sql)) {
                        $wo['incall']                 = $sql;
                        $wo['incall']['in_call_user'] = userData($sql['from_id']);
                        if ($wo['incall']['to_id'] == auth()->id) {
                            $wo['incall']['user']         = 1;
                            $wo['incall']['access_token'] = $wo['incall']['access_token'];
                        } else if ($wo['incall']['from_id'] == auth()->id) {
                            $wo['incall']['user']         = 2;
                            $wo['incall']['access_token'] = $wo['incall']['access_token_2'];
                        }
                        $user_1               = userData($wo['incall']['from_id']);
                        $user_2               = userData($wo['incall']['to_id']);
                        $wo['incall']['room'] = $wo['incall']['room_name'];


                        $html = '';
                        $theme_path = $_BASEPATH . 'themes' . $_DS . $config->theme . $_DS;
                        $template            = $theme_path . 'partails' . $_DS . 'modals' . $_DS . 'talking.php';
                        if (file_exists($template)) {
                            ob_start();
                            require($template);
                            $html .= ob_get_contents();
                            ob_end_clean();
                        }


                        $data['calls_html']   = $html;
                    }
                }
            }
        }
        header("Content-type: application/json");
        echo json_encode($data);
        exit();
    }
    function close_call(){
        global $conn;
        if (!empty($_GET['id'])) {
            $id    = Secure($_GET['id']);
            $query = mysqli_query($conn, "UPDATE `audiocalls` SET `declined` = '1' WHERE `id` = '$id'");
            if ($query) {
                $data = array(
                    'status' => 200
                );
            }
        }
        header("Content-type: application/json");
        echo json_encode($data);
        exit();
    }
    function create_new_audio_call(){
        global $db, $config,$_LIBS,$_BASEPATH,$_DS;
        if (self::ActiveUser() == NULL || empty($_GET['user_id2']) || empty($_GET['user_id1']) || $_GET['user_id1'] != self::ActiveUser()->id ) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }

        require_once($_LIBS . 'twilio'.$_DS.'vendor'.$_DS.'autoload.php');
        $user_1       = userData($_GET['user_id1']);
        $user_2       = userData($_GET['user_id2']);
        $room_script  = sha1(rand(1111111, 9999999));
        $accountSid   = $config->video_accountSid;
        $apiKeySid    = $config->video_apiKeySid;
        $apiKeySecret = $config->video_apiKeySecret;
        $call_id      = substr(md5(microtime()), 0, 15);
        $call_id_2    = substr(md5(time()), 0, 15);
        $token        = new AccessToken($accountSid, $apiKeySid, $apiKeySecret, 3600, $call_id);
        $grant        = new VideoGrant();
        $grant->setRoom($room_script);
        $token->addGrant($grant);
        $token_ = $token->toJWT();
        $token2 = new AccessToken($accountSid, $apiKeySid, $apiKeySecret, 3600, $call_id_2);
        $grant2 = new VideoGrant();
        $grant2->setRoom($room_script);
        $token2->addGrant($grant2);
        $token_2    = $token2->toJWT();
        $insertData = CreateNewAudioCall(array(
            'access_token' => Secure($token_),
            'from_id' => Secure($_GET['user_id1']),
            'to_id' => Secure($_GET['user_id2']),
            'access_token_2' => Secure($token_2),
            'room_name' => $room_script
        ));
        if ($insertData > 0) {
            $wo['calling_user'] = userData($_GET['user_id2']);
//            if (!empty($wo['calling_user']['ios_m_device_id']) && $wo['config']['ios_push_messages'] == 1) {
//                $send_array = array(
//                    'send_to' => array(
//                        $wo['calling_user']['ios_m_device_id']
//                    ),
//                    'notification' => array(
//                        'notification_content' => 'is calling you',
//                        'notification_title' => $wo['calling_user']['name'],
//                        'notification_image' => $wo['calling_user']['avatar'],
//                        'notification_data' => array(
//                            'call_type' => 'audio',
//                            'access_token_2' => Wo_Secure($token_2),
//                            'room_name' => $room_script,
//                            'call_id' => $insertData
//                        )
//                    )
//                );
//                Wo_SendPushNotification($send_array,'ios_messenger');
//            }
//            if (!empty($wo['calling_user']['android_m_device_id']) && $wo['config']['android_push_messages'] == 1) {
//                $send_array = array(
//                    'send_to' => array(
//                        $wo['calling_user']['android_m_device_id']
//                    ),
//                    'notification' => array(
//                        'notification_content' => 'is calling you',
//                        'notification_title' => $wo['calling_user']['name'],
//                        'notification_image' => $wo['calling_user']['avatar'],
//                        'notification_data' => array(
//                            'call_type' => 'audio',
//                            'access_token_2' => Wo_Secure($token_2),
//                            'room_name' => $room_script,
//                            'call_id' => $insertData
//                        )
//                    )
//                );
//                Wo_SendPushNotification($send_array,'android_messenger');
//            }

            $html = '';
            $theme_path = $_BASEPATH . 'themes' . $_DS . $config->theme . $_DS;
            $template            = $theme_path . 'partails' . $_DS . 'modals' . $_DS . 'calling-audio.php';
            if (file_exists($template)) {
                ob_start();
                require($template);
                $html .= ob_get_contents();
                ob_end_clean();
            }

            $data = array(
                'status' => 200,
                'access_token' => $token_,
                'id' => $insertData,
                'html' => $html,
                'text_no_answer' => __('No answer'),
                'text_please_try_again_later' => __('Please try again later.')
            );
        }
        header("Content-type: application/json");
        echo json_encode($data);
        exit();
    }
    function check_for_audio_answer(){
        global $conn,$db, $config,$_LIBS,$_BASEPATH,$_DS;
        $data = [];
        if (!empty($_GET['id'])) {
            $selectData = CheckAudioCallAnswer($_GET['id']);
            if ($selectData !== false) {
                $data  = array(
                    'status' => 200,
                    'text_answered' => __('Answered !'),
                    'text_please_wait' => __('Please wait..')
                );
                $id    = Secure($_GET['id']);
                $query = mysqli_query($conn, "SELECT * FROM `audiocalls` WHERE `id` = '{$id}'");
                $sql   = mysqli_fetch_assoc($query);
                if (!empty($sql) && is_array($sql)) {
                    $wo['incall']                 = $sql;
                    $wo['incall']['in_call_user'] = userData($sql['to_id']);
                    if ($wo['incall']['to_id'] == auth()->id) {
                        $wo['incall']['user']         = 1;
                        $wo['incall']['access_token'] = $wo['incall']['access_token'];
                    } else if ($wo['incall']['from_id'] == auth()->id) {
                        $wo['incall']['user']         = 2;
                        $wo['incall']['access_token'] = $wo['incall']['access_token_2'];
                    }
                    $user_1               = userData($wo['incall']['from_id']);
                    $user_2               = userData($wo['incall']['to_id']);
                    $wo['incall']['room'] = $wo['incall']['room_name'];

                    $html = '';
                    $theme_path = $_BASEPATH . 'themes' . $_DS . $config->theme . $_DS;
                    $template            = $theme_path . 'partails' . $_DS . 'modals' . $_DS . 'talking.php';
                    if (file_exists($template)) {
                        ob_start();
                        require($template);
                        $html .= ob_get_contents();
                        ob_end_clean();
                    }

                    $data['calls_html']   = $html;
                }
            } else {
                $check_declined = CheckAudioCallAnswerDeclined($_GET['id']);
                if ($check_declined) {
                    $data = array(
                        'status' => 400,
                        'text_call_declined' => __('Call declined'),
                        'text_call_declined_desc' => __('The recipient has declined the call, please try again later.')
                    );
                }
            }
        }
        header("Content-type: application/json");
        echo json_encode($data);
        exit();
    }
} 