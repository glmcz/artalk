<?php

$set_post_thumbnail_size = true;
$add_retina_sizes        = true;
$retina_appendix         = '-retina';

add_theme_support('post-thumbnails');
add_theme_support( 'html5', array( 'gallery', 'caption' ) );

$sizes = array(
    'thumbnail' => array(350, 220, true),    // grid thumbnails, gallery thumbs, footer feat, b-square feat
    'medium'    => array(470, 440, false),   // photoreport feat, comics
    'large'     => array(1060, 1060, false), // fullsize in post, gallery lightbox
    'avatar'    => array(90, 90, true),      // profile picture
    'featured'  => array(600, 400, true),    // featured image
    'logo'      => array(175, 75, false),    // partners
    'freport'   => array(250, 150, true),  // Cropped to Fotoreport
);

// Register image sizes, eventually with retina support
foreach ($sizes as $name => $atts) {
    $width  = $atts[0];
    $height = $atts[1];
    $crop   = $atts[2] ? array('center','center') : false;
    add_image_size( $name, $width, $height, $crop );
    if ( $add_retina_sizes ) {
        add_image_size( $name.$retina_appendix, $width*2, $height*2, $crop );
    }
}

if ( $set_post_thumbnail_size ) {
    set_post_thumbnail_size( $sizes['thumbnail'][0], $sizes['thumbnail'][1], $sizes['thumbnail'][2] );
}


// Remove paragraphs from around the images and image links inserted into post content
// @see http://wordpress.stackexchange.com/a/8356/2110
add_filter('the_content', 'artalk_unautop_images');
function artalk_unautop_images($content) {

    // do a regular expression replace:
    // find all p tags that have just
    // <p>, maybe white space, maybe link, <imgResize all stuff up to >, maybe link end, maybe whitespace </p>
    // replace it with just the image tag...
    // wrap in div
    $content = preg_replace('/<p>\s*(<a .*>)?\s*(<imgResize .*>)\s*(<\/a>)?\s*<\/p>/iU', '<div class="full-width">'.'\1\2\3'.'</div>', $content);

    // Add class to the image link
    // Replaced with the div wrap above
    // $content = preg_replace('/<a (.*)>\s*<imgResize/iU', '<a class="full-width" '.'\1'.'><imgResize', $content);

    return $content;
}




/* Featured image fallback */
add_filter( 'post_thumbnail_html', 'artalk_thumbnail_fallback', 99, 5 );
function artalk_thumbnail_fallback($html='', $post_id=null, $post_thumbnail_id=null, $size='post-thumbnail', $attr='') {
    // Return unchanged if not empty
    if ( ! empty($html) )
        return $html;
    // Try getting an image from attached images
    if ( $attachments = get_posts('posts_per_page=1&post_type=attachmet&post_parent='.$post_id) )
        return wp_get_attachment_image($attachments[0]->ID,$size,false,$attr);
    // Try getting a (possibly remote) image by parsing the content for imgResize tags
    if ( ! $post = get_post($post_id) )
        return '';
    if ( $img = preg_match_all('/<imgResize.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches) )
        return '<imgResize class="attachment-thumbnail wp-post-image" src="'.$matches[1][0].'" alt="'.esc_attr($post->post_title).'" />';
}


/**
 * Custom gallery output
 *
 */
add_filter( 'post_gallery', 'artalk_post_gallery', 10, 2 );
function artalk_post_gallery($output, $attr) {

    if ( ! is_single() )
        return $output;
    $post = get_post();
    static $instance = 0;
    $instance++;

    $html5 = current_theme_supports( 'html5', 'gallery' );
    $atts = shortcode_atts( array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post ? $post->ID : 0,
        'include'    => '',
        'exclude'    => '',
    ), $attr, 'gallery' );

    // thumbnails size
    $size = 'thumbnail';

    $id = intval( $atts['id'] );

    if ( ! empty( $atts['include'] ) ) {
        $_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( ! empty( $atts['exclude'] ) ) {
        $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    } else {
        $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    }

    if ( empty( $attachments ) ) {
        return '';
    }

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment ) {
            $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
        }
        return $output;
    }

    $selector   = "gallery-{$instance}";
    $thumbnails = '';
    $slides     = '';
    $captions   = '';
    $i          = 0;
    $attachments_count = count($attachments);

    foreach ( $attachments as $id => $attachment ) {
        if ( $i < 4 ) {
            $thumbnails .= "
          <div class='gallery-thumbnail columns small-6'>
            ".wp_get_attachment_image( $id, $size, false )."
          </div>
        ";
        }
        $image_data   = wp_get_attachment_image_src($id,'large',false);
        $image_class  = $image_data['2'] > $image_data['1'] ? 'portrait' : 'landscape';
        $image_src    = esc_url($image_data[0]);
        $active_class = $i ? '':'active';

        $image_alt = trim(strip_tags( get_post_meta($id, '_wp_attachment_image_alt', true) )); // try alt field first
        if ( empty($image_alt) ) // if not, use the caption
            $image_alt = trim(strip_tags( $attachment->post_excerpt ));
        if ( empty($image_alt) ) // finally, use the title
            $image_alt = trim(strip_tags( $attachment->post_title ));

        $image_aria = trim( $attachment->post_excerpt ) ? "aria-describedby='$selector-$id'" : '';

        // @todo remove spinner and error mesagge from the loop
        // @todo consider using html5 figure
        $slides .= "
        <div class='gallery-slide $active_class'>
          <imgResize class='centered-both $image_class' data-lazy='$image_src' alt='$image_alt' $image_aria>
          <div class='spinner centered-both'></div>
          <span class='gallery-imgResize-err-msg centered-both'>
            ".esc_html__('nelze načíst :(','artalk')."
            </span>
        </div>
      ";
        // @todo don't output caption at all if empty?
        // if ( trim($attachment->post_excerpt) ) { ...
        $captions .= "
        <div class='gallery-caption $active_class' data-gallery-caption='$i' id='$selector-$id'>
          ".wptexturize($attachment->post_excerpt)."
        </div>
      ";

        $i++;
    } // @endof foreach $attachments

    $output = "
      <div class='gallery-thumbnails row small-collapse full-width'>
        $thumbnails
        <a class='gallery-open-link' data-artalk-gallery-open='$instance' href='#'>
          <span class='artalk-button centered-both'>
            <span class='gallery-open-icon'></span>
            ".esc_html__('Otevřít galerii','artalk')." [$attachments_count]
            &nbsp;
          </span>
        </a>
      </div>
      <div class='gallery-overlay full-width' data-artalk-gallery='$instance' id='$selector'>
        <div class='row'>
          <div class='columns small-12 medium-9 large-10 gallery-slider'>
            $slides
          </div>
          <div class='columns small-12 medium-3 large-2 gallery-info'>
            <a class='gallery-close-link' href='#' data-artalk-gallery-close>
              <span class='button expand artalk-button show-for-small-only'>
                ".esc_html__('Zpět na článek','artalk')."
              </span>
              <span class='show-for-medium-up icon-close'></span>
            </a>
            <div class='inner'>
              <div class='gallery-counter'><span>1</span>/$attachments_count</div>
              <h2 class='gallery-title'>
                <a href='".esc_url(get_permalink($post->ID))."' data-artalk-gallery-close>
                  ".esc_html(get_the_title($post))."
                </a>
              </h2>
              ".artalk_post_cats($post->ID, '', false)."
              $captions
              ".artalk_share($post->ID, false)."
            </div>
          </div>
        </div>
      </div>
    ";

    return $output;
}