<?php
/**
 * Admin Helpers
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2013 - 2017, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*********************************
 * TAXONOMY TERMS
 *********************************/

/**
 * Get taxonomy term list for a post type with admin links
 *
 * @since 0.9
 * @param int $post_id Post ID to get term list for
 * @param string $taxonomy Taxonomy to get terms for
 * @return string Term list
 */
function ctc_admin_term_list( $post_id, $taxonomy ) {

	$list = '';

	// Get taxonomy and output a list
	$terms = get_the_terms( $post_id, $taxonomy );

	if ( $terms && ! is_wp_error( $terms ) ) {

		$post_type = get_post_type( $post_id );

		$terms_array = array();

		foreach ( $terms as $term ) {
			$terms_array[] = '<a href="' . esc_url( admin_url( 'edit.php?' . $taxonomy . '=' . $term->slug  . '&post_type=' . $post_type ) ) . '"> ' . $term->name . '</a>';
		}

		$list = implode( ', ', $terms_array );

	}

	return apply_filters( 'ctc_admin_term_list', $list, $post_id, $taxonomy );

}

/*********************************
 * CONDITIONS
 *********************************/

/**
 * Is this a Church Content plugin-provided custom post type add/edit screen?
 *
 * Example: Adding a sermon or editing an event.
 *
 * @since 2.0
 * @global bool $multipage
 * @return bool True if current post has multiple pages
 */
function ctc_is_cpt_add_edit() {

	// Default result.
	$result = false;

	// Get current screen.
	$screen = get_current_screen();

	// Check of adding or editing a Church Content plugin-provided custom post type.
	if ( 'post' === $screen->base && preg_match( '/^ctc_.*$/', $screen->post_type ) ) {
		$result = true;
	}

	// Return filtered.
	return apply_filters( 'ctc_is_cpt_add_edit', $result );

}
