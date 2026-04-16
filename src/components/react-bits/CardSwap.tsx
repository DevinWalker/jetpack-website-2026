import {
	Children,
	cloneElement,
	createRef,
	forwardRef,
	isValidElement,
	useCallback,
	useEffect,
	useImperativeHandle,
	useMemo,
	useRef,
	type HTMLAttributes,
	type MouseEvent,
	type ReactNode,
	type Ref,
} from 'react';
import gsap from 'gsap';

interface CardProps extends HTMLAttributes< HTMLDivElement > {
	customClass?: string;
	children?: ReactNode;
}

export const Card = forwardRef< HTMLDivElement, CardProps >(
	( { customClass, ...rest }, ref ) => (
		<div
			ref={ ref }
			{ ...rest }
			className={ `absolute top-1/2 left-1/2 rounded-xl bg-black transform-3d will-change-transform backface-hidden ${ customClass ?? '' } ${ rest.className ?? '' }`.trim() }
		/>
	)
);
Card.displayName = 'Card';

interface Slot {
	x: number;
	y: number;
	z: number;
	zIndex: number;
}

const makeSlot = (
	i: number,
	distX: number,
	distY: number,
	total: number,
	zDist?: number,
): Slot => ( {
	x: i * distX,
	y: -i * distY,
	z: -i * ( zDist ?? distX * 1.5 ),
	zIndex: total - i,
} );

const placeNow = ( el: HTMLElement, slot: Slot, skew: number ) =>
	gsap.set( el, {
		x: slot.x,
		y: slot.y,
		z: slot.z,
		xPercent: -50,
		yPercent: -50,
		skewY: skew,
		transformOrigin: 'center center',
		zIndex: slot.zIndex,
		force3D: true,
	} );

interface AnimConfig {
	ease: string;
	durDrop: number;
	durMove: number;
	durReturn: number;
	promoteOverlap: number;
	returnDelay: number;
}

export interface CardSwapHandle {
	/** Cancel any pending scheduled swap and trigger the next swap now.
	 * No-ops if a swap animation is already in flight. */
	advance: () => void;
}

interface CardSwapProps {
	width?: number | string;
	height?: number | string;
	cardDistance?: number;
	verticalDistance?: number;
	delay?: number;
	pauseOnHover?: boolean;
	/** Externally-driven pause. When true the scheduler stops; a running timeline is NOT paused. */
	paused?: boolean;
	onCardClick?: ( idx: number ) => void;
	/** When true, clicking a card calls advance() in addition to firing onCardClick. */
	advanceOnClick?: boolean;
	skewAmount?: number;
	easing?: 'linear' | 'elastic';
	/** Z-axis distance between stacked cards. Defaults to cardDistance × 1.5. */
	zDistance?: number;
	/** Override the outer container's positioning/transform classes entirely. */
	containerClassName?: string;
	/** Fires with the index of the card that just became the front card (at the promote label, mid-animation). */
	onSwap?: ( frontIndex: number ) => void;
	/** Fires with the front card's index once the swap timeline has fully completed (card landed). */
	onSettled?: ( frontIndex: number ) => void;
	children: ReactNode;
}

const DEFAULT_CONTAINER_CLASS =
	'absolute bottom-0 right-0 transform translate-x-[5%] translate-y-[20%] origin-bottom-right perspective-[900px] overflow-visible max-[768px]:translate-x-[25%] max-[768px]:translate-y-[25%] max-[768px]:scale-[0.75] max-[480px]:translate-x-[25%] max-[480px]:translate-y-[25%] max-[480px]:scale-[0.55]';

const CardSwap = forwardRef< CardSwapHandle, CardSwapProps >( ( {
	width = 500,
	height = 400,
	cardDistance = 60,
	verticalDistance = 70,
	delay = 5000,
	pauseOnHover = false,
	paused = false,
	onCardClick,
	advanceOnClick = false,
	skewAmount = 6,
	easing = 'elastic',
	zDistance,
	containerClassName,
	onSwap,
	onSettled,
	children,
}, ref ) => {
	const config: AnimConfig =
		easing === 'elastic'
			? {
					ease: 'elastic.out(0.6,0.9)',
					durDrop: 2,
					durMove: 2,
					durReturn: 2,
					promoteOverlap: 0.9,
					returnDelay: 0.05,
			  }
			: {
					ease: 'power1.inOut',
					durDrop: 0.8,
					durMove: 0.8,
					durReturn: 0.8,
					promoteOverlap: 0.45,
					returnDelay: 0.2,
			  };

	const childArr = useMemo( () => Children.toArray( children ), [ children ] );
	const refs = useMemo(
		() => childArr.map( () => createRef< HTMLDivElement >() ),
		// eslint-disable-next-line react-hooks/exhaustive-deps
		[ childArr.length ]
	);

	const order = useRef< number[] >( Array.from( { length: childArr.length }, ( _, i ) => i ) );
	const tlRef = useRef< gsap.core.Timeline | null >( null );
	const delayedCallRef = useRef< gsap.core.Tween | null >( null );
	const swapRef = useRef< ( () => void ) | null >( null );
	const container = useRef< HTMLDivElement >( null );

	const pausedRef = useRef( paused );
	const delayRef = useRef( delay );
	useEffect( () => { pausedRef.current = paused; }, [ paused ] );
	useEffect( () => { delayRef.current = delay; }, [ delay ] );

	const killScheduled = useCallback( () => {
		delayedCallRef.current?.kill();
		delayedCallRef.current = null;
	}, [] );

	const scheduleNext = useCallback( () => {
		killScheduled();
		if ( pausedRef.current ) return;
		if ( ! swapRef.current ) return;
		delayedCallRef.current = gsap.delayedCall( delayRef.current / 1000, swapRef.current );
	}, [ killScheduled ] );

	useImperativeHandle( ref, () => ( {
		advance: () => {
			killScheduled();
			if ( tlRef.current?.isActive() ) return;
			swapRef.current?.();
		},
	} ), [ killScheduled ] );

	useEffect( () => {
		const total = refs.length;
		refs.forEach( ( r, i ) => {
			if ( r.current ) {
				placeNow( r.current, makeSlot( i, cardDistance, verticalDistance, total, zDistance ), skewAmount );
			}
		} );

		const swap = () => {
			if ( order.current.length < 2 ) return;
			killScheduled();

			const [ front, ...rest ] = order.current;
			const elFront = refs[ front ].current;
			if ( ! elFront ) return;

			const tl = gsap.timeline();
			tlRef.current = tl;

			tl.to( elFront, {
				y: '+=500',
				duration: config.durDrop,
				ease: config.ease,
			} );

			tl.addLabel( 'promote', `-=${ config.durDrop * config.promoteOverlap }` );
			tl.call(
				() => {
					order.current = [ ...rest, front ];
					onSwap?.( order.current[ 0 ] );
				},
				undefined,
				'promote'
			);
			rest.forEach( ( idx, i ) => {
				const el = refs[ idx ].current;
				if ( ! el ) return;
				const slot = makeSlot( i, cardDistance, verticalDistance, refs.length, zDistance );
				tl.set( el, { zIndex: slot.zIndex }, 'promote' );
				tl.to(
					el,
					{
						x: slot.x,
						y: slot.y,
						z: slot.z,
						duration: config.durMove,
						ease: config.ease,
					},
					`promote+=${ i * 0.15 }`
				);
			} );

			const backSlot = makeSlot( refs.length - 1, cardDistance, verticalDistance, refs.length, zDistance );
			tl.addLabel( 'return', `promote+=${ config.durMove * config.returnDelay }` );
			tl.call(
				() => {
					gsap.set( elFront, { zIndex: backSlot.zIndex } );
				},
				undefined,
				'return'
			);
			tl.to(
				elFront,
				{
					x: backSlot.x,
					y: backSlot.y,
					z: backSlot.z,
					duration: config.durReturn,
					ease: config.ease,
				},
				'return'
			);

			tl.eventCallback( 'onComplete', () => {
				onSettled?.( order.current[ 0 ] );
				scheduleNext();
			} );
		};

		swapRef.current = swap;
		swap();

		if ( pauseOnHover ) {
			const node = container.current;
			if ( ! node ) return;

			const pause = () => {
				killScheduled();
			};
			const resume = () => {
				if ( tlRef.current?.isActive() ) return;
				scheduleNext();
			};
			node.addEventListener( 'mouseenter', pause );
			node.addEventListener( 'mouseleave', resume );
			return () => {
				node.removeEventListener( 'mouseenter', pause );
				node.removeEventListener( 'mouseleave', resume );
				killScheduled();
			};
		}
		return () => {
			killScheduled();
		};
		// eslint-disable-next-line react-hooks/exhaustive-deps
	}, [ cardDistance, verticalDistance, delay, pauseOnHover, skewAmount, easing, zDistance ] );

	useEffect( () => {
		if ( paused ) {
			killScheduled();
			return;
		}
		if ( tlRef.current?.isActive() ) return;
		scheduleNext();
	}, [ paused, killScheduled, scheduleNext ] );

	const rendered = childArr.map( ( child, i ) =>
		isValidElement< CardProps >( child )
			? cloneElement( child, {
					key: i,
					ref: refs[ i ] as Ref< HTMLDivElement >,
					style: { width, height, ...( ( child.props as CardProps ).style ?? {} ) },
					onClick: ( e: MouseEvent< HTMLDivElement > ) => {
						( child.props as CardProps ).onClick?.( e );
						onCardClick?.( i );
						if ( advanceOnClick ) {
							killScheduled();
							if ( ! tlRef.current?.isActive() ) {
								swapRef.current?.();
							}
						}
					},
			  } )
			: child
	);

	return (
		<div
			ref={ container }
			className={ containerClassName ?? DEFAULT_CONTAINER_CLASS }
			style={ { width, height } }
		>
			{ rendered }
		</div>
	);
} );
CardSwap.displayName = 'CardSwap';

export default CardSwap;
