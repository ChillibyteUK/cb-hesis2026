<?php
/**
 * Project-specific helpers.
 *
 * @package cb-hesis2026
 */

defined( 'ABSPATH' ) || exit;

/**
 * Excerpt derived from the post's own content, ignoring the manual excerpt.
 *
 * @param int|WP_Post|null $post   Post to excerpt. Defaults to the loop post.
 * @param int               $length Words to keep.
 * @return string Plain-text excerpt (unescaped - escape at output).
 */
function cb_hesis2026_content_excerpt( $post = null, $length = 30 ) {
	$post = get_post( $post );

	if ( ! $post ) {
		return '';
	}

	$text = strip_shortcodes( $post->post_content );
	$text = excerpt_remove_blocks( $text );
	$text = wp_strip_all_tags( $text );
	$text = trim( preg_replace( '/\s+/', ' ', $text ) );

	if ( '' === $text ) {
		return '';
	}

	return wp_trim_words( $text, absint( $length ), '…' );
}

/**
 * Inline HESIS logo, from img/logo.svg (vectors lifted from the design file).
 *
 * Colours come from CSS: .logo__mark--a / --b are the orange and coral bars,
 * .logo__text the wordmark, .logo__sub the "An andwis. group company" line.
 * The header flips them between cream-on-dark and navy-on-white; the footer
 * sets everything white.
 *
 * @param string $class Extra class on the root <svg>.
 * @return string
 */
function cb_hesis2026_logo_svg( $class = '' ) {
	static $svg = null;

	if ( null === $svg ) {
		$path = get_template_directory() . '/img/logo.svg';
		$svg  = file_exists( $path ) ? file_get_contents( $path ) : ''; // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	}

	if ( ! $svg ) {
		return '';
	}

	return preg_replace( '/^<svg /', '<svg class="' . esc_attr( trim( 'logo ' . $class ) ) . '" ', $svg, 1 );
}

/**
 * Diagonal arrow used after text links ("View all services").
 *
 * @return string
 */
function cb_hesis2026_arrow_icon() {
	return '<svg class="arrow" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M4 4l8 8M12 5v7H5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>';
}

/**
 * Render a link attribute pair (text/url/target) as an anchor.
 *
 * @param array  $attributes Block attributes.
 * @param string $name       camelCase field base, e.g. 'primaryCta'.
 * @param string $class      Anchor class.
 * @param string $fallback   Text used when the field has a URL but no text.
 * @param string $after      Markup appended inside the anchor (e.g. an icon).
 * @return string Empty when there is no URL.
 */
function cb_hesis2026_link( $attributes, $name, $class, $fallback = '', $after = '' ) {
	$url = $attributes[ $name . 'Url' ] ?? '';

	if ( ! $url ) {
		return '';
	}

	$text   = $attributes[ $name . 'Text' ] ?? '';
	$target = ! empty( $attributes[ $name . 'Target' ] ) ? ' target="_blank" rel="noopener"' : '';

	return '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '"' . $target . '>' . esc_html( $text ? $text : $fallback ) . $after . '</a>';
}

/**
 * Output one case study card. Shared by the CB Case Studies carousel and
 * any later index so the two cannot drift apart.
 *
 * Sector kicker = first case_study_sector term; tags = case_study_service terms.
 *
 * @param WP_Post|int $item The case study post or its ID.
 * @return void
 */
function cb_hesis2026_case_study_card( $item ) {
	$item = get_post( $item );

	if ( ! $item ) {
		return;
	}

	$image   = get_post_thumbnail_id( $item->ID );
	$sectors = get_the_terms( $item->ID, 'case_study_sector' );
	$tags    = get_the_terms( $item->ID, 'case_study_service' );
	$label   = ( $sectors && ! is_wp_error( $sectors ) ) ? $sectors[0]->name : '';
	?>
	<article class="case-study-card">
		<div class="case-study-card__media">
			<?php
			if ( $image ) {
				echo wp_get_attachment_image( $image, 'medium_large', false, array( 'loading' => 'lazy' ) );
			}
			?>
		</div>
		<div class="case-study-card__body">
			<?php
			if ( $label ) {
				?>
			<span class="kicker kicker--coral"><?php echo esc_html( $label ); ?></span>
				<?php
			}
			?>
			<h3 class="case-study-card__title"><a href="<?php echo esc_url( get_permalink( $item ) ); ?>"><?php echo esc_html( get_the_title( $item ) ); ?></a></h3>
			<?php
			if ( $tags && ! is_wp_error( $tags ) ) {
				?>
			<ul class="case-study-card__tags">
				<?php
				foreach ( $tags as $tag ) {
					?>
				<li><?php echo esc_html( $tag->name ); ?></li>
					<?php
				}
				?>
			</ul>
				<?php
			}
			?>
			<a class="text-link case-study-card__cta" href="<?php echo esc_url( get_permalink( $item ) ); ?>">
				<?php esc_html_e( 'Read Case Study', 'cb-hesis2026' ); ?>
				<?php echo cb_hesis2026_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted inline SVG. ?>
			</a>
		</div>
	</article>
	<?php
}

/**
 * House style: plain hyphens, never em or en dashes.
 *
 * wptexturize() runs on the_content at priority 10 and rewrites a spaced
 * hyphen into an en dash, which reaches block output too. This runs after it
 * and converts them back. Smart quotes are left alone.
 *
 * @param string $text Text being filtered.
 * @return string
 */
function cb_hesis2026_plain_hyphens( $text ) {
	if ( ! is_string( $text ) || '' === $text ) {
		return $text;
	}

	return str_replace(
		array( "\xE2\x80\x93", "\xE2\x80\x94", '&#8211;', '&#8212;', '&ndash;', '&mdash;' ),
		'-',
		$text
	);
}
foreach ( array( 'the_content', 'the_title', 'the_excerpt' ) as $cb_hesis2026_dash_hook ) {
	add_filter( $cb_hesis2026_dash_hook, 'cb_hesis2026_plain_hyphens', 20 );
}
unset( $cb_hesis2026_dash_hook );
