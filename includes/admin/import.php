<?php
/**
 * WordPress Importer
 *
 * It can useful to modify data after importing an XML file with the WordPress Importer plugin.
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2013 - 2014, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      1.0.1
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

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

	// Set defaults for event fields that did not always exist
	ctc_set_events_defaults();

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

	ctc_update_recurring_event_dates();

}

add_action( 'import_end', 'ctc_import_recur_events' );
