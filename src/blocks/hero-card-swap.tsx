import { useCallback, useEffect, useRef, useState } from 'react';
import { createRoot } from 'react-dom/client';
import gsap from 'gsap';
import { Shield, Zap, TrendingUp } from 'lucide-react';
import CardSwap, { Card } from '@/components/react-bits/CardSwap';

const mount = document.getElementById( 'jetpack-card-swap-mount' );
const THEME_URI = ( mount as HTMLElement | null )?.dataset.themeUri ?? '';
const SWAP_DELAY = 5000;

interface PillarCard {
	pillLabel: string;
	pillColor: string;
	pillBg: string;
	barBg: string;
	PillIcon: typeof Shield;
	headline: string;
	body: string;
}

const CARDS: PillarCard[] = [
	{
		pillLabel: 'Security & Backups',
		pillColor: 'text-emerald-400',
		pillBg:    'bg-emerald-500/20',
		barBg:     'bg-emerald-400',
		PillIcon:  Shield,
		headline: 'Protected around the clock.',
		body:     'Real-time malware scanning, automated backups, and one-click restores keep your site safe — without lifting a finger.',
	},
	{
		pillLabel: 'Speed & Performance',
		pillColor: 'text-sky-400',
		pillBg:    'bg-sky-500/20',
		barBg:     'bg-sky-400',
		PillIcon:  Zap,
		headline: 'Lightning-fast, every time.',
		body:     'Automatic image optimisation, a global CDN, and built-in caching make every page load faster for every visitor.',
	},
	{
		pillLabel: 'Growth & Traffic',
		pillColor: 'text-violet-400',
		pillBg:    'bg-violet-500/20',
		barBg:     'bg-violet-400',
		PillIcon:  TrendingUp,
		headline: 'Grow your audience, effortlessly.',
		body:     'Auto-share to every social network, boost posts to millions of WordPress.com readers, and climb search rankings with built-in SEO tools.',
	},
];

function HeroCards() {
	const textRefs   = useRef< ( HTMLDivElement | null )[] >( [ null, null, null ] );
	const barRefs    = useRef< ( HTMLDivElement | null )[] >( [ null, null, null ] );
	const barTween   = useRef< gsap.core.Tween | null >( null );
	const wrapperRef = useRef< HTMLDivElement >( null );

	const [ paused, setPaused ] = useState( false );
	const hovered = useRef( false );
	const inView  = useRef( true );

	const resolvePause = useCallback( () => {
		setPaused( hovered.current || ! inView.current );
	}, [] );

	const startBar = useCallback( ( index: number ) => {
		barTween.current?.kill();
		barRefs.current.forEach( ( el ) => {
			if ( el ) gsap.set( el, { scaleX: 0 } );
		} );
		const bar = barRefs.current[ index ];
		if ( bar ) {
			gsap.set( bar, { scaleX: 1 } );
			barTween.current = gsap.to( bar, {
				scaleX: 0,
				duration: SWAP_DELAY / 1000,
				ease: 'none',
			} );
		}
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
		startBar( 0 );
	}, [ startBar ] );

	useEffect( () => {
		if ( paused ) {
			barTween.current?.pause();
		} else {
			barTween.current?.resume();
		}
	}, [ paused ] );

	const handleSwap = useCallback( ( frontIndex: number ) => {
		startBar( frontIndex );
		textRefs.current.forEach( ( el, i ) => {
			if ( ! el ) return;
			if ( i === frontIndex ) {
				gsap.to( el, { opacity: 1, duration: 0.4, delay: 0.35, ease: 'power2.out' } );
			} else {
				gsap.to( el, { opacity: 0, duration: 0.25, ease: 'power2.in' } );
			}
		} );
	}, [ startBar ] );

	return (
		<div ref={ wrapperRef } className="relative w-full h-full">
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
				containerClassName="absolute bottom-0 left-0 right-0 perspective-[900px] overflow-visible origin-bottom"
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
							className="absolute top-8 left-1/2 -translate-x-1/2 w-[420px] max-w-[calc(100%-2rem)] px-4 py-3.5 rounded-xl bg-neutral-950/75 flex flex-col gap-2 shadow-lg overflow-hidden"
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

							<div
								ref={ ( el ) => { barRefs.current[ i ] = el; } }
								className={ `absolute top-0 left-0 right-0 h-[2px] ${ card.barBg } origin-left` }
								style={ { transform: 'scaleX(0)' } }
							/>
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
