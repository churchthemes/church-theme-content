Church Theme Content (Plugin)
=============================

A WordPress plugin providing compatible themes with church-related post types, taxonomies and fields.

Purpose
-------

Church Theme Content provides functionality enabling the user to manage *sermons*, *events*, *people* and *locations* to be displayed by a compatible theme.

Experienced WordPress developers agree that functionality like this does not belong in themes since themes are intended only to control the appearance of a WordPress site. Content that users might expect to take with them if they switch themes should "live" in a plugin. Similarly, our approach is not to display content using the plugin since themes offer more control for that purpose.

Visit the [plugin's page on WordPress.org](http://wordpress.org/plugins/church-theme-content) for more information.

Developers
----------

The Church Theme Content plugin was made in a way that other church theme developers can take advantage of it. A couple benefits are that you will save time and be helping to accomplish better data portability among church websites powered by WordPress.

This guide assumes you have some proficiency with [WordPress Theme Development](http://codex.wordpress.org/Theme_Development) or are willing to learn.

### Basic Usage

You can do this in your theme's **functions.php** file using the ``after_setup_theme`` hook.

```php
function yourtheme_add_ctc_support() {

	/**
	 * Plugin Support
	 *
	 * Tell plugin theme supports it. This leaves all features disabled so they can
	 * be enabled explicitly below. When support not added, all features are revealed
	 * so user can access content (in case switched to an unsupported theme).
	 *
	 * This also removes the plugin's "not using compatible theme" message.
	 */

	add_theme_support( 'church-theme-content' );

	/**
	 * Plugin Features
	 *
	 * When array of arguments not given, plugin defaults are used (enabling all taxonomies
	 * and fields for feature). It is recommended to explicitly specify taxonomies and
	 * fields used by theme so plugin updates don't reveal unsupported features.
	 */
	add_theme_support( 'ctc-sermons' );
	add_theme_support( 'ctc-events' );
	add_theme_support( 'ctc-people' );
	add_theme_support( 'ctc-locations' );

}

add_action( 'after_setup_theme', 'yourtheme_add_ctc_support' );
```

This will enable all post types, taxonomies and fields.

### Recommended Usage

Notice the comment above says, *"It is recommended to explicitly specify taxonomies and fields used by theme so plugin updates don't reveal unsupported features."* Below is an example from one of our themes showing how to do that. This code would replace the block of code under *Plugin Features* above.

```php
// Sermons
add_theme_support( 'ctc-sermons', array(
	'taxonomies' => array(
		'ctc_sermon_topic',
		'ctc_sermon_book',
		'ctc_sermon_series',
		'ctc_sermon_speaker',
		'ctc_sermon_tag',
	),
	'fields' => array(
		'_ctc_sermon_has_full_text',
		'_ctc_sermon_video',
		'_ctc_sermon_audio',
		'_ctc_sermon_pdf',
	),
	'field_overrides' => array()
) );

// Events
add_theme_support( 'ctc-events', array(
	'taxonomies' => array(),
	'fields' => array(
		'_ctc_event_start_date',
		'_ctc_event_end_date',
		'_ctc_event_time',
		'_ctc_event_recurrence',
		'_ctc_event_recurrence_end_date',
		'_ctc_event_venue',
		'_ctc_event_address',
		'_ctc_event_show_directions_link',
		'_ctc_event_map_lat',
		'_ctc_event_map_lng',
		'_ctc_event_map_type',
		'_ctc_event_map_zoom',
	),
	'field_overrides' => array()
) );

// People
add_theme_support( 'ctc-people', array(
	'taxonomies' => array(
		'ctc_person_group',
	),
	'fields' => array(
		'_ctc_person_position',
		'_ctc_person_phone',
		'_ctc_person_email',
		'_ctc_person_urls',
	),
	'field_overrides' => array()
) );

// Locations
add_theme_support( 'ctc-locations', array(
	'taxonomies' => array(),
	'fields' => array(
		'_ctc_location_address',
		'_ctc_location_show_directions_link',
		'_ctc_location_map_lat',
		'_ctc_location_map_lng',
		'_ctc_location_map_type',
		'_ctc_location_map_zoom',
		'_ctc_location_phone',
		'_ctc_location_times',
	),
	'field_overrides' => array()
) );
```

### Field Overrides

Did you notice ``field_overrides`` above? You can use this to change how a field is presented to the user. Maybe you want to change the title or description. Here's one example of doing so for a couple *Person* fields.

```php
'field_overrides' => array(
	'_ctc_person_urls' => array(
		'name' => __( 'New Title', 'yourtheme' ),
		'desc' => __( 'Enter one URL per line.', 'yourtheme' )
	),
	'_ctc_person_email' => array(
		'desc' => sprintf( __( 'The WordPress <a href="%s" target="_blank">antispambot</a> function is used to help deter automated email harvesting.', 'yourtheme' ), 'http://codex.wordpress.org/Function_Reference/antispambot' )
	)
)
```

You can change other things like the field's default value and whether or not it can be left empty. Look into the **{feature}-fields.php** files in [includes/admin](https://github.com/churchthemes/church-theme-content/tree/master/includes/admin) to see which field settings you can override.

### Showing Content

Showing content is the territory of your theme. This plugin simply provides the user with a way to manage church-related content. We believe in a clear separation between functionality and presentation. Content should be theme-independent and belongs in a plugin like this. Similarly, themes are best for showing content.

#### Post Types, Taxonomies and Fields

You can get full details on the post types and taxonomies that the plugin registers in:

* [includes/post-types.php](https://github.com/churchthemes/church-theme-content/blob/master/includes/post-types.php)
* [includes/taxonomies.php](https://github.com/churchthemes/church-theme-content/blob/master/includes/taxonomies.php)
* [includes/admin/sermon-fields.php](https://github.com/churchthemes/church-theme-content/blob/master/includes/admin/sermon-fields.php)
* [includes/admin/event-fields.php](https://github.com/churchthemes/church-theme-content/blob/master/includes/admin/event-fields.php)
* [includes/admin/person-fields.php](https://github.com/churchthemes/church-theme-content/blob/master/includes/admin/person-fields.php)
* [includes/admin/location-fields.php](https://github.com/churchthemes/church-theme-content/blob/master/includes/admin/location-fields.php)

#### Church Theme Framework

If you'd like an extra hand in presenting content from this plugin, have a look at our [Church Theme Framework](https://github.com/churchthemes/church-theme-framework). Like this plugin, you can enable many useful features with a flick of ``add_theme_support``. Helper functions also make development quicker and easier.

### Additional Notes

* Sermon audio podcasting is built-in. When an audio URL is provided, it is used in the sermons feed as an enclosure.
* Events can be set to automatically recur. This is accomplished with WordPress's scheduling feature.