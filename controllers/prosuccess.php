<?php
Class ProSuccess extends Theme {
    public static $page_data = array('title' => 'Premium Membership Success');
    public static $partial = 'pro-success';
    public static function init_data() {
        global $config;
        parent::init_data();
        if (isset(self::$page_data['title']) && self::$page_data['title'] !== '') {
            parent::$data['title'] = ucfirst(__('Premium Membership Success')) . ' . ' . $config->site_name;
        }
        parent::$data['name'] = self::$partial;
    }
    public static function show($partial = array()) {
        self::init_data();
        parent::show(self::$partial);
    }
}