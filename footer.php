<?php
/**
 * Footer template.
 *
 * @package Seawinds
 */

$sw = seawinds_brand();
?>
</main><!-- #sw-main -->

<footer class="sw-footer">
	<div class="sw-footer__inner sw-container">

		<div class="sw-footer__col sw-footer__brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sw-footer__logo">
				<img src="<?php echo esc_url( SEAWINDS_URI . '/assets/images/logo.png' ); ?>" alt="<?php esc_attr_e( 'Sea Winds BTL Advertising LLC', 'seawinds' ); ?>" width="187" height="44">
			</a>
			<p class="sw-footer__tagline"><?php echo esc_html( $sw['tagline'] ); ?></p>
			<div class="sw-social">
				<a href="<?php echo esc_url( $sw['facebook'] ); ?>" class="sw-social__link" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><?php echo seawinds_icon( 'facebook' ); // phpcs:ignore ?></a>
				<a href="<?php echo esc_url( $sw['instagram'] ); ?>" class="sw-social__link" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><?php echo seawinds_icon( 'instagram' ); // phpcs:ignore ?></a>
				<a href="<?php echo esc_url( $sw['whatsapp_url'] ); ?>" class="sw-social__link" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><?php echo seawinds_icon( 'whatsapp' ); // phpcs:ignore ?></a>
			</div>
		</div>

		<div class="sw-footer__col sw-footer__nav">
			<div class="sw-footer__nav-col">
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'seawinds' ); ?></a></li>
					<li><a href="<?php echo esc_url( seawinds_page_url( 'about-us', 'about-us' ) ); ?>"><?php esc_html_e( 'About', 'seawinds' ); ?></a></li>
					<li><a href="<?php echo esc_url( seawinds_page_url( 'services', 'services' ) ); ?>"><?php esc_html_e( 'Services', 'seawinds' ); ?></a></li>
					<li><a href="<?php echo esc_url( seawinds_page_url( 'portfolio', 'portfolio' ) ); ?>"><?php esc_html_e( 'Portfolio', 'seawinds' ); ?></a></li>
				</ul>
			</div>
			<div class="sw-footer__nav-col">
				<ul>
					<li><a href="<?php echo esc_url( seawinds_page_url( 'gallery', 'gallery' ) ); ?>"><?php esc_html_e( 'Gallery', 'seawinds' ); ?></a></li>
					<li><a href="<?php echo esc_url( seawinds_page_url( 'our-clients', 'our-clients' ) ); ?>"><?php esc_html_e( 'Clients', 'seawinds' ); ?></a></li>
					<li><a href="<?php echo esc_url( seawinds_page_url( 'contact-us', 'contact-us' ) ); ?>"><?php esc_html_e( 'Contact', 'seawinds' ); ?></a></li>
					<li><a href="<?php echo esc_url( seawinds_page_url( 'blog', 'blog' ) ); ?>"><?php esc_html_e( 'Blog', 'seawinds' ); ?></a></li>
				</ul>
			</div>
		</div>

		<div class="sw-footer__col sw-footer__contact">
			<h4 class="sw-footer__heading"><?php esc_html_e( 'Get In Touch', 'seawinds' ); ?></h4>
			<ul class="sw-footer__contact-list">
				<li><span class="sw-footer__ic"><?php echo seawinds_icon( 'pin' ); // phpcs:ignore ?></span><?php echo esc_html( $sw['address'] ); ?></li>
				<li><span class="sw-footer__ic"><?php echo seawinds_icon( 'phone' ); // phpcs:ignore ?></span><a href="tel:<?php echo esc_attr( $sw['phone1_href'] ); ?>"><?php echo esc_html( $sw['phone1'] ); ?></a></li>
				<li><span class="sw-footer__ic"><?php echo seawinds_icon( 'phone' ); // phpcs:ignore ?></span><a href="tel:<?php echo esc_attr( $sw['phone2_href'] ); ?>"><?php echo esc_html( $sw['phone2'] ); ?></a></li>
				<li><span class="sw-footer__ic"><?php echo seawinds_icon( 'mail' ); // phpcs:ignore ?></span><a href="mailto:<?php echo esc_attr( $sw['email'] ); ?>"><?php echo esc_html( $sw['email'] ); ?></a></li>
			</ul>
			<a href="<?php echo esc_url( $sw['whatsapp_url'] ); ?>" class="sw-btn sw-btn--pill sw-btn--gold sw-footer__wa" target="_blank" rel="noopener noreferrer">
				<?php echo seawinds_icon( 'whatsapp' ); // phpcs:ignore ?>
				<span><?php esc_html_e( 'WhatsApp Us', 'seawinds' ); ?></span>
			</a>
		</div>

	</div>

	<div class="sw-footer__bottom">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Sea Winds BTL Advertising LLC. <?php esc_html_e( 'All rights reserved.', 'seawinds' ); ?></p>
	</div>
</footer>

<?php // ---- Floating WhatsApp button (all pages). ?>
<a href="<?php echo esc_url( $sw['whatsapp_url'] ); ?>" class="sw-float-wa" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'seawinds' ); ?>">
	<?php echo seawinds_icon( 'whatsapp' ); // phpcs:ignore ?>
</a>

<?php wp_footer(); ?>
<!-- SEAWINDS BUILD: 2026-07-28-cnc-phone-v26 -->
</body>
</html>
