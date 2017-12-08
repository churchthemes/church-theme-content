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

		// Remove previous instance of message before showing new.
		$( '.ctc-pro-setting-inactive-message-inline' ).remove();

		// Get parent cell.
		var $field_container = $( this ).parents( 'td' );

		// Get message from section description.
		var $message = $( '.ctc-pro-setting-inactive-message:visible' ).html();

		// Copy message below field.
		$field_container.append( '<span class="ctc-pro-setting-inactive-message-inline">' + $message + '</span>' );

		// Fade it in.
		$( '.ctc-pro-setting-inactive-message-inline' ).hide().fadeIn( 'fast' );

	} );

	// Prevent checkbox changes on inactive fields (due to missin theme support or Pro being required).
	// readonly attribute does not stop changes to checkbox states.
	$( 'input[type=checkbox].ctc-setting-readonly' ).click( function( e ) {
		return false;
	} );


} );
