/**
 * Plugin Settings
 */

jQuery( document ).ready( function( $ ) {

	// Open Podcasting section when "Podcasting Settings" link clicked in Sermons section.
	$( '#ctps-content-podcasting_shortcut a' ).click( function( e ) {

		e.preventDefault();

		ctps_switch_section( 'podcasting' );

	} );

} );
