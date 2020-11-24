<?php
Class Login extends Theme {
    public static $page_data = array('title' => 'Login');
    public static $partial = 'login';
    public static function init_data() {
        global $config;
        parent::init_data();
        parent::$data['title'] = GetPageTitle(self::$partial);
        parent::$data['keywords'] = GetPageKeyword(self::$partial);
        parent::$data['description'] = GetPageDescription(self::$partial);
        // if (isset(self::$page_data['title']) && self::$page_data['title'] !== '') {
        //     parent::$data['title'] = ucfirst(__('Login')) . ' . ' . $config->site_name;
        // }
        parent::$data['name'] = self::$partial;
    }
    public static function show($partial = '') {
        global $db;
        self::init_data();
        if (isset($_SESSION['JWT'])) {
            $is_login = $db->where('web_token', $_SESSION['JWT']->web_token)->getOne('users');
            if (!empty($is_login)) {
                header('location: ' . self::Config()->uri);
                exit();
            }
        }
        parent::show(self::$partial);
    }
}