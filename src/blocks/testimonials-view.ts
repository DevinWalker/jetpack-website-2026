/**
 * Testimonials slider view script.
 * Handles auto-advance, dot navigation, and slide transitions.
 */

function initTestimonialsSlider(): void {
	const section = document.querySelector< HTMLElement >( '.jetpack-testimonials' );
	if ( ! section ) return;

	const slides = Array.from( section.querySelectorAll< HTMLElement >( '.jetpack-slide' ) );
	const dots   = Array.from( section.querySelectorAll< HTMLElement >( '.jetpack-slider__dot' ) );
	const count  = slides.length;

	if ( count < 1 ) return;

	let active = 0;
	let timer: ReturnType< typeof setInterval > | null = null;
	const INTERVAL = 8000;

	function activate( idx: number ): void {
		active = ( ( idx % count ) + count ) % count;

		slides.forEach( ( slide, i ) => {
			const isActive = i === active;
			slide.classList.toggle( 'jetpack-slide--active', isActive );
			slide.setAttribute( 'aria-hidden', String( ! isActive ) );
		} );

		dots.forEach( ( dot, i ) => {
			const isActive = i === active;
			dot.classList.toggle( 'jetpack-slider__dot--active', isActive );
			dot.setAttribute( 'aria-selected', String( isActive ) );
		} );
	}

	activate( 0 );

	dots.forEach( ( dot ) => {
		dot.addEventListener( 'click', () => {
			const idx = parseInt( dot.dataset.dotIndex ?? '0', 10 );
			activate( idx );
			resetTimer();
		} );
	} );

	function startTimer(): void {
		timer = setInterval( () => activate( active + 1 ), INTERVAL );
	}

	function resetTimer(): void {
		if ( timer ) clearInterval( timer );
		startTimer();
	}

	if ( count > 1 ) startTimer();
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', initTestimonialsSlider );
} else {
	initTestimonialsSlider();
}
