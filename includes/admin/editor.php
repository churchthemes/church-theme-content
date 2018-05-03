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

/**********************************
 * CLASSIC EDITOR
 **********************************/

/**
 * Change "Enter title here" to "Enter name here" when adding person in classic editor.
 *
 * @since 0.9
 * @param string $title Default title placeholder
 * @return string Modified placeholder
 */
function ctc_person_title_text( $title ) {

	$screen = get_current_screen();

	if  ( 'ctc_person' === $screen->post_type ) {
		$title = esc_html__( 'Enter name here', 'church-theme-content' );
	}

	return $title;

}

add_filter( 'enter_title_here', 'ctc_person_title_text' );
