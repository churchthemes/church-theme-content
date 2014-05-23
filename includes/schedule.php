<?php
/**
 * Scheduled Functions
 *
 * Schedule functions to run at certain times using the WordPress "cron" functions.
 *
 * @package    Church_Theme_Content
 * @subpackage Functions
 * @copyright  Copyright (c) 2013, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*************************************************
 * RECURRING EVENTS
 *************************************************/

/**
 * Schedule weekly, monthly and yearly events
 *
 * Move recurring event dates forward after they end.
 *
 * @since 0.9
 */
function ctc_schedule_recurring_events() {

	// Schedule if not already scheduled
	if ( ! wp_next_scheduled( 'ctc_update_recurring_event_dates' ) ) {
		wp_schedule_event( time(), 'hourly', 'ctc_update_recurring_event_dates' ); // hourly so happens as soon as possible after event ends the day before
	}

}

add_action( 'wp', 'ctc_schedule_recurring_events' );

/**
 * Update recurring event dates
 *
 * @since 0.9
 */
function ctc_update_recurring_event_dates() {

	// Localized dates
	$yesterday = date_i18n( 'Y-m-d', time() - DAY_IN_SECONDS );

	// Get all events with end date in past and have valid recurring value and
	$events_query = new WP_Query( array(
		'post_type'	=> 'ctc_event',
		'nopaging'	=> true,
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => '_ctc_event_end_date',
				'value' => date_i18n( 'Y-m-d' ), // today localized
		 		'compare' => '<', // earlier than today
		   ),
			array(
				'key' => '_ctc_event_recurrence',
				'value' => array( 'weekly', 'monthly', 'yearly' ),
		 		'compare' => 'IN',
		   )
		)
	) );

	// Loop events
	if ( ! empty( $events_query->posts ) ) {

		foreach ( $events_query->posts as $post ) {

		 	// Get recurrence
		 	$recurrence = get_post_meta( $post->ID, '_ctc_event_recurrence', true );
			$recurrence_end_date = get_post_meta( $post->ID, '_ctc_event_recurrence_end_date', true );

			// Get start and end dates
			$start_date = get_post_meta( $post->ID, '_ctc_event_start_date', true );
			$end_date = get_post_meta( $post->ID, '_ctc_event_end_date', true );

			// Difference between start and end date in seconds
			$time_difference = strtotime( $end_date ) - strtotime( $start_date );

			// Calculate incremented dates
			$new_start_date = ctc_increment_future_date( $start_date, $recurrence ); // get closest incremented date in future
			$new_end_date = date( 'Y-m-d', ( strtotime( $new_start_date ) + $time_difference ) ); // add difference between original start/end date to new start date to get new end date

			// Has recurrence ended?
			// Recurrence end date exists and is earlier than new start date
			if ( $recurrence_end_date && strtotime( $recurrence_end_date ) < strtotime( $new_start_date ) ) {

				// Unset recurrence option to keep dates from being moved forward
				update_post_meta( $post->ID, '_ctc_event_recurrence', 'none' );

			}

			// No recurrence or recurrence end date is still future
			else {

				// Update dates
				update_post_meta( $post->ID, '_ctc_event_start_date', $new_start_date );
				update_post_meta( $post->ID, '_ctc_event_end_date', $new_end_date );

			}

		}

	}

}

add_action( 'ctc_update_recurring_event_dates', 'ctc_update_recurring_event_dates' );
