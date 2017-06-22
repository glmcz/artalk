<?php
/* secure */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
// menu actions 
add_action('admin_menu', 'easy_ads_create_menu');
if (!isset($get_value)){ $get_value = ""; }
// create master menus
function easy_ads_create_menu() {
    add_menu_page( 'easy adds options', __( 'Easy Adverts', 'easy-ads-manager' ), 'manage_options', 'easy-ads', 'easy_ads_control_section', plugin_dir_url( __FILE__ ) .'imgs/icon.png' );
	add_submenu_page( 'easy-ads', __('adverts sections & places','easy-ads-manager'), __('adverts sections & places','easy-ads-manager'), 'manage_options', 'easy-ads-main-sections', 'easy_ads_section_control_section' );
}
//footer function
function easy_ads_footer(){ 
    echo '<div class="repeater-footer">';
    $f_text = __( 'all rights reserved for %s ','easy-ads-manager');
    echo sprintf( $f_text , get_bloginfo( 'name' ) )  ;
    echo '</div>';
}
//register settings function
function easy_ads_control_section(){ global $get_value;
?>
<div class="wrap repeater-container">
    <div class="repeater-header">
        <h2><?php _e( 'Easy Adverts', 'easy-ads-manager' ) ?></h2>
        <small><?php _e( 'Adverts Control ', 'easy-ads-manager' ); ?></small>
    </div>
<?php 
	if ( isset( $_POST['easy_ads_update'] ) ) { /// if update ads 
    $post_information = array(
      	'ID'           => wp_strip_all_tags( $_POST['easy_ads_id'] ),
		'post_title' => wp_strip_all_tags( $_POST['easy_ads_title'] ),
        'post_content' => '',
    );
    $the_post_id = wp_update_post( $post_information );
	easy_ads_update_post_meta( $the_post_id, 'main_easy_ads_array', $_POST['main_easy_ads_array'] );
		
	$txo_santa = sanitize_text_field( $_POST['main_easy_ads_taxonomy_custom_field'] );
	$date_santa = sanitize_text_field( $_POST['main_easy_ads_date_custom_field'] );
	$date_santa = substr($date_santa, 6, 4).'-'.substr($date_santa, 3, 2).'-'.substr($date_santa, 0, 2);
		
	easy_ads_update_post_meta( $the_post_id, 'main_easy_ads_taxonomy_custom_field', $txo_santa );
	easy_ads_update_post_meta( $the_post_id, 'main_easy_ads_date_custom_field', $date_santa );
	$added = "true";
	$message = __('the advert has been updated','easy-ads-manager');
	echo '<meta http-equiv="refresh" content="1">';
	}
	if ( isset( $_POST['easy_ads_submit'] ) ) { /// if add ads 
    $post_information = array(
        'post_title' => sanitize_text_field( $_POST['easy_ads_title'] ),
        'post_content' => '',
        'post_type' => 'easy_ads',
        'post_status' => 'publish'
    );
    $the_post_id = wp_insert_post( $post_information );
	easy_ads_update_post_meta( $the_post_id, 'main_easy_ads_array', $_POST['main_easy_ads_array'] );
		
	$txo_santa = sanitize_text_field( $_POST['main_easy_ads_taxonomy_custom_field'] );
	$date_santa = sanitize_text_field( $_POST['main_easy_ads_date_custom_field'] );
	$date_santa = substr($date_santa, 6, 4).'-'.substr($date_santa, 3, 2).'-'.substr($date_santa, 0, 2);
		
	easy_ads_update_post_meta( $the_post_id, 'main_easy_ads_taxonomy_custom_field', $txo_santa );
	easy_ads_update_post_meta( $the_post_id, 'main_easy_ads_date_custom_field', $date_santa );
	$added = "true";
	$message = __('the advert has been added','easy-ads-manager');
	echo '<meta http-equiv="refresh" content="1">';
	}
	if ( isset( $_POST['easy_remove_submit'] ) ) { /// if remove ads 
	$id_to_remove = $_POST['removed_ads_id'];
	wp_delete_post( $id_to_remove, true );
	$added = "true";
	$message = __('the advert was successfully removed','easy-ads-manager');
	echo '<meta http-equiv="refresh" content="1">';
	}
	if ( isset( $_POST['easy_edite_submit'] ) ) { /// if update ads
		$post_id = $_POST['edite_ads_id'];
	$args = array ('post_type' => array( 'easy_ads' ),'p' => $post_id,'posts_per_page'=> '1',);$get_single_ads = new WP_Query( $args );if ( $get_single_ads->have_posts() ) {	while ( $get_single_ads->have_posts() ) {
		$get_single_ads->the_post();
		$modify = 'true';
		$advert_title = get_the_title();
		$id = get_the_id(); $get_data = get_post_meta( $id , 'main_easy_ads_array' );
		$get_taxnomy = get_post_meta( $id , 'main_easy_ads_taxonomy_custom_field' );
		$get_date = get_post_meta( $id , 'main_easy_ads_date_custom_field' );
	}} else {}wp_reset_postdata();}
	if ( isset( $added ) ){ $added = $added ; } else { $added = '' ; }
	if ( isset( $modify ) ){ $modify = $modify ; } else { $modify = '' ; }
?>
			<form action="" id="easy-main-form-add-ads" method="POST">
				<div class="main-options-cc">
					<div class="headline-option">
					<?php if ($modify == "true"){ ?>
						<?php _e('edite Advert','easy-ads-manager'); ?>
					<?php } else { ?>
						<?php _e('Add New Advert','easy-ads-manager'); ?>
					<?php } ?>
					</div>
					<?php if ($added == "true"){ ?>
					<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> <?php echo $message;  ?></div>
					<?php  } ?>
					<div class="row-option">
					<?php $get_ads_value = ''; if ($modify == "true"){ $get_value = $advert_title ; } ?>
						<div class="col-1">
							<?php _e('Add Name','easy-ads-manager'); ?>
						</div>
						<div class="col-2">
						<input type="text" name="easy_ads_title" id="easy_ads_title" class="required" placeholder="<?php _e('Add Name','easy-ads-manager'); ?>" value="<?php echo $get_value; ?>" required="required" />
						<p class="desc"><?php _e('the name of your advert','easy-ads-manager'); ?></p>
						</div>
					</div>
					
					<div class="row-option"><!-- option image or code -->
						<div class="col-1">
							<?php _e('advert type','easy-ads-manager'); ?>
						</div>
						<div class="col-2">
						<?php $get_ads_value = ''; if ($modify == "true"){ $get_ads_value = $get_data[0]['type']['value'] ; $get_ads_main_type = $get_ads_value ; } else { $get_ads_main_type = '' ; $get_ads_value = '' ; } ?>
                        <input type="hidden" name="main_easy_ads_array[type][key]" value="type">
						<input type="hidden" value="image" name="main_easy_ads_array[type][value]" />
						<input type="checkbox" <?php if ( $get_ads_value == "code" ){echo 'checked="checked"' ; } ?> id="type_choose_check_id" class="inline-inner type-choose" value="code" name="main_easy_ads_array[type][value]" />
						<label for="type_choose_check_id" id="easy_ads_toggle-check"><span></span></label>
							<p class="desc"><?php _e('choose advert type ( click to change )','easy-ads-manager'); ?></p>
						</div>
					</div>
					
					<div class="row-option imagewcode <?php if ( $get_ads_main_type == "code" ){ echo 'remove-ss' ; } ?>" id="easy-image-select-section"><!-- option image -->
						<div class="col-1">
							<?php _e('advert Image','easy-ads-manager'); ?>
						</div>
						<div class="col-2">
						<?php $get_ads_value = ''; if ($modify == "true"){ $get_ads_value = $get_data[0]['image']['value'] ; } ?>
						<?php if ( empty($get_ads_value) ){ $get_ads_value = plugin_dir_url( __FILE__ ) .'imgs/no.png' ; } ?>
                        <input type="hidden" name="main_easy_ads_array[image][key]" value="Image">
                        <img src="<?php echo $get_ads_value; ?>" id="previmg" class="prv-image" alt="img" />
                        <input type="hidden" name="main_easy_ads_array[image][value]" id="easy_ads_image_url" class="inline-fields" value="<?php echo $get_ads_value; ?>">
                        <button type="button" class="easy_ads_upload-btn inline-fields"><i class="fa fa-plus"></i> <span><?php _e('add / change image','easy-ads-manager'); ?></button>
                        <button type="button" class="easy_ads_remove-btn inline-fields"><i class="fa fa-close"></i> <span><?php _e('remove image','easy-ads-manager'); ?></button>
                    <p class="desc"><?php _e('choose image to be the advert','easy-ads-manager'); ?></p>
						</div>
					</div>
					
					<div class="row-option imagewcode <?php if ( $get_ads_main_type == "image" OR empty($get_ads_main_type) ){ echo 'remove-ss' ; } ?>" id="easy-code-select-section"><!-- option image -->
						<div class="col-1">
							<?php _e('advert Code','easy-ads-manager'); ?>
						</div>
						<div class="col-2">
						<?php $get_ads_value = ''; if ($modify == "true"){ $get_ads_value = $get_data[0]['code']['value'] ; } ?>
						<?php if ( empty($get_ads_value) ){ $get_ads_value = ''; } ?>
                        <input type="hidden" name="main_easy_ads_array[code][key]" value="Image">
						<textarea id="easy_code_easy_editor" name="main_easy_ads_array[code][value]"><?php echo $get_ads_value; ?></textarea>
                    <p class="desc"><?php _e('choose code to be the advert','easy-ads-manager'); ?></p>
						</div>
					</div>
							
					<div class="row-option"><!-- option link -->
						<div class="col-1">
							<?php _e('advert link','easy-ads-manager'); ?>
						</div>
						<div class="col-2">
						<?php $get_ads_value = ''; if ($modify == "true"){ $get_ads_value = $get_data[0]['link']['value'] ; } ?>
						<?php if ( empty($get_ads_value) ){ $get_ads_value = '#' ; } ?>
                        <input type="hidden" name="main_easy_ads_array[link][key]" value="width">
						<input type="text" name="main_easy_ads_array[link][value]" value="<?php echo $get_ads_value; ?>" placeholder="<?php _e('link','easy-ads-manager'); ?>" />
                    	<p class="desc"><?php _e('the link that open when click the ads','easy-ads-manager'); ?></p>
						</div>
					</div>

					<div class="row-option"><!-- option target -->
						<div class="col-1">
							<?php _e('new windows link','easy-ads-manager'); ?>
						</div>
						<div class="col-2">
						<?php $get_ads_value = ''; if ($modify == "true"){ $get_ads_value = $get_data[0]['target']['value'] ; } ?>
						<?php if ( empty($get_ads_value) ){ $get_ads_value = '' ; } ?>
                        <input type="hidden" name="main_easy_ads_array[target][key]" value="target">
						<input type="hidden" value="false" name="main_easy_ads_array[target][value]" />
						<input <?php if ($get_ads_value == "true"){echo 'checked="checked"' ; } ?> type="checkbox" id="is_new-windows_check_id" class="inline-inner megacheackbox" value="true" name="main_easy_ads_array[target][value]" />
						<label for="is_new-windows_check_id" id="new-windows-check"><span></span></label>
							<p class="desc"><?php _e('open the link in new windows choose true or false','easy-ads-manager'); ?></p>
						</div>
					</div>
							
					<div class="row-option"><!-- option width -->
						<div class="col-1">
							<?php _e('image size ( width )','easy-ads-manager'); ?>
						</div>
						<div class="col-2">
						<?php $get_ads_value = ''; if ($modify == "true"){ $get_ads_value = $get_data[0]['width']['value'] ; } ?>
						<?php if ( empty($get_ads_value) ){ $get_ads_value = '' ; } ?>
                        <input type="hidden" name="main_easy_ads_array[width][key]" value="width">
						<input type="number" name="main_easy_ads_array[width][value]" value="<?php echo $get_ads_value; ?>" placeholder="<?php _e('width','easy-ads-manager'); ?>" />
                    	<p class="desc"><?php _e('leave it blank if responsive','easy-ads-manager'); ?></p>
						</div>
					</div>
							
					<div class="row-option"><!-- option height -->
						<div class="col-1">
							<?php _e('image size ( height )','easy-ads-manager'); ?>
						</div>
						<div class="col-2">
						<?php $get_ads_value = ''; if ($modify == "true"){ $get_ads_value = $get_data[0]['height']['value'] ; } ?>
						<?php if ( empty($get_ads_value) ){ $get_ads_value = '' ; } ?>
                        <input type="hidden" name="main_easy_ads_array[height][key]" value="height">
						<input type="number" name="main_easy_ads_array[height][value]" value="<?php echo $get_ads_value; ?>" placeholder="<?php _e('height','easy-ads-manager'); ?>" />
                    	<p class="desc"><?php _e('leave it blank if responsive','easy-ads-manager'); ?></p>
						</div>
					</div>

					<div class="row-option"><!-- option date -->
						<div class="col-1">
							<?php _e('advert end date','easy-ads-manager'); ?>
						</div>
						<div class="col-2">
						<?php $get_ads_value = ($modify == 'true' ? date('d-m-Y', strtotime($get_date[0])) : date('d-m-Y', strtotime('+1 month')));	?>
						<input type="text" id="easy-ads-date-start" name="main_easy_ads_date_custom_field" value="<?php echo $get_ads_value; ?>" />
                    	<p class="desc"><?php _e('choose the date that the advert end ','easy-ads-manager'); ?></p>
						</div>
					</div>

					<div class="row-option"><!-- option section -->
						<div class="col-1">
							<?php _e('advert section & place','easy-ads-manager'); ?>
						</div>
						<div class="col-2">

						<?php $get_ads_value = ''; if ($modify == "true"){ $get_ads_value = $get_taxnomy[0] ; } ?>
						<?php if ( empty($get_ads_value) ){ $get_ads_value = '' ; }
							$args = array( 'hide_empty' => 0 );
							$terms = get_terms( 'easy_ads_taxnomy_sections', $args );
							?>
						<select name="main_easy_ads_taxonomy_custom_field">
							<?php 
							 if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
								 foreach ( $terms as $term ) {
							 	   if ( $get_ads_value == $term->term_id ){ $o = 'selected="selected"'; } else { $o = ''; }
								   echo '<option '.$o.'  value="' . $term->term_id . '">' . $term->name . '</option>';
								 }
							 }
							?>
						</select>
                    	<p class="desc"><?php _e('link advert to section ( choose ) ','easy-ads-manager'); ?></p>
						</div>
					</div>
					<?php if ($modify == "true"){ ?>
						<input type="hidden" name="easy_ads_id" value="<?php echo get_the_id(); ?>" />
					<?php } ?>
				<fieldset class="easy-ads-submits">
					<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
					<?php if ($modify == "true"){ ?>
					<input type="hidden" name="easy_ads_update" id="easy_ads_submit" value="true" />
					<button type="submit" class="save_field_button"><i class="fa fa-save"></i> <span><?php _e('Save The advert','easy-ads-manager'); ?></span></button>
					<?php } else { ?>
					<input type="hidden" name="easy_ads_submit" id="easy_ads_submit" value="true" />
					<button type="submit" class="save_field_button"><i class="fa fa-plus"></i> <span><?php _e('Add The advert','easy-ads-manager'); ?></span></button>
					<?php } ?>
				</fieldset>
							
				</div>
			</form>
			<br />
			<div class="headline-option">
				<?php _e('Adverts Control','easy-ads-manager'); ?>
			</div>
					
			<div class="easy-ads-container-all">
			<?php $args = array ('post_type'=> array( 'easy_ads' ),'posts_per_page'=> '150'); $get_ads = new WP_Query( $args );if ( $get_ads->have_posts() ) { while ( $get_ads->have_posts() ) { $get_ads->the_post(); 
				  $id = get_the_id();
				  $get_typez = get_post_meta( $id , 'main_easy_ads_array' );
				  $get_type = $get_typez[0]['type']['value'];
                  $clicks_countt = get_post_meta($id, 'easy_ads_manager_views_count' , true);
                  if( empty( $clicks_countt ) ){ $clicks_countt = 0 ;  }
			      $get_typex = get_post_meta( $id , 'main_easy_ads_taxonomy_custom_field' );
				  $get_term_d = get_term( $get_typex[0], 'easy_ads_taxnomy_sections','','');
				  if ( !empty($get_term_d) ){$get_term_n = $get_term_d->name;} else {$get_term_n = __('no section selected','easy-ads-manager');}
				?>
				<div class="advert-item">
					<div class="easy-ads-remove inline-tools-ads"><form action="" method="POST">
					<input type="hidden" value="<?php the_id(); ?>" name="removed_ads_id" />
					<button type="submit" name="easy_remove_submit" class="easy-ads-remove-advert"><i class="fa fa-close"></i></button>
					</form></div>
					<div class="easy-ads-edite inline-tools-ads"><form action="" method="POST">
					<input type="hidden" value="<?php the_id(); ?>" name="edite_ads_id" />
					<button type="submit" name="easy_edite_submit" class="easy-ads-edite-advert"><i class="fa fa-pencil"></i></button>
					</form></div>
					<?php 
					$id = get_the_id(); $img_or_code = get_post_meta( $id , 'main_easy_ads_array' );
					$sec_id = $get_typex;
					?>
					<div class="easy-ads-title inline-tools-ads"><?php the_title(); ?><br /><b><?php echo $get_term_n ; ?>
					<span><i class="fa fa-eye"></i> : <?php echo get_easy_ads_views_count($id) ?>
					<br />
					<i class="fa fa-hand-pointer-o"></i> : <?php echo $clicks_countt ;  ?>
					</span>
					</b></div>
					<div class="easy-ads-image">
						<?php if ( $get_type == "code" ){ ?>
						<?php echo $img_or_code[0]['code']['value'] ; ?>
						<?php } else { ?>
						<img src="<?php echo $img_or_code[0]['image']['value'] ; ?>" alt="<?php the_title(); ?>" />
						<?php } ?>
					</div>
				</div>
			<?php }} else { ?>
				<div class="alert alert-danger" role="alert"><i class="fa fa-close"></i> <?php _e('there is no adverts for now','easy-ads-manager'); ?></div>
			<?php }wp_reset_postdata(); ?>
			</div>
					
	<?php echo easy_ads_footer(); ?>
	</div>
	<?php }
/*sections functions*/

function easy_ads_section_control_section(){ global $get_value;
// Check to see if correct form is being submitted, if so continue to process
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['delete'] ) &&  $_POST['delete'] == "delet_term") {
	if ( isset($_POST['removed_section_id']) ){
		$added = "deleted";
		$id_to_delete = $_POST['removed_section_id'];
		wp_delete_term( $id_to_delete, 'easy_ads_taxnomy_sections' );
		echo '<meta http-equiv="refresh" content="1">';
	} else {
       	$added = "false";  
	}
		echo '<meta http-equiv="refresh" content="1">';
}										
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['modify'] ) &&  $_POST['modify'] == "modify_term") {
	if ( isset($_POST['update_section_id']) ){
	$modify = 'true';
	$get_term_infoes = get_term( $_POST['update_section_id'], 'easy_ads_taxnomy_sections');
	$get_term_data = get_metadata( 'easy_ads_taxnomy_sections_', $_POST['update_section_id'] , 'easy_ads_addotionals' );
	} else {
       	$added = "false";  
		echo '<meta http-equiv="refresh" content="1">';
	}
}
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['update'] ) &&  $_POST['update'] == "update_term") {
	if ( isset($_POST['updatableid']) ){
		$the_updetable_id = $_POST['updatableid'];
		$the_upditable_name = sanitize_text_field( $_POST['easy_ads_term'] );
		$the_upditable_slug = str_replace(" ","-",$the_upditable_name);
		wp_update_term($the_updetable_id, 'easy_ads_taxnomy_sections', array(
		  'name' => $the_upditable_name,
		  'slug' => $the_upditable_slug
		));
		$doo = easy_ads_update_section_meta( $the_updetable_id, 'easy_ads_addotionals', $_POST['easy_ads_addotionals'] );
		$added = "updated";
	} else {
       	$added = "false";  
	}
		echo '<meta http-equiv="refresh" content="1">';
}
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['new'] ) &&  $_POST['new'] == "new_term") {
    // Check to see if input field for new term is set 
    if (isset ($_POST['easy_ads_term'])) {
        // If set, stores user input in variable
        $new_term =  sanitize_text_field ( $_POST['easy_ads_term'] );
        // Function to handle inserting of new term into taxonomy
        $returen_v = wp_insert_term(
          $new_term,
          // The easy_ads_taxnomy_sections taxonomy
          'easy_ads_taxnomy_sections'        
        );
	 if (array_key_exists('term_id', $returen_v)){
		$dooo = easy_ads_update_section_meta( $returen_v['term_id'], 'easy_ads_addotionals', $_POST['easy_ads_addotionals'] );
		$added = "true";
		echo '<meta http-equiv="refresh" content="1">';
		} else {
       	$added = "eroor"; 
		$error_msg = $returen_v;
		echo '<meta http-equiv="refresh" content="6">';
		}
		} else { 
        // Else throw an error message
       	$added = "false";  
		echo '<meta http-equiv="refresh" content="1">';
    }
}
if ( isset( $added ) ){ $added = $added ; } else { $added = '' ; }
if ( isset( $modify ) ){ $modify = $modify ; } else { $modify = '' ; }
?>
<div class="wrap repeater-container">
    <div class="repeater-header">
        <h2><?php _e( 'Easy Adverts', 'easy-ads-manager' ) ?></h2>
        <small><?php _e( 'sections Control ', 'easy-ads-manager' ); ?></small>
    </div>
	<div class="main-options-cc">
		<div class="headline-option">
			<?php if ($modify == "true"){?> 
			<?php _e('Edite Advert','easy-ads-manager'); ?>
			<?php } else { ?>
			<?php _e('Add New Advert','easy-ads-manager'); ?>
			<?php } ?>
		</div>
		<?php if ($added == "true"){ ?>
		<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> <?php _e('the section was successfully added','easy-ads-manager'); ?></div>
		<?php  } elseif ($added == "false"){ ?>
		<div class="alert alert-danger" role="alert"><i class="fa fa-close"></i> <?php _e('there is an error','easy-ads-manager'); ?></div>
		<?php  } elseif ($added == "deleted"){ ?>
		<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> <?php _e('the section has been deleted ','easy-ads-manager'); ?></div>
		<?php  } elseif ($added == "updated"){ ?>
		<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> <?php _e('the section has been updated ','easy-ads-manager'); ?></div>
		<?php  } elseif ($added == "eroor"){ ?>
		<div class="alert alert-danger" role="alert"><i class="fa fa-close"></i> <?php print_r($error_msg) ; ?></div>
		<?php  } ?>
		<form id="insert_term" name="insert_term" method="post" action=""> 
			<div class="row-option"><!-- option width -->
				<div class="col-1">
					<?php _e('place or section name','easy-ads-manager'); ?>
				</div>
				<?php $get_section_value = ''; if ($modify == "true"){ $get_section_value = $get_term_infoes->name; } ?>
				<?php if ( empty($get_section_value) ){ $get_section_value = '' ; } ?>
				<div class="col-2">
					<?php if ( empty($get_section_value) ){ $get_section_value = '' ; } ?> 
				<input type="text" name="easy_ads_term" value="<?php echo $get_section_value; ?>" placeholder="<?php _e('place or section name','easy-ads-manager'); ?>" required="required" />
				<p class="desc"><?php _e('leave it blank if responsive','easy-ads-manager'); ?></p>
				</div>
			</div>
			<div class="row-option"><!-- option gallery -->
				<div class="col-1">
					<?php _e('this section is gallery','easy-ads-manager'); ?>
				</div>
				<?php $get_section_value = ''; if ($modify == "true"){ $get_section_value = $get_term_data[0]['gallery']; } ?>
				<?php if ( empty($get_section_value) ){ $get_section_value = '' ; } ?>
				<div class="col-2">
				<input type="hidden" value="false" name="easy_ads_addotionals[gallery]" />
				<input <?php if ( $get_section_value == "true" ){ echo 'checked="checked"' ; } ?> type="checkbox" id="is_gellery_check_id" class="inline-inner megacheackbox" value="true" name="easy_ads_addotionals[gallery]" />
				<label for="is_gellery_check_id" id="toggle-check"><span></span></label>
					<p class="desc"><?php _e('check it if is gallery','easy-ads-manager'); ?></p>
				</div>
			</div>
			<div class="row-option"><!-- option random -->
				<div class="col-1">
					<?php _e('Random Adverts','easy-ads-manager'); ?>
				</div>
				<?php $get_section_value = ''; if ($modify == "true"){ $get_section_value = $get_term_data[0]['random']; } ?>
				<?php if ( empty($get_section_value) ){ $get_section_value = '' ; } ?>
				<div class="col-2">
				<input type="hidden" value="false" name="easy_ads_addotionals[random]" />
				<input <?php if ( $get_section_value == "true" ){ echo 'checked="checked"' ; } ?> type="checkbox" id="is_random_check_id" class="inline-inner megacheackbox" value="true" name="easy_ads_addotionals[random]" />
				<label for="is_random_check_id" id="toggle-check"><span></span></label>
					<p class="desc"><?php _e('Display Adverts By Random Order','easy-ads-manager'); ?></p>
				</div>
			</div>
			<div class="row-option"><!-- option position -->
				<div class="col-1">
					<?php _e('ads display position','easy-ads-manager'); ?>
				</div>
				<?php $get_section_value = ''; if ($modify == "true"){ $get_section_value = $get_term_data[0]['position']; } ?>
				<?php if ( empty($get_section_value) ){ $get_section_value = '' ; } ?>
				<div class="col-2">
                    <div class="easy-ads-radios-image">
                        <div>
                        <input <?php if ( $get_section_value == "vertical" OR empty($get_section_value) ){ echo 'checked="checked"' ; } ?> id="easy-radio-select-1" type="radio" name="easy_ads_addotionals[position]" value="vertical" />
                        <label for="easy-radio-select-1"><img src="<?php echo plugin_dir_url( __FILE__ ) .'imgs/ver.png' ; ?>" alt="img" /></label>
                        </div>
                        <div>
                        <input <?php if ( $get_section_value == "harozintal" ){ echo 'checked="checked"' ; } ?> id="easy-radio-select-2" type="radio" name="easy_ads_addotionals[position]" value="harozintal" />
                        <label for="easy-radio-select-2"><img src="<?php echo plugin_dir_url( __FILE__ ) .'imgs/har.png' ; ?>" alt="img" /></label>
                        </div>
					</div>
				<p class="desc"><?php _e('choose the type of ads inline or underline <br/ > if you choose inline the gallery will not work and the ads appers inline','easy-ads-manager'); ?></p>
				</div>
			</div>
				<?php $get_section_value = ''; if ($modify == "true"){ $get_section_value = $get_term_data[0]['max']; } ?>
				<?php if ( empty($get_section_value) ){ $get_section_value = '10' ; } ?>
			<div class="row-option"><!-- option max -->
				<div class="col-1">
					<?php _e('max number of ads to show','easy-ads-manager'); ?>
				</div>
				<div class="col-2">
				<input type="number" value="<?php echo $get_section_value ; ?>" name="easy_ads_addotionals[max]" />
					<p class="desc"><?php _e('choose tha max number of ads to show','easy-ads-manager'); ?></p>
				</div>
			</div>
			<fieldset class="easy-ads-submits">
			<?php if ($modify == "true"){?> 
				<input type="hidden" value="<?php echo $get_term_infoes->term_id; ?>" name="updatableid" />
				<input type="hidden" name="update" value="update_term" />
				<button type="submit" class="save_field_button"><i class="fa fa-save"></i> <span><?php _e('Save section','easy-ads-manager'); ?></span></button>
			<?php } else { ?>
				<input type="hidden" name="new" value="new_term" />
				<button type="submit" class="save_field_button"><i class="fa fa-plus"></i> <span><?php _e('Add section','easy-ads-manager'); ?></span></button>
			<?php } ?>
			</fieldset>
		</form>
		<br />
		<div class="headline-option">
			<?php _e('sections & places','easy-ads-manager'); ?>
		</div>
		<div class="easy-sections-container-all">
			<?php 
			$args = array( 'hide_empty' => 0 );
			$terms = get_terms( 'easy_ads_taxnomy_sections', $args );
			 if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
				 foreach ( $terms as $term ) {
						$get_section_addis = get_metadata( 'easy_ads_taxnomy_sections_', $term->term_id , 'easy_ads_addotionals' );
						$is_gallery = $get_section_addis[0]['gallery'];
						$is_random = $get_section_addis[0]['random'];
						$is_position = $get_section_addis[0]['position'];
						$max = $get_section_addis[0]['max'];
					?>
					<div class="easy-section-holder">
					<form class="easy-section-inline" action="" method="POST">
					<input type="hidden" value="<?php echo $term->term_id ; ?>" name="removed_section_id" />
					<input type="hidden" name="delete" value="delet_term" />
					<button type="submit" name="easy_remove_submit" class="easy-remove-section"><i class="fa fa-close"></i></button>
					</form>
					<form class="easy-section-inline" action="" method="POST">
					<input type="hidden" value="<?php echo $term->term_id ; ?>" name="update_section_id" />
					<input type="hidden" name="modify" value="modify_term" />
					<button type="submit" name="easy_update_submit" class="easy-update-section"><i class="fa fa-pencil"></i></button>
					</form>
					<span class="easy-section-inline easy-section-info-name"><?php _e('name','easy-ads-manager'); ?> : <?php echo $term->name ; ?></span>
					<label for="easy-shortcode-label"><?php _e('shortcode','easy-ads-manager'); ?> : </label>
					<input id="easy-shortcode-label" type="text" readonly class="easy-section-inline easy_ads-short" value="[easy_adverts_ads section_id='<?php echo $term->term_id ; ?>']" />
					<span class="easy-section-inline easy-section-info-gallery"><?php _e('gallery','easy-ads-manager'); ?> : <?php if ($is_gallery == "true"){ echo '<i class="fa fa-check"></i>' ; } else { echo '<i class="fa fa-close"></i>' ; } ?></span>
					<span class="easy-section-inline easy-section-info-random"><?php _e('random','easy-ads-manager'); ?> : <?php if ($is_random == "true"){ echo '<i class="fa fa-check"></i>' ; } else { echo '<i class="fa fa-close"></i>' ; } ?></span>
					<span class="easy-section-inline easy-section-info-position"><?php _e('position','easy-ads-manager'); ?> : <?php if ($is_position == "harozintal"){ echo '<i class="fa fa-ellipsis-h"></i>' ; } else { echo '<i class="fa fa-ellipsis-v"></i>' ; } ?></span>
					<span class="easy-section-inline easy-section-info-max"><?php _e('max number','easy-ads-manager'); ?> : <?php echo $max ; ?></span>
					</div>
				   <?php
				 }
			 } else { ?>
				<div class="alert alert-danger" role="alert"><i class="fa fa-close"></i> <?php _e('there is no sections for now','easy-ads-manager'); ?></div>
			 <?php } ?>
		</div>
	</div>
	<?php echo easy_ads_footer(); ?>
	</div>
<?php }