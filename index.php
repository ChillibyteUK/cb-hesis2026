<?php
/**
 * Fallback / blog index template.
 *
 * @package cb-hesis2026
 */

get_header();
?>

<section class="hero hero--short on-dark">
	<div class="hero__scrim" aria-hidden="true"></div>
	<div class="container">
		<div class="hero__content">
			<h1 class="hero__title"><?php echo esc_html( is_home() && get_option( 'page_for_posts' ) ? get_the_title( get_option( 'page_for_posts' ) ) : __( 'News', 'cb-hesis2026' ) ); ?></h1>
		</div>
	</div>
</section>

<div class="container section">
	<?php
	if ( have_posts() ) {
		?>
	<div class="grid" style="--grid-min: 18rem">
		<?php
		while ( have_posts() ) {
			the_post();
			?>
		<a class="post-card" href="<?php the_permalink(); ?>">
			<div class="post-card__media"><?php the_post_thumbnail( 'medium_large' ); ?></div>
			<div class="post-card__body">
				<span class="kicker"><?php echo esc_html( get_the_date( 'j M Y' ) ); ?></span>
				<h2 class="post-card__title"><?php the_title(); ?></h2>
				<p><?php echo esc_html( cb_hesis2026_content_excerpt() ); ?></p>
				<span class="text-link"><?php esc_html_e( 'Read more', 'cb-hesis2026' ); ?> <?php echo cb_hesis2026_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			</div>
		</a>
			<?php
		}
		?>
	</div>
		<?php
		the_posts_pagination();
	} else {
		?>
	<p><?php esc_html_e( 'Nothing found.', 'cb-hesis2026' ); ?></p>
		<?php
	}
	?>
</div>

<?php
get_footer();
