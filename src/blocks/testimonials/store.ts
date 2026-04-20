/**
 * Testimonials Interactivity API store.
 * Handles avatar click, auto-advance timer, progress ring animation,
 * and quote fade transition (via DOM class toggling).
 */
import { store, getContext, getElement } from '@wordpress/interactivity';

interface TestimonialsState {
	activeIndex: number;
}

let autoAdvanceTimer: ReturnType< typeof setInterval > | null = null;

function applyActiveState( root: Element, nextIndex: number, prevIndex: number ): void {
	// Update quotes visibility.
	root.querySelectorAll< HTMLElement >( '.jetpack-quote' ).forEach( ( el ) => {
		const i = parseInt( el.dataset.testimonialIndex ?? '-1', 10 );
		el.classList.toggle( 'active', i === nextIndex );
	} );

	// Update logo opacity.
	root.querySelectorAll< HTMLElement >( '[data-testimonial-logo]' ).forEach( ( el ) => {
		const i = parseInt( el.dataset.testimonialLogo ?? '-1', 10 );
		const img = el.querySelector< HTMLImageElement >( 'img' );
		if ( img ) {
			img.classList.toggle( 'opacity-100', i === nextIndex );
			img.classList.toggle( 'opacity-30', i !== nextIndex );
		}
	} );

	// Update avatar scale / opacity.
	root.querySelectorAll< HTMLElement >( '.jetpack-testimonial-avatar' ).forEach( ( el ) => {
		const ctx = el.dataset.wpContext ? JSON.parse( el.dataset.wpContext ) : {};
		const i   = ctx.index ?? -1;
		el.style.transform = i === nextIndex ? 'scale(1.1)' : 'scale(0.9)';
		el.style.opacity   = i === nextIndex ? '1' : '0.6';
	} );

	// Reset and restart progress ring.
	const rings = root.querySelectorAll< SVGCircleElement >( '.jetpack-progress-ring' );
	rings.forEach( ( ring, i ) => {
		const dashArray = parseFloat( ring.getAttribute( 'stroke-dasharray' ) ?? '0' );
		ring.style.transition = 'none';
		ring.setAttribute( 'stroke-dashoffset', String( dashArray ) );
		if ( i === nextIndex ) {
			requestAnimationFrame( () => {
				ring.style.transition = 'stroke-dashoffset 10s linear';
				ring.setAttribute( 'stroke-dashoffset', '0' );
			} );
		}
	} );
}

function startAutoAdvance( root: Element, count: number ): void {
	if ( autoAdvanceTimer ) clearInterval( autoAdvanceTimer );
	autoAdvanceTimer = setInterval( () => {
		const s   = store( 'jetpack-theme/testimonials' );
		const prev = s.state.activeIndex;
		const next = ( prev + 1 ) % count;
		s.state.activeIndex = next;
		applyActiveState( root, next, prev );
	}, 10_000 );
}

const { state } = store( 'jetpack-theme/testimonials', {
	state: {
		activeIndex: 0,
	} as TestimonialsState,

	actions: {
		setActive() {
			const ctx  = getContext< { index: number; count: number } >();
			const prev = state.activeIndex;
			state.activeIndex = ctx.index;

			const el   = getElement();
			const root = el.ref?.closest( '.jetpack-testimonials' );
			if ( root ) {
				applyActiveState( root, ctx.index, prev );
				startAutoAdvance( root, ctx.count );
			}
		},
	},

	callbacks: {
		init() {
			const el   = getElement();
			const root = el.ref?.closest( '.jetpack-testimonials' );
			if ( ! root ) return;

			const ctx = getContext< { count: number } >();
			// Set initial state.
			applyActiveState( root, 0, -1 );
			startAutoAdvance( root, ctx.count );
		},
	},
} );
