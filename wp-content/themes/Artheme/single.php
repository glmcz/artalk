<?php get_header(); ?>    
  
    <div class="row">

        <div class="col-sm-8">

          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <h1><?php the_title(); ?></h1>

            <?php $content_width = 600; echo get_the_content_reformatted(); ?>

            <br /><br />

            <?php comments_template(); ?>

            <?php endwhile; else: ?>

                <h3>Sorry, no posts matched your criteria.</h3>

            <?php endif; ?>

            <div class="clear"></div>

        </div>

        <!--//single_left-->q
        <?php get_template_part('templates/sidebar', 'single'); ?>

        <div class="clear"></div>
      
    </div>

    

    </div>
    <!--//content-->
  
<!--footer-->
<?php get_sidebar(); ?>

<?php get_footer(); ?>