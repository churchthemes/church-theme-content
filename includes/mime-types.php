<?php
/**
 * Mime Types
 *
 * @package    Church_Theme_Content
 * @subpackage Functions
 * @copyright  Copyright (c) 2013, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add mime types for media upload
 *
 * The sermon feature supports audio, video and PDF. Make sure these files can be uploaded.
 * The audio and video types below are supported by the MediaElement.js core WordPress player.
 *
 * See wp_get_mime_types() for available mime types.
 *
 * @since 0.9
 * @param array $mime_types Currently uploadable mime types
 * @return array Mime types with additions
 */
function ctc_add_mime_types( $mime_types ) {

	// Sermon feature supported?
	if ( ctc_feature_supported( 'sermons' ) ) {

		// Video
		$mime_types['webm']			= 'video/webm';
		$mime_types['ogv']			= 'video/ogg';
		$mime_types['mp4|m4v']		= 'video/mp4';
		$mime_types['wmv']			= 'video/x-ms-wmv';
		$mime_types['mov|qt']		= 'video/quicktime';
		$mime_types['flv']			= 'video/x-flv';

		// Audio
		$mime_types['mp3|m4a|m4b']	= 'audio/mpeg';
		$mime_types['ogg|oga']		= 'audio/ogg';
		$mime_types['wma']			= 'audio/x-ms-wma';
		$mime_types['wav']			= 'audio/wav';

		// PDF
		$mime_types['pdf']			= 'application/pdf';

	}

	return $mime_types;

}

add_filter( 'upload_mimes', 'ctc_add_mime_types' );

/**
 * Add mime types for media filtering
 *
 * The media manager will have a new PDF filter in addition to the default Image, Video and Audio options.
 * This makes it easier to manage sermon PDF's
 *
 * 'application/pdf' can also then be used as upload_type in sermon's PDF field (as 'audio' is for MP3).
 *
 * @since  0.9
 * @param array $post_mime_types Default mime types
 * @return array Modified mime types
 */
function ctc_add_post_mime_types( $post_mime_types ) {

	// PDF
	// No need to escape these strings - core handles it
	$post_mime_types['application/pdf'] = array(
		__( 'PDF', 'church-theme-content' ),
		__( 'Manage PDFs', 'church-theme-content' ),
		_n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>', 'church-theme-content' )
	);

	return $post_mime_types;

}

add_filter( 'post_mime_types', 'ctc_add_post_mime_types' );
