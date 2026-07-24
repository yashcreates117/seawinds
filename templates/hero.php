<?php
/**
 * Homepage hero — scroll-scrubbed frame sequence.
 *
 * The hero video (assets source: Final.mp4) is pre-rendered into a JPEG frame
 * sequence in /assets/hero-frames/. As the user scrolls through this tall
 * section, hero.js draws the matching frame onto a pinned <canvas>, so the clip
 * "plays" locked to scroll. Text lines fade through over the top.
 *
 * To swap the video later: re-generate the frames into /assets/hero-frames/
 * (same frame_0001.jpg… naming) and update data-frame-count below.
 *
 * @package Seawinds
 */

$sw_hero_frames = 90;
?>
<section
	class="sw-hero-scroll"
	id="sw-hero"
	data-frames="<?php echo esc_url( SEAWINDS_URI . '/assets/hero-frames/' ); ?>"
	data-frame-count="<?php echo esc_attr( $sw_hero_frames ); ?>"
	data-hero-lines='["Crafting Experiences","Building Brands","Delivering Excellence"]'
>
	<div class="sw-hero-scroll__pin">
		<canvas class="sw-hero-scroll__canvas" id="sw-hero-canvas" aria-hidden="true"></canvas>

		<div class="sw-hero-scroll__overlay">
			<div class="sw-hero-scroll__text" id="sw-hero-text">
				<h1 class="sw-hero__line" aria-live="polite">Crafting Experiences</h1>
			</div>
		</div>

		<div class="sw-hero-scroll__loader" id="sw-hero-loader" aria-hidden="true"><span></span></div>

		<a href="#sw-experience" class="sw-hero__scroll" aria-label="<?php esc_attr_e( 'Scroll down', 'seawinds' ); ?>">
			<span class="sw-hero__chevron"></span>
		</a>
	</div>
</section>
