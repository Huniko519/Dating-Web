<?php
require realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'bootstrap.php';

if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    throw new Exception('Hybridauth 3 requires PHP version 5.4 or higher.');
}
require_once $_LIBS . 'hybridauth' . $_DS . 'Data' . $_DS . 'Collection.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Data' . $_DS . 'Parser.php';


require_once $_LIBS . 'hybridauth' . $_DS . 'Adapter' . $_DS . 'AdapterInterface.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Adapter' . $_DS . 'DataStoreTrait.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Adapter' . $_DS . 'AbstractAdapter.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Adapter' . $_DS . 'OAuth1.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Adapter' . $_DS . 'OAuth2.php';

require_once $_LIBS . 'hybridauth' . $_DS . 'Exception' . $_DS . 'ExceptionInterface.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Exception' . $_DS . 'Exception.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Exception' . $_DS . 'RuntimeException.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Exception' . $_DS . 'InvalidArgumentException.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Exception' . $_DS . 'UnexpectedValueException.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Exception' . $_DS . 'HttpRequestFailedException.php';


require_once $_LIBS . 'hybridauth' . $_DS . 'Storage' . $_DS . 'StorageInterface.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Storage' . $_DS . 'Session.php';

require_once $_LIBS . 'hybridauth' . $_DS . 'Logger' . $_DS . 'LoggerInterface.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Logger' . $_DS . 'Logger.php';

require_once $_LIBS . 'hybridauth' . $_DS . 'Thirdparty' . $_DS . 'OAuth' . $_DS . 'OAuthUtil.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Thirdparty' . $_DS . 'OAuth' . $_DS . 'OAuthRequest.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Thirdparty' . $_DS . 'OAuth' . $_DS . 'OAuthConsumer.php';

require_once $_LIBS . 'hybridauth' . $_DS . 'Thirdparty' . $_DS . 'OAuth' . $_DS . 'OAuthSignatureMethod.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Thirdparty' . $_DS . 'OAuth' . $_DS . 'OAuthSignatureMethodHMACSHA1.php';



require_once $_LIBS . 'hybridauth' . $_DS . 'HttpClient' . $_DS . 'HttpClientInterface.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'HttpClient' . $_DS . 'Curl.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'HttpClient' . $_DS . 'Util.php';

require_once $_LIBS . 'hybridauth' . $_DS . 'User' . $_DS . 'Profile.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'User' . $_DS . 'Activity.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'User' . $_DS . 'Contact.php';

require_once $_LIBS . 'hybridauth' . $_DS . 'Provider' . $_DS . 'Facebook.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Provider' . $_DS . 'Google.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Provider' . $_DS . 'Twitter.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Provider' . $_DS . 'LinkedIn.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Provider' . $_DS . 'Vkontakte.php';
require_once $_LIBS . 'hybridauth' . $_DS . 'Provider' . $_DS . 'Instagram.php';


require_once $_LIBS . 'hybridauth' . $_DS . 'Hybridauth.php';

use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;

$user = LoadEndPointResource('users');
if( $user ){
    $uri = $config->uri;
    if (substr($uri, -1) == '/') {
        $uri = substr($uri, 0, -1);
    }
    $provider = '';
    if (isset($_GET['provider'])) {
        $provider = Secure($_GET['provider']);
    }
    $LoginWithConfig = array(
        'callback' => $uri . '/social-login.php?provider=' . $provider,
        'providers' => array(
            'Google' => array(
                'enabled' => true,
                'keys' => array(
                    'id' => $config->googleAppId,
                    'secret' => $config->googleAppKey
                )
            ),
            'Facebook' => array(
                'enabled' => true,
                'keys' => array(
                    'id' => $config->facebookAppId,
                    'secret' => $config->facebookAppKey
                ),
                'scope' => 'email',
                'trustForwarded' => false
            ),
            'Twitter' => array(
                'enabled' => true,
                'keys' => array(
                    'key' => $config->twitterAppId,
                    'secret' => $config->twitterAppKey
                ),
                'includeEmail' => true
            ),
            'LinkedIn' => array(
                'enabled' => true,
                'keys' => array(
                    'key' => $config->linkedinAppId,
                    'secret' => $config->linkedinAppKey
                )
            ),
            'Vkontakte' => array(
                'enabled' => true,
                'keys' => array(
                    'id' => $config->VkontakteAppId,
                    'secret' => $config->VkontakteAppKey
                )
            ),
            'Instagram' => array(
                'enabled' => true,
                'keys' => array(
                    'id' => $config->instagramAppId,
                    'secret' => $config->instagramAppkey
                )
            )
        )
    );

    $provider = '';
    $types    = array(
        'Google',
        'Facebook',
        'Twitter',
        'LinkedIn',
        'Vkontakte',
        'Instagram'
    );
    if (isset($_GET['provider']) && in_array($_GET['provider'], $types)) {
        $provider = Secure($_GET['provider']);
    }
    if (isset($_GET['provider']) && in_array($_GET['provider'], $types)) {
        try {
            $hybridauth = new Hybridauth( $LoginWithConfig );
            $authProvider = $hybridauth->authenticate($provider);
            $tokens = $authProvider->getAccessToken();
            $user_profile = $authProvider->getUserProfile();
            if ($user_profile && isset($user_profile->identifier)) {
                $name = $user_profile->firstName;
                if ($provider == 'Google') {
                    $notfound_email     = 'go_';
                    $notfound_email_com = '@google.com';
                } else if ($provider == 'Facebook') {
                    $notfound_email     = 'fa_';
                    $notfound_email_com = '@facebook.com';
                } else if ($provider == 'Twitter') {
                    $notfound_email     = 'tw_';
                    $notfound_email_com = '@twitter.com';
                } else if ($provider == 'LinkedIn') {
                    $notfound_email     = 'li_';
                    $notfound_email_com = '@linkedIn.com';
                } else if ($provider == 'Vkontakte') {
                    $notfound_email     = 'vk_';
                    $notfound_email_com = '@vk.com';
                } else if ($provider == 'Instagram') {
                    $notfound_email     = 'in_';
                    $notfound_email_com = '@instagram.com';
                    $name               = $user_profile->displayName;
                }
                $user_name  = $notfound_email . $user_profile->identifier;
                $user_email = $user_name . $notfound_email_com;
                if (!empty($user_profile->email)) {
                    $user_email = $user_profile->email;
                }
                if (Wo_IsBanned($user_profile->identifier)) {
                    header('Location: ' . $config->uri);
                    exit();
                }
                if ($user->isEmailExists($user_email)) {
                    $user->SetLoginWithSession($user_email);
                    header('Location: ' . $config->uri);
                    exit();
                } else {
                    $str            = md5(microtime());
                    $id             = substr($str, 0, 9);
                    $user_uniq_id   = ($user->isUsernameExists($id) === false) ? $id : 'u_' . $id;
                    $social_url     = substr($user_profile->profileURL, strrpos($user_profile->profileURL, '/') + 1);
                    $imported_image = $user->ImportImageFromLogin($user_profile->photoURL, 1);
                    if (empty($imported_image)) {
                        $imported_image = $config->userDefaultAvatar;
                    }
                    $about      = Secure($user_profile->description);
                    $birthDay   = Secure($user_profile->birthDay);
                    $webSiteURL = Secure($user_profile->webSiteURL);
                    $phone      = Secure($user_profile->phone);
                    $password   = rand(111111, 999999);
                    $password_hash   = password_hash($password, PASSWORD_DEFAULT, array('cost' => 11));
                    $re_data    = array(
                        'username' => Secure($user_uniq_id, 0),
                        'email' => Secure($user_email, 0),
                        'password' => Secure($password_hash, 0),
                        'first_name' => Secure($name),
                        'last_name' => Secure($user_profile->lastName),
                        'avater' => Secure($imported_image),
                        'src' => Secure($provider),
                        'start_up' => 0,
                        'lastseen' => time(),
                        'social_login' => 1,
                        'about' => $about,
                        'birthday' => $birthDay,
                        'website' => $webSiteURL,
                        'phone_number' => $phone,
                        'active' => '1'
                    );
                    if ($provider == 'Google') {
                        $re_data['about']  = Secure($user_profile->description);
                        $re_data['google'] = Secure($social_url);
                    }
                    if ($provider == 'Facebook') {
                        $fa_social_url       = @explode('/', $user_profile->profileURL);
                        $re_data['facebook'] = Secure($fa_social_url[sizeof($fa_social_url) - 1]);
                        $re_data['gender']   = '0';
                        if (!empty($user_profile->gender)) {
                            if ($user_profile->gender == 'male') {
                                $re_data['gender'] = '0';
                            } else if ($user_profile->gender == 'female') {
                                $re_data['gender'] = '1';
                            }
                        }
                    }
                    if ($provider == 'Twitter') {
                        $re_data['twitter'] = Secure($social_url);
                    }
                    if ($provider == 'LinkedIn') {
                        $re_data['about']    = Secure($user_profile->description);
                        $re_data['linkedIn'] = Secure($social_url);
                    }
                    if ($provider == 'Instagram') {
                        $re_data['instagram'] = Secure($user_profile->username);
                    }
                    $regestered_user = $user->register($re_data);
                    if ($regestered_user['code'] == 200) {
                        $user->SetLoginWithSession($user_email);
                        $user_id = $regestered_user['userId'];
                        if (!empty($user_profile->photoURL) && $imported_image != $config->userDefaultAvatar) {
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
//                        $body = Emails::parse('social-login', array(
//                            'first_name' => Secure($user_profile->lastName),
//                            'username' => $re_data['username'],
//                            'password' => $password
//                        ));
//                        SendEmail($re_data['email'], $config->site_name . ' ' . __('Thank you for your registration.'), $body);
                        header('Location: ' . $config->uri . '/steps');
                        exit();
                    }
                }
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
            echo ' <b><a href="' . $config->uri . '">Try again<a></b>';
        }
    } else {
        header('Location: ' . $config->uri);
        exit();
    }
}else{
    header('Location: ' . $config->uri);
    exit();
}