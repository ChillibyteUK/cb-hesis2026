/*!
 * cb-hesis2026 v1.0.0 (https://github.com/ChillibyteUK/cb-hesis2026)
 * Copyright 2026 Chillibyte - DS
 * Licensed under GPL-3.0
 */
(function () {
	'use strict';

	/**
	 * Mobile nav toggle. Wires any button with aria-controls pointing at a
	 * .navbar-collapse to show/hide it and keep aria-expanded in sync — this is
	 * the entire replacement for Bootstrap's Collapse component for this use case.
	 */
	function initNavToggle() {
	  document.querySelectorAll('.navbar-toggler[aria-controls]').forEach(toggler => {
	    const target = document.getElementById(toggler.getAttribute('aria-controls'));
	    if (!target) return;
	    toggler.addEventListener('click', () => {
	      const isOpen = target.classList.toggle('is-open');
	      toggler.setAttribute('aria-expanded', String(isOpen));
	    });

	    // Close after choosing a link — expected mobile nav behaviour.
	    target.querySelectorAll('a').forEach(link => {
	      link.addEventListener('click', () => {
	        target.classList.remove('is-open');
	        toggler.setAttribute('aria-expanded', 'false');
	      });
	    });
	  });
	}

	/**
	 * Click-to-open nav dropdowns. Each dropdown-toggle button shows/hides its
	 * linked .dropdown-menu and keeps aria-expanded in sync. Clicking elsewhere,
	 * or pressing Escape, closes whatever is open — this is the entire
	 * replacement for hover-based submenus.
	 */
	function initNavDropdowns() {
	  const toggles = document.querySelectorAll('.dropdown-toggle[aria-controls]');
	  function close(toggle) {
	    const menu = document.getElementById(toggle.getAttribute('aria-controls'));
	    if (!menu) return;
	    menu.classList.remove('is-open');
	    toggle.setAttribute('aria-expanded', 'false');
	  }
	  function closeAllExcept(except) {
	    toggles.forEach(toggle => {
	      if (toggle !== except) close(toggle);
	    });
	  }
	  toggles.forEach(toggle => {
	    const menu = document.getElementById(toggle.getAttribute('aria-controls'));
	    if (!menu) return;
	    toggle.addEventListener('click', event => {
	      event.stopPropagation();
	      const isOpen = menu.classList.toggle('is-open');
	      toggle.setAttribute('aria-expanded', String(isOpen));
	      closeAllExcept(toggle);
	    });
	  });
	  document.addEventListener('click', event => {
	    if (event.target.closest('.dropdown-menu')) return;
	    closeAllExcept();
	  });
	  document.addEventListener('keydown', event => {
	    if (event.key !== 'Escape') return;
	    const openToggle = Array.from(toggles).find(toggle => toggle.getAttribute('aria-expanded') === 'true');
	    closeAllExcept();
	    if (openToggle) openToggle.focus();
	  });
	}

	/**
	 * Native <dialog> wiring — replaces Bootstrap's Modal component entirely.
	 * showModal()/close() do the heavy lifting (focus trap, Escape-to-close,
	 * ::backdrop); this just connects trigger/close buttons to a target dialog.
	 *
	 * Markup:
	 *   <button data-dialog-target="my-dialog">Open</button>
	 *   <dialog id="my-dialog">
	 *     <button data-dialog-close>Close</button>
	 *     ...
	 *   </dialog>
	 *
	 * A dialog containing <iframe data-src="..."> (click-to-play video embeds)
	 * only loads the iframe when the dialog opens — nothing is fetched or
	 * tracked until asked for — and unloads it again on close, so background
	 * playback stops the moment the modal closes.
	 */
	function initDialogs() {
	  document.querySelectorAll('[data-dialog-target]').forEach(trigger => {
	    const dialog = document.getElementById(trigger.getAttribute('data-dialog-target'));
	    if (!(dialog instanceof HTMLDialogElement)) return;
	    trigger.addEventListener('click', () => {
	      dialog.querySelectorAll('iframe[data-src]').forEach(frame => {
	        if (!frame.getAttribute('src')) frame.setAttribute('src', frame.getAttribute('data-src'));
	      });
	      dialog.showModal();
	    });
	    dialog.querySelectorAll('[data-dialog-close]').forEach(closeBtn => {
	      closeBtn.addEventListener('click', () => dialog.close());
	    });

	    // Click on the backdrop (the dialog element itself, outside its content) closes it.
	    dialog.addEventListener('click', event => {
	      if (event.target === dialog) dialog.close();
	    });

	    // Unload lazy iframes on close — removes the video from the page so
	    // playback (and tracking) stops, ready to load fresh next open.
	    dialog.addEventListener('close', () => {
	      dialog.querySelectorAll('iframe[data-src]').forEach(frame => {
	        frame.removeAttribute('src');
	      });
	    });
	  });
	}

	/**
	 * Smooth scroll via Lenis, synced with GSAP ScrollTrigger through a single
	 * gsap-ticker-driven loop — this sync is the whole point: Lenis on its own
	 * rAF loop leaves ScrollTrigger reading native scroll positions that no
	 * longer match what's on screen, desyncing every scroll-driven trigger on
	 * the page. Self-guarding: no-ops if the Lenis global isn't present;
	 * reduced-motion visitors get native scrolling instead of a hijacked one.
	 */
	function initLenis() {
	  if (typeof window.Lenis === 'undefined') return;
	  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
	  const lenis = new window.Lenis({
	    lerp: 0.1
	  });
	  if (typeof window.gsap !== 'undefined' && typeof window.ScrollTrigger !== 'undefined') {
	    try {
	      window.gsap.registerPlugin(window.ScrollTrigger);
	      lenis.on('scroll', window.ScrollTrigger.update);
	      window.gsap.ticker.add(time => {
	        lenis.raf(time * 1000);
	      });
	      window.gsap.ticker.lagSmoothing(0);
	      return;
	    } catch (error) {
	      // Fall through to a standalone rAF loop below.
	    }
	  }
	  function raf(time) {
	    lenis.raf(time);
	    requestAnimationFrame(raf);
	  }
	  requestAnimationFrame(raf);
	}

	/**
	 * Adds .scrolled to #masthead once the page has moved, so the header can
	 * start transparent over a hero and turn solid as the user scrolls
	 * (src/css/header.css). Pages without a hero are solid from load via
	 * body:not(.has-hero), so this is purely additive there.
	 */
	function initHeaderScroll() {
	  const header = document.getElementById('masthead');
	  if (!header) return;
	  let ticking = false;
	  function update() {
	    header.classList.toggle('scrolled', window.scrollY > 20);
	    ticking = false;
	  }
	  window.addEventListener('scroll', () => {
	    if (!ticking) {
	      window.requestAnimationFrame(update);
	      ticking = true;
	    }
	  }, {
	    passive: true
	  });
	  update();
	}

	/**
	 * Logo marquee. Drives [data-marquee] > [data-marquee-track]: when the track
	 * overflows its container the content is duplicated and slid with GSAP;
	 * otherwise it is left static and spread across the row. Pauses on hover,
	 * does nothing for reduced-motion visitors.
	 */
	function initMarquees() {
	  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	  document.querySelectorAll('[data-marquee]').forEach(el => {
	    const track = el.querySelector('[data-marquee-track]');
	    if (!track) return;
	    const original = track.innerHTML;
	    let tween = null;
	    function start() {
	      if (tween) {
	        tween.kill();
	        tween = null;
	      }
	      track.innerHTML = original;
	      track.classList.remove('is-scrolling');
	      track.style.transform = '';
	      if (track.scrollWidth <= el.clientWidth + 1 || !window.gsap || prefersReduced) {
	        return;
	      }
	      track.classList.add('is-scrolling');
	      track.innerHTML = original + original;
	      const distance = track.scrollWidth / 2;
	      const speed = parseFloat(el.dataset.marqueeSpeed) || 60;
	      tween = window.gsap.to(track, {
	        x: -distance,
	        duration: distance / speed,
	        ease: 'none',
	        repeat: -1
	      });
	    }
	    el.addEventListener('mouseenter', () => tween && tween.pause());
	    el.addEventListener('mouseleave', () => tween && tween.play());
	    let timer;
	    window.addEventListener('resize', () => {
	      clearTimeout(timer);
	      timer = setTimeout(start, 200);
	    });
	    start();
	  });
	}

	/**
	 * Scroll-triggered fade-up for anything carrying .fade-in. Falls back to
	 * simply showing the element when GSAP is absent or motion is reduced.
	 */
	function initFadeIns() {
	  const items = document.querySelectorAll('.fade-in');
	  if (!items.length) return;
	  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	  if (!window.gsap || !window.ScrollTrigger || prefersReduced) {
	    items.forEach(el => el.classList.add('is-visible'));
	    return;
	  }
	  window.gsap.registerPlugin(window.ScrollTrigger);
	  items.forEach(el => {
	    window.gsap.fromTo(el, {
	      opacity: 0,
	      y: 20
	    }, {
	      opacity: 1,
	      y: 0,
	      duration: 0.7,
	      ease: 'power2.out',
	      onStart: () => el.classList.add('is-visible'),
	      scrollTrigger: {
	        trigger: el,
	        start: 'top 88%',
	        once: true
	      }
	    });
	  });
	}

	document.addEventListener('DOMContentLoaded', () => {
	  initLenis();
	  initNavToggle();
	  initNavDropdowns();
	  initDialogs();
	  initHeaderScroll();
	  initMarquees();
	  initFadeIns();
	});

})();
//# sourceMappingURL=theme.js.map
