<?php
/**
 * Dashboard Functions
 *
 * Manipulate the WordPress dashboard screen.
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2017, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      1.8
 */

// No direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*************************************************
 * AT A GLANCE
 *************************************************/

/**
 * Add our custom post types to "At a Glance" on the Dashboard.
 *
 * Based on code from Hugh Lashbrooke: https://hugh.blog/2014/02/26/wordpress-add-items-glance-widget/
 *
 * @since 1.8
 * @param array $items Empty array to add to.
 * @return array Array with additional items.
 */
function ctc_glance_add_post_types( $items ) {

	// Post types to show.
	$post_types = array(
		'ctc_sermon',
		'ctc_event',
		'ctc_person',
		'ctc_location',
	);

	// Loop post types.
	foreach ( $post_types as $type ) {

		// Only if post type is registered.
		if ( ! post_type_exists( $type ) ) {
			continue;
		}

		// Get post counts (published, trash, etc.).
		$num_posts = wp_count_posts( $type );

		// Only if have count data.
		if ( $num_posts ) {

			// Count published posts to show.
			$published = intval( $num_posts->publish );

			// Get post type data.
			$post_type = get_post_type_object( $type );

			// Singular or plural label based on published post count.
			if ( 1 === $published ) {
				$text = number_format_i18n( $published ) . ' ' . $post_type->labels->singular_name;
			} else {
				$text = number_format_i18n( $published ) . ' ' . $post_type->labels->name;
			}

			// Show linked if user can edit posts.
			if ( current_user_can( $post_type->cap->edit_posts ) ) {
				$items[] = sprintf( '<a class="%1$s-count" href="edit.php?post_type=%1$s">%2$s</a>', $type, $text ) . "\n";
			} else { // Otherwise show unlinked.
				$items[] = sprintf( '<span class="%1$s-count">%2$s</span>', $type, $text ) . "\n";
			}

		}

	}

	return $items;

}

add_filter( 'dashboard_glance_items', 'ctc_glance_add_post_types', 10, 1 );
