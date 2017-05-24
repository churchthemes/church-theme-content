<?php
/**
 * Register Taxonomies
 *
 * @package    Church_Theme_Content
 * @subpackage Functions
 * @copyright  Copyright (c) 2013 - 2017, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**********************************
 * SERMON TAXONOMIES
 **********************************/

/**
 * Sermon topic
 *
 * @since 0.9
 */
function ctc_register_taxonomy_sermon_topic() {

	// Arguments
	$args = array(
		'labels' => array(
			'name' 							=> esc_html_x( 'Sermon Topics', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> esc_html_x( 'Sermon Topic', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> esc_html_x( 'Search Topics', 'sermons', 'church-theme-content' ),
			'popular_items' 				=> esc_html_x( 'Popular Topics', 'sermons', 'church-theme-content' ),
			'all_items' 					=> esc_html_x( 'All Topics', 'sermons', 'church-theme-content' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> esc_html_x( 'Edit Topic', 'sermons', 'church-theme-content' ),
			'update_item' 					=> esc_html_x( 'Update Topic', 'sermons', 'church-theme-content' ),
			'add_new_item' 					=> esc_html_x( 'Add Topic', 'sermons', 'church-theme-content' ),
			'new_item_name' 				=> esc_html_x( 'New Topic', 'sermons', 'church-theme-content' ),
			'separate_items_with_commas' 	=> esc_html_x( 'Separate topics with commas', 'sermons', 'church-theme-content' ),
			'add_or_remove_items' 			=> esc_html_x( 'Add or remove topics', 'sermons', 'church-theme-content' ),
			'choose_from_most_used' 		=> esc_html_x( 'Choose from the most used topics', 'sermons', 'church-theme-content' ),
			'menu_name' 					=> esc_html_x( 'Topics', 'sermon menu name', 'church-theme-content' )
		),
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ctc_taxonomy_supported( 'sermons', 'ctc_sermon_topic' ),
		'rewrite' 		=> array(
			'slug' 			=> 'sermon-topic',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);
	$args = apply_filters( 'ctc_taxonomy_sermon_topic_args', $args ); // allow filtering

	// Registration
	register_taxonomy(
		'ctc_sermon_topic',
		'ctc_sermon',
		$args
	);

}

add_action( 'init', 'ctc_register_taxonomy_sermon_topic' );

/**
 * Sermon book
 *
 * @since 0.9
 */
function ctc_register_taxonomy_sermon_book() {

	// Arguments
	$args = array(
		'labels' => array(
			'name' 							=> esc_html_x( 'Sermon Books', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> esc_html_x( 'Sermon Book', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> esc_html_x( 'Search Books', 'sermons', 'church-theme-content' ),
			'popular_items' 				=> esc_html_x( 'Popular Books', 'sermons', 'church-theme-content' ),
			'all_items' 					=> esc_html_x( 'All Books', 'sermons', 'church-theme-content' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> esc_html_x( 'Edit Book', 'sermons', 'church-theme-content' ),
			'update_item' 					=> esc_html_x( 'Update Book', 'sermons', 'church-theme-content' ),
			'add_new_item' 					=> esc_html_x( 'Add Book', 'sermons', 'church-theme-content' ),
			'new_item_name' 				=> esc_html_x( 'New Book', 'sermons', 'church-theme-content' ),
			'separate_items_with_commas' 	=> esc_html_x( 'Separate books with commas', 'sermons', 'church-theme-content' ),
			'add_or_remove_items' 			=> esc_html_x( 'Add or remove books', 'sermons', 'church-theme-content' ),
			'choose_from_most_used' 		=> esc_html_x( 'Choose from the most used books', 'sermons', 'church-theme-content' ),
			'menu_name' 					=> esc_html_x( 'Books', 'sermon menu name', 'church-theme-content' )
		),
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ctc_taxonomy_supported( 'sermons', 'ctc_sermon_book' ),
		'rewrite' 		=> array(
			'slug' 			=> 'sermon-book',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);
	$args = apply_filters( 'ctc_taxonomy_sermon_book_args', $args ); // allow filtering

	// Registration
	register_taxonomy(
		'ctc_sermon_book',
		'ctc_sermon',
		$args
	);

}

add_action( 'init', 'ctc_register_taxonomy_sermon_book' );

/**
 * Sermon series
 *
 * @since 0.9
 */
function ctc_register_taxonomy_sermon_series() {

	// Arguments
	$args = array(
		'labels' => array(
			'name' 							=> esc_html_x( 'Sermon Series', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> esc_html_x( 'Sermon Series', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> esc_html_x( 'Search Series', 'sermons', 'church-theme-content' ),
			'popular_items' 				=> esc_html_x( 'Popular Series', 'sermons', 'church-theme-content' ),
			'all_items' 					=> esc_html_x( 'All Series', 'sermons', 'church-theme-content' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> esc_html_x( 'Edit Series', 'sermons', 'church-theme-content' ),
			'update_item' 					=> esc_html_x( 'Update Series', 'sermons', 'church-theme-content' ),
			'add_new_item' 					=> esc_html_x( 'Add Series', 'sermons', 'church-theme-content' ),
			'new_item_name' 				=> esc_html_x( 'New Series', 'sermons', 'church-theme-content' ),
			'separate_items_with_commas' 	=> esc_html_x( 'Separate series with commas', 'sermons', 'church-theme-content' ),
			'add_or_remove_items' 			=> esc_html_x( 'Add or remove series', 'sermons', 'church-theme-content' ),
			'choose_from_most_used' 		=> esc_html_x( 'Choose from the most used series', 'sermons', 'church-theme-content' ),
			'menu_name' 					=> esc_html_x( 'Series', 'sermon menu name', 'church-theme-content' )
		),
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ctc_taxonomy_supported( 'sermons', 'ctc_sermon_series' ),
		'rewrite' 		=> array(
			'slug' 			=> 'sermon-series',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);
	$args = apply_filters( 'ctc_taxonomy_sermon_series_args', $args ); // allow filtering

	// Registration
	register_taxonomy(
		'ctc_sermon_series',
		'ctc_sermon',
		$args
	);

}

add_action( 'init', 'ctc_register_taxonomy_sermon_series' );

/**
 * Sermon speaker
 *
 * @since 0.9
 */
function ctc_register_taxonomy_sermon_speaker() {

	// Arguments
	$args = array(
		'labels' => array(
			'name' 							=> esc_html_x( 'Sermon Speakers', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> esc_html_x( 'Sermon Speaker', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> esc_html_x( 'Search Speakers', 'sermons', 'church-theme-content' ),
			'popular_items' 				=> esc_html_x( 'Popular Speakers', 'sermons', 'church-theme-content' ),
			'all_items' 					=> esc_html_x( 'All Speakers', 'sermons', 'church-theme-content' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> esc_html_x( 'Edit Speaker', 'sermons', 'church-theme-content' ),
			'update_item' 					=> esc_html_x( 'Update Speaker', 'sermons', 'church-theme-content' ),
			'add_new_item' 					=> esc_html_x( 'Add Speaker', 'sermons', 'church-theme-content' ),
			'new_item_name' 				=> esc_html_x( 'New Speaker', 'sermons', 'church-theme-content' ),
			'separate_items_with_commas' 	=> esc_html_x( 'Separate speakers with commas', 'sermons', 'church-theme-content' ),
			'add_or_remove_items' 			=> esc_html_x( 'Add or remove speakers', 'sermons', 'church-theme-content' ),
			'choose_from_most_used' 		=> esc_html_x( 'Choose from the most used speakers', 'sermons', 'church-theme-content' ),
			'menu_name' 					=> esc_html_x( 'Speakers', 'sermon menu name', 'church-theme-content' )
		),
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ctc_taxonomy_supported( 'sermons', 'ctc_sermon_speaker' ),
		'rewrite' 		=> array(
			'slug' 			=> 'sermon-speaker',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);
	$args = apply_filters( 'ctc_taxonomy_sermon_speaker_args', $args ); // allow filtering

	// Registration
	register_taxonomy(
		'ctc_sermon_speaker',
		'ctc_sermon',
		$args
	);

}

add_action( 'init', 'ctc_register_taxonomy_sermon_speaker' );

/**
 * Sermon tag
 *
 * @since 0.9
 */
function ctc_register_taxonomy_sermon_tag() {

	// Arguments
	$args = array(
		'labels' => array(
			'name' 							=> esc_html_x( 'Sermon Tags', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> esc_html_x( 'Sermon Tag', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> esc_html_x( 'Search Tags', 'sermons', 'church-theme-content' ),
			'popular_items' 				=> esc_html_x( 'Popular Tags', 'sermons', 'church-theme-content' ),
			'all_items' 					=> esc_html_x( 'All Tags', 'sermons', 'church-theme-content' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> esc_html_x( 'Edit Tag', 'sermons', 'church-theme-content' ),
			'update_item' 					=> esc_html_x( 'Update Tag', 'sermons', 'church-theme-content' ),
			'add_new_item' 					=> esc_html_x( 'Add Tag', 'sermons', 'church-theme-content' ),
			'new_item_name' 				=> esc_html_x( 'New Tag', 'sermons', 'church-theme-content' ),
			'separate_items_with_commas' 	=> esc_html_x( 'Separate tags with commas', 'sermons', 'church-theme-content' ),
			'add_or_remove_items' 			=> esc_html_x( 'Add or remove tags', 'sermons', 'church-theme-content' ),
			'choose_from_most_used' 		=> esc_html_x( 'Choose from the most used tags', 'sermons', 'church-theme-content' ),
			'menu_name' 					=> esc_html_x( 'Tags', 'sermon menu name', 'church-theme-content' )
		),
		'hierarchical'	=> false, // tag style instead of category style
		'public' 		=> ctc_taxonomy_supported( 'sermons', 'ctc_sermon_tag' ),
		'rewrite' 		=> array(
			'slug' 			=> 'sermon-tag',
			'with_front'	=> false,
			'hierarchical' 	=> true
		)
	);
	$args = apply_filters( 'ctc_taxonomy_sermon_tag_args', $args ); // allow filtering

	// Registration
	register_taxonomy(
		'ctc_sermon_tag',
		'ctc_sermon',
		$args
	);

}

add_action( 'init', 'ctc_register_taxonomy_sermon_tag' );

/**********************************
 * EVENT TAXONOMIES
 **********************************/

/**
 * Event category
 *
 * @since 1.3
 */
function ctc_register_taxonomy_event_category() {

	// Arguments
	$args = array(
		'labels' => array(
			'name' 							=> esc_html_x( 'Event Categories', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> esc_html_x( 'Event Category', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> esc_html_x( 'Search Categories', 'events', 'church-theme-content' ),
			'popular_items' 				=> esc_html_x( 'Popular Categories', 'events', 'church-theme-content' ),
			'all_items' 					=> esc_html_x( 'All Categories', 'events', 'church-theme-content' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> esc_html_x( 'Edit Event Category', 'events', 'church-theme-content' ),
			'update_item' 					=> esc_html_x( 'Update Event Category', 'events', 'church-theme-content' ),
			'add_new_item' 					=> esc_html_x( 'Add Category', 'events', 'church-theme-content' ),
			'new_item_name' 				=> esc_html_x( 'New Category', 'events', 'church-theme-content' ),
			'separate_items_with_commas' 	=> esc_html_x( 'Separate categories with commas', 'events', 'church-theme-content' ),
			'add_or_remove_items' 			=> esc_html_x( 'Add or remove categories', 'events', 'church-theme-content' ),
			'choose_from_most_used' 		=> esc_html_x( 'Choose from the most used categories', 'events', 'church-theme-content' ),
			'menu_name' 					=> esc_html_x( 'Categories', 'event menu name', 'church-theme-content' )
		),
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ctc_taxonomy_supported( 'events', 'ctc_event_category' ),
		'rewrite' 		=> array(
			'slug' 			=> 'event-category',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);
	$args = apply_filters( 'ctc_taxonomy_event_category_args', $args ); // allow filtering

	// Registration
	register_taxonomy(
		'ctc_event_category',
		'ctc_event',
		$args
	);

}

add_action( 'init', 'ctc_register_taxonomy_event_category' );

/**********************************
 * PERSON TAXONOMIES
 **********************************/

/**
 * Person group
 *
 * @since 0.9
 */
function ctc_register_taxonomy_person_group() {

	// Arguments
	$args = array(
		'labels' => array(
			'name' 							=> esc_html_x( 'Groups', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> esc_html_x( 'Group', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> esc_html_x( 'Search Groups', 'people', 'church-theme-content' ),
			'popular_items' 				=> esc_html_x( 'Popular Groups', 'people', 'church-theme-content' ),
			'all_items' 					=> esc_html_x( 'All Groups', 'people', 'church-theme-content' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> esc_html_x( 'Edit Group', 'people', 'church-theme-content' ),
			'update_item' 					=> esc_html_x( 'Update Group', 'people', 'church-theme-content' ),
			'add_new_item' 					=> esc_html_x( 'Add Group', 'people', 'church-theme-content' ),
			'new_item_name' 				=> esc_html_x( 'New Group', 'people', 'church-theme-content' ),
			'separate_items_with_commas' 	=> esc_html_x( 'Separate groups with commas', 'people', 'church-theme-content' ),
			'add_or_remove_items' 			=> esc_html_x( 'Add or remove groups', 'people', 'church-theme-content' ),
			'choose_from_most_used' 		=> esc_html_x( 'Choose from the most used groups', 'people', 'church-theme-content' ),
			'menu_name' 					=> esc_html_x( 'Groups', 'people menu name', 'church-theme-content' )
		),
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ctc_taxonomy_supported( 'people', 'ctc_person_group' ),
		'rewrite' 		=> array(
			'slug' 			=> 'group',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);
	$args = apply_filters( 'ctc_taxonomy_person_group_args', $args ); // allow filtering

	// Registration
	register_taxonomy(
		'ctc_person_group',
		'ctc_person',
		$args
	);

}

add_action( 'init', 'ctc_register_taxonomy_person_group' );
