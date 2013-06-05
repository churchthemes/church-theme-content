<?php
/**
 * Plugin Name: Church Content Manager
 * Plugin URI: http://churchthemes.com/plugins/church-content-manager
 * Description: This plugin provides content management functionality for sermons, events, locations and people. It <strong>requires a compatible theme</strong> to display the content.
 * Author: churchthemes.com
 * Author URI: http://churchthemes.com
 * Version: 0.8.5
 * License: GPL2
 * 
 * Copyright 2012 - 2013 DreamDolphin Media, LLC
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * 
 * @package   Church_Content_Manager
 * @copyright Copyright (c) 2013, churchthemes.com
 * @link      https://github.com/churchthemes/church-content-manager
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/********************************************
 * CONSTANTS
 ********************************************/
		
/**
 * Get plugin data
 */

if ( ! function_exists( 'get_plugins' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

$ccm_plugin_data = current( get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) ) );

/**
 * Define constants
 */

// Plugin Data
define( 'CCM_VERSION', 		$ccm_plugin_data['Version'] );						// plugin version
define( 'CCM_NAME', 		$ccm_plugin_data['Name'] );							// plugin name
define( 'CCM_INFO_URL',		$ccm_plugin_data['PluginURI'] );					// plugin's info page URL
define( 'CCM_FILE', 		__FILE__ );											// plugin's main file path
define( 'CCM_DIR', 			dirname( plugin_basename( CCM_FILE ) ) );			// plugin's directory
define( 'CCM_PATH',			untrailingslashit( plugin_dir_path( CCM_FILE ) ) );	// plugin's directory
define( 'CCM_URL', 			untrailingslashit( plugin_dir_url( CCM_FILE ) ) );	// plugin's directory URL

// Include and Asset Directories
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

/********************************************
 * INCLUDES
 ********************************************/

/**
 * Files to include
 */
$ccm_includes = array(

	// Frontend or Admin
	'always' => array(
		
		// Functions
		CCM_INC_DIR . '/helpers.php',
		CCM_INC_DIR . '/localization.php',
		CCM_INC_DIR . '/mime-types.php',
		CCM_INC_DIR . '/post-types.php', 
		CCM_INC_DIR . '/schedule.php',
		CCM_INC_DIR . '/support.php',
		CCM_INC_DIR . '/taxonomies.php',
	),

	// Admin Only
	'admin' => array(
	
		// Functions
		CCM_ADMIN_DIR . '/activation.php',
		CCM_ADMIN_DIR . '/admin-helpers.php',
		CCM_ADMIN_DIR . '/event-fields.php',
		CCM_ADMIN_DIR . '/location-fields.php',
		CCM_ADMIN_DIR . '/person-fields.php',
		CCM_ADMIN_DIR . '/sermon-fields.php', 
		
		// Libraries
		CCM_LIB_DIR . '/ct-meta-box/ct-meta-box.php', // see CTMB_URL constant defined above

	),
	
	// Frontend Only
	/*
	'frontend' => array (

	),
	*/

);

/**
 * Load includes
 */
$ccm_includes = apply_filters( 'ccm_includes', $ccm_includes ); // make filterable
ccm_load_includes( $ccm_includes );

/**
 * Include loader function
 *
 * Include file based on whether or not condition is met.
 *
 * @since 0.5
 * @param array $includes Files to include'church-content-manager'
 */
function ccm_load_includes( $includes ) {
		
	// Loop conditions
	foreach ( $includes as $condition => $files ) {
	
		// Check condition
		$do_includes = false;
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
		
			foreach( $files as $file ) {			
				require_once trailingslashit( CCM_PATH ) . $file;				
			}
			
		}
		
	}

}
