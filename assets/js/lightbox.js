/* =========================================================================
   Sea Winds — lightbox.js
   Premium fullscreen lightbox for project / gallery photo grids.
   Triggered by any element with [data-lightbox] inside a [data-lightbox-group].
   Features: prev/next, counter, keyboard nav, Escape, swipe, fade transitions.
   ========================================================================= */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var groups = document.querySelectorAll('[data-lightbox-group]');
		if (!groups.length) {
			return;
		}

		var overlay = buildOverlay();
		document.body.appendChild(overlay.root);

		var current = { items: [], index: 0 };

		groups.forEach(function (group) {
			var triggers = group.querySelectorAll('[data-lightbox]');
			var items = Array.prototype.map.call(triggers, function (t) {
				return t.getAttribute('data-lightbox');
			});

			triggers.forEach(function (trigger, i) {
				trigger.addEventListener('click', function (e) {
					e.preventDefault();
					current.items = items;
					current.index = i;
					open();
				});
			});
		});

		function open() {
			render();
			overlay.root.classList.add('is-open');
			overlay.root.setAttribute('aria-hidden', 'false');
			document.body.style.overflow = 'hidden';
		}

		function close() {
			overlay.root.classList.remove('is-open');
			overlay.root.setAttribute('aria-hidden', 'true');
			document.body.style.overflow = '';
		}

		function render() {
			var src = current.items[current.index];
			overlay.img.classList.add('is-fading');
			window.setTimeout(function () {
				overlay.img.src = src;
				overlay.img.classList.remove('is-fading');
			}, 180);
			overlay.counter.textContent = (current.index + 1) + ' / ' + current.items.length;
		}

		function nextImg() {
			current.index = (current.index + 1) % current.items.length;
			render();
		}

		function prevImg() {
			current.index = (current.index - 1 + current.items.length) % current.items.length;
			render();
		}

		overlay.closeBtn.addEventListener('click', close);
		overlay.nextBtn.addEventListener('click', nextImg);
		overlay.prevBtn.addEventListener('click', prevImg);

		// Click the dark backdrop (but not the image/controls) to close.
		overlay.root.addEventListener('click', function (e) {
			if (e.target === overlay.root || e.target === overlay.stage) {
				close();
			}
		});

		// Keyboard navigation.
		document.addEventListener('keydown', function (e) {
			if (!overlay.root.classList.contains('is-open')) {
				return;
			}
			if (e.key === 'Escape') { close(); }
			else if (e.key === 'ArrowRight') { nextImg(); }
			else if (e.key === 'ArrowLeft') { prevImg(); }
		});

		// Swipe support (touch).
		var touchStartX = 0;
		var touchEndX = 0;
		overlay.root.addEventListener('touchstart', function (e) {
			touchStartX = e.changedTouches[0].screenX;
		}, { passive: true });
		overlay.root.addEventListener('touchend', function (e) {
			touchEndX = e.changedTouches[0].screenX;
			var delta = touchEndX - touchStartX;
			if (Math.abs(delta) > 45) {
				if (delta < 0) { nextImg(); } else { prevImg(); }
			}
		}, { passive: true });

		// Disable right-click / drag on the lightbox image.
		overlay.img.addEventListener('contextmenu', function (e) { e.preventDefault(); });
		overlay.img.addEventListener('dragstart', function (e) { e.preventDefault(); });
	});

	function buildOverlay() {
		var root = document.createElement('div');
		root.className = 'sw-lightbox';
		root.setAttribute('aria-hidden', 'true');
		root.setAttribute('role', 'dialog');
		root.setAttribute('aria-modal', 'true');

		var counter = document.createElement('div');
		counter.className = 'sw-lightbox__counter';

		var closeBtn = document.createElement('button');
		closeBtn.className = 'sw-lightbox__close';
		closeBtn.setAttribute('type', 'button');
		closeBtn.setAttribute('aria-label', 'Close');
		closeBtn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>';

		var prevBtn = document.createElement('button');
		prevBtn.className = 'sw-lightbox__nav sw-lightbox__nav--prev';
		prevBtn.setAttribute('type', 'button');
		prevBtn.setAttribute('aria-label', 'Previous');
		prevBtn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>';

		var nextBtn = document.createElement('button');
		nextBtn.className = 'sw-lightbox__nav sw-lightbox__nav--next';
		nextBtn.setAttribute('type', 'button');
		nextBtn.setAttribute('aria-label', 'Next');
		nextBtn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>';

		var stage = document.createElement('div');
		stage.className = 'sw-lightbox__stage';

		var img = document.createElement('img');
		img.className = 'sw-lightbox__img';
		img.setAttribute('alt', '');
		img.setAttribute('draggable', 'false');

		stage.appendChild(img);
		root.appendChild(counter);
		root.appendChild(closeBtn);
		root.appendChild(prevBtn);
		root.appendChild(nextBtn);
		root.appendChild(stage);

		return {
			root: root,
			stage: stage,
			img: img,
			counter: counter,
			closeBtn: closeBtn,
			prevBtn: prevBtn,
			nextBtn: nextBtn
		};
	}
})();
