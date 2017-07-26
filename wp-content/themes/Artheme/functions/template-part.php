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


/* FEATURE POST big picture on home page*/
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
//		switch ( $comment->comment_type ) :
//			case 'pingback' :
//			case 'trackback' :
//				// Display trackbacks differently than normal comments.
//				?>
<!--                <li --><?php //comment_class(); ?><!-- id="comment---><?php //comment_ID(); ?><!--">-->
<!--                <p>--><?php //_e( 'Pingback:', 'fws' ); ?><!----><?php //comment_author_link(); ?><!----><?php //edit_comment_link( __( '(Edit)', 'fws' ), '<span class="edit-link">', '</span>' ); ?><!--</p>-->
<!--				--><?php
//				break;
//			default :
				// Proceed with normal comments.
				global $post;
				?>
                <li class="commented-list" id="li-comment-<?php comment_ID(); ?>">
                    <article id="comment-<?php comment_ID(); ?>" class="row">
                        <header class="col-md-3">
							<?php
							// user name, email and web page
                            echo '<ul class="comment_author_bio">';

							printf( '<li class="">%1$s %2$s</li>',
								'<a href="mailto:'.get_comment_author_email().'">'.get_comment_author().'</a>'
                                ,comment_author_url(),
								// If current post author is also comment author, make it known visually.
								( $comment->user_id === $post->post_author ) ? '<span> ' . __( '(Post author) ', 'fws' ) . '</span>' : ''
							);
							echo '</ul>';

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
							<?php comment_reply_link( array_merge( $args, array(
								'reply_text' => __( 'odpovědět', 'fws' ),
								'depth'      => $depth,
								'max_depth'  => $args['max_depth']
							) ) ); ?>
                        </div><!-- .reply -->
                    </article><!-- #comment-## -->
                </li>
				<?php
//				break;
//		endswitch; // end comment_type check
	}
endif;

function get_related_author_posts() {
	global $authordata, $post;

	$authors_posts = get_posts( array( 'author' => $authordata->ID, 'post__not_in' => array( $post->ID ), 'posts_per_page' => 5 ) );

	$output = "";
	foreach ( $authors_posts as $authors_post ) {
		$output .= '<a class="external_link" href="' . get_permalink( $authors_post->ID ) . '">' . apply_filters( 'the_title', $authors_post->post_title, $authors_post->ID ) . '</a>';
	}
	return $output;
}

function wp_author_info_box() {
			global $post;

// Detect if it is a single post with a post author
			if ( is_single() && isset( $post->post_author ) ) {

// Get author's display name
				$display_name = get_the_author_meta( 'display_name', $post->post_author );

// If display name is not available then use nickname as display name
				if ( empty( $display_name ) ) {
					$display_name = get_the_author_meta( 'nickname', $post->post_author );
				}

// Get author's biographical information or description
				$user_description = get_the_author_meta( 'user_description', $post->post_author );

// Get author's website URL
				$user_website = get_the_author_meta( 'url', $post->post_author );

// Get link to the author archive page
				$user_posts = get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) );

				if ( ! empty( $display_name ) ) {
					$author_details = '<p class="author_heading">Autor</p><p class="author_name">' . $display_name . '</p>';
				}

				if ( ! empty( $user_description ) ) // Author avatar and bio

				{
					$author_details .= '<p class="author_details">' . get_avatar( get_the_author_meta( 'user_email' ), 200 ,'403',null, array('class' => array('img-responsive', 'img-rounded') )) . nl2br( $user_description ) . '</p>';
				}

//        $author_details .= '<p class="author_links"><a href="'. $user_posts .'">View all posts by ' . $display_name . '</a>';

// Check if author has a website in their profile
				if ( ! empty( $user_website ) ) {

// Display author website link
					$author_details .= ' | <a href="' . $user_website . '" target="_blank" rel="nofollow">Website</a></p>';

				} else {
// if there is no author website then just close the paragraph
					$author_details .= '</p>';
				}

// Pass all this info to post content

				echo ' <footer class="author_bio_section" >' . $author_details . '</footer>';

			}
		}

/**
 * Get authors
 *
 * @see wp_list_authors()
 * @param $args Array
 * @return $authors Array
 */
function artalk_get_authors( $args = '', $letter = '') {
    global $wpdb;
    $letter = get_query_var( 'c' );
    $defaults = array(
        'orderby'       => array('post_count' => 'DESC', 'name' => 'ASC'), // irelevant see usort below
        'number'        => '',
        'exclude'       => '',
        'include'       => '',
        'fields'        => 'all',
        'hide_empty'    => false,
    );

    $args = wp_parse_args( $args, $defaults );
    $query_args = wp_array_slice_assoc( $args, array( 'orderby', 'number', 'exclude', 'include', 'fields' ) );
    if ( ! $authors = get_users( $query_args ) )
        return array();
    $author_count = array();
    foreach ( (array) $wpdb->get_results( "SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE " . get_private_posts_cap_sql( 'post' ) . " GROUP BY post_author" ) as $row ) {
        $author_count[$row->post_author] = $row->count;
    }
    foreach ( $authors as $author_index => $author ) {
        $posts = isset( $author_count[$author->ID] ) ? $author_count[$author->ID] : 0;
        if ( ! $posts && $args['hide_empty'] ) {
            unset($authors[$author_index]);
        }
    }
    // sort by last name
    usort($authors, create_function('$a, $b', 'return strnatcasecmp(remove_accents($a->last_name), remove_accents($b->last_name));'));
    //echo $authors->data->display_name;

    //echo $filtered = array_filter($array, create_function('$a', 'return $a[0] == "' . $letter . '";'));
    $authors= array_filter($authors, create_function('$a', 'return remove_accents(end((explode(\' \',$a->data->display_name))))[0] == "' . $letter . '";'));
    //array_filter($authors, 'GetNamesByLetter use($that)');
    return $authors;
    //var_dump($authors);
}


function author_letter_line() {
    foreach (range('A', 'Z') as $char) {
        echo '<a href="'.esc_url( add_query_arg( 'c', $char ) ).'">'.$char . " ".'</a>';
    }
}