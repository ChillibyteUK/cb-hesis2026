<?php
/**
 * Block template for CB Testimonials.
 *
 * Orange band carrying a Swiper of white quote cards, two across on desktop.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

$kicker       = $attributes['kicker'] ?? '';
$heading      = $attributes['heading'] ?? '';
$testimonials = array_filter(
	(array) ( $attributes['testimonials'] ?? array() ),
	function ( $item ) {
		return ! empty( $item['quote'] );
	}
);

if ( ! $testimonials ) {
	return;
}

$slider_id          = wp_unique_id( 'testimonials-' );
$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'testimonials section on-dark' ) );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() already escapes. ?>>
	<div class="container">
		<div class="section-head testimonials__head fade-in">
			<?php
			if ( $kicker ) {
				?>
			<span class="kicker"><?php echo esc_html( $kicker ); ?></span>
				<?php
			}
			if ( $heading ) {
				?>
			<h2><?php echo esc_html( $heading ); ?></h2>
				<?php
			}
			?>
		</div>
		<div class="swiper testimonials__swiper" id="<?php echo esc_attr( $slider_id ); ?>">
			<div class="swiper-wrapper">
				<?php
				foreach ( $testimonials as $item ) {
					?>
				<div class="swiper-slide">
					<blockquote class="testimonial">
						<span class="testimonial__mark" aria-hidden="true">&ldquo;</span>
						<p class="testimonial__quote"><?php echo esc_html( $item['quote'] ); ?></p>
						<?php
						if ( ! empty( $item['name'] ) || ! empty( $item['role'] ) ) {
							?>
						<footer class="testimonial__cite">
							<?php
							if ( ! empty( $item['name'] ) ) {
								?>
							<strong><?php echo esc_html( $item['name'] ); ?></strong><?php echo ! empty( $item['role'] ) ? ',' : ''; ?>
								<?php
							}
							if ( ! empty( $item['role'] ) ) {
								?>
							<span><?php echo esc_html( $item['role'] ); ?></span>
								<?php
							}
							?>
						</footer>
							<?php
						}
						?>
					</blockquote>
				</div>
					<?php
				}
				?>
			</div>
		</div>
		<div class="testimonials__foot">
			<?php
			$cta = cb_hesis2026_link( $attributes, 'cta', 'text-link text-link--light', __( 'View more testimonials', 'cb-hesis2026' ), ' ' . cb_hesis2026_arrow_icon() );
			echo $cta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in cb_hesis2026_link().
			?>
			<div class="carousel-controls carousel-controls--light">
				<button type="button" class="carousel-btn" id="<?php echo esc_attr( $slider_id ); ?>-prev" aria-label="<?php esc_attr_e( 'Previous testimonials', 'cb-hesis2026' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 5l-7 7 7 7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
				<button type="button" class="carousel-btn" id="<?php echo esc_attr( $slider_id ); ?>-next" aria-label="<?php esc_attr_e( 'Next testimonials', 'cb-hesis2026' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
			</div>
		</div>
	</div>
</section>
<?php
wp_add_inline_script(
	'swiper',
	'new Swiper("#' . esc_js( $slider_id ) . '", {
		slidesPerView: 1,
		spaceBetween: 24,
		watchOverflow: true,
		loop: ' . ( count( $testimonials ) > 2 ? 'true' : 'false' ) . ',
		breakpoints: { 768: { slidesPerView: 2 } },
		navigation: { prevEl: "#' . esc_js( $slider_id ) . '-prev", nextEl: "#' . esc_js( $slider_id ) . '-next" },
		a11y: { enabled: true }
	});'
);
