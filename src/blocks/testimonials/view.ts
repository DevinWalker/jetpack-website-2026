import './style.css';

/**
 * Testimonials slider view script.
 * Nav is inside each slide's content column — use event delegation on the section.
 */

function initTestimonialsSlider(): void {
	const section = document.querySelector< HTMLElement >( '.jetpack-testimonials' );
	if ( ! section ) return;

	const slides   = Array.from( section.querySelectorAll< HTMLElement >( '.jetpack-slide' ) );
	const counters = Array.from( section.querySelectorAll< HTMLElement >( '.jetpack-slider__current' ) );
	const count    = slides.length;

	if ( count < 2 ) return;

	let active = 0;
	let timer: ReturnType< typeof setInterval > | null = null;
	const INTERVAL = 8000;

	function goTo( idx: number ): void {
		active = ( ( idx % count ) + count ) % count;
		slides.forEach( ( s, i ) => {
			s.classList.toggle( 'jetpack-slide--active', i === active );
		} );
		const label = String( active + 1 );
		counters.forEach( ( el ) => { el.textContent = label; } );
	}

	function resetTimer(): void {
		if ( timer ) clearInterval( timer );
		timer = setInterval( () => goTo( active + 1 ), INTERVAL );
	}

	section.addEventListener( 'click', ( e ) => {
		const btn = ( e.target as HTMLElement ).closest< HTMLElement >( '[data-dir]' );
		if ( ! btn ) return;
		goTo( btn.dataset.dir === 'prev' ? active - 1 : active + 1 );
		resetTimer();
	} );

	goTo( 0 );
	resetTimer();
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', initTestimonialsSlider );
} else {
	initTestimonialsSlider();
}
