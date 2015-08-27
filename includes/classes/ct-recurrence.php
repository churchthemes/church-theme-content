<?php
/**
 * CT Recurrence Class
 *
 * This class presents future recurring dates based on given arguments.
 * It is used in the Church Theme Content, Custom Recurring Events add-on and Church Theme Framework.
 *
 * It is compatible with PHP 5.2.4, the minimum version required by WordPress.
 * PHP manual recommends using DateTime::modify() for PHP 5.2 versus strtotime().
 * See last note on http://php.net/manual/en/function.strtotime.php
 *
 * Otherwise, simshaun/recurr or tplaner/When would be a good choice.
 *
 * See example usage at bottom of this file.
 *
 * @copyright Copyright (c) 2014 - 2015 churchthemes.com
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

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
			$this->version = '0.9';

		}

		/**
		 * Prepare arguments
		 *
		 * This validates, sets defaults and returns arguments.
		 * It returns false if any of the arugments are invalid.
		 *
		 * @since 0.9
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
		 * Calculate next date
		 *
		 * Calculate next date without regard for until_date or limit.
		 * This may or may not be in the future.
		 *
		 * IMPORTANT: calc_* methods have no regard for until_date (the get_* methods do)
		 *
		 * @since 0.9
		 * @access public
		 * @param array $args Arguments determining recurrence
		 * @return string|bool Date string or false if arguments invalid or no next date
		 */
		public function calc_next_date( $args ) {

			$date = false;

			// Validate and set default arguments
			$args = $this->prepare_args( $args );

			// Get next recurring date
			// This may or may not be future
			if ( $args ) { // valid args

				// Get month, day and year
				list( $start_date_y, $start_date_m, $start_date_d ) = explode( '-', $args['start_date'] );

				// Calculate next recurrence
				switch ( $args['frequency'] ) {

					// Weekly
					case 'weekly' :

						// Add week(s)
						// This will always be the same day of the week (Mon, Tue, etc.)
						$DateTime = new DateTime( $args['start_date'] );
						$DateTime->modify( '+' . $args['interval'] . ' weeks' );
						list( $y, $m, $d ) = explode( '-', $DateTime->format( 'Y-m-d' ) );

						break;

					// Monthly
					case 'monthly' :

						// On same day of the month
						// Move forward X month(s)
						$DateTime = new DateTime( $args['start_date'] );
						$DateTime->modify( '+' . $args['interval'] . ' months' );
						list( $y, $m, $d ) = explode( '-', $DateTime->format( 'Y-m-d' ) );

							// If day is less than what it was, the next month was skipped to because day of month didn't exist
							// For example, October 31 recurring monthly became December 1, because November 31 doesn't example
							// Another example is Feburary 29 not existing except on leap years
							// Users should use "Last Day" instead of 29+ since they do not always exist (they can edit to correct)
							if ( $d < $start_date_d ) {

								// Move back to last day of last month
								// It makes more helpful to stay on same month than skip to the next
								$m--;
								if ( 0 == $m ) {
									$m = 12;
									$y--;
								}

								// Get days in the prior month
								$d = date( 't', mktime( 0, 0, 0, $m, $d, $y) );

							}

						// On a specific week of month's day
						// 1st - 4th or Last day of week in the month
						// This will adjust day of the month from "same day" to "Third Sunday", for example
						// Note: Every month always has at least 4 full weeks (only 5 or 6 occasionally)
						if ( 'week' == $args['monthly_type'] && ! empty( $args['monthly_week'] ) ) {

							// What is start_date's day of the week
							// 0 - 6 represents Sunday through Saturday
							$start_date_day_of_week = date( 'w', strtotime( $args['start_date'] ) );

							// Loop the days of this month
							$week_of_month = 1;
							$times_day_of_week_found = 0;
							$days_in_month = date( 't', mktime( 0, 0, 0, $m, 1, $y ) );

							for ( $i = 1; $i <= $days_in_month; $i++ ) {

								// Get this day's day of week (0 - 6)
								$day_of_week = date( 'w', mktime( 0, 0, 0, $m, $i, $y ) );

								// This day's day of week matches start date's day of week
								if ( $day_of_week == $start_date_day_of_week ) {

									$last_day_of_week_found = $i;

									// Count it
									$times_day_of_week_found++;

									// Is this the 1st - 4th day of week we're looking for?
									if ( $args['monthly_week'] == $times_day_of_week_found ) {

										$d = $i;

										break;

									}

								}

							}

							// Are we looking for 'last' day of week in a month?
							if ( 'last' == $args['monthly_week'] && ! empty( $last_day_of_week_found ) ) {
								$d = $last_day_of_week_found;
							}

						}

						break;

					// Yearly
					case 'yearly' :

						// Move forward X year(s)
						$DateTime = new DateTime( $args['start_date'] );
						$DateTime->modify( '+' . $args['interval'] . ' years' );
						list( $y, $m, $d ) = explode( '-', $DateTime->format( 'Y-m-d' ) );

							// If day is less than what it was, the next month was skipped to because day of month didn't exist
							// In the case of year this happens when February 29 tries to recur to next non-leap year
							// Users should use "Last Day" instead of 29+ since they do not always exist (they can edit to correct)
							if ( $d < $start_date_d ) {

								// Move back to last day of last month
								// It is more helpful to stay on same month than skip to the next
								$m--;
								if ( 0 == $m ) {
									$m = 12;
									$y--;
								}

								// Get days in the prior month
								$d = date( 't', mktime( 0, 0, 0, $m, $d, $y) );

							}

						break;

				}

				// Form the date string
				$date = date( 'Y-m-d', mktime( 0, 0, 0, $m, $d, $y ) ); // pad day, month with 0

			}

			return $date;

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

			// Get next date
			// This may or may not be future
			$date = $this->calc_next_date( $args ); // returns false if invalid args

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
					$date = $this->calc_next_date( $next_args );

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
		 * Get dates
		 *
		 * Get multiple recurring dates.
		 * The start date is included in the dates returned.
		 *
		 * @since 0.9
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
				while ( ++$i && $args['limit'] != 1) {

					// Get next date
					$next_args = $args;
					$next_args['start_date'] = $next_start_date;
					$next_date = $this->calc_next_date( $next_args );

					// If for some reason no next date can be calculated, stop
					// This is a safeguard to prevent an infinite loop
					if ( empty( $next_date ) ) {
						break;
					}

					// Has until_date been exceeded?
					if ( ! empty( $args['until_date'] ) ) { // until date is provided

						$until_date_ts = strtotime( date_i18n( 'Y-m-d', strtotime( $args['until_date'] ) ) ); // localized
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

/*

if ( is_admin() && ! empty( $_GET['recurrence_test' ] ) ) {

	// Instantiate class first
	$ct_recurrence = new CT_Recurrence();

	// Specify arguments
	// Note: until_date does not have effect on the calc_* methods, only the get_* methods
	$args = array(
		'start_date'			=> '2014-01-01', // first day of event, YYYY-mm-dd (ie. 2015-07-20 for July 15, 2015)
		//'until_date'			=> '2014-06-01', // date recurrence should not extend beyond (has no effect on calc_* functions)
		'frequency'				=> 'monthly', // weekly, monthly, yearly
		'interval'				=> '1', // every 1, 2 or 3 weeks, months or years
		'monthly_type'			=> 'week', // day (same day of month) or week (on a specific week); if recurrence is monthly (day is default)
		'monthly_week'			=> '1', // 1 - 4 or 'last'; if recurrence is monthly and monthly_type is 'week'
		'limit'					=> '20', // maximum dates to return (if no until_date, default is 100 to prevent infinite loop)
	);

	?>

	<h4>$args</h3>

	<?php echo '<pre>' . print_r( $args, true ) . '</pre>'; ?>

	<h4>calc_next_date()</h3>

	<?php
	$date = $ct_recurrence->calc_next_date( $args );
	?>

	<pre>Start Date:<br><?php echo date( 'Y-m-d  F j, Y 	(l)', strtotime( $args['start_date'] ) ); ?></pre>
	<pre>Recur Date:<br><?php echo date( 'Y-m-d  F j, Y 	(l)', strtotime( $date ) ); ?></pre>

	<h4>calc_next_future_date()</h3>

	<?php
	$date = $ct_recurrence->calc_next_future_date( $args );
	?>

	<pre>Start Date:<br><?php echo date( 'Y-m-d  F j, Y 	(l)', strtotime( $args['start_date'] ) ); ?></pre>
	<pre>Recur Date:<br><?php echo date( 'Y-m-d  F j, Y 	(l)', strtotime( $date ) ); ?></pre>

	<h4>get_dates()</h3>

	<?php

	$dates = $ct_recurrence->get_dates( $args );

	?>

	<pre><?php

		foreach( $dates as $date ) {
			echo date( 'Y-m-d  F j, Y 	(l)', strtotime( $date ) );
			echo '<br>';
		}

	?></pre>

	<?php

	exit;

}

*/