<?php
/**
 * Custom Post Types Registration
 *
 * Services and Sectors are built from blocks in the editor and render
 * through page.php (see cb_hesis2026_use_page_template_for_cpts() below).
 * Case Studies have their own single-case_study.php.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register custom post types for the theme.
 *
 * @return void
 */
function cb_hesis2026_register_post_types() {
	$common = array(
		'has_archive'         => false,
		'public'              => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'show_in_nav_menus'   => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt' ),
		'capability_type'     => 'post',
		'map_meta_cap'        => true,
	);

	register_post_type(
		'service',
		array_merge(
			$common,
			array(
				'labels'        => array(
					'name'               => 'Services',
					'singular_name'      => 'Service',
					'add_new_item'       => 'Add New Service',
					'edit_item'          => 'Edit Service',
					'new_item'           => 'New Service',
					'view_item'          => 'View Service',
					'search_items'       => 'Search Services',
					'not_found'          => 'No services found',
					'not_found_in_trash' => 'No services in trash',
				),
				'menu_position' => 21,
				'menu_icon'     => 'dashicons-admin-tools',
				'rewrite'       => array(
					'slug'       => 'services',
					'with_front' => false,
				),
			)
		)
	);

	register_post_type(
		'sector',
		array_merge(
			$common,
			array(
				'labels'        => array(
					'name'               => 'Sectors',
					'singular_name'      => 'Sector',
					'add_new_item'       => 'Add New Sector',
					'edit_item'          => 'Edit Sector',
					'new_item'           => 'New Sector',
					'view_item'          => 'View Sector',
					'search_items'       => 'Search Sectors',
					'not_found'          => 'No sectors found',
					'not_found_in_trash' => 'No sectors in trash',
				),
				'menu_position' => 22,
				'menu_icon'     => 'dashicons-building',
				'rewrite'       => array(
					'slug'       => 'sectors',
					'with_front' => false,
				),
			)
		)
	);

	register_post_type(
		'case_study',
		array_merge(
			$common,
			array(
				'labels'        => array(
					'name'               => 'Case Studies',
					'singular_name'      => 'Case Study',
					'add_new_item'       => 'Add New Case Study',
					'edit_item'          => 'Edit Case Study',
					'new_item'           => 'New Case Study',
					'view_item'          => 'View Case Study',
					'search_items'       => 'Search Case Studies',
					'not_found'          => 'No case studies found',
					'not_found_in_trash' => 'No case studies in trash',
				),
				'menu_position' => 23,
				'menu_icon'     => 'dashicons-portfolio',
				'rewrite'       => array(
					'slug'       => 'case-studies',
					'with_front' => false,
				),
			)
		)
	);
}
add_action( 'init', 'cb_hesis2026_register_post_types' );

/**
 * Serve page.php for singular views of any custom post type that has no
 * single-{post_type}.php of its own. CPT content here is built from the same
 * blocks as pages, so single.php's blog-post chrome would clash.
 *
 * @param string $template Template path WordPress would otherwise use.
 * @return string
 */
function cb_hesis2026_use_page_template_for_cpts( $template ) {
	if ( is_singular() && ! is_page() && ! is_singular( 'post' ) && 'single.php' === basename( $template ) ) {
		$page_template = get_query_template( 'page' );

		if ( $page_template ) {
			return $page_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'cb_hesis2026_use_page_template_for_cpts' );

/**
 * Flush rewrite rules on theme activation so the custom post type slugs work.
 *
 * @return void
 */
function cb_hesis2026_flush_rewrites() {
	cb_hesis2026_register_post_types();
	cb_hesis2026_register_taxonomies();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'cb_hesis2026_flush_rewrites' );
