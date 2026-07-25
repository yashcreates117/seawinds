<?php
/**
 * Template Name: Gallery Page
 * Template Post Type: page
 *
 * Flat grid of ALL projects (not categories) — same blog-card style as the
 * Portfolio page, no filter tabs. Projects come from seawinds_get_projects().
 * Each card links to /project/<slug>/.
 *
 * @package Seawinds
 */

get_header();

$sw_projects = seawinds_get_projects();
?>

<section class="sw-page-hero">
	<div class="sw-page-hero__inner">
		<span class="sw-page-hero__eyebrow"><?php esc_html_e( 'Our Projects', 'seawinds' ); ?></span>
		<h1 class="sw-page-hero__title"><?php esc_html_e( 'Gallery', 'seawinds' ); ?></h1>
		<div class="sw-page-hero__underline"></div>
	</div>
</section>

<section class="sw-pf sw-section--light">
	<div class="sw-container">
		<?php if ( ! empty( $sw_projects ) ) : ?>
			<div class="sw-pf__grid sw-stagger">
				<?php foreach ( $sw_projects as $project ) : ?>
					<a href="<?php echo esc_url( home_url( '/project/' . $project['slug'] . '/' ) ); ?>" class="sw-pf-card sw-animate" data-anim="fadeUp">
						<div class="sw-pf-card__media">
							<img src="<?php echo esc_url( $project['cover'] ); ?>" alt="<?php echo esc_attr( $project['name'] ); ?>" loading="lazy" decoding="async" draggable="false">
						</div>
						<div class="sw-pf-card__body">
							<span class="sw-pf-card__cat"><?php echo esc_html( $project['category'] ); ?></span>
							<h3 class="sw-pf-card__title"><?php echo esc_html( $project['name'] ); ?></h3>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="sw-empty" style="color:#6a6459;"><?php esc_html_e( 'Projects will appear here soon.', 'seawinds' ); ?></p>
		<?php endif; ?>

		<div class="sw-center-cta">
			<a href="<?php echo esc_url( seawinds_page_url( 'contact-us', 'contact-us' ) ); ?>" class="sw-btn sw-btn--pill sw-btn--gold sw-btn--lg"><?php esc_html_e( 'Get In Touch', 'seawinds' ); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();
