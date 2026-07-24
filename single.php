<?php
/**
 * Single blog post template.
 *
 * @package Seawinds
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article class="sw-single">
		<header class="sw-page-hero">
			<div class="sw-page-hero__inner">
				<?php
				$sw_cats = get_the_category();
				if ( ! empty( $sw_cats ) ) :
					?>
					<span class="sw-page-hero__eyebrow"><?php echo esc_html( $sw_cats[0]->name ); ?></span>
				<?php endif; ?>
				<h1 class="sw-page-hero__title"><?php the_title(); ?></h1>
				<div class="sw-page-hero__underline"></div>
				<p class="sw-single__meta"><?php echo esc_html( get_the_date() ); ?><?php echo get_the_author() ? ' &middot; ' . esc_html( get_the_author() ) : ''; ?></p>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="sw-single__featured">
				<?php the_post_thumbnail( 'large', array( 'loading' => 'eager', 'draggable' => 'false' ) ); ?>
			</div>
		<?php endif; ?>

		<div class="sw-single__content">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="sw-page-links">' . esc_html__( 'Pages:', 'seawinds' ),
					'after'  => '</div>',
				)
			);
			?>

			<a href="<?php echo esc_url( seawinds_page_url( 'blog', 'blog' ) ); ?>" class="sw-back-link">&larr; <?php esc_html_e( 'Back to Blog', 'seawinds' ); ?></a>
		</div>
	</article>
	<?php
endwhile;

get_footer();
