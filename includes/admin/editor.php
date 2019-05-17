<?php
/**
 * Editor in Admin
 *
 * Meta boxes and admin columns.
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2018 - 2019, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since 2.0
 */

// No direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**********************************
 * PLACEHOLDERS
 **********************************/

/**
 * Change "Add Title" placeholder to make sense for various post types.
 *
 * @since 2.0
 * @param string $placeholder Default title placeholder
 * @return string Modified placeholder
 */
function ctc_title_placeholder( $placeholder ) {

	// Get current screen.
	$screen = get_current_screen();

	// Using Gutenberg?
	$block_editor = ctc_is_block_editor();

	// "Enter name here" string.
	$enter_name_here = __( 'Enter name here', 'church-theme-content' );

	// Switch post type possibilities.
	switch ( $screen->post_type ) {

		// Page.
		case 'page':

		 	// Gutenberg editor.
			if ( $block_editor ) {
				$placeholder = sprintf(
					/* translators: For title placeholder when adding new page with block editor (example result: "Page Title"). %1$s is "Page" (singular) word, possibly changed by translation. Always use %1$s and not "Page" */
					_x( '%1$s Title', 'page title placeholder', 'church-theme-content' ),
					ctc_post_type_label( 'page', 'singular' )
				);
			}

			// Classic editor unchanged: "Enter title here".

			break;

		// Post.
		case 'post':

		 	// Gutenberg editor.
			if ( $block_editor ) {
				$placeholder = sprintf(
					/* translators: For title placeholder when adding new post with block editor (example result: "Post Title"). %1$s is "Post" (singular) word, possibly changed by translation. Always use %1$s and not "Post" */
					_x( '%1$s Title', 'post title placeholder', 'church-theme-content' ),
					ctc_post_type_label( 'post', 'singular' )
				);
			}

			// Classic editor unchanged: "Enter title here".

			break;

		// Sermon.
		case 'ctc_sermon':

		 	// Gutenberg editor.
			if ( $block_editor ) {
				$placeholder = sprintf(
					/* translators: For title placeholder when adding new sermon with block editor (example result: "Sermon Title"). %1$s is "Sermon" (singular) word, possibly changed by settings or translation. Always use %1$s and not "Sermon". */
					_x( '%1$s Title', 'sermon title placeholder', 'church-theme-content' ),
					ctc_sermon_word_singular()
				);
			}

			// Classic editor unchanged: "Enter title here".

			break;


		// Event.
		case 'ctc_event':

		 	// Gutenberg editor.
			if ( $block_editor ) {
				$placeholder = sprintf(
					/* translators: For title placeholder when adding new event with block editor (example result: "Event Title"). %1$s is "Event" (singular) word, possibly changed by translation. Always use %1$s and not "Event". */
					_x( '%1$s Name', 'event title placeholder', 'church-theme-content' ),
					ctc_post_type_label( 'ctc_event', 'singular' )
				);
			}

			// Classic editor.
			else {
				$placeholder = $enter_name_here; // "event name" is more common than "event title".
			}

			break;

		// Location.
		case 'ctc_location':

		 	// Gutenberg editor.
			if ( $block_editor ) {
				$placeholder = sprintf(
					/* translators: For title placeholder when adding new location with block editor (example result: "Location Name"). %1$s is "Location" (singular) word, possibly changed by translation. Always use %1$s and not "Location" */
					_x( '%1$s Name', 'location title placeholder', 'church-theme-content' ),
					ctc_post_type_label( 'ctc_location', 'singular' )
				);
			}

			// Classic editor.
			else {
				$placeholder = $enter_name_here; // "location name" is more common than "location title".
			}

			break;

		// Person.
		case 'ctc_person':

		 	// Gutenberg editor.
			if ( $block_editor ) {
				$placeholder = sprintf(
					/* translators: For title placeholder when adding new person with block editor (example result: "Person's Name"). %s is "Person" (singular) word, possibly changed by translation. Always use %s and not "Person" */
					_x( "%s's Name", 'person title placeholder', 'church-theme-content' ),
					ctc_post_type_label( 'ctc_person', 'singular' )
				);
			}

			// Classic editor.
			else {
				$placeholder = $enter_name_here;
			}

			break;

	}

	// Unchanged for other post types.

	// Return.
	return $placeholder;

}

add_filter( 'enter_title_here', 'ctc_title_placeholder' );

/**
 * Change "Write your story" to "Add content" when adding a new post in block editor.
 *
 * This generic form is more suitable for pages, sermons, events, etc.
 *
 * Note: The filter this uses is for Gutenberg only.
 *
 * @since 2.0
 * @param string $placeholder Default body placeholder
 * @return string Modified placeholder
 */
function ctc_body_placeholder( $placeholder ) {

	// Get current screen.
	$screen = get_current_screen();

	// Switch post type possibilities.
	switch ( $screen->post_type ) {

		// Sermon.
		case 'ctc_sermon':

			$placeholder = sprintf(
				/* translators: For content placeholder when adding new sermon with block editor (example result: "Enter sermon transcript or details here"). %1$s is "sermon" word (singular, lowercase), possibly changed by settings or translation. Always use %1$s and not "sermon". */
				__( 'Enter %1$s transcript or details', 'church-theme-content' ),
				strtolower( ctc_sermon_word_singular() )
			);

			break;

		// Event.
		case 'ctc_event':

			$placeholder = sprintf(
				/* translators: For content placeholder when adding new event with block editor (example result: "Describe the event"). %1$s is "event" word (singular, lowercase), possibly changed by translation. Always use %1$s and not "event". */
				_x( 'Describe the %1$s', 'event body placeholder', 'church-theme-content' ),
				strtolower( ctc_post_type_label( 'ctc_event', 'singular' ) )
			);

			break;

		// Location.
		case 'ctc_location':

			$placeholder = sprintf(
				/* translators: For content placeholder when adding new location with block editor (example result: "Describe the location"). %1$s is "location" word (singular, lowercase), possibly changed by translation. Always use %1$s and not "location". */
				_x( 'Describe the %1$s', 'location body placeholder', 'church-theme-content' ),
				strtolower( ctc_post_type_label( 'ctc_location', 'singular' ) )
			);

			break;

		// Location.
		case 'ctc_person':

			/* translators: For content placeholder when adding new person with block editor. */
			$placeholder = __( 'Write a biography', 'church-theme-content' );

			break;

		// Other post types (post, page).
		default:

			// "Add content" makes more sense than "Write your story" for any post type.
			$placeholder = __( 'Add content', 'church-theme-content' );

			break;

	}

	return $placeholder;

}

add_filter( 'write_your_story', 'ctc_body_placeholder' );

/*******************************************
 * HELPERS
 *******************************************/

/**
 * Check if block editor (Gutenberg) is in use on add/edit screen.
 *
 * @since 2.0
 */
function ctc_is_block_editor() {

	global $post, $pagenow;

	// Default false.
	$is = false;

	// Editing single post and Gutenberg is available.
	// Using $pagenow instead of get_current_screen() since it's sometimes too early to be available.
	if ( in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) && function_exists( 'gutenberg_can_edit_post' ) ) {

		// Not using classic editor.
		if ( isset( $_GET['classic-editor'] ) ) {
			$is = false;
		}

		// Not able to edit with Gutenberg.
		elseif ( ! gutenberg_can_edit_post( $post ) ) {
			$is = false;
		}

		// Gutenburg running.
		else {
			$is = true;
		}

	}

	return $is;

}

