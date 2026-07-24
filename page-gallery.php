<?php
/**
 * Template Name: Gallery Page
 * Template Post Type: page
 *
 * Flat grid of every project across all categories. Each project opens the
 * premium lightbox showing its gallery images.
 *
 * @package Seawinds
 */

get_header();

$sw_projects = new WP_Query(
	array(
		'post_type'      => 'project',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
	)
);
?>

<section class="sw-page-hero">
	<div class="sw-page-hero__inner">
		<span class="sw-page-hero__eyebrow"><?php esc_html_e( 'Our Craftsmanship', 'seawinds' ); ?></span>
		<h1 class="sw-page-hero__title"><?php esc_html_e( 'Gallery', 'seawinds' ); ?></h1>
		<div class="sw-page-hero__underline"></div>
	</div>
</section>

<section class="sw-portfolio">
	<div class="sw-container">
		<?php if ( $sw_projects->have_posts() ) : ?>
			<div class="sw-portfolio__grid sw-stagger" data-lightbox-group>
				<?php
				while ( $sw_projects->have_posts() ) :
					$sw_projects->the_post();
					$gallery = seawinds_get_project_gallery( get_the_ID() );
					$cover   = ! empty( $gallery ) ? $gallery[0] : ( has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : SEAWINDS_URI . '/assets/images/logo.png' );
					?>
					<div class="sw-project-card sw-animate" data-anim="fadeUp">
						<div class="sw-project-card__media" data-lightbox="<?php echo esc_url( $cover ); ?>" role="button" tabindex="0" aria-label="<?php the_title_attribute(); ?>">
							<img src="<?php echo esc_url( $cover ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" decoding="async" draggable="false">
							<span class="sw-project-card__gradient" aria-hidden="true"></span>
						</div>
						<div class="sw-project-card__body">
							<h3 class="sw-project-card__title"><?php the_title(); ?></h3>
							<a href="<?php the_permalink(); ?>" class="sw-project-card__more"><?php esc_html_e( 'View Project', 'seawinds' ); ?> &rarr;</a>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<p class="sw-empty"><?php esc_html_e( 'Projects will appear here once they are added in the WordPress dashboard under Projects.', 'seawinds' ); ?></p>
			<div class="sw-center-cta">
				<a href="<?php echo esc_url( seawinds_page_url( 'portfolio', 'portfolio' ) ); ?>" class="sw-btn sw-btn--pill sw-btn--outline sw-btn--lg"><?php esc_html_e( 'View Portfolio', 'seawinds' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
