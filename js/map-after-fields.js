/**
 * Map after fields on event and location screen
 */

jQuery( document ).ready( function( $ ) {

	// Only if map container exists
	if ( ! $( '#ctc-map-after-fields' ).length ) {
		return;
	}

	// Show initial map
	ctc_show_map_after_fields();

	// Update map based on field changes
	$( '.ctc-map-field' ).bind( 'change', function() {

		// can bind PASTE too? That way when user pastes manual lat/lng
		// it will update map before unfocusing the input

		// Update map
		ctc_show_map_after_fields();

	} );

} );

// Show Map
function ctc_show_map_after_fields() {

	var map;

	// Get Coordinates
	lat = jQuery( '#ctmb-input-_ctc_location_map_lat' ).val();
	lng = jQuery( '#ctmb-input-_ctc_location_map_lng' ).val();

	// Get Zoom
	zoom = 14; // default if no zoom field
	if ( jQuery( '#ctmb-input-_ctc_location_map_zoom' ).length ) {
		zoom = jQuery( '#ctmb-input-_ctc_location_map_zoom' ).val();
	}

	// Get Type
	type = 'ROAD'; // default if no type field
	if ( jQuery( '#ctmb-input-_ctc_location_map_type' ).length ) {
		type = jQuery( '#ctmb-input-_ctc_location_map_type' ).val();
	}

	// Latitude and Longitude entered
	if ( lat && lng ) {

		// Show map container
		jQuery( '#ctc-map-after-fields' ).show();

		// Render map
		map = new google.maps.Map( document.getElementById( 'ctc-map-after-fields' ), {
			center: {
				lat: parseFloat( lat ),
				lng: parseFloat( lng ),
			},
			zoom: parseFloat( zoom ),
			mapTypeId: google.maps.MapTypeId[type],
			disableDefaultUI: true, // form fields control zoom, type, etc.
			scrollwheel: false, // disable scroll zoom (mistake prone, let use Zoom field)
		} );

	}

	// Hide map container if no lat/lng
	else {
		jQuery( '#ctc-map-after-fields' ).hide();
	}

}
