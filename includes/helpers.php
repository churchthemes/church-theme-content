<?php
/**
 * Helper Functions
 *
 * @package    Church_Content_Manager
 * @subpackage Functions
 * @copyright  Copyright (c) 2013, churchthemes.com
 * @link       https://github.com/churchthemes/church-content-manager
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      0.5
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
 */

function ccm_file_url( $file, $directory = false ) {

	if ( ! empty( $directory ) ) {
		$path = trailingslashit( $directory ) . $file;
	} else {
		$path = $file;
	}
	
	$path = trailingslashit( CCM_URL ) . $path;
	
	return apply_filters( 'ccm_file_url', $path, $file, $directory );
}

/**
 * File Path
 *
 * An easy way to get the absolute path of a file.
 */

function ccm_file_path( $file, $directory = false ) {

	if ( ! empty( $directory ) ) {
		$path = trailingslashit( $directory ) . $file;
	} else {
		$path = $file;
	}
	
	$path = trailingslashit( CCM_PATH ) . $path;
	
	return apply_filters( 'ccm_file_path', $path, $file, $directory );
}

/*************************************************
 * ARRAYS
 *************************************************/

/**
 * Merge an array into another array after a specific key
 *
 * Meant for one dimensional associative arrays.
 * Used to insert post type overview columns.
 */

function ccm_array_merge_after_key( $original_array, $insert_array, $after_key ) {

	$modified_array = array();

	// loop original array items
	foreach( $original_array as $item_key => $item_value ) {
	
		// rebuild the array one item at a time
		$modified_array[$item_key] = $item_value;
		
		// insert array after specific key
		if ( $item_key == $after_key ) {
			$modified_array = array_merge( $modified_array, $insert_array );
		}
	
	}

	return apply_filters( 'ccm_array_merge_after_key', $modified_array, $original_array, $insert_array, $after_key );

}

/*************************************************
 * DATES
 *************************************************/

/**
 * Move date forward
 *
 * Move date forward by one week, month or year.
 * $increment is weekly, monthly or yearly.
 */

function ccm_increment_date( $date, $increment ) {

	// In case no change could be made
	$new_date = $date;

	// Get month, day and year, increment if date is valid
	list( $y, $m, $d ) = explode( '-', $date );
	if ( checkdate( $m, $d, $y ) ) {

		// Increment
		switch ( $increment ) {

			// Weekly
			case 'weekly' :

				// Add 7 days
				list( $y, $m, $d ) = explode( '-', date( 'Y-m-d', strtotime( $date ) + WEEK_IN_SECONDS ) );

				break;

			// Monthly
			case 'monthly' :

				// Move forward one month
				if ( $m < 12 ) { // same year
					$m++; // add one month
				} else { // next year (old month is December)
					$m = 1; // first month of year
					$y++; // add one year
				}

				break;

			// Yearly
			case 'yearly' :

				// Move forward one year
				$y++;

				break;

		}

		// Day does not exist in month
		// Example: Make "November 31" into 30 or "February 29" into 28 (for non-leap year)
		$days_in_month = date( 't', mktime( 0, 0, 0, $m, 1, $y ) );
		if ( $d > $days_in_month ) {
			$d = $days_in_month;
		}

		// Form the date string
		$new_date = date( 'Y-m-d', mktime( 0, 0, 0, $m, $d, $y ) ); // pad day, month with 0

	}

	// Return filterable
	return apply_filters( 'ccm_move_date_forward', $new_date, $date, $increment );

}
