<?php
/**
 * Register Taxonomies
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
			'name' 							=> _x( 'Sermon Topics', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> _x( 'Sermon Topic', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> _x( 'Search Topics', 'sermons', 'church-theme-content' ),
			'popular_items' 				=> _x( 'Popular Topics', 'sermons', 'church-theme-content' ),
			'all_items' 					=> _x( 'All Topics', 'sermons', 'church-theme-content' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> _x( 'Edit Topic', 'sermons', 'church-theme-content' ),
			'update_item' 					=> _x( 'Update Topic', 'sermons', 'church-theme-content' ),
			'add_new_item' 					=> _x( 'Add Topic', 'sermons', 'church-theme-content' ),
			'new_item_name' 				=> _x( 'New Topic', 'sermons', 'church-theme-content' ),
			'separate_items_with_commas' 	=> _x( 'Separate topics with commas', 'sermons', 'church-theme-content' ),
			'add_or_remove_items' 			=> _x( 'Add or remove topics', 'sermons', 'church-theme-content' ),
			'choose_from_most_used' 		=> _x( 'Choose from the most used topics', 'sermons', 'church-theme-content' ),
			'menu_name' 					=> _x( 'Topics', 'sermon menu name', 'church-theme-content' )
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
			'name' 							=> _x( 'Sermon Books', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> _x( 'Sermon Book', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> _x( 'Search Books', 'sermons', 'church-theme-content' ),
			'popular_items' 				=> _x( 'Popular Books', 'sermons', 'church-theme-content' ),
			'all_items' 					=> _x( 'All Books', 'sermons', 'church-theme-content' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> _x( 'Edit Book', 'sermons', 'church-theme-content' ),
			'update_item' 					=> _x( 'Update Book', 'sermons', 'church-theme-content' ),
			'add_new_item' 					=> _x( 'Add Book', 'sermons', 'church-theme-content' ),
			'new_item_name' 				=> _x( 'New Book', 'sermons', 'church-theme-content' ),
			'separate_items_with_commas' 	=> _x( 'Separate books with commas', 'sermons', 'church-theme-content' ),
			'add_or_remove_items' 			=> _x( 'Add or remove books', 'sermons', 'church-theme-content' ),
			'choose_from_most_used' 		=> _x( 'Choose from the most used books', 'sermons', 'church-theme-content' ),
			'menu_name' 					=> _x( 'Books', 'sermon menu name', 'church-theme-content' )
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
			'name' 							=> _x( "Sermon Series", 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> _x( "Sermon Series", 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> _x( "Search Series", 'sermons', 'church-theme-content' ),
			'popular_items' 				=> _x( "Popular Series", 'sermons', 'church-theme-content' ),
			'all_items' 					=> _x( "All Series", 'sermons', 'church-theme-content' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> _x( 'Edit Series', 'sermons', 'church-theme-content' ),
			'update_item' 					=> _x( 'Update Series', 'sermons', 'church-theme-content' ),
			'add_new_item' 					=> _x( 'Add Series', 'sermons', 'church-theme-content' ),
			'new_item_name' 				=> _x( 'New Series', 'sermons', 'church-theme-content' ),
			'separate_items_with_commas' 	=> _x( "Separate series with commas", 'sermons', 'church-theme-content' ),
			'add_or_remove_items' 			=> _x( "Add or remove series", 'sermons', 'church-theme-content' ),
			'choose_from_most_used' 		=> _x( "Choose from the most used series", 'sermons', 'church-theme-content' ),
			'menu_name' 					=> _x( "Series", 'sermon menu name', 'church-theme-content' )
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
			'name' 							=> _x( 'Sermon Speakers', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> _x( 'Sermon Speaker', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> _x( 'Search Speakers', 'sermons', 'church-theme-content' ),
			'popular_items' 				=> _x( 'Popular Speakers', 'sermons', 'church-theme-content' ),
			'all_items' 					=> _x( 'All Speakers', 'sermons', 'church-theme-content' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> _x( 'Edit Speaker', 'sermons', 'church-theme-content' ),
			'update_item' 					=> _x( 'Update Speaker', 'sermons', 'church-theme-content' ),
			'add_new_item' 					=> _x( 'Add Speaker', 'sermons', 'church-theme-content' ),
			'new_item_name' 				=> _x( 'New Speaker', 'sermons', 'church-theme-content' ),
			'separate_items_with_commas' 	=> _x( 'Separate speakers with commas', 'sermons', 'church-theme-content' ),
			'add_or_remove_items' 			=> _x( 'Add or remove speakers', 'sermons', 'church-theme-content' ),
			'choose_from_most_used' 		=> _x( 'Choose from the most used speakers', 'sermons', 'church-theme-content' ),
			'menu_name' 					=> _x( 'Speakers', 'sermon menu name', 'church-theme-content' )
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
			'name' 							=> _x( 'Sermon Tags', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> _x( 'Sermon Tag', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> _x( 'Search Tags', 'sermons', 'church-theme-content' ),
			'popular_items' 				=> _x( 'Popular Tags', 'sermons', 'church-theme-content' ),
			'all_items' 					=> _x( 'All Tags', 'sermons', 'church-theme-content' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> _x( 'Edit Tag', 'sermons', 'church-theme-content' ),
			'update_item' 					=> _x( 'Update Tag', 'sermons', 'church-theme-content' ),
			'add_new_item' 					=> _x( 'Add Tag', 'sermons', 'church-theme-content' ),
			'new_item_name' 				=> _x( 'New Tag', 'sermons', 'church-theme-content' ),
			'separate_items_with_commas' 	=> _x( 'Separate tags with commas', 'sermons', 'church-theme-content' ),
			'add_or_remove_items' 			=> _x( 'Add or remove tags', 'sermons', 'church-theme-content' ),
			'choose_from_most_used' 		=> _x( 'Choose from the most used tags', 'sermons', 'church-theme-content' ),
			'menu_name' 					=> _x( 'Tags', 'sermon menu name', 'church-theme-content' )
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
			'name' 							=> _x( 'Groups', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> _x( 'Group', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> _x( 'Search Groups', 'people', 'church-theme-content' ),
			'popular_items' 				=> _x( 'Popular Groups', 'people', 'church-theme-content' ),
			'all_items' 					=> _x( 'All Groups', 'people', 'church-theme-content' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> _x( 'Edit Group', 'people', 'church-theme-content' ),
			'update_item' 					=> _x( 'Update Group', 'people', 'church-theme-content' ),
			'add_new_item' 					=> _x( 'Add Group', 'people', 'church-theme-content' ),
			'new_item_name' 				=> _x( 'New Group', 'people', 'church-theme-content' ),
			'separate_items_with_commas' 	=> _x( 'Separate groups with commas', 'people', 'church-theme-content' ),
			'add_or_remove_items' 			=> _x( 'Add or remove groups', 'people', 'church-theme-content' ),
			'choose_from_most_used' 		=> _x( 'Choose from the most used groups', 'people', 'church-theme-content' ),
			'menu_name' 					=> _x( 'Groups', 'people menu name', 'church-theme-content' )
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
