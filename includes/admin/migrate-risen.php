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
					__( 'Click "Make Compatible" to make <b>sermons</b>, <b>events</b>, <b>locations</b> and <b>staff</b> in the Risen theme compatible with the <a href="%1$s" target="_blank">Church Content plugin</a> so that you can switch to a newer theme from <a href="%2$s" target="_blank">ChurchThemes.com</a>. Read the <a href="%3$s" target="_blank">Switching from Risen</a> guide for full details before proceeding.', 'church-theme-content' ),
					ctc_ctcom_url( 'church-content', array( 'utm_campaign' => 'migrate-risen' ) ),
					ctc_ctcom_url( 'home', array( 'utm_campaign' => 'migrate-risen' ) ),
					ctc_ctcom_url( 'migrate-risen' )
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
					ctc_ctcom_url( 'migrate-risen-backup' )
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

			<?php

			// Button arguments.
			$button_args = array(
				'onclick' => "var button = this; setTimeout( function() { button.disabled = true; button.value=' " . esc_attr( __( "Processing. Please wait...", 'church-theme-content' ) ) . "' }, 10 ) ;return true;",
			);

			// WordPress version is too old.
			// wp_insert_post()'s meta_input argument requires WordPress 4.4+.
			if ( version_compare( get_bloginfo( 'version' ), '4.4', '<' ) ) {

				// Disable button.
				$button_args['disabled'] = 'disabled';

				// Show message.
				echo '<p><i>';
				echo wp_kses(
					__( '<strong>Update WordPress:</strong> Please update WordPress to the latest version before running this tool.', 'church-theme-content' ),
					array(
						'strong' => array(),
						'i' => array(),
					)
				);
				echo '</i></p>';

			}

			// Show button.
			submit_button( esc_html( 'Make Compatible', 'church-theme-content' ), 'primary', 'submit', true, $button_args );

			?>

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
				__( 'Your <b>sermons</b>, <b>events</b>, <b>locations</b> and <b>staff</b> in the Risen theme have been made compatible with the <a href="%1$s" target="_blank">Church Content plugin</a>. Now you can switch to a newer theme from <a href="%2$s" target="_blank">ChurchThemes.com</a>. Read the <a href="%3$s" target="_blank">Switching from Risen</a> guide for additional instructions.', 'church-theme-content' ),
				ctc_ctcom_url( 'church-content', array( 'utm_campaign' => 'migrate-risen' ) ),
				ctc_ctcom_url( 'home', array( 'utm_campaign' => 'migrate-risen' ) ),
				ctc_ctcom_url( 'migrate-risen' )
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
				'_risen_multimedia_video_url'      => '_ctc_sermon_video',
				'_risen_multimedia_audio_url'      => '_ctc_sermon_audio',
				'_risen_multimedia_pdf_url'        => '_ctc_sermon_pdf',
				'_risen_multimedia_text'           => '_ctc_sermon_has_full_text',
			),
			'taxonomies' => array(
				'risen_multimedia_category'        => 'ctc_sermon_topic',
				'risen_multimedia_speaker'         => 'ctc_sermon_speaker',
				'risen_multimedia_tag'             => 'ctc_sermon_tag',
			),
		),
		'risen_event' => array(
			'ctc_post_type' => 'ctc_event',
			'fields' => array(
				'_risen_event_start_date'          => '_ctc_event_start_date',
				'_risen_event_end_date'            => '_ctc_event_end_date',
				'_risen_event_time'                => '_ctc_event_time',
				'_risen_event_recurrence'          => '_ctc_event_recurrence',
				'_risen_event_recurrence_end_date' => '_ctc_event_recurrence_end_date',
				'_risen_event_venue'               => '_ctc_event_venue',
				'_risen_event_address'             => '_ctc_event_address',
				'_risen_event_map_lat'             => '_ctc_event_map_lat',
				'_risen_event_map_lng'             => '_ctc_event_map_lng',
				'_risen_event_map_type'            => '_ctc_event_map_type',
				'_risen_event_map_zoom'            => '_ctc_event_map_zoom',
			),
		),
		'risen_location' => array(
			'ctc_post_type' => 'ctc_location',
			'fields' => array(
				'_risen_location_address'          => '_ctc_location_address',
				'_risen_location_directions'       => '_ctc_location_show_directions_link',
				'_risen_location_phone'            => '_ctc_location_phone',
				'_risen_location_contact'          => '_ctc_location_email',
				'_risen_location_map_lat'          => '_ctc_location_map_lat',
				'_risen_location_map_lng'          => '_ctc_location_map_lng',
				'_risen_location_map_type'         => '_ctc_location_map_type',
				'_risen_location_map_zoom'         => '_ctc_location_map_zoom',
			),
		),
		'risen_staff' => array(
			'ctc_post_type' => 'ctc_person',
			'fields' => array(
				'_risen_staff_position'            => '_ctc_person_position',
				'_risen_staff_contact'             => '_ctc_person_email',
			),
		),
	);

	// Loop post types.
	foreach ( $post_types as $post_type => $post_type_data ) {

		// Get taxonomies for post type.
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );

		// Loop taxonomies.
		$terms_map = array(); // map old ID to new ID for this post type.
		foreach ( $taxonomies as $taxonomy => $taxonomy_object ) {

			// Get taxonomy terms.
			$terms = get_terms( $taxonomy );

			// Taxonomy name.
			$results .= '<h4>' . esc_html( $taxonomy_object->label ) . ' (' . esc_html( count( $terms ) ) . ')</h4>';

			// Loop terms.
			foreach ( $terms as $term ) {

				$results .= '<div>' . esc_html( $term->name ) . '</div>';

				// Insert term if not already added to new taxonomy.
				$term_id = ctc_migrate_risen_duplicate_post_term( $term, $post_type_data );

				// Update terms map (old ID's to new).
				if ( $term_id ) {
					$terms_map[ $taxonomy ][ $term->term_id ] = $term_id;
				}

			}

			// Loop terms again (now that all added and have IDs) to set parents.
			foreach ( $terms as $term ) {

				// Has parent?
				if ( ! empty( $term->parent ) ) {

					// Get new term ID.
					$term_id = $terms_map[ $taxonomy ][ $term->term_id ];

					// Get parent's new term ID.
					$parent_id = $terms_map[ $taxonomy ][ $term->parent ];

					// Set parent.
					if ( $parent_id ) {

						wp_update_term( $term_id, $post_type_data['taxonomies'][ $term->taxonomy ], array(
							'parent' => $parent_id,
						) );

					}

				}

			}

		}

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

			$post_id = ctc_migrate_risen_duplicate_post( $post, $post_type_data, $terms_map );

			$results .= '<div>' . esc_html( $post->post_title ) . '</div>';

		}

	}

	// Additional.
	$results .= '<h4>Miscellaneous</h4>';

		// Set Google Maps API Key.
		if ( function_exists( 'risen_option' ) ) {

			// Get key from Theme Options.
			$google_maps_api_key = risen_option( 'gmaps_api_key' );

			// Set key in Church Content settings.
			if ( $google_maps_api_key ) {

				// Update option.
				ctc_update_setting( 'google_maps_api_key', $google_maps_api_key );

				// Results.
				$results .= '<div>' . __( 'Google Maps API Key set', 'church-theme-content' ) . '</div>';

			}

		}

		// Grandfather basic event recurrence.
		update_option( 'ctfw_grandfather_recurring_events', true ); // Tell Church Theme Framework to grandfather basic recurrence.
		update_option( 'ctfw_grandfather_recurring_events_checked', true ); // Save option to indicate check has been run, so don't run it again.
		$results .= '<div>' . __( 'Basic event recurrence grandfathered (Church Theme Framework)', 'church-theme-content' ) . '</div>';

	// Prevent notice asking to run tool from showing again,
	update_option( 'ctc_migrate_risen_processed', true );

	// Make results available for display.
	$ctc_migrate_risen_results = $results;

}

/**
 * Duplicate post (as new post type).
 *
 * @since 2.1
 * @param object $original_term Original term to duplicate.
 * @param string $post_type_data Array with data for handling duplication.
 * @return int $term_id New term's ID.
 */
function ctc_migrate_risen_duplicate_post_term( $original_term, $post_type_data ) {

	$term_id = 0;

	// Get new taxonomy.
	$new_taxonomy = ! empty( $post_type_data['taxonomies'][ $original_term->taxonomy ] ) ? $post_type_data['taxonomies'][ $original_term->taxonomy ] : false;

	// Have new taxonomy.
	if ( $new_taxonomy ) {

		// Term not already added (otherwise get ID).
		$term = term_exists( $original_term->name, $new_taxonomy );
		if ( ! ( 0 !== $term && null !== $term ) ) {

			// Duplicate as new term of new taxonomy (or update if was already converted).
			// Won't add it already exists (but won't update either).
			$term = wp_insert_term( $original_term->name, $new_taxonomy, array(
				'description' => $original_term->description,
				'slug' => $original_term->slug,
			) );

		}

		// Get new term ID.
		$term_id = isset( $term['term_id'] ) ? $term['term_id'] : 0;

	}

	// Return new ID.
	return $term_id;

}

/**
 * Duplicate post (as new post type).
 *
 * @since 2.1
 * @param object $post Original post to duplicate.
 * @param string $post_type_data Array with data for handling duplication.
 * @param string $terms_map Array mapping original term ID to new term ID.
 * @return int $post_id New post's ID.
 */
function ctc_migrate_risen_duplicate_post( $original_post, $post_type_data, $terms_map ) {

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
	$post->tax_input = isset( $post_type_data['taxonomies'] ) ? ctc_migrate_risen_tax_input( $original_post_id, $post_type_data['taxonomies'], $terms_map ) : array(); // set taxonomy terms.
	unset( $post->guid ); // generate a new GUID.
	$post_id = wp_insert_post( $post ); // add or update and get post ID if new.

	// Set featured image.
	$thumbnail_id = get_post_thumbnail_id( $original_post_id );
	if ( $thumbnail_id ) {
		set_post_thumbnail( $post_id, $thumbnail_id );
	}

	// Processing after save.
	switch ( $post_type_data['ctc_post_type'] ) {

		case 'ctc_sermon' :

			// Update the enclosure for this sermon.
			ctc_do_enclose( $post_id );

			break;

		case 'ctc_event' :

			// Correct event to update hidden event DATETIME fields, etc.
			ctc_correct_event( $post_id );

			break;

	}

	return $post_id;

}

/*******************************************
 * ADMIN
 *******************************************/

/**
 * Hide post type menu items
 *
 * Let Risen items show for now and not both Risen and Church Content.
 * When user finishes switch to Church Content then those will show.
 *
 * @since 2.1
 */
function ctc_migrate_risen_hide_menu_items( $args ) {

	// Hide menu items only when Risen is active.
	if ( ctc_migrate_risen_show() ) {
		$args['show_ui'] = false;
		$args['show_in_nav_menus'] = false;
	}

	return $args;

}

add_filter( 'ctc_post_type_sermon_args', 'ctc_migrate_risen_hide_menu_items' );
add_filter( 'ctc_post_type_event_args', 'ctc_migrate_risen_hide_menu_items' );
add_filter( 'ctc_post_type_location_args', 'ctc_migrate_risen_hide_menu_items' );
add_filter( 'ctc_post_type_person_args', 'ctc_migrate_risen_hide_menu_items' );


/*******************************************
 * NOTICES
 *******************************************/

/**
 * Show notice directing to migration tool.
 *
 * Risen stops showing its notice about being discontinued when Church Content plugin activated.
 * In place of that nows, show one directing user to the migration tool.
 *
 * @since 2.1
 */
function ctc_migrate_risen_notice() {

	// Risen must be active.
	if ( ! ctc_migrate_risen_show() ) {
		return;
	}

	// Show only on relevant pages as not to overwhelm admin (same places as Risen theme).
	$screen = get_current_screen();
	if ( ! ( in_array( $screen->base, array( 'dashboard', 'themes', 'plugins' ) ) || preg_match( '/^risen_.+/', $screen->post_type ) ) ) {
		return;
	}

	// Show only if tool has not yet been run.
	if ( get_option( 'ctc_migrate_risen_processed' ) ) {
		return;
	}

	// Notice.
	?>
	<div id="risen-ctc-migrate-notice" class="notice notice-warning">
		<p>
			<?php
			printf(
				wp_kses(
					__( 'Use the <a href="%1$s">Risen Theme to Church Content Plugin</a> migration tool to begin switching themes. <a href="%2$s" target="_blank">Learn More</a>', 'church-theme-content' ),
					array(
						'b' => array(),
						'a' => array(
							'href' => array(),
							'target' => array(),
						)
					)
				),
				esc_url( admin_url( 'tools.php?page=ctc-migrate-risen' ) ),
				ctc_ctcom_url( 'migrate-risen' )
			);
			?>
		</p>
	</div>
	<?php

}

add_action( 'admin_notices', 'ctc_migrate_risen_notice' );

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
	if ( function_exists( 'wp_get_theme' ) ) {

		$theme = wp_get_theme();

		if ( 'Risen' === $theme->get( 'Name' ) || 'risen' === $theme->get( 'Template' ) ) {
			$show = true;
		}

	}

	return $show;

}

/**
 * Build meta_input array.
 *
 * Return array to let wp_insert_post() set custom fields.
 *
 * @since 2.1
 * @param int $post_id Post ID to get meta for.
 * @param array $keys Array of keys.
 * @return array $meta_input Custom fields as array (key / value pairs).
 */
function ctc_migrate_risen_meta_input( $post_id, $keys ) {

	$meta_input = array();

	// Upload dir.
	$upload_dir = wp_upload_dir();

	// Loop fields.
	foreach ( $keys as $old_key => $new_key ) {

		// Meta value.
		$value = get_post_meta( $post_id, $old_key, true );

		// Replace [upload_url] with actual URL whenever necessary.
		$value = str_ireplace( '[upload_url]', $upload_dir['baseurl'], $value );

		// Get email address from contacts options.
		if ( in_array( $old_key, array( '_risen_staff_contact', '_risen_location_contact' ) ) ) {

			$found_email = false;

			// Have function for contacts.
			if ( function_exists( 'risen_contacts' ) ) {

				// Get contacts.
				$contacts = risen_contacts();

				// Loop contacts.
				foreach ( $contacts as $name => $email ) {

					// Match?
					if ( $value === md5( $email ) ) {

						// Set value as email.
						$found_email = $email;

						break;

					}

				}

			}

			// Set email if found.
			if ( $found_email ) {
				$value = $found_email;
			} else { // empty if not (so doesn't use md5).
				$value = '';
			}

		}

		// Assign value.
		$meta_input[ $new_key ] = $value;

	}

	return $meta_input;

}

/**
 * Build tax_input array.
 *
 * Return array to let wp_insert_post() set taxonomy terms.
 *
 * @since 2.1
 * @param array $original_post_id Original post's ID.
 * @param array $taxonomies Array of taxonomies.
 * @param array $terms_map Array mapping old ID's to new ID's.
 * @return array $tax_input Array of taxonomies with term IDs.
 */
function ctc_migrate_risen_tax_input( $original_post_id, $taxonomies, $terms_map ) {

	$tax_input = array();

	foreach ( $taxonomies as $old_taxonomy => $new_taxonomy ) {

		// Get original post's terms for this taxonomy.
		$terms = wp_get_post_terms( $original_post_id, $old_taxonomy );

		// Loop terms.
		foreach ( $terms as $term ) {

			// Hierarchical? Use IDs.
			if ( is_taxonomy_hierarchical( $old_taxonomy ) && ! empty( $terms_map[ $old_taxonomy ][ $term->term_id ] ) ) {

				// Add new term's ID to array.
				$tax_input[ $new_taxonomy ][] = $terms_map[ $old_taxonomy ][ $term->term_id ];

			}

			// Non-hierarchical, like tags (use names instead of IDs).
			elseif ( ! empty( $term->name ) ) {

				// Add new term's name to array.
				$tax_input[ $new_taxonomy ][] = $term->name;

			}

		}

	}

	return $tax_input;

}
