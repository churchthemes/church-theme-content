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

					// Date is earlier than start date
					if ( $args && strtotime( $args['until_date'] ) < strtotime( $args['start_date'] ) ) {
						$args = false;
					}

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
		 * Get dates recurring in the future
		 *
		 * @since 0.1
		 * @access public
		 * @param array $args Arguments determining future recurrence
		 * @return array|bool Array of dates or false if arguments invalid
		 */
		public function get_dates( $args ) {

			$dates = array();

			// Validate and set default arguments
			$args = $this->prepare_args( $args );



			return $dates;

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
