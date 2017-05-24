<?php
/**
 * Helper Functions
 *
 * @package    Church_Theme_Content
 * @subpackage Functions
 * @copyright  Copyright (c) 2013 - 2017, churchthemes.com
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
