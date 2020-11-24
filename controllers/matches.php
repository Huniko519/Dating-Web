<?php
Class Matches extends Theme {
    public static $page_data = array();
    public static $partial = 'matches';
    public static function init_data() {
        global $config;
        parent::init_data();

        parent::$data['title'] = self::ActiveUser()->full_name . ' ' . GetPageTitle(self::$partial);
        parent::$data['keywords'] = GetPageKeyword(self::$partial);
        parent::$data['description'] = GetPageDescription(self::$partial);

        parent::$data['name']    = self::$partial;
        parent::$data['matches'] = self::MatchesData();
    }
    public static function show($partial = '') {
        self::init_data();
        parent::show(self::$partial);
    }
    public static function MatchesData() {
        global $_AJAX, $_CONTROLLERS;
        $data            = '';
        $ajax_class      = realpath($_CONTROLLERS . 'aj.php');
        $ajax_class_file = realpath($_AJAX . 'loadmore.php');
        if (file_exists($ajax_class_file)) {
            require_once $ajax_class;
            require_once $ajax_class_file;
            $_POST['page'] = 1;
            $loadmore      = new Loadmore();
            $match_users   = $loadmore->matches();
            if (isset($match_users['html'])) {
                $data = $match_users['html'];
            }
        }
        return $data;
    }
}