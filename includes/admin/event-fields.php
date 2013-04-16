<?php
/**
 * Event Fields
 *
 * Meta boxes and admin columns.
 */

/**********************************
 * META BOXES
 **********************************/
 
/**
 * Date & Time
 */
 
add_action( 'admin_init', 'ccm_add_meta_box_event_date' );

function ccm_add_meta_box_event_date() {

	// Configure Meta Box
	$meta_box = array(
	
		// Meta Box
		'id' 		=> 'ccm_event_date', // unique ID
		'title' 	=> _x( 'Date & Time', 'event meta box', 'ccm' ),
		'post_type'	=> 'ccm_event',
		'context'	=> 'normal', // where the meta box appear: normal (left above standard meta boxes), advanced (left below standard boxes), side
		'priority'	=> 'high', // high, core, default or low (see this: http://www.wproots.com/ultimate-guide-to-meta-boxes-in-wordpress/)
		
		// Fields
		'fields' => array(
		
			// Example
			/*
			'option_key' => array(
				'name'				=> __( 'Field Name', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'This is the description below the field.', 'ccm' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, url
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
			'_ccm_event_start_date' => array(
				'name'				=> __( 'Start Date', 'ccm' ),
				'after_name'		=> __( '(Required)', 'ccm' ), // (Optional), (Required), etc.
				'desc'				=> '',
				'type'				=> 'date', // text, textarea, checkbox, radio, select, number, upload, url
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
			// Note: ccm_sanitize_event_end_date calback corrects end and start dates (ie. end date but no start or end is sooner than start)
			'_ccm_event_end_date' => array(
				'name'				=> __( 'End Date', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> '',
				'type'				=> 'date', // text, textarea, checkbox, radio, select, number, upload, url
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
				'custom_sanitize'	=> 'ccm_sanitize_event_end_date', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),
			
			// Time				
			'_ccm_event_time' => array(
				'name'				=> __( 'Time', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'Optionally provide a time such as "8:00 am &ndash; 2:00 pm"', 'ccm' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, url
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
			
		),

	);
	
	// Add Meta Box
	new CT_Meta_Box( $meta_box );
	
}

/**
 * Location
 */

add_action( 'admin_init', 'ccm_add_meta_box_event_location' );

function ccm_add_meta_box_event_location() {

	// Configure Meta Box
	$meta_box = array(
	
		// Meta Box
		'id' 		=> 'ccm_event_location', // unique ID
		'title' 	=> _x( 'Location', 'event meta box', 'ccm' ),
		'post_type'	=> 'ccm_event',
		'context'	=> 'normal', // where the meta box appear: normal (left above standard meta boxes), advanced (left below standard boxes), side
		'priority'	=> 'high', // high, core, default or low (see this: http://www.wproots.com/ultimate-guide-to-meta-boxes-in-wordpress/)
		
		// Fields
		'fields' => array(
		
			// Example
			/*
			'option_key' => array(
				'name'				=> __( 'Field Name', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'This is the description below the field.', 'ccm' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, url
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
			'_ccm_event_venue' => array(
				'name'				=> __( 'Venue', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'You can provide a building name, room number or other location name to help people find the event.', 'ccm' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, url
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
			'_ccm_event_address' => array(
				'name'				=> _x( 'Address', 'event meta box', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'You can enter an address if it is necessary for people to find this event.', 'ccm' ),
				'type'				=> 'textarea', // text, textarea, checkbox, radio, select, number, upload, url
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
			'_ccm_event_show_directions_link' => array(
				'name'				=> '',
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> '',
				'type'				=> 'checkbox', // text, textarea, checkbox, radio, select, number, upload, url
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
			'_ccm_event_map_lat' => array(
				'name'				=> _x( 'Map Latitude', 'event meta box', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'You can <a href="http://churchthemes.com/get-latitude-longitude" target="_blank">use this</a> to convert an address into coordinates.', 'ccm' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, url
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
			'_ccm_event_map_lng' => array(
				'name'				=> _x( 'Map Longitude', 'event meta box', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> '',
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, url
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
			'_ccm_event_map_type' => array(
				'name'				=> _x( 'Map Type', 'event meta box', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> _x( 'You can show a road map, satellite imagery, a combination of both (hybrid) or terrain.', 'event meta box', 'ccm' ),
				'type'				=> 'select', // text, textarea, checkbox, radio, select, number, upload, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> ccm_gmaps_types(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)

				'default'			=> ccm_gmaps_type_default(), // value to pre-populate option with (before first save or on reset)
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
			'_ccm_event_map_zoom' => array(
				'name'				=> _x( 'Map Zoom', 'event meta box', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> _x( 'A lower number is more zoomed out while a higher number is more zoomed in.', 'event meta box', 'ccm' ),
				'type'				=> 'select', // text, textarea, checkbox, radio, select, number, upload, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> ccm_gmaps_zoom_levels(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)

				'default'			=> ccm_gmaps_zoom_level_default(), // value to pre-populate option with (before first save or on reset)
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

/**
 * End Date Sanitization
 *
 * This callback runs after CT_Meta_Box general sanitization but before saving for End Date.
 * In order for this to work properly, End Date must be after Start Date so that the saved/sanitized
 * Start Date value is available in database.
 */
 
function ccm_sanitize_event_end_date( $value ) {

	global $post_id, $post;

	// End Date already sanitized by CT_Meta_Box in general and for date type, but not yet saved
	$end_date = $value;

	// Get Start Date
	// Already saved and sanitzed by CT_Meta_Box in general and for date type
	$start_date = get_post_meta( $post_id, '_ccm_event_start_date', true );
	
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
	
	// Update Start Date in case changed
	update_post_meta( $post_id, '_ccm_event_start_date', $start_date );
	
	// Return sanitized End Date for saving
	return $end_date;

}

/**********************************
 * ADMIN COLUMNS
 **********************************/

/**
 * Add/remove event list columns
 */


add_filter( 'manage_ccm_event_posts_columns' , 'ccm_event_columns' ); // add columns for meta values

function ccm_event_columns( $columns ) {

	// insert start date, venue after title
	$insert_array = array();
	if ( ccm_field_supported( 'events', '_ccm_event_start_date' ) ) $insert_array['ccm_event_dates'] = _x( 'When', 'events admin column', 'ccm' );
	if ( ccm_field_supported( 'events', '_ccm_event_venue' ) ) $insert_array['ccm_event_venue'] = _x( 'Where', 'events admin column', 'ccm' );
	$columns = ccm_array_merge_after_key( $columns, $insert_array, 'title' );

	// remove author
	unset( $columns['author'] );
	
	return $columns;

}

/**
 * Add content to new columns
 */

add_action( 'manage_posts_custom_column' , 'ccm_event_columns_content' ); // add content to the new columns
 
function ccm_event_columns_content( $column ) {

	global $post;
	
	switch ( $column ) {

		// Dates
		case 'ccm_event_dates' :
		
			$dates = array();
		
			$start_date = trim( get_post_meta( $post->ID , '_ccm_event_start_date' , true ) );
			if ( ! empty( $start_date ) ) {
				$dates[] = date_i18n( get_option( 'date_format' ), strtotime( $start_date ) ); // translated date
			}
			
			$end_date = get_post_meta( $post->ID , '_ccm_event_end_date' , true );
			if ( ! empty( $end_date ) ) {
				$dates[] = date_i18n( get_option( 'date_format' ), strtotime( $end_date ) ); // translated date
			}
			
			echo implode( _x( ' &ndash; ', 'date range separator', 'ccm' ), $dates );
			
			$time = get_post_meta( $post->ID , '_ccm_event_time' , true );
			if ( ! empty( $time ) ) {
				echo '<div class="description"><i>' . $time . '</i></div>';
			}

			break;

		// Venue
		case 'ccm_event_venue' :
		
			echo get_post_meta( $post->ID , '_ccm_event_venue' , true );
		
			break;
			
	}

}

/**
 * Enable sorting for new columns
 */

add_filter( 'manage_edit-ccm_event_sortable_columns', 'ccm_event_columns_sorting' ); // make columns sortable
 
function ccm_event_columns_sorting( $columns ) {

	$columns['ccm_event_dates'] = '_ccm_event_start_date';
	$columns['ccm_event_venue'] = '_ccm_event_venue';

	return $columns;

}

/**
 * Set how to sort columns (default sorting, custom fields)
 */
 
add_filter( 'request', 'ccm_event_columns_sorting_request' ); // set how to sort columns
	
function ccm_event_columns_sorting_request( $args ) {

	// admin area only
	if ( is_admin() ) {
	
		$screen = get_current_screen();

		// only on this post type's list
		if ( 'ccm_event' == $screen->post_type && 'edit' == $screen->base ) {

			// orderby has been set, tell how to order
			if ( isset( $args['orderby'] ) ) {

				switch ( $args['orderby'] ) {

					// Start Date
					case '_ccm_event_start_date' :

						$args['meta_key'] = '_ccm_event_start_date';
						$args['orderby'] = 'meta_value'; // alphabetically (meta_value_num for numeric)
						
						break;

					// Venue
					case '_ccm_event_venue' :

						$args['meta_key'] = '_ccm_event_venue';
						$args['orderby'] = 'meta_value'; // alphabetically (meta_value_num for numeric)
						
						break;
						
				}
				
			}
			
			// orderby not set, tell which column to sort by default
			else {

				$args['meta_key'] = '_ccm_event_start_date';
				$args['orderby'] = 'meta_value'; // alphabetically (meta_value_num for numeric)
				$args['order'] = 'DESC';

			}
			
		}
		
	}
 
	return $args;

}
