<?php
/**
 * Admin Notice Functions
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2017, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since 2.0
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**********************************
 * ADMIN NOTICES
 **********************************/

/**
 * Content for PHP update notice when CT Recurrence class needs it.
 *
 * This is shown in admin notice via ctc_recurrence_php_notice().
 *
 * @since 2.0
 */
function ctc_recurrence_php_note() {

	$content = '';

	// Instantiate class.
	$ct_recurrence = new CT_Recurrence();

	// Show by default.
	$show = true;

	// Show notice only if PHP version is insufficient.
	if ( ! $ct_recurrence->php_is_old ) {
		$show = false;
	}

	// Show notice only if recurrence is enabled.
	if ( ! ctc_field_supported( 'events', '_ctc_event_recurrence' ) ) {
		$show = false;
	}

	// Show notice only on relevant screens.
	// Dashboard, events list and event add/edit.
	$screen = get_current_screen();
	if ( 'dashboard' !== $screen->base && 'ctc_event' !== $screen->post_type ) {
		$show = false;
	}

	// Show notice.
	if ( $show ) {

		$content = sprintf(
			wp_kses(
				/* translators: %1$s is minimum required version of PHP, %2$s is URL with information on updating PHP. */
				__( '<strong>Event recurrence is disabled.</strong> PHP %1$s or newer is required for recurrence to work. <a href="%2$s" target="_blank">Update PHP</a> to resolve.', 'church-theme-content' ),
				array(
					'strong' => array(),
					'a' => array(
						'href' => array(),
						'target' => array(),
					),
				)
			),
			esc_html( $ct_recurrence->php_min_version ),
			esc_url( ctc_ctcom_url( 'update-php', array( 'utm_content' => 'recurrence' ) ) )
		);

	}

	// Return.
	return apply_filters( '', $content );

}

/**
 * Show PHP update notice when CT Recurrence class needs it.
 *
 * CT Recurrence methods return empty when PHP version not satisfied.
 * Recurring events are treated as non-recurring until PHP is updated.
 *
 * @since 2.0
 */
function ctc_recurrence_php_notice() {

	// Get notice if it is to be shown.
	$notice = ctc_recurrence_php_note();

	// Have notice.
	if ( $notice ) {

		?>
		<div id="ctc-recurrence-php-notice" class="notice notice-error is-dismissible">
			<p>
				<?php echo $notice; ?>
			</p>
		</div>
		<?php

	}

}

add_action( 'admin_notices', 'ctc_recurrence_php_notice' );
