<?php get_header();   ?>
    <div class="row">
        <article>
            <div class="col-md-8 no-margin text_width ">

				<?php if (have_posts()) : while (have_posts()) : the_post();?>


                <h1><?php the_title(); ?></h1>

                <!--                --><?php //$var = '600';echo get_the_content_reformatted($var);?>


                <div class="post-meta-single ">
                    <span><?php the_author_posts_link(); ?></span> | <span><?php the_time( get_option( 'date_format' ) ); ?></span>
                    <span><?php edit_post_link( 'edit', ' | ' ); ?></span> <span> RECENZE - </span> <span><?php do_action('artalk_post_cats'); ?></span>
                </div>


                <div class="col-md-9 col_9_padding_single_right">
					<?php
					the_contents();
                     ?>

					<?php endwhile; else: ?>

                        <h3>Sorry, no posts matched your criteria.</h3>

					<?php endif;


					?>

                    <div class="clear"></div>
                </div>

                <div class="col-md-3 col_3_padding_single_left">
                    <div class="single-tags-container">
                        <?php

                        $terms =wp_get_post_tags($post->ID);
                        //                   echo '<p>';
                        foreach($terms as $term) {

                            //                            echo $term->name; //the output
                            //                            echo get_tag_link($term->term_id);
                            echo '<span class="single-tags-tag"><a class="taglink" href="'. get_tag_link($term->term_id) .'">'. $term->name . '</a></span>';
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

			<?php  comments_template(); ?>
        </article>
    </div><!--//content-->


<?php get_sidebar(); ?>

<?php get_footer(); ?>