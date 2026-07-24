/* =========================================================================
   Sea Winds — hero.js
   Scroll-scrubbed hero: draws a JPEG frame sequence onto a pinned <canvas>,
   mapped to how far the user has scrolled through the tall hero section.
   The first frame paints immediately; the rest stream in (in scroll order),
   so the hero is usable right away and gets smoother as frames arrive.
   Hero text lines fade through as configured in the section's data attribute.
   ========================================================================= */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var section = document.getElementById('sw-hero');
		var canvas = document.getElementById('sw-hero-canvas');
		if (!section || !canvas || !canvas.getContext) {
			return;
		}

		var ctx = canvas.getContext('2d');
		var base = section.getAttribute('data-frames') || '';
		var count = parseInt(section.getAttribute('data-frame-count'), 10) || 0;
		var lineEl = document.querySelector('#sw-hero-text .sw-hero__line');
		var loader = document.getElementById('sw-hero-loader');
		var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

		var lines = [];
		try {
			lines = JSON.parse(section.getAttribute('data-hero-lines')) || [];
		} catch (e) {}

		if (!count) {
			return;
		}

		var images = new Array(count);
		var currentFrame = -1;
		var currentLine = -1;
		var ticking = false;

		function frameURL(i) {
			var n = String(i + 1);
			while (n.length < 4) { n = '0' + n; }
			return base + 'frame_' + n + '.jpg';
		}

		function dpr() {
			return Math.min(window.devicePixelRatio || 1, 2);
		}

		function resize() {
			var pin = canvas.parentElement;
			var w = pin.clientWidth;
			var h = pin.clientHeight;
			var ratio = dpr();
			canvas.width = Math.round(w * ratio);
			canvas.height = Math.round(h * ratio);
			canvas.style.width = w + 'px';
			canvas.style.height = h + 'px';
			ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
			drawFrame(currentFrame < 0 ? 0 : currentFrame, true);
		}

		function isReady(i) {
			var img = images[i];
			return img && img.complete && img.naturalWidth > 0;
		}

		// Draw image "cover"-style into the canvas (fills, cropping overflow).
		function drawFrame(i, force) {
			i = i | 0;
			if (i < 0) { i = 0; }
			if (i > count - 1) { i = count - 1; }
			if (i === currentFrame && !force) { return; }

			// Fall back to the nearest already-loaded earlier frame.
			var f = i;
			while (f > 0 && !isReady(f)) { f--; }
			if (!isReady(f)) { return; }

			currentFrame = i;
			var img = images[f];
			var cw = canvas.clientWidth;
			var ch = canvas.clientHeight;
			var ir = img.naturalWidth / img.naturalHeight;
			var cr = cw / ch;
			var dw, dh, dx, dy;
			if (cr > ir) {
				dw = cw; dh = cw / ir; dx = 0; dy = (ch - dh) / 2;
			} else {
				dh = ch; dw = ch * ir; dy = 0; dx = (cw - dw) / 2;
			}
			ctx.clearRect(0, 0, cw, ch);
			ctx.drawImage(img, dx, dy, dw, dh);
		}

		function updateText(progress) {
			if (!lineEl || !lines.length) { return; }
			var idx = Math.floor(progress * lines.length);
			if (idx > lines.length - 1) { idx = lines.length - 1; }
			if (idx === currentLine) { return; }
			currentLine = idx;
			if (prefersReduced) {
				lineEl.textContent = lines[idx];
				return;
			}
			lineEl.classList.add('is-swapping');
			window.setTimeout(function () {
				lineEl.textContent = lines[idx];
				lineEl.classList.remove('is-swapping');
			}, 220);
		}

		function progressNow() {
			var scrollable = section.offsetHeight - window.innerHeight;
			if (scrollable <= 0) { return 0; }
			var top = section.getBoundingClientRect().top;
			var p = -top / scrollable;
			return Math.max(0, Math.min(1, p));
		}

		function render() {
			ticking = false;
			var p = progressNow();
			drawFrame(Math.round(p * (count - 1)));
			updateText(p);
		}

		function onScroll() {
			if (!ticking) {
				ticking = true;
				window.requestAnimationFrame(render);
			}
		}

		// Reduced motion: collapse the scroll length and show a single frame.
		if (prefersReduced) {
			section.style.height = '100vh';
		}

		// Sequential preload in scroll order so the frames a user reaches first
		// are the ones that load first.
		function loadFrom(i) {
			if (i >= count) {
				if (loader) { loader.classList.add('is-hidden'); }
				return;
			}
			var img = new Image();
			img.decoding = 'async';
			img.onload = img.onerror = function () {
				if (i === 0) {
					resize();
					drawFrame(0, true);
					if (loader) { loader.classList.add('is-dim'); }
				}
				// If the freshly loaded frame is at/behind the current target, repaint.
				render();
				loadFrom(i + 1);
			};
			img.src = frameURL(i);
			images[i] = img;
		}

		// Init.
		resize();
		loadFrom(0);

		if (!prefersReduced) {
			window.addEventListener('scroll', onScroll, { passive: true });
		}

		var resizeTimer = null;
		window.addEventListener('resize', function () {
			window.clearTimeout(resizeTimer);
			resizeTimer = window.setTimeout(resize, 150);
		});
	});
})();
