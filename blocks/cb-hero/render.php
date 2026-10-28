<?php
/**
 * Block template for CB Hero.
 *
 * Full-bleed photo with a dark scrim, kicker, heading, intro and two CTAs.
 * Every page should open with one: the fixed header starts transparent
 * over it (see src/css/header.css).
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

$kicker       = $attributes['kicker'] ?? '';
$heading      = $attributes['heading'] ?? '';
$intro        = $attributes['intro'] ?? '';
$image_id     = absint( $attributes['backgroundImageId'] ?? 0 );
$focal        = $attributes['backgroundImageFocalPoint'] ?? array();
$bottom_curve = ! empty( $attributes['bottomCurve'] );
$position     = sprintf( '%s%% %s%%', round( ( $focal['x'] ?? 0.5 ) * 100, 2 ), round( ( $focal['y'] ?? 0.5 ) * 100, 2 ) );

$classes = array( 'hero', 'on-dark' );
if ( $bottom_curve ) {
	$classes[] = 'curve-bottom';
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() already escapes. ?>>
	<?php
	if ( $image_id ) {
		?>
	<div class="hero__bg" aria-hidden="true">
		<?php
		echo wp_get_attachment_image(
			$image_id,
			'full',
			false,
			array(
				'fetchpriority' => 'high',
				'loading'       => 'eager',
				'style'         => 'object-position: ' . esc_attr( $position ),
			)
		);
		?>
	</div>
		<?php
	}
	?>
	<div class="hero__scrim" aria-hidden="true"></div>
	<div class="container">
		<div class="hero__content">
			<?php
			if ( $kicker ) {
				?>
			<span class="kicker"><?php echo esc_html( $kicker ); ?></span>
				<?php
			}
			if ( $heading ) {
				?>
			<h1 class="hero__title"><?php echo esc_html( $heading ); ?></h1>
				<?php
			}
			if ( $intro ) {
				?>
			<p class="hero__intro"><?php echo nl2br( esc_html( $intro ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- nl2br() of an escaped string. ?></p>
				<?php
			}
			$primary   = cb_hesis2026_link( $attributes, 'primaryCta', 'btn btn-primary', __( 'Get in touch', 'cb-hesis2026' ) );
			$secondary = cb_hesis2026_link( $attributes, 'secondaryCta', 'btn btn-outline', __( 'Our services', 'cb-hesis2026' ) );
			if ( $primary || $secondary ) {
				?>
			<div class="hero__ctas btn-group">
				<?php echo $primary . $secondary; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in cb_hesis2026_link(). ?>
			</div>
				<?php
			}
			?>
		</div>
	</div>
</section>
