<!-- Dropdown language -->
<span class="dt_foot_langs">
	<a class="dropdown-trigger" href="#" data-target="lang_dropdown"><?php echo __( 'Language' );?> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M7,15L12,10L17,15H7Z" /></svg></a>
	<ul id="lang_dropdown" class="dropdown-content">

        <?php
        $language = Dataset::load('language');
        if (isset($language) && !empty($language)) {
            foreach ($language as $key => $val) {?>

            <li <?php if( GetActiveLang() == $key ){ echo 'style="background-color: #f1f2f3;"';}?>><a href="?language=<?php echo $key;?>"><?php echo $val;?></a></li>

            <?php    }
        }
        ?>
	</ul>
</span>