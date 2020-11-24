<?php
function SessionStart(){
    global $app;
    if (session_status() != PHP_SESSION_NONE) {
        return;
    }
    ini_set('session.hash_bits_per_character', 5);
    ini_set('session.serialize_handler', 'php_serialize');
    ini_set('session.use_only_cookies', 1);
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params(
        $cookieParams['lifetime'],
        $cookieParams['path'],
        $cookieParams['domain'],
        false,
        true
    );
    session_name(strtolower($app));
    session_start();
}
SessionStart();
$config = new stdClass();
function LoadConfig() {
    global $db,$config,$site_url;
    $result = $db->get('options',null,array('option_name','option_value'));
    if (!empty($result)) {
        foreach ($result as $key => $val) {
            $config->{$val->option_name} = $val->option_value;
        }
        if( $config->default_language == 'arabic' ){
            $config->is_rtl = true;
        }else{
            $config->is_rtl = false;
        }

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        $config->uri = $protocol . str_replace(array("https://","http://"), '' , $site_url);
    }
    return $config;
}
$config = LoadConfig();
function reset_langs(){
    unset($_SESSION['lang']);
    unset($_SESSION['gender']);
    unset($_SESSION['language']);
    unset($_SESSION['height']);
    unset($_SESSION['hair_color']);
    unset($_SESSION['relationship']);
    unset($_SESSION['work_status']);
    unset($_SESSION['education']);
    unset($_SESSION['ethnicity']);
    unset($_SESSION['body']);
    unset($_SESSION['character']);
    unset($_SESSION['children']);
    unset($_SESSION['friends']);
    unset($_SESSION['pets']);
    unset($_SESSION['live_with']);
    unset($_SESSION['car']);
    unset($_SESSION['religion']);
    unset($_SESSION['smoke']);
    unset($_SESSION['drink']);
    unset($_SESSION['travel']);
    unset($_SESSION['notification']);
}
$lang  = new stdClass();
function GetActiveLang(){
    global $config;
    $lang = $config->default_language;
//    if( isset( $_SESSION['activeLang'] ) && !isset( $_COOKIE['activeLang'] ) ){
//        $lang = $_SESSION['activeLang'];
//    }
    if( isset( $_COOKIE['activeLang'] ) ){
        $lang = $_COOKIE['activeLang'];
    }
    return $lang;
}
function LoadLanguage() {
    global $db,$config,$lang;
    if( isset( $_GET['language'] ) && $_GET['language'] !== '' ){
        //Dataset::reset();
        //$_SESSION['activeLang'] = Secure($_GET['language']);
        setcookie("activeLang", Secure($_GET['language']), time() + (10 * 365 * 24 * 60 * 60), '/');
    }
    $dafault_lang = GetActiveLang();//$config->default_language;
//    if( !isset( $_SESSION['activeLang'] ) ){
//        $_SESSION['activeLang'] = $config->default_language;
//    }
//    if( isset( $_COOKIE['activeLang'] ) ){
//        $dafault_lang = $_COOKIE['activeLang'];
//    }else {
//        if (isset($_SESSION['activeLang'])) {
//            $dafault_lang = $_SESSION['activeLang'];
//        }
//    }

    $result = $db->arrayBuilder()->get('langs',null,array('lang_key','english',$dafault_lang));
    if (!empty($result)) {
        foreach ($result as $key => $val) {
            if(!empty($val['lang_key'])) {
                if (is_null($val[$dafault_lang]) || $val[$dafault_lang] == '' || empty($val[$dafault_lang])) {
                    $lang->{$val['lang_key']} = $val['english'];
                } else {
                    $lang->{$val['lang_key']} = $val[$dafault_lang];
                }
            }
        }
    }
    return $lang;
}
function ToArray($obj) {
    if (is_object($obj))
        $obj = (array) $obj;
    if (is_array($obj)) {
        $new = array();
        foreach ($obj as $key => $val) {
            $new[$key] = ToArray($val);
        }
    } else {
        $new = $obj;
    }
    return $new;
}
$lang = LoadLanguage();
$dev = true;
function __($key) {
    global $lang , $db,$dev;
    //$lang_array = ToArray($lang);
    $string = trim($key);
    if(empty($string)) return false;
    $stringFromArray = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','_', $string));

    if(property_exists($lang,$stringFromArray)){
        return $lang->{$stringFromArray};
    }

//    if (in_array($stringFromArray, array_keys($lang_array))) {
//        if(property_exists($lang,$stringFromArray)){
//            return $lang->{$stringFromArray};
//        }else{
//            return $stringFromArray;
//        }
//    }
    if((GetActiveLang() == 'english')) {
        if($dev === true) {
            $insert = $db->insert('langs', ['lang_key' => $stringFromArray, 'english' => secure($string)]);
        }else{
            return '';
        }
        $lang->{$stringFromArray} = $string;
        return $string;
    }else{
        return $string;
    }
}
function _lang($string){
    global $lang;
    if(empty($string)) return $string;
    $stringFromArray = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','_', $string));
    if(property_exists($lang,$stringFromArray)){
        return $lang->{$stringFromArray};
    }else{
        return $string;
    }

}
function GetInterested(){
    global $db;
    $data = array();
    $interested = $db->get('users',null,array('interest'));
    foreach ($interested as $key => $value ){
        if( !empty($value['interest'])) {
            foreach (explode(',',$value['interest']) as $k => $v){
                if( $v !== '') {
                    $data[trim($v)] = null;
                }
            }
        }
    }
    return $data;
}
function ProUsers(){
    global $db;
    $pro_users  = new stdClass();

    $u = auth();
    $limit = 15;
    if($u->is_pro === "1" || $u->admin === "1" ){
        $limit = 16;
    }

    if($u->is_pro === "0" && $u->admin === "1" ){
        $limit = 15;
    }

    $gender_query = '';
    $genders = GetGenders($u);
    if( strpos( $genders, ',' ) === false ) {
        $gender_query = '`gender` = "'. $genders .'"';
    }else{
        $gender_query = '`gender` IN ('. $genders .')';
    }

    $sql = 'SELECT * FROM `users` WHERE '. $gender_query . ' AND `verified` = "1" AND (`is_pro` = "1" OR `is_boosted` = "1") AND `id` NOT IN (SELECT `like_userid` FROM `likes` WHERE `is_dislike` = "1" AND `user_id` = '.$u->id.') AND `id` NOT IN (SELECT `block_userid` FROM `blocks` WHERE `user_id` = '.$u->id.') ORDER BY rand(),`boosted_time`,`is_pro`,`pro_time` DESC LIMIT '. $limit;
    $pro_users = $db->rawQuery($sql);

    return ToObject($pro_users);
}
function isAjax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
}
function BlokedUsers($userid = null){
    global $db;
    $blocked = array();
    if( $userid > 0 ){
        $uid = $userid;
    }else{
        $uid = auth()->id;
    }
    $blocked_users = $db->arrayBuilder()
        ->where( 'b.user_id', $uid )
        ->where( 'verified', '1' )
        ->join( 'users u', 'u.id=b.`block_userid`', 'LEFT')
        ->get( 'blocks b', null, array('u.id', 'u.username'));
    foreach ($blocked_users as $key => $value) {
        $blocked[$value['id']] = $value['username'];
    }

    $blocked_users2 = $db->arrayBuilder()
        ->where( 'b.block_userid', $uid )
        ->where( 'verified', '1' )
        ->join( 'users u', 'u.id=b.`user_id`', 'LEFT')
        ->get( 'blocks b', null, array('u.id', 'u.username'));
    foreach ($blocked_users2 as $key => $value) {
        $blocked[$value['id']] = $value['username'];
    }
    return $blocked;
}
function LikedUsers($userid = null){
    global $db;
    $liked = array();
    if( $userid > 0 ){
        $uid = $userid;
    }else{
        $uid = auth()->id;
    }
    $liked_users = $db->arrayBuilder()
                        ->where( 'l.user_id', $uid )
                        ->where( 'l.is_like', '1' )
                        ->where( 'verified', '1' )
                        ->join( 'users u', 'u.id = l.like_userid', 'LEFT')
                        ->get( 'likes l', null, array('u.id', 'u.username'));
    foreach ($liked_users as $key => $value) {
        $liked[$value['id']] = $value['username'];
    }
    return $liked;
}
function DisLikedUsers($userid = null){
    global $db;
    $liked = array();
    if( $userid > 0 ){
        $uid = $userid;
    }else{
        $uid = auth()->id;
    }
    $liked_users = $db->arrayBuilder()
        ->where( 'l.user_id', $uid )
        ->where( 'l.is_dislike', '1' )
        ->where( 'verified', '1' )
        ->join( 'users u', 'u.id = l.like_userid', 'LEFT')
        ->get( 'likes l', null, array('u.id', 'u.username'));
    foreach ($liked_users as $key => $value) {
        $liked[$value['id']] = $value['username'];
    }
    return $liked;
}
function isUserInBlockList($user,$user_id = null){
    //global $_blocked_users;
    if( $user_id !== null ){
        $blockusers = BlokedUsers($user_id);
    }else{
        $blockusers = BlokedUsers();
    }
    $userid = $user;
    $username = $user;
    $is_blocked = false;
    if (isset($blockusers[$userid])) {
        $is_blocked = true;
    }
    if (in_array($username, $blockusers)) {
        $is_blocked = true;
    }
    return $is_blocked;
}
function isUserInLikeList($user){
    //global $_liked_users;
    $likedusers = LikedUsers();
    $userid = $user;
    $username = $user;
    $is_liked = false;
    if (isset($likedusers[$userid])) {
        $is_liked = true;
    }
    if (in_array($username, $likedusers)) {
        $is_liked = true;
    }
    return $is_liked;
}
function isUserInDisLikeList($user){
    //global $_disliked_users;
    $dislikedusers = DisLikedUsers();
    $userid = $user;
    $username = $user;
    $is_disliked = false;
    if (isset($dislikedusers[$userid])) {
        $is_disliked = true;
    }
    if (in_array($username, $dislikedusers)) {
        $is_disliked = true;
    }
    return $is_disliked;
}
$loggedin_user  = new stdClass();
function auth(){
    global $loggedin_user, $db;
    $token = '';
    if( isset( $_SESSION['user_id'] ) && !empty( $_SESSION['user_id'] ) ){
        $token = $_SESSION['user_id'];
    }else if( isset( $_COOCKIE['JWT'] ) && !empty( $_COOCKIE['JWT'] ) ){
        $token = $_COOCKIE['JWT'];
    }else if( isset( $_POST['access_token'] ) && !empty( $_POST['access_token'] ) ){
        $token = $_POST['access_token'];
    }

    if(IS_LOGGED === true) {

        //if (!isset($_SESSION['userEdited'])) {
            if (isset($loggedin_user->id)) {
                //var_dump($loggedin_user);
                return $loggedin_user;
            }else {
                //}

                $_user = LoadEndPointResource('users');
                if ($_user) {
                    $uid = GetUserFromSessionID($token);
                    $loggedin_user = userData($uid);//$_user->get_user_profile($uid, array(), true);
                    if (isset($_SESSION['userEdited'])) {
                        unset($_SESSION['userEdited']);
                    }
                    return $loggedin_user;
                }
            }
    }else if(IS_LOGGED === false && isEndPointRequest()){
        if( isset ( $_POST['access_token'] ) && !empty( $_POST['access_token'] )){
            $user_id = GetUserFromSessionID(Secure($_POST['access_token']));
            $loggedin_user = userData($user_id);
            return $loggedin_user;
        }else{
            return $loggedin_user;
        }
    }else{
        return $loggedin_user;
    }
}
function userData($username, $cols = array(),$only_token = false){
    global $config;
    if( $username == '' ){
        return false;
    }

    $user = userProfile($username, $cols ,$only_token);
//
//    $_user = LoadEndPointResource('users');
//    if( $_user ) {
//        $user = $_user->get_user_profile($username,$cols,false);
//    }
    return $user;
}
function GetAd($type, $admin = true) {
    global $conn;
    $type      = Secure($type);
    $query_one = "SELECT `code` FROM `site_ads` WHERE `placement` = '{$type}'";
    if ($admin === false) {
        $query_one .= " AND `active` = '1'";
    }
    $sql          = mysqli_query($conn, $query_one);
    $fetched_data = mysqli_fetch_assoc($sql);

    if (empty($fetched_data)) {
        return '';
    }else{
        return htmlspecialchars_decode($fetched_data['code']);
    }
}
function GetUserByID($id) {
    global $conn;
    $id      = Secure($id);
    $query_one = "SELECT * FROM `users` WHERE `id` = {$id}";
    $sql          = mysqli_query($conn, $query_one);
    $fetched_data = mysqli_fetch_assoc($sql);

    if (empty($fetched_data)) {
        return array();
    }else{
        return $fetched_data;
    }
}
function verifiedUser($user){
    global $db,$config;
    if(!isset($user->admin) || !isset($user->active) ||!isset($user->phone_verified) ) return false;
    if( $user->admin == 1 ){
        return true;
    }
    $usermedia_files = $db->where('user_id',$user->id)->getValue('mediafiles','count(id)');
    if($config->emailValidation == "1" && intval($usermedia_files) >= 5){
        return true;
    }
    if( $user->phone_verified == 1 && $user->active == 1 && intval($usermedia_files) >= 6 ){
        return true;
    }else{
        if( $user->active == 1 && intval($usermedia_files) >= 6 ){
            return true;
        }else{
            return false;
        }
    }
    //to verify user profile without uploading 5 image, admin approve user account manually
    if($config->image_verification == "1") {
        if( $user->approved_at > 0 && $user->snapshot !== '' ){
            return true;
        }
    }
}
function FullName($user){
    if( !isset($user->first_name) || !isset($user->last_name) || !isset($user->username)) return '';
    $full_name = trim($user->first_name . ' ' . $user->last_name);
    return (empty($full_name)) ? trim($user->username) : $full_name;
}
function DatasetGetSelect($database_value, $dataset_array, $null_value) {
    $result = '';
    $result .= '<option value="" disabled selected>' . $null_value . '</option>';
    $data = Dataset::load($dataset_array);
    if (isset($data) && !empty($data)) {
        foreach ($data as $key => $val) {
            $result .= '<option value="' . $key . '" ' . (($database_value == $key) ? 'selected' : '') . '>' . $val . '</option>';
        }
        return $result;
    } else {
        return $result;
    }
}
function GetMedia($media, $allow_empty = true) {
    global $config;
    $s3_site_url = 'https://test.s3.amazonaws.com';
    if (!empty($config->bucket_name)) {
        $s3_site_url = 'https://'.$config->bucket_name.'.s3.amazonaws.com';
    }
    $config->s3_site_url = $s3_site_url;

    if ($allow_empty) {
        if (empty($media)) {
            return '';
        }
    }
    if ($config->amazone_s3 == 1) {
        if (empty($config->amazone_s3_key) || empty($config->amazone_s3_s_key) || empty($config->region) || empty($config->bucket_name)) {
            return $config->uri . '/' . $media;
        }
        return $config->s3_site_url . '/' . $media;
    }
    if($_SERVER['DOCUMENT_ROOT'] == 'D:/xampp/htdocs/quickdate'){
        return 'https://quickdatescript.com'. '/' . $media;
    }
    return $config->uri . '/' . $media;
}
function get_verification_photo($id){
    global $db;
    if (empty($id)) {
        return '';
    }
    $img = $db->where('user_id',Secure($id))->getValue('verification_requests','photo');
    return $img;
}
function get_verification_passport($id){
    global $db;
    if (empty($id)) {
        return '';
    }
    $img = $db->where('user_id',Secure($id))->getValue('verification_requests','passport');
    return $img;
}
function timestampdiff($qw,$saw)
{
    $datetime1 = new DateTime("@$qw");
    $datetime2 = new DateTime("@$saw");
    $interval = $datetime1->diff($datetime2);
    return $interval->format('%H');
}
function Secure($string, $br = true, $strip = 0) {
    global $conn;
    if(is_array($string) || is_object($string)) return;
    $string = trim($string);
    $string = mysqli_real_escape_string($conn, $string);
    $string = htmlspecialchars($string, ENT_QUOTES);
    if ($br == true) {
        $string = str_replace('\r\n', ' <br>', $string);
        $string = str_replace('\n\r', ' <br>', $string);
        $string = str_replace('\r', ' <br>', $string);
        $string = str_replace('\n', ' <br>', $string);
    } else {
        $string = str_replace('\r\n', '', $string);
        $string = str_replace('\n\r', '', $string);
        $string = str_replace('\r', '', $string);
        $string = str_replace('\n', '', $string);
    }
    if ($strip == 1) {
        $string = stripslashes($string);
    }
    $string = str_replace('&amp;#', '&#', $string);
    return $string;
}
function url_slug($str, $options = array()) {
    $str      = mb_convert_encoding((string) $str, 'UTF-8', mb_list_encodings());
    $defaults = array(
        'delimiter' => '_',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => false
    );
    $options  = array_merge($defaults, $options);
    $char_map = array(
        'À' => 'A',
        'Á' => 'A',
        'Â' => 'A',
        'Ã' => 'A',
        'Ä' => 'A',
        'Å' => 'A',
        'Æ' => 'AE',
        'Ç' => 'C',
        'È' => 'E',
        'É' => 'E',
        'Ê' => 'E',
        'Ë' => 'E',
        'Ì' => 'I',
        'Í' => 'I',
        'Î' => 'I',
        'Ï' => 'I',
        'Ð' => 'D',
        'Ñ' => 'N',
        'Ò' => 'O',
        'Ó' => 'O',
        'Ô' => 'O',
        'Õ' => 'O',
        'Ö' => 'O',
        'Ő' => 'O',
        'Ø' => 'O',
        'Ù' => 'U',
        'Ú' => 'U',
        'Û' => 'U',
        'Ü' => 'U',
        'Ű' => 'U',
        'Ý' => 'Y',
        'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a',
        'á' => 'a',
        'â' => 'a',
        'ã' => 'a',
        'ä' => 'a',
        'å' => 'a',
        'æ' => 'ae',
        'ç' => 'c',
        'è' => 'e',
        'é' => 'e',
        'ê' => 'e',
        'ë' => 'e',
        'ì' => 'i',
        'í' => 'i',
        'î' => 'i',
        'ï' => 'i',
        'ð' => 'd',
        'ñ' => 'n',
        'ò' => 'o',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ö' => 'o',
        'ő' => 'o',
        'ø' => 'o',
        'ù' => 'u',
        'ú' => 'u',
        'û' => 'u',
        'ü' => 'u',
        'ű' => 'u',
        'ý' => 'y',
        'þ' => 'th',
        'ÿ' => 'y',
        '©' => '(c)',
        'Α' => 'A',
        'Β' => 'B',
        'Γ' => 'G',
        'Δ' => 'D',
        'Ε' => 'E',
        'Ζ' => 'Z',
        'Η' => 'H',
        'Θ' => '8',
        'Ι' => 'I',
        'Κ' => 'K',
        'Λ' => 'L',
        'Μ' => 'M',
        'Ν' => 'N',
        'Ξ' => '3',
        'Ο' => 'O',
        'Π' => 'P',
        'Ρ' => 'R',
        'Σ' => 'S',
        'Τ' => 'T',
        'Υ' => 'Y',
        'Φ' => 'F',
        'Χ' => 'X',
        'Ψ' => 'PS',
        'Ω' => 'W',
        'Ά' => 'A',
        'Έ' => 'E',
        'Ί' => 'I',
        'Ό' => 'O',
        'Ύ' => 'Y',
        'Ή' => 'H',
        'Ώ' => 'W',
        'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a',
        'β' => 'b',
        'γ' => 'g',
        'δ' => 'd',
        'ε' => 'e',
        'ζ' => 'z',
        'η' => 'h',
        'θ' => '8',
        'ι' => 'i',
        'κ' => 'k',
        'λ' => 'l',
        'μ' => 'm',
        'ν' => 'n',
        'ξ' => '3',
        'ο' => 'o',
        'π' => 'p',
        'ρ' => 'r',
        'σ' => 's',
        'τ' => 't',
        'υ' => 'y',
        'φ' => 'f',
        'χ' => 'x',
        'ψ' => 'ps',
        'ω' => 'w',
        'ά' => 'a',
        'έ' => 'e',
        'ί' => 'i',
        'ό' => 'o',
        'ύ' => 'y',
        'ή' => 'h',
        'ώ' => 'w',
        'ς' => 's',
        'ϊ' => 'i',
        'ΰ' => 'y',
        'ϋ' => 'y',
        'ΐ' => 'i',
        'Ş' => 'S',
        'İ' => 'I',
        'Ç' => 'C',
        'Ü' => 'U',
        'Ö' => 'O',
        'Ğ' => 'G',
        'ş' => 's',
        'ı' => 'i',
        'ç' => 'c',
        'ü' => 'u',
        'ö' => 'o',
        'ğ' => 'g',
        'А' => 'A',
        'Б' => 'B',
        'В' => 'V',
        'Г' => 'G',
        'Д' => 'D',
        'Е' => 'E',
        'Ё' => 'Yo',
        'Ж' => 'Zh',
        'З' => 'Z',
        'И' => 'I',
        'Й' => 'J',
        'К' => 'K',
        'Л' => 'L',
        'М' => 'M',
        'Н' => 'N',
        'О' => 'O',
        'П' => 'P',
        'Р' => 'R',
        'С' => 'S',
        'Т' => 'T',
        'У' => 'U',
        'Ф' => 'F',
        'Х' => 'H',
        'Ц' => 'C',
        'Ч' => 'Ch',
        'Ш' => 'Sh',
        'Щ' => 'Sh',
        'Ъ' => '',
        'Ы' => 'Y',
        'Ь' => '',
        'Э' => 'E',
        'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'е' => 'e',
        'ё' => 'yo',
        'ж' => 'zh',
        'з' => 'z',
        'и' => 'i',
        'й' => 'j',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'h',
        'ц' => 'c',
        'ч' => 'ch',
        'ш' => 'sh',
        'щ' => 'sh',
        'ъ' => '',
        'ы' => 'y',
        'ь' => '',
        'э' => 'e',
        'ю' => 'yu',
        'я' => 'ya',
        'Є' => 'Ye',
        'І' => 'I',
        'Ї' => 'Yi',
        'Ґ' => 'G',
        'є' => 'ye',
        'і' => 'i',
        'ї' => 'yi',
        'ґ' => 'g',
        'Č' => 'C',
        'Ď' => 'D',
        'Ě' => 'E',
        'Ň' => 'N',
        'Ř' => 'R',
        'Š' => 'S',
        'Ť' => 'T',
        'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c',
        'ď' => 'd',
        'ě' => 'e',
        'ň' => 'n',
        'ř' => 'r',
        'š' => 's',
        'ť' => 't',
        'ů' => 'u',
        'ž' => 'z',
        'Ą' => 'A',
        'Ć' => 'C',
        'Ę' => 'e',
        'Ł' => 'L',
        'Ń' => 'N',
        'Ó' => 'o',
        'Ś' => 'S',
        'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a',
        'ć' => 'c',
        'ę' => 'e',
        'ł' => 'l',
        'ń' => 'n',
        'ó' => 'o',
        'ś' => 's',
        'ź' => 'z',
        'ż' => 'z',
        'Ā' => 'A',
        'Č' => 'C',
        'Ē' => 'E',
        'Ģ' => 'G',
        'Ī' => 'i',
        'Ķ' => 'k',
        'Ļ' => 'L',
        'Ņ' => 'N',
        'Š' => 'S',
        'Ū' => 'u',
        'Ž' => 'Z',
        'ā' => 'a',
        'č' => 'c',
        'ē' => 'e',
        'ģ' => 'g',
        'ī' => 'i',
        'ķ' => 'k',
        'ļ' => 'l',
        'ņ' => 'n',
        'š' => 's',
        'ū' => 'u',
        'ž' => 'z'
    );
    $str      = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    $str = trim($str, $options['delimiter']);
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}
function _print_r($a) {
    echo '<pre>' . print_r($a, 1) . '</pre>';
}
function execTime($id = '0', $round = 4, $reset = FALSE) {
    global $console_log;
    static $data = array();
    if (!isset($data[$id]) or $reset) {
        $data[$id] = microtime(true);
        return 0;
    } else {
        if (LOGTIME == true) {
            if (!isEndPointRequest()) {
                $console_log['log'][] = str_pad($id, 60, ".", STR_PAD_RIGHT) . " : \t" . number_format((microtime(true) - $data[$id]), $round) . " Sec";
            }
        } else {
            number_format((microtime(true) - $data[$id]), $round);
        }
    }
}
function write_console() {
    global $console_log;
    echo '<script>';
    if (isset($console_log['log']) && !empty($console_log['log'])) {
        echo 'console.group(\'Application Load time log\');';
        foreach ($console_log['log'] as $key => $value) {
            echo 'console.info(\'' . $value . '\');';
        }
        echo 'console.groupEnd();';
    }
    if (isset($console_log['error']) && !empty($console_log['error'])) {
        echo 'console.groupCollapsed(\'Application Error log. [ ' . count($console_log['error']) . ' ] Issue found.\');';
        foreach ($console_log['error'] as $key => $value) {
            echo 'console.warn("' . escapeJavaScriptText($value) . '");';
        }
        echo 'console.groupEnd();';
    }
    if (isset($console_log['database']) && !empty($console_log['database'])) {
        echo 'console.groupCollapsed(\'Application Database log. [ ' . count($console_log['database']) . ' ] Query found\');';
        $tim = 0;
        foreach ($console_log['database'] as $key => $value) {
            if( isset( $value['time'] ) ) {
                $tim += $value['time'];
            }
            echo 'console.log(JSON.parse("' . escapeJavaScriptText(json_encode($value)) . '"));';
        }
        echo 'console.warn("Total execution time = ' . escapeJavaScriptText($tim) . ' ms.");';
        echo 'console.groupEnd();';
    }
    if (isset($console_log['debug']) && !empty($console_log['debug'])) {
        echo 'console.group(\'Application debug log. [ ' . count($console_log['debug']) . ' ].\');';
        foreach ($console_log['debug'] as $key => $value) {
            echo 'console.group(\'' . $key . '\');';
            echo 'console.log(JSON.parse("' . escapeJavaScriptText(json_encode($value)) . '"));';
            echo 'console.groupEnd();';
        }
        echo 'console.groupEnd();';
    }

    echo 'console.groupCollapsed(\'Application SESSION\');';
    echo 'console.log(JSON.parse("' . escapeJavaScriptText(json_encode($_SESSION)) . '"));';
    echo 'console.groupEnd();';
    echo '</script>';
}
function isEndPointRequest() {
    if (strstr($_SERVER['SCRIPT_NAME'], 'endpoint/index.php') !== 'endpoint/index.php') {
        return false;
    } else {
        return true;
    }
}
function json($array, $code = 0, $exit = true) {
    global $_statusCodes;
    if ($array === null && $code === 0) {
        $code = 204;
    }
    if ($array !== null && $code === 0) {
        $code = 200;
    }
    if (!isEndPointRequest()) {
        $exit = false;
    }else{
        if( !isset( $array['data'] ) ) $array['data'] = array();
        if( !isset( $array['errors'] ) ) $array['errors'] = array('error_id'=>'','error_text'=>'');
        if( !isset( $array['message'] ) ) $array['message'] = '';
    }
    if ($exit) {
        header('HTTP/1.1 ' . $code . '  ' . $_statusCodes[$code]);
        if ($array !== null) {
            echo json_encode($array, JSON_UNESCAPED_UNICODE);
        }
        exit();
    } else {
        return $array;
    }
}
function escapeJavaScriptText($string) {
    return str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string) $string), "\0..\37'\\")));
}
function route($segment) {
    if ($segment == 0) {
        return null;
    }
    $segment = $segment - 1;
    $path    = array();
    if (ISSET($_GET['path']) && !empty($_GET['path'])) {
        $path = explode('/', $_GET['path']);
        if (!empty($path)) {
            if (empty($path[0])) {
                unset($path[0]);
                $path_ = $path;
                $path = array();
                foreach ($path_ as $key => $new_path) {
                    $path[] = $new_path;
                }
            }
            if (!empty($path[$segment])) {
                return $path[$segment];
            }
        }
    }
}
function render($file,$_data = array()){
    global $config,$_BASEPATH,$_DS;
    $site_url = $config->uri;
    $theme_url = $config->uri . '/themes/' . $config->theme .'/';
    $theme_path = $_BASEPATH . 'themes' . $_DS . $config->theme . $_DS;
    $base_file = $theme_path . 'base.php';
    $file_path = $theme_path . $file . '.php';
    $profile = auth();
    $data = $_data;
    if( file_exists( $file_path ) ){
        require($base_file);
    }else{
        require($theme_path .'404.php');
    }
}
function Time_Elapsed_String($ptime) {
    $etime = time() - $ptime;
    if ($etime < 45) {
        return __('Just now');
    }
    if ($etime >= 45 && $etime < 90) {
        return __('about a minute ago');
    }
    $day = 24 * 60 * 60;
    if ($etime > $day * 30 && $etime < $day * 45) {
        return __('about a month ago');
    }
    $a        = array(
        365 * 24 * 60 * 60 => "year",
        30 * 24 * 60 * 60 => "month",
        24 * 60 * 60 => "day",
        60 * 60 => "hour",
        60 => "minute",
        1 => "second"
    );
    $a_plural = array(
        'year' => __("years"),
        'month' => __("months"),
        'day' => __("days"),
        'hour' => __("hours"),
        'minute' => __("minutes"),
        'second' => __("seconds")
    );
    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r        = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ' . __("ago");
        }
    }
}
function GetIpAddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && ValidateIpAddress($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (ValidateIpAddress($ip))
                    return $ip;
            }
        } else {
            if (ValidateIpAddress($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && ValidateIpAddress($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && ValidateIpAddress($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && ValidateIpAddress($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && ValidateIpAddress($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];
    return $_SERVER['REMOTE_ADDR'];
}
function ValidateIpAddress($ip) {
    if (strtolower($ip) === 'unknown')
        return false;
    $ip = ip2long($ip);
    if ($ip !== false && $ip !== -1) {
        $ip = sprintf('%u', $ip);
        if ($ip >= 0 && $ip <= 50331647)
            return false;
        if ($ip >= 167772160 && $ip <= 184549375)
            return false;
        if ($ip >= 2130706432 && $ip <= 2147483647)
            return false;
        if ($ip >= 2851995648 && $ip <= 2852061183)
            return false;
        if ($ip >= 2886729728 && $ip <= 2887778303)
            return false;
        if ($ip >= 3221225984 && $ip <= 3221226239)
            return false;
        if ($ip >= 3232235520 && $ip <= 3232301055)
            return false;
        if ($ip >= 4294967040)
            return false;
    }
    return true;
}
function GetBrowser() {
    $ub    = '';
    $u_agent  = $_SERVER['HTTP_USER_AGENT'];
    $bname    = 'Unknown';
    $platform = 'Unknown';
    $version  = '';
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub    = 'MSIE';
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub    = 'Firefox';
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub    = 'Chrome';
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub    = 'Safari';
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub    = 'Opera';
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub    = 'Netscape';
    }
    $known   = array(
        'Version',
        $ub,
        'other'
    );
    $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
    }
    $i = count($matches['browser']);
    if ($i != 1) {
        if (strripos($u_agent, 'Version') < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }
    if ($version == null || $version == "") {
        $version = '?';
    }
    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => $platform,
        'pattern' => $pattern
    );
}
function GetDeviceType() {
    $deviceName = '';
    $userAgent    = $_SERVER['HTTP_USER_AGENT'];
    $devicesTypes = array(
        'computer' => array(
            'msie 10',
            'msie 9',
            'msie 8',
            'windows.*firefox',
            'windows.*chrome',
            'x11.*chrome',
            'x11.*firefox',
            'macintosh.*chrome',
            'macintosh.*firefox',
            'opera'
        ),
        'tablet' => array(
            'tablet',
            'android',
            'ipad',
            'tablet.*firefox'
        ),
        'mobile' => array(
            'mobile ',
            'android.*mobile',
            'iphone',
            'ipod',
            'opera mobi',
            'opera mini'
        ),
        'bot' => array(
            'googlebot',
            'mediapartners-google',
            'adsbot-google',
            'duckduckbot',
            'msnbot',
            'bingbot',
            'ask',
            'facebook',
            'yahoo',
            'addthis'
        )
    );
    foreach ($devicesTypes as $deviceType => $devices) {
        foreach ($devices as $device) {
            if (preg_match('/' . $device . '/i', $userAgent)) {
                $deviceName = $deviceType;
            }
        }
    }
    return ucfirst($deviceName);
}
function GetDeviceToken() {
    $finger_print               = array();
    $browser                    = GetBrowser();
    $finger_print['ip']         = GetIpAddress();
    $finger_print['browser']    = $browser['name'] . " " . $browser['version'];
    $finger_print['os']         = $browser['platform'];
    $finger_print['deviceType'] = GetDeviceType();
    $device                     = serialize($finger_print);
    return $device;
}
function LoadEndPointResource( $_resourceName, $IsLoadFromLoadEndPointResource = false ) {
    global $_ENDPOINT_PATH,$_DS;
    $_resourceName = strtolower($_resourceName);
    $_resourceFile = $_ENDPOINT_PATH . 'models' . $_DS . $_resourceName . '.php';
    if (file_exists($_resourceFile)) {
        if(!class_exists($_resourceFile)) {
            require_once($_resourceFile);
            $resource = new $_resourceName($IsLoadFromLoadEndPointResource);
            return $resource;
        }
    }else{
        return false;
    }
}
function userProfile($username, $cols = array(),$only_token = false){
    global $db,$config;
    $profile_completion_fields       = array(
        'email',
        'first_name',
        'last_name',
        'avater',
        'facebook',
        'google',
        'twitter',
        'linkedin',
        'instagram',
        'phone_number',
        'birthday',
        'interest',
        'location',
        'relationship',
        'work_status',
        'education',
        'ethnicity',
        'body',
        'character',
        'children',
        'friends',
        'pets',
        'live_with',
        'car',
        'religion',
        'smoke',
        'drink',
        'travel',
        'music',
        'dish',
        'song',
        'hobby',
        'city',
        'sport',
        'book',
        'movie',
        'colour',
        'tv'
    );
    $profile_completion_fields_count = count($profile_completion_fields);
    $profile_completion_field        = 0;
    $profile_completion_value        = 0;
    $profile_completion_missing      = array();
    $profile                         = new stdClass();
    $columns = array('*');
    if(!empty($cols)){
        $columns = $cols;
    }
    if( $only_token == true ){
        $db->where('id', $username);
    }else{
        $db->Where('username', $username);
        $db->orWhere('id', $username);
        $db->orWhere('email', $username);
    }
    $user = $db->objectBuilder()->getOne('users',$columns);
    if ($db->count > 0) {
        if( $columns[0] == "*" ) {
            foreach ($user as $key => $value) {
                $profile->$key = trim($value);
                $profile->verified_final = verifiedUser($user);
                $profile->fullname = FullName($user);

                if (in_array($key, $profile_completion_fields)) {
                    if (!empty($value)) {
                        $profile_completion_field++;
                    } else {
                        $profile_completion_missing[] = $key;
                    }
                }
                $data = Dataset::load($key);
                if (isset($data) && !empty($data)) {
                    if (isset($data[$value])) {
                        $profile->{$key . '_txt'} = $data[$value];
                    } else {
                        $profile->{$key . '_txt'} = '';
                    }
                }
                if ($user->country !== '') {
                    $countries = Dataset::load('countries');
                    if (isset($countries[$user->country])) {
                        $profile->country_txt = $countries[$user->country]['name'];
                        if ($user->phone_number !== '') {
                            $profile->full_phone_number = '+' . $countries[$user->country]['isd'] . $user->phone_number;
                        }
                    }
                } else {
                    $profile->country_txt = '-';
                }

                if ($user->phone_verified == 1) {
                    $profile->full_phone_number = '+' . $user->phone_number;
                }
                if ($user->web_token !== '') {
                    $profile->web_token = strtolower($user->web_token);
                }
                $profile->password = '**********************';
                if ($user->birthday !== '0000-00-00') {
                    $profile->age = floor((time() - strtotime($user->birthday)) / 31556926);
                } else {
                    $profile->age = 0;
                }
                if ($user->web_device !== '') {
                    $profile->web_device = unserialize($user->web_device);
                }
                $profile_completion_value = ((100 * $profile_completion_field) / $profile_completion_fields_count);
                $profile->profile_completion = (int)$profile_completion_value;
                $profile->profile_completion_missing = $profile_completion_missing;

                if (isEndPointRequest()) {
                    $profile->avater = GetMedia($user->avater, false);
                }else{
                    $profile->avater = new stdClass();
                    $profile->avater->full = GetMedia(str_replace('_avater.', '_full.', $user->avater), false);
                    $profile->avater->avater = GetMedia($user->avater, false);
                }

                $full_name = ucfirst(trim($user->first_name . ' ' . $user->last_name));
                $profile->full_name = ($full_name == '') ? ucfirst(trim($user->username)) : $full_name;
            }
            $profile->lastseen_txt = get_time_ago($user->lastseen);
            $profile->lastseen_date = date('c', $user->lastseen);
            $profile->mediafiles = array();
            $mediafiles = $db->where('user_id', trim($profile->id))->orderBy('id', 'desc')->get('mediafiles', null, array('id','file','is_private','private_file','is_video','video_file','is_confirmed','is_approved'));
            if ($mediafiles) {
                $mediafilesid = 0;
                foreach ($mediafiles as $mediafile) {
                    $mf = array(
                        'id' => $mediafile['id'],
                        'full' => GetMedia($mediafile['file'], false),
                        'avater' => GetMedia(str_replace('_full.', '_avater.', $mediafile['file']), false),
                        'is_private' => $mediafile['is_private'],
                        'private_file_full' => GetMedia( $mediafile['private_file'], false),
                        'private_file_avater' => GetMedia(str_replace('_full.', '_avatar.', $mediafile['private_file']), false),
                        'is_video' => $mediafile['is_video'],
                        'video_file' => GetMedia($mediafile['video_file']),
                        'is_confirmed' => $mediafile['is_confirmed'],
                        'is_approved' => $mediafile['is_approved']
                    );
                    $profile->mediafiles[] = $mf;
                }
            }
        }else{
            foreach ($user as $key => $value) {
                if (in_array($key, $columns)) {
                    $profile->$key = trim($value);
                    $profile->verified_final = verifiedUser($user);
                    $profile->fullname = FullName($user);
                    $data = Dataset::load($key);
                    if (isset($data) && !empty($data)) {

                        if (isset($data[$value])) {
                            $profile->{$key} = $data[$value];
                        }

                        if ($user->country !== '') {
                            $countries = Dataset::load('countries');
                            if (isset($countries[$user->country])) {
                                $profile->country = $countries[$user->country]['name'];
                            }
                        } else {
                            $profile->country = '-';
                        }

                    }
                }

                if( isset( $user->id ) ) {
                    $profile->mediafiles = array();
                    $mediafiles = $db->where('user_id', trim($user->id))->orderBy('id', 'desc')->get('mediafiles', null, array('id','file','is_private','private_file'));
                    if ($mediafiles) {
                        $mediafilesid = 0;
                        foreach ($mediafiles as $mediafile) {
                            $profile->mediafiles[$mediafilesid] = array();
                            $profile->mediafiles[$mediafilesid]['id'] = $mediafile['id'];
                            $profile->mediafiles[$mediafilesid]['full'] = GetMedia($mediafile['file'], false);
                            $profile->mediafiles[$mediafilesid]['avater'] = GetMedia(str_replace('_full.', '_avater.', $mediafile['file']), false);
                            $profile->mediafiles[$mediafilesid]['is_private'] = $mediafile['is_private'];
                            $profile->mediafiles[$mediafilesid]['private_full'] = GetMedia($mediafile['private_file'], false);
                            $profile->mediafiles[$mediafilesid]['private_avater'] = GetMedia(str_replace('_full.', '_avatar.', $mediafile['private_file']), false);

                            $mediafilesid++;
                        }
                    }
                }
            }
        }
        if(isEndPointRequest()){
            unset($profile->web_device);
        }else{

            if(!is_avatar_approved($user->id, $user->avater)) {
                $profile->avater->full = GetMedia($config->userDefaultAvatar, false);
                $profile->avater->avater = GetMedia($config->userDefaultAvatar, false);
            }
        }


        return $profile;
    }else{
        if(!is_avatar_approved($user->id, $user->avater)) {
            $profile->avater->full = GetMedia($config->userDefaultAvatar, false);
            $profile->avater->avater = GetMedia($config->userDefaultAvatar, false);
        }
        return $profile;
    }
}
use Aws\S3\S3Client;
function UploadToS3($filename, $options = array()) {
    $path = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR;
    $safefilename = str_replace($path, '',$filename );
    global $config;
    $s3_site_url = 'https://test.s3.amazonaws.com';
    if (!empty($config->bucket_name)) {
        $s3_site_url = 'https://'.$config->bucket_name.'.s3.amazonaws.com';
    }
    $config->s3_site_url = $s3_site_url;

    if ($config->amazone_s3 == 0) {
        return false;
    }
    if (empty($config->amazone_s3_key) || empty($config->amazone_s3_s_key) || empty($config->region) || empty($config->bucket_name)) {
        return false;
    }
    $s3 = new S3Client(array(
        'version' => 'latest',
        'region' => $config->region,
        'credentials' => array(
            'key' => $config->amazone_s3_key,
            'secret' => $config->amazone_s3_s_key
        )
    ));
    $s3->putObject(array(
        'Bucket' => $config->bucket_name,
        'Key' => $safefilename,
        'Body' => fopen($filename, 'r+'),
        'ACL' => 'public-read',
        'CacheControl' => 'max-age=3153600'
    ));
    if (empty($options['delete'])) {
        if ($s3->doesObjectExist($config->bucket_name, $filename)) {
            if (empty($options['amazon'])) {
                @unlink($filename);
            }
            return true;
        }
    } else {
        return true;
    }
}
function DeleteFromToS3($filename, $options = array()) {
    global $config,$_BASEPATH;
    if( file_exists($_BASEPATH.$filename) ) {
        if( @unlink($_BASEPATH.$filename) !== true ){
            return false;
        }else{
            return true;
        }
    }

    if($config->amazone_s3 == 0) {
        return false;
    }
    if($config->amazone_s3 == 1) {
        if (empty($config->amazone_s3_key) || empty($config->amazone_s3_s_key) || empty($config->region) || empty($config->bucket_name)) {
            return false;
        }
        $s3 = new S3Client(array(
            'version' => 'latest',
            'region' => $config->region,
            'credentials' => array(
                'key' => $config->amazone_s3_key,
                'secret' => $config->amazone_s3_s_key
            )
        ));
        $s3->deleteObject(array(
            'Bucket' => $config->bucket_name,
            'Key' => $filename
        ));
        if (!$s3->doesObjectExist($config->bucket_name, $filename)) {
            return true;
        }
    }
}
function CompressImage($source_url, $destination_url, $quality, $blur = false) {
    global $config;
    $imgsize = getimagesize($source_url);
    $finfof  = $imgsize['mime'];
    $image_c = 'imagejpeg';
    if ($finfof == 'image/jpeg') {
        header("content-type: image/jpeg");
        $image   = @imagecreatefromjpeg($source_url);
        $image_c = 'imagejpeg';
    } else if ($finfof == 'image/gif') {
        $image   = @imagecreatefromgif($source_url);
        $image_c = 'imagegif';
    } else if ($finfof == 'image/png') {
        header("content-type: image/png");
        $image   = @imagecreatefrompng($source_url);
        $image_c = 'imagepng';
    } else {
        header("content-type: image/jpeg");
        $image = @imagecreatefromjpeg($source_url);
    }
    if (function_exists('exif_read_data')) {
        $exif = @exif_read_data($source_url);
        if (!empty($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 3:
                    $image = @imagerotate($image, 180, 0);
                    break;
                case 6:
                    $image = @imagerotate($image, -90, 0);
                    break;
                case 8:
                    $image = @imagerotate($image, 90, 0);
                    break;
            }
        }
    }
    if( $blur == true ) {
        for ($x = 1; $x <= $config->img_blur_amount; $x++) {
            imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);
        }
    }
    @$image_c($image, $destination_url);
    return $destination_url;
}
function Resize_Crop_Image($max_width, $max_height, $source_file, $dst_dir, $quality = 80) {
    $imgsize = @getimagesize($source_file);
    $width   = $imgsize[0];
    $height  = $imgsize[1];
    $mime    = $imgsize['mime'];
    $image   = 'imagejpeg';
    switch ($mime) {
        case 'image/gif':
            $image_create = 'imagecreatefromgif';
            break;
        case 'image/png':
            $image_create = 'imagecreatefrompng';
            break;
        case 'image/jpeg':
            $image_create = 'imagecreatefromjpeg';
            break;
        default:
            return false;
            break;
    }
    $dst_img = @imagecreatetruecolor($max_width, $max_height);
    $src_img = @$image_create($source_file);
    if (function_exists('exif_read_data')) {
        $exif          = @exif_read_data($source_file);
        $another_image = false;
        if (!empty($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 3:
                    $src_img = @imagerotate($src_img, 180, 0);
                    @imagejpeg($src_img, $dst_dir, $quality);
                    $another_image = true;
                    break;
                case 6:
                    $src_img = @imagerotate($src_img, -90, 0);
                    @imagejpeg($src_img, $dst_dir, $quality);
                    $another_image = true;
                    break;
                case 8:
                    $src_img = @imagerotate($src_img, 90, 0);
                    @imagejpeg($src_img, $dst_dir, $quality);
                    $another_image = true;
                    break;
            }
        }
        if ($another_image == true) {
            $imgsize = @getimagesize($dst_dir);
            if ($width > 0 && $height > 0) {
                $width  = $imgsize[0];
                $height = $imgsize[1];
            }
        }
    }
    @$width_new = $height * $max_width / $max_height;
    @$height_new = $width * $max_height / $max_width;
    if ($width_new > $width) {
        $h_point = (($height - $height_new) / 2);
        @imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
    } else {
        $w_point = (($width - $width_new) / 2);
        @imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
    }
    @imagejpeg($dst_img, $dst_dir, $quality);
    if ($dst_img)
        @imagedestroy($dst_img);
    if ($src_img)
        @imagedestroy($src_img);
    return true;
}
function fetchDataFromURL($url = '') {
    if (empty($url)) {
        return false;
    }
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    return curl_exec($ch);
}
function isUserBlocked($userid){
    global $db;
    $blocked = false;
    if( isset( $_SESSION['JWT'] ) ){
        $user = $db->objectBuilder()
            ->where('user_id', auth()->id )
            ->where('block_userid', $userid )
            ->getValue('blocks','count(*)');
        if( $user > 0 ){
            $blocked = true;
        }
        return $blocked;
    }else{
        return false;
    }
}
function isUserReported($userid){
    global $db;
    $reported = false;
    if( isset( $_SESSION['JWT'] ) ){
        $user = $db->objectBuilder()
            ->where('user_id', auth()->id )
            ->where('report_userid', $userid )
            ->getValue('reports','count(*)');
        if( $user > 0 ){
            $reported = true;
        }
        return $reported;
    }else{
        return false;
    }
}
function isUserLiked($userid){
    global $db;
    $liked = false;
    if( isset( $_SESSION['JWT'] ) ){
        $user = $db->objectBuilder()
            ->where('user_id', auth()->id )
            ->where('like_userid', $userid )
            ->where('is_like', '1' )
            ->getValue('likes','count(*)');
        if( $user > 0 ){
            $liked = true;
        }
        return $liked;
    }else{
        return false;
    }
}
function isUserDisliked($userid){
    global $db;
    $disliked = false;
    if( isset( $_SESSION['JWT'] ) ){
        $user = $db->objectBuilder()
            ->where('user_id', auth()->id )
            ->where('like_userid', $userid )
            ->where('is_dislike', '1' )
            ->getValue('likes','count(*)');
        if( $user > 0 ){
            $disliked = true;
        }
        return $disliked;
    }else{
        return false;
    }
}
function GenerateKey($minlength = 20, $maxlength = 20, $uselower = true, $useupper = true, $usenumbers = true, $usespecial = false) {
    $charset = '';
    if ($uselower) {
        $charset .= 'abcdefghijklmnopqrstuvwxyz';
    }
    if ($useupper) {
        $charset .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    if ($usenumbers) {
        $charset .= '123456789';
    }
    if ($usespecial) {
        $charset .= '~@#$%^*()_+-={}|][';
    }
    if ($minlength > $maxlength) {
        $length = mt_rand($maxlength, $minlength);
    } else {
        $length = mt_rand($minlength, $maxlength);
    }
    $key = '';
    for ($i = 0; $i < $length; $i++) {
        $key .= $charset[(mt_rand(0, strlen($charset) - 1))];
    }
    return $key;
}
function GetUserFromSessionID($session_id, $platform = 'web') {
    global $conn, $db;
    if (empty($session_id)) {
        return false;
    }
    $session_id = Secure($session_id);
    $query      = mysqli_query($conn, "SELECT * FROM `sessions` WHERE `session_id` = '{$session_id}' LIMIT 1");
    $fetched_data = mysqli_fetch_assoc($query);
    if (empty($fetched_data['platform_details']) && $fetched_data['platform'] == 'web') {
        $ua = serialize(GetBrowser());
        if (isset($fetched_data['platform_details'])) {
            $update_session = $db->where('id', $fetched_data['id'])->update('sessions', array('platform_details' => $ua));
        }
    }
    return $fetched_data['user_id'];
}
function CreateLoginSession($user_id = 0, $platform = 'web') {
    global $conn, $db;
    if (empty($user_id)) {
        return false;
    }
    $user_id   = Secure($user_id);
    $hash      = sha1(rand(111111111, 999999999)) . md5(microtime()) . rand(11111111, 99999999) . md5(rand(5555, 9999));
    $query_two = mysqli_query($conn, "DELETE FROM `sessions` WHERE `session_id` = '{$hash}'");
    if ($query_two) {
        $ua = serialize(getBrowser());
        $query_three = mysqli_query($conn, "INSERT INTO `sessions` (`user_id`, `session_id`, `platform`, `platform_details`, `time`) VALUES('{$user_id}', '{$hash}', '{$platform}', '$ua'," . time() . ")");
        if ($query_three) {
            return $hash;
        }
    }
}
function IsLogged() {
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $id = GetUserFromSessionID($_SESSION['user_id']);
        if (is_numeric($id) && !empty($id)) {
            return true;
        }
    } else if (!empty($_COOKIE['JWT']) && !empty($_COOKIE['JWT'])) {
        $id = GetUserFromSessionID($_COOKIE['JWT']);
        if (is_numeric($id) && !empty($id)) {
            return true;
        }
    } else {
        return false;
    }
}
DEFINE('IS_LOGGED', IsLogged());
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
function SendEmail($to, $subject, $message, $db = false) {
    error_reporting(1);
    ini_set('display_startup_errors', true);
    ini_set('display_errors', true);

    global $config,$conn;
    $mail = new PHPMailer;
    if (empty($to)) {
        return false;
    }
    if (empty($subject)) {
        return false;
    }
    if (empty($message)) {
        return false;
    }
    $message = str_replace(array("\r\n", "\r", "\n"), "", $message);
    $message_body    = mysqli_real_escape_string($conn, $message);
    if ($db === true) {
        $u = auth();
        $user_id   = Secure($u->id);
        $query_one = mysqli_query($conn, "INSERT INTO `emails` (`email_to`, `user_id`, `subject`, `message`) VALUES ('{$to}', '{$user_id}', '{$subject}', '{$message_body}')");
        if ($query_one) {
            return true;
        }
        return true;
        exit();
    }
    if ($config->smtp_or_mail == 'mail') {
        $mail->IsMail();
    } else if ($config->smtp_or_mail == 'smtp') {
        $mail->isSMTP();
        $mail->Host          = $config->smtp_host;
        $mail->SMTPAuth      = true;
        $mail->SMTPKeepAlive = true;
        $mail->Username      = $config->smtp_username;
        $mail->Password      = $config->smtp_password;
        $mail->SMTPSecure    = $config->smtp_encryption;
        $mail->Port          = $config->smtp_port;
        $mail->SMTPOptions   = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    }
    $mail->setFrom($config->siteEmail, $config->site_name);
    $mail->CharSet = 'utf-8';
    $mail->IsHTML(true);
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->MsgHTML($message_body);
    $sent = $mail->send();
    $mail->ClearAddresses();
    return $sent;
}
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
function SendSMS($to, $message) {
    global $config;
    if (empty($to)) {
        return false;
    }
    if (empty($message)) {
        return false;
    }
    if ($config->sms_provider == 'twilio') {
        $twilio_number = $config->sms_t_phone_number;
        $account_sid   = $config->sms_twilio_username;
        $auth_token    = $config->sms_twilio_password;
        $Twilio_client = new Client($account_sid, $auth_token);
        if (!$Twilio_client) {
            return false;
        }
        try {
            $send = $Twilio_client->account->messages->create($to, array(
                'from' => $twilio_number,
                'body' => $message
            ));
            if ($send) {
                return true;
            } else {
                return false;
            }
        }
        catch (RestException $e) {
            return false;
        }
        return false;
    }
    return false;
}
function ToObject($array) {
    $object = new stdClass();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $value = ToObject($value);
        }
        if (isset($value)) {
            $object->$key = $value;
        }
    }
    return $object;
}
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
function PayUsingPayPal($product, $price, $mode = 'credits', $ReturnUrl = '', $CancelUrl = '') {
    global $config;
    $paypal = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential($config->paypal_id, $config->paypal_secret));
    $paypal->setConfig(array(
        'mode' => $config->paypal_mode
    ));
    if (empty($product)) {
        return false;
    }
    if (empty($price) || !is_numeric($price)) {
        return false;
    }
    $product  = Secure($product);
    $price    = Secure($price);
    $currency = $config->currency;
    $payer    = new Payer();
    $payer->setPaymentMethod('paypal');
    $item = new Item();
    $item->setName($product)->setQuantity(1)->setPrice($price)->setCurrency($currency);
    $itemList = new ItemList();
    $itemList->setItems(array(
        $item
    ));
    $details = new Details();
    $details->setSubtotal($price);
    $amount = new Amount();
    $amount->setCurrency($currency)->setTotal($price)->setDetails($details);
    $transaction = new Transaction();
    $transaction->setAmount($amount)->setItemList($itemList)->setDescription('Pay For ' . $config->site_name)->setInvoiceNumber(uniqid());
    $redirectUrls = new RedirectUrls();
    if ($ReturnUrl == '') {
        $ReturnUrl = $config->uri . '/aj/paypal/payment_success?userid=' . auth()->id . '&mode=' . $mode . '&price=' . $price . '&product=' . urlencode($product);
    }
    if ($CancelUrl == '') {
        $CancelUrl = $config->uri . '/aj/paypal/payment_cenceled?userid=' . auth()->id . '&mode=' . $mode . '&price=' . $price . '&product=' . urlencode($product);
    }
    $redirectUrls->setReturnUrl($ReturnUrl)->setCancelUrl($CancelUrl);
    $payment = new Payment();
    $payment->setIntent('sale')->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions(array(
        $transaction
    ));
    try {
        $payment->create($paypal);
    }
    catch (Exception $e) {
        $data = array(
            'type' => 'ERROR',
            'details' => json_decode($e->getData())
        );
        if (empty($data['details'])) {
            $data['details'] = json_decode($e->getCode());
        }
        return $data;
    }
    $data = array(
        'type' => 'SUCCESS',
        'url' => $payment->getApprovalLink()
    );
    return $data;
}
function PayPalCheckPayment($paymentId, $PayerID) {
    global $config;
    $paypal = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential($config->paypal_id, $config->paypal_secret));
    $paypal->setConfig(array(
        'mode' => $config->paypal_mode
    ));
    $payment = Payment::get($paymentId, $paypal);
    $execute = new PaymentExecution();
    $execute->setPayerId($PayerID);
    try {
        $result = $payment->execute($execute, $paypal);
    }
    catch (Exception $e) {
        return json_decode($e->getData(), true);
    }
    return true;
}
function SeoUri($link) {
    global $config;
    return $config->uri . '/' . $link;
}
function PayUsingStripe($product, $price, $ReturnUrl = '', $CancelUrl = '') {
    global $config, $paypal;
    if (empty($product)) {
        return false;
    }
    if (empty($price) || !is_numeric($price)) {
        return false;
    }
    $data     = array();
    $product  = Secure($product);
    $price    = Secure($price);
    $currency = strtolower($config->currency);
    $token    = '';
    try {
        $customer = \Stripe\Customer::create(array(
            'source' => $token
        ));
        $charge   = \Stripe\Charge::create(array(
            'customer' => $customer->id,
            'amount' => $price,
            'currency' => $currency
        ));
        if ($charge) {
            $data = array(
                'status' => 200,
                'error' => 'Payment successfully'
            );
        }
    }
    catch (Exception $e) {
        $data = array(
            'status' => 400,
            'error' => $e->getMessage()
        );
        return $data;
    }
}
function getMessageContainer($message){
    $class = "";
    $avater = "";
    $sent = "";
    if( $message->type == 'received' ){
        $class = "r";
        $avater = '     <div class="m_avatar"><img src="'. GetMedia($message->from_avater) .'" alt="'. $message->to_name .'" title="'. $message->to_name .'"></div>' . "\n";
    }else if( $message->type == 'sent' ){
        $class = "s";
        if( $message->seen > 0  ){
            $sent .= '      <div class="seen" title="'. $message->seen.'" data-seen="'.$message->seen.'">' . "\n";
            $sent .= '          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#03A9F4" d="M0.41,13.41L6,19L7.41,17.58L1.83,12M22.24,5.58L11.66,16.17L7.5,12L6.07,13.41L11.66,19L23.66,7M18,7L16.59,5.58L10.24,11.93L11.66,13.34L18,7Z" /></svg>' . "\n";
            $sent .= '      </div>' . "\n";
        }
    }
    $response = '<div class="messages messages--'.$message->type.'" data-msgid="'.$message->id.'" data-lastid="MSGID">' . "\n";
    $response .= '  <div class="msg_'.$class.'_combo">' . "\n";
    $response .= $avater;
    $response .= '      <div class="m_msg_part">' . "\n";
    $response .= 'CONTENT';
    $response .= '      </div>' . "\n";
    $response .= $sent;
    $response .= '  </div>' . "\n";
    $response .= '</div>' . "\n";
    return $response;
}
function renderTextMessage(&$message,$msg){
    if( (int)$msg['from'] === (int)auth()->id ){
        $message .= '<div class="message" data-messageid="'.$msg['id'].'">' . makeClickableLinks(trim(nl2br( $msg['_message'] )),'#ffffff') . '</div>';
    }else{
        $message .= '<div class="message" data-messageid="'.$msg['id'].'">' . makeClickableLinks(trim(nl2br( $msg['_message'] ))) . '</div>';
    }
}
function makeClickableLinks($s,$color='') {
    return stripslashes( preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" style="color: '.$color.'" target="_blank">$1</a>', $s) );
}
function renderMediaMessage(&$message,$msg){
    $css = "gifimg";
    $mediafile = $msg['_message'];
    if(strpos($mediafile,'giphy') === false){
        $mediafile = GetMedia($msg['_message']);
        $css = "image";
    }
    $message .= '<div class="message '.$css.'" data-messageid="'.$msg['id'].'"><a class="fancybox" href="'. $mediafile .'" rel="gallery'.$msg['id'].'" tabIndex="-1" data-fancybox="gallery'.$msg['id'].'"><img src="data:image/gif;base64,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" style="background: #dddddd;" data-src="' . $mediafile . '"></a></div>';
}
function renderStickerMessage(&$message,$msg){
    $message .= '<div class="message sticker" data-messageid="'.$msg['id'].'"><a class="fancybox" href="'. GetMedia($msg['_message']) .'" rel="gallery'.$msg['id'].'" tabIndex="-1" data-fancybox="gallery'.$msg['id'].'"><img src="' . GetMedia($msg['_message']) . '"></a></div>';
}
function chat_messages_sortFunction( $a, $b ) {
    return strtotime($a["created_at"]) - strtotime($b["created_at"]);
}
function logout($redirect = true){
    global $db,$config;
    $token = '';
    if( isset($_SESSION['user_id']) && $_SESSION['user_id'] !== '' ) {
        $db->where('web_token', $_SESSION['user_id'])->update('users', array('web_token' => null, 'web_token_created_at' => '0', 'web_device' => null));
        $db->where('session_id', $_SESSION['user_id'])->delete('sessions');
    }
    setcookie('JWT', '', 1, '/');
    setcookie('verify_email', '', 1, '/');
    setcookie('verify_phone', '', 1, '/');
    setcookie('quickdating', '', 1, '/');
    setcookie('src', '', 1, '/');
    setcookie('mode', '', 1, '/');
    if( isset($_SESSION['JWT'] ) ){
        unset($_SESSION['JWT']);
        unset($_SESSION['user_id']);
    }
    session_write_close();
    @session_destroy();
    if($redirect) {
        header('Location: ' . $config->uri);
        exit();
    }
}
function generate_chat_messages_convirsation($user_id,$to,$offset = 0,$show_unreadline = true,$lastmsg = 0,$prev=false){
    global $db,$console_log;

    $operator = '>';
    if( $prev == true ){
        $operator = '<';
    }
    $limit = array($offset,40);

    $db->where("m.id  " . $operator .  ' ' . (int)$lastmsg);
    $db->where("( (`to` = ? and `from` = ?) OR (`to` = ? and `from` = ?) )", Array($user_id,$to,$to,$user_id));
    $db->join("stickers s", "m.sticker=s.id", "LEFT");
    $db->join("users u", "m.`from`=u.id", "LEFT");
    $db->join("users u1", "m.`to`=u1.id", "LEFT");
    $db->orderBy('m.created_at','DESC');

    $chat_messages = $db->arrayBuilder()->get('messages m',$limit,array('m.id','u.username as from_name','u.avater as from_avater','u1.username as to_name','u1.avater as to_avater','m.`from`','m.`to`','m.text','m.media','m.from_delete','m.to_delete','s.file as sticker','m.created_at','m.seen'));
    if( !empty( $chat_messages ) ) {
        $messagesList = '';
        $MessageContainer = '';
        $chat = '';
        $is_from_delete = false;
        usort($chat_messages, "chat_messages_sortFunction");
        $_msg = LoadEndPointResource('messages');
        $last_message = count($chat_messages) - 1;
        $is_unread_show = false;
        $is_unread_showen = false;
        $unread_count = 0;
        $unread_txt = '<div class="unread_msg_line"> {{unread_count}} ' . __('Unread Messages') . '&nbsp;&nbsp;</div>';
        if ($chat_messages) {

            foreach ($chat_messages as $key => $value) {
                if (!empty($value['text'])) {
                    $chat_messages[$key]['_function'] = 'renderTextMessage';
                    $chat_messages[$key]['_message'] = $value['text'];
                }
                if (!empty($value['media'])) {
                    $chat_messages[$key]['_function'] = 'renderMediaMessage';
                    $chat_messages[$key]['_message'] = $value['media'];
                }
                if (!empty($value['sticker'])) {
                    $chat_messages[$key]['_function'] = 'renderStickerMessage';
                    $chat_messages[$key]['_message'] = $value['sticker'];
                }
                if ($value['to'] !== $user_id) {
                    $chat_messages[$key]['type'] = 'sent';
                    $chat_messages[$key]['class'] = 's';
                } else {
                    $chat_messages[$key]['type'] = 'received';
                    $chat_messages[$key]['class'] = 'r';
                }
                if (isset($chat_messages[$key + 1])) {
                    if ($chat_messages[$key + 1]['to'] !== $value['to']) {
                        $chat_messages[$key]['container'] = getMessageContainer(ToObject($chat_messages[$key]));
                        $MessageContainer = getMessageContainer(ToObject($chat_messages[$key]));
                    }
                    if ($chat_messages[$key]['seen'] === 0) {
                        $is_unread_show = true;
                        if ($_msg) {

                            if ($user_id == $value['to']) {

                                if ($_msg->setMessageSeen($value['id'], $value['from'])) {
                                    $unread_count++;
                                }
                            }
                        }
                    }
                } else {
                    $chat_messages[$last_message]['container'] = getMessageContainer(ToObject($chat_messages[$key]));
                    $MessageContainer = getMessageContainer(ToObject($chat_messages[$key]));
                    if ($chat_messages[$key]['seen'] === 0) {
                        $is_unread_show = true;
                        if ($_msg) {
                            if ($user_id == $value['to']) {
                                if ($_msg->setMessageSeen($value['id'], $value['from'])) {
                                    $unread_count++;
                                }
                            }
                        }
                    }
                    $unread_txt = str_replace('{{unread_count}}', $unread_count, $unread_txt);
                }
                if (isset($chat_messages[$key]['_function'])) {
                    if ($chat_messages[$key]['from'] == $user_id && $chat_messages[$key]['from_delete'] == 1) {

                    } else if ($chat_messages[$key]['to'] == $user_id && $chat_messages[$key]['to_delete'] == 1) {

                    } else {
                        $chat .= call_user_func_array($chat_messages[$key]['_function'], array(&$chat, $chat_messages[$key]));
                    }
                }
                if ($is_unread_show == true && $is_unread_showen === false) {
                    $is_unread_showen = true;
                }
                if (isset($chat_messages[$key]['container'])) {
                    $messagesList .= str_replace(array('CONTENT', 'MSGID'), array($chat, $chat_messages[$key]['id']), $MessageContainer);
                    $chat = '';
                }
            }
        } else {
            $db->where('`to`', $user_id)->where('`from`', $to)->where('seen', 0)->update('messages', array('seen' => time()));
        }


        if ($show_unreadline) {
            $messagesList = str_replace('{{unread_text}}', $unread_txt, $messagesList);
        } else {
            $messagesList = str_replace('{{unread_text}}', '', $messagesList);
        }
        return $messagesList;
    }else{
        return '';
    }
}
function userEmailNotification($recipient_id){
    $u = LoadEndPointResource( 'users' )->get_user_profile($recipient_id);
    $data = array(
        'email_on_profile_view'             => $u->email_on_profile_view,
        'email_on_new_message'              => $u->email_on_new_message,
        'email_on_profile_like'             => $u->email_on_profile_like,
        'email_on_purchase_notifications'   => $u->email_on_purchase_notifications,
        'email_on_special_offers'           => $u->email_on_special_offers,
        'email_on_announcements'            => $u->email_on_announcements,
        'email_on_get_gift'                 => $u->email_on_get_gift,
        'email_on_got_new_match'            => $u->email_on_got_new_match,
        'email_on_chat_request'             => $u->email_on_chat_request
    );
    if (!in_array(1, $data)) {
        return false;
    } else {
        return $data;
    }
}
function sendNotificationEmail($notification){
    global $db,$config;
    $send_mail = false;
    $userEmailNotification = $db->where('id', $notification['recipient_id'])->getOne('users',array('id','username','first_name','last_name','email','email_on_profile_view','email_on_profile_like','email_on_get_gift','email_on_got_new_match','email_on_new_message','email_on_purchase_notifications','email_on_chat_request'));

    $u = auth();

    if($config->emailNotification == 1 && $userEmailNotification !== false) {
        if (($notification['type'] == 'visit') && $userEmailNotification['email_on_profile_view'] == 1) {
            $send_mail = true;
        }
        if (($notification['type'] == 'like') && $userEmailNotification['email_on_profile_like'] == 1) {
            $send_mail = true;
        }
        if (($notification['type'] == 'send_gift') && $userEmailNotification['email_on_get_gift'] == 1) {
            $send_mail = true;
        }
        if (($notification['type'] == 'got_new_match') && $userEmailNotification['email_on_got_new_match'] == 1) {
            $send_mail = true;
        }
        if (($notification['type'] == 'message') && $userEmailNotification['email_on_new_message'] == 1) {
            $send_mail = true;
        }
        if (($notification['type'] == 'approve_receipt' || $notification['type'] == 'disapprove_receipt') && $userEmailNotification['email_on_purchase_notifications'] == 1) {
            $send_mail = true;
        }
        if (($notification['type'] == 'accept_chat_request' || $notification['type'] == 'decline_chat_request') && $userEmailNotification['email_on_chat_request'] == 1) {
            $send_mail = true;
        }
    }
    if ($send_mail == true) {
        $body = Emails::parse('notification-email', array(
            'full_name' => $u->full_name,
            'username' => $u->username,
            'avater' => $u->avater->avater,
            'contents' => $notification['contents'],
            'url' => $notification['url']
        ));
        SendEmail($userEmailNotification['email'], 'New notification', $body,true);
    }
    return true;
}
function CanSendEmails() {
    global $config;
    if (IS_LOGGED == false) {
        return false;
    }
    // if ($config->smtp_or_mail == 'mail') {
    //     return false;
    // }
    $can_send_time = time() - 180;
    $u = auth();
    if ($u->last_email_sent > $can_send_time) {
        return false;
    }
    return true;
}
function SendMessageFromDB() {
    global $config,$conn;
    $mail = new PHPMailer;
    if (IS_LOGGED == false) {
        return false;
    }
    $data = array();
    if (CanSendEmails() === false) {
        return false;
    }
    $u = auth();
    $user_id   = Secure($u->id);
    $query_one = " SELECT * FROM `emails` WHERE `user_id` = {$user_id} ORDER BY `id` DESC";
    $sql       = mysqli_query($conn, $query_one);
    if (mysqli_num_rows($sql) < 1) {
        return false;
    }

    if ($config->smtp_or_mail == 'mail') {
        $mail->IsMail();
    } else if ($config->smtp_or_mail == 'smtp') {
        $mail->isSMTP();
        $mail->Host          = $config->smtp_host;
        $mail->SMTPAuth      = true;
        $mail->SMTPKeepAlive = true;
        $mail->Username      = $config->smtp_username;
        $mail->Password      = $config->smtp_password;
        $mail->SMTPSecure    = $config->smtp_encryption;
        $mail->Port          = $config->smtp_port;
        $mail->SMTPOptions   = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    } else {
        return false;
    }
    $mail->setFrom($config->siteEmail, $config->site_name);
    $send          = false;
    $mail->CharSet = 'utf-8';

    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $mail->addAddress($fetched_data['email_to']);
        $mail->Subject = $fetched_data['subject'];
        $mail->MsgHTML($fetched_data['message']);
        $mail->IsHTML(true);
        $send = $mail->send();
        if($send){
            $query_one_  = "DELETE FROM `emails` WHERE `user_id` = {$user_id} AND `id`= " . $fetched_data['id'];
            $sql_        = mysqli_query($conn, $query_one_);
        }
        $mail->ClearAddresses();
    }

    $query_one__ = "UPDATE `users` SET `last_email_sent` = " . time() . " WHERE `id` = {$user_id}";
    $sql__       = mysqli_query($conn, $query_one__);
    return $send;
}
function sendOneSignalPush($data = array()){
    global $db,$config;
    if( $config->push == 0 ){
        return false;
    }
    if( !isset( $data['img'] ) ){
        $data['img'] = $config->uri . '/themes/' . $config->theme .'/assets/img/icon.png';
    }

    $notify['userdata'] = $db->where('id', $data['data']['notifier_id'])->getOne('users',array('id','username','first_name','last_name','avater'));

    if( !isset( $notify['userdata']['username'] ) ){
        $data['title'] = $config->site_name;
    }else{
        $data['title'] = $notify['userdata']['username'] . ' . ' . $config->site_name;
    }
    if( !isset( $data['url'] ) ){
        $data['url'] = $config->uri;
    }
    $fields = array(
        'app_id' => $config->push_id,
        'headings' => array("en" => $data['title']),
        'isAnyWeb' => true,
        'chrome_web_icon' => $data['img'],
        'firefox_icon' => $data['img'],
        'chrome_web_image' => $data['img'],
        //'url' => $data['url'],
    );
    //if( isset( $data['data'] ) ){
    $notify = array();
    $notify['type'] = $data['data']['type'];
    $notify['userdata'] = $db->where('id', $data['data']['notifier_id'])->getOne('users',array('id','username','first_name','last_name','avater'));
    $notify['userdata']['avater'] = GetMedia($notify['userdata']['avater']);
    $fields['data'] = $notify;
    //}
    if( !isset( $data['player_ids'] )){
        $fields['included_segments'] = array('All');
    }else{
        $fields['include_player_ids'] = $data['player_ids'];
    }
    $notification_text = Dataset::load('notification');
    if (isset($notification_text[$data['data']['type']])) {
        $txt = $notification_text[$data['data']['type']];
        $fields['contents'] = array("en" => $txt);
    }else{
        $fields['contents'] = array("en" => '');
    }
    $ch = curl_init();
    $onesignal_post_url = "https://onesignal.com/api/v1/notifications";
    curl_setopt($ch, CURLOPT_URL, $onesignal_post_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Basic ' . $config->push_key
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $curl_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($response);
    if ($curl_http_code === 200) {
        if( isset( $data['id'] ) && !empty( $data['id'] ) ){
            $db->where('id', (int)$data['id'])->update('notifications',array('push_sent'=>time()));
        }
        return true;
    }else{
        return false;
    }
}
function audit($type,$data){
    global $db;
    return false;

    $txt = '';
    if( is_array($data) ) {
        $txt = "Key                             : Value\n";
        $txt .= "--------------------------------------------------------------\n";
        foreach ($data as $key => $value) {
            $txt .= "|" . str_pad($key, 30, ".", STR_PAD_RIGHT) . "\t: " . ( is_array($value) ? json_encode($value) : $value ) . "\n";
        }
    }else{
        $txt = $data;
    }
    $item = array();
    $item['type'] = $type;
    $item['message'] = $txt;
    $item['user_id'] = auth()->id;
    $item['created_at'] = time();
    $db->insert('audits',$item);
}
function get_time_ago($time_stamp)
{
    //_lang
//    $strings = [
//        'suffixAgo' => _lang("ago"),
//        'suffixFromNow' => _lang("from now"),
//        'inPast'=> _lang("any moment now"),
//        'seconds'=> _lang("Just now"),
//        'minute' => _lang("about a minute ago"),
//        'minutes' => _lang("%d minutes ago"),
//        'hour'=> _lang("about an hour ago"),
//        'hours'=> _lang("%d hours ago"),
//        'day'=> _lang("a day ago"),
//        'days'=> _lang("%d days ago"),
//        'month'=> _lang("about a month ago"),
//        'months'=> _lang("%d months ago"),
//        'year'=> _lang("about a year ago"),
//        'years'=> _lang("%d years ago"),
//    ];

    $strings = [
        'suffixAgo' => __("ago"),
        'suffixFromNow' => __("from now"),
        'inPast'=> __("any moment now"),
        'seconds'=> __("Just now"),
        'minute' => __("about a minute ago"),
        'minutes' => __("%d minutes ago"),
        'hour'=> __("about an hour ago"),
        'hours'=> __("%d hours ago"),
        'day'=> __("a day ago"),
        'days'=> __("%d days ago"),
        'month'=> __("about a month ago"),
        'months'=> __("%d months ago"),
        'year'=> __("about a year ago"),
        'years'=> __("%d years ago"),
    ];

//    $strings = [
//        'suffixAgo' => "ago",
//        'suffixFromNow' => "from now",
//        'inPast'=> "any moment now",
//        'seconds'=> "Just now",
//        'minute' => "about a minute ago",
//        'minutes' => "%d minutes ago",
//        'hour'=> "about an hour ago",
//        'hours'=> "%d hours ago",
//        'day'=> "a day ago",
//        'days'=> "%d days ago",
//        'month'=> "about a month ago",
//        'months'=> "%d months ago",
//        'year'=> "about a year ago",
//        'years'=> "%d years ago",
//    ];

    $time_difference = time() - $time_stamp;
    $seconds =  $time_difference ;
    $minutes = $seconds / 60;
    $hours = $minutes / 60;
    $days = $hours / 24;
    $years = $days / 365;

    if( $seconds < 45 ){
        return str_replace('%d',floor($seconds), $strings['seconds']);
    }
    if( $seconds < 90 ){
        return str_replace('%d',1, $strings['minute']);
    }
    if( $minutes < 45 ){
        return str_replace('%d',floor($minutes), $strings['minutes']);
    }
    if( $minutes < 90 ){
        return str_replace('%d',1, $strings['hour']);
    }
    if( $hours < 24 ){
        return str_replace('%d',floor($hours), $strings['hours']);
    }
    if( $hours < 42 ){
        return str_replace('%d',1, $strings['day']);
    }
    if( $days < 30 ){
        return str_replace('%d',floor($days), $strings['days']);
    }
    if( $days < 45 ){
        return str_replace('%d',1, $strings['month']);
    }
    if( $days < 365 ){
        return str_replace('%d',floor($days / 30), $strings['months']);
    }
    if( $years < 1.5 ){
        return str_replace('%d',1, $strings['year']);
    }else{
        return str_replace('%d',floor($years), $strings['years']);
    }
}
function get_time_ago_string($time_stamp, $divisor, $time_unit)
{
    $time_difference = strtotime("now") - $time_stamp;
    $time_units      = round(floor($time_difference / $divisor));
    settype($time_units, 'string');
    if( $time_difference < 45 ){
        return __('Just now');
    }else if( $time_difference < 90 ){
        return __('about a minute ago');
    }else if( $time_difference < 45*60 ){
        return str_replace('%d',$time_units, __('%d minutes ago'));
    }else if( $time_difference < 90*60 ){
        return __('about an hour ago');
    }else if( $time_difference < 24*60*60 ){
        return str_replace('%d',$time_units, __('%d hours ago'));
    }else if( $time_difference < 42*60*60 ){
        return __('a day ago');
    }else if( $time_difference < 30*24*60*60 ){
        return str_replace('%d',$time_units,__('%d days ago'));
    }else if( $time_difference < 45*24*60*60 ){
        return __('about a month ago');
    }else if( $time_difference < 365*24*60*60 ){
        return str_replace('%d',$time_units,__('%d months ago'));
    }else if( $time_difference < 1.5*365*24*60*60 ){
        return __('about a year ago');
    }else{
        return str_replace('%d',$time_units,__('%d years ago'));
    }
}
function minifyhtml($input) {
    if($input === "") return $input;
    $input = preg_replace_callback('#<([^\/\s<>!]+)(?:\s+([^<>]*?)\s*|\s*)(\/?)>#s', function($matches) {
        return '<' . $matches[1] . preg_replace('#([^\s=]+)(\=([\'"]?)(.*?)\3)?(\s+|$)#s', ' $1$2', $matches[2]) . $matches[3] . '>';
    }, str_replace("\r", "", $input));
    if(strpos($input, ' style=') !== false) {
        $input = preg_replace_callback('#<([^<]+?)\s+style=([\'"])(.*?)\2(?=[\/\s>])#s', function($matches) {
            return '<' . $matches[1] . ' style=' . $matches[2] . minify_css($matches[3]) . $matches[2];
        }, $input);
    }
    if(strpos($input, '</style>') !== false) {
        $input = preg_replace_callback('#<style(.*?)>(.*?)</style>#is', function($matches) {
            return '<style' . $matches[1] .'>'. minify_css($matches[2]) . '</style>';
        }, $input);
    }
    return preg_replace(
        array(
            '#<(img|input)(>| .*?>)#s',
            '#(<!--.*?-->)|(>)(?:\n*|\s{2,})(<)|^\s*|\s*$#s',
            '#(<!--.*?-->)|(?<!\>)\s+(<\/.*?>)|(<[^\/]*?>)\s+(?!\<)#s',
            '#(<!--.*?-->)|(<[^\/]*?>)\s+(<[^\/]*?>)|(<\/.*?>)\s+(<\/.*?>)#s',
            '#(<!--.*?-->)|(<\/.*?>)\s+(\s)(?!\<)|(?<!\>)\s+(\s)(<[^\/]*?\/?>)|(<[^\/]*?\/?>)\s+(\s)(?!\<)#s',
            '#(<!--.*?-->)|(<[^\/]*?>)\s+(<\/.*?>)#s',
            '#<(img|input)(>| .*?>)<\/\1>#s',
            '#(&nbsp;)&nbsp;(?![<\s])#',
            '#(?<=\>)(&nbsp;)(?=\<)#',
            '#\s*<!--(?!\[if\s).*?-->\s*|(?<!\>)\n+(?=\<[^!])#s'
        ),
        array(
            '<$1$2</$1>',
            '$1$2$3',
            '$1$2$3',
            '$1$2$3$4$5',
            '$1$2$3$4$5$6$7',
            '$1$2$3',
            '<$1$2',
            '$1 ',
            '$1',
            ""
        ),
        $input);
}
function minify_css($input) {
    if(trim($input) === "") return $input;
    return preg_replace(
        array(
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
            '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
            '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
            '#(background-position):0(?=[;\}])#si',
            '#(?<=[\s:,\-])0+\.(\d+)#s',
            '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
            '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
            '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
            '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
            '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
        ),
        array(
            '$1',
            '$1$2$3$4$5$6$7',
            '$1',
            ':0',
            '$1:0 0',
            '.$1',
            '$1$3',
            '$1$2$4$5',
            '$1$2$3',
            '$1:0',
            '$1$2'
        ),
        $input);
}
function minify_js($input) {
    if(trim($input) === "") return $input;
    return preg_replace(
        array(
            '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
            '#;+\}#',
            '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
            '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
        ),
        array(
            '$1',
            '$1$2',
            '}',
            '$1$3',
            '$1.$3'
        ),
        $input);
}
function DeleteSpamWarning() {
    global $conn,$db;
    $day_duration   = 86400;
    $query_one = "SELECT `id`, `spam_warning` FROM `users` WHERE `spam_warning` > 0 ORDER BY `id` ASC";
    $sql       = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        if ($fetched_data['spam_warning'] < (time() - $day_duration)) {
            $db->where('id',$fetched_data['id'])->update('users',array('spam_warning'=>'0'));
        }
    }
    return true;
}
function DeleteExpiredProMemebership() {
    global $conn,$db;
    $week_duration   = 604800;
    $month_duration    = 2629743;
    $year_duration = 31556926;
    $life_duration    = 0;

    $data      = array();
    $query_one = "SELECT `id`, `is_pro`, `pro_type`, `pro_time` FROM `users` WHERE `is_pro` = '1' ORDER BY `id` ASC";
    $sql       = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $update_data = false;
        switch ($fetched_data['pro_type']) {
            case '1':
                if ($fetched_data['pro_time'] < (time() - $week_duration)) {
                    $update_data = true;
                }
                break;
            case '2':
                if ($fetched_data['pro_time'] < (time() - $month_duration)) {
                    $update_data = true;
                }
                break;
            case '3':
                if ($fetched_data['pro_time'] < (time() - $year_duration)) {
                    $update_data = true;
                }
                break;
            case '4':
                if ($life_duration > 0) {
                    if ($fetched_data['pro_time'] < (time() - $life_duration)) {
                        $update_data = true;
                    }
                }
                break;
        }
        if ($update_data == true) {
            $db->where('id',$fetched_data['id'])->update('users',array('pro_time'=>'0','pro_type'=>'0','is_pro'=>'0'));
        }
    }
    return true;
}
function DeleteExpiredBoosts() {
    global $config,$db;
    $boost_duration   = time() - ( $config->boost_expire_time * 60 );
    $boosted = $db->objectBuilder()->where('is_boosted','1')->get('users',null,array('id','boosted_time'));
    foreach ($boosted as $key => $value){
        if( isset( $value->boosted_time ) ){
            if($value->boosted_time <= $boost_duration){
                $db->where('id',$value->id)->update('users',array('is_boosted'=>'0','boosted_time'=>'0'));
            }
        }
    }
    return true;
}
function DeleteExpiredXvisits() {
    global $config,$db;
    $_duration   = time() - ( $config->xvisits_expire_time * 60 );
    $boosted = $db->objectBuilder()->where('user_buy_xvisits','1')->get('users',null,array('id','xvisits_created_at'));
    foreach ($boosted as $key => $value){
        if( isset( $value->xvisits_created_at ) ){
            if($value->xvisits_created_at <= $_duration){
                $db->where('id',$value->id)->update('users',array('user_buy_xvisits'=>'0','xvisits_created_at'=>'0'));
            }
        }
    }
    return true;
}
function DeleteExpiredXmatches() {
    global $config,$db;
    $_duration   = time() - ( $config->xmatche_expire_time * 60 );
    $boosted = $db->objectBuilder()->where('user_buy_xmatches','1')->get('users',null,array('id','xmatches_created_at'));
    foreach ($boosted as $key => $value){
        if( isset( $value->xmatches_created_at ) ){
            if($value->xmatches_created_at <= $_duration){
                $db->where('id',$value->id)->update('users',array('user_buy_xmatches'=>'0','xmatches_created_at'=>'0'));
            }
        }
    }
    return true;
}
function DeleteExpiredHotUsers() {
    global $config,$db;
    $week_duration   = 604800;
    $month_duration  = 2629743;
    $year_duration   = 31556926;
    $_duration   = time() - $week_duration;
    $db->objectBuilder()->where('created_at',$_duration,'<=')->delete('hot');
    return true;
}
function DeleteUnusedVideo() {
    global $config, $db,$_BASEPATH;
    $videos = $db->where('is_video', '1')->where('is_confirmed', '0')->get('mediafiles',null, array('*'));
    foreach ($videos as $key => $value){
        $date1 = strtotime($value['created_at']);
        $date2 = time();
        $interval = floor(($date2 - $date1) / 60);
        if($interval > 30) {
            if ($value['private_file'] <> '') {
                $private_file = $_BASEPATH . str_replace('/', DIRECTORY_SEPARATOR, $value['private_file']);
                if (file_exists($private_file)) {
                    @unlink($private_file);
                }
            }
            if ($value['file'] <> '') {
                $file = $_BASEPATH . str_replace('/', DIRECTORY_SEPARATOR, $value['file']);
                if (file_exists($file)) {
                    @unlink($file);
                }
            }
            if ($value['video_file'] <> '') {
                $video_file = $_BASEPATH . str_replace('/', DIRECTORY_SEPARATOR, $value['video_file']);
                if (file_exists($video_file)) {
                    @unlink($video_file);
                }
            }
            $db->where('id', $value['id'])->delete('mediafiles');
        }
    }
}
function DeleteExpiredXlikes() {
    global $config,$db;
    $_duration   = time() - ( $config->xlike_expire_time * 60 );
    $boosted = $db->objectBuilder()->where('user_buy_xlikes','1')->get('users',null,array('id','xlikes_created_at'));
    foreach ($boosted as $key => $value){
        if( isset( $value->xlikes_created_at ) ){
            if($value->xlikes_created_at <= $_duration){
                $db->where('id',$value->id)->update('users',array('user_buy_xlikes'=>'0','xlikes_created_at'=>'0'));
            }
        }
    }
    return true;
}
function ShareFile($data = array(), $type = 0, $crop = true,$fldr=false) {
    global $config, $s3,$_UPLOAD;
    $allowed = '';
    $path = '';
    if( $fldr !== false && $fldr == 'blogs' ){
        $path = '../';
    }
    if (!file_exists($path.'upload/files/' . date('Y'))) {
        @mkdir($path.'upload/files/' . date('Y'), 0777, true);
    }
    if (!file_exists($path.'upload/files/' . date('Y') . '/' . date('m'))) {
        @mkdir($path.'upload/files/' . date('Y') . '/' . date('m'), 0777, true);
    }
    if (!file_exists($path.'upload/photos/' . date('Y'))) {
        @mkdir($path.'upload/photos/' . date('Y'), 0777, true);
    }
    if (!file_exists($path.'upload/photos/' . date('Y') . '/' . date('m'))) {
        @mkdir($path.'upload/photos/' . date('Y') . '/' . date('m'), 0777, true);
    }
    if (!file_exists($path.'upload/videos/' . date('Y'))) {
        @mkdir($path.'upload/videos/' . date('Y'), 0777, true);
    }
    if (!file_exists($path.'upload/videos/' . date('Y') . '/' . date('m'))) {
        @mkdir($path.'upload/videos/' . date('Y') . '/' . date('m'), 0777, true);
    }
    if (!file_exists($path.'upload/sounds/' . date('Y'))) {
        @mkdir($path.'upload/sounds/' . date('Y'), 0777, true);
    }
    if (!file_exists($path.'upload/sounds/' . date('Y') . '/' . date('m'))) {
        @mkdir($path.'upload/sounds/' . date('Y') . '/' . date('m'), 0777, true);
    }
    if (!file_exists($path.'upload/gifts/' . date('Y'))) {
        @mkdir($path.'upload/gifts/' . date('Y'), 0777, true);
    }
    if (!file_exists($path.'upload/gifts/' . date('Y') . '/' . date('m'))) {
        @mkdir($path.'upload/gifts/' . date('Y') . '/' . date('m'), 0777, true);
    }
    if (isset($data['file']) && !empty($data['file'])) {
        $data['file'] = $data['file'];
    }
    if (isset($data['name']) && !empty($data['name'])) {
        $data['name'] = Secure($data['name']);
    }
    if (empty($data)) {
        return false;
    }
    $allowed = 'jpg,png,jpeg,gif,mp4,m4v,webm,flv,mov,mpeg,mp3,wav';
    $new_string        = pathinfo($data['name'], PATHINFO_FILENAME) . '.' . strtolower(pathinfo($data['name'], PATHINFO_EXTENSION));
    $extension_allowed = explode(',', $allowed);
    $file_extension    = pathinfo($new_string, PATHINFO_EXTENSION);
    if (!in_array($file_extension, $extension_allowed)) {
        return false;
    }
    if ($data['size'] > $config->maxUpload) {
        return false;
    }
    if ($file_extension == 'jpg' || $file_extension == 'jpeg' || $file_extension == 'png' || $file_extension == 'gif') {
        $folder   = 'photos';
        $fileType = 'image';
    } else if ($file_extension == 'mp4' || $file_extension == 'mov' || $file_extension == 'webm' || $file_extension == 'flv') {
        $folder   = 'videos';
        $fileType = 'video';
    } else if ($file_extension == 'mp3' || $file_extension == 'wav') {
        $folder   = 'sounds';
        $fileType = 'soundFile';
    } else {
        $folder   = 'files';
        $fileType = 'file';
    }
    if( $fldr !== false && $fldr == 'blogs' ){
        $folder = 'photos';
    }
    if (empty($folder) || empty($fileType)) {
        return false;
    }
    $mime_types = explode(',', str_replace(' ', '', $config->mime_types . ',application/octet-stream'));
    if (!in_array($data['type'], $mime_types)) {
        return false;
    }
    $fn = GenerateKey() . '_' . date('d') . '_' . md5(time()) . "_{$fileType}.{$file_extension}";
    $dir         = $_UPLOAD . "{$folder}" . DIRECTORY_SEPARATOR . date('Y') . DIRECTORY_SEPARATOR . date('m');
    $filename    = $dir . DIRECTORY_SEPARATOR . $fn;

    if( $fldr == 'gifts' || $fldr == 'stickers' ){
        $filename    = 'upload/' . "{$fldr}" . DIRECTORY_SEPARATOR . $fn;
    }

    $second_file = pathinfo($filename, PATHINFO_EXTENSION);
    if (move_uploaded_file($data['file'], $filename)) {
        if ($second_file == 'jpg' || $second_file == 'jpeg' || $second_file == 'png' || $second_file == 'gif') {
            $check_file = getimagesize($filename);
            if (!$check_file) {
                unlink($filename);
            }
            if( $crop == true ){
                if ($type == 1) {
                    @CompressImage($filename, $filename, 50);
                    $explode2  = @end(explode('.', $filename));
                    $explode3  = @explode('.', $filename);
                    $last_file = $explode3[0] . '_small.' . $explode2;

                    if (Resize_Crop_Image(400, 400, $filename, $last_file, 60)) {
                        if (($config->amazone_s3 == 1) && !empty($last_file)) {
                            $upload_s3 = UploadToS3($last_file);
                        }
                    }
                } else {
                    if (!isset($data['compress']) && $second_file != 'gif') {
                        @CompressImage($filename, $filename, 10);
                    }
                }
            }
        }
        if (!empty($data['crop'])) {
            $crop_image = Resize_Crop_Image($data['crop']['width'], $data['crop']['height'], $filename, $filename, 60);
        }
        if (($config->amazone_s3 == 1 ) && !empty($filename)) {
            $upload_s3 = UploadToS3($filename);
        }
        $last_data             = array();
        if( $fldr == 'gifts' || $fldr == 'stickers' ) {
            $last_data['filename'] = 'upload/'.$fldr.'/'.$fn;
        }else{
            if( $fldr !== false && $fldr == 'blogs' ){
                $last_data['filename'] = 'upload/photos/'. date('Y') . '/' . date('m') . '/' . $fn;
            }else{
                $last_data['filename'] = $filename;
            }
        }
        $last_data['name']     = $data['name'];
        return $last_data;
    }
}
function GetStories(){
    global $conn;
    $data = array();
    $sql  = mysqli_query($conn, 'SELECT * FROM `success_stories` WHERE `status` = "1" ORDER BY `story_date` DESC, `id` DESC LIMIT 4;');
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $fetched_data['user1Data'] = userData($fetched_data['user_id']);
        $fetched_data['user2Data'] = userData($fetched_data['story_user_id']);
        $data[] = $fetched_data;
    }
    return $data;
}
function GetSiteUsers(){
    global $conn, $config;
    $data = array();
    $showed_user = 20;
    if(!empty($config->showed_user)){
        $showed_user = $config->showed_user;
    }
    $sql  = mysqli_query($conn, 'SELECT * FROM `users` WHERE `active` = "1" ORDER BY `id` DESC LIMIT '.$showed_user.' ;');
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $data[] = userData($fetched_data['id']);;
    }
    return $data;
}
function GetNonProMaxUserChatsPerDay($userid){
    global $conn;
    $data      = array();
    $query_one = "SELECT COUNT(DISTINCT(messages.`to`)) as ChatCount FROM messages WHERE messages.`from` = ".$userid." AND DATE(messages.created_at) = CURDATE() ORDER BY messages.`to`";
    $sql       = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $data['ChatCount'] = $fetched_data['ChatCount'];
    }
    return $data['ChatCount'];
}
function isNonProBuyChatCredits($userid,$chat_userid){
    global $conn;
    $data      = array();
    $row_cnt = 0;
    $query_one = "SELECT id FROM user_chat_buy WHERE `user_id` = ".$userid." AND `chat_user_id` = ".$chat_userid." AND DATE(`created_at`) = CURDATE() LIMIT 1";
    if ($result = mysqli_query($conn, $query_one)){
        $row_cnt = mysqli_num_rows($result);
        mysqli_free_result($result);
    }
    if( $row_cnt == 0 ){
        return false;
    }else{
        return true;
    }
}
function isNonProCanChatWith($userid,$chat_userid){
    global $conn;
    $_result = false;
    $row_cnt = 0;
    $query_one = "SELECT id FROM `messages` WHERE ( ( `from` = ".$userid." AND `to` = ".$chat_userid." ) OR ( `from` = ".$chat_userid." AND `to` = ".$userid." ) ) AND DATE(`created_at`) = CURDATE() LIMIT 1";
    if ($result = mysqli_query($conn, $query_one)){
        $row_cnt = mysqli_num_rows($result);
        mysqli_free_result($result);
    }
    if( $row_cnt > 0 ){
        $_result = true;
    }
    //If one user used credit to initiate chat the other should be able to reply without having to buy credit.
//    $_result2 = isNonProBuyChatCredits($chat_userid,$userid);
//    if( $_result2 === false ){
//        $_result = false;
//    }else{
//        $_result = true;
//    }
//    $_result = isNonProBuyChatCredits($userid,$chat_userid);

    return $_result;
}
function isChatBefore($userid,$chat_userid){
    global $conn;
    if (IS_LOGGED == false) {
        return false;
    }
    if (empty($userid)) {
        return false;
    }
    $userid    = Secure($userid);
    $chat_userid    = Secure($chat_userid);
    $sql = 'SELECT count(id) FROM `conversations` WHERE `sender_id` = '.$userid.' AND `receiver_id` = '.$chat_userid.' AND `status` = 1';
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        if((int)Sql_Result($query, 0) > 0){
            return true;
        }else{
            return false;
        }
    } else {
        return false;
    }


}
function NonProCanChat($userid,$chat_userid){
    global $conn;
    $data  = array();
    $query = 'SELECT
                    `id`,
                    (SELECT `created_at` FROM `conversations` WHERE `sender_id` = `users`.`id` ORDER BY `created_at` DESC LIMIT 1) as last_chat,
                    DATEDIFF(DATE_FORMAT(FROM_UNIXTIME((SELECT `created_at` FROM `conversations` WHERE `sender_id` = `users`.`id` ORDER BY `created_at` DESC LIMIT 1)), \'%Y-%m-%d %H:%i:%s\'),CURDATE()) * -1 as `days`
                FROM 
                    `users`
                WHERE
                    `id` IN (SELECT receiver_id FROM `conversations` WHERE sender_id = '.$userid.')
                AND
                    (`id` NOT IN (SELECT `id` FROM `user_chat_buy` WHERE `user_id` = '.$userid.')';
    $sql = mysqli_query($conn, $query);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $data[$fetched_data['id']]['last_chat'] = $fetched_data['last_chat'];
        $data[$fetched_data['id']]['days'] = $fetched_data['days'];
    }
    if( isset($data[$chat_userid]) ){
        if( $data[$chat_userid]['days'] > 1 ){
            return false;
        }else{
            return true;
        }
    }else{
        return false;
    }
}
function GetLastChat($userid){
    global $conn;
    $data  = 0;
    $query = 'SELECT `created_at` FROM `conversations` WHERE `sender_id` = '.$userid.' AND `receiver_id` NOT IN (SELECT `chat_user_id` FROM `user_chat_buy` WHERE `user_id` = '.$userid.') ORDER BY `created_at` DESC LIMIT 1';
    $sql = mysqli_query($conn, $query);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $data = $fetched_data['created_at'];
    }
    if( $data > 1 ){
        return $data;
    }else{
        return 0;
    }
}
function GetTotalLikes(){
    global $conn;
    $data      = array();
    $query_one = "SELECT COUNT(`id`) as LikeCount FROM `likes` WHERE `created_at` >= (DATE_SUB(CURDATE(), INTERVAL 5 MINUTE));";
    $sql       = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $data['LikeCount'] = $fetched_data['LikeCount'];
    }
    return $data['LikeCount'];
}
function GetTotalVisits(){
    global $conn;
    $data      = array();
    $query_one = "SELECT COUNT(`id`) as VisitCount FROM `views` WHERE `created_at` >= (DATE_SUB(CURDATE(), INTERVAL 5 MINUTE));";
    $sql       = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $data['VisitCount'] = $fetched_data['VisitCount'];
    }
    return $data['VisitCount'];
}
function GetTotalMatches(){
    global $conn;
    $data      = array();
    $query_one = "SELECT COUNT(`id`) as MatcheCount FROM `notifications` WHERE `type` = 'got_new_match' AND `created_at` >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 5 MINUTE));";
    $sql       = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $data['MatcheCount'] = $fetched_data['MatcheCount'];
    }
    return $data['MatcheCount'];
}
function GetUserTotalLikes($userid){
    global $conn;
    $data      = array();
    $query_one = "SELECT COUNT(`id`) as LikeCount FROM `likes` WHERE `like_userid` = ".$userid." AND `created_at` >= (DATE_SUB(CURDATE(), INTERVAL 5 MINUTE));";
    $sql       = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $data['LikeCount'] = $fetched_data['LikeCount'];
    }
    return $data['LikeCount'];
}
function GetUserTotalVisits($userid){
    global $conn;
    $data      = array();
    $query_one = "SELECT COUNT(`id`) as VisitCount FROM `views` WHERE `view_userid` = ".$userid." AND `created_at` < NOW() AND UNIX_TIMESTAMP(`created_at`) < UNIX_TIMESTAMP(DATE_ADD(NOW(), INTERVAL -50 MINUTE));";
    $sql       = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $data['VisitCount'] = $fetched_data['VisitCount'];
    }
    return $data['VisitCount'];
}
function GetUserTotalSwipes($userid){
    global $conn;
    $data      = array();
    $data['SwipeCount'] = 0;
    $query_one = "SELECT COUNT(`id`) as SwipeCount FROM `likes` WHERE `user_id` = ".$userid." AND `created_at` < NOW() AND UNIX_TIMESTAMP(`created_at`) > UNIX_TIMESTAMP(DATE_ADD(NOW(), INTERVAL -1 DAY));";
    $sql       = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $data['SwipeCount'] = $fetched_data['SwipeCount'];
    }
    return $data['SwipeCount'];
}
function GetUserTotalMatches($userid){
    global $conn;
    $data      = array();
    $query_one = "SELECT COUNT(`id`) as MatcheCount FROM `notifications` WHERE `recipient_id` = ".$userid." AND `type` = 'got_new_match' AND `created_at` < NOW() AND `created_at` > UNIX_TIMESTAMP(DATE_ADD(NOW(), INTERVAL -50 MINUTE));";
    $sql       = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $data['MatcheCount'] = $fetched_data['MatcheCount'];
    }
    return $data['MatcheCount'];
}
function GetUserPopularity($user_id,$percent = false,$color= false){
    $color_txt = '';
    $GetTotalLikes = GetTotalLikes();
    $GetTotalVisits = GetTotalVisits();
    $GetTotalMatches = GetTotalMatches();
    $siteTotal = $GetTotalLikes + $GetTotalVisits + $GetTotalMatches;

    $GetUserTotalLikes = GetUserTotalLikes($user_id);
    $GetUserTotalVisits = GetUserTotalVisits($user_id);
    $GetUserTotalMatches = GetUserTotalMatches($user_id);
    $userTotal = $GetUserTotalLikes + $GetUserTotalVisits + $GetUserTotalMatches;

    $percentage = 0;
    $percentageText = '';
    if( $siteTotal > 0 && $userTotal > 0 ) {
        $percentage = (int)(($userTotal * 100) / $siteTotal);
    }

    if( $percentage > 100 ){
        $percentage = 100;
    }

    if( $percentage >= 0 && $percentage <= 25 ){
        $percentageText = __('Very low');
        $color_txt = '';
    }else if( $percentage > 25 && $percentage <= 50 ){
        $percentageText = __('Low');
        $color_txt = '#9C27B0';
    }else if( $percentage > 50 && $percentage <= 75 ){
        $percentageText = __('High');
        $color_txt = '#2196F3';
    }else if( $percentage > 75 && $percentage <= 100 ){
        $percentageText = __('Very high');
        $color_txt = '#8BC34A';
    }
    if($color === true){
        return $color_txt;
    }
    if($percent === false) {
        return $percentageText;
    }else{
        return $percentage;
    }
}
function CreateNotification($token = '',$notifier_id,$recipient_id,$type,$text = '',$url){
    if (empty($notifier_id) || empty($recipient_id) || empty($type) || empty($url) ) return false;
    if (isEndPointRequest()) {
        $Notification = LoadEndPointResource('Notifications',true);
    }else{
        $Notification = LoadEndPointResource('Notifications');
    }
    if($Notification){
        $notification = $Notification->createNotification($token,(int)$notifier_id, (int)$recipient_id, $type, $text, $url);
        if( $notification['code'] == 200 ) {
            return true;
        }else {
            return false;
        }
    }else{
        return false;
    }
}
function getAge($date) {
    if(empty($date) || $date === '0000-00-00') return 0;
    return intval(date('Y', time() - strtotime($date))) - 1970;
}
function udetails($user){
    $return = '';
    $age = getAge($user->birthday);
    $country = '';
    if(isset(Dataset::load('countries')[$user->country])){
        $country = Dataset::load('countries')[$user->country]['name'];
    }
    if($age > 0){
        $return = $age ;
    }
    if($country !== ''){
        if($return !== ''){
            $return .= ',';
        }
        $return .= '&nbsp;'.$country;
    }
    if($return == ''){
        $return = '&nbsp;';
    }
    return $return;
}
function GetGendersKeys(){
    global $db;
    $_genders = $db->where('ref','gender')->get('langs',null,array('lang_key'));
    $_data = array();
    foreach ($_genders as $key => $value) {
        $_data[$value['lang_key']] = $value['lang_key'];
    }
    $genders = implode(",",$_data);
    return $genders;
}
function GetGenders($u){
    global $config,$db;
    $_genders = $db->where('ref','gender')->get('langs',null,array('lang_key'));
    $_data = array();
    foreach ($_genders as $key => $value) {
        $_data[$value['lang_key']] = $value['lang_key'];
    }
    if($config->opposite_gender == "1"){
        if( in_array($u->gender, $_data) ){
            unset($_data[$u->gender]);
        }
    }
    $genders = implode(",",$_data);
    return $genders;
}
function GetFindMatcheQuery($user_id, $limit, $offset, $country = true,$search = false){
    global $config,$db;
    $u = auth();

    if( $limit == 0 ){
        $limit = 20;
    }
    $where = '';

    $genders_keys = GetGendersKeys();
    $genders = $genders_keys;
    if( isset($_POST['_gender']) && !empty($_POST['_gender'])){
        $_SESSION[ '_gender' ] = $_POST['_gender'];
        $genders = Secure($_POST['_gender']);
    }
    if( $config->opposite_gender == "1"  && $search == false) {
        if( isset($_POST['_gender']) && $genders_keys == $_POST['_gender'] ) {
            $genders = GetGenders($u);
        }else{
            $genders = $_POST['_gender'];
        }
    }
    if( $genders !== null ) {
        if (strpos($genders, ',') === false) {
            $gender_query = ' AND `gender` = "' . $genders . '" ';
            $where .= $gender_query;
        } else {
            $gender_query = ' AND `gender` IN (' . $genders . ') ';
            $where .= $gender_query;
        }
    }else{
        if( $config->opposite_gender == "1"  && $search == false) {
            $genders = GetGenders($u);
            if (strpos($genders, ',') === false) {
                $gender_query = ' AND `gender` = "' . $genders . '" ';
                $where .= $gender_query;
            } else {
                $gender_query = ' AND `gender` IN (' . $genders . ') ';
                $where .= $gender_query;
            }
        }
    }

    $dist_query = '';
    $mycountry = $u->show_me_to;
    if(empty($u->show_me_to)){
        $mycountry = $u->country;
    }

    if ($mycountry == $u->country) {
        if( isset( $_REQUEST['access_token'] ) ) {

        }else{
        //var_dump('activate distance filter');
        $located = 50;
        $lat = 0;
        $lng = 0;
        if( isset( $_SESSION['_lat'] ) ) $lat = Secure($_SESSION['_lat']);
        if( isset( $_POST['_lat'] ) ) $lat = Secure($_POST['_lat']);

        if( isset( $_SESSION['_lng'] ) ) $lng = Secure($_SESSION['_lng']);
        if( isset( $_POST['_lng'] ) ) $lng = Secure($_POST['_lng']);

        if( isset( $_SESSION['_located'] ) ) $located = Secure($_SESSION['_located']);
        if( isset( $_POST['_located'] ) ) $located = Secure($_POST['_located']);
        //var_dump('distance : ' . $located);
        //var_dump('lat : ' . $lat . ', lng :' . $lng);

        $distance = ' AND ROUND( ( 6371 * acos(cos(radians(' . $lat . ')) * cos(radians(`lat`)) * cos(radians(`lng`) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) * sin(radians(`lat`)))) ,1) ';
        $dist_query = $distance . ' <= ' . $located . ' AND `country` = "' . $mycountry . '"';
        }
    } else {
        //var_dump('activate country filter');
        if( !empty($mycountry) ) {
            $dist_query = ' AND `country` = "' . $mycountry . '"';
        }
    }
        //var_dump($dist_query);


    // if( empty($u->show_me_to) ) {
    //     if (
    //         ( isset($_POST['_lat']) && !empty($_POST['_lat']) && isset($_POST['_lng']) && !empty($_POST['_lng']) )
    //         ||
    //         ( isset($_SESSION['_lat']) && !empty($_SESSION['_lat']) && isset($_SESSION['_lng']) && !empty($_SESSION['_lng']) )
    //     ) {
    //         $lat = 0;
    //         $lng = 0;
    //         $located = 7;
    //         if( isset( $_SESSION['_lat'] ) ) $lat = Secure($_SESSION['_lat']);
    //         if( isset( $_POST['_lat'] ) ) $lat = Secure($_POST['_lat']);

    //         if( isset( $_SESSION['_lng'] ) ) $lng = Secure($_SESSION['_lng']);
    //         if( isset( $_POST['_lng'] ) ) $lng = Secure($_POST['_lng']);

    //         if( isset( $_SESSION['_located'] ) ) $located = Secure($_SESSION['_located']);
    //         if( isset( $_POST['_located'] ) ) $located = Secure($_POST['_located']);

    //         $distance = 'ROUND( ( 6371 * acos(cos(radians(' . $lat . ')) * cos(radians(`lat`)) * cos(radians(`lng`) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) * sin(radians(`lat`)))) ,1) ';
    //         $dist_query = $distance . ' <= ' . $located;

    //         if(!empty($u->country)){
    //             $dist_query .= ' AND `country` = "' . $u->country . '"';
    //         }

    //         $where_and[] = $dist_query;
    //     }
    // }else{
    //     //if( $country == true ) {
    //         $ctry = (empty($u->show_me_to)) ? $u->country : $u->show_me_to;
    //         if(!empty($ctry)){
    //             $where_and[] = '`country` = "' . $u->show_me_to . '"';
    //         }
    //     //}
    // }

//    $located = null;
//    if( isset( $_SESSION['_located'] ) ) $located = Secure($_SESSION['_located']);
//    if( isset( $_POST['_located'] ) ) $located = Secure($_POST['_located']);
//    if(!empty($located) && $located > 1){
//        $lat = 0;
//        $lng = 0;
//        $located = 7;
//        if( isset( $_SESSION['_lat'] ) ) $lat = Secure($_SESSION['_lat']);
//        if( isset( $_POST['_lat'] ) ) $lat = Secure($_POST['_lat']);
//
//        if( isset( $_SESSION['_lng'] ) ) $lng = Secure($_SESSION['_lng']);
//        if( isset( $_POST['_lng'] ) ) $lng = Secure($_POST['_lng']);
//
//        if( isset( $_SESSION['_located'] ) ) $located = Secure($_SESSION['_located']);
//        if( isset( $_POST['_located'] ) ) $located = Secure($_POST['_located']);
//
//        $distance = 'ROUND( ( 6371 * acos(cos(radians(' . $lat . ')) * cos(radians(`lat`)) * cos(radians(`lng`) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) * sin(radians(`lat`)))) ,1) ';
//        $dist_query = $distance . ' <= ' . $located;
//
////        if(!empty($u->country)){
////            $dist_query .= ' AND `country` = "' . $u->country . '"';
////        }
//
//        if( isset( $_POST['_my_country'] ) ){
//            if( $u->country == $_POST['_my_country'] ){
//                $where_and[] = $dist_query . ' AND `country` = "' . Secure($_POST['_my_country']) . '"';
//            }else{
//                $where_and[] = '`country` = "' . Secure($_POST['_my_country']). '"';
//            }
//        }
//    }else{
//        //if( $country == true ) {
//        $ctry = (empty($u->show_me_to)) ? $u->country : $u->show_me_to;
//        if(!empty($ctry)){
//            $where_and[] = '`country` = "' . $u->show_me_to . '"';
//        }
//        //}
//    }

    $age_query = '';
    // check age from post or from session
    if( isset($_POST['_age_from']) && !empty($_POST['_age_from']) && isset($_POST['_age_to']) && !empty($_POST['_age_to']) ){
        $age_query = ' (DATEDIFF(CURDATE(), `birthday`)/365 >= "'. Secure($_POST['_age_from']) .'" AND DATEDIFF(CURDATE(), `birthday`)/365 <= "'. Secure($_POST['_age_to']) . '") ';
        $where_and[] = $age_query;
    }else{
        if( isset( $_REQUEST['access_token'] ) ) {

        }else{
            if(isset( $_SESSION['_age_from'] ) && isset( $_SESSION['_age_to'] )) {
                $age_query = ' (DATEDIFF(CURDATE(), `birthday`)/365 >= "'. Secure($_SESSION['_age_from']) .'" AND DATEDIFF(CURDATE(), `birthday`)/365 <= "'. Secure($_SESSION['_age_to']) . '") ';
                $where_and[] = $age_query;
            }else{
                $age_query = ' (DATEDIFF(CURDATE(), `birthday`)/365 >= "18" AND DATEDIFF(CURDATE(), `birthday`)/365 <= "55") ';
                $where_and[] = $age_query;
            }
        }
    }



    $where_and2 = array();
    //******************* Looks Filters ************************//
    if( isset($_POST['_height_from']) && !empty($_POST['_height_from']) && isset($_POST['_height_to']) && !empty($_POST['_height_to']) ){
        $where_and2[] = '`height` BETWEEN "'. Secure($_POST['_height_from']) .'" AND "'. Secure($_POST['_height_to']) .'"';
    }
    if( isset($_POST['_body']) && !empty($_POST['_body']) ){
        if( strpos( Secure( $_POST['_body'] ), ',' ) === false ) {
            $where_and2[] = '`body` = "'. Secure($_POST['_body']) . '"';
        }else{
            $where_and2[] = '`body` IN (0,'. Secure($_POST['_body']) .')';
        }
    }
    //******************* Background Filter ********************//
    if( isset($_POST['_language']) && !empty($_POST['_language']) ){
        if( strpos( Secure( $_POST['_language'] ), ',' ) === false ) {
            $where_and2[] = '`language` = "'. Secure($_POST['_language']) .'"';
        }else{
            $langss = @explode(',', Secure($_POST['_language']));
            $where_and2[] = '`language` IN ("'. @implode('","', $langss) .'")';
        }
    }
    if( isset($_POST['_ethnicity']) && !empty($_POST['_ethnicity']) ){
        if( strpos( Secure( $_POST['_ethnicity'] ), ',' ) === false ) {
            $where_and2[] = '`ethnicity` = "'. Secure($_POST['_ethnicity']) . '"';
        }else{
            $where_and2[] = '`ethnicity` IN (0,'. Secure($_POST['_ethnicity']) .')';
        }
    }
    if( isset($_POST['_religion']) && !empty($_POST['_religion']) ){
        if( strpos( Secure( $_POST['_religion'] ), ',' ) === false ) {
            $where_and2[] = '`religion` = "'. Secure($_POST['_religion']) . '"';
        }else{
            $where_and2[] = '`religion` IN (0,'. Secure($_POST['_religion']) .')';
        }
    }
    //******************* LifeStyle filter *********************//
    if( isset($_POST['_relationship']) && !empty($_POST['_relationship']) ){
        if( strpos( Secure( $_POST['_relationship'] ), ',' ) === false ) {
            $where_and2[] = '`relationship` = "'. Secure($_POST['_relationship']) .'"';
        }else{
            $where_and2[] = '`relationship` IN (0,'. Secure($_POST['_relationship']) .')';
        }
    }
    if( isset($_POST['_smoke']) && !empty($_POST['_smoke']) ){
        if( strpos( Secure( $_POST['_smoke'] ), ',' ) === false ) {
            $where_and2[] = '`smoke` = "'. Secure($_POST['_smoke']) . '"';
        }else{
            $where_and2[] = '`smoke` IN (0,'. Secure($_POST['_smoke']) .')';
        }
    }
    if( isset($_POST['_drink']) && !empty($_POST['_drink']) ){
        if( strpos( Secure( $_POST['_drink'] ), ',' ) === false ) {
            $where_and2[] = '`drink` = "'. Secure($_POST['_drink']) . '"';
        }else{
            $where_and2[] = '`drink` IN (0,'. Secure($_POST['_drink']) .')';
        }
    }
    //******************* More Filter **************************//
    if( isset($_POST['_interest']) && !empty($_POST['_interest']) ){
        $where_and2[] = '`interest` like "%'. Secure($_POST['_interest']) .'%"';
    }
    if( isset($_POST['_education']) && !empty($_POST['_education']) ){
        if( strpos( Secure( $_POST['_education'] ), ',' ) === false ) {
            $where_and2[] = '`education` = "'. Secure($_POST['_education']) . '"';
        }else{
            $where_and2[] = '`education` IN (0,'. Secure($_POST['_education']) .')';
        }
    }
    if( isset($_POST['_pets']) && !empty($_POST['_pets']) ){
        if( strpos( Secure( $_POST['_pets'] ), ',' ) === false ) {
            $where_and2[] = '`pets` = "'. Secure($_POST['_pets']) .'"';
        }else{
            $where_and2[] = '`pets` IN (0,'. Secure($_POST['_pets']) .')';
        }
    }

    $custom_sql = [];
    if(isset($_POST['custom_profile_data'])){
        $count = 100;
        for($i = 0 ; $i <= $count ; $i++ ){
            if(isset($_POST['fid_' . $i])){
                if(!empty($_POST['fid_' . $i])){
                    $custom_sql[] = ' id IN (SELECT `user_id` FROM `userfields` WHERE `fid_' . $i .'` = "'.Secure($_POST['fid_' . $i]) . '") ';
                }
            }
        }
    }

    $custom_sql_text = '';
    if(!empty($custom_sql)){
        $custom_sql_text .= ' AND ( ';
        $custom_sql_text .= implode(' OR ', $custom_sql);
        $custom_sql_text .= ' ) ';
    }

    if( isset( $_REQUEST['access_token'] ) ) {
        $uid = GetUserFromSessionID(Secure($_REQUEST['access_token']));
        $u->id = $uid;
    }

    $notin = '';
    if( isset( $u->id ) ) {
        // to exclude blocked users
        $notin = ' AND `id` NOT IN (SELECT `block_userid` FROM `blocks` WHERE `user_id` = ' . $u->id . ') ';
        // to exclude liked and disliked users users
        $notin .= ' AND `id` NOT IN (SELECT `like_userid` FROM `likes` WHERE `user_id` = ' . $u->id . ') ';
        $notin .= ' AND `id` NOT IN (SELECT `user_id` FROM `likes` WHERE `like_userid` = ' . $u->id . ') ';
        $notin .= ' AND `id` <> "' . $u->id . '" ';
        //$notin .= ' AND '.$age_query;
        //if( $dist_query !== '' ) {
        //    $notin .= ' AND ' . $dist_query;
        //}
    }

    if( !empty($where_and) ){
        $where = $where . ' AND (' . implode($where_and, ' AND ') . ')';
    }
    if( !empty($where_and2) ){
        $where = $where . ' AND (' . implode($where_and2, ' AND ') . ')';
    }
    if( route(1) == "find-matches" ){
        //$where = '';
        if( $config->opposite_gender == "1" && $search == false ) {
            $genders = GetGenders($u);
            if (strpos($genders, ',') === false) {
                $gender_query = ' AND `gender` = "' . $genders . '" ';
                $where .= $gender_query;
            } else {
                $gender_query = ' AND `gender` IN (' . $genders . ') ';
                $where .= $gender_query;
            }
        }
    }

    if( !empty($u->show_me_to) ){
        $where .= ' AND `country` = "'. $u->show_me_to . '" ';
    }

    if( isset( $_SESSION['homepage'] ) && $_SESSION['homepage'] == true ) {
        //$notin = '';
        //$where = '';
        $custom_sql_text = '';
        $dist_query = '';
    }

    $orderBy = ' ORDER BY';
    $orderBy .= '`xlikes_created_at` DESC';
    $orderBy .= ',`xvisits_created_at` DESC';
    $orderBy .= ',`xmatches_created_at` DESC';
    $orderBy .= ',`is_pro` DESC,`hot_count` DESC,`gender` DESC';
    $query = 'SELECT *, ROUND( ( 6371 * acos(cos(radians(' . $u->lat . ')) * cos(radians(`lat`)) * cos(radians(`lng`) - radians(' . $u->lng . ')) + sin(radians(' . $u->lat . ')) * sin(radians(`lat`)))) ,1) as dist FROM `users` WHERE `id` > 0 ' . $notin . $where . $custom_sql_text . $dist_query . $orderBy . ' LIMIT '.$limit.' OFFSET '.$offset.';';
    return $query;
}
function can_change_gender($gender){
    global $db;
    $can = $db->where('lang_key', $gender)->getValue('langs','options');
    if((int)$can === 1){
        return true;
    }else{
        return false;
    }
}
function _GetFindMatcheQuery($user_id, $limit, $offset, $country = true){
    global $config,$db;
    $where_or = array();
    $where_and = array();
    $u = auth();
    // main query
    $query = 'SELECT DISTINCT *, ROUND( ( 6371 * acos(cos(radians(' . $u->lat . ')) * cos(radians(`lat`)) * cos(radians(`lng`) - radians(' . $u->lng . ')) + sin(radians(' . $u->lat . ')) * sin(radians(`lat`)))) ,1) as dist FROM `users`';
    // Filters
    $where = ' WHERE ( ';

    $dist_query = '';
    // must be verified
    $where_and[] = '`active` = "1"';
    //$where_and[] = '`privacy_show_profile_match_profiles` = "1"';
    //********** public search params *****************//
    // check gender from post or from session
    $genders = null;
    $gender_query = '';

    /*

    if( $config->opposite_gender == "1" ) {
        if ($genders == null) {
            $genders = GetGenders($u);
        }
    }

    if( isset($_SESSION['_gender']) && $_SESSION['_gender'] !== ''){
        $genders = Secure( $_SESSION['_gender'] );
    }
    if( isset($_POST['_gender']) && $_POST['_gender'] !== ''){
        $_SESSION[ '_gender' ] = $_POST['_gender'];
        $genders = Secure( $_POST['_gender'] );
    }



    if( is_array($genders) ){
        $genders = @implode( ',' , $genders );
    }else{
        $genders = @explode( ',' , $genders );

        if($config->opposite_gender == "1"){
            foreach($genders as $key => $value ){
                if($value == $u->gender){
                    unset($genders[$key]);
                }
            }
        }
        $genders = @implode( ',' , $genders );
    }

    var_dump($genders);

    if( strpos( $genders, ',' ) === false ) {
        $gender_query = '`gender` = "'. $genders .'"';
        $where_and[] = $gender_query;
    }else{
        $gender_query = '`gender` IN ('. $genders .')';
        $where_and[] = $gender_query;
    }
    */
    if( $config->opposite_gender == "1" ) {
        $_SESSION['_gender'] = GetGenders($u);
    }else{
        unset($_SESSION['_gender']);
        $_SESSION['_gender'] = GetGendersKeys();
    }
    if( isset($_SESSION['_gender']) && $_SESSION['_gender'] !== ''){
        $genders = Secure( $_SESSION['_gender'] );
    }
    if( isset($_POST['_gender']) && !empty($_POST['_gender'])){
        $_SESSION[ '_gender' ] = Secure( $_POST['_gender'] );
        $genders = $_SESSION[ '_gender' ];
    }

    if( $config->opposite_gender == "1" ) {
        if ($genders == null) {
            $genders = GetGenders($u);
        }
    }

    if( strpos( $genders, ',' ) === false ) {
        $gender_query = '`gender` = "'. $genders .'"';
        $where_and[] = $gender_query;
    }else{
        $gender_query = '`gender` IN ('. $genders .')';
        $where_and[] = $gender_query;
    }

    //var_dump($gender_query);
    $age_query = '';
    // check age from post or from session
    if( isset($_POST['_age_from']) && !empty($_POST['_age_from']) && isset($_POST['_age_to']) && !empty($_POST['_age_to']) ){
        $age_query = 'DATEDIFF(CURDATE(), `birthday`)/365 >= "'. Secure($_POST['_age_from']) .'" AND DATEDIFF(CURDATE(), `birthday`)/365 <= "'. Secure($_POST['_age_to']) . '"';
        $where_and[] = $age_query;
    }else{
        if(isset( $_SESSION['_age_from'] ) && isset( $_SESSION['_age_to'] )) {
            $age_query = 'DATEDIFF(CURDATE(), `birthday`)/365 >= "'. Secure($_SESSION['_age_from']) .'" AND DATEDIFF(CURDATE(), `birthday`)/365 <= "'. Secure($_SESSION['_age_to']) . '"';
            $where_and[] = $age_query;
        }else{
            $age_query = 'DATEDIFF(CURDATE(), `birthday`)/365 >= "20" AND DATEDIFF(CURDATE(), `birthday`)/365 <= "55"';
            $where_and[] = $age_query;
        }
    }
    if( $u->show_me_to == '' ) {
        if (
            ( isset($_POST['_lat']) && !empty($_POST['_lat']) && isset($_POST['_lng']) && !empty($_POST['_lng']) )
            ||
            ( isset($_SESSION['_lat']) && !empty($_SESSION['_lat']) && isset($_SESSION['_lng']) && !empty($_SESSION['_lng']) )
        ) {
            $lat = 0;
            $lng = 0;
            $located = 7;
            if( isset( $_SESSION['_lat'] ) ) $lat = Secure($_SESSION['_lat']);
            if( isset( $_POST['_lat'] ) ) $lat = Secure($_POST['_lat']);

            if( isset( $_SESSION['_lng'] ) ) $lng = Secure($_SESSION['_lng']);
            if( isset( $_POST['_lng'] ) ) $lng = Secure($_POST['_lng']);

            if( isset( $_SESSION['_located'] ) ) $located = Secure($_SESSION['_located']);
            if( isset( $_POST['_located'] ) ) $located = Secure($_POST['_located']);

            $distance = 'ROUND( ( 6371 * acos(cos(radians(' . $lat . ')) * cos(radians(`lat`)) * cos(radians(`lng`) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) * sin(radians(`lat`)))) ,1) ';
            $dist_query = $distance . ' <= ' . $located;
            $where_and[] = $dist_query;
        }
    }else{
        if( $country == true ) {
            $where_and[] = '`country` = "' . $u->show_me_to . '"';
        }
    }

    if (
        ( isset($_POST['_lat']) && !empty($_POST['_lat']) && isset($_POST['_lng']) && !empty($_POST['_lng']) )
        ||
        ( isset($_SESSION['_lat']) && !empty($_SESSION['_lat']) && isset($_SESSION['_lng']) && !empty($_SESSION['_lng']) )
    ) {
        $lat = 0;
        $lng = 0;
        $located = 7;
        if( isset( $_SESSION['_lat'] ) ) $lat = Secure($_SESSION['_lat']);
        if( isset( $_POST['_lat'] ) ) $lat = Secure($_POST['_lat']);

        if( isset( $_SESSION['_lng'] ) ) $lng = Secure($_SESSION['_lng']);
        if( isset( $_POST['_lng'] ) ) $lng = Secure($_POST['_lng']);

        if( isset( $_SESSION['_located'] ) ) $located = Secure($_SESSION['_located']);
        if( isset( $_POST['_located'] ) ) $located = Secure($_POST['_located']);

        $distance = 'ROUND( ( 6371 * acos(cos(radians(' . $lat . ')) * cos(radians(`lat`)) * cos(radians(`lng`) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) * sin(radians(`lat`)))) ,1) ';
        $dist_query = $distance . ' <= ' . $located;
    }
    //******************* Looks Filters ************************//
    if( isset($_POST['_height_from']) && !empty($_POST['_height_from']) && isset($_POST['_height_to']) && !empty($_POST['_height_to']) ){
        $where_or[] = '`height` BETWEEN "'. Secure($_POST['_height_from']) .'" AND "'. Secure($_POST['_height_to']) .'"';
    }
    if( isset($_POST['_body']) && !empty($_POST['_body']) ){
        if( strpos( Secure( $_POST['_body'] ), ',' ) === false ) {
            $where_or[] = '`body` = "'. Secure($_POST['_body']) . '"';
        }else{
            $where_or[] = '`body` IN ('. Secure($_POST['_body']) .')';
        }
    }
    //******************* Background Filter ********************//
    if( isset($_POST['_language']) && !empty($_POST['_language']) ){
        $where_or[] = '`language` = "'. Secure($_POST['_language']) .'"';
    }
    if( isset($_POST['_ethnicity']) && !empty($_POST['_ethnicity']) ){
        if( strpos( Secure( $_POST['_ethnicity'] ), ',' ) === false ) {
            $where_or[] = '`ethnicity` = "'. Secure($_POST['_ethnicity']) . '"';
        }else{
            $where_or[] = '`ethnicity` IN ('. Secure($_POST['_ethnicity']) .')';
        }
    }
    if( isset($_POST['_religion']) && !empty($_POST['_religion']) ){
        if( strpos( Secure( $_POST['_religion'] ), ',' ) === false ) {
            $where_or[] = '`religion` = "'. Secure($_POST['_religion']) . '"';
        }else{
            $where_or[] = '`religion` IN ('. Secure($_POST['_religion']) .')';
        }
    }
    //******************* LifeStyle filter *********************//
    if( isset($_POST['_relationship']) && !empty($_POST['_relationship']) ){
        if( strpos( Secure( $_POST['_relationship'] ), ',' ) === false ) {
            $where_or[] = '`relationship` = "'. Secure($_POST['_relationship']) .'"';
        }else{
            $where_or[] = '`relationship` IN ('. Secure($_POST['_relationship']) .')';
        }
    }
    if( isset($_POST['_smoke']) && !empty($_POST['_smoke']) ){
        if( strpos( Secure( $_POST['_smoke'] ), ',' ) === false ) {
            $where_or[] = '`smoke` = "'. Secure($_POST['_smoke']) . '"';
        }else{
            $where_or[] = '`smoke` IN ('. Secure($_POST['_smoke']) .')';
        }
    }
    if( isset($_POST['_drink']) && !empty($_POST['_drink']) ){
        if( strpos( Secure( $_POST['_drink'] ), ',' ) === false ) {
            $where_or[] = '`drink` = "'. Secure($_POST['_drink']) . '"';
        }else{
            $where_or[] = '`drink` IN ('. Secure($_POST['_drink']) .')';
        }
    }
    //******************* More Filter **************************//
    if( isset($_POST['_interest']) && !empty($_POST['_interest']) ){
        $where_or[] = '`interest` like "%'. Secure($_POST['_interest']) .'%"';
    }
    if( isset($_POST['_education']) && !empty($_POST['_education']) ){
        if( strpos( Secure( $_POST['_education'] ), ',' ) === false ) {
            $where_or[] = '`education` = "'. Secure($_POST['_education']) . '"';
        }else{
            $where_or[] = '`education` IN ('. Secure($_POST['_education']) .')';
        }
    }
    if( isset($_POST['_pets']) && !empty($_POST['_pets']) ){
        if( strpos( Secure( $_POST['_pets'] ), ',' ) === false ) {
            $where_or[] = '`pets` = "'. Secure($_POST['_pets']) .'"';
        }else{
            $where_or[] = '`pets` IN ('. Secure($_POST['_pets']) .')';
        }
    }
    if( !empty($where_or) ){
        $where = $where . '('. implode($where_or, ' AND ') . ') ';
    }
    if( !empty($where_and) ){
        if( !empty($where_or) ) {
            $where = $where . ' AND (' . implode($where_and, ' AND ') . ')';
        }else{
            $where = $where . ' (' . implode($where_and, ' AND ') . ')';
        }
    }

    if( isset( $_REQUEST['access_token'] ) ) {
        $uid = GetUserFromSessionID(Secure($_REQUEST['access_token']));
        $u->id = $uid;
    }

    $notin = '';
    if( isset( $u->id ) ) {
        // to exclude blocked users
        $notin = ' AND `id` NOT IN (SELECT `block_userid` FROM `blocks` WHERE `user_id` = ' . $u->id . ') ';
        // to exclude liked and disliked users users
        $notin .= ' AND `id` NOT IN (SELECT `like_userid` FROM `likes` WHERE `user_id` = ' . $u->id . ') ';
        $notin .= ' AND `id` NOT IN (SELECT `user_id` FROM `likes` WHERE `like_userid` = ' . $u->id . ') ';
        $notin .= ' AND `id` <> "' . $u->id . '" ';
        $notin .= ' AND '.$age_query;
        if( $dist_query !== '' ) {
            $notin .= ' AND ' . $dist_query;
        }
    }

    $custom_sql = [];
    if(isset($_POST['custom_profile_data'])){
        $count = 100;
        for($i = 0 ; $i <= $count ; $i++ ){
            if(isset($_POST['fid_' . $i])){
                if(!empty($_POST['fid_' . $i])){
                    $custom_sql[] = ' id IN (SELECT `user_id` FROM `userfields` WHERE `fid_' . $i .'` = "'.Secure($_POST['fid_' . $i]) . '") ';
                }
            }
        }
    }

    $custom_sql_text = '';
    if(!empty($custom_sql)){
        $custom_sql_text .= ' AND ( ';
        $custom_sql_text .= implode(' OR ', $custom_sql);
        $custom_sql_text .= ' ) ';
    }


    if( $u->show_me_to !== '' ){
        $custom_sql_text .= ' OR (`country` = "'.$u->show_me_to.'"' . $notin . ') ';
    }

    //if( $config->opposite_gender == "1" ){
        $custom_sql_text .= ' AND (' . $gender_query . ' ' . $notin . ')';
    //}else{

    //}



    if( $limit == 0 ){
        $limit = 20;
    }

    $orderBy = ' ORDER BY ';
    $orderBy .= '`xlikes_created_at` DESC';
    $orderBy .= ',`xvisits_created_at` DESC';
    $orderBy .= ',`xmatches_created_at` DESC';
    $orderBy .= ',`is_pro` DESC,`hot_count` DESC';
    $query = $query . ' ' . $where . $notin . ') ' . $custom_sql_text . $orderBy . ' LIMIT '.$limit.' OFFSET '.$offset.';';
    return $query;
}
function allow_gender($genders, $gender){
    if(in_array($gender, $genders)) {
        return true;
    }else{
        return false;
    }
}
function GetAnnouncement($id) {
    global $conn;
    if (IS_LOGGED == false) {
        return false;
    }
    $data    = array();
    if (empty($id) || !is_numeric($id) || $id < 1) {
        return false;
    }
    $query = mysqli_query($conn, "SELECT * FROM `announcement` WHERE `id` = {$id} ORDER BY `id` DESC");
    if (mysqli_num_rows($query) == 1) {
        $fetched_data         = mysqli_fetch_assoc($query);
        return $fetched_data;
    }
}
function GetHomeAnnouncements() {
    global $conn;
    if (IS_LOGGED == false) {
        return false;
    }
    $user_id      = Secure(auth()->id);
    $query        = mysqli_query($conn, "SELECT `id` FROM `announcement` WHERE `active` = '1' AND `id` NOT IN (SELECT `announcement_id` FROM `announcement_views` WHERE `user_id` = {$user_id}) ORDER BY RAND() LIMIT 1");
    $fetched_data = mysqli_fetch_assoc($query);
    $data         = GetAnnouncement($fetched_data['id']);
    return $data;
}
function IsThereAnnouncement() {
    global $conn;
    if (IS_LOGGED == false) {
        return false;
    }
    $user_id = Secure(auth()->id);
    $query   = mysqli_query($conn, "SELECT COUNT(`id`) as count FROM `announcement` WHERE `active` = '1' AND `id` NOT IN (SELECT `announcement_id` FROM `announcement_views` WHERE `user_id` = {$user_id})");
    $sql     = mysqli_fetch_assoc($query);
    return ($sql['count'] > 0) ? true : false;
}
function IsActiveAnnouncement($id) {
    global $conn;
    $id    = Secure($id);
    $query = mysqli_query($conn, "SELECT COUNT(`id`) FROM `announcement` WHERE `id` = '{$id}' AND `active` = '1'");
    return (Sql_Result($query, 0) == 1) ? true : false;
}
function IsViewedAnnouncement($id) {
    global $conn, $wo;
    if (IS_LOGGED == false) {
        return false;
    }
    $id      = Secure($id);
    $user_id = Secure(auth()->id);
    $query   = mysqli_query($conn, "SELECT COUNT(`id`) FROM `announcement_views` WHERE `announcement_id` = '{$id}' AND `user_id` = '{$user_id}'");
    return (Sql_Result($query, 0) > 0) ? true : false;
}
function Sql_Result($res, $row = 0, $col = 0) {
    $numrows = mysqli_num_rows($res);
    if ($numrows && $row <= ($numrows - 1) && $row >= 0) {
        mysqli_data_seek($res, $row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])) {
            return $resrow[$col];
        }
    }
    return false;
}
function GetNotificationIdFromChatRequest($route){
    global $db;
    $notification = $db->where('type','message')->where('url',$route)->orderBy('created_at','DESC')->get('notifications',1,array('*'));
    if(isset($notification[0]) && !empty($notification[0])) {
        return $notification[0];
    }else{
        return false;
    }
}
function CreateNewAudioCall($re_data,$api = false) {
    global  $conn;
    if( $api == false ) {
        if (IS_LOGGED == false) {
            return false;
        }
    }
    if (empty($re_data)) {
        return false;
    }
    $user_data  = userData($re_data['from_id']);
    $user_data2 = userData($re_data['to_id']);
    if (empty($user_data) || empty($user_data2)) {
        return false;
    }
    $logged_user_id    = Secure(auth()->id);
    $query1            = mysqli_query($conn, "DELETE FROM `audiocalls` WHERE `from_id` = {$logged_user_id} OR `to_id` = {$logged_user_id}");
    $re_data['active'] = 0;
    $re_data['called'] = $re_data['from_id'];
    $re_data['time']   = Secure(time());
    $fields            = '`' . implode('`, `', array_keys($re_data)) . '`';
    $data              = '\'' . implode('\', \'', $re_data) . '\'';
    $query             = mysqli_query($conn, "INSERT INTO `audiocalls` ({$fields}) VALUES ({$data})");
    if ($query) {
        return mysqli_insert_id($conn);
    } else {
        return false;
    }
}
function CreateNewVideoCall($re_data,$api = false) {
    global $conn;
    if( $api == false ) {
        if (IS_LOGGED == false) {
            return false;
        }
    }
    if (empty($re_data)) {
        return false;
    }
    $user_data  = userData($re_data['from_id']);
    $user_data2 = userData($re_data['to_id']);
    if (empty($user_data) || empty($user_data2)) {
        return false;
    }
    $logged_user_id    = Secure(auth()->id);
    $query1            = mysqli_query($conn, "DELETE FROM `videocalles` WHERE `from_id` = {$logged_user_id} OR `to_id` = {$logged_user_id}");
    $re_data['active'] = 0;
    $re_data['called'] = $re_data['from_id'];
    $re_data['time']   = Secure(time());
    $fields            = '`' . implode('`, `', array_keys($re_data)) . '`';
    $data              = '\'' . implode('\', \'', $re_data) . '\'';
    $query             = mysqli_query($conn, "INSERT INTO `videocalles` ({$fields}) VALUES ({$data})");
    if ($query) {
        return mysqli_insert_id($conn);
    } else {
        return false;
    }
}
function CheckCallAnswer($id = 0,$api = false) {
    global $conn,$config;
    if( $api == false ) {
        if (IS_LOGGED == false) {
            return false;
        }
    }
    if (empty($id)) {
        return false;
    }
    $data1 = array();
    $id    = Secure($id);
    $query = mysqli_query($conn, "SELECT * FROM `videocalles`  WHERE `id` = '{$id}' AND `active` = '1' AND `declined` = '0'");
    if (mysqli_num_rows($query) > 0) {
        $sql          = mysqli_fetch_assoc($query);
        $sql['url'] = $config->uri . '/video-call/' . $id;
        $sql['id'] =  $id;
        return $sql;
    } else {
        return false;
    }
}
function CheckCallAnswerDeclined($id = 0,$api = false) {
    global $conn,$config;
    if( $api == false ) {
        if (IS_LOGGED == false) {
            return false;
        }
    }
    if (empty($id)) {
        return false;
    }
    $id    = Secure($id);
    $query = mysqli_query($conn, "SELECT COUNT(`id`) FROM `videocalles` WHERE `id` = '{$id}' AND `declined` = '1'");
    return (Sql_Result($query, 0) == 1) ? true : false;
}
function CheckFroInCalls($type = 'video'){
    global $conn, $config;
    if (IS_LOGGED == false) {
        return false;
    }
    $user_id = Secure(auth()->id);
    $data1 = array();
    $time = time() - 40;
    $table = '`videocalles`';
    if ($type == 'audio') {
        $table = '`audiocalls`';
    }
    $query = mysqli_query($conn, "SELECT * FROM {$table}  WHERE `to_id` = '{$user_id}' AND `time` > '$time' AND `active` = '0' AND `declined` = 0");
    if (mysqli_num_rows($query) > 0) {
        $sql = mysqli_fetch_assoc($query);
        if (isUserBlocked($sql['from_id'])) {
            return false;
        }
        $sql['url'] = $config->uri . '/video-call/' . $sql['id'];
        $sql['id'] =  $sql['id'];
        return $sql;
    } else {
        return false;
    }
}
function GetAllDataFromCallID($id = 0) {
    global $conn,$config;
    $user_id = auth()->id;
    if (IS_LOGGED == false) {
        return false;
    }
    if (empty($id)) {
        return false;
    }
    $data1 = array();
    $id    = Secure($id);
    $query = mysqli_query($conn, "SELECT * FROM `videocalles` WHERE `id` = '{$id}'");
    if (mysqli_num_rows($query) > 0) {
        $sql        = mysqli_fetch_assoc($query);
        $sql['url'] = $config->uri . '/video-call/' . $sql['id'];
        return $sql;
    } else {
        return false;
    }
}
function CheckAudioCallAnswer($id = 0,$api = false) {
    global $conn,$config;
    if( $api == false ) {
        if (IS_LOGGED == false) {
            return false;
        }
    }
    if (empty($id)) {
        return false;
    }
    $data1 = array();
    $id    = Secure($id);
    $query = mysqli_query($conn, "SELECT * FROM `audiocalls`  WHERE `id` = '{$id}' AND `active` = '1' AND `declined` = '0'");
    if (mysqli_num_rows($query) > 0) {
        if( $api == false ) {
            return true;
        }else{
            $sql = mysqli_fetch_assoc($query);
            $sql['url'] = $config->uri . '/audio-call/' . $sql['id'];
            $sql['id'] =  $sql['id'];
            return $sql;
        }
    } else {
        return false;
    }
}
function CheckAudioCallAnswerDeclined($id = 0,$api = false) {
    global $conn;
    if( $api == false ) {
        if (IS_LOGGED == false) {
            return false;
        }
    }
    if (empty($id)) {
        return false;
    }
    $id    = Secure($id);
    $query = mysqli_query($conn, "SELECT COUNT(`id`) FROM `audiocalls` WHERE `id` = '{$id}' AND `declined` = '1'");
    return (Sql_Result($query, 0) == 1) ? true : false;
}
function IsConversationDeclined($notifier_id = 0, $recipient_id = 0){
    global $conn;
    if (IS_LOGGED == false) {
        return false;
    }
    if (empty($notifier_id)) {
        return false;
    }
    if (empty($recipient_id)) {
        return false;
    }
    $notifier_id    = Secure($notifier_id);
    $recipient_id   = Secure($recipient_id);
    $query = mysqli_query($conn, "SELECT `status`,`created_at` FROM `conversations` WHERE ( (`sender_id` = {$notifier_id} AND `receiver_id` = {$recipient_id}) OR (`sender_id` = {$recipient_id} AND `receiver_id` = {$notifier_id}) ) AND `status` = 2");
    if (mysqli_num_rows($query) > 0) {
        $arr = ['status' => (int)Sql_Result($query, 0), 'created_at' => Sql_Result($query, 1)];
        return $arr;
    }else{
        return false;
    }
}
function CheckIfConversionAccepted($notifier_id = 0, $recipient_id = 0){
    global $conn,$config;
    if($config->message_request_system == 'off'){
        return true;
    }
    if (IS_LOGGED == false) {
        return false;
    }
    if (empty($notifier_id)) {
        return false;
    }
    if (empty($recipient_id)) {
        return false;
    }
    $notifier_id    = Secure($notifier_id);
    $recipient_id   = Secure($recipient_id);



//    $query = mysqli_query($conn, "SELECT `id` FROM `notifications` WHERE `type` = 'message' AND `notifier_id` = {$notifier_id} AND `recipient_id` = {$recipient_id}");
//    if (mysqli_num_rows($query) > 0) {
//        return true;
//    } else {
//        return false;
//    }



    if($notifier_id !== auth()->id){
        $query = mysqli_query($conn, "SELECT `status`,`created_at` FROM `conversations` WHERE `sender_id` = {$notifier_id} AND `receiver_id` = {$recipient_id}");
    }else{
        $query = mysqli_query($conn, "SELECT `status`,`created_at` FROM `conversations` WHERE `sender_id` = {$recipient_id} AND `receiver_id` = {$notifier_id}");

    }

    if (mysqli_num_rows($query) > 0) {
        $arr = ['status' => (int)Sql_Result($query, 0), 'created_at' => Sql_Result($query, 1)];
        return $arr;
//        if((int)Sql_Result($query, 0) == 1){
//            //return true;
//            $arr = ['status' => (int)Sql_Result($query, 0), 'created_at' => Sql_Result($query, 1)];
//            return $arr;
//        }else if((int)Sql_Result($query, 0) == 2){
//            //return true;
//            $arr = ['status' => (int)Sql_Result($query, 0), 'created_at' => Sql_Result($query, 1)];
//            return $arr;
//        }else{
//            $arr = ['status' => (int)Sql_Result($query, 0), 'created_at' => Sql_Result($query, 1)];
//            return $arr;
//            //return false;
//        }
    } else {
        return false;
    }

}
function CheckIfUserDeclinedBefore($userid =0, $toid = 0){
    global $conn;
    if (IS_LOGGED == false) {
        return [];
    }
    if (empty($userid)) {
        return [];
    }
    if (empty($toid)) {
        return 0;
    }
    $userid    = Secure($userid);
    $toid      = Secure($toid);
    $query = mysqli_query($conn, "SELECT `status`,`created_at` FROM `conversations` WHERE `sender_id` = {$userid} AND `receiver_id` = {$toid}");
    if (mysqli_num_rows($query) > 0) {
        $row = $query->fetch_object();
        @mysqli_free_result($query);
        if(isset($row)){
            return $row;
        }else{
            return [];
        }
    } else {
        return [];
    }
}
function GetChatRequestCount($user_id,$api=false){
    global $conn;
    if( $api === false ){
        if (IS_LOGGED == false) {
            return 0;
        }
    }
    if (empty($user_id)) {
        return 0;
    }
    $userid    = Secure($user_id);
    $query = mysqli_query($conn, "SELECT count('id') FROM `conversations` WHERE `status` = 0 AND `receiver_id` = {$userid}");
    if (mysqli_num_rows($query) > 0) {
        if((int)Sql_Result($query, 0) > 0){
            return (int)Sql_Result($query, 0);
        }else{
            return 0;
        }
    } else {
        return 0;
    }
}
function GetChatRequestList($user_id,$api=false){
    global $conn;
    if( $api === false ){
        if (IS_LOGGED == false) {
            return 0;
        }
    }
    if (empty($user_id)) {
        return 0;
    }
    $data = array();
    $userid    = Secure($user_id);
    $query = mysqli_query($conn, "SELECT * FROM `conversations` WHERE `status` = 0 AND `receiver_id` = {$userid}");
    while ($fetched_data = mysqli_fetch_assoc($query)) {
        $fetched_data['senderData'] = userData($fetched_data->sender_id);
        $data[] = $fetched_data;
    }
    return $data;
}
function IsUserSpammer($user_id){
    global $conn,$db;
    if (IS_LOGGED == false) {
        return 0;
    }
    if (empty($user_id)) {
        return 0;
    }
    $userid    = Secure($user_id);
    $query = mysqli_query($conn, "SELECT count('id') FROM `conversations` WHERE `created_at` >= DATE_SUB(CURDATE(), INTERVAL 6 MINUTE) AND `sender_id` = {$userid}");
    if (mysqli_num_rows($query) > 0) {
        if((int)Sql_Result($query, 0) > 5){
            return true;
        }else{
            return false;
        }
    } else {
        return false;
    }
}
function LangsNamesFromDB($lang = 'english') {
    global $conn, $wo;
    $data  = array();
    $query = mysqli_query($conn, "SHOW COLUMNS FROM `langs`");
    while ($fetched_data = mysqli_fetch_assoc($query)) {
        $data[$fetched_data['Field']] = __($fetched_data['Field']);
    }
    unset($data['id']);
    unset($data['ref']);
    unset($data['lang_key']);
    unset($data['options']);
    return $data;
}
function DeleteChatFiles($from,$to){
    global $db,$_UPLOAD;
    if (IS_LOGGED == false) {
        return 0;
    }
    if (empty($from)) {
        return false;
    }
    if (empty($to)) {
        return false;
    }
    $deleted = false;
    $deleted_message = $db->where('from_delete', '1')
        ->where('to_delete', '1')
        ->where('( `to` = ' . $to . ' AND `from` = ' . $from . ' ) OR ( `to` = ' . $from . ' AND `from` = ' . $to . ' )')
        ->get('messages',null,array('*'));
    if(!empty($deleted_message)){
        foreach ($deleted_message as $key => $value){
            $file = $value['media'];
            if( file_exists($file) ) {
                if( @is_writable($file) ) {
                    if( @unlink($file) ) {
                        $deleted = true;
                    }else{
                        $deleted = false;
                    }
                }
            }
        }
        return $deleted;
    }else{
        return false;
    }
}
function GetCustomPages() {
    global $conn;
    $data          = array();
    $query_one     = "SELECT * FROM `custom_pages` ORDER BY `id` DESC";
    $sql_query_one = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql_query_one)) {
        $data[] = GetCustomPage($fetched_data['page_name']);
    }
    return $data;
}
function GetCustomPage($page_name) {
    global $conn;
    if (empty($page_name)) {
        return false;
    }
    $data          = array();
    $page_name     = Secure($page_name);
    $query_one     = "SELECT * FROM `custom_pages` WHERE `page_name` = '{$page_name}'";
    $sql_query_one = mysqli_query($conn, $query_one);
    $fetched_data  = mysqli_fetch_assoc($sql_query_one);
    return $fetched_data;
}
function RegisterNewField($registration_data) {
    global $conn,$db;
    if (empty($registration_data)) {
        return false;
    }
    $fields = '`' . implode('`, `', array_keys($registration_data)) . '`';
    $data   = '\'' . implode('\', \'', $registration_data) . '\'';
    $query  = mysqli_query($conn, "INSERT INTO `profilefields` ({$fields}) VALUES ({$data})");
    if ($query) {

        $sql_id  = mysqli_insert_id($conn);
        $column  = 'fid_' . $sql_id;
        $length  = $registration_data['length'];
        $query_2 = mysqli_query($conn, "ALTER TABLE `userfields` ADD COLUMN `{$column}` varchar({$length}) NOT NULL DEFAULT ''");
        $insert = $db->insert('langs', ['lang_key' => $registration_data["name"], GetActiveLang() => secure($registration_data["description"])]);

        return true;
    }
    return false;
}
function GetProfileFields($type = 'all') {
    global $conn;
    $data       = array();
    $where      = '';
    $placements = array(
        'profile',
        'general',
        'social'
    );
    if ($type != 'all' && in_array($type, $placements)) {
        $where = "WHERE `placement` = '{$type}' AND `placement` <> 'none' AND `active` = '1'";
    } else if ($type == 'none') {
        $where = "WHERE `profile_page` = '1' AND `active` = '1'";
    } else if ($type != 'admin') {
        $where = "WHERE `active` = '1'";
    }
    $type      = Secure($type);
    $query_one = "SELECT * FROM `profilefields` {$where} ORDER BY `id` ASC";
    $sql       = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $fetched_data['fid'] = 'fid_' . $fetched_data['id'];
        $fetched_data['name'] = preg_replace_callback("/{{LANG (.*?)}}/", function($m) {
            return __($m[1]);
        }, $fetched_data['name']);
        $fetched_data['description'] = preg_replace_callback("/{{LANG (.*?)}}/", function($m) {
            return __($m[1]);
        }, $fetched_data['description']);
        $fetched_data['type'] = preg_replace_callback("/{{LANG (.*?)}}/", function($m) {
            return __($m[1]);
        }, $fetched_data['type']);
        $data[]               = $fetched_data;
    }
    return $data;
}
function GetUserCustomFields() {
    global $conn;
    $data       = array();
    $where = "WHERE `active` = '1' AND `profile_page` = 1";

    $query_one = "SELECT * FROM `profilefields` {$where} ORDER BY `id` ASC";
    $sql       = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $fetched_data['fid'] = 'fid_' . $fetched_data['id'];
        $fetched_data['name'] = preg_replace_callback("/{{LANG (.*?)}}/", function($m) {
            return __($m[1]);
        }, $fetched_data['name']);
        $fetched_data['description'] = preg_replace_callback("/{{LANG (.*?)}}/", function($m) {
            return __($m[1]);
        }, $fetched_data['description']);
        $fetched_data['type'] = preg_replace_callback("/{{LANG (.*?)}}/", function($m) {
            return __($m[1]);
        }, $fetched_data['type']);
        $data[]               = $fetched_data;
    }
    return $data;
}
function UserFieldsData($user_id) {
    global $conn;
    if (empty($user_id) || !is_numeric($user_id) || $user_id < 0) {
        return false;
    }
    $data         = array();
    $user_id      = Secure($user_id);
    $query_one    = "SELECT * FROM `userfields` WHERE `user_id` = {$user_id}";
    $sql          = mysqli_query($conn, $query_one);
    $fetched_data = mysqli_fetch_assoc($sql);
    if (empty($fetched_data)) {
        return array();
    }
    return $fetched_data;
}
function UpdateUserCustomData($user_id, $update_data, $loggedin = true) {
    global $conn;
    if ($loggedin == true) {
        if (IS_LOGGED == false) {
            return false;
        }
    }
    if (empty($user_id) || !is_numeric($user_id) || $user_id < 0) {
        return false;
    }
    if (empty($update_data)) {
        return false;
    }
    $user_id = Secure($user_id);
    $u = auth();
    if ($loggedin == true) {
        if ($u->admin === "0") {
            if ($u->id != $user_id) {
                return false;
            }
        }
    }
    $update = array();
    foreach ($update_data as $field => $data) {
        foreach ($data as $key => $value) {
            $update[] = '`' . $key . '` = \'' . Secure($value, 0) . '\'';
        }
    }
    $impload     = implode(', ', $update);
    $query_one   = "UPDATE `userfields` SET {$impload} WHERE `user_id` = {$user_id}";
    $query_1     = mysqli_query($conn, "SELECT COUNT(`id`) as count FROM `userfields` WHERE `user_id` = {$user_id}");
    $query_1_sql = mysqli_fetch_assoc($query_1);
    $query       = false;
    if ($query_1_sql['count'] == 1) {
        $query = mysqli_query($conn, $query_one);
    } else {
        $query_2 = mysqli_query($conn, "INSERT INTO `userfields` (`user_id`) VALUES ({$user_id})");
        if ($query_2) {
            $query = mysqli_query($conn, $query_one);
        }
    }
    if ($query) {
        return true;
    }
    return false;
}
function GetFieldData($id = 0) {
    global $conn;
    if (empty($id) || !is_numeric($id) || $id < 0) {
        return false;
    }
    $data         = array();
    $id           = Secure($id);
    $query_one    = "SELECT * FROM `profilefields` WHERE `id` = {$id}";
    $sql          = mysqli_query($conn, $query_one);
    $fetched_data = mysqli_fetch_assoc($sql);
    if (empty($fetched_data)) {
        return array();
    }
    return $fetched_data;
}
function UpdateField($id, $update_data) {
    global $conn;
    if (IS_LOGGED == false) {
        return false;
    }
    if (empty($id) || !is_numeric($id) || $id < 0) {
        return false;
    }
    if (empty($update_data)) {
        return false;
    }
    $id = Secure($id);
//    $u = auth();
//    if ($u->admin === "0") {
//        return false;
//    }
    $update = array();
    foreach ($update_data as $field => $data) {
        $update[] = '`' . $field . '` = \'' . Secure($data, 0) . '\'';
        if ($field == 'length') {
            $mysqli = mysqli_query($conn, "ALTER TABLE `userfields` CHANGE `fid_{$id}` `fid_{$id}` VARCHAR(" . Secure($data) . ") CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '';");
        }
    }
    $impload   = implode(', ', $update);
    $query_one = "UPDATE `profilefields` SET {$impload} WHERE `id` = {$id} ";
    $query     = mysqli_query($conn, $query_one);
    if ($query) {
        return true;
    }
    return false;
}
function DeleteField($id) {
    global $conn;
    if (IS_LOGGED == false) {
        return false;
    }
//    $u = auth();
//    if ($u->admin === "0") {
//        return false;
//    }
    $id    = Secure($id); 
    $query = mysqli_query($conn, "DELETE FROM `profilefields` WHERE `id` = {$id}");
    if ($query) {
        $query2 = mysqli_query($conn, "ALTER TABLE `userfields` DROP `fid_{$id}`;");
        if ($query2) {
            return true;
        }
    }
    return false;
}
function br2nl($st) {
    $breaks   = array(
        "\r\n",
        "\r",
        "\n"
    );
    $st       = str_replace($breaks, "", $st);
    $st_no_lb = preg_replace("/\r|\n/", "", $st);
    return preg_replace('/<br(\s+)?\/?>/i', "\r", $st_no_lb);
}
function isGenderFree($gender_code){
    global $conn,$config;
    if($config->free_features === "1"){
        return true;
    }
    if (empty($gender_code) || !is_numeric($gender_code) || $gender_code < 0) {
        return false;
    }
    $id    = Secure($gender_code);
    $query = mysqli_query($conn, "SELECT `options` FROM `langs` WHERE `lang_key` = '{$id}' AND `ref` = 'gender'");
    return (Sql_Result($query, 0) == '1') ? true : false;
}
function TwoFactor($username = '') {
    global $config, $db;

    if (empty($username)) {
        return true;
    }
    if ($config->two_factor == 0) {
        return true;
    }
    $getuser = userData($username);
    if ($getuser->two_factor == 0 || $getuser->two_factor_verified == 0) {
        return true;
    }
    $code = rand(111111, 999999);
    $hash_code = md5($code);
    $update_code =  $db->where('id', $username)->update('users', array('email_code' => $hash_code));
    $message = "Your confirmation code is: $code";
    if (!empty($getuser->phone_number) && ($config->two_factor_type == 'both' || $config->two_factor_type == 'phone')) {
        $send_message = SendSMS($getuser->phone_number, $message);
    }
    if ($config->two_factor_type == 'both' || $config->two_factor_type == 'email') {
        $send = SendEmail($getuser->email,'Please verify that it\'s you',$message,false);
    }
    return false;
}
function UserIdFromUsername($username) {
    global $conn;
    if (empty($username)) {
        return false;
    }
    $username = Secure($username);
    $query    = mysqli_query($conn, "SELECT `id` FROM `users` WHERE `username` = '{$username}'");
    return Wo_Sql_Result($query, 0, 'id');
}
function get_ip_address() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (validate_ip($ip))
                    return $ip;
            }
        } else {
            if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];
    return $_SERVER['REMOTE_ADDR'];
}
function validate_ip($ip) {
    if (strtolower($ip) === 'unknown')
        return false;
    $ip = ip2long($ip);
    if ($ip !== false && $ip !== -1) {
        $ip = sprintf('%u', $ip);
        if ($ip >= 0 && $ip <= 50331647)
            return false;
        if ($ip >= 167772160 && $ip <= 184549375)
            return false;
        if ($ip >= 2130706432 && $ip <= 2147483647)
            return false;
        if ($ip >= 2851995648 && $ip <= 2852061183)
            return false;
        if ($ip >= 2886729728 && $ip <= 2887778303)
            return false;
        if ($ip >= 3221225984 && $ip <= 3221226239)
            return false;
        if ($ip >= 3232235520 && $ip <= 3232301055)
            return false;
        if ($ip >= 4294967040)
            return false;
    }
    return true;
}
function ip_in_range($ip, $range) {
    if (strpos($range, '/') == false) {
        $range .= '/32';
    }
    // $range is in IP/CIDR format eg 127.0.0.1/24
    list($range, $netmask) = explode('/', $range, 2);
    $range_decimal    = ip2long($range);
    $ip_decimal       = ip2long($ip);
    $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
    $netmask_decimal  = ~$wildcard_decimal;
    return (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal));
}
function Wo_Sql_Result($res, $row = 0, $col = 0) {
    $numrows = mysqli_num_rows($res);
    if ($numrows && $row <= ($numrows - 1) && $row >= 0) {
        mysqli_data_seek($res, $row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])) {
            return $resrow[$col];
        }
    }
    return false;
}
function Wo_UserData($user_id){
    global $wo, $conn, $cache;
    if (empty($user_id) || !is_numeric($user_id) || $user_id < 0) {
        return false;
    }
    $data           = array();
    $user_id        = Secure($user_id);
    $query_one      = "SELECT * FROM `users` WHERE `id` = {$user_id}";
    $sql          = mysqli_query($conn, $query_one);
    $fetched_data = mysqli_fetch_assoc($sql);
    if (empty($fetched_data)) {
        return array();
    }
    return $fetched_data;
}
function Wo_RequestNewPayment($user_id = 0, $amount = 0) {
    global $conn;
    if (empty($user_id)) {
        return false;
    }
    if (empty($amount)) {
        return false;
    }
    $user_id = Secure($user_id);
    $amount  = Secure($amount);
    if (Wo_IsUserPaymentRequested($user_id) === true) {
        return false;
    }
    $user_data   = Wo_UserData($user_id);
    $full_amount = Secure($user_data['aff_balance']);
    $time        = time();
    $query_text  = "INSERT INTO `affiliates_requests` (`user_id`, `amount`, `full_amount`, `time`) VALUES ('$user_id', '$amount', '$full_amount', '$time')";
    $query       = mysqli_query($conn, $query_text);
    if ($query) {
        return true;
    }
    return false;
}
function Wo_IsUserPaymentRequested($user_id = 0) {
    global $conn;
    if (empty($user_id)) {
        return false;
    }
    $user_id = Secure($user_id);
    $query   = mysqli_query($conn, "SELECT COUNT(`id`) FROM `affiliates_requests` WHERE `user_id` = '{$user_id}' AND status = '0'");
    return (Wo_Sql_Result($query, 0) == 1) ? true : false;
}
function Wo_GetPaymentsHistory($user_id = 0) {
    global $conn;
    if (empty($user_id)) {
        return false;
    }
    $user_id       = Secure($user_id);
    $data          = array();
    $query_one     = "SELECT `id` FROM `affiliates_requests` WHERE `user_id` = '{$user_id}' ORDER BY `id` DESC";
    $sql_query_one = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql_query_one)) {
        $data[] = Wo_GetPaymentHistory($fetched_data['id']);
    }
    return $data;
}
function Wo_GetAllPaymentsHistory($type = 0) {
    global $conn;
    $type  = Secure($type);
    $data  = array();
    $where = "";
    if ($type != 'all') {
        $where = "WHERE `status` = '{$type}'";
    }
    $query_one     = "SELECT * FROM `affiliates_requests` {$where} ORDER BY `id` DESC";
    $sql_query_one = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql_query_one)) {
        $data[] = Wo_GetPaymentHistory($fetched_data['id']);
    }
    return $data;
}
function Wo_UserActive($username) {
    global $conn;
    if (empty($username)) {
        return false;
    }
    $username = Secure($username);
    $query    = mysqli_query($conn, "SELECT COUNT(`user_id`) FROM `users`  WHERE (`username` = '{$username}' OR `email` = '{$username}' OR `phone_number` = '{$username}') AND `active` = '1'");
    return (Wo_Sql_Result($query, 0) == 1) ? true : false;
}
function Wo_CountPaymentHistory($id) {
    global $conn;
    $data          = array();
    $id            = Secure($id);
    $query_one     = "SELECT COUNT(`id`) as count FROM `affiliates_requests` WHERE `status` = '{$id}'";
    $sql_query_one = mysqli_query($conn, $query_one);
    $fetched_data  = mysqli_fetch_assoc($sql_query_one);
    return $fetched_data['count'];
}
function Wo_GetPaymentHistory($id) {
    global $conn, $wo;
    if (empty($id)) {
        return false;
    }
    $data                         = array();
    $id                           = Secure($id);
    $query_one                    = "SELECT * FROM `affiliates_requests` WHERE `id` = '{$id}'";
    $sql_query_one                = mysqli_query($conn, $query_one);
    $fetched_data                 = mysqli_fetch_assoc($sql_query_one);
    $fetched_data['user']         = userData($fetched_data['user_id']);
    $fetched_data['total_refs']   = Wo_CountRefs($fetched_data['user_id']);
    $fetched_data['time_text']    = Time_Elapsed_String($fetched_data['time']);
    //$fetched_data['callback_url'] = $wo['config']['site_url'] . '/' . 'requests.php?f=admincp&paid_user_id=' . $fetched_data['id'] . '&paid_ref_id=' . $fetched_data['id'];
    return $fetched_data;
}
function Wo_CountRefs($user_id = 0) {
    global $conn;
    $data          = array();
    $user_id       = Secure($user_id);
    $query_one     = "SELECT COUNT(`id`) as count FROM `users` WHERE `referrer` = '{$user_id}'";
    $sql_query_one = mysqli_query($conn, $query_one);
    $fetched_data  = mysqli_fetch_assoc($sql_query_one);
    return $fetched_data['count'];
}
function Wo_GetReferrers($user_id = 0) {
    global $conn, $wo;
    if (IS_LOGGED == false) {
        return false;
    }
    if (empty($user_id)) {
        $u = auth();
        $user_id = Secure($u->id);
    } else {
        $user_id = Secure($user_id);
    }
    $data          = array();
    $query_one     = "SELECT * FROM `users` WHERE `referrer` = '{$user_id}' ORDER BY `id` DESC";
    $sql_query_one = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql_query_one)) {
        $data[] = Wo_UserData($fetched_data['id']);
    }
    return $data;
}
function Wo_UpdateBalance($user_id = 0, $balance = 0, $type = '+') {
    global $wo, $conn;
    if (empty($user_id) || !is_numeric($user_id) || $user_id < 0) {
        return false;
    }
    if (empty($balance)) {
        return false;
    }
    $user_id   = Secure($user_id);
    $balance   = Secure($balance);
    $user_data = Wo_UserData($user_id);
    if ($type == '+') {
        $balance = ((int)$user_data['aff_balance'] + $balance);
    } else {
        $balance = ((int)$user_data['aff_balance'] - $balance);
    }
    $query_one = "UPDATE `users` SET `aff_balance` = '{$balance}' WHERE `id` = {$user_id} ";
    $query     = mysqli_query($conn, $query_one);
    if ($query) {
        return true;
    }
    return false;
}
function Wo_GetBanned($type = '') {
    global $conn;
    $data  = array();
    $query = mysqli_query($conn, "SELECT * FROM `banned_ip` ORDER BY id DESC");
    if ($type == 'user') {
        while ($fetched_data = mysqli_fetch_assoc($query)) {
            $data[] = $fetched_data['ip_address'];
        }
    } else {
        while ($fetched_data = mysqli_fetch_assoc($query)) {
            $data[] = $fetched_data;
        }
    }
    return $data;
}
function Wo_IsBanned($value = '') {
    global $conn;
    $value           = Secure($value);
    $query_one    = mysqli_query($conn, "SELECT COUNT(`id`) as count FROM `banned_ip` WHERE `ip_address` = '{$value}'");
    $fetched_data = mysqli_fetch_assoc($query_one);
    if ($fetched_data['count'] > 0) {
        return true;
    }
    return false;
}
function Wo_BanNewIp($ip) {
    global $conn;
    $ip           = Secure($ip);
    $query_one    = mysqli_query($conn, "SELECT COUNT(`id`) as count FROM `banned_ip` WHERE `ip_address` = '{$ip}'");
    $fetched_data = mysqli_fetch_assoc($query_one);
    if ($fetched_data['count'] > 0) {
        return false;
    }
    $time      = time();
    $query_two = mysqli_query($conn, "INSERT INTO `banned_ip` (`ip_address`,`time`) VALUES ('{$ip}','{$time}')");
    if ($query_two) {
        return true;
    }
}
function Wo_IsIpBanned($id) {
    global $conn;
    $id           = Secure($id);
    $query_one    = mysqli_query($conn, "SELECT COUNT(`id`) as count FROM `banned_ip` WHERE `id` = '{$id}'");
    $fetched_data = mysqli_fetch_assoc($query_one);
    if ($fetched_data['count'] > 0) {
        return true;
    } else {
        return false;
    }
}
function Wo_DeleteBanned($id) {
    global $conn;
    $id = Secure($id);
    if (Wo_IsIpBanned($id) === false) {
        return false;
    }
    $query_two = mysqli_query($conn, "DELETE FROM `banned_ip` WHERE `id` = {$id}");
    if ($query_two) {
        return true;
    }
}
function Wo_IsBlocked($user_id) {
    global $wo, $conn;
//    if (IS_LOGGED == false) {
//        return false;
//    }
    if (empty($user_id) || !is_numeric($user_id) || $user_id < 0) {
        return false;
    }
    $u = auth();
    $logged_user_id = Secure($u->id);
    $user_id        = Secure($user_id);
    $query          = mysqli_query($conn, "SELECT COUNT(`id`) FROM `blocks` WHERE (`user_id` = {$logged_user_id} AND `blocked` = {$user_id}) OR (`user_id` = {$user_id} AND `block_userid` = {$logged_user_id})");
    return (Wo_Sql_Result($query, 0) == 1) ? true : false;
}
//done
function Wo_IsFollowing($following_id, $user_id = 0) {
    global $conn, $wo;
//    if (IS_LOGGED == false) {
//        return false;
//    }
    if (empty($following_id) || !is_numeric($following_id) || $following_id < 0) {
        return false;
    }
    if ((empty($user_id) || !is_numeric($user_id) || $user_id < 0)) {
        $u = auth();
        $user_id = Secure($u->id);
    }
    $following_id = Secure($following_id);
    $user_id      = Secure($user_id);
    $query        = mysqli_query($conn, " SELECT COUNT(`id`) FROM `followers` WHERE `following_id` = {$following_id} AND `follower_id` = {$user_id} AND `active` = '1' ");
    return (Wo_Sql_Result($query, 0) == 1) ? true : false;
}
function Wo_RegisterFollow($following_id = 0, $followers_id = 0) {
    global $config, $conn, $db;
//    if (IS_LOGGED == false) {
//        return false;
//    }
    if (!isset($following_id) or empty($following_id) or !is_numeric($following_id) or $following_id < 1) {
        return false;
    }
    if (!is_array($followers_id)) {
        $followers_id = array($followers_id);
    }
    foreach ($followers_id as $follower_id) {
        if (!isset($follower_id) or empty($follower_id) or !is_numeric($follower_id) or $follower_id < 1) {
            continue;
        }
        if (Wo_IsBlocked($following_id)) {
            continue;
        }
        $following_id = Secure($following_id);
        $follower_id  = Secure($follower_id);
        $active       = 1;
        if (Wo_IsFollowing($following_id, $follower_id) === true) {
            continue;
        }
        $follower_data  = Wo_UserData($follower_id);
        $following_data = Wo_UserData($following_id);
        if (empty($follower_data['id']) || empty($following_data['id'])) {
            continue;
        }
        if ($following_data['confirm_followers'] == "1") {
            $active = 0;
        }
        $query = mysqli_query($conn, " INSERT INTO `followers` (`following_id`,`follower_id`,`active`,`created_at`) VALUES ({$following_id},{$follower_id},'{$active}','".time()."')");
        if ($query) {
            if (isEndPointRequest()) {
                $Notif = LoadEndPointResource('Notifications',true);
            }else{
                $Notif = LoadEndPointResource('Notifications');
            }
            if ($Notif) {
                if ($active === 1) {
                    $Notif->createNotification($following_data['web_device_id'], $follower_id, $following_id, 'friend_request_accepted', '', '/@' . $follower_data['username']);
                    $Notif->createNotification($following_data['web_device_id'], $following_id, $follower_id, 'friend_request_accepted', '', '/@' . $following_data['username']);
                }else{
                    $Notif->createNotification($following_data['web_device_id'], $follower_id, $following_id, 'friend_request', '', '/@' . $follower_data['username']);
                }
            }
        }
    }
    return true;
}
function Wo_CountFollowRequests($data = array()) {
    global $wo, $conn;
    if (IS_LOGGED == false) {
        return false;
    }
    $get     = array();
    $user_id = Secure($wo['user']['user_id']);
    if (empty($data['account_id']) || $data['account_id'] == 0) {
        $data['account_id'] = $user_id;
        $account            = $wo['user'];
    }
    if (!is_numeric($data['account_id']) || $data['account_id'] < 1) {
        return false;
    }
    if ($data['account_id'] != $user_id) {
        $data['account_id'] = Secure($data['account_id']);
        $account            = Wo_UserData($data['account_id']);
    }
    $query_one = " SELECT COUNT(`id`) AS `FollowRequests` FROM `followers` WHERE `active` = '0' AND `following_id` =  " . $account['user_id'] . " AND `follower_id` IN (SELECT `user_id` FROM `users` WHERE `active` = '1')";
    if (isset($data['unread']) && $data['unread'] == true) {
        $query_one .= " AND `seen` = 0";
    }
    $query_one .= " ORDER BY `id` DESC";
    $sql_query_one = mysqli_query($conn, $query_one);
    $sql_fetch_one = mysqli_fetch_assoc($sql_query_one);
    return $sql_fetch_one['FollowRequests'];
}
function Wo_IsFollowRequested($following_id = 0, $follower_id = 0) {
    global $conn;
    if (!isset($following_id) or empty($following_id) or !is_numeric($following_id) or $following_id < 1) {
        return false;
    }
    if (!is_numeric($follower_id) or $follower_id < 1) {
        return false;
    }
    $following_id = Secure($following_id);
    $follower_id  = Secure($follower_id);
    $query        = "SELECT `id` FROM `followers` WHERE `follower_id` = {$following_id} AND `following_id` = {$follower_id} AND `active` = '0'";
    $sql_query    = mysqli_query($conn, $query);
    if (mysqli_num_rows($sql_query) > 0) {
        return true;
    }else{
        return false;
    }
//     global $conn;
// //    if (IS_LOGGED == false) {
// //        return false;
// //    }
//     if (!isset($following_id) or empty($following_id) or !is_numeric($following_id) or $following_id < 1) {
//         return false;
//     }
//     if ((!isset($follower_id) or empty($follower_id) or !is_numeric($follower_id) or $follower_id < 1)) {
//         $u = auth();
//         $follower_id = Secure($u->id);
//     }
//     if (!is_numeric($follower_id) or $follower_id < 1) {
//         return false;
//     }
//     $following_id = Secure($following_id);
//     $follower_id  = Secure($follower_id);
//     $query        = "SELECT `id` FROM `followers` WHERE `follower_id` = {$follower_id} AND `following_id` = {$following_id} AND `active` = '0'";
//     $sql_query    = mysqli_query($conn, $query);
//     if (mysqli_num_rows($sql_query) > 0) {
//         return true;
//     }else{
//         return false;
//     }
}
//done
function Wo_DeleteFollow($following_id = 0, $follower_id = 0) {
    global $config, $conn;
//    if (IS_LOGGED == false) {
//        return false;
//    }
    if (!isset($following_id) or empty($following_id) or !is_numeric($following_id) or $following_id < 1) {
        return false;
    }
    if (!isset($follower_id) or empty($follower_id) or !is_numeric($follower_id) or $follower_id < 1) {
        return false;
    }
    $following_id = Secure($following_id);
    $follower_id  = Secure($follower_id);
    if (Wo_IsFollowing($following_id, $follower_id) === false && Wo_IsFollowRequested($following_id, $follower_id) === false) {
        return false;
    } else {
        $query = mysqli_query($conn, " DELETE FROM `followers` WHERE `following_id` = {$following_id} AND `follower_id` = {$follower_id}");
        if ($config->connectivitySystem == "1") {
            $query_two     = "DELETE FROM `followers` WHERE `follower_id` = {$following_id} AND `following_id` = {$follower_id}";
            $sql_query_two = mysqli_query($conn, $query_two);

            $query_two1     = "DELETE FROM `notifications` WHERE ( `notifier_id` = {$following_id} AND `recipient_id` = {$follower_id} AND `type` = 'friend_request_accepted' ) OR ( `notifier_id` = {$follower_id} AND `recipient_id` = {$following_id} AND `type` = 'friend_request_accepted' )";
            $sql_query_two1 = mysqli_query($conn, $query_two1);

        }
        if ($query) {

            return true;
        }
    }
}
//done
function Wo_CountFollowing($user_id,$active = true) {
    global $wo, $conn;
    $data = array();
    if (empty($user_id) or !is_numeric($user_id) or $user_id < 1) {
        return false;
    }
    $user_id    = Secure($user_id);
    $sub_sql    = '';
    if ($active === true) {
        $sub_sql = "AND `active` = '1'";
    }
    $query_text = "SELECT COUNT(`id`) AS count FROM `users` WHERE `id` IN (SELECT `following_id` FROM `followers` WHERE `follower_id` = {$user_id} AND `following_id` <> {$user_id} {$sub_sql}) {$sub_sql}";
    if (IS_LOGGED == true) {
        $u = auth();
        $logged_user_id = Secure($u->id);
        $query_text .= " AND `id` NOT IN (SELECT `block_userid` FROM `blocks` WHERE `id` = '{$logged_user_id}') AND `id` NOT IN (SELECT `user_id` FROM `blocks` WHERE `block_userid` = '{$logged_user_id}')";
    }
    $query        = mysqli_query($conn, $query_text);
    $fetched_data = mysqli_fetch_assoc($query);
    return $fetched_data['count'];
}
function Wo_AcceptFollowRequest($following_id = 0, $follower_id = 0) {
    global $conn;
    if (IS_LOGGED == false) {
        return false;
    }
    if (!isset($following_id) or empty($following_id) or !is_numeric($following_id) or $following_id < 1) {
        return false;
    }
    if (!isset($follower_id) or empty($follower_id) or !is_numeric($follower_id) or $follower_id < 1) {
        return false;
    }
    $following_id = Secure($following_id);
    $follower_id  = Secure($follower_id);
    if (Wo_IsFollowRequested($following_id, $follower_id) === false) {
        return false;
    }
    $follower_data = Wo_UserData($follower_id);
    if (empty($follower_data['id'])) {
        return false;
    }
    $following_data = Wo_UserData($following_id);
    if (empty($following_data['id'])) {
        return false;
    }
    $query = mysqli_query($conn, "UPDATE `followers` SET `active` = '1' WHERE `following_id` = {$follower_id} AND `follower_id` = {$following_id} AND `active` = '0'");
//    if ($wo['config']['connectivitySystem'] == 1) {
//        $query_two = mysqli_query($conn, "INSERT INTO `followers` (`following_id`,`follower_id`,`active`) VALUES ({$following_id},{$follower_id},'1') ");
//    }
    if ($query) {
        if (isEndPointRequest()) {
            $Notif = LoadEndPointResource('Notifications',true);
        }else{
            $Notif = LoadEndPointResource('Notifications');
        }
        if ($Notif) {
            $n = $Notif->createNotification($following_data['web_device_id'], $follower_id, $following_id, 'friend_request_accepted', '', '/@' . $follower_data['username']);
            if ($n === true) {
                return true;
            } else {
                return false;
            }
        }
    }
}
function Wo_DeleteFollowRequest($following_id, $follower_id) {
    global $wo, $conn;
    if (IS_LOGGED == false) {
        return false;
    }
    if (!isset($following_id) or empty($following_id) or !is_numeric($following_id) or $following_id < 1) {
        return false;
    }
    if (!isset($follower_id) or empty($follower_id) or !is_numeric($follower_id) or $follower_id < 1) {
        return false;
    }
    $following_id = Secure($following_id);
    $follower_id  = Secure($follower_id);
    if (Wo_IsFollowRequested($following_id, $follower_id) === false) {
        return false;
    } else {
        $query = mysqli_query($conn, " DELETE FROM `followers` WHERE `following_id` = {$follower_id} AND `follower_id` = {$following_id} ");
        if ($query) {
            return true;
        }
    }
}
function Wo_GetFollowRequests($user_id = 0, $search_query = '') {
    global $wo, $conn;
    if (IS_LOGGED == false) {
        return false;
    }
    $data = array();
    if (empty($user_id) or $user_id == 0) {
        $user_id = $wo['user']['user_id'];
    }
    if (!is_numeric($user_id) or $user_id < 1) {
        return false;
    }
    $user_id = Secure($user_id);
    $query   = "SELECT `user_id` FROM `users` WHERE `user_id` IN (SELECT `follower_id` FROM `followers` WHERE `follower_id` <> {$user_id} AND `following_id` = {$user_id} AND `active` = '0') AND `active` = '1' ";
    if (!empty($search_query)) {
        $search_query = Secure($search_query);
        $query .= " AND `name` LIKE '%$search_query%'";
    }
    $query .= " ORDER BY `user_id` DESC";
    $sql_query = mysqli_query($conn, $query);
    while ($sql_fetch = mysqli_fetch_assoc($sql_query)) {
        $data[] = Wo_UserData($sql_fetch['user_id']);
    }
    return $data;
}
//done
function Wo_CountFollowers($user_id) {
    global $wo, $conn;
    if (empty($user_id) or !is_numeric($user_id) or $user_id < 1) {
        return false;
    }
    $data       = array();
    $user_id    = Secure($user_id);
    $query_text = " SELECT COUNT(`id`) AS count FROM `users` WHERE `id` IN (SELECT `follower_id` FROM `followers` WHERE `follower_id` <> {$user_id} AND `following_id` = {$user_id} AND `active` = '1') AND `active` = '1'";
    if (IS_LOGGED == true) {
        $u = auth();
        $logged_user_id = Secure($u->id);
        $query_text .= " AND `id` NOT IN (SELECT `block_userid` FROM `blocks` WHERE `user_id` = '{$logged_user_id}') AND `id` NOT IN (SELECT `user_id` FROM `blocks` WHERE `block_userid` = '{$logged_user_id}')";
    }
    $query        = mysqli_query($conn, $query_text);
    $fetched_data = mysqli_fetch_assoc($query);
    return $fetched_data['count'];
}
function Wo_SearchFollowers($user_id, $filter = '', $limit = 10, $event_id = 0) {
    global $wo, $conn;
    $data = array();
    if (empty($user_id) || !is_numeric($user_id) || $user_id < 1) {
        return false;
    }
    if (empty($event_id)) {
        return false;
    }
    $user_id = Secure($user_id);
    $filter  = Secure($filter);
    ;
    $query = " SELECT `user_id` FROM `users` WHERE `user_id` IN (SELECT `follower_id` FROM `followers` WHERE `follower_id` <> {$user_id} AND `following_id` = {$user_id} AND `active` = '1') AND `active` = '1'";
    if (!empty($filter)) {
        $query .= " AND (`username` LIKE '%$filter%' OR `first_name` LIKE '%$filter%' OR `last_name` LIKE '%$filter%')";
    }
    $query .= " AND `user_id` NOT IN (SELECT `invited_id` FROM " . T_EVENTS_INV . " WHERE `inviter_id` = '$user_id') ";
    $query .= " AND `user_id` NOT IN (SELECT `user_id` FROM " . T_EVENTS_GOING . " WHERE `event_id` = '$event_id') ";
    $query .= " AND `user_id` NOT IN (SELECT `poster_id` FROM " . T_EVENTS . " WHERE `id` = '$event_id') ";
    $query .= " LIMIT {$limit} ";
    $sql_query = mysqli_query($conn, $query);
    while ($fetched_data = mysqli_fetch_assoc($sql_query)) {
        $data[] = Wo_UserData($fetched_data['user_id']);
    }
    return $data;
}
function Wo_GetFollowing($user_id, $type = '', $limit = '', $after_user_id = '', $placement = array()) {
    global $wo, $conn;
    $data = array();
    if (empty($user_id) or !is_numeric($user_id) or $user_id < 1) {
        return false;
    }
    $user_id       = Secure($user_id);
    $after_user_id = Secure($after_user_id);
    $query         = "SELECT `user_id` FROM `users` WHERE `user_id` IN (SELECT `following_id` FROM `followers` WHERE `follower_id` = {$user_id} AND `following_id` <> {$user_id} AND `active` = '1') AND `active` = '1' ";
    if (!empty($after_user_id) && is_numeric($after_user_id)) {
        $query .= " AND `user_id` < {$after_user_id}";
    }
    if (IS_LOGGED == true) {
        $logged_user_id = Secure($wo['user']['user_id']);
        $query .= " AND `user_id` NOT IN (SELECT `block_userid` FROM `blocks` WHERE `user_id` = '{$logged_user_id}') AND `user_id` NOT IN (SELECT `user_id` FROM `blocks` WHERE `block_userid` = '{$logged_user_id}')";
    }
    if ($type == 'sidebar' && !empty($limit) && is_numeric($limit)) {
        $query .= " ORDER BY RAND() LIMIT {$limit}";
    }
    if ($type == 'profile' && !empty($limit) && is_numeric($limit)) {
        $query .= " ORDER BY `user_id` DESC LIMIT {$limit}";
    }
    if (!empty($placement)) {
        if ($placement['in'] == 'profile_sidebar' && is_array($placement['following_data'])) {
            foreach ($placement['following_data'] as $key => $id) {
                $user_data   = Wo_UserData($id, false);
                if (!empty($user_data)) {
                    $data[]  = $user_data;
                }
            }
            return $data;
        }
    }
    $sql_query = mysqli_query($conn, $query);
    while ($fetched_data = mysqli_fetch_assoc($sql_query)) {
        $user_data                  = Wo_UserData($fetched_data['user_id'], false);
        $user_data['family_member'] = Wo_GetFamalyMember($fetched_data['user_id'], $wo['user']['id']);
        $data[]                     = $user_data;
    }
    return $data;
}
function Wo_GetFollowers($user_id, $type = '', $limit = '', $after_user_id = '', $placement = array()) {
    global $wo, $conn;
    $data = array();
    if (empty($user_id) or !is_numeric($user_id) or $user_id < 1) {
        return false;
    }
    $user_id       = Secure($user_id);
    $after_user_id = Secure($after_user_id);
    $query         = " SELECT `id` FROM `users` WHERE `user_id` IN (SELECT `follower_id` FROM `followers` WHERE `follower_id` <> {$user_id} AND `following_id` = {$user_id} AND `active` = '1') AND `active` = '1'";
    if (!empty($after_user_id) && is_numeric($after_user_id)) {
        $query .= " AND `user_id` < {$after_user_id}";
    }
    if (IS_LOGGED == true) {
        $logged_user_id = Secure($wo['user']['user_id']);
        $query .= " AND `user_id` NOT IN (SELECT `block_userid` FROM `blocks` WHERE `user_id` = '{$logged_user_id}') AND `user_id` NOT IN (SELECT `user_id` FROM `blocks` WHERE `block_userid` = '{$logged_user_id}')";
    }
    if ($type == 'sidebar' && !empty($limit) && is_numeric($limit)) {
        $query .= " ORDER BY RAND()";
    }
    if ($type == 'profile' && !empty($limit) && is_numeric($limit)) {
        $query .= " ORDER BY `user_id` DESC";
    }
    $query .= " LIMIT {$limit} ";
    if (!empty($placement)) {
        if ($placement['in'] == 'profile_sidebar' && is_array($placement['followers_data'])) {
            foreach ($placement['followers_data'] as $key => $id) {
                $user_data   = Wo_UserData($id);
                if (!empty($user_data)) {
                    $data[]  = $user_data;
                }
            }
            return $data;
        }
    }
    $sql_query = mysqli_query($conn, $query);
    while ($fetched_data = mysqli_fetch_assoc($sql_query)) {
        $user_data                  = Wo_UserData($fetched_data['id']);
        $data[]                     = $user_data;
    }
    return $data;
}
function Wo_GetFollowButton($user_id = 0) {
    global $wo;
    if (IS_LOGGED == false) {
        return false;
    }
    if (!is_numeric($user_id) or $user_id < 0) {
        return false;
    }
    if ($user_id == $wo['user']['user_id']) {
        return false;
    }
    $account = $wo['follow'] = Wo_UserData($user_id);
    if (!isset($wo['follow']['user_id'])) {
        return false;
    }
    $user_id           = Secure($user_id);
    $logged_user_id    = Secure($wo['user']['user_id']);
    $follow_button     = 'buttons/follow';
    $unfollow_button   = 'buttons/unfollow';
    $add_frined_button = 'buttons/add-friend';
    $unfrined_button   = 'buttons/unfriend';
    $accept_button     = 'buttons/accept-request';
    $request_button    = 'buttons/requested';
    if (Wo_IsFollowing($user_id, $logged_user_id)) {
        if ($wo['config']['connectivitySystem'] == 1) {
            return Wo_LoadPage($unfrined_button);
        } else {
            return Wo_LoadPage($unfollow_button);
        }
    } else {
        if (Wo_IsFollowRequested($user_id, $logged_user_id)) {
            return Wo_LoadPage($request_button);
        } else if (Wo_IsFollowRequested($logged_user_id, $user_id)) {
            return Wo_LoadPage($accept_button);
        } else {
            if ($account['follow_privacy'] == 1) {
                if (Wo_IsFollowing($logged_user_id, $user_id)) {
                    if ($wo['config']['connectivitySystem'] == 1) {
                        return Wo_LoadPage($add_frined_button);
                    } else {
                        return Wo_LoadPage($follow_button);
                    }
                }
            } else if ($account['follow_privacy'] == 0) {
                if ($wo['config']['connectivitySystem'] == 1) {
                    return Wo_LoadPage($add_frined_button);
                } else {
                    return Wo_LoadPage($follow_button);
                }
            }
        }
    }
}
function SendQueueEmails(){
    global $config,$conn;
    $mail = new PHPMailer;
    $data = array();
    $query_one = " SELECT * FROM `emails` WHERE `src` = 'admin' ORDER BY `id` DESC LIMIT 1";
    $sql       = mysqli_query($conn, $query_one);
    if (mysqli_num_rows($sql) < 1) {
        return false;
    }
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $email_sent = SendEmail($fetched_data['email_to'], $fetched_data['subject'], $fetched_data['message']);
        if($email_sent){
            $query_one_  = "DELETE FROM `emails` WHERE `id` = {$fetched_data['id']}";
            $sql_        = mysqli_query($conn, $query_one_);
        }
    }
    return $send;
}

function CheckPermission($permissions, $permission){
    if(empty( $permissions )){
        return false;
    }else{
        $_permission = unserialize($permissions);
        if(is_array($_permission)){
            if(isset($_permission[$permission]) && $_permission[$permission] == "1") {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}

function is_avatar_approved($user_id, $avatar){
    global $wo, $conn, $config;
    // if (IS_LOGGED == false) {
    //     return false;
    // }
    if (!is_numeric($user_id) or $user_id < 1) {
        return false;
    }
    if(empty($avatar)){
        return false;
    }
    if($config->review_media_files == '0'){
        return true;
    }
    $user_id = Secure($user_id);
    $avatar = str_replace( '_avater.' , '_full.', $avatar);
    $sql   = "SELECT `is_approved` FROM `mediafiles` WHERE `user_id` = $user_id AND `file` = '{$avatar}'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        if(Sql_Result($query, 0) == '1'){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
function RegisterAffRevenue($user_id,$amount = 0){
    global $db,$config;
    $amount_percent_ref = $config->amount_percent_ref;
    $total_revinue = ( $amount * $amount_percent_ref ) / 100;
    $me = $db->where('id',$user_id)->getOne('users');
    if($me){
        if($me['src'] !== 'Referrer'){
            return false;
        }
        $ref_user = $db->where('id',$me['referrer'])->getOne('users');
        $new_balance = (double)$ref_user['aff_balance'] + (double)$total_revinue ;
        $db->where('id',$ref_user['id'])->update('users', array('aff_balance' => floatval($new_balance)));
    }
    return false;
}
function GetPageTitle($page_name){
    global $config;
    $arr = unserialize($config->seo);
    if(isset($arr[$page_name])){
        return $arr[$page_name]['title'];
    }else{
        return __($page_name);
    }
}
function GetPageKeyword($page_name){
    global $config;
    $arr = unserialize($config->seo);
    if(isset($arr[$page_name])){
        return $arr[$page_name]['meta_keywords'];
    }else{
        return __($page_name);
    }
}
function GetPageDescription($page_name){
    global $config;
    $arr = unserialize($config->seo);
    if(isset($arr[$page_name])){
        return $arr[$page_name]['meta_description'];
    }else{
        return __($page_name);
    }
}

function RecordDailyCredit(){
    global $config,$db;
    if (IS_LOGGED == false) return false;
    if($config->credit_earn_system == 0) return false;
    $u = auth();
    $max_days = (int)$config->credit_earn_max_days;
    $day_amount = (int)$config->credit_earn_day_amount;

    $dates = $db->where('user_id', $u->id)->get('daily_credits',null,array('count(*) as CountDays','TIMESTAMPDIFF(DAY, from_unixtime( max(created_at) ), from_unixtime( min(created_at) )) as TotalDays','TIMESTAMPDIFF(DAY, now() , from_unixtime( min(created_at) )) as DaysFromNow'));
    $DaysFromNow = (int)abs($dates[0]['DaysFromNow']);
    $TotalDays = (int)abs($dates[0]['TotalDays']);
    $CountDays = (int)abs($dates[0]['CountDays']);
    if($CountDays <= $max_days){
        $add = false;
        if( ( $CountDays === 0 || $CountDays === $DaysFromNow ) && $CountDays <= $DaysFromNow ){
            $add = true;
        }
        if( $CountDays === 0 ){
            $add = true;
        }
        if( ( $TotalDays > $max_days ) || ( $max_days === $TotalDays + 1) ){
            $add = false;
        }

        if($add === true){
            $db->insert('daily_credits',array(
                "user_id" => $u->id,
                "created_at" => time()
            ));
        }

        if($DaysFromNow > 0 && $CountDays > 0 && $CountDays === $max_days) {


//        var_dump(($max_days >= $CountDays && $u->reward_daily_credit == 0));
//        var_dump($max_days);
//        var_dump($TotalDays);
//        var_dump($CountDays);
//        var_dump($DaysFromNow);
//        exit();

            if (($max_days >= $CountDays && $u->reward_daily_credit == 0)) {
                //here we will update user credits
                $total_amount = $day_amount * $max_days;
            $db->where('id', $u->id)->update('users',array(
                "balance" => $db->inc($total_amount),
                "reward_daily_credit" => 1
            ));
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }
}