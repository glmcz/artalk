<?php
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