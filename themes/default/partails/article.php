<?php
global $site_url;
?>
<div class="dt_sections articles qd_blog_lists">
    <div class="valign-wrapper">
		<div class="qd_blog_list_img">
		<a href="<?php echo $site_url;?>/article/<?php echo $article->id . '_' . url_slug(html_entity_decode($article->title));?>" data-ajax="/article/<?php echo $article->id . '_' . url_slug(html_entity_decode($article->title));?>">
            <img src="<?php echo GetMedia($article->thumbnail);?>" alt="<?php echo $article->title;?>">
        </a>
		</div>
		<div class="qd_blog_list_info">
        <h5>
            <a href="<?php echo $site_url;?>/article/<?php echo $article->id . '_' . url_slug(html_entity_decode($article->title));?>" data-ajax="/article/<?php echo $article->id . '_' . url_slug(html_entity_decode($article->title));?>">
            <?php echo $article->title;?>
            </a>
        </h5>
        
        <em><?php echo get_time_ago($article->created_at);?> <a href="<?php echo $site_url;?>/blog/<?php echo $article->category . '_' . url_slug(html_entity_decode(Dataset::blog_categories()[$article->category]));?>" data-ajax="/blog/<?php echo $article->category . '_' . url_slug(html_entity_decode(Dataset::blog_categories()[$article->category]));?>"><?php echo Dataset::blog_categories()[$article->category];?></a></em>
        <!--<p><?php echo $article->description;?></p>-->
        <a class="btn btn_primary btn-blog" href="<?php echo $site_url;?>/article/<?php echo $article->id . '_' . url_slug(html_entity_decode($article->title));?>" data-ajax="/article/<?php echo $article->id . '_' . url_slug(html_entity_decode($article->title));?>"><?php echo __( 'READ MORE' );?> </a>
		</div>
    </div>
</div>