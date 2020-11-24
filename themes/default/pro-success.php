<!-- Premium  -->
<div class="container page-margin find_matches_cont">
	<div class="row r_margin">
		<div class="col l3">
			<?php require( $theme_path . 'main' . $_DS . 'sidebar.php' );?>
		</div>
		
		<div class="col l9">
			<div class="dt_premium dt_sections">
				<div class="dt_p_head center pro_success">
					<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"></circle><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path></svg>
					<h2 class="light"><?php echo __( 'Congratulations!' );?></h2>
					<?php if( isset($_GET['paymode']) && $_GET['paymode'] == 'pro'){ ?>
						<p class="bold"><?php echo __( 'You are a pro now.' );?></p>
					<?php }else{ ?>
						<p class="bold"><?php echo __( 'Your payment was processed successfully.' );?></p>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Premium  -->
<a href="javascript:void(0);" id="btnProSuccessRedirect" data-ajax="/find-matches" style="visibility: hidden;display: none;"></a>

<?php if( isset($_GET['paymode']) && $_GET['paymode'] == 'pro'){ ?>
    <script>
        $('[data-ajax="/pro"]').remove();
    </script>
<?php }else{ ?>
    <script>
        setTimeout(() => {
            $("#btnProSuccessRedirect").click();
        }, 3000);
    </script>
<?php } ?>