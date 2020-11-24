<?php
Class SettingsBlocked extends Theme {
    public static $page_data = array('title' => 'Profile Settings Blocked');
    public static $partial = 'settings-blocked';
    public static function init_data() {
        global $config;
        parent::init_data();
        if (isset(self::$page_data['title']) && self::$page_data['title'] !== '') {
            parent::$data['title'] = ucfirst(__('Profile Settings Blocked')) . ' . ' . $config->site_name;
        }
        parent::$data['name'] = self::$partial;
        parent::$data['blocked'] = self::BlockedData();
    }
    public static function show($partial = array()) {
        self::init_data();
        parent::show(self::$partial);
    }
    public static function BlockedData() {
        global $_AJAX, $_CONTROLLERS;
        $data            = '';
        $ajax_class      = realpath($_CONTROLLERS . 'aj.php');
        $ajax_class_file = realpath($_AJAX . 'loadmore.php');
        if (file_exists($ajax_class_file)) {
            require_once $ajax_class;
            require_once $ajax_class_file;
            $_POST['page'] = 1;
            $loadmore      = new Loadmore();
            $blocked_users   = $loadmore->blocked_users();
            if (isset($blocked_users['html'])) {
                $data = $blocked_users['html'];
            }
        }
        return $data;
    }
}
