<?php
/**
 * Portfolio category archive (taxonomy: project_category).
 *
 * @package Seawinds
 */

get_header();

$sw_term = get_queried_object();
?>

<section class="sw-page-hero">
	<div class="sw-page-hero__inner">
		<span class="sw-page-hero__eyebrow"><?php esc_html_e( 'Portfolio Category', 'seawinds' ); ?></span>
		<h1 class="sw-page-hero__title"><?php echo esc_html( $sw_term ? $sw_term->name : get_the_archive_title() ); ?></h1>
		<div class="sw-page-hero__underline"></div>
		<?php if ( $sw_term && $sw_term->description ) : ?>
			<p class="sw-page-hero__sub"><?php echo esc_html( $sw_term->description ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="sw-portfolio">
	<div class="sw-container">
		<?php if ( have_posts() ) : ?>
			<div class="sw-portfolio__grid sw-stagger">
				<?php
				while ( have_posts() ) :
					the_post();
					$gallery = seawinds_get_project_gallery( get_the_ID() );
					$cover   = ! empty( $gallery ) ? $gallery[0] : ( has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : SEAWINDS_URI . '/assets/images/logo.png' );
					$name    = get_post_meta( get_the_ID(), '_seawinds_project_name', true );
					$name    = $name ? $name : get_the_title();
					?>
					<a href="<?php the_permalink(); ?>" class="sw-project-card sw-animate" data-anim="fadeUp">
						<div class="sw-project-card__media">
							<img src="<?php echo esc_url( $cover ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" decoding="async" draggable="false">
							<span class="sw-project-card__gradient" aria-hidden="true"></span>
						</div>
						<div class="sw-project-card__body">
							<h3 class="sw-project-card__title"><?php echo esc_html( $name ); ?></h3>
							<span class="sw-project-card__more"><?php esc_html_e( 'View Project', 'seawinds' ); ?> &rarr;</span>
						</div>
					</a>
					<?php
				endwhile;
				?>
			</div>

			<div class="sw-pagination">
				<?php
				echo paginate_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					array(
						'prev_text' => '&larr;',
						'next_text' => '&rarr;',
					)
				);
				?>
			</div>
		<?php else : ?>
			<p class="sw-empty"><?php esc_html_e( 'No projects in this category yet. Add projects in the WordPress dashboard and assign them to this category.', 'seawinds' ); ?></p>
			<div class="sw-center-cta">
				<a href="<?php echo esc_url( seawinds_page_url( 'contact-us', 'contact-us' ) ); ?>" class="sw-btn sw-btn--pill sw-btn--outline sw-btn--lg"><?php esc_html_e( 'Get In Touch', 'seawinds' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
