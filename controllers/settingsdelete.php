<?php
Class SettingsDelete extends Theme {
    public static $page_data = array('title' => 'Delete Profile');
    public static $partial = 'settings-delete';
    public static function init_data() {
        global $config;
        parent::init_data();
        if (isset(self::$page_data['title']) && self::$page_data['title'] !== '') {
            parent::$data['title'] = ucfirst(__('Delete Profile')) . ' . ' . $config->site_name;
        }
        parent::$data['name'] = self::$partial;
    }
    public static function show($partial = array()) {
        self::init_data();
        parent::show(self::$partial);
    }
}
