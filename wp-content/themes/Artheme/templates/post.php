<article>
	<div class="col-md-6 col-sm-6 post-container">
        <div class="post">
            <header>
                <h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title() ?></a></h2>
            </header>
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="image_container">
                        <a class="thumb-link" href="<?php the_permalink(); ?>">
<!--                            work only with support of featured images plugin which make them from first posted images in posts -->
                            <?php echo fly_get_attachment_image( get_post_thumbnail_id(), array( 350, 200 ), true ); ?>
<!--                            - css resize of featured thumbnails from posts
                                -><?php //$url = get_the_post_thumbnail_url($post)?>
<!--                            --><?php //echo '<div class="thumb" style="background: url('.$url.')">'?>
<!--                            --><?php //echo '</div>'; ?>
<!--                            old version without resize -->
<!--                         --><?php //echo get_the_post_thumbnail($post, array( 350,200 ),array('class' => 'img-responsive')); ?>
                        </a>
                    </div>
                <?php endif; ?>

            <div class="content excerpt">
                <?php the_excerpt(); ?>
            </div>
            <footer>
                <?php get_template_part('templates/post-meta'); ?>
            </footer>
        </div>
	</div>

</article>

     

       