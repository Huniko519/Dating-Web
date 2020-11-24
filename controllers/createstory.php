<?php
Class CreateStory extends Theme {
    public static $page_data = array('title' => 'Create story');
    public static $partial = 'create-story';
    public static function init_data() {
        global $config;
        parent::init_data();
        if (isset(self::$page_data['title']) && self::$page_data['title'] !== '') {
            parent::$data['title'] = ucfirst(__('Create story')) . ' . ' . $config->site_name;
        }
        parent::$data['name'] = self::$partial;
        parent::$data['users'] = self::listusers();
    }
    public static function show($partial = array()) {
        self::init_data();
        parent::show(self::$partial);
    }
    public static function listusers(){
        global $db;
        $data = array();
        $users = $db->objectBuilder()->rawQuery("SELECT * FROM `users` WHERE `src` != 'Fake'");
        $currentuser = self::ActiveUser()->username;
        foreach ($users as $user) {
            if( $currentuser !== $user->username ) {
                $data[$user->username] = GetMedia($user->avater);
            }
        }
        return json_encode($data);
    }
}