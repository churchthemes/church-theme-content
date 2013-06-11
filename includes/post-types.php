<?php
/**
 * Register Post Types
 *
 * @package    Church_Content_Manager
 * @subpackage Functions
 * @copyright  Copyright (c) 2013, churchthemes.com
 * @link       https://github.com/churchthemes/church-content-manager
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**********************************
 * SERMON
 **********************************/

/**
 * Register sermon post type
 *
 * @since 0.9
 */
function ccm_register_post_type_sermon() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'Sermons', 'post type general name', 'church-content-manager' ),
			'singular_name'			=> _x( 'Sermon', 'post type singular name', 'church-content-manager' ),
			'add_new' 				=> _x( 'Add New', 'sermon', 'church-content-manager' ),
			'add_new_item' 			=> __( 'Add Sermon', 'church-content-manager' ),
			'edit_item' 			=> __( 'Edit Sermon', 'church-content-manager' ),
			'new_item' 				=> __( 'New Sermon', 'church-content-manager' ),
			'all_items' 			=> __( 'All Sermons', 'church-content-manager' ),
			'view_item' 			=> __( 'View Sermon', 'church-content-manager' ),
			'search_items' 			=> __( 'Search Sermons', 'church-content-manager' ),
			'not_found' 			=> __( 'No sermons found', 'church-content-manager' ),
			'not_found_in_trash' 	=> __( 'No sermons found in Trash', 'church-content-manager' )
		),
		'public' 		=> ccm_feature_supported( 'sermons' ),
		'has_archive' 	=> ccm_feature_supported( 'sermons' ),
		'rewrite'		=> array(
			'slug' 			=> 'sermons',
			'with_front' 	=> false,
			'feeds'			=> ccm_feature_supported( 'sermons' )
		),
		'supports' 		=> array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'author', 'revisions' ), // 'editor' required for media upload button (see Meta Boxes note below about hiding)
		'taxonomies' 	=> array( 'ccm_sermon_topic', 'ccm_sermon_book', 'ccm_sermon_series', 'ccm_sermon_speaker', 'ccm_sermon_tag' )
	);
	$args = apply_filters( 'ccm_post_type_sermon_args', $args ); // allow filtering
		
	// Registration
	register_post_type(
		'ccm_sermon',
		$args
	);

}

add_action( 'init', 'ccm_register_post_type_sermon' ); // register post type
 
/**********************************
 * EVENT
 **********************************/

/**
 * Register event post type
 *
 * @since 0.9
 */
function ccm_register_post_type_event() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'Events', 'post type general name', 'church-content-manager' ),
			'singular_name'			=> _x( 'Event', 'post type singular name', 'church-content-manager' ),
			'add_new' 				=> _x( 'Add New', 'event', 'church-content-manager' ),
			'add_new_item' 			=> __( 'Add Event', 'church-content-manager' ),
			'edit_item' 			=> __( 'Edit Event', 'church-content-manager' ),
			'new_item' 				=> __( 'New Event', 'church-content-manager' ),
			'all_items' 			=> __( 'All Events', 'church-content-manager' ),
			'view_item' 			=> __( 'View Event', 'church-content-manager' ),
			'search_items' 			=> __( 'Search Events', 'church-content-manager' ),
			'not_found' 			=> __( 'No events found', 'church-content-manager' ),
			'not_found_in_trash' 	=> __( 'No events found in Trash', 'church-content-manager' )
		),
		'public' 		=> ccm_feature_supported( 'events' ),
		'has_archive' 	=> ccm_feature_supported( 'events' ),
		'rewrite'		=> array(
			'slug' 			=> 'events',
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

add_action( 'init', 'ccm_register_post_type_event' ); // register post type

/**********************************
 * LOCATION
 **********************************/

/**
 * Register location post type
 *
 * @since 0.9
 */
function ccm_location_post_type() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'Locations', 'post type general name', 'church-content-manager' ),
			'singular_name'			=> _x( 'Location', 'post type singular name', 'church-content-manager' ),
			'add_new' 				=> _x( 'Add New', 'location', 'church-content-manager' ),
			'add_new_item' 			=> __( 'Add Location', 'church-content-manager' ),
			'edit_item' 			=> __( 'Edit Location', 'church-content-manager' ),
			'new_item' 				=> __( 'New Location', 'church-content-manager' ),
			'all_items' 			=> __( 'All Locations', 'church-content-manager' ),
			'view_item' 			=> __( 'View Location', 'church-content-manager' ),
			'search_items' 			=> __( 'Search Locations', 'church-content-manager' ),
			'not_found' 			=> __( 'No location found', 'church-content-manager' ),
			'not_found_in_trash' 	=> __( 'No location found in Trash', 'church-content-manager' )
		),
		'public' 		=> ccm_feature_supported( 'locations' ),
		'has_archive' 	=> ccm_feature_supported( 'locations' ),
		'rewrite'		=> array(
			'slug' 			=> 'locations',
			'with_front' 	=> false,
			'feeds'			=> ccm_feature_supported( 'locations' ),
		),
		'supports' 		=> array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' )
	);
	$args = apply_filters( 'ccm_post_type_location_args', $args ); // allow filtering
		
	// Registration
	register_post_type(
		'ccm_location',
		$args
	);
	
}

add_action( 'init', 'ccm_location_post_type' ); // register post type

/**********************************
 * PERSON
 **********************************/ 

/**
 * Register person post type
 *
 * @since 0.9
 */	
function ccm_register_post_type_person() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'People', 'post type general name', 'church-content-manager' ),
			'singular_name'			=> _x( 'Person', 'post type singular name', 'church-content-manager' ),
			'add_new' 				=> _x( 'Add New', 'person', 'church-content-manager' ),
			'add_new_item' 			=> __( 'Add Person', 'church-content-manager' ),
			'edit_item' 			=> __( 'Edit Person', 'church-content-manager' ),
			'new_item' 				=> __( 'New Person', 'church-content-manager' ),
			'all_items' 			=> __( 'All People', 'church-content-manager' ),
			'view_item' 			=> __( 'View Person', 'church-content-manager' ),
			'search_items' 			=> __( 'Search People', 'church-content-manager' ),
			'not_found' 			=> __( 'No people found', 'church-content-manager' ),
			'not_found_in_trash' 	=> __( 'No people found in Trash', 'church-content-manager' )
		),
		'public' 		=> ccm_feature_supported( 'people' ),
		'has_archive' 	=> ccm_feature_supported( 'people' ),
		'rewrite'		=> array(
			'slug' 			=> 'people',
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

add_action( 'init', 'ccm_register_post_type_person' ); // register post type
