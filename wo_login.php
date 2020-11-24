<?php
require realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'bootstrap.php';
$uri = $config->uri;
if (substr($uri, -1) == '/') {
    $uri = substr($uri, 0, -1);
}

global $db;
if (isset($_GET['code']) && !empty($_GET['code'])) {
    $app_id        = $config->wowonder_app_ID;
    $app_secret    = $config->wowonder_app_key;
    $wowonder_url  = $config->wowonder_domain_uri;
    $code          = Secure($_GET['code']);
    $url           = $wowonder_url . "/authorize?app_id={$app_id}&app_secret={$app_secret}&code={$code}";
    $get           = file_get_contents($url);
    $wo_json_reply = json_decode($get, true);
    $access_token  = '';
    if (is_array($wo_json_reply) && isset($wo_json_reply['access_token'])) {
        $access_token    = $wo_json_reply['access_token'];
        $type            = "get_user_data";
        $url             = $wowonder_url . "/api_request?access_token={$access_token}&type={$type}";
        $user_data_json  = file_get_contents($url);
        $user_data_array = json_decode($user_data_json, true);

        if (is_array($user_data_array) && !empty($user_data_array) && isset($user_data_array['user_data'])) {
            $user_data  = $user_data_array['user_data'];
            $user_email = $user_data['email'];

            $user = LoadEndPointResource('users');
            if( $user ){

                $dbEmail = $user->isEmailExists($user_email);
                $emailExist = false;
                if(isset($dbEmail['email']) && $dbEmail['email'] == $user_email){
                    $emailExist = true;
                }

                if ($emailExist) {

                    $user->SetLoginWithSession($user_email);
                    header('Location: ' . $uri);
                    exit();

                } else {

                    if (!empty($user_data['avatar'])) {
                        $imported_image = $user->ImportImageFromLogin($user_data['avatar'], 1);
                    }
                    if (empty($imported_image)) {
                        $imported_image = $config->userDefaultAvatar;
                    }
                    $str            = md5(microtime());
                    $id             = substr($str, 0, 9);
                    $user_uniq_id   = ($user->isUsernameExists($id) === false) ? $id : 'u_' . $id;
                    $password   = rand(111111, 999999);
                    $password_hash   = password_hash($password, PASSWORD_DEFAULT, array('cost' => 11));
                    $gender       = (isset($user_data['gender'])) ? Secure($user_data['gender'], 0) : 'male';
                    if($gender == 'male'){
                        $gender = 0;
                    }else{
                        $gender = 1;
                    }
                    $re_data    = array(
                        'username' => Secure($user_uniq_id, 0),
                        'email' => Secure($user_email, 0),
                        'password' => Secure($password_hash, 0),
                        'first_name' => (isset($user_data['first_name'])) ? Secure($user_data['first_name'], 0) : '',
                        'last_name' => (isset($user_data['last_name'])) ? Secure($user_data['last_name'], 0) : '',
                        'avater' => $imported_image,
                        'src' => 'wowonder',
                        'start_up' => 0,
                        'lastseen' => time(),
                        'gender' => $gender,
                        'social_login' => 1,
                        'active' => '1',
                        'verified' => '1',
                        'language' => 'english'
                    );
                    $regestered_user = $user->register($re_data);
                    if ($regestered_user['code'] == 200) {
                        $user->SetLoginWithSession($user_email);
                        $user_id = $regestered_user['userId'];
                        if (!empty($user_data['avatar']) && $imported_image != $config->userDefaultAvatar) {
                            $explode2  = @end(explode('.', $imported_image));
                            $explode3  = @explode('.', $imported_image);
                            $last_file = $explode3[0] . '_full.' . $explode2;
                            $compress  = CompressImage($imported_image, $last_file, 50);
                            if ($compress) {
                                $upload_s3 = UploadToS3($last_file);
                                Resize_Crop_Image($config->profile_picture_width_crop, $config->profile_picture_height_crop, $imported_image, $imported_image, $config->profile_picture_image_quality);
                                $upload_s3 = UploadToS3($imported_image);
                            }
                        }
                        $body = Emails::parse('social-login', array(
                            'first_name' => $re_data['first_name'] . ' ' . $re_data['last_name'],
                            'username' => $re_data['username'],
                            'password' => $password
                        ));
                        SendEmail($re_data['email'], $config->site_name . ' ' . __('Thank you for your registration.'), $body);
                        header('Location: ' . $uri . '/steps');
                        exit();
                    } else { var_dump($regestered_user); }

                }
            }else{
                var_dump($user);
            }


        }else{
            echo 'else';
            var_dump($user_data_array);
        }

    } else {
        echo __('Error found, please try again later.') . "<a href='" . $uri . "'>".__('Return back')."</a>";
    }
} else {
    echo "<a href='" . $uri . "'>".__('Return back')."</a>";
}
?>