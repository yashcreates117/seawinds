<?php
/**
 * Homepage hero — scroll-scrubbed frame sequence with a frosted-glass text box.
 *
 * The hero video (source: Final.mp4) is pre-rendered into a JPEG frame sequence
 * in /assets/hero-frames/. As the user scrolls through this tall section,
 * hero.js draws the matching frame onto a pinned <canvas>. A frosted-glass box
 * on the left reveals three lines in sequence as the user scrolls.
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
>
	<div class="sw-hero-scroll__pin">
		<canvas class="sw-hero-scroll__canvas" id="sw-hero-canvas" aria-hidden="true"></canvas>

		<h1 class="screen-reader-text"><?php esc_html_e( 'Your Vision. Our Craft. Brought to Life. — Sea Winds BTL Advertising', 'seawinds' ); ?></h1>

		<div class="sw-hero-glass" id="sw-hero-glass">
			<div class="sw-hero-glass__lines">
				<h2 class="sw-hero-line" data-line="0"><span class="sw-hero-line__w">YOUR</span> <span class="sw-hero-line__g">VISION.</span></h2>
				<h2 class="sw-hero-line" data-line="1"><span class="sw-hero-line__w">OUR</span> <span class="sw-hero-line__g">CRAFT.</span></h2>
				<h2 class="sw-hero-line" data-line="2"><span class="sw-hero-line__w">BROUGHT TO</span> <span class="sw-hero-line__g">LIFE.</span></h2>
			</div>
		</div>

		<div class="sw-hero-scroll__loader" id="sw-hero-loader" aria-hidden="true"><span></span></div>

		<a href="#sw-experience" class="sw-hero__scroll" aria-label="<?php esc_attr_e( 'Scroll down', 'seawinds' ); ?>">
			<span class="sw-hero__chevron"></span>
		</a>
	</div>
</section>
