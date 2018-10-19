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
			<?php submit_button( esc_html( 'Make Compatible', 'church-theme-content' ) ); ?>
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
	$results = array();

	// Do it...
	$results[] = 'result item';

	// Make results available for display.
	$ctc_migrate_risen_results = $results;

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
