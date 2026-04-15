/**
 * Interactions — vanilla TypeScript handling site-wide UI behaviors.
 * Loaded globally on every page. No framework dependencies.
 *
 * Handles:
 *   - Header entrance animation + dropdown hover + mobile menu
 *
 * Note: FAQ and Testimonials have dedicated per-block view scripts.
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

// ── Init ─────────────────────────────────────────────────────────────────────

document.addEventListener( 'DOMContentLoaded', () => {
	initHeader();
} );
