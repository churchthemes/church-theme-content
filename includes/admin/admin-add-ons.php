<?php/** * Add-ons in Admin * * Admin functions relating to add-ons. * * @package    Church_Theme_Content * @subpackage Admin * @copyright  Copyright (c) 2014 - 2016 churchthemes.com * @link       https://github.com/churchthemes/church-theme-content * @license    GPLv2 or later * @since      1.2 */// No direct accessif ( ! defined( 'ABSPATH' ) ) exit;/************************************************* * ADD-ON DATA *************************************************//** * Get all add-ons * * @since 1.2 * @return array Addons and their data passed in when registered * @global array $ctc_add_ons */function ctc_get_add_ons() {	global $ctc_add_ons;	$add_ons = array();	if ( isset( $ctc_add_ons ) ) {		$add_ons = $ctc_add_ons;	}	return apply_filters( 'ctc_get_add_ons', $add_ons );}/** * Get single add-on * * Get single add-on. Optionally get an add-on's argument when specified. * * @since 1.2 * @param string Add-on's directory name * @param string Optional argument name to get value for * @return mixed Arguments, single argument or false */function ctc_get_add_on( $add_on_dir, $arg = false ) {	$data = false;	// Get add-ons	$add_ons = ctc_get_add_ons();	// Valid add-on?	if ( isset( $add_ons[$add_on_dir] ) ) {		// Get add-on data		$data = $add_ons[$add_on_dir];		// Get specific argument?		if ( ! empty( $arg ) ) {			// Is argument valid? Use value			if ( isset( $data[$arg] ) ) {				$data = $data[$arg];			}			// If invalid, return false (not array)			else {				$data = false;			}		}	}	return apply_filters( 'ctc_get_add_on', $data, $add_on_dir, $arg );}/************************************************* * PLUGINS SCREEN *************************************************//** * Add "Upgrade to Pro" plugin meta link * * This will insert a link into the plugin's meta links (after "View details") on the Plugins screen * * @since 1.2 * @param array $plugin_meta An array of the plugin's metadata * @param string $plugin_file Path to the plugin file, relative to the plugins directory * @param array $plugin_data An array of plugin data * @param string $status Status of the plugin * @return array Modified meta links */function ctc_pro_upgrade_plugin_meta_link( $plugin_meta, $plugin_file, $plugin_data, $status ) {	// Modify only this plugin's meta links.	if ( $plugin_file === CTC_FILE_BASE ) {		// Only if Pro plugin not active already.		if ( ! ctc_pro_is_active() ) {			// Have links array?			if ( is_array( $plugin_meta ) ) {				// Append "Upgrade to Pro" link.				$pro_url = ctc_ctcom_url( 'church-content-pro', array( 'utm_content' => 'plugins' ) );				$plugin_meta[] = '<a href="' . esc_url( $pro_url ) . '" target="_blank">' . esc_html__( 'Upgrade to Pro', 'church-theme-content' ) . '</a>';			}		}	}	// Return links array, possibly modified.	return $plugin_meta;}add_filter( 'plugin_row_meta', 'ctc_pro_upgrade_plugin_meta_link', 10, 4 );/** * Add "License Key" link to add-on plugin's action links * * This adds "License Key" link after other action links for each add-on supporting licensing on Plugins screen. * * @since 1.2 * @param array $actions An array of plugin action links. * @param string $plugin_file Path to the plugin file. * @param array $plugin_data An array of plugin data. * @param string $context The plugin context. * @return array Modified action links */function ctc_add_ons_plugin_meta_links( $actions, $plugin_file, $plugin_data, $context ) {	$plugin_dirname = dirname( $plugin_file );	// Is this plugin a CTC add-on that supports licensing.	if ( ctc_edd_license_supported( $plugin_dirname ) ) {		// Have action links array?		if ( is_array( $actions ) ) {			// Append "License Key" link.			$actions[] = '<a href="' . admin_url( 'options-general.php?page=' . CTC_DIR ) . '#licenses">' . esc_html__( 'License Key', 'church-theme-content' ) . '</a>';		}	}	return $actions;}add_filter( 'plugin_action_links', 'ctc_add_ons_plugin_meta_links', 10, 4 );/************************************************* * POST FIELDS *************************************************//** * Append "Upgrade to Pro" note below Recurrence field description when basic recurrence supported. * * Inform user of Pro add-on by appending note to Recurrence field's description. * This only runs when the basic recurrence field is supported, either by theme or grandfathering. * * Also see ctc_no_recurrence_field_upgrade_note() for note to show when basic recurrence not supported. * * @since 1.9 * @param array $field Field settings. * @return array Modified field settings. */function ctc_recurrence_field_upgrade_note( $field ) {	$note = '';	// Neither Pro nor Custom Recurring Events active.	if ( ! ctc_pro_is_active() && ! ctc_cre_is_active() ) {		// Note.		// Descriptions are sanitized with wp_kses automatically by CT Meta Box. <a> tag allowed.		$note = sprintf(			/* translators: %1$s is URL for Church Content Pro plugin */			__( 'Upgrade to <a href="%1$s" target="_blank">Church Content Pro</a> for more recurrence options.', 'church-theme-content' ),			esc_url( ctc_ctcom_url( 'church-content-pro', array( 'utm_content' => 'settings' ) ) )		);	}	// Custom Recurring Events is active.	elseif ( ! ctc_pro_is_active() && ctc_cre_is_active() ) {		// Note.		// Descriptions are sanitized with wp_kses automatically by CT Meta Box. <a> tag allowed.		$note = sprintf(			/* translators: %1$s is URL for upgrading to Church Content Pro from Custom Recurring Events */			__( 'Upgrade to <a href="%1$s" target="_blank">Church Content Pro</a> for more options than Custom Recurring Events.', 'church-theme-content' ),			esc_url( ctc_ctcom_url( 'cre-to-pro', array( 'utm_content' => 'settings' ) ) )		);	}	// Append note below Recurrence field.	if ( $note ) {		// Description key may not be set.		$field['desc'] = isset( $field['desc'] ) ? $field['desc'] : '';		// If has desc, break to new line.		if ( ! empty( $field['desc'] ) ) {			$field['desc'] .= '<br>';		}		// Append note.		// Descriptions are sanitized with wp_kses automatically by CT Meta Box. <a> tag allowed.		$field['desc'] .= $note;	}	return $field;}add_action( 'ctmb_field-_ctc_event_recurrence', 'ctc_recurrence_field_upgrade_note' );/** * Add empty "Recurrence" psuedo-field with "Upgrade to Pro" note when basic recurrence not supported. * * Also see ctc_recurrence_field_upgrade_note() for note to show when basic recurrence is supported. * * @since 1.9 * @param object $instance Meta box instance. */function ctc_no_recurrence_field_upgrade_note( $instance ) {	// Only event's Date & Time metabox.	if ( ! isset( $instance->meta_box['id'] ) || 'ctc_event_date' !== $instance->meta_box['id'] ) {		return;	}	// Get event fields that are supported by theme.	$supported_fields = ctc_get_theme_support( 'ctc-events', 'fields' );	// Only if specific fields are supported.	// Because, if no fields specified, all are automatically supported (including the basic recurrence fields).	if ( ! isset( $supported_fields ) ) {		return;	}	// Only if no recurrence field support (no theme support, grandfathering, Pro or Custom Recurring events).	if ( in_array( '_ctc_event_recurrence', $supported_fields ) ) {		return;	}	// Add "Recurrence" psuedo-field with message about enabling recurrence with Pro add-on.	?>	<div id="ctmb-field-_ctc_event_recurrence" class="ctmb-field ctmb-field-type-select">		<div class="ctmb-name">Recurrence</div>		<div class="ctmb-value">			<p class="description">				<?php                printf(                    wp_kses(						/* translators: %1$s is URL for Church Content Pro add-on */                        __( 'Upgrade to <a href="%1$s" target="_blank">Church Content Pro</a> to save time with recurring events.', 'church-theme-content' ),                        array(                            'a' => array(                                'href' => array(),                                'target' => array(),                            )                        )                    ),					esc_url( ctc_ctcom_url( 'church-content-pro', array( 'utm_content' => 'recurrence_field' ) ) )                );				?>			</p>		</div>	</div>	<?php}add_action( 'ctmb_after_fields', 'ctc_no_recurrence_field_upgrade_note' );/** * Show "Upgrade to Pro" notice at top of event's Location meta box. * * This tells them Pro gives them location memory and autocomplete to save time. * * @since 1.9 * @param object $meta_box Meta box instance from CT Meta Box class. */function ctc_event_location_memory_upgrade_note( $meta_box ) {	// Only if Pro plugin not active.	if ( ctc_pro_is_active() ) {		return;	}	// Only on Location meta box.	if ( 'ctc_event_location' !== $meta_box->meta_box['id'] ) {		return;	}	// Only if Venue and/or Address field supported.	// Otherwise, upgrading to Pro has no advantage with these.	if ( ! ctc_field_supported( 'events', '_ctc_event_venue' ) && ! ctc_field_supported( 'events', '_ctc_event_address' ) ) {		return;	}	// Output upgrade message.	?>	<p>		<?php		printf(			wp_kses(				/* translators: %1$s is URL for Church Content Pro add-on */				__( 'Upgrade to <a href="%1$s" target="_blank">Church Content Pro</a> to save time by selecting previously used locations.', 'church-theme-content' ),				array(					'a' => array(						'href' => array(),						'target' => array(),					),				)			),			esc_url( ctc_ctcom_url( 'church-content-pro', array( 'utm_content' => 'event_location_box' ) ) )		);		?>	</p>	<?php}add_action( 'ctmb_before_fields', 'ctc_event_location_memory_upgrade_note' );