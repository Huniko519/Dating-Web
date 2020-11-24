<div class="usr_thumb <?php if($matche_img_first === true){ echo ' isActive'; }?>" data-id="<?php echo $matche->id;?>" id="user<?php echo $matche->id;?>">
    <img alt="<?php echo $matche->username;?>" src="<?php echo GetMedia('',false); ?><?php echo $matche->avater;?>">
</div>