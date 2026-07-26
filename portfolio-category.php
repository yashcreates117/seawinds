<?php
/**
 * Portfolio category subpage — /portfolio/<category-slug>/
 *
 * Loaded by seawinds_category_template() in functions.php. Shows the projects
 * that belong to one of the 33 categories as boxes (same style as the Portfolio
 * grid). Clicking a project box opens its photo lightbox (project-modal.js).
 *
 * @package Seawinds
 */

get_header();

$sw_slug     = get_query_var( 'sw_pf_cat' );
$sw_cat      = seawinds_category_by_slug( $sw_slug );
$sw_projects = $sw_cat ? seawinds_projects_in_category( $sw_slug ) : array();
$sw_title    = $sw_cat ? $sw_cat['title'] : __( 'Portfolio', 'seawinds' );
$sw_group    = $sw_cat ? $sw_cat['group'] : __( 'Our Work', 'seawinds' );
?>

<section class="sw-page-hero">
	<div class="sw-page-hero__inner">
		<span class="sw-page-hero__eyebrow"><?php echo esc_html( $sw_group ); ?></span>
		<h1 class="sw-page-hero__title"><?php echo esc_html( $sw_title ); ?></h1>
		<div class="sw-page-hero__underline"></div>
	</div>
</section>

<section class="sw-pf sw-section--light">
	<div class="sw-container">
		<?php
		// Optional per-category intro (e.g. CNC Cutting capabilities + quote CTA).
		echo seawinds_category_intro( $sw_slug ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
		<?php if ( ! empty( $sw_projects ) ) : ?>
			<div class="sw-pf__grid sw-stagger">
				<?php
				foreach ( $sw_projects as $project ) :
					$images = ! empty( $project['images'] ) ? $project['images'] : array( $project['cover'] );
					?>
					<div
						class="sw-pf-card sw-project-open sw-animate"
						data-anim="fadeUp"
						role="button"
						tabindex="0"
						data-project="<?php echo esc_attr( $project['name'] ); ?>"
						data-images="<?php echo esc_attr( wp_json_encode( array_values( $images ) ) ); ?>"
					>
						<div class="sw-pf-card__media">
							<img src="<?php echo esc_url( $project['cover'] ); ?>" alt="<?php echo esc_attr( $project['name'] ); ?>" loading="lazy" decoding="async" draggable="false">
						</div>
						<div class="sw-pf-card__body">
							<span class="sw-pf-card__cat"><?php echo esc_html( $project['category'] ); ?></span>
							<h3 class="sw-pf-card__title"><?php echo esc_html( $project['name'] ); ?></h3>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="sw-empty" style="color:#6a6459;"><?php esc_html_e( 'Projects for this category are coming soon.', 'seawinds' ); ?></p>
		<?php endif; ?>

		<div class="sw-center-cta">
			<a href="<?php echo esc_url( seawinds_page_url( 'portfolio', 'portfolio' ) ); ?>" class="sw-btn sw-btn--pill sw-btn--outline sw-btn--lg">&larr; <?php esc_html_e( 'All Categories', 'seawinds' ); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();
