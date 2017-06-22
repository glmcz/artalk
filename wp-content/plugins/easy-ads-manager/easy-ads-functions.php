<?php
/* secure */ 
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/* add ads post type */
	function easy_ads_post_type() {
		$labels = array(
			'name'                => _x( 'ads', 'Post Type General Name', 'easy-ads-manager' ),
			'singular_name'       => _x( 'ads', 'Post Type Singular Name', 'easy-ads-manager' ),
			'menu_name'           => __( 'easy ads controll', 'easy-ads-manager' ),
			'name_admin_bar'      => __( 'easy ads controll', 'easy-ads-manager' ),
			'parent_item_colon'   => __( 'Parent Item:', 'easy-ads-manager' ),
			'all_items'           => __( 'All Items', 'easy-ads-manager' ),
			'add_new_item'        => __( 'Add New Item', 'easy-ads-manager' ),
			'add_new'             => __( 'Add New', 'easy-ads-manager' ),
			'new_item'            => __( 'New Item', 'easy-ads-manager' ),
			'edit_item'           => __( 'Edit Item', 'easy-ads-manager' ),
			'update_item'         => __( 'Update Item', 'easy-ads-manager' ),
			'view_item'           => __( 'View Item', 'easy-ads-manager' ),
			'search_items'        => __( 'Search Item', 'easy-ads-manager' ),
			'not_found'           => __( 'Not found', 'easy-ads-manager' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'easy-ads-manager' ),
		);
		$args = array(
			'label'               => __( 'ads', 'easy-ads-manager' ),
			'description'         => __( 'easy ads post type', 'easy-ads-manager' ),
			'labels'              => $labels,
			'supports'            => array( ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => false,
			'show_in_menu'        => false,
			'menu_position'       => 80,
			'menu_icon'           => 'https://cdn2.iconfinder.com/data/icons/social-buttons-2/512/link-16.png',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,		
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => false,
			'capability_type'     => 'post',
		);
		register_post_type( 'easy_ads', $args );
	}
	add_action( 'init', 'easy_ads_post_type', 0 );
// Register Custom Taxonomy
	function easy_ads_custom_taxonomy() {

		$labels = array(
			'name'                       => _x( 'easy ads sections', 'Taxonomy General Name', 'easy-ads-manager' ),
			'singular_name'              => _x( 'easy ads section', 'Taxonomy Singular Name', 'easy-ads-manager' ),
			'menu_name'                  => __( 'easy ads sections', 'easy-ads-manager' ),
			'all_items'                  => __( 'All Items', 'easy-ads-manager' ),
			'parent_item'                => __( 'Parent Item', 'easy-ads-manager' ),
			'parent_item_colon'          => __( 'Parent Item:', 'easy-ads-manager' ),
			'new_item_name'              => __( 'New Item Name', 'easy-ads-manager' ),
			'add_new_item'               => __( 'Add New Item', 'easy-ads-manager' ),
			'edit_item'                  => __( 'Edit Item', 'easy-ads-manager' ),
			'update_item'                => __( 'Update Item', 'easy-ads-manager' ),
			'view_item'                  => __( 'View Item', 'easy-ads-manager' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'easy-ads-manager' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'easy-ads-manager' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'easy-ads-manager' ),
			'popular_items'              => __( 'Popular Items', 'easy-ads-manager' ),
			'search_items'               => __( 'Search Items', 'easy-ads-manager' ),
			'not_found'                  => __( 'Not Found', 'easy-ads-manager' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => false,
			'show_ui'                    => false,
			'show_admin_column'          => false,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
		);
		register_taxonomy( 'easy_ads_taxnomy_sections', array( 'easy_ads' ), $args );
	}
	add_action( 'init', 'easy_ads_custom_taxonomy', 0 );
/* post meta function */
	function easy_ads_update_post_meta( $post_id, $field_name, $value = '' )
	{
		if ( empty( $value ) OR ! $value )
		{
			delete_post_meta( $post_id, $field_name );
		}
		elseif ( ! get_post_meta( $post_id, $field_name ) )
		{
			add_post_meta( $post_id, $field_name, $value );
		}
		else
		{
			update_post_meta( $post_id, $field_name, $value );
		}
	}
/* register new tax fields */
	 global $wpdb;
	 $type = 'easy_ads_taxnomy_sections_';
	 $table_name = $wpdb->prefix . $type . 'meta';
	 $variable_name = $type . 'meta';
	 $wpdb->$variable_name = $table_name;
/* creat table on activation */
		 global $wpdb;
		 $type = 'easy_ads_taxnomy_sections_';
		 $table_name = $wpdb->prefix . $type . 'meta';
		 $variable_name = $type . 'meta';
		 $wpdb->$variable_name = $table_name;
		 
		if (!empty ($wpdb->charset))
			$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
		if (!empty ($wpdb->collate))
			$charset_collate .= " COLLATE {$wpdb->collate}";
		$sql = "CREATE TABLE IF NOT EXISTS {$table_name} (meta_id bigint(20) NOT NULL AUTO_INCREMENT,{$type}_id bigint(20) NOT NULL default 0,meta_key varchar(255)DEFAULT NULL,meta_value longtext DEFAULT NULL,UNIQUE KEY meta_id (meta_id)) {$charset_collate};";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);
/* sections meta function */
	function easy_ads_update_section_meta( $post_id, $field_name, $value = '' )
	{
		if ( empty( $value ) OR ! $value )
		{
			$doo = delete_metadata( 'easy_ads_taxnomy_sections_', $post_id , $field_name , $value);
		}
		elseif ( ! get_metadata( 'easy_ads_taxnomy_sections_', $post_id , $field_name ) )
		{
			$doo = add_metadata( 'easy_ads_taxnomy_sections_', $post_id , $field_name , $value );
		}
		else
		{
			$doo = update_metadata( 'easy_ads_taxnomy_sections_', $post_id , $field_name , $value );
		}
		return $doo ;
	}
	// easy views counter
	function get_easy_ads_views_count($postID){
		$count_key = 'easy_ads_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if ($count==''){
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return "0";
		}
		return $count;
	}
	function set_easy_ads_views_count($postID) {
		$count_key = 'easy_ads_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if ($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		} else {
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}
	// Section Shortcode
	function get_easy_adverts_section( $atts ) {
		$atts = shortcode_atts( array(
			'section_id' => '0'
		), $atts, 'easy_adverts_ads' );

		return get_short_code_content($atts['section_id']) ;
	}
	add_shortcode( 'easy_adverts_ads', 'get_easy_adverts_section' );

	// get short content
	function get_short_code_content( $atts="" ){
	// WP_Query arguments
		$get_section_addis = get_metadata( 'easy_ads_taxnomy_sections_', $atts , 'easy_ads_addotionals' );
		$easy_gallery = $get_section_addis[0]['gallery'];
		$easy_max = $get_section_addis[0]['max'];
		$easy_position = $get_section_addis[0]['position'];
        if ( isset( $get_section_addis[0]['random'] ) ){
            $if_is_rand = $get_section_addis[0]['random'] ;
        }else{
            $if_is_rand = '';
        }
        if ( $if_is_rand == "true" ){
            $o_d_b = 'rand';
        }else{
            $o_d_b = 'modified';
        }
		$easy_args = array (
			'posts_per_page'         => $get_section_addis[0]['max'],
			'post_type' 			 => 'easy_ads',
            'orderby'                => $o_d_b,
			'meta_query'             => array(
                'relation' => 'AND',
				array(
					'key'       => 'main_easy_ads_taxonomy_custom_field',
					'value'     => $atts,
					'compare'   => '=',
					'type'      => 'NUMERIC',
				),
				array(
					'key'       => 'main_easy_ads_date_custom_field',
					'value'     => date('Y-m-d'),
					'compare'   => '>=',
					'type'		=> 'DATE'
				)
			),
		);
		$easy_adverts_get_out_ads = new WP_Query( $easy_args );if ( $easy_adverts_get_out_ads->have_posts() ) { ?>
			<div class="easy-adverts-out-ads-holder <?php if ($easy_gallery != "true" AND $easy_position == "harozintal"){echo ' inline-centra ';} ?> <?php if ($easy_gallery == "true" AND $easy_position != "harozintal"){echo ' owl-carousel easy-ads-rotating ';} ?>">
		<?php
			while ( $easy_adverts_get_out_ads->have_posts() ) { $easy_adverts_get_out_ads->the_post();
			$id = get_the_id(); 
			$get_ads_info = get_post_meta( $id , 'main_easy_ads_array' );
			$type = $get_ads_info[0]['type']['value'];
			$width = $get_ads_info[0]['width']['value'];$height = $get_ads_info[0]['height']['value'];
			set_easy_ads_views_count($id);
		?>
			<div class="easy-adverts-out-item <?php if ($easy_gallery != "true" AND $easy_position == "harozintal"){echo ' inline-easy-ads ';} else { echo ' m0auto' ; } ?>" id="e-a-id<?php echo $id ; ?>" <?php if ( !empty($width) AND $easy_gallery != "true" ){ echo 'style="width:'.$width.'px;height:'.$height.'px"' ; }?> >
				<?php if ($type == "image"){ ?>
				<div class="easy-adds-image">
					<a href="<?php echo esc_url( get_permalink($id) ) /*$get_ads_info[0]['link']['value']*/; ?>"  <?php if ($get_ads_info[0]['target']['value'] == "true" ){ echo 'target="_blank"'; } ?> >
						<img <?php if ( !empty($width) AND $easy_gallery != "true" ){ echo 'width="'.$width.'"' ; } if ( !empty($height) AND $easy_gallery != "true" ){ echo 'height="'.$height.'"' ; } ?> src="<?php echo $get_ads_info[0]['image']['value']; ?>" alt="<?php the_title(); ?>" />
					</a>
				</div>
				<?php } elseif ($type == "code"){ ?>
				<div class="easy-adds-code">
					<?php echo $get_ads_info[0]['code']['value']; ?>
				</div>
				<?php } ?>
			</div>	
		<?php
		}
		?>
			</div>
		<?php
		} else {
		_e('no adverts for now', 'easy-ads-manager');
	} wp_reset_postdata() ; } 

// the wedgite function
	class easy_ads_wedgite_class extends WP_Widget {
	function __construct() {
	parent::__construct(
	// Base ID of your widget
	'easy_ads_wedgite_class', 
	// Widget name will appear in UI
	' + - '.__('easy ads adverts', 'easy-ads-manager').' - + ', 
	// Widget description
	array( 'description' => __('easy ads adverts wdgit', 'easy-ads-manager'), ) 
	);
	}
	// Creating widget front-end
	public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	$cat = apply_filters( 'widget_cat', $instance['cat'] );
	echo $args['before_widget'];
	if ( ! empty( $title ) ){
	echo $args['before_title'] . $title . $args['after_title'];
	}
	?>
	<div class="mb10 main-block-cc">
		<?php echo  get_short_code_content( $cat ) ; ?>
	</div>
	<?php
	// before and after widget arguments are defined by themes
	echo $args['after_widget'];
	}
	// Widget Backend 
	public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
	}
	else {
	$title = __( 'easy ads title', 'easy-ads-manager' );
	}
	if ( isset( $instance[ 'cat' ] ) ) {
	$cat = $instance[ 'cat' ];
	}
	else {
	$cat = "";
	}
	// Widget admin form
	?>
	<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php __( 'block title ', 'easy-ads-manager' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		<br />
		<br />
	<label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php __( 'choose advert section ', 'easy-ads-manager' ); ?></label> 
	<select id="<?php echo $this->get_field_id( 'cat' ); ?>" name="<?php echo $this->get_field_name( 'cat' ); ?>"> 
		 <?php 
			$args = array( 'hide_empty' => 0 );
			$terms = get_terms( 'easy_ads_taxnomy_sections', $args );
			 if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
				 foreach ( $terms as $term ) {
				   if ( $cat == $term->term_id ){ $o = 'selected="selected"'; } else { $o = ''; }
				   echo '<option '.$o.'  value="' . $term->term_id . '">' . $term->name . '</option>';
				 }
			 }
		 ?>
	</select>
		<br />
	</p>
	<?php 
	}
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	$instance['cat'] = ( ! empty( $new_instance['cat'] ) ) ? $new_instance['cat'] : '';
	return $instance;
	}
	} 
	function easy_ads_manager_load_widget() {
		register_widget( 'easy_ads_wedgite_class' );
	}
	add_action( 'widgets_init', 'easy_ads_manager_load_widget' );
    /* add ads view */
    function get_custom_post_type_template_easy_ads_manager($single_template) {
         global $post;
         if ($post->post_type == 'easy_ads') {
              $single_template = dirname( __FILE__ ) . '/template.php';
         }
         return $single_template;
    }
    add_filter( 'single_template', 'get_custom_post_type_template_easy_ads_manager' );

?>