/* ;(function ($, window, undefined) {
  'use strict';

  $.ArtalkUtils = {
    'init' : function() {
      this.comments();
      this.equalColumns();
      this.masonryInit();
      this.placeholdersInit();
    },
    'comments' : function() {
      var comments_area = $('#comments');
      if ( '#respond' == window.location.hash ) {
        comments_area.slideDown(300); // .show()
      }
      $('[data-artalk-comments-open]').click(function(e){
        e.preventDefault();
        comments_area.slideToggle(300);
      });
    },
    'masonryInit' : function() {
      this.masonryPureJS = true;
      if ( ! $.Artalk.grid.length )
        return false;
      var self = this;
      var args = {
          isInitLayout: false,
          stamp: '.masonry_stamp'
      };
      if ( this.masonryPureJS ) {
        this.mason = new Masonry( $.Artalk.gridjs, args);
        this.mason.once( 'layoutComplete', this.masonryLayoutComplete );
      } else {
        this.mason = $.Artalk.grid.masonry(args);
        this.mason.one( 'layoutComplete', this.masonryLayoutComplete );
      }
      Foundation.utils.image_loaded($('img',$.Artalk.grid), function(){
        if ( self.masonryPureJS ) {
          self.mason.layout();
        } else {
          self.mason.masonry();
        }
      });
    },
    'masonryLayoutComplete' : function(){
        $('body').addClass('artalk-masonry-done');
    },
    'equalColumns': function() {
      this.colConts = $('.equal-height');
      this.cols = this.colConts.children();
      var self  = this;
      // on init
      Foundation.utils.image_loaded($('img',$.Artalk.grid), function(){
        self.resizeColumns();
        self.colConts.addClass('has-equal-heights');
      });
      // on resize
      $(window).resize(function(){
        self.resizeColumns();
      });
    },
    'resizeColumns' : function() {
        if ( Foundation.utils.is_small_only() ) {
          this.cols.css({'height':'auto'});
        } else {
          var max_h = 0;
          this.cols.each(function(){
            var th = $(this).outerHeight();
            if (th > max_h) max_h = th;
          });
          this.cols.height(max_h);
        }
    },
    'placeholdersInit' : function() {
      var self = this;
      $('input[placeholder]')
        .each(function(){self.placeholdersDeco($(this));})
        .blur(function(){self.placeholdersDeco($(this));});
    },
    'placeholdersDeco' : function(t) {
      var v = t.val();
      if ( '' === v || t.attr('placeholder') === v ) {
        t.addClass('isEmpty');
      } else {
        t.removeClass('isEmpty');
      }
    },
  };

})(jQuery, this); */