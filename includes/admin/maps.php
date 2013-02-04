<?php
/**
 * Google Maps Functions
 *
 * This helps with setting up custom fields for meta boxes.
 */

/**********************************
 * MAP TYPE
 **********************************/

/**
 * Map Types Array
 */

if ( ! function_exists( 'ccm_gmaps_types' ) ) {

	function ccm_gmaps_types() {

		$types = array(
			'ROADMAP'	=> _x( 'Road', 'map', 'ccm' ),
			'SATELLITE'	=> _x( 'Satellite', 'map', 'ccm' ),
			'HYBRID'	=> _x( 'Hybrid', 'map', 'ccm' ),
			'TERRAIN'	=> _x( 'Terrain', 'map', 'ccm' )
		);
		
		return apply_filters( 'ccm_gmaps_types', $types );
	
	}
	
}

/**
 * Map Type Default
 */

function ccm_gmaps_type_default() {

	return apply_filters( 'ccm_gmaps_type_default', 'HYBRID' );

}
 
/**********************************
 * ZOOM LEVEL
 **********************************/
 
/**
 * Zoom Levels Array
 */

if ( ! function_exists( 'ccm_gmaps_zoom_levels' ) ) {

	function ccm_gmaps_zoom_levels() {

		$zoom_levels = array();
		
		$zoom_min = 1; // 0 is actually lowest but then it's detected as not set and reverts to default
		$zoom_max = 21;
		
		for ( $z = $zoom_min; $z <= $zoom_max; $z++ ) {
			$zoom_levels[$z] = $z;
		}
		
		return $zoom_levels;
	
	}
	
}

/**
 * Zoom Level Default
 */

function ccm_gmaps_zoom_level_default() {

	return apply_filters( 'ccm_gmaps_zoom_level_default', 14 );

}
