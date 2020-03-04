<?php
/**
 * Plugin Settings
 *
 * Setup and retrieve plugin settings. Also handles WordPress settings.
 *
 * @package    Church_Theme_Content
 * @copyright  Copyright (c) 2014 - 2020, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      1.2
 */

// No direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**********************************
 * SETTINGS SETUP
 **********************************/

/**
 * Settings config for CT Plugin Settings class.
 *
 * This is used by ctc_settings_setup() to make settings available to user.
 *
 * @since 2.0
 * @return array Settings array.
 */
function ctc_settings_config() {

	/**********************************
	 * SHARED
 	 **********************************/

	// Pro plugin is active.
	$pro_is_active = ctc_pro_is_active();

	// Default sermon post type wording and slug.
	// We get this from post type registration before the values are filtered.
	$sermon_cpt_args_unfiltered = ctc_post_type_sermon_args( 'unfiltered' );
	$sermon_word_singular_default = $sermon_cpt_args_unfiltered['labels']['singular_name'];
	$sermon_word_plural_default   = $sermon_cpt_args_unfiltered['labels']['name'];
	$sermon_url_slug_default = $sermon_cpt_args_unfiltered['rewrite']['slug'];

	// Default sermon taxonomy slugs.
	$sermon_topic_args_unfiltered = ctc_taxonomy_sermon_topic_args( 'unfiltered' );
	$sermon_series_args_unfiltered = ctc_taxonomy_sermon_series_args( 'unfiltered' );
	$sermon_book_args_unfiltered = ctc_taxonomy_sermon_book_args( 'unfiltered' );
	$sermon_speaker_args_unfiltered = ctc_taxonomy_sermon_speaker_args( 'unfiltered' );
	$sermon_tag_args_unfiltered = ctc_taxonomy_sermon_tag_args( 'unfiltered' );
	$sermon_topic_url_slug_default = $sermon_topic_args_unfiltered['rewrite']['slug'];
	$sermon_series_url_slug_default = $sermon_series_args_unfiltered['rewrite']['slug'];
	$sermon_book_url_slug_default = $sermon_book_args_unfiltered['rewrite']['slug'];
	$sermon_speaker_url_slug_default = $sermon_speaker_args_unfiltered['rewrite']['slug'];
	$sermon_tag_url_slug_default = $sermon_tag_args_unfiltered['rewrite']['slug'];

	// Default event post type slug.
	$event_cpt_args_unfiltered = ctc_post_type_event_args( 'unfiltered' );
	$event_url_slug_default = $event_cpt_args_unfiltered['rewrite']['slug'];

	// Default event category taxonomy slug.
	$event_category_args_unfiltered = ctc_taxonomy_event_category_args( 'unfiltered' );
	$event_category_url_slug_default = $event_category_args_unfiltered['rewrite']['slug'];

	// Default location post type slug.
	$location_cpt_args_unfiltered = ctc_post_type_location_args( 'unfiltered' );
	$location_url_slug_default = $location_cpt_args_unfiltered['rewrite']['slug'];

	// Default person post type slug.
	$person_cpt_args_unfiltered = ctc_post_type_person_args( 'unfiltered' );
	$person_url_slug_default = $person_cpt_args_unfiltered['rewrite']['slug'];

	// Default people group taxonomy slug.
	$person_group_args_unfiltered = ctc_taxonomy_person_group_args( 'unfiltered' );
	$person_group_url_slug_default = $person_group_args_unfiltered['rewrite']['slug'];

	// Feature support.
	$sermons_supported = ctc_feature_supported( 'sermons' );
	$events_supported = ctc_feature_supported( 'events' );
	$locations_supported = ctc_feature_supported( 'locations' );
	$people_supported = ctc_feature_supported( 'people' );

	// Structured Data field.
	$seo_field = array(
		'name'              => _x( 'Enhanced SEO', 'settings', 'church-theme-content' ),
		'after_name'        => '', // append (Optional) or (Pro), etc.
		'desc'              => sprintf(
			/* translators: %1$s is URL with information about SEO with JSON-LD */
			__( 'Automatic Search Engine Optimization (SEO) with Schema.org structured data using JSON-LD. <a href="%1$s" target="_blank">Learn More</a>', 'church-theme-content' ),
			esc_url( ctc_ctcom_url( 'seo-setting' ) )
		),
		'type'              => 'checkbox', // text, textarea, checkbox, checkbox_multiple, radio, select, number.
		'checkbox_label'    => '',
		'inline'            => false, // make radio inputs inline instead of stacked.
		'options'           => array(), // array of keys/values for radio or select.
		'upload_button'     => '', // text for button that opens media chooser.
		'upload_title'      => '', // title appearing at top of media chooser.
		'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
		'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
		'default'           => false, // value to pre-populate option with (before first save or on reset).
		'no_empty'          => false, // if user empties value, force default to be saved instead.
		'allow_html'        => false, // allow HTML to be used in the value.
		'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
		'class'             => '', // classes to add to input.
		'content'           => '', // custom content instead of input (HTML allowed).
		'custom_sanitize'   => '', // function to do additional sanitization.
		'custom_content'    => '', // function for custom display of field input.
		'pro'               => array( // field input element disabled when Pro not active.
			'default' => true, // default to use instead, when Pro plugin (Pro plugin will also set this on first installation).
		),
	);

	// URL Base field.
	/* translators: %1$s is default slug, %2$s is example URL showing how post type slug is used. */
	$url_slug_desc = __( 'Change "%1$s" in URLs. Example: <code>%2$s</code>', 'church-theme-content' );
	$url_slug_title = trailingslashit( sanitize_title( __( 'Title' ) ) ); // use core translation.
	$url_slug_name = trailingslashit( sanitize_title(
		/* translators: Appended as example event, location or person name in URL. Examples: https://yourname.com/events/name/ and https://yourname.com/people/name/ */
		_x( 'name', 'url slug setting', 'church-theme-content' ) ) // append /name/ to end of URL (use core translated string).
	);
	$url_slug_field = array(
		'name'              => '',
		'after_name'        => '', // append (Optional) or (Pro), etc.
		'desc'              => '',
		'type'              => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
		'checkbox_label'    => '', // show text after checkbox.
		'inline'            => false, // make radio inputs inline instead of stacked.
		'options'           => array(), // array of keys/values for radio or select.
		'upload_button'     => '', // text for button that opens media chooser.
		'upload_title'      => '', // title appearing at top of media chooser.
		'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
		'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
		'default'           => '', // value to pre-populate option with (before first save or on reset).
		'no_empty'          => false, // if user empties value, force default to be saved instead.
		'allow_html'        => false, // allow HTML to be used in the value.
		'attributes'        => array( // attr => value array (e.g. set min/max for number or range type).
			'maxlength' => '30',
		),
		'class'             => 'ctps-width-200', // classes to add to input.
		'content'           => '', // custom content instead of input (HTML allowed).
		'custom_sanitize'   => 'ctc_sanitize_setting_url_slug', // function to do additional sanitization.
		'custom_content'    => '', // function for custom display of field input.
		'pro'               => true, // field input element disabled when Pro not active.
	);

	// Taxonomy URL Base field.
	$taxonomy_url_slug_field = array(
		'name'              => '',
		'after_name'        => '', // append (Optional) or (Pro), etc.
		'desc'              => '',
		'type'              => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
		'checkbox_label'    => '', // show text after checkbox.
		'inline'            => false, // make radio inputs inline instead of stacked.
		'options'           => array(), // array of keys/values for radio or select.
		'upload_button'     => '', // text for button that opens media chooser.
		'upload_title'      => '', // title appearing at top of media chooser.
		'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
		'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
		'default'           => '', // value to pre-populate option with (before first save or on reset).
		'no_empty'          => false, // if user empties value, force default to be saved instead.
		'allow_html'        => false, // allow HTML to be used in the value.
		'attributes'        => array( // attr => value array (e.g. set min/max for number or range type).
			'maxlength' => '30',
		),
		'class'             => 'ctps-width-200', // classes to add to input.
		'content'           => '', // custom content instead of input (HTML allowed).
		'custom_sanitize'   => 'ctc_sanitize_setting_url_slug', // function to do additional sanitization.
		'custom_content'    => '', // function for custom display of field input.
		'pro'               => true, // field input element disabled when Pro not active.
	);

	// Hide in Admin Menu field.
	$hide_admin_field = array(
		'name'              => __( 'Hide in Admin', 'church-theme-content' ),
		'after_name'        => '', // append (Optional) or (Pro), etc.
		'desc'              => __( 'This can be useful if you are not using the feature.', 'church-theme-content' ),
		'type'              => 'checkbox', // text, textarea, checkbox, checkbox_multiple, radio, select, number.
		'checkbox_label'    => '',
		'inline'            => false, // make radio inputs inline instead of stacked.
		'options'           => array(), // array of keys/values for radio or select.
		'upload_button'     => '', // text for button that opens media chooser.
		'upload_title'      => '', // title appearing at top of media chooser.
		'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
		'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
		'default'           => false, // value to pre-populate option with (before first save or on reset).
		'no_empty'          => false, // if user empties value, force default to be saved instead.
		'allow_html'        => false, // allow HTML to be used in the value.
		'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
		'class'             => '', // classes to add to input.
		'content'           => '', // custom content instead of input (HTML allowed).
		'custom_sanitize'   => '', // function to do additional sanitization.
		'custom_content'    => '', // function for custom display of field input.
		'pro'               => false, // field input element disabled when Pro not active.
	);

	/**********************************
	 * SETTINGS
	 **********************************/

	// Podcast data.
	$podcast_supported = ctc_podcast_content_supported();
	$podcast_feed_url = ctc_podcast_feed_url();
	//$itunes_submit_url = 'https://podcastsconnect.apple.com/my-podcasts/new-feed?submitfeed=' . urlencode( $podcast_feed_url );
	//$google_submit_url = 'https://play.google.com/music/podcasts/publish';
	$itunes_submit_url = ctc_ctcom_url( 'podcast-submit-apple', array( 'url' => urlencode( $podcast_feed_url ) ) ); // e.g. https://churchthemes.com/go/apple-podcast-submit?url=https%3A%2F%2Fdev.churchthemes.local%2Fjubilee%2Ffeed%2Fsermon-podcast%2F
	$google_submit_url = ctc_ctcom_url( 'podcast-submit-google', array( 'url' => urlencode( $podcast_feed_url ) ) );
	$podcast_guide_url = ctc_ctcom_url( 'podcast-guide', array( 'utm_content' => 'settings' ) );

	// Podcast Feed URL link.
	$podcast_feed_link = '<a href="' . esc_url( $podcast_feed_url ) . '" target="_blank" id="ctc-settings-podcast-feed-link">' . esc_html( $podcast_feed_url ) . '</a>';
	if ( ! $pro_is_active || ! $podcast_supported ) { // linked only if Pro active and theme supports sermon audio.
		$podcast_feed_link = strip_tags( $podcast_feed_link );
	}

	// Podcast button classes (for Feed URL buttons and Update Enclosures button)
	$podcast_button_classes = 'button';
	if ( ! $pro_is_active ) {
		$podcast_button_classes = ' ctc-pro-setting-inactive button-disabled';
	} elseif ( ! $podcast_supported ) {
		$podcast_button_classes = ' button-disabled';
	}

	// Podcast Feed URL content.
	$podcast_feed_content  = '<div id="ctc-settings-podcast-feed-url">';
	$podcast_feed_content .= '	' . $podcast_feed_link;
	$podcast_feed_content .= '	<span id="ctc-podcast-url-copied">' . __( 'Copied to Clipboard', 'church-theme-content' ) . '</span>';
	$podcast_feed_content .= '</div>';
	$podcast_feed_content .= '<div id="ctc-settings-podcast-feed-buttons">';
	$podcast_feed_content .= '	<a href="#" id="ctc-copy-podcast-url-button" class="button ' . esc_attr( $podcast_button_classes ) . '" data-clipboard-text="' . esc_attr( $podcast_feed_url ) . '">' . _x( 'Copy', 'podcast feed URL', 'church-theme-content' ) . '</a>';
	$podcast_feed_content .= '	<a href="' . esc_url( $itunes_submit_url ) . '" class="button ' . esc_attr( $podcast_button_classes ) . '" target="_blank">' . __( 'Submit to iTunes', 'church-theme-content' ) . '</a>';
	$podcast_feed_content .= '	<a href="' . esc_url( $google_submit_url ) . '" class="button ' . esc_attr( $podcast_button_classes ) . '" target="_blank">' . __( 'Submit to Google Play', 'church-theme-content' ) . '</a>';
	$podcast_feed_content .= '</div>';

	// Event recurrence content and description.
	// Show different info depending on status of Church Content Pro or Custom Recurring Events plugin.
	$event_recurrence_desc = __( 'Save time by setting events to repeat automatically (e.g. "Every month on last Sunday except December 25").', 'church-theme-content' );
	if ( $pro_is_active ) { // Pro plugin active.

		$event_recurrence_content = _x( 'Enabled by <b>Church Content Pro</b> <span class="ctps-light ctps-italic">(Always On)</span>', 'recurrence setting', 'church-theme-content' );

	} elseif ( ctc_cre_is_active() ) { // Custom Recurring Events plugin active, not Pro.

		$event_recurrence_content = __( 'Partially Enabled by <b>Custom Recurring Events</b> Add-on', 'church-theme-content' );

		$event_recurrence_desc = sprintf(
			/* translators: %1$s is URL with info on upgrading from Custom Recurring Events to Church Content Pro */
			__( 'Upgrade to <a href="%1$s" target="_blank">Church Content Pro</a> for the complete set of recurrence and exclusion options.'),
			esc_url( ctc_ctcom_url( 'cre-to-pro', array( 'utm_content' => 'settings' ) ) )
		);

	} else { // No plugin active for recurring events.

		// We check CT Framework's grandfathering directly because it occurs after these settings are registered so ctc_field_supported() is unable to check for field support that has been added.
		$ctfw_grandfather_recurring_events = get_option( 'ctfw_grandfather_recurring_events' );

		// Basic recurrence enabled either by theme support or grandfathering.
		if ( ctc_field_supported( 'events', '_ctc_event_recurrence' ) || $ctfw_grandfather_recurring_events ) {

			$event_recurrence_content = __( 'Basic Recurrence Only <span class="ctps-light ctps-italic">(Pro Recurrence Inactive)</span>', 'church-theme-content' );

			$event_recurrence_desc = sprintf(
				/* translators: %1$s is URL for Church Content Pro */
				__( 'Install <a href="%1$s" target="_blank">Church Content Pro</a> for full recurrence (e.g. "Every month on last Sunday except December 25").'),
				esc_url( ctc_ctcom_url( 'church-content-pro', array( 'utm_content' => 'settings' ) ) )
			);

		}

		// No recurrence of any kind is enabled.
		else {

			$event_recurrence_content = sprintf(
				/* translators: %1$s is URL for Church Content Pro info */
				_x( 'Install <a href="%1$s" target="_blank">Church Content Pro</a> to Enable <span class="ctps-light ctps-italic">(Recommended)</span>', 'recurrence setting', 'church-theme-content' ),
				esc_url( ctc_ctcom_url( 'church-content-pro', array( 'utm_content' => 'settings' ) ) )
			);

		}

	}

	// Configuration.
	$config = array(

		// Master Option.
		// All settings will be saved as an array under this single option ID.
		'option_id' => 'ctc_settings',

		// Titles.
		'page_title' => sprintf(
			/* translators: %1$s is Church Content plugin URL, %2$s is add-ons URL */
			__( '%1$s Settings', 'church-theme-content' ),
			CTC_NAME
		),
		'menu_title' => CTC_NAME,

		// Settings page description.
		'desc' => sprintf(
			/* translators: %1$s is Church Content plugin URL, %2$s is URL to Customizer. */
			__( 'These settings are for the <a href="%1$s" target="_blank">Church Content</a> plugin. Use the <a href="%2$s">Customizer</a> for theme-provided appearance settings.', 'church-theme-content' ),
			esc_url( ctc_ctcom_url( 'church-content', array( 'utm_content' => 'settings' ) ) ),
			esc_url( admin_url( 'customize.php' ) )
		),

		// Plugin File
		'plugin_file' => CTC_FILE, // path to plugin's main file.

		// URL for CT Plugin Settings directory.
		// This is used for loading its CSS and JS files.
		'url' => CTC_URL . '/' . CTC_LIB_DIR . '/ct-plugin-settings',

		// Section Tabs.
		'sections' => array(

			// Licenses.
			'licenses' => array(

				// Title.
				'title' => _x( 'Licenses', 'settings', 'church-theme-content' ),

				// Description.
				'desc' => __( "Save then activate your add-on's license key to enable one-click updates.", 'church-theme-content' ),

				// Fields (Settings).
				// License key fields are filtered in.
				'fields' => array(

					// Church Content Pro.
					// Prompt to install it.
					'church_content_pro_note' => array(
						'name'              => _x( 'Church Content Pro', 'settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => sprintf(
							/* translators: %1$s is URL to Church Content Pro add-on. */
							__( 'Install the <a href="%1$s" target="_blank">Church Content Pro</a> add-on to enter its license key here.', 'church-theme-content' ),
							esc_url( ctc_ctcom_url( 'church-content-pro', array( 'utm_content' => 'settings' ) ) )
						),
						'type'              => 'content', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => '', // classes to add to input.
						'content'           => __( 'Not Installed', 'church-theme-content' ), // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => false, // field input element disabled when Pro not active.
						'unsupported'       => false, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Agency Mode.
					'agency_mode_note' => array(
						'name'              => _x( 'Agency Mode', 'settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => ctc_agency_mode_note(),
						'type'              => 'content', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => '', // classes to add to input.
						'content'           => _x( 'Disabled', 'agency mode', 'church-theme-content' ), // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => false, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

				),

			),

			// Sermons.
			'sermons' => array(

				// Title.
				'title' => _x( 'Sermons', 'settings section title', 'church-theme-content' ),

				// Description.
				'desc' => '',

				// Fields (Settings).
				'fields' => array(

					// Sermon Podcast (Shortcut).
					'podcast_content' => array(
						'name'             => _x( 'Sermon Podcast', 'settings', 'church-theme-content' ),
						'after_name'       => '', // append (Optional) or (Pro), etc.
						'desc'             => __( 'Set up your sermon podcast to reach more people automatically on iTunes, Google Play and elsewhere.', 'church-theme-content' ),
						'type'             => 'content', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'   => '', // show text after checkbox.
						'inline'           => false, // make radio inputs inline instead of stacked.
						'options'          => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'          => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'         => false, // if user empties value, force default to be saved instead.
						'allow_html'       => false, // allow HTML to be used in the value.
						'attributes'       => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'            => '', // classes to add to input.
						'content'          => __( '<a href="#">Podcast Settings</a>', 'church-theme-content' ), // custom content instead of input (HTML allowed).
						'custom_sanitize'  => '', // function to do additional sanitization.
						'custom_content'   => '', // function for custom display of field input.
						'pro'              => true, // field input element disabled when Pro not active.
						'unsupported'      => ! ctc_field_supported( 'sermons', '_ctc_sermon_audio' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Enhanced SEO.
					'sermons_seo' => array_merge( $seo_field, array(
						'checkbox_label' => __( 'Enable Structured Data for Sermons <span class="ctps-light ctps-italic">(Recommended)</span>', 'church-theme-content' ), // show text after checkbox.
						'unsupported'      => ! $sermons_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Alternative Wording - Singular
					'sermon_word_singular'  => array(
						'name'              => __( 'Alternative Wording', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => '',
						'type'              => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_word_singular_default, // show the standard value if they leave blank.
							'maxlength'   => '30',
						),
						'class'             => 'ctps-width-200', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $sermons_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Alternative Wording - Plural
					'sermon_word_plural' => array(
						'name'              => '',
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => sprintf(
							/* translators: %1$s is "Sermon" and %2$s is "Sermons" (translated). */
							__( 'Enter alternative wording for "%1$s" and "%2$s" (e.g. "Message" and "Messages").', 'church-theme-content' ),
							$sermon_word_singular_default,
							$sermon_word_plural_default
						),
						'type'              => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_word_plural_default, // show the standard value if they leave blank.
							'maxlength'   => '30',
						),
						'class'             => 'ctps-width-200', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $sermons_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Sermon URL Base (Slug).
					'sermon_url_slug' => array_merge( $url_slug_field, array(
						'name'              => __( 'Sermon URL Base', 'church-theme-content' ), // "Base" makes more sense to users than "Slug" and that's what it's called in Permalink settings, for consistency.
						'desc'              => sprintf(
							$url_slug_desc,
							$sermon_url_slug_default,
							ctc_make_url_slug_bold( $sermon_url_slug_default ) . $url_slug_title // make slug bold.
						),
						'attributes'        => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'       => ! $sermons_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Topic URL Base (Slug).
					'sermon_topic_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'              => __( 'Category URL Bases', 'church-theme-content' ),
						'desc'              => sprintf(
							$url_slug_desc,
							$sermon_topic_url_slug_default,
							ctc_make_url_slug_bold( $sermon_topic_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'        => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_topic_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'       => ! ctc_taxonomy_supported( 'sermons', 'ctc_sermon_topic' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Series URL Base (Slug).
					'sermon_series_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'        => '',
						'desc'        => sprintf(
							$url_slug_desc,
							$sermon_series_url_slug_default,
							ctc_make_url_slug_bold( $sermon_series_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'  => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_series_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported' => ! ctc_taxonomy_supported( 'sermons', 'ctc_sermon_series' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Book URL Base (Slug).
					'sermon_book_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'        => '',
						'desc'        => sprintf(
							$url_slug_desc,
							$sermon_book_url_slug_default,
							ctc_make_url_slug_bold( $sermon_book_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'  => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_book_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported' => ! ctc_taxonomy_supported( 'sermons', 'ctc_sermon_book' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Speaker URL Base (Slug).
					'sermon_speaker_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'       => '',
						'desc'       => sprintf(
							$url_slug_desc,
							$sermon_speaker_url_slug_default,
							ctc_make_url_slug_bold( $sermon_speaker_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'  => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_speaker_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported' => ! ctc_taxonomy_supported( 'sermons', 'ctc_sermon_speaker' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Tag URL Base (Slug).
					'sermon_tag_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'        => '',
						'desc'        => sprintf(
							$url_slug_desc,
							$sermon_tag_url_slug_default,
							ctc_make_url_slug_bold( $sermon_tag_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'  => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_tag_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported' => ! ctc_taxonomy_supported( 'sermons', 'ctc_sermon_tag' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Hide in Admin Menu.
					'sermons_admin_hide' => array_merge( $hide_admin_field, array(
						'checkbox_label' => __( 'Hide Sermons in Admin Menu', 'church-theme-content' ), // show text after checkbox.
						'unsupported'    => ! $sermons_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

				),

			),

			// Podcast.
			'podcast' => array(

				// Title.
				'title' => _x( 'Podcast', 'settings section title', 'church-theme-content' ),

				// Description.
				'desc' => sprintf(
					/* translators: Used in settings at top of Podcast section. %1$s is URL for sermon podcast guide. */
					__( 'Set up your <a href="%1$s" target="_blank">Sermon Podcast</a> to reach more people.', 'church-theme-content' ),
					esc_url( $podcast_guide_url )
				),

				// Fields (Settings).
				'fields' => array(

					// Feed URL.
					'podcast_feed_content' => array(
						'name'              => _x( 'Feed URL', 'settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => sprintf(
							/* translators: %1$s is URL to guide about sermon podcasting. */
							__( 'Submit your podcast feed URL to iTunes, Google Play, etc. Read the <a href="%1$s" target="_blank">Podcasting Guide</a> to learn how.', 'church-theme-content' ),
							esc_url( $podcast_guide_url )
						),
						'type'              => 'content', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => '', // classes to add to input.
						'content'           => $podcast_feed_content, // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Image.
					'podcast_image' => array(
						'name'              => _x( 'Image', 'podcast settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => __( 'Square image must be between 1400x1400 and 3000x3000 pixels and in JPG or PNG format. <b>Required by iTunes</b>.', 'church-theme-content' ),
						'type'              => 'upload', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => __( 'Choose Image', 'church-theme-content' ), // text for button that opens media chooser.
						'upload_title'      => __( 'Choose an Image', 'church-theme-content' ), // title appearing at top of media chooser.
						'upload_type'       => 'image', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => '350', // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => '', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Title.
					'podcast_title' => array(
						'name'              => _x( 'Title', 'podcast settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => __( 'The title of your sermon podcast. Example: "Grace Church Sermons" or "Cornerstone Church Podcast". <b>Required</b>.', 'church-theme-content' ),
						'type'              => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => ctc_podcast_title_default(),
							'maxlength'   => '60',
						),
						'class'             => '', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Subtitle.
					'podcast_subtitle' => array(
						'name'              => _x( 'Subtitle', 'podcast settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => __( 'A short description of your podcast. Example: "Weekly sermons by Pastor Bob Smith at Grace Church in Orlando, FL."', 'church-theme-content' ),
						'type'              => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => ctc_podcast_subtitle_default(),
							'maxlength'   => '255', // enforce with custom_sanitize
						),
						'class'             => 'ctps-width-500', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => 'ctc_sanitize_setting_podcast_subtitle', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Description (Summary).
					'podcast_summary' => array(
						'name'              => _x( 'Description', 'podcast settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => __( 'A full description of your podcast. You can write about your church, mission and pastor, link to your website, etc.', 'church-theme-content' ),
						'type'              => 'textarea', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array( // attr => value array (e.g. set min/max for number or range type).
							'maxlength' => '4000', // enforce with custom_sanitize
						),
						'class'             => 'ctps-width-500', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => 'ctc_sanitize_setting_podcast_summary', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Provider (Author).
					'podcast_author' => array(
						'name'              => _x( 'Provider', 'podcast settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => __( 'The name of your church and/or pastor. Example: "Grace Church - Pastor Bob Smith". <b>Required</b>.', 'church-theme-content' ),
						'type'              => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => ctc_podcast_author_default(),
							'maxlength'   => '60',
						),
						'class'             => '', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Copyright.
					'podcast_copyright' => array(
						'name'              => _x( 'Copyright', 'podcast settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => __( 'Copyright notice for your podcast. Example: "&copy; Grace Church"', 'church-theme-content' ),
						'type'              => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => ctc_podcast_copyright_default(),
							'maxlength'   => '60',
						),
						'class'             => '', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Link (Website URL).
					'podcast_link' => array(
						'name'              => _x( 'Link', 'podcast settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => __( 'Provide a URL if you want your podcast to link to somewhere other than your website homepage.', 'church-theme-content' ),
						'type'              => 'url', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => ctc_podcast_link_default(),
						),
						'class'             => '', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Email.
					'podcast_email' => array(
						'name'              => _x( 'Email', 'podcast settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => __( 'Email to receive notifications from iTunes / Google Play. Not shown to public (but is in feed). <b>Required by Google Play</b>.', 'church-theme-content' ),
						'type'              => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array( // attr => value array (e.g. set min/max for number or range type).
							'maxlength' => '60',
						),
						'class'             => '', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Category.
					'podcast_category' => array(
						'name'              => _x( 'Category', 'sermon settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => __( 'Choosing a category for your podcast is <b>required by iTunes</b> and can help users find it.', 'church-theme-content' ),
						'type'              => 'radio', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => true, // make radio inputs inline instead of stacked.
						'options'           => ctc_podcast_category_options(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => 'Religion & Spirituality|Christianity', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => true, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => '', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true,
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Clean (Not Explicit).
					'podcast_not_explicit' => array(
						'name'              => _x( 'Clean', 'sermon settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => __( 'iTunes and Google Play need to know if a podcast contains explicit content or not.', 'church-theme-content' ),
						'type'              => 'checkbox', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => __( 'Podcast does <em>not</em> contain explicit content', 'church-theme-content' ), // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => true, // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => '', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true,
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Language.
					'podcast_language' => array(
						'name'              => _x( 'Language', 'podcast settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => sprintf(
							/* translators: %1$s is URL to ISO 639-1 language code list, %2$s is URL to General Settings */
							__( 'Specify your podcast language in <a href="%1$s" target="_blank">ISO 639-1</a> format. If not specified, the language in <a href="%2$s" target="_blank">General Settings</a> will be used.', 'church-theme-content' ),
							'http://www.loc.gov/standards/iso639-2/php/code_list.php',
							esc_url( admin_url( 'options-general.php' ) )
						),
						'type'              => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => ctc_podcast_language_default(),
							'maxlength'   => '5',
						),
						'class'             => 'ctps-width-100', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Limit.
					'podcast_limit' => array(
						'name'              => _x( 'Limit', 'podcast settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => sprintf(
							/* translators: %1$s is URL to Reading Settings */
							__( 'Include the X most recent sermons in your podcast feed. Defaults to "Syndication feeds..." in <a href="%1$s" target="_blank">Reading Settings</a>.', 'church-theme-content' ),
							esc_url( admin_url( 'options-reading.php' ) )
						),
						'type'              => 'number', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => ctc_podcast_limit_default(),
							'min' 	      => '1',
							'max'         => '999',
						),
						'class'             => 'ctps-width-100', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => 'ctc_sanitize_podcast_limit', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// iTunes New Feed URL.
					'podcast_new_url' => array(
						'name'              => _x( 'iTunes New Feed URL', 'podcast settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => sprintf(
							/* translators: %1$s is <itunes:new-feed-url>, %2$s is URL to Apple's docs on changing podcast feed URLs */
							__( 'If necessary, enter a URL to add the <code>%1$s</code> tag to your podcast feed. <a href="%2$s" target="_blank">Learn More</a>', 'church-theme-content' ),
							htmlspecialchars( '<itunes:new-feed-url>' ),
							'https://help.apple.com/itc/podcasts_connect/#/itca489031e0'
						),
						'type'              => 'url', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => '', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Maintenance.
					'podcast_maintenance' => array(
						'name'              => _x( 'Maintenance', 'podcast settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => __( 'Updates enclosures for all sermons. This can be helpful if you find that any are missing from your feed (not common).', 'church-theme-content' ),
						'type'              => 'content', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => '', // classes to add to input.
						'content'           => '<a href="#" id="ctc-podcast-update-enclosures" class="button ' . esc_attr( $podcast_button_classes ) . '">' . __( 'Update Enclosures', 'church-theme-content' ) . '</a>', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					/* Future possibility. Problem: ctc_term_options() cannot get terms because taxonomies not registered this early. Would need to hide any taxonomies not supported by theme.

					// Filter Topics.
					'podcast_topic' => array(
						'name'              => _x( 'Filtering', 'podcast settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => '',
						'type'              => 'select', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => ctc_term_options( 'sermons', 'ctc_sermon_topic', array( // array of keys/values for radio or select.
							'all' => _x( 'All Topics', 'podcast settings', 'church-theme-content' )
						) ),
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => 'all', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => true, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => 'ctps-width-350', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Filter Books.
					'podcast_book' => array(
						'name'              => '',
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => '',
						'type'              => 'select', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => ctc_term_options( 'sermons', 'ctc_sermon_book', array( // array of keys/values for radio or select.
							'all' => _x( 'All Books', 'podcast settings', 'church-theme-content' )
						) ),
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => 'all', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => true, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => 'ctps-width-350', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Filter Series.
					'podcast_series' => array(
						'name'              => '',
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => '',
						'type'              => 'select', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => ctc_term_options( 'sermons', 'ctc_sermon_series', array( // array of keys/values for radio or select.
							'all' => _x( 'All Series', 'podcast settings', 'church-theme-content' )
						) ),
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => 'all', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => true, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => 'ctps-width-350', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Filter Speaker.
					'podcast_speaker' => array(
						'name'              => '',
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => '',
						'type'              => 'select', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => ctc_term_options( 'sermons', 'ctc_sermon_speaker', array( // array of keys/values for radio or select.
							'all' => _x( 'All Speakers', 'podcast settings', 'church-theme-content' )
						) ),
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => 'all', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => true, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => 'ctps-width-350', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Filter Tags.
					'podcast_tag' => array(
						'name'              => '',
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => __( 'You may choose to limit which sermons are included in your podcast.', 'church-theme-content' ),
						'type'              => 'select', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => ctc_term_options( 'sermons', 'ctc_sermon_tag', array( // array of keys/values for radio or select.
							'all' => _x( 'All Tags', 'podcast settings', 'church-theme-content' )
						) ),
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => 'all', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => true, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => 'ctps-width-350', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					*/
				),

			),

			// Events.
			'events' => array(

				// Title.
				'title' => _x( 'Events', 'settings section title', 'church-theme-content' ),

				// Description.
				'desc' => '',

				// Fields (Settings).
				'fields' => array(

					// Recurring Events.
					'event_recurrence_content' => array(
						'name'              => _x( 'Recurring Events', 'settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => $event_recurrence_desc,
						'type'              => 'content', // text, textarea, checkbox, checkbox_multiple, radio, select, number, upload, url, content.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => '', // classes to add to input.
						'content'           => $event_recurrence_content, // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => true, // field input element disabled when Pro not active.
						'unsupported'       => ! $events_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Enhanced SEO.
					'events_seo' => array_merge( $seo_field, array(
						'checkbox_label' => __( 'Enable Structured Data for Events <span class="ctps-light ctps-italic">(Recommended)</span>', 'church-theme-content' ), // show text after checkbox.
						'unsupported'      => ! $events_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Location Memory.
					'event_location_memory' => array(
						'name'              => __( 'Location Memory', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => __( 'Save time when adding events by choosing from previously used locations.', 'church-theme-content' ),
						'type'              => 'checkbox', // text, textarea, checkbox, checkbox_multiple, radio, select, number.
						'checkbox_label'    => __( 'Enable "Choose" Button and Autocomplete <span class="ctps-light ctps-italic">(Recommended)</span>', 'church-theme-content' ),
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => false, // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => '', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => array( // field input element disabled when Pro not active.
							'default' => true, // default to use instead, when Pro plugin (Pro plugin will also set this on first installation).
						),
						'unsupported'      => ! ( ctc_field_supported( 'events', '_ctc_event_address' ) || ctc_field_supported( 'events', '_ctc_event_venue' ) ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Event URL Base (Slug).
					'event_url_slug' => array_merge( $url_slug_field, array(
						'name'              => __( 'Event URL Base', 'church-theme-content' ), // "Base" makes more sense to users than "Slug" and that's what it's called in Permalink settings, for consistency.
						'desc'              => sprintf(
							$url_slug_desc,
							$event_url_slug_default,
							ctc_make_url_slug_bold( $event_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'        => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $event_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'       => ! $events_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Category URL Base (Slug).
					'event_category_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'              => __( 'Category URL Base', 'church-theme-content' ), // "Base" makes more sense to users than "Slug" and that's what it's called in Permalink settings, for consistency.
						'desc'              => sprintf(
							$url_slug_desc,
							$event_category_url_slug_default,
							ctc_make_url_slug_bold( $event_category_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'        => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $event_category_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'       => ! ctc_taxonomy_supported( 'events', 'ctc_event_category' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Hide in Admin Menu.
					'events_admin_hide' => array_merge( $hide_admin_field, array(
						'checkbox_label' => __( 'Hide Events in Admin Menu', 'church-theme-content' ), // show text after checkbox.
						'unsupported'      => ! $events_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

				),

			),

			// Locations.
			'locations' => array(

				// Title.
				'title' => _x( 'Locations', 'settings section title', 'church-theme-content' ),

				// Description.
				'desc' => '',

				// Fields (Settings).
				'fields' => array(

					// Google Maps API Key.
					'google_maps_api_key' => array(
						'name'              => _x( 'Google Maps API Key', 'settings', 'church-theme-content' ),
						'after_name'        => __( '(Required)', 'setting label', 'church-theme-content' ), // append (Optional) or (Pro), etc.
						'desc'              => sprintf(
							/* translators: %1$s is URL to guide telling user how to get a Google Maps API Key */
							__( 'An API Key for Google Maps is required if you want to show maps for locations or events. <a href="%1$s" target="_blank">Get an API Key</a>', 'church-theme-content' ),
							esc_url( ctc_ctcom_url( 'google-maps-api-key' ) ) // how to get API key.
						),
						'type'              => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number.
						'checkbox_label'    => '', // show text after checkbox.
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => '', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'unsupported'       => '', // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Location URL Base (Slug).
					'location_url_slug' => array_merge( $url_slug_field, array(
						'name'              => __( 'Location URL Base', 'church-theme-content' ), // "Base" makes more sense to users than "Slug" and that's what it's called in Permalink settings, for consistency.
						'desc'              => sprintf(
							$url_slug_desc,
							$location_url_slug_default,
							ctc_make_url_slug_bold( $location_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'        => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $location_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'       => ! $locations_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Hide in Admin Menu.
					'locations_admin_hide' => array_merge( $hide_admin_field, array(
						'checkbox_label' => __( 'Hide Locations in Admin Menu', 'church-theme-content' ), // show text after checkbox.
						'unsupported'      => ! $locations_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

				),

			),

			// People.
			'people' => array(

				// Title.
				'title' => _x( 'People', 'settings section title', 'church-theme-content' ),

				// Description.
				'desc' => '',

				// Fields (Settings).
				'fields' => array(

					// Person URL Base (Slug).
					'person_url_slug' => array_merge( $url_slug_field, array(
						'name'              => __( 'Person URL Base', 'church-theme-content' ), // "Base" makes more sense to users than "Slug" and that's what it's called in Permalink settings, for consistency.
						'desc'              => sprintf(
							$url_slug_desc,
							$person_url_slug_default,
							ctc_make_url_slug_bold( $person_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'        => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $person_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'      => ! $people_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Group URL Base (Slug).
					'person_group_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'              => __( 'Group URL Base', 'church-theme-content' ), // "Base" makes more sense to users than "Slug" and that's what it's called in Permalink settings, for consistency.
						'desc'              => sprintf(
							$url_slug_desc,
							$person_group_url_slug_default,
							ctc_make_url_slug_bold( $person_group_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'        => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $person_group_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'       => ! ctc_taxonomy_supported( 'people', 'ctc_person_group' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Hide in Admin Menu.
					'people_admin_hide' => array_merge( $hide_admin_field, array(
						'checkbox_label' => __( 'Hide People in Admin Menu', 'church-theme-content' ), // show text after checkbox.
						'unsupported'   => ! $people_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

				),

			),

			// Other.
			'other' => array(

				// Title.
				'title' => _x( 'Other', 'settings section title', 'church-theme-content' ),

				// Description.
				'desc' => '',

				// Fields (Settings).
				'fields' => array(

					// Dashboard News.
					'dashboard_news' => array(
						'name'              => _x( 'Dashboard News', 'settings', 'church-theme-content' ),
						'after_name'        => '', // append (Optional) or (Pro), etc.
						'desc'              => sprintf(
							/* translators: %1$s is URL for newsletter sign up */
							__( 'Hear about updates, new features, themes and tips. You can also subscribe to our <a href="%1$s" target="_blank">Newsletter</a>.', 'church-theme-content' ),
							esc_url( ctc_ctcom_url( 'newsletter' ) )
						),
						'type'              => 'checkbox', // text, textarea, checkbox, checkbox_multiple, radio, select, number.
						'checkbox_label'    => sprintf( // show text after checkbox.
							/* translators: %1$s is URL for ChurchThemes.com blog, %2$s is URL for admin dashboard */
							__( 'Show news from <a href="%1$s" target="_blank">ChurchThemes.com</a> on your admin <a href="%2$s">Dashboard</a>', 'church-theme-content' ),
							esc_url( ctc_ctcom_url( 'blog' ) ),
							esc_url( admin_url() )
						),
						'inline'            => false, // make radio inputs inline instead of stacked.
						'options'           => array(), // array of keys/values for radio or select.
						'upload_button'     => '', // text for button that opens media chooser.
						'upload_title'      => '', // title appearing at top of media chooser.
						'upload_type'       => '', // optional type of media to filter by (image, audio, video, application/pdf).
						'upload_show_image' => false, // provide a pixel width to show the image, if type is image.
						'default'           => true, // value to pre-populate option with (before first save or on reset).
						'no_empty'          => false, // if user empties value, force default to be saved instead.
						'allow_html'        => false, // allow HTML to be used in the value.
						'attributes'        => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'             => '', // classes to add to input.
						'content'           => '', // custom content instead of input (HTML allowed).
						'custom_sanitize'   => '', // function to do additional sanitization.
						'custom_content'    => '', // function for custom display of field input.
						'pro'               => false, // field input element disabled when Pro not active.
						'unsupported'       => false, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

				),

			),

		),

	);

	// Return filtered.
	return apply_filters( 'ctc_settings_config', $config );

}

/**
 * Init settings class
 *
 * This will add settings page and make $ctc_settings object available for settings retrieval.
 *
 * Note that title, description, etc. are escaped by CT Plugin Settings for translation security.
 *
 * @since 1.2
 * @global object $ctc_settings
 */
function ctc_settings_setup() {

	global $ctc_settings;

	// Get settings config with sections and fields.
	// This is for CT_Plugin_Settings class.
	$config = ctc_settings_config();

	// Pro tag to show after field labels.
	$pro_tag = _x( '(Pro)', 'settings', 'church-theme-content' );
	$pro_tag = '<a href="' . esc_url( ctc_ctcom_url( 'church-content-pro', array( 'utm_content' => 'settings' ) ) ) . '" target="">' . $pro_tag . '</a>';

	// Loop sections to add "Pro" tags, disable inputs and add to section description.
	foreach ( $config['sections'] as $section_id => $section ) {

		// Track number of settings inactive.
		$unsupported_settings = 0;
		$pro_inactive_settings = 0;

		// Have fields.
		if ( isset( $section['fields'] ) ) {

			// Loop fields.
			foreach ( $section['fields'] as $field_id => $field ) {

				$readonly = false;

				// Add Pro tag is is Pro setting.
				if ( ! empty( $field['pro'] ) ) {
					$config['sections'][ $section_id ]['fields'][ $field_id ]['after_name'] = $pro_tag;
				}

				// Setting not supported by theme.
				// 'unsupported' arg was set true due to lack of theme support for CTC feature, field or taxonomy.
				if ( ! empty( $field['unsupported'] ) ) {

					// Don't let user change field value.
					$readonly = true;

					// Replace description with message saying theme does not support this setting.
					// We leave the "(Pro)" after_name so they know that even if they do switch themes, they have to use Pro.
					$config['sections'][ $section_id ]['fields'][ $field_id ]['desc'] = __( '<b>Note:</b> This is not supported by your theme and will have no effect.', 'church-theme-content' );

					// Count inactive settings due to missing theme support.
					$unsupported_settings++;

				}

				// Field is Pro but Pro plugin is inactive.
				elseif ( ! empty( $field['pro'] ) && ! ctc_pro_is_active() ) {

					// Don't let user change field value.
					$readonly = true;

					// Add class to warn this requires Pro upgrade.
					$config['sections'][ $section_id ]['fields'][ $field_id ]['class'] .= ' ctc-pro-setting-inactive'; // preceding space in case already have class (CT_Plugin_Settings will trim).

					// Count inactive settings due to Pro not being active.
					$pro_inactive_settings++;

				}

				// Make readonly so cannot change.
				if ( $readonly ) {

					// Append readonly attribute to array.
					$config['sections'][ $section_id ]['fields'][ $field_id ]['attributes'] = array_merge( $field['attributes'], array(
						'readonly' => 'readonly',
					) );

					// Add class to stop changes to checkbox inputs (readonly doesn't stop state changes).
					$config['sections'][ $section_id ]['fields'][ $field_id ]['class'] .= ' ctc-setting-readonly'; // preceding space in case already have class (CT_Plugin_Settings will trim).

				}

			}

			// Show note at top of section explaining (Pro) denotation.
			if ( $pro_inactive_settings ) { // at least one settings that requires Pro plugin is used.

				// Have description. Add space before appending new note...
				if ( ! empty( $config['sections'][ $section_id ]['desc'] ) ) {
					$config['sections'][ $section_id ]['desc'] .= ' ';
				} else {
					$config['sections'][ $section_id ]['desc'] = '';
				}

				// Add note.
				$config['sections'][ $section_id ]['desc'] .= '<span class="ctc-pro-setting-inactive-message">' . sprintf(
					/* %1$s is URL to Church Content Pro plugin info */
					__( '"Pro" settings are provided by the <a href="%1$s" target="_blank">Church Content Pro</a> plugin. Install it to add more features.', 'church-theme-content' ),
					esc_url( ctc_ctcom_url( 'church-content-pro', array( 'utm_content' => 'settings' ) ) )
				) . '</span>';

			}

		}

	}

	// Add settings.
	$ctc_settings = new CT_Plugin_Settings( $config );

}

add_action( 'init', 'ctc_settings_setup', 1 ); // early so later actions can use it.

/**********************************
 * SAVING SETTINGS
 **********************************/

/**
 * Sanitize URL slug.
 *
 * @since 2.0
 * @param string $setting Setting key.
 * @return mixed Setting value.
 * @global object $ctc_settings.
 */
function ctc_sanitize_setting_url_slug( $value, $field ) {

	// Lowercase, replace space with -, remove special chars, etc.
	// This is what WordPress uses to change post title into URL slug.
	$value = sanitize_title( $value );

	// Return sanitized value.
	return $value;

}

/**
 * Sanitize Podcast Subtitle.
 *
 * Limit the length of content. Tags are already stripped on save.
 *
 * @since 2.0
 * @param string $setting Setting key.
 * @return mixed Setting value.
 * @global object $ctc_settings.
 */
function ctc_sanitize_setting_podcast_subtitle( $value, $field = false ) {

	// Strip shortcodes.
	$value = strip_shortcodes( $value );
	$value = trim( $value );

	// Max characters for iTunes.
	$value = ctc_shorten( $value, 255 );

	// Return sanitized value.
	return $value;

}

/**
 * Sanitize Podcast Description (Summary).
 *
 * Limit the length of content. Tags are already stripped on save.
 *
 * @since 2.0
 * @param string $setting Setting key.
 * @return mixed Setting value.
 * @global object $ctc_settings.
 */
function ctc_sanitize_setting_podcast_summary( $value, $field = false ) {

	// Strip shortcodes.
	$value = strip_shortcodes( $value );
	$value = trim( $value );

	// Max characters for iTunes.
	$value = ctc_shorten( $value, 4000 );

	// Return sanitized value.
	return $value;

}

/**
 * Sanitize podcast limit.
 *
 * @since 2.0
 * @param string $setting Setting key.
 * @return mixed Setting value.
 * @global object $ctc_settings.
 */
function ctc_sanitize_podcast_limit( $value, $field ) {

	// Positive number only.
	if ( ! empty( $value ) ) { // allow empty, so can use default.
		$value = absint( $value );
	}

	// Return sanitized value.
	return $value;

}

/**
 * Flush rewrite rules on save.
 *
 * Do this in case URL slug setting(s) have changed.
 *
 * @since 1.0
 * @global object $ctc_settings
 */
function ctc_settings_flush_rewrite_rules() {

	global $ctc_settings;

	// Is this plugin settings page?
	if ( ! $ctc_settings->is_settings_page() ) {
		return;
	}

	// Flush rules.
	flush_rewrite_rules();

}

add_action( 'ctps_after_save', 'ctc_settings_flush_rewrite_rules' );

/**
 * Delete dashboard news transients on save.
 *
 * This purges the cache so any changes to dashboard_news setting take effect immediately.
 *
 * @since 2.0
 * @global object $ctc_settings
 */
function ctc_settings_delete_dashboard_news_transients() {

	global $wpdb;

	$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '\_transient\_feed\_%' OR option_name LIKE '\_transient\_dash\_%'" );

}

add_action( 'ctps_after_save', 'ctc_settings_delete_dashboard_news_transients' );

/**********************************
 * GETTING SETTINGS
 **********************************/

/**
 * Force non-Pro default on Pro settings while Pro plugin is inactive.
 *
 * This will make form inputs use default values and ctc_setting() to return defaults.
 * If a user re-activated Pro, their saved values will work again - unless they've saved form w/defaults.
 *
 * Church Content plugin doesn't use Pro setting values, but this cleans things up nicely just in case.
 *
 * @param array $value Current value.
 * @param string $setting Setting name (field ID).
 * @param object $instance Passing $this.
 * @return string Non-Pro default if necessary.
 */
function ctc_force_non_pro_setting_default( $value, $setting, $instance ) {

	// On Church Content settings only.
	// (just in case another plugin uses CT Plugin Settings).
	if ( 'ctc_settings' === $instance->config['option_id'] ) {

		// Pro plugin is inactive.
		if ( ! ctc_pro_is_active() ) {

			// Get field data.
			$field = $instance->fields[ $setting ];

			// Is Pro setting.
			if ( ! empty( $field['pro'] ) ) {

				// Get non-Pro default value.
				$default = isset( $field['default'] ) ? $field['default'] : '';

				// Force default value.
				$value = $default;

			}

		}

	}

	return $value;

}

add_filter( 'ctps_get', 'ctc_force_non_pro_setting_default', 10, 3 );

/**
 * Get a setting
 *
 * @since 1.2
 * @param string $setting Setting key.
 * @return mixed Setting value.
 * @global object $ctc_settings.
 */
function ctc_setting( $setting ) {

	global $ctc_settings;

	// Get value.
	$value = $ctc_settings->get( $setting );

	// Return filtered.
	return apply_filters( 'ctc_setting', $value, $setting );

}

/**********************************
 * UPDATING SETTINGS
 **********************************/

/**
 * Update a setting
 *
 * Update a single setting's value in the option array.
 *
 * @since 2.1
 * @param string $setting Setting key.
 * @param mixed $value Setting value.
 * @global object $ctc_settings.
 */
function ctc_update_setting( $setting, $value ) {

	global $ctc_settings;

	// Update setting value.
	$ctc_settings->update( $setting, $value );

}

/**********************************
 * WORDPRESS SETTINGS
 **********************************/

/**
 * Change WordPress "Blog pages show at most" label text.
 *
 * "Posts per page" makes more sense when using multiple post types.
 *
 * @since 2.0.
 */
function ctc_change_wp_per_page_label( $translated_text, $text, $domain ) {

	switch ( $translated_text ) {

		case 'Blog pages show at most':
			/* translators: This replaces "Blog pages show at most" in WordPress Settings > Reading" */
			$translated_text = __( 'Posts per page', 'church-theme-content' );
			break;

	}

	return $translated_text;

}

add_filter( 'gettext', 'ctc_change_wp_per_page_label', 20, 3 );

/**
 * Insert note on Settings > Reading to say use Church Content settings to change "per page" per post type.
 *
 * A description is added after the "Blog pages show at most" input, which we renamed to "Posts per page".
 *
 * @since 2.0.
 */
function ctc_add_wp_per_page_desc() {

	// Get current screen.
	$screen = get_current_screen();

	// On settings screen only.
	if ( 'options-reading' !== $screen->base ) {
		return;
	}

	// Note to append.
	$note = sprintf(
		wp_kses(
			/* translators: %1$s is URL for Church Content Settings */
			__( 'Use <a href="%1$s">Church Content Settings</a> to override this for specific post types (sermons, events, etc.)', 'church-theme-content' ),
			array(
				'a' => array(
					'href' => array(),
				),
			)
		),
		esc_url( admin_url( 'options-general.php?page=' . CTC_DIR ) )
	);

	// Output JS to footer to insert description below input.
	?>
	<script type="text/javascript">

	jQuery( document ).ready( function( $ ) {

		// Get posts_per_page input element.
		var $per_page_input = $( 'input[name=posts_per_page]' );

		// Get parent td of input.
		var $container = $per_page_input.parent( 'td' );

		// Append note to bottom of td as description.
		$container.append( '<p class="description"><?php echo $note; ?></p>' );

	} );

	</script>
	<?php

}

// Disabled. Settings don't exist (better via theme in Customizer).
// This still serves as good example of how to add a description.
//add_action( 'admin_print_footer_scripts', 'ctc_add_wp_per_page_desc' );

/**
 * Add settings section to Permalink Settings.
 *
 * This tells the user there are permalink settings for custom post types in Church Content plugin settings.
 *
 * @since 2.0.
 */
function ctc_add_permalink_setting_section() {

	// Add section to Permalink Settings.
	add_settings_section(
		'ctc_permalink_setting_section',
		__( 'Church Content Settings', 'church-theme-content' ),
		'ctc_permalink_setting_section_output',
		'permalink'
	);

}

add_action( 'admin_init', 'ctc_add_permalink_setting_section' );

/**
 * Output content for ctc_add_permalink_setting_section();
 *
 * @since 2.0.
 */
function ctc_permalink_setting_section_output( $arg ) {

	?>

	<p>

		<?php
		printf(
			wp_kses(
				/* translators: %1$s is URL for Church Content Settings */
				__( 'Go to <a href="%1$s">Church Content Settings</a> to set custom URL bases for sermons, events, etc.', 'church-theme-content' ),
				array(
					'a' => array(
						'href' => array(),
					),
				)
			),
			esc_url( admin_url( 'options-general.php?page=' . CTC_DIR . '#sermons' ) ) // start at sermons, not licenses.
		);
		?>

	</p>

	<?php

}

/*******************************************
 * AGENCY MODE
 *******************************************/

/**
 * Agency mode note.
 *
 * Note shown on add-on license settings and Theme License to tell user about Agency Mode.
 *
 * @since 2.0
 */
function ctc_agency_mode_note() {

	$note = sprintf(
		wp_kses(
			//* translators: %1$s is URL for guide on Agency Mode */
			__( 'Agencies and freelancers can enable <a href="%1$s" target="_blank">Agency Mode</a>.', 'church-theme-content' ),
			array(
				'a' => array(
					'href' => array(),
					'target' => array(),
				),
			)
		),
		ctc_ctcom_url( 'agency-mode' )
	);

	return apply_filters( 'ctc_agency_mode_note', $note );

}
