<?php
/**
 * Block template for CB Accreditations.
 *
 * Dark band of accreditation logos under the hero. Carries the white curve
 * that leads into the page. Logos scroll (src/js/marquee.js) when they
 * overflow and Scroll Continuously is on.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

$label        = $attributes['label'] ?? '';
$logos        = array_filter( array_map( 'absint', (array) ( $attributes['logos'] ?? array() ) ) );
$marquee      = ! empty( $attributes['scrollContinuously'] );
$bottom_curve = ! empty( $attributes['bottomCurve'] );

if ( ! $logos && ! $label ) {
	return;
}

$classes = array( 'accreditations', 'on-dark' );
if ( $bottom_curve ) {
	$classes[] = 'curve-bottom';
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() already escapes. ?>>
	<div class="container accreditations__inner">
		<?php
		if ( $label ) {
			?>
		<span class="kicker accreditations__label"><?php echo esc_html( $label ); ?></span>
			<?php
		}
		if ( $logos ) {
			?>
		<div class="accreditations__logos"<?php echo $marquee ? ' data-marquee' : ''; ?>>
			<ul class="accreditations__track"<?php echo $marquee ? ' data-marquee-track' : ''; ?>>
				<?php
				foreach ( $logos as $logo_id ) {
					?>
				<li class="accreditations__logo"><?php echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'loading' => 'lazy' ) ); ?></li>
					<?php
				}
				?>
			</ul>
		</div>
			<?php
		}
		?>
	</div>
</section>
