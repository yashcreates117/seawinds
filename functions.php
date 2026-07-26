<?php
/**
 * Sea Winds theme functions and definitions.
 *
 * @package Seawinds
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

if ( ! defined( 'SEAWINDS_VERSION' ) ) {
	define( 'SEAWINDS_VERSION', '1.0.0' );
}

define( 'SEAWINDS_DIR', get_template_directory() );
define( 'SEAWINDS_URI', get_template_directory_uri() );

/* -------------------------------------------------------------------------
 * 1. Theme setup
 * ---------------------------------------------------------------------- */
function seawinds_setup() {
	load_theme_textdomain( 'seawinds', SEAWINDS_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Enable featured images for posts and the project CPT.
	add_post_type_support( 'post', 'thumbnail' );

	register_nav_menus(
		array(
			'primary_menu' => __( 'Primary Menu', 'seawinds' ),
			'footer_menu'  => __( 'Footer Menu', 'seawinds' ),
		)
	);
}
add_action( 'after_setup_theme', 'seawinds_setup' );

/* -------------------------------------------------------------------------
 * 2. Custom post type: project + taxonomies
 * ---------------------------------------------------------------------- */
function seawinds_register_project_cpt() {
	$labels = array(
		'name'               => __( 'Projects', 'seawinds' ),
		'singular_name'      => __( 'Project', 'seawinds' ),
		'menu_name'          => __( 'Projects', 'seawinds' ),
		'add_new'            => __( 'Add New', 'seawinds' ),
		'add_new_item'       => __( 'Add New Project', 'seawinds' ),
		'edit_item'          => __( 'Edit Project', 'seawinds' ),
		'new_item'           => __( 'New Project', 'seawinds' ),
		'view_item'          => __( 'View Project', 'seawinds' ),
		'search_items'       => __( 'Search Projects', 'seawinds' ),
		'not_found'          => __( 'No projects found', 'seawinds' ),
		'not_found_in_trash' => __( 'No projects found in Trash', 'seawinds' ),
		'all_items'          => __( 'All Projects', 'seawinds' ),
	);

	register_post_type(
		'project',
		array(
			'labels'             => $labels,
			'public'             => true,
			// Archive is OFF so the base /portfolio/ URL is free for the
			// Portfolio PAGE (page-portfolio.php, the 33-item filter grid).
			// Single projects still live at /portfolio/<project-slug>/.
			'has_archive'        => false,
			'menu_icon'          => 'dashicons-portfolio',
			'menu_position'      => 5,
			'show_in_rest'       => true,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'rewrite'            => array( 'slug' => 'portfolio', 'with_front' => false ),
			'publicly_queryable' => true,
		)
	);

	// Taxonomy: project_category (Portfolio categories, e.g. Exhibition Stand).
	register_taxonomy(
		'project_category',
		'project',
		array(
			'labels'            => array(
				'name'          => __( 'Project Categories', 'seawinds' ),
				'singular_name' => __( 'Project Category', 'seawinds' ),
				'search_items'  => __( 'Search Categories', 'seawinds' ),
				'all_items'     => __( 'All Categories', 'seawinds' ),
				'edit_item'     => __( 'Edit Category', 'seawinds' ),
				'update_item'   => __( 'Update Category', 'seawinds' ),
				'add_new_item'  => __( 'Add New Category', 'seawinds' ),
				'new_item_name' => __( 'New Category Name', 'seawinds' ),
				'menu_name'     => __( 'Categories', 'seawinds' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'project-cat', 'with_front' => false ),
		)
	);

	// Taxonomy: project_item (secondary grouping/tagging).
	register_taxonomy(
		'project_item',
		'project',
		array(
			'labels'            => array(
				'name'          => __( 'Project Items', 'seawinds' ),
				'singular_name' => __( 'Project Item', 'seawinds' ),
				'menu_name'     => __( 'Project Items', 'seawinds' ),
			),
			'hierarchical'      => false,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'project-item', 'with_front' => false ),
		)
	);
}
add_action( 'init', 'seawinds_register_project_cpt' );

/* Flush rewrite rules on activation so the CPT permalinks work immediately. */
function seawinds_rewrite_flush() {
	seawinds_register_project_cpt();
	flush_rewrite_rules();
	seawinds_clean_portfolio_elementor(); // Also strip Elementor data on activation.
}
add_action( 'after_switch_theme', 'seawinds_rewrite_flush' );

/**
 * Remove any Elementor data stored on the Portfolio page and point it at our
 * template. Elementor keeps its layout in post meta + a rendered CSS cache; if
 * those exist it renders its own content instead of page-portfolio-override.php.
 * Safe to run repeatedly.
 */
function seawinds_clean_portfolio_elementor() {
	$portfolio_page = get_page_by_path( 'portfolio' );
	if ( ! $portfolio_page ) {
		return;
	}
	$id = $portfolio_page->ID;

	delete_post_meta( $id, '_elementor_edit_mode' );
	delete_post_meta( $id, '_elementor_template_type' );
	delete_post_meta( $id, '_elementor_version' );
	delete_post_meta( $id, '_elementor_pro_version' );
	delete_post_meta( $id, '_elementor_data' );
	delete_post_meta( $id, '_elementor_css' );
	delete_post_meta( $id, '_elementor_page_settings' );

	// Point the page at our template.
	update_post_meta( $id, '_wp_page_template', 'page-portfolio-override.php' );

	// Clear Elementor's separate CSS cache file/meta if the API is available.
	if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::instance()->files_manager ) ) {
		\Elementor\Plugin::instance()->files_manager->clear_cache();
	}
}

/*
 * One-time auto-run of the Elementor cleanup WITHOUT needing to re-activate the
 * theme. Runs once per marker on a normal page load (admin or front). This is
 * why you don't strictly need to deactivate/reactivate the theme after upload.
 */
function seawinds_maybe_clean_portfolio_elementor() {
	$marker  = 'v1-portfolio-elementor-clean';
	$current = get_option( 'seawinds_elementor_clean' );
	if ( $current !== $marker ) {
		seawinds_clean_portfolio_elementor();
		update_option( 'seawinds_elementor_clean', $marker );
	}
}
add_action( 'init', 'seawinds_maybe_clean_portfolio_elementor', 25 );

/*
 * One-time auto-flush of rewrite rules when the routing config changes, so
 * the site owner doesn't have to visit Settings → Permalinks manually after an
 * update. Runs after the CPT is registered (init priority 20) and flushes only
 * once per "rewrite version" marker below — bump the marker whenever the CPT /
 * taxonomy rewrite config changes.
 */
function seawinds_maybe_flush_rewrites() {
	$marker  = 'v5-category-subpages'; // Bump this string on future rewrite changes.
	$current = get_option( 'seawinds_rewrite_version' );
	if ( $current !== $marker ) {
		flush_rewrite_rules();
		update_option( 'seawinds_rewrite_version', $marker );
	}
}
add_action( 'init', 'seawinds_maybe_flush_rewrites', 20 );

/*
 * Guarantee a real Portfolio PAGE exists at /portfolio/.
 *
 * Root cause of the "Portfolio Archive" problem: there was no WordPress page
 * with slug "portfolio" — /portfolio/ was only ever the project CPT archive, so
 * our page template never had a page to attach to, and Elementor's archive
 * layout rendered instead. This creates (or re-publishes) that page, points it
 * at our template, and strips any Elementor data from it. Runs once per marker.
 * Priority 15 = after the CPT is registered (10) and before the rewrite flush
 * (20), so the freshly-created page is in place when rules are regenerated.
 */
function seawinds_ensure_portfolio_page() {
	if ( 'v4' === get_option( 'seawinds_portfolio_page_ready' ) ) {
		return;
	}

	$existing = get_page_by_path( 'portfolio' );

	if ( $existing ) {
		$page_id = $existing->ID;
		if ( 'publish' !== $existing->post_status ) {
			wp_update_post(
				array(
					'ID'          => $page_id,
					'post_status' => 'publish',
				)
			);
		}
	} else {
		$page_id = wp_insert_post(
			array(
				'post_title'   => 'Portfolio',
				'post_name'    => 'portfolio',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
	}

	if ( $page_id && ! is_wp_error( $page_id ) ) {
		update_post_meta( $page_id, '_wp_page_template', 'page-portfolio-override.php' );

		// Strip Elementor so it can't render its own layout on this page.
		$elementor_meta = array(
			'_elementor_edit_mode',
			'_elementor_template_type',
			'_elementor_version',
			'_elementor_pro_version',
			'_elementor_data',
			'_elementor_css',
			'_elementor_page_settings',
		);
		foreach ( $elementor_meta as $meta_key ) {
			delete_post_meta( $page_id, $meta_key );
		}

		// A new page needs the rewrite rules regenerated so /portfolio/ resolves
		// to it instead of the (now-disabled) CPT archive.
		flush_rewrite_rules();

		update_option( 'seawinds_portfolio_page_ready', 'v4' );
	}
}
add_action( 'init', 'seawinds_ensure_portfolio_page', 15 );

/*
 * Guarantee a real Clients PAGE exists at /our-clients/ using the clients
 * template, so the header "Clients" link (which points to /our-clients/)
 * resolves even if the original page was created at the slug 'our-clients-2'.
 * The clients logo grid is hardcoded in the template, so an otherwise-empty
 * page still renders correctly. Runs once per marker.
 */
function seawinds_ensure_clients_page() {
	if ( 'v1' === get_option( 'seawinds_clients_page_ready' ) ) {
		return;
	}

	$existing = get_page_by_path( 'our-clients' );
	if ( $existing ) {
		$page_id = $existing->ID;
		if ( 'publish' !== $existing->post_status ) {
			wp_update_post( array( 'ID' => $page_id, 'post_status' => 'publish' ) );
		}
	} else {
		$page_id = wp_insert_post(
			array(
				'post_title'   => 'Our Clients',
				'post_name'    => 'our-clients',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
	}

	if ( $page_id && ! is_wp_error( $page_id ) ) {
		update_post_meta( $page_id, '_wp_page_template', 'page-our-clients.php' );
		flush_rewrite_rules();
		update_option( 'seawinds_clients_page_ready', 'v1' );
	}
}
add_action( 'init', 'seawinds_ensure_clients_page', 15 );

/*
 * Reroute the /portfolio/ CPT-archive request to the Portfolio PAGE at the
 * QUERY level, before the main query runs. This is what actually fixes the
 * "Project Archive" browser-tab title: it works even if the rewrite rules were
 * never flushed, because it rewrites the query vars themselves. Only the bare
 * archive request ( post_type=project with no single-project name ) is caught —
 * individual projects at /portfolio/<slug>/ are left alone.
 */
function seawinds_reroute_portfolio_archive( $query_vars ) {
	if (
		isset( $query_vars['post_type'] ) && 'project' === $query_vars['post_type']
		&& empty( $query_vars['name'] )
		&& empty( $query_vars['project'] )
		&& empty( $query_vars['pagename'] )
		&& empty( $query_vars['p'] )
	) {
		$page = get_page_by_path( 'portfolio' );
		if ( $page ) {
			return array( 'pagename' => 'portfolio' );
		}
	}
	return $query_vars;
}
add_filter( 'request', 'seawinds_reroute_portfolio_archive' );

/*
 * Belt-and-suspenders for the browser-tab title: force it to "Portfolio" for
 * any portfolio view (covers the edge case where the reroute above can't run
 * because no Portfolio page exists and it stays an archive).
 */
function seawinds_portfolio_document_title( $parts ) {
	if ( function_exists( 'seawinds_is_portfolio_view' ) && seawinds_is_portfolio_view() ) {
		$parts['title'] = 'Portfolio';
	}
	return $parts;
}
add_filter( 'document_title_parts', 'seawinds_portfolio_document_title' );

/* -------------------------------------------------------------------------
 * 3. Enqueue styles and scripts
 * ---------------------------------------------------------------------- */
/**
 * Version string for an asset based on its file modification time, so any edit
 * to a CSS/JS file automatically busts the browser & CDN cache. Falls back to
 * the theme version if the file can't be read.
 *
 * @param string $rel_path Path relative to the theme root, e.g. 'assets/css/main.css'.
 * @return string
 */
function seawinds_asset_ver( $rel_path ) {
	$full = SEAWINDS_DIR . '/' . ltrim( $rel_path, '/' );
	$mtime = @filemtime( $full ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
	return $mtime ? (string) $mtime : SEAWINDS_VERSION;
}

function seawinds_assets() {
	// Preconnect handled via wp_resource_hints below.

	// Google Fonts.
	wp_enqueue_style(
		'seawinds-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap',
		array(),
		null
	);

	// Theme root stylesheet (theme header only).
	wp_enqueue_style( 'seawinds-style', get_stylesheet_uri(), array(), seawinds_asset_ver( 'style.css' ) );

	// Main CSS. filemtime versioning guarantees fresh CSS after every edit.
	wp_enqueue_style( 'seawinds-main', SEAWINDS_URI . '/assets/css/main.css', array( 'seawinds-fonts' ), seawinds_asset_ver( 'assets/css/main.css' ) );
	wp_enqueue_style( 'seawinds-animations', SEAWINDS_URI . '/assets/css/animations.css', array( 'seawinds-main' ), seawinds_asset_ver( 'assets/css/animations.css' ) );
	wp_enqueue_style( 'seawinds-lightbox', SEAWINDS_URI . '/assets/css/lightbox.css', array( 'seawinds-main' ), seawinds_asset_ver( 'assets/css/lightbox.css' ) );

	// JavaScript (all deferred for performance).
	wp_enqueue_script( 'seawinds-main', SEAWINDS_URI . '/assets/js/main.js', array(), seawinds_asset_ver( 'assets/js/main.js' ), true );
	wp_enqueue_script( 'seawinds-scroll', SEAWINDS_URI . '/assets/js/scroll-animations.js', array(), seawinds_asset_ver( 'assets/js/scroll-animations.js' ), true );
	wp_enqueue_script( 'seawinds-carousel', SEAWINDS_URI . '/assets/js/carousel.js', array(), seawinds_asset_ver( 'assets/js/carousel.js' ), true );
	wp_enqueue_script( 'seawinds-lightbox', SEAWINDS_URI . '/assets/js/lightbox.js', array(), seawinds_asset_ver( 'assets/js/lightbox.js' ), true );
	wp_enqueue_script( 'seawinds-hero', SEAWINDS_URI . '/assets/js/hero.js', array(), seawinds_asset_ver( 'assets/js/hero.js' ), true );
	wp_enqueue_script( 'seawinds-project-modal', SEAWINDS_URI . '/assets/js/project-modal.js', array(), seawinds_asset_ver( 'assets/js/project-modal.js' ), true );

	// Expose data to the frontend (AJAX URL + nonce for the contact form).
	wp_localize_script(
		'seawinds-main',
		'seawindsData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'seawinds_contact_nonce' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'seawinds_assets' );

/* Add defer attribute to non-critical theme scripts. */
function seawinds_defer_scripts( $tag, $handle ) {
	$defer = array( 'seawinds-scroll', 'seawinds-carousel', 'seawinds-lightbox', 'seawinds-hero', 'seawinds-project-modal' );
	if ( in_array( $handle, $defer, true ) ) {
		return str_replace( ' src', ' defer src', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'seawinds_defer_scripts', 10, 2 );

/* Preconnect to Google Fonts. */
function seawinds_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$hints[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$hints[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'seawinds_resource_hints', 10, 2 );

/* -------------------------------------------------------------------------
 * 4. Widget areas (footer)
 * ---------------------------------------------------------------------- */
function seawinds_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer — Column 1', 'seawinds' ),
			'id'            => 'footer-1',
			'description'   => __( 'Optional footer widget area (column 1).', 'seawinds' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="footer-widget-title">',
			'after_title'   => '</h4>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer — Column 2', 'seawinds' ),
			'id'            => 'footer-2',
			'description'   => __( 'Optional footer widget area (column 2).', 'seawinds' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="footer-widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'seawinds_widgets_init' );

/* -------------------------------------------------------------------------
 * 5. Project custom fields (gallery images, name, description)
 * ---------------------------------------------------------------------- */
function seawinds_project_meta_box() {
	add_meta_box(
		'seawinds_project_details',
		__( 'Project Details', 'seawinds' ),
		'seawinds_project_meta_box_html',
		'project',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'seawinds_project_meta_box' );

function seawinds_project_meta_box_html( $post ) {
	wp_nonce_field( 'seawinds_project_save', 'seawinds_project_nonce' );

	$project_name = get_post_meta( $post->ID, '_seawinds_project_name', true );
	$project_desc = get_post_meta( $post->ID, '_seawinds_project_desc', true );
	$gallery      = get_post_meta( $post->ID, '_seawinds_project_gallery', true );
	?>
	<p>
		<label for="seawinds_project_name"><strong><?php esc_html_e( 'Project Name', 'seawinds' ); ?></strong></label><br>
		<input type="text" id="seawinds_project_name" name="seawinds_project_name" value="<?php echo esc_attr( $project_name ); ?>" style="width:100%;" placeholder="<?php esc_attr_e( 'e.g. The Sevens 2025', 'seawinds' ); ?>">
	</p>
	<p>
		<label for="seawinds_project_desc"><strong><?php esc_html_e( 'Project Description', 'seawinds' ); ?></strong></label><br>
		<textarea id="seawinds_project_desc" name="seawinds_project_desc" rows="4" style="width:100%;"><?php echo esc_textarea( $project_desc ); ?></textarea>
	</p>
	<p>
		<label for="seawinds_project_gallery"><strong><?php esc_html_e( 'Gallery Images', 'seawinds' ); ?></strong></label><br>
		<span class="description"><?php esc_html_e( 'Enter attachment IDs OR full image URLs, one per line (or comma-separated). These appear in the project photo grid & lightbox.', 'seawinds' ); ?></span><br>
		<textarea id="seawinds_project_gallery" name="seawinds_project_gallery" rows="6" style="width:100%;"><?php echo esc_textarea( $gallery ); ?></textarea>
	</p>
	<?php
}

function seawinds_project_save_meta( $post_id ) {
	if ( ! isset( $_POST['seawinds_project_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['seawinds_project_nonce'] ) ), 'seawinds_project_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['seawinds_project_name'] ) ) {
		update_post_meta( $post_id, '_seawinds_project_name', sanitize_text_field( wp_unslash( $_POST['seawinds_project_name'] ) ) );
	}
	if ( isset( $_POST['seawinds_project_desc'] ) ) {
		update_post_meta( $post_id, '_seawinds_project_desc', sanitize_textarea_field( wp_unslash( $_POST['seawinds_project_desc'] ) ) );
	}
	if ( isset( $_POST['seawinds_project_gallery'] ) ) {
		update_post_meta( $post_id, '_seawinds_project_gallery', sanitize_textarea_field( wp_unslash( $_POST['seawinds_project_gallery'] ) ) );
	}
}
add_action( 'save_post_project', 'seawinds_project_save_meta' );

/**
 * Parse the stored gallery meta into an array of usable image URLs.
 *
 * @param int $post_id Project ID.
 * @return array URLs.
 */
function seawinds_get_project_gallery( $post_id ) {
	$raw = get_post_meta( $post_id, '_seawinds_project_gallery', true );
	$out = array();

	if ( ! empty( $raw ) ) {
		$parts = preg_split( '/[\r\n,]+/', $raw );
		foreach ( $parts as $part ) {
			$part = trim( $part );
			if ( '' === $part ) {
				continue;
			}
			if ( is_numeric( $part ) ) {
				$url = wp_get_attachment_image_url( (int) $part, 'large' );
				if ( $url ) {
					$out[] = $url;
				}
			} elseif ( filter_var( $part, FILTER_VALIDATE_URL ) ) {
				$out[] = esc_url_raw( $part );
			}
		}
	}

	// Fall back to the featured image if no gallery is set.
	if ( empty( $out ) && has_post_thumbnail( $post_id ) ) {
		$out[] = get_the_post_thumbnail_url( $post_id, 'large' );
	}

	return $out;
}

/* -------------------------------------------------------------------------
 * 6. SEO meta tags
 * ---------------------------------------------------------------------- */
function seawinds_seo_meta() {
	$site_name   = 'Sea Winds BTL Advertising LLC';
	$default_img = SEAWINDS_URI . '/assets/images/logo.png';

	if ( is_front_page() ) {
		$title = $site_name . ' | Creative Branding, Signage & Display Solutions in Dubai';
		$desc  = 'Sea Winds BTL Advertising LLC — your one-stop solution for creative branding, digital printing, signage and display stand fabrication in Dubai. 20+ years of in-house craftsmanship.';
	} elseif ( is_singular() ) {
		$title = get_the_title() . ' | ' . $site_name;
		$desc  = has_excerpt() ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', get_the_ID() ) ), 30, '…' );
		if ( has_post_thumbnail() ) {
			$default_img = get_the_post_thumbnail_url( get_the_ID(), 'large' );
		}
	} elseif ( is_tax() || is_category() || is_archive() ) {
		$title = wp_strip_all_tags( get_the_archive_title() ) . ' | ' . $site_name;
		$desc  = wp_strip_all_tags( get_the_archive_description() );
		if ( empty( $desc ) ) {
			$desc = 'Browse our portfolio of premium branding, signage and display projects delivered across Dubai and the UAE.';
		}
	} else {
		$title = wp_get_document_title();
		$desc  = 'Sea Winds BTL Advertising LLC — premium branding, signage and display fabrication in Dubai.';
	}

	$desc = trim( wp_strip_all_tags( $desc ) );
	if ( is_front_page() ) {
		$url = home_url( '/' );
	} elseif ( is_singular() ) {
		$url = get_permalink();
	} else {
		$request = isset( $GLOBALS['wp']->request ) ? $GLOBALS['wp']->request : '';
		$url     = home_url( add_query_arg( array(), $request ) );
	}
	$url = esc_url( $url );
	?>
	<meta name="description" content="<?php echo esc_attr( $desc ); ?>">
	<meta name="robots" content="index, follow">
	<link rel="canonical" href="<?php echo esc_url( $url ); ?>">
	<meta property="og:type" content="<?php echo is_singular( 'post' ) ? 'article' : 'website'; ?>">
	<meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>">
	<meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $desc ); ?>">
	<meta property="og:image" content="<?php echo esc_url( $default_img ); ?>">
	<meta property="og:url" content="<?php echo esc_url( $url ); ?>">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo esc_attr( $title ); ?>">
	<meta name="twitter:description" content="<?php echo esc_attr( $desc ); ?>">
	<meta name="twitter:image" content="<?php echo esc_url( $default_img ); ?>">
	<?php
}
add_action( 'wp_head', 'seawinds_seo_meta', 1 );

/* Favicon (uses the logo until a dedicated favicon is added). */
function seawinds_favicon() {
	if ( ! has_site_icon() ) {
		echo '<link rel="icon" href="' . esc_url( SEAWINDS_URI . '/assets/images/logo.png' ) . '" sizes="32x32">' . "\n";
		echo '<link rel="apple-touch-icon" href="' . esc_url( SEAWINDS_URI . '/assets/images/logo.png' ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'seawinds_favicon', 2 );

/* -------------------------------------------------------------------------
 * 7. Lazy loading for images
 * ---------------------------------------------------------------------- */
function seawinds_add_lazy_loading( $content ) {
	if ( is_admin() || empty( $content ) ) {
		return $content;
	}
	if ( false === strpos( $content, '<img' ) ) {
		return $content;
	}
	// Add loading="lazy" and decoding="async" to images that lack them.
	$content = preg_replace_callback(
		'/<img\b((?:[^>]*?))>/i',
		function ( $matches ) {
			$img = $matches[0];
			if ( false === stripos( $img, 'loading=' ) ) {
				$img = str_replace( '<img', '<img loading="lazy"', $img );
			}
			if ( false === stripos( $img, 'decoding=' ) ) {
				$img = str_replace( '<img', '<img decoding="async"', $img );
			}
			return $img;
		},
		$content
	);
	return $content;
}
add_filter( 'the_content', 'seawinds_add_lazy_loading', 20 );

/* -------------------------------------------------------------------------
 * 8. Contact form handler (AJAX -> wp_mail)
 * ---------------------------------------------------------------------- */
function seawinds_handle_contact() {
	// Verify nonce.
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'seawinds_contact_nonce' ) ) {
		wp_send_json_error( array( 'message' => 'Security check failed. Please refresh the page and try again.' ), 403 );
	}

	// Honeypot (spam bots fill hidden fields).
	if ( ! empty( $_POST['sw_website'] ) ) {
		wp_send_json_error( array( 'message' => 'Spam detected.' ), 400 );
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	// Server-side validation of mandatory fields.
	$errors = array();
	if ( '' === $name ) {
		$errors[] = 'name';
	}
	if ( '' === $phone ) {
		$errors[] = 'phone';
	}
	if ( '' === $email || ! is_email( $email ) ) {
		$errors[] = 'email';
	}
	if ( ! empty( $errors ) ) {
		wp_send_json_error(
			array(
				'message' => 'Please complete all required fields with valid information.',
				'fields'  => $errors,
			),
			422
		);
	}

	$to      = 'yash@seawindsadvertising.com';
	$subject = sprintf( 'New Enquiry from Sea Winds Website — %s', $name );

	$body  = "You have received a new enquiry from the Sea Winds website:\n\n";
	$body .= 'Name: ' . $name . "\n";
	$body .= 'Phone: ' . $phone . "\n";
	$body .= 'Email: ' . $email . "\n\n";
	$body .= "Message:\n" . ( '' !== $message ? $message : '(No message provided)' ) . "\n\n";
	$body .= '---' . "\n";
	$body .= 'Sent from ' . home_url( '/' ) . "\n";

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'From: Sea Winds Website <' . seawinds_get_from_email() . '>',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = wp_mail( $to, $subject, $body, $headers );

	if ( $sent ) {
		wp_send_json_success(
			array(
				'message' => sprintf( 'Thank you %s, we\'ll be in touch shortly.', $name ),
			)
		);
	} else {
		wp_send_json_error(
			array(
				'message' => 'Something went wrong. Please call us directly.',
			),
			500
		);
	}
}
add_action( 'wp_ajax_seawinds_contact', 'seawinds_handle_contact' );
add_action( 'wp_ajax_nopriv_seawinds_contact', 'seawinds_handle_contact' );

/**
 * Build a safe From: email on the site's own domain so wp_mail is deliverable.
 */
function seawinds_get_from_email() {
	$sitename = wp_parse_url( network_home_url(), PHP_URL_HOST );
	if ( 'www.' === substr( $sitename, 0, 4 ) ) {
		$sitename = substr( $sitename, 4 );
	}
	return 'no-reply@' . $sitename;
}

/* -------------------------------------------------------------------------
 * 9. Helper: brand constants available to templates
 * ---------------------------------------------------------------------- */
function seawinds_brand() {
	return array(
		'phone1'      => '+971 52 195 1973',
		'phone1_href' => '+971521951973',
		'phone2'      => '+971 52 197 1575',
		'phone2_href' => '+971521971575',
		'whatsapp'    => '971521971575',
		'email'       => 'info@seawindsadvertising.com',
		'address'     => 'Al Quoz Ind. 3, Dubai',
		'facebook'    => 'https://www.facebook.com/seawindsdxb/',
		'instagram'   => 'https://www.instagram.com/seawindsdxb/',
		'tagline'     => 'Your one-stop solution for creative branding, digital printing, and display solutions',
		'whatsapp_url'=> 'https://api.whatsapp.com/send/?phone=971521971575',
	);
}

/**
 * Central list of PROJECTS.
 *
 * The Portfolio page shows the 33 CATEGORIES (Exhibition Stand, Photo Booth, …).
 * Each category contains one or more real projects — this is that list. The
 * Gallery shows every project here flat (not grouped by category). Later, the
 * same data will drive category pages (projects within a category) and single
 * project pages (a project's photos).
 *
 * Fields per project:
 *   name     — display title
 *   slug     — URL segment ( /project/<slug>/ )
 *   category — human label of the category it belongs to (one of the 33)
 *   cat_slug — that category's slug (matches the Portfolio item slugs)
 *   cover    — card image
 *   images   — array of the project's photos (for the single-project page)
 *
 * Placeholder sample below until the real projects/photos are supplied.
 */
function seawinds_get_projects() {
	return array(
		array(
			'name'     => 'The Sevens Stadium 2025',
			'slug'     => 'the-sevens-stadium-2025',
			'category' => 'Exhibition Stand',
			'cat_slug' => 'exhibition-stand',
			'cover'    => 'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-122041-1.png',
			'images'   => array(
				'https://seawindsadvertising.com/wp-content/uploads/2021/08/Screenshot-2024-12-13-122041-1.png',
			),
		),
	);
}

/**
 * The 33 portfolio CATEGORIES (title, slug, parent group). Drives the Portfolio
 * grid and the per-category subpages at /portfolio/<slug>/.
 */
function seawinds_get_categories() {
	return array(
		array( 'title' => 'Exhibition Stand',           'slug' => 'exhibition-stand',                 'group' => 'Events & Exhibition' ),
		array( 'title' => 'Photo Booth',                'slug' => 'photo-booth',                      'group' => 'Events & Exhibition' ),
		array( 'title' => 'Event Branding',             'slug' => 'event-branding',                   'group' => 'Events & Exhibition' ),
		array( 'title' => 'Press Wall',                 'slug' => 'press-wall',                       'group' => 'Events & Exhibition' ),
		array( 'title' => 'Themed Structures',          'slug' => 'themed-structures',                'group' => 'Events & Exhibition' ),
		array( 'title' => 'Insta Box',                  'slug' => 'insta-box',                        'group' => 'Events & Exhibition' ),
		array( 'title' => 'Flags',                      'slug' => 'flags-printing',                   'group' => 'Events & Exhibition' ),
		array( 'title' => 'Promotion Stand',            'slug' => 'promotion-stand',                  'group' => 'Events & Exhibition' ),
		array( 'title' => 'Pop-Up Stand',               'slug' => 'pop-up-stand',                     'group' => 'Events & Exhibition' ),
		array( 'title' => 'Gondola',                    'slug' => 'gondola',                          'group' => 'Display Stands' ),
		array( 'title' => 'Island Counter',             'slug' => 'island-counter',                   'group' => 'Display Stands' ),
		array( 'title' => 'Mall Kiosk',                 'slug' => 'mall-kiosk',                        'group' => 'Display Stands' ),
		array( 'title' => 'Optical Displays',           'slug' => 'optical-display',                  'group' => 'Display Stands' ),
		array( 'title' => 'Light Box',                  'slug' => 'light-box',                        'group' => 'Display Stands' ),
		array( 'title' => 'Acrylic Fabrication',        'slug' => 'acrylic-fabrication',              'group' => 'Display Stands' ),
		array( 'title' => 'Mall Podium',                'slug' => 'mall-podium',                      'group' => 'Display Stands' ),
		array( 'title' => 'Roll-up Stands',             'slug' => 'roll-up-stands',                   'group' => 'Display Stands' ),
		array( 'title' => 'Pop-Up Counter',             'slug' => 'pop-up-counter',                   'group' => 'Display Stands' ),
		array( 'title' => 'Pillar Unit',                'slug' => 'pillar-unit',                      'group' => 'Display Stands' ),
		array( 'title' => 'Wall Unit',                  'slug' => 'wall-unit',                        'group' => 'Display Stands' ),
		array( 'title' => 'Window Display',             'slug' => 'window-display',                   'group' => 'Display Stands' ),
		array( 'title' => 'Interior Decor',             'slug' => 'interior-decor',                   'group' => 'Interiors & Decor' ),
		array( 'title' => 'Outdoor Signboard',          'slug' => 'outdoor-signboard',                'group' => 'Signage' ),
		array( 'title' => 'Shop Front Signage',         'slug' => 'shop-front-signs',                 'group' => 'Signage' ),
		array( 'title' => 'Reception Signage',          'slug' => 'reception-signage',                'group' => 'Signage' ),
		array( 'title' => 'Pylon Signage',              'slug' => 'pylon-signage',                    'group' => 'Signage' ),
		array( 'title' => 'Neon Signs',                 'slug' => 'neon-signs',                       'group' => 'Signage' ),
		array( 'title' => 'Corporate Logo',             'slug' => 'corporate-logo',                   'group' => 'Signage' ),
		array( 'title' => 'CNC Cutting',                'slug' => 'cnc-cutting',                      'group' => 'Signage' ),
		array( 'title' => 'Graphics Branding',          'slug' => 'indoor-outdoor-graphics-branding', 'group' => 'Graphics' ),
		array( 'title' => 'Hoarding Graphics',          'slug' => 'hoarding-graphics',                'group' => 'Graphics' ),
		array( 'title' => 'Outdoor Hoarding',           'slug' => 'outdoor-hoarding',                 'group' => 'Graphics' ),
		array( 'title' => 'Vehicle Graphics',           'slug' => 'vehicle-graphics',                 'group' => 'Graphics' ),
		array( 'title' => 'Cut-outs Mascot',            'slug' => 'cut-outs-mascot',                  'group' => 'Graphics' ),
	);
}

/** Look up one category by slug. */
function seawinds_category_by_slug( $slug ) {
	foreach ( seawinds_get_categories() as $cat ) {
		if ( $cat['slug'] === $slug ) {
			return $cat;
		}
	}
	return null;
}

/** All projects belonging to a category slug. */
function seawinds_projects_in_category( $slug ) {
	$out = array();
	foreach ( seawinds_get_projects() as $p ) {
		if ( isset( $p['cat_slug'] ) && $p['cat_slug'] === $slug ) {
			$out[] = $p;
		}
	}
	return $out;
}

/**
 * Optional intro block rendered on a category subpage, below the hero and above
 * the project grid. Returns HTML for categories that need it (e.g. CNC Cutting),
 * or an empty string otherwise.
 *
 * @param string $slug Category slug.
 * @return string HTML.
 */
function seawinds_category_intro( $slug ) {
	if ( 'cnc-cutting' !== $slug ) {
		return '';
	}

	$sw       = seawinds_brand();
	$whatsapp = $sw['whatsapp_url'];
	$wa_icon  = seawinds_icon( 'whatsapp' );

	$machines   = array( 'CNC Router Cutting', 'CNC Laser Cutting' );
	$materials  = array( 'MDF', 'Solid Wood', 'Laminate', 'Veneer', 'Acrylic', 'Aluminum' );
	$techniques = array( '2D Cutting', '3D Cutting', 'Engraving', 'Grooving' );

	ob_start();
	?>
	<div class="sw-cnc">
		<p class="sw-cnc__lead">
			Precision cutting, engineered to your exact spec. Our in-house CNC department runs both
			<strong>router</strong> and <strong>laser</strong> systems for clean, repeatable results —
			from flat 2D profiles to sculpted 3D forms, across wood, acrylic and metal alike.
		</p>

		<div class="sw-cnc__groups">
			<div class="sw-cnc__group">
				<span class="sw-cnc__label">Cutting Machines</span>
				<div class="sw-pills">
					<?php foreach ( $machines as $m ) : ?>
						<span class="sw-pill"><?php echo esc_html( $m ); ?></span>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="sw-cnc__group">
				<span class="sw-cnc__label">Materials We Cut</span>
				<div class="sw-pills">
					<?php foreach ( $materials as $m ) : ?>
						<span class="sw-pill"><?php echo esc_html( $m ); ?></span>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="sw-cnc__group">
				<span class="sw-cnc__label">Techniques</span>
				<div class="sw-pills">
					<?php foreach ( $techniques as $m ) : ?>
						<span class="sw-pill"><?php echo esc_html( $m ); ?></span>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="sw-cnc__cta">
			<h3 class="sw-cnc__cta-title">Instant Quote — Share Your File Now</h3>
			<p class="sw-cnc__cta-text">Send us your design file on WhatsApp and we'll get a quote back to you fast.</p>
			<a class="sw-btn sw-btn--pill sw-btn--whatsapp-pill sw-btn--lg" href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener noreferrer">
				<?php echo $wa_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span>Share Your File on WhatsApp</span>
			</a>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/* -------------------------------------------------------------------------
 * Category subpage routing: /portfolio/<category-slug>/ → portfolio-category.php
 * ---------------------------------------------------------------------- */
function seawinds_category_rewrite() {
	// 'top' so this beats the project CPT's own /portfolio/<x>/ rule.
	add_rewrite_rule( '^portfolio/([^/]+)/?$', 'index.php?sw_pf_cat=$matches[1]', 'top' );
}
add_action( 'init', 'seawinds_category_rewrite', 5 );

function seawinds_category_query_var( $vars ) {
	$vars[] = 'sw_pf_cat';
	return $vars;
}
add_filter( 'query_vars', 'seawinds_category_query_var' );

function seawinds_category_template( $template ) {
	$slug = get_query_var( 'sw_pf_cat' );
	if ( $slug && seawinds_category_by_slug( $slug ) ) {
		status_header( 200 );
		if ( isset( $GLOBALS['wp_query'] ) ) {
			$GLOBALS['wp_query']->is_404 = false;
		}
		$tpl = locate_template( 'portfolio-category.php' );
		if ( $tpl ) {
			return $tpl;
		}
	}
	return $template;
}
// 999998 = just under the portfolio override (999999); the override only fires
// for the bare /portfolio/ view, so category subpages are left to this filter.
add_filter( 'template_include', 'seawinds_category_template', 999998 );

/** Correct <title> for category subpages. */
function seawinds_category_document_title( $parts ) {
	$slug = get_query_var( 'sw_pf_cat' );
	$cat  = $slug ? seawinds_category_by_slug( $slug ) : null;
	if ( $cat ) {
		$parts['title'] = $cat['title'];
	}
	return $parts;
}
add_filter( 'document_title_parts', 'seawinds_category_document_title' );

/**
 * Return the URL for a named theme page, falling back to a slug path.
 *
 * @param string $slug     Page slug.
 * @param string $fallback Fallback relative path.
 * @return string
 */
function seawinds_page_url( $slug, $fallback = '' ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return get_permalink( $page->ID );
	}
	return home_url( '/' . ltrim( $fallback ? $fallback : $slug, '/' ) . '/' );
}

/**
 * Reusable SVG icon set.
 *
 * @param string $name Icon name.
 * @return string SVG markup.
 */
function seawinds_icon( $name ) {
	$icons = array(
		'whatsapp'  => '<svg viewBox="0 0 32 32" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M16.001 3.2C9.03 3.2 3.36 8.87 3.36 15.84c0 2.23.59 4.4 1.71 6.32L3.2 28.8l6.79-1.78a12.6 12.6 0 0 0 6.01 1.53h.01c6.97 0 12.64-5.67 12.64-12.64 0-3.38-1.32-6.56-3.71-8.95a12.55 12.55 0 0 0-8.94-3.76zm0 23.09h-.01a10.5 10.5 0 0 1-5.35-1.47l-.38-.23-3.97 1.04 1.06-3.87-.25-.4a10.44 10.44 0 0 1-1.6-5.57c0-5.79 4.72-10.5 10.51-10.5 2.81 0 5.44 1.09 7.42 3.08a10.42 10.42 0 0 1 3.07 7.43c0 5.79-4.71 10.5-10.5 10.5zm5.76-7.86c-.32-.16-1.87-.92-2.16-1.03-.29-.11-.5-.16-.71.16-.21.32-.82 1.03-1 1.24-.18.21-.37.24-.68.08-.32-.16-1.33-.49-2.53-1.56-.94-.83-1.57-1.86-1.75-2.18-.18-.32-.02-.49.14-.65.14-.14.32-.37.47-.55.16-.18.21-.32.32-.53.11-.21.05-.4-.03-.55-.08-.16-.71-1.71-.97-2.34-.26-.62-.52-.53-.71-.54l-.6-.01c-.21 0-.55.08-.84.4-.29.32-1.1 1.08-1.1 2.62 0 1.55 1.13 3.04 1.29 3.25.16.21 2.22 3.39 5.38 4.76.75.32 1.34.51 1.79.66.75.24 1.44.21 1.98.13.6-.09 1.87-.76 2.13-1.5.26-.74.26-1.37.18-1.5-.08-.14-.29-.21-.61-.37z"/></svg>',
		'facebook'  => '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.99 3.66 9.13 8.44 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99C18.34 21.13 22 16.99 22 12z"/></svg>',
		'instagram' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41a3.7 3.7 0 0 1-1.38-.9 3.7 3.7 0 0 1-.9-1.38c-.16-.42-.36-1.06-.41-2.23C2.17 15.58 2.16 15.2 2.16 12s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41C8.42 2.17 8.8 2.16 12 2.16zm0 1.94c-3.14 0-3.51.01-4.75.07-.9.04-1.39.19-1.71.32-.43.17-.74.37-1.06.69-.32.32-.52.63-.69 1.06-.13.32-.28.81-.32 1.71-.06 1.24-.07 1.61-.07 4.75s.01 3.51.07 4.75c.04.9.19 1.39.32 1.71.17.43.37.74.69 1.06.32.32.63.52 1.06.69.32.13.81.28 1.71.32 1.24.06 1.61.07 4.75.07s3.51-.01 4.75-.07c.9-.04 1.39-.19 1.71-.32.43-.17.74-.37 1.06-.69.32-.32.52-.63.69-1.06.13-.32.28-.81.32-1.71.06-1.24.07-1.61.07-4.75s-.01-3.51-.07-4.75c-.04-.9-.19-1.39-.32-1.71a2.85 2.85 0 0 0-.69-1.06 2.85 2.85 0 0 0-1.06-.69c-.32-.13-.81-.28-1.71-.32-1.24-.06-1.61-.07-4.75-.07zm0 3.3a4.6 4.6 0 1 0 0 9.2 4.6 4.6 0 0 0 0-9.2zm0 7.59a2.99 2.99 0 1 1 0-5.98 2.99 2.99 0 0 1 0 5.98zm5.86-7.81a1.08 1.08 0 1 1-2.15 0 1.08 1.08 0 0 1 2.15 0z"/></svg>',
		'phone'     => '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.68 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.32 1.85.55 2.81.68A2 2 0 0 1 22 16.92z"/></svg>',
		'mail'      => '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/></svg>',
		'pin'       => '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
		'arrow'     => '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>',
	);
	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/* -------------------------------------------------------------------------
 * 10. Excerpt tweaks
 * ---------------------------------------------------------------------- */
function seawinds_excerpt_length( $length ) {
	return 24;
}
add_filter( 'excerpt_length', 'seawinds_excerpt_length' );

function seawinds_excerpt_more( $more ) {
	return '…';
}
add_filter( 'excerpt_more', 'seawinds_excerpt_more' );

/* Drop the "Archives:" / "Category:" etc. prefix from archive titles. */
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

/* -------------------------------------------------------------------------
 * 11. Body classes for template-aware styling
 * ---------------------------------------------------------------------- */
function seawinds_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'sw-front';
	}
	$classes[] = 'sw-theme';
	return $classes;
}
add_filter( 'body_class', 'seawinds_body_classes' );

/* -------------------------------------------------------------------------
 * 12. Bulletproof template router
 *
 * front-page.php is already the highest-priority template for a static front
 * page, and page-<slug>.php auto-loads for each interior page. This filter is a
 * hard guarantee on top of that: it force-loads the correct theme template for
 * the front page and for every known page slug, overriding anything a plugin,
 * a stale/leftover template file, or a wrongly "assigned" page template might
 * do. Templates are only forced if the file genuinely exists in the theme, so
 * a missing upload can never be masked.
 * ---------------------------------------------------------------------- */
function seawinds_template_router( $template ) {
	// Front page → front-page.php.
	if ( is_front_page() && ! is_home() ) {
		$front = locate_template( 'front-page.php' );
		if ( $front ) {
			return $front;
		}
	}

	/*
	 * /portfolio/ → always the Portfolio content, no matter how WordPress routed
	 * the request. This catches BOTH:
	 *   (a) is_page( 'portfolio' )              — after rewrite rules are flushed
	 *   (b) is_post_type_archive( 'project' )   — the stale CPT-archive rule that
	 *       otherwise renders index.php as "Archives: Portfolio"
	 * page-portfolio-override.php is self-contained (hardcoded content, not the
	 * main loop), so it renders correctly in either query context. Single project
	 * pages ( /portfolio/<slug>/ ) are is_singular('project') and untouched.
	 */
	if ( is_page( 'portfolio' ) || is_post_type_archive( 'project' ) ) {
		$override = locate_template( 'page-portfolio-override.php' );
		if ( $override ) {
			return $override;
		}
		$pf = locate_template( 'page-portfolio.php' );
		if ( $pf ) {
			return $pf;
		}
	}

	// Interior pages → page-<slug>.php, keyed by the page's actual slug.
	if ( is_page() ) {
		$slug_map = array(
			'about-us'      => 'page-about-us.php',
			'services'      => 'page-services.php',
			'portfolio'     => 'page-portfolio.php',
			'gallery'       => 'page-gallery.php',
			'our-clients'   => 'page-our-clients.php',
			'our-clients-2' => 'page-our-clients.php', // Fallback slug if 'our-clients' was taken.
			'contact-us'    => 'page-contact-us.php',
			'blog'          => 'page-blog.php',
		);
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		if ( isset( $slug_map[ $slug ] ) ) {
			$mapped = locate_template( $slug_map[ $slug ] );
			if ( $mapped ) {
				return $mapped;
			}
		}
	}

	return $template;
}
add_filter( 'template_include', 'seawinds_template_router', 99 );

/* -------------------------------------------------------------------------
 * 13. Elementor override for the Portfolio view
 *
 * If Elementor is active it can hijack template_include (priority 12) and serve
 * its own canvas/content for the Portfolio page, hiding our template. These
 * hooks force page-portfolio-override.php on /portfolio/ (both the page and the
 * project CPT archive), strip Elementor's front-end assets there, and blank any
 * Elementor the_content output — all scoped to the Portfolio view only.
 * ---------------------------------------------------------------------- */
/**
 * True for the /portfolio/ landing view, however WordPress routed it.
 *
 * Besides our own 'project' CPT, this also matches the /portfolio/ URL itself,
 * so it still catches the case where a DIFFERENT plugin or a leftover from the
 * old theme registered its own portfolio/projects post type that owns
 * /portfolio/ (which our post-type-specific checks would otherwise miss).
 * Single projects at /portfolio/<slug>/ are NOT matched.
 */
function seawinds_is_portfolio_view() {
	if ( is_admin() ) {
		return false;
	}

	if (
		is_page( 'portfolio' )
		|| is_post_type_archive( 'project' )
		|| ( is_home() && 'project' === get_query_var( 'post_type' ) )
	) {
		return true;
	}

	// URL-based catch-all: the bare /portfolio/ base URL, any query type.
	$path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ) : '';
	$path = trim( (string) $path, '/' );

	// Remove a subdirectory-install home path prefix if present.
	$home_path = trim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
	if ( '' !== $home_path && ( $path === $home_path || 0 === strpos( $path . '/', $home_path . '/' ) ) ) {
		$path = trim( substr( $path, strlen( $home_path ) ), '/' );
	}

	return ( 'portfolio' === $path );
}

function seawinds_portfolio_override_template( $template ) {
	if ( seawinds_is_portfolio_view() ) {
		if ( class_exists( '\Elementor\Plugin' ) ) {
			$instance = \Elementor\Plugin::instance();
			if ( is_object( $instance ) ) {
				remove_filter( 'template_include', array( $instance, 'template_include' ), 12 );
			}
			remove_filter( 'template_include', 'elementor_page_templates_override', 12 );
		}
		$override = get_template_directory() . '/page-portfolio-override.php';
		if ( file_exists( $override ) ) {
			return $override;
		}
	}
	return $template;
}
// Priority 999999 so this runs after (and overrides) Elementor's priority-12 filter.
add_filter( 'template_include', 'seawinds_portfolio_override_template', 999999 );

function seawinds_portfolio_dequeue_elementor() {
	if ( seawinds_is_portfolio_view() && class_exists( '\Elementor\Plugin' ) ) {
		$instance = \Elementor\Plugin::instance();
		if ( is_object( $instance ) && isset( $instance->frontend ) && is_object( $instance->frontend ) ) {
			remove_action( 'wp_enqueue_scripts', array( $instance->frontend, 'enqueue_styles' ) );
			remove_action( 'wp_enqueue_scripts', array( $instance->frontend, 'enqueue_scripts' ) );
		}
	}
}
add_action( 'wp', 'seawinds_portfolio_dequeue_elementor' );

function seawinds_portfolio_strip_elementor_content( $content ) {
	if ( seawinds_is_portfolio_view() ) {
		return '';
	}
	return $content;
}
add_filter( 'elementor/frontend/the_content', 'seawinds_portfolio_strip_elementor_content' );
