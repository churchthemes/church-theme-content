/**
 * Map after fields on event and location screen
 */

jQuery( document ).ready( function( $ ) {

	// Only if map container exists
	if ( ! $( '#ctc-map-after-fields' ).length ) {
		return;
	}

	/**************************************
	 * SHOW MAP
	 **************************************/

	// REPLACE THIS WITH ACTUAL COORDS, ETC.
	// NEED TO LOCALIZE FOR DEFAULT TYPE AND ZOOM

	var map;

	map = new google.maps.Map( document.getElementById( 'ctc-map-after-fields' ), {
		center: {
			lat: -34.397,
			lng: 150.644,
		},
		zoom: 8,
	} );

	/**************************************
	 * CHANGE MAP (based on field changes)
	 **************************************/

	$( '.ctc-map-field' ).bind( 'change', function() {

		console.log( 'fields changed, update map' );

	} );

	/**************************************
	 * CHANGE FIELDS (based on map changes)
	 **************************************/



} );
