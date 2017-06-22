/*jslint browser: true*/
/*global $, jQuery, alert*/
jQuery(document).ready(function($) {
    'use strict';
    $(".easy-ads-rotating").owlCarousel({
        navigation: false,
        pagination: false,
        mouseDrag : false,
        theme : "easy-ads-slider-rotator-class",
        autoPlay : 8000,
        responsive : true,
        autoHeight : true,
        singleItem : true
    });
});