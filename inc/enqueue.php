<?php
/**
 * Enqueue theme CSS/JS. filemtime versioning, no dependencies (no jQuery,
 * no Bootstrap JS) — plain vanilla output, loads immediately.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue theme.min.css.
 *
 * @return void
 */
function cb_hesis2026_enqueue_styles() {
	$rel = '/css/theme.min.css';
	$abs = get_stylesheet_directory() . $rel;
	if ( file_exists( $abs ) ) {
		wp_enqueue_style( 'cb-hesis2026-theme', get_stylesheet_directory_uri() . $rel, array(), filemtime( $abs ) );
	}
}
add_action( 'wp_enqueue_scripts', 'cb_hesis2026_enqueue_styles' );

/**
 * Swiper 11, for the case study and testimonial carousels. Registered
 * (not enqueued) so it only loads on pages where a block calls
 * wp_add_inline_script( 'swiper', ... ), which enqueues it on demand.
 *
 * @return void
 */
function cb_hesis2026_register_swiper() {
	wp_register_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11.2.10/swiper-bundle.min.css', array(), '11.2.10' );
	wp_register_script( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11.2.10/swiper-bundle.min.js', array(), '11.2.10', true );
	wp_style_add_data( 'swiper', 'path', '' );
}
add_action( 'wp_enqueue_scripts', 'cb_hesis2026_register_swiper', 4 );

/**
 * Blocks add their Swiper init with wp_add_inline_script( 'swiper', ... )
 * during render, after the enqueue hooks have run, so enqueue the registered
 * handle (and its stylesheet) at print time whenever an init was attached.
 *
 * @return void
 */
function cb_hesis2026_print_swiper_when_used() {
	$scripts = wp_scripts();
	if ( isset( $scripts->registered['swiper'] ) && $scripts->get_data( 'swiper', 'after' ) ) {
		wp_enqueue_style( 'swiper' );
		wp_enqueue_script( 'swiper' );
	}
}
add_action( 'wp_footer', 'cb_hesis2026_print_swiper_when_used', 5 );

/**
 * Enqueue a file from js/vendor/, filemtime-versioned like everything else.
 *
 * Third-party libraries a project needs should be vendored into js/vendor/
 * and committed, the same convention the compiled css/ and js/ output
 * already follows, rather than loaded from a CDN — that avoids extra DNS/TLS
 * handshakes and keeps a vendored stylesheet off a third-party origin. Note
 * the file the upstream version came from in a comment near the call site
 * (e.g. gsap.min.js 3.12.7 cdn.jsdelivr.net/npm/gsap) since it's vendored by
 * hand rather than tracked in package.json.
 *
 * @param string   $handle Handle to register under.
 * @param string   $file   Filename within js/vendor/.
 * @param bool     $is_css True to enqueue as a stylesheet rather than a script.
 * @param string[] $deps   Other registered handles this depends on (e.g. a
 *                         gsap plugin depending on the 'gsap' handle itself).
 * @return void
 */
function cb_hesis2026_enqueue_vendor( $handle, $file, $is_css = false, $deps = array() ) {
	$rel = '/js/vendor/' . $file;
	$abs = get_stylesheet_directory() . $rel;
	if ( ! file_exists( $abs ) ) {
		return;
	}
	$url = get_stylesheet_directory_uri() . $rel;
	if ( $is_css ) {
		wp_enqueue_style( $handle, $url, $deps, filemtime( $abs ) );
	} else {
		wp_enqueue_script( $handle, $url, $deps, filemtime( $abs ), true );
	}
}

/**
 * Enqueue Adobe Fonts (Typekit) — frontend and block editor alike, so the
 * editor iframe renders the same faces as the frontend. Disabled until a
 * project sets its kit ID: uncomment the body and the two add_action()s.
 *
 * @return void
 */
function cb_hesis2026_enqueue_fonts() {
	// wp_enqueue_style( 'cb-hesis2026-typekit', 'https://use.typekit.net/KIT_ID.css', array(), null );
}
// add_action( 'wp_enqueue_scripts', 'cb_hesis2026_enqueue_fonts' );
// add_action( 'enqueue_block_editor_assets', 'cb_hesis2026_enqueue_fonts' );

/**
 * Enqueue theme.min.js.
 *
 * @return void
 */
function cb_hesis2026_enqueue_scripts() {

	// cb_hesis2026_enqueue_vendor( 'gsap', 'gsap.min.js' );
	// cb_hesis2026_enqueue_vendor( 'lenis-style', 'lenis.css', true );
	// cb_hesis2026_enqueue_vendor( 'lenis', 'lenis.min.js' );

	$rel = '/js/theme.min.js';
	$abs = get_stylesheet_directory() . $rel;
	if ( file_exists( $abs ) ) {
		wp_enqueue_script( 'cb-hesis2026-theme', get_stylesheet_directory_uri() . $rel, array(), filemtime( $abs ), true );
	}
}
add_action( 'wp_enqueue_scripts', 'cb_hesis2026_enqueue_scripts' );
