<?php
/**
 * Admin Helpers
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*********************************
 * TAXONOMY TERMS
 *********************************/

/**
 * Get taxonomy term list for a post type with admin links
 */

function ccm_admin_term_list( $post_id, $taxonomy ) {

	$list = '';

	// Get taxonomy and output a list
	$terms = get_the_terms( $post_id, $taxonomy );

	if ( $terms && ! is_wp_error( $terms ) ) {
	
		$post_type = get_post_type( $post_id );

		$terms_array = array();
		
		foreach ( $terms as $term ) {
			$terms_array[] = '<a href="' . esc_url( admin_url( 'edit.php?' . $taxonomy . '=' . $term->slug  . '&post_type=' . $post_type ) ) . '"> ' . $term->name . '</a>';
		}	
		
		$list = implode( ', ', $terms_array );
		
	}

	return apply_filters( 'ccm_admin_term_list', $list, $post_id, $taxonomy );

}

/**********************************
 * GOOGLE MAPS
 **********************************/

/**
 * Map Types Array
 */

function ccm_gmaps_types() {

	$types = array(
		'ROADMAP'	=> _x( 'Road', 'map', 'church-content-manager' ),
		'SATELLITE'	=> _x( 'Satellite', 'map', 'church-content-manager' ),
		'HYBRID'	=> _x( 'Hybrid', 'map', 'church-content-manager' ),
		'TERRAIN'	=> _x( 'Terrain', 'map', 'church-content-manager' )
	);
	
	return apply_filters( 'ccm_gmaps_types', $types );

}

/**
 * Map Type Default
 */

function ccm_gmaps_type_default() {

	return apply_filters( 'ccm_gmaps_type_default', 'HYBRID' );

}

/**
 * Zoom Levels Array
 */

function ccm_gmaps_zoom_levels() {

	$zoom_levels = array();
	
	$zoom_min = 1; // 0 is actually lowest but then it's detected as not set and reverts to default
	$zoom_max = 21;
	
	for ( $z = $zoom_min; $z <= $zoom_max; $z++ ) {
		$zoom_levels[$z] = $z;
	}
	
	return apply_filters( 'ccm_gmaps_zoom_levels', $zoom_levels );

}

/**
 * Zoom Level Default
 */

function ccm_gmaps_zoom_level_default() {

	return apply_filters( 'ccm_gmaps_zoom_level_default', 14 );

}