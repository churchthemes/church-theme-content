<?php
/**
 * Sermon Fields
 *
 * Meta boxes and admin columns.
 */

/**********************************
 * META BOXES
 **********************************/

/**
 * Sermon Details
 */
 
add_action( 'admin_init', 'ccm_add_meta_box_sermon_details' );

function ccm_add_meta_box_sermon_details() {

	// Configure Meta Box
	$meta_box = array(
	
		// Meta Box
		'id' 		=> 'ccm_sermon_options', // unique ID
		'title' 	=> _x( 'Sermon Media', 'meta box', 'ccm' ),
		'post_type'	=> 'ccm_sermon',
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
			'_ccm_sermon_video_url' => array(
				'name'				=> __( 'Video URL', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> sprintf( __( 'Enter a YouTube or Vimeo video page URL. Examples: %s', 'ccm' ), '<br /><br />http://www.youtube.com/watch?v=mmRPSoDrrFU<br />http://vimeo.com/28323716' ),
				'type'				=> 'url', // text, textarea, checkbox, radio, select, number, upload, url
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
			
			// Audio URL					
			'_ccm_sermon_audio_url' => array(
				'name'				=> __( 'MP3 Audio File', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'Upload or provide the URL to an audio file in MP3 format. <b>File too big?</b> Refer to the documentation for help.', 'ccm' ),
				'type'				=> 'upload', // text, textarea, checkbox, radio, select, number, upload, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'file_button'		=> __( 'Upload MP3', 'ccm' ), // text for button that spawns media library (upload type only)
				'insert_button'		=> __( 'Use for MP3 File', 'ccm' ), // text for button that inserts URL for selected media (upload type only)
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
			
			// PDF URL					
			'_ccm_sermon_pdf_url' => array(
				'name'				=> __( 'PDF File', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'Upload or provide the URL to a PDF file.', 'ccm' ),
				'type'				=> 'upload', // text, textarea, checkbox, radio, select, number, upload, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'file_button'		=> __( 'Upload PDF', 'ccm' ), // text for button that spawns media library (upload type only)
				'insert_button'		=> __( 'Use for PDF File', 'ccm' ), // text for button that inserts URL for selected media (upload type only)
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
			
			// Full Text					
			'_ccm_sermon_text' => array(
				'name'				=> __( 'Full Text', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'If you provide a complete transcript in the content box above then check this box.', 'ccm' ),
				'type'				=> 'checkbox', // text, textarea, checkbox, radio, select, number, upload, url
				'checkbox_label'	=> __( 'Full sermon text provided', 'ccm' ), //show text after checkbox
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
 * Add/remove sermon list columns
 *
 * Add speaker, media, categories
 */
 

add_filter( 'manage_ccm_sermon_posts_columns' , 'ccm_sermon_columns' ); // add columns for thumbnail, categories, etc.

function ccm_sermon_columns( $columns ) {

	// insert media types, speakers, categories after title
	$insert_array = array();
	$insert_array['ccm_sermon_types'] = __( 'Media Types', 'ccm' );
	if ( ccm_taxonomy_supported( 'sermons', 'ccm_sermon_speaker' ) ) $insert_array['ccm_sermon_speakers'] = _x( 'Speakers', 'people', 'ccm' );
	if ( ccm_taxonomy_supported( 'sermons', 'ccm_sermon_category' ) ) $insert_array['ccm_sermon_categories'] = __( 'Categories', 'ccm' );
	$columns = ccm_array_merge_after_key( $columns, $insert_array, 'title' );

	// remove author
	unset( $columns['author'] );
	
	return $columns;

}

/**
 * Change sermon list column content
 *
 * Add content to new columns
 */

add_action( 'manage_posts_custom_column' , 'ccm_sermon_columns_content' ); // add content to the new columns
 
function ccm_sermon_columns_content( $column ) {

	global $post;
	
	switch ( $column ) {

		// Media Types
		case 'ccm_sermon_types' :

			$media_types = array();
		
			if ( get_post_meta( $post->ID , '_ccm_sermon_video_url' , true ) ) {
				$media_types[] = _x( 'Video', 'media type', 'ccm' );
			}
			
			if ( get_post_meta( $post->ID , '_ccm_sermon_audio_url' , true ) ) {
				$media_types[] = _x( 'Audio', 'media type', 'ccm' );
			}
			
			if ( get_post_meta( $post->ID , '_ccm_sermon_pdf_url' , true ) ) {
				$media_types[] = _x( 'PDF', 'media type', 'ccm' );
			}
			
			if ( get_post_meta( $post->ID , '_ccm_sermon_text' , true ) ) {
				$media_types[] = _x( 'Text', 'media type', 'ccm' );
			}
			
			echo implode( ', ', $media_types );

			break;
			
		// Speakers
		case 'ccm_sermon_speakers' :

			// Get speakers and output a list
			$speakers = get_the_terms( $post->ID, 'ccm_sermon_speaker' );
			if ( $speakers && ! is_wp_error( $speakers ) ) {
			
				$speakers_array = array();
				
				foreach ( $speakers as $speaker ) {
					$speakers_array[] = $speaker->name;
				}	
				
				echo implode( ', ', $speakers_array );
				
			}

			break;
			
		// Categories
		case 'ccm_sermon_categories' :

			// Get categories and output a list
			$categories = get_the_terms( $post->ID, 'ccm_sermon_category' );
			if ( $categories && ! is_wp_error( $categories ) ) {
			
				$categories_array = array();
				
				foreach ( $categories as $category ) {
					$categories_array[] = $category->name;
				}	
				
				echo implode( ', ', $categories_array );
				
			}

			break;

	}

}
