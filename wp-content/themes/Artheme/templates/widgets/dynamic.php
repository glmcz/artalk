
<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>

	<div id="sidebar-widgets" class="row primary-sidebar widget-area" role="complementary">

		<?php dynamic_sidebar( 'sidebar-1' ); ?>

	</div>

<?php endif; ?>