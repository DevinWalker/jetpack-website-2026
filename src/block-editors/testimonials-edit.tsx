import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';

interface TestimonialItem {
	quote: string; name: string; title: string;
	url: string; avatar: string;
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
						<TextControl     label="Name"       value={ item.name }   onChange={ ( v ) => updateItem( i, { name: v } ) } />
						<TextControl     label="Role"       value={ item.title }  onChange={ ( v ) => updateItem( i, { title: v } ) } />
						<TextControl     label="URL"        value={ item.url }    onChange={ ( v ) => updateItem( i, { url: v } ) } type="url" />
						<TextControl     label="Photo URL"  value={ item.avatar } onChange={ ( v ) => updateItem( i, { avatar: v } ) } type="url" />
						<TextareaControl label="Quote"      value={ item.quote }  onChange={ ( v ) => updateItem( i, { quote: v } ) } rows={ 4 } />
					</PanelBody>
				) ) }
			</InspectorControls>
			<div { ...useBlockProps( { className: 'jetpack-testimonials-editor' } ) }>
				<p style={ { fontSize: '0.7rem', color: '#737373', margin: '0 0 0.25rem' } }>TESTIMONIALS SLIDER</p>
				<p style={ { fontWeight: 600, margin: '0 0 0.75rem' } }>{ attributes.sectionTitle }</p>
				{ attributes.items.map( ( item, i ) => (
					<div key={ i } style={ { display: 'flex', gap: '0.75rem', alignItems: 'center', marginBottom: '0.5rem', padding: '0.5rem', background: '#fff', borderRadius: '0.5rem' } }>
						<img src={ item.avatar } alt={ item.name } style={ { width: 40, height: 40, borderRadius: '50%', objectFit: 'cover' } } />
						<div>
							<div style={ { fontWeight: 600, fontSize: '0.8rem' } }>{ item.name }</div>
							<div style={ { fontSize: '0.7rem', color: '#737373' } }>{ item.title }</div>
						</div>
					</div>
				) ) }
			</div>
		</>
	);
}
