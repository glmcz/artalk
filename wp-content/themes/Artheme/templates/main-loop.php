<div class="row main-magazine">
    <div class="bar-info">
        <div class="col-md-8 col-sm-6 col-xs-12 noleftpadding">Nejnovější články</div>
        <div class="col-md-4 col-sm-6">Inzerce</div>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 noleftpadding" id="posts">
            <?php
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        if ( is_home() ) {
            $query = new WP_Query(array(
            'ignore_sticky_posts' => true,
            'paged' => $paged,
            'posts_per_page' => 10,
             'category_name' => 'arena',
            ));
        } else
        {
            $query = new WP_Query(array(
            'post_type' => 'post',
            'ignore_sticky_posts' => true,
            'paged' => $paged,
            'posts_per_page' => 14,
            'category_name' => artalk_get_current_category()
            ));
        }
    ?>

        <?php while ($query -> have_posts()) : $query->the_post(); ?>

            <?php get_template_part('templates/post', artalk_get_current_category() ); ?>

        <?php endwhile; ?>

        <?php next_posts_link( '<div class="further-content">Načíst další obsah</div>' ); ?>

    </div>

    <?php wp_reset_query(); ?>
    <?php wp_reset_query(); ?>

    <?php get_template_part('templates/sidebar'); ?>

    <?php  get_template_part('templates/magazine-bottom'); ?>
