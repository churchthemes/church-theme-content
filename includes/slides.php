<?php

// REMOVE THIS IF USING WIDGET INSTEAD
// REMOVE THIS IF USING WIDGET INSTEAD
// REMOVE THIS IF USING WIDGET INSTEAD
// REMOVE THIS IF USING WIDGET INSTEAD
// REMOVE THIS IF USING WIDGET INSTEAD

// NOTE: THIS IS NOT USING THE CT_META_BOX CLASS YET
// NOTE: THIS IS NOT USING THE CT_META_BOX CLASS YET
// NOTE: THIS IS NOT USING THE CT_META_BOX CLASS YET
// NOTE: THIS IS NOT USING THE CT_META_BOX CLASS YET
// NOTE: THIS IS NOT USING THE CT_META_BOX CLASS YET

/**
 * Slider Functions
 *
 * Post type, meta boxes, admin columns, etc.
 */

/**********************************
 * POST TYPE
 **********************************/

add_action( 'init', 'ccm_slide_post_type' ); // register post type

function ccm_slide_post_type() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'Slides', 'post type general name', 'ccm' ),
			'singular_name'			=> _x( 'Slide', 'post type singular name', 'ccm' ),
			'add_new' 				=> _x( 'Add New', 'slides', 'ccm' ),
			'add_new_item' 			=> __( 'Add Slide', 'ccm' ),
			'edit_item' 			=> __( 'Edit Slide', 'ccm' ),
			'new_item' 				=> __( 'New Slide', 'ccm' ),
			'all_items' 			=> __( 'All Slides', 'ccm' ),
			'view_item' 			=> __( 'View Slide', 'ccm' ),
			'search_items' 			=> __( 'Search Slides', 'ccm' ),
			'not_found' 			=> __( 'No slides found', 'ccm' ),
			'not_found_in_trash' 	=> __( 'No slides found in Trash', 'ccm' ),
			'menu_name'				=> __( 'Slides', 'ccm' )
		),
		'public' 			=> ccm_feature_supported( 'slides' ),
		'has_archive'		=> false,
		'show_in_nav_menus' => false, // don't let use in menu
		'rewrite'			=> array(
			'slug' 				=> 'slide', // theme could redirect singular('ccm_slide') to homepage
			'with_front' 		=> false
		),
		'supports' 			=> array( 'thumbnail', 'page-attributes' ) // 'editor' required for media upload button (see Meta Boxes note below about hiding)
	);
	$args = apply_filters( 'ccm_post_type_slide_args', $args ); // allow filtering
	
	// Registration
	register_post_type(
		'ccm_slide',
		$args
	);

}

/**********************************
 * META BOXES
 **********************************/
 
/**
 * Setup Meta Boxes
 */
 
add_action( 'load-post-new.php', 'ccm_slide_meta_boxes_setup' ); // setup meta boxes on add page
add_action( 'load-post.php', 'ccm_slide_meta_boxes_setup' ); // setup meta boxes on edit page
 
function ccm_slide_meta_boxes_setup() {

	// This post type only
	$screen = get_current_screen();
	if ( 'ccm_slide' == $screen->post_type ) {

		// Add Meta Boxes
		add_action( 'add_meta_boxes', 'ccm_slide_meta_boxes_add' );

		// Save Meta Boxes
		add_action( 'save_post', 'ccm_slide_meta_boxes_save', 10, 2 );

	}
	
}

/**
 * Add Meta Boxes
 */

function ccm_slide_meta_boxes_add() {

	// Slide Options
	add_meta_box(
		'ccm_slide_options',					// Unique meta box ID
		__( 'Slide Options', 'ccm' ),			// Title of meta box
		'ccm_slide_options_meta_box_html',		// Callback function to output HTML
		'ccm_slide',							// Post Type
		'normal',								// Context - Where the meta box appear: normal (left above standard meta boxes), advanced (left below standard boxes), side
		'core'									// Priority - high, core, default or low (see this: http://www.wproots.com/ultimate-guide-to-meta-boxes-in-wordpress/)
	);
	
	// Another Here

}

/**
 * Save Meta Boxes
 */

function ccm_slide_meta_boxes_save( $post_id, $post ) {

	global $allowedtags;

	/**
	 * Validation
	 *
	 * Values will be automatically trimmed and have potentially dangerous HTML tags stripped when ctmb_meta_box_save() is run.
	 * This is custom validation for the field values.
	 */

	// Title
	$_POST['_ccm_slide_title'] = isset( $_POST['_ccm_slide_title'] ) ? stripslashes( wp_filter_kses( addslashes( $_POST['_ccm_slide_title'] ), $allowedtags ) ) : ''; // allow most basic HTML tags
	
	// Description
	$_POST['_ccm_slide_description'] = isset( $_POST['_ccm_slide_description'] ) ? stripslashes( wp_filter_kses( addslashes( $_POST['_ccm_slide_description'] ), $allowedtags ) ) : ''; // allow most basic HTML tags
	 
	// Click URL
	$_POST['_ccm_slide_click_url'] = isset( $_POST['_ccm_slide_click_url'] ) ? esc_url_raw( $_POST['_ccm_slide_click_url'] ) : '';
	
	// Video URL
	$_POST['_ccm_slide_video_url'] = isset( $_POST['_ccm_slide_video_url'] ) ? esc_url_raw( $_POST['_ccm_slide_video_url'] ) : '';
	
	/**
	 * Save Values
	 */

	// Slide Options
	$meta_box_id = 'ccm_slide_options';
	$meta_keys = array( // fields to validate and save
		'_ccm_slide_title',
		'_ccm_slide_description',
		'_ccm_slide_click_url',
		'_ccm_slide_video_url'
	);
	ctmb_meta_box_save( $meta_box_id, $meta_keys, $post_id, $post );

	// Another Here

}

/**
 * Options Meta Box HTML
 */

function ccm_slide_options_meta_box_html( $object, $box ) {

	?>

	<?php
	$nonce_params = ctmb_meta_box_nonce_params( $box['id'] );
	wp_nonce_field( $nonce_params['action'], $nonce_params['key'] );
	?>
	
	<?php $meta_key = '_ccm_slide_title'; ?>
	<div id="ctmb-field-<?php echo $meta_key; ?>" class="ctmb-field<?php if ( ! ccm_field_supported( 'slides', $meta_key ) ) : ?> ctmb-hidden<?php endif; ?>">
		<div class="ctmb-name">
			<label for="<?php echo $meta_key; ?>"><?php _e( 'Title', 'ccm' ); ?></label>
		</div>
		<div class="ctmb-value">
			<input type="text" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo esc_attr( get_post_meta( $object->ID, $meta_key, true ) ); ?>" size="30" />
		</div>
	</div>
	
	<?php $meta_key = '_ccm_slide_description'; ?>
	<div id="ctmb-field-<?php echo $meta_key; ?>" class="ctmb-field<?php if ( ! ccm_field_supported( 'slides', $meta_key ) ) : ?> ctmb-hidden<?php endif; ?>">
		<div class="ctmb-name">
			<label for="<?php echo $meta_key; ?>"><?php _e( 'Description', 'ccm' ); ?></label>
		</div>
		<div class="ctmb-value">
			<input type="text" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo esc_attr( get_post_meta( $object->ID, $meta_key, true ) ); ?>" size="30" />
		</div>
	</div>
	
	<?php $meta_key = '_ccm_slide_click_url'; ?>
	<div id="ctmb-field-<?php echo $meta_key; ?>" class="ctmb-field<?php if ( ! ccm_field_supported( 'slides', $meta_key ) ) : ?> ctmb-hidden<?php endif; ?>">
		<div class="ctmb-name">
			<label for="<?php echo $meta_key; ?>"><?php _e( 'Click URL', 'ccm' ); ?></label>
		</div>
		<div class="ctmb-value">
			<input type="text" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo esc_attr( get_post_meta( $object->ID, $meta_key, true ) ); ?>" size="30" />
			<p class="description">
				<?php _e( 'Enter a URL to go to upon clicking the slide.', 'ccm' ); ?>
			</p>
		</div>
	</div>
	
	<?php $meta_key = '_ccm_slide_video_url'; ?>
	<div id="ctmb-field-<?php echo $meta_key; ?>" class="ctmb-field<?php if ( ! ccm_field_supported( 'slides', $meta_key ) ) : ?> ctmb-hidden<?php endif; ?>">
		<div class="ctmb-name">
			<label for="<?php echo $meta_key; ?>"><?php _e( 'Video URL', 'ccm' ); ?></label>
		</div>
		<div class="ctmb-value">
			<input type="text" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo esc_attr( get_post_meta( $object->ID, $meta_key, true ) ); ?>" size="30" />
			<p class="description">
				<?php _e( 'To make this a video slide, enter a YouTube or Vimeo video page URL. Examples:', 'ccm' ); ?>
				<br />
				<br />http://www.youtube.com/watch?v=mmRPSoDrrFU
				<br />http://vimeo.com/28323716
				<br />
				<br />
				<?php _e( '<b>Note:</b> You must provide an image above to represent this video slide.', 'ccm' ); ?>
			</p>
		</div>
	</div>

	<?php

}

/**
 * Move "Featured Image" meta box below Editor
 */

add_action( 'do_meta_boxes', 'ccm_slide_image_box' ); // move Featured Image meta box beneath editor
 
function ccm_slide_image_box() {

	// remove it from side
	remove_meta_box( 'postimagediv', 'ccm_slide', 'side' );

	// move below editor with new name
	add_meta_box( 'postimagediv', __( 'Image (Required)', 'ccm' ), 'post_thumbnail_meta_box', 'ccm_slide', 'normal', 'high' );

}
 
/**********************************
 * ADMIN COLUMNS
 **********************************/

/**
 * Add/remove slide list columns
 *
 * Add thumbnail, type, order
 */

add_filter( 'manage_ccm_slide_posts_columns' , 'ccm_slide_columns' ); // add and manipulate columns
 
function ccm_slide_columns( $columns ) {

	// remove WordPress title column
	unset( $columns['title'] );

	// insert thumbnail, title, type, order after checkbox
	$insert_array = array();
	$insert_array['ccm_slide_thumbnail'] = __( 'Image', 'ccm' );
	$insert_array['ccm_slide_title'] = _x( 'Title', 'slides', 'ccm' );
	$insert_array['ccm_slide_type'] = _x( 'Type', 'slides', 'ccm' );
	$insert_array['ccm_slide_order'] = _x( 'Order', 'sorting', 'ccm' );
	$columns = ccm_array_merge_after_key( $columns, $insert_array, 'cb' );
	
	return $columns;

}

/**
 * Change slide list column content
 *
 * Add content to new columns
 */

add_action( 'manage_posts_custom_column' , 'ccm_slide_columns_content' ); // add content to the new columns
 
function ccm_slide_columns_content( $column ) {

	global $post;

	switch ( $column ) {

		// Thumbnail
		case 'ccm_slide_thumbnail' :

			if ( has_post_thumbnail() ) {
				echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, array( 240, 240 ), array( 'style' => 'width: 240px; height: auto;' ) ) . '</a>';
			}

			break;

		// Title
		case 'ccm_slide_title' :

			$edit_url = get_edit_post_link( $post->ID );
			$trash_url = get_delete_post_link( $post->ID );
		
			$title = strip_tags( get_post_meta( $post->ID , '_ccm_slide_title' , true ), '<b><strong><i><em>' );

			if ( empty( $title ) ) {
				$title = __( 'No Title', 'ccm' );
			}
			
			echo '<a class="row-title" style="font-weight:normal" href="' . $edit_url . '">' . $title . '</a>';

			echo '<div class="row-actions"><span class="edit"><a href="' . $edit_url . '">' . __( 'Edit', 'ccm' ) . '</a> | </span><span class="trash"><a class="submitdelete" href="' . $trash_url . '">Trash</a></span></div>';
			
			break;
			
		// Type
		case 'ccm_slide_type' :

			$video_page_url = get_post_meta( $post->ID , '_ccm_slide_video_url' , true );
		
			$type = ''; // if no img or video
			if ( has_post_thumbnail() ) { // image provided?
				$type = ! empty( $video_page_url ) ? 'Video' : 'Image'; // if no video URL, it's image
			}

			echo $type;

			break;
			
		// Order
		case 'ccm_slide_order' :

			echo isset( $post->menu_order ) ? $post->menu_order : '';			

			break;

	}

}

/**
 * Enable sorting for new columns
 */
 
add_filter( 'manage_edit-ccm_slide_sortable_columns', 'ccm_slide_columns_sorting' ); // make columns sortable

function ccm_slide_columns_sorting( $columns ) {

	$columns['ccm_slide_order'] = 'menu_order';
	//$columns['ccm_slide_title'] = '_ccm_slide_title';

	return $columns;

}

/**
 * Set how to sort columns (default sorting, custom fields)
 */

add_filter( 'request', 'ccm_slide_columns_sorting_request' ); // set how to sort columns (default sorting, custom fields)

function ccm_slide_columns_sorting_request( $args ) {

	// admin area only
	if ( is_admin() ) {
	
		$screen = get_current_screen();

		// only on this post type's list
		if ( 'ccm_slide' == $screen->post_type && 'edit' == $screen->base ) {

			// orderby has been set, tell how to order
			if ( isset( $args['orderby'] ) ) {

				switch ( $args['orderby'] ) {
				
					// Title
					/*
					case '_ccm_slide_title' :

						$args['meta_key'] = '_ccm_slide_title';
						$args['orderby'] = 'meta_value'; // alphabetically (meta_value_num for numeric)
						
						break;
					*/

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
