<?php
Class Article extends Theme {
    public static $page_data = array('title' => 'Article');
    public static $partial = 'article';
    public static function init_data() {
        global $config;
        parent::init_data();
        if (isset(self::$page_data['title']) && self::$page_data['title'] !== '') {
            parent::$data['title'] = __('Article');
        }
        parent::$data['name'] = self::$partial;
    }
    public static function show($partial = '') {
        global $config,$db;
        self::init_data();

        if (!empty(route(2))) {

            $arr = explode("_",route(2));
            $article      = $db->where('id', Secure((int)$arr[0]) )->getOne('blog',array('*'));
            if( !$article ){
                header('location: ' . $config->uri);
                exit();
            }else{
                if( !isset( $_SESSION['blog_view'][Secure((int)$arr[0])] ) ) {
                    $db->where('id', Secure((int)$arr[0]))->update('blog', array('view' => $db->inc()));
                    $_SESSION['blog_view'][Secure((int)$arr[0])] = true;
                }
            }

            $article['url'] = '';
            $quote = $article['title'];
            if ($quote !== '') {
                parent::$data['title'] = $quote . ' . ' . $config->site_name;
                parent::$data['keywords'] = $quote;
                parent::$data['description'] = $article['description'];

                $article['url'] = urlencode( $config->uri . '/' . $article['id'] . '_' . url_slug(html_entity_decode($article['title'])) );

                parent::$data['image'] = GetMedia($article['thumbnail']);
            }

            parent::$data['article'] = $article;

            parent::show(self::$partial);
        } else {
            header('location: ' . $config->uri);
            exit();
        }
    }
}