<?php if (!isset($_POST['ajax'])) {?><?php require( $theme_path . 'main' . $_DS . 'header.php' );?>
    <?php
        if( isset( $_SESSION['JWT'] ) ){
            require( $theme_path . 'main' . $_DS . 'nav-logged-in.php' );
        }else{
            require( $theme_path . 'main' . $_DS . 'nav-not-logged-in.php' );
        }
    ?>
    <?php if ($data['name'] !== 'login' && $data['name'] !== 'contact' && $data['name'] !== 'register' && $data['name'] !== 'forgot' && $data['name'] !== 'reset' && $data['name'] !== 'verifymail' && $data['name'] !== 'index' && $data['name'] !== 'home') { ?>
    <div class="container" style="transform: none;"><?php echo GetAd('header');?></div>
    <?php } ?>
    <div id="container">
<?php } ?>
        <?php require($file_path);?>
<?php if (!isset($_POST['ajax'])) {?>
    </div>
    <a href="javascript:void(0);" id="ajaxRedirect" style="visibility: hidden;display: none;"></a>
    <?php require( $theme_path . 'main' . $_DS . 'full-footer.php' );?>
    <?php require( $theme_path . 'main' . $_DS . 'footer.php' );?>
<?php } ?>