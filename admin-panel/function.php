<?php
unset($_SESSION['config']);
$_SESSION['config_expiry'] = time();
$wo = array();
use Aws\S3\S3Client;
$wo['loggedin'] = false;
if( isset( $_SESSION['JWT'] ) ){
    $wo['loggedin'] = true;
}else{
    header('location: ' . $config->uri);
    exit();
}

$wo['site_url'] = $config->uri;
$wo['config'] = (array)$config;
$wo['config']['siteTitle'] = $config->site_name;
$wo['config']['theme_url'] = $config->uri . '/themes/' . $config->theme ;
$wo['config']['site_url'] = $config->uri;
$wo['config']['siteName'] = $config->default_title;
$wo['script_version'] = $config->version;


$wo['user']['avatar'] = auth()->avater->avater;
$wo['user']['url'] = $config->uri . '/@' . auth()->username;
$wo['user']['name'] = auth()->username;

$wo['config']['btn_background_color']  = '#a33596';
$wo['config']['header_background']  = '#1e2321';
$current_user_id = auth()->id;
$is_admin = false;
if(auth()->admin == 1 ) {
    $is_admin = true;
}else if ( auth()->permission !== '' ) {

} else {
    header('location: ' . $config->uri);
    exit();
}
function CheckUserPermission($user_id, $permission, $is_radio = false){
    global $conn, $wo,$is_admin;
    if ($wo['loggedin'] == false) {
        return false;
    }
    if ($is_admin === true && $is_radio === false) {
        return true;
    }
    if (empty($user_id) || empty($permission)) {
        return false;
    }
    $id            = Secure($user_id);
    $query_one     = mysqli_query($conn, "SELECT `permission` FROM `users` WHERE `id` = {$id}");
    $sql_query_one = mysqli_fetch_assoc($query_one);
    if(empty( $sql_query_one['permission'] )){
        return false;
    }else{
        $_permission = unserialize($sql_query_one['permission']);
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
function CheckRadioPermission($user_id, $permission, $is_true = true){
    if(CheckUserPermission($user_id, $permission, true)){
        if($is_true === true) {
            return ' checked=""';
        }
//        else{
//            return ' checked=""';
//        }
    }else{
        if($is_true === false){
            return ' checked=""';
        }
    }
}
function Wo_AddNewAnnouncement($text) {
    global $conn, $wo,$is_admin;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $text    = mysqli_real_escape_string($conn, $text);
//    if ($is_admin === false) {
//        return false;
//    }
    if (empty($text)) {
        return false;
    }
    $query = mysqli_query($conn, "INSERT INTO `announcement` (`text`, `time`, `active`) VALUES ('{$text}', " . time() . ", '1')");
    if ($query) {
        return mysqli_insert_id($conn);
    }
}
function Wo_GetAnnouncementViews($id) {
    global $conn, $wo;
    $id            = Secure($id);
    $query_one     = mysqli_query($conn, "SELECT COUNT(`id`) as `count` FROM `announcement_views` WHERE `announcement_id` = {$id}");
    $sql_query_one = mysqli_fetch_assoc($query_one);
    return $sql_query_one['count'];
}
function Wo_GetAnnouncement($id) {
    global $conn, $wo;
    if ($wo['loggedin'] == false) {
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
function Wo_GetActiveAnnouncements() {
    global $conn, $wo,$is_admin;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $data    = array();
//    if ($is_admin === false) {
//        return false;
//    }
    $query = mysqli_query($conn, "SELECT `id` FROM `announcement` WHERE `active` = '1' ORDER BY `id` DESC");
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = Wo_GetAnnouncement($row['id']);
    }
    return $data;
}
function Wo_GetHomeAnnouncements() {
    global $conn, $wo;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $user_id      = Secure(auth()->id);
    $query        = mysqli_query($conn, "SELECT `id` FROM `announcement` WHERE `active` = '1' AND `id` NOT IN (SELECT `announcement_id` FROM `announcement_views` WHERE `user_id` = {$user_id}) ORDER BY RAND() LIMIT 1");
    $fetched_data = mysqli_fetch_assoc($query);
    $data         = Wo_GetAnnouncement($fetched_data['id']);
    return $data;
}
function Wo_GetInactiveAnnouncements() {
    global $conn, $wo,$is_admin;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $data    = array();
//    if ($is_admin === false) {
//        return false;
//    }
    $query = mysqli_query($conn, "SELECT `id` FROM `announcement` WHERE `active` = '0' ORDER BY `id` DESC");
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = Wo_GetAnnouncement($row['id']);
    }
    return $data;
}
function Wo_DeleteAnnouncement($id) {
    global $conn, $wo,$is_admin;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $id      = Secure($id);
//    if ($is_admin === false) {
//        return false;
//    }
    $query_one = mysqli_query($conn, "DELETE FROM `announcement` WHERE `id` = {$id}");
    $query_one .= mysqli_query($conn, "DELETE FROM `announcement_views` WHERE `announcement_id` = {$id}");
    if ($query_one) {
        return true;
    }
}
function Wo_IsActiveAnnouncement($id) {
    global $conn;
    $id    = Secure($id);
    $query = mysqli_query($conn, "SELECT COUNT(`id`) FROM `announcement` WHERE `id` = '{$id}' AND `active` = '1'");
    return (Wo_Sql_Result($query, 0) == 1) ? true : false;
}
function Wo_IsViewedAnnouncement($id) {
    global $conn, $wo;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $id      = Secure($id);
    $user_id = Secure(auth()->id);
    $query   = mysqli_query($conn, "SELECT COUNT(`id`) FROM `announcement_views` WHERE `announcement_id` = '{$id}' AND `user_id` = '{$user_id}'");
    return (Wo_Sql_Result($query, 0) > 0) ? true : false;
}
function Wo_IsThereAnnouncement() {
    global $conn, $wo;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $user_id = Secure(auth()->id);
    $query   = mysqli_query($conn, "SELECT COUNT(`id`) as count FROM `announcement` WHERE `active` = '1' AND `id` NOT IN (SELECT `announcement_id` FROM `announcement_views` WHERE `user_id` = {$user_id})");
    $sql     = mysqli_fetch_assoc($query);
    return ($sql['count'] > 0) ? true : false;
}
function Wo_DisableAnnouncement($id) {
    global $conn, $wo,$is_admin;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $id      = Secure($id);
//    if ($is_admin === false) {
//        return false;
//    }
    if (Wo_IsActiveAnnouncement($id) === false) {
        return false;
    }
    $query_one = mysqli_query($conn, "UPDATE `announcement` SET `active` = '0' WHERE `id` = {$id}");
    if ($query_one) {
        return true;
    }
}
function Wo_ActivateAnnouncement($id) {
    global $conn, $wo,$is_admin;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $id      = Secure($id);
//    if ($is_admin === false) {
//        return false;
//    }
    if (Wo_IsActiveAnnouncement($id) === true) {
        return false;
    }
    $query_one = mysqli_query($conn, "UPDATE `announcement` SET `active` = '1' WHERE `id` = {$id}");
    if ($query_one) {
        return true;
    }
}
//function Wo_Sql_Result($res, $row = 0, $col = 0) {
//    $numrows = mysqli_num_rows($res);
//    if ($numrows && $row <= ($numrows - 1) && $row >= 0) {
//        mysqli_data_seek($res, $row);
//        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
//        if (isset($resrow[$col])) {
//            return $resrow[$col];
//        }
//    }
//    return false;
//}
function Wo_RunInBackground($data = array()) {
    ob_end_clean();
    header("Content-Encoding: none");
    header("Connection: close");
    ignore_user_abort();
    ob_start();
    if (!empty($data)) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    $size = ob_get_length();
    header("Content-Length: $size");
    ob_end_flush();
    flush();
    session_write_close();
    if (is_callable('fastcgi_finish_request')) {
        fastcgi_finish_request();
    }
}
function Wo_GenerateKey($minlength = 20, $maxlength = 20, $uselower = true, $useupper = true, $usenumbers = true, $usespecial = false) {
    $charset = '';
    if ($uselower) {
        $charset .= "abcdefghijklmnopqrstuvwxyz";
    }
    if ($useupper) {
        $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    }
    if ($usenumbers) {
        $charset .= "123456789";
    }
    if ($usespecial) {
        $charset .= "~@#$%^*()_+-={}|][";
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
function Wo_ImportImageFromFile($media, $custom_name = '_url_image') {
    global $wo;
    if (empty($media)) {
        return false;
    }
    if (!file_exists('upload/photos/' . date('Y'))) {
        mkdir('upload/photos/' . date('Y'), 0777, true);
    }
    if (!file_exists('upload/photos/' . date('Y') . '/' . date('m'))) {
        mkdir('upload/photos/' . date('Y') . '/' . date('m'), 0777, true);
    }
    $extension = 0; //image_type_to_extension($size[2]);
    if (empty($extension)) {
        $extension = '.jpg';
    }
    $dir               = 'upload/photos/' . date('Y') . '/' . date('m');
    $file_dir          = $dir . '/' . Wo_GenerateKey() . $custom_name . $extension;
    $fileget           = file_get_contents($media);
    if (!empty($fileget)) {
        $importImage = @file_put_contents($file_dir, $fileget);
    }
    if (file_exists($file_dir)) {
        //$upload_s3 = Wo_UploadToS3($file_dir);
        $check_image = getimagesize($file_dir);
        if (!$check_image) {
            unlink($file_dir);
        }
        return $file_dir;
    } else {
        return false;
    }
}
function Wo_UploadToS3($filename, $config = array()) {
    global $wo,$_BASEPATH;
//    require_once($_BASEPATH.'lib'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'s3'.DIRECTORY_SEPARATOR.'aws-autoloader.php');
//    require_once($_BASEPATH.'lib'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'spaces'.DIRECTORY_SEPARATOR.'spaces.php');
//    require_once($_BASEPATH.'lib'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'ftp'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php');
    $filename = str_replace('/',DIRECTORY_SEPARATOR,$_BASEPATH.$filename);
    if ($wo['config']['amazone_s3'] == 0 ) {
        return false;
    }
    if ($wo['config']['amazone_s3'] == 1){
        if (empty($wo['config']['amazone_s3_key']) || empty($wo['config']['amazone_s3_s_key']) || empty($wo['config']['region']) || empty($wo['config']['bucket_name'])) {
            return false;
        }
        $s3 = new S3Client([
            'version'     => 'latest',
            'region'      => $wo['config']['region'],
            'credentials' => [
                'key'    => $wo['config']['amazone_s3_key'],
                'secret' => $wo['config']['amazone_s3_s_key'],
            ]
        ]);
        $s3->putObject([
            'Bucket' => $wo['config']['bucket_name'],
            'Key'    => $filename,
            'Body'   => fopen($filename, 'r+'),
            'ACL'    => 'public-read',
            'CacheControl' => 'max-age=3153600',
        ]);
        if (empty($config['delete'])) {
            if ($s3->doesObjectExist($wo['config']['bucket_name'], $filename)) {
                if (empty($config['amazon'])) {
                    @unlink($filename);
                }
                return true;
            }
        } else {
            return true;
        }
    }
}
function UploadLogo($data = array()) {
    global $config,$_BASEPATH,$_DS;
    if (isset($data['file']) && !empty($data['file'])) {
        $data['file'] = Secure($data['file']);
    }
    if (isset($data['name']) && !empty($data['name'])) {
        $data['name'] = Secure($data['name']);
    }
    if (isset($data['name']) && !empty($data['name'])) {
        $data['name'] = Secure($data['name']);
    }
    if (empty($data)) {
        return false;
    }
    $allowed           = 'png';
    $new_string        = pathinfo($data['name'], PATHINFO_FILENAME) . '.' . strtolower(pathinfo($data['name'], PATHINFO_EXTENSION));
    $extension_allowed = explode(',', $allowed);
    $file_extension    = pathinfo($new_string, PATHINFO_EXTENSION);
    if (!in_array($file_extension, $extension_allowed)) {
        return false;
    }
    $logo_name = 'logo';
    if (!empty($data['light-logo'])) {
        $logo_name = 'logo-light';
    }
    if (!empty($data['favicon'])) {
        $logo_name = 'icon';
    }
    $dir      = $_BASEPATH . $_DS . "themes" . $_DS . $config->theme . $_DS . "assets" . $_DS . "img" . $_DS;
    $filename = $dir . "$logo_name.png";
    if (move_uploaded_file($data['file'], $filename)) {
        return true;
    }
}
function GetThemes() {
    global $ask,$_BASEPATH,$_DS;
    $themes = glob($_BASEPATH.$_DS.'themes'.$_DS.'*', GLOB_ONLYDIR);
    return $themes;
}
function Wo_CountUnseenReports() {
    global $wo, $conn;
    $query_one    = "SELECT COUNT(`id`) AS `reports` FROM `reports` WHERE `seen` = 0 ";
    $sql          = mysqli_query($conn, $query_one);
    $fetched_data = mysqli_fetch_assoc($sql);
    return $fetched_data['reports'];
}
function Wo_DeleteReport($report_id = '') {
    global $wo, $conn;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $report_id = Secure($report_id);
    $query     = mysqli_query($conn, "DELETE FROM `reports` WHERE `id` = {$report_id}");
    if ($query) {
        return true;
    }
}
function Wo_DeletePhoto($photo_id = '') {
    global $wo, $conn;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $photo_id = Secure($photo_id);
    $query     = mysqli_query($conn, "DELETE FROM `mediafiles` WHERE `id` = {$photo_id}");
    if ($query) {
        return true;
    }
}
function Wo_ApprovePhoto($photo_id = '') {
    global $wo, $conn;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $photo_id = Secure($photo_id);
    $query     = mysqli_query($conn, "UPDATE `mediafiles` SET `is_approved` = '1' WHERE `id` = {$photo_id}");
    if ($query) {
        return true;
    }
}
function Wo_DisApprovePhoto($photo_id = '') {
    global $wo, $conn;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $photo_id = Secure($photo_id);
    $query     = mysqli_query($conn, "UPDATE `mediafiles` SET `is_approved` = '0' WHERE `id` = {$photo_id}");
    if ($query) {
        return true;
    }
}
function Wo_ApproveAllPhoto() {
    global $wo, $conn;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $query     = mysqli_query($conn, "UPDATE `mediafiles` SET `is_approved` = '1'");
    if ($query) {
        return true;
    }
}
function Wo_DisApproveAllPhoto() {
    global $wo, $conn;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $query     = mysqli_query($conn, "UPDATE `mediafiles` SET `is_approved` = '0'");
    if ($query) {
        return true;
    }
}
function Wo_LangsNamesFromDB($lang = 'english', $full = false) {
    global $conn, $wo;
    $data  = array();
    $query = mysqli_query($conn, "SHOW COLUMNS FROM `langs`");
    while ($fetched_data = mysqli_fetch_assoc($query)) {
        $data[] = $fetched_data['Field'];
    }
    unset($data[0]);
    unset($data[1]);
    if($full === false) {
        unset($data[2]);
        unset($data[3]);
    }
    return $data;
}
function Wo_GetVerifications() {
    global $wo, $conn;
    $data      = array();
    $query_one = " SELECT * FROM verification_requests ORDER BY `id` DESC";
    $sql       = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        if (!empty($fetched_data['user_id'])) {
            $fetched_data['request_from']       = Wo_UserData($fetched_data['user_id']);
            $fetched_data['request_from']['id'] = $fetched_data['user_id'];
        }
        $data[]               = $fetched_data;
    }
    return $data;
}
function Wo_VerifyUser($id = 0, $verification_id = 0) {
    global $conn, $wo;
    if (empty($id) || empty($verification_id)) {
        return false;
    }
    if (auth()->admin === false) {
        return false;
    }
    $id          = Secure($id);
    $update      = false;
    $update     = mysqli_query($conn, "UPDATE `users` SET `verified` = '1', `active` = '1' WHERE `id` = {$id}");
    if ($update) {
        $deleted = mysqli_query($conn, "DELETE FROM `verification_requests` WHERE `id` = {$verification_id}");
        if ($deleted) {
            return true;
        }
    }

}
function Wo_LangsFromDB($lang = 'english') {
    global $conn, $wo;
    $data  = array();
    $query = mysqli_query($conn, "SELECT `lang_key`, `$lang` FROM `langs`");
    while ($fetched_data = mysqli_fetch_assoc($query)) {
        $data[$fetched_data['lang_key']] = htmlspecialchars_decode($fetched_data[$lang]);
    }
    return $data;
}
function Wo_GetLangDetailsByid($lang_key = '',$full = false) {
    global $conn, $wo;
    if (empty($lang_key)) {
        return false;
    }
    $lang_key = Secure($lang_key);
    $data     = array();
    $query    = mysqli_query($conn, "SELECT * FROM `langs` WHERE `id` = '{$lang_key}'");
    while ($fetched_data = mysqli_fetch_assoc($query)) {

        unset($fetched_data['id']);
        unset($fetched_data['ref']);
        if($full === false) {
            unset($fetched_data['options']);
            unset($fetched_data['lang_key']);
        }
        $data[] = $fetched_data;
    }
    return $data;
}
function Wo_GetLangDetails($lang_key = '',$full = false) {
    global $conn, $wo;
    if (empty($lang_key)) {
        return false;
    }
    $lang_key = Secure($lang_key);
    $data     = array();
    $query    = mysqli_query($conn, "SELECT * FROM `langs` WHERE `lang_key` = '{$lang_key}'");
    while ($fetched_data = mysqli_fetch_assoc($query)) {
        unset($fetched_data['lang_key']);
        unset($fetched_data['id']);
        unset($fetched_data['ref']);
        if($full === false) {
            unset($fetched_data['options']);
        }
        $data[] = $fetched_data;
    }
    return $data;
}
function Wo_GetReports() {
    global $wo, $conn;
    $data      = array();
    $query_one = " SELECT * FROM `reports` ORDER BY `id` DESC";
    $sql       = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $fetched_data['reporter'] = userData($fetched_data['user_id']);
        $fetched_data['reported'] = userData($fetched_data['report_userid']);
        //$fetched_data['story']    = Wo_PostData($fetched_data['post_id']);
        $fetched_data['type']     = 'user';
        $data[]                   = $fetched_data;
    }
    return $data;
}
function Wo_GetRegisteredDataStatics($month, $type = 'user') {
    global $wo, $conn;
    $year       = date("Y");
    $type_table = 'users';
    $type_id    = 'id';
    if ($type == 'user') {
        $type_table = 'users';
        $type_id    = 'id';
    }
//    } else if ($type == 'page') {
//        $type_table = T_PAGES;
//        $type_id    = 'page_id';
//    } else if ($type == 'group') {
//        $type_table = T_GROUPS;
//        $type_id    = 'id';
//    } else if ($type == 'posts') {
//        $type_table = T_POSTS;
//        $type_id    = 'id';
//    }
    $type_id      = Secure($type_id);
    $query_one    = mysqli_query($conn, "SELECT COUNT($type_id) as count FROM {$type_table} WHERE YEAR(`created_at`) = '{$year}' AND MONTH(`created_at`) = '{$month}'");
    $fetched_data = mysqli_fetch_assoc($query_one);
    return $fetched_data['count'];
}
function GetDateScope($type = 'day', $interval = 1){ 
    $data        = array();
    $hours       = array('00' => 0 ,'01' => 0 ,'02' => 0 ,'03' => 0 ,'04' => 0 ,'05' => 0 ,'06' => 0 ,'07' => 0 ,'08' => 0 ,'09' => 0 ,'10' => 0 ,'11' => 0 ,'12' => 0 ,'13' => 0 ,'14' => 0 ,'15' => 0 ,'16' => 0 ,'17' => 0 ,'18' => 0 ,'19' => 0 ,'20' => 0 ,'21' => 0 ,'22' => 0 ,'23' => 0);
    $days        = array('Saturday' => 0 , 'Sunday' => 0 , 'Monday' => 0 , 'Tuesday' => 0 , 'Wednesday' => 0 , 'Thursday' => 0 , 'Friday' => 0);
    $month       = array_fill(1, date('t', mktime(0, 0, 0, date('m'), 1, date('Y'))),0);

    $days_in_month = date('t', mktime(0, 0, 0, date('m'), 1, date('Y')));

    if ($days_in_month == 31) {
        $month = array('01' => 0 ,'02' => 0 ,'03' => 0 ,'04' => 0 ,'05' => 0 ,'06' => 0 ,'07' => 0 ,'08' => 0 ,'09' => 0 ,'10' => 0 ,'11' => 0 ,'12' => 0 ,'13' => 0 ,'14' => 0 ,'15' => 0 ,'16' => 0 ,'17' => 0 ,'18' => 0 ,'19' => 0 ,'20' => 0 ,'21' => 0 ,'22' => 0 ,'23' => 0,'24' => 0 ,'25' => 0 ,'26' => 0 ,'27' => 0 ,'28' => 0 ,'29' => 0 ,'30' => 0 ,'31' => 0);
    }elseif ($days_in_month == 30) {
        $month = array('01' => 0 ,'02' => 0 ,'03' => 0 ,'04' => 0 ,'05' => 0 ,'06' => 0 ,'07' => 0 ,'08' => 0 ,'09' => 0 ,'10' => 0 ,'11' => 0 ,'12' => 0 ,'13' => 0 ,'14' => 0 ,'15' => 0 ,'16' => 0 ,'17' => 0 ,'18' => 0 ,'19' => 0 ,'20' => 0 ,'21' => 0 ,'22' => 0 ,'23' => 0,'24' => 0 ,'25' => 0 ,'26' => 0 ,'27' => 0 ,'28' => 0 ,'29' => 0 ,'30' => 0);
    }elseif ($days_in_month == 29) {
        $month = array('01' => 0 ,'02' => 0 ,'03' => 0 ,'04' => 0 ,'05' => 0 ,'06' => 0 ,'07' => 0 ,'08' => 0 ,'09' => 0 ,'10' => 0 ,'11' => 0 ,'12' => 0 ,'13' => 0 ,'14' => 0 ,'15' => 0 ,'16' => 0 ,'17' => 0 ,'18' => 0 ,'19' => 0 ,'20' => 0 ,'21' => 0 ,'22' => 0 ,'23' => 0,'24' => 0 ,'25' => 0 ,'26' => 0 ,'27' => 0 ,'28' => 0 ,'29' => 0);
    }elseif ($days_in_month == 28) {
        $month = array('01' => 0 ,'02' => 0 ,'03' => 0 ,'04' => 0 ,'05' => 0 ,'06' => 0 ,'07' => 0 ,'08' => 0 ,'09' => 0 ,'10' => 0 ,'11' => 0 ,'12' => 0 ,'13' => 0 ,'14' => 0 ,'15' => 0 ,'16' => 0 ,'17' => 0 ,'18' => 0 ,'19' => 0 ,'20' => 0 ,'21' => 0 ,'22' => 0 ,'23' => 0,'24' => 0 ,'25' => 0 ,'26' => 0 ,'27' => 0 ,'28' => 0);
    }

    $months = array('01' => 0 ,'02' => 0 ,'03' => 0 ,'04' => 0 ,'05' => 0 ,'06' => 0 ,'07' => 0 ,'08' => 0 ,'09' => 0 ,'10' => 0 ,'11' => 0 ,'12' => 0 );
    if( $type == 'day' ){
        $data  = $hours;
        $start = strtotime(date('M')." ".date('d').", ".date('Y')." 12:00am");
        $end   = strtotime(date('M')." ".date('d').", ".date('Y')." 11:59pm");
    } else if( $type == 'day_before' ){
        $start = strtotime('-' . (int)$interval . ' day', time());
        $end = time();
        if ($end>=$start) {
            while ($start<$end) {
                $start+=86400; // add 24 hours
                $data[$start] = date('d M',$start);
            }
        }
    } else if( $type == 'week' ){
        $data  = $days;
        $time = strtotime(date(' l').", ".date('M')." ".date('d').", ".date('Y'));
        if (date('l') == 'Saturday') {
            $start = strtotime(date('M')." ".date('d').", ".date('Y')." 12:00am");
        } else {
            $start = strtotime('last saturday, 12:00am', $time);
        }
        if (date('l') == 'Friday') {
            $end = strtotime(date('M')." ".date('d').", ".date('Y')." 11:59pm");
        } else {
            $end = strtotime('next Friday, 11:59pm', $time);
        }
    } else if( $type == 'month' ){
        $data  = $month;
        $start = strtotime("1 ".date('M')." ".date('Y')." 12:00am");
        $end = strtotime(date('t', mktime(0, 0, 0, date('m'), 1, date('Y')))." ".date('M')." ".date('Y')." 11:59pm");
    } else if( $type == 'year' ){
        $data  = $months;
        $start = strtotime("1 ".date('M')." ".date('Y')." 12:00am");
        $end = strtotime(date('t', mktime(0, 0, 0, date('m'), 1, date('Y')))." ".date('M')." ".date('Y')." 11:59pm");
    } else if( $type == 'week_before' ){
        $data  = $month;
        $start = strtotime('-' . (int)$interval . ' week', time());
        $end = time();
    } else if( $type == 'month_before' ){
        $data  = $month;
        $start = strtotime('-' . (int)$interval . ' month', time());
        $end = time();
    } else if( $type == 'year_before' ){
        $data  = $month;
        $start = strtotime('-' . (int)$interval . ' year', time());
        $end = time();
    }

    return array(
        'data'   => $data,
        'start'  => $start,
        'end'    => $end
    );
}

function GetUserDidNotLoggedIn($mode = 'week', $interval = 1){
    global $conn;
    $data = array();
    $start = 0;
    $end = 0;
    if( $mode == 'week' ) {
        $dates = GetDateScope('week_before',$interval);
        $start = $dates['start'];
        $end = $dates['end'];
    }else if( $mode == 'month' ) {
        $dates = GetDateScope('month_before',$interval);
        $start = $dates['start'];
        $end = $dates['end'];
    }else if( $mode == 'year' ) {
        $dates = GetDateScope('year_before',$interval);
        $start = $dates['start'];
        $end = $dates['end'];
    }

    $query_one    = mysqli_query($conn, "SELECT * FROM `users` WHERE lastseen >= {$start} AND lastseen <= {$end}");
    $fetched_data = mysqli_fetch_assoc($query_one);
    while ($fetched_data = mysqli_fetch_assoc($query_one)) {
        $data[] = $fetched_data;
    }
    return $data;
}
function Wo_CountAllData($type){
    global $wo, $conn;
    $type_table = 'users';
    $type_id    = 'id';
    if ($type == 'user') {
        $type_table = T_USERS;
        $type_id    = 'user_id';
    } else if ($type == 'page') {
        $type_table = T_PAGES;
        $type_id    = 'page_id';
    } else if ($type == 'group') {
        $type_table = T_GROUPS;
        $type_id    = 'id';
    } else if ($type == 'blocks') {
        $type_table = 'blocks';
        $type_id    = 'id';
    } else if ($type == 'reports') {
        $type_table = 'reports';
        $type_id    = 'id';
    } else if ($type == 'messages') {
        $type_table = 'messages';
        $type_id    = 'id';
    } else if ($type == 'mediafiles') {
        $type_table = 'mediafiles';
        $type_id    = 'id';
    }
    $type_id      = Secure($type_id);
    $query_one    = mysqli_query($conn, "SELECT COUNT($type_id) as count FROM {$type_table}");
    $fetched_data = mysqli_fetch_assoc($query_one);
    return $fetched_data['count'];
}
function Wo_CountOnlineData(){
    return rand(5000,9000);
}
function Wo_userOnlineData(){
    global $wo, $conn;
    $query_one    = mysqli_query($conn, "SELECT COUNT(id) as count FROM `users` WHERE TIMESTAMPDIFF(second,FROM_UNIXTIME(`lastseen`),CURRENT_TIMESTAMP()) < 60");
    $fetched_data = mysqli_fetch_assoc($query_one);
    return $fetched_data['count'];
}
function Wo_CountAllPaymentData($type) {
    global $wo, $conn;
    $type_table   = 'payments';
    $type         = Secure($type);
    $query_one    = mysqli_query($conn, "SELECT COUNT(`id`) as count FROM {$type_table} WHERE `pro_plan` = '{$type}'");
    $fetched_data = mysqli_fetch_assoc($query_one);
    return $fetched_data['count'];
}
function Wo_GetAllStickers($limit = 5, $after = 0) {
    global $wo, $conn;
    $data      = array();
    $query_one = " SELECT * FROM `stickers`";
    if (!empty($after) && is_numeric($after) && $after > 0) {
        $query_one .= " WHERE `id` < " . Secure($after);
    }
    $query_one .= " ORDER BY `id` DESC";
    if (isset($limit) and !empty($limit)) {
        $query_one .= " LIMIT {$limit}";
    }
    $sql = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $data[]                  = $fetched_data;
    }

    return $data;
}
function Wo_GetAllGifts($limit = 5, $after = 0) {
    global $wo, $conn;
    $data      = array();
    $query_one = " SELECT * FROM `gifts`";
    if (!empty($after) && is_numeric($after) && $after > 0) {
        $query_one .= " WHERE `id` < " . Secure($after);
    }
    $query_one .= " ORDER BY `id` DESC";
    if (isset($limit) and !empty($limit)) {
        $query_one .= " LIMIT {$limit}";
    }
    $sql = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql)) {
        $data[]                  = $fetched_data;
    }
    return $data;
}
function Wo_DeleteGift($gift_id) {
    global $wo, $conn, $cache,$is_admin;
    if ($gift_id < 1 || empty($gift_id) || !is_numeric($gift_id)) {
        return false;
    }
    if ($wo['loggedin'] == false) {
        return false;
    }
//    if ($is_admin === false) {
//        return false;
//    }
    $gift_id      = Secure($gift_id);
    $query_delete = mysqli_query($conn, "DELETE FROM `gifts` WHERE `id` = {$gift_id}");
    $query_delete .= mysqli_query($conn, "DELETE FROM `user_gifts` WHERE `gift_id` = {$gift_id}");
    //$query_delete .= mysqli_query($conn, "DELETE FROM `notifications` WHERE `type` = 'gift_{$gift_id}'");
    if ($query_delete) {
        return true;
    } else {
        return false;
    }
}
function Wo_DeleteSticker($sticker_id) {
    global $wo, $conn, $cache,$is_admin;
    if ($sticker_id < 1 || empty($sticker_id) || !is_numeric($sticker_id)) {
        return false;
    }
    if ($wo['loggedin'] == false) {
        return false;
    }
//    if ($is_admin === false) {
//        return false;
//    }
    $sticker_id      = Secure($sticker_id);
    $query_delete = mysqli_query($conn, "DELETE FROM `stickers` WHERE `id` = {$sticker_id}");
    // $query_delete .= mysqli_query($sqlConnect, "DELETE FROM " . T_USERGIFTS . " WHERE `gift_id` = {$gift_id}");
    // $query_delete .= mysqli_query($sqlConnect, "DELETE FROM " . T_NOTIFICATION . " WHERE `type2` = 'gift_{$gift_id}'");
    if ($query_delete) {
        return true;
    } else {
        return false;
    }
}
function Wo_CreditsPaymentData() {
    global $wo, $conn;
    $type_table   = 'payments';
    $query_one    = mysqli_query($conn, "SELECT SUM(`amount`) as count FROM {$type_table} WHERE `type` = 'CREDITS' AND `amount` <> 0 AND YEAR(`date`) = '".date("Y")."' AND MONTH(`date`) = '".date('n')."'");
    $fetched_data = mysqli_fetch_assoc($query_one);
    return $fetched_data['count'];
}
function Wo_CountAllPayment() {
    global $wo, $conn;
    $type_table = 'payments';
    $query_one  = mysqli_query($conn, "SELECT `amount` FROM {$type_table}");
    $final_data = 0;
    while ($fetched_data = mysqli_fetch_assoc($query_one)) {
        $final_data += $fetched_data['amount'];
    }
    return $final_data;
}
function Wo_CountThisMonthPayment() {
    global $wo, $conn;
    $type_table = 'payments';
    $date       = date('n') . '/' . date("Y");
    $query_one  = mysqli_query($conn, "SELECT `amount` FROM {$type_table} WHERE `amount` <> 0 AND YEAR(`date`) = '".date("Y")."' AND MONTH(`date`) = '".date('n')."'");
    $final_data = 0;
    while ($fetched_data = mysqli_fetch_assoc($query_one)) {
        $final_data += $fetched_data['amount'];
    }
    return $final_data;
}
function Wo_GetRegisteredPaymentsStatics($month, $type = '') {
    global $wo, $conn;
    $year         = date("Y");
    $type_table   = 'payments';
    $query_one    = mysqli_query($conn, "SELECT COUNT(`id`) as count FROM {$type_table} WHERE YEAR(`date`) = '".$year."' AND MONTH(`date`) = '".$month."' AND `pro_plan` = '{$type}'");
    $fetched_data = mysqli_fetch_assoc($query_one);
    return $fetched_data['count'];
}
function Wo_LoadAdminPage($page_url = '',$admin = true) {
    global $wo,$db, $dir;
    $page = realpath(dirname(__FILE__)) . '/pages/' . $page_url . '.phtml';
    $page_content = '';
    ob_start();
    require($page);
    $page_content = ob_get_contents();
    ob_end_clean();
    return $page_content;
}
function Wo_LoadAdminLink($link = '') {
    global $config;
    return $config->uri . '/admin-panel/' . $link;
}
function Wo_CreateMainSession(){
    if( isset( $_SESSION['JWT'] ) ){
        return $_SESSION['JWT']->web_token;
    }else{
        return '';
    }
}
function Wo_UpdateSeenReports() {
    global $wo, $conn;
    $query_one = " UPDATE reports SET `seen` = 1 WHERE `seen` = 0";
    $sql       = mysqli_query($conn, $query_one);
    if ($sql) {
        return true;
    }
}
function Wo_CreateSession() {
    $hash = sha1(rand(1111, 9999));
    if (!empty($_SESSION['hash_id'])) {
        $_SESSION['hash_id'] = $_SESSION['hash_id'];
        return $_SESSION['hash_id'];
    }
    $_SESSION['hash_id'] = $hash;
    return $hash;
}
function Wo_CheckSession($hash = '') {
    if (!isset($_SESSION['hash_id']) || empty($_SESSION['hash_id'])) {
        return false;
    }
    if (empty($hash)) {
        return false;
    }
    if ($hash == $_SESSION['hash_id']) {
        return true;
    }
    return false;
}
function Wo_SaveConfig($update_name, $value) {
    global $config, $conn;
    if( !isset( $_SESSION['JWT'] ) ){
        return false;
    }
    if (!array_key_exists($update_name, (array)$config)) {
        return false;
    }
    $update_name = Secure($update_name);
    $value       = mysqli_real_escape_string($conn, $value);
    $query_one   = " UPDATE options SET `option_value` = '{$value}' WHERE `option_name` = '{$update_name}'";
    $query       = mysqli_query($conn, $query_one);
    if ($query) {
        return true;
    } else {
        return false;
    }
}
function Wo_LoadAdminLinkSettings($link = '') {
    global $config;
    return $config->uri . '/admin-cp/' . $link;
}
function Wo_GetScriptWarnings() {
    global $conn, $wo;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $results  = array();
    $results1 = array();
    $query    = mysqli_query($conn, "SELECT @@sql_mode as modes;");
    $sql_sql  = mysqli_fetch_assoc($query);
    if (count($sql_sql) > 0) {
        $results_sql = @explode(',', $sql_sql['modes']);
        if (in_array('STRICT_TRANS_TABLES', $results_sql)) {
            $results['STRICT_TRANS_TABLES'] = true;
        }
        if (in_array('STRICT_ALL_TABLES', $results_sql)) {
            $results['STRICT_ALL_TABLES'] = true;
        }
    }
    if (ini_get("safe_mode")) {
        $results['safe_mode'] = true;
    }
    if (!ini_get("allow_url_fopen")) {
        $results['allow_url_fopen'] = true;
    }
    if (file_exists("update.php")) {
        if (filemtime("update.php") > time() - 86400) {
            $results['update_file'] = true;
        }
    }
    return $results1[] = $results;
}
function Wo_CountUserData($type) {
    global $wo, $conn;
    $type_table = 'users';
    $type_id    = 'id';
    $where      = '';
    if ($type == 'male') {
        $where = "`gender` = 4525";
    } else if ($type == 'female') {
        $where = "`gender` = 4526";
    } else if ($type == 'active') {
        $where = "`active` = '1'";
    } else if ($type == 'not_active') {
        $where = "`active` <> '1'";
    }
    $query_one    = mysqli_query($conn, "SELECT COUNT($type_id) as count FROM {$type_table} WHERE {$where}");
    $fetched_data = mysqli_fetch_assoc($query_one);
    return $fetched_data['count'];
}
//function Wo_UserData($user_id){
//    global $wo, $conn, $cache;
//    if (empty($user_id) || !is_numeric($user_id) || $user_id < 0) {
//        return false;
//    }
//    $data           = array();
//    $user_id        = Secure($user_id);
//    $query_one      = "SELECT * FROM `users` WHERE `id` = {$user_id}";
//    $sql          = mysqli_query($conn, $query_one);
//    $fetched_data = mysqli_fetch_assoc($sql);
//    if (empty($fetched_data)) {
//        return array();
//    }
//    return $fetched_data;
//}
function Wo_GetCustomPages() {
    global $conn;
    $data          = array();
    $query_one     = "SELECT * FROM `custom_pages` ORDER BY `id` DESC";
    $sql_query_one = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql_query_one)) {
        $data[] = Wo_GetCustomPage($fetched_data['page_name']);
    }
    return $data;
}
function Wo_GetSuccessStories() {
    global $conn;
    $data          = array();
    $query_one     = "SELECT * FROM `success_stories` ORDER BY `id` DESC";
    $sql_query_one = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql_query_one)) {
        $data[] = Wo_GetSuccessStory($fetched_data['id']);
    }
    return $data;
}
function Wo_GetBlogArticles() {
    global $conn;
    $data          = array();
    $query_one     = "SELECT * FROM `blog` ORDER BY `id` DESC";
    $sql_query_one = mysqli_query($conn, $query_one);
    while ($fetched_data = mysqli_fetch_assoc($sql_query_one)) {
        $data[] = Wo_GetArticle($fetched_data['id']);
    }
    return $data;
}
function Wo_GetArticle($page_name) {
    global $conn;
    if (empty($page_name)) {
        return false;
    }
    $data          = array();
    $page_name     = Secure($page_name);
    $query_one     = "SELECT * FROM `blog` WHERE `id` = '{$page_name}'";
    $sql_query_one = mysqli_query($conn, $query_one);
    $fetched_data  = mysqli_fetch_assoc($sql_query_one);
    return $fetched_data;
}
function Wo_GetSuccessStory($page_name) {
    global $conn;
    if (empty($page_name)) {
        return false;
    }
    $data          = array();
    $page_name     = Secure($page_name);
    $query_one     = "SELECT * FROM `success_stories` WHERE `id` = '{$page_name}'";
    $sql_query_one = mysqli_query($conn, $query_one);
    $fetched_data  = mysqli_fetch_assoc($sql_query_one);
    return $fetched_data;
}
function Wo_GetCustomPage($page_name) {
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
function Wo_RegisterNewPage($registration_data) {
    global $wo, $conn;
    if (empty($registration_data)) {
        return false;
    }
    $fields = '`' . implode('`, `', array_keys($registration_data)) . '`';
    $data   = '\'' . implode('\', \'', $registration_data) . '\'';
    $query  = mysqli_query($conn, "INSERT INTO `custom_pages` ({$fields}) VALUES ({$data})");
    if ($query) {
        return true;
    }
    return false;
}
function Wo_RegisterNewBlogPost($registration_data) {
    global $wo, $conn;
    if (empty($registration_data)) {
        return false;
    }
    $fields = '`' . implode('`, `', array_keys($registration_data)) . '`';
    $data   = '\'' . implode('\', \'', $registration_data) . '\'';
    $query  = mysqli_query($conn, "INSERT INTO `blog` ({$fields}) VALUES ({$data})");
    if ($query) {
        return true;
    }
    return false;
}
function Wo_DeleteCustomPage($id) {
    global $wo, $conn;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $id    = Secure($id);
    $query = mysqli_query($conn, "DELETE FROM `custom_pages` WHERE `id` = {$id}");
    if ($query) {
        return true;
    }
    return false;
}
function Wo_Deletesuccess_stories($id) {
    global $wo, $conn;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $id    = Secure($id);
    $query = mysqli_query($conn, "DELETE FROM `success_stories` WHERE `id` = {$id}");
    if ($query) {
        return true;
    }
    return false;
}
function Wo_DeleteArticle($id, $thumbnail) {
    global $wo, $conn;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $id    = Secure($id);
    $query = mysqli_query($conn, "DELETE FROM `blog` WHERE `id` = {$id}");
    if ($query) {
        DeleteFromToS3( $thumbnail );
        return true;
    }
    return false;
}
function Wo_Approvesuccess_stories($id) {
    global $wo, $conn;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $id    = Secure($id);
    $query = mysqli_query($conn, "UPDATE `success_stories` SET `status` = 1 WHERE `id` = {$id}");
    if ($query) {
        return true;
    }
    return false;
}
function Wo_DisApprovesuccess_stories($id) {
    global $wo, $conn;
    if ($wo['loggedin'] == false) {
        return false;
    }
    $id    = Secure($id);
    $query = mysqli_query($conn, "UPDATE `success_stories` SET `status` = 0 WHERE `id` = {$id}");
    if ($query) {
        return true;
    }
    return false;
}
function Wo_UpdateCustomPageData($id, $update_data) {
    global $wo, $conn, $cache;
    if ($wo['loggedin'] == false) {
        return false;
    }
    if (empty($id) || !is_numeric($id) || $id < 0) {
        return false;
    }
    if (empty($update_data)) {
        return false;
    }
    $id = Secure($id);
    $update = array();
    foreach ($update_data as $field => $data) {
        $update[] = '`' . $field . '` = \'' . Secure($data, 0) . '\'';
    }
    $impload   = implode(', ', $update);
    $query_one = "UPDATE `custom_pages` SET {$impload} WHERE `id` = {$id} ";
    $query     = mysqli_query($conn, $query_one);
    if ($query) {
        return true;
    }
    return false;
}



