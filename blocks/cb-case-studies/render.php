<?php
/**
 * Block template for CB Case Studies.
 *
 * Swiper carousel of the latest case studies: circular photo, sector
 * kicker, title, service tags and a read link. Cards come from
 * cb_hesis2026_case_study_card() in inc/helpers.php.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

$kicker  = $attributes['kicker'] ?? '';
$heading = $attributes['heading'] ?? '';
$limit   = absint( $attributes['limit'] ?? 0 );

$query = new WP_Query(
	array(
		'post_type'      => 'case_study',
		'post_status'    => 'publish',
		'posts_per_page' => $limit > 0 ? $limit : 6,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
		'no_found_rows'  => true,
	)
);

if ( ! $query->have_posts() ) {
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		echo '<p class="block-note">CB Case Studies: no published case studies to show yet.</p>';
	}
	return;
}

$slider_id          = wp_unique_id( 'case-studies-' );
$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'case-studies section' ) );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() already escapes. ?>>
	<div class="container">
		<div class="section-head fade-in">
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
		<div class="swiper case-studies__swiper" id="<?php echo esc_attr( $slider_id ); ?>">
			<div class="swiper-wrapper">
				<?php
				foreach ( $query->posts as $item ) {
					?>
				<div class="swiper-slide"><?php cb_hesis2026_case_study_card( $item ); ?></div>
					<?php
				}
				wp_reset_postdata();
				?>
			</div>
		</div>
		<div class="carousel-controls">
			<button type="button" class="carousel-btn" id="<?php echo esc_attr( $slider_id ); ?>-prev" aria-label="<?php esc_attr_e( 'Previous case studies', 'cb-hesis2026' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 5l-7 7 7 7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
			<div class="carousel-pagination" id="<?php echo esc_attr( $slider_id ); ?>-dots"></div>
			<button type="button" class="carousel-btn" id="<?php echo esc_attr( $slider_id ); ?>-next" aria-label="<?php esc_attr_e( 'Next case studies', 'cb-hesis2026' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
		</div>
		<?php
		$cta = cb_hesis2026_link( $attributes, 'cta', 'text-link', __( 'Discover all case studies', 'cb-hesis2026' ), ' ' . cb_hesis2026_arrow_icon() );
		if ( $cta ) {
			?>
		<p class="case-studies__cta text-center"><?php echo $cta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in cb_hesis2026_link(). ?></p>
			<?php
		}
		?>
	</div>
</section>
<?php
wp_add_inline_script(
	'swiper',
	'new Swiper("#' . esc_js( $slider_id ) . '", {
		slidesPerView: 1.1,
		spaceBetween: 16,
		watchOverflow: true,
		breakpoints: { 576: { slidesPerView: 1.5, spaceBetween: 20 }, 768: { slidesPerView: 2, spaceBetween: 24 }, 992: { slidesPerView: 3, spaceBetween: 24 } },
		navigation: { prevEl: "#' . esc_js( $slider_id ) . '-prev", nextEl: "#' . esc_js( $slider_id ) . '-next" },
		pagination: { el: "#' . esc_js( $slider_id ) . '-dots", clickable: true },
		a11y: { enabled: true }
	});'
);
