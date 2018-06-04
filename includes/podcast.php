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
 * PODCAST SETTINGS
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

	$podcast_feed_url = 'https://feedurl';

	return apply_filters( 'ctc_podcast_feed_url', $podcast_feed_url );

}

/*********************************************
 * PODCAST FEED
 *********************************************/


