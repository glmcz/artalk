<?php

/* 
    Created on : 5.2.2016, 12:02:05
    Author     : Filip Uhlir
    Description: Utils for Artheme
*/

 /**
   * Get current category slug
   */
  function artalk_get_current_category($field='slug') {
    if ( is_search() )
      return 'search';
    if ( ! is_category() )
      return false;
    return get_category(get_query_var('cat'))->slug;
  }

  function artalk_get_post_headings($post=null) {
    if ( ! $post || empty($post->post_content) )
      return array();
    // preg_match_all('|<h[^>]+>(.*)</h[^>]+>|iU', $post->post_content, $headings);
    preg_match_all('|<h2>(.*)</h2>|iU', $post->post_content, $headings);
    if ( empty($headings) || empty($headings[1]) )
      return array();
    $headings = $headings[1];
    $headings = array_map('wp_strip_all_tags',$headings);
    $headings = array_map('artalk_remove_more_tag',$headings);
    $headings = array_map('artalk_remove_headings_numbers',$headings);
    $headings = array_filter($headings);
    return $headings;
  }
  /**
   * Featured posts by Mau
   */
  
  function artalk_get_featured_posts($args='') {

  $defaults = array(
    'post_type'      => 'post',
    'posts_per_page' => 1,
    'meta_key'       => '_mau_feat_order',
    'orderby'        => '_mau_feat_order',
    'order'          => 'ASC',
  );
  $args = wp_parse_args( $args, $defaults );
  $featured = get_posts( $args );
  $feat_count = count($featured );

  // add up missing places from normal posts
  if ( $feat_count < $args['posts_per_page'] ) {
    unset($args['meta_key']);
    $args['posts_per_page'] = $args['posts_per_page'] - $feat_count;
    $args['orderby'] = 'post_date';
    $args['order']   = 'DESC';
    $featured = array_merge( $featured, (array) get_posts($args) );
  }

  return $featured;
}

/**
   * Custom excerpt output by Mau
   */
  function artalk_get_the_excerpt( $post_ID = null, $excerpt_length = null , $excerpt_more = null, $allowed_tags = '<a>', $trimChar = null ) {

  	//global $post;
  	$post_obj = get_post($post_ID);
  	if ( ! $post_obj )
  		return false;

    if ( ! $excerpt_length = absint($excerpt_length) )
      $excerpt_length = apply_filters('excerpt_length', 55);

    if ( ! is_string($excerpt_more) )
      $excerpt_more = apply_filters('excerpt_more', ' ...');

    $text = empty( $post_obj->post_excerpt ) ? $post_obj->post_content : $post_obj->post_excerpt;

    $text = strip_shortcodes( $text );
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
    $text = strip_tags($text,$allowed_tags);

    $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if ( count($words) > $excerpt_length ) {
        array_pop($words);
        $text = implode(' ', $words);
        if ($trimChar && $trimChar < strlen ( $text )){
            $text = mb_substr($text,0,$trimChar);
        }

        $text = $text . $excerpt_more;
    } else {
        $text = implode(' ', $words);
    }

    $text = force_balance_tags($text);

    $text = wpautop($text);

  	return $text;

  }
  /* FOOTER */
	add_action( 'artalk_copyright', 'artalk_copyright' );
	function artalk_copyright() {
		$s_year = 2007;
		$c_year = date('Y');
		$year = $s_year == $c_year ? $s_year : "$s_year - $c_year";
		echo "&copy; COPYRIGHT $year Artalk.cz. Jakékoliv užití obsahu včetně převzetí, šíření či dalšího zpřístupňování článků a fotografií je bez souhlasu Artalk z.s., zakázáno.";
	}

/**
 * Popular Posts by Destrosvet
 */

function recent_popular_posts($post_id) {
    $count_key = 'popular_posts';
    $count = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}
function recent_track_posts($post_id) {
    if (!is_single()) return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    recent_popular_posts($post_id);
}
add_action('wp_head', 'recent_track_posts');

function template_part( $atts, $content = null ){
    $tp_atts = shortcode_atts(array(
        'path' =>  null,
    ), $atts);
    ob_start();
    get_template_part($tp_atts['path']);
    $ret = ob_get_contents();
    ob_end_clean();
    return $ret;
}
add_shortcode('template_part', 'template_part');

function load_template_part($template_name, $part_name=null) {
    ob_start();
    get_template_part($template_name, $part_name);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}

function feat_get_author( $post_id = 0 ){
    $post = get_post( $post_id );
    return $post->post_author;
}