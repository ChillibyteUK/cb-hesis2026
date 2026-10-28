<?php
/**
 * 404 template.
 *
 * @package cb-hesis2026
 */

get_header();
?>

<section class="hero hero--short on-dark">
	<div class="hero__scrim" aria-hidden="true"></div>
	<div class="container">
		<div class="hero__content">
			<span class="kicker">404</span>
			<h1 class="hero__title"><?php esc_html_e( 'Page not found', 'cb-hesis2026' ); ?></h1>
			<p class="hero__intro"><?php esc_html_e( "We can't seem to find the page you're looking for.", 'cb-hesis2026' ); ?></p>
			<div class="hero__ctas btn-group">
				<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Return to homepage', 'cb-hesis2026' ); ?></a>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
