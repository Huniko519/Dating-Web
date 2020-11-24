<?php
Class Steps extends Theme {
    public static $page_data = array('title' => 'Profile steps');
    public static $partial = 'steps';
    public static function init_data() {
        global $config;
        parent::init_data();
        parent::$data['title'] = GetPageTitle(self::$partial);
        parent::$data['keywords'] = GetPageKeyword(self::$partial);
        parent::$data['description'] = GetPageDescription(self::$partial);
        // if (isset(self::$page_data['title']) && self::$page_data['title'] !== '') {
        //     parent::$data['title'] = ucfirst(__('Profile steps')) . ' . ' . $config->site_name;
        // }
        parent::$data['name'] = self::$partial;
    }
    public static function show($partial = '') {
//        global $db;
//        self::init_data();
//        if (isset($_SESSION['JWT'])) {
//            $stop = true;
//            if( self::Config()->image_verification == 1 && self::Config()->pending_verification == 1 && self::ActiveUser()->approved_at == 0 ){
//                $stop = false;
//            }
//
//            if( self::ActiveUser()->start_up == 3 ){
//                if($stop) {
//                    header('location: ' . self::Config()->uri);
//                    exit();
//                }
//            }
//        }
//        parent::show(self::$partial);
        global $db;
        self::init_data();
        if (isset($_SESSION['JWT'])) {
            $stop = false;
            if( (int)self::Config()->image_verification == 1 && (int)self::Config()->pending_verification == 1 && (int)self::ActiveUser()->approved_at == 0 ){
                $stop = true;
            }
            if( self::ActiveUser()->start_up == 3 ){
                if($stop) {
                    header('location: ' . self::Config()->uri);
                    exit();
                }
            }
        }
        parent::show(self::$partial);
    }
}