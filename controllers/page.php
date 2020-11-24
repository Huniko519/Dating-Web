<?php
Class Page extends Theme {
    public static $page_data = array('title' => 'page');
    public static $partial = 'page';
    public static function init_data() {
        global $config;
        parent::init_data();

        $page_name = route(2);
        if($page_name == ''){
            header('location: ' . $config->uri);
            exit();
        }
        $CustomPage = GetCustomPage($page_name);
        if($CustomPage == null){
            header('location: ' . $config->uri);
            exit();
        }
        parent::$data['title'] = $CustomPage['page_title'] . ' . ' . $config->site_name;
        parent::$data['name'] = $CustomPage['page_name'];
        parent::$data['content'] = $CustomPage['page_content'];
        parent::$data['page_type'] = $CustomPage['page_type'];
    }
    public static function show($partial = '') {
        self::init_data();
        parent::show(self::$partial);
    }
}