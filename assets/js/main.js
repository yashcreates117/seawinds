/* =========================================================================
   Sea Winds — main.js
   Global behaviour: header scroll state, mobile drawer,
   image protection, contact form handling.
   ========================================================================= */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		initHeader();
		initDrawer();
		initImageProtection();
		initContactForm();
		initPortfolioFilter();
	});

	/* ---------------------------------------------------------------------
	 * Header — solid background on scroll past the hero.
	 * ------------------------------------------------------------------ */
	function initHeader() {
		var header = document.getElementById('sw-header');
		if (!header) {
			return;
		}

		var threshold = 60;

		function onScroll() {
			if (window.pageYOffset > threshold) {
				header.classList.add('is-scrolled');
			} else {
				header.classList.remove('is-scrolled');
			}
		}

		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });
	}

	/* ---------------------------------------------------------------------
	 * Mobile drawer.
	 * ------------------------------------------------------------------ */
	function initDrawer() {
		var hamburger = document.getElementById('sw-hamburger');
		var drawer = document.getElementById('sw-drawer');
		var overlay = document.getElementById('sw-drawer-overlay');

		if (!hamburger || !drawer || !overlay) {
			return;
		}

		function openDrawer() {
			drawer.classList.add('is-open');
			overlay.classList.add('is-open');
			hamburger.classList.add('is-active');
			hamburger.setAttribute('aria-expanded', 'true');
			drawer.setAttribute('aria-hidden', 'false');
			document.body.style.overflow = 'hidden';
		}

		function closeDrawer() {
			drawer.classList.remove('is-open');
			overlay.classList.remove('is-open');
			hamburger.classList.remove('is-active');
			hamburger.setAttribute('aria-expanded', 'false');
			drawer.setAttribute('aria-hidden', 'true');
			document.body.style.overflow = '';
		}

		hamburger.addEventListener('click', function () {
			if (drawer.classList.contains('is-open')) {
				closeDrawer();
			} else {
				openDrawer();
			}
		});

		overlay.addEventListener('click', closeDrawer);

		// Close when a link is tapped.
		drawer.querySelectorAll('a').forEach(function (link) {
			link.addEventListener('click', closeDrawer);
		});

		// Close on Escape.
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
				closeDrawer();
			}
		});
	}

	/* ---------------------------------------------------------------------
	 * Image protection — disable right-click on images, disable drag.
	 * ------------------------------------------------------------------ */
	function initImageProtection() {
		document.addEventListener('contextmenu', function (e) {
			if (e.target && e.target.tagName === 'IMG') {
				e.preventDefault();
			}
		});

		function markImages() {
			document.querySelectorAll('img').forEach(function (img) {
				img.setAttribute('draggable', 'false');
			});
		}

		markImages();

		// Re-apply for images added dynamically.
		if ('MutationObserver' in window) {
			var mo = new MutationObserver(function () {
				markImages();
			});
			mo.observe(document.body, { childList: true, subtree: true });
		}
	}

	/* ---------------------------------------------------------------------
	 * Portfolio filter tabs.
	 * ------------------------------------------------------------------ */
	function initPortfolioFilter() {
		var filter = document.querySelector('.sw-filter');
		var grid = document.getElementById('sw-portfolio-grid');
		if (!filter || !grid) {
			return;
		}

		var buttons = filter.querySelectorAll('.sw-filter__btn');
		// Any direct card in the grid that carries a data-cat attribute.
		var cards = grid.querySelectorAll('[data-cat]');

		buttons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				var target = btn.getAttribute('data-filter');

				buttons.forEach(function (b) { b.classList.remove('is-active'); });
				btn.classList.add('is-active');

				cards.forEach(function (card) {
					// data-cat may hold several space-separated categories.
					var cats = (card.getAttribute('data-cat') || '').split(/\s+/);
					var match = target === 'all' || cats.indexOf(target) !== -1;
					card.classList.toggle('is-hidden', !match);
				});
			});
		});
	}

	/* ---------------------------------------------------------------------
	 * Contact form — client validation + AJAX submission.
	 * ------------------------------------------------------------------ */
	function initContactForm() {
		var form = document.getElementById('sw-contact-form');
		if (!form) {
			return;
		}

		var feedback = form.querySelector('.sw-form__feedback');
		var submitBtn = form.querySelector('.sw-form__submit');

		function setError(field, show) {
			var input = form.querySelector('[name="' + field + '"]');
			var errorEl = form.querySelector('.sw-form__error[data-for="' + field + '"]');
			if (input) {
				input.classList.toggle('has-error', show);
			}
			if (errorEl) {
				errorEl.classList.toggle('is-shown', show);
			}
		}

		function validate() {
			var ok = true;
			var name = form.querySelector('[name="name"]');
			var phone = form.querySelector('[name="phone"]');
			var email = form.querySelector('[name="email"]');
			var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

			if (!name.value.trim()) { setError('name', true); ok = false; } else { setError('name', false); }
			if (!phone.value.trim()) { setError('phone', true); ok = false; } else { setError('phone', false); }
			if (!email.value.trim() || !emailRe.test(email.value.trim())) { setError('email', true); ok = false; } else { setError('email', false); }

			return ok;
		}

		// Clear error as the user types.
		form.querySelectorAll('input, textarea').forEach(function (el) {
			el.addEventListener('input', function () {
				el.classList.remove('has-error');
				var errorEl = form.querySelector('.sw-form__error[data-for="' + el.name + '"]');
				if (errorEl) {
					errorEl.classList.remove('is-shown');
				}
			});
		});

		form.addEventListener('submit', function (e) {
			e.preventDefault();
			feedback.textContent = '';
			feedback.classList.remove('is-success', 'is-error');

			if (!validate()) {
				feedback.textContent = 'Please complete all required fields.';
				feedback.classList.add('is-error');
				return;
			}

			if (typeof window.seawindsData === 'undefined') {
				feedback.textContent = 'Something went wrong. Please call us directly.';
				feedback.classList.add('is-error');
				return;
			}

			var data = new FormData(form);
			data.append('action', 'seawinds_contact');
			data.append('nonce', window.seawindsData.nonce);

			submitBtn.disabled = true;
			var originalLabel = submitBtn.textContent;
			submitBtn.textContent = 'Sending…';

			fetch(window.seawindsData.ajaxUrl, {
				method: 'POST',
				body: data,
				credentials: 'same-origin'
			})
				.then(function (res) { return res.json(); })
				.then(function (json) {
					if (json && json.success) {
						feedback.textContent = json.data.message;
						feedback.classList.add('is-success');
						form.reset();
					} else {
						var msg = (json && json.data && json.data.message) ? json.data.message : 'Something went wrong. Please call us directly.';
						feedback.textContent = msg;
						feedback.classList.add('is-error');
						if (json && json.data && json.data.fields) {
							json.data.fields.forEach(function (f) { setError(f, true); });
						}
					}
				})
				.catch(function () {
					feedback.textContent = 'Something went wrong. Please call us directly.';
					feedback.classList.add('is-error');
				})
				.finally(function () {
					submitBtn.disabled = false;
					submitBtn.textContent = originalLabel;
				});
		});
	}
})();
