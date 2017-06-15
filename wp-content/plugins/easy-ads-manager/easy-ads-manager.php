<?php
/*
Plugin Name: easy ads manager
Plugin URI:  http://mohamedshokry.com/easy-ads-manager
Description: easy ads is a free advertisement plugin to manage , add and remove ads easily way to wordpress.
Version:     1.0.1
Author:      shokry055
Author URI:  http://mohamedshokry.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: easy-ads-manager
*/
/* secure */ 
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
	define('GETTEMPLATEPTHTOPLUG_ADS', get_template_directory().'/');
/* enqueues - admin */
	function easy_ads_manager_admin_eq() {
		if ( is_rtl() ){
		wp_enqueue_style( 'mian-css-admin_ads', plugin_dir_url( __FILE__ ) . 'css/easy-ads-manager.css' );
		wp_enqueue_style( 'mian-css-admin_rtl_ads', plugin_dir_url( __FILE__ ) . 'css/rtl.css' );
		}else{
		wp_enqueue_style( 'mian-css-admin_ads', plugin_dir_url( __FILE__ ) . 'css/easy-ads-manager.css' );
		}
		wp_enqueue_style('jquery-ui-datepicker-style', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css');
		wp_enqueue_style( 'font_awesom-admin_ads', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );
		?>
	<script type="text/javascript">
		var pluginurl_ads = '<?php echo plugin_dir_url( __FILE__ ); ?>',
			path_ads = '<?php echo get_home_path(); ?>';
	</script>
	<?php
		wp_enqueue_media();
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script( 'ajax-script_ads', plugin_dir_url( __FILE__ ) .'js/easy-ads-manager.js', array('jquery') );
		wp_localize_script( 'ajax-script_ads', 'ajax_object',
		array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}
	add_action( 'admin_enqueue_scripts', 'easy_ads_manager_admin_eq' );
/* enqueues - front */
	function easy_ads_front_enqueue_style() {
		wp_enqueue_style( 'mian-css-front_ads', plugin_dir_url( __FILE__ ) . 'css/easy-ads-manager-front.css' );
		wp_enqueue_script( 'owl-carousel-easy-ads', plugin_dir_url( __FILE__ ) .'js/owl.carousel.min.js', array('jquery') );
		wp_enqueue_script( 'call-carousel-easy-ads', plugin_dir_url( __FILE__ ) .'js/easy-ads-manager-front.js', array('jquery') );
	}
	add_action( 'wp_enqueue_scripts', 'easy_ads_front_enqueue_style' );
/* main structure */
	include( plugin_dir_path( __FILE__ ) . 'options_admin.php');
/* include functions */
	include( plugin_dir_path( __FILE__ ) . 'easy-ads-functions.php');
/* easy language */
	function easy_ads_manager_internationalization() {
		load_plugin_textdomain('easy-ads-manager', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
	add_action( 'plugins_loaded', 'easy_ads_manager_internationalization' );