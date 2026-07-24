/* =========================================================================
   Sea Winds — scroll-animations.js
   Intersection Observer driven reveal animations.
   Elements with .sw-animate fade/slide in when 20% visible.
   Parents with .sw-stagger apply an incremental delay to their children.
   ========================================================================= */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		var animated = document.querySelectorAll('.sw-animate');

		initCounters(prefersReducedMotion);

		if (!animated.length) {
			return;
		}

		// If reduced motion or IO unsupported, reveal everything immediately.
		if (prefersReducedMotion || !('IntersectionObserver' in window)) {
			animated.forEach(function (el) {
				el.classList.add('is-visible');
			});
			return;
		}

		// Apply stagger delays as inline styles for precise control.
		document.querySelectorAll('.sw-stagger').forEach(function (parent) {
			var children = parent.querySelectorAll(':scope > .sw-animate');
			children.forEach(function (child, i) {
				child.style.transitionDelay = (i * 0.1) + 's';
			});
		});

		var observer = new IntersectionObserver(function (entries, obs) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					obs.unobserve(entry.target);
				}
			});
		}, {
			threshold: 0.2,
			rootMargin: '0px 0px -5% 0px'
		});

		animated.forEach(function (el) {
			observer.observe(el);
		});
	});

	/* ---------------------------------------------------------------------
	 * Animated stat counters. Any element with [data-count] counts up from 0
	 * to its target over 2s (ease-out) when it scrolls into view, then keeps
	 * the optional [data-suffix] (e.g. "+").
	 * ------------------------------------------------------------------ */
	function initCounters(prefersReducedMotion) {
		var counters = document.querySelectorAll('[data-count]');
		if (!counters.length) {
			return;
		}

		function finalText(el) {
			var target = parseInt(el.getAttribute('data-count'), 10) || 0;
			return target + (el.getAttribute('data-suffix') || '');
		}

		// Reduced motion or no IO support: just show the final numbers.
		if (prefersReducedMotion || !('IntersectionObserver' in window)) {
			counters.forEach(function (el) { el.textContent = finalText(el); });
			return;
		}

		function runCount(el) {
			var target = parseInt(el.getAttribute('data-count'), 10) || 0;
			var suffix = el.getAttribute('data-suffix') || '';
			var duration = 2000;
			var start = null;

			function step(timestamp) {
				if (start === null) {
					start = timestamp;
				}
				var elapsed = timestamp - start;
				var t = Math.min(elapsed / duration, 1);
				// easeOutCubic
				var eased = 1 - Math.pow(1 - t, 3);
				var value = Math.round(eased * target);
				el.textContent = value + suffix;
				if (t < 1) {
					window.requestAnimationFrame(step);
				} else {
					el.textContent = target + suffix;
				}
			}

			window.requestAnimationFrame(step);
		}

		var counterObserver = new IntersectionObserver(function (entries, obs) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					runCount(entry.target);
					obs.unobserve(entry.target);
				}
			});
		}, {
			threshold: 0.4
		});

		counters.forEach(function (el) {
			counterObserver.observe(el);
		});
	}
})();
