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
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> __( 'This is the description below the field.', 'church-theme-content' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'=> '', // function for custom display of field input
			*/

			// Start Date
			'_ctc_event_start_date' => array(
				'name'				=> __( 'Start Date', 'church-theme-content' ),
				'after_name'		=> __( '(Required)', 'church-theme-content' ), // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time) (fields: text, select, number, upload, url, date, time)
				'desc'				=> '',
				'type'				=> 'date', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// End Date
			// Note: ctc_correct_event_end_date() callback corrects end and start dates (ie. end date but no start or end is sooner than start)
			'_ctc_event_end_date' => array(
				'name'				=> __( 'End Date', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> '',
				'type'				=> 'date', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Start Time
			'_ctc_event_start_time' => array(
				'name'				=> __( 'Start Time', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> '',
				'type'				=> 'time', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> 'ctmb-small', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// End Time
			// Note: ctc_correct_event_end_time() corrects end and start times (ie. end time but no start or end is sooner than start)
			'_ctc_event_end_time' => array(
				'name'				=> __( 'End Time', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> '',
				'type'				=> 'time', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> 'ctmb-small', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Hide Start/End Time
			// The user may just want to show the Time Description while still having a Start Time for ordeing purposes
			// An example is Sunday Worship Services having Time Description as "9:30 am and 11:00 am" with another event happening later that night
			'_ctc_event_hide_time_range' => array(
				'name'				=> '',
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> '',
				'type'				=> 'checkbox', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> __( 'Do not show times entered above (use only for ordering events)', 'church-theme-content' ), //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> false, // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> 'ctmb-no-top-margin', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Time Description
			// Formerly, "Time" was the only Time field
			// Start Time and End Time were added for precise ordering
			'_ctc_event_time' => array(
				'name'				=> __( 'Time Description', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> __( 'Optionally describe the time (e.g. "9:30 am and 11:00 am" or "After Second Service")', 'church-theme-content' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> 'ctmb-medium', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Recurrence
			'_ctc_event_recurrence' => array(
				'name'				=> __( 'Recurrence', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> _x( "Start and end dates will automatically move forward after the event ends.", 'event meta box', 'church-theme-content' ),
				'type'				=> 'select', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
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
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Recur Every X Weeks
			'_ctc_event_recurrence_weekly_every' => array(
				'name'				=> _x( 'Recur Every', 'weeks', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> __( 'week(s)', 'church-theme-content' ), // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> '',
				'type'				=> 'number', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '1', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> true, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array( // attr => value array (e.g. set min/max for number type)
					'min'	=> '1',
				),
				'class'				=> 'ctmb-three-digits', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Recur Every X Months
			'_ctc_event_recurrence_monthly_every' => array(
				'name'				=> _x( 'Recur Every', 'months', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> __( 'month(s)', 'church-theme-content' ), // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> '',
				'type'				=> 'number', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '1', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> true, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array( // attr => value array (e.g. set min/max for number type)
					'min'	=> '1',
				),
				'class'				=> 'ctmb-three-digits', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Recur Monthly Type
			// 'day' can later trigger a new field for multiple days like Apple Calendar
			'_ctc_event_recurrence_monthly_type' => array(
				'name'				=> '',
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> '',
				'type'				=> 'radio', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', // show text after checkbox
				'options'			=> array( // array of keys/values for radio or select
					'day'	=> __( 'On same day of the month', 'church-theme-content' ),
					'week'	=> __( "On a specific week...", 'church-theme-content' ),
				),
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> 'day', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> true, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Recur Monthly on Week
			'_ctc_event_recurrence_monthly_week' => array(
				'name'				=> '',
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> __( 'Day of the week is controlled by Start Date.', 'church-theme-content' ),
				'type'				=> 'select', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', // show text after checkbox
				'options'			=> array( // array of keys/values for radio or select
					''		=> __( 'Select a Week', '', 'church-theme-content' ),
					'1'		=> __( 'First', 'week of month', 'church-theme-content' ),
					'2'		=> __( 'Second', 'week of month', 'church-theme-content' ),
					'3'		=> __( 'Third', 'week of month', 'church-theme-content' ),
					'4'		=> __( 'Fourth', 'week of month', 'church-theme-content' ),
					'last'	=> __( 'Last', 'week of month', 'church-theme-content' ),
				),
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> true, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Recur Until
			'_ctc_event_recurrence_end_date' => array(
				'name'				=> __( 'Recur Until', 'church-theme-content' ),
				'after_name'		=> '',
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> '',
				'type'				=> 'date', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
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
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> __( 'This is the description below the field.', 'church-theme-content' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'=> '', // function for custom display of field input
			*/

			// Venue
			'_ctc_event_venue' => array(
				'name'				=> __( 'Venue', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> __( 'You can provide a building name, room number or other location name to help people find the event.', 'church-theme-content' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> 'ctmb-medium', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Address
			'_ctc_event_address' => array(
				'name'				=> _x( 'Address', 'event meta box', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> __( 'You can enter an address if it is necessary for people to find this event.', 'church-theme-content' ),
				'type'				=> 'textarea', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> 'ctmb-medium', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> 'ctmb-no-bottom-margin', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Directions
			'_ctc_event_show_directions_link' => array(
				'name'				=> '',
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> '',
				'type'				=> 'checkbox', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> __( 'Show directions link', 'church-theme-content' ), //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> true, // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> 'ctmb-no-top-margin', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Map Latitude
			'_ctc_event_map_lat' => array(
				'name'				=> _x( 'Map Latitude', 'event meta box', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> __( 'You can <a href="http://churchthemes.com/get-latitude-longitude" target="_blank">use this</a> to convert an address into coordinates.', 'church-theme-content' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> 'ctmb-medium', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Map Longitude
			'_ctc_event_map_lng' => array(
				'name'				=> _x( 'Map Longitude', 'event meta box', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> '',
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> 'ctmb-medium', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Map Type
			'_ctc_event_map_type' => array(
				'name'				=> _x( 'Map Type', 'event meta box', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> _x( 'You can show a road map, satellite imagery, a combination of both (hybrid) or terrain.', 'event meta box', 'church-theme-content' ),
				'type'				=> 'select', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> ctc_gmaps_types(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> ctc_gmaps_type_default(), // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> true, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// Map Zoom
			'_ctc_event_map_zoom' => array(
				'name'				=> _x( 'Map Zoom', 'event meta box', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, upload, url, date, time)
				'desc'				=> _x( 'A lower number is more zoomed out while a higher number is more zoomed in.', 'event meta box', 'church-theme-content' ),
				'type'				=> 'select', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> ctc_gmaps_zoom_levels(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)

				'default'			=> ctc_gmaps_zoom_level_default(), // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> true, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
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

/**********************************
 * AFTER SAVING
 **********************************/

/**
 * After Save Event
 *
 * This runs after the event post is saved, for further manipulation of meta data.
 *
 * @since 1.2
 * @param int $post_id Post ID
 * @param object $post Data for post being saved
 */
function ctc_after_save_event( $post_id, $post ) {

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
	$nonce_key = 'ctc_event_date_nonce';
	$nonce_action = 'ctc_event_date_save';
	if ( empty( $_POST[$nonce_key] ) || ! wp_verify_nonce( $_POST[$nonce_key], $nonce_action ) ) {
		return;
	}

	// Make sure user has permission to edit
	$post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return;
	}

	// Action hook
	do_action( 'ctc_after_save_event', $post_id, $post );

}

add_action( 'save_post', 'ctc_after_save_event', 11, 2 ); // after save at default 10

/**
 * End Date Sanitization
 *
 * This is to be run after event is saved (ctc_after_save_event hook).
 * In order for this to work properly, End Date must be after Start Date so that the saved/sanitized
 * Start Date value is available in database.
 *
 * @since 0.9.1
 * @param int $post_id Post ID
 * @param object $post Data for post being saved
 */
function ctc_correct_event_end_date( $post_id, $post ) {

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

add_action( 'ctc_after_save_event', 'ctc_correct_event_end_date', 10, 2 );

/**
 * End Time Sanitization
 *
 * This is to be run after event is saved (ctc_after_save_event hook).
 * In order for this to work properly, End Time must be after Start Time so that the saved/sanitized
 * Start Time value is available in database.
 *
 * @since 1.2
 * @param int $post_id Post ID
 * @param object $post Data for post being saved
 */
function ctc_correct_event_end_time( $post_id, $post ) {

	// Get start and end times already saved by CT Meta Box
	$start_time = get_post_meta( $post_id, '_ctc_event_start_time', true );
	$end_time = get_post_meta( $post_id, '_ctc_event_end_time', true );

	// If end time given but start time empty, empty end time
	if ( empty( $start_time ) && ! empty( $end_time ) ) {
		$end_time = '';
	}

	// If end time is same as or earlier than start time, empty end time
	if ( ! empty( $start_time ) && $end_time <= $start_time ) {
		$end_time = '';
	}

	// Uptime times in case changed
	update_post_meta( $post_id, '_ctc_event_start_time', $start_time );
	update_post_meta( $post_id, '_ctc_event_end_time', $end_time );

}

add_action( 'ctc_after_save_event', 'ctc_correct_event_end_time', 10, 2 );

/**
 * Update Date/Time Fields
 *
 * Date and Time fields are combined into one field for easier ordering (simpler queries)
 *
 * If no date, value will be 0000-00-00 00:00:00
 * If no time, value will be 2014-10-28 00:00:00
 *
 * @since 1.2
 * @param int $post_id Post ID
 * @param object $post Data for post being saved
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

add_action( 'ctc_after_save_event', 'ctc_update_event_date_time' );

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
			$end_date = get_post_meta( $post->ID , '_ctc_event_end_date' , true );
			$time = get_post_meta( $post->ID , '_ctc_event_time' , true );
			$start_time = get_post_meta( $post->ID , '_ctc_event_start_time' , true );
			$end_time = get_post_meta( $post->ID , '_ctc_event_end_time' , true );
			$hide_time_range = get_post_meta( $post->ID , '_ctc_event_hide_time_range' , true );
			$recurrence = get_post_meta( $post->ID , '_ctc_event_recurrence' , true );

			if ( ! empty( $start_date ) ) {
				$dates[] = date_i18n( get_option( 'date_format' ), strtotime( $start_date ) ); // translated date
			}

			if ( ! empty( $end_date ) ) {
				$dates[] = date_i18n( get_option( 'date_format' ), strtotime( $end_date ) ); // translated date
			}

			echo '<b>' . esc_html( implode( _x( ' &ndash; ', 'date range separator', 'church-theme-content' ), $dates ) ) . '</b>';

			// Show Start/End Time unless hidden
			// Otherwise show Time Description
			$time_format = 'g:i a';
			if ( $start_time && ! $hide_time_range ) {

				echo '<div class="description">';

				$start_time_formatted = date( $time_format, strtotime( $start_time ) );

				if ( ! $end_time ) { // just start time
					echo esc_html( date( $time_format, strtotime( $start_time ) ) );
				} else {

					$end_time_formatted = date( $time_format, strtotime( $end_time ) );

					echo esc_html( implode( _x( ' &ndash; ', 'time range separator', 'church-theme-content' ), array(
						$start_time_formatted,
						$end_time_formatted
					) ) );

				}

				echo '</div>';

			} elseif ( $time ) {
				echo '<div class="description">' . esc_html( $time ) . '</div>';
			}

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

						$args['meta_key'] = '_ctc_event_start_date_start_time';
						$args['meta_type'] = 'DATETIME';
						$args['orderby'] = 'meta_value';

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

				$args['meta_key'] = '_ctc_event_start_date_start_time';
				$args['meta_type'] = 'DATETIME';
				$args['orderby'] = 'meta_value';
				$args['order'] = 'DESC';

			}

		}

	}

	return $args;

}

add_filter( 'request', 'ctc_event_columns_sorting_request' ); // set how to sort columns

/**********************************
 * DATABASE UPGRADES
 **********************************/

/**
 * Update All Events' Date/Time Fields
 *
 * Date and Time fields are combined into one field for easier ordering (simpler queries)
 * This is run by the database updater (older versions did not have these hidden fields)
 * See ctc_upgrade_1_2() in includes/upgrade.php
 *
 * If no date, value will be 0000-00-00 00:00:00
 * If no time, value will be 2014-10-28 00:00:00
 *
 * @since 1.2
 */
function ctc_update_all_events_date_time() {

	// Select all events to check/update
	$posts = get_posts( array(
		'post_type'			=> 'ctc_event',
		'post_status'		=> 'publish,pending,draft,auto-draft,future,private,inherit,trash', // all to be safe
		'numberposts'		=> -1 // no limit
	) );

	// Loop each post to update fields
	foreach( $posts as $post ) {
		ctc_update_event_date_time( $post->ID );
	}

}
