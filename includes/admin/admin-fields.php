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

	// Error messages
	$error_no_address = __( 'Please enter an Address first.', 'church-theme-content' );
	$error_failed = __( 'Latitide and Longitude could not be determined from Address. Please check for errors or enter manually.', 'church-theme-content' );

	// JavaScript for click on "Get From Address" button
?>

<script type="text/javascript">

jQuery( document ).ready( function( $ ) {

	$( '#ctc-get-coordinates-button' ).click( function() {

		var address, error;

		// Address entered?
		address = $('textarea[id^="ctmb-input-_ctc_"][id$="_address"]').val().trim();
		if ( address ) {

			// Convert address to one line


			// Get coordinates from Google Maps geocoder


			// Failed to get coordinates
			//error = '<?php echo esc_js( $error_failed ); ?>';

		}

		// No address
		else {
			error = '<?php echo esc_js( $error_no_address ); ?>';
		}

		// Show error
		if ( error ) {
			alert( error );
		}

	} );

} );

</script>

<?php

}

add_action( 'admin_print_footer_scripts', 'ctc_get_coordinates_js' ); // before admin_notices
