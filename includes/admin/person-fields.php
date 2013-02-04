<?php
/**
 * Person Fields
 *
 * Meta boxes and admin columns.
 */

/**********************************
 * TITLE FIELD
 **********************************/

/**
 * Change "Enter title here"
 */
 
add_filter( 'enter_title_here', 'ccm_person_title_text' );

function ccm_person_title_text( $title ) {

	$screen = get_current_screen();

	if  ( 'ccm_person' == $screen->post_type ) {
		$title = __( 'Enter name here', 'ccm' );
	}

	return $title;

}
 
/**********************************
 * META BOXES
 **********************************/

/**
 * Person Details
 */
 
add_action( 'admin_init', 'ccm_add_meta_box_person_details' );

function ccm_add_meta_box_person_details() {

	// Configure Meta Box
	$meta_box = array(
	
		// Meta Box
		'id' 		=> 'ccm_person_details', // unique ID
		'title' 	=> _x( 'Person Details', 'meta box', 'ccm' ),
		'post_type'	=> 'ccm_person',
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
				'file_button'		=> '', // text for button that spawns media library (upload type only)
				'insert_button'		=> '', // text for button that inserts URL for selected media (upload type only)
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

			// Video URL					
			'_ccm_person_position' => array(
				'name'				=> __( 'Position', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( "Enter the person's position or title (e.g. Senior Pastor, Deacon, etc.)", 'ccm' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, upload, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'file_button'		=> '', // text for button that spawns media library (upload type only)
				'insert_button'		=> '', // text for button that inserts URL for selected media (upload type only)
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

/**********************************
 * ADMIN COLUMNS
 **********************************/
 
/**
 * Add/remove list columns
 */

add_filter( 'manage_ccm_person_posts_columns' , 'ccm_person_columns' ); // add columns

function ccm_person_columns( $columns ) {

	// insert thumbnail after checkbox (before title)
	$insert_array = array();
	$insert_array['ccm_person_thumbnail'] = __( 'Thumbnail', 'ccm' );
	$columns = ccm_array_merge_after_key( $columns, $insert_array, 'cb' );

	// insert columns after title
	$insert_array = array();
	if ( ccm_field_supported( 'people', '_ccm_person_position' ) ) $insert_array['ccm_person_position'] = __( 'Position', 'ccm' );
	$insert_array['ccm_person_order'] = _x( 'Order', 'sorting', 'ccm' );
	$columns = ccm_array_merge_after_key( $columns, $insert_array, 'title' );
	
	//change "title" to "name"
	$columns['title'] = _x( 'Name', 'person', 'ccm' );
	
	return $columns;

}

/**
 * Change list column content
 */

add_action( 'manage_posts_custom_column' , 'ccm_person_columns_content' ); // add content for columns
 
function ccm_person_columns_content( $column ) {

	global $post;
	
	switch ( $column ) {
			
		// Thumbnail
		case 'ccm_person_thumbnail' :

			if ( has_post_thumbnail() ) {
				echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, array( 80, 80 ) ) . '</a>';
			}

			break;
	
		// Under Name
		case 'ccm_person_position' :

			echo get_post_meta( $post->ID , '_ccm_person_position' , true );

			break;

		// Order
		case 'ccm_person_order' :

			echo isset( $post->menu_order ) ? $post->menu_order : '';			

			break;

	}

}

/**
 * Enable sorting for new columns
 */

add_filter( 'manage_edit-ccm_person_sortable_columns', 'ccm_person_columns_sorting' ); // make columns sortable

function ccm_person_columns_sorting( $columns ) {

	$columns['ccm_person_position'] = '_ccm_person_position';
	$columns['ccm_person_order'] = 'menu_order';

	return $columns;

}

/**
 * Set how to sort columns (default sorting, custom fields)
 */

add_filter( 'request', 'ccm_person_columns_sorting_request' ); // set how to sort columns
 
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