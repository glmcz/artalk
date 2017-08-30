<?php
/**
 * Created by Teapot.
 * User: Filip Uhlir
 * Date: 01.02.2017
 * Time: 11:04
 */
?>
<?php //if ( is_active_sidebar( 'featured-widget' ) ) : ?>

    <div class="col-md-6 nopadding nomargin" id="featured">

        <?php


            dynamic_sidebar( 'featured-widget' );
            do_action(artalk_feature());
        ?>

    </div>

<?php //endif; ?>