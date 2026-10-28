	</main>

	<?php
	$cb_hesis2026_tagline = cb_hesis2026_get_setting( 'footer_tagline' );
	$cb_hesis2026_offices = cb_hesis2026_get_repeater_setting( 'offices' );
	$cb_hesis2026_phone   = cb_hesis2026_get_setting( 'phone' );
	$cb_hesis2026_email   = cb_hesis2026_get_setting( 'email' );

	// Statutory disclosure. Maintained on Site-Wide Settings > Legal; anything
	// left empty is simply omitted.
	$cb_hesis2026_legal_lines = array();
	$cb_hesis2026_legal_name  = trim( (string) cb_hesis2026_get_setting( 'registered_name' ) );
	$cb_hesis2026_legal_no    = trim( (string) cb_hesis2026_get_setting( 'company_number' ) );
	$cb_hesis2026_legal_place = trim( (string) cb_hesis2026_get_setting( 'place_of_registration' ) );
	$cb_hesis2026_legal_vat   = trim( (string) cb_hesis2026_get_setting( 'vat_number' ) );
	$cb_hesis2026_legal_off   = trim( (string) cb_hesis2026_get_setting( 'registered_office' ) );

	if ( $cb_hesis2026_legal_name ) {
		$cb_hesis2026_reg = $cb_hesis2026_legal_name;
		if ( $cb_hesis2026_legal_place ) {
			$cb_hesis2026_reg .= ' is registered in ' . $cb_hesis2026_legal_place;
		}
		if ( $cb_hesis2026_legal_no ) {
			$cb_hesis2026_reg .= ( $cb_hesis2026_legal_place ? ', ' : ' ' ) . 'company number ' . $cb_hesis2026_legal_no;
		}
		$cb_hesis2026_legal_lines[] = $cb_hesis2026_reg . '.';
	} elseif ( $cb_hesis2026_legal_no ) {
		$cb_hesis2026_legal_lines[] = 'Company number ' . $cb_hesis2026_legal_no . '.';
	}
	if ( $cb_hesis2026_legal_off ) {
		$cb_hesis2026_legal_lines[] = 'Registered office: ' . implode( ', ', array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $cb_hesis2026_legal_off ) ) ) ) . '.';
	}
	if ( $cb_hesis2026_legal_vat ) {
		$cb_hesis2026_legal_lines[] = 'VAT registration number ' . $cb_hesis2026_legal_vat . '.';
	}

	// Legal links. A page that does not exist is dropped rather than linked to a 404.
	$cb_hesis2026_legal_pages = array();
	foreach ( array(
		'privacy-policy'       => 'Privacy Policy',
		'cookie-policy'        => 'Cookie Policy',
		'terms-and-conditions' => 'Terms & Conditions',
	) as $cb_hesis2026_slug => $cb_hesis2026_label ) {
		$cb_hesis2026_page = get_page_by_path( $cb_hesis2026_slug );
		if ( $cb_hesis2026_page && 'publish' === $cb_hesis2026_page->post_status ) {
			$cb_hesis2026_legal_pages[ get_permalink( $cb_hesis2026_page ) ] = $cb_hesis2026_label;
		}
	}
	?>
	<!-- FOOTER:START -->
	<footer id="footer" class="site-footer">
		<div class="container">
			<div class="row site-footer__main">
				<div class="col-12 col-lg-5 site-footer__brand">
					<a class="site-footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'HESIS home', 'cb-hesis2026' ); ?>">
						<?php echo cb_hesis2026_logo_svg( 'logo--footer' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted inline SVG. ?>
					</a>
					<?php
					if ( $cb_hesis2026_tagline ) {
						?>
					<p class="site-footer__tagline"><?php echo esc_html( $cb_hesis2026_tagline ); ?></p>
						<?php
					}
					echo do_shortcode( '[social_icons class="site-footer__social"]' );
					?>
				</div>
				<div class="col-6 col-md-4 col-lg-2">
					<h2 class="site-footer__heading"><?php esc_html_e( 'Services', 'cb-hesis2026' ); ?></h2>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer_services',
							'container'      => false,
							'menu_class'     => 'site-footer__menu',
							'fallback_cb'    => false,
							'depth'          => 1,
						)
					);
					?>
				</div>
				<div class="col-6 col-md-4 col-lg-2">
					<h2 class="site-footer__heading"><?php esc_html_e( 'Company', 'cb-hesis2026' ); ?></h2>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer_company',
							'container'      => false,
							'menu_class'     => 'site-footer__menu',
							'fallback_cb'    => false,
							'depth'          => 1,
						)
					);
					?>
				</div>
				<div class="col-12 col-md-4 col-lg-3 site-footer__contact">
					<h2 class="site-footer__heading"><?php esc_html_e( 'Contact', 'cb-hesis2026' ); ?></h2>
					<?php
					foreach ( $cb_hesis2026_offices as $cb_hesis2026_office ) {
						if ( empty( $cb_hesis2026_office['name'] ) && empty( $cb_hesis2026_office['line_1'] ) ) {
							continue;
						}
						?>
					<address class="site-footer__office">
						<?php
						if ( ! empty( $cb_hesis2026_office['name'] ) ) {
							?>
						<strong><?php echo esc_html( $cb_hesis2026_office['name'] ); ?></strong>
							<?php
						}
						foreach ( array( 'line_1', 'line_2', 'postcode' ) as $cb_hesis2026_part ) {
							if ( ! empty( $cb_hesis2026_office[ $cb_hesis2026_part ] ) ) {
								?>
						<span><?php echo esc_html( $cb_hesis2026_office[ $cb_hesis2026_part ] ); ?></span>
								<?php
							}
						}
						?>
					</address>
						<?php
					}
					if ( $cb_hesis2026_phone ) {
						?>
					<p class="site-footer__phone">T: <a href="tel:<?php echo esc_attr( parse_phone( $cb_hesis2026_phone ) ); ?>"><?php echo esc_html( $cb_hesis2026_phone ); ?></a></p>
						<?php
					}
					if ( $cb_hesis2026_email ) {
						?>
					<p class="site-footer__email"><a href="mailto:<?php echo esc_attr( antispambot( $cb_hesis2026_email ) ); ?>"><?php echo antispambot( esc_html( $cb_hesis2026_email ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- antispambot() of an escaped string. ?></a></p>
						<?php
					}
					?>
				</div>
			</div>
			<div class="site-footer__legal d-flex flex-column flex-lg-row justify-content-between gap-2">
				<div>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> HESIS Ltd. All rights reserved. An <strong>andwis.</strong> group company.</div>
				<?php
				if ( $cb_hesis2026_legal_pages ) {
					?>
				<div class="site-footer__legal-links d-flex flex-wrap gap-3">
					<?php
					foreach ( $cb_hesis2026_legal_pages as $cb_hesis2026_url => $cb_hesis2026_label ) {
						?>
					<a href="<?php echo esc_url( $cb_hesis2026_url ); ?>"><?php echo esc_html( $cb_hesis2026_label ); ?></a>
						<?php
					}
					?>
				</div>
					<?php
				}
				?>
			</div>
			<?php
			if ( $cb_hesis2026_legal_lines ) {
				?>
			<p class="site-footer__legal-details"><?php echo implode( '<br>', array_map( 'esc_html', $cb_hesis2026_legal_lines ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- each line escaped. ?></p>
				<?php
			}
			?>
		</div>
	</footer>
	<!-- FOOTER:END -->

	<?php wp_footer(); ?>
</body>
</html>
