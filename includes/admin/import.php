<?php
/**
 * WordPress Importer
 *
 * It can useful to modify data after importing an XML file with the WordPress Importer plugin.
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2013 - 2018, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      1.0.1
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*************************************************
 * BEFORE IMPORT
 *************************************************/

/**
 * Prevent import if theme not active.
 *
 * This is to prevent any CT Framework recurring events grandfathering
 * from happening by activating the plugin, importing, then activating the theme
 * which would then grandfather based on sample content. Theme should be active
 * to make grandfathering decision first, before importing sample content.
 *
 * @since 2.0
 */
function ctc_prevent_import() {

	// Current theme does not support Church Content plugin.
	if ( ! current_theme_supports( 'church-theme-content' ) ) {

		?>

		<div class="notice notice-warning" style="margin-top: 20px">
			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %1$s is plugin name, %2$s is URL to plugin information */
						__( 'Please activate a theme compatible with the %1$s plugin before importing content. <a href="%2$s" target="_blank">More Information</a>', 'church-theme-content' ),
						array(
							'b' => array(),
							'a' => array(
								'href' => array(),
								'target' => array(),
							)
						)
					),
					CTC_NAME,
					'https://wordpress.org/plugins/church-theme-content/'
				);
				?>
			</p>
		</div>

		<?php

		// Stop import.
		exit;

	}

}

add_action( 'import_start', 'ctc_prevent_import' );

/*************************************************
 * AFTER IMPORT
 *************************************************/

/**
 * Set defaults after import
 *
 * A user may be importing old sample content or site export XML file while using up to date plugin.
 * This would mean the upgrade routine is not run because version in database is fine.
 *
 * Let's at least set defaults on custom fields to help make things smooth.
 * Later, if necessary, it may be useful to run entire upgrade routine if it is true that that will
 * not cause destruction if re-run.
 *
 * @since 1.0
 */
function ctc_after_import() {

	// Set defaults for event fields that did not always exist.
	// This will also cause Pro plugin's corrections to be made.
	ctc_correct_all_events();

}

add_action( 'import_end', 'ctc_after_import' ); // WordPress Importer plugin hook

/**
 * Update event recurrence
 *
 * Move recurring events up to date after import
 *
 * @since 1.0.1
 */
function ctc_import_recur_events() {

	// Force update even if recurrence not supported.
	// This is to keep sample content imports up to date when Pro not installed.
	$force = true;

	// Move recurring event dates forward.
	ctc_update_recurring_event_dates( $force );

}

add_action( 'import_end', 'ctc_import_recur_events' );
