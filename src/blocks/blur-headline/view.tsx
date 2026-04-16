/**
 * Blur-Headline view script.
 *
 * Replicates the exact word-by-word scroll-driven blur reveal from
 * the original blur-in-headline.tsx in the Next.js source app.
 *
 * Each word is server-rendered as <span class="jetpack-blur-word">.
 * As the section scrolls into view, words reveal sequentially:
 *   - opacity animates from 0.15 → 1
 *   - filter animates from blur(8px) → blur(0)
 *
 * The reveal starts when the section top is at 90% of viewport height
 * and completes when the section top reaches 25% of viewport height.
 */

function initBlurHeadline( section: HTMLElement ): void {
	const words = Array.from( section.querySelectorAll< HTMLElement >( '.jetpack-blur-word' ) );
	if ( words.length === 0 ) return;

	let ticking = false;

	const update = (): void => {
		const rect       = section.getBoundingClientRect();
		const wh         = window.innerHeight;
		const startOff   = wh * 0.9;
		const endOff     = wh * 0.25;
		const progress   = Math.min( 1, Math.max( 0, ( startOff - rect.top ) / ( startOff - endOff ) ) );

		words.forEach( ( word, index ) => {
			const wordStart   = index / words.length;
			const wordEnd     = wordStart + 1 / words.length;
			const wordProgress = Math.min( 1, Math.max( 0, ( progress - wordStart ) / ( wordEnd - wordStart ) ) );

			word.style.opacity = String( 0.15 + wordProgress * 0.85 );
			word.style.filter  = `blur(${ ( 1 - wordProgress ) * 8 }px)`;
		} );
	};

	const onScroll = (): void => {
		if ( ticking ) return;
		ticking = true;
		requestAnimationFrame( () => {
			update();
			ticking = false;
		} );
	};

	window.addEventListener( 'scroll', onScroll, { passive: true } );
	update(); // set initial state immediately
}

document.querySelectorAll< HTMLElement >( '.jetpack-blur-headline' ).forEach( initBlurHeadline );
