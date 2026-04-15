/**
 * FAQ Interactivity API store.
 * Handles accordion open/close. CSS max-height transition provides animation.
 */
import { store, getContext } from '@wordpress/interactivity';

interface FAQState {
	openIndex: number;
}

const { state } = store( 'jetpack-theme/faq', {
	state: {
		openIndex: 0,
	} as FAQState,

	actions: {
		toggle() {
			const ctx = getContext< { index: number } >();
			state.openIndex = state.openIndex === ctx.index ? -1 : ctx.index;
		},

		keydown( event: KeyboardEvent ) {
			if ( event.key === 'Enter' || event.key === ' ' ) {
				event.preventDefault();
				const ctx = getContext< { index: number } >();
				state.openIndex = state.openIndex === ctx.index ? -1 : ctx.index;
			}
		},
	},
} );
