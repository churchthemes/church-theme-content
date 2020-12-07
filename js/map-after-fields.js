/**
 * Map after fields on event and location screen
 */

jQuery(document).ready(function ($) {

	/**************************************
	 * SHOW MAP
	 **************************************/

	// Show initial map
	ctc_show_map_after_fields();

	// Latitude/longitude change or keyup
	$('.ctc-map-lat-field, .ctc-map-lng-field').on('change keyup', function () {
		ctc_show_map_after_fields('coordinates');
	});

	// Latitude/longitude paste
	$('.ctc-map-lat-field, .ctc-map-lng-field').on('paste', function () {

		// Update map map after timeout
		setTimeout(function () {
			ctc_show_map_after_fields('coordinates');
		}, 250);

	});

	// Type change
	$('.ctc-map-type-field').on('change', function () {
		ctc_show_map_after_fields('type');
	});

	// Zoom change
	$('.ctc-map-zoom-field').on('input', function () { // do it as user drags, not just on release (change)
		ctc_show_map_after_fields('zoom'); // zoom only so user can drag/zoom to manually click
	});

	/**************************************
	 * GEOCODE ADDRESS
	 **************************************/

	// Click "Get From Address" button
	$('#ctc-get-coordinates-button').on('click', function () {

		var address;

		// Show alert if no API Key
		if (!ctc_map_after_fields_data.has_api_key) {

			alert(ctc_map_after_fields_data.missing_key_message);

			// Don't attempt geocoding
			return;

		}

		// Get address
		address = $('.ctc-address-field').val(); // event or location
		address = $("<div/>").html(address).text(); // remove HTML
		address = address.replace(/\r?\n/g, ', '); // replace line breaks with commas
		address = address.trim(); // remove whitespace

		// Have address
		if (address) {

			// Geocode address
			geocoder = new google.maps.Geocoder();
			geocoder.geocode({
				'address': address
			}, function (results, status) {

				var coordinates;

				// Success
				if (google.maps.GeocoderStatus.OK == status) {

					// Update Latitude and Longitude fields
					$('.ctc-map-lat-field').val(results[0].geometry.location.lat);
					$('.ctc-map-lng-field').val(results[0].geometry.location.lng);

					// Map not showing (new Add), show it based on fields
					if (!$('#ctc-map-after-fields-container').is(':visible')) {
						ctc_show_map_after_fields();
					}

					// Map showing, just update it by moving marker/center
					else {

						// Get coordinates
						coordinates = results[0].geometry.location;

						// Move marker and recenter
						ctc_map_after_fields_marker.setPosition(coordinates);
						ctc_map_after_fields.panTo(coordinates);

					}

				}

				// Failure
				else {

					// Give instructions
					alert(ctc_map_after_fields_data.get_from_address_failed);

				}

			});

		}

		// No address, show alert
		else {
			alert(ctc_map_after_fields_data.missing_address);
		}

	});

});

/**************************************
 * FUNCTIONS
 **************************************/

// Show Map
function ctc_show_map_after_fields(update) {

	var lat, lng, zoom, type, coordinates, click_timeout;

	// Only if map container exists
	if (!jQuery('#ctc-map-after-fields-container').length) {
		return;
	}

	// Get Coordinates
	lat = parseFloat(jQuery('.ctc-map-lat-field').val());
	lng = parseFloat(jQuery('.ctc-map-lng-field').val());

	// Get Type
	type = 'ROAD'; // default if no type field
	if (jQuery('.ctc-map-type-field').length) { // field supported
		type = jQuery('.ctc-map-type-field:checked').val();
	}

	// Get Zoom
	zoom = 14; // default if no zoom field
	if (jQuery('.ctc-map-zoom-field').length) { // field supported
		zoom = parseFloat(jQuery('.ctc-map-zoom-field').val());
	}

	// Latitude and Longitude entered
	if (lat && lng) {

		// Coordinates
		coordinates = { lat: lat, lng: lng };

		// Map not showing (new Add), show it based on fields
		if (!jQuery('#ctc-map-after-fields-container').is(':visible')) {

			// Show map container
			// Show container first because hidden div has no size
			// Doing this first prevents empty gray map in some cases
			jQuery('#ctc-map-after-fields-container').show();

			// Render map first time
			ctc_map_after_fields = new google.maps.Map(document.getElementById('ctc-map-after-fields'), {
				center: coordinates,
				zoom: zoom,
				mapTypeId: google.maps.MapTypeId[type],
				disableDefaultUI: true, // form fields control zoom, type, etc.
				scrollwheel: false, // disable scroll zoom (mistake prone, let use Zoom field)
				clickableIcons: false, // place names interfere with manual location clicking
			});

			// Add marker to new map
			ctc_map_after_fields_marker = new google.maps.Marker({
				position: coordinates,
				map: ctc_map_after_fields,
			});

			// Move marker to point clicked
			click_timeout = null;
			ctc_map_after_fields.addListener('click', function (event) {

				click_timeout = setTimeout(function () {

					// Move marker
					ctc_map_after_fields_marker.setPosition(event.latLng);

					// Center on marker
					setTimeout(function () {
						ctc_map_after_fields.panTo(event.latLng);
					}, 200);

					// Update Latitude/Longitude fields
					jQuery('.ctc-map-lat-field').val(event.latLng.lat());
					jQuery('.ctc-map-lng-field').val(event.latLng.lng());

				}, 200);

			});

			// Prevent single click from being triggered on double click
			ctc_map_after_fields.addListener('dblclick', function () {
				clearTimeout(click_timeout);
			});

			// Make double click to zoom update Zoom field
			ctc_map_after_fields.addListener('zoom_changed', function () {
				jQuery('.ctc-map-zoom-field').val(ctc_map_after_fields.getZoom());
			});

		}

		// Map already showing, just update it by adjusting zoom, type and moving marker/center
		else {

			// Adjust type
			if (update == 'type' || !update) {
				ctc_map_after_fields.setMapTypeId(google.maps.MapTypeId[type]);
			}

			// Adjust zoom
			if (update == 'zoom' || !update) {
				ctc_map_after_fields.setZoom(zoom);
			}

			// Move marker and recenter
			if (update == 'coordinates' || !update) {
				ctc_map_after_fields_marker.setPosition(coordinates);
				ctc_map_after_fields.panTo(coordinates);
			}

		}

	}

	// Hide map container if no lat/lng
	else {
		jQuery('#ctc-map-after-fields-container').hide();
	}

}
