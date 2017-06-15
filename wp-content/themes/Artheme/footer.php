  </div><!--//main_container-->
	<footer class="art-footer">
		<div class="container">
			<nav>
				<?php wp_nav_menu(array('theme_location'=>'footer-menu','menu_class'=>'footer-menu')); ?>
			</nav>
            <p class="information">
				<?php do_action('artalk_copyright'); ?>
			</p>
		</div>
	</footer>

</div><!--//row-fluid-->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/cs_CZ/sdk.js#xfbml=1&version=v2.3";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
<?php wp_footer(); ?>
</body>
</html>



