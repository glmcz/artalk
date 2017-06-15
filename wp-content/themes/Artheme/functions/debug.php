<?php

// add_filter( 'request', 'mau_debug_request', 999 );
function mau_debug_request( $request ) {

	if ( is_admin() )
		return $request;

	// $request['posts_per_page'] = 10;

    error_log('REQUEST:');
	error_log(print_r($request,1));

	$dummy_query = new WP_Query();
    $dummy_query->parse_query( $request );
	error_log('QUERY:');
	error_log(print_r($dummy_query,1));

	return $request;
}

// add_action( 'wp_footer', 'mau_debug_query' );
function mau_debug_query() {
	global $wp_query;
	$q = $wp_query;
	unset($q->posts);
	echo '<pre>'.print_r($q,1).'</pre>';
}