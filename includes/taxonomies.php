<?php
/**
 * Register Taxonomies
 */

/**********************************
 * SERMON TAXONOMIES
 **********************************/

/**
 * Category
 */
 
add_action( 'init', 'ccm_register_taxonomy_sermon_category' ); // category taxonomy
 
function ccm_register_taxonomy_sermon_category() {

	// Arguments
	$args = array(
		'labels' => array(
			'name' 							=> _x( 'Sermon Categories', 'taxonomy general name', 'ccm' ),
			'singular_name'					=> _x( 'Sermon Category', 'taxonomy singular name', 'ccm' ),
			'search_items' 					=> _x( 'Search Categories', 'sermons', 'ccm' ),
			'popular_items' 				=> _x( 'Popular Categories', 'sermons', 'ccm' ),
			'all_items' 					=> _x( 'All Categories', 'sermons', 'ccm' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> _x( 'Edit Category', 'sermons', 'ccm' ), 
			'update_item' 					=> _x( 'Update Category', 'sermons', 'ccm' ),
			'add_new_item' 					=> _x( 'Add Category', 'sermons', 'ccm' ),
			'new_item_name' 				=> _x( 'New Category', 'sermons', 'ccm' ),
			'separate_items_with_commas' 	=> _x( 'Separate categories with commas', 'sermons', 'ccm' ),
			'add_or_remove_items' 			=> _x( 'Add or remove categories', 'sermons', 'ccm' ),
			'choose_from_most_used' 		=> _x( 'Choose from the most used categories', 'sermons', 'ccm' ),
			'menu_name' 					=> _x( 'Categories', 'sermon menu name', 'ccm' )
		),
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ccm_taxonomy_supported( 'sermons', 'ccm_sermon_category' ),
		'rewrite' 		=> array(
			'slug' 			=> 'sermon-category',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);
	$args = apply_filters( 'ccm_taxonomy_sermon_category_args', $args ); // allow filtering

	// Registration
	register_taxonomy(
		'ccm_sermon_category',
		'ccm_sermon',
		$args
	);

}

/**
 * Tag
 */
 
add_action( 'init', 'ccm_register_taxonomy_sermon_tag' ); // tag taxonomy
 
function ccm_register_taxonomy_sermon_tag() {

	// Arguments
	$args = array(
		'labels' => array(
			'name' 							=> _x( 'Sermon Tags', 'taxonomy general name', 'ccm' ),
			'singular_name'					=> _x( 'Sermon Tag', 'taxonomy singular name', 'ccm' ),
			'search_items' 					=> _x( 'Search Tags', 'sermons', 'ccm' ),
			'popular_items' 				=> _x( 'Popular Tags', 'sermons', 'ccm' ),
			'all_items' 					=> _x( 'All Tags', 'sermons', 'ccm' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> _x( 'Edit Tag', 'sermons', 'ccm' ), 
			'update_item' 					=> _x( 'Update Tag', 'sermons', 'ccm' ),
			'add_new_item' 					=> _x( 'Add Tag', 'sermons', 'ccm' ),
			'new_item_name' 				=> _x( 'New Tag', 'sermons', 'ccm' ),
			'separate_items_with_commas' 	=> _x( 'Separate tags with commas', 'sermons', 'ccm' ),
			'add_or_remove_items' 			=> _x( 'Add or remove tags', 'sermons', 'ccm' ),
			'choose_from_most_used' 		=> _x( 'Choose from the most used tags', 'sermons', 'ccm' ),
			'menu_name' 					=> _x( 'Tags', 'sermon menu name', 'ccm' )
		),
		'hierarchical'	=> false, // tag style instead of category style
		'public' 		=> ccm_taxonomy_supported( 'sermons', 'ccm_sermon_tag' ),
		'rewrite' 		=> array(
			'slug' 			=> 'sermon-tag',
			'with_front'	=> false,
			'hierarchical' 	=> true
		)
	);
	$args = apply_filters( 'ccm_taxonomy_sermon_tag_args', $args ); // allow filtering

	// Registration
	register_taxonomy(
		'ccm_sermon_tag',
		'ccm_sermon',
		$args
	);

}

/**
 * Speaker
 */

add_action( 'init', 'ccm_register_taxonomy_sermon_speaker' ); // speaker taxonomy
 
function ccm_register_taxonomy_sermon_speaker() {

	// Arguments
	$args = array(
		'labels' => array(
			'name' 							=> _x( 'Sermon Speakers', 'taxonomy general name', 'ccm' ),
			'singular_name'					=> _x( 'Sermon Speaker', 'taxonomy singular name', 'ccm' ),
			'search_items' 					=> _x( 'Search Speakers', 'sermons', 'ccm' ),
			'popular_items' 				=> _x( 'Popular Speakers', 'sermons', 'ccm' ),
			'all_items' 					=> _x( 'All Speakers', 'sermons', 'ccm' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> _x( 'Edit Speaker', 'sermons', 'ccm' ), 
			'update_item' 					=> _x( 'Update Speaker', 'sermons', 'ccm' ),
			'add_new_item' 					=> _x( 'Add Speaker', 'sermons', 'ccm' ),
			'new_item_name' 				=> _x( 'New Speaker', 'sermons', 'ccm' ),
			'separate_items_with_commas' 	=> _x( 'Separate speakers with commas', 'sermons', 'ccm' ),
			'add_or_remove_items' 			=> _x( 'Add or remove speakers', 'sermons', 'ccm' ),
			'choose_from_most_used' 		=> _x( 'Choose from the most used speakers', 'sermons', 'ccm' ),
			'menu_name' 					=> _x( 'Speakers', 'sermon menu name', 'ccm' )
		),
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ccm_taxonomy_supported( 'sermons', 'ccm_sermon_speaker' ),
		'rewrite' 		=> array(
			'slug' 			=> 'sermon-speaker',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);
	$args = apply_filters( 'ccm_taxonomy_sermon_speaker_args', $args ); // allow filtering

	// Registration
	register_taxonomy(
		'ccm_sermon_speaker',
		'ccm_sermon',
		$args
	);

}

/**********************************
 * GALLERY TAXONOMIES
 **********************************/

/**
 * Album
 */
 
add_action( 'init', 'ccm_register_taxonomy_gallery_album' );
 
function ccm_register_taxonomy_gallery_album() {

	// Arguments
	$args = array(
		'labels' => array(
			'name' 							=> _x( 'Gallery Albums', 'taxonomy general name', 'ccm' ),
			'singular_name'					=> _x( 'Gallery Album', 'taxonomy singular name', 'ccm' ),
			'search_items' 					=> __( 'Search Albums', 'ccm' ),
			'popular_items' 				=> __( 'Popular Albums', 'ccm' ),
			'all_items' 					=> __( 'All Albums', 'ccm' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> __( 'Edit Album', 'ccm' ), 
			'update_item' 					=> __( 'Update Album', 'ccm' ),
			'add_new_item' 					=> __( 'Add Album', 'ccm' ),
			'new_item_name' 				=> __( 'New Album', 'ccm' ),
			'separate_items_with_commas' 	=> __( 'Separate albums with commas', 'ccm' ),
			'add_or_remove_items' 			=> __( 'Add or remove albums.', 'ccm' ),
			'choose_from_most_used' 		=> __( 'Choose from the most used albums.', 'ccm' ),
			'menu_name' 					=> _x( 'Albums', 'gallery menu name', 'ccm' )
		),
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ccm_taxonomy_supported( 'gallery', 'ccm_gallery_album' ),
		'rewrite' 		=> array(
			'slug' 			=> 'album',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);
	$args = apply_filters( 'ccm_taxonomy_gallery_album_args', $args ); // allow filtering

	// Register
	register_taxonomy(
		'ccm_gallery_album',
		'ccm_gallery_item',
		$args
	);

}

/**********************************
 * PERSON TAXONOMIES
 **********************************/

/**
 * Group
 */

add_action( 'init', 'ccm_register_taxonomy_person_group' );
 
function ccm_register_taxonomy_person_group() {

	// Arguments
	$args = array(
		'labels' => array(
			'name' 							=> _x( 'People Groups', 'taxonomy general name', 'ccm' ),
			'singular_name'					=> _x( 'People Group', 'taxonomy singular name', 'ccm' ),
			'search_items' 					=> _x( 'Search Groups', 'people', 'ccm' ),
			'popular_items' 				=> _x( 'Popular Groups', 'people', 'ccm' ),
			'all_items' 					=> _x( 'All Groups', 'people', 'ccm' ),
			'parent_item' 					=> null,
			'parent_item_colon' 			=> null,
			'edit_item' 					=> _x( 'Edit Group', 'people', 'ccm' ), 
			'update_item' 					=> _x( 'Update Group', 'people', 'ccm' ),
			'add_new_item' 					=> _x( 'Add Group', 'people', 'ccm' ),
			'new_item_name' 				=> _x( 'New Group', 'people', 'ccm' ),
			'separate_items_with_commas' 	=> _x( 'Separate groups with commas', 'people', 'ccm' ),
			'add_or_remove_items' 			=> _x( 'Add or remove groups', 'people', 'ccm' ),
			'choose_from_most_used' 		=> _x( 'Choose from the most used groups', 'people', 'ccm' ),
			'menu_name' 					=> _x( 'Groups', 'people menu name', 'ccm' )
		),
		'hierarchical'	=> true, // category-style instead of tag-style
		'public' 		=> ccm_taxonomy_supported( 'people', 'ccm_person_group' ),
		'rewrite' 		=> array(
			'slug' 			=> 'people-group',
			'with_front' 	=> false,
			'hierarchical' 	=> true
		)
	);
	$args = apply_filters( 'ccm_taxonomy_person_group_args', $args ); // allow filtering

	// Registration
	register_taxonomy(
		'ccm_person_group',
		'ccm_person',
		$args
	);

}
