<?php
/**
 * Scheduled Functions
 *
 * Schedule functions to run at certain times using the WordPress "cron" functions.
 *
 * @package    Church_Theme_Content
 * @subpackage Functions
 * @copyright  Copyright (c) 2013 - 2018, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
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

	// Schedule if not already scheduled.
	if ( ! wp_next_scheduled( 'ctc_update_recurring_event_dates' ) ) {
		wp_schedule_event( time(), 'hourly', 'ctc_update_recurring_event_dates' ); // hourly so happens as soon as possible after event ends the day before.
	}

}

add_action( 'wp', 'ctc_schedule_recurring_events' );

/**
 * Update recurring event dates.
 *
 * @since 0.9
 * @param bool $force Force update even when recurrence not supported (for sample content imports to be up to date).
 */
function ctc_update_recurring_event_dates( $force = false ) {

	// Only if recurrence is supported.
	if ( ! $force && ! ctc_field_supported( 'events', '_ctc_event_recurrence' ) ) {
		return;
	}

	// Get all events with end date in past and have valid recurring value.
	$events_query = new WP_Query( array(
		'post_type'       => 'ctc_event',
		'nopaging'        => true,
		'meta_query'      => array(
			'relation'    => 'AND',
			array(
				'key'     => '_ctc_event_end_date',
				'value'   => date_i18n( 'Y-m-d' ), // today localized.
				'compare' => '<', // earlier than today.
				'type'    => 'DATE',
			),
			array(
				'key'     => '_ctc_event_recurrence',
				'value'   => array( 'weekly', 'monthly', 'yearly' ),
				'compare' => 'IN',
			),
		),
	) );

	// Loop events.
	if ( ! empty( $events_query->posts ) ) {

		// Instantiate recurrence class.
		$ctc_recurrence = new CT_Recurrence();

		// Loop events to modify dates.
		foreach ( $events_query->posts as $post ) {

			// Get start and end date.
			$start_date = get_post_meta( $post->ID, '_ctc_event_start_date', true );
			$end_date = get_post_meta( $post->ID, '_ctc_event_end_date', true );

			// Get recurrence.
			$recurrence = get_post_meta( $post->ID, '_ctc_event_recurrence', true );
			$recurrence_end_date = get_post_meta( $post->ID, '_ctc_event_recurrence_end_date', true );

			// Difference between start and end date in seconds.
			$time_difference = strtotime( $end_date ) - strtotime( $start_date );

			// Get soonest occurrence that is today or later.
			$args = array(
				'start_date' => $start_date, // first day of event, YYYY-mm-dd (ie. 2015-07-20 for July 15, 2015).
				'frequency'  => $recurrence, // weekly, monthly, yearly.
			);
			$args = apply_filters( 'ctc_event_recurrence_args', $args, $post ); // Pro / Custom Recurring Events add-ons hook into this.
			$new_start_date = $ctc_recurrence->calc_next_future_date( $args );

			// If no new start date gotten, set it to current start date.
			// This could be because recurrence ended, arguments are invalid, etc.
			if ( ! $new_start_date ) {
				$new_start_date = $start_date;
			}

			// Add difference between original start/end date to new start date to get new end date.
			$new_end_date = date( 'Y-m-d', ( strtotime( $new_start_date ) + $time_difference ) );

			// Has recurrence ended?
			// Recurrence end date exists and is earlier than new start date.
			if ( $recurrence_end_date && strtotime( $recurrence_end_date ) < strtotime( $new_start_date ) ) {

				// Unset recurrence option to keep dates from being moved forward.
				update_post_meta( $post->ID, '_ctc_event_recurrence', 'none' );

			}

			// No recurrence or recurrence end date is still future.
			else {

				// Update start and end dates.
				update_post_meta( $post->ID, '_ctc_event_start_date', $new_start_date );
				update_post_meta( $post->ID, '_ctc_event_end_date', $new_end_date );

				// Update the hidden datetime fields for ordering.
				ctc_update_event_date_time( $post->ID );

			}

			// Action after process a single recurring event.
			// Example: Pro hooks into this to remove past excluded dates.
			do_action( 'ctc_update_recurring_event_dates_after', $post->ID );

		}

	}

}

add_action( 'ctc_update_recurring_event_dates', 'ctc_update_recurring_event_dates' );

// Uncomment for development and debugging. Recurrence will run on every page load.
// Or, install the Crontrol plugin to execute the scheduled cron event on demand.
//add_action( 'admin_init', 'ctc_update_recurring_event_dates' );
