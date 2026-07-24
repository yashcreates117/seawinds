<?php
/**
 * Default page template.
 *
 * @package Seawinds
 */

get_header();

// Diagnostic marker — if you see this in the homepage source, WordPress is
// falling back to page.php instead of front-page.php. Safe to delete later.
echo "\n<!-- SEAWINDS TEMPLATE: page.php -->\n";

while ( have_posts() ) :
	the_post();
	?>
	<section class="sw-page-hero">
		<div class="sw-page-hero__inner">
			<h1 class="sw-page-hero__title"><?php the_title(); ?></h1>
			<div class="sw-page-hero__underline"></div>
		</div>
	</section>

	<section class="sw-page-content">
		<div class="sw-container">
			<div class="sw-page-content__inner sw-animate" data-anim="fadeUp">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="sw-page-links">' . esc_html__( 'Pages:', 'seawinds' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>
		</div>
	</section>
	<?php
endwhile;

get_footer();
