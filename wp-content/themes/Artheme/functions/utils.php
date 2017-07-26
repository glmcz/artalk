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
function short_title($after = '', $length) {
	$mytitle = explode(' ', get_the_title(), $length);
//	$title = explode(' ', get_the_title(), $length);
	if (count($mytitle)>=$length) {
		array_pop($mytitle);
		$mytitle = implode(" ",$mytitle). $after;
	} else {
		$mytitle = implode(" ",$mytitle);
	}
	return $mytitle;
}
function short_title_text($text, $after = '', $length) {
	$mytitle = explode(' ', $text, $length);
//	$title = explode(' ', get_the_title(), $length);
	if (count($mytitle)>=$length) {
		array_pop($mytitle);
		$mytitle = implode(" ",$mytitle). $after;
	} else {
		$mytitle = implode(" ",$mytitle);
	}
	return $mytitle;
}

function ns_filter_avatar($avatar, $id_or_email, $size, $default, $alt, $args)
{
	$headers = @get_headers( $args['url'] );
	if( ! preg_match("|200|", $headers[0] ) ) {
		return;
	}
	return $avatar;
}
add_filter('get_avatar','ns_filter_avatar', 10, 6);

function the_contents(){
	$html = "";
	// Create DOM from string
	$html = str_get_html(get_the_content_without_citate());
	//global
	$arr_citate_under_text = array();
	$arr_citate_anchors    = array();
	$arr_citate_replace    = array();
	$cont                  = "";
	if($html->find(' * [href^=#_ftnref] ')){
	//	                    find citate text under post
		foreach($html->find(' * [href^=#_ftnref] ') as $element) {
			$arr_citate_under_text[] = $element->parent();
		}
		//					anchors from text content
		foreach ($html->find('p a[name^=_ftn]') as $el) {
			$a = str_get_html( $el );
			foreach ( $a->find( 'a[name^=_ftnref]' ) as $link ) {
				$arr_citate_anchors[] = $link->outertext;
			}
		}
		for ($i = 0; $i < count($arr_citate_under_text);$i++){
			$arr_citate_replace[$i] = $arr_citate_anchors[$i] . '<div class="citate_left">' . $arr_citate_under_text[$i] . '</div>' ;
			//						deleted matched citate text under post
			$cont = get_the_content_without_citate($arr_citate_under_text[$i], $cont,"","","");
			//						moved citate text under post behind anchors in text
			$cont = get_the_content_with_formatting_replace($arr_citate_anchors[$i], $arr_citate_replace[$i], $cont,"","","");
		}
		echo $cont;
	}else {
		the_content();
	}
}

function get_the_content_without_citate ($citate='', $ref_content='', $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
	if($ref_content == ''){
		$content = get_the_content($more_link_text, $stripteaser, $more_file);
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		$content = str_replace($citate, '' ,$content);
		return $content;
	}
	else {
		$content = $ref_content;
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		$content = str_replace($citate, '' ,$content);
		return $content;
	}
}
function get_the_content_with_formatting_replace ($citate='' , $replace,  $ref_content='', $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
	if($ref_content == ''){
		$content = get_the_content($more_link_text, $stripteaser, $more_file);
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		$content = str_replace($citate, $replace ,$content);
		return $content;
	}
	else {
		$content = $ref_content;
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		$content = str_replace($citate, $replace ,$content);
		return $content;
	}
}


//function get_the_content_reformatted ($var, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
//	$content = get_the_content($more_link_text, $stripteaser, $more_file);
//	$content = apply_filters('the_content', $content);
//	$content = str_replace(range(700,1400), $var, $content);
//	return $content;
//}

// regex pokusy

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


// responsive images auto class
//function add_image_responsive_class($content) {
//	global $post;
//	$pattern ="/<img(.*?)class=\"(.*?)\"(.*?)>/i";
//	$replacement = '<img$1class="$2 img-responsive"$3>';
//	$content = preg_replace($pattern, $replacement, $content);
//	return $content;
//}
//add_filter('get_the_content', 'add_image_responsive_class');
//

//function remove_comment_fields($fields) {
//	unset($fields['comment-notes']);
//	return $fields;
//}
//add_filter('comment_form_default_fields','remove_comment_fields');

//function fb_unautop_references( $content ) {
//
//    $content =  preg_replace('<a href="_ftnref">', '<b class="class"> </b>', $content);
//    return $content;
//}
//add_filter( 'the_content', 'fb_unautop_references', 98 );

// end regex pokus;


//apply_filters('the_content',get_the_content()) ;

//function filter_images($content){
//	return preg_replace('/<img (.*) \/>\s*/iU', '<div class="col-md-12 responsive"><img \1 /></div>', $content);
//}
//add_filter('the_content', 'filter_images');
//add_theme_support( 'post-thumbnails' );
remove_filter( 'the_content', 'wp_make_content_images_responsive' );

function add_custom_query_var( $vars ){
    $vars[] = "c";
    return $vars;
}
add_filter( 'query_vars', 'add_custom_query_var' );

