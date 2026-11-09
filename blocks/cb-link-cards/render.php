<?php
/**
 * Block template for CB Link Cards.
 *
 * Row of white cards on the light grey section, each a title, a sentence and
 * an arrow link onward. Used for "Explore further" style signposting.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

$kicker  = $attributes['kicker'] ?? '';
$heading = $attributes['heading'] ?? '';
$intro   = $attributes['intro'] ?? '';
$cards   = array_filter(
	(array) ( $attributes['cards'] ?? array() ),
	function ( $item ) {
		return ! empty( $item['title'] ) || ! empty( $item['text'] );
	}
);

if ( ! $cards ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'link-cards section' ) );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() already escapes. ?>>
	<div class="container">
		<?php
		if ( $kicker || $heading || $intro ) {
			?>
		<header class="link-cards__header fade-in">
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
			<div class="link-cards__intro prose"><?php echo wp_kses_post( wpautop( $intro ) ); ?></div>
				<?php
			}
			?>
		</header>
			<?php
		}
		?>
		<ul class="link-cards__grid">
			<?php
			foreach ( $cards as $item ) {
				$link_url    = $item['link'] ?? '';
				$link_text   = $item['linkText'] ?? '';
				$link_target = ! empty( $item['linkTarget'] );
				?>
			<li class="link-card fade-in">
				<?php
				if ( ! empty( $item['title'] ) ) {
					?>
				<h3 class="link-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
					<?php
				}
				if ( ! empty( $item['text'] ) ) {
					?>
				<div class="link-card__text"><?php echo wp_kses_post( wpautop( $item['text'] ) ); ?></div>
					<?php
				}
				if ( $link_url ) {
					?>
				<a class="text-link link-card__link" href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_target ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $link_text ? $link_text : __( 'Find out more', 'cb-hesis2026' ) ); ?> <?php echo cb_hesis2026_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- theme SVG. ?></a>
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
