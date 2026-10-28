/**
 * Scroll-triggered fade-up for anything carrying .fade-in. Falls back to
 * simply showing the element when GSAP is absent or motion is reduced.
 */
export function initFadeIns() {
	const items = document.querySelectorAll('.fade-in');
	if (!items.length) return;

	const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	if (!window.gsap || !window.ScrollTrigger || prefersReduced) {
		items.forEach((el) => el.classList.add('is-visible'));
		return;
	}

	window.gsap.registerPlugin(window.ScrollTrigger);

	items.forEach((el) => {
		window.gsap.fromTo(
			el,
			{ opacity: 0, y: 20 },
			{
				opacity: 1,
				y: 0,
				duration: 0.7,
				ease: 'power2.out',
				onStart: () => el.classList.add('is-visible'),
				scrollTrigger: { trigger: el, start: 'top 88%', once: true },
			}
		);
	});
}
