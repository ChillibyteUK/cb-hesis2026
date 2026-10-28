<?php
/**
 * Block template for CB Image Text.
 *
 * Copy on one side, a circular photo on the other with an optional second
 * circle and a rotating ring of orange dots. Used for the About teaser.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

$kicker       = $attributes['kicker'] ?? '';
$heading      = $attributes['heading'] ?? '';
$body         = $attributes['body'] ?? '';
$image_id     = absint( $attributes['mainImageId'] ?? 0 );
$secondary_id = absint( $attributes['secondaryImageId'] ?? 0 );
$position     = 'Left' === ( $attributes['imagePosition'] ?? 'Right' ) ? 'left' : 'right';
$dot_ring     = ! empty( $attributes['dotRing'] );

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'image-text section image-text--image-' . $position ) );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() already escapes. ?>>
	<div class="container">
		<div class="row align-items-center gap-5">
			<div class="col-12 col-lg-6 image-text__copy-col">
				<div class="image-text__copy fade-in">
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
					if ( $body ) {
						?>
					<div class="prose"><?php echo wp_kses_post( $body ); ?></div>
						<?php
					}
					$cta = cb_hesis2026_link( $attributes, 'cta', 'btn btn-primary', __( 'Find out more', 'cb-hesis2026' ) );
					if ( $cta ) {
						?>
					<div class="image-text__cta"><?php echo $cta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in cb_hesis2026_link(). ?></div>
						<?php
					}
					?>
				</div>
			</div>
			<?php
			if ( $image_id ) {
				?>
			<div class="col-12 col-lg-6 image-text__media-col">
				<div class="image-text__media<?php echo $dot_ring ? ' image-text__media--dots' : ''; ?>">
					<div class="image-text__circle">
						<?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'loading' => 'lazy' ) ); ?>
					</div>
					<?php
					if ( $secondary_id ) {
						?>
					<div class="image-text__circle image-text__circle--small">
						<?php echo wp_get_attachment_image( $secondary_id, 'medium', false, array( 'loading' => 'lazy' ) ); ?>
					</div>
						<?php
					}
					?>
				</div>
			</div>
				<?php
			}
			?>
		</div>
	</div>
</section>
