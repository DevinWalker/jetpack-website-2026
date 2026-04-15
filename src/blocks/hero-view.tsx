/**
 * Hero view script — mounts React Bits Pro components into the hero block.
 *
 * StaggeredText: Replaces the server-rendered h1 with an animated version
 */
import { createRoot } from 'react-dom/client';
import StaggeredText from '@/components/react-bits/staggered-text';

// ── Mount StaggeredText on the hero headline ──────────────────────────────────

document.querySelectorAll< HTMLElement >( '.jetpack-hero__headline' ).forEach( ( el ) => {
	// Read the text content that PHP rendered.
	const line1Text   = el.childNodes[ 0 ]?.textContent?.trim() ?? '';
	const accentSpan  = el.querySelector< HTMLElement >( '.jetpack-hero__accent' );
	const accentText  = accentSpan?.textContent?.trim() ?? '';

	if ( ! line1Text ) return;

	// Clear the existing DOM content and mount animated version.
	el.innerHTML = '';
	el.style.opacity = '1';
	el.style.filter  = 'none';
	el.style.transform = 'none';

	const wrapper = document.createElement( 'span' );
	wrapper.className = 'block';
	el.appendChild( wrapper );

	createRoot( wrapper ).render(
		<StaggeredText
			text={ line1Text }
			as="span"
			segmentBy="words"
			delay={ 80 }
			duration={ 0.7 }
			direction="top"
			blur={ true }
			className="block text-black"
		/>
	);

	if ( accentText ) {
		const accentWrapper = document.createElement( 'span' );
		accentWrapper.className = 'block text-accent';
		el.appendChild( accentWrapper );

		createRoot( accentWrapper ).render(
			<StaggeredText
				text={ accentText }
				as="span"
				segmentBy="words"
				delay={ 100 }
				duration={ 0.7 }
				direction="top"
				blur={ true }
				className="block text-accent"
			/>
		);
	}
} );

// ── Animate remaining hero elements ──────────────────────────────────────────
// Badge, body, CTA, dashboard, logos use CSS transitions via rAF.

const EASE = 'cubic-bezier(0.23, 1, 0.32, 1)';

function fadeIn( el: HTMLElement | null, delay: number, extras = '' ): void {
	if ( ! el ) return;
	el.style.transition = `opacity 0.8s ${ EASE } ${ delay }s, transform 0.8s ${ EASE } ${ delay }s${ extras ? ', ' + extras : '' }`;
	el.style.opacity    = '1';
	el.style.transform  = 'translateY(0) scale(1)';
	el.style.filter     = 'blur(0px)';
}

requestAnimationFrame( () => {
	const hero = document.querySelector< HTMLElement >( '.jetpack-hero' );
	if ( ! hero ) return;

	const badge     = hero.querySelector< HTMLElement >( '.jetpack-hero__badge' );
	const body      = hero.querySelector< HTMLElement >( '.jetpack-hero__body' );
	const cta       = hero.querySelector< HTMLElement >( '.jetpack-hero__cta' );
	const dashboard = hero.querySelector< HTMLElement >( '.jetpack-hero__dashboard' );
	const logos     = hero.querySelector< HTMLElement >( '.jetpack-hero__logos' );

	if ( badge )     { badge.style.filter     = 'blur(8px)'; fadeIn( badge,     0.2 ); }
	if ( body )      { body.style.filter      = 'blur(8px)'; fadeIn( body,      0.5 ); }
	if ( cta )       fadeIn( cta,       0.65 );
	if ( dashboard ) fadeIn( dashboard, 0.8 );
	if ( logos )     fadeIn( logos,     1.0 );
} );
