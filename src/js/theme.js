import { initNavToggle } from './nav-toggle';
import { initNavDropdowns } from './nav-dropdown';
import { initDialogs } from './dialog';
import { initLenis } from './lenis-init';
import { initHeaderScroll } from './header-scroll';
import { initMarquees } from './marquee';
import { initFadeIns } from './fade-in';

document.addEventListener('DOMContentLoaded', () => {
	initLenis();
	initNavToggle();
	initNavDropdowns();
	initDialogs();
	initHeaderScroll();
	initMarquees();
	initFadeIns();
});
