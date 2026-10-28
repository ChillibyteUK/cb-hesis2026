/**
 * Logo marquee. Drives [data-marquee] > [data-marquee-track]: when the track
 * overflows its container the content is duplicated and slid with GSAP;
 * otherwise it is left static and spread across the row. Pauses on hover,
 * does nothing for reduced-motion visitors.
 */
export function initMarquees() {
	const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	document.querySelectorAll('[data-marquee]').forEach((el) => {
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
				repeat: -1,
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
