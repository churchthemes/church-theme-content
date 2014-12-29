<?php
/**
 * Plugin Settings
 *
 * Setup and retrieve plugin settings.
 *
 * @package    Church_Theme_Content
 * @copyright  Copyright (c) 2014, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      1.2
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**********************************
 * SETTINGS SETUP
 **********************************/

/**
 * Init settings class
 *
 * This will add settings page and make $ctc_settings object available for settings retrieval
 *
 * @since 1.2
 * @global object $ctc_settings
 */
function ctc_settings_setup() {

	global $ctc_settings;

	// Configuration
	$config = array(

		// Master Option
		// All settings will be saved as an array under this single option ID
		'option_id'		=> 'ctc_settings',

		// Titles
		'page_title' 	=> sprintf( __( '%1$s Settings', 'church-theme-content' ), CTC_NAME ),
		'menu_title'	=> CTC_NAME,

		// Settings page description
						/* translators: %1$s is Church Theme Content plugin URL, %2$s is add-ons URL */
		'desc'			=> sprintf(
							__( 'These settings are for the <a href="%1$s" target="_blank">Church Theme Content</a> plugin and its <a href="%2$s" target="_blank">Add-ons</a>.', 'church-theme-content' ),
							'http://churchthemes.com/plugins/church-theme-content/?utm_source=ctc&utm_medium=plugin&utm_campaign=church-theme-content&utm_content=settings',
							'http://churchthemes.com/plugins/?utm_source=ctc&utm_medium=plugin&utm_campaign=add-ons&utm_content=settings'
						),

		// Plugin File
		'plugin_file'	=> CTC_FILE,	// path to plugin's main file

		// URL for CT Plugin Settings directory
		// This is used for loading its CSS and JS files
		'url'			=> CTC_URL . '/' . CTC_LIB_DIR . '/ct-plugin-settings',

		// Section Tabs
		'sections' => array(

			// Future
			// - Possibly add extendable "Add-on Settings" with section for each add-on, like EDD
			// - It would sit next to the existing "Add-on Licenses" tab, like EDD

			// Add-on Licenses
			'licenses' => array(

				// Title
				'title'	=> _x( 'Add-on Licenses', 'settings', 'church-theme-content' ),

				// Description
				'desc'	=> sprintf(
								/* translators: %1$s is URl to Add-ons */
								__( 'Save then activate your add-on license keys to enable one-click updates for them.', 'church-theme-content' ),
								'http://churchthemes.com/plugins/?utm_source=ctc&utm_medium=plugin&utm_campaign=add-ons&utm_content=settings'
							),

				// Fields (Settings)
				'fields' => array(

					// Example
					/*
					'setting_key' => array(
						'name'				=> __( 'Field Name', 'church-theme-content' ),
						'desc'				=> __( 'This is the description below the field.', 'church-theme-content' ),
						'type'				=> 'text', // text, textarea, checkbox, radio, select, number
						'checkbox_label'	=> '', //show text after checkbox
						'options'			=> array(), // array of keys/values for radio or select
						'default'			=> '', // value to pre-populate option with (before first save or on reset)
						'no_empty'			=> false, // if user empties value, force default to be saved instead
						'allow_html'		=> false, // allow HTML to be used in the value
						'class'				=> '', // classes to add to input
						'custom_sanitize'	=> '', // function to do additional sanitization
						'custom_content'	=> '', // function for custom display of field input
					),
					*/

				)

			),

			/*
			// Second Section
			'second_section' => array(

				// Title
				'title'	=> __( 'Second Section', 'church-theme-content' ),

				// Description
				'desc'	=> __( 'Second section description.', 'church-theme-content' ),

				// Fields (Settings)
				'fields' => array(

					// Example
					'setting_key' => array(
						'name'				=> __( 'Field Name', 'church-theme-content' ),
						'desc'				=> __( 'This is the description below the field.', 'church-theme-content' ),
						'type'				=> 'text', // text, textarea, checkbox, radio, select, number
						'checkbox_label'	=> '', //show text after checkbox
						'options'			=> array(), // array of keys/values for radio or select
						'default'			=> '', // value to pre-populate option with (before first save or on reset)
						'no_empty'			=> false, // if user empties value, force default to be saved instead
						'allow_html'		=> false, // allow HTML to be used in the value
						'class'				=> '', // classes to add to input
						'custom_sanitize'	=> '', // function to do additional sanitization
						'custom_content'	=> '', // function for custom display of field input
					),

				)

			),
			*/

		)

	);

	// Filter config
	$config = apply_filters( 'ctc_settings_config', $config );

	// Add settings
	$ctc_settings = new CT_Plugin_Settings( $config );

}

add_action( 'init', 'ctc_settings_setup' );

/**********************************
 * SETTINGS DATA
 **********************************/

/**
 * Get a setting
 *
 * @since 1.2
 * @param string $setting Setting key
 * @return mixed Setting value
 * @global object $ctc_settings
 */
function ctc_setting( $setting ) {

	global $ctc_settings;

	$value = $ctc_settings->get( $setting );

	return apply_filters( 'ctc_setting', $value, $setting );

}
