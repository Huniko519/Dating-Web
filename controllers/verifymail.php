<?php
Class VerifyMail extends Theme {
    public static $page_data = array('title' => 'Verify E-Mail address');
    public static $partial = 'verifymail';
    public static function init_data() {
        global $config;
        parent::init_data();
        parent::$data['title'] = GetPageTitle(self::$partial);
        parent::$data['keywords'] = GetPageKeyword(self::$partial);
        parent::$data['description'] = GetPageDescription(self::$partial);
        // if (isset(self::$page_data['title']) && self::$page_data['title'] !== '') {
        //     parent::$data['title'] = ucfirst(__('Verify E-Mail address')) . ' . ' . $config->site_name;
        // }
        parent::$data['name'] = self::$partial;
    }
    public static function show($partials = array()) {
        self::init_data();
        parent::show(self::$partial);
    }
}