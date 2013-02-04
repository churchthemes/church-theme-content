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
 * Highlights Functions
 *
 * Post type, meta boxes, columns, etc.
 */
 
/**********************************
 * POST TYPE
 **********************************/
 
add_action( 'init', 'ccm_highlight_post_type' ); // register post type
 
function ccm_highlight_post_type() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'Highlights', 'post type general name', 'ccm' ),
			'singular_name'			=> _x( 'Highlight', 'post type singular name', 'ccm' ),
			'add_new' 				=> _x( 'Add New', 'highlight', 'ccm' ),
			'add_new_item' 			=> __( 'Add Highlight', 'ccm' ),
			'edit_item' 			=> __( 'Edit Highlight', 'ccm' ),
			'new_item' 				=> __( 'New Highlight', 'ccm' ),
			'all_items' 			=> __( 'All Highlights', 'ccm' ),
			'view_item' 			=> __( 'View Highlight', 'ccm' ),
			'search_items' 			=> __( 'Search Highlights', 'ccm' ),
			'not_found' 			=> __( 'No highlights found', 'ccm' ),
			'not_found_in_trash' 	=> __( 'No highlights found in Trash', 'ccm' ),
			'menu_name'				=> __( 'Highlights', 'ccm' )
		),
		'public' 			=> ccm_feature_supported( 'highlights' ),
		'has_archive'		=> false,
		'show_in_nav_menus' => false, // don't let use in menu
		'rewrite'			=> array(
			'slug' 				=> 'highlight', // theme could redirect singular('ccm_highlight') to homepage
			'with_front'		=> false
		),
		'supports' 			=> array( 'thumbnail', 'page-attributes' ) // 'editor' required for media upload button (see Meta Highlights note below about hiding)
	);
	$args = apply_filters( 'ccm_post_type_highlight_args', $args ); // allow filtering

	// Registration
	register_post_type(
		'ccm_highlight',
		$args
	);

}

/**********************************
 * META BOXES
 **********************************/

/**
 * Setup Meta Highlights
 */

add_action( 'load-post-new.php', 'ccm_highlight_meta_boxes_setup' ); // setup meta boxs on add page
add_action( 'load-post.php', 'ccm_highlight_meta_boxes_setup' ); // setup meta boxs on edit page
 
function ccm_highlight_meta_boxes_setup() {

	// This post type only
	$screen = get_current_screen();
	if ( 'ccm_highlight' == $screen->post_type ) {

		// Add Meta Highlights
		add_action( 'add_meta_boxes', 'ccm_highlight_meta_boxes_add' );

		// Save Meta Highlights
		add_action( 'save_post', 'ccm_highlight_meta_boxes_save', 10, 2 );

	}
	
}

/**
 * Add Meta Highlights
 */
 
function ccm_highlight_meta_boxes_add() {

	// Highlight Options
	add_meta_box(
		'ccm_highlight_options',					// Unique meta box ID
		__( 'Highlight Options', 'ccm' ),			// Title of meta box
		'ccm_highlight_options_meta_box_html',		// Callback function to output HTML
		'ccm_highlight',							// Post Type
		'normal',									// Context - Where the meta box appear: normal (left above standard meta boxs), advanced (left below standard highlights), side
		'core'										// Priority - high, core, default or low (see this: http://www.wproots.com/ultimate-guide-to-meta-highlights-in-wordpress/)
	);
	
	// Another Here

}

/**
 * Save Meta Highlights
 */

function ccm_highlight_meta_boxes_save( $post_id, $post ) {

	global $allowedtags;

	/**
	 * Validation
	 *
	 * Values will be automatically trimmed and have potentially dangerous HTML tags stripped when ctmb_meta_box_save() is run.
	 * This is custom validation for the field values.
	 */

	// Title
	$_POST['_ccm_highlight_title'] = isset( $_POST['_ccm_highlight_title'] ) ? stripslashes( wp_filter_kses( addslashes( $_POST['_ccm_highlight_title'] ), $allowedtags ) ) : ''; // allow most basic HTML tags
	
	// Description
	$_POST['_ccm_highlight_description'] = isset( $_POST['_ccm_highlight_description'] ) ? stripslashes( wp_filter_kses( addslashes( $_POST['_ccm_highlight_description'] ), $allowedtags ) ) : ''; // allow most basic HTML tags
	 
	// Click URL
	$_POST['_ccm_highlight_click_url'] = isset( $_POST['_ccm_highlight_click_url'] ) ? esc_url_raw( $_POST['_ccm_highlight_click_url'] ) : '';
	
	/**
	 * Save Values
	 */

	// Highlight Options
	$meta_box_id = 'ccm_highlight_options';
	$meta_keys = array( // fields to validate and save
		'_ccm_highlight_title',
		'_ccm_highlight_description',
		'_ccm_highlight_click_url'
	);
	ctmb_meta_box_save( $meta_box_id, $meta_keys, $post_id, $post );

}

/**
 * Options Meta Box HTML
 */

function ccm_highlight_options_meta_box_html( $object, $highlight ) {

	?>

	<?php
	$nonce_params = ctmb_meta_box_nonce_params( $highlight['id'] );
	wp_nonce_field( $nonce_params['action'], $nonce_params['key'] );
	?>
	
	<?php $meta_key = '_ccm_highlight_title'; ?>
	<div id="ctmb-field-<?php echo $meta_key; ?>" class="ctmb-field<?php if ( ! ccm_field_supported( 'highlights', $meta_key ) ) : ?> ctmb-hidden<?php endif; ?>">
		<div class="ctmb-name">
			<label for="<?php echo $meta_key; ?>"><?php _ex( 'Title', 'highlight', 'ccm' ); ?></label>
		</div>
		<div class="ctmb-value">
			<input type="text" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo esc_attr( get_post_meta( $object->ID, $meta_key, true ) ); ?>" size="30" />
		</div>
	</div>
	
	<?php $meta_key = '_ccm_highlight_description'; ?>
	<div id="ctmb-field-<?php echo $meta_key; ?>" class="ctmb-field<?php if ( ! ccm_field_supported( 'highlights', $meta_key ) ) : ?> ctmb-hidden<?php endif; ?>">
		<div class="ctmb-name">
			<label for="<?php echo $meta_key; ?>"><?php _ex( 'Description', 'highlight', 'ccm' ); ?></label>
		</div>
		<div class="ctmb-value">
			<input type="text" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo esc_attr( get_post_meta( $object->ID, $meta_key, true ) ); ?>" size="30" />
		</div>
	</div>
	
	<?php $meta_key = '_ccm_highlight_click_url'; ?>
	<div id="ctmb-field-<?php echo $meta_key; ?>" class="ctmb-field<?php if ( ! ccm_field_supported( 'highlights', $meta_key ) ) : ?> ctmb-hidden<?php endif; ?>">
		<div class="ctmb-name">
			<label for="<?php echo $meta_key; ?>"><?php _ex( 'Click URL', 'highlight', 'ccm' ); ?></label>
		</div>
		<div class="ctmb-value">
			<input type="text" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo esc_attr( get_post_meta( $object->ID, $meta_key, true ) ); ?>" size="30" />
			<p class="description">
				<?php _e( 'Enter a URL to go to upon clicking the highlight.', 'ccm' ); ?>
			</p>
		</div>
	</div>

	<?php

}

/**
 * Move "Featured Image" meta box below Editor
 */
 
add_action( 'do_meta_boxes', 'ccm_highlight_image_highlight' ); // move Featured Image meta box beneath editor

function ccm_highlight_image_highlight() {

	// remove it from side
	remove_meta_box( 'postimagediv', 'ccm_highlight', 'side' );

	// move below editor with new name
	add_meta_box( 'postimagediv', __( 'Image (Required)', 'ccm' ), 'post_thumbnail_meta_box', 'ccm_highlight', 'normal', 'high' );

}
 
/**********************************
 * ADMIN COLUMNS
 **********************************/

/**
 * Add/remove highlight list columns
 *
 * Add thumbnail, type, order
 */
 

add_filter( 'manage_ccm_highlight_posts_columns' , 'ccm_highlight_columns' ); // add and manipulate columns

function ccm_highlight_columns( $columns ) {

	// remove standard WP title column
	unset( $columns['title'] );
	
	// insert thumbnail, custom title field, order after checkhighlight
	$insert_array = array(
		'ccm_highlight_thumbnail' => __( 'Image', 'ccm' ),
		'ccm_highlight_title' => _x( 'Title', 'highlight', 'ccm' ),
		'ccm_highlight_order' => _x( 'Order', 'sorting', 'ccm' )
	);
	$columns = ccm_array_merge_after_key( $columns, $insert_array, 'cb' );
	
	return $columns;

}

/**
 * Change highlight list column content
 *
 * Add content to new columns
 */

add_action( 'manage_posts_custom_column' , 'ccm_highlight_columns_content' ); // add content to the new columns

function ccm_highlight_columns_content( $column ) {

	global $post;

	switch ( $column ) {

		// Thumbnail
		case 'ccm_highlight_thumbnail' :

			if ( has_post_thumbnail() ) {
				echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, array( 80, 80 ) ) . '</a>';
			}

			break;
			
		// Title
		case 'ccm_highlight_title' :

			$edit_url = get_edit_post_link( $post->ID );
			$trash_url = get_delete_post_link( $post->ID );
		
			$title = strip_tags( get_post_meta( $post->ID , '_ccm_highlight_title' , true ), '<b><strong><i><em>' );

			if ( empty( $title ) ) {
				$title = __( 'No Title', 'ccm' );
			}
			
			echo '<a class="row-title" href="' . $edit_url . '">' . strip_tags( $title ) . '</a>';

			echo '<div class="row-actions"><span class="edit"><a href="' . $edit_url . '">' . __( 'Edit', 'ccm' ) . '</a> | </span><span class="trash"><a class="submitdelete" href="' . $trash_url . '">Trash</a></span></div>';
			
			break;
			
		// Order
		case 'ccm_highlight_order' :

			echo isset( $post->menu_order ) ? $post->menu_order : '';			

			break;

	}

}

/**
 * Enable sorting for new columns
 */

add_filter( 'manage_edit-ccm_highlight_sortable_columns', 'ccm_highlight_columns_sorting' ); // make columns sortable

function ccm_highlight_columns_sorting( $columns ) {

	$columns['ccm_highlight_order'] = 'menu_order';

	return $columns;

}

/**
 * Set how to sort columns (default sorting, custom fields)
 */
 
add_filter( 'request', 'ccm_highlight_columns_sorting_request' ); // set how to sort columns (default sorting, custom fields)
 
function ccm_highlight_columns_sorting_request( $args ) {

	// admin area only
	if ( is_admin() ) {
	
		$screen = get_current_screen();

		// only on this post type's list
		if ( 'ccm_highlight' == $screen->post_type && 'edit' == $screen->base ) {

			// orderby has been set, tell how to order
			if ( isset( $args['orderby'] ) ) {

				switch ( $args['orderby'] ) {
				
					// can do sorting here

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
