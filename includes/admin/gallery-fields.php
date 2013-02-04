<?php
/**
 * Gallery Fields
 *
 * Meta boxes and admin columns.
 */

/**********************************
 * META BOXES
 **********************************/

/**
 * Move/Rename Featured Image
 */

add_action( 'load-post-new.php', 'ctc_gallery_image_meta_box_setup' ); // add post
add_action( 'load-post.php', 'ctc_gallery_image_meta_box_setup' ); // edit post
 
function ctc_gallery_image_meta_box_setup() {

	$screen = get_current_screen();

	if ( 'ccm_gallery_item' == $screen->post_type ) {
		add_action( 'add_meta_boxes', 'ctc_gallery_image_meta_box_change' );
	}
	
}

function ctc_gallery_image_meta_box_change() {

	remove_meta_box( 'postimagediv', 'ccm_gallery_item', 'side' ); // remove it first
	add_meta_box( 'postimagediv', _x( 'Image (Required)', 'gallery meta box', 'ccm' ), 'post_thumbnail_meta_box', 'ccm_gallery_item', 'normal', 'high' );
	
}

/**
 * Video Meta Box
*/

add_action( 'admin_init', 'ccm_add_meta_box_gallery_item_video' );

function ccm_add_meta_box_gallery_item_video() {

	// Configure Meta Box
	$meta_box = array(
	
		// Meta Box
		'id' 				=> 'ccm_gallery_item_video', // unique ID (used in filter below too)
		'title' 			=> _x( 'Video', 'meta box', 'ccm' ),
		'post_type'			=> 'ccm_gallery_item',
		'context'			=> 'normal', // where the meta box appear: normal (left above standard meta boxes), advanced (left below standard boxes), side
		'priority'			=> 'high', // high, core, default or low (see this: http://www.wproots.com/ultimate-guide-to-meta-boxes-in-wordpress/)
		'custom_sanitize'	=> 'ccm_gallery_item_set_media_type', // function to call on sanitized values array for additional manipulation before saving
		
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
			'_ccm_gallery_item_video_url' => array(
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
			
		),

	);
	
	// Add Meta Box
	new CT_Meta_Box( $meta_box );
	
}

/**
 * Manipulate sanitized Video meta box values before saving
 * Set media type before saving Video meta box values
 *
 * Saving this helps filter by meta value on image only and video only.
 */

function ccm_gallery_item_set_media_type( $sanitized_values ) {

	// Determine media type
	$type =  'image'; // image by default
	if ( ! empty( $sanitized_values['_ccm_gallery_item_video_url'] ) ) { // video URL provided
		$type =  'video';
	}
	
	// Add to sanitized values array
	$sanitized_values['_ccm_gallery_item_type'] = $type;
	
	// Return for saving
	return $sanitized_values;

}

/**********************************
 * ADMIN COLUMNS
 **********************************/

/**
 * Add/remove gallery list columns
 */

add_filter( 'manage_ccm_gallery_item_posts_columns' , 'ccm_gallery_item_columns' ); // add columns for thumbnail, media type, albums
 
function ccm_gallery_item_columns( $columns ) {

	// insert thumbnail after checkbox (before title)
	$insert_array = array();
	$insert_array['ccm_gallery_item_thumbnail'] = __( 'Thumbnail', 'ccm' );
	$columns = ccm_array_merge_after_key( $columns, $insert_array, 'cb' );
	
	// insert media type, albums after title
	$insert_array = array();
	if ( ccm_field_supported( 'gallery', '_ccm_gallery_item_video_url' ) ) $insert_array['ccm_gallery_item_type'] = __( 'Type', 'ccm' );
	if ( ccm_taxonomy_supported( 'gallery', 'ccm_gallery_album' ) ) $insert_array['ccm_gallery_item_albums'] = __( 'Albums', 'ccm' );
	$columns = ccm_array_merge_after_key( $columns, $insert_array, 'title' );
	
	// remove author
	unset( $columns['author'] );

	return $columns;

}

/**
 * Change gallery list column content
 *
 * Add content to new columns
 */

add_action( 'manage_posts_custom_column' , 'ccm_gallery_item_columns_content' ); // add content to the new columns

function ccm_gallery_item_columns_content( $column ) {

	global $post;
	
	switch ( $column ) {

		// Thumbnail
		case 'ccm_gallery_item_thumbnail' :

			if ( has_post_thumbnail() ) {
				echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, array( 80, 80 ) ) . '</a>';
			}

			break;

		// Media Type
		case 'ccm_gallery_item_type' :

			$type = get_post_meta( $post->ID , '_ccm_gallery_item_type' , true );

			echo ucfirst( $type );

			break;
			
		// Albums
		case 'ccm_gallery_item_albums' :

			// Get albums and output a list
			$albums = get_the_terms( $post->ID, 'ccm_gallery_album' );
			if ( $albums && ! is_wp_error( $albums ) ) {
			
				$albums_array = array();
				
				foreach ( $albums as $album ) {
					$albums_array[] = $album->name;
				}	
				
				echo implode( ', ', $albums_array );
				
			}

			break;

	}

}
