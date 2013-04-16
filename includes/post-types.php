<?php
/**
 * Register Post Types
 */

/**********************************
 * SERMON
 **********************************/

add_action( 'init', 'ccm_register_post_type_sermon' ); // register post type
 
function ccm_register_post_type_sermon() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'Sermons', 'post type general name', 'ccm' ),
			'singular_name'			=> _x( 'Sermon', 'post type singular name', 'ccm' ),
			'add_new' 				=> _x( 'Add New', 'sermon', 'ccm' ),
			'add_new_item' 			=> __( 'Add Sermon', 'ccm' ),
			'edit_item' 			=> __( 'Edit Sermon', 'ccm' ),
			'new_item' 				=> __( 'New Sermon', 'ccm' ),
			'all_items' 			=> __( 'All Sermons', 'ccm' ),
			'view_item' 			=> __( 'View Sermon', 'ccm' ),
			'search_items' 			=> __( 'Search Sermons', 'ccm' ),
			'not_found' 			=> __( 'No sermons found', 'ccm' ),
			'not_found_in_trash' 	=> __( 'No sermons found in Trash', 'ccm' )
		),
		'public' 		=> ccm_feature_supported( 'sermons' ),
		'has_archive' 	=> ccm_feature_supported( 'sermons' ),
		'rewrite'		=> array(
			'slug' 			=> 'sermons', // has archive, so using plural so it makes sense on single post and archives and so that slug is not likely to match page slug (that causes issues)
			'with_front' 	=> false,
			'feeds'			=> ccm_feature_supported( 'sermons' ),
		),
		'supports' 		=> array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'author', 'revisions' ), // 'editor' required for media upload button (see Meta Boxes note below about hiding)
		'taxonomies' 	=> array( 'ccm_sermon_category', 'ccm_sermon_tag', 'ccm_sermon_speaker' )
	);
	$args = apply_filters( 'ccm_post_type_sermon_args', $args ); // allow filtering
		
	// Registration
	register_post_type(
		'ccm_sermon',
		$args
	);

}
 
/**********************************
 * EVENT
 **********************************/

add_action( 'init', 'ccm_register_post_type_event' ); // register post type
	
function ccm_register_post_type_event() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'Events', 'post type general name', 'ccm' ),
			'singular_name'			=> _x( 'Event', 'post type singular name', 'ccm' ),
			'add_new' 				=> _x( 'Add New', 'event', 'ccm' ),
			'add_new_item' 			=> __( 'Add Event', 'ccm' ),
			'edit_item' 			=> __( 'Edit Event', 'ccm' ),
			'new_item' 				=> __( 'New Event', 'ccm' ),
			'all_items' 			=> __( 'All Events', 'ccm' ),
			'view_item' 			=> __( 'View Event', 'ccm' ),
			'search_items' 			=> __( 'Search Events', 'ccm' ),
			'not_found' 			=> __( 'No events found', 'ccm' ),
			'not_found_in_trash' 	=> __( 'No events found in Trash', 'ccm' )
		),
		'public' 		=> ccm_feature_supported( 'events' ),
		'has_archive' 	=> ccm_feature_supported( 'events' ),
		'rewrite'		=> array(
			'slug' 			=> 'events', 	// has archive, so using plural so it makes sense on single post and archives and so that slug is not likely to match page slug (that causes issues)
												// using "items" instead of "archive" since that indicates past which is not always the case
			'with_front'	=> false,
			'feeds'			=> ccm_feature_supported( 'events' ),
		),
		'supports' 		=> array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'author', 'revisions' )
	);
	$args = apply_filters( 'ccm_post_type_event_args', $args ); // allow filtering
	
	// Registration
	register_post_type(
		'ccm_event',
		$args
	);
	
}

/**********************************
 * GALLERY ITEM
 **********************************/
 
add_action( 'init', 'ccm_register_post_type_gallery_item' ); // register post type
 
function ccm_register_post_type_gallery_item() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'Gallery', 'post type general name', 'ccm' ),
			'singular_name'			=> _x( 'Gallery Item', 'post type singular name', 'ccm' ),
			'add_new' 				=> _x( 'Add New', 'gallery', 'ccm' ),
			'add_new_item' 			=> __( 'Add Gallery Item', 'ccm' ),
			'edit_item' 			=> __( 'Edit Gallery Item', 'ccm' ),
			'new_item' 				=> __( 'New Gallery Item', 'ccm' ),
			'all_items' 			=> _x( 'All Items', 'gallery', 'ccm' ),
			'view_item' 			=> __( 'View Gallery Item', 'ccm' ),
			'search_items' 			=> __( 'Search Gallery Items', 'ccm' ),
			'not_found' 			=> __( 'No gallery items found', 'ccm' ),
			'not_found_in_trash' 	=> __( 'No gallery items found in Trash', 'ccm' )
		),
		'public' 		=> ccm_feature_supported( 'gallery' ),
		'has_archive' 	=> ccm_feature_supported( 'gallery' ),
		'rewrite'		=> array(
			'slug' 			=> 'gallery', // has archive, so using plural so it makes sense on single post and archives and so that slug is not likely to match page slug (that causes issues)
			'with_front' 	=> false,
			'feeds'			=> ccm_feature_supported( 'gallery' ),
		),
		'supports' 		=> array( 'title', 'editor', 'thumbnail', 'comments', 'author', 'revisions' ),
		'taxonomies' 	=> array( 'ccm_gallery_album' )
	);
	$args = apply_filters( 'ccm_post_type_gallery_item_args', $args ); // allow filtering
		
	// Registration
	register_post_type(
		'ccm_gallery_item',
		$args
	);

}

/**********************************
 * LOCATION
 **********************************/

add_action( 'init', 'ccm_location_post_type' ); // register post type

function ccm_location_post_type() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'Locations', 'post type general name', 'ccm' ),
			'singular_name'			=> _x( 'Location', 'post type singular name', 'ccm' ),
			'add_new' 				=> _x( 'Add New', 'location', 'ccm' ),
			'add_new_item' 			=> __( 'Add Location', 'ccm' ),
			'edit_item' 			=> __( 'Edit Location', 'ccm' ),
			'new_item' 				=> __( 'New Location', 'ccm' ),
			'all_items' 			=> __( 'All Locations', 'ccm' ),
			'view_item' 			=> __( 'View Location', 'ccm' ),
			'search_items' 			=> __( 'Search Locations', 'ccm' ),
			'not_found' 			=> __( 'No location found', 'ccm' ),
			'not_found_in_trash' 	=> __( 'No location found in Trash', 'ccm' )
		),
		'public' 		=> ccm_feature_supported( 'locations' ),
		'has_archive' 	=> ccm_feature_supported( 'locations' ),
		'rewrite'		=> array(
			'slug' 			=> 'locations', // has archive, so using plural so it makes sense on single post and archives and so that slug is not likely to match page slug (that causes issues)
			'with_front' 	=> false,
			'feeds'			=> ccm_feature_supported( 'locations' ),
		),
		'supports' 		=> array( 'title', 'editor', 'page-attributes' )
	);
	$args = apply_filters( 'ccm_post_type_location_args', $args ); // allow filtering
		
	// Registration
	register_post_type(
		'ccm_location',
		$args
	);
	
}

/**********************************
 * PERSON
 **********************************/ 
 
add_action( 'init', 'ccm_register_post_type_person' ); // register post type
	
function ccm_register_post_type_person() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'People', 'post type general name', 'ccm' ),
			'singular_name'			=> _x( 'Person', 'post type singular name', 'ccm' ),
			'add_new' 				=> _x( 'Add New', 'person', 'ccm' ),
			'add_new_item' 			=> __( 'Add Person', 'ccm' ),
			'edit_item' 			=> __( 'Edit Person', 'ccm' ),
			'new_item' 				=> __( 'New Person', 'ccm' ),
			'all_items' 			=> __( 'All People', 'ccm' ),
			'view_item' 			=> __( 'View Person', 'ccm' ),
			'search_items' 			=> __( 'Search People', 'ccm' ),
			'not_found' 			=> __( 'No people found', 'ccm' ),
			'not_found_in_trash' 	=> __( 'No people found in Trash', 'ccm' )
		),
		'public' 		=> ccm_feature_supported( 'people' ),
		'has_archive' 	=> ccm_feature_supported( 'people' ),
		'rewrite'		=> array(
			'slug' 			=> 'people', // has archive, so using plural so it makes sense on single post and archives and so that slug is not likely to match page slug (that causes issues)
			'with_front' 	=> false,
			'feeds'			=> ccm_feature_supported( 'people' ),
		),
		'supports' 		=> array( 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ),
		'taxonomies' 	=> array( 'ccm_person_group' )
	);
	$args = apply_filters( 'ccm_post_type_person_args', $args ); // allow filtering
	
	// Registration
	register_post_type(
		'ccm_person',
		$args
	);
	
}

/**********************************
 * RESERVED SLUGS
 **********************************/ 

/**
 * Prevent post from using slug reserved for a post type archive
 *
 * If an identical slug is entered, it will be appended by a number.
 * For example, a 'sermons' page slug will become 'sermons-2'.
 *
 * This is broad but mainly intended for top-level pages.
 */

add_filter( 'wp_unique_post_slug_is_bad_flat_slug', 'ccm_is_bad_post_slug', 10, 2 );
add_filter( 'wp_unique_post_slug_is_bad_hierarchical_slug', 'ccm_is_bad_post_slug', 10, 2 );

function ccm_is_bad_post_slug( $current_value, $slug ) {

	// Get post types with archives
	$post_types = get_post_types( array(
		'has_archive' => true
	), 'objects' );

	// Check if post slug matches a post type rewrite slug
	foreach( $post_types as $post_type ) {
		if ( ! empty( $post_type->rewrite['slug'] ) && $post_type->rewrite['slug'] == $slug ) {
			return true;
		}
	}

	return $current_value;

}
