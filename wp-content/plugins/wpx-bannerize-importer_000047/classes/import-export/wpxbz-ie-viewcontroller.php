<?php

/**
 * Import/Export view controller
 *
 * @class              WPXBZImporterImportExportViewController
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012- wpXtreme Inc. All Rights Reserved.
 * @date               2013-11-07
 * @version            0.8.3
 *
 */
class WPXBZImporterImportExportViewController extends WPDKjQueryTabsViewController {

  /**
   * Return a singleton instance of WPXBZImporterImportExportViewController class
   *
   * @return WPXBZImporterImportExportViewController
   */
  public static function init()
  {
    static $instance = null;
    if ( is_null( $instance ) ) {
      $instance = new self();
    }

    return $instance;
  }

  /**
   * Create an instance of WPXBZImporterImportExportViewController class
   *
   * @return WPXBZImporterImportExportViewController
   */
  public function __construct()
  {

    /* Single instances of tab content. */
    $import_view = new WPXBZImporterImportView();

    /* Create each single tab. */
    $tabs = array(
      new WPDKjQueryTab( $import_view->id, __( 'Import', WPXBZ_IMPORTER_TEXTDOMAIN ), $import_view->html() ),
    );

    /* Create the view. */
    $view = new WPDKjQueryTabsView( 'wpxbz-importer-import-export', $tabs );

    parent::__construct( $view->id, __( 'Import/Export', WPXBZ_IMPORTER_TEXTDOMAIN ), $view );

  }

  /**
   * Fires when styles are printed for a specific admin page based on $hook_suffix.
   */
  public function admin_print_styles()
  {
    wp_enqueue_style( 'wpxbz-importer', WPXBZ_IMPORTER_URL_CSS .
                                        'wpxbz-importer.css', array(), WPXBZ_IMPORTER_VERSION );
  }

  /**
   * This static method is called when the head of this view controller is loaded by WordPress.
   * It is used by WPDKMenu for example, as 'admin_head-' action.
   */
  public function admin_head()
  {
    wp_enqueue_script( 'wpxbz-importer', WPXBZ_IMPORTER_URL_JAVASCRIPT .
                                         'wpxbz-importer.js', array(), WPXBZ_IMPORTER_VERSION, true );
  }
}


/**
 * Import view
 *
 * @class           WPXBZImporterImportView
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date            2013-11-07
 * @version         1.0.0
 *
 */
class WPXBZImporterImportView extends WPDKView {

  /**
   * WPXBZImporterConverter
   *
   * @var WPXBZImporterConverter $converter
   */
  public $converter;

  const ID = 'wpxbz-importer-import';

  /**
   * Create an instance of WPXBZImporterImportView class
   *
   * @return WPXBZImporterImportView
   */
  public function __construct()
  {
    parent::__construct( self::ID );

    $this->converter = WPXBZImporterConverter::init();
  }

  /**
   * Display
   */
  public function draw()
  {
    $layout = new WPDKUIControlsLayout( $this->fields() );
    $layout->display();
  }

  /**
   * Inner fields controls for groups
   *
   * @return string
   */
  private function groups()
  {
    $groups = WPXBZImporterWPBannerizeTable::init()->groups;

    if ( empty( $groups ) ) {
      return '';
    }

    $items = array();

    foreach ( $groups as $group ) {
      $items[] = array(
        'type'  => WPDKUIControlType::CHECKBOX,
        'id'    => 'wpxbz-importer-groups-' . sanitize_title( $group ),
        'name'  => 'wpxbz-importer-groups[]',
        'label' => $group,
        'value' => $group
      );
    }

    $click_here = sprintf( '<a id="wpxbz-importer-select-all-groups" href="#" class="button button-small">%s</a>', __( 'Toggle All', WPXBZ_IMPORTER_TEXTDOMAIN ) );

    $fields = array(
      __( 'Groups', WPXBZ_IMPORTER_TEXTDOMAIN ) => array(
        __( 'Please select at least one group of banner below that you would like to import or', WPXBZ_IMPORTER_TEXTDOMAIN ) .
        ' ' . $click_here,
        $items
      )
    );

    $layout = new WPDKUIControlsLayout( $fields );

    return $layout->html();
  }

  /**
   * Inner fields controls for types
   *
   * @return string
   */
  private function types()
  {
    $types = WPXBZImporterWPBannerizeTable::init()->types();

    if ( empty( $types ) ) {
      return '';
    }

    $items = array();

    foreach ( $types as $key => $type ) {
      $items[] = array(
        'type'  => WPDKUIControlType::CHECKBOX,
        'id'    => 'wpxbz-importer-types-' . sanitize_title( $type ),
        'name'  => 'wpxbz-importer-types[]',
        'label' => $type,
        'value' => $key
      );
    }

    $click_here = sprintf( '<a id="wpxbz-importer-select-all-types" href="#" class="button button-small">%s</a>', __( 'Toggle All', WPXBZ_IMPORTER_TEXTDOMAIN ) );

    $fields = array(
      __( 'Types', WPXBZ_IMPORTER_TEXTDOMAIN ) => array(
        __( 'Please select at least one type of banner below that you would like to import or', WPXBZ_IMPORTER_TEXTDOMAIN ) .
        ' ' . $click_here,
        $items
      )
    );

    $layout = new WPDKUIControlsLayout( $fields );

    return $layout->html();
  }

  /**
   * Return the controls layout fields for conversions
   */
  private function fields()
  {
    /* Check for previous WP Bannerize (.org) table */
    $old_table = WPXBZImporterWPBannerizeTable::init()->exists();

    /* Get the previous info conversion */
    $info_conversion = $this->converter->infoConversion();

    /* Delete old table button */
    $delete_button = '';
    if ( true === $old_table ) {
      WPDKHTML::startCompress(); ?>
      <?php _e( 'Remember that you can delete this table by click below', WPXBZ_IMPORTER_TEXTDOMAIN ) ?>
      <p>
  <button id="wpxbz-ie-delete-old-table"
          class="button button-large"
          data-confirm="<?php _e( 'Warning!\n\nThis operation IS NOT Reversible!\n\nAre you sure to delete old WP Bannerize table?', WPXBZ_IMPORTER_TEXTDOMAIN ) ?>"
    >
    <?php _e( 'Delete OLD Table', WPXBZ_IMPORTER_TEXTDOMAIN ) ?></button>
</p>
      <?php
      $delete_button = WPDKHTML::endHTMLCompress();
    }

    /* Info about last conversion/import */
    $info_alert = '';
    if ( $info_conversion && is_array( $info_conversion ) ) {
      $info_alert = array(
        array(
          'type'           => WPDKUIControlType::ALERT,
          'alert_type'     => WPDKUIAlertType::WARNING,
          'dismiss_button' => false,
          'title'          => __( 'Note Well', WPXBZ_IMPORTER_TEXTDOMAIN ),
          'value'          => sprintf( __( 'You have already imported <strong>%s</strong> record(s) of the previous version of WP Bannerize database table <strong>%s ago</strong>. %s', WPXBZ_IMPORTER_TEXTDOMAIN ), $info_conversion['numbers_of_records'], human_time_diff( $info_conversion['time'] ), $delete_button ),
        )
      );
    }

    if ( true === $old_table && WPXBZImporterWPBannerizeTable::init()->total_records > 0 ) {
      $fields = array(
        __( 'Previous Release Importer Options', WPXBZ_IMPORTER_TEXTDOMAIN ) => array(
          array(
            array(
              'type'           => WPDKUIControlType::ALERT,
              'alert_type'     => WPDKUIAlertType::INFORMATION,
              'dismiss_button' => false,
              'title'          => sprintf( __( 'Found WP Bannerize (v3.1+) table named `%s`', WPXBZ_IMPORTER_TEXTDOMAIN ), WPXBZImporterWPBannerizeTable::init()->tableName ),
              'value'          => __( 'Info Table', WPXBZ_IMPORTER_TEXTDOMAIN ) . '<br/>' .
                                  sprintf( __( 'Trash Records <strong>%s</strong>', WPXBZ_IMPORTER_TEXTDOMAIN ), WPXBZImporterWPBannerizeTable::init()->total_trash ) .
                                  '<br/>' .
                                  sprintf( __( 'Enabled Records <strong>%s</strong>', WPXBZ_IMPORTER_TEXTDOMAIN ), WPXBZImporterWPBannerizeTable::init()->total_enabled ) .
                                  '<br/>' .
                                  sprintf( __( 'Disable Records <strong>%s</strong>', WPXBZ_IMPORTER_TEXTDOMAIN ), WPXBZImporterWPBannerizeTable::init()->total_disabled ) .
                                  '<br/>' .
                                  sprintf( __( '<strong>Total Records %s</strong>', WPXBZ_IMPORTER_TEXTDOMAIN ), WPXBZImporterWPBannerizeTable::init()->total_records ) .
                                  '<br/>' .
                                  __( 'You can convert and import your old data in the new format following instructions below.', WPXBZ_IMPORTER_TEXTDOMAIN ),
            )
          ),
          ( $info_conversion && is_array( $info_conversion ) ) ? $info_alert : '',
          array(
            array(
              'type'    => WPDKUIControlType::CUSTOM,
              'content' => $this->groups(),
            ),
          ),
          array(
            array(
              'type'    => WPDKUIControlType::CUSTOM,
              'content' => $this->types(),
            ),
          ),
          array(
            array(
              'type'  => WPDKUIControlType::SWIPE,
              'name'  => 'wpxbz-importer-import-trash',
              'label' => __( 'Import Trash', WPXBZ_IMPORTER_TEXTDOMAIN ),
              'value' => 'off'
            )
          ),
          array(
            array(
              'type'  => WPDKUIControlType::SWIPE,
              'name'  => 'wpxbz-importer-import-disabled',
              'label' => __( 'Import Disabled', WPXBZ_IMPORTER_TEXTDOMAIN ),
              'value' => 'off'
            )
          ),
          array(
            array(
              'type'  => WPDKUIControlType::SWIPE,
              'name'  => 'wpxbz-importer-delete-table',
              'label' => __( 'Delete table after import', WPXBZ_IMPORTER_TEXTDOMAIN ),
              'data'  => array(
                'confirm' => __( "Warning!\n\nAre you sure to delete old table after import?", WPXBZ_IMPORTER_TEXTDOMAIN )
              ),
              'value' => 'off'
            )
          ),
          array(
            array(
              'type'  => WPDKUIControlType::BUTTON,
              'name'  => 'wpxbz-import-select-all',
              'class' => 'button button-large alignleft',
              'value' => __( 'Select All', WPXBZ_IMPORTER_TEXTDOMAIN )
            ),
            array(
              'type'  => WPDKUIControlType::BUTTON,
              'name'  => 'wpxbz-import-previous-version',
              'data'  => array(
                'alert_no_groups' => __( "Warning!\n\nNo Groups selected. Please select at least one Group of banner.", WPXBZ_IMPORTER_TEXTDOMAIN ),
                'alert_no_types'  => __( "Warning!\n\nNo Types selected. Please select at least one Type of banner.", WPXBZ_IMPORTER_TEXTDOMAIN ),
              ),
              'class' => 'button button-primary button-large alignright',
              'value' => __( 'Start Import', WPXBZ_IMPORTER_TEXTDOMAIN )
            ),
          ),
        )
      );
    }
    /* Old table found but with zero records */
    elseif ( true === $old_table ) {
      $fields = array(
        __( 'Previous Release Importer Options', WPXBZ_IMPORTER_TEXTDOMAIN ) => array(
          array(
            array(
              'type'           => WPDKUIControlType::ALERT,
              'alert_type'     => WPDKUIAlertType::INFORMATION,
              'dismiss_button' => false,
              'title'          => sprintf( __( 'Found WP Bannerize (v3.1+) table named `%s`', WPXBZ_IMPORTER_TEXTDOMAIN ), WPXBZImporterWPBannerizeTable::init()->tableName ),
              'value'          => __( 'Info Table', WPXBZ_IMPORTER_TEXTDOMAIN ) . '<br/>' .
                                  sprintf( __( '<strong>Total Records %s</strong>', WPXBZ_IMPORTER_TEXTDOMAIN ), WPXBZImporterWPBannerizeTable::init()->total_records ) .
                                  '<br/>' .
                                  __( 'Sorrry, no records found to import/convert...', WPXBZ_IMPORTER_TEXTDOMAIN ),
            )
          ),
          ( $info_conversion && is_array( $info_conversion ) ) ? $info_alert : '',
        )
      );
    }
    /* No old table found */
    else {
      $fields = array(
        __( 'Previous release', WPXBZ_IMPORTER_TEXTDOMAIN ) => array(
          array(
            array(
              'type'           => WPDKUIControlType::ALERT,
              'alert_type'     => WPDKUIAlertType::WARNING,
              'dismiss_button' => false,
              'title'          => __( 'Warning!', WPXBZ_IMPORTER_TEXTDOMAIN ),
              'value'          => __( 'No WP Bannerize (3.1+) database table version found!', WPXBZ_IMPORTER_TEXTDOMAIN ),
            ),
          ),
          ( $info_conversion && is_array( $info_conversion ) ) ? $info_alert : '',
        )
      );
    }

    return $fields;
  }

}
