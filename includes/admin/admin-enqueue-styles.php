<?php
/**
 * Admin Styles
 *
 * Enqueue stylesheets for admin area.
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
 * Enqueue Admin Styles
 *
 * @since 1.0
 * @global object $ctc_settings
 */
function ctc_admin_enqueue_styles() {

	global $ctc_settings;

	// Plugin Settings
	if ( $ctc_settings->is_settings_page() ) { // only on Plugin Settings page
		wp_enqueue_style( 'ctc-settings', CTC_URL . '/' . CTC_CSS_DIR . '/settings.css', false, CTC_VERSION ); // bust cache on update
	}

}

add_action( 'admin_enqueue_scripts', 'ctc_admin_enqueue_styles' ); // admin-end only
