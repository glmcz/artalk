<?php

/**
 * Bannerize single mime type model to extends
 *
 * @class           WPXBannerizeMimeType
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date            2013-10-16
 * @version         1.0.0
 *
 */
class WPXBannerizeMimeType {

  /**
   * First supported mime type
   *
   * @var string $mime_type
   */
  public $mime_type = '';

  /**
   * Mime Types
   *
   * @var array $mime_types
   */
  public $mime_types = array();

  /**
   * File extensions
   *
   * @var array $extensions
   */
  public $extensions = array();

  /**
   * View class name
   *
   * @var string $view_class
   */
  private $view_class;

  /**
   * Create an instance of WPXBannerizeMimeType class
   *
   * @param array  $mime_types List of mime types
   * @param array  $extensions List of file extensions
   * @param string $view_class Name of view class for this mime type
   *
   * @return WPXBannerizeMimeType
   */
  public function __construct( $mime_types, $extensions, $view_class )
  {
    $this->mime_types = $mime_types;
    $this->mime_type  = current( $mime_types );
    $this->extensions = $extensions;
    $this->view_class = $view_class;
  }

  /**
   * Return an instance of WPXBannerizeBannerView
   *
   * @param WPXBannerizeBanner $banner An instance of WPXBannerizeBanner class
   *
   * @return WPXBannerizeBannerView
   */
  public function view( $banner )
  {
    return new $this->view_class( $banner );
  }
}


/**
 * Bannerize mime types model
 *
 * @class           WPXBannerizeMimeTypes
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date            2013-10-16
 * @version         1.0.0
 *
 */
class WPXBannerizeMimeTypes {

  public  $mime_types       = array();
  private $mime_type_class  = array();
  private $extensions_class = array();

  /**
   * Return a singleton instance of WPXBannerizemimeTypes class
   *
   * @return WPXBannerizemimeTypes
   */
  public static function init()
  {
    static $instance = null;
    if( is_null( $instance ) ) {
      $instance = new self();
    }

    return $instance;
  }

  /**
   * Create an instance of WPXBannerizeMimeTypes class
   *
   * @return WPXBannerizeMimeTypes
   */
  public function __construct()
  {
    $this->mime_types = $this->registeredMimeTypes();

    /**
     * @var WPXBannerizeMimeType $mime_type
     */
    foreach( $this->mime_types as $mime_type ) {
      foreach( $mime_type->mime_types as $code ) {
        $this->mime_type_class[ $code ] = $mime_type;
      }
    }

    /**
     * @var WPXBannerizeMimeType $mime_type
     */
    foreach( $this->mime_types as $mime_type ) {
      foreach( $mime_type->extensions as $code ) {
        $this->extensions_class[ $code ] = $mime_type;
      }
    }
  }

  /**
   * Return a key value pairs array with registered mime types. Where key is the mime types as `image/png` and the value
   * is a Mime Type model.
   *
   * @return array
   */
  private function registeredMimeTypes()
  {

    $mime_types = array(
      new WPXBannerizeMimeTypeImage(),
      new WPXBannerizeMimeTypeShockwaveFlash(),
      new WPXBannerizeMimeTypeText(),
    );

    return apply_filters( 'wpx_bannerize_registered_mime_types', $mime_types );
  }

  /**
   * Return an instance of WPXBannerizeMimeType class or FALSE if not found
   *
   * @param string $search Mime type
   *
   * @return bool|WPXBannerizeMimeType
   */
  public function mimeTypeWithMimeType( $search )
  {
    if( isset( $this->mime_type_class[ $search ] ) ) {
      return $this->mime_type_class[ $search ];
    }

    return false;
  }

  /**
   * Return an instance of WPXBannerizeMimeType class or FALSE if not found
   *
   * @param string $search Mime type
   *
   * @return bool|WPXBannerizeMimeType
   */
  public function mimeTypeWithExtensions( $search )
  {
    if( isset( $this->extensions_class[ $search ] ) ) {
      return $this->extensions_class[ $search ];
    }

    return false;
  }

}