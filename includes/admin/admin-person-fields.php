<?php
/**
 * Person Fields in Admin
 *
 * Meta boxes and admin columns.
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2013 - 2020, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      0.9
 */

// No direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**********************************
 * META BOXES
 **********************************/

/**
 * Person details
 *
 * Note that title, description, etc. is escaped automatically by CT Meta Box class
 * for localization security
 *
 * @since 0.9
 */
function ctc_add_meta_box_person_details() {

	// Configure Meta Box
	$meta_box = array(

		// Meta Box
		'id' 		=> 'ctc_person_details', // unique ID
		'title' 	=> _x( 'Person Details', 'meta box', 'church-theme-content' ),
		'post_type'	=> 'ctc_person',
		'context'	=> 'normal', // where the meta box appear: normal (left above standard meta boxes), advanced (left below standard boxes), side
		'priority'	=> 'high', // high, core, default or low (see this: http://www.wproots.com/ultimate-guide-to-meta-boxes-in-wordpress/)
		'callback_args' => array(
			'__block_editor_compatible_meta_box' => true, // meta box works in Gutenberg editor.
		),

		// Fields
		'fields' => array(

			// Example
			/*
			'option_key' => array(
				'name'				=> __( 'Field Name', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, range, upload, url, date, time)
				'desc'				=> __( 'This is the description below the field.', 'church-theme-content' ),
				'type'				=> 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, range, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'date_multiple'		=> false, // whether or not to allow date field type to select multiple dates, to be saved as comma-separated list.
				'date_button'       => '', // text for button user clicks to open datepicker calendar.
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number or range type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
				'visibility' 		=> array( // show/hide this field based on other fields' values
					'field1'	=> 'value', // and...
					'field2'	=> array( 'value', '!=' ), // not having this value
				),
			*/

			// Position
			'_ctc_person_position' => array(
				'name'				=> _x( 'Position', 'person meta box', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, range, upload, url, date, time)
				'desc'				=> __( "Enter the person's position or title (e.g. Senior Pastor, Deacon, etc.)", 'church-theme-content' ),
				'type'				=> 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, range, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'date_multiple'		=> false, // whether or not to allow date field type to select multiple dates, to be saved as comma-separated list.
				'date_button'       => '', // text for button user clicks to open datepicker calendar.
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number or range type)
				'class'				=> 'ctmb-medium', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
				'visibility' 		=> array(), // show/hide based on other fields' values: array( array( 'field1' => 'value' ), array( 'field2' => array( 'value', '!=' ) )
			),

			// Phone
			'_ctc_person_phone' => array(
				'name'				=> __( 'Phone', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, range, upload, url, date, time)
				'desc'				=> '',
				'type'				=> 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, range, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'date_multiple'		=> false, // whether or not to allow date field type to select multiple dates, to be saved as comma-separated list.
				'date_button'       => '', // text for button user clicks to open datepicker calendar.
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number or range type)
				'class'				=> 'ctmb-medium', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
				'visibility' 		=> array(), // show/hide based on other fields' values: array( array( 'field1' => 'value' ), array( 'field2' => array( 'value', '!=' ) )
			),

			// Email
			'_ctc_person_email' => array(
				'name'				=> __( 'Email', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, range, upload, url, date, time)
				'desc'				=> '',
				'type'				=> 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, range, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'date_multiple'		=> false, // whether or not to allow date field type to select multiple dates, to be saved as comma-separated list.
				'date_button'       => '', // text for button user clicks to open datepicker calendar.
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number or range type)
				'class'				=> 'ctmb-medium', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> 'sanitize_email', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
				'visibility' 		=> array(), // show/hide based on other fields' values: array( array( 'field1' => 'value' ), array( 'field2' => array( 'value', '!=' ) )
			),

			// URLs
			'_ctc_person_urls' => array(
				'name'				=> __( 'URLs', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, range, upload, url, date, time)
				'desc'				=> '',
				'type'				=> 'textarea', // text, textarea, checkbox, checkbox_multiple, radio, select, number, range, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'date_multiple'		=> false, // whether or not to allow date field type to select multiple dates, to be saved as comma-separated list.
				'date_button'       => '', // text for button user clicks to open datepicker calendar.
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number or range type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
				'visibility' 		=> array(), // show/hide based on other fields' values: array( array( 'field1' => 'value' ), array( 'field2' => array( 'value', '!=' ) )
			),

		),

	);

	// Add Meta Box
	new CT_Meta_Box( $meta_box );

}

add_action( 'admin_init', 'ctc_add_meta_box_person_details' );

/**********************************
 * ADMIN COLUMNS
 **********************************/

/**
 * Add/remove list columns
 *
 * @since 0.9
 * @param array $columns Columns to manipulate
 * @return array Modified columns
 */
function ctc_person_columns( $columns ) {

	// insert thumbnail after checkbox (before title)
	$insert_array = array();
	$insert_array['ctc_person_thumbnail'] = esc_html__( 'Thumbnail', 'church-theme-content' );
	$columns = ctc_array_merge_after_key( $columns, $insert_array, 'cb' );

	// insert columns after title
	$insert_array = array();
	if ( ctc_field_supported( 'people', '_ctc_person_position' ) ) $insert_array['ctc_person_position'] = esc_html__( 'Position', 'church-theme-content' );
	if ( ctc_taxonomy_supported( 'people', 'ctc_person_group' ) ) $insert_array['ctc_person_group'] = esc_html_x( 'Groups', 'people column', 'church-theme-content' );
	$insert_array['ctc_person_order'] = esc_html_x( 'Order', 'sorting', 'church-theme-content' );
	$columns = ctc_array_merge_after_key( $columns, $insert_array, 'title' );

	//change "title" to "name"
	$columns['title'] = esc_html_x( 'Name', 'person', 'church-theme-content' );

	return $columns;

}

add_filter( 'manage_ctc_person_posts_columns' , 'ctc_person_columns' ); // add columns

/**
 * Change person list column content
 *
 * @since 0.9
 * @param string $column Column being worked on
 */
function ctc_person_columns_content( $column ) {

	global $post;

	switch ( $column ) {

		// Thumbnail
		case 'ctc_person_thumbnail' :

			if ( has_post_thumbnail() ) {
				echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, array( 60, 60 ) ) . '</a>';
			}

			break;

		// Position
		case 'ctc_person_position' :

			echo strip_tags( get_post_meta( $post->ID , '_ctc_person_position' , true ) );

			break;

		// Group
		case 'ctc_person_group' :

			echo ctc_admin_term_list( $post->ID, 'ctc_person_group' );

			break;

		// Order
		case 'ctc_person_order' :

			echo isset( $post->menu_order ) ? $post->menu_order : '';

			break;

	}

}

add_action( 'manage_posts_custom_column' , 'ctc_person_columns_content' ); // add content for columns

/**
 * Enable sorting for new columns
 *
 * @since 0.9
 * @param array $columns Columns being worked on
 * @return array Modified columns
 */
function ctc_person_columns_sorting( $columns ) {

	$columns['ctc_person_position'] = '_ctc_person_position';
	$columns['ctc_person_order'] = 'menu_order';

	return $columns;

}

add_filter( 'manage_edit-ctc_person_sortable_columns', 'ctc_person_columns_sorting' ); // make columns sortable

/**
 * Set how to sort columns (default sorting, custom fields)
 *
 * @since 0.9
 * @param array $args Sorting arguments
 * @return array Modified arguments
 */
function ctc_person_columns_sorting_request( $args ) {

	// admin area only
	if ( is_admin() ) {

		// Don't run if something causing filter to run when would not normally.
		if ( ! function_exists( 'get_current_screen' ) ) {
			return;
		}

		$screen = get_current_screen();

		// only on this post type's list
		if ( 'ctc_person' == $screen->post_type && 'edit' == $screen->base ) {

			// orderby has been set, tell how to order
			if ( isset( $args['orderby'] ) ) {

				switch ( $args['orderby'] ) {

					// Under Name
					case '_ctc_person_position' :

						$args['meta_key'] = '_ctc_person_position';
						$args['orderby'] = 'meta_value'; // alphabetically (meta_value_num for numeric)

						break;

				}

			}

			// orderby not set, tell which column to sort by default
			else {
				$args['orderby'] = 'menu_order'; // sort by Order column by default
				$args['order'] = 'ASC';
			}

		}

	}

	return $args;

}

add_filter( 'request', 'ctc_person_columns_sorting_request' ); // set how to sort columns
