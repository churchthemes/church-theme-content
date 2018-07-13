<?php
/**
 * Register Post Types
 *
 * @package    Church_Theme_Content
 * @subpackage Functions
 * @copyright  Copyright (c) 2013 - 2017, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**********************************
 * SERMON POST TYPE
 **********************************/

/**
 * Sermon post type arguments.
 *
 * @since 2.0
 * @param bool $unfiltered Set true to return arguments without being filtered.
 * @return array Post type registration arguments.
 */
function ctc_post_type_sermon_args( $unfiltered = false ) {

	// Sermon wording.
	$singular = ctc_sermon_word_singular();
	$plural = ctc_sermon_word_plural();

	// Filterable wording.
	if ( ! $unfiltered ) {
		$singular = apply_filters( 'ctc_post_type_sermon_singular', $singular );
		$plural = apply_filters( 'ctc_post_type_sermon_plural', $plural );
	}

	// Lowercase variants.
	$singular_lowercase = strtolower( $singular );
	$plural_lowercase = strtolower( $plural );

	// Arguments.
	$args = array(
		'labels' => array(
			'name'               => esc_html( $plural ),
			'singular_name'      => esc_html( $singular ),
			'add_new'            => esc_html_x( 'Add New', 'sermon', 'church-theme-content' ),
			'add_new_item'       => esc_html( sprintf(
				/* translators: %s is singular word for "Sermon", possibly changed via settings. Always use %s and not "Sermon" directly. */
				_x( 'Add %s', 'sermon', 'church-theme-content' ),
				$singular
			) ),
			'edit_item'          => esc_html( sprintf(
				/* translators: %s is singular word for "Sermon", possibly changed via settings. Always use %s and not "Sermon" directly. */
				_x( 'Edit %s', 'sermon', 'church-theme-content' ),
				$singular
			) ),
			'new_item'           => esc_html( sprintf(
				/* translators: %s is singular word for "Sermon", possibly changed via settings. Always use %s and not "Sermon" directly. */
				_x( 'New %s', 'sermon', 'church-theme-content' ),
				$singular
			) ),
			'all_items'          => esc_html( sprintf(
				/* translators: %s is plural word for "Sermons", possibly changed via settings. Always use %s and not "Sermons" directly. */
				_x( 'All %s', 'sermons', 'church-theme-content' ),
				$plural
			) ),
			'view_item'          => esc_html( sprintf(
				/* translators: %s is singular word for "Sermon", possibly changed via settings. Always use %s and not "Sermon" directly. */
				_x( 'View %s', 'sermon', 'church-theme-content' ),
				$singular
			) ),
			'view_items'         => esc_html( sprintf(
				/* translators: %s is plural word for "Sermons", possibly changed via settings. Always use %s and not "Sermons" directly. */
				_x( 'View %s', 'sermons', 'church-theme-content' ),
				$plural
			) ),
			'search_items'       => esc_html( sprintf(
				/* translators: %s is plural word for "Sermons", possibly changed via settings. Always use %s and not "Sermons" directly. */
				_x( 'Search %s', 'sermons', 'church-theme-content' ),
				$plural
			) ),
			'not_found'          => esc_html( sprintf(
				/* translators: %s is lowercase plural word for "sermons", possibly changed via settings. Always use %s and not "sermons" directly. */
				_x( 'No %s found', 'sermons', 'church-theme-content' ),
				$plural_lowercase
			) ),
			'not_found_in_trash' => esc_html( sprintf(
				/* translators: %s is lowercase plural word for "sermons", possibly changed via settings. Always use %s and not "sermons" directly. */
				_x( 'No %s found in Trash', 'sermons', 'church-theme-content' ),
				$plural_lowercase
			) ),
			// Note: WordPress now offers additional labels that may be worth defining: https://codex.wordpress.org/Function_Reference/register_post_type#Arguments.
		),
		'public'       => ctc_feature_supported( 'sermons' ),
		'has_archive'  => ctc_feature_supported( 'sermons' ),
		'rewrite'      => array(
			'slug'       => 'sermons',
			'with_front' => false,
			'feeds'      => ctc_feature_supported( 'sermons' ),
		),
		'supports'     => array( 'title', 'editor', 'excerpt', 'publicize', 'thumbnail', 'comments', 'author', 'revisions' ), // 'editor' required for media upload button (see Meta Boxes note below about hiding)
		'taxonomies'   => array( 'ctc_sermon_topic', 'ctc_sermon_book', 'ctc_sermon_series', 'ctc_sermon_speaker', 'ctc_sermon_tag' ),
		'menu_icon'    => 'dashicons-video-alt3',
		'show_in_rest' => true,
	);

	// Filter arguments.
	if ( ! $unfiltered ) {
		$args = apply_filters( 'ctc_post_type_sermon_args', $args );
	}

	return $args;

}

/**
 * Register sermon post type.
 *
 * @since 0.9
 */
function ctc_register_post_type_sermon() {

	// Arguments.
	$args = ctc_post_type_sermon_args();

	// Registration.
	register_post_type(
		'ctc_sermon',
		$args
	);

}

add_action( 'init', 'ctc_register_post_type_sermon' ); // register post type.

/**
 * "Sermon" singular label from post type.
 *
 * @since 2.0
 * @return string Default, translated or what is set in settings.
 */
function ctc_sermon_word_singular() {

	// Get post type label, possibly changed by Pro settings.
	$word = ctc_post_type_label( 'ctc_sermon', 'singular' );

	// Get default word in case post type not registered yet.
	if ( ! $word ) {
		$word = _x( 'Sermon', 'post type singular', 'church-theme-content' );
	}

	return $word;

}

/**
 * "Sermons" plural label from post type.
 *
 * @since 2.0
 * @return string Default, translated or what is set in settings.
 */
function ctc_sermon_word_plural() {

	// Get post type label, possibly changed by Pro settings.
	$word = ctc_post_type_label( 'ctc_sermon', 'plural' );

	// Get default word in case post type not registered yet.
	if ( ! $word ) {
		$word = _x( 'Sermons', 'post type plural', 'church-theme-content' );
	}

	return $word;

}

/**********************************
 * EVENT POST TYPE
 **********************************/

/**
 * Event post type arguments.
 *
 * @since 2.0
 * @param bool $unfiltered Set true to return arguments without being filtered.
 * @return array Post type registration arguments.
 */
function ctc_post_type_event_args( $unfiltered = false ) {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> esc_html_x( 'Events', 'post type general name', 'church-theme-content' ),
			'singular_name'			=> esc_html_x( 'Event', 'post type singular name', 'church-theme-content' ),
			'add_new' 				=> esc_html_x( 'Add New', 'event', 'church-theme-content' ),
			'add_new_item' 			=> esc_html__( 'Add Event', 'church-theme-content' ),
			'edit_item' 			=> esc_html__( 'Edit Event', 'church-theme-content' ),
			'new_item' 				=> esc_html__( 'New Event', 'church-theme-content' ),
			'all_items' 			=> esc_html__( 'All Events', 'church-theme-content' ),
			'view_item' 			=> esc_html__( 'View Event', 'church-theme-content' ),
			'view_items'			=> esc_html__( 'View Events', 'church-theme-content' ),
			'search_items' 			=> esc_html__( 'Search Events', 'church-theme-content' ),
			'not_found' 			=> esc_html__( 'No events found', 'church-theme-content' ),
			'not_found_in_trash' 	=> esc_html__( 'No events found in Trash', 'church-theme-content' )
		),
		'public' 		=> ctc_feature_supported( 'events' ),
		'has_archive' 	=> ctc_feature_supported( 'events' ),
		'rewrite'		=> array(
			'slug' 			=> 'events',
			'with_front'	=> false,
			'feeds'			=> ctc_feature_supported( 'events' ),
		),
		'supports' 		=> array( 'title', 'editor', 'excerpt', 'publicize', 'thumbnail', 'comments', 'author', 'revisions' ),
		'taxonomies' 	=> array( 'ctc_event_category' ),
		'menu_icon'		=> 'dashicons-calendar',
		'show_in_rest'	=> true,
	);

	// Filter arguments.
	if ( ! $unfiltered ) {
		$args = apply_filters( 'ctc_post_type_event_args', $args );
	}

	return $args;

}

/**
 * Register event post type.
 *
 * @since 0.9
 */
function ctc_register_post_type_event() {

	// Arguments.
	$args = ctc_post_type_event_args();

	// Registration.
	register_post_type(
		'ctc_event',
		$args
	);

}

add_action( 'init', 'ctc_register_post_type_event' ); // register post type.

/**********************************
 * LOCATION POST TYPE
 **********************************/

/**
 * Location post type arguments.
 *
 * @since 2.0
 * @param bool $unfiltered Set true to return arguments without being filtered.
 * @return array Post type registration arguments.
 */
function ctc_post_type_location_args( $unfiltered = false ) {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> esc_html_x( 'Locations', 'post type general name', 'church-theme-content' ),
			'singular_name'			=> esc_html_x( 'Location', 'post type singular name', 'church-theme-content' ),
			'add_new' 				=> esc_html_x( 'Add New', 'location', 'church-theme-content' ),
			'add_new_item' 			=> esc_html__( 'Add Location', 'church-theme-content' ),
			'edit_item' 			=> esc_html__( 'Edit Location', 'church-theme-content' ),
			'new_item' 				=> esc_html__( 'New Location', 'church-theme-content' ),
			'all_items' 			=> esc_html__( 'All Locations', 'church-theme-content' ),
			'view_item' 			=> esc_html__( 'View Location', 'church-theme-content' ),
			'view_items'			=> esc_html__( 'View Locations', 'church-theme-content' ),
			'search_items' 			=> esc_html__( 'Search Locations', 'church-theme-content' ),
			'not_found' 			=> esc_html__( 'No location found', 'church-theme-content' ),
			'not_found_in_trash' 	=> esc_html__( 'No location found in Trash', 'church-theme-content' )
		),
		'public' 		=> ctc_feature_supported( 'locations' ),
		'has_archive' 	=> ctc_feature_supported( 'locations' ),
		'rewrite'		=> array(
			'slug' 			=> 'locations',
			'with_front' 	=> false,
			'feeds'			=> ctc_feature_supported( 'locations' ),
		),
		'supports' 		=> array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		'menu_icon'		=> 'dashicons-location',
		'show_in_rest'	=> true,
	);

	// Filter arguments.
	if ( ! $unfiltered ) {
		$args = apply_filters( 'ctc_post_type_location_args', $args );
	}

	return $args;

}

/**
 * Register location post type.
 *
 * @since 0.9
 */
function ctc_register_location_post_type() {

	// Arguments.
	$args = ctc_post_type_location_args();

	// Registration.
	register_post_type(
		'ctc_location',
		$args
	);

}

add_action( 'init', 'ctc_register_location_post_type' ); // register post type.

/**********************************
 * PERSON POST TYPE
 **********************************/

/**
 * Person post type arguments.
 *
 * @since 2.0
 * @param bool $unfiltered Set true to return arguments without being filtered.
 * @return array Post type registration arguments.
 */
function ctc_post_type_person_args( $unfiltered = false ) {

	// Arguments
	$args = array(
		'labels' => array(
			'name'					=> esc_html_x( 'People', 'post type general name', 'church-theme-content' ),
			'singular_name'			=> esc_html_x( 'Person', 'post type singular name', 'church-theme-content' ),
			'add_new' 				=> esc_html_x( 'Add New', 'person', 'church-theme-content' ),
			'add_new_item' 			=> esc_html__( 'Add Person', 'church-theme-content' ),
			'edit_item' 			=> esc_html__( 'Edit Person', 'church-theme-content' ),
			'new_item' 				=> esc_html__( 'New Person', 'church-theme-content' ),
			'all_items' 			=> esc_html__( 'All People', 'church-theme-content' ),
			'view_item' 			=> esc_html__( 'View Person', 'church-theme-content' ),
			'view_items'			=> esc_html__( 'View People', 'church-theme-content' ),
			'search_items' 			=> esc_html__( 'Search People', 'church-theme-content' ),
			'not_found' 			=> esc_html__( 'No people found', 'church-theme-content' ),
			'not_found_in_trash' 	=> esc_html__( 'No people found in Trash', 'church-theme-content' )
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
		'menu_icon'		=> 'dashicons-admin-users',
		'show_in_rest'	=> true,
	);

	// Filter arguments.
	if ( ! $unfiltered ) {
		$args = apply_filters( 'ctc_post_type_person_args', $args );
	}

	return $args;

}

/**
 * Register person post type.
 *
 * @since 0.9
 */
function ctc_register_post_type_person() {

	// Arguments.
	$args = ctc_post_type_person_args();

	// Registration.
	register_post_type(
		'ctc_person',
		$args
	);

}

add_action( 'init', 'ctc_register_post_type_person' ); // register post type.

/**********************************
 * POST TYPE HELPERS
 **********************************/

/**
 * Get post type label (plural or singular).
 *
 * This will get the label used when registering post type.
 * The value may be the default or what Pro settings provide.
 *
 * Will return empty if post type not yet registered.
 *
 * @since 2.0
 * @param string $post_type Post type to get label for.
 * @param string $form 'singular' or 'plural' (can also leave empty to get plural).
 * @return string Singular or plural label for post type.
 */
function ctc_post_type_label( $post_type, $form = false ) {

	// Empty if cannot get name.
	$name = '';

	// Get post type object.
	$obj = get_post_type_object( $post_type );

	// Have object.
	if ( ! empty( $obj ) ) {

		// Singular form.
		if ( 'singular' === $form && isset( $obj->labels->singular_name ) ) {
			$name = $obj->labels->singular_name;
		}

		// Plural form.
		// If not singular, assume plural.
		elseif ( isset( $obj->labels->name ) ) {
			$name = $obj->labels->name;
		}

	}

	// Return filtered.
	return apply_filters( 'ctc_post_type_label', $name );

}
