<?php
/**
 * Admin Fields
 *
 * Functions used in multiple areas of admin.
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2016, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      1.6
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*********************************************
 * CUSTOM FIELDS
 *********************************************/

/**
 * Coordinates Field
 *
 * Input field for coordinates with "Autofill" button.
 * Used with CT Meta Box's custom_field in Event and Location latitude/longitude fields.
 * Replaces standard text field. <input> is same but with the button on end.
 *
 * @since 1.6
 */
function ctc_coordinate_field( $data ) {

	// Text input from CT Meta Box
	$input = '<input type="text" ' . $data['common_atts'] . ' id="' . $data['esc_element_id'] . '" value="' . $data['esc_value'] . '" />';

	// Aufofill button
	$input .= ' <input type="button" value="' .  esc_attr_x( 'Get From Address', 'coordinate button', 'church-theme-content' ) . '" id="ctc-get-coordinates-button" class="button">';

	return $input;

}

add_action( 'admin_init', 'ctc_hide_theme_support_notice' ); // before admin_notices

/**
 * Process "Get From Address"
 *
 * Fill latitude/longitude fields when button clicked.
 * Uses Google Maps geocoding service.
 *
 * @since 1.6
 */
function ctc_get_coordinates_js() {

	$screen = get_current_screen();

	// Add/edit screen only
	if ( $screen->base != 'post') {
		return;
	}

	// Only event or location if theme supports necessary fields
	if (
		! in_array( $screen->post_type, array( 'ctc_event', 'ctc_location' ) )
		||
		(
			'ctc_event' == $screen->post_type
			&&
			! (
				ctc_field_supported( 'events', '_ctc_event_address' )
				&& ctc_field_supported( 'events', '_ctc_event_map_lat' )
				&& ctc_field_supported( 'events', '_ctc_event_map_lng' )
			)
		)
		||
		(
			'ctc_location' == $screen->post_type
			&&
			! (
				ctc_field_supported( 'locations', '_ctc_location_address' )
				&& ctc_field_supported( 'locations', '_ctc_location_map_lat' )
				&& ctc_field_supported( 'locations', '_ctc_location_map_lng' )
			)
		)
	) {
		return;
	}

	// JavaScript for click on "Get From Address" button
?>

<script type="text/javascript">

</script>

<?php

}

add_action( 'admin_print_footer_scripts', 'ctc_get_coordinates_js' ); // before admin_notices
