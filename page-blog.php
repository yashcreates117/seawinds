<?php
/**
 * Template Name: Blog Listing
 * Template Post Type: page
 *
 * Assign this template to a page (e.g. "Blog") to show the post listing grid.
 *
 * @package Seawinds
 */

get_header();

$sw_paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );

$sw_blog = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 9,
		'paged'          => $sw_paged,
	)
);
?>

<section class="sw-page-hero">
	<div class="sw-page-hero__inner">
		<span class="sw-page-hero__eyebrow"><?php esc_html_e( 'Latest Updates', 'seawinds' ); ?></span>
		<h1 class="sw-page-hero__title"><?php esc_html_e( 'Blog', 'seawinds' ); ?></h1>
		<div class="sw-page-hero__underline"></div>
	</div>
</section>

<section class="sw-blog">
	<div class="sw-container">
		<?php if ( $sw_blog->have_posts() ) : ?>
			<div class="sw-blog__grid sw-stagger">
				<?php
				while ( $sw_blog->have_posts() ) :
					$sw_blog->the_post();
					get_template_part( 'blog', 'card' );
				endwhile;
				?>
			</div>

			<div class="sw-pagination">
				<?php
				echo paginate_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					array(
						'total'     => $sw_blog->max_num_pages,
						'current'   => max( 1, $sw_paged ),
						'prev_text' => '&larr;',
						'next_text' => '&rarr;',
					)
				);
				?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<p class="sw-empty" style="color:#6a6459;"><?php esc_html_e( 'No posts yet. Check back soon for insights and updates.', 'seawinds' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
