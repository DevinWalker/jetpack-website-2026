/**
 * Type stubs for WordPress packages that are externalized by @wordpress/scripts.
 * These are provided by wp-includes at runtime; we only need enough type info
 * to satisfy the compiler in the block editor files.
 */

declare module '@wordpress/block-editor' {
	import type { ComponentType, ReactNode, CSSProperties } from 'react';

	export function useBlockProps( props?: { className?: string; style?: CSSProperties; [ key: string ]: unknown } ): Record< string, unknown >;
	export const InspectorControls: ComponentType< { children: ReactNode } >;
	export const RichText: ComponentType< { tagName?: string; value?: string; onChange?: ( v: string ) => void; placeholder?: string; className?: string } >;
}

declare module '@wordpress/components' {
	import type { ComponentType, ReactNode, ChangeEvent } from 'react';

	interface PanelBodyProps { title?: string; initialOpen?: boolean; children?: ReactNode }
	interface TextControlProps { label?: string; value?: string; onChange?: ( v: string ) => void; type?: string; help?: string }
	interface TextareaControlProps { label?: string; value?: string; onChange?: ( v: string ) => void; rows?: number; help?: string }
	interface ToggleControlProps { label?: string; checked?: boolean; onChange?: ( v: boolean ) => void; help?: string }
	interface SelectControlProps { label?: string; value?: string; options?: { label: string; value: string }[]; onChange?: ( v: string ) => void }

	export const PanelBody:    ComponentType< PanelBodyProps >;
	export const TextControl:  ComponentType< TextControlProps >;
	export const TextareaControl: ComponentType< TextareaControlProps >;
	export const ToggleControl:   ComponentType< ToggleControlProps >;
	export const SelectControl:   ComponentType< SelectControlProps >;
}

declare module '@wordpress/blocks' {
	export function registerBlockType( name: string, settings: Record< string, unknown > ): void;
	export function unregisterBlockType( name: string ): void;
}

declare module '@wordpress/data' {
	export function useSelect< T >( selector: ( select: ( store: string ) => unknown ) => T ): T;
	export function useDispatch( store: string ): Record< string, ( ...args: unknown[] ) => unknown >;
}
