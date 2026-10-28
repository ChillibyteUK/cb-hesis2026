<?php
/**
 * Block template for CB Service Tiles.
 *
 * Grid of white tiles, each an orange icon circle over a short label, on a
 * light grey band. Five across on desktop via .grid.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

$heading = $attributes['heading'] ?? '';
$intro   = $attributes['intro'] ?? '';
$tiles   = array_filter(
	(array) ( $attributes['tiles'] ?? array() ),
	function ( $tile ) {
		return ! empty( $tile['title'] );
	}
);

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'service-tiles section' ) );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() already escapes. ?>>
	<div class="container">
		<?php
		if ( $heading || $intro ) {
			?>
		<div class="section-head section-head--center fade-in">
			<?php
			if ( $heading ) {
				?>
			<h2><?php echo esc_html( $heading ); ?></h2>
				<?php
			}
			if ( $intro ) {
				?>
			<p><?php echo esc_html( $intro ); ?></p>
				<?php
			}
			?>
		</div>
			<?php
		}
		if ( $tiles ) {
			?>
		<div class="grid service-tiles__grid" style="--grid-min: 13rem">
			<?php
			foreach ( $tiles as $tile ) {
				$url      = $tile['link'] ?? '';
				$icon_id  = absint( $tile['iconImage'] ?? 0 );
				$icon_svg = ! $icon_id ? get_icon( sanitize_key( $tile['iconName'] ?? '' ) ) : '';
				$tag      = $url ? 'a' : 'div';
				?>
			<<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static tag name. ?> class="service-tile"<?php echo $url ? ' href="' . esc_url( $url ) . '"' : ''; ?>>
				<span class="service-tile__icon" aria-hidden="true">
					<?php
					if ( $icon_id ) {
						echo wp_get_attachment_image( $icon_id, 'thumbnail', false, array( 'loading' => 'lazy' ) );
					} else {
						echo $icon_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- theme's own SVG file.
					}
					?>
				</span>
				<span class="service-tile__title"><?php echo esc_html( $tile['title'] ); ?></span>
			</<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static tag name. ?>>
				<?php
			}
			?>
		</div>
			<?php
		}
		$cta = cb_hesis2026_link( $attributes, 'cta', 'text-link', __( 'View all services', 'cb-hesis2026' ), ' ' . cb_hesis2026_arrow_icon() );
		if ( $cta ) {
			?>
		<p class="service-tiles__cta text-center"><?php echo $cta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in cb_hesis2026_link(). ?></p>
			<?php
		}
		?>
	</div>
</section>
