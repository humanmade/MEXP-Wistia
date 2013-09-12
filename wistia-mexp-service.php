<?php
/*
Plugin Name: Wistia Service for MEXP
Description: Extends the Media Manager to add support for external Wistia
Version:     0.1
Author:      Human Made Limited
Text Domain: mexp
Domain Path: /languages/
License:     GPL v2 or later

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

defined( 'ABSPATH' ) or die();

require_once 'service.php';

require_once 'template.php';

add_action( 'wp_loaded', 'plugin_init' );

function plugin_init() {
	wp_oembed_add_provider( '/https?:\/\/(.+)?(wistia.com|wi.st)\/(medias|embed)\/.*/', 'http://fast.wistia.com/oembed', true );
}

/**
 * Extends the MEXP plugin to add Wistia
 *
 * @param array $services
 * @return array
 */
function mexp_service_wistia( array $services ) {

	$services['wistia'] = new MEXP_Wistia_Service;

	return $services;

}
add_filter( 'mexp_services', 'mexp_service_wistia' );

/**
 * Add your developer key here.
 * @return string
 */
function mexp_wistia_developer_key_callback() {

	// Get your developer key at: <https://yourname.wistia.com/account>
	return '';

}
add_filter( 'mexp_wistia_developer_key', 'mexp_wistia_developer_key_callback' );

/**
 * Add your Wistia user name ( first part of profile URL <yourname>.wistia.com )
 */
function mexp_wistia_username_callback() {

	return '';
}
add_filter( 'mexp_username', 'mexp_wistia_username_callback' );
