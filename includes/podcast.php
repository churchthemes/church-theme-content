<?php
/**
 * Sermon Podcasting
 *
 * @package    Church_Theme_Content
 * @subpackage Functions
 * @copyright  Copyright (c) 2018, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      1.9
 */

// No direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*********************************************
 * FEED HELPERS
 *********************************************/

/**
 * Podcast feed URL
 *
 * Get the podcast feed URL.
 *
 * @since 1.9
 * @return string Feed URL
 */
function ctc_podcast_feed_url() {

	$feed_name = ctc_podcast_feed_name();
	$podcast_feed_url = get_feed_link( $feed_name );

	return apply_filters( 'ctc_podcast_feed_url', $podcast_feed_url );

}

/**
 * Podcast content supported?
 *
 * Determine if content necessary for podcast is supported by theme.
 * Sermon feature and audio field must be supported.
 *
 * Note that this does NOT consider whether or not Pro plugin is active or not.
 *
 * @since 1.9
 * @return bool True if supported.
 */
function ctc_podcast_content_supported() {

	$supported = false;

	// Audio field and thus sermon feature supported?
	if ( ctc_field_supported( 'sermons', '_ctc_sermon_audio' ) ) {
		$supported = true;
	}

	return apply_filters( 'ctc_podcast_content_supported', $supported );

}

/*********************************************
 * FEED GENERATION
 *********************************************/

/**
 * Podcast feed name.
 *
 * Filterable feed name used with add_feed() and get_feed_link().
 *
 * @since 1.9
 * @return string Feed name.
 */
function ctc_podcast_feed_name() {

	$name = 'sermon-podcast';

	return apply_filters( 'ctc_podcast_feed_name', $name );

}