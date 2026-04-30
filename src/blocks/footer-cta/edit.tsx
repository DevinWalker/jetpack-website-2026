import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';

interface Attrs { ctaHeadline: string; ctaPlaceholder: string; ctaButtonText: string }
interface Props { attributes: Attrs; setAttributes: ( a: Partial< Attrs > ) => void }

export function FooterCtaEdit( { attributes, setAttributes }: Props ) {
	return (
		<>
			<InspectorControls>
				<PanelBody title="CTA Section" initialOpen>
					<TextareaControl label="Headline"    value={ attributes.ctaHeadline }    onChange={ ( v: string ) => setAttributes( { ctaHeadline: v } ) } />
					<TextControl     label="Placeholder" value={ attributes.ctaPlaceholder } onChange={ ( v: string ) => setAttributes( { ctaPlaceholder: v } ) } />
					<TextControl     label="Button text" value={ attributes.ctaButtonText }  onChange={ ( v: string ) => setAttributes( { ctaButtonText: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps( { style: { background: '#a8d946', padding: '1rem', borderRadius: '0.5rem', fontFamily: 'sans-serif' } } ) }>
				<p style={ { fontSize: '0.7rem', color: 'rgba(0,0,0,0.5)', margin: '0 0 0.25rem' } }>FOOTER CTA</p>
				<p style={ { fontSize: '0.85rem', margin: 0 } }>CTA card. The footer link grid is in the <strong>Footer</strong> template part (Site Editor → Patterns → Template Parts).</p>
			</div>
		</>
	);
}
