<?php
/**
 * Block template for CB Stats.
 *
 * Navy band of large orange figures with small uppercase labels.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

$stats = array_filter(
	(array) ( $attributes['stats'] ?? array() ),
	function ( $stat ) {
		return ! empty( $stat['value'] ) || ! empty( $stat['label'] );
	}
);

if ( ! $stats ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'stats on-dark' ) );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() already escapes. ?>>
	<div class="container">
		<ul class="stats__list">
			<?php
			foreach ( $stats as $stat ) {
				?>
			<li class="stats__stat fade-in">
				<?php
				if ( ! empty( $stat['value'] ) ) {
					?>
				<span class="stats__value"><?php echo esc_html( $stat['value'] ); ?></span>
					<?php
				}
				if ( ! empty( $stat['label'] ) ) {
					?>
				<span class="stats__label"><?php echo esc_html( $stat['label'] ); ?></span>
					<?php
				}
				?>
			</li>
				<?php
			}
			?>
		</ul>
	</div>
</section>
