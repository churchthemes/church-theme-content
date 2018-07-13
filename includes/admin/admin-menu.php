<?php
/**
 * Admin Menu Functions
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2013 - 2018, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      0.9.3
 */

// No direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*******************************************
 * INSERTIONS
 *******************************************/

/**
 * Add links to setting pages into custom post type menus
 *
 * For example, add "Settings" and "Podcast" links to Sermons
 * linking to Church Content plugin settings tabs.
 *
 * @since 2.0
 * @global array $submenu Existing menu items.
 */
function ctc_add_settings_menu_links() {

	global $submenu;

	// Options page URI.
	$rand = rand( 0, 9999999 ); // assists reload when already on settings page (e.g. Sermons > Settings then Sermons > Podcast).
	$settings_page_uri = 'options-general.php?page=' . CTC_DIR . '&rand=' . $rand;

	// Capability.
	$capability = 'manage_options'; // role/capability with access.

	// Setting word for all post types.
	$settings_word = _x( 'Settings', 'custom post type menu', 'church-theme-content' );

	// Sermons.
	$key = 'edit.php?post_type=ctc_sermon';

		// Podcast.
		$submenu[ $key ][] = array(
			_x( 'Podcast', 'custom post type menu', 'church-theme-content' ),
			$capability,
			admin_url( $settings_page_uri . '#podcast' ),
		);

		// Settings.
		$submenu[ $key ][] = array(
			$settings_word,
			$capability,
			admin_url( $settings_page_uri . '#sermons' ),
		);

	// Events.
	$key = 'edit.php?post_type=ctc_event';

		// Settings.
		$submenu[ $key ][] = array(
			$settings_word,
			$capability,
			admin_url( $settings_page_uri . '#events' ),
		);

	// Locations.
	$key = 'edit.php?post_type=ctc_location';

		// Settings.
		$submenu[ $key ][] = array(
			$settings_word,
			$capability,
			admin_url( $settings_page_uri . '#locations' ),
		);

	// People.
	$key = 'edit.php?post_type=ctc_person';

		// Settings.
		$submenu[ $key ][] = array(
			$settings_word,
			$capability,
			admin_url( $settings_page_uri . '#people' ),
		);

}

add_action( 'admin_menu', 'ctc_add_settings_menu_links' );

/*******************************************
 * REORDERING
 *******************************************/

/**
 * Enable custom menu order
 *
 * Note ctc_reorder_admin_menu which does the actual ordering.
 *
 * @since 0.9
 */
function ctc_custom_menu_order() {
	return true;
}

add_filter( 'custom_menu_order', 'ctc_custom_menu_order' ); // enable custom menu order

/**
 * Friendly admin menu order
 *
 * Move Pages to top followed by Posts then custom post types.
 * Show Comments and Media at bottom.
 *
 * @since 0.9
 * @param array $menu_ord Menu data
 * @return array Modified $menu_ord
 */
function ctc_reorder_admin_menu( $menu_ord ) {

	// Move Pages before Posts
	ctc_move_admin_menu_item( $menu_ord, 'edit.php?post_type=page', 'edit.php', 'before' );

	// Move Comments and Media after the LAST CPT
	// This is in case some CPT's are not used or reordered
	$last_cpt = '';
	foreach ( $menu_ord as $item ) {
		if ( preg_match( '/^edit\.php\?post_type=/', $item ) ) {
			$last_cpt = $item;
		}
	}
	ctc_move_admin_menu_item( $menu_ord, 'upload.php', $last_cpt ); // Media Library - last
	ctc_move_admin_menu_item( $menu_ord, 'edit-comments.php', $last_cpt ); // Comments - second to last

	// Return manipulated menu array
	return $menu_ord;

}

add_filter( 'menu_order', 'ctc_reorder_admin_menu' );

/**
 * Function to move admin menu item before or after another
 *
 * Use this with custom_menu_order and menu_order filters.
 *
 * @since 0.9
 * @param array $menu_ord The original menu from menu_order filter
 * @param string $move_item Value of item in array to move
 * @param string $target_item Value of item in array to move $move_item before or after
 * @param string $position Position 'after' (default) or 'before' in which to place $move_item in relation to $target_item
 * @return array Modified $menu_ord
 */
function ctc_move_admin_menu_item( &$menu_ord, $move_item, $target_item, $position = 'after' ) {

	// make sure items given are in array
	if ( in_array( $move_item, $menu_ord ) && in_array( $target_item, $menu_ord ) ) {

		// get position of each item
		$move_key = array_search( $move_item, $menu_ord );
		$move_key_after = array_search( $target_item, $menu_ord );

		// move item before instead of after
		if ( 'before' == $position ) {
			$move_key_after = ( $move_key_after - 1 ) >= 0 ? ( $move_key_after - 1 ) : 0; // move after item before item to move after (unless item to move after is at very top)
		}

		// move one item directly after the other
		if ( $move_key < $move_key_after ) { // item to move is currently before item to move after
			$menu_ord = array_merge(
				array_slice( $menu_ord, 0, $move_key ), // everything before item being moved
				array_slice( $menu_ord, $move_key + 1, $move_key_after - $move_key ), // everything after item being moved through item to move after
				array( $menu_ord[$move_key] ), // add item to move after item to move after
				array_slice( $menu_ord, $move_key_after + 1 ) // everything after item to move after
			);
		} else if ( $move_key > $move_key_after ) { // item to move is currently after item to move directly after
			$menu_ord = array_merge(
				array_slice( $menu_ord, 0, $move_key_after + 1 ), // everything from item to move after and before
				array( $menu_ord[$move_key] ), // add item to move after item to move after
				array_slice( $menu_ord, $move_key_after + 1, $move_key - $move_key_after - 1 ), // everything after item to move after and before item to move
				array_slice( $menu_ord, $move_key + 1 ) // everything after item to move
			);
		}

		// if moving item before very first item, run again but with $move_item and $target_item inverted
		// there was no higher item to move after so we ran as normal and now swap the new two top items
		if ( 'before' == $position && 0 == $move_key_after ) {
			ctc_move_admin_menu_item( $menu_ord, $target_item, $move_item ); // run again with item to move and item to move after swapped
		}

	}

	// return manipulated menu or original menu if no manipulation done
	return apply_filters( 'ctc_move_admin_menu_item', $menu_ord, $menu_ord, $move_item, $target_item, $position );

}

/*******************************************
 * HIDING
 *******************************************/

/**
 * Hide sermons in admin area.
 *
 * Apply setting to hide post type in admin area.
 * Useful when not using a particular feature (e.g. using a third-party plugin.
 *
 * This filters post type registration arguments.
 *
 * @since 2.0
 * @param array $args Current post type arguments.
 * @return array Modified post type arguments.
 */
function ctc_admin_hide_sermons( $args ) {
	return ctc_admin_hide_post_type_args( 'sermons_admin_hide', $args );
}

add_filter( 'ctc_post_type_sermon_args', 'ctc_admin_hide_sermons' );

/**
 * Hide events in admin area.
 *
 * @since 2.0
 * @param array $args Current post type arguments.
 * @return array Modified post type arguments.
 */
function ctc_admin_hide_events( $args ) {
	return ctc_admin_hide_post_type_args( 'events_admin_hide', $args );
}

add_filter( 'ctc_post_type_event_args', 'ctc_admin_hide_events' );

/**
 * Hide locations in admin area.
 *
 * @since 2.0
 * @param array $args Current post type arguments.
 * @return array Modified post type arguments.
 */
function ctc_admin_hide_locations( $args ) {
	return ctc_admin_hide_post_type_args( 'locations_admin_hide', $args );
}

add_filter( 'ctc_post_type_location_args', 'ctc_admin_hide_locations' );

/**
 * Hide people in admin area.
 *
 * @since 2.0
 * @param array $args Current post type arguments.
 * @return array Modified post type arguments.
 */
function ctc_admin_hide_people( $args ) {
	return ctc_admin_hide_post_type_args( 'people_admin_hide', $args );
}

add_filter( 'ctc_post_type_person_args', 'ctc_admin_hide_people' );

/**
 * Update post type arguments array to hide in admin, when a setting is true.
 *
 * @since 2.0
 * @param string $setting Setting ID to check for true value on.
 * @param array $args Arguments to merge into.
 * @return array Modified post type arguments.
 */
function ctc_admin_hide_post_type_args( $setting, $args ) {

	// Setting is active.
	if ( ctc_setting( $setting ) ) {

		// Change post type registration arguments.
		$args['show_ui'] = false;
		$args['show_in_nav_menus'] = false;

	}

	return $args;

}
