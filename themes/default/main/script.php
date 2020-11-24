<?php
    foreach ($data['jsfiles'] as $key => $js_file) {
        echo '<script src="'. $theme_url . $js_file . '" type="text/javascript" id="' . $key . '"/></script>';
    }
    if( isset( $_SESSION['JWT'] ) ){
        require_once ( $theme_path . 'main' . $_DS . 'timeago.php' );
        echo '<script src="'. $theme_url . 'assets/js/chat.js" type="text/javascript" id="chat-script"/></script>';
        //echo '<script src="https://checkout.stripe.com/checkout.js"></script>';
    }
