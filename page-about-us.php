<?php
/**
 * Template Name: About Page
 * Template Post Type: page
 *
 * Named page-about-us.php so it also auto-loads for the page with slug
 * "about-us" even if no template is manually assigned.
 *
 * @package Seawinds
 */

get_header();
?>

<section class="sw-page-hero">
	<div class="sw-page-hero__inner">
		<span class="sw-page-hero__eyebrow"><?php esc_html_e( 'Sea Winds BTL Advertising', 'seawinds' ); ?></span>
		<h1 class="sw-page-hero__title"><?php esc_html_e( 'About Us', 'seawinds' ); ?></h1>
		<div class="sw-page-hero__underline"></div>
	</div>
</section>

<?php // ---- Section 1 — Who We Are (light) ---- ?>
<section class="sw-section sw-section--light">
	<div class="sw-container sw-about-two">
		<div class="sw-about-block sw-animate" data-anim="fadeUp">
			<h2 class="sw-about-block__title"><?php esc_html_e( 'Who We Are', 'seawinds' ); ?></h2>
		</div>
		<div class="sw-about-block sw-animate" data-anim="fadeUp">
			<p><?php esc_html_e( 'Sea Winds BTL Advertising LLC is a Dubai-based full-service fabrication and branding company specializing in display stands, exhibition stands, signage, and large-format graphics. Founded over two decades ago, we have built a reputation for delivering quality craftsmanship and creative excellence across the UAE.', 'seawinds' ); ?></p>
		</div>
	</div>
</section>

<?php // ---- Section 2 — What We Do (dark) ---- ?>
<section class="sw-section sw-section--dark">
	<div class="sw-container">
		<div class="sw-section__head sw-animate" data-anim="fadeUp">
			<span class="sw-eyebrow"><?php esc_html_e( 'Our Expertise', 'seawinds' ); ?></span>
			<h2 class="sw-section__title sw-section__title--light"><?php esc_html_e( 'What We Do', 'seawinds' ); ?></h2>
		</div>
		<div class="sw-feature-grid sw-stagger">
			<div class="sw-feature sw-animate" data-anim="fadeUp">
				<span class="sw-feature__icon"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 2 2.4 7.4H22l-6 4.6 2.3 7.4-6.3-4.6L5.7 21.4 8 14 2 9.4h7.6z"/></svg></span>
				<h3 class="sw-feature__title"><?php esc_html_e( 'Creative Branding', 'seawinds' ); ?></h3>
				<p class="sw-feature__desc"><?php esc_html_e( 'In-store and event branding solutions tailored to your identity.', 'seawinds' ); ?></p>
			</div>
			<div class="sw-feature sw-animate" data-anim="fadeUp">
				<span class="sw-feature__icon"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 4 20 10 10 20 4 20 4 14z"/><path d="m13 5 6 6"/></svg></span>
				<h3 class="sw-feature__title"><?php esc_html_e( 'Precision Fabrication', 'seawinds' ); ?></h3>
				<p class="sw-feature__desc"><?php esc_html_e( 'Acrylic, wood, metal — crafted in our in-house facility.', 'seawinds' ); ?></p>
			</div>
			<div class="sw-feature sw-animate" data-anim="fadeUp">
				<span class="sw-feature__icon"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h13v10H3z"/><path d="M16 10h3l2 3v4h-5z"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg></span>
				<h3 class="sw-feature__title"><?php esc_html_e( 'End-to-End Delivery', 'seawinds' ); ?></h3>
				<p class="sw-feature__desc"><?php esc_html_e( 'From design to installation, we manage every step.', 'seawinds' ); ?></p>
			</div>
		</div>
	</div>
</section>

<?php // ---- Section 3 — Our Facility (light) ---- ?>
<section class="sw-section sw-section--light">
	<div class="sw-container sw-about-two">
		<div class="sw-about-block sw-animate" data-anim="fadeUp">
			<h2 class="sw-about-block__title"><?php esc_html_e( 'Our Facility', 'seawinds' ); ?></h2>
		</div>
		<div class="sw-about-block sw-animate" data-anim="fadeUp">
			<p><?php esc_html_e( 'Our in-house capabilities include digital printing, vinyl plotting, CNC router cutting, laser cutting, laser engraving, acrylic fabrication, wooden fabrication, painting and installations — all under one roof in Al Quoz, Dubai.', 'seawinds' ); ?></p>
		</div>
	</div>
</section>

<?php // ---- Section 4 — Numbers (dark) ---- ?>
<section class="sw-section sw-section--dark">
	<div class="sw-container">
		<div class="sw-stats sw-stagger">
			<div class="sw-animate" data-anim="fadeUp">
				<span class="sw-stat__num" data-count="20" data-suffix="+">0+</span>
				<span class="sw-stat__label"><?php esc_html_e( 'Years', 'seawinds' ); ?></span>
			</div>
			<div class="sw-animate" data-anim="fadeUp">
				<span class="sw-stat__num" data-count="500" data-suffix="+">0+</span>
				<span class="sw-stat__label"><?php esc_html_e( 'Projects', 'seawinds' ); ?></span>
			</div>
			<div class="sw-animate" data-anim="fadeUp">
				<span class="sw-stat__num" data-count="200" data-suffix="+">0+</span>
				<span class="sw-stat__label"><?php esc_html_e( 'Clients', 'seawinds' ); ?></span>
			</div>
			<div class="sw-animate" data-anim="fadeUp">
				<span class="sw-stat__num">Dubai</span>
				<span class="sw-stat__label"><?php esc_html_e( 'UAE', 'seawinds' ); ?></span>
			</div>
		</div>
	</div>
</section>

<?php // ---- Section 5 — Why Choose Us (light) ---- ?>
<?php get_template_part( 'templates/why-seawinds', null, array( 'title' => 'Why Choose Us', 'variant' => 'light' ) ); ?>

<?php
get_footer();
