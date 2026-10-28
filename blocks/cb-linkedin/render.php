<?php
/**
 * Block template for CB LinkedIn.
 *
 * Three post cards on a grey band. Source "Live feed" reads the cache kept by
 * the CBP LinkedIn Feed plugin (cbp_linkedin_feed_get_posts()); "Manual rows"
 * uses the repeater. Live feed falls back to the manual rows while the plugin
 * is absent, not connected or has nothing cached, so the section never goes
 * blank.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

$kicker      = $attributes['kicker'] ?? '';
$profile_url = $attributes['profileUrl'] ?? '';
$source      = $attributes['source'] ?? 'Live feed';
$limit       = absint( $attributes['limit'] ?? 0 );
$posts       = array();
$is_live     = false;

if ( 'Live feed' === $source && function_exists( 'cbp_linkedin_feed_get_posts' ) ) {
	foreach ( cbp_linkedin_feed_get_posts( $limit > 0 ? $limit : 3 ) as $live ) {
		if ( empty( $live['text'] ) ) {
			continue;
		}
		$posts[] = array(
			'author'  => $live['author'] ?? '',
			'meta'    => cbp_linkedin_feed_relative_time( $live ),
			'text'    => $live['text'],
			'postUrl' => $live['url'] ?? '',
			'image'   => $live['image'] ?? '',
		);
	}
	$is_live = (bool) $posts;
}

if ( ! $posts ) {
	$posts = array_filter(
		(array) ( $attributes['posts'] ?? array() ),
		function ( $item ) {
			return ! empty( $item['text'] );
		}
	);
}

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
				<?php
				if ( ! empty( $item['image'] ) ) {
					?>
				<a class="linkedin-card__image" href="<?php echo esc_url( $post_url ); ?>" target="_blank" rel="noopener" tabindex="-1" aria-hidden="true"><img src="<?php echo esc_url( $item['image'] ); ?>" alt="" loading="lazy"></a>
					<?php
				}
				?>
				<p class="linkedin-card__text"><?php echo esc_html( wp_trim_words( $item['text'], $is_live ? 40 : 200, '…' ) ); ?></p>
			</article>
				<?php
			}
			?>
		</div>
	</div>
</section>
