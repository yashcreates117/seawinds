<?php
/**
 * Template Name: Contact Page
 * Template Post Type: page
 *
 * @package Seawinds
 */

get_header();
$sw = seawinds_brand();
?>

<section class="sw-page-hero">
	<div class="sw-page-hero__inner">
		<span class="sw-page-hero__eyebrow"><?php esc_html_e( 'Let\'s Build Something', 'seawinds' ); ?></span>
		<h1 class="sw-page-hero__title"><?php esc_html_e( 'Get In Touch', 'seawinds' ); ?></h1>
		<div class="sw-page-hero__underline"></div>
	</div>
</section>

<section class="sw-contact">
	<div class="sw-container">
		<div class="sw-contact__grid">

			<?php // ---- Left: contact info ---- ?>
			<div class="sw-contact-info sw-animate" data-anim="fadeUp">
				<h2 class="sw-contact-info__title"><?php esc_html_e( 'Contact Information', 'seawinds' ); ?></h2>
				<div class="sw-contact-info__list">

					<div class="sw-contact-info__item">
						<span class="sw-contact-info__ic"><?php echo seawinds_icon( 'pin' ); // phpcs:ignore ?></span>
						<div>
							<span class="sw-contact-info__label"><?php esc_html_e( 'Address', 'seawinds' ); ?></span>
							<span class="sw-contact-info__value"><?php echo esc_html( $sw['address'] ); ?></span>
						</div>
					</div>

					<div class="sw-contact-info__item">
						<span class="sw-contact-info__ic"><?php echo seawinds_icon( 'phone' ); // phpcs:ignore ?></span>
						<div>
							<span class="sw-contact-info__label"><?php esc_html_e( 'Phone 1', 'seawinds' ); ?></span>
							<span class="sw-contact-info__value"><a href="tel:<?php echo esc_attr( $sw['phone1_href'] ); ?>"><?php echo esc_html( $sw['phone1'] ); ?></a></span>
							<div class="sw-contact-actions">
								<a href="tel:<?php echo esc_attr( $sw['phone1_href'] ); ?>" class="sw-btn sw-btn--pill sw-btn--outline"><?php esc_html_e( 'Call Now', 'seawinds' ); ?></a>
							</div>
						</div>
					</div>

					<div class="sw-contact-info__item">
						<span class="sw-contact-info__ic"><?php echo seawinds_icon( 'phone' ); // phpcs:ignore ?></span>
						<div>
							<span class="sw-contact-info__label"><?php esc_html_e( 'Phone 2', 'seawinds' ); ?></span>
							<span class="sw-contact-info__value"><a href="tel:<?php echo esc_attr( $sw['phone2_href'] ); ?>"><?php echo esc_html( $sw['phone2'] ); ?></a></span>
							<div class="sw-contact-actions">
								<a href="tel:<?php echo esc_attr( $sw['phone2_href'] ); ?>" class="sw-btn sw-btn--pill sw-btn--outline"><?php esc_html_e( 'Call Now', 'seawinds' ); ?></a>
							</div>
						</div>
					</div>

					<div class="sw-contact-info__item">
						<span class="sw-contact-info__ic"><?php echo seawinds_icon( 'whatsapp' ); // phpcs:ignore ?></span>
						<div>
							<span class="sw-contact-info__label"><?php esc_html_e( 'WhatsApp', 'seawinds' ); ?></span>
							<span class="sw-contact-info__value"><?php echo esc_html( $sw['phone2'] ); ?></span>
							<div class="sw-contact-actions">
								<a href="<?php echo esc_url( $sw['whatsapp_url'] ); ?>" class="sw-btn sw-btn--pill sw-btn--whatsapp-pill" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'WhatsApp Now', 'seawinds' ); ?></a>
							</div>
						</div>
					</div>

					<div class="sw-contact-info__item">
						<span class="sw-contact-info__ic"><?php echo seawinds_icon( 'mail' ); // phpcs:ignore ?></span>
						<div>
							<span class="sw-contact-info__label"><?php esc_html_e( 'Email', 'seawinds' ); ?></span>
							<span class="sw-contact-info__value"><a href="mailto:<?php echo esc_attr( $sw['email'] ); ?>"><?php echo esc_html( $sw['email'] ); ?></a></span>
						</div>
					</div>

				</div>

				<div class="sw-contact-info__social">
					<a href="<?php echo esc_url( $sw['facebook'] ); ?>" class="sw-social__link" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><?php echo seawinds_icon( 'facebook' ); // phpcs:ignore ?></a>
					<a href="<?php echo esc_url( $sw['instagram'] ); ?>" class="sw-social__link" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><?php echo seawinds_icon( 'instagram' ); // phpcs:ignore ?></a>
					<a href="<?php echo esc_url( $sw['whatsapp_url'] ); ?>" class="sw-social__link" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><?php echo seawinds_icon( 'whatsapp' ); // phpcs:ignore ?></a>
				</div>
			</div>

			<?php // ---- Right: contact form ---- ?>
			<div class="sw-animate" data-anim="fadeUp">
				<form id="sw-contact-form" class="sw-form" novalidate>
					<div class="sw-form__row">
						<label class="sw-form__label" for="sw-name"><?php esc_html_e( 'Full Name', 'seawinds' ); ?> <span class="req">*</span></label>
						<input type="text" id="sw-name" name="name" autocomplete="name" required>
						<span class="sw-form__error" data-for="name"><?php esc_html_e( 'Please enter your name.', 'seawinds' ); ?></span>
					</div>

					<div class="sw-form__row">
						<label class="sw-form__label" for="sw-phone"><?php esc_html_e( 'Phone Number', 'seawinds' ); ?> <span class="req">*</span></label>
						<input type="tel" id="sw-phone" name="phone" autocomplete="tel" required>
						<span class="sw-form__error" data-for="phone"><?php esc_html_e( 'Please enter your phone number.', 'seawinds' ); ?></span>
					</div>

					<div class="sw-form__row">
						<label class="sw-form__label" for="sw-email"><?php esc_html_e( 'Email Address', 'seawinds' ); ?> <span class="req">*</span></label>
						<input type="email" id="sw-email" name="email" autocomplete="email" required>
						<span class="sw-form__error" data-for="email"><?php esc_html_e( 'Please enter a valid email address.', 'seawinds' ); ?></span>
					</div>

					<div class="sw-form__row">
						<label class="sw-form__label" for="sw-message"><?php esc_html_e( 'Message', 'seawinds' ); ?></label>
						<textarea id="sw-message" name="message" rows="5"></textarea>
					</div>

					<?php // Honeypot — hidden from users, catches bots. ?>
					<div class="sw-form__honeypot" aria-hidden="true">
						<label for="sw-website"><?php esc_html_e( 'Leave this field empty', 'seawinds' ); ?></label>
						<input type="text" id="sw-website" name="sw_website" tabindex="-1" autocomplete="off">
					</div>

					<button type="submit" class="sw-form__submit"><?php esc_html_e( 'Send Message', 'seawinds' ); ?></button>

					<p class="sw-form__feedback" role="status" aria-live="polite"></p>
				</form>
			</div>

		</div>
	</div>
</section>

<?php
get_footer();
