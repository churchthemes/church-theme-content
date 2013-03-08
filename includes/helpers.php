<?php
/**
 * Helper Functions
 */

/*************************************************
 * URLs & PATHS
 *************************************************/
 
/**
 * File URL
 *
 * An easy way to get the URL of a file.
 */

function ccm_file_url( $file, $directory = false ) {

	if ( ! empty( $directory ) ) {
		$path = trailingslashit( $directory ) . $file;
	} else {
		$path = $file;
	}
	
	$path = trailingslashit( CCM_URL ) . $path;
	
	return apply_filters( 'ccm_file_url', $path, $file, $directory );
}

/**
 * File Path
 *
 * An easy way to get the absolute path of a file.
 */

function ccm_file_path( $file, $directory = false ) {

	if ( ! empty( $directory ) ) {
		$path = trailingslashit( $directory ) . $file;
	} else {
		$path = $file;
	}
	
	$path = trailingslashit( CCM_PATH ) . $path;
	
	return apply_filters( 'ccm_file_path', $path, $file, $directory );
}

/*************************************************
 * ARRAYS
 *************************************************/

/**
 * Merge an array into another array after a specific key
 *
 * Meant for one dimensional associative arrays.
 * Used to insert post type overview columns.
 */

function ccm_array_merge_after_key( $original_array, $insert_array, $after_key ) {

	$modified_array = array();

	// loop original array items
	foreach( $original_array as $item_key => $item_value ) {
	
		// rebuild the array one item at a time
		$modified_array[$item_key] = $item_value;
		
		// insert array after specific key
		if ( $item_key == $after_key ) {
			$modified_array = array_merge( $modified_array, $insert_array );
		}
	
	}

	return apply_filters( 'ccm_array_merge_after_key', $modified_array, $original_array, $insert_array, $after_key );

}