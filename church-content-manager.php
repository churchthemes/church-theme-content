<?php
/*
Plugin Name: Church Content Manager
Plugin URI: http://churchthemes.com/plugins/church-content-manager
Description: This plugin provides content management functionality for sermons, events, gallery items, locations and people. It <strong>requires a compatible theme</strong> to display the content.
Author: churchthemes.com
Author URI: http://churchthemes.com
License: GPL2
Version: 0.5

Copyright 2012 DreamDolphin Media, LLC

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// No Direct Access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/********************************************
 * CONSTANTS
 ********************************************/
		
/**
 * Get Plugin Data
 */

if ( ! function_exists( 'get_plugins' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

$ccm_plugin_data = current( get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) ) );

/**
 * Define Constants
 */

// Plugin Data
define( 'CCM_VERSION', 		$ccm_plugin_data['Version'] );						// plugin version
define( 'CCM_NAME', 		$ccm_plugin_data['Name'] );							// plugin name
define( 'CCM_INFO_URL',		$ccm_plugin_data['PluginURI'] );					// plugin's info page URL
define( 'CCM_FILE', 		__FILE__ );											// plugin's main file path
define( 'CCM_DIR', 			dirname( plugin_basename( CCM_FILE ) ) ); 			// plugin's directory
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

// CT Meta Box
if ( ! defined( 'CTMB_URL' ) ) { // in case also used in theme
	//define( 'CTMB_URL', CCM_URL . '/' . CCM_LIB_DIR . '/ct-meta-box' ); // for enqueing JS/CSS
}

// DO SIMILAR FOR CT OPTIONS HERE?
// DO SIMILAR FOR CT OPTIONS HERE?
// DO SIMILAR FOR CT OPTIONS HERE?
// DO SIMILAR FOR CT OPTIONS HERE?
// DO SIMILAR FOR CT OPTIONS HERE?
// DO SIMILAR FOR CT OPTIONS HERE?

/********************************************
 * INCLUDES
 ********************************************/

/**
 * Files to Include
 */

$ccm_includes = array(

	// Frontend or Admin
	'always' => array(
		
		// Functions
		CCM_INC_DIR . '/localization.php',
		CCM_INC_DIR . '/support.php',
		CCM_INC_DIR . '/post-types.php', 
		CCM_INC_DIR . '/taxonomies.php',
		CCM_INC_DIR . '/helpers.php',
	),

	// Admin Only
	'admin' => array(
	
		// Functions
		CCM_ADMIN_DIR . '/activation.php',
		CCM_ADMIN_DIR . '/admin-js.php',
		CCM_ADMIN_DIR . '/admin-css.php',
		CCM_ADMIN_DIR . '/sermon-fields.php', 
		CCM_ADMIN_DIR . '/event-fields.php',
		CCM_ADMIN_DIR . '/gallery-fields.php',
		CCM_ADMIN_DIR . '/person-fields.php',
		CCM_ADMIN_DIR . '/location-fields.php',
		CCM_ADMIN_DIR . '/maps.php',
		
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
 * Load Includes
 */
 
$ccm_includes = apply_filters( 'ccm_includes', $ccm_includes ); // make filterable
ccm_load_includes( $ccm_includes );

/**
 * Include Loader Function
 *
 * Include file based on whether or not condition is met.
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
