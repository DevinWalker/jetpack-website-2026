/**
 * Header Interactivity API store.
 * Handles: desktop dropdown hover, mobile menu toggle, mobile sub-menu expand.
 */
import { store, getContext } from '@wordpress/interactivity';

interface HeaderState {
	openMenu:    string | null;
	openSubMenu: string | null;
	mobileOpen:  boolean;
}

const { state } = store( 'jetpack-theme/header', {
	state: {
		openMenu:    null,
		openSubMenu: null,
		mobileOpen:  false,
	} as HeaderState,

	actions: {
		openMenu() {
			const ctx = getContext< { menuId: string } >();
			state.openMenu = ctx.menuId;
		},
		closeMenu() {
			state.openMenu = null;
		},
		toggleMobile() {
			state.mobileOpen = ! state.mobileOpen;
			if ( ! state.mobileOpen ) {
				state.openSubMenu = null;
			}
		},
		closeMobile() {
			state.mobileOpen  = false;
			state.openSubMenu = null;
		},
		toggleSubMenu() {
			const ctx = getContext< { subMenuId: string } >();
			state.openSubMenu = state.openSubMenu === ctx.subMenuId ? null : ctx.subMenuId;
		},
	},
} );
