<?php
/**
 * Mime Types
 *
 * @package    Church_Content_Manager
 * @subpackage Functions
 * @copyright  Copyright (c) 2013, churchthemes.com
 * @link       https://github.com/churchthemes/church-content-manager
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      0.5
 */

/**
 * Add Mime Types
 *
 * Add mime types to the array provided by WordPress core (image, audio, video).
 * 
 * This makes it easier to manage sermon PDF's in media manager.
 * 'application/pdf' can also be used as upload_type in sermon's PDF field (as 'audio' is for MP3).
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'post_mime_types', 'ccm_post_mime_types' );

function ccm_post_mime_types( $post_mime_types ) {

	// PDF
	$post_mime_types['application/pdf'] = array(
		__( 'PDF', 'church-content-manager' ),
		__( 'Manage PDFs', 'church-content-manager' ),
		_n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>', 'church-content-manager' )
	);

	return $post_mime_types;

}
