<?php
/**
 * Editor ini Admin
 *
 * Meta boxes and admin columns.
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2018, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      1.9
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
 * @since 1.9
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

		// Sermon.
		case 'ctc_sermon':

		 	// Gutenberg editor.
			if ( $block_editor ) {
				$placeholder = sprintf(
					/* translators: %1$s is "Sermon" (singular) word, possibly changed by setting or translation. Always use %1$s and not "Sermon" */
					__( '%s Title', 'church-theme-content' ),
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
					/* translators: %1$s is "Event" (singular) word, possibly changed by translation. Always use %1$s and not "Event" */
					__( '%s Name', 'church-theme-content' ),
					 ctc_post_type_label( 'ctc_event', 'singular' )
				);
			}

			// Classic editor.
			else {
				$placeholder = $enter_name_here; // "event name" is more common than "event title".
			}

			// Classic editor unchanged.

			break;

		// Location.
		case 'ctc_location':

		 	// Gutenberg editor.
			if ( $block_editor ) {
				$placeholder = sprintf(
					/* translators: %1$s is "Location" (singular) word, possibly changed by translation. Always use %1$s and not "Location" */
					__( '%s Name', 'church-theme-content' ),
					 ctc_post_type_label( 'ctc_location', 'singular' )
				);
			}

			// Classic editor.
			else {
				$placeholder = $enter_name_here; // "location name" is more common than "location title".
			}

			// Classic editor unchanged.

			break;

		// Person.
		case 'ctc_person':

		 	// Gutenberg editor.
			if ( $block_editor ) {
				$placeholder = sprintf(
					/* translators: %1$s is "Person" (singular) word, possibly changed by translation. Always use %1$s and not "Person" */
					__( "%s's Name", 'church-theme-content' ),
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
 * @since 1.9
 * @param string $placeholder Default body placeholder
 * @return string Modified placeholder
 */
function ctc_body_placeholder( $placeholder ) {

	$placeholder = __( 'Add content', 'church-theme-content' );

	return $placeholder;

}

add_filter( 'write_your_story', 'ctc_body_placeholder' );

/*******************************************
 * HELPERS
 *******************************************/

/**
 * Check if block editor (Gutenberg) is in use on add/edit screen.
 *
 * @since 1.9
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

