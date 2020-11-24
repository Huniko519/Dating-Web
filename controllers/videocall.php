<?php
Class VideoCall extends Theme {
    public static $page_data = array('title' => 'Video Call');
    public static $partial = 'video-call';
    public static function init_data() {
        global $config;

        if ($config->video_chat == 0) {
            header("Location: " . $config->uri);
            exit();
        }
        parent::init_data();
        parent::$data['title'] = GetPageTitle(self::$partial);
        parent::$data['keywords'] = GetPageKeyword(self::$partial);
        parent::$data['description'] = GetPageDescription(self::$partial);
        // if (isset(self::$page_data['title']) && self::$page_data['title'] !== '') {
        //     parent::$data['title'] = __('Video Call') . ' . ' . $config->site_name;
        // }
        parent::$data['name'] = self::$partial;

        $id = intval(Secure(route(2)));
        $data2 = GetAllDataFromCallID($id);
        if (!$data2) {
            header("Location: " . $config->uri);
            exit();
        }

        parent::$data['video_call']      = $data2;
        if (parent::$data['video_call']['to_id'] == auth()->id) {
            parent::$data['video_call']['user'] = 1;
            parent::$data['video_call']['access_token'] = parent::$data['video_call']['access_token'];
            //parent::$data['video_call']['call_id'] = parent::$data['video_call']['call_id_2'];
        } else if (parent::$data['video_call']['from_id'] == auth()->id) {
            parent::$data['video_call']['user'] = 2;
            parent::$data['video_call']['access_token'] = parent::$data['video_call']['access_token_2'];
            //parent::$data['video_call']['call_id'] = parent::$data['video_call']['call_id'];
        } else {
            header("Location: " . $config->uri);
            exit();
        }

        $user_1 = userData(parent::$data['video_call']['from_id']);
        $user_2 = userData(parent::$data['video_call']['to_id']);
        parent::$data['video_call']['room'] = $user_1->username . '_' . $user_2->username;
        if (parent::$data['video_call']['from_id'] == auth()->id) {
            $user_id = Secure(auth()->id);
        }
    }
    public static function show($partial = array()) {
        self::init_data();
        parent::show(self::$partial);
    }
}