/**
 * Map after fields on event and location screen
 */

jQuery( document ).ready( function( $ ) {

	/**************************************
	 * SHOW MAP
	 **************************************/

	// Map container exists
	if ( $( '#ctc-map-after-fields' ).length ) {

		var map;

		map = new google.maps.Map( document.getElementById( 'ctc-map-after-fields' ), {
			center: {
				lat: -34.397,
				lng: 150.644,
			},
			zoom: 8,
		} );

	}

} );
