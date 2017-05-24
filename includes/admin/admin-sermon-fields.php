<?php
/**
 * Sermon Fields in Admin
 *
 * Meta boxes and admin columns.
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2013 - 2017, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
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
 * Note that title, description, etc. is escaped automatically by CT Meta Box class
 * for localization security
 *
 * @since 0.9
 */
function ctc_add_meta_box_sermon_details() {

	// Configure Meta Box
	$meta_box = array(

		// Meta Box
		'id' 		=> 'ctc_sermon_options', // unique ID
		'title' 	=> _x( 'Sermon Media', 'meta box', 'church-theme-content' ),
		'post_type'	=> 'ctc_sermon',
		'context'	=> 'normal', // where the meta box appear: normal (left above standard meta boxes), advanced (left below standard boxes), side
		'priority'	=> 'high', // high, core, default or low (see this: http://www.wproots.com/ultimate-guide-to-meta-boxes-in-wordpress/)

		// Fields
		'fields' => array(

			// Example
			/*
			'option_key' => array(
				'name'				=> __( 'Field Name', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, range, upload, url, date, time)
				'desc'				=> __( 'This is the description below the field.', 'church-theme-content' ),
				'type'				=> 'text', // text, textarea, checkbox, radio, select, number, range, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> false, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number or range type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'=> '', // function for custom display of field input
				'visibility' 		=> array( // show/hide this field based on other fields' values
					'field1'	=> 'value', // and...
					'field2'	=> array( 'value', '!=' ), // not having this value
				),
			*/

			// Full Text
			'_ctc_sermon_has_full_text' => array(
				'name'				=> __( 'Full Text', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, range, upload, url, date, time)
				'desc'				=> __( 'Check this if you provide a complete transcript above.', 'church-theme-content' ),
				'type'				=> 'checkbox', // text, textarea, checkbox, radio, select, number, range, upload, upload_textarea, url, date, time
				'checkbox_label'	=> __( 'Full sermon text provided', 'church-theme-content' ), //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> '', // text for button that opens media frame
				'upload_title'		=> '', // title appearing at top of media frame
				'upload_type'		=> '', // optional type of media to filter by (image, audio, video, application/pdf)
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

			// Video
			'_ctc_sermon_video' => array( // intended for URL or embed code
				'name'				=> __( 'Video', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, range, upload, url, date, time)
				'desc'				=> sprintf(
											__( 'Upload a file by clicking "Choose Video" or upload a video to one of the <a href="%s" target="_blank">supported sites</a> (such as YouTube) then paste its URL here, or paste an embed code from another site. <a href="%s" target="_blank">Video Help</a>', 'church-theme-content' ),
											apply_filters( 'ctc_sermon_video_sites_url', 'https://churchthemes.com/go/ctc-sermon-video-sites' ),
											apply_filters( 'ctc_sermon_video_help_url', 'https://churchthemes.com/go/ctc-sermon-video-help' )
										),
				'type'				=> 'upload_textarea', // text, textarea, checkbox, radio, select, number, range, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> __( 'Choose Video', 'church-theme-content' ), // text for button that opens media frame
				'upload_title'		=> __( 'Choose a Video File', 'church-theme-content' ), // title appearing at top of media frame
				'upload_type'		=> 'video', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> true, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number or range type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
				'visibility' 		=> array(), // show/hide based on other fields' values: array( array( 'field1' => 'value' ), array( 'field2' => array( 'value', '!=' ) )
			),

			// Audio
			'_ctc_sermon_audio' => array( // intended for URL or embed code
				'name'				=> __( 'Audio', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, range, upload, url, date, time)
				'desc'				=> sprintf(
											__( 'Upload a file by clicking "Choose Audio" or upload audio to one of the <a href="%s" target="_blank">supported sites</a> (such as SoundCloud) then paste its URL here, or paste an embed code from another site. <a href="%s" target="_blank">Audio Help</a>', 'church-theme-content' ),
											apply_filters( 'ctc_sermon_audio_sites_url', 'https://churchthemes.com/go/ctc-sermon-audio-sites' ),
											apply_filters( 'ctc_sermon_audio_help_url', 'https://churchthemes.com/go/ctc-sermon-audio-help' )
										),
				'type'				=> 'upload_textarea', // text, textarea, checkbox, radio, select, number, range, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> __( 'Choose Audio', 'church-theme-content' ), // text for button that opens media frame
				'upload_title'		=> __( 'Choose an Audio File', 'church-theme-content' ), // title appearing at top of media frame
				'upload_type'		=> 'audio', // optional type of media to filter by (image, audio, video, application/pdf)
				'default'			=> '', // value to pre-populate option with (before first save or on reset)
				'no_empty'			=> false, // if user empties value, force default to be saved instead
				'allow_html'		=> true, // allow HTML to be used in the value (text, textarea)
				'attributes'		=> array(), // attr => value array (e.g. set min/max for number or range type)
				'class'				=> '', // class(es) to add to input (try ctmb-medium, ctmb-small, ctmb-tiny)
				'field_attributes'	=> array(), // attr => value array for field container
				'field_class'		=> '', // class(es) to add to field container
				'custom_sanitize'	=> '', // function to do additional sanitization
				'custom_field'		=> '', // function for custom display of field input
				'visibility' 		=> array(), // show/hide based on other fields' values: array( array( 'field1' => 'value' ), array( 'field2' => array( 'value', '!=' ) )
			),

			// PDF URL
			'_ctc_sermon_pdf' => array(
				'name'				=> __( 'PDF', 'church-theme-content' ),
				'after_name'		=> '', // (Optional), (Required), etc.
				'after_input'		=> '', // text to show to right of input (fields: text, select, number, range, upload, url, date, time)
				'desc'				=> __( 'Upload a file by clicking "Choose PDF" or paste the URL to a PDF hosted on another site.', 'church-theme-content' ),
				'type'				=> 'upload', // text, textarea, checkbox, radio, select, number, range, upload, upload_textarea, url, date, time
				'checkbox_label'	=> '', //show text after checkbox
				'options'			=> array(), // array of keys/values for radio or select
				'upload_button'		=> __( 'Choose PDF', 'church-theme-content' ), // text for button that opens media frame
				'upload_title'		=> __( 'Choose a PDF File', 'church-theme-content' ), // title appearing at top of media frame
				'upload_type'		=> 'application/pdf', // optional type of media to filter by (image, audio, video, application/pdf)
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

add_action( 'admin_init', 'ctc_add_meta_box_sermon_details' );

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
function ctc_sermon_save_audio_enclosure( $post_id, $post ) {

	// Stop if no post, auto-save (meta not submitted) or user lacks permission
	$post_type = get_post_type_object( $post->post_type );
	if ( empty( $_POST ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return false;
	}

	// Stop if PowerPress plugin is active
	// Solves conflict regarding enclosure field: http://wordpress.org/support/topic/breaks-blubrry-powerpress-plugin?replies=6
	if ( defined( 'POWERPRESS_VERSION' ) ) {
		return false;
	}

	// Get audio URL
	$audio = get_post_meta( $post_id , '_ctc_sermon_audio' , true );

	// Populate enclosure field with URL, length and format, if valid URL found
	do_enclose( $audio, $post_id );

}

add_action( 'save_post', 'ctc_sermon_save_audio_enclosure', 11, 2 ); // after 'save_post' saves meta fields on 10

/**********************************
 * ADMIN COLUMNS
 **********************************/

/**
 * Add/remove sermon list columns
 *
 * Add speaker, media, topics, etc.
 *
 * @since 0.9
 * @param array $columns Columns to manipulate
 * @return array Modified columns
 */
function ctc_sermon_columns( $columns ) {

	// insert thumbnail after checkbox (before title)
	$insert_array = array();
	$insert_array['ctc_sermon_thumbnail'] = esc_html__( 'Thumbnail', 'church-theme-content' );
	$columns = ctc_array_merge_after_key( $columns, $insert_array, 'cb' );

	// insert media types, speakers, topics after title
	$insert_array = array();
	$insert_array['ctc_sermon_types'] = esc_html_x( 'Formats', 'sermons', 'church-theme-content' );
	if ( ctc_taxonomy_supported( 'sermons', 'ctc_sermon_topic' ) ) $insert_array['ctc_sermon_topics'] = esc_html__( 'Topics', 'church-theme-content' );
	//if ( ctc_taxonomy_supported( 'sermons', 'ctc_sermon_book' ) ) $insert_array['ctc_sermon_books'] = esc_html_x( 'Books', 'sermons', 'church-theme-content' );
	//if ( ctc_taxonomy_supported( 'sermons', 'ctc_sermon_series' ) ) $insert_array['ctc_sermon_series'] = esc_html_x( 'Series', 'sermons', 'church-theme-content' );
	// little room: if ( ctc_taxonomy_supported( 'sermons', 'ctc_sermon_speaker' ) ) $insert_array['ctc_sermon_speakers'] = esc_html_x( 'Speakers', 'sermons', 'church-theme-content' );
	$columns = ctc_array_merge_after_key( $columns, $insert_array, 'title' );

	// remove author
	unset( $columns['author'] );

	return $columns;

}

add_filter( 'manage_ctc_sermon_posts_columns' , 'ctc_sermon_columns' ); // add columns for thumbnail, topics, etc.

/**
 * Change sermon list column content
 *
 * @since 0.9
 * @param string $column Column being worked on
 */
function ctc_sermon_columns_content( $column ) {

	global $post;

	switch ( $column ) {

		// Thumbnail
		case 'ctc_sermon_thumbnail' :

			if ( has_post_thumbnail() ) {
				echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, array( 80, 80 ) ) . '</a>';
			}

			break;

		// Media Types
		case 'ctc_sermon_types' :

			$media_types = array();

			if ( get_post_meta( $post->ID , '_ctc_sermon_text' , true ) ) {
				$media_types[] = esc_html_x( 'Text', 'media type', 'church-theme-content' );
			}

			if ( get_post_meta( $post->ID , '_ctc_sermon_video' , true ) ) {
				$media_types[] = esc_html_x( 'Video', 'media type', 'church-theme-content' );
			}

			if ( get_post_meta( $post->ID , '_ctc_sermon_audio' , true ) ) {
				$media_types[] = esc_html_x( 'Audio', 'media type', 'church-theme-content' );
			}

			if ( get_post_meta( $post->ID , '_ctc_sermon_pdf' , true ) ) {
				$media_types[] = esc_html_x( 'PDF', 'media type', 'church-theme-content' );
			}

			echo implode( ', ', $media_types );

			break;

		// Topics
		case 'ctc_sermon_topics' :

			echo ctc_admin_term_list( $post->ID, 'ctc_sermon_topic' );

			break;

		// Books
		case 'ctc_sermon_books' :

			echo ctc_admin_term_list( $post->ID, 'ctc_sermon_book' );

			break;

		// Series
		case 'ctc_sermon_series' :

			echo ctc_admin_term_list( $post->ID, 'ctc_sermon_series' );

			break;

		// Speakers
		case 'ctc_sermon_speakers' :

			echo ctc_admin_term_list( $post->ID, 'ctc_sermon_speaker' );

			break;

	}

}

add_action( 'manage_posts_custom_column' , 'ctc_sermon_columns_content' );
