<?php
/**
 * Block template for CB Timeline.
 *
 * Navy band with a row of milestones along a line: year in orange, a short
 * title and a sentence. Stacks into a vertical timeline on small screens.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

$kicker     = $attributes['kicker'] ?? '';
$heading    = $attributes['heading'] ?? '';
$intro      = $attributes['intro'] ?? '';
$milestones = array_filter(
	(array) ( $attributes['milestones'] ?? array() ),
	function ( $item ) {
		return ! empty( $item['year'] ) || ! empty( $item['title'] ) || ! empty( $item['description'] );
	}
);

if ( ! $milestones && ! $heading ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'timeline section on-dark' ) );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() already escapes. ?>>
	<div class="container">
		<?php
		if ( $kicker || $heading || $intro ) {
			?>
		<header class="timeline__header fade-in">
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
			<div class="timeline__intro prose"><?php echo wp_kses_post( wpautop( $intro ) ); ?></div>
				<?php
			}
			?>
		</header>
			<?php
		}
		if ( $milestones ) {
			?>
		<ol class="timeline__list">
			<?php
			foreach ( $milestones as $item ) {
				?>
			<li class="timeline__item fade-in">
				<?php
				if ( ! empty( $item['year'] ) ) {
					?>
				<span class="timeline__year"><?php echo esc_html( $item['year'] ); ?></span>
					<?php
				}
				if ( ! empty( $item['title'] ) ) {
					?>
				<h3 class="timeline__title"><?php echo esc_html( $item['title'] ); ?></h3>
					<?php
				}
				if ( ! empty( $item['description'] ) ) {
					?>
				<div class="timeline__text"><?php echo wp_kses_post( wpautop( $item['description'] ) ); ?></div>
					<?php
				}
				?>
			</li>
				<?php
			}
			?>
		</ol>
			<?php
		}
		?>
	</div>
</section>
