/**
 * Map after fields on event and location screen
 */

jQuery( document ).ready( function( $ ) {

	var map;

	// Only if map container exists
	if ( ! $( '#ctc-map-after-fields' ).length ) {
		return;
	}

	/**************************************
	 * INITIAL MAP
	 **************************************/

	// SHOW ONLY IF HAVE COORDS
	// NEED TO LOCALIZE FOR DEFAULT TYPE AND ZOOM


	map = new google.maps.Map( document.getElementById( 'ctc-map-after-fields' ), {
		center: {
			lat: -34.397,
			lng: 150.644,
		},
		zoom: 8,
		mapTypeId: google.maps.MapTypeId.HYBRID,
		disableDefaultUI: true, // form fields control zoom, type, etc.
		scrollwheel: false, // disable scroll zoom (mistake prone, let use Zoom field)
	} );

	/**************************************
	 * CHANGE MAP (based on field changes)
	 **************************************/

	$( '.ctc-map-field' ).bind( 'change', function() {

		// can bind PASTE too? That way when user pastes manual lat/lng
		// it will update map before unfocusing the input

		console.log( 'fields changed, update map' );

		// Adjust map

	} );

	/**************************************
	 * CHANGE FIELDS (based on map changes)
	 **************************************/



} );
