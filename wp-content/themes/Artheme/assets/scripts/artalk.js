;(function ($, window, undefined) {
  'use strict';

  $.Artalk = {
    'init' : function() {
      $('html').removeClass('doc-not-ready');
      this.setup();
      // init all
      //$.ArtalkNavigation.init();
      //$.ArtalkFeatured.init();
      //$.ArtalkGalleries.init();
      //$.ArtalkLoader.init();
      //$.ArtalkUtils.init();
      $('body').addClass('artalk-js-init');
    },
    'setup' : function() {
      this.gridjs = document.querySelector('#grid-inner');
      this.grid   = $(this.gridjs);
    }
  };

  $(document).ready(function() {

    $.Artalk.init();

    //$.MauSticky.init();

    // refire fonts active callback
    if ( artalkFontActiveCallback.fired() ) {
      artalkFontActiveCallback.fire();
    }

  });

})(jQuery, this);