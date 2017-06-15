<div class="post-meta">
	<span><span class="author-link"><?php the_author_posts_link(); ?></span> | <time><?php the_time( get_option( 'date_format' ) ); ?><time>
	<?php edit_post_link( 'edit', ' | ' ); ?>
<!--	--><?php //do_action('artalk_post_cats'); ?>
    <?php //do_action('artalk_sub_cats'); ?></span>
</div>