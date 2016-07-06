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

	// Update map based on field changes
	$( '.ctc-map-field' ).bind( 'change', function() {

		// can bind PASTE too? That way when user pastes manual lat/lng
		// it will update map before unfocusing the input

		// Update map
		ctc_show_map_after_fields();

	} );

	/**************************************
	 * GEOCODE ADDRESS
	 **************************************/

	// Click "Get From Address" button
	$( '#ctc-get-coordinates-button' ).click( function() {

		var address;

		// Get address
		address = $( 'textarea[id^="ctmb-input-_ctc_"][id$="_address"]' ).val(); // event or location
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

				var marker;

				// Success
				if ( google.maps.GeocoderStatus.OK == status ) {

					// Add coordinates to fields
// DO IT

					// Remove old marker
// DO IT

					// Add marker
					marker = new google.maps.Marker( {
						map: ctc_map_after_fields,
						position: results[0].geometry.location
					} );

					// Re-center map
					ctc_map_after_fields.setCenter( results[0].geometry.location );

				}

				// Failure
				else {

					// Give instructions
					alert( 'Address could not be converted into Latitude and Longitude coordinates. Please check the address or manually click your location on the map below.' );
// WP LOCALIZE THIS

					// Show map zoomed out so they can manually click
// DO IT

				}
			} );

		}

		// No address, show alert
		else {
			alert( 'Please enter an Address above.' );
// WP LOCALIZE THIS
		}

	} );

} );

/**************************************
 * FUNCTIONS
 **************************************/

// Show Map
function ctc_show_map_after_fields() {

	var coordinates;

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
		var marker = new google.maps.Marker( {
			position: coordinates,
			map: ctc_map_after_fields,
		});

	}

	// Hide map container if no lat/lng
	else {
		jQuery( '#ctc-map-after-fields' ).hide();
	}

}
