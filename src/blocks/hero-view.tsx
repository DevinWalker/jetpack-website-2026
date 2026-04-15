/**
 * Hero view script — entrance animations matching the original Next.js hero.
 *
 * Variants (from hero.tsx):
 *   fadeInUp:    { opacity:0, y:20, blur:8px } → { opacity:1, y:0,    blur:0 }
 *   fadeInScale: { opacity:0, scale:.95, blur:8px } → { opacity:1, scale:1, blur:0 }
 *
 * Stagger: delayChildren 0.2s, staggerChildren 0.15s
 *   badge   → 0.20s
 *   line1   → 0.35s
 *   accent  → 0.50s
 *   body    → 0.65s
 *   cta     → 0.80s
 *
 * Outside stagger:
 *   dashboard → delay 0.6s, duration 1.0s
 *   logos     → delay 1.0s, duration 0.8s, opacity only
 *
 * Double-rAF pattern: frame 1 paints the explicit "from" state inline so the
 * browser has a committed starting point; frame 2 applies transitions + "to"
 * state so the animation actually runs.
 */

const EASE = 'cubic-bezier(0.23, 1, 0.32, 1)';

function setInitial(
	el: HTMLElement | null,
	styles: Partial< CSSStyleDeclaration >,
): void {
	if ( ! el ) return;
	Object.assign( el.style, styles );
}

function transition(
	el: HTMLElement | null,
	props: string[],
	to: Partial< CSSStyleDeclaration >,
	delay: number,
	duration = 0.8,
): void {
	if ( ! el ) return;
	const t = `${ duration }s ${ EASE } ${ delay }s`;
	el.style.transition = props.map( ( p ) => `${ p } ${ t }` ).join( ', ' );
	Object.assign( el.style, to );
}

requestAnimationFrame( () => {
	const hero = document.querySelector< HTMLElement >( '.jetpack-hero' );
	if ( ! hero ) return;

	const badge     = hero.querySelector< HTMLElement >( '.jetpack-hero__badge' );
	const line1     = hero.querySelector< HTMLElement >( '.jetpack-hero__headline-line' );
	const accent    = hero.querySelector< HTMLElement >( '.jetpack-hero__accent' );
	const body      = hero.querySelector< HTMLElement >( '.jetpack-hero__body' );
	const cta       = hero.querySelector< HTMLElement >( '.jetpack-hero__cta' );
	const dashboard = hero.querySelector< HTMLElement >( '.jetpack-hero__dashboard' );
	// Logos live outside <section> so search the whole document.
	const logos     = document.querySelector< HTMLElement >( '.jetpack-hero__logos' );

	// ── Frame 1: commit "from" states as inline styles ────────────────────────
	// fadeInUp elements
	[ badge, line1, accent, body ].forEach( ( el ) => {
		setInitial( el, { opacity: '0', transform: 'translateY(20px)', filter: 'blur(8px)' } );
	} );

	// fadeInScale element (CTA)
	setInitial( cta, { opacity: '0', transform: 'scale(0.95)', filter: 'blur(8px)' } );

	// dashboard: y:40, no blur
	setInitial( dashboard, { opacity: '0', transform: 'translateY(40px)' } );

	// logos: opacity only
	setInitial( logos, { opacity: '0' } );

	// ── Frame 2: apply transitions → "to" states ──────────────────────────────
	requestAnimationFrame( () => {
		const UP    = [ 'opacity', 'transform', 'filter' ];
		const SCALE = [ 'opacity', 'transform', 'filter' ];
		const FADE  = [ 'opacity' ];

		transition( badge,  UP,    { opacity: '1', transform: 'translateY(0)', filter: 'blur(0px)' }, 0.20 );
		transition( line1,  UP,    { opacity: '1', transform: 'translateY(0)', filter: 'blur(0px)' }, 0.35 );
		transition( accent, UP,    { opacity: '1', transform: 'translateY(0)', filter: 'blur(0px)' }, 0.50 );
		transition( body,   UP,    { opacity: '1', transform: 'translateY(0)', filter: 'blur(0px)' }, 0.65 );
		transition( cta,    SCALE, { opacity: '1', transform: 'scale(1)',      filter: 'blur(0px)' }, 0.80 );

		transition( dashboard, UP,   { opacity: '1', transform: 'translateY(0)' }, 0.6, 1.0 );
		transition( logos,     FADE, { opacity: '1' },                             1.0, 0.8 );
	} );
} );

// ── Logo loop — rAF velocity animation matching LogoLoop component ────────────
// Smooth exponential easing toward target velocity; pauses gracefully on hover.

( () => {
	const track = document.querySelector< HTMLElement >( '.jetpack-logo-track' );
	const seq   = document.querySelector< HTMLElement >( '[data-logo-seq]' );
	if ( ! track || ! seq ) return;

	if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) return;

	const SPEED     = 60;   // px/s — matches LogoLoop speed prop
	const SMOOTH_TAU = 0.25; // smoothing time constant (seconds)

	let offset    = 0;
	let velocity  = 0;
	let lastTs: number | null = null;
	let hovered   = false;

	track.addEventListener( 'mouseenter', () => { hovered = true; } );
	track.addEventListener( 'mouseleave', () => { hovered = false; } );

	const tick = ( ts: number ) => {
		if ( lastTs === null ) lastTs = ts;
		const dt = Math.max( 0, ts - lastTs ) / 1000;
		lastTs = ts;

		const target      = hovered ? 0 : SPEED;
		const easingFactor = 1 - Math.exp( -dt / SMOOTH_TAU );
		velocity += ( target - velocity ) * easingFactor;

		const seqWidth = seq.getBoundingClientRect().width;
		if ( seqWidth > 0 ) {
			offset = ( ( offset + velocity * dt ) % seqWidth + seqWidth ) % seqWidth;
			track.style.transform = `translate3d(${ -offset }px, 0, 0)`;
		}

		requestAnimationFrame( tick );
	};

	requestAnimationFrame( tick );
} )();
