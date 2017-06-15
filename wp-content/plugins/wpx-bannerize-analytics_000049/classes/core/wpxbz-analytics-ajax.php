<?php
if( wpdk_is_ajax() ) {

  /**
   * Ajax gateway engine
   *
   * @class              WPXBZAnalyticsAjax
   * @author             =undo= <info@wpxtre.me>
   * @copyright          Copyright (C) 2012-2015 wpXtreme Inc. All Rights Reserved.
   * @date               2015-01-22
   * @version            1.0.0
   *
   */
  final class WPXBZAnalyticsAjax extends WPDKAjax {

    /**
     * Create or return a singleton instance of WPXBZAnalyticsAjax
     *
     * @return WPXBZAnalyticsAjax
     */
    public static function getInstance()
    {
      $instance = null;
      if( is_null( $instance ) ) {
        $instance = new self();
      }

      return $instance;
    }

    /**
     * Alias of getInstance();
     *
     * @return WPXBZAnalyticsAjax
     */
    public static function init()
    {
      return self::getInstance();
    }

    /**
     * Return the array with the list of ajax allowed methods
     *
     * @return array
     */
    protected function actions()
    {
      $actionsMethods = array(

        'wpxbza_action_impressions'            => false,
        'wpxbza_action_clicks'                 => false,
        'wpxbza_action_ctr'                    => false,
        'wpxbza_action_impression_banners'     => false,
        'wpxbza_action_clicked_banners'        => false,
        'wpxbza_action_reports_banners_list'   => false,

        'wpxbza_action_overview_banner_types'  => false,
        'wpxbza_action_overview_banner_status' => false,

        'wpxbza_action_reports'                => false,
      );

      return $actionsMethods;
    }

    /**
     * Return data for Morris Graph
     *
     * @return string
     */
    public function wpxbza_action_impression_banners()
    {
      // Prepare response
      $response = new WPDKAjaxResponse();

      // Get DOM element for Morris charts
      $element_id = esc_attr( $_POST[ 'element_id' ] );

      // Ask to the reports model to get the post data
      $reports = WPXBZAnalyticsReports::init();

      // Prepare the query - The impressions overview are the last month impressions with day accuracy
      $args = array(
        'orderby'            => 'impressions_count DESC,impressions_unique_count',
        'order'              => 'DESC',
        'limit'              => 'LIMIT 0,10',
        'count'              => 'COUNT( DISTINCT impressions.banner_id, impressions.ip, impressions.user_agent, DATE_FORMAT( impressions.date, "' . WPDKDateTime::accuracy( $reports->accuracy ) . '" ) ) AS impressions_unique_count, COUNT( impressions.banner_id ) AS impressions_count',
        'group_by'           => 'GROUP BY impressions.banner_id',
        'accuracy'           => $reports->accuracy,
        'categories'         => $reports->categories,
        'banners_id'         => $reports->banners_id,
        'date_interval_from' => '',
        'date_interval_to'   => '',
        'date_from'          => WPDKDateTime::mySQLDateTime( $reports->date_range_from ),
        'date_to'            => WPDKDateTime::mySQLDateTime( $reports->date_range_to ),
      );

      // Query
      $items = WPXBannerizeImpressions::init()->select( $args );

      // Save this results
      $user_id = get_current_user_id();
      update_user_meta( $user_id, md5( 'impression_banners' ), $items );

      // Create the Morris Line charts
      $morris_charts                 = new MorrisBarCharts( $element_id );
      $morris_charts->xkey           = array( 'title' );
      $morris_charts->ykeys          = array( 'impressions_count', 'impressions_unique_count' );
      $morris_charts->lables         = array( __( 'Impressions' ), __( 'Unique' ) );
      $morris_charts->resize         = true;
      $morris_charts->barOpacity     = 0.8;
      $morris_charts->barSizeRatio   = 0.4;
      $morris_charts->lineColors     = array( '#ed5a61', '#92b46f' );
      $morris_charts->goalLineColors = $morris_charts->lineColors;
      $morris_charts->barColors      = $morris_charts->lineColors;

      // Calculate average
      $total        = 0;
      $total_unique = 0;
      foreach( $items as $value ) {
        $morris_charts->data[ ] = array(
          'title'                    => $value[ 'title' ],
          'impressions_count'        => $value[ 'impressions_count' ],
          'impressions_unique_count' => $value[ 'impressions_unique_count' ],
        );
        $total += $value[ 'impressions_count' ];
        $total_unique += $value[ 'impressions_unique_count' ];
      }

      // Average
      $avg        = count( $items ) ? number_format( $total / count( $items ), 2, '.', '' ) : 0;
      $avg_unique = count( $items ) ? number_format( $total_unique / count( $items ), 2, '.', '' ) : 0;

      // Use morris goal to display the average
      $morris_charts->goals = array( $avg, $avg_unique );

      // Additional information
      $response->data[ 'info' ] = array(
        'total'          => number_format( $total, 2 ),
        'average'        => number_format( $avg, 2 ),
        'total_unique'   => number_format( $total_unique, 2 ),
        'average_unique' => number_format( $avg_unique, 2 ),
      );

      // Charts
      $response->data[ 'charts' ] = $morris_charts->toArray();
      $response->json();
    }

    /**
     * Return data for Morris Graph
     *
     * @return string
     */
    public function wpxbza_action_clicked_banners()
    {
      // Prepare response
      $response = new WPDKAjaxResponse();

      // Get DOM element for Morris charts
      $element_id = esc_attr( $_POST[ 'element_id' ] );

      // Ask to the reports model to get the post data
      $reports = WPXBZAnalyticsReports::init();

      // Prepare the query - The impressions overview are the last month impressions with day accuracy
      $args = array(
        'orderby'            => 'clicks_count DESC,clicks_unique_count',
        'order'              => 'DESC',
        'limit'              => 'LIMIT 0,10',
        'count'              => 'COUNT( DISTINCT clicks.banner_id, clicks.ip, clicks.user_agent, DATE_FORMAT( clicks.date, "' . WPDKDateTime::accuracy( $reports->accuracy ) . '" ) ) AS clicks_unique_count, COUNT( clicks.banner_id ) AS clicks_count',
        'group_by'           => 'GROUP BY clicks.banner_id',
        'accuracy'           => $reports->accuracy,
        'categories'         => $reports->categories,
        'banners_id'         => $reports->banners_id,
        'date_interval_from' => '',
        'date_interval_to'   => '',
        'date_from'          => WPDKDateTime::mySQLDateTime( $reports->date_range_from ),
        'date_to'            => WPDKDateTime::mySQLDateTime( $reports->date_range_to ),
      );

      // Query
      $items = WPXBannerizeClicks::init()->select( $args );

      // Save this results
      $user_id = get_current_user_id();
      update_user_meta( $user_id, md5( 'clicked_banners' ), $items );

      // Create the Morris Line charts
      $morris_charts                 = new MorrisBarCharts( $element_id );
      $morris_charts->xkey           = array( 'title' );
      $morris_charts->ykeys          = array( 'clicks_count', 'clicks_unique_count' );
      $morris_charts->labels         = array( __( 'Clicks' ), __( 'Unique' ) );
      $morris_charts->resize         = true;
      $morris_charts->barOpacity     = 0.8;
      $morris_charts->barSizeRatio   = 0.4;
      $morris_charts->lineColors     = array( '#ed5a61', '#92b46f' );
      $morris_charts->goalLineColors = $morris_charts->lineColors;
      $morris_charts->barColors      = $morris_charts->lineColors;

      // Calculate average
      $total        = 0;
      $total_unique = 0;
      foreach( $items as $value ) {
        $morris_charts->data[ ] = array(
          'title'               => $value[ 'title' ],
          'clicks_count'        => $value[ 'clicks_count' ],
          'clicks_unique_count' => $value[ 'clicks_unique_count' ],
        );
        $total += $value[ 'clicks_count' ];
        $total_unique += $value[ 'clicks_unique_count' ];
      }

      // Average
      $avg        = count( $items ) ? number_format( $total / count( $items ), 2, '.', '' ) : 0;
      $avg_unique = count( $items ) ? number_format( $total_unique / count( $items ), 2, '.', '' ) : 0;

      // Use morris goal to display the average
      $morris_charts->goals = array( $avg, $avg_unique );

      // Additional information
      $response->data[ 'info' ] = array(
        'total'          => number_format( $total, 2 ),
        'average'        => number_format( $avg, 2 ),
        'total_unique'   => number_format( $total_unique, 2 ),
        'average_unique' => number_format( $avg_unique, 2 ),
      );

      // Charts
      $response->data[ 'charts' ] = $morris_charts->toArray();
      $response->json();
    }


    /**
     * Return data for Morris Graph
     *
     * @return string
     */
    public function wpxbza_action_impressions()
    {
      // Prepare response
      $response = new WPDKAjaxResponse();

      // Get DOM element for Morris charts
      $element_id = esc_attr( $_POST[ 'element_id' ] );

      // Ask to the reports model to get the post data
      $reports = WPXBZAnalyticsReports::init();

      // Prepare the query - The impressions overview are the last month impressions with day accuracy
      $args = array(
        'count'              => 'COUNT( DISTINCT impressions.banner_id, impressions.ip ) AS impressions_unique_count, COUNT( impressions.banner_id ) AS impressions_count',
        'group_by'           => 'GROUP BY date_impressions',
        'accuracy'           => $reports->accuracy,
        'categories'         => $reports->categories,
        'banners_id'         => $reports->banners_id,
        'date_interval_from' => '',
        'date_interval_to'   => '',
        'date_from'          => WPDKDateTime::mySQLDateTime( $reports->date_range_from ),
        'date_to'            => WPDKDateTime::mySQLDateTime( $reports->date_range_to ),
      );

      // Query
      $items = WPXBannerizeImpressions::init()->select( $args );

      // Save this results
      $user_id = get_current_user_id();
      update_user_meta( $user_id, md5( 'impressions' ), $items );


      // Create the Morris Line charts
      $morris_line_charts                 = new MorrisLineCharts( $element_id );
      $morris_line_charts->xkey           = array( 'date_impressions' );
      $morris_line_charts->ykeys          = array( 'impressions_count', 'impressions_unique_count' );
      $morris_line_charts->labels         = array( __( 'Impressions' ), __( 'Unique' ) );
      $morris_line_charts->resize         = true;
      $morris_line_charts->lineColors     = array( '#ed5a61', '#92b46f' );
      $morris_line_charts->goalLineColors = $morris_line_charts->lineColors;
      $morris_line_charts->barColors      = $morris_line_charts->lineColors;

      // Calculate average
      $total        = 0;
      $total_unique = 0;
      foreach( $items as $value ) {
        $morris_line_charts->data[ ] = array(
          'date_impressions'         => $value[ 'date_impressions' ],
          'impressions_count'        => $value[ 'impressions_count' ],
          'impressions_unique_count' => $value[ 'impressions_unique_count' ],
        );
        $total += $value[ 'impressions_count' ];
        $total_unique += $value[ 'impressions_unique_count' ];
      }

      // Average
      $avg        = count( $items ) ? number_format( $total / count( $items ), 2, '.', '' ) : 0;
      $avg_unique = count( $items ) ? number_format( $total_unique / count( $items ), 2, '.', '' ) : 0;

      // Use morris goal to display the average
      $morris_line_charts->goals = array( $avg, $avg_unique );

      // Additional information
      $response->data[ 'info' ] = array(
        'total'          => number_format( $total, 2 ),
        'average'        => number_format( $avg, 2 ),
        'total_unique'   => number_format( $total_unique, 2 ),
        'average_unique' => number_format( $avg_unique, 2 ),
      );

      // Charts
      $response->data[ 'charts' ] = $morris_line_charts->toArray();
      $response->json();
    }

    /**
     * Return data for Morris Graph
     *
     * @return string
     */
    public function wpxbza_action_clicks()
    {
      // Prepare response
      $response = new WPDKAjaxResponse();

      // Get DOM element for Morris charts
      $element_id = esc_attr( $_POST[ 'element_id' ] );

      // Ask to the reports model to get the post data
      $reports = WPXBZAnalyticsReports::init();

      // Prepare the query - The impressions overview are the last month impressions with day accuracy
      $args = array(
        'count'              => 'COUNT( DISTINCT clicks.banner_id, clicks.ip ) AS clicks_unique_count, COUNT( clicks.banner_id ) AS clicks_count',
        'group_by'           => 'GROUP BY date_clicks',
        'accuracy'           => $reports->accuracy,
        'categories'         => $reports->categories,
        'banners_id'         => $reports->banners_id,
        'date_interval_from' => '',
        'date_interval_to'   => '',
        'date_from'          => WPDKDateTime::mySQLDateTime( $reports->date_range_from ),
        'date_to'            => WPDKDateTime::mySQLDateTime( $reports->date_range_to ),
      );

      // Query
      $items = WPXBannerizeClicks::init()->select( $args );

      // Save this results
      $user_id = get_current_user_id();
      update_user_meta( $user_id, md5( 'clicks' ), $items );


      // Create the Morris Line charts
      $morris_line_charts                 = new MorrisLineCharts( $element_id );
      $morris_line_charts->xkey           = array( 'date_clicks' );
      $morris_line_charts->ykeys          = array( 'clicks_count', 'clicks_unique_count' );
      $morris_line_charts->labels         = array( __( 'Clicks' ), __( 'Unique' ) );
      $morris_line_charts->resize         = true;
      $morris_line_charts->goalLineColors = array( '#ed5a61', '#92b46f' );
      $morris_line_charts->lineColors     = array( '#ed5a61', '#92b46f' );
      $morris_line_charts->barColors      = $morris_line_charts->lineColors;

      // Calculate average
      $total        = 0;
      $total_unique = 0;
      foreach( $items as $value ) {
        $morris_line_charts->data[ ] = array(
          'date_clicks'         => $value[ 'date_clicks' ],
          'clicks_count'        => $value[ 'clicks_count' ],
          'clicks_unique_count' => $value[ 'clicks_unique_count' ],
        );
        $total += $value[ 'clicks_count' ];
        $total_unique += $value[ 'clicks_unique_count' ];
      }

      // Average
      $avg        = count( $items ) ? number_format( $total / count( $items ), 2, '.', '' ) : 0;
      $avg_unique = count( $items ) ? number_format( $total_unique / count( $items ), 2, '.', '' ) : 0;

      // Use morris goal to display the average
      $morris_line_charts->goals = array( $avg, $avg_unique );

      // Additional information
      $response->data[ 'info' ] = array(
        'total'          => number_format( $total, 2 ),
        'average'        => number_format( $avg, 2 ),
        'total_unique'   => number_format( $total_unique, 2 ),
        'average_unique' => number_format( $avg_unique, 2 ),
      );

      // Charts
      $response->data[ 'charts' ] = $morris_line_charts->toArray();
      $response->json();
    }

    /**
     * Return data for Morris Graph
     *
     * @return string
     */
    public function wpxbza_action_ctr()
    {
      // Prepare response
      $response = new WPDKAjaxResponse();

      // Get DOM element for Morris charts
      $element_id = esc_attr( $_POST[ 'element_id' ] );

      // Ask to the reports model to get the post data
      $reports = WPXBZAnalyticsReports::init();

      // Prepare the query - The impressions overview are the last month impressions with day accuracy
      $args = array(
        'accuracy'           => $reports->accuracy,
        'categories'         => $reports->categories,
        'banners_id'         => $reports->banners_id,
        'date_interval_from' => '',
        'date_interval_to'   => '',
        'date_from'          => WPDKDateTime::mySQLDateTime( $reports->date_range_from ),
        'date_to'            => WPDKDateTime::mySQLDateTime( $reports->date_range_to ),
      );

      // Query
      $items = WPXBZAnalyticsCTR::init()->select( $args );

      // Save this results
      $user_id = get_current_user_id();
      update_user_meta( $user_id, md5( 'ctr' ), $items );


      // Create the Morris Line charts
      $morris_line_charts                  = new MorrisLineCharts( $element_id );
      $morris_line_charts->xkey            = array( 'date_ctr' );
      $morris_line_charts->ykeys           = array( 'CTR', 'CTR_unique' );
      $morris_line_charts->labels          = array( __( 'CTR' ), __( 'Unique' ) );
      $morris_line_charts->resize          = true;
      $morris_line_charts->postUnits       = '%';
      $morris_line_charts->lineColors      = array( '#ed5a61', '#92b46f' );
      $morris_line_charts->goalLineColors  = $morris_line_charts->lineColors;
      $morris_line_charts->goalStrokeWidth = 2;

      // Calculate average
      $total        = 0;
      $total_unique = 0;
      foreach( $items as $value ) {
        $morris_line_charts->data[ ] = array(
          'date_ctr'   => $value[ 'date_ctr' ],
          'CTR'        => $value[ 'CTR' ],
          'CTR_unique' => $value[ 'CTR_unique' ]
        );
        $total += $value[ 'CTR' ];
        $total_unique += $value[ 'CTR_unique' ];
      }

      // Average
      $avg        = count( $items ) ? number_format( $total / count( $items ), 2, '.', '' ) : 0;
      $avg_unique = count( $items ) ? number_format( $total_unique / count( $items ), 2, '.', '' ) : 0;

      // Use morris goal to display the average
      $morris_line_charts->goals = array( $avg, $avg_unique );

      // Additional information
      $response->data[ 'info' ] = array(
        'average'        => number_format( $avg, 2 ),
        'average_unique' => number_format( $avg_unique, 2 ),
      );

      // Charts
      $response->data[ 'charts' ] = $morris_line_charts->toArray();
      $response->json();
    }

    /**
     * Return data for Morris Graph
     *
     * @return string
     */
    public function wpxbza_action_reports()
    {
      // Prepare response
      $response = new WPDKAjaxResponse();

      // Get DOM element for Morris charts
      $element_id = esc_attr( $_POST[ 'element_id' ] );

      // Ask to the reports model to get the post data
      $reports = WPXBZAnalyticsReports::init();

      // Prepare the query - The impressions overview are the last month impressions with day accuracy
      $args = array(
        'count'              => 'COUNT( DISTINCT impressions.banner_id, impressions.ip ) AS impressions_unique_count, COUNT( impressions.banner_id ) AS impressions_count',
        'group_by'           => 'GROUP BY date_impressions',
        'accuracy'           => $reports->accuracy,
        'categories'         => $reports->categories,
        'date_interval_from' => '',
        'date_interval_to'   => '',
        'date_from'          => WPDKDateTime::mySQLDateTime( $reports->date_range_from ),
        'date_to'            => WPDKDateTime::mySQLDateTime( $reports->date_range_to ),
      );

      // Query
      $items = WPXBannerizeImpressions::init()->select( $args );

      // Create the Morris Line charts

      $morris_line_charts                 = ( 'line' == $reports->charts_type ) ? new MorrisLineCharts( $element_id ) : new MorrisBarCharts( $element_id );
      $morris_line_charts->xkey           = array( 'date_impressions' );
      $morris_line_charts->ykeys          = array( 'impressions_count', 'impressions_unique_count' );
      $morris_line_charts->labels         = array( __( 'Impressions' ), __( 'Unique' ) );
      $morris_line_charts->resize         = true;
      $morris_line_charts->goalLineColors = array( '#ed5a61', '#92b46f' );
      $morris_line_charts->lineColors     = array( '#ed5a61', '#92b46f' );
      $morris_line_charts->barColors      = $morris_line_charts->lineColors;

      // Calculate average
      $total        = 0;
      $total_unique = 0;
      foreach( $items as $value ) {
        $morris_line_charts->data[ ] = array(
          'date_impressions'         => $value[ 'date_impressions' ],
          'impressions_count'        => $value[ 'impressions_count' ],
          'impressions_unique_count' => $value[ 'impressions_unique_count' ],
        );
        $total += $value[ 'impressions_count' ];
        $total_unique += $value[ 'impressions_unique_count' ];
      }

      // Average
      $avg        = count( $items ) ? number_format( $total / count( $items ), 2, '.', '' ) : 0;
      $avg_unique = count( $items ) ? number_format( $total_unique / count( $items ), 2, '.', '' ) : 0;

      // Use morris goal to display the average
      $morris_line_charts->goals = array( $avg, $avg_unique );

      // Additional information
      $response->data[ 'info' ] = array(
        'total'          => number_format( $total, 2 ),
        'average'        => number_format( $avg, 2 ),
        'total_unique'   => number_format( $total_unique, 2 ),
        'average_unique' => number_format( $avg_unique, 2 ),
      );

      // Charts
      $response->data[ 'charts' ] = $morris_line_charts->toArray();
      $response->json();
    }


    /**
     * Return data for Morris Graph
     *
     * @return string
     */
    public function wpxbza_action_overview_banner_types()
    {
      global $wpdb;

      // Prepare response
      $response = new WPDKAjaxResponse();

      // Get DOM element for Morris charts
      $element_id = esc_attr( $_POST[ 'element_id' ] );

      // Bannerize CPT id
      $bannerize_id = WPXBannerizeCustomPostType::ID;

      // Meta bannerize types
      $banner_type = WPXBannerizeBannerMeta::META_KEY_BANNER_TYPE;

      // Prepare the query - The impressions overview are the last month impressions with day accuracy
      $sql   = <<<SQL
SELECT
	COUNT( postmeta.meta_value ) AS value,
	postmeta.meta_value AS label

FROM ( {$wpdb->posts} AS posts )

LEFT JOIN {$wpdb->postmeta} AS postmeta ON ( postmeta.post_id = posts.ID )

WHERE 1

	AND posts.post_type = '{$bannerize_id}'
	AND postmeta.meta_key = '$banner_type'

GROUP BY postmeta.meta_value
SQL;
      $items = $wpdb->get_results( $sql, ARRAY_A );

      // Create the Morris Line charts
      $morris_donut_charts = new MorrisDonutCharts( $element_id );

      // Banner types label
      $labels = WPXBannerizeBannerType::types();

      // Calculate average
      foreach( $items as $value ) {
        $morris_donut_charts->data[ ] = array(
          'label' => $labels[ $value[ 'label' ] ],
          'value' => $value[ 'value' ]
        );
      }

      // Additional information
      $response->data[ 'info' ] = array();

      // Charts
      $response->data[ 'charts' ] = $morris_donut_charts->toArray();
      $response->json();
    }

    /**
     * Return data for Morris Graph
     *
     * @return string
     */
    public function wpxbza_action_overview_banner_status()
    {
      global $wpdb;

      // Prepare response
      $response = new WPDKAjaxResponse();

      // Get DOM element for Morris charts
      $element_id = esc_attr( $_POST[ 'element_id' ] );

      // Bannerize CPT id
      $bannerize_id = WPXBannerizeCustomPostType::ID;

      // Meta bannerize types
      //$banner_type = WPXBannerizeBannerMeta::META_KEY_BANNER_TYPE;

      // Prepare the query - The impressions overview are the last month impressions with day accuracy
      $sql   = <<<SQL
SELECT
	COUNT( * ) AS value,
	posts.post_status AS label

FROM ( {$wpdb->posts} AS posts )

WHERE 1

	AND posts.post_type = '{$bannerize_id}'

GROUP BY posts.post_status
SQL;
      $items = $wpdb->get_results( $sql, ARRAY_A );

      // Create the Morris Line charts
      $morris_donut_charts = new MorrisDonutCharts( $element_id );

      // Calculate average
      foreach( $items as $value ) {
        $morris_donut_charts->data[ ] = array(
          'label' => $value[ 'label' ],
          'value' => $value[ 'value' ]
        );
      }

      // Additional information
      $response->data[ 'info' ] = array();

      // Charts
      $response->data[ 'charts' ] = $morris_donut_charts->toArray();
      $response->json();
    }


    /**
     * Return the scrollable banners list
     */
    public function wpxbza_action_reports_banners_list()
    {
      $response       = new WPDKAjaxResponse();
      $response->data = WPXBZAnalyticsReportsBannersScrollableView::init()->html();
      $response->json();
    }

  }
}