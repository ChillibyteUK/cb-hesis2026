<?php
/**
 * Block template for CB CTA.
 *
 * Coral band with a heading, contact line and a navy button. The footer's
 * curve rises into it, so it goes last on a page.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

$heading    = $attributes['heading'] ?? '';
$subline    = $attributes['subline'] ?? '';
$show_phone = ! empty( $attributes['showPhone'] );
$phone      = cb_hesis2026_get_setting( 'phone' );
$cta        = cb_hesis2026_link( $attributes, 'cta', 'btn btn-navy', __( 'Contact us', 'cb-hesis2026' ) );

if ( ! $heading && ! $cta ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'cta on-dark' ) );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() already escapes. ?>>
	<div class="container cta__inner">
		<div class="cta__copy">
			<?php
			if ( $heading ) {
				?>
			<h2><?php echo esc_html( $heading ); ?></h2>
				<?php
			}
			if ( $subline || ( $show_phone && $phone ) ) {
				?>
			<p class="cta__subline">
				<?php
				echo esc_html( $subline );
				if ( $show_phone && $phone ) {
					echo $subline ? ' - ' : '';
					?>
				<a href="tel:<?php echo esc_attr( parse_phone( $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
					<?php
				}
				?>
			</p>
				<?php
			}
			?>
		</div>
		<?php
		if ( $cta ) {
			?>
		<div class="cta__actions"><?php echo $cta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in cb_hesis2026_link(). ?></div>
			<?php
		}
		?>
	</div>
</section>
