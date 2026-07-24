<?php
/**
 * Reusable blog post card (loaded via get_template_part( 'blog', 'card' )).
 *
 * @package Seawinds
 */

$sw_cats = get_the_category();
$sw_cat  = ! empty( $sw_cats ) ? $sw_cats[0]->name : __( 'Insights', 'seawinds' );
?>
<article class="sw-post-card sw-animate" data-anim="fadeUp">
	<a href="<?php the_permalink(); ?>" class="sw-post-card__media" aria-label="<?php the_title_attribute(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy', 'decoding' => 'async', 'draggable' => 'false' ) ); ?>
		<?php else : ?>
			<img src="<?php echo esc_url( SEAWINDS_URI . '/assets/images/logo.png' ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" decoding="async" draggable="false">
		<?php endif; ?>
	</a>
	<div class="sw-post-card__body">
		<span class="sw-post-card__cat"><?php echo esc_html( $sw_cat ); ?></span>
		<h3 class="sw-post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="sw-post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '…' ) ); ?></p>
		<div class="sw-post-card__footer">
			<a href="<?php the_permalink(); ?>" class="sw-post-card__more"><?php esc_html_e( 'Read More', 'seawinds' ); ?> &rarr;</a>
			<span class="sw-post-card__date"><?php echo esc_html( get_the_date() ); ?></span>
		</div>
	</div>
</article>
