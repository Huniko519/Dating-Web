<?php
Class SettingsSessions extends Theme {
    public static $page_data = array('title' => 'Manage Sessions');
    public static $partial = 'settings-sessions';
    public static function init_data() {
        global $config;
        parent::init_data();
        if (isset(self::$page_data['title']) && self::$page_data['title'] !== '') {
            parent::$data['title'] = ucfirst(__('Manage Sessions')) . ' . ' . $config->site_name;
        }
        parent::$data['name'] = self::$partial;
    }
    public static function show($partial = array()) {
        self::init_data();
        parent::show(self::$partial);

    }
}
