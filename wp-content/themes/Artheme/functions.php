<?php


//function get_the_content_reformatted ($var, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
//	$content = get_the_content($more_link_text, $stripteaser, $more_file);
//	$content = apply_filters('the_content', $content);
//	$content = str_replace(range(700,1400), $var, $content);
//	return $content;
//}

//add_action( 'init', 'wpse34528_add_page_cats' );
//function wpse34528_add_page_cats(){
//    register_taxonomy_for_object_type('post_tag', 'single');
//    register_taxonomy_for_object_type('category', 'single');
//}

function add_image_responsive_class($content) {
	global $post;
	$pattern ="/<img(.*?)class=\"(.*?)\"(.*?)>/i";
	$replacement = '<img$1class="$2 img-responsive"$3>';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}
function fb_unautop_4_img( $content ) {

    $content = preg_replace(
        '/<p>\\s*?(<a rel=\"attachment.*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s',
        '<figure class="thumb">$1</figure>',
        $content
    );

    return $content;
}
add_filter( 'the_content', 'fb_unautop_4_img', 99 );


//function fb_unautop_references( $content ) {
//
//    $content =  preg_replace('<a href="_ftnref">', '<b class="class"> </b>', $content);
//    return $content;
//}
//add_filter( 'the_content', 'fb_unautop_references', 98 );


//function wpb_tags() {
//	$string  = ' ';
//	$wpbtags = get_tag();
//	foreach ( $wpbtags as $tag ) {
//		$string .= '<span class="tagbox"><a class="taglink" href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a></span>' . "\n";
//	}
//	echo $string;
//}
//    $tags = get_the_tag_list();
//    $html = '<div class="post_tags">';
//    foreach ( $tags as $tag ) {
//        $tag_link = get_tag_link( $tag->term_id );
//
//        $html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
//        $html .= "{$tag->name}</a>";
//    }
//    $html .= '</div>';
//    echo $html;

//}
//add_shortcode('wpbtags' , 'wpb_tags' );

function ns_filter_avatar($avatar, $id_or_email, $size, $default, $alt, $args)
{
	$headers = @get_headers( $args['url'] );
	if( ! preg_match("|200|", $headers[0] ) ) {
		return;
	}
	return $avatar;
}
add_filter('get_avatar','ns_filter_avatar', 10, 6);

function wp_author_info_box() {
    global $post;

// Detect if it is a single post with a post author
    if ( is_single() && isset( $post->post_author ) ) {

// Get author's display name
        $display_name = get_the_author_meta( 'display_name', $post->post_author );

// If display name is not available then use nickname as display name
        if ( empty( $display_name ) )
            $display_name = get_the_author_meta( 'nickname', $post->post_author );

// Get author's biographical information or description
        $user_description = get_the_author_meta( 'user_description', $post->post_author );

// Get author's website URL
        $user_website = get_the_author_meta('url', $post->post_author);

// Get link to the author archive page
        $user_posts = get_author_posts_url( get_the_author_meta( 'ID' , $post->post_author));

        if ( ! empty( $display_name ) )

            $author_details = '<p class="author_heading">Autor</p><p class="author_name">' . $display_name . '</p>';

        if ( ! empty( $user_description ) )
// Author avatar and bio

            $author_details .= '<p class="author_details">' . get_avatar( get_the_author_meta('user_email') , 90,'404' ) . nl2br( $user_description ). '</p>';

//        $author_details .= '<p class="author_links"><a href="'. $user_posts .'">View all posts by ' . $display_name . '</a>';

// Check if author has a website in their profile
        if ( ! empty( $user_website ) ) {

// Display author website link
            $author_details .= ' | <a href="' . $user_website .'" target="_blank" rel="nofollow">Website</a></p>';

        } else {
// if there is no author website then just close the paragraph
            $author_details .= '</p>';
        }

// Pass all this info to post content

       echo ' <footer class="author_bio_section" >' . $author_details . '</footer>';
        echo '<a class="widget_single" href="'. $user_posts .'">Další články autora</a>';
     global $query_string;
    query_posts( $query_string . '&posts_per_page=5' );

    while (have_posts()) : the_post();
    ?>
    <a class="external_link" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
    <?php
    endwhile;



    }

}






//add_filter('the_content', 'add_image_responsive_class');
//function filter_images($content){
//	return preg_replace('/<img (.*) \/>\s*/iU', '<span class="className"><b><img \1 /></b></span>', $content);
//}
//
//add_filter('the_content', 'filter_images');
//function filter_p($content){
//    return preg_replace('/<p>\s*/iU', '<span class="class"> </span>', $content);
//}
//
//add_filter('the_content', 'filter_p');

//function insert_inline_style( $content = null ){
//
//	if( null === $content )
//		return $content;
//
//	return str_replace( '<p>', '<p style="color:red;width: 200px;">', $content );
//
//}
//add_filter( 'the_content', 'insert_inline_style', 10, 1 );

if ( ! isset( $content_width ) ) {
    $content_width = 400;
}

include ('aqua_res.php');
add_action( 'after_setup_theme', 'artalk_theme_init', 10 );
function artalk_theme_init() {

	/* INIT */
	include_once('functions/init.php');

	/* ASSETS */
	include_once('functions/assets.php');

    /* TEMPLATE PARTS */
    include_once('functions/template-part.php');

    /* RECENT ITEMS */
    include_once('functions/recent-items.php');

	/* MEDIA */
	//include_once('functions/media.php');

	/* TEMPLATE TAGS */
	//include_once('functions/template_tags.php');

	/* BLACKSQUARE */
	//include_once('functions/blacksquare.php');

	/* FEATURED POSTS */
	//include_once('functions/featured.php');

	/* RELATED POSTS */
	//include_once('functions/related_posts.php');

	/* AJAX LOADER */
	//include_once('functions/ajax_loader.php');

	/* NAVIGATION */
	// include_once('functions/nav.php');

	/* SHORTCODES */
	// include_once('functions/shortcodes.php');

	/* SEARCH */
	// include_once('functions/search.php');

	/* UTILITIES */
	include_once('functions/utils.php');

	/* ADMIN */
	/*if ( is_admin() )
		include_once('functions/admin.php');
         *
         */

	/* DEVELOPMENT */
	/*if ( current_user_can('update_core') )
		include_once('functions/develop.php');
         
         */

	/* DEBUGGING */
	if ( WP_DEBUG && current_user_can('update_core') )
		include_once('functions/debug.php');


}