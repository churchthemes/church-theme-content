<?php
/**
 * Plugin Settings
 *
 * Setup and retrieve plugin settings. Also handles WordPress settings.
 *
 * @package    Church_Theme_Content
 * @copyright  Copyright (c) 2014 - 2017, churchthemes.com
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
 * This is used by:
 * - ctc_settings_setup() to make settings available to user
 * - ctc_get_settings() to get flat array of settings without sections.
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

	// Pro tag to show after field labels.
	$pro_tag = _x( '(Pro)', 'settings', 'church-theme-content' );
	$pro_tag = '<a href="' . esc_url( ctc_ctcom_url( 'church-content-pro', array( 'utm_content' => 'settings' ) ) ) . '" target="">' . $pro_tag . '</a>';

	// SEO Structured Data field.
	$seo_field = array(
		'name'            => _x( 'SEO Structured Data', 'settings', 'church-theme-content' ),
		'after_name'      => $pro_tag, // append (Optional) or (Pro), etc.
		'desc'            => sprintf(
			/* translators: %1$s is URL with information about SEO with JSON-LD */
			__( 'Automatic Search Engine Optimization (SEO) with Schema.org structured data via JSON-LD. <a href="%1$s" target="_blank">Learn More</a>', 'church-theme-content' ),
			esc_url( ctc_ctcom_url( 'seo-setting' ) )
		),
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
		'pro'             => array( // field input element disabled when Pro not active.
			'default' => true, // value to set by Pro when first activated.
		),
	);

	// Per Page field
	// Re-use this for sermons, events, etc., changing just name.
	$per_page_field = array(
		'name'            => '',
		'after_name'      => $pro_tag, // append (Optional) or (Pro), etc.
		'desc'            => sprintf(
			/* translators: %1$s is URL to Setting > Reading */
			__( 'Override the global "Posts per page" setting in <a href="%1$s">Reading Settings</a>. Leave blank to use the global setting.', 'church-theme-content' ),
			admin_url( 'options-reading.php' )
		),
		'type'            => 'number', // text, textarea, checkbox, checkbox_multiple, radio, select, number.
		'checkbox_label'  => '', // show text after checkbox.
		'options'         => array(), // array of keys/values for radio or select.
		'default'         => '', // value to pre-populate option with (before first save or on reset).
		'no_empty'        => false, // if user empties value, force default to be saved instead.
		'allow_html'      => false, // allow HTML to be used in the value.
		'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
			'min' => '1',
			'placeholder' => get_option( 'posts_per_page' ),
		),
		'class'           => '', // classes to add to input.
		'content'         => '', // custom content instead of input (HTML allowed).
		'custom_sanitize' => '', // function to do additional sanitization.
		'custom_content'  => '', // function for custom display of field input.
		'pro'             => true, // field input element disabled when Pro not active.
	);

	// URL Slug field.
	$url_slug_desc = __( 'Optionally change the default "%1$s" slug in URLs. Example: %2$s', 'church-theme-content' );
	$url_slug_field = array(
		'name'            => '',
		'after_name'      => $pro_tag, // append (Optional) or (Pro), etc.
		'desc'            => '',
		'type'            => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, content.
		'checkbox_label'  => '', // show text after checkbox.
		'options'         => array(), // array of keys/values for radio or select.
		'default'         => '', // value to pre-populate option with (before first save or on reset).
		'no_empty'        => false, // if user empties value, force default to be saved instead.
		'allow_html'      => false, // allow HTML to be used in the value.
		'attributes'      => array(), // attr => value array (e.g. set min/max for number or range type).
		'class'           => '', // classes to add to input.
		'content'         => '', // custom content instead of input (HTML allowed).
		'custom_sanitize' => 'ctc_sanitize_setting_url_slug', // function to do additional sanitization.
		'custom_content'  => '', // function for custom display of field input.
		'pro'             => true, // field input element disabled when Pro not active.
	);

	// Taxonomy URL Slug field.
	$taxonomy_url_slug_field = array(
		'name'            => '',
		'after_name'      => $pro_tag, // append (Optional) or (Pro), etc.
		'desc'            => '',
		'type'            => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, content.
		'checkbox_label'  => '', // show text after checkbox.
		'options'         => array(), // array of keys/values for radio or select.
		'default'         => '', // value to pre-populate option with (before first save or on reset).
		'no_empty'        => false, // if user empties value, force default to be saved instead.
		'allow_html'      => false, // allow HTML to be used in the value.
		'attributes'      => array(), // attr => value array (e.g. set min/max for number or range type).
		'class'           => '', // classes to add to input.
		'content'         => '', // custom content instead of input (HTML allowed).
		'custom_sanitize' => 'ctc_sanitize_setting_url_slug', // function to do additional sanitization.
		'custom_content'  => '', // function for custom display of field input.
		'pro'             => true, // field input element disabled when Pro not active.
	);

	// Hide in Admin Menu field.
	$hide_admin_field = array(
		'name'            => __( 'Hide in Admin Menu', 'church-theme-content' ),
		'after_name'      => $pro_tag, // append (Optional) or (Pro), etc.
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
		'pro'             => true, // field input element disabled when Pro not active.
	);

	/**********************************
	 * SETTINGS
	 **********************************/

	// Note to add to page description for Pro add-on when not active.
	$pro_upgrade_note = '';
	if ( ! ctc_pro_is_active() ) { // plugin not active.

		$pro_upgrade_note = sprintf(
			/* translators: %1$s is URL for Church Content Pro info. */
			__( '<a href="%1$s" target="_blank">Upgrade to Pro</a> to enable extra settings and features.', 'church-theme-content' ),
			esc_url( ctc_ctcom_url( 'church-content-pro', array( 'utm_content' => 'settings' ) ) )
		);

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
			/* translators: %1$s is Church Content plugin URL, %2$s is note about upgrading to Pro (if not active), %3$s is URL to Customizer. */
			__( 'These settings are for the <a href="%1$s" target="_blank">Church Content</a> plugin. %2$s Use the <a href="%3$s">Customizer</a> for theme-provided appearance settings.', 'church-theme-content' ),
			esc_url( ctc_ctcom_url( 'church-content', array( 'utm_content' => 'settings' ) ) ),
			$pro_upgrade_note,
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
					'sermon_seo' => array_merge( $seo_field, array(
						'checkbox_label' => __( 'Improve SEO for Sermons <span class="ctps-light ctps-italic">(Recommended)</span>', 'church-theme-content' ), // show text after checkbox.
					) ),

					// Sermon Podcasting (Shortcut).
					'podcasting_content' => array(
						'name'            => _x( 'Sermon Podcasting', 'settings', 'church-theme-content' ),
						'after_name'      => $pro_tag, // append (Optional) or (Pro), etc.
						'desc'            => '',
						'type'            => 'content', // text, textarea, checkbox, checkbox_multiple, radio, select, number, content.
						'checkbox_label'  => '', // show text after checkbox.
						'options'         => array(), // array of keys/values for radio or select.
						'default'         => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'        => false, // if user empties value, force default to be saved instead.
						'allow_html'      => false, // allow HTML to be used in the value.
						'attributes'      => array(), // attr => value array (e.g. set min/max for number or range type).
						'class'           => '', // classes to add to input.
						'content'         => __( '<a href="#">Podcasting Settings</a>', 'church-theme-content' ), // custom content instead of input (HTML allowed).
						'custom_sanitize' => '', // function to do additional sanitization.
						'custom_content'  => '', // function for custom display of field input.
						'pro'             => true, // field input element disabled when Pro not active.
					),

					// Sermons Per Page.
					'sermons_per_page' => array_merge( $per_page_field, array(
						'name' => __( 'Sermons Per Page', 'church-theme-content' ),
					) ),

					// Alternative Wording - Singular
					'sermon_word_singular' => array(
						'name'            => __( 'Alternative Wording', 'church-theme-content' ),
						'after_name'      => $pro_tag, // append (Optional) or (Pro), etc.
						'desc'            => '',
						'type'            => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number, content.
						'checkbox_label'  => '', // show text after checkbox.
						'options'         => array(), // array of keys/values for radio or select.
						'default'         => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'        => false, // if user empties value, force default to be saved instead.
						'allow_html'      => false, // allow HTML to be used in the value.
						'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_word_singular_default, // show the standard value if they leave blank.
						),
						'class'           => '', // classes to add to input.
						'content'         => '', // custom content instead of input (HTML allowed).
						'custom_sanitize' => '', // function to do additional sanitization.
						'custom_content'  => '', // function for custom display of field input.
						'pro'             => true, // field input element disabled when Pro not active.
					),

					// Alternative Wording - Plural
					'sermon_word_plural' => array(
						'name'            => '',
						'after_name'      => $pro_tag, // append (Optional) or (Pro), etc.
						'desc'            => sprintf(
							/* translators: %1$s is "Sermon" and %2$s is "Sermons" (translated). */
							__( 'Optionally enter alternative wording for "%1$s" and "%2$s" (e.g. "Message" and "Messages").', 'church-theme-content' ),
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
						),
						'class'           => '', // classes to add to input.
						'content'         => '', // custom content instead of input (HTML allowed).
						'custom_sanitize' => '', // function to do additional sanitization.
						'custom_content'  => '', // function for custom display of field input.
						'pro'             => true, // field input element disabled when Pro not active.
					),

					// Sermon URL Slug.
					'sermon_url_slug' => array_merge( $url_slug_field, array(
						'name'            => __( 'Sermon URL Slug', 'church-theme-content' ),
						'desc'            => sprintf(
							/* translators: %1$s is default slug, %2$s is example URL showing how post type slug is used. */
							$url_slug_desc,
							$sermon_url_slug_default,
							preg_replace( '/(.*)(\/(.*)\/)$/', '$1/<b>' . $sermon_url_slug_default . '</b>/', get_post_type_archive_link( 'ctc_sermon' ) ) // make slug bold.
						),
						'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_url_slug_default, // show the standard value if they leave blank.
						),
					) ),

					// Topic URL Slug.
					'sermon_topic_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'            => __( 'Topic URL Slug', 'church-theme-content' ),
						'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_topic_url_slug_default, // show the standard value if they leave blank.
						),
					) ),

					// Series URL Slug.
					'sermon_series_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'            => __( 'Series URL Slug', 'church-theme-content' ),
						'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_series_url_slug_default, // show the standard value if they leave blank.
						),
					) ),

					// Book URL Slug.
					'sermon_book_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'            => __( 'Book URL Slug', 'church-theme-content' ),
						'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_book_url_slug_default, // show the standard value if they leave blank.
						),
					) ),

					// Speaker URL Slug.
					'sermon_speaker_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'            => __( 'Speaker URL Slug', 'church-theme-content' ),
						'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_speaker_url_slug_default, // show the standard value if they leave blank.
						),
					) ),

					// Tag URL Slug.
					'sermon_tag_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'            => __( 'Tag URL Slug', 'church-theme-content' ),
						'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $sermon_tag_url_slug_default, // show the standard value if they leave blank.
						),
					) ),

					// Hide in Admin Menu.
					'sermons_admin_hide' => array_merge( $hide_admin_field, array(
						'checkbox_label' => __( 'Hide Sermons', 'church-theme-content' ), // show text after checkbox.
					) ),

				),

			),

			// Podcasting.
			'podcasting' => array(

				// Title.
				'title' => _x( 'Podcasting', 'settings section title', 'church-theme-content' ),

				// Description.
				'desc' => '',

				// Fields (Settings).
				'fields' => array(

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
						'after_name'      => $pro_tag, // append (Optional) or (Pro), etc.
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
					),

					// SEO Structured Data.
					'event_seo' => array_merge( $seo_field, array(
						'checkbox_label' => __( 'Improve SEO for Events <span class="ctps-light ctps-italic">(Recommended)</span>', 'church-theme-content' ), // show text after checkbox.
					) ),

					// Location Memory.
					'event_location_memory' => array(
						'name'            => __( 'Location Memory', 'church-theme-content' ),
						'after_name'      => $pro_tag, // append (Optional) or (Pro), etc.
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
							'default' => true, // value to set by Pro when first activated.
						),
					),

					// Events Per Page.
					'events_per_page' => array_merge( $per_page_field, array(
						'name' => __( 'Events Per Page', 'church-theme-content' ),
					) ),

					// Event URL Slug.
					'event_url_slug' => array_merge( $url_slug_field, array(
						'name'            => __( 'Event URL Slug', 'church-theme-content' ),
						'desc'            => sprintf(
							/* translators: %1$s is default slug, %2$s is example URL showing how post type slug is used. */
							$url_slug_desc,
							$event_url_slug_default,
							preg_replace( '/(.*)(\/(.*)\/)$/', '$1/<b>' . $event_url_slug_default . '</b>/', get_post_type_archive_link( 'ctc_event' ) ) // make slug bold.
						),
						'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $event_url_slug_default, // show the standard value if they leave blank.
						),
					) ),

					// Category URL Slug.
					'event_category_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'            => __( 'Category URL Slug', 'church-theme-content' ),
						'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $event_category_url_slug_default, // show the standard value if they leave blank.
						),
					) ),

					// Hide in Admin Menu.
					'events_admin_hide' => array_merge( $hide_admin_field, array(
						'checkbox_label' => __( 'Hide Events', 'church-theme-content' ), // show text after checkbox.
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
					'location_seo' => array_merge( $seo_field, array(
						'checkbox_label' => __( 'Improve SEO for Locations <span class="ctps-light ctps-italic">(Recommended)</span>', 'church-theme-content' ), // show text after checkbox.
					) ),

					// Google Maps API Key.
					'google_maps_api_key' => array(
						'name'            => _x( 'Google Maps API Key', 'settings', 'church-theme-content' ),
						'after_name'      => __( '(Required)', 'setting label', 'church-theme-content' ), // append (Optional) or (Pro), etc.
						'desc'            => sprintf(
							/* translators: %1$s is URL to guide telling user how to get a Google Maps API Key */
							__( 'An API Key for Google Maps is required if you want to show maps for locations or events. <a href="%1$s" target="_blank">Get an API Key</a>', 'church-theme-content' ),
							esc_url( ctc_ctcom_url( 'google-maps-api-key', array( 'utm_content' => 'settings' ) ) ) // how to get API key.
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
					),

					// Locations Per Page.
					'locations_per_page' => array_merge( $per_page_field, array(
						'name' => __( 'Locations Per Page', 'church-theme-content' ),
					) ),

					// Location URL Slug.
					'location_url_slug' => array_merge( $url_slug_field, array(
						'name'            => __( 'Location URL Slug', 'church-theme-content' ),
						'desc'            => sprintf(
							/* translators: %1$s is default slug, %2$s is example URL showing how post type slug is used. */
							$url_slug_desc,
							$location_url_slug_default,
							preg_replace( '/(.*)(\/(.*)\/)$/', '$1/<b>' . $location_url_slug_default . '</b>/', get_post_type_archive_link( 'ctc_location' ) ) // make slug bold.
						),
						'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $location_url_slug_default, // show the standard value if they leave blank.
						),
					) ),

					// Hide in Admin Menu.
					'locations_admin_hide' => array_merge( $hide_admin_field, array(
						'checkbox_label' => __( 'Hide Locations', 'church-theme-content' ), // show text after checkbox.
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
					'person_seo' => array_merge( $seo_field, array(
						'checkbox_label' => __( 'Improve SEO for People <span class="ctps-light ctps-italic">(Recommended)</span>', 'church-theme-content' ), // show text after checkbox.
					) ),

					// People Per Page.
					'people_per_page' => array_merge( $per_page_field, array(
						'name' => __( 'People Per Page', 'church-theme-content' ),
					) ),

					// Person URL Slug.
					'person_url_slug' => array_merge( $url_slug_field, array(
						'name'            => __( 'Person URL Slug', 'church-theme-content' ),
						'desc'            => sprintf(
							/* translators: %1$s is default slug, %2$s is example URL showing how post type slug is used. */
							$url_slug_desc,
							$person_url_slug_default,
							preg_replace( '/(.*)(\/(.*)\/)$/', '$1/<b>' . $person_url_slug_default . '</b>/', get_post_type_archive_link( 'ctc_person' ) ) // make slug bold.
						),
						'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $person_url_slug_default, // show the standard value if they leave blank.
						),
					) ),

					// Group URL Slug.
					'person_group_url_slug' => array_merge( $taxonomy_url_slug_field, array(
						'name'            => __( 'Group URL Slug', 'church-theme-content' ),
						'attributes'      => array( // attr => value array (e.g. set min/max for number or range type).
							'placeholder' => $person_group_url_slug_default, // show the standard value if they leave blank.
						),
					) ),

					// Hide in Admin Menu.
					'people_admin_hide' => array_merge( $hide_admin_field, array(
						'checkbox_label' => __( 'Hide People', 'church-theme-content' ), // show text after checkbox.
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

	// Disable Pro inputs when Pro not active.
	if ( ! ctc_pro_is_active() ) {

		// Loop sections.
		foreach ( $config['sections'] as $section_id => $section ) {

			// Have fields.
			if ( isset( $section['fields'] ) ) {

				// Loop fields.
				foreach ( $section['fields'] as $field_id => $field ) {

					// Field is Pro.
					if ( ! empty( $field['pro'] ) ) {

						// Make readonly so cannot change.
						$config['sections'][ $section_id ]['fields'][ $field_id ]['attributes'] = array_merge( $field['attributes'], array(
							'readonly' => 'readonly', // append attribute to array.
						) );

						// Add class to warn this requires Pro upgrade.
						$config['sections'][ $section_id ]['fields'][ $field_id ]['class'] = ' ctc-pro-setting-inactive'; // preceding space in case already have class (CT_Plugin_Settings will trim).

					}

				}

			}

		}

	}

	// Add settings.
	$ctc_settings = new CT_Plugin_Settings( $config );

}

add_action( 'init', 'ctc_settings_setup' );

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

/**********************************
 * GETTING SETTINGS
 **********************************/

/**
 * Get settings data
 *
 * This returns flat array of settings from ctc_settings_config(), without sections.
 *
 * This is used by:
 *
 * - ctc_setting() to force non-Pro default when Pro inactive.
 * - Pro plugin to change certain values when first activated.
 *
 * @since 1.9
 * @return array Settings array.
 */
function ctc_get_settings() {



}

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

	$value = $ctc_settings->get( $setting );

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

add_action( 'admin_print_footer_scripts', 'ctc_add_wp_per_page_desc' );

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
				__( 'Go to <a href="%1$s">Church Content Settings</a> to set custom URL slugs for sermons, events, etc.', 'church-theme-content' ),
				array(
					'a' => array(
						'href' => array(),
					),
				)
			),
			admin_url( 'options-general.php?page=' . CTC_DIR )
		);
		?>

	</p>

	<?php

}