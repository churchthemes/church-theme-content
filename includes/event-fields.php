<?php
/**
 * Event Fields
 *
 * Global event field functions (ie. functions necessary outside of admin area).
 *
 * @package    Church_Theme_Content
 * @subpackage Functions
 * @copyright  Copyright (c) 2013 - 2017, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      1.2
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**********************************
 * META DATA
 **********************************/

/**
 * Update Date/Time Hidden Fields
 *
 * Date and Time fields are combined into one field for easier ordering (simpler queries)
 *
 * If no date, value will be 0000-00-00 00:00:00
 * If no time, value will be 2014-10-28 00:00:00
 *
 * This is run after an event is saved and after an event recurs (note that schedule.php runs on front-end).
 *
 * @since 1.2
 * @param int $post_id Post ID
 */
function ctc_update_event_date_time( $post_id ) {

	// Get Start/End Date and Time fields
	$start_date 	= get_post_meta( $post_id, '_ctc_event_start_date', true );
	$end_date 		= get_post_meta( $post_id, '_ctc_event_end_date', true );
	$start_time 	= get_post_meta( $post_id, '_ctc_event_start_time', true );
	$end_time 		= get_post_meta( $post_id, '_ctc_event_end_time', true );

	// Combine dates and times
	$start_date_start_time 	= ctc_convert_to_datetime( $start_date, $start_time );	// Useful for ordering upcoming events (soonest to farthest)
	$start_date_end_time  	= ctc_convert_to_datetime( $start_date, $end_time ); 	// It's possible there will be a use for this combination
	$end_date_start_time  	= ctc_convert_to_datetime( $end_date, $start_time );	// Useful for ordering past events (those ended most recently first)
	$end_date_end_time  	= ctc_convert_to_datetime( $end_date, $end_time );  	// It's possible there will be a use for this combination

	// Update date/time fields
	update_post_meta( $post_id, '_ctc_event_start_date_start_time', $start_date_start_time );
	update_post_meta( $post_id, '_ctc_event_start_date_end_time', $start_date_end_time );
	update_post_meta( $post_id, '_ctc_event_end_date_start_time', $end_date_start_time );
	update_post_meta( $post_id, '_ctc_event_end_date_end_time', $end_date_end_time );

}
