<?php
/**
 * Single post template.
 *
 * @package cb-hesis2026
 */

get_header();

while ( have_posts() ) {
	the_post();
	$cb_hesis2026_hero_id = get_post_thumbnail_id();
	$cb_hesis2026_cats    = get_the_category();
	?>
	<section class="hero hero--short on-dark">
		<?php
		if ( $cb_hesis2026_hero_id ) {
			?>
		<div class="hero__bg" aria-hidden="true"><?php echo wp_get_attachment_image( $cb_hesis2026_hero_id, 'full' ); ?></div>
			<?php
		}
		?>
		<div class="hero__scrim" aria-hidden="true"></div>
		<div class="container">
			<div class="hero__content">
				<?php
				if ( ! empty( $cb_hesis2026_cats[0] ) ) {
					?>
				<span class="kicker"><?php echo esc_html( $cb_hesis2026_cats[0]->name ); ?></span>
					<?php
				}
				?>
				<h1 class="hero__title"><?php the_title(); ?></h1>
				<p class="hero__intro"><?php echo esc_html( get_the_date( 'j M Y' ) ); ?></p>
			</div>
		</div>
	</section>
	<div class="container section">
		<article <?php post_class( 'row' ); ?>>
			<div class="col-12 col-lg-8 prose">
				<?php the_content(); ?>
			</div>
		</article>
	</div>
	<?php
}

get_footer();
