<?php
global $site_url;
?>

<div class="container page-margin find_matches_cont">
    <div class="row r_margin">

        <?php if( IS_LOGGED ){ ?>


		<div class="col l3">
			<?php require( $theme_path . 'main' . $_DS . 'sidebar.php' );?>
		</div>

        <?php }?>

        <div class="col <?php if( IS_LOGGED ){ echo 'l9'; }else{ echo 'l12'; }?>">
			<div class="qd_read_blog_thumb">
				<a class="inline" href="<?php echo GetMedia($data['article']['thumbnail']);?>">
					<img src="<?php echo GetMedia($data['article']['thumbnail']);?>" alt="<?php echo $data['article']['title'];?>" />
				</a>
			</div>
			<div class="row qd_read_blog_row">
				<div class="col l1"></div>
				<div class="col l10">
					<div class="dt_sections qd_read_blog_section">
						<div class="qd_read_blog_head">
							<h2><?php echo $data['article']['title'];?></h2>
							<blockquote><?php echo $data['article']['description'];?></blockquote>
							<div class="valign-wrapper">
								<a href="<?php echo $site_url;?>/blog/<?php echo $data['article']['category'] . '_' . url_slug(html_entity_decode(Dataset::blog_categories()[$data['article']['category']]));?>" data-ajax="/blog/<?php echo $data['article']['category'] . '_' . url_slug(html_entity_decode(Dataset::blog_categories()[$data['article']['category']]));?>"><?php echo Dataset::blog_categories()[$data['article']['category']];?></a>
								<span class="middot">·</span>
								<time><?php echo get_time_ago($data['article']['created_at']) ;?></time>
								<span class="middot">·</span>
								<span><?php echo $data['article']['view'];?> <?php echo __('Views');?></span>
								<div class="qd_read_blog_share">
									<ul>
										<li>
											<a href="https://www.facebook.com/sharer.php?u=<?php echo $data['article']['url'];?>" target="_blank" title="Facebook"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#337ab7"><path d="M5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3M18,5H15.5A3.5,3.5 0 0,0 12,8.5V11H10V14H12V21H15V14H18V11H15V9A1,1 0 0,1 16,8H18V5Z"></path></svg></a>
										</li>
										<li>
											<a href="http://twitter.com/intent/tweet?text=<?php echo $data['article']['title'];?>&amp;url=<?php echo $data['article']['url'];?>" target="_blank" title="Twitter"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#55acee"><path d="M5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3M17.71,9.33C18.19,8.93 18.75,8.45 19,7.92C18.59,8.13 18.1,8.26 17.56,8.33C18.06,7.97 18.47,7.5 18.68,6.86C18.16,7.14 17.63,7.38 16.97,7.5C15.42,5.63 11.71,7.15 12.37,9.95C9.76,9.79 8.17,8.61 6.85,7.16C6.1,8.38 6.75,10.23 7.64,10.74C7.18,10.71 6.83,10.57 6.5,10.41C6.54,11.95 7.39,12.69 8.58,13.09C8.22,13.16 7.82,13.18 7.44,13.12C7.81,14.19 8.58,14.86 9.9,15C9,15.76 7.34,16.29 6,16.08C7.15,16.81 8.46,17.39 10.28,17.31C14.69,17.11 17.64,13.95 17.71,9.33Z"></path></svg></a>
										</li>
										<li>
											<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $data['article']['url'];?>" target="_blank" title="Linkedin"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#007bb6"><path d="M19,3A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3H19M18.5,18.5V13.2A3.26,3.26 0 0,0 15.24,9.94C14.39,9.94 13.4,10.46 12.92,11.24V10.13H10.13V18.5H12.92V13.57C12.92,12.8 13.54,12.17 14.31,12.17A1.4,1.4 0 0,1 15.71,13.57V18.5H18.5M6.88,8.56A1.68,1.68 0 0,0 8.56,6.88C8.56,5.95 7.81,5.19 6.88,5.19A1.69,1.69 0 0,0 5.19,6.88C5.19,7.81 5.95,8.56 6.88,8.56M8.27,18.5V10.13H5.5V18.5H8.27Z"></path></svg></a>
										</li>
										<li>
											<a href="http://pinterest.com/pin/create/button/?url=<?php echo $data['article']['url'];?>" target="_blank" title="Pinterest"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#cb2027"><path d="M13,16.2C12.2,16.2 11.43,15.86 10.88,15.28L9.93,18.5L9.86,18.69L9.83,18.67C9.64,19 9.29,19.2 8.9,19.2C8.29,19.2 7.8,18.71 7.8,18.1C7.8,18.05 7.81,18 7.81,17.95H7.8L7.85,17.77L9.7,12.21C9.7,12.21 9.5,11.59 9.5,10.73C9.5,9 10.42,8.5 11.16,8.5C11.91,8.5 12.58,8.76 12.58,9.81C12.58,11.15 11.69,11.84 11.69,12.81C11.69,13.55 12.29,14.16 13.03,14.16C15.37,14.16 16.2,12.4 16.2,10.75C16.2,8.57 14.32,6.8 12,6.8C9.68,6.8 7.8,8.57 7.8,10.75C7.8,11.42 8,12.09 8.34,12.68C8.43,12.84 8.5,13 8.5,13.2A1,1 0 0,1 7.5,14.2C7.13,14.2 6.79,14 6.62,13.7C6.08,12.81 5.8,11.79 5.8,10.75C5.8,7.47 8.58,4.8 12,4.8C15.42,4.8 18.2,7.47 18.2,10.75C18.2,13.37 16.57,16.2 13,16.2M20,2H4C2.89,2 2,2.89 2,4V20A2,2 0 0,0 4,22H20A2,2 0 0,0 22,20V4C22,2.89 21.1,2 20,2Z"></path></svg></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<article><?php echo br2nl( html_entity_decode( $data['article']['content'] ));?></article>
					</div>
					<p class="bold"><?php echo __( 'Tags' );?></p>
					<ul class="qd_read_blog_tags">
						<?php
							$tags = explode(',' , $data['article']['tags'] );
							foreach ($tags as $key => $tag) {
						?>
							<li><a href="<?php echo $site_url;?>/blog/<?php echo $tag;?>" data-ajax="/blog/<?php echo $tag;?>"><?php echo $tag;?></a></li>
						<?php }?>
					</ul>
				</div>
				<div class="col l1"></div>
			</div>
        </div>


    </div>
</div>