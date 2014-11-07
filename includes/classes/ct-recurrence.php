<?php
/**
 * CT Recurrence Class
 *
 * This class presents future recurring dates based on given arguments.
 * It is used in the Church Theme Content plugin and Church Theme Framework.
 *
 * It is compatible with PHP 5.2.4, the minimum version required by WordPress.
 * Otherwise, simshaun/recurr or tplaner/When would be a good choice.
 *
 * @copyright Copyright (c) 2014, churchthemes.com
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Class may be used in both theme and plugin(s)
if ( ! class_exists( 'CT_Recurrence' ) ) {

	/**
	 * CT Recurrence Class
	 *
	 * @since 0.1
	 */
	class CT_Recurrence {

		/**
		 * Version
		 *
		 * @since 0.1
		 * @var string
		 */
		public $version;

		/**
		 * Constructor
		 *
		 * @since 0.1
		 * @access public
		 * @param array $args Configuration for meta box and its fields
		 */
		public function __construct() {

			// Version
			$this->version = '0.1';

		}

		/**
		 * Prepare arguments
		 *
		 * This validates, sets defaults and returns arguments.
		 * It returns false if any of the arugments are invalid.
		 *
		 * @since 0.1
		 * @access public
		 * @param array $args Arguments for recurrence
		 * @return array|bool Clean array or false if invalid
		 */
		public function prepare_args( $args ) {

			// Is it a non-empty array?
			if ( empty( $args ) || ! is_array( $args ) ) { // could be empty array; set bool
				$args = false;
			}

			// Acceptable arguments
			$acceptable_args = array(
				'start_date',
				'until_date',
				'frequency',
				'interval',
				'monthly_type',
				'monthly_week',
				'limit',
			);

			// Loop arguments
			// Sanitize and set all keys
			$new_args = array();
			foreach( $acceptable_args as $arg ) {

				// If no key, set it
				if ( ! empty( $args[$arg] ) ) {
					$new_args[$arg] = $args[$arg];
				} else {
					$new_args[$arg] = '';
				}

				// Trim value
				$args[$arg] = trim( $new_args[$arg] );

			}
			$args = $new_args;

			// Start Date
			if ( $args ) {

				if ( empty( $args['start_date'] ) || ! $this->validate_date( $args['start_date'] ) ) {
					$args = false;
				}

			}

			// Until Date (optional)
			if ( $args ) {

				// Value is provided
				if ( ! empty( $args['until_date'] ) ) {

					// Date is invalid
					if ( ! $this->validate_date( $args['until_date'] ) ) {
						$args = false;
					}

					// Note: until_date can exceed start date
					// If not allowed, would not be able to loop and check effectively

				}

			}

			// Frequency
			if ( $args ) {

				// Value is invalid
				if ( empty( $args['frequency'] ) || ! in_array( $args['frequency'], array( 'weekly', 'monthly', 'yearly' ) ) ) {
					$args = false;
				}

			}

			// Interval
			// Every X weeks / months / years
			if ( $args ) {

				// Default is 1 if nothing given
				if ( empty( $args['interval'] ) ) {
					$args['interval'] = 1;
				}

				// Invalid if not numeric or is negative
				if ( ! is_numeric( $args['interval'] ) || $args['interval'] < 1 ) {
					$args = false;
				}

			}

			// Monthly Type (required when frequency is monthly)
			if ( $args ) {

				// Value is required
				if ( 'monthly' == $args['frequency'] ) {

					// Default to day if none
					if ( empty( $args['monthly_type'] ) ) {
						$args['monthly_type'] = 'day';
					}

					// Value is invalid
					if ( ! in_array( $args['monthly_type'], array( 'day', 'week' ) ) ) {
						$args = false; // value is invalid
					}

				}

				// Not required in this case
				else {
					$args['monthly_type'] = '';
				}

			}

			// Monthly Week (required when frequency is monthly and monthly_type is week)
			if ( $args ) {

				// Value is required
				if ( 'monthly' == $args['frequency'] && 'week' == $args['monthly_type'] ) {

					// Is value valid?
					if ( empty( $args['monthly_week'] ) || ! in_array( $args['monthly_week'], array( '1', '2', '3', '4', 'last' ) ) ) {
						$args = false; // value is invalid
					}

				}

				// Not required in this case
				else {
					$args['monthly_week'] = '';
				}

			}

			// Limit (optional)
			if ( $args ) {

				// Set default if no until date to prevent infinite loop
				if ( empty( $args['limit'] ) && empty( $args['until_date'] ) ) {
					$args['limit'] = 100;
				}

				// Limit is not numeric or is negative
				if ( ! empty( $args['limit'] ) && ( ! is_numeric( $args['limit'] ) || $args['limit'] < 1 ) ) {
					$args['limit'] = false;
				}

			}

			return $args;

		}

		/**
		 * Get dates
		 *
		 * Get multiple recurring dates.
		 * The start date is included in the dates returned.
		 *
		 * @since 0.1
		 * @access public
		 * @param array $args Arguments determining recurrence
		 * @return array|bool Array of dates or false if arguments invalid
		 */
		public function get_dates( $args ) {

			$dates = array();

			// Validate and set default arguments
			$args = $this->prepare_args( $args );

			// Have valid arguments?
			// If not, return false
			if ( ! $args ) {
				$dates = false;
			}

			// Get multiple recurring dates
			if ( $args ) { // valid args

				// Keep track of how many dates are returned
				$i = 1;

				// Include the date provided
				$dates[] = $args['start_date'];

				// Get next dates until until_date or limit is reached (whichever is sooner)
				$next_start_date = $args['start_date'];
				while ( ++$i ) {

					// Get next date
					$next_args = $args;
					$next_args['start_date'] = $next_start_date;
					$next_date = $this->get_next_date( $next_args );

					// If for some reason no next date can be calculated, stop
					// This is a safeguard to prevent an infinite loop
					if ( empty( $next_date ) ) {
						break;
					}

					// Has until_date been exceeded?
					if ( ! empty( $args['until_date'] ) ) { // until date is provided

						$until_date_ts = strtotime( date_i18n( 'Y-m-d', $args['until_date'] ) ); // localized
						$next_date_ts = strtotime( $next_date );

						if ( $next_date_ts > $until_date_ts ) { // yes, stop loop
							break;
						}

					}

					// Add it to array
					$dates[] = $next_date; // add it to array

					// Has limit been reached?
					if ( ! empty( $args['limit'] ) && $i == $args['limit'] ) {
						break;
					}

					// Update start_date argument
					$next_start_date = $next_date;

				}

			}

			return $dates;

		}

		/**
		 * Get next date
		 *
		 * Get the next recurring date.
		 * This may or may not be future.
		 * until_date and limit have no effect (they are for get_dates() only)
		 *
		 * @since 0.1
		 * @access public
		 * @param array $args Arguments determining recurrence
		 * @return string|bool Date string or false if arguments invalid or no next date
		 */
		public function get_next_date( $args ) {

			$date = false;

			// Validate and set default arguments
			$args = $this->prepare_args( $args );

			// Get next recurring date
			// This may or may not be future
			if ( $args ) { // valid args

				// Get month, day and year
				list( $y, $m, $d ) = explode( '-', $args['start_date'] );

				// Calculate next recurrence
				switch ( $args['frequency'] ) {

					// UNFINISHED
					// Add logic for advanced recurrence

					// Weekly
					case 'weekly' :

						// Add 7 days
						// This will always be the same day of the week (Mon, Tue, etc.)
						list( $y, $m, $d ) = explode( '-', date( 'Y-m-d', strtotime( $args['start_date'] ) + WEEK_IN_SECONDS ) );

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

						// Note: Every month always has at least 4 full weeks

						break;

					// Yearly
					case 'yearly' :

						// Move forward one year
						$y++;

						break;

				}

				// UNFINISHED
				// Day does not exist in month
				// Increment until it does exist
				// Example: January 30 recurring monthly goes to March 30, because there is no February 30
				// Example 2: February 29 on a leap year recurring yearly skips to the next leap year
				$days_in_month = date( 't', mktime( 0, 0, 0, $m, 1, $y ) );
				if ( $d > $days_in_month ) {

					// Figure this out. If loop get_next_date() on date that doesn't exist, it returns false
					// Maybe double the interval and check until returns a valid date?
					// Use checkdate instead?
					// Test all scenarios

				}

				// Form the date string
				$date = date( 'Y-m-d', mktime( 0, 0, 0, $m, $d, $y ) ); // pad day, month with 0

			}

			return $date;

		}

		/**
		 * Get next future date
		 *
		 * Get the next future recurring date (future includes today).
		 * This is helpful when cron misses a beat.
		 * until_date and limit have no effect (they are for get_dates() only)
		 *
		 * @since 0.1
		 * @access public
		 * @param array $args Arguments determining recurrence
		 * @return string|bool Date string or false if arguments invalid or no next date
		 */
		public function get_next_future_date( $args ) {

			// Get next date
			// This may or may not be future
			$date = $this->get_next_date( $args ); // returns false if invalid args

			// Have valid date
			if ( $date ) {

				// Convert dates to timestamp for comparison
				$today_ts = strtotime( date_i18n( 'Y-m-d' ) ); // localized
				$date_ts = strtotime( $date );

				// Continue getting next date until it is not in past
				// This provides automatic correction in case wp-cron misses a beat
				while ( $date_ts < $today_ts ) {

					// Get next date
					$next_args = $args;
					$next_args['start_date'] = $date;
					$date = $this->get_next_date( $next_args );

					// If for some reason no next date can be calculated, stop
					// This is a safeguard to prevent an infinite loop
					if ( empty( $date ) ) {
						break;
					}

					// Convert new date to timestamp
					$date_ts = strtotime( $date );

				}

			}

			return $date;

		}

		/**
		 * Validate date
		 *
		 * @since 0.1
		 * @access public
		 * @param string $date Date in YYYY-mm-dd format
		 * @return bool Whether or not date is valid
		 */
		public function validate_date( $date ) {

			$valid = false;

			// Check format
			// 2014-1-1 is not valid
			if ( preg_match( '/([0-9]{4})-([0-9]{2})-([0-9]{2})/', $date ) ) {

				// Get year, month, day
				list( $y, $m, $d ) = explode( '-', $date );

				// Check that date itself is valid
				if ( checkdate( $m, $d, $y ) ) {
					$valid = true;
				}

			}

			return $valid;

		}

	}

}




// TESTING
// ADD USAGE TO TOP

// init this where? ctc.php (available everywhere then)? events? schdedule.php? make a dates include?
$ctc_recurrence = new CT_Recurrence();


?><h4>get_next_date()</h3><?php

$args = array(
	'start_date'			=> '2014-11-10', // first day of event, YYYY-mm-dd (ie. 2015-07-20 for July 15, 2015)
	'until_date'			=> '2014-11-30', // date recurrence should not extend beyond
	'frequency'				=> 'monthly', // weekly, monthly, yearly
	'interval'				=> '1', // every 1, 2 or 3 weeks, months or years
	'monthly_type'			=> 'week', // day (same day of month) or week (on a specific week); if recurrence is monthly (day is default)
	'monthly_week'			=> 'last', // 1 - 4 or 'last'; if recurrence is monthly and monthly_type is 'week'
	'limit'					=> '10', // maximum dates to return (if no until_date, default is 100 to prevent infinite loop)
);
$dates = $ctc_recurrence->get_next_date( $args );
ctc_print_array( $args );
ctc_print_array( $dates );


?><h4>get_next_future_date()</h3><?php

$args = array(
	'start_date'			=> '2014-11-10', // first day of event, YYYY-mm-dd (ie. 2015-07-20 for July 15, 2015)
	'until_date'			=> '2014-11-30', // date recurrence should not extend beyond
	'frequency'				=> 'monthly', // weekly, monthly, yearly
	'interval'				=> '1', // every 1, 2 or 3 weeks, months or years
	'monthly_type'			=> 'week', // day (same day of month) or week (on a specific week); if recurrence is monthly (day is default)
	'monthly_week'			=> 'last', // 1 - 4 or 'last'; if recurrence is monthly and monthly_type is 'week'
	'limit'					=> '10', // maximum dates to return (if no until_date, default is 100 to prevent infinite loop)
);
$dates = $ctc_recurrence->get_next_future_date( $args );
ctc_print_array( $args );
ctc_print_array( $dates );


?><h4>get_dates()</h3><?php

$args = array(
	'start_date'			=> '2014-11-10', // first day of event, YYYY-mm-dd (ie. 2015-07-20 for July 15, 2015)
	'until_date'			=> '2014-11-30', // date recurrence should not extend beyond
	'frequency'				=> 'monthly', // weekly, monthly, yearly
	'interval'				=> '1', // every 1, 2 or 3 weeks, months or years
	'monthly_type'			=> 'week', // day (same day of month) or week (on a specific week); if recurrence is monthly (day is default)
	'monthly_week'			=> 'last', // 1 - 4 or 'last'; if recurrence is monthly and monthly_type is 'week'
	'limit'					=> '10', // maximum dates to return (if no until_date, default is 100 to prevent infinite loop)
);
$dates = $ctc_recurrence->get_dates( $args );
ctc_print_array( $args );
ctc_print_array( $dates );

exit;







