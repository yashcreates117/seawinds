<?php
/**
 * Header template.
 *
 * @package Seawinds
 */

$sw = seawinds_brand();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- GA4_PLACEHOLDER: paste your GA4 script here -->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="sw-skip-link screen-reader-text" href="#sw-main"><?php esc_html_e( 'Skip to content', 'seawinds' ); ?></a>

<header id="sw-header" class="sw-header" data-transparent="<?php echo is_front_page() ? 'true' : 'false'; ?>">
	<div class="sw-header__inner">

		<div class="sw-header__left">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sw-logo" aria-label="<?php esc_attr_e( 'Sea Winds — Home', 'seawinds' ); ?>">
				<img src="<?php echo esc_url( SEAWINDS_URI . '/assets/images/logo.png' ); ?>" alt="<?php esc_attr_e( 'Sea Winds BTL Advertising LLC', 'seawinds' ); ?>" class="sw-logo__img" width="221" height="52">
			</a>
		</div>

		<nav class="sw-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'seawinds' ); ?>">
			<?php
			if ( has_nav_menu( 'primary_menu' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary_menu',
						'container'      => false,
						'menu_class'     => 'sw-nav__list',
						'depth'          => 2,
						'fallback_cb'    => 'seawinds_default_menu',
					)
				);
			} else {
				seawinds_default_menu();
			}
			?>
		</nav>

		<div class="sw-header__right">
			<a href="<?php echo esc_url( seawinds_page_url( 'contact-us', 'contact-us' ) ); ?>" class="sw-btn sw-btn--pill sw-btn--outline sw-get-in-touch"><?php esc_html_e( 'Get In Touch', 'seawinds' ); ?></a>
			<a href="<?php echo esc_url( $sw['whatsapp_url'] ); ?>" class="sw-whatsapp-btn" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'seawinds' ); ?>">
				<?php echo seawinds_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>

			<button class="sw-hamburger" id="sw-hamburger" aria-label="<?php esc_attr_e( 'Open menu', 'seawinds' ); ?>" aria-expanded="false" aria-controls="sw-drawer">
				<span></span><span></span><span></span>
			</button>
		</div>

	</div>
</header>

<?php // ---- Mobile drawer + overlay. ?>
<div class="sw-drawer-overlay" id="sw-drawer-overlay"></div>
<aside class="sw-drawer" id="sw-drawer" aria-hidden="true">
	<nav class="sw-drawer__nav" aria-label="<?php esc_attr_e( 'Mobile navigation', 'seawinds' ); ?>">
		<?php
		if ( has_nav_menu( 'primary_menu' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'primary_menu',
					'container'      => false,
					'menu_class'     => 'sw-drawer__list',
					'depth'          => 1,
					'fallback_cb'    => 'seawinds_default_menu_drawer',
				)
			);
		} else {
			seawinds_default_menu_drawer();
		}
		?>
	</nav>
	<div class="sw-drawer__actions">
		<a href="<?php echo esc_url( $sw['whatsapp_url'] ); ?>" class="sw-btn sw-btn--whatsapp-pill" target="_blank" rel="noopener noreferrer">
			<?php echo seawinds_icon( 'whatsapp' ); // phpcs:ignore ?>
			<span><?php esc_html_e( 'WhatsApp', 'seawinds' ); ?></span>
		</a>
		<a href="<?php echo esc_url( seawinds_page_url( 'contact-us', 'contact-us' ) ); ?>" class="sw-btn sw-btn--pill sw-btn--gold"><?php esc_html_e( 'Get In Touch', 'seawinds' ); ?></a>
	</div>
</aside>

<main id="sw-main" class="sw-main">
<?php
/**
 * Default hard-coded menu used until the site owner assigns a WordPress menu.
 */
function seawinds_default_menu() {
	$items = seawinds_default_menu_items();
	echo '<ul class="sw-nav__list">';
	foreach ( $items as $item ) {
		$active = seawinds_is_menu_active( $item['url'] ) ? ' class="current-menu-item"' : '';
		printf(
			'<li%1$s><a href="%2$s">%3$s</a></li>',
			$active, // phpcs:ignore
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}

function seawinds_default_menu_drawer() {
	$items = seawinds_default_menu_items();
	echo '<ul class="sw-drawer__list">';
	foreach ( $items as $item ) {
		$active = seawinds_is_menu_active( $item['url'] ) ? ' class="current-menu-item"' : '';
		printf(
			'<li%1$s><a href="%2$s">%3$s</a></li>',
			$active, // phpcs:ignore
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}

function seawinds_default_menu_items() {
	return array(
		array( 'label' => 'Home', 'url' => home_url( '/' ) ),
		array( 'label' => 'About', 'url' => seawinds_page_url( 'about-us', 'about-us' ) ),
		array( 'label' => 'Services', 'url' => seawinds_page_url( 'services', 'services' ) ),
		array( 'label' => 'Portfolio', 'url' => seawinds_page_url( 'portfolio', 'portfolio' ) ),
		array( 'label' => 'Gallery', 'url' => seawinds_page_url( 'gallery', 'gallery' ) ),
		array( 'label' => 'Clients', 'url' => seawinds_page_url( 'our-clients', 'our-clients' ) ),
		array( 'label' => 'Contact', 'url' => seawinds_page_url( 'contact-us', 'contact-us' ) ),
		array( 'label' => 'Blog', 'url' => seawinds_page_url( 'blog', 'blog' ) ),
	);
}

function seawinds_is_menu_active( $url ) {
	$current = home_url( add_query_arg( array(), $GLOBALS['wp']->request ) );
	$current = trailingslashit( $current );
	$url     = trailingslashit( $url );
	if ( home_url( '/' ) === $url ) {
		return is_front_page();
	}
	return $current === $url;
}
