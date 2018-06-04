<?php
/**
 * Plugin Settings
 *
 * Setup and retrieve plugin settings. Also handles WordPress settings.
 *
 * @package    Church_Theme_Content
 * @copyright  Copyright (c) 2014 - 2018, churchthemes.com
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
 * @since 1.9
 * @return array Settings array.
 */
function ctc_settings_config() {

	/**********************************
	 * SHARED
 	 **********************************/

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

	// SEO Structured Data field.
	$seo_field = array(
		'name'             => _x( 'SEO Structured Data', 'settings', 'church-theme-content' ),
		'after_name'       => '', // append (Optional) or (Pro), etc.
		'desc'             => sprintf(
			/* translators: %1$s is URL with information about SEO with JSON-LD */
			__( 'Automatic Search Engine Optimization (SEO) with Schema.org structured data via JSON-LD. <a href="%1$s" target="_blank">Learn More</a>', 'church-theme-content' ),
			esc_url( ctc_ctcom_url( 'seo-setting' ) )
		),
		'type'             => 'checkbox', // text, textarea, checkbox, checkbox_multiple, radio, select, number.
		'checkbox_label'   => '',
		'options'          => array(), // array of keys/values for radio or select.
		'default'          => false, // value to pre-populate option with (before first save or on reset).
		'no_empty'         => false, // if user empties value, force default to be saved instead.
		'allow_html'       => false, // allow HTML to be used in the value.
		'attributes'       => array(), // attr => value array (e.g. set min/max for number or range type).
		'class'            => '', // classes to add to input.
		'content'          => '', // custom content instead of input (HTML allowed).
		'custom_sanitize'  => '', // function to do additional sanitization.
		'custom_content'   => '', // function for custom display of field input.
		'pro'              => array( // field input element disabled when Pro not active.
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
		'name'            => '',
		'after_name'      => '', // append (Optional) or (Pro), etc.
		'desc'            => '',
		'type'            => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, content.
		'checkbox_label'  => '', // show text after checkbox.
		'options'         => array(), // array of keys/values for radio or select.
		'default'         => '', // value to pre-populate option with (before first save or on reset).
		'no_empty'        => false, // if user empties value, force default to be saved instead.
		'allow_html'      => false, // allow HTML to be used in the value.
		'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
			'maxlength'   => '30',
		),
		'class'           => 'ctps-width-200', // classes to add to input.
		'content'         => '', // custom content instead of input (HTML allowed).
		'custom_sanitize' => 'ctc_sanitize_setting_url_slug', // function to do additional sanitization.
		'custom_content'  => '', // function for custom display of field input.
		'pro'             => true, // field input element disabled when Pro not active.
	);

	// Taxonomy URL Base field.
	$taxonomy_url_slug_field = array(
		'name'            => '',
		'after_name'      => '', // append (Optional) or (Pro), etc.
		'desc'            => '',
		'type'            => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, content.
		'checkbox_label'  => '', // show text after checkbox.
		'options'         => array(), // array of keys/values for radio or select.
		'default'         => '', // value to pre-populate option with (before first save or on reset).
		'no_empty'        => false, // if user empties value, force default to be saved instead.
		'allow_html'      => false, // allow HTML to be used in the value.
		'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
			'maxlength'   => '30',
		),
		'class'           => 'ctps-width-200', // classes to add to input.
		'content'         => '', // custom content instead of input (HTML allowed).
		'custom_sanitize' => 'ctc_sanitize_setting_url_slug', // function to do additional sanitization.
		'custom_content'  => '', // function for custom display of field input.
		'pro'             => true, // field input element disabled when Pro not active.
	);

	// Hide in Admin Menu field.
	$hide_admin_field = array(
		'name'            => __( 'Hide in Admin', 'church-theme-content' ),
		'after_name'      => '', // append (Optional) or (Pro), etc.
		'desc'            => __( 'This can be useful if you are not using the feature.', 'church-theme-content' ),
		'type'            => 'checkbox', // text, textarea, checkbox, checkbox_multiple, radio, select, number.
		'checkbox_label'  => '',
		'options'         => array(), // array of keys/values for radio or select.
		'default'         => false, // value to pre-populate option with (before first save or on reset).
		'no_empty'        => false, // if user empties value, force default to be saved instead.
		'allow_html'      => false, // allow HTML to be used in the value.
		'attributes'      => array(), // attr => value array (e.g. set min/max for number or range type).
		'class'           => '', // classes to add to input.
		'content'         => '', // custom content instead of input (HTML allowed).
		'custom_sanitize' => '', // function to do additional sanitization.
		'custom_content'  => '', // function for custom display of field input.
		'pro'             => false, // field input element disabled when Pro not active.
	);

	/**********************************
	 * SETTINGS
	 **********************************/

	// Podcasting supported when sermons supported and audio URL field supported.
	$sermon_audio_supported = ctc_field_supported( 'sermons', '_ctc_sermon_audio' );
	$podcast_supported = $sermons_supported && $sermon_audio_supported ? true : false;

	// Podcast feed URL.
	$podcast_feed_url = ctc_podcast_feed_url();

	// Podcast feed description.
	$podcast_feed_desc = __( 'Submit the podcast feed URL to iTunes, Google Play, etc. Read the <a href="%1$s">Podcasting Guide</a> to learn how.', 'church-theme-content' );

	// Podcast feed content.
	$podcast_feed_content  = '<div id="ctc-settings-podcast-feed-url">' . $podcast_feed_url . '</div>';
	if ( $sermon_audio_supported ) {
		$podcast_feed_content .= '<div id="ctc-settings-podcast-feed-buttons">';
		$podcast_feed_content .= '	<a href="' . esc_url( $podcast_feed_url ) . '" class="button" target="_blank">' . __( 'View', 'podcast feed URL', 'church-theme-content' ) . '</a>';
		$podcast_feed_content .= '	<a href="" class="button">' . __( 'Copy', 'podcast feed URL', 'church-theme-content' ) . '</a>';
		$podcast_feed_content .= '	<a href="" class="button" target="_blank">' . __( 'Validate', 'podcast feed URL', 'church-theme-content' ) . '</a>';
		$podcast_feed_content .= '</div>';
	}

	// Event recurrence content and description.
	// Show different info depending on status of Church Content Pro or Custom Recurring Events plugin.
	$event_recurrence_desc = __( 'Save time by setting events to repeat automatically (e.g. "Every month on last Sunday except December 25").', 'church-theme-content' );
	if ( ctc_pro_is_active() ) { // Pro plugin active.

		$event_recurrence_content = _x( 'Enabled by <b>Church Content Pro</b> <span class="ctps-light ctps-italic">(Always On)</span>', 'recurrence setting', 'church-theme-content' );

	} elseif ( ctc_cre_is_active() ) { // Custom Recurring Events plugin active, not Pro.

		$event_recurrence_content = __( 'Partially Enabled by <b>Custom Recurring Events</b> Add-on', 'church-theme-content' );

		$event_recurrence_desc = sprintf(
			/* translators: %1$s is URL with info on upgrading from Custom Recurring Events to Church Content Pro */
			__( 'Upgrade to <a href="%1$s" target="_blank">Church Content Pro</a> for the complete set of recurrence and exclusion options.'),
			esc_url( ctc_ctcom_url( 'cre-to-pro', array( 'utm_content' => 'settings' ) ) )
		);

	} else { // No plugin active for recurring events.

		// Basic recurrence enabled either by grandfathering or theme support.
		if ( ctc_field_supported( 'events', '_ctc_event_recurrence' ) ) {

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
				'desc' => __( "Save then activate your add-on's license key to enable one-click updates for it.", 'church-theme-content' ),

				// Fields (Settings).
				// These are filtered in.
				'fields' => array(),

			),

			// Sermons.
			'sermons' => array(

				// Title.
				'title' => _x( 'Sermons', 'settings section title', 'church-theme-content' ),

				// Description.
				'desc' => '',

				// Fields (Settings).
				'fields' => array(

					// SEO Structured Data.
					'sermons_seo' => array_merge( $seo_field, array(
						'checkbox_label' => __( 'Improve SEO for Sermons <span class="ctps-light ctps-italic">(Recommended)</span>', 'church-theme-content' ), // show text after checkbox.
						'unsupported'    => ! $sermons_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Sermon Podcast (Shortcut).
					'podcast_content' => array(
						'name'             => _x( 'Sermon Podcast', 'settings', 'church-theme-content' ),
						'after_name'       => '', // append (Optional) or (Pro), etc.
						'desc'             => '',
						'type'             => 'content', // text, textarea, checkbox, checkbox_multiple, radio, select, number, content.
						'checkbox_label'   => '', // show text after checkbox.
						'options'          => array(), // array of keys/values for radio or select.
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

					// Alternative Wording - Singular
					'sermon_word_singular' => array(
						'name'            => __( 'Alternative Wording', 'church-theme-content' ),
						'after_name'      => '', // append (Optional) or (Pro), etc.
						'desc'            => '',
						'type'            => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, content.
						'checkbox_label'  => '', // show text after checkbox.
						'options'         => array(), // array of keys/values for radio or select.
						'default'         => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'        => false, // if user empties value, force default to be saved instead.
						'allow_html'      => false, // allow HTML to be used in the value.
						'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_word_singular_default, // show the standard value if they leave blank.
							'maxlength'   => '30',
						),
						'class'           => 'ctps-width-200', // classes to add to input.
						'content'         => '', // custom content instead of input (HTML allowed).
						'custom_sanitize' => '', // function to do additional sanitization.
						'custom_content'  => '', // function for custom display of field input.
						'pro'             => true, // field input element disabled when Pro not active.
						'unsupported'    => ! $sermons_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Alternative Wording - Plural
					'sermon_word_plural' => array(
						'name'            => '',
						'after_name'      => '', // append (Optional) or (Pro), etc.
						'desc'            => sprintf(
							/* translators: %1$s is "Sermon" and %2$s is "Sermons" (translated). */
							__( 'Enter alternative wording for "%1$s" and "%2$s" (e.g. "Message" and "Messages").', 'church-theme-content' ),
							$sermon_word_singular_default,
							$sermon_word_plural_default
						),
						'type'            => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, content.
						'checkbox_label'  => '', // show text after checkbox.
						'options'         => array(), // array of keys/values for radio or select.
						'default'         => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'        => false, // if user empties value, force default to be saved instead.
						'allow_html'      => false, // allow HTML to be used in the value.
						'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_word_plural_default, // show the standard value if they leave blank.
							'maxlength'   => '30',
						),
						'class'           => 'ctps-width-200', // classes to add to input.
						'content'         => '', // custom content instead of input (HTML allowed).
						'custom_sanitize' => '', // function to do additional sanitization.
						'custom_content'  => '', // function for custom display of field input.
						'pro'             => true, // field input element disabled when Pro not active.
						'unsupported'    => ! $sermons_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Sermon URL Base (Slug).
					'sermon_url_slug' => array_merge( $url_slug_field, array(
						'name'            => __( 'Sermon URL Base', 'church-theme-content' ), // "Base" makes more sense to users than "Slug" and that's what it's called in Permalink settings, for consistency.
						'desc'            => sprintf(
							$url_slug_desc,
							$sermon_url_slug_default,
							ctc_make_url_slug_bold( $sermon_url_slug_default ) . $url_slug_title // make slug bold.
						),
						'attributes'      => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'    => ! $sermons_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Topic URL Base (Slug).
					'sermon_topic_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'            => __( 'Category URL Bases', 'church-theme-content' ),
						'desc'            => sprintf(
							$url_slug_desc,
							$sermon_topic_url_slug_default,
							ctc_make_url_slug_bold( $sermon_topic_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'      => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_topic_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'    => ! ctc_taxonomy_supported( 'sermons', 'ctc_sermon_topic' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Series URL Base (Slug).
					'sermon_series_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'            => '',
						'desc'            => sprintf(
							$url_slug_desc,
							$sermon_series_url_slug_default,
							ctc_make_url_slug_bold( $sermon_series_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'      => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_series_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'    => ! ctc_taxonomy_supported( 'sermons', 'ctc_sermon_series' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Book URL Base (Slug).
					'sermon_book_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'            => '',
						'desc'            => sprintf(
							$url_slug_desc,
							$sermon_book_url_slug_default,
							ctc_make_url_slug_bold( $sermon_book_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'      => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_book_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'    => ! ctc_taxonomy_supported( 'sermons', 'ctc_sermon_book' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Speaker URL Base (Slug).
					'sermon_speaker_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'            => '',
						'desc'            => sprintf(
							$url_slug_desc,
							$sermon_speaker_url_slug_default,
							ctc_make_url_slug_bold( $sermon_speaker_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'      => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_speaker_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'    => ! ctc_taxonomy_supported( 'sermons', 'ctc_sermon_speaker' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Tag URL Base (Slug).
					'sermon_tag_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'            => '',
						'desc'            => sprintf(
							$url_slug_desc,
							$sermon_tag_url_slug_default,
							ctc_make_url_slug_bold( $sermon_tag_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'      => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_tag_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'    => ! ctc_taxonomy_supported( 'sermons', 'ctc_sermon_tag' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
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
				'desc' => '',

				// Fields (Settings).
				'fields' => array(

					// Recurring Events.
					'podcast_feed_content' => array(
						'name'            => _x( 'Feed URL', 'settings', 'church-theme-content' ),
						'after_name'      => '', // append (Optional) or (Pro), etc.
						'desc'            => $podcast_feed_desc,
						'type'            => 'content', // text, textarea, checkbox, checkbox_multiple, radio, select, number, content.
						'checkbox_label'  => '', // show text after checkbox.
						'options'         => array(), // array of keys/values for radio or select.
						'default'         => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'        => false, // if user empties value, force default to be saved instead.
						'allow_html'      => false, // allow HTML to be used in the value.
						'attributes'      => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'           => '', // classes to add to input.
						'content'         => $podcast_feed_content, // custom content instead of input (HTML allowed).
						'custom_sanitize' => '', // function to do additional sanitization.
						'custom_content'  => '', // function for custom display of field input.
						'pro'             => true, // field input element disabled when Pro not active.
						'unsupported'     => ! $podcast_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

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
						'name'            => _x( 'Recurring Events', 'settings', 'church-theme-content' ),
						'after_name'      => '', // append (Optional) or (Pro), etc.
						'desc'            => $event_recurrence_desc,
						'type'            => 'content', // text, textarea, checkbox, checkbox_multiple, radio, select, number, content.
						'checkbox_label'  => '', // show text after checkbox.
						'options'         => array(), // array of keys/values for radio or select.
						'default'         => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'        => false, // if user empties value, force default to be saved instead.
						'allow_html'      => false, // allow HTML to be used in the value.
						'attributes'      => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'           => '', // classes to add to input.
						'content'         => $event_recurrence_content, // custom content instead of input (HTML allowed).
						'custom_sanitize' => '', // function to do additional sanitization.
						'custom_content'  => '', // function for custom display of field input.
						'pro'             => true, // field input element disabled when Pro not active.
						'unsupported'     => ! $events_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// SEO Structured Data.
					'events_seo' => array_merge( $seo_field, array(
						'checkbox_label' => __( 'Improve SEO for Events <span class="ctps-light ctps-italic">(Recommended)</span>', 'church-theme-content' ), // show text after checkbox.
						'unsupported'    => ! $events_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Location Memory.
					'event_location_memory' => array(
						'name'            => __( 'Location Memory', 'church-theme-content' ),
						'after_name'      => '', // append (Optional) or (Pro), etc.
						'desc'            => __( 'Save time when adding events by choosing from previously used locations.', 'church-theme-content' ),
						'type'            => 'checkbox', // text, textarea, checkbox, checkbox_multiple, radio, select, number.
						'checkbox_label'  => __( 'Enable "Choose" Button and Autocomplete <span class="ctps-light ctps-italic">(Recommended)</span>', 'church-theme-content' ),
						'options'         => array(), // array of keys/values for radio or select.
						'default'         => false, // value to pre-populate option with (before first save or on reset).
						'no_empty'        => false, // if user empties value, force default to be saved instead.
						'allow_html'      => false, // allow HTML to be used in the value.
						'attributes'      => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'           => '', // classes to add to input.
						'content'         => '', // custom content instead of input (HTML allowed).
						'custom_sanitize' => '', // function to do additional sanitization.
						'custom_content'  => '', // function for custom display of field input.
						'pro'             => array( // field input element disabled when Pro not active.
							'default' => true, // default to use instead, when Pro plugin (Pro plugin will also set this on first installation).
						),
						'unsupported'    => ! ( ctc_field_supported( 'events', '_ctc_event_address' ) || ctc_field_supported( 'events', '_ctc_event_venue' ) ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Event URL Base (Slug).
					'event_url_slug' => array_merge( $url_slug_field, array(
						'name'            => __( 'Event URL Base', 'church-theme-content' ), // "Base" makes more sense to users than "Slug" and that's what it's called in Permalink settings, for consistency.
						'desc'            => sprintf(
							$url_slug_desc,
							$event_url_slug_default,
							ctc_make_url_slug_bold( $event_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'      => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $event_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'     => ! $events_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Category URL Base (Slug).
					'event_category_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'            => __( 'Category URL Base', 'church-theme-content' ), // "Base" makes more sense to users than "Slug" and that's what it's called in Permalink settings, for consistency.
						'desc'            => sprintf(
							$url_slug_desc,
							$event_category_url_slug_default,
							ctc_make_url_slug_bold( $event_category_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'      => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $event_category_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'     => ! ctc_taxonomy_supported( 'events', 'ctc_event_category' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Hide in Admin Menu.
					'events_admin_hide' => array_merge( $hide_admin_field, array(
						'checkbox_label' => __( 'Hide Events in Admin Menu', 'church-theme-content' ), // show text after checkbox.
						'unsupported'    => ! $events_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
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

					// SEO Structured Data.
					'locations_seo' => array_merge( $seo_field, array(
						'checkbox_label' => __( 'Improve SEO for Locations <span class="ctps-light ctps-italic">(Recommended)</span>', 'church-theme-content' ), // show text after checkbox.
						'unsupported'    => ! $locations_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Google Maps API Key.
					'google_maps_api_key' => array(
						'name'            => _x( 'Google Maps API Key', 'settings', 'church-theme-content' ),
						'after_name'      => __( '(Required)', 'setting label', 'church-theme-content' ), // append (Optional) or (Pro), etc.
						'desc'            => sprintf(
							/* translators: %1$s is URL to guide telling user how to get a Google Maps API Key */
							__( 'An API Key for Google Maps is required if you want to show maps for locations or events. <a href="%1$s" target="_blank">Get an API Key</a>', 'church-theme-content' ),
							esc_url( ctc_ctcom_url( 'google-maps-api-key' ) ) // how to get API key.
						),
						'type'            => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number.
						'checkbox_label'  => '', // show text after checkbox.
						'options'         => array(), // array of keys/values for radio or select.
						'default'         => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'        => false, // if user empties value, force default to be saved instead.
						'allow_html'      => false, // allow HTML to be used in the value.
						'attributes'      => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'           => '', // classes to add to input.
						'content'         => '', // custom content instead of input (HTML allowed).
						'custom_sanitize' => '', // function to do additional sanitization.
						'custom_content'  => '', // function for custom display of field input.
						'unsupported'     => '', // set true if theme doesn't support required feature, taxonomy, fields, etc.
					),

					// Location URL Base (Slug).
					'location_url_slug' => array_merge( $url_slug_field, array(
						'name'            => __( 'Location URL Base', 'church-theme-content' ), // "Base" makes more sense to users than "Slug" and that's what it's called in Permalink settings, for consistency.
						'desc'            => sprintf(
							$url_slug_desc,
							$location_url_slug_default,
							ctc_make_url_slug_bold( $location_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'      => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $location_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'     => ! $locations_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Hide in Admin Menu.
					'locations_admin_hide' => array_merge( $hide_admin_field, array(
						'checkbox_label' => __( 'Hide Locations in Admin Menu', 'church-theme-content' ), // show text after checkbox.
						'unsupported'    => ! $locations_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
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

					// SEO Structured Data.
					'people_seo' => array_merge( $seo_field, array(
						'checkbox_label' => __( 'Improve SEO for People <span class="ctps-light ctps-italic">(Recommended)</span>', 'church-theme-content' ), // show text after checkbox.
						'unsupported' => ! $people_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Person URL Base (Slug).
					'person_url_slug' => array_merge( $url_slug_field, array(
						'name'            => __( 'Person URL Base', 'church-theme-content' ), // "Base" makes more sense to users than "Slug" and that's what it's called in Permalink settings, for consistency.
						'desc'            => sprintf(
							$url_slug_desc,
							$person_url_slug_default,
							ctc_make_url_slug_bold( $person_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'      => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $person_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'    => ! $people_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Group URL Base (Slug).
					'person_group_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'            => __( 'Group URL Base', 'church-theme-content' ), // "Base" makes more sense to users than "Slug" and that's what it's called in Permalink settings, for consistency.
						'desc'            => sprintf(
							$url_slug_desc,
							$person_group_url_slug_default,
							ctc_make_url_slug_bold( $person_group_url_slug_default ) . $url_slug_name // make slug bold.
						),
						'attributes'      => array_merge( $url_slug_field['attributes'], array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $person_group_url_slug_default, // show the standard value if they leave blank.
						) ),
						'unsupported'     => ! ctc_taxonomy_supported( 'people', 'ctc_person_group' ), // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

					// Hide in Admin Menu.
					'people_admin_hide' => array_merge( $hide_admin_field, array(
						'checkbox_label' => __( 'Hide People in Admin Menu', 'church-theme-content' ), // show text after checkbox.
						'unsupported'   => ! $people_supported, // set true if theme doesn't support required feature, taxonomy, fields, etc.
					) ),

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
					__( 'Settings labeled "Pro" are provided by the <a href="%1$s" target="_blank">Church Content Pro</a> plugin. Install it to add Pro features.', 'church-theme-content' ),
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
 * @since 1.9
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

/**********************************
 * GETTING SETTINGS
 **********************************/

/**
 * Force non-Pro default on Pro settings while Pro plugin is inactive.
 *
 * This will make form inputs use default values and and ctc_setting() to return defaults.
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
 * WORDPRESS SETTINGS
 **********************************/

/**
 * Change WordPress "Blog pages show at most" label text.
 *
 * "Posts per page" makes more sense when using multiple post types.
 *
 * @since 1.9.
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
 * @since 1.9.
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
		admin_url( 'options-general.php?page=' . CTC_DIR )
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
 * @since 1.9.
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
 * @since 1.9.
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
			admin_url( 'options-general.php?page=' . CTC_DIR . '#sermons' ) // start at sermons, not licenses.
		);
		?>

	</p>

	<?php

}