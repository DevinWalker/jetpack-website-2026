/**
 * Scroll-triggered entrance animations using GSAP + ScrollTrigger.
 * Handles: bento cards, pricing cards, FAQ items, testimonials heading.
 * Respects prefers-reduced-motion.
 *
 * This script is loaded as a global viewScript for the features-bento,
 * pricing, and any other sections that use `.jetpack-reveal` or
 * `.jetpack-bento-card` CSS classes.
 */
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin( ScrollTrigger );

const REVEAL_ALL = '.jetpack-reveal, .jetpack-bento-card, .jetpack-pricing-card, .jetpack-fh-section, .hero-with-icon .wp-block-media-text';

if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
	document.querySelectorAll< HTMLElement >( REVEAL_ALL ).forEach( ( el ) => {
		el.style.opacity   = '1';
		el.style.transform = 'none';
	} );
} else {
	// Bento cards — staggered entrance per card.
	const bentoCards = gsap.utils.toArray< HTMLElement >( '.jetpack-bento-card' );
	bentoCards.forEach( ( card, i ) => {
		gsap.to( card, {
			opacity:    1,
			y:          0,
			duration:   0.8,
			ease:       'power3.out',
			delay:      i * 0.1,
			scrollTrigger: {
				trigger: card,
				start:   'top 90%',
				once:    true,
			},
		} );
	} );

	// Generic reveal elements (pricing header, FAQ header, etc.).
	const reveals = gsap.utils.toArray< HTMLElement >( '.jetpack-reveal' );
	reveals.forEach( ( el ) => {
		gsap.to( el, {
			opacity:    1,
			y:          0,
			duration:   0.6,
			ease:       'power3.out',
			scrollTrigger: {
				trigger: el,
				start:   'top 88%',
				once:    true,
			},
		} );
	} );

	// Pricing cards — staggered.
	const pricingCards = gsap.utils.toArray< HTMLElement >( '.jetpack-pricing-card' );
	pricingCards.forEach( ( card, i ) => {
		gsap.to( card, {
			opacity:    1,
			y:          0,
			duration:   0.6,
			ease:       'power3.out',
			delay:      i * 0.1,
			scrollTrigger: {
				trigger: card,
				start:   'top 88%',
				once:    true,
			},
		} );
	} );

	// Features highlights sections — staggered entrance per section.
	const fhSections = gsap.utils.toArray< HTMLElement >( '.jetpack-fh-section' );
	fhSections.forEach( ( section, i ) => {
		gsap.to( section, {
			opacity:    1,
			y:          0,
			duration:   0.8,
			ease:       'power3.out',
			delay:      i * 0.15,
			scrollTrigger: {
				trigger: section,
				start:   'top 88%',
				once:    true,
			},
		} );
	} );

	// Testimonials section heading.
	const testimonialH2 = document.querySelector< HTMLElement >( '.jetpack-testimonials h2' );
	if ( testimonialH2 ) {
		gsap.to( testimonialH2, {
			opacity:  1,
			duration: 0.6,
			ease:     'power2.out',
			scrollTrigger: {
				trigger: testimonialH2,
				start:   'top 85%',
				once:    true,
			},
		} );
	}

	// Production media-text sections inside feature page containers.
	const mediaTexts = gsap.utils.toArray< HTMLElement >( '.hero-with-icon .wp-block-media-text' );
	mediaTexts.forEach( ( el ) => {
		gsap.fromTo( el,
			{ opacity: 0, y: 40 },
			{
				opacity:    1,
				y:          0,
				duration:   0.8,
				ease:       'power3.out',
				scrollTrigger: {
					trigger: el,
					start:   'top 88%',
					once:    true,
				},
			}
		);
	} );
}
