<?php
/**
 * Projects archive (post type: project).
 *
 * @package Seawinds
 */

get_header();
?>

<section class="sw-page-hero">
	<div class="sw-page-hero__inner">
		<span class="sw-page-hero__eyebrow"><?php esc_html_e( 'Our Work', 'seawinds' ); ?></span>
		<h1 class="sw-page-hero__title"><?php esc_html_e( 'Portfolio', 'seawinds' ); ?></h1>
		<div class="sw-page-hero__underline"></div>
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
					$terms   = get_the_terms( get_the_ID(), 'project_category' );
					?>
					<a href="<?php the_permalink(); ?>" class="sw-project-card sw-animate" data-anim="fadeUp">
						<div class="sw-project-card__media">
							<img src="<?php echo esc_url( $cover ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" decoding="async" draggable="false">
							<span class="sw-project-card__gradient" aria-hidden="true"></span>
						</div>
						<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
							<span class="sw-project-card__cat"><?php echo esc_html( $terms[0]->name ); ?></span>
						<?php endif; ?>
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
			<p class="sw-empty"><?php esc_html_e( 'No projects yet.', 'seawinds' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
