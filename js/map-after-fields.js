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

	// Show initial map
	ctc_show_map_after_fields();

	// Update map as fields are changed
	$( '.ctc-map-field' ).bind( 'change keyup', function() {
		ctc_show_map_after_fields();
	} );

	// Update map based on latitude/longitude paste
	$( '.ctc-map-lat-field, .ctc-map-lng-field' ).bind( 'paste', function() {

		// Update map map after timeout
		setTimeout( function() {
			ctc_show_map_after_fields();
		}, 250 );

	} );

	/**************************************
	 * GEOCODE ADDRESS
	 **************************************/

	// Click "Get From Address" button
	$( '#ctc-get-coordinates-button' ).click( function() {

		var address;

		// Get address
		address = $( '.ctc-address-field' ).val(); // event or location
		address = $("<div/>").html( address ).text(); // remove HTML
		address = address.replace( /\r?\n/g, ', ' ); // replace line breaks with commas
		address = address.trim(); // remove whitespace

		// Have address
		if ( address ) {

			// Geocode address
	 		geocoder = new google.maps.Geocoder();
			geocoder.geocode( {
				'address': address
			}, function( results, status ) {

				var coordinates;

				// Success
				if ( google.maps.GeocoderStatus.OK == status ) {

					// Update Latitude and Longitude fields
					$( '.ctc-map-lat-field' ).val( results[0].geometry.location.lat );
					$( '.ctc-map-lng-field' ).val( results[0].geometry.location.lng );

					// Get coordinates
					coordinates = results[0].geometry.location;

					// Move marker
					ctc_map_after_fields_marker.setPosition( coordinates );

					// Re-center map
					ctc_map_after_fields.setCenter( coordinates );

				}

				// Failure
				else {

					// Give instructions
					alert( ctc_map_after_fields_data.get_from_address_failed );

					// Show map zoomed out so they can manually click when geocoding fails
// DO IT

				}

			} );

		}

		// No address, show alert
		else {
			alert( ctc_map_after_fields_data.missing_address );
		}

	} );

} );

/**************************************
 * FUNCTIONS
 **************************************/

// Show Map
function ctc_show_map_after_fields() {

	var lat, lng, zoom, type, coordinates;

	// Get Coordinates
	lat = jQuery( '.ctc-map-lat-field' ).val();
	lng = jQuery( '.ctc-map-lng-field' ).val();

	// Get Zoom
	zoom = 14; // default if no zoom field
	if ( jQuery( 'ctc-map-zoom-field' ).length ) {
		zoom = jQuery( 'ctc-map-zoom-field' ).val();
	}

	// Get Type
	type = 'ROAD'; // default if no type field
	if ( jQuery( '.ctc-map-type-field' ).length ) {
		type = jQuery( '.ctc-map-type-field' ).val();
	}

	// Latitude and Longitude entered
	if ( lat && lng ) {

		// Show map container
		jQuery( '#ctc-map-after-fields' ).show();

		// Coordinates
		coordinates = { lat: parseFloat( lat ), lng: parseFloat( lng ) };

		// Render map
		ctc_map_after_fields = new google.maps.Map( document.getElementById( 'ctc-map-after-fields' ), {
			center: coordinates,
			zoom: parseFloat( zoom ),
			mapTypeId: google.maps.MapTypeId[type],
			disableDefaultUI: true, // form fields control zoom, type, etc.
			scrollwheel: false, // disable scroll zoom (mistake prone, let use Zoom field)
		} );

		// Add marker
		ctc_map_after_fields_marker = new google.maps.Marker( {
			position: coordinates,
			map: ctc_map_after_fields,
		});

	}

	// Hide map container if no lat/lng
	else {
		jQuery( '#ctc-map-after-fields' ).hide();
	}

}
