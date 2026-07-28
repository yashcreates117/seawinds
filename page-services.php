<?php
/**
 * Template Name: Services Page
 * Template Post Type: page
 *
 * Auto-loads for the page with slug "services".
 *
 * @package Seawinds
 */

get_header();

$sw_categories = array(
	array(
		'num'      => '01',
		'title'    => 'General Services',
		'dark'     => true,
		'services' => array(
			'Acrylic Fabrication', 'Wooden Fabrication', 'Signboard Fabrication', 'Interior Joinery',
			'Spray Booth Painting', 'Acrylic Laser Cutting', 'CNC Router Cutting', 'Large Format Printing',
			'Digital Vinyl Cutting', 'Lamination & Mounting', 'Indoor & Outdoor Installation',
		),
	),
	array(
		'num'      => '02',
		'title'    => 'Decor & Displays',
		'dark'     => false,
		'services' => array(
			'Acrylic Display Stand', 'In-store Display Units', 'Custom Acrylic Cubes', 'Counter-top Display',
			'Island Counter', 'Gondola Counter', 'Wall Unit Display', 'Pillar Unit Display', 'Perfume Unit',
			'Cosmetics Display', 'Shopping Mall Kiosk', 'Jewelry Kiosk', 'Modular Stands', 'Trade Show Stands',
			'Promotion Stands', 'Exhibition Stands', 'Promotional Counters', 'Road Show Stands', 'Product Display',
		),
	),
	array(
		'num'      => '03',
		'title'    => 'Digital Printing',
		'dark'     => true,
		'services' => array(
			'Press Wall', 'Event Branding', 'Vinyl Graphics', 'Banners', 'Flexface', 'Laminated Posters',
			'Light-box Durotrans', 'One-way Vision Prints', 'Vinyl-cut Stickers', 'Pop-up Stand', 'Roll Up Banner Graphics',
		),
	),
	array(
		'num'      => '04',
		'title'    => 'Indoor & Outdoor Signage',
		'dark'     => false,
		'services' => array(
			'Acrylic Glass Wood & Metal', 'Custom Indoor Signage', 'Outdoor Signboard', 'Directional Sign',
			'External Pylon Signage', 'Exterior Building Signage', 'Shop-front Signage', 'Reception Signage',
			'Mall Signage', 'Wall Signage', 'Office Signage', 'Door Signage', 'LED Back-lit Letters', '3D Embossed Logo',
		),
	),
);

/*
 * Services that map cleanly to a portfolio category → the pill becomes a link
 * to /portfolio/<slug>/. Only confident matches are listed; every other
 * service stays a plain, non-clickable tag.
 */
$sw_service_links = array(
	'Acrylic Fabrication'    => 'acrylic-fabrication',
	'Acrylic Display Stand'  => 'acrylic-fabrication',
	'Custom Acrylic Cubes'   => 'acrylic-fabrication',
	'Acrylic Laser Cutting'  => 'cnc-cutting',
	'CNC Router Cutting'     => 'cnc-cutting',
	'Island Counter'         => 'island-counter',
	'Gondola Counter'        => 'gondola',
	'Wall Unit Display'      => 'wall-unit',
	'Pillar Unit Display'    => 'pillar-unit',
	'Shopping Mall Kiosk'    => 'mall-kiosk',
	'Promotion Stands'       => 'promotion-stand',
	'Exhibition Stands'      => 'exhibition-stand',
	'Press Wall'             => 'press-wall',
	'Event Branding'         => 'event-branding',
	'Pop-up Stand'           => 'pop-up-stand',
	'Light-box Durotrans'    => 'light-box',
	'Outdoor Signboard'      => 'outdoor-signboard',
	'External Pylon Signage' => 'pylon-signage',
	'Shop-front Signage'     => 'shop-front-signs',
	'Reception Signage'      => 'reception-signage',
);
?>

<section class="sw-page-hero">
	<div class="sw-page-hero__inner">
		<span class="sw-page-hero__eyebrow"><?php esc_html_e( 'End-to-End Fabrication & Branding', 'seawinds' ); ?></span>
		<h1 class="sw-page-hero__title"><?php esc_html_e( 'Our Services', 'seawinds' ); ?></h1>
		<div class="sw-page-hero__underline"></div>
	</div>
</section>

<?php foreach ( $sw_categories as $cat ) : ?>
	<section class="sw-section <?php echo $cat['dark'] ? 'sw-section--dark' : 'sw-section--light'; ?>">
		<div class="sw-container">
			<div class="sw-service-cat">
				<div class="sw-service-cat__head sw-animate" data-anim="fadeUp">
					<span class="sw-service-cat__num"><?php echo esc_html( $cat['num'] ); ?></span>
					<h2 class="sw-service-cat__title"><?php echo esc_html( $cat['title'] ); ?></h2>
				</div>
				<div class="sw-pills sw-stagger">
					<?php foreach ( $cat['services'] as $service ) : ?>
						<?php if ( isset( $sw_service_links[ $service ] ) ) : ?>
							<a href="<?php echo esc_url( home_url( '/portfolio/' . $sw_service_links[ $service ] . '/' ) ); ?>" class="sw-pill sw-pill--link sw-animate" data-anim="fadeUp"><?php echo esc_html( $service ); ?></a>
						<?php else : ?>
							<span class="sw-pill sw-animate" data-anim="fadeUp"><?php echo esc_html( $service ); ?></span>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
<?php endforeach; ?>

<?php // ---- Bottom CTA ---- ?>
<section class="sw-cta">
	<div class="sw-container sw-animate" data-anim="fadeUp">
		<h2 class="sw-cta__title"><?php esc_html_e( 'Ready to Start Your Project?', 'seawinds' ); ?></h2>
		<a href="<?php echo esc_url( seawinds_page_url( 'contact-us', 'contact-us' ) ); ?>" class="sw-btn sw-btn--pill sw-btn--gold sw-btn--lg"><?php esc_html_e( 'Get In Touch', 'seawinds' ); ?></a>
	</div>
</section>

<?php
get_footer();
