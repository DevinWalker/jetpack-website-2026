import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

interface Attrs { ctaText: string; ctaUrl: string }
interface Props { attributes: Attrs; setAttributes: ( a: Partial< Attrs > ) => void }

export function SiteHeaderEdit( { attributes, setAttributes }: Props ) {
	return (
		<>
			<InspectorControls>
				<PanelBody title="CTA Button" initialOpen>
					<TextControl label="Button text" value={ attributes.ctaText } onChange={ ( v: string ) => setAttributes( { ctaText: v } ) } />
					<TextControl label="Button URL"  value={ attributes.ctaUrl ?? '' }  help={ `Default: ${ window.jetpackThemeData?.homeUrl ?? '' }/pricing/` } onChange={ ( v: string ) => setAttributes( { ctaUrl: v } ) } type="url" />
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps( { style: { background: '#f5f5f5', padding: '1rem', borderRadius: '0.5rem', fontFamily: 'sans-serif' } } ) }>
				<p style={ { fontSize: '0.7rem', color: '#737373', margin: '0 0 0.25rem' } }>SITE HEADER</p>
				<p style={ { fontSize: '0.85rem', margin: 0 } }>Nav managed via <strong>Appearance → Menus</strong> (Primary Navigation location). CTA: <strong>{ attributes.ctaText }</strong></p>
			</div>
		</>
	);
}
