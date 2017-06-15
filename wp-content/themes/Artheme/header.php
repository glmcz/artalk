<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
    <head> 
        <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>          
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" title="no title" charset="utf-8"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
        <script>document.documentElement.className = 'doc-not-ready';</script>
        <?php wp_head(); ?>
<!--        <script>
		var artalkFontActiveCallback = jQuery.Callbacks();
		 WebFont.load({
		     custom: { families: ['SimplonNorm'] },
		     active: function () { artalkFontActiveCallback.fire(); },
		 });
	    </script>-->
    </head>
    <body>
        <div class="row-fluid">
        <div class="container">
            <h1 class="site-title hidden"><?php bloginfo('name'); ?></h1>
            <a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php do_action('artalk_logo'); ?>
            </a>
            <?php
                if ( is_home() ) {
                    echo (artalk_get_current_category());
                } else
                {
                     echo (artalk_get_current_category());
                }
                ?>
        </div>
        <nav class="navbar-art">
            <div class="container nopadding navbar-art-container">
                <?php wp_nav_menu(array(
                        'theme_location' => 'main-menu',
//                        'container_class'   => 'navbar-collapse collapse',
                        'menu_class'        => 'nav navbar-nav'
                    )); ?>

            </div>
        </nav>
        <div class="container post-container">
