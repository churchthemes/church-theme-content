<?php
/**
 * Person Fields
 *
 * Meta boxes and admin columns.
 *
 * @package    Church_Content_Manager
 * @subpackage Admin
 * @copyright  Copyright (c) 2013, churchthemes.com
 * @link       https://github.com/churchthemes/church-content-manager
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**********************************
 * TITLE FIELD
 **********************************/

/**
 * Change "Enter title here"
 */
function ccm_person_title_text( $title ) {

	$screen = get_current_screen();

	if  ( 'ccm_person' == $screen->post_type ) {
		$title = __( 'Enter name here', 'church-content-manager' );
	}

	return $title;

}
 
add_filter( 'enter_title_here', 'ccm_person_title_text' );
 
/**********************************
 * META BOXES
 **********************************/

/**
 * Person Details
 */
function ccm_add_meta_box_person_details() {

	// Configure Meta Box
	$meta_box = array(
	
		// Meta Box
		'id' 		=> 'ccm_person_details', // unique ID
		'title' 	=> _x( 'Person Details', 'meta box', 'church-content-manager' ),
		'post_type'	=> 'ccm_person',
		'context'	=> 'normal', // where the meta box appear: normal (left above standard meta boxes), advanced (left below standard boxes), side
		'priority'	=> 'high', // high, core, default or low (see this: http://www.wproots.com/ultimate-guide-to-meta-boxes-in-wordpress/)
		
		// Fields
		'fields' => array(
		
			// Example
			/*
			'option_key' => array(
				'name'				=> __( 'Field Name', 'church-content-manager' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'This is the description below the field.', 'church-content-manager' ),
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

			// Position				
			'_ccm_person_position' => array(
				'name'				=> __( 'Position', 'church-content-manager' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( "Enter the person's position or title (e.g. Senior Pastor, Deacon, etc.)", 'church-content-manager' ),
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
				'custom_field'		=> '', // function for custom display of field input
			),

			// Phone				
			'_ccm_person_phone' => array(
				'name'				=> _x( 'Phone', 'location meta box', 'church-content-manager' ),
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

			// Email				
			'_ccm_person_email' => array(
				'name'				=> _x( 'Email', 'location meta box', 'church-content-manager' ),
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
				'custom_sanitize'	=> 'sanitize_email', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),

			// URLs
			'_ccm_person_urls' => array(
				'name'				=> __( 'URLs', 'church-content-manager' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> '',
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
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),
			
		),

	);
	
	// Add Meta Box
	new CT_Meta_Box( $meta_box );
	
}
 
add_action( 'admin_init', 'ccm_add_meta_box_person_details' );

/**********************************
 * ADMIN COLUMNS
 **********************************/
 
/**
 * Add/remove list columns
 */
function ccm_person_columns( $columns ) {

	// insert thumbnail after checkbox (before title)
	$insert_array = array();
	$insert_array['ccm_person_thumbnail'] = __( 'Thumbnail', 'church-content-manager' );
	$columns = ccm_array_merge_after_key( $columns, $insert_array, 'cb' );

	// insert columns after title
	$insert_array = array();
	if ( ccm_field_supported( 'people', '_ccm_person_position' ) ) $insert_array['ccm_person_position'] = __( 'Position', 'church-content-manager' );
	if ( ccm_taxonomy_supported( 'people', 'ccm_person_group' ) ) $insert_array['ccm_person_group'] = _x( 'Groups', 'people column', 'church-content-manager' );
	$insert_array['ccm_person_order'] = _x( 'Order', 'sorting', 'church-content-manager' );
	$columns = ccm_array_merge_after_key( $columns, $insert_array, 'title' );
	
	//change "title" to "name"
	$columns['title'] = _x( 'Name', 'person', 'church-content-manager' );
	
	return $columns;

}

add_filter( 'manage_ccm_person_posts_columns' , 'ccm_person_columns' ); // add columns

/**
 * Change list column content
 */
function ccm_person_columns_content( $column ) {

	global $post;
	
	switch ( $column ) {
			
		// Thumbnail
		case 'ccm_person_thumbnail' :

			if ( has_post_thumbnail() ) {
				echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, array( 80, 80 ) ) . '</a>';
			}

			break;
	
		// Position
		case 'ccm_person_position' :

			echo get_post_meta( $post->ID , '_ccm_person_position' , true );

			break;

		// Group
		case 'ccm_person_group' :

			echo ccm_admin_term_list( $post->ID, 'ccm_person_group' );

			break;

		// Order
		case 'ccm_person_order' :

			echo isset( $post->menu_order ) ? $post->menu_order : '';			

			break;

	}

}

add_action( 'manage_posts_custom_column' , 'ccm_person_columns_content' ); // add content for columns

/**
 * Enable sorting for new columns
 */
function ccm_person_columns_sorting( $columns ) {

	$columns['ccm_person_position'] = '_ccm_person_position';
	$columns['ccm_person_order'] = 'menu_order';

	return $columns;

}

add_filter( 'manage_edit-ccm_person_sortable_columns', 'ccm_person_columns_sorting' ); // make columns sortable

/**
 * Set how to sort columns (default sorting, custom fields)
 */
function ccm_person_columns_sorting_request( $args ) {

	// admin area only
	if ( is_admin() ) {
	
		$screen = get_current_screen();

		// only on this post type's list
		if ( 'ccm_person' == $screen->post_type && 'edit' == $screen->base ) {

			// orderby has been set, tell how to order
			if ( isset( $args['orderby'] ) ) {

				switch ( $args['orderby'] ) {
				
					// Under Name
					case '_ccm_person_position' :

						$args['meta_key'] = '_ccm_person_position';
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

add_filter( 'request', 'ccm_person_columns_sorting_request' ); // set how to sort columns
