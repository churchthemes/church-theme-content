<?php
/**
 * Admin Feature Support
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2013 - 2024, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*********************************************
 * ADMIN NOTICE
 *********************************************/

/**
 * Show admin notice
 *
 * Show a message if current theme does not support the plugin.
 *
 * @since 0.9
 */
function ctc_get_theme_support_notice() {

	// Theme does not support plugin
	if ( ! current_theme_supports( 'church-theme-content' ) ) {

		// Show only if user has some control over plugins and themes
		if ( ! current_user_can( 'activate_plugins' ) && ! current_user_can( 'switch_themes' ) ) {
			return;
		}

		// Show only on relavent pages as not to overwhelm admin
		$screen = get_current_screen();
		if ( ! in_array( $screen->base, array( 'themes', 'plugins' ) ) && ! preg_match( '/^ctc_.+/', $screen->post_type ) ) {
			return;
		}

		// Show except on discontinued Risen theme (in that case we show migration notice).
		if ( ctc_migrate_risen_show() ) {
			return;
		}

		// Option ID
		$theme_data = wp_get_theme();
		$option_id = 'ctc_hide_theme_support_notice-' . $theme_data['Template']; // unique to theme so if change, message shows again

		// Message has not been dismissed for this theme
		if ( ! get_option( $option_id  ) ) {

			// Nonce
			$nonce = wp_create_nonce( 'ctc_hide_theme_support_notice' );

			// Dismiss URL
			$dismiss_url = add_query_arg( [
				'ctc_hide_theme_support_notice' => '1',
				'ctc_hide_theme_support_notice_security' => $nonce
			] );

			?>
			<div class="notice notice-warning">
				<p>
					<?php
					printf(
						wp_kses(
							__( 'The <b>%1$s</b> theme does not support the <b>%2$s</b> plugin. <a href="%3$s" target="_blank">More Information</a>, <a href="%4$s">Dismiss</a>', 'church-theme-content' ),
							array(
								'b' => array(),
								'a' => array(
									'href' => array(),
									'target' => array(),
								)
							)
						),
						wp_get_theme(),
						CTC_NAME,
						'https://wordpress.org/plugins/church-theme-content/',
						esc_url( $dismiss_url )
					);
					?>
				</p>
			</div>
			<?php

		}

	}

}

add_action( 'admin_notices', 'ctc_get_theme_support_notice' );

/**
 * Dismiss admin notice
 *
 * Save data to keep message from showing on this theme.
 *
 * @since 0.9
 */
function ctc_hide_theme_support_notice() {

	// User requested dismissal
	if ( ! empty( $_GET['ctc_hide_theme_support_notice'] ) ) {

		// Check nonce
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET[ 'ctc_hide_theme_support_notice_security' ] ) ), 'ctc_hide_theme_support_notice' ) ) {
			return;
		}

		// Option ID
		$theme_data = wp_get_theme();
		$option_id = 'ctc_hide_theme_support_notice-' . $theme_data['Template']; // unique to theme so if change, message shows again

		// Mark notice for this theme as dismissed
		update_option( $option_id, '1' );

	}

}

add_action( 'admin_init', 'ctc_hide_theme_support_notice' ); // before admin_notices
