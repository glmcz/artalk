<?php
/**
 * Recent comment and article
 * User: Filip Uhlir
 * Date: 20.01.2017
 * Time: 15:30
 */
?>


<div class="row">
    <div class="col-md-12 col-xs-12 recent-header norightpadding">
        <div class="col-md-6 noleftpadding">
            <h5>Nejnovější komentáře</h5>
        </div>
        <div class="col-md-6">
            <h5>Nejčtenější články</h5>
        </div>
    </div>
    <div class="col-md-6  col-xs-12 side-recent-item">
        <?php bg_recent_comments(); ?>
    </div>
    <div class="col-md-6 col-xs-12 side-recent-item left-border">
        <?php bg_popular_post(); ?>
    </div>
</div>