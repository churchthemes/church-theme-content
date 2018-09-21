<?php
/**
 * ChurchThemes.com Dashboard News.
 *
 * This adds posts from the ChurchThemes.com blog feed to the News dashboard widget.
 *
 * This is based heavily on the GPL-licensed AM_Dashboard_Widget_Extend_Feed by AwesomeMotive
 * as found in the Google Analytics for WordPress by Monster Insights plugin.
 *
 * https://wordpress.org/plugins/google-analytics-for-wordpress/
 *
 * @package    Church_Theme_Content
 * @author     ChurchThemes.com, AwesomeMotive Team
 * @license    GPLv2 or later
 * @copyright  Copyright (c) 2018, ChurchThemes.com, Awesome Motive LLC
 * @version    1.0
 */
class CTC_Dashboard_News {

	/**
	 * The number of feed items to show.
	 *
	 * @since 1.0
	 *
	 * @var int
	 */
	const FEED_COUNT = 6;

	/**
	 * Construct.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		// Actions.
		add_action( 'wp_feed_options', array( $this, 'dashboard_update_feed_urls' ), 10, 2 );

		// Filters.
		add_filter( 'dashboard_secondary_items', array( $this, 'dashboard_items_count' ) );

	}

	/**
	 * Set the number of feed items to show.
	 *
	 * @since 1.0
	 *
	 * @return int Count of feed items.
	 */
	public function dashboard_items_count() {

		// Allow filtering of count.
		$count = (int) apply_filters( 'ctc_dashboard_news_count', self::FEED_COUNT );

		return $count;

	}

	/**
	 * Update the planet feed to add other custom blog feed(s).
	 *
	 * @since 1.0
	 *
	 * @param object $feed SimplePie feed object (passed by reference).
	 * @param string $url URL of feed to retrieve (original planet feed url). If an array of URLs, the feeds are merged.
	 */
	public function dashboard_update_feed_urls( $feed, $url ) {

		global $pagenow;

		// Return early if not on the right page.
		if ( 'admin-ajax.php' !== $pagenow ) {
			return;
		}

		/**
		 * Return early if not on the right feed.
		 * We want to modify the feed URLs only for the
		 * WordPress Events & News Dashboard Widget
		 */
		if ( strpos( $url, 'planet.wordpress.org' ) === false ) {
			return;
		}

		// Build the feed sources.
		$all_feed_urls = $this->get_feed_urls( $url );

		// Update the feed sources.
		$feed->set_feed_url( $all_feed_urls );

	}

	/**
	 * Get the feed URL(s) to add.
	 *
	 * @since 1.0
	 *
	 * @param string $url Planet Feed URL.
	 *
	 * @return array Array of Feed URLs.
	 */
	public function get_feed_urls( $url ) {

		// Initialize the feeds array.
		$feed_urls = array(
			'https://churchthemes.com/feed/?dashboard_news=1', // ?dashboard_news=1 prepends "ChurchThemes.com: " to titles consistent with planet feed
			$url,
		);

		// Return the feed URL(s).
		return array_unique( $feed_urls );

	}

}
