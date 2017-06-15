(function( $, window, document, undefined ) {
    $(document).ready(function(){
		if( parent.tinymce.activeEditor !== null ){
			var getdata = parent.tinymce.activeEditor.windowManager.getParams();
		}
		if( $('.focuswp-layout-selector').length > 0 ){
			var dummy = $( '#focuswp-dummy-fld' ).val();
			$('.focuswp-type-fld').remove();
			$('.focuswp-layout-selector label').removeClass('selected');
			// console.log('asfda');

			$('.focuswp-styling-input').each(function(){
				var n = $( this ).attr('data-name');
				$( this ).attr( 'name', dummy.replace('--dummy--', n) );
			});

		}
		// console.log( $('.focuswp-layout-selector') );

		if( typeof getdata != 'undefined' && getdata && typeof getdata.scdata != 'undefined' ){
			$( 'form#focuswp-media-frame' ).css({ 'visibility' : 'hidden' });
			$( 'form #focuswp-query-submit' ).attr('data-action', 'edit').val( focuswp_localized.update );
			$( 'form #media_frame_fld' ).val( 'true' );
			var scdata = $.ajax({
				url: focuswp_localized.ajaxurl,
				type: 'POST',
				data: { action : 'focuswp_extract_shortcodes', data : $( getdata.scdata ).html() },
				success: function(response) {
					var scdata = $.parseJSON(response);
					if( scdata ){
						// console.log( scdata );
						if( typeof scdata.category != 'undefined' && scdata.category ){
							var category = scdata.category.split(',');
						}
						$.each( scdata, function( key, value ) {
							if( $('.focuswp-layout-selector').length > 0 && key == 'type' ){
								$( 'form#focuswp-media-frame' ).find('[data-name="'+ key +'"]').filter('[value="'+ value +'"]').attr( 'checked', true );
								if( value ){
									$( 'form#focuswp-media-frame' ).find('[data-name="'+ key +'"]').filter('[value="'+ value +'"]').parent('label').addClass('selected');
								}
							}
							else if( key == 'category' && typeof category != 'undefined' ){
								$.each( category, function( k,v ){
									$( 'form#focuswp-media-frame' ).find('[data-name="'+ key +'-'+ v +'"]').attr( 'checked', true );
								} );
							}else if( key == 'autoplay' && value == 'true' ){
								$( 'form#focuswp-media-frame' ).find('[data-name="'+ key +'"]').attr( 'checked', true );
							}else if( key == 'pager' && value == 'true' ){
								$( 'form#focuswp-media-frame' ).find('[data-name="'+ key +'"]').attr( 'checked', true );
							}else if( key == 'type' && value == 'featured--on' ){
								$( 'form#focuswp-media-frame' ).find('[data-name="'+ key +'"]').attr( 'checked', true );
							}else{
								$( 'form#focuswp-media-frame' ).find('[data-name="'+ key +'"]').val( value );
							}
						});
						if( $('.focuswp-color').length > 0 ){
							$( '.focuswp-color' ).each( function( kc, vc ){
								$(this).wpColorPicker('color', $(this).val() );
							} );
							// console.log('asdfasd');
						}

						$( 'form#focuswp-media-frame' ).css({ 'visibility' : 'visible' });
					}
				}
			});
		}
        $('form#focuswp-media-frame').on( 'submit', function(e){
            var form = $(this);
			var dataAction = form.find('#focuswp-query-submit').attr('data-action');
            // console.log( form.serializeArray() );
			var result = $.ajax({
				url: form.attr('action'),
				type: 'POST',
				data: { action : 'focuswp_media_upload', data : form.serialize() },
				success: function(response) {
					// console.log( response );
					if( typeof dataAction != 'undefined' && dataAction == 'edit' ){
						top.tinymce.activeEditor.selection.setContent( response );
			        	top.tinymce.activeEditor.windowManager.close();
					}else{
						focuswp_media_send_to_editor( response );
					}
				}
			});

            return false;
        });
    });

    function focuswp_media_send_to_editor(htmlString) {
		var win = window.dialogArguments || opener || parent || top;
		win.send_to_editor(htmlString);
	}
})( jQuery, window, document );
