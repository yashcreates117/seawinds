/* =========================================================================
   Sea Winds — carousel.js
   Conveyor services carousel. Responsive visible-count, auto-rotate,
   arrows, dots, pause-on-hover. Loops smoothly by cloning slides.
   ========================================================================= */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('.sw-carousel').forEach(initCarousel);
	});

	function initCarousel(root) {
		var viewport = root.querySelector('.sw-carousel__viewport');
		var track = root.querySelector('.sw-carousel__track');
		var prevBtn = root.querySelector('.sw-carousel__arrow--prev');
		var nextBtn = root.querySelector('.sw-carousel__arrow--next');
		var dotsWrap = root.parentElement.querySelector('.sw-carousel__dots');

		if (!viewport || !track) {
			return;
		}

		var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		var interval = parseInt(root.getAttribute('data-interval'), 10) || 4000;

		var originals = Array.prototype.slice.call(track.children);
		var total = originals.length;
		if (!total) {
			return;
		}

		var visible = getVisible();
		var index = 0;
		var timer = null;
		var isAnimating = false;

		// Clone a set of leading slides at the end to allow seamless looping.
		function buildClones() {
			// Remove any prior clones.
			track.querySelectorAll('.is-clone').forEach(function (c) { c.remove(); });
			for (var i = 0; i < visible; i++) {
				var clone = originals[i % total].cloneNode(true);
				clone.classList.add('is-clone');
				clone.setAttribute('aria-hidden', 'true');
				track.appendChild(clone);
			}
		}

		function getVisible() {
			var w = window.innerWidth;
			if (w <= 768) { return 1; }
			if (w <= 1024) { return 2; }
			return 4;
		}

		function slideWidthPct() {
			return 100 / visible;
		}

		function layout() {
			var pct = slideWidthPct();
			Array.prototype.forEach.call(track.children, function (slide) {
				slide.style.flexBasis = pct + '%';
				slide.style.maxWidth = pct + '%';
			});
			setPosition(false);
		}

		function setPosition(animate) {
			track.style.transition = animate ? 'transform 0.6s cubic-bezier(0.4,0,0.2,1)' : 'none';
			track.style.transform = 'translateX(-' + (index * slideWidthPct()) + '%)';
		}

		function next() {
			if (isAnimating) {
				return;
			}
			isAnimating = true;
			index++;
			setPosition(true);
		}

		function prev() {
			if (isAnimating) {
				return;
			}
			isAnimating = true;
			if (index <= 0) {
				// Jump to the equivalent position at the cloned end, then step back.
				index = total;
				setPosition(false);
				// Force reflow.
				void track.offsetWidth;
			}
			index--;
			setPosition(true);
		}

		track.addEventListener('transitionend', function () {
			isAnimating = false;
			// Seamless loop: once we pass the last original, snap back to start.
			if (index >= total) {
				index = 0;
				setPosition(false);
			}
			updateDots();
		});

		// Dots — one per original slide "page".
		function buildDots() {
			if (!dotsWrap) {
				return;
			}
			dotsWrap.innerHTML = '';
			for (var i = 0; i < total; i++) {
				var dot = document.createElement('button');
				dot.className = 'sw-carousel__dot';
				dot.setAttribute('type', 'button');
				dot.setAttribute('aria-label', 'Go to service ' + (i + 1));
				(function (i) {
					dot.addEventListener('click', function () {
						if (isAnimating) { return; }
						isAnimating = true;
						index = i;
						setPosition(true);
						restart();
					});
				})(i);
				dotsWrap.appendChild(dot);
			}
			updateDots();
		}

		function updateDots() {
			if (!dotsWrap) {
				return;
			}
			var active = ((index % total) + total) % total;
			Array.prototype.forEach.call(dotsWrap.children, function (dot, i) {
				dot.classList.toggle('is-active', i === active);
			});
		}

		function start() {
			if (prefersReducedMotion || timer) {
				return;
			}
			timer = window.setInterval(next, interval);
		}

		function stop() {
			if (timer) {
				window.clearInterval(timer);
				timer = null;
			}
		}

		function restart() {
			stop();
			start();
		}

		// Arrows.
		if (nextBtn) {
			nextBtn.addEventListener('click', function () { next(); restart(); });
		}
		if (prevBtn) {
			prevBtn.addEventListener('click', function () { prev(); restart(); });
		}

		// Pause on hover.
		root.addEventListener('mouseenter', stop);
		root.addEventListener('mouseleave', start);

		// Rebuild on resize if the visible count changes.
		var resizeTimer = null;
		window.addEventListener('resize', function () {
			window.clearTimeout(resizeTimer);
			resizeTimer = window.setTimeout(function () {
				var newVisible = getVisible();
				if (newVisible !== visible) {
					visible = newVisible;
					index = 0;
					buildClones();
					layout();
				}
			}, 200);
		});

		// Init.
		buildClones();
		buildDots();
		layout();
		start();
	}
})();
