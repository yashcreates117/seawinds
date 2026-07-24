<?php
/**
 * Fallback template.
 *
 * Used whenever a more specific template is not available.
 *
 * @package Seawinds
 */

get_header();
?>

<section class="sw-page-hero">
	<div class="sw-page-hero__inner">
		<?php if ( is_home() || is_front_page() ) : ?>
			<span class="sw-page-hero__eyebrow"><?php esc_html_e( 'Latest Updates', 'seawinds' ); ?></span>
			<h1 class="sw-page-hero__title"><?php esc_html_e( 'Blog', 'seawinds' ); ?></h1>
		<?php else : ?>
			<span class="sw-page-hero__eyebrow"><?php esc_html_e( 'Latest Updates', 'seawinds' ); ?></span>
			<h1 class="sw-page-hero__title"><?php echo esc_html( wp_strip_all_tags( get_the_archive_title() ) ? wp_strip_all_tags( get_the_archive_title() ) : get_bloginfo( 'name' ) ); ?></h1>
		<?php endif; ?>
		<div class="sw-page-hero__underline"></div>
	</div>
</section>

<section class="sw-blog">
	<div class="sw-container">
		<?php if ( have_posts() ) : ?>
			<div class="sw-blog__grid sw-stagger">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'blog', 'card' );
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
			<p class="sw-empty"><?php esc_html_e( 'Nothing found.', 'seawinds' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
