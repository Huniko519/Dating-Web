<?php
$dir = str_replace('admin-panel', '', dirname(__FILE__));
require_once($dir . '/bootstrap.php');

include 'function.php';

$page  = 'dashboard';

$pages = array('manage-stickers',
    'manage-gifts',
    'add-new-gift',
    'add-new-sticker',
    'manage-photos',
    'general-settings',
    'dashboard',
    'site-settings',
    'dashboard',
    'site-features',
    'amazon-settings',
    'email-settings',
    'social-login',
    'chat-settings',
    'manage-languages',
    'add-language',
    'edit-lang',
    'manage-users',
    'manage-payments',
    'manage-profile-fields',
    'add-new-profile-field',
    'edit-profile-field',
    'manage-verification-reqeusts',
    'payment-reqeuests',
    'affiliates-settings',
    'referrals-list',
    'pro-memebers',
    'pro-settings',
    'payments',
    'payment-settings',
    'manage-pages',
    'manage-groups',
    'manage-posts',
    'manage-articles',
    'manage-events',
    'manage-forum-sections',
    'manage-forum-forums',
    'manage-forum-threads',
    'manage-forum-messages',
    'create-new-section',
    'create-new-forum',
    'manage-movies',
    'add-new-movies',
    'manage-games',
    'add-new-game',
    'ads-settings',
    'manage-site-ads',
    'manage-user-ads',
    'manage-site-design',
    'manage-announcements',
    'mailing-list',
    'mass-notifications',
    'ban-users',
    'generate-sitemap',
    'manage-invitation-keys',
    'backups',
    'manage-custom-pages',
    'add-new-custom-page',
    'edit-custom-page',
    'edit-terms-pages',
    'manage-reports',
    'push-notifications-system',
    'manage-api-access-keys',
    'verfiy-applications',
    'manage-updates',
    'changelog',
    'online-users',
    'custom-code',
    'manage-third-psites',
    'edit-movie',
    'auto-delete',
    'manage-themes',
    'change-site-desgin',
    'custom-design',
    'fake-users',
    'manage-announcements',
    'manage-genders',
    'add-genders',
    'edit-genders',
    'bank-receipts',
    'video-settings',
    'manage-website-ads',

    'manage-success-stories',
    'add-success-stories',
    'edit-success-stories',

    'add-new-article',
    'edit-new-article',
    'manage-blog-categories',
    'edit-article',
    'edit-blog-category',

    'manage-user-verification',
    'push-notifications-system',
    'edit-user-permissions',

    'affiliates-settings',
    'payment-requests',
    'referrals-list',
    'mock-email',

    'pages-seo',

    'manage-countries',
    'add-countries',
    'edit-countries',

    'manage-verification-requests',
);

$mod_pages = array('dashboard', 'manage-users', 'online-users', 'manage-stories', 'manage-pages', 'manage-groups', 'manage-posts', 'manage-articles', 'manage-events', 'manage-forum-threads', 'manage-forum-messages', 'manage-movies', 'manage-games', 'add-new-game', 'manage-user-ads', 'manage-reports', 'manage-third-psites', 'edit-movie');
if (!empty($_GET['path'])) {
    $_GET['page'] = str_replace('/admin-panel/', '', $_GET['path']);
    $_GET['page'] = str_replace('/admin-cp/', '', $_GET['page']);
}
$_GET['page'] = str_replace('admin-cp/', '', $_GET['page']);
if (!empty($_GET['page'])) {
    $page = Secure($_GET['page'], 0);
}
if ($_GET['page'] == '/admin-cp' || $_GET['page'] == 'admin-cp') {
   $page = 'dashboard';
}
if ($page == 'dashboard') {
   //Wo_GetOfflineTyping();
   //Wo_DelexpiredEnvents();
}

if ($is_admin == false) {
    $authorized = false;
    if( $page == 'edit-user-permissions' ){
        if( CheckUserPermission($current_user_id, 'manage-users') === true ){
            $authorized = true;
        }
    }
    if( $page == 'add-genders' || $page == 'edit-genders' ){
        if( CheckUserPermission($current_user_id, 'manage-genders') === true ){
            $authorized = true;
        }
    }
    if( $page == 'add-countries' || $page == 'edit-countries' ){
        if( CheckUserPermission($current_user_id, 'manage-countries') === true ){
            $authorized = true;
        }
    }
    if( $page == 'manage-verification-requests'  ){
        if( CheckUserPermission($current_user_id, 'manage-verification-requests') === true ){
            $authorized = true;
        }
    }
    if( $page == 'edit-profile-field' || $page == 'add-new-profile-field' ){
        if( CheckUserPermission($current_user_id, 'manage-profile-fields') === true ){
            $authorized = true;
        }
    }
    if( $page == 'add-success-stories' || $page == 'edit-success-stories' ){
        if( CheckUserPermission($current_user_id, 'manage-success-stories') === true ){
            $authorized = true;
        }
    }
    if( $page == 'add-new-sticker' ){
        if( CheckUserPermission($current_user_id, 'manage-stickers') === true ){
            $authorized = true;
        }
    }
    if( $page == 'edit-article' ){
        if( CheckUserPermission($current_user_id, 'manage-articles') === true ){
            $authorized = true;
        }
    }
    if( $page == 'edit-lang' ){
        if( CheckUserPermission($current_user_id, 'manage-languages') === true ){
            $authorized = true;
        }
    }
    if( $page == 'edit-custom-page' || $page == 'add-new-custom-page' ){
        if( CheckUserPermission($current_user_id, 'manage-custom-pages') === true ){
            $authorized = true;
        }
    }

    if( CheckUserPermission($current_user_id, $page) === false && $page !== 'dashboard' && $authorized === false ){
        header("Location: " . $wo['site_url']);
        exit();
    }
//    if (!in_array($page, $mod_pages)) {
//        header("Location: " . $wo['site_url']);
//        exit();
//    }
}


$page_loaded = '';
if( $page == 'requests.php' ){
    require 'requests.php';
}
if (in_array($page, $pages)) {
    $page_loaded = Wo_LoadAdminPage("$page/content");
}
if (empty($page_loaded)) {
    global $wo;
    header("Location: " . $wo['site_url']);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Admin Panel | <?php echo $wo['config']['siteTitle']; ?></title>
    <link rel="icon" href="<?php echo $wo['config']['theme_url']; ?>/assets/img/icon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <script src="<?php echo Wo_LoadAdminLink('plugins/jquery/jquery.min.js'); ?>"></script>
    <link href="<?php echo Wo_LoadAdminLink('plugins/bootstrap/css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo Wo_LoadAdminLink('plugins/node-waves/waves.css'); ?>" rel="stylesheet" />
    <link href="<?php echo Wo_LoadAdminLink('plugins/animate-css/animate.css'); ?>" rel="stylesheet" />
    <link href="<?php echo Wo_LoadAdminLink('css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo Wo_LoadAdminLink('plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet" />
    <link href="<?php echo Wo_LoadAdminLink('css/themes/all-themes.css'); ?>" rel="stylesheet" />
    <link href="<?php echo Wo_LoadAdminLink('plugins/bootstrap-select/css/bootstrap-select.css'); ?>" rel="stylesheet" />
    <link href="<?php echo Wo_LoadAdminLink('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo Wo_LoadAdminLink('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css'); ?>" rel="stylesheet">
    <script src="<?php echo Wo_LoadAdminLink('plugins/codemirror-5.30.0/lib/codemirror.js'); ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('plugins/codemirror-5.30.0/mode/css/css.js'); ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('plugins/codemirror-5.30.0/mode/javascript/javascript.js'); ?>"></script>
    <link href="<?php echo Wo_LoadAdminLink('plugins/codemirror-5.30.0/lib/codemirror.css'); ?>" rel="stylesheet">
    <script src="<?php echo Wo_LoadAdminLink('js/jquery.form.min.js'); ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('js/m-popup/jquery.magnific-popup.min.js'); ?>"></script>
    <link href="<?php echo Wo_LoadAdminLink('css/font-awesome-4.7.0/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo Wo_LoadAdminLink('js/m-popup/magnific-popup.css'); ?>" rel="stylesheet" media="all">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script>
        function Wo_Ajax_Requests_File(){
            return "<?php echo $wo['config']['site_url'].'/admin-panel/requests.php';?>"
        }
    </script>
</head>

<body class="theme-red">
   <input type="hidden" class="main_session" value="<?php echo Wo_CreateMainSession();?>">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo $wo['site_url']; ?>"><img src="<?php echo $wo['config']['theme_url']; ?>/assets/img/logo.png" alt=""></a>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?php echo $wo['user']['avatar']; ?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name">Welcome back, <a href="<?php echo $wo['user']['url']; ?>" target="_blank"><?php echo $wo['user']['name']; ?></a></div>
                    <div class="name" style="font-size: 12px">Logged in as <?php echo ($is_admin) ? 'Administrator' : 'Moderator' ?></div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <?php //if ($is_admin == true || CheckUserPermission($current_user_id, "dashboard")) { ?>
                    <li <?php echo ($page == 'dashboard') ? 'class="active"' : ''; ?>>
                        <a href="<?php echo Wo_LoadAdminLinkSettings(''); ?>">
                            <i class="material-icons">dashboard</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <?php //} ?>
                    <?php
                    if ($is_admin == true
                        ||
                        (
                            CheckUserPermission($current_user_id, "general-settings") ||
                            CheckUserPermission($current_user_id, "site-settings") ||
                            CheckUserPermission($current_user_id, "site-features") ||
                            CheckUserPermission($current_user_id, "email-settings") ||
                            CheckUserPermission($current_user_id, "video-settings") ||
                            CheckUserPermission($current_user_id, "chat-settings") ||
                            CheckUserPermission($current_user_id, "social-login") ||
                            CheckUserPermission($current_user_id, "payment-settings") ||
                            CheckUserPermission($current_user_id, "amazon-settings")
                        )
                    ) {
                        ?>
                    <li <?php echo ($page == 'general-settings' || $page == 'site-settings' || $page == 'video-settings' || $page == 'email-settings' || $page == 'social-login' || $page == 'site-features' || $page == 'amazon-settings' ||  $page == 'chat-settings' || $page == 'payment-settings') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">settings</i>
                            <span>Settings</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "general-settings")){ ?>
                            <li <?php echo ($page == 'general-settings') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('general-settings'); ?>">General Settings</a>
                            </li>
                            <?php } ?>
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "site-settings")){ ?>
                            <li <?php echo ($page == 'site-settings') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('site-settings'); ?>">Site Settings</a>
                            </li>
                            <?php } ?>
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "site-features")){ ?>
                            <li <?php echo ($page == 'site-features') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('site-features'); ?>">Manage Site Features</a>
                            </li>
                            <?php } ?>
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "email-settings")){ ?>
                            <li <?php echo ($page == 'email-settings') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('email-settings'); ?>">E-mail & SMS Settings</a>
                            </li>
                            <?php } ?>
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "video-settings")){ ?>
                            <li <?php echo ($page == 'video-settings') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('video-settings'); ?>">Video & Audio Chat Settings</a>
                            </li>
                            <?php } ?>
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "chat-settings")){ ?>
                            <li <?php echo ($page == 'chat-settings') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('chat-settings'); ?>">Chat Settings</a>
                            </li>
                            <?php } ?>
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "social-login")){ ?>
                            <li <?php echo ($page == 'social-login') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('social-login'); ?>">Social Login Settings</a>
                            </li>
                            <?php } ?>
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "payment-settings")){ ?>
                            <li <?php echo ($page == 'payment-settings') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('payment-settings'); ?>">Payment System Settings</a>
                            </li>
                            <?php } ?>
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "amazon-settings")){ ?>
                            <li <?php echo ($page == 'amazon-settings') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('amazon-settings'); ?>">Storage Settings</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if ($is_admin == true
                        ||
                        (
                            CheckUserPermission($current_user_id, "manage-users") ||
                            CheckUserPermission($current_user_id, "manage-genders") ||
                            CheckUserPermission($current_user_id, "manage-profile-fields") ||
                            CheckUserPermission($current_user_id, "manage-success-stories") ||
                            CheckUserPermission($current_user_id, "manage-user-verification") ||
                            CheckUserPermission($current_user_id, "manage-verification-requests")
                        )
                    ) { ?>
                    <li <?php echo ($page == 'manage-verification-requests' || $page == 'manage-users' || $page == 'manage-verification-reqeusts' || $page == 'affiliates-settings' || $page == 'payment-requests' || $page == 'referrals-list' || $page == 'edit-user-permissions' || $page == 'manage-user-verification' || $page == 'manage-genders' || $page == 'add-genders' || $page == 'edit-genders' || $page == 'manage-profile-fields' || $page == 'add-new-profile-field' || $page == 'edit-profile-field' || $page == 'manage-success-stories' || $page == 'add-success-stories' || $page == 'edit-success-stories' || $page == 'manage-countries' || $page == 'add-countries' || $page == 'edit-countries') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">account_circle</i>
                            <span>Users</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "manage-users")){ ?>
                            <li <?php echo ($page == 'manage-users' || $page == 'edit-user-permissions') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-users'); ?>">Manage Users</a>
                            </li>
                            <?php }?>
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "manage-genders")){ ?>
                            <li <?php echo ($page == 'manage-genders' || $page == 'add-genders' || $page == 'edit-genders') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-genders'); ?>">Manage Genders</a>
                            </li>
                            <?php }?>
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "manage-countries")){ ?>
                                <li <?php echo ($page == 'manage-countries' || $page == 'add-countries' || $page == 'edit-countries') ? 'class="active"' : ''; ?>>
                                    <a href="<?php echo Wo_LoadAdminLinkSettings('manage-countries'); ?>">Manage Countries</a>
                                </li>
                            <?php }?>
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "manage-profile-fields")){ ?>
                            <li <?php echo ($page == 'manage-profile-fields' || $page == 'add-new-profile-field' || $page == 'edit-profile-field') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-profile-fields'); ?>">Manage Custom Profile Fields</a>
                            </li>
                            <?php }?>
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "manage-success-stories")){ ?>
                            <li <?php echo ($page == 'manage-success-stories' || $page == 'add-success-stories' || $page == 'edit-success-stories') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-success-stories'); ?>">Manage success stories</a>
                            </li>
                            <?php }?>
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "manage-user-verification")){ ?>
                            <li <?php echo ($page == 'manage-user-verification') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-user-verification'); ?>">Manage user verification</a>
                            </li>
                            <?php }?>
                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "manage-verification-requests")){ ?>
                                <li <?php echo ($page == 'manage-verification-requests') ? 'class="active"' : ''; ?>>
                                    <a href="<?php echo Wo_LoadAdminLinkSettings('manage-verification-requests'); ?>">Manage user verification requests</a>
                                </li>
                            <?php }?>

                            <?php if($is_admin == true || CheckRadioPermission($current_user_id, "affiliates-settings") || CheckRadioPermission($current_user_id, "payment-requests")){ ?>
                                <li <?php echo ($page == 'affiliates-settings' || $page == 'payment-requests' || $page == 'referrals-list') ? 'class="active"' : ''; ?>>
                                    <a href="javascript:void(0);" class="menu-toggle">Affiliates System</a>
                                    <ul class="ml-menu">
                                        <?php if($is_admin == true || CheckRadioPermission($current_user_id, "affiliates-settings")){ ?>
                                        <li <?php echo ($page == 'affiliates-settings') ? 'class="active"' : ''; ?>>
                                            <a href="<?php echo Wo_LoadAdminLinkSettings('affiliates-settings'); ?>">
                                                <span>Affiliates Settings</span>
                                            </a>
                                        </li>
                                        <?php }?>
                                        <?php if($is_admin == true || CheckRadioPermission($current_user_id, "payment-requests")){ ?>
                                        <li <?php echo ($page == 'payment-requests' || $page == 'referrals-list') ? 'class="active"' : ''; ?>>
                                            <a href="<?php echo Wo_LoadAdminLinkSettings('payment-requests'); ?>">
                                                <span>Payment Requests</span>
                                            </a>
                                        </li>
                                        <?php }?>
                                    </ul>
                                </li>
                            <?php } ?>

                        </ul>
                    </li>
                    <?php }?>
                    <?php if ($is_admin == true
                        ||
                        (
                            CheckUserPermission($current_user_id, "payments") ||
                            CheckUserPermission($current_user_id, "manage-payments") ||
                            CheckUserPermission($current_user_id, "bank-receipts")
                        )
                    ) { ?>
                    <li <?php echo ( $page == 'manage-payments' || $page == 'payments' || $page == 'bank-receipts' ) ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">money</i>
                            <span>Earnings</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "payments")) { ?>
                            <li <?php echo ($page == 'payments') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('payments'); ?>">Payments</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "manage-payments")) { ?>
                            <li <?php echo ($page == 'manage-payments') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-payments'); ?>">Manage Payments</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "bank-receipts")) { ?>
                            <li <?php echo ($page == 'bank-receipts') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('bank-receipts'); ?>">Manage bank receipts</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }?>
                    <?php if ($is_admin == true || CheckUserPermission($current_user_id, "manage-photos")) { ?>
                    <li <?php echo ($page == 'manage-photos' ) ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">perm_media</i>
                            <span>Photos</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'manage-photos') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-photos'); ?>">Manage Photos & Videos</a>
                            </li>
                        </ul>
                    </li>
                    <?php }?>
                    <?php if ($is_admin == true
                        ||
                        (
                            CheckUserPermission($current_user_id, "manage-stickers") ||
                            CheckUserPermission($current_user_id, "add-new-sticker")
                        )
                    ) { ?>
                    <li <?php echo ($page == 'manage-stickers' || $page == 'add-new-sticker' ) ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">perm_media</i>
                            <span>Stickers</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "manage-stickers")) { ?>
                            <li <?php echo ($page == 'manage-stickers') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-stickers'); ?>">Manage stickers</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "add-new-sticker")) { ?>
                            <li <?php echo ($page == 'add-new-sticker') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('add-new-sticker'); ?>">
                                    <span>Add New sticker</span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }?>
                    <?php if ($is_admin == true
                        ||
                        (
                            CheckUserPermission($current_user_id, "manage-articles") ||
                            CheckUserPermission($current_user_id, "manage-blog-categories") ||
                            CheckUserPermission($current_user_id, "add-new-article")
                        )
                    ) { ?>
                    <li <?php echo ($page == 'manage-articles' || $page == 'add-new-article' || $page == 'manage-blog-categories' || $page == 'edit-article') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">description</i>
                            <span>Blogs</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "manage-articles")) { ?>
                            <li <?php echo ($page == 'manage-articles' || $page == 'edit-article') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-articles'); ?>">Manage Blog</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "manage-blog-categories")) { ?>
                            <li <?php echo ($page == 'manage-blog-categories') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-blog-categories'); ?>">Blog categories</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "add-new-article")) { ?>
                            <li <?php echo ($page == 'add-new-article') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('add-new-article'); ?>">
                                    <span>Add New article</span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }?>
                    <?php if ($is_admin == true
                        ||
                        (
                            CheckUserPermission($current_user_id, "manage-gifts") ||
                            CheckUserPermission($current_user_id, "add-new-gift")
                        )
                    ) { ?>
                    <li <?php echo ($page == 'manage-gifts' || $page == 'add-new-gift' ) ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">perm_media</i>
                            <span>Gifts</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "manage-gifts")) { ?>
                            <li <?php echo ($page == 'manage-gifts') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-gifts'); ?>">Manage gifts</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "add-new-gift")) { ?>
                            <li <?php echo ($page == 'add-new-gift') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('add-new-gift'); ?>">
                                    <span>Add New Gift</span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }?>
                    <?php if ($is_admin == true || CheckUserPermission($current_user_id, "manage-website-ads") ) { ?>
                    <li <?php echo ( $page == 'manage-website-ads') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">attach_money</i>
                            <span>Advertisement</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'manage-website-ads') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-website-ads'); ?>">Manage Website Ads</a>
                            </li>
                        </ul>
                    </li>
                    <?php }?>
                    <?php if ($is_admin == true
                        ||
                        (
                            CheckUserPermission($current_user_id, "manage-themes") ||
                            CheckUserPermission($current_user_id, "change-site-desgin") ||
                            CheckUserPermission($current_user_id, "custom-design")
                        )
                    ) { ?>
                    <li <?php echo ($page == 'manage-themes' || $page == 'change-site-desgin' || $page == 'custom-design') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">color_lens</i>
                            <span>Design</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "manage-themes")) { ?>
                            <li <?php echo ($page == 'manage-themes') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-themes'); ?>">Themes</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "change-site-desgin")) { ?>
                            <li <?php echo ($page == 'change-site-desgin') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('change-site-desgin'); ?>">Change Site Design</a>
                            </li>
                            <?php } ?>
                            <!--<li <?php echo ($page == 'custom-design') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('custom-design'); ?>">Custom Design</a>
                            </li>-->
                        </ul>
                    </li>
                    <?php }?>
                    <?php if ($is_admin == true
                        ||
                        (
                            CheckUserPermission($current_user_id, "fake-users") ||
                            CheckUserPermission($current_user_id, "manage-announcements")
                        )
                    ) { ?>
                    <li <?php echo ($page == 'fake-users' || $page == 'manage-announcements' || $page == 'ban-users' || $page == 'mock-email' ) ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">build</i>
                            <span>Tools</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "fake-users")) { ?>
                            <li <?php echo ($page == 'fake-users') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('fake-users'); ?>">Fake User Generator</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "manage-announcements")) { ?>
                            <li <?php echo ($page == 'manage-announcements') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-announcements'); ?>">Announcements</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "ban-users")) { ?>
                                <li <?php echo ($page == 'ban-users') ? 'class="active"' : ''; ?>>
                                    <a href="<?php echo Wo_LoadAdminLinkSettings('ban-users'); ?>">BlackList</a>
                                </li>
                            <?php } ?>
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "mock-email")) { ?>
                                <li <?php echo ($page == 'mock-email') ? 'class="active"' : ''; ?>>
                                    <a href="<?php echo Wo_LoadAdminLinkSettings('mock-email'); ?>">Send E-mail</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }?>
                    <?php if ($is_admin == true
                        ||
                        (
                            CheckUserPermission($current_user_id, "manage-languages") ||
                            CheckUserPermission($current_user_id, "add-language")
                        )
                    ) { ?>
                    <li <?php echo ($page == 'manage-languages' || $page == 'add-language' || $page == 'edit-lang') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">language</i>
                            <span>Languages</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "add-language")) { ?>
                            <li <?php echo ($page == 'add-language') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('add-language'); ?>">Add New Language & Keys</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "manage-languages")) { ?>
                            <li <?php echo ($page == 'manage-languages') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-languages'); ?>">Manage Languages</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php }?>
                    <?php if ($is_admin == true
                        ||
                        (
                            CheckUserPermission($current_user_id, "manage-custom-pages") ||
                            CheckUserPermission($current_user_id, "edit-terms-pages")
                        )
                    ) { ?>
                    <li <?php echo ($page == 'edit-terms-pages' || $page == 'manage-custom-pages' || $page == 'add-new-custom-page' || $page == 'edit-custom-page' ) ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">description</i>
                            <span>Pages</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "manage-custom-pages")) { ?>
                            <li <?php echo ($page == 'manage-custom-pages' || $page == 'add-new-custom-page' || $page == 'edit-custom-page') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-custom-pages'); ?>">Manage Custom Pages</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true || CheckUserPermission($current_user_id, "edit-terms-pages")) { ?>
                            <li <?php echo ($page == 'edit-terms-pages') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('edit-terms-pages'); ?>">Edit Terms Pages</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true ) { ?>
                            <li <?php echo ($page == 'pages-seo') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('pages-seo'); ?>">Pages SEO</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if ($is_admin == true || CheckUserPermission($current_user_id, "manage-reports")) { ?>
                     <li <?php echo ($page == 'manage-reports') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">warning</i>
                            <span>Reports</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'manage-reports') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('manage-reports'); ?>">Manage Reports</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if ($is_admin == true || CheckUserPermission($current_user_id, "push-notifications-system") ) { ?>
                    <li <?php echo ( $page == 'push-notifications-system' ) ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">compare_arrows</i>
                            <span>API Settings</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'push-notifications-system') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo Wo_LoadAdminLinkSettings('push-notifications-system'); ?>">Push Notifications Settings</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if ($is_admin == true) { ?>
                    <li <?php echo ($page == 'changelog') ? 'class="active"' : ''; ?>>
                        <a href="<?php echo Wo_LoadAdminLinkSettings('changelog'); ?>">
                            <i class="material-icons">update</i>
                            <span>Changelogs</span>
                        </a>
                    </li>
                    <li>
                        <a href="http://docs.quickdatescript.com/#faq" target="_blank">
                            <i class="material-icons">more_vert</i>
                            <span>FAQs</span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    Copyright &copy; <?php  echo date('Y') ?> <a href="javascript:void(0);"><?php echo $wo['config']['siteName'] ?></a>.
                </div>
                <div class="version">
                    <b>Version: </b> <?php echo $wo['script_version'] ?>
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
              <?php if (is_dir('../install')) { ?>
              <div class="alert alert-danger">
                <i class="fa fa-fw fa-exclamation-triangle"></i> <strong>Risk:</strong> Please delete the ./install folder for security reasons.
              </div>
              <?php } ?>
              <?php 
              $warnings = Wo_GetScriptWarnings();
              if (!empty($warnings)) {
                 foreach ($warnings as $key => $value1) { ?>
                   <div class="alert alert-warning">
                      <i class="fa fa-fw fa-exclamation-circle"></i>
                      <?php 
                      if ($key == "STRICT_TRANS_TABLES") {
                        echo "<strong>Warning:</strong> The sql-mode <b>STRICT_TRANS_TABLES</b> is enabled in your mysql server, please contact your host provider to disable it.";
                      }
                      if ($key == "STRICT_ALL_TABLES") {
                        echo "<strong>Warning:</strong> The sql-mode <b>STRICT_ALL_TABLES</b> is enabled in your mysql server, please contact your host provider to disable it.";
                      }
                      if ($key == "safe_mode") {
                        echo "<strong>Warning:</strong> The php-mode <b>safe_mode</b> is enabled in your server, please contact your host provider to disable it.";
                      }
                      if ($key == "allow_url_fopen") {
                        echo "<strong>Warning:</strong> The php-extension <b>allow_url_fopen</b> is disabled in your server, please contact your host provider to enable it.";
                      }
                      if ($key == 'update_file') {
                        echo "<strong>Important:</strong> The file <b>update.php</b> is uploaded and not run yet, <a href='" . $wo['config']['site_url']. "/update.php' style='color:#fff; text-decoration:underline;'>Click Here</a> to update the script to v" . $wo['script_version'];
                      }
                      ?>
                   </div>
                 <?php }
              }
              ?>
        </div>
        <?php echo $page_loaded; ?>
    </section>
    
    <!-- Bootstrap Core Js -->
    <script src="<?php echo Wo_LoadAdminLink('plugins/bootstrap/js/bootstrap.js'); ?>"></script>

    <script src="<?php echo Wo_LoadAdminLink('plugins/jquery-datatable/jquery.dataTables.js'); ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js'); ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('plugins/jquery-datatable/extensions/export/buttons.flash.min.js'); ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('plugins/jquery-datatable/extensions/export/jszip.min.js'); ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('plugins/jquery-datatable/extensions/export/pdfmake.min.js'); ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('plugins/jquery-datatable/extensions/export/vfs_fonts.js'); ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('plugins/jquery-datatable/extensions/export/buttons.html5.min.js'); ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('plugins/jquery-datatable/extensions/export/buttons.print.min.js'); ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('js/pages/tables/jquery-datatable.js'); ?>"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo Wo_LoadAdminLink('plugins/bootstrap-select/js/bootstrap-select.js'); ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('plugins/sweetalert/sweetalert.min.js'); ?>"></script>

    <!-- ColorPicker Plugin Js -->
    <script src="<?php echo Wo_LoadAdminLink('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js'); ?>"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo Wo_LoadAdminLink('plugins/jquery-slimscroll/jquery.slimscroll.js'); ?>"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo Wo_LoadAdminLink('plugins/node-waves/waves.js'); ?>"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo Wo_LoadAdminLink('plugins/jquery-countto/jquery.countTo.js'); ?>"></script>

    <!-- Custom Js -->
    <script src="<?php echo Wo_LoadAdminLink('js/admin.js'); ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('js/pages/index.js'); ?>"></script>
</body>
<style>
    .sidebar .user-info {
        background-size: cover;
    }
    .theme-red .sidebar .menu .list li.active > :first-child i, .theme-red .sidebar .menu .list li.active > :first-child span {
        color: <?php echo $wo['config']['btn_background_color']?>;
    }
    .theme-red .navbar {
        background: <?php echo $wo['config']['header_background']?>;
    }
    .sidebar .user-info {
        background: <?php echo $wo['config']['btn_background_color']?> !important;
    }
    [type="radio"]:checked + label:after, [type="radio"].with-gap:checked + label:after {
        background-color: <?php echo $wo['config']['btn_background_color']?> !important;
    }
    [type="radio"]:checked + label:after, [type="radio"].with-gap:checked + label:before, [type="radio"].with-gap:checked + label:after {
        border: 2px solid <?php echo $wo['config']['btn_background_color']?> !important;
    }

    .btn-primary, .btn-primary:hover, .btn-primary:active, .btn-primary:focus {
        background-color: <?php echo $wo['config']['btn_background_color']?> !important;
    }
    .sidebar .user-info {
        height: 135px !important;
    }
    .sidebar .menu .list .ml-menu span {
        margin: 0 !important;
    }
    .sidebar .menu .list .ml-menu li.active a.toggled:not(.menu-toggle):before, .sidebar .menu .list .ml-menu li.active a.toggled:not(.menu-toggle), .theme-red .sidebar .legal .copyright a {
        color: <?php echo $wo['config']['btn_background_color']?> !important;
    }
    .spinner-layer.pl-red {
        border-color:  <?php echo $wo['config']['btn_background_color']?>;
    }
    a:hover, a:focus {
        color: #747474!important;
    }
</style>

<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
        var hash = $('.main_session').val();
        $.ajaxSetup({
            data: {
                hash: hash
            },
            cache: false
        });
    });
</script>
</html>
