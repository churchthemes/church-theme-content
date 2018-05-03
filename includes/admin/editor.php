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
 * BLOCK EDITOR (GUTENBERG)
 **********************************/

/**
 * Change "Add Title" in block editor.
 */
function ctc_block_editor_title_placeholder( $placeholder ) {

	$screen = get_current_screen();

	if  ( 'ctc_person' === $screen->post_type ) {
		$placeholder = esc_html__( 'Add Name', 'church-theme-content' );
	}

	return $placeholder;

}

add_filter( 'enter_title_here', 'ctc_editor_title_text' );

/*
		'titlePlaceholder'    => apply_filters( 'enter_title_here', __( 'Add title', 'gutenberg' ), $post ),
  951: 		'bodyPlaceholder'     => apply_filters( 'write_your_story', __( 'Write your story', 'gutenberg' ),



  Sermon Title


  Person
  - Add Name (not "Add Title")


  "Add content"
*/

/**********************************
 * CLASSIC EDITOR
 **********************************/

/**
 * Change "Add Title" to "Add Name" when adding a person in block editor.
 *
 * Change "Enter title here" to "Enter name here" when adding person in classic editor.
 *
 * @since 0.9
 * @param string $title Default title placeholder
 * @return string Modified placeholder
 */
function ctc_person_title_text( $title ) {

	$screen = get_current_screen();

	// Person.
	if  ( 'ctc_person' === $screen->post_type ) {

		// Block Editor.
		if ( ctc_is_block_editor() ) {
			$title = esc_html__( 'Add Name', 'church-theme-content' );
		}

		// Classic Editor
		else {
			$title = esc_html__( 'Enter name here', 'church-theme-content' );
		}

	}

	return $title;

}

add_filter( 'enter_title_here', 'ctc_person_title_text' );

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

