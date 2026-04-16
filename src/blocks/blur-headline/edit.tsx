import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextareaControl } from '@wordpress/components';

interface Attrs { text: string }
interface Props { attributes: Attrs; setAttributes: ( a: Partial< Attrs > ) => void }

export function BlurHeadlineEdit( { attributes, setAttributes }: Props ) {
	return (
		<>
			<InspectorControls>
				<PanelBody title="Blur-In Headline" initialOpen>
					<TextareaControl
						label="Paragraph text"
						value={ attributes.text }
						onChange={ ( v: string ) => setAttributes( { text: v } ) }
						rows={ 5 }
						help="Each word reveals sequentially as the user scrolls."
					/>
				</PanelBody>
			</InspectorControls>
			<div
				{ ...useBlockProps( {
					style: {
						background: '#f5f5f5',
						padding: '1.5rem',
						borderRadius: '0.5rem',
						fontFamily: 'sans-serif',
					},
				} ) }
			>
				<p style={ { fontSize: '0.7rem', color: '#737373', margin: '0 0 0.5rem' } }>
					BLUR-IN HEADLINE
				</p>
				<p style={ { fontSize: '1rem', color: '#0a0a0a', margin: 0, lineHeight: 1.6 } }>
					{ attributes.text }
				</p>
			</div>
		</>
	);
}
