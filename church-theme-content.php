<?php
/**
 * Plugin Name: Church Content
 * Plugin URI: https://churchthemes.com/plugins/church-content/
 * Description: Provides an interface for managing sermons, events, people and locations. A <strong>compatible theme is required</strong> for presenting content from these church-centric post types in a tightly-integrated manner.
 * Version: 2.6.2
 * Author: ChurchThemes.com
 * Author URI: https://churchthemes.com
 * License: GPLv2 or later
 * Text Domain: church-theme-content
 * Domain Path: /languages
 *
 * @package   Church_Theme_Content
 * @copyright Copyright (c) 2013 - 2024, ChurchThemes.com, LLC
 * @link      https://github.com/churchthemes/church-theme-content
 * @license   GPLv2 or later
 */

// No direct access
if (! defined( 'ABSPATH' )) exit;

/**
 * Main class
 *
 * @since 0.9
 */
class Church_Theme_Content {

	/**
	 * Plugin data from get_plugins()
	 *
	 * @since 0.9
	 * @var object
	 */
	public $plugin_data;

	/**
	 * Includes to load
	 *
	 * @since 0.9
	 * @var array
	 */
	public $includes;

	/**
	 * Constructor
	 *
	 * Add actions for methods that define constants and load includes.
	 *
	 * @since 0.9
	 * @access public
	 */
	public function __construct() {

		// Set plugin data.
		add_action( 'plugins_loaded', array( $this, 'set_plugin_data' ), 1 );

		// Define constants.
		add_action( 'plugins_loaded', array( $this, 'define_constants' ), 1 );

		// Load language file for old versions of WordPress.
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ), 1 );

		// Set includes.
		add_action( 'plugins_loaded', array( $this, 'set_includes' ), 1 );

		// Load includes.
		add_action( 'plugins_loaded', array( $this, 'load_includes' ), 1 );

		// Trigger flushing of rewrite rules on plugin activation.
		// This must be done early (not on plugins_loaded or init).
		register_activation_hook( __FILE__, array( &$this, 'trigger_flush_rewrite_rules' ) );

		// Check if rewrite rules should be flushed.
		add_action( 'init', array( $this, 'ctc_check_flush_rewrite_rules' ), 1 );

	}

	/**
	 * Set plugin data
	 *
	 * This data is used by constants.
	 *
	 * @since 0.9
	 * @access public
	 */
	public function set_plugin_data() {

		// Load plugin.php if get_plugins() not available
		if (! function_exists( 'get_plugins' )) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		// Get path to plugin's directory
		$plugin_dir = plugin_basename( dirname( __FILE__ ) );

		// Get plugin data
		$plugin_data = current( get_plugins( '/' . $plugin_dir ) );

		// Set plugin data
		$this->plugin_data = apply_filters( 'ctc_plugin_data', $plugin_data );

	}

	/**
	 * Define constants
	 *
	 * @since 0.9
	 * @access public
	 */
	public function define_constants() {

		// Plugin details
		define( 'CTC_VERSION', 		$this->plugin_data['Version'] );					// plugin version
		define( 'CTC_NAME', 		$this->plugin_data['Name'] );						// plugin name
		define( 'CTC_AUTHOR', 		strip_tags( $this->plugin_data['Author'] ) );		// plugin author
		define( 'CTC_INFO_URL',		$this->plugin_data['PluginURI'] );					// plugin's info page URL
		define( 'CTC_FILE', 		__FILE__ );											// plugin's main file absolute path
		define( 'CTC_FILE_BASE', 	plugin_basename( CTC_FILE ) );						// plugin's main file path relative to plugin directory
		define( 'CTC_DIR', 			dirname( CTC_FILE_BASE ) );							// plugin's directory
		define( 'CTC_PATH',			untrailingslashit( plugin_dir_path( CTC_FILE ) ) );	// plugin's absolute path
		define( 'CTC_URL', 			untrailingslashit( plugin_dir_url( CTC_FILE ) ) );	// plugin's directory URL

		// Directories
		define( 'CTC_INC_DIR',		'includes' );					// includes directory
		define( 'CTC_ADMIN_DIR',	CTC_INC_DIR . '/admin' );		// admin directory
		define( 'CTC_CLASS_DIR', 	CTC_INC_DIR . '/classes' );		// classes directory
		define( 'CTC_LIB_DIR', 		CTC_INC_DIR . '/libraries' );	// libraries directory
		define( 'CTC_CSS_DIR', 		'css' );						// stylesheets directory
		define( 'CTC_JS_DIR', 		'js' );							// JavaScript directory
		define( 'CTC_IMG_DIR', 		'images' );						// images directory
		define( 'CTC_LANG_DIR', 	'languages' );					// languages directory

		// CT Meta Box
		if (! defined( 'CTMB_URL' )) { // in case also used in theme or other plugin
			define( 'CTMB_URL', CTC_URL . '/' . CTC_LIB_DIR . '/ct-meta-box' ); // for enqueueing JS/CSS
		}

	}

	/**
	 * Load language file
	 *
	 * For WordPress versions under 4.6 only. https://make.wordpress.org/core/2016/07/06/i18n-improvements-in-4-6/
	 *
	 * This will load the MO file for the current locale.
	 * The translation file must be named church-theme-content-$locale.mo.
	 *
	 * First it will check to see if the MO file exists in wp-content/languages/plugins.
	 * If not, then the 'languages' directory inside the plugin will be used.
	 * It is ideal to keep translation files outside of the plugin to avoid loss during updates.
	 *
	 * @since 0.9
	 * @access public
	 */
	public function load_textdomain() {

		// Get version of WordPress in use.
		$wp_version = get_bloginfo( 'version' );

		// Textdomain.
		$domain = 'church-theme-content';

		// WordPress core locale filter.
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		// WordPress 3.6 and earlier don't auto-load from wp-content/languages, so check and load manually: http://core.trac.wordpress.org/changeset/22346.
		$external_mofile = WP_LANG_DIR . '/plugins/' . $domain . '-' . $locale . '.mo';
		if (version_compare( $wp_version, '3.6', '<=' ) && file_exists( $external_mofile )) { // external translation exists.
			load_textdomain( $domain, $external_mofile );
		}

		// Load normally.
		// Either using WordPress 3.7+ or older version with external translation.
		else {
			$languages_dir = CTC_DIR . '/' . trailingslashit( CTC_LANG_DIR ); // ensure trailing slash.
			load_plugin_textdomain( $domain, false, $languages_dir );
		}

	}

	/**
	 * Set includes
	 *
	 * @since 0.9
	 * @access public
	 */
	public function set_includes() {

		$this->includes = apply_filters( 'ctc_includes', array(

			// Frontend or admin
			'always' => array(

				// Functions.
				CTC_INC_DIR . '/add-ons.php',
				CTC_INC_DIR . '/event-fields.php',
				CTC_INC_DIR . '/helpers.php',
				CTC_INC_DIR . '/mime-types.php',
				CTC_INC_DIR . '/podcast.php',
				CTC_INC_DIR . '/post-types.php',
				CTC_INC_DIR . '/schedule.php',
				CTC_INC_DIR . '/settings.php',
				CTC_INC_DIR . '/support.php',
				CTC_INC_DIR . '/taxonomies.php',

				// Libraries.
				CTC_LIB_DIR . '/ct-plugin-settings/ct-plugin-settings.php', // see CTPS_URL constant defined above.
				CTC_LIB_DIR . '/ct-recurrence/ct-recurrence-load.php', // don't load ct-recurrence.php directly.

				// Classes.

			),

			// Admin only.
			'admin' => array(

				// Functions
				CTC_ADMIN_DIR . '/admin-add-ons.php',
				CTC_ADMIN_DIR . '/admin-enqueue-scripts.php',
				CTC_ADMIN_DIR . '/admin-enqueue-styles.php',
				CTC_ADMIN_DIR . '/admin-event-fields.php',
				CTC_ADMIN_DIR . '/admin-helpers.php',
				CTC_ADMIN_DIR . '/admin-location-fields.php',
				CTC_ADMIN_DIR . '/admin-maps.php',
				CTC_ADMIN_DIR . '/admin-menu.php',
				CTC_ADMIN_DIR . '/admin-person-fields.php',
				CTC_ADMIN_DIR . '/admin-posts.php',
				CTC_ADMIN_DIR . '/admin-sermon-fields.php',
				CTC_ADMIN_DIR . '/admin-support.php',
				CTC_ADMIN_DIR . '/dashboard.php',
				CTC_ADMIN_DIR . '/edd-license.php',
				CTC_ADMIN_DIR . '/editor.php',
				CTC_ADMIN_DIR . '/import.php',
				CTC_ADMIN_DIR . '/migrate-risen.php',
				CTC_ADMIN_DIR . '/notices.php',
				CTC_ADMIN_DIR . '/upgrade.php',

				// Libraries.
				CTC_LIB_DIR . '/ct-meta-box/ct-meta-box.php', // see CTMB_URL constant defined above

				// Classes.
				CTC_CLASS_DIR . '/CTC_Dashboard_News.php', // see CTMB_URL constant defined above

			),

			// Frontend only
			/*
			'frontend' => array (

			),
			*/

		) );

	}

	/**
	 * Load includes
	 *
 	 * Include files based on whether or not condition is met.
	 *
	 * @since 0.9
	 * @access public
	 */
	public function load_includes() {

		// Get includes
		$includes = $this->includes;

		// Loop conditions
		foreach ($includes as $condition => $files) {

			$do_includes = false;

			// Check condition
			switch($condition) {

				// Admin Only
				case 'admin':

					if (is_admin()) {
						$do_includes = true;
					}

					break;

				// Frontend Only
				case 'frontend':

					if (! is_admin()) {
						$do_includes = true;
					}

					break;

				// Admin or Frontend (always)
				default:

					$do_includes = true;

					break;

			}

			// Loop files if condition met
			if ($do_includes) {

				foreach ($files as $file) {
					require_once trailingslashit( CTC_PATH ) . $file;
				}

			}

		}

	}

	/**
	 * Trigger flushing of rewrite rules.
	 *
	 * Doing this on activation makes post type rewrite slugs take effect.
	 *
	 * @since 1.0
	 * @access public
	 */
	public static function trigger_flush_rewrite_rules() {

		// Tell to flush rules after post types registered.
		update_option( 'ctc_flush_rewrite_rules', '1' );

	}

	/**
	 * Check if rewrite rules should be flushed.
	 *
	 * This checks if ctc_flush_rewrite_rules option has been set earlier
	 * so that the rewrite rules can be flushed later.
	 */
	public function ctc_check_flush_rewrite_rules() {

		// Check if option was set.
		if (get_option( 'ctc_flush_rewrite_rules' )) {

			// Flush rewrite rules.
			flush_rewrite_rules();

			// Delete option so this doesn't run again.
			delete_option( 'ctc_flush_rewrite_rules' );

		}

	}

}

// Instantiate the main class.
new Church_Theme_Content();
