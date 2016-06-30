<?php
/**
 * Google Maps
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2016, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
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
		'TERRAIN'	=> esc_html_x( 'Terrain', 'map', 'church-theme-content' )
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

	$zoom_min = 1; // 0 is actually lowest but then it's detected as not set and reverts to default
	$zoom_max = 21;

	for ( $z = $zoom_min; $z <= $zoom_max; $z++ ) {
		$zoom_levels[$z] = $z;
	}

	return apply_filters( 'ctc_gmaps_zoom_levels', $zoom_levels );

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
