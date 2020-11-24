<?php
Class SettingsEmail extends Theme {
    public static $page_data = array('title' => 'Profile Email Settings');
    public static $partial = 'settings-email';
    public static function init_data() {
        global $config;
        parent::init_data();
        if (isset(self::$page_data['title']) && self::$page_data['title'] !== '') {
            parent::$data['title'] = ucfirst(__('Profile Email Settings')) . ' . ' . $config->site_name;
        }
        parent::$data['name'] = self::$partial;
    }
    public static function show($partial = array()) {
        self::init_data();
        parent::show(self::$partial);
    }
}
