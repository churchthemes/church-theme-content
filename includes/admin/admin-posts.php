<?php
/**
 * Admin Post Functions
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

/**********************************
 * RESERVED POST SLUGS
 **********************************/

/**
 * Prevent post from using slug reserved for a post type archive
 *
 * If an identical slug is entered, it will be appended by a number.
 * For example, a 'sermons' page slug will become 'sermons-2'.
 *
 * This is broad but mainly intended for top-level pages.
 *
 * @since 0.9
 * @param string $current_value The current value
 * @param string $slug The slug to check
 * @return bool Whether or not post slug is valid
 */
function ctc_is_bad_post_slug( $current_value, $slug ) {

	// Get post types with archives
	$post_types = get_post_types( array(
		'has_archive' => true
	), 'objects' );

	// Check if post slug matches a post type rewrite slug
	foreach ( $post_types as $post_type ) {
		if ( ! empty( $post_type->rewrite['slug'] ) && $post_type->rewrite['slug'] == $slug ) {
			return true;
		}
	}

	return $current_value;

}

add_filter( 'wp_unique_post_slug_is_bad_flat_slug', 'ctc_is_bad_post_slug', 10, 2 );
add_filter( 'wp_unique_post_slug_is_bad_hierarchical_slug', 'ctc_is_bad_post_slug', 10, 2 );
