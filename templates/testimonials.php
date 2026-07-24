<?php
/**
 * Testimonials section (homepage section 7).
 *
 * @package Seawinds
 */

$sw_testimonials = array(
	array(
		'quote' => 'Very impressed with the professional service, on-time delivery, great quality & support throughout the job!',
		'name'  => 'Vinay',
		'role'  => 'Event branding & fabrication',
	),
	array(
		'quote' => 'Great turnover time mixed with experienced team and great finishing made it an amazing experience for me.',
		'name'  => 'Harry',
		'role'  => 'Photobooth signage',
	),
	array(
		'quote' => 'Looks amazing! Thanks a lot, definitely recommend their services.',
		'name'  => 'Srishti',
		'role'  => 'Reception signage',
	),
);
?>
<section class="sw-section sw-testimonials sw-section--light">
	<div class="sw-container">
		<div class="sw-section__head sw-animate" data-anim="fadeUp">
			<span class="sw-eyebrow sw-eyebrow--dark"><?php esc_html_e( 'Testimonials', 'seawinds' ); ?></span>
			<h2 class="sw-section__title"><?php esc_html_e( 'What Our Clients Say', 'seawinds' ); ?></h2>
		</div>

		<div class="sw-testimonials__grid sw-stagger">
			<?php foreach ( $sw_testimonials as $t ) : ?>
				<figure class="sw-testimonial sw-animate" data-anim="fadeUp">
					<span class="sw-testimonial__mark" aria-hidden="true">&ldquo;</span>
					<blockquote class="sw-testimonial__quote"><?php echo esc_html( $t['quote'] ); ?></blockquote>
					<figcaption class="sw-testimonial__caption">
						<span class="sw-testimonial__name"><?php echo esc_html( $t['name'] ); ?></span>
						<span class="sw-testimonial__role"><?php echo esc_html( $t['role'] ); ?></span>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
