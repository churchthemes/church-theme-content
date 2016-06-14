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
	$input .= ' <input type="button" value="' .  esc_attr_x( 'Get From Address', 'coordinate button', 'church-theme-content' ) . '" class="button">';

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



}

add_action( 'wp_footer', 'ctc_get_coordinates_js' ); // before admin_notices
