<?php
/**
 * Plugin Name: Church Content Manager
 * Plugin URI: http://churchthemes.com/plugins/church-content-manager
 * Description: This plugin provides content management functionality for sermons, events, locations and people. It <strong>requires a compatible theme</strong> to display the content.
 * Version: 0.8.5
 * Author: churchthemes.com
 * Author URI: http://churchthemes.com
 * License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * 
 * @package   Church_Content_Manager
 * @copyright Copyright (c) 2013, churchthemes.com
 * @link      https://github.com/churchthemes/church-content-manager
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Main class
 *
 * @since 0.9
 */
class Church_Content_Manager {

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
		$this->plugin_data = apply_filters( 'ccm_plugin_data', $plugin_data );

	}

	/**
	 * Define constants
	 *
	 * @since 0.9
	 * @access public
	 */
	public function define_constants() {

		// Plugin details
		define( 'CCM_VERSION', 		$this->plugin_data['Version'] );					// plugin version
		define( 'CCM_NAME', 		$this->plugin_data['Name'] );						// plugin name
		define( 'CCM_INFO_URL',		$this->plugin_data['PluginURI'] );					// plugin's info page URL
		define( 'CCM_FILE', 		__FILE__ );											// plugin's main file path
		define( 'CCM_DIR', 			dirname( plugin_basename( CCM_FILE ) ) );			// plugin's directory
		define( 'CCM_PATH',			untrailingslashit( plugin_dir_path( CCM_FILE ) ) );	// plugin's directory
		define( 'CCM_URL', 			untrailingslashit( plugin_dir_url( CCM_FILE ) ) );	// plugin's directory URL

		// Directories
		define( 'CCM_INC_DIR',		'includes' );					// includes directory
		define( 'CCM_ADMIN_DIR',	CCM_INC_DIR . '/admin' );		// admin directory
		define( 'CCM_CLASS_DIR', 	CCM_INC_DIR . '/classes' );		// classes directory
		define( 'CCM_LIB_DIR', 		CCM_INC_DIR . '/libraries' );	// libraries directory
		define( 'CCM_CSS_DIR', 		'css' );						// stylesheets directory
		define( 'CCM_JS_DIR', 		'js' );							// JavaScript directory
		define( 'CCM_IMG_DIR', 		'images' );						// images directory
		define( 'CCM_LANG_DIR', 	'languages' );					// languages directory

		// CT Meta Box
		if ( ! defined( 'CTMB_URL' ) ) { // in case also used in theme or other plugin
			define( 'CTMB_URL', CCM_URL . '/' . CCM_LIB_DIR . '/ct-meta-box' ); // for enqueing JS/CSS
		}

	}

	/**
	 * Load language file
	 *
	 * This will load the MO file for the current locale.
	 * The translation file must be named church-content-manager-$locale.mo.
	 * 
	 * First it will check to see if the MO file exists in wp-content/languages/plugins.
	 * If not, then the 'languages' direcory inside the plugin will be used.
	 * It is ideal to keep translation files outside of the plugin to avoid loss during updates.
	 *
	 * To Do: load_plugin_textdomain() will presumably be updated as load_theme_textdomain() was to 
	 * natively support external loading from WP_LANG_DIR. When this is so, simplify this function.
	 * http://core.trac.wordpress.org/changeset/22346
	 *
	 * @since 0.9
	 * @access public
	 */
	public function load_textdomain() {

		// Textdomain
		$domain = 'church-content-manager';

		// WordPress core locale filter
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		// Does external MO file exist? Load it
		// This is ideal since it is not wiped out by plugin updates
		$external_mofile = WP_LANG_DIR . '/plugins/'. $domain . '-' . $locale . '.mo';
		if ( file_exists( $external_mofile ) ) {
			load_textdomain( $domain, $external_mofile );
		}

		// Otherwise use MO file stored in plugin
		// This is not ideal except for pre-made, unedited translations included with the plugin
		else {
			$languages_dir = CCM_DIR . '/' . trailingslashit( CCM_LANG_DIR ); // ensure trailing slash
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

		$this->includes = apply_filters( 'ccm_includes', array(

			// Frontend or admin
			'always' => array(
				
				// Functions
				CCM_INC_DIR . '/helpers.php',
				CCM_INC_DIR . '/mime-types.php',
				CCM_INC_DIR . '/post-types.php', 
				CCM_INC_DIR . '/schedule.php',
				CCM_INC_DIR . '/support.php',
				CCM_INC_DIR . '/taxonomies.php',
			),

			// Admin only
			'admin' => array(
			
				// Functions
				CCM_ADMIN_DIR . '/activation.php',
				CCM_ADMIN_DIR . '/admin-helpers.php',
				CCM_ADMIN_DIR . '/admin-support.php',
				CCM_ADMIN_DIR . '/event-fields.php',
				CCM_ADMIN_DIR . '/location-fields.php',
				CCM_ADMIN_DIR . '/person-fields.php',
				CCM_ADMIN_DIR . '/sermon-fields.php', 
				
				// Libraries
				CCM_LIB_DIR . '/ct-meta-box/ct-meta-box.php', // see CTMB_URL constant defined above

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
					require_once trailingslashit( CCM_PATH ) . $file;				
				}
				
			}
			
		}

	}

}

// Instantiate the main class
new Church_Content_Manager();
