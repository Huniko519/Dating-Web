<link rel="icon" href="<?php echo $theme_url;?>assets/img/icon.png" type="image/x-icon">
<?php
    foreach ($data['cssfiles'] as $key => $css_file) {
        echo '<link href="'. $theme_url . $css_file . '" type="text/css" id="' . $key . '" rel="stylesheet" media="screen,projection"/>';
    }
?>

<link href="<?php echo $theme_url;?>assets/css/ie.css" type="text/css" id="ie" rel="stylesheet" media="screen,projection"/>

<?php if( $config->displaymode == 'night' ){?>
    <link href="<?php echo $theme_url;?>assets/css/night.css" type="text/css" id="night-mode-css" rel="stylesheet" media="screen,projection"/>
<?php } ?>

<?php if( $config->is_rtl === true ){?>
    <link href="<?php echo $theme_url;?>assets/css/rtl.css" type="text/css" id="rtl" rel="stylesheet" media="screen,projection"/>
<?php } ?>