<?php
/**
 * Event Fields
 *
 * Meta boxes and admin columns.
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2013, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**********************************
 * META BOXES
 **********************************/

/**
 * Date & time
 *
 * @since 0.9
 */
function ctc_add_meta_box_event_date() {

	// Configure Meta Box
	$meta_box = array(

		// Meta Box
		'id' 		=> 'ctc_event_date', // unique ID
		'title' 	=> _x( 'Date & Time', 'event meta box', 'church-theme-content' ),
		'post_type'	=> 'ctc_event',
		'context'	=> 'normal', // where the meta box appear: normal (left above standard meta boxes), advanced (left below standard boxes), side
		'priority'	=> 'high', // high, core, default or low (see this: http://www.wproots.com/ultimate-guide-to-meta-boxes-in-wordpress/)

		// Fields
		'fields' => array(

			// Example
			/*
			'option_key' => array(
				'name'				=> __( 'Field Name', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'This is the description below the field.', 'church-theme-content' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'=> '', // function for custom display of field input
			*/

			// Start Date
			'_ctc_event_start_date' => array(
				'name'				=> __( 'Start Date', 'church-theme-content' ),
				'after_name'		=> __( '(Required)', 'church-theme-content' ), // (Optional), (Required), etc.
				'desc'				=> '',
				'type'				=> 'date', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// End Date
			// Note: ctc_sanitize_event_end_date calback corrects end and start dates (ie. end date but no start or end is sooner than start)
			'_ctc_event_end_date' => array(
				'name'				=> __( 'End Date', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> '',
				'type'				=> 'date', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Time
			'_ctc_event_time' => array(
				'name'				=> __( 'Time', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'Optionally provide a time such as "8:00 am &ndash; 2:00 pm"', 'church-theme-content' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> 'ctmb-medium', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Recurrence
			'_ctc_event_recurrence' => array(
				'name'				=> __( 'Recurrence', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> _x( "Start and end dates will automatically move forward after the event ends.", 'event meta box', 'church-theme-content' ),
				'type'				=> 'select', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array( // array of keys/values for radio or select
					'none'			=> _x( 'None', 'event meta box', 'church-theme-content' ),
					'weekly'	=> _x( 'Weekly', 'event meta box', 'church-theme-content' ),
					'monthly'	=> _x( 'Monthly', 'event meta box', 'church-theme-content' ),
					'yearly'	=> _x( 'Yearly', 'event meta box', 'church-theme-content' ),
				),
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> 'none', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> true, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Recur Until
			'_ctc_event_recurrence_end_date' => array(
				'name'				=> __( 'Recur Until', 'church-theme-content' ),
				'after_name'		=> '',
				'desc'				=> '',
				'type'				=> 'date', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

		),

	);

	// Add Meta Box
	new CT_Meta_Box( $meta_box );

}

add_action( 'admin_init', 'ctc_add_meta_box_event_date' );

/**
 * Location
 *
 * @since 0.9
 */
function ctc_add_meta_box_event_location() {

	// Configure Meta Box
	$meta_box = array(

		// Meta Box
		'id' 		=> 'ctc_event_location', // unique ID
		'title' 	=> _x( 'Location', 'event meta box', 'church-theme-content' ),
		'post_type'	=> 'ctc_event',
		'context'	=> 'normal', // where the meta box appear: normal (left above standard meta boxes), advanced (left below standard boxes), side
		'priority'	=> 'high', // high, core, default or low (see this: http://www.wproots.com/ultimate-guide-to-meta-boxes-in-wordpress/)

		// Fields
		'fields' => array(

			// Example
			/*
			'option_key' => array(
				'name'				=> __( 'Field Name', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'This is the description below the field.', 'church-theme-content' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'=> '', // function for custom display of field input
			*/

			// Venue
			'_ctc_event_venue' => array(
				'name'				=> __( 'Venue', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'You can provide a building name, room number or other location name to help people find the event.', 'church-theme-content' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> 'ctmb-medium', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Address
			'_ctc_event_address' => array(
				'name'				=> _x( 'Address', 'event meta box', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'You can enter an address if it is necessary for people to find this event.', 'church-theme-content' ),
				'type'				=> 'textarea', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> 'ctmb-medium', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> 'ctmb-no-bottom-margin', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Directions
			'_ctc_event_show_directions_link' => array(
				'name'				=> '',
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> '',
				'type'				=> 'checkbox', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> 'Show directions link', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> true, // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> 'ctmb-no-top-margin', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Map Latitude
			'_ctc_event_map_lat' => array(
				'name'				=> _x( 'Map Latitude', 'event meta box', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'You can <a href="http://churchthemes.com/get-latitude-longitude" target="_blank">use this</a> to convert an address into coordinates.', 'church-theme-content' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> 'ctmb-medium', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Map Longitude
			'_ctc_event_map_lng' => array(
				'name'				=> _x( 'Map Longitude', 'event meta box', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> '',
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> 'ctmb-medium', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Map Type
			'_ctc_event_map_type' => array(
				'name'				=> _x( 'Map Type', 'event meta box', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> _x( 'You can show a road map, satellite imagery, a combination of both (hybrid) or terrain.', 'event meta box', 'church-theme-content' ),
				'type'				=> 'select', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> ctc_gmaps_types(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> ctc_gmaps_type_default(), // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> true, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Map Zoom
			'_ctc_event_map_zoom' => array(
				'name'				=> _x( 'Map Zoom', 'event meta box', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> _x( 'A lower number is more zoomed out while a higher number is more zoomed in.', 'event meta box', 'church-theme-content' ),
				'type'				=> 'select', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> ctc_gmaps_zoom_levels(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)

				'default'			=> ctc_gmaps_zoom_level_default(), // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> true, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

		),

	);

	// Add Meta Box
	new CT_Meta_Box( $meta_box );



}

add_action( 'admin_init', 'ctc_add_meta_box_event_location' );

/**
 * End Date sanitization
 *
 * This callback runs after CT_Meta_Box general sanitization but before saving for End Date.
 * In order for this to work properly, End Date must be after Start Date so that the saved/sanitized
 * Start Date value is available in database.
 *
 * @since 0.9.1
 * @param int $post_id Post ID
 * @param object $post Data for post being saved
 */
function ctc_correct_event_end_date( $post_id, $post ) {

	// Event is being saved
	if ( ! isset( $post->post_type ) || 'ctc_event' != $post->post_type ) {
		return;
	}

	// Is a POST occurring?
	if ( empty( $_POST ) ) {
		return;
	}

	// Not an auto-save (meta values not submitted)
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Verify the nonce
	$nonce_key = 'ctc_event_location_nonce';
	$nonce_action = 'ctc_event_location_save';
	if ( empty( $_POST[$nonce_key] ) || ! wp_verify_nonce( $_POST[$nonce_key], $nonce_action ) ) {
		return;
	}

	// Make sure user has permission to edit
	$post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return;
	}

	// Get start and end dates already saved by CT Meta Box
	$start_date = get_post_meta( $post_id, '_ctc_event_start_date', true );
	$end_date = get_post_meta( $post_id, '_ctc_event_end_date', true );

	// If end date given but start date empty, make end date start date
	if ( empty( $start_date ) && ! empty( $end_date ) ) {
		$start_date = $end_date;
		$end_date = '';
	}

	// If end date is empty or earlier than start date, use start date as end date
	// Note: end date is required for proper ordering
	if ( ! empty( $start_date )
		 && (
			empty( $end_date )
			|| ( $end_date < $start_date )
		)
	) {
		$end_date = $start_date;
	}

	// Update dates in case changed
	update_post_meta( $post_id, '_ctc_event_start_date', $start_date );
	update_post_meta( $post_id, '_ctc_event_end_date', $end_date );

}
add_action( 'save_post', 'ctc_correct_event_end_date', 11, 2 ); // after save at default 10

/**********************************
 * ADMIN COLUMNS
 **********************************/

/**
 * Add/remove event list columns
 *
 * @since 0.9
 * @param array $columns Columns to manipulate
 * @return array Modified columns
 */
function ctc_event_columns( $columns ) {

	// insert thumbnail after checkbox (before title)
	$insert_array = array();
	$insert_array['ctc_event_thumbnail'] = __( 'Thumbnail', 'church-theme-content' );
	$columns = ctc_array_merge_after_key( $columns, $insert_array, 'cb' );

	// insert start date, venue after title
	$insert_array = array();
	if ( ctc_field_supported( 'events', '_ctc_event_start_date' ) ) $insert_array['ctc_event_dates'] = _x( 'When', 'events admin column', 'church-theme-content' );
	if ( ctc_field_supported( 'events', '_ctc_event_venue' ) ) $insert_array['ctc_event_venue'] = _x( 'Where', 'events admin column', 'church-theme-content' );
	$columns = ctc_array_merge_after_key( $columns, $insert_array, 'title' );

	// remove author
	unset( $columns['author'] );

	return $columns;

}

add_filter( 'manage_ctc_event_posts_columns' , 'ctc_event_columns' ); // add columns for meta values

/**
 * Change event list column content
 *
 * @since 0.9
 * @param string $column Column being worked on
 */
function ctc_event_columns_content( $column ) {

	global $post;

	switch ( $column ) {

		// Thumbnail
		case 'ctc_event_thumbnail' :

			if ( has_post_thumbnail() ) {
				echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, array( 80, 80 ) ) . '</a>';
			}

			break;

		// Dates
		case 'ctc_event_dates' :

			$dates = array();

			$start_date = trim( get_post_meta( $post->ID , '_ctc_event_start_date' , true ) );
			if ( ! empty( $start_date ) ) {
				$dates[] = date_i18n( get_option( 'date_format' ), strtotime( $start_date ) ); // translated date
			}

			$end_date = get_post_meta( $post->ID , '_ctc_event_end_date' , true );
			if ( ! empty( $end_date ) ) {
				$dates[] = date_i18n( get_option( 'date_format' ), strtotime( $end_date ) ); // translated date
			}

			echo '<b>' . implode( _x( ' &ndash; ', 'date range separator', 'church-theme-content' ), $dates ) . '</b>';

			$time = get_post_meta( $post->ID , '_ctc_event_time' , true );
			if ( ! empty( $time ) ) {
				echo '<div class="description">' . $time . '</div>';
			}

			$recurrence = get_post_meta( $post->ID , '_ctc_event_recurrence' , true );
			if ( ! empty( $recurrence ) && $recurrence != 'none' ) {
				echo '<div class="description"><i>';
				switch ( $recurrence ) {
					case 'weekly' :
						_e( 'Recurs Weekly', 'church-theme-content' );
						break;
					case 'monthly' :
						_e( 'Recurs Monthly', 'church-theme-content' );
						break;
					case 'yearly' :
						_e( 'Recurs Yearly', 'church-theme-content' );
						break;
				}
				echo '</i></div>';
			}

			break;

		// Venue
		case 'ctc_event_venue' :

			echo get_post_meta( $post->ID , '_ctc_event_venue' , true );

			break;

	}

}

add_action( 'manage_posts_custom_column' , 'ctc_event_columns_content' ); // add content to the new columns

/**
 * Enable sorting for new columns
 *
 * @since 0.9
 * @param array $columns Columns being worked on
 * @return array Modified columns
 */
function ctc_event_columns_sorting( $columns ) {

	$columns['ctc_event_dates'] = '_ctc_event_start_date';
	$columns['ctc_event_venue'] = '_ctc_event_venue';

	return $columns;

}

add_filter( 'manage_edit-ctc_event_sortable_columns', 'ctc_event_columns_sorting' ); // make columns sortable

/**
 * Set how to sort columns (default sorting, custom fields)
 *
 * @since 0.9
 * @param array $args Sorting arguments
 * @return array Modified arguments
 */
function ctc_event_columns_sorting_request( $args ) {

	// admin area only
	if ( is_admin() ) {

		$screen = get_current_screen();

		// only on this post type's list
		if ( 'ctc_event' == $screen->post_type && 'edit' == $screen->base ) {

			// orderby has been set, tell how to order
			if ( isset( $args['orderby'] ) ) {

				switch ( $args['orderby'] ) {

					// Start Date
					case '_ctc_event_start_date' :

						$args['meta_key'] = '_ctc_event_start_date';
						$args['orderby'] = 'meta_value'; // alphabetically (meta_value_num for numeric)

						break;

					// Venue
					case '_ctc_event_venue' :

						$args['meta_key'] = '_ctc_event_venue';
						$args['orderby'] = 'meta_value'; // alphabetically (meta_value_num for numeric)

						break;

				}

			}

			// orderby not set, tell which column to sort by default
			else {

				$args['meta_key'] = '_ctc_event_start_date';
				$args['orderby'] = 'meta_value'; // alphabetically (meta_value_num for numeric)
				$args['order'] = 'DESC';

			}

		}

	}

	return $args;

}

add_filter( 'request', 'ctc_event_columns_sorting_request' ); // set how to sort columns

