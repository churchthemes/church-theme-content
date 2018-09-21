<?php
/**
 * Dashboard Functions
 *
 * Manipulate the WordPress dashboard screen.
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2017, ChurchThemes.com
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

	// Get Church Content plugin features / post types.
	$ctc_features = ctc_get_feature_data();

	// Loop features / post types.
	foreach ( $ctc_features as $feature => $feature_data ) {

		// Get post type.
		$post_type = $feature_data['post_type'];

		// Only if features is supported and post type is registered.
		if ( ! ctc_feature_supported( $feature ) || ! post_type_exists( $post_type ) ) {
			continue;
		}

		// Get post counts (published, trash, etc.).
		$num_posts = wp_count_posts( $post_type );

		// Only if have count data.
		if ( $num_posts ) {

			// Count published posts to show.
			$published = intval( $num_posts->publish );

			// Get post type data.
			$post_type_data = get_post_type_object( $post_type );

			// Singular or plural label based on published post count.
			if ( 1 === $published ) {
				$text = number_format_i18n( $published ) . ' ' . $post_type_data->labels->singular_name;
			} else {
				$text = number_format_i18n( $published ) . ' ' . $post_type_data->labels->name;
			}

			// Show linked if user can edit posts.
			if ( current_user_can( $post_type_data->cap->edit_posts ) ) {
				$items[] = sprintf( '<a class="%1$s-count" href="edit.php?post_type=%1$s">%2$s</a>', $post_type, $text ) . "\n";
			} else { // Otherwise show unlinked.
				$items[] = sprintf( '<span class="%1$s-count">%2$s</span>', $post_type, $text ) . "\n";
			}

		}

	}

	return $items;

}

add_filter( 'dashboard_glance_items', 'ctc_glance_add_post_types', 10, 1 );

/*************************************************
 * NEWS
 *************************************************/

/**
 * Show ChurchThemes.com feed items in News widget.
 *
 * @since 2.0
 */
function ctc_dashboard_news() {

	// Must be enabled in settings.
	if ( ctc_setting( 'dashboard_news' ) ) {

		// Create an instance.
		new CTC_Dashboard_News();

	}

}

add_filter( 'admin_init', 'ctc_dashboard_news' );
