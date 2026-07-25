<?php
/**
 * Front page (homepage) template.
 *
 * @package Seawinds
 */

get_header();

// Diagnostic marker — view page source and search for this string to confirm
// this template rendered. Safe to delete once the homepage is confirmed working.
echo "\n<!-- SEAWINDS TEMPLATE: front-page.php -->\n";

// Section 4 — Our Work Glimpses cards.
$sw_glimpses = array(
	array( 'title' => 'Exhibition Stand',   'url' => home_url( '/portfolio/exhibition-stand/' ),               'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-122041-1.png' ),
	array( 'title' => 'Sign Board',         'url' => home_url( '/portfolio/outdoor-signboard/' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/0340a8_c135de1dd66346bb9eba449d1198945dmv2.jpg' ),
	array( 'title' => 'Graphics',           'url' => home_url( '/portfolio/indoor-outdoor-graphics-branding/' ),                     'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/Digital-printing.jpg' ),
	array( 'title' => 'Shop Decor',         'url' => home_url( '/portfolio/shop-front-signs/' ),               'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/0340a8_8022e3848a8b4a5aac215e13e4f84bd5mv2.jpg' ),
	array( 'title' => 'Mall Kiosk',         'url' => home_url( '/portfolio/mall-kiosk/' ),                     'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/Khalidiya-kiosk-view-2_JPG.jpg' ),
	array( 'title' => 'Shop Front Signs',   'url' => home_url( '/portfolio/shop-front-signs/' ),               'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/Al-Jaber-signboard-_-Arabian-Centre_JPG.jpg' ),
	array( 'title' => 'Hoarding Graphics',  'url' => home_url( '/portfolio/hoarding-graphics/' ),              'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-122726-1.png' ),
	array( 'title' => 'Island Counter',     'url' => home_url( '/portfolio/island-counter/' ),                 'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/12/Screenshot-2024-12-13-123311-1.png' ),
	array( 'title' => 'Display Stands',     'url' => home_url( '/portfolio/gondola/' ),                'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/celebrity-optics-indoor-perspective-view_edited.jpeg' ),
	array( 'title' => 'Outdoor Signboard',  'url' => home_url( '/portfolio/outdoor-signboard/' ),              'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-113048-1.png' ),
	array( 'title' => 'Event Branding',     'url' => home_url( '/portfolio/event-branding/' ),                 'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-121634-1.png' ),
	array( 'title' => 'Wall Unit',          'url' => home_url( '/portfolio/wall-unit/' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/celebrity-optics-wall-unit-display_JPG.jpeg' ),
	array( 'title' => 'Promotion Stand',    'url' => home_url( '/portfolio/promotion-stand/' ),                'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/12/Screenshot-2024-12-13-125251-1.png' ),
	array( 'title' => 'Reception Signage',  'url' => home_url( '/portfolio/reception-signage/' ),              'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-121017-1.png' ),
	array( 'title' => 'In-Store Graphics',  'url' => home_url( '/portfolio/indoor-outdoor-graphics-branding/' ), 'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-121330-1.png' ),
	array( 'title' => 'Gondola',            'url' => home_url( '/portfolio/gondola/' ),                        'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/island-gondola-2-t_JPG.jpeg' ),
);

// Section 6 — Happy Customers client logos.
$sw_logos = array(
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_c0c2d47b2bba4b15887ab33350a836e0mv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_4888bbb5cfbc4e5a9ccca4e4f552dd6amv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_ba6d1bc6c8804b8aa2ffdc4dcfa8227fmv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_c0a5505d62ed4ff1bb1e370ea5b0d69emv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_a8e2089e80794c9b9ca4e632b31f7ab6mv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_97b0df9abd17404d99c0b28499e3bc49mv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_4f7979174d9944e4b89f674db8363256mv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_222dbd7a67184ec9b4f96d1823914f9cmv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_aad6bbd35e584641b23139596d6a319bmv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_5b499f6b466b43e1a6c095598a07c1dfmv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_6c8be014eae9489e9b250f2feb95e3f9mv2.avif',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_f34ea506c8a94fe98b12b170c865b082mv2-1.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/Screenshot-2024-12-03-110746.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_1ffd0d480a9741348fa30a901e10d10d_mv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_5a95d311224247dca2296a3392ec0f4c_mv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_f342184c0997411b8e9ccd033a334573_mv2.png',
	'https://seawindsadvertising.com/wp-content/uploads/2024/12/0340a8_ab974eb2ffe44063aab7f2959724e874_mv2.png',
);
$sw_logos_half = (int) ceil( count( $sw_logos ) / 2 );
$sw_logos_row1 = array_slice( $sw_logos, 0, $sw_logos_half );
$sw_logos_row2 = array_slice( $sw_logos, $sw_logos_half );
?>

<?php // ===== Section 1 — Hero ===== ?>
<?php get_template_part( 'templates/hero' ); ?>

<?php // ===== Section 2 — Experience Bar ===== ?>
<section class="sw-experience sw-section--darker" id="sw-experience">
	<div class="sw-container sw-experience__inner sw-animate" data-anim="fadeUp">
		<span class="sw-experience__num">20+</span>
		<span class="sw-experience__label"><?php esc_html_e( 'Years of Experience', 'seawinds' ); ?></span>
	</div>
</section>

<?php // ===== Section 3 — Intro Text ===== ?>
<section class="sw-section sw-intro-text sw-section--light">
	<div class="sw-container sw-intro-text__inner sw-animate" data-anim="fadeUp">
		<h2 class="sw-intro-text__title"><?php esc_html_e( 'Welcome to Sea Winds BTL Advertising', 'seawinds' ); ?></h2>
		<p class="sw-intro-text__sub"><?php esc_html_e( 'Graphics, Signage & Display Stands Manufacturing Company', 'seawinds' ); ?></p>
		<p class="sw-intro-text__body">
			<?php esc_html_e( 'One stop shop for digital printing, display stands, exhibition stands, counters, in-store branding, event branding, indoor signage, outdoor sign boards, and much more. We have in-house facility of digital printing, vinyl plotting, CNC router cutting, laser cutting, laser engraving, acrylic fabrication, wooden fabrication, painting & installations. We have technically qualified & experienced people, specialized in respective fields to execute different kinds of display & branding projects with quality excellence and reliability. It\'s truly a fusion of creative ideas combined with skillful craftsmanship and attention to details thus exceeding client satisfaction in all areas.', 'seawinds' ); ?>
		</p>
	</div>
</section>

<?php // ===== Section 4 — Our Work Glimpses ===== ?>
<section class="sw-section sw-glimpses sw-section--dark">
	<div class="sw-container">
		<div class="sw-section__head sw-animate" data-anim="fadeUp">
			<span class="sw-eyebrow"><?php esc_html_e( 'A Selection of Our Finest Projects', 'seawinds' ); ?></span>
			<h2 class="sw-section__title sw-section__title--light"><?php esc_html_e( 'Our Work Glimpses', 'seawinds' ); ?></h2>
		</div>

		<div class="sw-glimpses__grid sw-stagger">
			<?php foreach ( $sw_glimpses as $card ) : ?>
				<a href="<?php echo esc_url( $card['url'] ); ?>" class="sw-glimpse-card sw-animate" data-anim="fadeUp">
					<div class="sw-glimpse-card__media">
						<img src="<?php echo esc_url( $card['img'] ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>" loading="lazy" decoding="async" draggable="false">
						<span class="sw-glimpse-card__overlay" aria-hidden="true"></span>
					</div>
					<div class="sw-glimpse-card__body">
						<h3 class="sw-glimpse-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
						<span class="sw-glimpse-card__more"><?php esc_html_e( 'View More', 'seawinds' ); ?> &rarr;</span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php // ===== Section 5 — Services Carousel ===== ?>
<?php get_template_part( 'templates/services-carousel' ); ?>

<?php // ===== Section 6 — Happy Customers ===== ?>
<section class="sw-section sw-clients-strip sw-section--dark">
	<div class="sw-container">
		<div class="sw-section__head sw-animate" data-anim="fadeUp">
			<h2 class="sw-section__title sw-section__title--light"><?php esc_html_e( 'Our Happy Customers', 'seawinds' ); ?></h2>
		</div>
	</div>

	<div class="sw-marquee" aria-hidden="false">
		<div class="sw-marquee__row sw-marquee__row--left">
			<?php for ( $i = 0; $i < 2; $i++ ) : ?>
				<div class="sw-marquee__group">
					<?php foreach ( $sw_logos_row1 as $logo ) : ?>
						<a href="<?php echo esc_url( seawinds_page_url( 'our-clients', 'our-clients' ) ); ?>" class="sw-logo-box" aria-label="<?php esc_attr_e( 'View our clients', 'seawinds' ); ?>">
							<img src="<?php echo esc_url( $logo ); ?>" alt="<?php esc_attr_e( 'Client logo', 'seawinds' ); ?>" loading="lazy" decoding="async" draggable="false">
						</a>
					<?php endforeach; ?>
				</div>
			<?php endfor; ?>
		</div>

		<div class="sw-marquee__row sw-marquee__row--right">
			<?php for ( $i = 0; $i < 2; $i++ ) : ?>
				<div class="sw-marquee__group">
					<?php foreach ( $sw_logos_row2 as $logo ) : ?>
						<a href="<?php echo esc_url( seawinds_page_url( 'our-clients', 'our-clients' ) ); ?>" class="sw-logo-box" aria-label="<?php esc_attr_e( 'View our clients', 'seawinds' ); ?>">
							<img src="<?php echo esc_url( $logo ); ?>" alt="<?php esc_attr_e( 'Client logo', 'seawinds' ); ?>" loading="lazy" decoding="async" draggable="false">
						</a>
					<?php endforeach; ?>
				</div>
			<?php endfor; ?>
		</div>
	</div>
</section>

<?php // ===== Section 7 — Testimonials ===== ?>
<?php get_template_part( 'templates/testimonials' ); ?>

<?php // ===== Section 8 — Why Sea Winds ===== ?>
<?php get_template_part( 'templates/why-seawinds' ); ?>

<?php
get_footer();
