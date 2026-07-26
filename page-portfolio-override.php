<?php
/**
 * Portfolio content (the single source of truth for the Portfolio page).
 *
 * Force-loaded by seawinds_template_router() / seawinds_portfolio_override_template()
 * for any /portfolio/ request. Self-contained (hardcoded arrays), so it renders
 * correctly whether WP treats /portfolio/ as a page, CPT archive, or Elementor
 * page.
 *
 * @package Seawinds
 */

// Force this template to ignore Elementor rendering.
if ( ! defined( 'ELEMENTOR_NO_RENDER' ) ) {
	define( 'ELEMENTOR_NO_RENDER', true );
}
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/*
 * The 33+ CATEGORY boxes. Each links to its subpage /portfolio/<slug>/ unless a
 * 'url' override is set (e.g. Neon Signs → the shop). 'cats' drives the filter
 * tabs + the small gold label; the FIRST entry is the primary label.
 */
$sw_cat_labels = array(
	'events-exhibition' => 'Events & Exhibition',
	'display-stands'    => 'Display Stands',
	'signage'           => 'Signage',
	'graphics'          => 'Graphics',
);

$sw_items = array(
	// --- Events & Exhibition ---
	array( 'title' => 'Exhibition Stand',  'slug' => 'exhibition-stand',                'cats' => array( 'events-exhibition' ),                   'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-122041-1.png' ),
	array( 'title' => 'Photo Booth',       'slug' => 'photo-booth',                     'cats' => array( 'events-exhibition', 'display-stands' ), 'img' => 'https://seawindsadvertising.com/wp-content/uploads/2025/01/vic-secrets-1.jpg' ),
	array( 'title' => 'Event Branding',    'slug' => 'event-branding',                  'cats' => array( 'events-exhibition', 'graphics' ),       'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-121634-1.png' ),
	array( 'title' => 'Press Wall',        'slug' => 'press-wall',                      'cats' => array( 'events-exhibition' ),                   'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/t-Watani-Flag-Day-event-branding-4-_-Etihad-Museum-Jumeirah.jpeg' ),
	array( 'title' => 'Themed Structures', 'slug' => 'themed-structures',               'cats' => array( 'events-exhibition', 'display-stands' ), 'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/12/Screenshot-2024-12-13-134953-1.png' ),
	array( 'title' => 'Flags',             'slug' => 'flags-printing',                  'cats' => array( 'events-exhibition', 'graphics' ),       'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-122327-1.png' ),
	array( 'title' => 'Promotion Stand',   'slug' => 'promotion-stand',                 'cats' => array( 'events-exhibition', 'display-stands' ), 'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/12/Screenshot-2024-12-13-125251-1.png' ),
	array( 'title' => 'Pop-Up Stand',      'slug' => 'pop-up-stand',                    'cats' => array( 'events-exhibition', 'display-stands' ), 'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/P1040685_JPG.jpeg' ),

	// --- Display Stands ---
	array( 'title' => 'Gondola',           'slug' => 'gondola',                         'cats' => array( 'display-stands' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-123037-1.png' ),
	array( 'title' => 'Island Counter',    'slug' => 'island-counter',                  'cats' => array( 'display-stands' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/12/Screenshot-2024-12-13-123311-1.png' ),
	array( 'title' => 'Mall Kiosk',        'slug' => 'mall-kiosk',                      'cats' => array( 'display-stands' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/12/Screenshot-2024-12-13-124640-1.png' ),
	array( 'title' => 'Optical Displays',  'slug' => 'optical-display',                 'cats' => array( 'display-stands' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/12/Screenshot-2024-12-13-124129-1.png' ),
	array( 'title' => 'Light Box',         'slug' => 'light-box',                       'cats' => array( 'display-stands' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/xpress-indoor-sign-3_11zon-t.jpeg' ),
	array( 'title' => 'Acrylic Fabrication','slug' => 'acrylic-fabrication',            'cats' => array( 'display-stands' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/12/Screenshot-2024-12-13-141158-1-1.png' ),
	array( 'title' => 'Mall Podium',       'slug' => 'mall-podium',                     'cats' => array( 'display-stands' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/12/Screenshot-2024-12-13-124952-1.png' ),
	array( 'title' => 'Roll-up Stands',    'slug' => 'roll-up-stands',                  'cats' => array( 'display-stands' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/celebrity-optics-indoor-perspective-view_edited.jpeg' ),
	array( 'title' => 'Pop-Up Counter',    'slug' => 'pop-up-counter',                  'cats' => array( 'display-stands' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/P1080171-new_JPG.jpg' ),
	array( 'title' => 'Pillar Unit',       'slug' => 'pillar-unit',                     'cats' => array( 'display-stands' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/12/Screenshot-2024-12-13-134709-1.png' ),
	array( 'title' => 'Wall Unit',         'slug' => 'wall-unit',                       'cats' => array( 'display-stands' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/celebrity-optics-wall-unit-display_JPG.jpeg' ),
	array( 'title' => 'Window Display',    'slug' => 'window-display',                  'cats' => array( 'display-stands' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/0340a8_8022e3848a8b4a5aac215e13e4f84bd5mv2.jpg' ),
	array( 'title' => 'Interior Decor',    'slug' => 'interior-decor',                  'cats' => array( 'display-stands' ),                      'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/celebrity-optics-indoor-perspective-view_edited.jpeg' ),

	// --- Signage ---
	array( 'title' => 'Outdoor Signboard', 'slug' => 'outdoor-signboard',               'cats' => array( 'signage' ),                             'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-113048-1.png' ),
	array( 'title' => 'Shop Front Signage','slug' => 'shop-front-signs',                'cats' => array( 'signage' ),                             'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-120527-1-1.png' ),
	array( 'title' => 'Reception Signage', 'slug' => 'reception-signage',               'cats' => array( 'signage' ),                             'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-121017-1.png' ),
	array( 'title' => 'Pylon Signage',     'slug' => 'pylon-signage',                   'cats' => array( 'signage' ),                             'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/Al-Jaber-signboard-_-Arabian-Centre_JPG.jpg' ),
	array( 'title' => 'Neon Signs',        'slug' => 'neon-signs',  'url' => home_url( '/shop/' ), 'cats' => array( 'signage' ),                    'img' => 'https://seawindsadvertising.com/wp-content/uploads/2025/05/neon-tunnel-dubai-scaled-1.jpg' ),
	array( 'title' => 'Corporate Logo',    'slug' => 'corporate-logo',                  'cats' => array( 'signage' ),                             'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/0340a8_c135de1dd66346bb9eba449d1198945dmv2.jpg' ),
	array( 'title' => 'CNC Cutting',       'slug' => 'cnc-cutting',                     'cats' => array( 'signage' ),                             'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/1_11zon-t.jpeg' ),

	// --- Graphics ---
	array( 'title' => 'Graphics Branding', 'slug' => 'indoor-outdoor-graphics-branding', 'cats' => array( 'graphics' ),                           'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-121330-1.png' ),
	array( 'title' => 'Hoarding Graphics', 'slug' => 'hoarding-graphics',               'cats' => array( 'graphics' ),                            'img' => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-122726-1.png' ),
	array( 'title' => 'Outdoor Hoarding',  'slug' => 'outdoor-hoarding',                'cats' => array( 'graphics' ),                            'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/b-young-arabian-hoarding-branding_11zon-t.jpg' ),
	array( 'title' => 'Cut-outs Mascot',   'slug' => 'cut-outs-mascot',                 'cats' => array( 'graphics' ),                            'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/Digital-printing.jpg' ),

	// --- Blank / coming soon, positioned at the end ---
	array( 'title' => 'Vehicle Graphics',  'slug' => 'vehicle-graphics',                'cats' => array( 'graphics' ),                            'img' => 'https://seawindsadvertising.com/wp-content/uploads/2024/11/Hitachi-2.jpg' ),
	array( 'title' => 'Insta Box',         'slug' => 'insta-box',                       'cats' => array( 'events-exhibition' ),                   'img' => 'https://seawindsadvertising.com/wp-content/uploads/2025/05/027-JC_EVENT-scaled-1-1536x1024-1.jpg' ),
);
?>

<section class="sw-page-hero">
	<div class="sw-page-hero__inner">
		<span class="sw-page-hero__eyebrow"><?php esc_html_e( 'Our Work', 'seawinds' ); ?></span>
		<h1 class="sw-page-hero__title"><?php esc_html_e( 'Portfolio', 'seawinds' ); ?></h1>
		<div class="sw-page-hero__underline"></div>
	</div>
</section>

<?php // ---- Filter tabs on a light (#F7F5F0) bar ---- ?>
<div class="sw-filter sw-filter--light" role="tablist" aria-label="<?php esc_attr_e( 'Filter portfolio', 'seawinds' ); ?>">
	<button class="sw-filter__btn is-active" data-filter="all"><?php esc_html_e( 'All', 'seawinds' ); ?></button>
	<button class="sw-filter__btn" data-filter="events-exhibition"><?php esc_html_e( 'Events & Exhibition', 'seawinds' ); ?></button>
	<button class="sw-filter__btn" data-filter="display-stands"><?php esc_html_e( 'Display Stands', 'seawinds' ); ?></button>
	<button class="sw-filter__btn" data-filter="signage"><?php esc_html_e( 'Signage', 'seawinds' ); ?></button>
	<button class="sw-filter__btn" data-filter="graphics"><?php esc_html_e( 'Graphics', 'seawinds' ); ?></button>
</div>

<section class="sw-pf sw-section--light">
	<div class="sw-container">
		<div class="sw-pf__grid sw-stagger" id="sw-portfolio-grid">
			<?php
			foreach ( $sw_items as $item ) :
				$primary = $item['cats'][0];
				$link    = ! empty( $item['url'] ) ? $item['url'] : home_url( '/portfolio/' . $item['slug'] . '/' );
				?>
				<a href="<?php echo esc_url( $link ); ?>" class="sw-pf-card sw-animate" data-anim="fadeUp" data-cat="<?php echo esc_attr( implode( ' ', $item['cats'] ) ); ?>">
					<div class="sw-pf-card__media">
						<img src="<?php echo esc_url( $item['img'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy" decoding="async" draggable="false">
					</div>
					<div class="sw-pf-card__body">
						<span class="sw-pf-card__cat"><?php echo esc_html( $sw_cat_labels[ $primary ] ); ?></span>
						<h3 class="sw-pf-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
					</div>
				</a>
			<?php endforeach; ?>
		</div>

		<div class="sw-center-cta">
			<a href="<?php echo esc_url( seawinds_page_url( 'contact-us', 'contact-us' ) ); ?>" class="sw-btn sw-btn--pill sw-btn--gold sw-btn--lg"><?php esc_html_e( 'Get In Touch', 'seawinds' ); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();
