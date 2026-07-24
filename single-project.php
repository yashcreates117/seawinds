<?php
/**
 * Single project template — premium photo grid + lightbox.
 *
 * @package Seawinds
 */

get_header();

while ( have_posts() ) :
	the_post();

	$gallery      = seawinds_get_project_gallery( get_the_ID() );
	$project_name = get_post_meta( get_the_ID(), '_seawinds_project_name', true );
	$project_desc = get_post_meta( get_the_ID(), '_seawinds_project_desc', true );
	$title        = $project_name ? $project_name : get_the_title();

	// Determine the primary category for the "back" link.
	$terms     = get_the_terms( get_the_ID(), 'project_category' );
	$back_url  = seawinds_page_url( 'portfolio', 'portfolio' );
	$back_text = __( 'Back to Portfolio', 'seawinds' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$back_url  = get_term_link( $terms[0] );
		$back_text = sprintf( __( 'Back to %s', 'seawinds' ), $terms[0]->name );
	}
	?>

	<section class="sw-page-hero">
		<div class="sw-page-hero__inner">
			<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
				<span class="sw-page-hero__eyebrow"><?php echo esc_html( $terms[0]->name ); ?></span>
			<?php endif; ?>
			<h1 class="sw-page-hero__title"><?php echo esc_html( $title ); ?></h1>
			<div class="sw-page-hero__underline"></div>
		</div>
	</section>

	<section class="sw-project">
		<div class="sw-container">

			<?php if ( $project_desc || get_the_content() ) : ?>
				<div class="sw-project__desc sw-animate" data-anim="fadeUp">
					<?php echo $project_desc ? esc_html( $project_desc ) : wp_kses_post( wpautop( get_the_content() ) ); ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $gallery ) ) : ?>
				<div class="sw-photo-grid sw-stagger" data-lightbox-group>
					<?php foreach ( $gallery as $img ) : ?>
						<div class="sw-photo sw-animate" data-anim="fadeUp" data-lightbox="<?php echo esc_url( $img ); ?>" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'View photo', 'seawinds' ); ?>">
							<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" decoding="async" draggable="false">
						</div>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<p class="sw-empty"><?php esc_html_e( 'Photos for this project are coming soon.', 'seawinds' ); ?></p>
			<?php endif; ?>

			<div class="sw-center-cta">
				<a href="<?php echo esc_url( $back_url ); ?>" class="sw-btn sw-btn--pill sw-btn--outline sw-btn--lg">&larr; <?php echo esc_html( $back_text ); ?></a>
			</div>

		</div>
	</section>

	<?php
endwhile;

get_footer();
