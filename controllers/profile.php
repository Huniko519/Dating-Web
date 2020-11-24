<?php
Class Profile extends Theme {
    public static $page_data = array('title' => 'profile');
    public static $partial = 'profile';
    public static function init_data() {
        global $config;
        parent::init_data();
        parent::$data['name'] = self::$partial;
    }
    public static function show($partial = '') {
        global $config;
        self::init_data();
        if (!empty(route(1))) {
            $user = array();
            $_user = LoadEndPointResource('users');
            if( $_user ) {
                $user = $_user->get_user_profile(Secure(substr(route(1), 1),array('*'),true));
            }
            $full_name = $user->first_name . ' ' . $user->last_name;
            if ($full_name == ' ') {
                $full_name = $user->username;
            }
            parent::$data['title'] = $full_name . ' . ' . $config->site_name;
            parent::$data['keywords'] = $user->interest;
            parent::$data['description'] = $user->about;

            parent::$data['image'] =$user->avater->full;

            parent::show(self::$partial);
        } else {
            header('location: ' . $config->uri);
            exit();
        }
    }
}