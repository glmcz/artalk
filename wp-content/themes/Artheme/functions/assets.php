<?php

add_action('wp_enqueue_scripts', 'artalk_assets');


/* SCRIPTS */
function artalk_assets(){
	global $wp_query;
	$dir = get_stylesheet_directory_uri();
	$ver = '1.0.23';
	$deps = array();

	// modernizr
	/*wp_enqueue_script(
		'modernizr',
		$dir.'/bower_components/foundation/js/vendor/modernizr.js',
		array(),
		$ver,
		false
	);
	$deps[] = 'modernizr';*/
	// webfontloader
	wp_enqueue_script(
		'jquery',
		$dir.'/assets/scripts/jquery-2.2.0.min.js',
		array(),
		$ver,
		false
	);
	$deps[] = 'jquery';
        
	// webfontloader
	wp_enqueue_script(
		'webfontloader',
		$dir.'/assets/scripts/webfontloader/webfont.js',
		array(),
		$ver,
		false
	);
	$deps[] = 'webfontloader';
        
        // scripts for home
        if ( is_home() || is_category( array('artservis','arena','magazine') ) || is_single() ) {
                    $theme_scripts = array(
                        'slick.min',
                    'artalk.featured'
            );
            foreach ( $theme_scripts as $script_handle ) {
                    wp_enqueue_script(
                            $script_handle,
                            $dir.'/assets/scripts/'.$script_handle.'.js',
                            $deps,
                            $ver,
                            true
                    );
                    $deps[] = $script_handle;
            }
        }

	/*// fastclick
	wp_enqueue_script(
		'fastclick',
		$dir.'/bower_components/foundation/js/vendor/fastclick.js',
		array(),
		$ver,
		true
	);
	$deps[] = 'fastclick';*/

	// foundation
	/*wp_enqueue_script(
		'foundation',
		$dir.'/bower_components/foundation/js/foundation.min.js',
		array('modernizr','jquery','fastclick'),
		$ver,
		true
	);
	$deps[] = 'foundation';*/

	//@TODO rewrite is_single() to a custom artalk_has_gallery() check
	/*if ( is_home() || is_category( array('artservis','arena','magazine') ) || is_single() ) {

		// slick
		wp_enqueue_style('slick', $dir.'/bower_components/slick.js/slick/slick.css', array(), $ver);
		wp_enqueue_script(
			'slick',
			$dir.'/bower_components/slick.js/slick/slick.min.js',
			array('jquery'),
			$ver,
			true
		);
		$deps[] = 'slick';
	}

	if ( is_home() || is_archive() || is_search() || is_author() ) {

		// masonry
		wp_enqueue_script('jquery-masonry');
		$deps[] = 'jquery-masonry';

		// handlebars
		wp_enqueue_script(
			'handlebars',
			$dir.'/assets/vendor/handlebars.min.js',
			array(),
			'3.0.0',
			true
		);
		$deps[] = 'handlebars';

		// imagesLoaded
		wp_enqueue_script(
			'imagesloaded',
			$dir.'/bower_components/imagesloaded/imagesloaded.pkgd.min.js',
			array(),
			'3.1.8',
			true
		);
		$deps[] = 'imagesloaded';
	}*/

	// main style, dashicons & scripts
	/*wp_enqueue_style('artalk', $dir.'/style.css', array( 'dashicons' ), $ver);
	$theme_scripts = array(
		'artalk.gallery',
		'artalk.navigation',
		'artalk.featured',
		'artalk.loader',
		'artalk.utils',
		'mau.sticky', // @TODO move to vendors
		'artalk',
	);
	foreach ( $theme_scripts as $script_handle ) {
		wp_enqueue_script(
			$script_handle,
			$dir.'/assets/scripts/build/'.$script_handle.'.min.js',
			$deps,
			$ver,
			true
		);
		$deps[] = $script_handle;
	}*/


	/*wp_localize_script( 'artalk', 'ArtalkL10n', array(
		'loading'   => __('Načítám...','artalk'),
		'thats_all' => __("No more posts",'artalk'),
	) );

	wp_localize_script( 'artalk', 'ArtalkData', array(
		'query' => (object) $wp_query->query,
	) );*/

}