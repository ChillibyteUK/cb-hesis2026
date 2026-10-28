<?php
/**
 * Custom taxonomies.
 *
 * Case studies are labelled by sector (the kicker on a card) and tagged by
 * service (the pills). Both are plain taxonomies rather than relationships
 * to the sector/service post types, so there is nothing to keep in sync and
 * no ACF needed: a term named "Healthcare" is all a card needs.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register taxonomies.
 *
 * @return void
 */
function cb_hesis2026_register_taxonomies() {
	register_taxonomy(
		'case_study_sector',
		array( 'case_study' ),
		array(
			'labels'            => array(
				'name'          => 'Sectors',
				'singular_name' => 'Sector',
				'search_items'  => 'Search Sectors',
				'all_items'     => 'All Sectors',
				'edit_item'     => 'Edit Sector',
				'update_item'   => 'Update Sector',
				'add_new_item'  => 'Add New Sector',
				'new_item_name' => 'New Sector Name',
				'menu_name'     => 'Sectors',
			),
			'hierarchical'      => true,
			'public'            => false,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => false,
		)
	);

	register_taxonomy(
		'case_study_service',
		array( 'case_study' ),
		array(
			'labels'            => array(
				'name'          => 'Services',
				'singular_name' => 'Service',
				'search_items'  => 'Search Services',
				'all_items'     => 'All Services',
				'edit_item'     => 'Edit Service',
				'update_item'   => 'Update Service',
				'add_new_item'  => 'Add New Service',
				'new_item_name' => 'New Service Name',
				'menu_name'     => 'Services',
			),
			'hierarchical'      => true,
			'public'            => false,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => false,
		)
	);
}
add_action( 'init', 'cb_hesis2026_register_taxonomies' );
