<?php
/**
 * Feature Support
 *
 * Handle support for plugin features based on theme support and plugin settings.
 */

/*********************************************
 * FEATURE DATA
 *********************************************/
 
/**
 * Get Feature Data
 *
 * Used for mapping features to post types, theme support and so on.
 * Al feature data returned when $feature is empty
 */

function ccm_get_feature_data( $feature = false ) {
 
	// Feature data
	$features = array(
	
		'sermons' => array(
			'theme_support'	=> 'ccm-sermons', 	// theme support feature name
			'post_type'		=> 'ccm_sermon', 	// post type feature requires
		),
		
		'events' => array(
			'theme_support'	=> 'ccm-events',
			'post_type'		=> 'ccm_event',
		),
		
		'people' => array(
			'theme_support'	=> 'ccm-people',
			'post_type'		=> 'ccm_person',
		),
		
		'locations' => array(
			'theme_support'	=> 'ccm-locations',
			'post_type'		=> 'ccm_location',
		),

	);
	
	// Add feature to array values for ease of use
	foreach ( $features as $feature_key => $feature_data ) {
		$features[$feature_key]['feature'] = $feature_key;
	}
	
	// Return specific feature
	if ( ! empty( $feature ) ) {
		if ( isset( $features[$feature] ) ) { // feature data exists
			return apply_filters( 'ccm_get_feature_data-' . $feature, $features[$feature] );
		}
	}
	
	// Return all features
	else {
		return apply_filters( 'ccm_get_feature_data', $features );
	}
	
	// In case feature given but not valid
	return false;
	
}

/**
 * Get feature data by post type
 */

function ccm_get_feature_data_by_post_type( $post_type ) {

	$data = false;

	// Get all features
	$features = ccm_get_feature_data();

	// Loop features to find post type and get feature data
	foreach ( $features as $feature_key => $feature_data ) {

		// Post type given used by this feature
		if ( $post_type == $feature_data['post_type'] ) {
		
			$data = $feature_data;
			
			break;

		}	
	}

	// Return filterable
	return apply_filters( 'ccm_get_feature_data_by_post_type', $data, $post_type );

}

/****************************************
 * THEME SUPPORT
 ****************************************

 /**
  * Default features for unsupported themes
  *
  * If no add_theme_support( 'ccm' ), add support for all features with no arguments.
  * This causes all content to be revealed in case admin switched to unsupported theme.
  * They can then develop the theme for the plugin or retrieve their content.
  */
 
add_action( 'init', 'ccm_set_default_theme_support', 1 ); // init 1 is right after after_setup_theme when theme add support but earlier than normal plugin init at 10

function ccm_set_default_theme_support() {

	// Theme does not support plugin
	if ( ! current_theme_supports( 'ccm' ) ) {
	
		// Loop features
		$features = ccm_get_feature_data();
		foreach ( $features as $feature_key => $feature_data ) {
		
			// Add support with no arguments so defaults are used (everything)
			add_theme_support( $feature_data['theme_support'] );
			
		}
	
	}

}
 
/**
 * Get theme support data for a feature
 *
 * Optionally specify an argument to get that data
 */

function ccm_get_theme_support( $feature, $argument = null ) {

	$data = false;

	// Theme has support
	if ( $support = get_theme_support( $feature ) ) {

		// Get theme support data
		$support = isset( $support[0] ) ? $support[0] : false;

		// Use data for specific argument
		if ( isset( $argument ) ) { // argument given
			if ( is_array( $support ) && isset( $support[$argument] ) ) { // argument is set (even if empty)
				$data = $support[$argument];
			} else {
				$data = null; // so return value will return false for isset()
			}
		}
		
		// Use all arguments
		else {
			$data = $support;
		}
	
	}
	
	// Return data
	return apply_filters( 'ccm_get_theme_support', $data, $feature, $argument );

}

/**
 * Get theme support data based on post type
 *
 * Optionally specify an argument to get that data
 */

function ccm_get_theme_support_by_post_type( $post_type, $argument = null ) {

	$data = false;

	// Get feature based on post type
	if ( $feature_data = ccm_get_feature_data_by_post_type( $post_type ) ) {
	
		// Get data for feature/argument
		$data = ccm_get_theme_support( $feature_data['theme_support'], $argument );
		
	}		
	
	// Return data
	return apply_filters( 'ccm_get_theme_support_by_post_type', $data, $post_type, $argument );

}
 
/*********************************************
 * FEATURE CHECKING
 *********************************************/

/**
 * Check if feature is supported
 */
 
function ccm_feature_supported( $feature ) {

	$supported = false;
	
	// Get feature data
	if ( $feature_data = ccm_get_feature_data( $feature ) ) { // valid feature returns data

		// Does theme support feature?
		if ( current_theme_supports( $feature_data['theme_support'] ) ) {
		
			$supported = true;	

			// (in future could override support via plugin settings here)
			
		}
		
	}
	
	// Return filtered
	return apply_filters( 'ccm_feature_supported', $supported, $feature );
	
}

/**
 * Check if taxonomy is supported
 */

function ccm_taxonomy_supported( $feature, $taxonomy ) {

	$supported = false;
	
	// Get feature data
	if ( $feature_data = ccm_get_feature_data( $feature ) ) { // valid feature returns data

		// Theme taxonomies are specified
		$theme_taxonomies = ccm_get_theme_support( $feature_data['theme_support'], 'taxonomies' );
		if ( isset( $theme_taxonomies ) ) {

			// Taxonomy is explicitly supported
			if ( in_array( $taxonomy, (array) $theme_taxonomies ) ) {
				$supported = true;
			}
		
		}
		
		// Theme taxonomies are not specified
		// Default is to use all taxonomies when support not explicit, so anything returns true
		else {
			$supported = true;				
		}
		
		// (if true, could override with false using plugin settings here)
		// (checking if show_ui is true is not enhough since this is used during taxonomy registration)

	}
	
	// Return filtered
	return apply_filters( 'ccm_taxonomy_supported', $supported, $feature, $taxonomy );
	
}

/**
 * Check if field is supported
 */
 
function ccm_field_supported( $feature, $field ) {

	$supported = false;
	
	// Get feature data
	if ( $feature_data = ccm_get_feature_data( $feature ) ) { // valid feature returns data

		// Theme fields are specified
		$theme_fields = ccm_get_theme_support( $feature_data['theme_support'], 'fields' );
		if ( isset( $theme_fields ) ) {

			// Field is explicitly supported
			if ( in_array( $field, (array) $theme_fields ) ) {
				$supported = true;
			}
		
		}
		
		// Theme fields are not specified
		// Default is to use all fields when support not explicit, so anything returns true
		else {
			$supported = true;				
		}
		
		// (if true, can override with false using plugin settings here)

	}
	
	// Return filtered
	return apply_filters( 'ccm_field_supported', $supported, $feature, $field );
	
}

/*********************************************
 * FIELD FILTERING
 *********************************************/
 
/**
 * Filter Meta Box Fields
 *
 * Add filters for CT_Meta_Box to set visibility and override data on fields
 * based on theme support and possibly in future plugin settings.
 */
 
add_action( 'init', 'ccm_filter_fields' );

function ccm_filter_fields() {

	// Loop features to filter their fields
	$features = ccm_get_feature_data();
	foreach ( $features as $feature_key => $feature_data ) {
	
		// Has post type, filter CT_Meta_Box configs
		if ( isset( $feature_data['post_type'] ) ) {
		
			// Set Visible Fields
			add_filter( 'ctmb_visible_fields-' . $feature_data['post_type'], 'ccm_set_visible_fields', 10, 2 );
			
			// Set Field Overrides
			add_filter( 'ctmb_field_overrides-' . $feature_data['post_type'], 'ccm_set_field_overrides', 10, 2 );
			
		}

	}

}

/**
 * Set Visible Fields
 *
 * Show or hide CT_Meta_Box fields for a post type based on add_theme_support.
 * Door is open for plugin settings to override in future.
 */

function ccm_set_visible_fields( $visible_fields, $post_type ) {
	
	// All fields
	$original_visible_fields = $visible_fields;
	
	// Filter visible fields based on theme support
	// If not set, all fields are used by default
	// If set and empty, all fields will be hidden
	$theme_fields = ccm_get_theme_support_by_post_type( $post_type, 'fields' );
	if ( isset( $theme_fields ) ) {
	
		// Make new array out of fields theme supports
		$visible_fields = $theme_fields;

		// Add support for fields that are not from Church Content Manager
		// (otherwise they would need to be in add_theme_support arguments)
		foreach( $original_visible_fields as $field ) {
			if ( ! preg_match( '/^_ccm_.+$/', $field ) ) { // CCM fields are prefixed by "_ccm_"
				$visible_fields[] = $field;
			}
		}
		
	}

	// (here plugin settings could disable fields supported by theme)
	
	// Return default or filtered field list
	return $visible_fields;

}

/**
 * Set Field Overrides
 *
 * Override CT_Meta_Box field data for a post type based on add_theme_support.
 */
 
function ccm_set_field_overrides( $field_overrides, $post_type ) {

	// Return field overrides, if any
	return ccm_get_theme_support_by_post_type( $post_type, 'field_overrides' );

}	

/*********************************************
 * ADMIN NOTICE
 *********************************************/

/**
 * Show Notice
 *
 * Show a message if current theme does not support the plugin.
 */

add_action( 'admin_notices', 'ccm_get_theme_support_notice' );

function ccm_get_theme_support_notice() {

	// Theme does not support plugin
	if ( ! current_theme_supports( 'ccm' ) ) {

		// Option ID
		$theme_data = wp_get_theme();
		$option_id = 'ccm_hide_theme_support_notice-' . $theme_data['Template']; // unique to theme so if change, message shows again

		// Message has not been dismissed for this theme
		if ( ! get_option( $option_id  ) ) {
			
			?>
			<div class="updated">
			   <p><?php printf( __( 'The <b>%1$s</b> theme does not support the <b>%2$s</b> plugin. <a href="%3$s" target="_blank">More Information</a>, <a href="%4$s">Dismiss</a>', 'church-content-manager' ), wp_get_theme(), CCM_NAME, CCM_INFO_URL, add_query_arg('ccm_hide_theme_support_notice', '1' ) ); ?></p>
			</div>
			<?php
			
		}
	
	}

}

/**
 * Dismiss Notice
 *
 * Save data to keep message from showing on this theme.
 */

add_action( 'admin_init', 'ccm_hide_theme_support_notice' ); // before admin_notices

function ccm_hide_theme_support_notice() {

	// User requested dismissal
	if ( ! empty( $_GET['ccm_hide_theme_support_notice'] ) ) {

		// Option ID
		$theme_data = wp_get_theme();
		$option_id = 'ccm_hide_theme_support_notice-' . $theme_data['Template']; // unique to theme so if change, message shows again

		// Mark notice for this theme as dismissed
		update_option( $option_id, '1' );
			
	}

}
