/**
 * Features Highlights view script.
 *
 * Mounts BlurHighlight on section headings and AnimatedList on benefit lists.
 * Follows the same createRoot pattern as hero-card-swap.tsx.
 */
import React from 'react';
import { createRoot } from 'react-dom/client';
import { BlurHighlight } from '@/components/react-bits/blur-highlight';
import AnimatedList from '@/components/react-bits/animated-list';
import type { AnimatedListItem } from '@/components/react-bits/animated-list';

interface BenefitData {
	text: string;
	linkText: string;
	linkUrl: string;
}

// ── Mount BlurHighlight on headings ────────────────────────────────────────────

document.querySelectorAll< HTMLElement >( '[data-fh-heading]' ).forEach( ( el ) => {
	const text = el.dataset.fhHeading ?? '';
	const highlight = el.dataset.fhHighlight ?? '';
	const className = el.className;

	el.className = '';
	el.removeAttribute( 'data-fh-heading' );
	el.removeAttribute( 'data-fh-highlight' );

	createRoot( el ).render(
		<BlurHighlight
			highlightedBits={ highlight ? [ highlight ] : [] }
			highlightColor="hsl(var(--accent) / 0.2)"
			blurAmount={ 8 }
			blurDuration={ 0.8 }
			highlightDelay={ 0.6 }
			highlightDuration={ 1.2 }
			highlightDirection="left"
			viewportOptions={ { once: true, amount: 0.3 } }
			className={ className }
		>
			{ text }
		</BlurHighlight>
	);
} );

// ── Mount AnimatedList on benefits ─────────────────────────────────────────────

document.querySelectorAll< HTMLElement >( '[data-fh-benefits]' ).forEach( ( el ) => {
	let benefits: BenefitData[] = [];
	try {
		benefits = JSON.parse( el.dataset.fhBenefits ?? '[]' );
	} catch {
		return;
	}

	if ( benefits.length === 0 ) return;

	const items: AnimatedListItem[] = benefits.map( ( b, i ) => ( {
		id: i,
		content: (
			<span className="flex items-start gap-3 text-foreground">
				<svg className="w-5 h-5 mt-0.5 shrink-0 text-accent" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
					<path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd"/>
				</svg>
				<span>
					{ b.text }{ ' ' }
					<a href={ b.linkUrl } className="font-semibold text-accent hover:underline">
						{ b.linkText }
					</a>
				</span>
			</span>
		),
	} ) );

	const parent = el.parentElement;
	if ( ! parent ) return;

	el.className = '';
	el.removeAttribute( 'data-fh-benefits' );

	createRoot( el ).render(
		<AnimatedList
			items={ items }
			autoAddDelay={ 0 }
			maxItems={ items.length }
			startFrom="top"
			animationType="blur"
			enterFrom="bottom"
			fadeEdges={ false }
			hoverEffect="none"
			clickEffect="none"
			swipeToDismiss={ false }
			itemGap={ 12 }
			height="auto"
			className="overflow-visible!"
			itemClassName="relative"
			renderItem={ ( item ) => (
				<div className="text-foreground">{ item.content }</div>
			) }
		/>
	);
} );
