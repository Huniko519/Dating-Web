<!-- About  -->
<style>
@media (max-width: 1024px){
.dt_slide_menu {
	display: none;
}
nav .header_user {
	display: block;
}
}
</style>
<?php if( $data['page_type'] == 0 ){?>
    <div class="container dt_terms">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="dt_terms_content_body">
                    <?php echo htmlspecialchars_decode($data['content']); ?>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
<div class="container dt_terms">
    <div class="row">
        <div class="col s12 m12 l12">
            <h2 class="bold"><?php echo $data['name'];?></h2>
            <div class="dt_terms_content_body">
                <?php echo htmlspecialchars_decode($data['content']); ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>