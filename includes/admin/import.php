<?php
/**
 * Import Functions
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2013, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      1.0.1
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

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
