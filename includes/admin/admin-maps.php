<?php
/**
 * Google Maps
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2016 - 2017, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      1.7
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**********************************
 * HELPERS
 **********************************/

/**
 * Google Map types array
 *
 * @since 0.9
 * @return array Google Maps API map types
 */
function ctc_gmaps_types() {

	$types = array(
		'ROADMAP'	=> esc_html_x( 'Road', 'map', 'church-theme-content' ),
		'SATELLITE'	=> esc_html_x( 'Satellite', 'map', 'church-theme-content' ),
		'HYBRID'	=> esc_html_x( 'Hybrid', 'map', 'church-theme-content' ),
		'TERRAIN'	=> esc_html_x( 'Terrain', 'map', 'church-theme-content' ),
	);

	return apply_filters( 'ctc_gmaps_types', $types );

}

/**
 * Google Map type default
 *
 * @since 0.9
 * @return string Default map type
 */
function ctc_gmaps_type_default() {
	return apply_filters( 'ctc_gmaps_type_default', 'HYBRID' );
}

/**
 * Zoom levels array
 *
 * @since 0.9
 * @return array Valid Google Maps zoom levels
 */
function ctc_gmaps_zoom_levels() {

	$zoom_levels = array();

	$zoom_min = ctc_gmaps_zoom_min(); // 0 is actually lowest but then it's detected as not set and reverts to default
	$zoom_max = ctc_gmaps_zoom_max();

	for ( $z = $zoom_min; $z <= $zoom_max; $z++ ) {
		$zoom_levels[$z] = $z;
	}

	return apply_filters( 'ctc_gmaps_zoom_levels', $zoom_levels );

}

/**
 * Zoom maximum
 *
 * @since 1.7.1
 * @return int Google Maps zoom max
 */
function ctc_gmaps_zoom_max() {
	return apply_filters( 'ctc_gmaps_zoom_max', 21 );
}

/**
 * Zoom minimum
 *
 * @since 0.9
 * @return int Default Google Maps zoom level
 */
function ctc_gmaps_zoom_min() {
	return apply_filters( 'ctc_gmaps_zoom_min', 1 );
}

/**
 * Zoom level default
 *
 * @since 0.9
 * @return int Default Google Maps zoom level
 */
function ctc_gmaps_zoom_level_default() {
	return apply_filters( 'ctc_gmaps_zoom_level_default', 14 );
}

/**********************************
 * CONDITIONS
 **********************************/

/**
 * Adding/editing event/location with longitude and latitude fields support?
 *
 * @since 1.7.1
 * @return bool True if conditions met
 */
function ctc_has_lat_lng_fields() {

	// Get current screen
	$screen = get_current_screen();

	// Only on Add/Edit Location or Event
	if ( ! ( $screen->base == 'post' && in_array( $screen->post_type, array( 'ctc_event', 'ctc_location' ) ) ) ) {
		return false;
	}

	// Only if has latitude and longitude fields supported
	if (
		( 'ctc_event' == $screen->post_type && ( ! ctc_field_supported( 'events', '_ctc_event_map_lat' ) || ! ctc_field_supported( 'events', '_ctc_event_map_lng' ) ) )
		|| ( 'ctc_location' == $screen->post_type && ( ! ctc_field_supported( 'locations', '_ctc_location_map_lat' ) || ! ctc_field_supported( 'locations', '_ctc_location_map_lng' ) ) )
	) {
		return false;
	}

	return true;

}

/**********************************
 * API KEY NOTICE
 **********************************/

/**
 * Show missing Google Maps API Key notice
 *
 * The notice should only be shown if certain conditions are met.
 *
 * @since 1.7
 * @return bool True if notice should be shown
 */
function ctc_gmaps_api_key_show_notice() {

	$show = true;

	// Get current screen
	$screen = get_current_screen();

	// Only on List or Add/Edit Location or Event
	if ( ! ( in_array( $screen->base, array( 'edit', 'post' ) ) && in_array( $screen->post_type, array( 'ctc_event', 'ctc_location' ) ) ) ) {
		$show = false;
	}

	// Only if user can edit plugin settings
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Only if latitude and longitude fields supported.
	// Skip this test on list of events/locations, since ctc_has_lat_lng_fields() checks that screen is add/edit.
	if ( 'edit' !== $screen->base && ! ctc_has_lat_lng_fields() ) {
		return;
	}

	// Only if key not set
	if ( ctc_setting( 'google_maps_api_key' ) ) {
		$show = false;
	}

	// Only if not already dismissed
	if ( get_option( 'ctc_gmaps_api_key_notice_dismissed' ) ) {
		$show = false;
	}

	return $show;

}

/**
 * Show notice if Google Maps API Key missing
 *
 * This will show only on Add/Edit event or location screen if key is not set and user has permission to set it.
 *
 * @since 1.7
 */
function ctc_gmaps_api_key_notice() {

	// Only on Add/Edit Location or Event, key is not set, not already dismissed and latitude/longitude fields supported
	if ( ! ctc_gmaps_api_key_show_notice() ) {
		return;
	}

	// Show notice
	?>

	<div id="ctc-gmaps-api-key-notice" class="notice notice-warning is-dismissible">
		<p>
			<?php
			printf(
				wp_kses(
					/* translators: %1$s is URL for plugin settings */
					__( '<strong>Google Maps API Key Not Set.</strong> You must set it in <a href="%1$s">Church Content Settings</a> for maps to work.', 'church-theme-content' ),
					array(
						'strong' => array(),
						'a' => array(
							'href' => array(),
							'target' => array(),
						),
					)
				),
				esc_url( admin_url( 'options-general.php?page=' . CTC_DIR . '#locations' ) )
			);
			?>
		</p>
	</div>

	<?php

}

add_action( 'admin_notices', 'ctc_gmaps_api_key_notice' );

/**
 * JavaScript for remembering Google Maps API Key missing notice was dismissed
 *
 * The dismiss button only closes notice for current page view.
 * This uses AJAX to set an option so that the notice can be hidden indefinitely.
 *
 * @since 1.7
 */
function ctc_gmaps_api_key_dismiss_notice_js() {

	// Only on Add/Edit Location or Event, key is not set, not already dismissed and latitude/longitude fields supported
	if ( ! ctc_gmaps_api_key_show_notice() ) {
		return;
	}

	// Nonce
	$ajax_nonce = wp_create_nonce( 'ctc_gmaps_api_key_dismiss_notice' );

	// JavaScript for detecting click on dismiss button
	?>

	<script type="text/javascript">

	jQuery( document ).ready( function( $ ) {

		$( document ).on( 'click', '#ctc-gmaps-api-key-notice .notice-dismiss', function() {
			$.ajax( {
				url: ajaxurl,
				data: {
					action: 'ctc_gmaps_api_key_dismiss_notice',
					security: '<?php echo esc_js( $ajax_nonce ); ?>',
				},
			} );
		} );

	} );

	</script>

	<?php

}

add_action( 'admin_print_footer_scripts', 'ctc_gmaps_api_key_dismiss_notice_js' );

/**
 * Set option to prevent notice from showing again
 *
 * This is called by AJAX in ctc_gmaps_api_key_dismiss_notice_js()
 *
 * @since 1.7
 */
function ctc_gmaps_api_key_dismiss_notice() {

	// Only if is AJAX request
	if ( ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		return;
	}

	// Check nonce
	check_ajax_referer( 'ctc_gmaps_api_key_dismiss_notice', 'security' );

	// Only if user is privileged to use screen notice shown on and can edit plugin settings
	if ( ! ( current_user_can( 'edit_posts' ) && current_user_can( 'manage_options' ) ) ) {
		return;
	}

	// Update option so notice is not shown again
	update_option( 'ctc_gmaps_api_key_notice_dismissed', '1' );

}

add_action( 'wp_ajax_ctc_gmaps_api_key_dismiss_notice', 'ctc_gmaps_api_key_dismiss_notice' );

/**********************************
 * MAP AFTER FIELDS
 **********************************/

// These functions facilitate a map below related fields when editing a location or event

/**
 * Add map container after related fields
 *
 * User can click "Get From Address" to plot marker and autofill latitude/longitude.
 * They can also click on map to adjust latitude/longitude if geocoding is imperfect.
 *
 * @since 1.7.1
 * @param object $object CT Meta Box object
 */
function ctc_map_after_fields( $object ) {

	// Only on event or location's meta box having map fields
	if ( ! in_array( $object->meta_box['id'], array( 'ctc_event_location', 'ctc_location' ) ) ) {
		return;
	}

	// Only if latitude and longitude fields supported
	if ( ! ctc_has_lat_lng_fields() ) {
		return;
	}

	// Only if entered API Key
	// This will prevent confusion for new users (which require a key)
	// It will help old users (not requiring a key) set one up to ensure things remain smooth
	if ( ctc_setting( 'google_maps_api_key' ) ) {

		// Output map elements
		?>

		<div id="ctc-map-after-fields-container">

			<div id="ctc-map-after-fields"></div>

			<p id="ctc-map-after-fields-description" class="description">
				<?php esc_html_e( 'You may click the map to adjust your location (it is draggable and can be double-clicked to zoom).', 'church-theme-content' ); ?>
			</p>

		</div>

		<?php

	// Show message if no API key
	} else {

		?>

			<p class="description">

				<?php
				printf(
					wp_kses(
						/* translators: %1$s is URL for plugin settings */
						__( '<strong>Important:</strong> You must set your Google Maps API Key in <a href="%1$s" target="_blank">Church Content Settings</a> for maps to work.', 'church-theme-content' ),
						array(
							'strong' => array(),
							'a' => array(
								'href' => array(),
								'target' => array(),
							),
						)
					),
					esc_url( admin_url( 'options-general.php?page=' . CTC_DIR . '#locations' ) )
				);
				?>



			</p>

		<?php
	}

}

add_action( 'ctmb_after_fields', 'ctc_map_after_fields' );

/**
 * Add "Get From Address" button after latitude for geocoding via the map
 *
 * Used with CT Meta Box's custom_field in Event and Location latitude/longitude fields.
 * Replaces standard text field. <input> is same but with the button on end.
 *
 * @since 1.6
 */
function ctc_coordinate_field( $data ) {

	// Get current screen
	$screen = get_current_screen();

	// Text input from CT Meta Box
	$input = '<input type="text" ' . $data['common_atts'] . ' id="' . $data['esc_element_id'] . '" value="' . $data['esc_value'] . '" />';

	// Only if address field supported
	if (
		( 'ctc_event' == $screen->post_type && ! ctc_field_supported( 'events', '_ctc_event_address' ) )
		|| ( 'ctc_location' == $screen->post_type && ! ctc_field_supported( 'locations', '_ctc_location_address' ) )
	) {
		return $input;
	}

	// Only if latitude and longitude fields supported
	if ( ! ctc_has_lat_lng_fields() ) {
		return $input;
	}

	// Append aufofill button
	$input .= ' <input type="button" value="' .  esc_attr_x( 'Get From Address', 'coordinate button', 'church-theme-content' ) . '" id="ctc-get-coordinates-button" class="button">';

	// Return input with button
	return $input;

}
