<article>
    <div class="col-md-6 col-sm-6 post-container">
        <div class="post-category post-category-content">
            <header>
                <h2 class="post-title">
                    <a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo short_title('...',12  );?></a>
                </h2>
            </header>

            <div class="content excerpt">
                <?php echo artalk_get_the_excerpt(get_the_ID(),45, $more = '… ', $allowed_tags = '<a>'); ?>
            </div>
            <footer>
                <?php get_template_part('templates/post-meta'); ?>
            </footer>
        </div>
    </div>

</article>