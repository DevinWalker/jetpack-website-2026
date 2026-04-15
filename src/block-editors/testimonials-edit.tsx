import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';

interface TestimonialItem {
	quote: string; name: string; title: string;
	avatar: string; company: string; logo: string;
}
interface Attrs { sectionTitle: string; items: TestimonialItem[] }
interface Props { attributes: Attrs; setAttributes: ( a: Partial< Attrs > ) => void }

export function TestimonialsEdit( { attributes, setAttributes }: Props ) {
	const updateItem = ( index: number, patch: Partial< TestimonialItem > ) => {
		const next = attributes.items.map( ( item, i ) =>
			i === index ? { ...item, ...patch } : item
		);
		setAttributes( { items: next } );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title="Section" initialOpen>
					<TextControl
						label="Section title"
						value={ attributes.sectionTitle }
						onChange={ ( v ) => setAttributes( { sectionTitle: v } ) }
					/>
				</PanelBody>
				{ attributes.items.map( ( item, i ) => (
					<PanelBody key={ i } title={ `Testimonial ${ i + 1 }: ${ item.name }` } initialOpen={ false }>
						<TextControl        label="Name"            value={ item.name }    onChange={ ( v ) => updateItem( i, { name: v } ) } />
						<TextControl        label="Title"           value={ item.title }   onChange={ ( v ) => updateItem( i, { title: v } ) } />
						<TextControl        label="Company"         value={ item.company } onChange={ ( v ) => updateItem( i, { company: v } ) } />
						<TextControl        label="Avatar URL"      value={ item.avatar }  onChange={ ( v ) => updateItem( i, { avatar: v } ) } type="url" />
						<TextControl        label="Logo path"       value={ item.logo }    onChange={ ( v ) => updateItem( i, { logo: v } ) } help="Relative to assets/ (e.g. mock-logos/commandr.svg)" />
						<TextareaControl    label="Quote"           value={ item.quote }   onChange={ ( v ) => updateItem( i, { quote: v } ) } rows={ 4 } />
					</PanelBody>
				) ) }
			</InspectorControls>
			<div { ...useBlockProps( { style: { background: '#f5f5f5', padding: '1.5rem', borderRadius: '0.5rem', fontFamily: 'sans-serif' } } ) }>
				<p style={ { fontSize: '0.7rem', color: '#737373', margin: '0 0 0.25rem' } }>TESTIMONIALS</p>
				<p style={ { fontWeight: 600, margin: '0 0 0.75rem' } }>{ attributes.sectionTitle }</p>
				<p style={ { fontSize: '0.75rem', color: '#525252', margin: 0 } }>{ attributes.items.length } testimonials — edit each in the sidebar.</p>
			</div>
		</>
	);
}
