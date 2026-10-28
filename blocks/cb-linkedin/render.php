<?php
/**
 * Block template for CB LinkedIn.
 *
 * Three post cards on a grey band. Posts are entered manually for now; swap
 * the repeater for a feed once a LinkedIn integration is agreed.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

$kicker      = $attributes['kicker'] ?? '';
$profile_url = $attributes['profileUrl'] ?? '';
$posts       = array_filter(
	(array) ( $attributes['posts'] ?? array() ),
	function ( $item ) {
		return ! empty( $item['text'] );
	}
);

if ( ! $posts ) {
	return;
}

$li_icon            = get_icon( 'linkedin' );
$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'linkedin section' ) );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() already escapes. ?>>
	<div class="container">
		<div class="section-head linkedin__head">
			<?php
			if ( $kicker ) {
				?>
			<span class="kicker kicker--coral"><?php echo esc_html( $kicker ); ?></span>
				<?php
			}
			if ( $profile_url ) {
				?>
			<a class="text-link" href="<?php echo esc_url( $profile_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Follow us', 'cb-hesis2026' ); ?> <?php echo cb_hesis2026_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted inline SVG. ?></a>
				<?php
			}
			?>
		</div>
		<div class="grid linkedin__grid" style="--grid-min: 18rem">
			<?php
			foreach ( $posts as $item ) {
				$post_url = ! empty( $item['postUrl'] ) ? $item['postUrl'] : $profile_url;
				?>
			<article class="linkedin-card">
				<header class="linkedin-card__head">
					<span class="linkedin-card__avatar" aria-hidden="true"><?php echo cb_hesis2026_logo_svg( 'logo--mark-only' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted inline SVG. ?></span>
					<span class="linkedin-card__author">
						<strong><?php echo esc_html( ! empty( $item['author'] ) ? $item['author'] : 'HESIS' ); ?></strong>
						<?php
						if ( ! empty( $item['meta'] ) ) {
							?>
						<small><?php echo esc_html( $item['meta'] ); ?></small>
							<?php
						}
						?>
					</span>
					<?php
					if ( $post_url ) {
						?>
					<a class="linkedin-card__icon" href="<?php echo esc_url( $post_url ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'View on LinkedIn', 'cb-hesis2026' ); ?>"><?php echo $li_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- theme SVG. ?></a>
						<?php
					} else {
						?>
					<span class="linkedin-card__icon" aria-hidden="true"><?php echo $li_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- theme SVG. ?></span>
						<?php
					}
					?>
				</header>
				<p class="linkedin-card__text"><?php echo esc_html( $item['text'] ); ?></p>
			</article>
				<?php
			}
			?>
		</div>
	</div>
</section>
