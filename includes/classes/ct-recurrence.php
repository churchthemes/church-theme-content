<?php
/**
 * CT Recurrence Class
 *
 * This class presents future recurring dates based on given arguments.
 * It also considers excluded dates which may or may not relate to recurrence.
 * It is used in the Church Content, Church Content Pro add-on and Church Theme Framework.
 *
 * It is compatible with PHP 5.2.4, the minimum version required by WordPress.
 * PHP manual recommends using DateTime::modify() for PHP 5.2 versus strtotime().
 * See last note on http://php.net/manual/en/function.strtotime.php
 *
 * Otherwise, simshaun/recurr, tplaner/When or a newer one could be a good choice.
 *
 * See example usage at bottom of this file.
 *
 * @copyright Copyright (c) 2014 - 2017 churchthemes.com
 * @license   GPLv2 or later
 */

// No direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// php-rrule namespace.
use RRule\RRule;

/*******************************************
 * RECURRENCE CLASS
 *******************************************/

// Class may be used in both theme and plugin(s)
if ( ! class_exists( 'CT_Recurrence' ) ) {

	/**
	 * CT Recurrence Class
	 *
	 * @since 0.9
	 */
	class CT_Recurrence {

		/**
		 * Version
		 *
		 * @since 0.9
		 * @var string
		 */
		public $version;

		/**
		 * Constructor
		 *
		 * @since 0.9
		 * @access public
		 * @param array $args Configuration for meta box and its fields
		 */
		public function __construct() {

			// Version
			$this->version = '2.0';

		}

		/**
		 * Prepare arguments
		 *
		 * This validates, sets defaults and returns arguments in format suitable for php-rrule.
		 * It returns false if any of the arugments are invalid.
		 *
		 * @since 0.9
		 * @access public
		 * @param array $args Arguments for recurrence.
		 * @return array|bool Clean array to pass onto rrule_args method before get_dates.
		 */
		public function prepare_args( $args ) {

			// Is it a non-empty array?
			if ( empty( $args ) || ! is_array( $args ) ) { // could be empty array; set bool.
				$args = false;
			}

			// Acceptable arguments
			$acceptable_args = array(
				'start_date',
				'until_date',
				'frequency',
				'interval',
				'weekly_day',
				'monthly_type',
				'monthly_week',
				'limit',
			);

			// Loop arguments
			// Sanitize and set all keys.
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

			// Array to collect rrule into.
			$rrule_args = array();

			// Continue until find a bad argument.
			$continue = true;

			// Start Date
			if ( $continue ) {

				// Date is invalid.
				if ( empty( $args['start_date'] ) || ! $this->validate_date( $args['start_date'] ) ) {
					$continue = false;
				}

				// Date is valid.
				else {

					// Get start date's day of week (used later with rrule).
					$start_date_day_of_week_abbrev = strtoupper( substr( date( 'D', strtotime( $args['start_date'] ) ), 0, 2 ) ); // English, two-letter code.

					// Format for rrule.
					$rrule_args['DTSTART'] = $args['start_date'];

				}

			}

			// Until Date (optional).
			if ( $continue ) {

				// Value is provided.
				if ( ! empty( $args['until_date'] ) ) {

					// Date is invalid.
					if ( ! $this->validate_date( $args['until_date'] ) ) {
						$continue = false;
					}

					// Format for rrule.
					else {
						$rrule_args['UNTIL'] = $args['until_date'];
					}

				}

			}

			// Frequency.
			if ( $continue ) {

				// Value is invalid.
				if ( empty( $args['frequency'] ) || ! in_array( $args['frequency'], array( 'weekly', 'monthly', 'yearly' ) ) ) {
					$continue = false;
				}

				// Format for rrule.
				else {
					$rrule_args['FREQ'] = strtoupper( $args['frequency'] );
				}

			}

			// Interval
			// Every X weeks / months / years
			if ( $continue ) {

				// Default is 1 if nothing given
				if ( empty( $args['interval'] ) ) {
					$args['interval'] = 1;
				}

				// Invalid if not numeric or is negative
				if ( ! is_numeric( $args['interval'] ) || $args['interval'] < 1 ) {
					$continue = false;
				}

				// Format for rrule.
				else {
					$rrule_args['INTERVAL'] = $args['interval'];
				}

			}

			// Monthly Type (required when frequency is monthly)
			if ( $continue ) {

				// Value is required
				if ( 'monthly' == $args['frequency'] ) {

					// Default to day if none
					if ( empty( $args['monthly_type'] ) ) {
						$args['monthly_type'] = 'day';
					}

					// Value is invalid
					if ( ! in_array( $args['monthly_type'], array( 'day', 'week' ) ) ) {
						$continue = false; // value is invalid
					}

				}

				// Not required in this case
				else {
					$args['monthly_type'] = '';
				}

			}

			// Weekly Day(s) (value when frequency is weekly).
			if ( $continue ) {

				// Value is required.
				if ( 'weekly' == $args['frequency'] ) {

					// Weekly day valid values.
					$weekly_day_valid_values = array(
						'SU',
						'MO',
						'TU',
						'WE',
						'TH',
						'FR',
						'SA',
					);

					// If value is empty, assume Start Date's day of week.
					if ( empty( $args['weekly_day'] ) && ! empty( $rrule_args['DTSTART'] ) ) {
						$args['weekly_day'] = wp_json_encode( array( $start_date_day_of_week_abbrev ) );
					}

					// Have value.
					if ( ! empty( $args['weekly_day'] ) ) {

						// Decode JSON array.
						$weekly_day_decoded = json_decode( $args['weekly_day'] );

						// Not an array
						if ( ! is_array( $weekly_day_decoded ) ) {
							$continue = false; // value is invalid.
						}

						// Is an array.
						else {

							// Loop 2-letter day of week code(s).
							$weekly_day_rrule = array();
							foreach ( $weekly_day_decoded as $weekly_day_value ) {

								// Day of week code is invalid.
								// All must be valid to continue.
								if ( ! in_array( $weekly_day_value, $weekly_day_valid_values ) ) {
									$continue = false;
									$weekly_day_rrule = array();
									break;
								}

								// Valid, add to array for rrule.
								else {
									$weekly_day_rrule[] = $weekly_day_value;
								}

							}

							// Format for rrule.
							if ( $continue && $weekly_day_rrule ) { // values all valid.
								$rrule_args['BYDAY'] = $weekly_day_rrule;
							}

						}

					}

				}

				// Not required in this case
				else {
					$args['weekly_day'] = '';
				}

			}

			// Monthly Week(s) (required when frequency is monthly and monthly_type is week).
			if ( $continue ) {

				// Value is required.
				if ( 'monthly' == $args['frequency'] && 'week' == $args['monthly_type'] ) {

					// Monthly week valid values.
					$monthly_week_valid_values = array( '1', '2', '3', '4', 'last' );

					// First, if value is single string, convert to JSON-encoded array.
					// Church Content Pro converted to this format to accommodate multiple weeks of month.
					// This is to create some backwards compatability between this class and old Custom Recurring Events users.
					if ( ! empty( $args['monthly_week'] ) && in_array( $args['monthly_week'], $monthly_week_valid_values ) ) {
						$args['monthly_week'] = (array) $args['monthly_week']; // convert single value to array.
						$args['monthly_week'] = wp_json_encode( $args['monthly_week'] ); // JSON-encode.
					}

					// Value is invalid.
					if ( empty( $args['monthly_week'] ) ) {
						$continue = false; // value is invalid.
					}

					// Value is valid.
					else {

						// Decode JSON array.
						$monthly_week_decoded = json_decode( $args['monthly_week'] );

						// Not an array
						if ( ! is_array( $monthly_week_decoded ) ) {
							$continue = false; // value is invalid.
						}

						// Is an array.
						else {

							// Loop values to validate each.
							$monthly_week_rrule = array();
							foreach ( $monthly_week_decoded as $monthly_week_value ) {

								// Is value valid?
								if ( ! in_array( $monthly_week_value, $monthly_week_valid_values, true ) ) {
									$continue = false; // value is invalid.
									$monthly_week_rrule = array();
									break; // stop checking other values; they must all be valid
								}

								// Valid, add to array for rrule.
								$monthly_week_rrule[] = str_replace( 'last', '-1', $monthly_week_value ); // -1 is last week of month.

							}

							// Format for rrule.
							if ( $continue && $monthly_week_rrule ) { // values all valid.
								$rrule_args['BYSETPOS'] = implode( ',', $monthly_week_rrule ); // 1 is week one, 2, 3, etc.; -1 is last week of month. Comma-separated.
								$rrule_args['BYDAY'] = $start_date_day_of_week_abbrev; // start date's day of week as 2-letter abbreviation.
							}

						}

					}

				}

				// Not required in this case.
				else {
					$args['monthly_week'] = '';
				}

			}

			// Limit (optional)
			if ( $continue ) {

				// Set default if no until date to prevent infinite loop
				if ( empty( $args['limit'] ) && empty( $args['until_date'] ) ) {
					$args['limit'] = 100;
				}

				// Limit is not numeric or is negative
				if ( ! empty( $args['limit'] ) && ( ! is_numeric( $args['limit'] ) || $args['limit'] < 1 ) ) {
					$args['limit'] = false;
				}

				// Format for rrule.
				else {

					// Only if UNTIL not set; cannot use both with rrule.
					if ( empty( $rrule_args['UNTIL'] ) ) {
						$rrule_args['COUNT'] = $args['limit'];
					}

				}

			}

			// Return rrule args or false.
			if ( $rrule_args ) {
				return $rrule_args;
			} else {
				return false;
			}

		}

		/**
		 * Get dates
		 *
		 * Get multiple recurring dates.
		 * The start date is included in the dates returned.
		 *
		 * Until 2.0, this calculated dates on its own. Now it uses php-rrule.
		 * The original argument names are still used and auto-converted to rrule format.
		 *
		 * @since 0.9
		 * @access public
		 * @param array $args Arguments determining recurrence.
		 * @return array|bool Array of dates or false if arguments invalid.
		 */
		public function get_dates( $args ) {

			// Return false if no result.
			$dates = false;

			// Get valid arguments suitable for php-rrule.
			$rrule_args = $this->prepare_args( $args );

echo '<pre>';
print_r( $rrule_args );
echo '</pre>';

			// Get multiple recurring dates.
			if ( $rrule_args ) {

				// Calculate dates.
				$results = new RRule( $rrule_args );

				// Format and add to array.
				$dates = array();
				$count = 0;
				foreach ( $results as $date ) {
					$dates[] = $date->format( 'Y-m-d' );
				}

				// Limit results.
				// With rrule, limit has no effect when until_date is in use, so it's possible limit is exceeded when using until_date.
				// This ensure limit is always enforced.
				if ( ! empty( $args['limit'] ) && is_numeric( $args['limit'] ) && $args['limit'] > 0 ) { // given, is number, not negative.
					$dates = array_slice( $dates, 0, $args['limit'] );
				}

			}

			return $dates;

		}

		/**
		 * Validate date
		 *
		 * @since 0.9
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

/*******************************************
 * EXAMPLE USAGE
 *******************************************/

// Copy this code to an appropriate place and go to wp-admin/?recurrence_test=1

if ( is_admin() && ! empty( $_GET['recurrence_test' ] ) ) {

	// Instantiate class first
	$ct_recurrence = new CT_Recurrence();

	// Specify arguments
	// Note: until_date does not have effect on the calc_* methods, only the get_* methods
	$args = array(
		'start_date'			=> '2017-10-01', // first day of event, YYYY-mm-dd (ie. 2015-07-20 for July 15, 2015)
		'until_date'			=> '2017-12-31', // date recurrence should not extend beyond (has no effect on calc_* functions)
		//'frequency'			=> 'monthly', // weekly, monthly, yearly
		'frequency'				=> 'weekly', // weekly, monthly, yearly
		'interval'				=> '1', // every 1, 2 or 3 weeks, months or years
		'weekly_day'			=> wp_json_encode( array( // data is now stored as JSON-encoded array with one or more values
									//'SU',
									//'MO',
									'TU',
									//'WE',
									'TH',
									//'FR',
									//'SA',
								) ),
		'monthly_type'			=> 'week', // day (same day of month) or week (on a specific week); if recurrence is monthly (day is default)
		//'monthly_week'		=> '1', // was formerly a single value as string - test this for back-compat, 1 - 4 or 'last'; if recurrence is monthly and monthly_type is 'week'
		'monthly_week'			=> wp_json_encode( array( // data is now stored as JSON-encoded array with one or more values
									'1',
									'2',
									'3',
									'4',
									'last',
								) ),
		'limit'					=> '20', // maximum dates to return (if no until_date, default is 100 to prevent infinite loop)
	);

	?>

	<h4>$args</h3>

	<?php echo '<pre>' . print_r( $args, true ) . '</pre>'; ?>

	<h4>get_dates()</h3>

	<?php

	$dates = $ct_recurrence->get_dates( $args );

	?>

	<pre><?php

		if ( $dates ) {

			foreach( $dates as $date ) {
				echo date( 'Y-m-d  F j, Y 	(l)', strtotime( $date ) );
				echo '<br>';
			}

		}

	?></pre>

	<?php

	exit;

}


