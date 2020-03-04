<?php
/**
 * Helper Functions
 *
 * @package    Church_Theme_Content
 * @subpackage Functions
 * @copyright  Copyright (c) 2013 - 2020, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*************************************************
 * URLs & PATHS
 *************************************************/

/**
 * File URL
 *
 * An easy way to get the URL of a file.
 *
 * @since 0.9
 * @param string $file File relative to theme root
 * @param string $directory Optional directory file is in, relative to theme root
 * @return string URL to file
 */
function ctc_file_url( $file, $directory = false ) {

	if ( ! empty( $directory ) ) {
		$path = trailingslashit( $directory ) . $file;
	} else {
		$path = $file;
	}

	$path = trailingslashit( CTC_URL ) . $path;

	return apply_filters( 'ctc_file_url', $path, $file, $directory );
}

/**
 * File path
 *
 * An easy way to get the absolute path of a file.
 *
 * @since 0.9
 * @param string $file File relative to theme root
 * @param string $directory Optional directory file is in, relative to theme root
 * @return string Absolute path to file
 */
function ctc_file_path( $file, $directory = false ) {

	if ( ! empty( $directory ) ) {
		$path = trailingslashit( $directory ) . $file;
	} else {
		$path = $file;
	}

	$path = trailingslashit( CTC_PATH ) . $path;

	return apply_filters( 'ctc_file_path', $path, $file, $directory );
}

/**
 * churchthemes.com URLs.
 *
 * @since 2.0
 * @param array $path_key Which URL this is for.
 * @param array $query_args Parameters to add or replace in URL.
 * @return string URL.
 */
function ctc_ctcom_url( $path_key = false, $query_args = array() ) {

	// Base URL.
	$url = 'https://churchthemes.com';

	// Google Analytics tracking base query string.
	// When calling ctc_ctcom_url(), can use $query_args to add utm_campaign and utm_content.
	$utm_base_query = '?utm_source=ctc&utm_medium=plugin';

	// Paths by key.
	$paths = array(

		// Homepage.
		'home'                  => '/' . $utm_base_query . '&utm_campaign=church-theme-content',

		// How to get a Google Maps API key.
		'google-maps-api-key'   => '/go/google-maps-api-key/', // no utm, messes up redirect.

		// Church Content product page.
		'church-content'        => '/plugins/church-content/' . $utm_base_query . '&utm_campaign=church-theme-content',

		// Church Content Pro product page.
		// Pro details are on same page as Church Content plugin.
		'church-content-pro'    => '/plugins/church-content-pro/' . $utm_base_query . '&utm_campaign=church_content_pro',

		// How to upgrade from Custom Recurring Events to Pro.
		'cre-to-pro'            => '/go/cre-to-pro/' . $utm_base_query . '&utm_campaign=church_content_pro',

		// What SEO Structured Data setting does.
		'seo-setting'           => '/go/seo-setting/' . $utm_base_query . '&utm_campaign=church_content_pro&utm_content=settings',

		// How to handle event registration.
		'event-registration'    => '/go/ctc-event-registration/' . $utm_base_query . '&utm_campaign=church-theme-content',

		// How to update PHP.
		'update-php'            => '/go/update-php/' . $utm_base_query . '&utm_campaign=church-theme-content',

		// URLs for sermon media field descriptions.
		'sermon-video-sites'    => '/go/ctc-sermon-video-sites/', // external.
		'sermon-video-help'     => '/go/ctc-sermon-video-help/' . $utm_base_query . '&utm_campaign=church-theme-content&utm_content=sermon',
		'sermon-audio-sites'    => '/go/ctc-sermon-audio-sites/', // external.
		'sermon-audio-help'     => '/go/ctc-sermon-audio-help/' . $utm_base_query . '&utm_campaign=church-theme-content&utm_content=sermon',

		// Podcasting guide.
		'podcast-guide'         => '/go/podcast-guide/' . $utm_base_query . '&utm_campaign=church-theme-content',

		// Podcasting submission.
		'podcast-submit-apple'  => '/go/apple-podcast-submit/', // no UTM, redirects. add ?url=https://feedurl argument
		'podcast-submit-google' => '/go/google-podcast-submit/', // no UTM, redirects.

		// Agency mode guide.
		'agency-mode'           => '/go/agency-mode/', // no UTM, used by theme framework too.

		// Newsletter sign up.
		'newsletter'            => '/newsletter/', // no UTM, redirects to Mailchimp page.

		// Blog.
		'blog'                  => '/blog/' . $utm_base_query . '&utm_campaign=church-theme-content&utm_content=settings',

		// Risen migration guide.
		'migrate-risen'         => '/go/switch-from-risen/' . $utm_base_query . '&utm_campaign=migrate-risen',
		'migrate-risen-backup'  => '/go/backups/',

	);

	// Make URL.
	if ( isset( $paths[ $path_key ] ) ) {
		$url .= $paths[ $path_key ];
	}

	// Add or replace params.
	if ( isset( $query_args ) && is_array( $query_args ) ) {
		$url = add_query_arg( $query_args, $url );
	}

	// Return filtered.
	return apply_filters( 'ctc_ctcom_url', $url, $path_key, $query_args );

}

/**
 * Make slug in URL bold.
 *
 * This is used by settings descriptions for URL slug change examples.
 *
 * Make https://yourname.com/slug/ into https://yourname.com/<b>slug</b>/
 *
 * @since 2.0
 * @param string $slug Slug to append to home_url().
 * @return string URL with slug made bold.
 */
function ctc_make_url_slug_bold( $slug ) {
	return preg_replace( '/(.*)(\/(.*)\/)$/', '$1/<b>' . $slug . '</b>/', trailingslashit( home_url( $slug ) ) );
}


/**
 * Check if string is a URL
 *
 * @since 2.0
 * @param string $string String to check for URL format
 * @return bool True if string i=s URL
 */
function ctc_is_url( $string ) {

	$bool = false;

	$url_pattern = '/^(http(s*)):\/\//i';

	if ( preg_match( $url_pattern, $string ) ) { // URL
		$bool = true;
	}

	return apply_filters( 'ctc_is_url', $bool, $string );

}

/*************************************************
 * STRINGS
 *************************************************/

/**
 * Shorten a string
 *
 * @since 2.0
 * @param string $string String to shorten.
 * @param int $length Max length of string.
 * @return string Shortened string.
 */
function ctc_shorten( $string, $length ) {

	// Trim.
	$string = trim( $string );

	// Shorten.
	$string = mb_substr( $string, 0, $length );

	// Trim.
	$string = trim( $string );

	// Return.
	return apply_filters( 'ctc_shorten', $string, $length );

}


/**
 * Convert to one line
 *
 * It replaces line breaks with commas.
 *
 * @since 2.0
 * @param string $string Multi-line string.
 * @return string Single line string.
 */
function ctc_one_line( $string ) {

	$one_line = $string;

	if ( $string ) {
		$one_line = strip_tags( $string ); // remove HTML
		$one_line = preg_replace( '/\r\n|\n|\r/', ', ', $one_line ); // replace line breaks with commas
		$one_line = trim( $one_line ); // remove whitespace
	}

	return apply_filters( 'ctc_one_line', $one_line, $string );

}

/*************************************************
 * ARRAYS
 *************************************************/

/**
 * Merge an array into another array after a specific key
 *
 * Meant for one dimensional associative arrays.
 * Used to insert post type overview columns.
 *
 * @since 0.9
 * @param array $original_array Array to merge another into
 * @param array $insert_array Array to merge into original
 * @param mixed $after_key Key in original array to merge second array after
 * @return array Modified array
 */
function ctc_array_merge_after_key( $original_array, $insert_array, $after_key ) {

	$modified_array = array();

	// loop original array items
	foreach ( $original_array as $item_key => $item_value ) {

		// rebuild the array one item at a time
		$modified_array[$item_key] = $item_value;

		// insert array after specific key
		if ( $item_key == $after_key ) {
			$modified_array = array_merge( $modified_array, $insert_array );
		}

	}

	return apply_filters( 'ctc_array_merge_after_key', $modified_array, $original_array, $insert_array, $after_key );

}

/**
 * Show array as HTML
 *
 * This is helpful for development / debugging
 *
 * @since 1.2
 * @param array $array Array to format
 * @param bool $return Return or echo output
 */
function ctc_print_array( $array, $return = false ) {

	$result = '<pre>' . print_r( $array, true ) . '</pre>';

	if ( empty($return) ) {
		echo $result;
	} else {
		return $result;
	}

}

/*************************************************
 * DATES
 *************************************************/

/**
 * Convert date and time to MySQL DATETIME format
 *
 * If no date, value will be 0000-00-00 00:00:00
 * If no time, value will be 2014-10-28 00:00:00
 *
 * @since 1.2
 * @param string $date Date in YYYY-mm-dd format (e.g. 2014-05-10 for May 5th, 2014)
 * @param string $time Time in 24-hour hh-mm format (e.g. 08:00 for 8 AM or 13:12 for 1:12 PM)
 * @return string Date and time in DATETIME format (e.g. 2014-05-10 13:12:00)
 */
function ctc_convert_to_datetime( $date, $time ) {

	if ( empty( $date ) ) {
		$date = '0000-00-00';
	}
	if ( empty( $time ) ) {
		$time = '00:00';
	}

	$datetime = $date . ' ' . $time . ':00';

	return apply_filters( 'ctc_convert_to_datetime', $datetime, $date, $time );

}

/**
 * Convert address to one line
 *
 * It replaces line breaks with commas.
 *
 * @since 2.0
 * @param string $address Multi-line address
 * @return string Single line address
 */
function ctc_address_one_line( $address ) {

	$address_one_line = ctc_one_line( $address );

	return apply_filters( 'ctc_address_one_line', $address_one_line, $address );

}

/*************************************************
 * FUNCTIONS
 *************************************************/

/**
 * Check if a function is available
 *
 * This is helpful: http://bit.ly/100BpPJ
 *
 * @since 1.2
 * @param string $function Name of function to check
 * @return bool True if function exists and is not disabled
 */
function ctc_function_available( $function ) {

	$available = false;

	// Function exists?
	if ( function_exists( $function ) ) {

		// Is it not disabled in php.ini?
		$disabled_functions = explode( ',', ini_get( 'disable_functions' ) );
		if ( ! in_array( $function, $disabled_functions ) ) {
			$available = true;
		}

	}

	return apply_filters( 'ctc_function_available', $available, $function );

}

/*************************************************
 * PLUGINS
 *************************************************/

/**
 * Check if Church Content Pro plugin active.
 *
 * @since 2.0
 * @return bool True if plugin installed and active.
 */
function ctc_pro_is_active() {

	$active = false;

	if ( defined( 'CCP_VERSION' ) ) {
		$active = true;
	}

	return $active;

}

/**
 * Check if Custom Recurring Events plugin is active.
 *
 * @since 2.0
 * @return bool True if plugin installed and active.
 */
function ctc_cre_is_active() {

	$active = false;

	if ( defined( 'CTC_CRE_VERSION' ) ) {
		$active = true;
	}

	return $active;

}
