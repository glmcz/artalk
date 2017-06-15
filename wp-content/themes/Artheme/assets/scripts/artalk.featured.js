;(function ($, window, undefined) {
  'use strict';

  $.ArtalkFeatured = {
    'init' : function() {
      this.featured = $('#featured');
      this.feat_thumbs = $('[data-slick-goto]','#featured-thumbs');
      if ( ! this.featured.length )
        return false;
      this.hookEvents();
      var self = this;
      Foundation.utils.image_loaded( $('img',this.featured) , function(){
        self.setHeight();
        self.featured.slick({
          accessibility:false,
          arrows:false,
          infinite:false,
        });
      });
    },
    'hookEvents' : function() {
      var self = this;
      // click
      this.feat_thumbs.click(function(e){
        e.preventDefault();
        var t = $(this);
        self.featured.slick( 'slickGoTo', t.data('slick-goto') );
      });
      // change
      this.featured.on('beforeChange', function( event, slick, currentSlide, nextSlide){
        $('[data-slick-goto='+currentSlide+']').removeClass('active');
        $('[data-slick-goto='+nextSlide+']').addClass('active');
      });
      // resize
      $(window).resize(function(){
        self.setHeight();
      });
    },
    'setHeight' : function() {
      this.featured.removeClass('heightSet').css({'height':'auto'}).height(this.featured.height()).addClass('heightSet');
    }
  };

})(jQuery, this);