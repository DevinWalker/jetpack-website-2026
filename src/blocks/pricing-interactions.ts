/**
 * Pricing view script — handles the billing-cycle toggle on the pricing-table
 * block and the category tabs on the pricing-comparison block.
 *
 * Vanilla DOM manipulation to match the theme's existing pattern (see
 * site-header/interactions.ts, faq/store.ts). The `data-wp-interactive` /
 * `data-wp-context` attributes in render.php are hints for future Interactivity
 * API migration; the runtime toggle is driven by the code below.
 *
 * Loaded via blocks/pricing-table/block.json `viewScript` and
 * blocks/pricing-comparison/block.json `viewScript` (same built file).
 */

type Cycle = 'monthly' | 'yearly' | 'biyearly';
type Category = 'security' | 'performance' | 'growth' | 'management';

// ── Pricing table: billing-cycle toggle ─────────────────────────────────────

function initPricingTable(): void {
	const section = document.querySelector< HTMLElement >( '.jetpack-pricing-table' );
	if ( ! section ) return;

	const defaultCycle = ( section.dataset.defaultCycle as Cycle | undefined ) ?? 'yearly';
	const buttons      = Array.from( section.querySelectorAll< HTMLButtonElement >( '.jetpack-cycle-toggle__btn' ) );
	const priceCells   = Array.from( section.querySelectorAll< HTMLElement >( '.jetpack-price-cell' ) );

	if ( buttons.length === 0 || priceCells.length === 0 ) return;

	function setCycle( cycle: Cycle ): void {
		buttons.forEach( ( btn ) => {
			const isActive = btn.dataset.cycle === cycle;
			btn.setAttribute( 'aria-selected', String( isActive ) );
			btn.classList.toggle( 'bg-jetpack-green-50', isActive );
			btn.classList.toggle( 'text-white', isActive );
			btn.classList.toggle( 'shadow-sm', isActive );
			btn.classList.toggle( 'text-muted-foreground', ! isActive );
			btn.classList.toggle( 'hover:text-foreground', ! isActive );
		} );
		priceCells.forEach( ( cell ) => {
			const matches = cell.dataset.cycle === cycle;
			cell.classList.toggle( 'hidden', ! matches );
			if ( matches ) {
				cell.removeAttribute( 'hidden' );
			} else {
				cell.setAttribute( 'hidden', '' );
			}
		} );
	}

	setCycle( defaultCycle );

	buttons.forEach( ( btn ) => {
		btn.addEventListener( 'click', () => {
			const next = btn.dataset.cycle as Cycle | undefined;
			if ( next ) setCycle( next );
		} );
	} );
}

// ── Pricing comparison: category tabs ───────────────────────────────────────

function initPricingComparison(): void {
	const section = document.querySelector< HTMLElement >( '.jetpack-pricing-comparison' );
	if ( ! section ) return;

	const defaultCategory = ( section.dataset.defaultCategory as Category | undefined ) ?? 'security';
	const buttons = Array.from( section.querySelectorAll< HTMLButtonElement >( '.jetpack-category-tabs__btn' ) );
	const panels  = Array.from( section.querySelectorAll< HTMLElement >( '.jetpack-category-panel' ) );

	if ( buttons.length === 0 || panels.length === 0 ) return;

	const activeClasses   = [ 'border-jetpack-green-50', 'bg-jetpack-green-50', 'text-white' ];
	const inactiveClasses = [ 'border-border', 'bg-frame', 'text-foreground', 'hover:bg-muted' ];

	function setCategory( category: Category ): void {
		buttons.forEach( ( btn ) => {
			const isActive = btn.dataset.category === category;
			btn.setAttribute( 'aria-selected', String( isActive ) );
			activeClasses.forEach( ( cls ) => btn.classList.toggle( cls, isActive ) );
			inactiveClasses.forEach( ( cls ) => btn.classList.toggle( cls, ! isActive ) );
		} );
		panels.forEach( ( panel ) => {
			const matches = panel.dataset.category === category;
			panel.classList.toggle( 'hidden', ! matches );
			if ( matches ) {
				panel.removeAttribute( 'hidden' );
			} else {
				panel.setAttribute( 'hidden', '' );
			}
		} );
	}

	setCategory( defaultCategory );

	buttons.forEach( ( btn ) => {
		btn.addEventListener( 'click', () => {
			const next = btn.dataset.category as Category | undefined;
			if ( next ) setCategory( next );
		} );
	} );
}

// ── Init ────────────────────────────────────────────────────────────────────

function init(): void {
	initPricingTable();
	initPricingComparison();
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', init );
} else {
	init();
}
