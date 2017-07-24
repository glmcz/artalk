<?php

//function getImage() {
//    global $more;
//    $more = 1;
//    $link = get_permalink();
//    $content = get_the_content();
//    $count = substr_count($content, '<img');
//
//    for($i=1;$i<=$count;$i++) {
//	    //move $start = 0 inside the loop
//	    $start = 0;
//	    $imgBeg = strpos($content, '<img', $start);
//	    $post = substr($content, $imgBeg);
//	    $imgEnd = strpos($post, '>');
//	    $postOutput = substr($post, 0, $imgEnd+1);
//	    $postOutput = preg_replace('/width="([0-9]*)" height="([0-9]*)"/', 'width="136%" height="400px"',$postOutput);;
//	    if(stristr($postOutput,'<img')) { echo $postOutput; }
//	    $content = substr($content,$imgEnd+1);
//    }
//    $more = 0;
//}
//add_filter( 'img_caption_shortcode', 'cleaner_caption', 10, 3 );


//size-full
//add_image_size('size-full', 600, 300, true);
//function cleaner_caption( $output, $attr, $content ) {
//
//	/* We're not worried abut captions in feeds, so just return the output here. */
//	if ( is_feed() )
//		return $output;
//
//	/* Set up the default arguments. */
//	$defaults = array(
//		'id' => '',
//		'align' => 'alignnone',
//		'width' => '200',
//		'caption' => ''
//
//	);
//
//	/* Merge the defaults with user input. */
//	$attr = shortcode_atts( $defaults, $attr );
//
//	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
//	if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
//		return $content;
//
//	/* Set up the attributes for the caption <div>. */
//	$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
//	$attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . '"';
//	$attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';
//
//	/* Open the caption <div>. */
//	$output = '<div' . $attributes .'>';
//
//	/* Allow shortcodes for the content the caption was created for. */
//	$output .= do_shortcode( $content );
//
//	/* Append the caption text. */
//	$output .= '<p class="wp-caption-text">' . $attr['caption'] . '</p>';
//
//	/* Close the caption </div>. */
//	$output .= '</div>';
//
//	/* Return the formatted, clean caption. */
//	return $output;
//}

//function my_image_replacement($the_content) {
//	global $post;
//	if (has_post_thumbnail()) {
//		$the_content = get_the_post_thumbnail($post->ID, 'my-custom-image-size');
//		// other stuff as necessary
//	}
//
//	return $the_content;
//}
//add_filter('the_content', 'my_image_replacement', 11);

//add_image_size('lrg-hdr', 1170, 544, true);
//add_image_size('med-hdr', 750, 400, true);
//add_image_size('sml-hdr', 500, 325, true);
add_image_size('size-full', 900, 600, true);
add_action( 'after_setup_theme', 'artalk_theme_init', 10 );

function get_the_content_with_formatting ($citate='', $ref_content='', $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
	if($ref_content == ''){
		$content = get_the_content($more_link_text, $stripteaser, $more_file);
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		$content = str_replace($citate, "",$content);
		return $content;
	}
	else {
		$content = $ref_content;
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		$content = str_replace($citate, "",$content);
		return $content;
	}
}
function artalk_theme_init() {

	/* INIT */
	include_once('functions/init.php');

	/* ASSETS */
	include_once('functions/assets.php');

    /* TEMPLATE PARTS */
    include_once('functions/template-part.php');

    /* RECENT ITEMS */
    include_once('functions/recent-items.php');

	/* CITACE  */
	include_once ('simple_html_dom.php');

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