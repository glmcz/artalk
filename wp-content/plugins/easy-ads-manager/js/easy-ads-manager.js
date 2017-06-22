/*jslint browser: true*/
/*global $, jQuery, alert*/
/*global $ , CodeMirror , Infinity , wp , pluginurl_ads */
jQuery(document).ready(function($) {
    'use strict';
	$('.easy_ads_upload-btn').click(function(e) {
		e.preventDefault();
        var thiss = $(this);
		var image = wp.media({ 
			title: 'Upload Image',
			// mutiple: true if you want to upload multiple files at once
			multiple: false
		}).open()
		.on('select', function(e){
			// This will return the selected image from the Media Uploader, the result is an object
			var uploaded_image = image.state().get('selection').first();
			// We convert uploaded_image to a JSON object to make accessing it easier
			// Output to the console uploaded_image
			console.log(uploaded_image);
			var image_url = uploaded_image.toJSON().url;
			// Let's assign the url value to the input field
			thiss.prev('#easy_ads_image_url').val(image_url);
			thiss.prev('#easy_ads_image_url').prev('#previmg').attr("src",image_url);
		});
	}); 
    $('.easy_ads_remove-btn').click(function(e) {
        $(this).prev('.easy_ads_upload-btn').prev('#easy_ads_image_url').removeAttr("value");
        $(this).prev('.easy_ads_upload-btn').prev('#easy_ads_image_url').prev('#previmg').attr("src",pluginurl_ads+'imgs/no.png');
    });
    $('#easy_ads_toggle-check').click(function(e) {
		if($('#easy-image-select-section').is(':visible')) {
			$('#easy-image-select-section').slideUp();
			$('#easy-code-select-section').slideDown();
		}else{
			$('#easy-code-select-section').slideUp();
			$('#easy-image-select-section').slideDown();
		}
    });
    jQuery('#easy-ads-date-start').datepicker({ dateFormat : 'dd-mm-yy' });
});