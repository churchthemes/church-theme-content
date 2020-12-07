/**
 * Plugin Settings
 */

jQuery(document).ready(function ($) {

	/**************************************
	 * PRO DISABLED
	 **************************************/

	// Add .ctc-pro-setting-inactive and .button-disabled to image button when image input readonly.
	if ($('#ctps-field-podcast_image').hasClass('ctc-setting-readonly')) {
		$('.ctps-upload-file', $('#ctps-field-podcast_image').parent('.ctps-section')).addClass('ctc-pro-setting-inactive button-disabled');
	}

	// Show notice when user engages field requiring Pro while Pro is inactive.
	// The Pro fields have readonly attribute so cannot be changed, but will be saved.
	$('.ctc-pro-setting-inactive').on('focus, click', function (e) {

		// Prevent clicks on links from having effect.
		e.preventDefault();

		// Remove previous instance of message before showing new.
		$('.ctc-pro-setting-inactive-message-inline').remove();

		// Get parent cell.
		var $field_container = $(this).parents('td');

		// Get message from section description.
		var $message = $('.ctc-pro-setting-inactive-message:visible').html();

		// Have message.
		if ($message) {

			// Copy message below field.
			$field_container.append('<span class="ctc-pro-setting-inactive-message-inline">' + $message + '</span>');

			// Fade it in.
			$('.ctc-pro-setting-inactive-message-inline').hide().fadeIn('fast');

		}

	});

	// Prevent checkbox/radio changes on inactive fields (due to missing theme support or Pro being required).
	// readonly attribute does not stop changes to checkbox states.
	$('input[type=checkbox].ctc-setting-readonly, input[type=radio].ctc-setting-readonly').on('click', function (e) {
		return false;
	});

	/**************************************
	 * PODCAST
	 **************************************/

	// Open Podcast section when "Podcast Settings" link clicked in Sermons section.
	$('.ctps-field-podcast_content a').on('click', function (e) {

		// Prevent regular click action.
		e.preventDefault();

		// Switch to Podcast tab.
		ctps_switch_section('podcast');

	});

	// Copy Feed URL to clipboard.
	var clipboard = new ClipboardJS('#ctc-copy-podcast-url-button', {

		// Get URL.
		text: function (trigger) {
			return $('#ctc-settings-podcast-feed-link').attr('href');
		}

	}).on('success', function (e) {

		// Show message.
		$('#ctc-podcast-url-copied').fadeIn('fast');

		// Hide message.
		setTimeout(function () {
			$('#ctc-podcast-url-copied').fadeOut('fast');
		}, 3000);

		// Stop click.
		return false;

	});

	// Stop click to # on Copy button.
	$('#ctc-copy-podcast-url-button').on('click', function (e) {
		e.preventDefault();
	});

});
