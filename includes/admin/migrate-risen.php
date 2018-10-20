<?php
/**
 * Migrate from Risen Theme
 *
 * @package    Church_Theme_Content
 * @subpackage Admin
 * @copyright  Copyright (c) 2018, ChurchThemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      2.1
 */

// No direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*******************************************
 * PAGE
 *******************************************/

/**
 * Add page under Tools
 *
 * @since 2.1
 */
function ctc_migrate_risen_page() {

	// Risen must be active.
	if ( ! ctc_migrate_risen_show() ) {
		return;
	}

	// Add page.
	$page_hook = add_management_page(
		esc_html__( 'Risen Theme to Church Content Plugin', 'church-theme-content' ), // Page title.
		esc_html__( 'Risen to Church Content', 'church-theme-content' ), // Menu title.
		'switch_themes', // Capability (can manage Appearance > Widgets).
		'ctc-migrate-risen', // Menu Slug.
		'ctc_migrate_risen_page_content' // Callback for displaying page content.
	);

}

add_action( 'admin_menu', 'ctc_migrate_risen_page' );

/**
 * Page content
 *
 * @since 2.1
 */
function ctc_migrate_risen_page_content() {

	?>
	<div class="wrap">

		<h2><?php esc_html_e( 'Risen Theme to Church Content Plugin', 'church-theme-content' ); ?></h2>

		<?php

		// Show results if have them.
		if ( ctc_migrate_risen_have_results() ) {

			ctc_migrate_risen_show_results();

			// Don't show content below.
			return;

		}

		?>

		<p>

			<?php

			echo wp_kses(
				sprintf(
					__( 'Click "Make Compatible" to make <b>sermons</b>, <b>events</b>, <b>locations</b> and <b>people</b> in the Risen theme compatible with the <a href="%1$s" target="_blank">Church Content plugin</a> so that you can switch to a newer theme from <a href="%2$s" target="_blank">ChurchThemes.com</a>. Read the <a href="%3$s" target="_blank">Switching from Risen</a> guide for full details before proceeding.', 'church-theme-content' ),
					'https://churchthemes.com/plugins/church-content/',
					'https://churchthemes.com/',
					'https://churchthemes.com/go/switch-from-risen/'
				),
				array(
					'b' => array(),
					'a' => array(
						'href' => array(),
						'target' => array(),
					),
				)
			);

			?>

		</p>

		<p>

			<?php

			echo wp_kses(
				sprintf(
					__( 'This will not modify your content used by Risen. Instead, it will modify a copy of the content to be compatible with the Church Content plugin. This is a safeguard to ensure you can switch back to Risen. In any case, <a href="%1$s" target="_blank">make a full website backup</a> before running this tool and switching themes to be extra safe.', 'church-theme-content' ),
					'https://churchthemes.com/go/backups/'
				),
				array(
					'b' => array(),
					'em' => array(),
					'a' => array(
						'href' => array(),
						'target' => array(),
					),
				)
			);

			?>

		</p>

		<form method="post">
			<?php wp_nonce_field( 'ctc_migrate_risen', 'ctc_migrate_risen_nonce' ); ?>
			<?php submit_button( esc_html( 'Make Compatible', 'church-theme-content' ), 'primary', 'submit', true, array(
				'onclick' => "var button = this; setTimeout( function() { button.disabled = true; button.value=' " . esc_attr( __( "Processing. Please wait...", 'church-theme-content' ) ) . "' }, 10 ) ;return true;",
			) ); ?>
		</form>

		<?php if ( ! empty( $ctc_migrate_risen_results ) ) : ?>
			<p id="ctc-migrate-risen-results">
				<?php echo wp_kses_post( $ctc_migrate_risen_results ); ?>
			</p>
			<br/>
		<?php endif; ?>

	</div>

	<?php

}

/**
 * Have results to show?
 *
 * @since 2.1
 * @global string $ctc_migrate_risen_results
 * @return bool True if have import results to show
 */
function ctc_migrate_risen_have_results() {

	global $ctc_migrate_risen_results;

	if ( ! empty( $ctc_migrate_risen_results ) ) {
		return true;
	}

	return false;

}

/**
 * Show results
 *
 * This is shown in place of page's regular content.
 *
 * @since 2.1
 * @global string $ctc_migrate_risen_results
 */
function ctc_migrate_risen_show_results() {

	global $ctc_migrate_risen_results;

	?>

	<h2 class="title"><?php echo esc_html( 'Finished', 'church-theme-content' ); ?></h2>

	<p>

		<?php

		echo wp_kses(
			sprintf(
				__( 'Your <b>sermons</b>, <b>events</b>, <b>locations</b> and <b>people</b> in the Risen theme have been made compatible with the <a href="%1$s" target="_blank">Church Content plugin</a>. Now you can switch to a newer theme from <a href="%2$s" target="_blank">ChurchThemes.com</a>. Read the <a href="%3$s" target="_blank">Switching from Risen</a> guide for additional instructions.', 'church-theme-content' ),
				'https://churchthemes.com/plugins/church-content/',
				'https://churchthemes.com/',
				'https://churchthemes.com/go/switch-from-risen/'
			),
			array(
				'b' => array(),
				'a' => array(
					'href' => array(),
					'target' => array(),
				),
			)
		);

		?>

	</p>

	<p id="ctc-migrate-risen-results">

		<?php

		$results = $ctc_migrate_risen_results;

		echo $results;

		?>

	</p>

	<?php

}

/*******************************************
 * PROCESSING
 *******************************************/

/**
 * Process button submission.
 *
 * @since 2.1
 */
function ctc_migrate_risen_submit() {

	// Check nonce for security since form was submitted.
	// check_admin_referer prints fail page and dies.
	if ( ! empty( $_POST['submit'] ) && check_admin_referer( 'ctc_migrate_risen', 'ctc_migrate_risen_nonce' ) ) {

		// Process content.
		ctc_migrate_risen_process();

	}

}

add_action( 'load-tools_page_ctc-migrate-risen', 'ctc_migrate_risen_submit' );

/**
 * Process content conversion.
 *
 * @since 2.1
 * @global string $ctc_migrate_risen_results
 */
function ctc_migrate_risen_process() {

	global $ctc_migrate_risen_results;

	// Prevent interruption.
	set_time_limit( 0 );
	ignore_user_abort( true );

	// Begin results.
	$results = '';

	// Post types.
	$post_types = array(
		'risen_multimedia' => array(
			'ctc_post_type' => 'ctc_sermon',
			'fields' => array(
				'_risen_multimedia_video_url' => '_ctc_sermon_video',
				'_risen_multimedia_audio_url' => '_ctc_sermon_audio',
				'_risen_multimedia_pdf_url'   => '_ctc_sermon_pdf',
				'_risen_multimedia_text'      => '_ctc_sermon_has_full_text',
			),
			'taxonomies' => array(

			)
		),
		'risen_event' => array(
			'ctc_post_type' => 'ctc_event',
			'fields' => array(
				'' => '',
			),
			'taxonomies' => array(

			)
		),
		'risen_staff' => array(
			'ctc_post_type' => 'ctc_person',
			'fields' => array(
				'' => '',
			),
			'taxonomies' => array(

			)
		),
		'risen_location' => array(
			'ctc_post_type' => 'ctc_location',
			'fields' => array(
				'' => '',
			),
			'taxonomies' => array(

			)
		),
	);

	// Loop post types.
	foreach ( $post_types as $post_type => $post_type_data ) {

		// Get posts.
		$posts = get_posts( array(
			'posts_per_page'   => -1,
			'post_type'        => $post_type,
			'post_status'      => 'publish',
		) );

		// Post type data.
		$post_type_object = get_post_type_object( $post_type );
		$post_type_label = $post_type_object->labels->name;

		// Post type name.
		$results .= '<h4>' . esc_html( $post_type_label ) . ' (' . esc_html( count( $posts ) ) . ')</h4>';

		// Loop posts.
		foreach ( $posts as $post ) {

			$post_id = ctc_migrate_risen_duplicate( $post, $post_type_data );

			$results .= '<div>' . esc_html( $post->post_title ) . '</div>';

			// Featured image, etc.? Will image be attached to it? Some library for just duplicating, then modifying?
			// Google how to programatically copy a post, completely.

			// Assign new taxonomy (so convert those first?).

			// Don't forget custom fields.

			// And post-processing (MP# enclosure, recurring events, etc.).

		}

		// Get taxonomies for post type.
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );

		// Loop taxonomies.
		foreach ( $taxonomies as $taxonomy => $taxonomy_object ) {

			// Get taxonomy terms.
			$terms = get_terms( $taxonomy );

			// Taxonomy name.
			$results .= '<h4>' . esc_html( $taxonomy_object->label ) . ' (' . esc_html( count( $terms ) ) . ')</h4>';

			foreach ( $terms as $term ) {

				$results .= '<div>' . esc_html( $term->name ) . '</div>';



			}

		}

	}

	// Don't foget to grandfather basic recurrence by updating options.


	// Make results available for display.
	$ctc_migrate_risen_results = $results;

}

/**
 * Duplicate post (as new post type).
 *
 * @since 2.0
 * @param object $post Original post to duplicate.
 * @param string $post_type_data Array with data for handling duplication.
 * @return int $post_id New post's ID.
 */
function ctc_migrate_risen_duplicate( $original_post, $post_type_data ) {

	// Original post ID.
	$original_post_id = $original_post->ID;

	// Get post if was already converted, so can update instead of adding again.
	$converted_post = get_page_by_path( $original_post->post_name, OBJECT, $post_type_data['ctc_post_type'] );
	$post_id = isset( $converted_post->ID ) ? $converted_post->ID : 0; // 0 causes wp_insert_post() to make new post versus updating existing.

	// Duplicate as new post type (or update if was already converted).
	$post = $original_post;
	$post->post_type = $post_type_data['ctc_post_type']; // use new post type.
	$post->ID = $post_id; // update if was already added so can run this tool again safely.
	$post->meta_input = ctc_migrate_risen_meta_input( $original_post_id, $post_type_data['fields'] ); // copy post meta.
	unset( $post->guid ); // generate a new GUID.
	$post_id = wp_insert_post( $post ); // add or update and get post ID if new.

	// Featured image?


	// What about slug not being unique?
	// Or is it fine because different post type?
	// See this: https://github.com/10up/secure-duplicate-post/blob/master/duplicate-post-admin.php#L315

	// Show message in place of button when not WP 4.4.4 or newer? meta_input added in that version.


	return $post_id;

}

/*******************************************
 * HELPERS
 *******************************************/

/**
 * Show Risen to Church Content tool?
 *
 * This is true only if Risen theme is active.
 *
 * @since 2.1
 * @return bool True if Risen active.
 */
function ctc_migrate_risen_show() {

	$show = false;

	// Risen theme is active.
	if ( function_exists( 'wp_get_theme' ) && 'Risen' === (string) wp_get_theme() ) {
		$show = true;
	}

	return $show;

}

/**
 * Get a post's custom fields.
 *
 * Return array with CC plugin's keys for use with wp_insert_post().
 *
 * @since 2.1
 * @param int $post_id Post ID to get meta for.
 * @param array $fields Array of keys.
 * @param array $fields Custom fields as array (key / value pairs).
 */
function ctc_migrate_risen_meta_input( $post_id, $keys ) {

	$fields = array();

	foreach ( $keys as $old_key => $new_key ) {
		$fields[ $new_key ] = get_post_meta( $post_id, $old_key, true );
	}

	return $fields;

}
