<?php
Class Disliked extends Theme {
    public static $page_data = array('title' => 'People i disliked');
    public static $partial = 'disliked';
    public static function init_data() {
        global $config;
        parent::init_data();
        parent::$data['title'] = GetPageTitle(self::$partial);
        parent::$data['keywords'] = GetPageKeyword(self::$partial);
        parent::$data['description'] = GetPageDescription(self::$partial);
        // if (isset(self::$page_data['title']) && self::$page_data['title'] !== '') {
        //     parent::$data['title'] = ucfirst(__('People i disliked')) . ' . ' . $config->site_name;
        // }
        parent::$data['name']     = self::$partial;
        parent::$data['disliked'] = self::DisLikedData();
    }
    public static function show($partial = array()) {
        self::init_data();
        parent::show(self::$partial);
    }
    public static function DisLikedData() {
        global $_AJAX, $_CONTROLLERS;
        $data            = '';
        $ajax_class      = realpath($_CONTROLLERS . 'aj.php');
        $ajax_class_file = realpath($_AJAX . 'loadmore.php');
        if (file_exists($ajax_class_file)) {
            require_once $ajax_class;
            require_once $ajax_class_file;
            $_POST['page'] = 1;
            $loadmore      = new Loadmore();
            $match_users   = $loadmore->disliked_users();
            if (isset($match_users['html'])) {
                $data = $match_users['html'];
            }
        }
        return $data;
    }
}