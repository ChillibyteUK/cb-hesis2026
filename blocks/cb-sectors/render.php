<?php
/**
 * Block template for CB Sectors.
 *
 * Photo background with a centred heading, a coral curve rising from the
 * foot, and a cream accordion of sectors in front of both. The accordion is
 * native <details>/<summary> sharing one `name`, so only one opens at a time.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

$kicker   = $attributes['kicker'] ?? '';
$heading  = $attributes['heading'] ?? '';
$intro    = $attributes['intro'] ?? '';
$image_id = absint( $attributes['backgroundImageId'] ?? 0 );
$focal    = $attributes['backgroundImageFocalPoint'] ?? array();
$focal_style = sprintf( '--focal-x: %s%%; --focal-y: %s%%', round( ( $focal['x'] ?? 0.5 ) * 100, 2 ), round( ( $focal['y'] ?? 0.5 ) * 100, 2 ) );
$sectors  = array_filter(
	(array) ( $attributes['sectors'] ?? array() ),
	function ( $sector ) {
		return ! empty( $sector['title'] );
	}
);
$group_id = wp_unique_id( 'sectors-' );

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'sectors on-dark' ) );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() already escapes. ?>>
	<?php
	if ( $image_id ) {
		?>
	<div class="sectors__bg" aria-hidden="true">
		<?php echo wp_get_attachment_image( $image_id, 'full', false, array( 'loading' => 'lazy', 'style' => esc_attr( $focal_style ) ) ); ?>
	</div>
		<?php
	}
	?>
	<div class="sectors__scrim" aria-hidden="true"></div>
	<div class="sectors__curve" aria-hidden="true"></div>
	<div class="container">
		<div class="section-head section-head--center sectors__head fade-in">
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
			if ( $intro ) {
				?>
			<p><?php echo esc_html( $intro ); ?></p>
				<?php
			}
			?>
		</div>
		<?php
		if ( $sectors ) {
			?>
		<div class="sectors__panel">
			<?php
			foreach ( $sectors as $sector ) {
				$title     = $sector['title'];
				$desc      = $sector['description'] ?? '';
				$link_url  = $sector['link'] ?? '';
				$link_text = $sector['linkText'] ?? '';

				if ( ! $link_url ) {
					// Fall back to the Sector post with the same name.
					$match = get_page_by_path( sanitize_title( $title ), OBJECT, 'sector' );
					if ( $match && 'publish' === $match->post_status ) {
						$link_url = get_permalink( $match );
					}
				}
				if ( ! $link_text ) {
					/* translators: %s: sector name */
					$link_text = sprintf( __( 'Explore %s', 'cb-hesis2026' ), strtolower( $title ) );
				}
				?>
			<details class="sectors__item" name="<?php echo esc_attr( $group_id ); ?>">
				<summary class="sectors__summary">
					<span><?php echo esc_html( $title ); ?></span>
					<span class="sectors__icon" aria-hidden="true"></span>
				</summary>
				<div class="sectors__body">
					<p>
						<?php
						if ( $desc ) {
							echo esc_html( $desc );
						}
						if ( $link_url ) {
							?>
						<a href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $link_text ); ?></a>
							<?php
						}
						?>
					</p>
				</div>
			</details>
				<?php
			}
			?>
		</div>
			<?php
		}
		$cta = cb_hesis2026_link( $attributes, 'cta', 'text-link text-link--light', __( 'View all sectors', 'cb-hesis2026' ), ' ' . cb_hesis2026_arrow_icon() );
		if ( $cta ) {
			?>
		<p class="sectors__cta text-center"><?php echo $cta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in cb_hesis2026_link(). ?></p>
			<?php
		}
		?>
	</div>
</section>
