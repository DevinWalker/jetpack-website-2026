import { useCallback, useEffect, useRef, useState } from 'react';
import { createRoot } from 'react-dom/client';
import gsap from 'gsap';
import { Shield, Zap, TrendingUp } from 'lucide-react';
import CardSwap, { Card } from '@/components/react-bits/CardSwap';

const mount = document.getElementById( 'jetpack-card-swap-mount' );
const THEME_URI = ( mount as HTMLElement | null )?.dataset.themeUri ?? '';
const SWAP_DELAY = 5000;

/* ── Circular countdown ring ─────────────────────────────────────────────── */

const RING_SIZE   = 28;
const RING_STROKE = 2;
const RING_R      = ( RING_SIZE - RING_STROKE ) / 2;
const RING_C      = 2 * Math.PI * RING_R;

function CircularTimer( { duration, paused, resetKey }: {
	duration: number;
	paused: boolean;
	resetKey: number;
} ) {
	const circleRef = useRef< SVGCircleElement >( null );
	const startRef  = useRef( 0 );
	const elapsed   = useRef( 0 );
	const rafRef    = useRef( 0 );

	useEffect( () => {
		elapsed.current  = 0;
		startRef.current = performance.now();

		const tick = ( now: number ) => {
			elapsed.current = Math.min( now - startRef.current, duration );
			const progress  = elapsed.current / duration;
			if ( circleRef.current ) {
				circleRef.current.style.strokeDashoffset = String( RING_C * ( 1 - progress ) );
			}
			if ( progress < 1 ) {
				rafRef.current = requestAnimationFrame( tick );
			}
		};

		rafRef.current = requestAnimationFrame( tick );
		return () => cancelAnimationFrame( rafRef.current );
	}, [ resetKey, duration ] );

	useEffect( () => {
		if ( paused ) {
			cancelAnimationFrame( rafRef.current );
		} else {
			if ( elapsed.current >= duration ) return;
			startRef.current = performance.now() - elapsed.current;

			const tick = ( now: number ) => {
				elapsed.current = Math.min( now - startRef.current, duration );
				const progress  = elapsed.current / duration;
				if ( circleRef.current ) {
					circleRef.current.style.strokeDashoffset = String( RING_C * ( 1 - progress ) );
				}
				if ( progress < 1 ) {
					rafRef.current = requestAnimationFrame( tick );
				}
			};

			rafRef.current = requestAnimationFrame( tick );
			return () => cancelAnimationFrame( rafRef.current );
		}
	}, [ paused, duration ] );

	return (
		<svg
			width={ 40 }
			height={ 40 }
			viewBox={ `0 0 ${ RING_SIZE } ${ RING_SIZE }` }
			className="absolute top-3 right-3 z-50 -rotate-90"
			aria-hidden="true"
			data-timer
		>
			<circle
				cx={ RING_SIZE / 2 }
				cy={ RING_SIZE / 2 }
				r={ RING_R }
				fill="none"
				stroke="red"
				strokeOpacity={ 0.5 }
				strokeWidth={ 3 }
			/>
			<circle
				ref={ circleRef }
				cx={ RING_SIZE / 2 }
				cy={ RING_SIZE / 2 }
				r={ RING_R }
				fill="none"
				stroke="lime"
				strokeOpacity={ 1 }
				strokeWidth={ 3 }
				strokeDasharray={ RING_C }
				strokeDashoffset={ RING_C }
				strokeLinecap="round"
			/>
		</svg>
	);
}

interface PillarCard {
	pillLabel: string;
	pillColor: string;
	pillBg: string;
	PillIcon: typeof Shield;
	headline: string;
	body: string;
}

const CARDS: PillarCard[] = [
	{
		pillLabel: 'Security & Backups',
		pillColor: 'text-emerald-400',
		pillBg:    'bg-emerald-500/20',
		PillIcon:  Shield,
		headline: 'Protected around the clock.',
		body:     'Real-time malware scanning, automated backups, and one-click restores keep your site safe — without lifting a finger.',
	},
	{
		pillLabel: 'Speed & Performance',
		pillColor: 'text-sky-400',
		pillBg:    'bg-sky-500/20',
		PillIcon:  Zap,
		headline: 'Lightning-fast, every time.',
		body:     'Automatic image optimisation, a global CDN, and built-in caching make every page load faster for every visitor.',
	},
	{
		pillLabel: 'Growth & Traffic',
		pillColor: 'text-violet-400',
		pillBg:    'bg-violet-500/20',
		PillIcon:  TrendingUp,
		headline: 'Grow your audience, effortlessly.',
		body:     'Auto-share to every social network, boost posts to millions of WordPress.com readers, and climb search rankings with built-in SEO tools.',
	},
];

function HeroCards() {
	const textRefs   = useRef< ( HTMLDivElement | null )[] >( [ null, null, null ] );
	const wrapperRef = useRef< HTMLDivElement >( null );

	const [ paused, setPaused ]     = useState( false );
	const [ resetKey, setResetKey ] = useState( 0 );
	const hovered = useRef( false );
	const inView  = useRef( true );

	const resolvePause = useCallback( () => {
		setPaused( hovered.current || ! inView.current );
	}, [] );

	useEffect( () => {
		const node = wrapperRef.current;
		if ( ! node ) return;

		const onEnter = () => { hovered.current = true;  resolvePause(); };
		const onLeave = () => { hovered.current = false; resolvePause(); };
		node.addEventListener( 'mouseenter', onEnter );
		node.addEventListener( 'mouseleave', onLeave );

		const io = new IntersectionObserver(
			( [ entry ] ) => { inView.current = entry.isIntersecting; resolvePause(); },
			{ threshold: 0.3 },
		);
		io.observe( node );

		return () => {
			node.removeEventListener( 'mouseenter', onEnter );
			node.removeEventListener( 'mouseleave', onLeave );
			io.disconnect();
		};
	}, [ resolvePause ] );

	useEffect( () => {
		const el = textRefs.current[ 0 ];
		if ( el ) {
			gsap.to( el, { opacity: 1, duration: 0.7, delay: 0, ease: 'power2.out' } );
		}
		const timer = wrapperRef.current?.querySelector< SVGElement >( '[data-timer]' );
		if ( timer ) {
			gsap.to( timer, { opacity: 1, duration: 0.6, delay: 0.3, ease: 'power2.out' } );
		}
	}, [] );

	const handleSwap = useCallback( ( frontIndex: number ) => {
		setResetKey( ( k ) => k + 1 );
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
		<div ref={ wrapperRef } className="relative w-full h-full">
			<CircularTimer duration={ SWAP_DELAY } paused={ paused } resetKey={ resetKey } />
			<CardSwap
				width="100%"
				height={ 560 }
				cardDistance={ 0 }
				verticalDistance={ 80 }
				zDistance={ 150 }
				delay={ SWAP_DELAY }
				paused={ paused }
				skewAmount={ 0 }
				easing="elastic"
				onSwap={ handleSwap }
				containerClassName="absolute bottom-0 left-0 right-0 perspective-[900px] overflow-visible origin-bottom max-[768px]:scale-[0.75] max-[480px]:scale-[0.55]"
			>
				{ CARDS.map( ( card, i ) => (
					<Card key={ i } className="bg-transparent overflow-hidden p-0">
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

						<div
							ref={ ( el ) => { textRefs.current[ i ] = el; } }
							className="absolute top-8 right-4 max-w-sm px-4 py-3.5 rounded-xl bg-neutral-950/75 flex flex-col gap-2 shadow-lg"
							style={ { opacity: 0 } }
						>
						<div className={ `self-start inline-flex items-center gap-1 ${ card.pillBg } ${ card.pillColor } text-[10px] font-semibold px-2 py-0.5 rounded-md` }>
							<card.PillIcon className="w-3.5 h-3.5 shrink-0" strokeWidth={ 2.5 } aria-hidden="true" />
							{ card.pillLabel }
						</div>

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
		</div>
	);
}

if ( mount ) {
	createRoot( mount ).render( <HeroCards /> );
}
