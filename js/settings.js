/**
 * Plugin Settings
 */

jQuery( document ).ready( function( $ ) {

	/**************************************
	 * SERMONS
	 **************************************/

	// Open Podcasting section when "Podcasting Settings" link clicked in Sermons section.
	$( '.ctps-field-podcasting_content a' ).click( function( e ) {

		// Prevent regular click action.
		e.preventDefault();

		// Switch to Podcasting tab.
		ctps_switch_section( 'podcasting' );

	} );

	/**************************************
	 * PRO SETTINGS
	 **************************************/

	// Show notice when user engages field requiring Pro while Pro is inactive.
	// The Pro fields have readonly attribute so cannot be changed, but will be saved.
	$( '.ctc-pro-setting-inactive' ).focus( function( e ) {

		console.log( 'tried change pro' );

	} );

	// Prevent checkbox changes on fields requiring Pro when Pro inactive.
	// readonly attribute does not stop changes to checkbox states.
	$( 'input[type=checkbox].ctc-pro-setting-inactive' ).click( function( e ) {
		return false;
	} );


} );
