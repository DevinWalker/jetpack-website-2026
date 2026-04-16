import './style.css';

/**
 * FAQ view script — handles accordion open/close.
 * Reads per-item context from data-wp-context attributes.
 * CSS max-height transition (via .jetpack-faq-open) provides the animation.
 */

function initFAQ(): void {
	const section = document.querySelector< HTMLElement >( '.jetpack-faq' );
	if ( ! section ) return;

	const items = Array.from( section.querySelectorAll< HTMLElement >( '.jetpack-faq-item' ) );
	let openIndex = 0;

	function setOpen( idx: number ): void {
		items.forEach( ( item ) => {
			const ctx = JSON.parse( item.dataset.wpContext ?? '{}' ) as { index: number };
			const answer = item.querySelector< HTMLElement >( '.jetpack-faq-answer' );
			const icon = item.querySelector< HTMLElement >( 'span[aria-hidden]' );
			const isOpen = ctx.index === idx;

			item.setAttribute( 'aria-expanded', String( isOpen ) );
			if ( answer ) answer.classList.toggle( 'jetpack-faq-open', isOpen );
			if ( icon ) icon.classList.toggle( 'rotate-180', isOpen );
		} );
		openIndex = idx;
	}

	setOpen( 0 );

	items.forEach( ( item ) => {
		const toggle = () => {
			const ctx = JSON.parse( item.dataset.wpContext ?? '{}' ) as { index: number };
			setOpen( openIndex === ctx.index ? -1 : ctx.index );
		};
		item.addEventListener( 'click', toggle );
		item.addEventListener( 'keydown', ( e: KeyboardEvent ) => {
			if ( e.key === 'Enter' || e.key === ' ' ) {
				e.preventDefault();
				toggle();
			}
		} );
	} );
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', initFAQ );
} else {
	initFAQ();
}
