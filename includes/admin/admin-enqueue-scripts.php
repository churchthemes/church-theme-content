<?php
/**
 * Admin Styles
 *
 * Enqueue stylesheets for admin area.
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2016 - 2018, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      1.7.1
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue Admin Scripts
 *
 * @since 1.7.1
 * @global object $ctc_settings
 */
function ctc_admin_enqueue_scripts() {

	global $ctc_settings;

	// Get current screen.
	$screen = get_current_screen();

	// Plugin settings.
	if ( $ctc_settings->is_settings_page() ) { // only on Plugin Settings page.

		// Settings script.
		wp_enqueue_script( 'ctc-settings', CTC_URL . '/' . CTC_JS_DIR . '/settings.js', array( 'jquery' ), CTC_VERSION ); // bust cache on update.

		// Clipboard.js
		wp_enqueue_script( 'clipboard-js', CTC_URL . '/' . CTC_JS_DIR . '/lib/clipboard.min.js', false, CTC_VERSION );

	}

	// Scripts for showing map after related fields on event/location screens
	if ( ctc_has_lat_lng_fields() ) { // only if event/location screen with latitude and longitude fields supported.

		// Enqueue Google Maps JavaScript API.
		wp_enqueue_script( 'google-maps', '//maps.googleapis.com/maps/api/js?key=' . ctc_setting( 'google_maps_api_key' ), false, null ); // no version, generic name to share w/plugins.

		// Script for initializing and interacting with map.
		wp_enqueue_script( 'ctc-map-after-fields', CTC_URL . '/' . CTC_JS_DIR . '/map-after-fields.js', false, CTC_VERSION );
		wp_localize_script( 'ctc-map-after-fields', 'ctc_map_after_fields_data', array( // data to use in JS.
			'get_from_address_failed' => __( 'Address could not be converted. Check the address or enter your city then click the map to pinpoint your location.', 'church-theme-content' ),
			'missing_address'         => __( 'Please enter an Address above.', 'church-theme-content' ),
			'missing_key_message'     => __( 'Go to Settings > Church Content > Locations to set your Google Maps API Key to use this button.', 'church-theme-content' ),
			'has_api_key'             => ctc_setting( 'google_maps_api_key' ) ? true : false,
		) );

	}

}

add_action( 'admin_enqueue_scripts', 'ctc_admin_enqueue_scripts' ); // admin-end only.
