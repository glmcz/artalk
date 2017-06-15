<?php

/* L10N */
  load_theme_textdomain( 'artalk', get_stylesheet_directory() . '/languages' );


/* NAVIGATION */
// Topbar menu
  add_filter('show_admin_bar', '__return_false');
  // Menus
  register_nav_menus( array(
    'main-menu' => 'Main Menu',
    'header-news-menu'     => 'Header News',
    'right-hand-menu'      => 'Right Hand Menu',
    'footer-menu'          => 'Footer Menu',
  ) );


/* WIDGETS */
    add_action( 'widgets_init', 'artalk_widgets_init' );
    function artalk_widgets_init() {
      register_sidebar( array(
      'name'         => __('Sidebar 1st half','artalk'),
      'id'           => 'sidebar-1',
      'description'  => __('Widgets in this area will be shown on first half of page on all posts and pages.','artalk'),
      'before_title' => '<h3>',
      'after_title'  => '</h3>',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      ) );
  }

add_action( 'widgets_init', 'artalk_widgets_init02' );
function artalk_widgets_init02() {
    register_sidebar( array(
        'name'         => __('Sidebar 2nd half','artalk'),
        'id'           => 'sidebar-2',
        'description'  => __('Widgets in this area will be shown on second half of page on all posts and pages.','artalk'),
        'before_title' => '<h3>',
        'after_title'  => '</h3>',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
    ) );
}
add_action( 'widgets_init', 'artalk_widgets_init03' );
function artalk_widgets_init03() {
    register_sidebar( array(
        'name'         => __('Featured widget','artalk'),
        'id'           => 'featured-widget',
        'description'  => __('Widgets for featured posts','artalk'),
        'before_title' => '<h3>',
        'after_title'  => '</h3>',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
    ) );
}


  /* BODY CLASS */
/*  add_filter( 'body_class', 'artalk_body_class' );
  function artalk_body_class( $classes ) {
    // Category specific color themes
    $classes[] = artalk_in_artservis() ? 'theme-artservis':'theme-magazine';
    return $classes;
  }
*/
/* REQUEST */
 /* add_filter( 'request', 'artalk_request');

  function artalk_request( $request ) {

    if ( is_admin() )
      return $request;

    $dummy_query = new WP_Query();
    $dummy_query->parse_query( $request );

    // Load only Magazine posts on home page
    // Ignore featured posts on home
    // @TODO get cat dynamicaly
    if ( $dummy_query->is_home() ) {
      $request['category_name']='arena'; // magazine
      $request['post__not_in'] = artalk_get_featured_posts(array('fields'=>'ids'));
      $request['artalk_home'] = 1;
    }

    // Ignore featured posts in the artalk.service archive
    // @TODO get cat dynamicaly
    if ( $dummy_query->is_category('artservis') ) {
      $request['post__not_in'] = array( artalk_get_photoreport_feat_id() );
      $request['category__not_in'] = array( artalk_get_top5_cat_id() );
    }

    // Load all posts on comics archive
    if ( $dummy_query->is_post_type_archive('artalk_comics') ) {
      $request['nopaging']=1;
    }

    return $request;
  }*/

  /**
   * Checks whether custom homepage query var has been set
   */
  function artalk_is_home() {
    global $wp_query;
    return isset($wp_query->query['artalk_home']) && $wp_query->query['artalk_home'];
  }

/* REDIRECTS */
  // @TODO maybe move all to post types plugin???
  add_action('template_redirect','artalk_redirects');
  function artalk_redirects() {

    // redirect magazine archive to homepage
    // @TODO get cat name dynamicaly
    if ( is_category('arena') && ! artalk_is_home() ) {
      wp_safe_redirect( get_home_url() );
      exit;
    }
    // redirect comics single to the archive, add hash
    if ( is_singular('artalk_comics') ) {
      $post = get_post();
      wp_safe_redirect( get_post_type_archive_link('artalk_comics').'#'.$post->post_name );
      exit;
    }
    // redirect blacksquare single to the archive, add hash
    // @TODO check pt name
    if ( is_single() && in_category('black-square') ) {
      $post = get_post();
      wp_safe_redirect( get_category_link('black-square').'#'.$post->post_name );
      exit;
    }
  }

/* EXCERPTS */
  add_filter( 'excerpt_length', 'artalk_excerpt_length', 99 );
  add_filter( 'excerpt_more', 'artalk_excerpt_more' );
  function artalk_excerpt_length() {
    return 18;
  }
  function artalk_excerpt_more() {
    return ' ...';
  }

/* PAGINATION */
  add_filter( 'next_posts_link_attributes', 'artalk_next_posts_attr' );
  function artalk_next_posts_attr( $attr ) {
    return 'id="next-posts" class="next-posts-link"';
  }


/* LOGIN PAGE */
  add_action('login_head', 'artalk_login_logo');
  function artalk_login_logo() {
      $primary_color   = '#2A49FF';
      $secondary_color = '#FF3E6C';
      $bg_color        = '#E6E6E6';
      echo '<style type="text/css">
          h1 {display:none}
          body {background:'.$bg_color.';}
          #login {padding: 5% 0 0 0;}
          .login form {
            border:none;
            box-shadow:none;
            background: '.$bg_color.' url('.get_stylesheet_directory_uri().'/assets/images/artalk_logo_small_t2x.png) center 10px no-repeat !important;
            padding-top:100px !important;
            padding-bottom:20px;
          }
          .login label {text-transform:uppercase; color:#aaa; }
          .login form .input, .login input[type="text"] {background:#FFF; padding: 5px 10px;}
          .wp-core-ui .button.button-large, .wp-core-ui .button-group.button-large .button {
            width:100%;text-transform:uppercase;
          }
          .wp-core-ui .button-primary {background:'.$primary_color.'; border:none;}
          .wp-core-ui .button-primary:hover {background: '.$primary_color.';}
          input[type=checkbox]:focus, input[type=email]:focus, input[type=number]:focus, input[type=password]:focus, input[type=radio]:focus, input[type=search]:focus, input[type=tel]:focus, input[type=text]:focus, input[type=url]:focus, select:focus, textarea:focus {
            border-color: #fff;
            box-shadow:none;
          }
          input[type=checkbox]:checked:before,.login #backtoblog a:hover,.login #nav a:hover,.login h1 a:hover {
            color: '.$primary_color.';
          }
          #login form p.submit {margin-top: 30px;}
          .login #nav {margin:0; text-align:center;}
          .login #backtoblog {display:none;}
          .login form .forgetmenot label {text-transform:none;}
          .login #nav a {color:#bbb;}
      </style>';
  }