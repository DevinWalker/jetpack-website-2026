import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

interface Attrs {
	eyebrow:          string;
	title:            string;
	subtitle:         string;
	primaryCtaText:   string;
	primaryCtaUrl:    string;
	secondaryCtaText: string;
	secondaryCtaUrl:  string;
	showAurora:       boolean;
}

interface Props {
	attributes:    Attrs;
	setAttributes: ( a: Partial< Attrs > ) => void;
}

/**
 * Pricing Hero edit UI — static preview + inspector controls.
 * Matches the theme's existing block pattern (static preview, no ServerSideRender).
 */
export function PricingHeroEdit( { attributes, setAttributes }: Props ) {
	const {
		eyebrow, title, subtitle,
		primaryCtaText, primaryCtaUrl,
		secondaryCtaText, secondaryCtaUrl,
		showAurora,
	} = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Hero content', 'jetpack-theme' ) } initialOpen>
					<TextControl     label={ __( 'Eyebrow',  'jetpack-theme' ) } value={ eyebrow }  onChange={ ( v ) => setAttributes( { eyebrow: v } ) } />
					<TextControl     label={ __( 'Title',    'jetpack-theme' ) } value={ title }    onChange={ ( v ) => setAttributes( { title: v } ) } />
					<TextareaControl label={ __( 'Subtitle', 'jetpack-theme' ) } value={ subtitle } onChange={ ( v ) => setAttributes( { subtitle: v } ) } rows={ 3 } />
				</PanelBody>

				<PanelBody title={ __( 'Primary CTA', 'jetpack-theme' ) } initialOpen={ false }>
					<TextControl label={ __( 'Text', 'jetpack-theme' ) } value={ primaryCtaText } onChange={ ( v ) => setAttributes( { primaryCtaText: v } ) } />
					<TextControl label={ __( 'URL',  'jetpack-theme' ) } value={ primaryCtaUrl }  onChange={ ( v ) => setAttributes( { primaryCtaUrl: v } ) } />
				</PanelBody>

				<PanelBody title={ __( 'Secondary CTA', 'jetpack-theme' ) } initialOpen={ false }>
					<TextControl label={ __( 'Text', 'jetpack-theme' ) } value={ secondaryCtaText } onChange={ ( v ) => setAttributes( { secondaryCtaText: v } ) } />
					<TextControl label={ __( 'URL',  'jetpack-theme' ) } value={ secondaryCtaUrl }  onChange={ ( v ) => setAttributes( { secondaryCtaUrl: v } ) } />
				</PanelBody>

				<PanelBody title={ __( 'Visual effects', 'jetpack-theme' ) } initialOpen={ false }>
					<ToggleControl
						label={ __( 'Show Aurora background', 'jetpack-theme' ) }
						help={ __( 'WebGL effect (skipped automatically for prefers-reduced-motion).', 'jetpack-theme' ) }
						checked={ showAurora }
						onChange={ ( v ) => setAttributes( { showAurora: v } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<div
				{ ...useBlockProps( {
					style: {
						background:   'linear-gradient(180deg, #f0f6e8 0%, #f5f5f5 100%)',
						padding:      '3rem 2rem',
						borderRadius: '0.75rem',
						textAlign:    'center',
						fontFamily:   'sans-serif',
					},
				} ) }
			>
				<p style={ { fontSize: '0.7rem', color: '#007117', margin: '0 0 0.5rem', fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em' } }>
					{ eyebrow }
				</p>
				<h1 style={ { fontSize: '2rem', fontWeight: 500, margin: '0 0 0.75rem', lineHeight: 1.15 } }>
					{ title }
				</h1>
				<p style={ { color: '#737373', margin: '0 auto 1.25rem', maxWidth: '32rem', lineHeight: 1.5 } }>
					{ subtitle }
				</p>
				<div style={ { display: 'inline-flex', gap: '0.75rem' } }>
					<span style={ { background: '#069e08', color: '#fff', padding: '0.5rem 1rem', borderRadius: '0.5rem', fontSize: '0.875rem', fontWeight: 600 } }>
						{ primaryCtaText }
					</span>
					<span style={ { background: '#ffffff', color: '#0a0a0a', padding: '0.5rem 1rem', borderRadius: '0.5rem', fontSize: '0.875rem', fontWeight: 600, border: '1px solid #e5e5e5' } }>
						{ secondaryCtaText }
					</span>
				</div>
			</div>
		</>
	);
}
