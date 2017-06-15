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

<div class="row authors-list">

	<div class="columns small-12 medium-8 main-col">
		<div class="row">

			<?php foreach( artalk_get_authors() as $author ) : ?>

				<?php if ( $bio = get_the_author_meta('description', $author->ID) ) : ?>

					<div class="columns small-12 author">
						<div class="row collapse inner">
							<div class="columns small-12 medium-3">
								<?php if ( $avatar = artalk_avatar($author->ID, $avatar_size, false) ) : ?>
									<a class="thumb-link author-image" href="<?php the_permalink(); ?>">
										<?php echo $avatar; ?>
									</a>
								<?php endif; ?>
							</div>
							<div class="columns small-12 medium-9">
								<h1 class="article-title author-name text-center"><a href="<?php echo esc_url(get_author_posts_url($author->ID)); ?>" ><?php esc_html_e($author->data->display_name); ?></a></h1>
								<div class="content bio">
									<?php echo esc_html($bio); ?>
								</div>
							</div>
						</div>
					</div>

				<?php endif; ?>

			<?php endforeach; ?>

		</div>
	</div>

	<?php get_template_part('templates/sidebar', 'authors'); ?>

</div>

<?php get_footer(); ?>