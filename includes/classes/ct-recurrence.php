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

// Prepare for php-rrule.
use RRule\RSet;

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
				'excluded_dates',
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

				// Convert and sanitize.
				if ( ! empty( $new_args[$arg] ) ) {

					// If JSON, decode it.
					if ( is_string( $new_args[$arg] ) && preg_match( '/^(\[|\{)/', $new_args[$arg] ) ) {
						$new_args[$arg] = json_decode( $new_args[$arg] );
					}

					// If comma, separated list, convert to array.
					if ( is_string( $new_args[$arg] ) && preg_match( '/,/', $new_args[$arg] ) ) {
						$new_args[$arg] = explode( ',', $new_args[$arg] );
					}

					// Trim string value.
					if ( is_string( $new_args[$arg] ) ) {
						$new_args[$arg] = trim( $new_args[$arg] );
					}

					// Trim array values.
					if ( is_array( $new_args[$arg] ) ) {

						// Trim each value in array.
						foreach ( $new_args[$arg] as $key => $value ) {
							$new_args[$arg][$key] = trim( $value );
						}

					}

				}

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

					// If value is string, cast to array.
					if ( ! empty( $args['weekly_day'] ) && is_string( $args['weekly_day'] ) ) {
						$args['weekly_day'] = (array) $args['weekly_day'];
					}

					// If value is empty, assume Start Date's day of week.
					if ( empty( $args['weekly_day'] ) && ! empty( $rrule_args['DTSTART'] ) ) {
						$args['weekly_day'] = array( $start_date_day_of_week_abbrev );
					}

					// Have value.
					if ( ! empty( $args['weekly_day'] ) ) {

						// Not an array
						if ( ! is_array( $args['weekly_day'] ) ) {
							$continue = false; // value is invalid.
						}

						// Is an array.
						else {

							// Loop 2-letter day of week code(s).
							$weekly_day_rrule = array();
							foreach ( $args['weekly_day'] as $weekly_day_value ) {

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

					// First, if value is single string, convert to array.
					// Church Content Pro converted to this format to accommodate multiple weeks of month.
					// This is to create some backwards compatability between this class and old Custom Recurring Events users.
					if ( ! empty( $args['monthly_week'] ) && in_array( $args['monthly_week'], $monthly_week_valid_values ) ) {
						$args['monthly_week'] = (array) $args['monthly_week']; // convert single value to array.

					}

					// Value is invalid.
					if ( empty( $args['monthly_week'] ) ) {
						$continue = false; // value is invalid.
					}

					// Value is valid.
					else {

						// Not an array
						if ( ! is_array( $args['monthly_week'] ) ) {
							$continue = false; // value is invalid.
						}

						// Is an array.
						else {

							// Loop values to validate each.
							$monthly_week_rrule = array();
							foreach ( $args['monthly_week'] as $monthly_week_value ) {

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

			// Excluded dates.
			if ( $continue ) {

				// Convert string to array.
				$args['excluded_dates'] = (array) $args['excluded_dates'];

				// Loop each.
				foreach ( $args['excluded_dates'] as $k => $excluded_date ) {

					// Invalid date.
					if ( ! $this->validate_date( $excluded_date ) ) {
						unset( $args['excluded_dates'][$k] ); // remove from array.
					}

				}

			}

			// Limit (optional).
			if ( $continue ) {

				// Set default if no until date to prevent infinite loop.
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

			// Return args or false.
			if ( $continue ) {

				return array(
					'args' => $args,
					'rrule_args' => $rrule_args,
				);

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

			// Get prepared arguments.
			$args = $this->prepare_args( $args );
			$rrule_args = $args['rrule_args']; // rrule args to add to RSet.
			$args = $args['args']; // original arguments prepared.

			// Get multiple recurring dates.
			if ( $rrule_args ) {

				// Start building RSet
				$rset = new RSet();
				$rset->addRRule( $rrule_args );

				// Exclude dates.
				foreach ( $args['excluded_dates'] as $excluded_date ) {
					$rset->addExDate( $excluded_date );
				}

				// Format and add to array.
				foreach ( $rset as $date ) {
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
		 * Calculate next future date
		 *
		 * Calculate the next date in the future (may be today) without regard for until_date or limit.
		 * This is helpful when cron misses a beat.
		 *
		 * IMPORTANT: calc_* methods have no regard for until_date (the get_* methods do)
		 *
		 * @since 0.9
		 * @access public
		 * @param array $args Arguments determining recurrence
		 * @return string|bool Date string or false if arguments invalid or no next date
		 */
		public function calc_next_future_date( $args ) {

			$next_future_date = false;

			// Validate and set default arguments.
			$args = $this->prepare_args( $args ); // false if invalid.
			$args = $args['args'];

			// Remove the bounds of until_date and limit.
			$args['until_date'] = ''; // old version of plugin disregarded until_date, keeping this behavior.
			$args['limit'] = '1000'; // 1000 is virtually unlimited without significant performance hit and while avoiding infinite loop.

			// Have valid args.
			if ( $args ) {

				// Convert today's date to localized timestamp for comparison.
				$today_ts = strtotime( date_i18n( 'Y-m-d' ) ); // localized.

				// Get date occurences.
				$dates = $this->get_dates( $args );

				// Have dates.
				if ( $dates ) {

					// Loop dates.
					foreach ( $dates as $date ) {

						// Convert date to timestamp for comparison.
						$date_ts = strtotime( $date );

						// Is this date today or future?
						if ( $date_ts >= $today_ts ) {

							// Capture as next future date.
							$next_future_date = $date;

							// Stop, we only need the first that is not past.
							break;

						}

					}

				}

			}

			return $next_future_date;

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

			// Check format.
			// 2014-1-1 is not valid.
			if ( preg_match( '/([0-9]{4})-([0-9]{2})-([0-9]{2})/', $date ) ) {

				// Get year, month, day.
				list( $y, $m, $d ) = explode( '-', $date );

				// Check that date itself is valid.
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
	// Note: until_date does not have effect on the calc_* methods, only the get_* methods.
	$args = array(
		'start_date'			=> '2017-10-01', // first day of event, YYYY-mm-dd (ie. 2015-07-20 for July 15, 2015).
		'until_date'			=> '2017-12-31', // date recurrence should not extend beyond (has no effect on calc_* functions).
		'frequency'				=> 'weekly', // weekly, monthly, yearly.
		'interval'				=> '1', // every X weeks, months or years.
		'weekly_day'			=> wp_json_encode( array( // single value, array or JSON-encoded array of day of week in 2-letter format (SU, MO, TU, etc.). If empty, uses same day of week.
										'SU',
										'MO',
										'TU',
										'WE',
										'TH',
										'FR',
										'SA',
									) ),
		'monthly_type'			=> 'week', // day (same day of month) or week (on a specific week); if recurrence is monthly (day is default).
		//'monthly_week'		=> '1', // was formerly a single value as string - test this for back-compat, 1 - 4 or 'last'; if recurrence is monthly and monthly_type is 'week'.
		'monthly_week'			=> wp_json_encode( array( // single value, array or JSON-encoded array of numeric week(s) of month (or 'last') (1, 3, last, etc.).
									'1',
									//'2',
									//'3',
									//'4',
									'last',
								) ),
		'excluded_dates'		=> array(
									//'2017-10-01',
									//'2017-11-05',
								),
		'limit'					=> '20', // maximum dates to return (if no until_date, default is 1000 to prevent infinite loop).
	);

	// Get prepared args for display purposes (get_dates() does this itself).
	$prepared_args = $ct_recurrence->prepare_args( $args );

	?>

	<h4>$args passed in</h4>

	<?php echo '<pre>' . print_r( $args, true ) . '</pre>'; ?>

	<h4>$args prepared</h4>

	<?php echo '<pre>' . print_r( $prepared_args['args'], true ) . '</pre>'; ?>

	<h4>$rrule_args</h4>

	<?php echo '<pre>' . print_r( $prepared_args['rrule_args'], true ) . '</pre>'; ?>

	<h4>get_dates()</h4>

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

	<h4>calc_next_future_date()</h4>

	<?php

	$next_future_date = $ct_recurrence->calc_next_future_date( $args );

	if ( $next_future_date ) {
		echo '<pre>' . date( 'Y-m-d  F j, Y 	(l)', strtotime( $next_future_date ) ) . '</pre>';
	}

	?>

	<?php

	exit;

}
