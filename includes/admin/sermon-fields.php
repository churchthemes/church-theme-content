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
		
			// Full Text					
			'_ccm_sermon_has_full_text' => array(
				'name'				=> __( 'Full Text', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'Check this if you provide a complete transcript above.', 'ccm' ),
				'type'				=> 'checkbox', // text, textarea, checkbox, radio, select, number, upload, url
				'checkbox_label'	=> __( 'Full sermon text provided', 'ccm' ), //show text after checkbox
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
			
			// Video URL					
			'_ccm_sermon_video_url' => array(
				'name'				=> __( 'Video URL', 'ccm' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> '',
				'type'				=> 'url', // text, textarea, checkbox, radio, select, number, upload, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_type'		=> '', // type of media (image, audio)
				'upload_select'		=> '', // text for button in media frame that inserts URL
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
				'desc'				=> __( 'Upload or provide the URL to an audio file in MP3 format. <b>File too big?</b> See documentation for help.', 'ccm' ),
				'type'				=> 'upload', // text, textarea, checkbox, radio, select, number, upload, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> __( 'Choose MP3', 'ccm' ), // text for button that opens media frame
				'upload_title'		=> __( 'Choose an MP3 File', 'ccm' ), // title appearing at top of media frame
				'upload_type'		=> 'audio', // optional type of media to filter by (image, audio, video, application/pdf)
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
				'upload_button'		=> __( 'Choose PDF', 'ccm' ), // text for button that opens media frame
				'upload_title'		=> __( 'Choose a PDF File', 'ccm' ), // title appearing at top of media frame
				'upload_type'		=> 'application/pdf', // optional type of media to filter by (image, audio, video, application/pdf)
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
 * PODCASTING ENCLOSURE
 **********************************/

/**
 * Save enclosure for sermon podcasting
 *
 * When audio URL is provided, save its data to the 'enclosure' field.
 * WordPress automatically uses this data to make feeds useful for podcasting.
 */

add_action( 'save_post', 'ccm_sermon_save_audio_enclosure', 11, 2 ); // after 'save_post' saves meta fields on 10

function ccm_sermon_save_audio_enclosure( $post_id, $post ) {

	// Stop if no post, auto-save (meta not submitted) or user lacks permission
	$post_type = get_post_type_object( $post->post_type );
	if ( empty( $_POST ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return false;
	}

	// Get audio URL
	$audio_url = get_post_meta( $post_id , '_ccm_sermon_audio_url' , true );

	// Populate enclosure field with URL, length and format, if valid URL found
	do_enclose( $audio_url, $post_id );

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

	// insert thumbnail after checkbox (before title)
	$insert_array = array();
	$insert_array['ccm_sermon_thumbnail'] = __( 'Thumbnail', 'ccm' );
	$columns = ccm_array_merge_after_key( $columns, $insert_array, 'cb' );

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

		// Thumbnail
		case 'ccm_sermon_thumbnail' :

			if ( has_post_thumbnail() ) {
				echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, array( 80, 80 ) ) . '</a>';
			}

			break;

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

			echo ccm_admin_term_list( $post->ID, 'ccm_sermon_speaker' );

			break;
			
		// Categories
		case 'ccm_sermon_categories' :

			echo ccm_admin_term_list( $post->ID, 'ccm_sermon_category' );

			break;

	}

}
