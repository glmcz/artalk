<?php get_header(); ?>    
  
    <div class="row">
        <article>
            <div class="col-md-8 no-margin text_width ">

                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <h1><?php the_title(); ?></h1>

    <!--                --><?php //$var = '600';echo get_the_content_reformatted($var);?>


                            <div class="post-meta-single ">
         <span><?php the_author_posts_link(); ?></span> | <span><?php the_time( get_option( 'date_format' ) ); ?></span>
                                <span><?php edit_post_link( 'edit', ' | ' ); ?></span> <span> RECENZE - </span> <span><?php do_action('artalk_post_cats'); ?></span>
                            </div>


                <div class="col-md-9 col_9_padding_single_right">
                            <?php echo the_content();?>

    <!--	              --><?php
    //
    //	              $phrase = get_the_content();
    //	              // This is where wordpress filters the content text and adds paragraphs
    //	              $phrase = apply_filters('the_content', $phrase);
    //	              $replace = '<p style="text-align: left;font-family: Georgia, Times, serif; font-size: 14px; line-height: 22px; color: #1b3d52; font-weight: normal; margin: 15px 0px; font-style: italic;">';
    //
    //	              echo str_replace('<strong>', $replace, $phrase);
    //
    //	              ?>
                    <br /><br />

                    <?php comments_template(); ?>

                    <?php endwhile; else: ?>

                        <h3>Sorry, no posts matched your criteria.</h3>

                    <?php endif; ?>
                <div class="clear"></div>
                    </div>
                <div class="col-md-3 col_3_padding_single_left">
                    <div class="tags">
		                <?php

		                $terms =wp_get_post_tags($post->ID);
		                //                   echo '<p>';
		                foreach($terms as $term) {

			                //                            echo $term->name; //the output
			                //                            echo get_tag_link($term->term_id);
			                echo '<span class="tagbox"><a class="taglink" href="'. get_tag_link($term->term_id) .'">'. $term->name . '</a></span>' . "\n"   ;
			                //                            echo $string .= '<span class="tagbox"><a class="taglink" href="'. get_tag_link($tag->term_id) .'">'. $tag->name . '</a></span>' . "\n"   ;

		                }
		                //                    echo '</p>';
		                //  the_tags('', '' ,'' ); ?>
                    </div>
	                <?php
	                do_action( 'side_matter_list_notes' );
	                ?>

                </div>
            </div>

            <div class="col-md-4 sidebar_right">

                <!--//single_left-->

                <?php get_template_part('templates/sidebar', 'single'); ?>

                <div class="clear"></div>
            </div>
       </article>
  </div><!--//content-->


<?php get_sidebar(); ?>

<?php get_footer(); ?>