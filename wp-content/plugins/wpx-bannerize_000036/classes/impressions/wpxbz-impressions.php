<?php

/**
 * Single row model for impression
 *
 * @class           WPXBannerizeImpression
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date            2013-10-17
 * @version         1.0.0
 *
 *
 *  INSERT INTO `wp_wpxbz_impressions` (`banner_id`, `date`, `referrer`, `ip`, `user_agent`)
 *  VALUES
 *  	(3362, '2014-03-01 12:11:03', 'http://beta.wpxtre.me/contacts/', '87.7.235.132', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:28.0) Gecko/20100101 Firefox/28.0'),
 *  	(3359, '2014-03-01 12:11:03', 'http://beta.wpxtre.me/contacts/', '87.7.235.132', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:28.0) Gecko/20100101 Firefox/28.0'),
 *  	(3355, '2014-03-01 12:13:15', 'http://beta.wpxtre.me/contacts/', '87.7.235.132', 'Mozilla/5.0 (iPad; CPU OS 7_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D167 Safari/9537.53'),
 *  	(3359, '2014-03-02 12:13:15', 'http://beta.wpxtre.me/contacts/', '87.7.235.132', 'Mozilla/5.0 (iPad; CPU OS 7_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D167 Safari/9537.53'),
 *  	(3362, '2014-03-02 12:13:44', 'http://beta.wpxtre.me/contacts/', '87.7.235.132', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.152 Safari/537.36'),
 *  	(3359, '2014-03-02 12:13:44', 'http://beta.wpxtre.me/contacts/', '87.7.235.132', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.152 Safari/537.36'),
 *  	(3359, '2014-03-02 12:15:55', 'http://beta.wpxtre.me/contacts/', '87.7.235.132', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:28.0) Gecko/20100101 Firefox/28.0'),
 *  	(3362, '2014-03-02 12:15:55', 'http://beta.wpxtre.me/contacts/', '87.7.235.132', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:28.0) Gecko/20100101 Firefox/28.0'),
 *  	(3355, '2014-03-03 12:17:59', 'http://beta.wpxtre.me/contacts/', '87.7.235.132', 'Mozilla/5.0 (iPad; CPU OS 7_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D167 Safari/9537.53'),
 *  	(3359, '2014-03-04 12:17:59', 'http://beta.wpxtre.me/contacts/', '87.7.235.132', 'Mozilla/5.0 (iPad; CPU OS 7_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D167 Safari/9537.53'),
 *  	(3355, '2014-03-05 12:20:02', 'http://beta.wpxtre.me/contacts/', '87.7.235.132', 'Mozilla/5.0 (iPad; CPU OS 7_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D167 Safari/9537.53'),
 *  	(3362, '2014-03-05 12:20:02', 'http://beta.wpxtre.me/contacts/', '87.7.235.132', 'Mozilla/5.0 (iPad; CPU OS 7_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D167 Safari/9537.53'),
 *  	(3362, '2014-03-06 12:20:14', 'http://beta.wpxtre.me/contacts/', '83.216.171.50', 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) CriOS/33.0.1750.21 Mobile/11D167 Safari/9537.53'),
 *  	(3355, '2014-03-07 12:20:14', 'http://beta.wpxtre.me/contacts/', '83.216.171.50', 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) CriOS/33.0.1750.21 Mobile/11D167 Safari/9537.53'),
 *  	(3359, '2014-03-07 12:20:25', 'http://beta.wpxtre.me/contacts/', '83.216.171.50', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36'),
 *  	(3362, '2014-03-08 12:20:25', 'http://beta.wpxtre.me/contacts/', '83.216.171.50', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36'),
 *  	(3357, '2014-03-09 12:20:43', 'http://beta.wpxtre.me/contacts/', '91.253.0.159', 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) CriOS/33.0.1750.21 Mobile/11D167 Safari/9537.53'),
 *  	(3359, '2014-03-10 12:20:43', 'http://beta.wpxtre.me/contacts/', '91.253.0.159', 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) CriOS/33.0.1750.21 Mobile/11D167 Safari/9537.53'),
 *  	(3359, '2014-03-16 12:21:01', 'http://beta.wpxtre.me/contacts/', '91.253.0.159', 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) CriOS/33.0.1750.21 Mobile/11D167 Safari/9537.53'),
 *  	(3355, '2014-03-17 12:21:01', 'http://beta.wpxtre.me/contacts/', '91.253.0.159', 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) CriOS/33.0.1750.21 Mobile/11D167 Safari/9537.53'),
 *  	(3359, '2014-03-18 12:21:11', 'http://beta.wpxtre.me/contacts/', '83.216.171.50', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36'),
 *  	(3362, '2014-03-18 12:21:11', 'http://beta.wpxtre.me/contacts/', '83.216.171.50', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36');
 *
 */
class WPXBannerizeImpression {

  // Row properties record
  public $id;
  public $banner_id;
  public $date;
  public $referrer;
  public $ip;
  public $user_agent;

  /**
   * Instance of model class of the database table
   *
   * @var WPXBannerizeImpressions $table
   */
  public $table;

  /**
   * Create an instance of WPXBannerizeImpression class
   *
   * @param int|array|object $id Optional. Any id, array or object
   *
   * @return WPXBannerizeImpression
   */
  public function __construct( $id = null )
  {
    $this->table = WPXBannerizeImpressions::init();
    $this->id    = $id;

    // Get columns and foreign data
    if ( !empty( $id ) ) {
      $this->columns();
    }
  }

  /**
   * Get the columns and foreign data
   */
  protected function columns()
  {
    // Get data
    $data = $this->table->select( array( WPXBannerizeImpressions::COLUMN_ID => $this->id ) );

    // Check result
    if( empty( $data ) ) {
      return;
    }

    // Get single record
    $row = current( $data );

    // Set the properties
    foreach( $row as $column => $value ) {
      $this->$column = $value;
    }
  }

  /**
   * Update/Insert a new record
   *
   * @return WPDKError
   */
  public function commit()
  {
    // Prepare values
    $values = array(
      WPXBannerizeImpressions::COLUMN_BANNER_ID  => $this->banner_id,
      WPXBannerizeImpressions::COLUMN_REFERRER   => $this->referrer,
      WPXBannerizeImpressions::COLUMN_DATE       => $this->date,
      WPXBannerizeImpressions::COLUMN_IP         => $this->ip,
      WPXBannerizeImpressions::COLUMN_USER_AGENT => $this->user_agent,
    );

    return empty( $this->id ) ? (  $this->id = $this->table->insert( $values ) ) : $this->table->update( $values );

  }

}


/**
 * Bannerize impressions table model
 *
 * @class           WPXBannerizeImpressions
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date            2013-10-17
 * @version         1.0.0
 *
 */
class WPXBannerizeImpressions extends WPDKDBListTableModel {

  // Table Columns
  const COLUMN_ID = 'id';
  const COLUMN_BANNER_ID = 'banner_id';
  const COLUMN_DATE = 'date';
  const COLUMN_REFERRER = 'referrer';
  const COLUMN_IP = 'ip';
  const COLUMN_USER_AGENT = 'user_agent';

  // List table id
  const LIST_TABLE_SINGULAR = 'impression_id';
  const LIST_TABLE_PLURAL = 'impressions';

  // Default order
  const DEFAULT_ORDER = 'ASC';

  // Default order by
  const DEFAULT_ORDER_BY = 'date';

  // Used this file to create and insert default values into the table
  const SQL_FILENAME = 'wpxbz-impressions.sql';

  // Do not used this constant for select. Use ->tableName property instead
  const TABLE_NAME = 'wpxbz_impressions';

  /**
   * Create an instance of WPXBannerizeImpressions class
   *
   * @return WPXBannerizeImpressions
   */
  public function __construct()
  {
    $sql_filename = sprintf( '%sdatabase/%s', WPXBANNERIZE_PATH, self::SQL_FILENAME );
    parent::__construct( self::TABLE_NAME, $sql_filename );
  }

  /**
   * Return a singleton instance of WPXBannerizeImpressions class
   *
   * @note  This method is an alias of init()
   *
   * @return WPXBannerizeImpressions
   */
  public static function getInstance()
  {
    return self::init();
  }

  /**
   * Return a singleton instance of WPXBannerizeImpressions class
   *
   * @return WPXBannerizeImpressions
   */
  public static function init()
  {
    static $instance = null;
    if ( is_null( $instance ) ) {
      $instance = new self();
    }
    return $instance;
  }

  // -------------------------------------------------------------------------------------------------------------------
  // CRUD
  // -------------------------------------------------------------------------------------------------------------------

  /**
   * Create a new record and return the action_result property
   *
   * @param array $post_data Key value pairs array
   *
   * @return int|bool
   */
  public function insert( $post_data = null )
  {
    if ( !is_null( $post_data ) ) {

      // Sanitize
      $values = array(
        self::COLUMN_BANNER_ID  => absint( $post_data[ self::COLUMN_BANNER_ID ] ),
        self::COLUMN_DATE       => $post_data[ self::COLUMN_DATE ],
        self::COLUMN_REFERRER   => esc_url( $post_data[ self::COLUMN_REFERRER ] ),
        self::COLUMN_IP         => esc_attr( $post_data[ self::COLUMN_IP ] ),
        self::COLUMN_USER_AGENT => esc_attr( $post_data[ self::COLUMN_USER_AGENT ] ),
      );

      return parent::insert( 'wpxbz_impressions', $values );
    }

    return false;
  }

  /**
   * Return rows.
   *
   *    ### Single record
   *
   * @param array $args Optional.
   *
   * @return array
   */
  public function select( $args = array() )
  {
    /**
     * @var wpdb $wpdb
     */
    global $wpdb;

    // Defaults values
    $defaults = array(
      'orderby'            => self::DEFAULT_ORDER_BY,
      'order'              => self::DEFAULT_ORDER,
      'limit'              => '',
      'banners_id'         => array(),
      'categories'         => array(),
      'count'              => false,
      'group_by'           => '',
      'accuracy'           => '%Y-%m-%d %H:%i:%s',
      'date_interval_from' => '1 MONTH',
      'date_interval_to'   => '',
      'date_from'          => '',
      'date_to'            => '',
    );

    $args = wp_parse_args( $args, $defaults );

    // Accuracy
    $accuracy = WPDKDateTime::accuracy( $args[ 'accuracy' ] );

    // Define an untitled banner
    $untitled = __( 'Untitled', WPXBZ_ANALYTICS_TEXTDOMAIN );

    // Prepare the where condictions
    $where = array( 'WHERE 1' );

    // Where date interval
    if( isset( $args['date_interval_from' ] ) && !empty( $args['date_interval_from' ] ) ) {
      $where[] = sprintf( 'DATE_FORMAT( impressions.date, "%s" ) >= DATE_SUB( NOW(), INTERVAL %s )', $accuracy, strtoupper( $args['date_interval_from'] ) );
    }
    if( isset( $args['date_interval_to' ] ) && !empty( $args['date_interval_to' ] ) ) {
      $where[] = sprintf( 'DATE_FORMAT( impressions.date, "%s" ) <= DATE_SUB( NOW(), INTERVAL %s )', $accuracy, strtoupper( $args['date_interval_to'] ) );
    }

    // Where date
    if( isset( $args['date_from' ] ) && !empty( $args['date_from' ] ) ) {
      $where[] = sprintf( 'DATE_FORMAT( impressions.date, "%s" ) >= DATE_FORMAT( "%s", "%s" )', $accuracy, $args['date_from'], $accuracy );
    }
    if( isset( $args['date_to' ] ) && !empty( $args['date_to' ] ) ) {
      $where[] = sprintf( 'DATE_FORMAT( impressions.date, "%s" ) <= DATE_FORMAT( "%s", "%s" )', $accuracy, $args['date_to'], $accuracy );
    }

    // Count
    $count = empty( $args['count'] ) ? '' : $args['count'] . ',';

    // Where for categories
    if ( !empty( $args['categories'] ) ) {
      $sub_select = sprintf( 'SELECT tr.object_id FROM %s AS tr WHERE tr.term_taxonomy_id IN(%s)', $wpdb->term_relationships, implode( ',', (array)$args['categories'] ) );
      $where[]    = sprintf( 'impressions.banner_id IN( %s )', $sub_select );
    }

    // Where for banners id
    if ( !empty( $args['banners_id'] ) ) {
      $where[] = sprintf( 'impressions.banner_id IN (%s)', implode( ',', $args['banners_id'] ) );
    }

    // Where for id
    $where[] = $this->table->where( $args, self::COLUMN_ID );

    // Build the where
    $where_str = implode( ' AND ', array_filter( $where ) );

    $sql = <<< SQL
SELECT
  {$count}
  impressions.*,
  impressions.id AS impression_id,
  DATE_FORMAT( impressions.date, '{$accuracy}' ) AS date_impressions,
  IF( posts.post_title = '', '{$untitled}', posts.post_title ) AS title

FROM ( {$this->table->table_name} AS impressions )

LEFT JOIN {$wpdb->posts} AS posts ON ( posts.ID = impressions.banner_id )

{$where_str}

{$args['group_by']}

ORDER BY {$args['orderby']} {$args['order']}
{$args['limit']}
SQL;

    //WPXtreme::log( $sql, 'impressions' );

    $data = $wpdb->get_results( $sql, ARRAY_A );

    return $data;
  }

  /**
   * Update a record
   *
   * @param array $post_data Optional.
   *
   * @return array|bool
   */
  public function update( $post_data = array() )
  {
    if ( empty( $post_data ) ) {
      return false;
    }

    // Sanitize
    $values = array(
      self::COLUMN_BANNER_ID  => absint( $post_data[ self::COLUMN_BANNER_ID ] ),
      self::COLUMN_DATE       => $post_data[ self::COLUMN_DATE ],
      self::COLUMN_REFERRER   => esc_url( $post_data[ self::COLUMN_REFERRER ] ),
      self::COLUMN_IP         => esc_attr( $post_data[ self::COLUMN_IP ] ),
      self::COLUMN_USER_AGENT => esc_attr( $post_data[ self::COLUMN_USER_AGENT ] ),
    );

    if ( empty( $post_data[ self::COLUMN_DATE ] ) ) {
      unset( $values[ self::COLUMN_DATE ] );
    }

    // Where for update
    $where = array(
      self::COLUMN_ID => $post_data[ self::COLUMN_ID ]
    );

    return parent::update( 'wpxbz_impressions', $values, $where );
  }
}