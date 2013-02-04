<?php
/**
 * Admin CSS
 */

/*******************************************
 * ENQUEUE STYLESHEETS
 *******************************************/

/*
 * Enqueue admin stylesheets
 */
 
add_action( 'admin_enqueue_scripts', 'ccm_admin_enqueue_styles' );

function ccm_admin_enqueue_styles() {

	// none currently (ct-meta-box handles its own)

}

/*******************************************
 * BODY CLASSES
 *******************************************/

/*
 * Add helper classes to admin <body> for easier style tweaks (e.g. hiding "Preview" button per post type)
 */

add_filter( 'admin_body_class', 'ccm_admin_body_classes' );
 
function ccm_admin_body_classes( $classes ) {

	$screen = get_current_screen();
	$screen_keys = array( 'action', 'base', 'id', 'post_type', 'taxonomy' );
	
	foreach( $screen_keys as $screen_key ) {
	
		if ( ! empty( $screen->$screen_key ) ) {
			$classes .= 'ccm-screen-' . $screen_key . '-' . $screen->$screen_key . ' '; // space at end to prevent run-together
		}
	
	}
	
	return $classes;
	
}
