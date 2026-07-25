/* =========================================================================
   Sea Winds — project-modal.js
   Two-tier project lightbox:
     Tier 1 (modal)  — click a project box → overlay with ALL its photos in a
                       scrollable grid, plus a close (X).
     Tier 2 (viewer) — click a photo → fullscreen single image with prev/next
                       arrows, a counter, and a close (X) back to the grid.
   Triggered by any element with class .sw-project-open + data-images (JSON) +
   data-project (name). Used on category subpages and the Gallery.
   ========================================================================= */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var triggers = document.querySelectorAll('.sw-project-open[data-images]');
		if (!triggers.length) {
			return;
		}

		var ui = buildUI();
		document.body.appendChild(ui.modal);
		document.body.appendChild(ui.viewer);

		var images = [];
		var index = 0;

		function openModal(name, imgs) {
			images = imgs;
			ui.title.textContent = name || '';
			ui.grid.innerHTML = '';
			imgs.forEach(function (src, i) {
				var cell = document.createElement('button');
				cell.type = 'button';
				cell.className = 'sw-pmodal__cell';
				cell.setAttribute('aria-label', 'View photo ' + (i + 1));
				var img = document.createElement('img');
				img.src = src;
				img.loading = 'lazy';
				img.decoding = 'async';
				img.alt = '';
				img.setAttribute('draggable', 'false');
				cell.appendChild(img);
				cell.addEventListener('click', function () { openViewer(i); });
				ui.grid.appendChild(cell);
			});
			ui.scroll.scrollTop = 0;
			ui.modal.classList.add('is-open');
			document.body.style.overflow = 'hidden';
		}

		function closeModal() {
			ui.modal.classList.remove('is-open');
			if (!ui.viewer.classList.contains('is-open')) {
				document.body.style.overflow = '';
			}
		}

		function renderViewer() {
			var src = images[index];
			ui.vimg.classList.add('is-fading');
			window.setTimeout(function () {
				ui.vimg.src = src;
				ui.vimg.classList.remove('is-fading');
			}, 160);
			ui.counter.textContent = (index + 1) + ' / ' + images.length;
		}

		function openViewer(i) {
			index = i;
			renderViewer();
			ui.viewer.classList.add('is-open');
		}

		function closeViewer() {
			ui.viewer.classList.remove('is-open');
		}

		function next() {
			index = (index + 1) % images.length;
			renderViewer();
		}

		function prev() {
			index = (index - 1 + images.length) % images.length;
			renderViewer();
		}

		triggers.forEach(function (t) {
			function fire() {
				var imgs = [];
				try {
					imgs = JSON.parse(t.getAttribute('data-images')) || [];
				} catch (e) {}
				if (!imgs.length) {
					return;
				}
				openModal(t.getAttribute('data-project'), imgs);
			}
			t.addEventListener('click', fire);
			t.addEventListener('keydown', function (e) {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					fire();
				}
			});
		});

		ui.modalClose.addEventListener('click', closeModal);
		ui.modal.addEventListener('click', function (e) {
			if (e.target === ui.modal || e.target === ui.scroll) { closeModal(); }
		});
		ui.vClose.addEventListener('click', closeViewer);
		ui.vNext.addEventListener('click', next);
		ui.vPrev.addEventListener('click', prev);
		ui.viewer.addEventListener('click', function (e) {
			if (e.target === ui.viewer || e.target === ui.vstage) { closeViewer(); }
		});

		document.addEventListener('keydown', function (e) {
			if (ui.viewer.classList.contains('is-open')) {
				if (e.key === 'Escape') { closeViewer(); }
				else if (e.key === 'ArrowRight') { next(); }
				else if (e.key === 'ArrowLeft') { prev(); }
			} else if (ui.modal.classList.contains('is-open')) {
				if (e.key === 'Escape') { closeModal(); }
			}
		});

		// Swipe in the viewer.
		var sx = 0;
		ui.viewer.addEventListener('touchstart', function (e) { sx = e.changedTouches[0].screenX; }, { passive: true });
		ui.viewer.addEventListener('touchend', function (e) {
			var d = e.changedTouches[0].screenX - sx;
			if (Math.abs(d) > 45) { d < 0 ? next() : prev(); }
		}, { passive: true });

		ui.vimg.addEventListener('contextmenu', function (e) { e.preventDefault(); });
		ui.vimg.addEventListener('dragstart', function (e) { e.preventDefault(); });
	});

	function make(tag, cls, html) {
		var e = document.createElement(tag);
		if (cls) { e.className = cls; }
		if (html) { e.innerHTML = html; }
		return e;
	}
	function closeSVG() {
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>';
	}
	function arrowSVG(d) {
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="' + d + '"/></svg>';
	}

	function buildUI() {
		// Tier 1 — project modal (grid of all photos).
		var modal = make('div', 'sw-pmodal');
		modal.setAttribute('role', 'dialog');
		modal.setAttribute('aria-modal', 'true');
		var head = make('div', 'sw-pmodal__head');
		var title = make('h2', 'sw-pmodal__title');
		var modalClose = make('button', 'sw-pmodal__close', closeSVG());
		modalClose.type = 'button';
		modalClose.setAttribute('aria-label', 'Close');
		head.appendChild(title);
		head.appendChild(modalClose);
		var scroll = make('div', 'sw-pmodal__scroll');
		var grid = make('div', 'sw-pmodal__grid');
		scroll.appendChild(grid);
		modal.appendChild(head);
		modal.appendChild(scroll);

		// Tier 2 — fullscreen viewer (single photo).
		var viewer = make('div', 'sw-pviewer');
		viewer.setAttribute('role', 'dialog');
		viewer.setAttribute('aria-modal', 'true');
		var counter = make('div', 'sw-pviewer__counter');
		var vClose = make('button', 'sw-pviewer__close', closeSVG());
		vClose.type = 'button';
		vClose.setAttribute('aria-label', 'Close');
		var vPrev = make('button', 'sw-pviewer__nav sw-pviewer__nav--prev', arrowSVG('m15 18-6-6 6-6'));
		vPrev.type = 'button';
		vPrev.setAttribute('aria-label', 'Previous');
		var vNext = make('button', 'sw-pviewer__nav sw-pviewer__nav--next', arrowSVG('m9 18 6-6-6-6'));
		vNext.type = 'button';
		vNext.setAttribute('aria-label', 'Next');
		var vstage = make('div', 'sw-pviewer__stage');
		var vimg = make('img', 'sw-pviewer__img');
		vimg.setAttribute('alt', '');
		vimg.setAttribute('draggable', 'false');
		vstage.appendChild(vimg);
		viewer.appendChild(counter);
		viewer.appendChild(vClose);
		viewer.appendChild(vPrev);
		viewer.appendChild(vNext);
		viewer.appendChild(vstage);

		return {
			modal: modal, title: title, modalClose: modalClose, scroll: scroll, grid: grid,
			viewer: viewer, counter: counter, vClose: vClose, vPrev: vPrev, vNext: vNext, vstage: vstage, vimg: vimg
		};
	}
})();
