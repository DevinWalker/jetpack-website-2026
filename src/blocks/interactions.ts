/**
 * Interactions — vanilla TypeScript handling all site UI behaviors.
 * Loaded globally on every page. No framework dependencies.
 *
 * Handles:
 *   - Header entrance animation + dropdown hover + mobile menu
 *   - Testimonials carousel (auto-advance, avatar click, progress ring)
 *
 * Note: FAQ accordion is handled by the Interactivity API store (faq-store.ts).
 */

// ── Utility ──────────────────────────────────────────────────────────────────

const $ = < T extends Element >( sel: string, root: Element | Document = document ) =>
	root.querySelector< T >( sel );
const $$ = < T extends Element >( sel: string, root: Element | Document = document ) =>
	Array.from( root.querySelectorAll< T >( sel ) );

// ── Header ───────────────────────────────────────────────────────────────────
// The entrance slide animation is handled entirely by CSS (@keyframes jetpackHeaderSlideIn).
// JS only manages interactive states: dropdowns, mobile menu.

function initHeader(): void {
	const header = $< HTMLElement >( '.jetpack-header' );
	if ( ! header ) return;

	// Desktop dropdowns.
	$$< HTMLElement >( '[data-wp-context]', header ).forEach( ( item ) => {
		let ctx: { menuId?: string } = {};
		try { ctx = JSON.parse( item.dataset.wpContext ?? '{}' ); } catch { /* */ }
		if ( ! ctx.menuId ) return;

		const dropdown = $< HTMLElement >( '.jetpack-dropdown-open, [data-wp-class--jetpack-dropdown-open]', item )
			|| item.querySelector< HTMLElement >( 'div:last-child' );

		item.addEventListener( 'mouseenter', () => {
			dropdown?.classList.add( 'jetpack-dropdown-open' );
		} );
		item.addEventListener( 'mouseleave', () => {
			dropdown?.classList.remove( 'jetpack-dropdown-open' );
		} );
	} );

	// Mobile hamburger.
	const hamburger  = $< HTMLButtonElement >( '[data-wp-on--click="actions.toggleMobile"]', header );
	const mobileNav  = $< HTMLElement >( '.jetpack-mobile-nav', header );
	const hamTop     = hamburger?.querySelector< HTMLElement >( 'span:first-child' );
	const hamBottom  = hamburger?.querySelector< HTMLElement >( 'span:last-child' );

	hamburger?.addEventListener( 'click', () => {
		const isOpen = mobileNav?.classList.contains( 'jetpack-mobile-open' );
		mobileNav?.classList.toggle( 'jetpack-mobile-open', ! isOpen );
		hamTop?.classList.toggle( 'jetpack-ham-top', ! isOpen );
		hamBottom?.classList.toggle( 'jetpack-ham-bottom', ! isOpen );
		hamburger.setAttribute( 'aria-expanded', String( ! isOpen ) );
	} );

	// Mobile sub-menus.
	$$< HTMLElement >( '[data-wp-on--click="actions.toggleSubMenu"]', header ).forEach( ( btn ) => {
		btn.addEventListener( 'click', () => {
			const panel = btn.nextElementSibling as HTMLElement | null;
			if ( ! panel ) return;
			const isOpen = panel.classList.contains( 'jetpack-submenu-open' );
			panel.classList.toggle( 'jetpack-submenu-open', ! isOpen );
			btn.setAttribute( 'aria-expanded', String( ! isOpen ) );
		} );
	} );

	// Close mobile nav on link clicks.
	$$< HTMLAnchorElement >( '[data-wp-on--click="actions.closeMobile"]', header ).forEach( ( a ) => {
		a.addEventListener( 'click', () => {
			mobileNav?.classList.remove( 'jetpack-mobile-open' );
			hamTop?.classList.remove( 'jetpack-ham-top' );
			hamBottom?.classList.remove( 'jetpack-ham-bottom' );
		} );
	} );
}

// ── Testimonials carousel ─────────────────────────────────────────────────────

function initTestimonials(): void {
	const section = $< HTMLElement >( '.jetpack-testimonials' );
	if ( ! section ) return;

	const ctx      = JSON.parse( section.dataset.wpContext ?? '{"activeIndex":0,"count":0}' ) as { activeIndex: number; count: number };
	let active     = ctx.activeIndex;
	const count    = ctx.count;
	const circ     = 2 * Math.PI * 48;
	let timer: ReturnType< typeof setInterval > | null = null;

	function activate( idx: number ): void {
		const prev = active;
		active     = ( idx + count ) % count;

		// Avatars.
		$$< HTMLElement >( '.jetpack-testimonial-avatar', section ).forEach( ( el ) => {
			const c = JSON.parse( el.dataset.wpContext ?? '{}' ) as { index: number };
			const isActive = c.index === active;
			el.style.transform = isActive ? 'scale(1.1)' : 'scale(0.9)';
			el.style.opacity   = isActive ? '1' : '0.6';
			el.setAttribute( 'aria-selected', String( isActive ) );
		} );

		// Quotes.
		$$< HTMLElement >( '.jetpack-quote', section ).forEach( ( el ) => {
			const i = parseInt( el.dataset.testimonialIndex ?? '-1', 10 );
			el.classList.toggle( 'active', i === active );
		} );

		// Logos.
		$$< HTMLElement >( '[data-testimonial-logo]', section ).forEach( ( el ) => {
			const i   = parseInt( el.dataset.testimonialLogo ?? '-1', 10 );
			const img = el.querySelector< HTMLImageElement >( 'img' );
			if ( img ) {
				img.classList.toggle( 'opacity-100', i === active );
				img.classList.toggle( 'opacity-30',  i !== active );
			}
		} );

		// Progress ring.
		$$< SVGCircleElement >( '.jetpack-progress-ring', section ).forEach( ( ring, i ) => {
			ring.style.transition    = 'none';
			ring.style.strokeDashoffset = String( circ );
			if ( i === active ) {
				requestAnimationFrame( () => {
					ring.style.transition       = `stroke-dashoffset 10s linear`;
					ring.style.strokeDashoffset = '0';
				} );
			}
		} );
	}

	// Initial state.
	activate( 0 );

	// Avatar click.
	$$< HTMLElement >( '.jetpack-testimonial-avatar', section ).forEach( ( el ) => {
		el.addEventListener( 'click', () => {
			const c = JSON.parse( el.dataset.wpContext ?? '{}' ) as { index: number };
			activate( c.index );
			if ( timer ) clearInterval( timer );
			startTimer();
		} );
	} );

	// Auto-advance.
	function startTimer(): void {
		timer = setInterval( () => activate( active + 1 ), 10_000 );
	}
	if ( count > 1 ) startTimer();
}

// ── Init ─────────────────────────────────────────────────────────────────────

document.addEventListener( 'DOMContentLoaded', () => {
	initHeader();
	initTestimonials();
} );
