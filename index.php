<?php
require_once realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'bootstrap.php';
$console_log = array();
$url_action   = (empty(route(1))) ? 'index' : str_replace('-', '', route(1));
$public_pages = array(
	'login',
	'register',
	'about',
	'contact',
	'forgot',
	'mail-otp',
	'privacy',
	'terms',
	'reset',
	'profile',
	'aj',
	'worker',
    'page',
    'article',
    'unusual-login',
    'blog'
);
$active_user = auth();
$config->nextmode_text = __('Night mode');
$config->is_rtl = false;
if(GetActiveLang() == 'arabic'){
    $config->is_rtl = true;
}

if (!isset($_COOKIE['activeLang'])) {
    setcookie("activeLang", $config->default_language, time() + (10 * 365 * 24 * 60 * 60), '/');
}

// night mode
if (empty($_COOKIE['mode'])) {

    if (!empty($config->displaymode)) {
        if ($config->displaymode == 'day') {
            setcookie("mode", 'day', time() + (10 * 365 * 24 * 60 * 60), '/');
            $_COOKIE['mode'] = 'day';
            $config->displaymode = 'day';
            $config->nextmode = 'night';
            $config->nextmode_text = __('Night mode');
        } else if ($config->displaymode == 'night') {
            setcookie("mode", 'night', time() + (10 * 365 * 24 * 60 * 60), '/');
            $_COOKIE['mode'] = 'night';
            $config->displaymode = 'night';
            $config->nextmode = 'day';
            $config->nextmode_text = __('Day mode');
        }
    }

} else {
    if ($_COOKIE['mode'] == 'day') {
        $config->displaymode = 'day';
        $config->nextmode = 'night';
        $config->nextmode_text = __('Night mode');
    }
    if ($_COOKIE['mode'] == 'night') {
        $config->displaymode = 'night';
        $config->nextmode = 'day';
        $config->nextmode_text = __('Day mode');
    }
}

if (!empty($_GET['mode'])) {
    if ($_GET['mode'] == 'day') {
        setcookie("mode", 'day', time() + (10 * 365 * 24 * 60 * 60), '/');
        $_COOKIE['mode'] = 'day';
        $config->displaymode = 'day';
        $config->nextmode = 'night';
        $config->nextmode_text = __('Night mode');
    } else if ($_GET['mode'] == 'night') {
        setcookie("mode", 'night', time() + (10 * 365 * 24 * 60 * 60), '/');
        $_COOKIE['mode'] = 'night';
        $config->displaymode = 'night';
        $config->nextmode = 'day';
        $config->nextmode_text = __('Day mode');
    }
}

$default_logo = $_BASEPATH . 'themes' . $_DS . $config->theme  . $_DS . 'assets' . $_DS . 'img' . $_DS . 'logo.png';
$light_logo = $_BASEPATH . 'themes' . $_DS . $config->theme . $_DS . 'assets' . $_DS . 'img' . $_DS . 'logo-light.png';

$config->sitelogo = $config->uri . '/themes/' . $config->theme . '/assets/img/logo.png';
if( file_exists($light_logo) ){
    if( $config->displaymode == 'night' ) {
        $config->sitelogo = $config->uri . '/themes/' . $config->theme . '/assets/img/logo-light.png';
    }
}


if(IS_LOGGED === true){

}else{
    logout(false);
}
if( !isset( $_COOKIE['JWT'] ) ) {
    logout(false);
}else{
    $u = $db->objectBuilder()->where('id',GetUserFromSessionID($_COOKIE['JWT']))->get('users',1,array('web_token','start_up','active','web_token_created_at','verified'));
    if( !empty($u)) {
        $_SESSION['JWT'] = $u[0];
    }
    $_SESSION['user_id'] = $_COOKIE['JWT'];
}

if( isset($_COOKIE['JWT']) && isset( $_SESSION['user_id'] ) ){
    if( $_COOKIE['JWT'] !== $_SESSION['user_id'] ){
        logout();
    }
}

if( $url_action == 'admincp' ){
    require 'admin-panel/autoload.php';
    exit();
}

$baned_ips = Wo_GetBanned('user');
if (in_array($_SERVER["REMOTE_ADDR"], $baned_ips)) {
    exit();
}

if( $url_action == 'Useractions' && route(2) == 'login' ){
    header("Location: ./");
    exit();
}

$maintenance_mode = false;
if ( $config->maintenance_mode == 1 ) {
    if ( IS_LOGGED === false ) {
        $maintenance_mode = true;
        //http://localhost/quickdatescript.com/?access=admin
        if(isset($_GET['access']) && $_GET['access'] == 'admin'){
            $maintenance_mode = false;
        }
    } else {
        if($active_user) {
            if ($active_user->admin === "0") {
                $maintenance_mode = true;
            }
        }
    }
    if( $maintenance_mode === true ){
        $maintenance_contoller_file       = $_CONTROLLERS . 'maintenance.php';
        if (file_exists($maintenance_contoller_file)) {
            require_once $maintenance_contoller_file;
            Maintenance::show();
            exit();
        }

    }
}


if (!empty($_GET['ref']) && IS_LOGGED == false && !isset($_COOKIE['src'])) {
    $get_ip = get_ip_address();
    if (!isset($_SESSION['ref']) && !empty($get_ip)) {
        $_GET['ref'] = Secure($_GET['ref']);
        $ref_user_id = UserIdFromUsername($_GET['ref']);
        $user_date = Wo_UserData($ref_user_id);
        if (!empty($user_date)) {
            if (ip_in_range($user_date['ip_address'], '/24') === false && $user_date['ip_address'] != $get_ip) {
                $_SESSION['ref'] = $user_date['username'];
                @setcookie('ref', $user_date['username'], time() + 31556926, '/');
            }
        }
    }
}
if (!isset($_COOKIE['src'])) {
    @setcookie('src', '1', time() + 31556926, '/');
}

$contoller_file       = $_CONTROLLERS . strtolower($url_action) . '.php';
if (file_exists($contoller_file)) {
    require_once $contoller_file;
}

if (IS_LOGGED === true) {
    if ($url_action == 'register' || $url_action == 'forgot' || $url_action == 'reset') {
        header("Location: ./");
        exit();
    }
}

$contoller_index_file = $_CONTROLLERS . 'findmatches.php';

if (isset($_SESSION['JWT']) && !empty($_SESSION['JWT'])) {

    if(strpos($_SERVER["REQUEST_URI"],'/aj/') === false) {
        $stop = false;
        if( $config->image_verification == 1 && $config->pending_verification == 1 && $active_user->approved_at == 0 ){
            $stop = true;
        }
        if ($active_user->start_up == "0" || $active_user->start_up == "1" ) {
            $stop = true;
        }
        //TODO::
        if( $config->image_verification == 1 ){
            if( (int)$config->image_verification_start < (int)$active_user->registered && $active_user->approved_at > 0){
                $stop = false;
            // }else{
            //     $stop = true;
            }
        }
        //TODO::
        if ($active_user->admin == "1" || ($active_user->start_up == "3" && $active_user->admin == "0")) {
            $stop = false;
        }
        if( $stop ){
            $contoller_userverify_file = $_CONTROLLERS . 'steps.php';
            if (file_exists($contoller_userverify_file)) {
                if (!class_exists('Steps', false)) {
                    require_once $contoller_userverify_file;
                }
                Steps::show();
                exit();
            }
        }
    }

    if ($active_user->verified == 0) {
        if (route(1) == 'verifymail' || route(1) == 'verifymailotp' || route(1) == 'verifyphone' || route(1) == 'verifyphoneotp' || route(1) == 'aj') {
            call_user_func(array(
                ucfirst($url_action),
                'show'
            ));
        } else {
            if( $config->emailValidation == "1" ) {
                $contoller_userverify_file = $_CONTROLLERS . 'steps.php';
                if (file_exists($contoller_userverify_file)) {
                    if (!class_exists('Steps', false)) {
                        require_once $contoller_userverify_file;
                    }
                    Steps::show();
                }
            }
        }
    }

    // if (route(1) == '') {
    //     $contoller_index_file = $_CONTROLLERS . 'findmatches.php';
    //     if (file_exists($contoller_index_file)) {
    //         if( !class_exists('FindMatches',false) ){
    //             require_once $contoller_index_file;
    //         }
    //         FindMatches::show();
    //     }

    if (route(1) === NULL) {
        header('Location: ' . $config->uri . '/find-matches');
        exit();
    } else {

        if( substr($url_action, 0, 1) == '@' ){
            $username = strtolower(substr($url_action, 1));


            if( strtolower($active_user->username) == $username ){
                $contoller_myprofile_file = $_CONTROLLERS . 'myprofile.php';
                if (file_exists($contoller_myprofile_file)) {
                    if( !class_exists('Myprofile',false) ){
                        require_once $contoller_myprofile_file;
                    }
                    Myprofile::show();
                }
            }else{
                $_user = LoadEndPointResource('users');
                $user = $_user->isUsernameExists($username);
                if( isset( $user['id'] ) && $user['id'] > 0 ){


                    if(isUserInBlockList(strtolower($username)) === false) {
//                        if( $user->verified !== "1" ) {
//                            header('Location: ' . $config->uri);
//                            exit();
//                        }

                        $contoller_profile_file = $_CONTROLLERS . 'profile.php';
                        if (file_exists($contoller_profile_file)) {
                            if( !class_exists('Profile',false) ){
                                require_once $contoller_profile_file;
                            }
                            Profile::show();
                        }
                    }else{


                        if(strpos($_SERVER["REQUEST_URI"],'/aj/') === false) {
                            header('Location: ' . $config->uri);
                        }else{
                            echo "<script>window.location.href = window.site_url;</script>";
                        }
                        exit();
                    }

                }else{
                    header('Location: ' . $config->uri);
                    exit();
                }
            }

            exit();
        }
        if (ctype_alpha($url_action)) {
            if (is_callable(array(
                ucfirst($url_action),
                'show'
            ))) {
                call_user_func(array(
                    ucfirst($url_action),
                    'show'
                ));
            } else {
                header('Location: ' . $config->uri);
                exit();
            }
        } else {
            header('Location: ' . $config->uri);
            exit();
        }
    }

}else{

    if (ctype_alpha($url_action)) {
		if (in_array(route(1), $public_pages)) {
			if (is_callable(array(
				ucfirst($url_action),
				'show'
			))) {
				call_user_func(array(
					ucfirst($url_action),
					'show'
				));
			} else {
				header('Location: ' . $config->uri);
				exit();
			}
		} else {
            $contoller_home_file  = $_CONTROLLERS . 'index.php';
            if (file_exists($contoller_home_file)) {
				if( !class_exists('Index',false) ){
                    require_once $contoller_home_file;
				}
                Index::show();
            }
		}
	} else {
        if( $config->show_user_on_homepage == '1'){
            if( substr($url_action, 0, 1) == '@' ) {
                $username = strtolower(substr($url_action, 1));
                $_user = LoadEndPointResource('users');
                $user = $_user->isUsernameExists($username);
                if( isset( $user['id'] ) && $user['id'] > 0 ){


                    if(isUserInBlockList(strtolower($username)) === false) {
//                        if( $user->verified !== "1" ) {
//                            header('Location: ' . $config->uri);
//                            exit();
//                        }

                        $contoller_profile_file = $_CONTROLLERS . 'profile.php';
                        if (file_exists($contoller_profile_file)) {
                            if( !class_exists('Profile',false) ){
                                require_once $contoller_profile_file;
                            }
                            Profile::show();
                        }
                    }else{


                        if(strpos($_SERVER["REQUEST_URI"],'/aj/') === false) {
                            header('Location: ' . $config->uri);
                        }else{
                            echo "<script>window.location.href = window.site_url;</script>";
                        }
                        exit();
                    }

                }else{
                    header('Location: ' . $config->uri);
                    exit();
                }
            }
        }else {
            header('Location: ' . $config->uri);
            exit();
        }
	}
}


$config = null;
$lang = null;
mysqli_close($conn);
$db = null;
$conn = null;