<?php
/**
 * Admin Feature Support
 *
 * @package    Church_Content_Manager
 * @subpackage Admin
 * @copyright  Copyright (c) 2013, churchthemes.com
 * @link       https://github.com/churchthemes/church-content-manager
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
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
function ccm_get_theme_support_notice() {

	// Theme does not support plugin
	if ( ! current_theme_supports( 'church-content-manager' ) ) {

		// Show only if user has some control over plugins and themes
		if ( ! current_user_can( 'activate_plugins' ) && ! current_user_can( 'switch_themes' ) ) {
			return;
		}

		// Show only on relavent pages as not to overwhelm admin
		$screen = get_current_screen();
		if ( ! in_array( $screen->base, array( 'themes', 'plugins' ) ) && ! preg_match( '/^ccm_.+/', $screen->post_type ) ) {
			return;
		}

		// Option ID
		$theme_data = wp_get_theme();
		$option_id = 'ccm_hide_theme_support_notice-' . $theme_data['Template']; // unique to theme so if change, message shows again

		// Message has not been dismissed for this theme
		if ( ! get_option( $option_id  ) ) {
			
			?>
			<div class="error">
			   <p><?php printf( __( 'The <b>%1$s</b> theme does not support the <b>%2$s</b> plugin. <a href="%3$s" target="_blank">More Information</a>, <a href="%4$s">Dismiss</a>', 'church-content-manager' ), wp_get_theme(), CCM_NAME, CCM_INFO_URL, add_query_arg( 'ccm_hide_theme_support_notice', '1' ) ); ?></p>
			</div>
			<?php
			
		}
	
	}

}

add_action( 'admin_notices', 'ccm_get_theme_support_notice' );

/**
 * Dismiss admin notice
 *
 * Save data to keep message from showing on this theme.
 *
 * @since 0.9
 */
function ccm_hide_theme_support_notice() {

	// User requested dismissal
	if ( ! empty( $_GET['ccm_hide_theme_support_notice'] ) ) {

		// Option ID
		$theme_data = wp_get_theme();
		$option_id = 'ccm_hide_theme_support_notice-' . $theme_data['Template']; // unique to theme so if change, message shows again

		// Mark notice for this theme as dismissed
		update_option( $option_id, '1' );
			
	}

}

add_action( 'admin_init', 'ccm_hide_theme_support_notice' ); // before admin_notices