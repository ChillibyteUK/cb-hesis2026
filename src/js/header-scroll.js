/**
 * Adds .scrolled to #masthead once the page has moved, so the header can
 * start transparent over a hero and turn solid as the user scrolls
 * (src/css/header.css). Pages without a hero are solid from load via
 * body:not(.has-hero), so this is purely additive there.
 */
export function initHeaderScroll() {
	const header = document.getElementById('masthead');
	if (!header) return;

	let ticking = false;

	function update() {
		header.classList.toggle('scrolled', window.scrollY > 20);
		ticking = false;
	}

	window.addEventListener(
		'scroll',
		() => {
			if (!ticking) {
				window.requestAnimationFrame(update);
				ticking = true;
			}
		},
		{ passive: true }
	);
	update();
}
