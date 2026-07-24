<?php
/**
 * Services conveyor carousel (homepage section 5).
 *
 * @package Seawinds
 */

$sw_services = array(
	'Wooden Fabrication', 'Acrylic Fabrication', 'Signage Fabrication', 'Graphics Printing',
	'Signage Installation', 'CNC Router Cutting', 'CNC Laser Cutting', 'Graphics Branding',
	'Joinery', 'Indoor/Outdoor Branding', 'Shop Decor', 'Plotter Cutting',
	'Event Fabrication', 'Exhibition Stands',
);
?>
<section class="sw-section sw-services-carousel sw-section--light">
	<div class="sw-container">
		<div class="sw-section__head sw-animate" data-anim="fadeUp">
			<span class="sw-eyebrow"><?php esc_html_e( 'End-to-End Fabrication & Branding Solutions', 'seawinds' ); ?></span>
			<h2 class="sw-section__title"><?php esc_html_e( 'Our Services', 'seawinds' ); ?></h2>
		</div>

		<div class="sw-carousel" id="sw-services" data-visible="4" data-interval="4000">
			<button class="sw-carousel__arrow sw-carousel__arrow--prev" aria-label="<?php esc_attr_e( 'Previous', 'seawinds' ); ?>">
				<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
			</button>

			<div class="sw-carousel__viewport">
				<div class="sw-carousel__track">
					<?php foreach ( $sw_services as $service ) : ?>
						<div class="sw-carousel__slide">
							<div class="sw-service-card">
								<span class="sw-service-card__accent" aria-hidden="true"></span>
								<span class="sw-service-card__name"><?php echo esc_html( $service ); ?></span>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<button class="sw-carousel__arrow sw-carousel__arrow--next" aria-label="<?php esc_attr_e( 'Next', 'seawinds' ); ?>">
				<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
			</button>
		</div>

		<div class="sw-carousel__dots" aria-hidden="true"></div>
	</div>
</section>
