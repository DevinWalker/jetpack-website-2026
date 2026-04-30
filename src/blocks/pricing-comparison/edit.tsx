import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

interface Attrs {
	sectionTitle:       string;
	sectionDescription: string;
}

interface Props {
	attributes:    Attrs;
	setAttributes: ( a: Partial< Attrs > ) => void;
}

/**
 * Pricing Comparison edit UI — static preview.
 * Feature rows themselves live in inc/pricing-data.php; editors only adjust
 * the section headline + description here.
 */
export function PricingComparisonEdit( { attributes, setAttributes }: Props ) {
	const { sectionTitle, sectionDescription } = attributes;
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Section', 'jetpack-theme' ) } initialOpen>
					<TextControl
						label={ __( 'Title', 'jetpack-theme' ) }
						value={ sectionTitle }
						onChange={ ( v ) => setAttributes( { sectionTitle: v } ) }
					/>
					<TextareaControl
						label={ __( 'Description', 'jetpack-theme' ) }
						value={ sectionDescription }
						onChange={ ( v ) => setAttributes( { sectionDescription: v } ) }
						rows={ 3 }
					/>
				</PanelBody>
			</InspectorControls>

			<div
				{ ...useBlockProps( {
					style: {
						background:   '#f5f5f5',
						padding:      '1.25rem',
						borderRadius: '0.5rem',
						fontFamily:   'sans-serif',
					},
				} ) }
			>
				<p style={ { fontSize: '0.7rem', color: '#007117', margin: '0 0 0.25rem', fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em' } }>
					{ __( 'Compare plans', 'jetpack-theme' ) }
				</p>
				<p style={ { fontWeight: 600, margin: '0 0 0.5rem' } }>{ sectionTitle }</p>
				<p style={ { fontSize: '0.8rem', color: '#737373', margin: 0 } }>
					{ __( 'Free vs Pro feature table — renders server-side with all categories visible.', 'jetpack-theme' ) }
				</p>
			</div>
		</>
	);
}
