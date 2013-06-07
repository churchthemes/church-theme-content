<?php
/**
 * Sermon Fields
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
 * META BOXES
 **********************************/

/**
 * Sermon details
 *
 * @since 0.9
 */
function ccm_add_meta_box_sermon_details() {

	// Configure Meta Box
	$meta_box = array(

		// Meta Box
		'id' 		=> 'ccm_sermon_options', // unique ID
		'title' 	=> _x( 'Sermon Media', 'meta box', 'church-content-manager' ),
		'post_type'	=> 'ccm_sermon',
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
		
			// Full Text					
			'_ccm_sermon_has_full_text' => array(
				'name'				=> __( 'Full Text', 'church-content-manager' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'Check this if you provide a complete transcript above.', 'church-content-manager' ),
				'type'				=> 'checkbox', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> __( 'Full sermon text provided', 'church-content-manager' ), //show text after checkbox
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
			
			// Video				
			'_ccm_sermon_video' => array( // intended for URL or embed code
				'name'				=> __( 'Video', 'church-content-manager' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> sprintf(
											__( 'Upload a file by clicking "Choose Video" or upload a video to one of the <a href="%s" target="_blank">supported sites</a> (such as YouTube) then paste its URL here, or paste an embed code from another site. <a href="%s" target="_blank">Video Help</a>', 'church-content-manager' ),
											apply_filters( 'ccm_sermon_video_sites_url', 'http://churchthemes.com/go/ccm-sermon-video-sites' ),
											apply_filters( 'ccm_sermon_video_help_url', 'http://churchthemes.com/go/ccm-sermon-video-help' )
										),
				'type'				=> 'upload_textarea', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> __( 'Choose Video', 'church-content-manager' ), // text for button that opens media frame
				'upload_title'		=> __( 'Choose an Video File', 'church-content-manager' ), // title appearing at top of media frame
				'upload_type'		=> 'video', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> true, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),
			
			// Audio
			'_ccm_sermon_audio' => array( // intended for URL or embed code
				'name'				=> __( 'Audio', 'church-content-manager' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> sprintf(
											__( 'Upload a file by clicking "Choose Audio" or upload audio to one of the <a href="%s" target="_blank">supported sites</a> (such as SoundCloud) then paste its URL here, or paste an embed code from another site. <a href="%s" target="_blank">Video Help</a>', 'church-content-manager' ),
											apply_filters( 'ccm_sermon_audio_sites_url', 'http://churchthemes.com/go/ccm-sermon-audio-sites' ),
											apply_filters( 'ccm_sermon_audio_help_url', 'http://churchthemes.com/go/ccm-sermon-audio-help' )
										),
				'type'				=> 'upload_textarea', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> __( 'Choose Audio', 'church-content-manager' ), // text for button that opens media frame
				'upload_title'		=> __( 'Choose an Audio File', 'church-content-manager' ), // title appearing at top of media frame
				'upload_type'		=> 'audio', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> true, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number type)
				'class'				=> '', // class(es) to add to input (try try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
			),
			
			// PDF URL					
			'_ccm_sermon_pdf' => array(
				'name'				=> __( 'PDF', 'church-content-manager' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'desc'				=> __( 'Upload a file by clicking "Choose PDF" or paste the URL to a PDF hosted on another site.', 'church-content-manager' ),
				'type'				=> 'upload', // text, textarea, checkbox, radio, select, number, upload, upload_textarea, url
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> __( 'Choose PDF', 'church-content-manager' ), // text for button that opens media frame
				'upload_title'		=> __( 'Choose a PDF File', 'church-content-manager' ), // title appearing at top of media frame
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
 
add_action( 'admin_init', 'ccm_add_meta_box_sermon_details' );

/**********************************
 * PODCASTING ENCLOSURE
 **********************************/

/**
 * Save enclosure for sermon podcasting
 *
 * When audio URL is provided, save its data to the 'enclosure' field.
 * WordPress automatically uses this data to make feeds useful for podcasting.
 *
 * @since 0.9
 * @param int $post_id ID of post being saved
 * @param object $post Post object being saved
 */
function ccm_sermon_save_audio_enclosure( $post_id, $post ) {

	// Stop if no post, auto-save (meta not submitted) or user lacks permission
	$post_type = get_post_type_object( $post->post_type );
	if ( empty( $_POST ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return false;
	}

	// Get audio URL
	$audio = get_post_meta( $post_id , '_ccm_sermon_audio' , true );

	// Populate enclosure field with URL, length and format, if valid URL found
	do_enclose( $audio, $post_id );

}

add_action( 'save_post', 'ccm_sermon_save_audio_enclosure', 11, 2 ); // after 'save_post' saves meta fields on 10

/**********************************
 * ADMIN COLUMNS
 **********************************/

/**
 * Add/remove sermon list columns
 *
 * Add speaker, media, categories
 *
 * @since 0.9
 * @param array $columns Columns to manipulate
 * @return array Modified columns
 */
function ccm_sermon_columns( $columns ) {

	// insert thumbnail after checkbox (before title)
	$insert_array = array();
	$insert_array['ccm_sermon_thumbnail'] = __( 'Thumbnail', 'church-content-manager' );
	$columns = ccm_array_merge_after_key( $columns, $insert_array, 'cb' );

	// insert media types, speakers, categories after title
	$insert_array = array();
	$insert_array['ccm_sermon_types'] = __( 'Media Types', 'church-content-manager' );
	if ( ccm_taxonomy_supported( 'sermons', 'ccm_sermon_speaker' ) ) $insert_array['ccm_sermon_speakers'] = _x( 'Speakers', 'people', 'church-content-manager' );
	if ( ccm_taxonomy_supported( 'sermons', 'ccm_sermon_category' ) ) $insert_array['ccm_sermon_categories'] = __( 'Categories', 'church-content-manager' );
	$columns = ccm_array_merge_after_key( $columns, $insert_array, 'title' );

	// remove author
	unset( $columns['author'] );
	
	return $columns;

}

add_filter( 'manage_ccm_sermon_posts_columns' , 'ccm_sermon_columns' ); // add columns for thumbnail, categories, etc.

/**
 * Change sermon list column content
 *
 * @since 0.9
 * @param string $column Column being worked on
 */
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
		
			if ( get_post_meta( $post->ID , '_ccm_sermon_video' , true ) ) {
				$media_types[] = _x( 'Video', 'media type', 'church-content-manager' );
			}
			
			if ( get_post_meta( $post->ID , '_ccm_sermon_audio' , true ) ) {
				$media_types[] = _x( 'Audio', 'media type', 'church-content-manager' );
			}
			
			if ( get_post_meta( $post->ID , '_ccm_sermon_pdf' , true ) ) {
				$media_types[] = _x( 'PDF', 'media type', 'church-content-manager' );
			}
			
			if ( get_post_meta( $post->ID , '_ccm_sermon_text' , true ) ) {
				$media_types[] = _x( 'Text', 'media type', 'church-content-manager' );
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

add_action( 'manage_posts_custom_column' , 'ccm_sermon_columns_content' );
