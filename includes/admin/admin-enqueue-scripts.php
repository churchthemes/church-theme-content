<?php
/**
 * Admin JavaScript
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2014, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      1.2
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue Admin JavaScript
 *
 * @since 1.2
 */
function ctc_admin_enqueue_scripts() {

	$screen = get_current_screen();

	// Event Add / Edit
	if ( 'post' == $screen->base && 'ctc_event' == $screen->post_type ) { // don't enqueue unless needed

		// Enqueue JS
		wp_enqueue_script( 'ctc-admin-events', CTC_URL . '/' . CTC_JS_DIR . '/admin-events.js', array( 'jquery' ), CTC_VERSION ); // bust cache on update

		// Pass data to JS
		wp_localize_script( 'ctc-admin-events', 'ctc_events', array(
			'week_days' => ctc_week_days(), // to show translated week day after "On a specific week" dropdown
		) );

	}

}

add_action( 'admin_enqueue_scripts', 'ctc_admin_enqueue_scripts' ); // admin-end only
