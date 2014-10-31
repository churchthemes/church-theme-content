/**
 * Admin Events
 */

// DOM is fully loaded
jQuery( document ).ready( function( $ ) {

	/********************************************
	 * FIELDS
	 ********************************************/

	// Update other elements depending on Start Date
	// Do this on page load and when date is changed
	ctc_start_date_changed(); // on page load
	$( '#ctmb-field-_ctc_event_start_date select, #ctmb-field-_ctc_event_start_date input' ).bind( 'change keyup', ctc_start_date_changed );

} );

// Update other elements depending on Start Date
// Do this on page load and when date is changed
function ctc_start_date_changed() {

	var start_date_year, start_date_month, start_date_day, start_date, day_of_week_num, day_of_week;

	// Show or update Start Date's day of week after week of month dropdown
	start_date_month = jQuery( '#ctmb-input-_ctc_event_start_date-month' ).val();
	start_date_year = jQuery( '#ctmb-input-_ctc_event_start_date-year' ).val();
	start_date_day = jQuery( '#ctmb-input-_ctc_event_start_date-day' ).val();
	if ( ctc_checkdate( start_date_month, start_date_day, start_date_year ) ) { // change date on screen only if date is valid

		// Store unmodified option text before week day is appended
		jQuery( '#ctmb-input-_ctc_event_recurrence_monthly_week option' ).each( function() {
			if ( ! jQuery( this ).attr( 'data-ctc-text' ) ) {
				jQuery( this ).attr( 'data-ctc-text', jQuery( this ).text() );
			}
		} );

		// Get day of week
		start_date = new Date( start_date_year, start_date_month - 1, start_date_day ); // Months are 0 - 11
		day_of_week_num = start_date.getDay();
		day_of_week = ctc_events.week_days[ day_of_week_num ];

		// Show it after select option
		jQuery( '#ctmb-input-_ctc_event_recurrence_monthly_week option' ).each( function() {

			// Pass over "Select a Week"
			if ( jQuery( this ).val() && 'none' != jQuery( this ).val() ) {

				// Add day of week to option
				jQuery( this ).text(
					ctc_events.week_of_month_format
						.replace( '\{week\}', jQuery( this ).attr( 'data-ctc-text' ) ) // First, Third, etc.
						.replace( '\{day\}', day_of_week ) // localized Sunday, Monday, etc.
				);

			}

		} );

	}

}

// Check for valid date
// From http://phpjs.org/functions/checkdate/ (MIT License)
// original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
// improved by: Pyerre
// improved by: Theriault
function ctc_checkdate( m, d, y ) {
	return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= ( new Date( y, m, 0 ) ).getDate();
}
