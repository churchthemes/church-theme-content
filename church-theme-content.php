<?php
/**
 * Plugin Name: Church Theme Content
 * Plugin URI: http://churchthemes.com/plugins/church-theme-content
 * Description: Provides compatible themes with sermon, event, person and location post types. A <strong>compatible theme is required</strong> for displaying content.
 * Version: 1.1.1
 * Author: churchthemes.com
 * Author URI: http://churchthemes.com
 * License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: church-theme-content
 * Domain Path: /languages
 *
 * @package   Church_Theme_Content
 * @copyright Copyright (c) 2013 - 2014, churchthemes.com
 * @link      https://github.com/churchthemes/church-theme-content
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

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

		// Set plugin data
		add_action( 'plugins_loaded', array( &$this, 'set_plugin_data' ), 1 );

		// Define constants
		add_action( 'plugins_loaded', array( &$this, 'define_constants' ), 1 );

		// Load language file
		add_action( 'plugins_loaded', array( &$this, 'load_textdomain' ), 1 );

		// Set includes
		add_action( 'plugins_loaded', array( &$this, 'set_includes' ), 1 );

		// Load includes
		add_action( 'plugins_loaded', array( &$this, 'load_includes' ), 1 );

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
		if ( ! function_exists( 'get_plugins' ) ) {
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
		define( 'CTC_INFO_URL',		$this->plugin_data['PluginURI'] );					// plugin's info page URL
		define( 'CTC_FILE', 		__FILE__ );											// plugin's main file path
		define( 'CTC_DIR', 			dirname( plugin_basename( CTC_FILE ) ) );			// plugin's directory
		define( 'CTC_PATH',			untrailingslashit( plugin_dir_path( CTC_FILE ) ) );	// plugin's directory
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
		if ( ! defined( 'CTMB_URL' ) ) { // in case also used in theme or other plugin
			define( 'CTMB_URL', CTC_URL . '/' . CTC_LIB_DIR . '/ct-meta-box' ); // for enqueing JS/CSS
		}

	}

	/**
	 * Load language file
	 *
	 * This will load the MO file for the current locale.
	 * The translation file must be named church-theme-content-$locale.mo.
	 *
	 * First it will check to see if the MO file exists in wp-content/languages/plugins.
	 * If not, then the 'languages' direcory inside the plugin will be used.
	 * It is ideal to keep translation files outside of the plugin to avoid loss during updates.
	 *
	 * @since 0.9
	 * @access public
	 */
	public function load_textdomain() {

		// Textdomain
		$domain = 'church-theme-content';

		// WordPress core locale filter
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		// WordPress 3.6 and earlier don't auto-load from wp-content/languages, so check and load manually
		// http://core.trac.wordpress.org/changeset/22346
		$external_mofile = WP_LANG_DIR . '/plugins/'. $domain . '-' . $locale . '.mo';
		if ( get_bloginfo( 'version' ) <= 3.6 && file_exists( $external_mofile ) ) { // external translation exists
			load_textdomain( $domain, $external_mofile );
		}

		// Load normally
		// Either using WordPress 3.7+ or older version with external translation
		else {
			$languages_dir = CTC_DIR . '/' . trailingslashit( CTC_LANG_DIR ); // ensure trailing slash
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

				// Functions
				CTC_INC_DIR . '/helpers.php',
				CTC_INC_DIR . '/mime-types.php',
				CTC_INC_DIR . '/post-types.php',
				CTC_INC_DIR . '/schedule.php',
				CTC_INC_DIR . '/support.php',
				CTC_INC_DIR . '/taxonomies.php',
			),

			// Admin only
			'admin' => array(

				// Functions
				CTC_ADMIN_DIR . '/activation.php',
				CTC_ADMIN_DIR . '/admin-helpers.php',
				CTC_ADMIN_DIR . '/admin-menu.php',
				CTC_ADMIN_DIR . '/admin-posts.php',
				CTC_ADMIN_DIR . '/admin-support.php',
				CTC_ADMIN_DIR . '/event-fields.php',
				CTC_ADMIN_DIR . '/import.php',
				CTC_ADMIN_DIR . '/location-fields.php',
				CTC_ADMIN_DIR . '/person-fields.php',
				CTC_ADMIN_DIR . '/sermon-fields.php',

				// Libraries
				CTC_LIB_DIR . '/ct-meta-box/ct-meta-box.php', // see CTMB_URL constant defined above

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
		foreach ( $includes as $condition => $files ) {

			$do_includes = false;

			// Check condition
			switch( $condition ) {

				// Admin Only
				case 'admin':

					if ( is_admin() ) {
						$do_includes = true;
					}

					break;

				// Frontend Only
				case 'frontend':

					if ( ! is_admin() ) {
						$do_includes = true;
					}

					break;

				// Admin or Frontend (always)
				default:

					$do_includes = true;

					break;

			}

			// Loop files if condition met
			if ( $do_includes ) {

				foreach ( $files as $file ) {
					require_once trailingslashit( CTC_PATH ) . $file;
				}

			}

		}

	}

}

// Instantiate the main class
new Church_Theme_Content();
