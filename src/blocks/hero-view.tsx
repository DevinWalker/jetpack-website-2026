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
	const logos     = hero.querySelector< HTMLElement >( '.jetpack-hero__logos' );

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
