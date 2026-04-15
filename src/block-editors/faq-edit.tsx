import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';

interface FAQItem { question: string; answer: string }
interface Attrs {
	sectionTitle: string; sectionDescription: string;
	ctaPrimaryText: string; ctaPrimaryUrl: string;
	ctaSecondaryText: string; ctaSecondaryUrl: string;
	items: FAQItem[];
}
interface Props { attributes: Attrs; setAttributes: ( a: Partial< Attrs > ) => void }

export function FAQEdit( { attributes, setAttributes }: Props ) {
	const updateItem = ( i: number, patch: Partial< FAQItem > ) => {
		setAttributes( { items: attributes.items.map( ( item, idx ) => idx === i ? { ...item, ...patch } : item ) } );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title="Section" initialOpen>
					<TextControl     label="Title"       value={ attributes.sectionTitle }       onChange={ ( v ) => setAttributes( { sectionTitle: v } ) } />
					<TextareaControl label="Description" value={ attributes.sectionDescription } onChange={ ( v ) => setAttributes( { sectionDescription: v } ) } />
				</PanelBody>
				<PanelBody title="CTA Buttons" initialOpen={ false }>
					<TextControl label="Primary text" value={ attributes.ctaPrimaryText }   onChange={ ( v ) => setAttributes( { ctaPrimaryText: v } ) } />
					<TextControl label="Primary URL"  value={ attributes.ctaPrimaryUrl }    onChange={ ( v ) => setAttributes( { ctaPrimaryUrl: v } ) } type="url" />
					<TextControl label="Secondary text" value={ attributes.ctaSecondaryText } onChange={ ( v ) => setAttributes( { ctaSecondaryText: v } ) } />
					<TextControl label="Secondary URL"  value={ attributes.ctaSecondaryUrl }  onChange={ ( v ) => setAttributes( { ctaSecondaryUrl: v } ) } type="url" />
				</PanelBody>
				{ attributes.items.map( ( item, i ) => (
					<PanelBody key={ i } title={ `Q${ i + 1 }` } initialOpen={ false }>
						<TextControl     label="Question" value={ item.question } onChange={ ( v ) => updateItem( i, { question: v } ) } />
						<TextareaControl label="Answer"   value={ item.answer }   onChange={ ( v ) => updateItem( i, { answer: v } ) } rows={ 4 } />
					</PanelBody>
				) ) }
			</InspectorControls>
			<div { ...useBlockProps( { style: { background: '#f5f5f5', padding: '1.5rem', borderRadius: '0.5rem', fontFamily: 'sans-serif' } } ) }>
				<p style={ { fontSize: '0.7rem', color: '#737373', margin: '0 0 0.25rem' } }>FAQ</p>
				<p style={ { fontWeight: 600, margin: '0 0 0.5rem' } }>{ attributes.sectionTitle }</p>
				<ul style={ { margin: 0, paddingLeft: '1rem', fontSize: '0.8rem' } }>
					{ attributes.items.map( ( item, i ) => (
						<li key={ i } style={ { marginBottom: '0.25rem' } }>{ item.question }</li>
					) ) }
				</ul>
			</div>
		</>
	);
}
