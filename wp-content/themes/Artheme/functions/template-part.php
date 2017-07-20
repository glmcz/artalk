<?php
/**
 * Created by Teapot.
 * User: Filip Uhlir
 * Date: 06.02.2017
 * Time: 15:47
 */
/* LOGO */
add_action( 'artalk_logo', 'artalk_logo' );
function artalk_logo() {
    echo '<img class="site-logo" src="'.get_stylesheet_directory_uri().'/assets/images/artalk-logo-sm.png" alt="Artalk Logo" />';
}

/* CATEGORIES */
add_action( 'artalk_post_cats', 'artalk_post_cats',10,3);
function artalk_post_cats( $post_id=null, $args='', $echo=true ) {
    if ( ! absint($post_id) )
        $post_id = get_the_ID();
    if ( ! $post_id = absint($post_id) )
        return false;
    $defaults = array(
        'separator' => ' ',
    );
    $args = wp_parse_args( $args, $defaults );
    $cats = wp_get_object_terms($post_id, 'category', $args);

    if ( empty($cats) )
        return false;
    $cats_out = array();
    foreach ( $cats as $key => $cat ) {
        if ( 'E-mail newsletter' == $cat->name )
            continue;
        $pre = '';
        //if ( $parent = get_category_parents($cat->parent,'category',false,' &raquo; ') ) {
        //   $pre = $parent.' &mdash; ';
        /*            if ($parent) {
                        $pre = '<a href="'.esc_url(get_term_link($parent)).'">'.$parent->name.'</a> &mdash; ';
                    }*/
        //}
        $cats_out[] = '<li>'.$pre.'<a href="'.esc_url(get_term_link($cat)).'">'.$cat->name.'</a></li>';
    }

    $cats_out = '<ul class="post-categories">'.join($args['separator'], $cats_out).'</ul>';

    if ( ! $echo )
        return $cats_out;
    echo $cats_out;
}
add_action( 'artalk_sub_cats', 'artalk_sub_cats' );
function artalk_sub_cats() {
    if ( ! is_category() )
        return false;
    $current_cat = get_queried_object();
    if ( in_array( $current_cat->slug, array('artservis','arena') ) || is_home() )
        return false;
    $i       = 0;
    $out     = '';
    $cats    = get_categories(array('parent'=>$current_cat->term_id));
    $count   = count($cats);
    $classes = 'columns small-6 medium-2';
    foreach(  $cats as $cat ) { $i++;
        if ( $count == $i )
            $classes .= ' end';
        $out .= '<li class="'.esc_attr($classes).'"><a href="'.esc_url( get_category_link( $cat->term_id ) ).'">'.esc_html($cat->name).'</a></li>';
    }
    $out = '<div id="sub-cats" class="sub-cats row text-center"><ul>'.$out.'</ul></div>';
    echo $out;
}
add_action ('artalk_service_part','artalk_service_part');
function artalk_service_part ($title='',$category='',$class='',$echo=true,$num=6,$col=1,$liClass='')
{
    // Get the ID of a given category
    $category_id = get_cat_ID( $category );

    // Get the URL of this category
    $category_link = get_category_link( $category_id );

    /*    var_dump(is_category(2));
        if ( ! is_category($category))
        {
            if ( ! $echo )
                return 'neplatná kategorie';
            echo 'neplatná kategorie';
            return;
        }*/

    $serContent = '<div class="'.$class.'">';
    $serContent .= '<div class="s-header"><a href="'.$category_link.'"><h5>'.$title.'</h5></a></div>';
    $serContent .= '<ul class="row">';

    $QArgsActual = array( 'category_name' => $category,'posts_per_page' => $num );
    query_posts($QArgsActual);
    while ( have_posts() ) : the_post();
        $serContent .= '<li class='.$liClass.'>';
        $serContent .= '<a href="'.get_permalink().'" title="'.get_the_title(false).'">&#9679; ';
        //$serContent .= the_date('d.m.Y','<time>','</time><br />');
        $Actualtitle = get_the_title();
        $serContent .= wp_trim_words( $Actualtitle, $num_words = 12, $more = '… ' );
        $serContent .= '</a></li>';
    endwhile;

    // Reset Query
    wp_reset_query();
    $serContent .= '</ul>';
    $serContent .= '</div>';

    if ( ! $echo )
        return $serContent;
    echo $serContent;
}
/* FEATURE POST */
add_action( 'artalk_feature', 'artalk_feature' );
function artalk_feature() {
    $args = array('posts_per_page' => 1,'post__in'  => get_option( 'sticky_posts' ),'ignore_sticky_posts' => 1 );
    $featured='';
    //$featuredPost = get_posts ($args);
    query_posts($args);
    while ( have_posts() ) : the_post();
        $featured .='<div class="featured"><h2>';
        $featured .='<header><a href="'.get_permalink().'" title="'.get_the_title(false).'">'.get_the_title().'</a></h2></header>';
        $featured .='<div class="content excerpt">';
        $featured .= artalk_get_the_excerpt( get_the_ID(), $num_words = 26, $more = '… ',$allowed_tags = '<a>');
        $featured .='</div>';
        $featured .='<footer>';
        $featured .= '<span><span class="author-link">'.get_the_author_posts_link().'</span> | <time>'. get_the_time( get_option("date_format"),get_the_ID() ).'<time> | ';
        $featured .= artalk_post_cats(get_the_ID(), '', false).'</span>';
        $featured .='</footer>';
        echo "ss";
        if( has_post_thumbnail() ){
            $featured .= '<div class="featured-img"><a href="'. get_permalink() .'" />';
            $featured .= get_the_post_thumbnail(get_the_ID(),'featured',array( 'class' => 'img-responsive' ));
            $featured .= '</a></div>';
        }else{
            $featured .='neni nahled';
        }
        $featured .='</div>';
        echo $featured;
    endwhile;
    wp_reset_query();
}

/* Comments template       */
if ( ! function_exists( 'fws_comment' ) ) :
	function fws_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				// Display trackbacks differently than normal comments.
				?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<p><?php _e( 'Pingback:', 'fws' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'fws' ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
				break;
			default :
				// Proceed with normal comments.
				global $post;
				?>
				<li class="commented-list" id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="row">
						<header class="col-md-3">
							<?php
//
							printf( '<cite class="fn">%1$s %2$s</cite>',
								get_comment_author_link(),
								// If current post author is also comment author, make it known visually.
								( $comment->user_id === $post->post_author ) ? '<span> ' . __( '(Post author) ', 'fws' ) . '</span>' : ''
							);

							?>
						</header><!-- .comment-meta -->

						<?php if ( '0' == $comment->comment_approved ) : ?>
							<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'fws' ); ?></p>
						<?php endif; ?>

						<section class="col-md-6">
							<?php
							printf( '<a class="links"href="%1$s"><time datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s ( %2$s  )', 'fws' ), get_comment_date(), get_comment_time() )
							);
							comment_text(); ?>
							<?php edit_comment_link( __( 'Edit', 'fws' ), '<p class="edit-link">', '</p>' ); ?>
						</section><!-- .comment-content -->

						<div class="col-md-3">
							<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'odpovědět', 'fws' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div><!-- .reply -->
					</article><!-- #comment-## -->
				</li>
				<?php
				break;
		endswitch; // end comment_type check
	}
endif;