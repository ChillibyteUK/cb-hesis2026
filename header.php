<?php
/**
 * Header template.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>document.documentElement.classList.add( 'js' );</script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<a class="skip-link" href="#main">Skip to content</a>
<?php wp_body_open(); ?>

<!-- HEADER-NAV:START -->
<header id="masthead">
	<nav class="navbar container" aria-label="Primary navigation">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-brand" aria-label="<?php esc_attr_e( 'HESIS home', 'cb-hesis2026' ); ?>">
			<?php echo cb_hesis2026_logo_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted inline SVG. ?>
		</a>

		<button class="navbar-toggler" type="button" aria-expanded="false" aria-controls="primary-menu" aria-label="Toggle navigation">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
				<path d="M3 6h18M3 12h18M3 18h18" />
			</svg>
		</button>

		<div class="navbar-collapse" id="primary-menu">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_class'     => 'navbar-nav',
					'container'      => false,
					'fallback_cb'    => false,
					'walker'         => new CB_HESIS_2026_Nav_Walker(),
				)
			);

			$cb_hesis2026_portal = cb_hesis2026_get_setting( 'client_portal_url' );
			if ( $cb_hesis2026_portal ) {
				?>
			<div class="nav-cta">
				<a href="<?php echo esc_url( $cb_hesis2026_portal ); ?>" class="btn btn-primary btn-sm" target="_blank" rel="noopener"><?php esc_html_e( 'Client Portal', 'cb-hesis2026' ); ?></a>
			</div>
				<?php
			}
			?>
		</div>
	</nav>
</header>
<!-- HEADER-NAV:END -->

<main id="main">
