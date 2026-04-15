import {
	Children,
	cloneElement,
	createRef,
	forwardRef,
	isValidElement,
	useEffect,
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

interface CardSwapProps {
	width?: number | string;
	height?: number | string;
	cardDistance?: number;
	verticalDistance?: number;
	delay?: number;
	pauseOnHover?: boolean;
	onCardClick?: ( idx: number ) => void;
	skewAmount?: number;
	easing?: 'linear' | 'elastic';
	/** Z-axis distance between stacked cards. Defaults to cardDistance × 1.5. */
	zDistance?: number;
	/** Override the outer container's positioning/transform classes entirely. */
	containerClassName?: string;
	/** Fires with the index of the card that just became the front card. */
	onSwap?: ( frontIndex: number ) => void;
	children: ReactNode;
}

const DEFAULT_CONTAINER_CLASS =
	'absolute bottom-0 right-0 transform translate-x-[5%] translate-y-[20%] origin-bottom-right perspective-[900px] overflow-visible max-[768px]:translate-x-[25%] max-[768px]:translate-y-[25%] max-[768px]:scale-[0.75] max-[480px]:translate-x-[25%] max-[480px]:translate-y-[25%] max-[480px]:scale-[0.55]';

const CardSwap = ( {
	width = 500,
	height = 400,
	cardDistance = 60,
	verticalDistance = 70,
	delay = 5000,
	pauseOnHover = false,
	onCardClick,
	skewAmount = 6,
	easing = 'elastic',
	zDistance,
	containerClassName,
	onSwap,
	children,
}: CardSwapProps ) => {
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
	const intervalRef = useRef< ReturnType< typeof setInterval > | undefined >( undefined );
	const container = useRef< HTMLDivElement >( null );

	useEffect( () => {
		const total = refs.length;
		refs.forEach( ( r, i ) => {
			if ( r.current ) {
				placeNow( r.current, makeSlot( i, cardDistance, verticalDistance, total, zDistance ), skewAmount );
			}
		} );

		const swap = () => {
			if ( order.current.length < 2 ) return;

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

			tl.call( () => {
				order.current = [ ...rest, front ];
				onSwap?.( order.current[ 0 ] );
			} );
		};

		swap();
		intervalRef.current = window.setInterval( swap, delay );

		if ( pauseOnHover ) {
			const node = container.current;
			if ( ! node ) return;

			const pause = () => {
				tlRef.current?.pause();
				clearInterval( intervalRef.current );
			};
			const resume = () => {
				tlRef.current?.play();
				intervalRef.current = window.setInterval( swap, delay );
			};
			node.addEventListener( 'mouseenter', pause );
			node.addEventListener( 'mouseleave', resume );
			return () => {
				node.removeEventListener( 'mouseenter', pause );
				node.removeEventListener( 'mouseleave', resume );
				clearInterval( intervalRef.current );
			};
		}
		return () => clearInterval( intervalRef.current );
		// eslint-disable-next-line react-hooks/exhaustive-deps
	}, [ cardDistance, verticalDistance, delay, pauseOnHover, skewAmount, easing, zDistance ] );

	const rendered = childArr.map( ( child, i ) =>
		isValidElement< CardProps >( child )
			? cloneElement( child, {
					key: i,
					ref: refs[ i ] as Ref< HTMLDivElement >,
					style: { width, height, ...( ( child.props as CardProps ).style ?? {} ) },
					onClick: ( e: MouseEvent< HTMLDivElement > ) => {
						( child.props as CardProps ).onClick?.( e );
						onCardClick?.( i );
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
};

export default CardSwap;
