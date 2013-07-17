<?php
/**
 * Admin Helpers
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2013, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*********************************
 * TAXONOMY TERMS
 *********************************/

/**
 * Get taxonomy term list for a post type with admin links
 *
 * @since 0.9
 * @param int $post_id Post ID to get term list for
 * @param string $taxonomy Taxonomy to get terms for
 * @return string Term list
 */
function ctc_admin_term_list( $post_id, $taxonomy ) {

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

	return apply_filters( 'ctc_admin_term_list', $list, $post_id, $taxonomy );

}

/**********************************
 * GOOGLE MAPS
 **********************************/

/**
 * Google Map types array
 *
 * @since 0.9
 * @return array Google Maps API map types
 */
function ctc_gmaps_types() {

	$types = array(
		'ROADMAP'	=> _x( 'Road', 'map', 'church-theme-content' ),
		'SATELLITE'	=> _x( 'Satellite', 'map', 'church-theme-content' ),
		'HYBRID'	=> _x( 'Hybrid', 'map', 'church-theme-content' ),
		'TERRAIN'	=> _x( 'Terrain', 'map', 'church-theme-content' )
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
