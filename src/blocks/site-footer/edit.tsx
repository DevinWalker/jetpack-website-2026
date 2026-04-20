import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';

interface Attrs { ctaHeadline: string; ctaPlaceholder: string; ctaButtonText: string; copyright: string }
interface Props { attributes: Attrs; setAttributes: ( a: Partial< Attrs > ) => void }

export function SiteFooterEdit( { attributes, setAttributes }: Props ) {
	return (
		<>
			<InspectorControls>
				<PanelBody title="CTA Section" initialOpen>
					<TextareaControl label="Headline"    value={ attributes.ctaHeadline }    onChange={ ( v: string ) => setAttributes( { ctaHeadline: v } ) } />
					<TextControl     label="Placeholder" value={ attributes.ctaPlaceholder } onChange={ ( v: string ) => setAttributes( { ctaPlaceholder: v } ) } />
					<TextControl     label="Button text" value={ attributes.ctaButtonText }  onChange={ ( v: string ) => setAttributes( { ctaButtonText: v } ) } />
				</PanelBody>
				<PanelBody title="Copyright" initialOpen={ false }>
					<TextControl label="Copyright text" value={ attributes.copyright } onChange={ ( v: string ) => setAttributes( { copyright: v } ) } help="Leave blank to auto-generate with current year." />
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps( { style: { background: '#a8d946', padding: '1rem', borderRadius: '0.5rem', fontFamily: 'sans-serif' } } ) }>
				<p style={ { fontSize: '0.7rem', color: 'rgba(0,0,0,0.5)', margin: '0 0 0.25rem' } }>SITE FOOTER</p>
				<p style={ { fontSize: '0.85rem', margin: 0 } }>Footer links managed via <strong>Appearance → Menus</strong> (footer-company, footer-resources, footer-social locations).</p>
			</div>
		</>
	);
}
