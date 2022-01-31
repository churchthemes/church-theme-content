<?php
/**
 * Register Taxonomies
 *
 * @package    Church_Theme_Content
 * @subpackage Functions
 * @copyright  Copyright (c) 2013 - 2019, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      0.9
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

/**********************************
 * SERMON TAXONOMIES
 **********************************/

/**
 * Sermon topic arguments.
 *
 * @since 2.0
 * @param bool $unfiltered Set true to return arguments without being filtered.
 * @return array Taxonomy registration arguments.
 */
function ctc_taxonomy_sermon_topic_args( $unfiltered = false ) {

	// Sermon wording.
	$sermon_word_singular = ctc_sermon_word_singular();
	$sermon_word_plural = ctc_sermon_word_plural();

	// Arguments.
	$args = array(
		'labels' => array(
			'name'       					=> esc_html( sprintf(
				/* translators: %s is singular word for "Sermon", possibly changed via settings. Always use %s and not "Sermon" directly. */
				_x( '%s Topics', 'sermon taxonomy general name', 'church-theme-content' ),
				$sermon_word_singular
			) ),
			'singular_name'       			=> esc_html( sprintf(
				/* translators: %s is singular word for "Sermon", possibly changed via settings. Always use %s and not "Sermon" directly. */
				_x( '%s Topic', 'sermon taxonomy singular name', 'church-theme-content' ),
				$sermon_word_singular
			) ),
			'search_items' 					=> esc_html_x( 'Search Topics', 'sermons', 'church-theme-content' ),
			'popular_items' 				=> esc_html_x( 'Popular Topics', 'sermons', 'church-theme-content' ),
			'all_items' 					=> esc_html_x( 'All Topics', 'sermons', 'church-theme-content' ),
			'parent_item' 					=> esc_html_x( 'Parent Topic', 'sermons', 'church-theme-content' ),
			'parent_item_colon' 			=> esc_html_x( 'Parent Topic:', 'sermons', 'church-theme-content' ),
			'edit_item' 					=> esc_html_x( 'Edit Topic', 'sermons', 'church-theme-content' ),
			'update_item' 					=> esc_html_x( 'Update Topic', 'sermons', 'church-theme-content' ),
			'add_new_item' 					=> esc_html_x( 'Add Topic', 'sermons', 'church-theme-content' ),
			'new_item_name' 				=> esc_html_x( 'New Topic', 'sermons', 'church-theme-content' ),
			'separate_items_with_commas' 	=> esc_html_x( 'Separate topics with commas', 'sermons', 'church-theme-content' ),
			'add_or_remove_items' 			=> esc_html_x( 'Add or remove topics', 'sermons', 'church-theme-content' ),
			'choose_from_most_used' 		=> esc_html_x( 'Choose from the most used topics', 'sermons', 'church-theme-content' ),
			'menu_name' 					=> esc_html_x( 'Topics', 'sermon menu name', 'church-theme-content' )
		),
		'show_in_rest'	=> true,
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ctc_taxonomy_supported( 'sermons', 'ctc_sermon_topic' ),
		'rewrite' 		=> array(
			'slug' 			=> 'sermon-topic',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);

	// Filter arguments.
	if (! $unfiltered) {
		$args = apply_filters( 'ctc_taxonomy_sermon_topic_args', $args );
	}

	return $args;

}

/**
 * Sermon topic registration.
 *
 * @since 0.9
 */
function ctc_register_taxonomy_sermon_topic() {

	// Arguments.
	$args = ctc_taxonomy_sermon_topic_args();

	// Registration.
	register_taxonomy(
		'ctc_sermon_topic',
		'ctc_sermon',
		$args
	);

}

add_action( 'init', 'ctc_register_taxonomy_sermon_topic' );

/**
 * Sermon book arguments.
 *
 * @since 2.0
 * @param bool $unfiltered Set true to return arguments without being filtered.
 * @return array Taxonomy registration arguments.
 */
function ctc_taxonomy_sermon_book_args( $unfiltered = false ) {

	// Sermon wording.
	$sermon_word_singular = ctc_sermon_word_singular();
	$sermon_word_plural = ctc_sermon_word_plural();

	// Arguments.
	$args = array(
		'labels' => array(
			'name'       					=> esc_html( sprintf(
				/* translators: %s is singular word for "Sermon", possibly changed via settings. Always use %s and not "Sermon" directly. */
				_x( '%s Books', 'sermon taxonomy general name', 'church-theme-content' ),
				$sermon_word_singular
			) ),
			'singular_name'       			=> esc_html( sprintf(
				/* translators: %s is singular word for "Sermon", possibly changed via settings. Always use %s and not "Sermon" directly. */
				_x( '%s Book', 'sermon taxonomy general name', 'church-theme-content' ),
				$sermon_word_singular
			) ),
			'search_items' 					=> esc_html_x( 'Search Books', 'sermons', 'church-theme-content' ),
			'popular_items' 				=> esc_html_x( 'Popular Books', 'sermons', 'church-theme-content' ),
			'all_items' 					=> esc_html_x( 'All Books', 'sermons', 'church-theme-content' ),
			'parent_item' 					=> esc_html_x( 'Parent Book', 'sermons', 'church-theme-content' ),
			'parent_item_colon' 			=> esc_html_x( 'Parent Book:', 'sermons', 'church-theme-content' ),
			'edit_item' 					=> esc_html_x( 'Edit Book', 'sermons', 'church-theme-content' ),
			'update_item' 					=> esc_html_x( 'Update Book', 'sermons', 'church-theme-content' ),
			'add_new_item' 					=> esc_html_x( 'Add Book', 'sermons', 'church-theme-content' ),
			'new_item_name' 				=> esc_html_x( 'New Book', 'sermons', 'church-theme-content' ),
			'separate_items_with_commas' 	=> esc_html_x( 'Separate books with commas', 'sermons', 'church-theme-content' ),
			'add_or_remove_items' 			=> esc_html_x( 'Add or remove books', 'sermons', 'church-theme-content' ),
			'choose_from_most_used' 		=> esc_html_x( 'Choose from the most used books', 'sermons', 'church-theme-content' ),
			'menu_name' 					=> esc_html_x( 'Books', 'sermon menu name', 'church-theme-content' )
		),
		'show_in_rest'	=> true,
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ctc_taxonomy_supported( 'sermons', 'ctc_sermon_book' ),
		'rewrite' 		=> array(
			'slug' 			=> 'sermon-book',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);

	// Filter arguments.
	if (! $unfiltered) {
		$args = apply_filters( 'ctc_taxonomy_sermon_book_args', $args );
	}

	return $args;

}

/**
 * Sermon book registration.
 *
 * @since 0.9
 */
function ctc_register_taxonomy_sermon_book() {

	// Arguments.
	$args = ctc_taxonomy_sermon_book_args();

	// Registration.
	register_taxonomy(
		'ctc_sermon_book',
		'ctc_sermon',
		$args
	);

}

add_action( 'init', 'ctc_register_taxonomy_sermon_book' );

/**
 * Sermon series arguments.
 *
 * @since 2.0
 * @param bool $unfiltered Set true to return arguments without being filtered.
 * @return array Taxonomy registration arguments.
 */
function ctc_taxonomy_sermon_series_args( $unfiltered = false ) {

	// Sermon wording.
	$sermon_word_singular = ctc_sermon_word_singular();
	$sermon_word_plural = ctc_sermon_word_plural();

	// Arguments.
	$args = array(
		'labels' => array(
			'name'       					=> esc_html( sprintf(
				/* translators: %s is singular word for "Sermon", possibly changed via settings. Always use %s and not "Sermon" directly. */
				_x( '%s Series', 'sermon taxonomy general name', 'church-theme-content' ),
				$sermon_word_singular
			) ),
			'singular_name'       			=> esc_html( sprintf(
				/* translators: %s is singular word for "Sermon", possibly changed via settings. Always use %s and not "Sermon" directly. */
				_x( '%s Series', 'sermon taxonomy general name', 'church-theme-content' ),
				$sermon_word_singular
			) ),
			'search_items' 					=> esc_html_x( 'Search Series', 'sermons', 'church-theme-content' ),
			'popular_items' 				=> esc_html_x( 'Popular Series', 'sermons', 'church-theme-content' ),
			'all_items' 					=> esc_html_x( 'All Series', 'sermons', 'church-theme-content' ),
			'parent_item' 					=> esc_html_x( 'Parent Series', 'sermons', 'church-theme-content' ),
			'parent_item_colon' 			=> esc_html_x( 'Parent Series:', 'sermons', 'church-theme-content' ),
			'edit_item' 					=> esc_html_x( 'Edit Series', 'sermons', 'church-theme-content' ),
			'update_item' 					=> esc_html_x( 'Update Series', 'sermons', 'church-theme-content' ),
			'add_new_item' 					=> esc_html_x( 'Add Series', 'sermons', 'church-theme-content' ),
			'new_item_name' 				=> esc_html_x( 'New Series', 'sermons', 'church-theme-content' ),
			'separate_items_with_commas' 	=> esc_html_x( 'Separate series with commas', 'sermons', 'church-theme-content' ),
			'add_or_remove_items' 			=> esc_html_x( 'Add or remove series', 'sermons', 'church-theme-content' ),
			'choose_from_most_used' 		=> esc_html_x( 'Choose from the most used series', 'sermons', 'church-theme-content' ),
			'menu_name' 					=> esc_html_x( 'Series', 'sermon menu name', 'church-theme-content' )
		),
		'show_in_rest'	=> true,
		'hierarchical'	=> true, // category-style instead of tag-style.
		'public' 		=> ctc_taxonomy_supported( 'sermons', 'ctc_sermon_series' ),
		'rewrite' 		=> array(
			'slug' 			=> 'sermon-series',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);

	// Filter arguments.
	if (! $unfiltered) {
		$args = apply_filters( 'ctc_taxonomy_sermon_series_args', $args );
	}

	return $args;

}

/**
 * Sermon series registration.
 *
 * @since 0.9
 */
function ctc_register_taxonomy_sermon_series() {

	// Arguments.
	$args = ctc_taxonomy_sermon_series_args();

	// Registration.
	register_taxonomy(
		'ctc_sermon_series',
		'ctc_sermon',
		$args
	);

}

add_action( 'init', 'ctc_register_taxonomy_sermon_series' );

/**
 * Sermon speaker arguments.
 *
 * @since 2.0
 * @param bool $unfiltered Set true to return arguments without being filtered.
 * @return array Taxonomy registration arguments.
 */
function ctc_taxonomy_sermon_speaker_args( $unfiltered = false ) {

	// Sermon wording.
	$sermon_word_singular = ctc_sermon_word_singular();
	$sermon_word_plural = ctc_sermon_word_plural();

	// Arguments.
	$args = array(
		'labels' => array(
			'name'       					=> esc_html( sprintf(
				/* translators: %s is singular word for "Sermon", possibly changed via settings. Always use %s and not "Sermon" directly. */
				_x( '%s Speakers', 'sermon taxonomy general name', 'church-theme-content' ),
				$sermon_word_singular
			) ),
			'singular_name'       			=> esc_html( sprintf(
				/* translators: %s is singular word for "Sermon", possibly changed via settings. Always use %s and not "Sermon" directly. */
				_x( '%s Speaker', 'sermon taxonomy general name', 'church-theme-content' ),
				$sermon_word_singular
			) ),			'search_items' 					=> esc_html_x( 'Search Speakers', 'sermons', 'church-theme-content' ),
			'popular_items' 				=> esc_html_x( 'Popular Speakers', 'sermons', 'church-theme-content' ),
			'all_items' 					=> esc_html_x( 'All Speakers', 'sermons', 'church-theme-content' ),
			'parent_item' 					=> esc_html_x( 'Parent Speaker', 'sermons', 'church-theme-content' ),
			'parent_item_colon' 			=> esc_html_x( 'Parent Speaker:', 'sermons', 'church-theme-content' ),
			'edit_item' 					=> esc_html_x( 'Edit Speaker', 'sermons', 'church-theme-content' ),
			'update_item' 					=> esc_html_x( 'Update Speaker', 'sermons', 'church-theme-content' ),
			'add_new_item' 					=> esc_html_x( 'Add Speaker', 'sermons', 'church-theme-content' ),
			'new_item_name' 				=> esc_html_x( 'New Speaker', 'sermons', 'church-theme-content' ),
			'separate_items_with_commas' 	=> esc_html_x( 'Separate speakers with commas', 'sermons', 'church-theme-content' ),
			'add_or_remove_items' 			=> esc_html_x( 'Add or remove speakers', 'sermons', 'church-theme-content' ),
			'choose_from_most_used' 		=> esc_html_x( 'Choose from the most used speakers', 'sermons', 'church-theme-content' ),
			'menu_name' 					=> esc_html_x( 'Speakers', 'sermon menu name', 'church-theme-content' )
		),
		'show_in_rest'	=> true,
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ctc_taxonomy_supported( 'sermons', 'ctc_sermon_speaker' ),
		'rewrite' 		=> array(
			'slug' 			=> 'sermon-speaker',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);

	// Filter arguments.
	if (! $unfiltered) {
		$args = apply_filters( 'ctc_taxonomy_sermon_speaker_args', $args ); // allow filtering.
	}

	return $args;

}

/**
 * Sermon speaker registration.
 *
 * @since 0.9
 */
function ctc_register_taxonomy_sermon_speaker() {

	// Arguments.
	$args = ctc_taxonomy_sermon_speaker_args();

	// Registration.
	register_taxonomy(
		'ctc_sermon_speaker',
		'ctc_sermon',
		$args
	);

}

add_action( 'init', 'ctc_register_taxonomy_sermon_speaker' );

/**
 * Sermon tag arguments.
 *
 * @since 2.0
 * @param bool $unfiltered Set true to return arguments without being filtered.
 * @return array Taxonomy registration arguments.
 */
function ctc_taxonomy_sermon_tag_args( $unfiltered = false ) {

	// Sermon wording.
	$sermon_word_singular = ctc_sermon_word_singular();
	$sermon_word_plural = ctc_sermon_word_plural();

	// Arguments.
	$args = array(
		'labels' => array(
			'name'       					=> esc_html( sprintf(
				/* translators: %s is singular word for "Sermon", possibly changed via settings. Always use %s and not "Sermon" directly. */
				_x( '%s Tags', 'sermon taxonomy general name', 'church-theme-content' ),
				$sermon_word_singular
			) ),
			'singular_name'       			=> esc_html( sprintf(
				/* translators: %s is singular word for "Sermon", possibly changed via settings. Always use %s and not "Sermon" directly. */
				_x( '%s Tag', 'sermon taxonomy general name', 'church-theme-content' ),
				$sermon_word_singular
			) ),
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
		'show_in_rest'	=> true,
		'hierarchical'	=> false, // tag style instead of category style
		'public' 		=> ctc_taxonomy_supported( 'sermons', 'ctc_sermon_tag' ),
		'rewrite' 		=> array(
			'slug' 			=> 'sermon-tag',
			'with_front'	=> false,
			'hierarchical' 	=> true
		)
	);

	// Filter arguments.
	if (! $unfiltered) {
		$args = apply_filters( 'ctc_taxonomy_sermon_tag_args', $args ); // allow filtering.
	}

	return $args;

}

/**
 * Sermon tag registration.
 *
 * @since 0.9
 */
function ctc_register_taxonomy_sermon_tag() {

	// Arguments.
	$args = ctc_taxonomy_sermon_tag_args();

	// Registration.
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
 * Event category arguments.
 *
 * @since 2.0
 * @param bool $unfiltered Set true to return arguments without being filtered.
 * @return array Taxonomy registration arguments.
 */
function ctc_taxonomy_event_category_args( $unfiltered = false ) {

	// Arguments.
	$args = array(
		'labels' => array(
			'name' 							=> esc_html_x( 'Event Categories', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> esc_html_x( 'Event Category', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> esc_html_x( 'Search Categories', 'events', 'church-theme-content' ),
			'popular_items' 				=> esc_html_x( 'Popular Categories', 'events', 'church-theme-content' ),
			'all_items' 					=> esc_html_x( 'All Categories', 'events', 'church-theme-content' ),
			'parent_item' 					=> esc_html_x( 'Parent Category', 'events', 'church-theme-content' ),
			'parent_item_colon' 			=> esc_html_x( 'Parent Category:', 'events', 'church-theme-content' ),
			'edit_item' 					=> esc_html_x( 'Edit Event Category', 'events', 'church-theme-content' ),
			'update_item' 					=> esc_html_x( 'Update Event Category', 'events', 'church-theme-content' ),
			'add_new_item' 					=> esc_html_x( 'Add Category', 'events', 'church-theme-content' ),
			'new_item_name' 				=> esc_html_x( 'New Category', 'events', 'church-theme-content' ),
			'separate_items_with_commas' 	=> esc_html_x( 'Separate categories with commas', 'events', 'church-theme-content' ),
			'add_or_remove_items' 			=> esc_html_x( 'Add or remove categories', 'events', 'church-theme-content' ),
			'choose_from_most_used' 		=> esc_html_x( 'Choose from the most used categories', 'events', 'church-theme-content' ),
			'menu_name' 					=> esc_html_x( 'Categories', 'event menu name', 'church-theme-content' )
		),
		'show_in_rest'	=> true,
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ctc_taxonomy_supported( 'events', 'ctc_event_category' ),
		'rewrite' 		=> array(
			'slug' 			=> 'event-category',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);

	// Filter arguments.
	if (! $unfiltered) {
		$args = apply_filters( 'ctc_taxonomy_event_category_args', $args );
	}

	return $args;

}

/**
 * Event category registration.
 *
 * @since 1.3
 */
function ctc_register_taxonomy_event_category() {

	// Arguments.
	$args = ctc_taxonomy_event_category_args();

	// Registration.
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
 * Person group arguments.
 *
 * @since 2.0
 * @param bool $unfiltered Set true to return arguments without being filtered.
 * @return array Taxonomy registration arguments.
 */
function ctc_taxonomy_person_group_args( $unfiltered = false ) {

	// Arguments.
	$args = array(
		'labels' => array(
			'name' 							=> esc_html_x( 'Groups', 'taxonomy general name', 'church-theme-content' ),
			'singular_name'					=> esc_html_x( 'Group', 'taxonomy singular name', 'church-theme-content' ),
			'search_items' 					=> esc_html_x( 'Search Groups', 'people', 'church-theme-content' ),
			'popular_items' 				=> esc_html_x( 'Popular Groups', 'people', 'church-theme-content' ),
			'all_items' 					=> esc_html_x( 'All Groups', 'people', 'church-theme-content' ),
			'parent_item' 					=> esc_html_x( 'Parent Group', 'people', 'church-theme-content' ),
			'parent_item_colon' 			=> esc_html_x( 'Parent Group:', 'people', 'church-theme-content' ),
			'edit_item' 					=> esc_html_x( 'Edit Group', 'people', 'church-theme-content' ),
			'update_item' 					=> esc_html_x( 'Update Group', 'people', 'church-theme-content' ),
			'add_new_item' 					=> esc_html_x( 'Add Group', 'people', 'church-theme-content' ),
			'new_item_name' 				=> esc_html_x( 'New Group', 'people', 'church-theme-content' ),
			'separate_items_with_commas' 	=> esc_html_x( 'Separate groups with commas', 'people', 'church-theme-content' ),
			'add_or_remove_items' 			=> esc_html_x( 'Add or remove groups', 'people', 'church-theme-content' ),
			'choose_from_most_used' 		=> esc_html_x( 'Choose from the most used groups', 'people', 'church-theme-content' ),
			'menu_name' 					=> esc_html_x( 'Groups', 'people menu name', 'church-theme-content' )
		),
		'show_in_rest'	=> true,
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ctc_taxonomy_supported( 'people', 'ctc_person_group' ),
		'rewrite' 		=> array(
			'slug' 			=> 'group',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);

	// Filter arguments.
	if (! $unfiltered) {
		$args = apply_filters( 'ctc_taxonomy_person_group_args', $args );
	}

	return $args;

}

/**
 * Person group registration.
 *
 * @since 0.9
 */
function ctc_register_taxonomy_person_group() {

	// Arguments.
	$args = ctc_taxonomy_person_group_args();

	// Registration.
	register_taxonomy(
		'ctc_person_group',
		'ctc_person',
		$args
	);

}

add_action( 'init', 'ctc_register_taxonomy_person_group' );

/**********************************
 * TAXONOMY TERM FIELDS
 **********************************/

/**
 * Taxonomies to hide Parent field for in editors and term screens.
 *
 * @since 2.1.2
 * @return array Taxonomy names
 */
function ctc_taxonomies_no_parent() {

	$taxonomies = array(
    	'ctc_sermon_series',
    	'ctc_sermon_book',
    	'ctc_sermon_speaker',
    );

    return apply_filters( 'ctc_taxonomies_no_parent', $taxonomies );

}

/**
 * Hide 'Parent' taxonomy term selector on Add/Edit term screens.
 *
 * We want hierachical-style selector, but without parent option.
 * Alternative is tag-style (hierarchical false), but that is unfriendly.
 *
 * Hide only if no parent already selected. Otherwise, user cannot remove parent.
 *
 * Only for series, book and speaker (topic can have parent).
 *
 * @since 2.1.2
 */
function ctc_taxonomy_hide_parent() {

    $screen = get_current_screen();

    // Specific taxonomies (Topic can have parent).
    if (! in_array( $screen->taxonomy, ctc_taxonomies_no_parent() )) {
    	return;
    }

    ?>

    <style type="text/css">

    /* Hide by default */
    .term-parent-wrap {
    	display: none;
    }

	</style>

    <script type="text/javascript">

    jQuery( document ).ready( function( $ ) {

    	// Get select element and selected value.
    	var $select = $( '.term-parent-wrap' );
    	var selected_value = $( 'option:selected', $select ).val();

    	// Show Parent only if already has option selected.
    	if ( selected_value.length && selected_value !== '-1' ) {
			$select.show();
		}

    } );

    </script>

    <?php

}

add_action( 'admin_head-edit-tags.php', 'ctc_taxonomy_hide_parent' ); // list and add term.
add_action( 'admin_head-term.php', 'ctc_taxonomy_hide_parent' ); // edit term.

/**
 * Hide 'Parent' taxonomy term selector when adding or editing a sermon.
 *
 * We want hierachical-style selector, but without parent option.
 * Alternative is tag-style (hierarchical false), but that is unfriendly.
 *
 * Hide only if no parent already selected. Otherwise, user cannot remove parent.
 *
 * Only for series, book and speaker (topic can have parent).
 *
 * @since 2.1.2
 */
function ctc_post_taxonomy_hide_parent() {

	global $wp_version;

	$screen = get_current_screen();

	// Add/edit sermon post type only.
	if ('post' !== $screen->base || ( isset( $screen->post_type ) && 'ctc_sermon' !== $screen->post_type )) {
		return;
	}

	// Get taxonomy label names translated, for CSS to hide in Gutenburg.
	$taxonomy_selectors = array();
	$taxonomies = get_object_taxonomies( 'ctc_sermon' );
	foreach($taxonomies as $taxonomy_name) {

		$taxonomy = get_taxonomy( $taxonomy_name );

		if (! empty( $taxonomy->labels->name ) && in_array( $taxonomy_name, ctc_taxonomies_no_parent() )) {
			if (version_compare($wp_version, '5.9', '<')) { // WordPress before 5.9
				$taxonomy_selectors[] = '.editor-post-taxonomies__hierarchical-terms-list[aria-label*="' . esc_html( $taxonomy->labels->name ) . '"] ~ form .components-base-control';
			} else { // WordPress 5.9 and later user different CSS selector
				$taxonomy_selectors[] = '.editor-post-taxonomies__hierarchical-terms-list[aria-label*="' . esc_html( $taxonomy->labels->name ) . '"] ~ form > .components-base-control:nth-of-type(2)';
			}
		}

	}

	// Hide Parent for book, series and speaker (topic can have parent).
    ?>

    <style type="text/css">

    /* Hide in Classic Editor */

    #newctc_sermon_book_parent,
    #newctc_sermon_series_parent,
    #newctc_sermon_speaker_parent {
    	display: none;
    }

    /* Hide in Block Editor */

    <?php echo implode( ',' . PHP_EOL, $taxonomy_selectors ); ?> {
		display: none;
	}

	</style>

    <?php

}

add_action( 'admin_head-post.php', 'ctc_post_taxonomy_hide_parent' ); // edit post.
add_action( 'admin_head-post-new.php', 'ctc_post_taxonomy_hide_parent' ); // add post.

/**********************************
 * TAXONOMY HELPERS
 **********************************/

/**
 * Taxonomy term options
 *
 * Returns ID/name pairs useful for creating select options and sanitizing.
 *
 * @since 2.0
 * @param string $feature ctc_taxonomy_supported
 * @param string $taxonomy_name Taxonomy slug
 * @param array $prepend Array to start with such as "All" or similar
 * @return array ID/name pairs
 */
function ctc_term_options( $feature, $taxonomy_name, $prepend = array() ) {

	$options = array();

	if (! preg_match( '/^ctc_/', $taxonomy_name ) || ctc_taxonomy_supported( $feature, $taxonomy_name )) { // make sure taxonomy supported.

		$terms = $categories = get_terms( $taxonomy_name );

		if (! empty( $prepend )) {
			$options = $prepend;
		}

		foreach ($terms as $term) {
			$options[ $term->term_id ] = $term->name;
		}

	}

	return apply_filters( 'ctc_term_options', $options, $taxonomy_name, $prepend );

}
