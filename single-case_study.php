<?php
/**
 * Single Case Study template.
 *
 * Hero from the featured image with the sector kicker and service tags,
 * then the block-built content.
 *
 * @package cb-hesis2026
 */

get_header();

while ( have_posts() ) {
	the_post();
	$cb_hesis2026_hero_id  = get_post_thumbnail_id();
	$cb_hesis2026_sectors  = get_the_terms( get_the_ID(), 'case_study_sector' );
	$cb_hesis2026_services = get_the_terms( get_the_ID(), 'case_study_service' );
	$cb_hesis2026_meta     = array();

	if ( $cb_hesis2026_services && ! is_wp_error( $cb_hesis2026_services ) ) {
		$cb_hesis2026_meta = wp_list_pluck( $cb_hesis2026_services, 'name' );
	}
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
				if ( $cb_hesis2026_sectors && ! is_wp_error( $cb_hesis2026_sectors ) ) {
					?>
				<span class="kicker"><?php echo esc_html( $cb_hesis2026_sectors[0]->name ); ?></span>
					<?php
				}
				?>
				<h1 class="hero__title"><?php the_title(); ?></h1>
				<?php
				if ( $cb_hesis2026_meta ) {
					?>
				<p class="hero__intro"><?php echo esc_html( implode( ' · ', $cb_hesis2026_meta ) ); ?></p>
					<?php
				}
				?>
			</div>
		</div>
	</section>
	<?php
	the_content();
}

get_footer();
