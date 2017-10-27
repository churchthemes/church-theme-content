<?php/** * Database Upgrades * * It is sometimes necessary to upgrade the database (posts and settings) after updating the plugin. * * @package    Church_Theme_Content * @subpackage Admin * @copyright  Copyright (c) 2014 - 2017 churchthemes.com * @link       https://github.com/churchthemes/church-theme-content * @license    GPLv2 or later * @since      1.2 */// No direct access.if ( ! defined( 'ABSPATH' ) ) {	exit;}/************************************************* * VERSIONS *************************************************//** * Upgrade Versions * * These versions require database upgrades. * Functions with names corresponding to versions are triggered when updating the plugin. * For example, updating from 1.2 to 1.3 with 1.3 in the array executes ctc_upgrade_1_3. * * @since 1.2 * @global object $wpdb */function ctc_upgrade_versions() {	// Versions requiring database upgrade, in sequential order.	// Add a function below that corresponds to this version.	$upgrade_versions = array(		// When modify database in upgrade routine, also consider ctc_after_import() in admin/import.php		'1.2', // hidden time fields.		'1.9', // ensure Recur Until is not earlier than Start Date.	);	// Ensure they are ordered sequentially, oldest to newest.	// Database changes likely build upon each other.	usort( $upgrade_versions, 'version_compare' );	return $upgrade_versions;}/** * Upgrade to 1.2 * * Version 1.2 introduced new time fields (visible and hidden). * This loops through all event posts and sets defaults. */function ctc_upgrade_1_2() {	// This will update hidden event DATETIME fields for easier sorting.	// This function can be run during any database upgrade.	// It sets defaults for fields not existing at initial release.	ctc_correct_all_events();}/** * Upgrade to 1.9 * * Version 1.9 started correcting Recur Until date. * This could prevent some back-compat issues relating to CT Recurrence 2.0 / php-rrule. */function ctc_upgrade_1_9() {	// This will empty Recur Until when no Start Date or when earlier than Start Date.	ctc_correct_all_events();}/************************************************* * ACTIONS *************************************************//** * Check Upgrade Necessity * * It may be necessary to upgrade the database from version to version. * This will check if upgrade(s) are necessary on every admin page load. * * @since 1.2 * @global object $wpdb */function ctc_check_upgrade() {	global $wpdb;	// Make sure runs only on admin end.	if ( ! is_admin() ) {		return;	}	// Version of plugin used before updating.	$old_version = get_option( 'ctc_version' );	// No old version value found.	// This could mean a first-time install was made (no upgrades necessary).	// Or, a plugin update from a version earlier than 1.2 was done (database upgrade necessary).	if ( ! $old_version ) {		// Are there posts using this plugin's custom post types in the database?		// If so, the plugin must have just been updated from a version earlier than 1.2.		// In this case, a database upgrade is necessary.		// Note: This check will only be run once ever (after installation or first upgrade to 1.2+).		$ctc_post_count = $wpdb->get_var(			$wpdb->prepare(				"					SELECT COUNT( * )					FROM {$wpdb->posts}					WHERE post_type IN( '%s', '%s', '%s', '%s' )				",				'ctc_sermon', // these four post types existed before 1.2, so no newer ones need to be counted.				'ctc_event',				'ctc_person',				'ctc_location'			)		);		if ( $ctc_post_count ) {			$old_version = '1.1.1'; // assume 1.1.1, the last version before database upgrades introduced in 1.2.		}		// Otherwise, treat this as a first-time plugin installation.		// In this case, no database upgrade is necessary because there is no data (set current version).		else {			$old_version = CTC_VERSION;		}		// Set the initial version number.		update_option( 'ctc_version', $old_version );	}	// Has plugin just been updated to new version?	// We know it did if old version in database is less than plugin's current version.	if ( version_compare( CTC_VERSION, $old_version, '>' ) ) {		ctc_run_upgrade( $old_version );	}}add_action( 'admin_init', 'ctc_check_upgrade' );/** * Run Necessary Upgrades * * Sequentially execute upgrade functions for one or more versions. * * @since 1.2 * @param string $old_version Version used before plugin update. */function ctc_run_upgrade( $old_version ) {	// Ensure the upgrade routine finishes.	ignore_user_abort( true );	if ( ctc_function_available( 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) { // check to avoid warnings.		set_time_limit( 0 );	}	// Get versions requiring database upgrade, in sequential order.	$upgrade_versions = ctc_upgrade_versions();	// Sequentially execute upgrade functions for older versions.	foreach ( $upgrade_versions as $upgrade_version ) {		// Do not run version's upgrade if it is older than version in database.		// The upgrade should have already run for that version, since it is in the database.		if ( version_compare( $old_version, $upgrade_version, '>=' ) ) {			continue;		}		// Do not run version's upgrade if it is newer than new plugin version.		// This would only happen plugin author specifies upgrade function with wrong number.		if ( version_compare( $upgrade_version, CTC_VERSION, '>' ) ) {			continue;		}		// Debug (also comment out update_option() for new version below).		//echo "<br>New Version: " . CTC_VERSION . ", Old Version: $old_version, Upgrade Function: $upgrade_version";		// Execute version's upgrade function.		// Example: 1.5.2 will execute ctc_upgrade_1_5_2().		$upgrade_version_clean = str_replace( '.', '_', $upgrade_version );		$function = 'ctc_upgrade_' . $upgrade_version_clean;		if ( function_exists( $function ) ) {			call_user_func( $function );		}	}	// Always flush rewrite rules in case post types or taxonomies added.	flush_rewrite_rules();	// Always update version number in the database, even if no upgrade function is run.	update_option( 'ctc_version', CTC_VERSION );}