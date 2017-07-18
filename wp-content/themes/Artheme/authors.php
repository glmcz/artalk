<?php
/**
 * Template Name: Seznam autoru
 * @package WordPress
 * @subpackage Artheme
 * @since Artalk 2017 0.9.2
*/

$avatar_size = 100;

get_header();

?>
<div class="row authors-letter-line">
    <?php author_letter_line();?>
</div>



		<div class="authors-list-row">

			<?php foreach( artalk_get_authors() as $author ) : ?>

				<?php if ( $bio = get_the_author_meta('description', $author->ID) ) : ?>

					<div class="col-md-4">
						<div class="authors-list-single">
							<div class="columns small-12 medium-3">
								<?php /*if ( $avatar = artalk_avatar($author->ID, $avatar_size, false) ) :*/?>
									<a class="thumb-link author-image" href="<?php the_permalink(); ?>">
										<?php /*echo $avatar; */?>
									</a>
								<?php /*endif; */?>
							</div>
							<div class="authors-list-single-text">
								<h1><a href="<?php echo esc_url(get_author_posts_url($author->ID)); ?>" ><?php esc_html_e($author->data->display_name);?></a></h1>
								<div class="content bio">
									<?php echo esc_html($bio); ?>
								</div>
                            <?php
                            $user_posts = get_author_posts_url(  $author->ID);
                            echo '<a class="widget_single" href="'. $user_posts .'">Další články autora</a>'; ?>
							</div>
						</div>
					</div>

				<?php endif; ?>

			<?php endforeach; ?>

		</div>


	<?php /*get_template_part('templates/sidebar', 'authors'); */?>


<?php get_footer(); ?>