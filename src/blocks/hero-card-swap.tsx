import { useCallback, useEffect, useRef, type ReactNode } from 'react';
import { createRoot } from 'react-dom/client';
import gsap from 'gsap';
import CardSwap, { Card } from '@/components/react-bits/CardSwap';

const mount = document.getElementById( 'jetpack-card-swap-mount' );
const THEME_URI = ( mount as HTMLElement | null )?.dataset.themeUri ?? '';

interface PillarCard {
	pillLabel: string;
	pillColor: string;
	pillBg: string;
	pillIcon: ReactNode;
	headline: string;
	body: string;
}

const CARDS: PillarCard[] = [
	{
		pillLabel: 'Security & Backups',
		pillColor: 'text-emerald-400',
		pillBg:    'bg-emerald-500/20',
		pillIcon: (
			<svg className="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" aria-hidden="true">
				<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
			</svg>
		),
		headline: 'Protected around the clock.',
		body:     'Real-time malware scanning, automated backups, and one-click restores keep your site safe — without lifting a finger.',
	},
	{
		pillLabel: 'Speed & Performance',
		pillColor: 'text-sky-400',
		pillBg:    'bg-sky-500/20',
		pillIcon: (
			<svg className="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" aria-hidden="true">
				<path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
			</svg>
		),
		headline: 'Lightning-fast, every time.',
		body:     'Automatic image optimisation, a global CDN, and built-in caching make every page load faster for every visitor.',
	},
	{
		pillLabel: 'Growth & Traffic',
		pillColor: 'text-violet-400',
		pillBg:    'bg-violet-500/20',
		pillIcon: (
			<svg className="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" aria-hidden="true">
				<path d="M4 12v8a2 2 0 002 2h12a2 2 0 002-2v-8M16 6l-4-4-4 4M12 2v13"/>
			</svg>
		),
		headline: 'Grow your audience, effortlessly.',
		body:     'Auto-share to every social network, boost posts to millions of WordPress.com readers, and climb search rankings with built-in SEO tools.',
	},
];

function HeroCards() {
	const textRefs = useRef< ( HTMLDivElement | null )[] >( [ null, null, null ] );

	// Fade in card 0's text after the hero entrance animation completes (~1.6s).
	useEffect( () => {
		const el = textRefs.current[ 0 ];
		if ( el ) {
			gsap.to( el, { opacity: 1, duration: 0.7, delay: 1.8, ease: 'power2.out' } );
		}
	}, [] );

	const handleSwap = useCallback( ( frontIndex: number ) => {
		textRefs.current.forEach( ( el, i ) => {
			if ( ! el ) return;
			if ( i === frontIndex ) {
				gsap.to( el, { opacity: 1, duration: 0.7, delay: 0.1, ease: 'power2.out' } );
			} else {
				gsap.to( el, { opacity: 0, duration: 0.25, ease: 'power2.in' } );
			}
		} );
	}, [] );

	return (
		<CardSwap
			width="100%"
			height={ 560 }
			cardDistance={ 0 }
			verticalDistance={ 80 }
			zDistance={ 150 }
			delay={ 5000 }
			pauseOnHover={ false }
			skewAmount={ 0 }
			easing="elastic"
			onSwap={ handleSwap }
			containerClassName="absolute bottom-0 left-0 right-0 perspective-[900px] overflow-visible origin-bottom max-[768px]:scale-[0.75] max-[480px]:scale-[0.55]"
		>
			{ CARDS.map( ( card, i ) => (
				<Card key={ i } className="bg-transparent border-transparent overflow-hidden p-0">
					{ /* Full-bleed placeholder image — fades at bottom via mask, matching main branch */ }
					<img
						src={ `${ THEME_URI }/assets/jetpack-paid-traffic.png` }
						alt=""
						aria-hidden="true"
						className="absolute inset-0 w-full h-full object-cover object-top"
						loading={ i === 0 ? 'eager' : 'lazy' }
						decoding="async"
						style={ {
							maskImage:       'linear-gradient(to bottom, black 55%, transparent 100%)',
							WebkitMaskImage: 'linear-gradient(to bottom, black 55%, transparent 100%)',
						} }
					/>

					{ /* Toast — opacity-0 until card is promoted to front */ }
					<div
						ref={ ( el ) => { textRefs.current[ i ] = el; } }
						className="absolute top-10 left-8 max-w-xs px-4 py-3.5 rounded-xl bg-neutral-950/90 flex flex-col gap-2 shadow-lg"
						style={ { opacity: 0 } }
					>
						{ /* Pill */ }
						<div className={ `self-start inline-flex items-center gap-1 ${ card.pillBg } ${ card.pillColor } text-[10px] font-semibold px-2 py-0.5 rounded-md` }>
							{ card.pillIcon }
							{ card.pillLabel }
						</div>

						{ /* Text */ }
						<div>
							<p className="text-white text-sm font-semibold leading-tight mb-1">
								{ card.headline }
							</p>
							<p className="text-neutral-400 text-xs leading-snug">
								{ card.body }
							</p>
						</div>
					</div>
				</Card>
			) ) }
		</CardSwap>
	);
}

if ( mount ) {
	createRoot( mount ).render( <HeroCards /> );
}
