<aside id="sidebar" class="col-md-12 no-margin sidebar-wrapper hide-for-small text-center">
    <div class="relatedposts">

        <?php wp_author_info_box();?>

    </div>
     <div class="relatedposts">
         <p class="widget_single">Dlaší články autora</p>
         <div class="relatedthumb">
             <?php echo get_related_author_posts() ?>
         </div>
        <p class="widget_single">Související články</p>

         <div class="relatedthumb">

	        <?php
	        //for use in the loop, list 5 post titles related to first tag on current post
	        $tags = wp_get_post_tags($post->ID);
	        if ($tags) {
		        $first_tag = $tags[0]->term_id;
		        $args=array(
			        'tag__in' => array($first_tag),
			        'post__not_in' => array($post->ID),
			        'posts_per_page'=>5,
			        'ignore_sticky_posts'=>1
		        );
		        $my_query = new WP_Query($args);
		        if( $my_query->have_posts() ) {
			        while ($my_query->have_posts()) : $my_query->the_post(); ?>
                        <a class="external_link" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php echo short_title('...',6); ?></a>

				        <?php
			        endwhile;
		        }
		        wp_reset_query();
	        }
	        ?>
<!--        --><?php
//        $orig_post = $post;
//        global $post;
//        $tags = wp_get_post_tags($post->ID);
//
//        if ($tags) {
//            $tag_ids = array();
//            foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
//            $args=array(
//                'tag__in' => $tag_ids,
//                'post__not_in' => array($post->ID),
//                'posts_per_page'=>4, // Number of related posts to display.
//                'ignore_sticky_posts'=>1
//            );
//
//            $my_query = new wp_query( $args );
//
//            while( $my_query->have_posts() ) {
//                $my_query->the_post();
//                ?>
<!---->
<!---->
<!--                    <a class="external_link" rel="external" href="--><?// the_permalink()?><!--">-->
<!--                        --><?php //the_title(); ?>
<!--                    </a>-->
<!---->
<!---->
<!--            --><?php //}
//
//        }
//        $post = $orig_post;
//        wp_reset_query();
        ?>
    </div>
    </div>


    <?php get_template_part('templates/widgets/dynamic'); ?>
    <?php get_template_part('templates/widgets/dynamic2'); ?>
</aside>