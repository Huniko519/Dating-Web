<?php
    $pages = GetCustomPages();
    if(count($pages) > 0){
?>
<!-- Dropdown language -->
<span class="dt_foot_langs">
	<a class="dropdown-trigger" href="#" data-target="pages_dropdown"><?php echo __( 'More' );?> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M7,15L12,10L17,15H7Z" /></svg></a>
	<ul id="pages_dropdown" class="dropdown-content" style="top: -90px!important;">
        <?php foreach ($pages as $key => $val) { ?>
            <li style="width: 100%;<?php if( $data['name'] == $val['page_name'] ){ echo 'background-color: #f1f2f3!important;';}?>"><a href="<?php echo $site_url;?>/page/<?php echo $val['page_name'];?>"><?php echo $val['page_title'];?></a></li>
        <?php } ?>
	</ul>
</span>
<?php } ?>