<?php
/**
 * Feature Support
 *
 * Handle support for plugin features based on theme support and plugin settings.
 *
 * @package    Church_Theme_Content
 * @subpackage Functions
 * @copyright  Copyright (c) 2013 - 2017, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*********************************************
 * FEATURE DATA
 *********************************************/

/**
 * Get feature data
 *
 * Used for mapping features to post types, theme support and so on.
 * All feature data returned when $feature is empty
 *
 * @since 0.9
 * @param string $feature Feature to get data for; if none, gets data for all features
 * @return mixed Data for feature, all features or false if failed
 */
function ctc_get_feature_data( $feature = false ) {

	// Feature data
	$features = array(

		'sermons' => array(
			'theme_support'	=> 'ctc-sermons', 	// theme support feature name
			'post_type'		=> 'ctc_sermon', 	// post type feature requires
		),

		'events' => array(
			'theme_support'	=> 'ctc-events',
			'post_type'		=> 'ctc_event',
		),

		'people' => array(
			'theme_support'	=> 'ctc-people',
			'post_type'		=> 'ctc_person',
		),

		'locations' => array(
			'theme_support'	=> 'ctc-locations',
			'post_type'		=> 'ctc_location',
		),

	);

	// Add feature to array values for ease of use
	foreach ( $features as $feature_key => $feature_data ) {
		$features[$feature_key]['feature'] = $feature_key;
	}

	// Return specific feature
	if ( ! empty( $feature ) ) {
		if ( isset( $features[$feature] ) ) { // feature data exists
			return apply_filters( 'ctc_get_feature_data-' . $feature, $features[$feature] );
		}
	}

	// Return all features
	else {
		return apply_filters( 'ctc_get_feature_data', $features );
	}

	// In case feature given but not valid
	return false;

}

/**
 * Get feature data by post type
 *
 * @since 0.9
 * @param string $post_type Post type to get feature data for
 * @return array Feature data
 */
function ctc_get_feature_data_by_post_type( $post_type ) {

	$data = false;

	// Get all features
	$features = ctc_get_feature_data();

	// Loop features to find post type and get feature data
	foreach ( $features as $feature_key => $feature_data ) {

		// Post type given used by this feature
		if ( $post_type == $feature_data['post_type'] ) {

			$data = $feature_data;

			break;

		}
	}

	// Return filterable
	return apply_filters( 'ctc_get_feature_data_by_post_type', $data, $post_type );

}

/****************************************
 * THEME SUPPORT
 ****************************************

/**
 * Default features for unsupported themes
 *
 * If no add_theme_support( 'church-theme-content' ), add support for all features with no arguments.
 * This causes all content to be revealed in case admin switched to unsupported theme.
 * They can then develop the theme for the plugin or retrieve their content.
 *
 * @since 0.9
 */
function ctc_set_default_theme_support() {

	// Theme does not support plugin
	if ( ! current_theme_supports( 'church-theme-content' ) ) {

		// Loop features
		$features = ctc_get_feature_data();
		foreach ( $features as $feature_key => $feature_data ) {

			// Add support with no arguments so defaults are used (everything)
			add_theme_support( $feature_data['theme_support'] );

		}

	}

}

add_action( 'init', 'ctc_set_default_theme_support', 1 ); // init 1 is right after after_setup_theme when theme add support but earlier than normal plugin init at 10

/**
 * Get theme support data for a feature
 *
 * Optionally specify an argument to get that data
 *
 * @since 0.9
 * @param string $feature Feature to get theme support data for
 * @return mixed Feature data if found
 */
function ctc_get_theme_support( $feature, $argument = null ) {

	$data = false;

	// Theme has support
	$support = get_theme_support( $feature );
	if ( $support ) {

		// Get theme support data
		$support = isset( $support[0] ) ? $support[0] : false;

		// Use data for specific argument
		if ( isset( $argument ) ) { // argument given
			if ( is_array( $support ) && isset( $support[$argument] ) ) { // argument is set (even if empty)
				$data = $support[$argument];
			} else {
				$data = null; // so return value will return false for isset()
			}
		}

		// Use all arguments
		else {
			$data = $support;
		}

	}

	// Return data
	return apply_filters( 'ctc_get_theme_support', $data, $feature, $argument );

}

/**
 * Get theme support data based on post type
 *
 * Optionally specify an argument to get that data.
 *
 * @since 0.9
 * @param string $post_type Post type to get theme support data for.
 * @param string $argument Optional feature argument to get specific data for.
 * @return mixed Array of all feature data or specific argument
 */
function ctc_get_theme_support_by_post_type( $post_type, $argument = null ) {

	$data = false;

	// Get feature based on post type
	$feature_data = ctc_get_feature_data_by_post_type( $post_type );
	if ( $feature_data ) {

		// Get data for feature/argument
		$data = ctc_get_theme_support( $feature_data['theme_support'], $argument );

	}

	// Return data
	return apply_filters( 'ctc_get_theme_support_by_post_type', $data, $post_type, $argument );

}

/*********************************************
 * FEATURE CHECKING
 *********************************************/

/**
 * Check if feature is supported
 *
 * @since 0.9
 * @param string $feature Feature to check support for
 * @return bool True if supported by theme
 */
function ctc_feature_supported( $feature ) {

	$supported = false;

	// Get feature data
	$feature_data = ctc_get_feature_data( $feature );
	if ( $feature_data ) { // valid feature returns data

		// Does theme support feature?
		if ( current_theme_supports( $feature_data['theme_support'] ) ) {

			$supported = true;

			// (in future could override support via plugin settings here)

		}

	}

	// Return filtered
	return apply_filters( 'ctc_feature_supported', $supported, $feature );

}

/**
 * Check if taxonomy is supported
 *
 * @since 0.9
 * @param string $feature Feature taxonomy relates to
 * @param string $taxonomy Taxonomy to check support for
 * @return bool True if feature supported
 */
function ctc_taxonomy_supported( $feature, $taxonomy ) {

	$supported = false;

	// Get feature data
	$feature_data = ctc_get_feature_data( $feature );
	if ( $feature_data ) { // valid feature returns data

		// Theme taxonomies are specified
		$theme_taxonomies = ctc_get_theme_support( $feature_data['theme_support'], 'taxonomies' );
		if ( isset( $theme_taxonomies ) ) {

			// Taxonomy is explicitly supported
			if ( in_array( $taxonomy, (array) $theme_taxonomies ) ) {
				$supported = true;
			}

		}

		// Theme taxonomies are not specified
		// Default is to use all taxonomies when support not explicit, so anything returns true
		else {
			$supported = true;
		}

		// (if true, could override with false using plugin settings here)
		// (checking if show_ui is true is not enough since this is used during taxonomy registration)

	}

	// Return filtered
	return apply_filters( 'ctc_taxonomy_supported', $supported, $feature, $taxonomy );

}

/**
 * Check if field is supported
 *
 * @since 0.9
 * @param string $feature Feature field relates to
 * @param string $field Field to check support for
 * @return bool True if field supported
 */
function ctc_field_supported( $feature, $field ) {

	$supported = false;

	// Get feature data
	$feature_data = ctc_get_feature_data( $feature );
	if ( $feature_data ) { // valid feature returns data

		// Theme fields are specified
		$theme_fields = ctc_get_theme_support( $feature_data['theme_support'], 'fields' );
		if ( isset( $theme_fields ) ) {

			// Field is explicitly supported
			if ( in_array( $field, (array) $theme_fields ) ) {
				$supported = true;
			}

		}

		// Theme fields are not specified
		// Default is to use all fields when support not explicit, so anything returns true
		else {
			$supported = true;
		}

		// (if true, can override with false using plugin settings here)

	}

	// Return filtered
	return apply_filters( 'ctc_field_supported', $supported, $feature, $field );

}

/*********************************************
 * FIELD FILTERING
 *********************************************/

/**
 * Filter Meta Box Fields
 *
 * Add filters for CT_Meta_Box to set visibility and override data on fields
 * based on theme support and possibly in future plugin settings.
 *
 * @since 0.9
 */
function ctc_filter_fields() {

	// Loop features to filter their fields
	$features = ctc_get_feature_data();
	foreach ( $features as $feature_key => $feature_data ) {

		// Has post type, filter CT_Meta_Box configs
		if ( isset( $feature_data['post_type'] ) ) {

			// Set Visible Fields
			add_filter( 'ctmb_visible_fields-' . $feature_data['post_type'], 'ctc_set_visible_fields', 10, 2 );

			// Set Field Overrides
			add_filter( 'ctmb_field_overrides-' . $feature_data['post_type'], 'ctc_set_field_overrides', 10, 2 );

		}

	}

}

add_action( 'init', 'ctc_filter_fields' );

/**
 * Set visible fields
 *
 * Show or hide CT_Meta_Box fields for a post type based on add_theme_support.
 * Door is open for plugin settings to override in future.
 *
 * @since 0.9
 * @param array $visible_fields Current field visibility
 * @param string $post_type Post type this relates to
 * @return array Modified $visible_fields
 */
function ctc_set_visible_fields( $visible_fields, $post_type ) {

	// All fields
	$original_visible_fields = $visible_fields;

	// Filter visible fields based on theme support
	// If not set, all fields are used by default
	// If set and empty, all fields will be hidden
	$theme_fields = ctc_get_theme_support_by_post_type( $post_type, 'fields' );
	if ( isset( $theme_fields ) ) {

		// Make new array out of fields theme supports
		$visible_fields = $theme_fields;

		// Add support for fields that are not from Church Content
		// (otherwise they would need to be in add_theme_support arguments)
		foreach ( $original_visible_fields as $field ) {
			if ( ! preg_match( '/^_ctc_.+$/', $field ) ) { // CTC fields are prefixed by "_ctc_"
				$visible_fields[] = $field;
			}
		}

	}

	// (here plugin settings could disable fields supported by theme)

	// Return default or filtered field list
	return $visible_fields;

}

/**
 * Set field overrides
 *
 * Override CT_Meta_Box field data for a post type based on add_theme_support.
 *
 * @since 0.9
 * @param array $field_overrides Field overrides to set
 * @param string $post_type Post type to set overrides on
 * @return mixed Theme support data
 */
function ctc_set_field_overrides( $field_overrides, $post_type ) {

	// Return field overrides, if any
	return ctc_get_theme_support_by_post_type( $post_type, 'field_overrides' );

}
