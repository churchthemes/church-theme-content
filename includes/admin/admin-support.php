<?php
/**
 * Admin Feature Support
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2013 - 2017, churchthemes.com
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

		// Option ID
		$theme_data = wp_get_theme();
		$option_id = 'ctc_hide_theme_support_notice-' . $theme_data['Template']; // unique to theme so if change, message shows again

		// Message has not been dismissed for this theme
		if ( ! get_option( $option_id  ) ) {

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
						esc_url( add_query_arg( 'ctc_hide_theme_support_notice', '1' ) )
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

		// Option ID
		$theme_data = wp_get_theme();
		$option_id = 'ctc_hide_theme_support_notice-' . $theme_data['Template']; // unique to theme so if change, message shows again

		// Mark notice for this theme as dismissed
		update_option( $option_id, '1' );

	}

}

add_action( 'admin_init', 'ctc_hide_theme_support_notice' ); // before admin_notices
