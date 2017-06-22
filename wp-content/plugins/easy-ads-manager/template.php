<?php
/* secure */ 
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
		 if ( have_posts() ) :
			while ( have_posts() ) : the_post();
                $postID = get_the_id(); 
                $count_key = 'easy_ads_manager_views_count';
                $count = get_post_meta($postID, $count_key, true);
                if($count==''){
                    $count = 0;
                    delete_post_meta($postID, $count_key);
                    add_post_meta($postID, $count_key, '0');
                }else{
                    $count++;
                    update_post_meta($postID, $count_key, $count);
                }
                $get_ads_info = get_post_meta( $postID , 'main_easy_ads_array' );
                $link = $get_ads_info[0]['link']['value'];
                    if ( $link == '' OR $link == '#' ){
                        $link = home_url();
                    }
                wp_redirect( $link, 301 ); exit;
			endwhile;
		// If no content, include the "No posts found" template.
		else :
            wp_redirect( home_url() ); exit;
		endif;
?>