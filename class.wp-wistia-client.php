<?php

/**
 * Class MEXP_Wistia_Client
 */
class MEXP_Wistia_Client {

	/**
	 * The Wistia API password / username is always 'api'
	 *
	 * @var string
	 */
	protected $developer_key = '';

	/**
	 * API URL
	 *
	 * @var string
	 */
	protected $api_url = 'https://api.wistia.com/v1/';

	/**
	 * Instantiate a new instance of this class
	 *
	 * @param $developer_key
	 */
	public function __construct( $developer_key ) {

		$this->developer_key = $developer_key;
	}

	/**
	 * Fetch videos
	 *
	 * @param $query
	 * @return mixed
	 */
	public function get_videos( $query ) {

		$request = $this->create_url( $query );

		return $this->get_json_as_array( $request );

	}

	/**
	 * This method creates an url from an array of parameters
	 *
	 * @param  array $query    an array containing the parameters for the request
	 * @param string $resource a string containing the endpoint of the API
	 * @return bool|string
	 */
	protected function create_url( array $query = array(), $resource = 'medias' ) {

		// URL for medias
		if ( 'medias' === $resource ) {

			$params = array();

			if ( isset( $query['project_id'] ) )
				$params['project_id'] = $query['project_id'];

			if ( isset( $query['name'] ) )
				$params['name'] = $query['name'];

			if ( isset( $query['type'] ) )
				$params['type'] = $query['type'];

			if ( isset( $query['hashed_id'] ) )
				$params['hashed_id'] = $query['hashed_id'];

			$params['api_password'] = $this->developer_key;

			return $this->api_url . $resource . '.json?' . http_build_query( $params, null, '&' );

		}

		return false;
	}

	/**
	 * Fetch an url and returns the json parsed as an array
	 *
	 * @param $url
	 * @return array|bool|mixed
	 */
	protected function get_json_as_array( $url ) {

		$response = wp_remote_get( $url );

		$response_code = wp_remote_retrieve_response_code( $response );

		$response_body = wp_remote_retrieve_body( $response );

		if ( 200 != $response_code || empty( $response_body ) ) {

			return false;

		} else {

			return json_decode( $response_body, true );

		}

	}

}
