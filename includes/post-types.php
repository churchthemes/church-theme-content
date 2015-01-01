<?php
/**
 * Register Post Types
 *
 * @package    Church_Theme_Content
 * @subpackage Functions
 * @copyright  Copyright (c) 2013 - 2015, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
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
function ctc_register_post_type_sermon() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'Sermons', 'post type general name', 'church-theme-content' ),
			'singular_name'			=> _x( 'Sermon', 'post type singular name', 'church-theme-content' ),
			'add_new' 				=> _x( 'Add New', 'sermon', 'church-theme-content' ),
			'add_new_item' 			=> __( 'Add Sermon', 'church-theme-content' ),
			'edit_item' 			=> __( 'Edit Sermon', 'church-theme-content' ),
			'new_item' 				=> __( 'New Sermon', 'church-theme-content' ),
			'all_items' 			=> __( 'All Sermons', 'church-theme-content' ),
			'view_item' 			=> __( 'View Sermon', 'church-theme-content' ),
			'search_items' 			=> __( 'Search Sermons', 'church-theme-content' ),
			'not_found' 			=> __( 'No sermons found', 'church-theme-content' ),
			'not_found_in_trash' 	=> __( 'No sermons found in Trash', 'church-theme-content' )
		),
		'public' 		=> ctc_feature_supported( 'sermons' ),
		'has_archive' 	=> ctc_feature_supported( 'sermons' ),
		'rewrite'		=> array(
			'slug' 			=> 'sermons',
			'with_front' 	=> false,
			'feeds'			=> ctc_feature_supported( 'sermons' )
		),
		'supports' 		=> array( 'title', 'editor', 'excerpt', 'publicize', 'thumbnail', 'comments', 'author', 'revisions' ), // 'editor' required for media upload button (see Meta Boxes note below about hiding)
		'taxonomies' 	=> array( 'ctc_sermon_topic', 'ctc_sermon_book', 'ctc_sermon_series', 'ctc_sermon_speaker', 'ctc_sermon_tag' ),
		'menu_icon'		=> 'dashicons-video-alt3'
	);
	$args = apply_filters( 'ctc_post_type_sermon_args', $args ); // allow filtering

	// Registration
	register_post_type(
		'ctc_sermon',
		$args
	);

}

add_action( 'init', 'ctc_register_post_type_sermon' ); // register post type

/**********************************
 * EVENT
 **********************************/

/**
 * Register event post type
 *
 * @since 0.9
 */
function ctc_register_post_type_event() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'Events', 'post type general name', 'church-theme-content' ),
			'singular_name'			=> _x( 'Event', 'post type singular name', 'church-theme-content' ),
			'add_new' 				=> _x( 'Add New', 'event', 'church-theme-content' ),
			'add_new_item' 			=> __( 'Add Event', 'church-theme-content' ),
			'edit_item' 			=> __( 'Edit Event', 'church-theme-content' ),
			'new_item' 				=> __( 'New Event', 'church-theme-content' ),
			'all_items' 			=> __( 'All Events', 'church-theme-content' ),
			'view_item' 			=> __( 'View Event', 'church-theme-content' ),
			'search_items' 			=> __( 'Search Events', 'church-theme-content' ),
			'not_found' 			=> __( 'No events found', 'church-theme-content' ),
			'not_found_in_trash' 	=> __( 'No events found in Trash', 'church-theme-content' )
		),
		'public' 		=> ctc_feature_supported( 'events' ),
		'has_archive' 	=> ctc_feature_supported( 'events' ),
		'rewrite'		=> array(
			'slug' 			=> 'events',
			'with_front'	=> false,
			'feeds'			=> ctc_feature_supported( 'events' ),
		),
		'supports' 		=> array( 'title', 'editor', 'excerpt', 'publicize', 'thumbnail', 'comments', 'author', 'revisions' ),
		'menu_icon'		=> 'dashicons-calendar'
	);
	$args = apply_filters( 'ctc_post_type_event_args', $args ); // allow filtering

	// Registration
	register_post_type(
		'ctc_event',
		$args
	);

}

add_action( 'init', 'ctc_register_post_type_event' ); // register post type

/**********************************
 * LOCATION
 **********************************/

/**
 * Register location post type
 *
 * @since 0.9
 */
function ctc_location_post_type() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'Locations', 'post type general name', 'church-theme-content' ),
			'singular_name'			=> _x( 'Location', 'post type singular name', 'church-theme-content' ),
			'add_new' 				=> _x( 'Add New', 'location', 'church-theme-content' ),
			'add_new_item' 			=> __( 'Add Location', 'church-theme-content' ),
			'edit_item' 			=> __( 'Edit Location', 'church-theme-content' ),
			'new_item' 				=> __( 'New Location', 'church-theme-content' ),
			'all_items' 			=> __( 'All Locations', 'church-theme-content' ),
			'view_item' 			=> __( 'View Location', 'church-theme-content' ),
			'search_items' 			=> __( 'Search Locations', 'church-theme-content' ),
			'not_found' 			=> __( 'No location found', 'church-theme-content' ),
			'not_found_in_trash' 	=> __( 'No location found in Trash', 'church-theme-content' )
		),
		'public' 		=> ctc_feature_supported( 'locations' ),
		'has_archive' 	=> ctc_feature_supported( 'locations' ),
		'rewrite'		=> array(
			'slug' 			=> 'locations',
			'with_front' 	=> false,
			'feeds'			=> ctc_feature_supported( 'locations' ),
		),
		'supports' 		=> array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		'menu_icon'		=> 'dashicons-location'
	);
	$args = apply_filters( 'ctc_post_type_location_args', $args ); // allow filtering

	// Registration
	register_post_type(
		'ctc_location',
		$args
	);

}

add_action( 'init', 'ctc_location_post_type' ); // register post type

/**********************************
 * PERSON
 **********************************/

/**
 * Register person post type
 *
 * @since 0.9
 */
function ctc_register_post_type_person() {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> _x( 'People', 'post type general name', 'church-theme-content' ),
			'singular_name'			=> _x( 'Person', 'post type singular name', 'church-theme-content' ),
			'add_new' 				=> _x( 'Add New', 'person', 'church-theme-content' ),
			'add_new_item' 			=> __( 'Add Person', 'church-theme-content' ),
			'edit_item' 			=> __( 'Edit Person', 'church-theme-content' ),
			'new_item' 				=> __( 'New Person', 'church-theme-content' ),
			'all_items' 			=> __( 'All People', 'church-theme-content' ),
			'view_item' 			=> __( 'View Person', 'church-theme-content' ),
			'search_items' 			=> __( 'Search People', 'church-theme-content' ),
			'not_found' 			=> __( 'No people found', 'church-theme-content' ),
			'not_found_in_trash' 	=> __( 'No people found in Trash', 'church-theme-content' )
		),
		'public' 		=> ctc_feature_supported( 'people' ),
		'has_archive' 	=> ctc_feature_supported( 'people' ),
		'rewrite'		=> array(
			'slug' 			=> 'people',
			'with_front' 	=> false,
			'feeds'			=> ctc_feature_supported( 'people' ),
		),
		'supports' 		=> array( 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ),
		'taxonomies' 	=> array( 'ctc_person_group' ),
		'menu_icon'		=> 'dashicons-admin-users'
	);
	$args = apply_filters( 'ctc_post_type_person_args', $args ); // allow filtering

	// Registration
	register_post_type(
		'ctc_person',
		$args
	);

}

add_action( 'init', 'ctc_register_post_type_person' ); // register post type
