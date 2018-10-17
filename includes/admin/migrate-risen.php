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
		esc_html__( 'Risen to Church Content', 'church-theme-content' ), // Page title.
		esc_html__( 'Risen to Church Content', 'church-theme-content' ), // Menu title.
		'edit_theme_options', // Capability (can manage Appearance > Widgets).
		'migrate-risen', // Menu Slug.
		'ctc_migrate_risen_page_content' // Callback for displaying page content.
	);

}

add_action( 'admin_menu', 'ctc_migrate_risen_page' );

/**
 * Page content
 *
 * @since 0.1
 */
function ctc_migrate_risen_page_content() {

	?>
	<div class="wrap">

		<h2><?php esc_html_e( 'Risen to Church Content', 'church-theme-content' ); ?></h2>

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
				__( 'Intro text here...', 'church-theme-content' ),
				array(
					'b' => array(),
				)
			);

			?>

		</p>

		<form method="post">
			<?php wp_nonce_field( 'ctc_migrate_risen', 'ctc_migrate_risen_nonce' ); ?>
			<?php submit_button( esc_html( 'Run Converter', 'church-theme-content' ) ); ?>
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

	<h3 class="title"><?php echo esc_html( 'Conversion Results', 'church-theme-content' ); ?></h3>

	<p>
		<?php echo esc_html_e( 'Text here...', 'church-theme-content' ); ?>
	</p>
`
	<p id="ctc-migrate-risen-results">

		<?php

		$results = $ctc_migrate_risen_results;

		echo '<pre>' . print_r( $results, 'true' ) . '</pre>';

		?>

	</p>

	<?php

}

/*******************************************
 * HELPERS
 *******************************************/

/**
 * Show Risen to Church Content tool?
 *
 * This is true only if Risen theme is active.
 *
 * @since 2.0
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
