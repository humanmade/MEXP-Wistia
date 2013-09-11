<?php

/**
 * Class MEXP_Wistia_Service
 */
class MEXP_Wistia_Service extends MEXP_Service {

	public function __construct() {

		require_once trailingslashit( dirname( __FILE__ ) ) . 'template.php';

		$this->set_template( new MEXP_Wistia_Template );

	}

	/**
	 * @return null|void
	 */
	public function load() {

		//add_action( 'nexp_enqueue', array( $this, 'enqueue_statics' ) );

		add_filter( 'mexp_tabs', array( $this, 'tabs' ) );

		add_filter( 'mexp_labels', array( $this, 'labels' ) );

	}

	/**
	 *
	 */
	public function enqueue_statics() {

	}

	/**
	 * Handles the AJAX request and returns an appropriate response. This should be used, for example, to perform an API request to the service provider and return the results.
	 *
	 * @param array $request The request parameters.
	 * @return bool|MEXP_Response|void|WP_Error  A MEXP_Response object should be returned on success, boolean false should be returned if there are no results to show, and a WP_Error should be returned if there is an error.
	 */
	public function request( array $request ) {

		if ( is_wp_error( $wistia = $this->get_connection() ) )
			return $wistia;

		$params = $request['params'];

		if ( array_key_exists( 'q', $params ) && ! empty( $params['q'] ) ) {

			$request = array(
				'name' => sanitize_text_field( $params['q'] ),
			);

		} else {

			$request = array();

		}


		// Make the request to the Wistia API
		$search_response = $wistia->get_videos( $request );

		// Create the response for the API
		$response = new MEXP_Response();

		if ( empty( $search_response ) )
			return false;

		foreach ( $search_response as $search_item ) {

			$item = new MEXP_Response_Item();

			$item->set_content( $search_item['name'] );

			$item->set_date( strtotime( $search_item['created'] ) );

			$item->set_thumbnail( $search_item['thumbnail']['url'] );

			$item->set_date_format( 'g:i A - j M y' );

			$username = (string) apply_filters( 'mexp_username', '' ) ;

			$item->set_url( esc_url_raw( 'http://' . $username . '.wistia.com/medias/' . $search_item['hashed_id'] . '?embedType=iframe&videoWidth=640' ) );

			$item->set_id( (int) $search_item['id'] );

			$response->add_item( $item );
		}

		return $response;
	}

	/**
	 * @param array $tabs
	 * @return array
	 */
	public function tabs( array $tabs ) {

		$tabs['wistia'] = array(
			'all' => array(
				'text' => _x( 'all', 'All', 'mexp' ),
				'defaultTab' => true
			)
		);

		return $tabs;
	}

	/**
	 * @return MEXP_Wistia_Client|WP_Error
	 */
	protected function get_connection() {

		// Add the Wistia class to the runtime
		require_once plugin_dir_path( __FILE__) . '/class.wp-wistia-client.php';

		$developer_key = (string) apply_filters( 'mexp_wistia_developer_key', '' ) ;

		if ( empty( $developer_key ) ) {

			return new WP_Error(
				'mexp_wistia_no_connection',
				__( 'API connection to Wistia not found.', 'mexp' )
			);
		}

		return new MEXP_Wistia_Client( $developer_key );
	}

	/**
	 * @param array $labels
	 * @return array
	 */
	public function labels( array $labels ) {

		$labels['wistia'] = array(
			'title' => __( 'Insert from Wistia', 'mexp' ),
			'insert' => __( 'Insert', 'mexp' ),
			'noresults' => __( 'No results', 'mexp' ),
		);

		return $labels;
	}

}
