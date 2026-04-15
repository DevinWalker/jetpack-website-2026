/**
 * Features Highlights view script.
 *
 * Mounts scroll-triggered animations on each section:
 *   - Eyebrow: blur fade-in
 *   - Heading: BlurHighlight with keyword highlight
 *   - Description: blur fade-in
 *   - Benefits: staggered blur fade-in per item
 *   - CTA: fade-in scale
 */
import React, { useRef } from 'react';
import { createRoot } from 'react-dom/client';
import { motion, useInView } from 'motion/react';
import { BlurHighlight } from '@/components/react-bits/blur-highlight';

interface BenefitData {
	text: string;
	linkText: string;
	linkUrl: string;
}

// ── Staggered benefits list ────────────────────────────────────────────────────

function BenefitsList( { benefits }: { benefits: BenefitData[] } ) {
	const ref = useRef< HTMLUListElement >( null );
	const inView = useInView( ref, { once: true, amount: 0.2 } );

	return (
		<ul ref={ ref } className="flex flex-col gap-4 mb-10">
			{ benefits.map( ( b, i ) => (
				<motion.li
					key={ i }
					className="flex items-start gap-3"
					initial={ { opacity: 0, y: 12, filter: 'blur(4px)' } }
					animate={ inView
						? { opacity: 1, y: 0, filter: 'blur(0px)' }
						: { opacity: 0, y: 12, filter: 'blur(4px)' }
					}
					transition={ {
						duration: 0.5,
						delay: i * 0.15,
						ease: [ 0.25, 0.1, 0.25, 1 ],
					} }
				>
					<span className="mt-1.5 shrink-0 w-5 h-5 rounded-full bg-neutral-200 flex items-center justify-center">
						<svg className="w-3 h-3 text-neutral-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">
							<polyline points="20 6 9 17 4 12"/>
						</svg>
					</span>
					<span className="text-base md:text-lg leading-normal text-neutral-600">
						{ b.text }
						<a
							href={ b.linkUrl }
							className="inline-flex items-center ml-1 px-2.5 py-0.5 rounded-full bg-accent/15 text-accent font-semibold text-sm md:text-[0.9375rem] hover:bg-accent/25 transition-colors"
						>
							{ b.linkText }
						</a>
					</span>
				</motion.li>
			) ) }
		</ul>
	);
}

// ── Simple scroll-triggered blur-in wrapper ────────────────────────────────────

function BlurIn( {
	children,
	className,
	delay = 0,
}: {
	children: React.ReactNode;
	className?: string;
	delay?: number;
} ) {
	const ref = useRef< HTMLDivElement >( null );
	const inView = useInView( ref, { once: true, amount: 0.3 } );

	return (
		<motion.div
			ref={ ref }
			className={ className }
			initial={ { opacity: 0, filter: 'blur(6px)', y: 8 } }
			animate={ inView
				? { opacity: 1, filter: 'blur(0px)', y: 0 }
				: { opacity: 0, filter: 'blur(6px)', y: 8 }
			}
			transition={ {
				duration: 0.6,
				delay,
				ease: [ 0.25, 0.1, 0.25, 1 ],
			} }
		>
			{ children }
		</motion.div>
	);
}

// ── Mount animations on each section ───────────────────────────────────────────

document.querySelectorAll< HTMLElement >( '.jetpack-fh-section' ).forEach( ( section ) => {
	// ── Eyebrow ──
	const eyebrow = section.querySelector< HTMLElement >( '.text-accent.uppercase' );
	if ( eyebrow ) {
		const text = eyebrow.textContent ?? '';
		const classes = eyebrow.className;
		const wrapper = document.createElement( 'div' );
		eyebrow.replaceWith( wrapper );
		createRoot( wrapper ).render(
			<BlurIn className={ classes } delay={ 0 }>{ text }</BlurIn>
		);
	}

	// ── Heading ──
	const heading = section.querySelector< HTMLElement >( '[data-fh-heading]' );
	if ( heading ) {
		const text = heading.dataset.fhHeading ?? '';
		const highlight = heading.dataset.fhHighlight ?? '';
		const classes = heading.className;

		heading.className = '';
		heading.removeAttribute( 'data-fh-heading' );
		heading.removeAttribute( 'data-fh-highlight' );

		createRoot( heading ).render(
			<BlurHighlight
				highlightedBits={ highlight ? [ highlight ] : [] }
				highlightColor="hsl(var(--accent) / 0.2)"
				blurAmount={ 8 }
				blurDuration={ 0.7 }
				blurDelay={ 0.1 }
				highlightDelay={ 0.5 }
				highlightDuration={ 1 }
				highlightDirection="left"
				viewportOptions={ { once: true, amount: 0.3 } }
				className={ classes }
			>
				{ text }
			</BlurHighlight>
		);
	}

	// ── Description ──
	const desc = section.querySelector< HTMLElement >( 'p.text-neutral-500' );
	if ( desc ) {
		const html = desc.innerHTML;
		const classes = desc.className;
		const wrapper = document.createElement( 'div' );
		desc.replaceWith( wrapper );
		createRoot( wrapper ).render(
			<BlurIn className={ classes } delay={ 0.2 }>
				<span dangerouslySetInnerHTML={ { __html: html } } />
			</BlurIn>
		);
	}

	// ── Benefits ──
	const list = section.querySelector< HTMLElement >( '[data-fh-benefits]' );
	if ( list ) {
		let benefits: BenefitData[] = [];
		try {
			benefits = JSON.parse( list.dataset.fhBenefits ?? '[]' );
		} catch {
			return;
		}
		if ( benefits.length === 0 ) return;

		list.removeAttribute( 'data-fh-benefits' );
		list.className = '';
		createRoot( list ).render( <BenefitsList benefits={ benefits } /> );
	}

	// ── CTA ──
	const cta = section.querySelector< HTMLElement >( 'a[class*="bg-foreground"]' );
	if ( cta ) {
		const ctaHtml = cta.outerHTML;
		const wrapper = document.createElement( 'div' );
		cta.parentElement?.replaceChild( wrapper, cta );
		createRoot( wrapper ).render(
			<BlurIn delay={ 0.4 }>
				<span dangerouslySetInnerHTML={ { __html: ctaHtml } } />
			</BlurIn>
		);
	}
} );
