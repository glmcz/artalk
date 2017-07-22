<?php if ( $featured = artalk_get_featured_posts() ) : $i=0; ?>
      <div class="col-md-6 nopadding nomargin" id="featured">

        <?php foreach ( $featured as $post ) : setup_postdata( $post ); $i++; ?>
        <?php if ( $has_thumbnail = has_post_thumbnail() ) : ?>


            <?php the_post_thumbnail('featured'); ?>
              <div class="columns medium-6">
                <a class="thumb-link" href="<?php the_permalink(); ?>">
                 
                </a>
              </div>
            <?php endif; ?>

            <div class="columns large-6 <?php echo $has_thumbnail ? 'medium-6':'medium-8 medium-centered'; ?>">
                <div class="inner">
                    <h3 class="article-title main-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title() ?></a></h3>
                    <div class="content excerpt">
                      <?php echo artalk_get_the_excerpt($post->ID, 28); ?>
                    </div>
                    <?php get_template_part('templates/post_meta'); ?>
                </div>
            </div>

        <?php endforeach; wp_reset_postdata(); ?>

      </div>
<?php endif; ?>