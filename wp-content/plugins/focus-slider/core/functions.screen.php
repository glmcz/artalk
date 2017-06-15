<?php
/*
 * Create Welcome Screen
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !class_exists( 'FOCUSWP_SLIDER_SCREEN' ) ){
	class FOCUSWP_SLIDER_SCREEN{

		public function __construct() {
			add_action( 'admin_enqueue_scripts', array($this, 'enqueue') );
			add_action( 'admin_menu', array($this, 'screen_page') );
			add_action('activated_plugin', array($this, 'redirect'));
			add_action('admin_head', array($this, 'remove_menu'));
			add_filter( 'admin_footer_text', array( $this, 'admin_footer'   ), 1, 2 );
		}

		function enqueue(){
			if ( !isset( $_GET['page'] ) || 'focuswp-getting-started' != $_GET['page'] )
			return;

			wp_enqueue_style( 'focuswp-welcome', plugins_url( 'assets/css/welcome.css' , dirname(__FILE__) ) , array(), null );
		}

		function screen_page(){
			add_dashboard_page(
				__( 'Getting started with Focus', 'focuswp' ),
				__( 'Getting started with Focus', 'focuswp' ),
				apply_filters( 'focuwp_welcome_cap', 'manage_options' ),
				'focuswp-getting-started',
				array( $this, 'welcome_content' )
			);
		}

		function welcome_head(){
			$selected = isset( $_GET['page'] ) ? $_GET['page'] : 'focuswp-getting-started';
			?>
			<h1><?php _e( 'Welcome to Focus', 'focuswp' ); ?></h1>
			<div class="about-text">
				<?php _e( 'Thank you for choosing Focus - a multi purpose Featured Slider Shortcode and Widget that allows you to spotlight your posts and display them elegantly anywhere you want.', 'focuswp' ); ?>
			</div>
			<div class="focuswp-badge">
				<span class="dashicons dashicons-image-flip-horizontal"></span>
				<span class="version"><?php _e( 'Version', 'focuswp' );?> <?php echo FOCUSWP_SLIDER_VERSION; ?></span>
			</div>
			<h2 class="nav-tab-wrapper">
				<a class="nav-tab <?php echo $selected == 'focuswp-getting-started' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'focuswp-getting-started' ), 'index.php' ) ) ); ?>">
					<?php _e( 'Getting Started', 'focuswp' ); ?>
				</a>
			</h2>
			<?php
		}

		function welcome_content(){ ?>
			<div class="wrap about-wrap focuswp-about-wrap">
				<?php $this->welcome_head(); ?>
				<p class="about-description">
					<?php _e( 'Use the tips below to get started then you will be up and running in no time. ', 'focuswp' ); ?>
				</p>

				<div class="feature-section two-col">
					<div class="col">
						<h3><?php _e( 'Creating Your Focus Powered Featured Content' , 'focuswp' ); ?></h3>
						<p><?php printf( __( 'Focus makes it very easy for you to add featured posts slider using the WordPress Editor or Widgets. You can follow the video tutorial on the right or read our how to <a href="%s" target="_blank">add your first featured posts content shortcode</a>.', 'focuswp' ), 'http://focus-wp.com/getting-started/' ); ?>
					</div>
					<div class="col">
						<div class="feature-video">
							<iframe width="495" height="278" src="https://player.vimeo.com/video/178769345" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
				</div>

				<div class="feature-section two-col">
					<h3><?php _e( 'See all Focus Features', 'focuswp' ); ?></h3>
					<p><?php _e( 'Focus is both easy to use and extremely powerful. We have tons of helpful features that will give you additional function on your websites by adding featured posts slider.', 'focuswp' ); ?></p>
					<p><a href="http://focus-wp.com/" target="_blank" class="focuswp-features-button button button-primary"><?php _e( 'See all Features', 'focuswp' ); ?></a></p>
				</div>
			</div>
		<?php }

		function redirect($plugin){
			if($plugin=='focus/plugin.php') {
				wp_redirect(admin_url('index.php?page=focuswp-getting-started'));
				die();
			}
		}
		function remove_menu(){
		    remove_submenu_page( 'index.php', 'focuswp-getting-started' );
		}

		function admin_footer( $text ) {

			global $current_screen;
			if ( !empty( $current_screen->id ) && strpos( $current_screen->id, 'focuswp' ) !== false ) {
				$url  = 'http://wordpress.org/plugins/focus/';
				$text = sprintf( __( 'Please rate <strong>Focus</strong> <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on <a href="%s" target="_blank">wordpress.org</a> to help us spread the word. Thank you from Phpbits Creative Studio!', 'focuswp' ), $url, $url );
			}
			return $text;
		}
	}

	new FOCUSWP_SLIDER_SCREEN();
}
?>
