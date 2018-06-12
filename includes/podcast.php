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
 * SETTINGS
 *********************************************/

/**
 * Default Podcast Title.
 *
 * Title to use when no podcast title saved in settings.
 *
 * Default is site name which is assumed to be church name.
 *
 * Not using sermon plural word because it's too early to show that in settings placeholder.
 * The user can easily change this from their church name to one of the examples "Grace Church Sermons" if they want.
 *
 * @since 1.9
 * @return string Default string.
 */
function ctc_podcast_title_default() {

	// Get site name.
	$site_name = get_bloginfo( 'name' ); // assumed to be church name.

	// Build default title string.
	$default = '';
	if ( 'WordPress Site' !== $site_name ) { // not default title
		$default = $site_name;
	}

	// Return filterable.
	return apply_filters( 'ctc_podcast_title_default', $default );

}

/**
 * Default Podcast Author.
 *
 * Author to use when no podcast author saved in settings.
 *
 * Default is site name which is assumed to be church name.
 *
 * @since 1.9
 * @return string Default string.
 */
function ctc_podcast_author_default() {

	// Get site name.
	$site_name = get_bloginfo( 'name' ); // assumed to be church name.

	// Build default title string.
	$default = '';
	if ( 'WordPress Site' !== $site_name ) { // not default title
		$default = $site_name;
	}

	// Return filterable.
	return apply_filters( 'ctc_podcast_author_default', $default );

}

/**
 * Default Podcast Subtitle.
 *
 * Subtitle to use when no subtitle saved in settings.
 *
 * Default is tagline from General Settings.
 *
 * @since 1.9
 * @return string Default string.
 */
function ctc_podcast_subtitle_default() {

	// Get tagline.
	$tagline = get_bloginfo( 'description' );

	// Build default string.
	$default = '';
	if ( 'Just another WordPress site' !== $tagline ) { // not default title.
		$default = $tagline;
	}

	// Return filterable.
	return apply_filters( 'ctc_podcast_subtitle_default', $default );

}

/**
 * Default Podcast Language.
 *
 * Language to use when no podcast language saved in settings.
 *
 * Default is from Settings > General.
 *
 * @since 1.9
 * @return string Default string.
 */
function ctc_podcast_language_default() {

	// Get language setting from Settings > General.
	$language = get_bloginfo( 'language' ); // assumed to be church name.

	// Build default string.
	$default = $language;

	// Return filterable.
	return apply_filters( 'ctc_podcast_language_default', $default );

}

/**
 * Default Podcast Link.
 *
 * URL used for link on podcast. Default is homepage.
 *
 * @since 1.9
 * @return string Default string.
 */
function ctc_podcast_link_default() {

	// Get homepage URL.
	$home_url = home_url();

	// Build default string.
	$default = trailingslashit( $home_url );

	// Return filterable.
	return apply_filters( 'ctc_podcast_link_default', $default );

}

/**
 * Default Podcast Copyright.
 *
 * Copyright notice to use when no copyright saved in settings.
 *
 * @since 1.9
 * @return string Default string.
 */
function ctc_podcast_copyright_default() {

	// Get site name.
	$site_name = get_bloginfo( 'name' ); // assumed to be church name.

	// Build default title string.
	$default = '';
	if ( $site_name && 'WordPress Site' !== $site_name ) { // have site name and not default title
		$default = '&copy; ' . $site_name;
	}

	// Return filterable.
	return apply_filters( 'ctc_podcast_copyright_default', $default );

}

/**
 * Default Podcast Limit.
 *
 * Limit to use when no limit saved in settings.
 *
 * Use posts_per_rss "Syndication feeds..." in Reading Settings as default.
 *
 * @since 1.9
 * @return string Default string.
 */
function ctc_podcast_limit_default() {

	// Get site name.
	$rss_limit = get_option( 'posts_per_rss' ); // assumed to be church name.

	// Build default title string.
	$default = $rss_limit;

	// Return filterable.
	return apply_filters( 'ctc_podcast_limit_default', $default );

}

/**
 * Podcast category options.
 *
 * Array of select options for podcast settings.
 *
 * Only iTunes subcategories relevant to Church Content plugin users are presented.
 * https://help.apple.com/itc/podcasts_connect/#/itc9267a2f12
 *
 * @since 1.9
 * @return array Key and value pairs.
 */
function ctc_podcast_category_options() {

	$options = array(
		'Religion & Spirituality|Christianity' => __( 'Christianity', 'podcast category', 'church-theme-content' ),
		'Government & Organizations|Non-Profit' => __( 'Non-Profit', 'podcast category', 'church-theme-content' ),
		'none' => __( 'None', 'podcast category', 'church-theme-content' ),
	);

	return apply_filters( 'ctc_podcast_category_options', $options );

}

/*********************************************
 * FEED
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
 * Add podcast feed.
 *
 * Register the custom podcast feed accessible at ctc_podcast_feed_url().
 *
 * @since 1.9
 */
function ctc_add_podcast_feed() {

	$feed_name = ctc_podcast_feed_name();

	add_feed( $feed_name, 'ctc_output_podcast_feed' );

}

add_action( 'init', 'ctc_add_podcast_feed' );

/**
 * Output podcast feed XML.
 *
 * Note: Do not rely on DOMDocument since not always available.
 *
 * @since 1.9
 * @return string Feed contents.
 */
function ctc_output_podcast_feed() {

	// Get settings.
	$title = ctc_setting( 'podcast_title' );

	// Set defaults.
	$title = empty( $title ) ? ctc_podcast_title_default() : $title;

	// Set content type and charset.
	header( 'Content-Type: ' . feed_content_type( 'rss2' ) . '; charset=' . get_option( 'blog_charset' ), true );

	// Buffer feed contents.
	ob_start();

	// Begin output.
	?>

<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
	xmlns:googleplay="http://www.google.com/schemas/play-podcasts/1.0"
	<?php do_action( 'rss2_ns' ); // Fires at the end of the RSS root to add namespaces. ?>
>

	<channel>

		<title><?php echo esc_html( $title ); ?></title>



	</channel>

</rss>

	<?php

	// Get XML.
	$xml = ob_get_contents();
	ob_end_clean(); // end buffer.

	// Filter XML.
	$xml = apply_filters( 'ctc_output_podcast_feed', $xml );

	// Trim XML.
	$xml = trim( $xml );

	// Output XML.
	echo $xml;

}

/*********************************************
 * HELPERS
 *********************************************/

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