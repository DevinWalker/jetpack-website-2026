/**
 * Pricing Hero view script — mounts the Aurora Blur WebGL effect into
 * any `[data-aurora-mount]` element, gated by:
 *   1. `prefers-reduced-motion: reduce` → skip entirely, leave the static
 *      green-tinted gradient fallback in place.
 *   2. IntersectionObserver → only instantiate once the hero is in viewport,
 *      so users who deep-link below the hero don't pay the WebGL cost.
 *
 * Mount pattern mirrors the existing hero block's FuzzyText mount in
 * src/blocks/hero/view.tsx.
 */

import { createElement, StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import AuroraBlur from '@/components/react-bits/AuroraBlur';

// Jetpack-green aurora palette — bumped saturation + intensity so the greens
// read clearly in the hero band instead of washing out to grey-pink noise.
const JETPACK_AURORA_LAYERS = [
	{ color: '#22c55e', speed: 0.25, intensity: 0.6 },
	{ color: '#16a34a', speed: 0.12, intensity: 0.5 },
	{ color: '#4ade80', speed: 0.18, intensity: 0.35 },
	{ color: '#069e08', speed: 0.08, intensity: 0.25 },
];

const JETPACK_AURORA_SKY = [
	{ color: '#f0f6e8', blend: 0.55 },
	{ color: '#ffffff', blend: 0.55 },
];

function mountAurora( host: HTMLElement ): void {
	createRoot( host ).render(
		createElement(
			StrictMode,
			null,
			createElement( AuroraBlur, {
				layers:         JETPACK_AURORA_LAYERS,
				skyLayers:      JETPACK_AURORA_SKY,
				speed:          0.6,
				noiseScale:     2.5,
				movementX:      -1,
				movementY:      -1.5,
				verticalFade:   0.85,
				bloomIntensity: 1.4,
				brightness:     0.95,
				saturation:     1.1,
				opacity:        0.55,
			} )
		)
	);

	// Cross-fade the mount container in once WebGL is ready.
	requestAnimationFrame( () => {
		host.classList.remove( 'opacity-0' );
		host.classList.add( 'opacity-100' );
	} );
}

function init(): void {
	const mounts = Array.from(
		document.querySelectorAll< HTMLElement >( '[data-aurora-mount]' )
	);
	if ( mounts.length === 0 ) {
		return;
	}

	// Respect user preference — skip mount entirely, leave static gradient.
	if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	if ( typeof IntersectionObserver === 'undefined' ) {
		mounts.forEach( mountAurora );
		return;
	}

	const observer = new IntersectionObserver(
		( entries, obs ) => {
			entries.forEach( ( entry ) => {
				if ( ! entry.isIntersecting ) return;
				const el = entry.target as HTMLElement;
				obs.unobserve( el );
				mountAurora( el );
			} );
		},
		{ rootMargin: '100px' }
	);

	mounts.forEach( ( m ) => observer.observe( m ) );
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', init );
} else {
	init();
}
