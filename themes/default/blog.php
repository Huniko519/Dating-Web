<div class="container page-margin find_matches_cont">
    <div class="row r_margin">
        <?php if(IS_LOGGED){ ?>
		<div class="col l3">
			<?php require( $theme_path . 'main' . $_DS . 'sidebar.php' );?>
		</div>
		<div class="col l1"></div>
        <?php } ?>
		<div class="col <?php if(IS_LOGGED){ echo 'l8'; } else { echo 'l12'; }?>">
			<div class="dt_home_rand_user">
				<h4 class="bold"><div style="background: #4caf50;"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M20,20H4A2,2 0 0,1 2,18V6A2,2 0 0,1 4,4H20A2,2 0 0,1 22,6V18A2,2 0 0,1 20,20M5,13V15H16V13H5M5,9V11H19V9H5Z"></path></svg></div> <?php echo __( 'Blog' );?></h4>
			</div>
			<div class="valign-wrapper qd_blog_sub_hdr">
                <div class="qd_blog_srch">
					<input type="text" placeholder="<?php echo __( 'Search' );?>" class="form-control" id="search-blog-input">
                    <span id="load-search-icon" class="hide">
                        <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25px" height="25px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve"><path fill="#333" d="M25.251,6.461c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615V6.461z" transform="rotate(65.2098 25 25)"><animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite"></animateTransform> </path></svg>
                    </span>
                </div>
				<div class="qd_blog_cats_list">
					<a class="dropdown-trigger" href="#" data-target="blog_cat_dropdown" title="<?php echo __( 'Categories' );?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5,9.5L7.5,14H2.5L5,9.5M3,4H7V8H3V4M5,20A2,2 0 0,0 7,18A2,2 0 0,0 5,16A2,2 0 0,0 3,18A2,2 0 0,0 5,20M9,5V7H21V5H9M9,19H21V17H9V19M9,13H21V11H9V13Z" /></svg></a>
					<ul id="blog_cat_dropdown" class="dropdown-content">
						<li><a href="<?php echo $site_url;?>/blog" data-ajax="/blog"><?php echo __('ALL');?></a></li>
						<?php
						$blog_categories = Dataset::blog_categories();
						foreach ($blog_categories as $key => $category) {
						?>
						<li><a href="<?php echo $site_url;?>/blog/<?php echo $key . '_' . url_slug(html_entity_decode($category));?>" data-ajax="/blog/<?php echo $key . '_' . url_slug(html_entity_decode($category));?>"><?php echo $category;?></a></li>
						<?php }?>
					</ul>
				</div>
			</div>
            <?php if(!empty($data['articles'])){ ?>
                <div id="articles_container">
					<?php echo $data['articles'];?>
                </div>
                <a href="javascript:void(0);" id="btn_load_more_articles" data-lang-nomore="<?php echo __('No more articles to show.');?>" data-ajax-post="/loadmore/articles" data-ajax-params="page=2" data-ajax-callback="callback_load_more_articles" class="btn waves-effect load_more"><?php echo __('Load more...');?></a>
            <?php }else{ ?>
                <?php require( $theme_path . 'partails' . $_DS . 'empty-article.php' );?>
            <?php }?>
        </div>
    </div>
</div>