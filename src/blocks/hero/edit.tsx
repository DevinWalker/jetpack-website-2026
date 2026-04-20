import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';

interface HeroAttributes {
	badgeText: string;
	changelogText: string;
	changelogUrl: string;
	headlineLine1: string;
	headlineAccent: string;
	subheadline: string;
	ctaText: string;
	ctaUrl: string;
}

interface Props {
	attributes: HeroAttributes;
	setAttributes: ( attrs: Partial< HeroAttributes > ) => void;
}

export function HeroEdit( { attributes, setAttributes }: Props ) {
	return (
		<>
			<InspectorControls>
				<PanelBody title="Badge & Changelog" initialOpen>
					<TextControl
						label="Badge text"
						value={ attributes.badgeText }
						onChange={ ( v ) => setAttributes( { badgeText: v } ) }
					/>
					<TextControl
						label="Changelog link text"
						value={ attributes.changelogText }
						onChange={ ( v ) => setAttributes( { changelogText: v } ) }
					/>
				<TextControl
					label="Changelog URL"
					value={ attributes.changelogUrl ?? '' }
					help={ `Default: ${ window.jetpackThemeData?.homeUrl ?? '' }/changelog` }
					onChange={ ( v ) => setAttributes( { changelogUrl: v } ) }
					type="url"
				/>
				</PanelBody>
				<PanelBody title="Headline" initialOpen>
					<TextControl
						label="Line 1"
						value={ attributes.headlineLine1 }
						onChange={ ( v ) => setAttributes( { headlineLine1: v } ) }
					/>
					<TextControl
						label="Accent word"
						value={ attributes.headlineAccent }
						onChange={ ( v ) => setAttributes( { headlineAccent: v } ) }
					/>
					<TextareaControl
						label="Subheadline"
						value={ attributes.subheadline }
						onChange={ ( v ) => setAttributes( { subheadline: v } ) }
						rows={ 3 }
					/>
				</PanelBody>
				<PanelBody title="CTA Button" initialOpen={ false }>
					<TextControl
						label="Button text"
						value={ attributes.ctaText }
						onChange={ ( v ) => setAttributes( { ctaText: v } ) }
					/>
				<TextControl
					label="Button URL"
					value={ attributes.ctaUrl ?? '' }
					help={ `Default: ${ window.jetpackThemeData?.homeUrl ?? '' }/pricing/` }
					onChange={ ( v ) => setAttributes( { ctaUrl: v } ) }
					type="url"
				/>
				</PanelBody>
			</InspectorControls>

			<div
				{ ...useBlockProps( {
					style: {
						background: '#e8f5c8',
						padding: '1.5rem',
						borderRadius: '0.5rem',
						fontFamily: 'sans-serif',
					},
				} ) }
			>
				<p style={ { fontSize: '0.7rem', color: '#737373', margin: '0 0 0.5rem' } }>
					HERO SECTION
				</p>
				<h1 style={ { fontSize: '1.5rem', fontWeight: 600, margin: '0 0 0.25rem' } }>
					{ attributes.headlineLine1 }{ ' ' }
					<em style={ { color: '#a8d946' } }>{ attributes.headlineAccent }</em>
				</h1>
				<p style={ { fontSize: '0.85rem', color: '#525252', margin: '0 0 0.75rem' } }>
					{ attributes.subheadline }
				</p>
				<span
					style={ {
						display: 'inline-block',
						background: '#0a0a0a',
						color: '#fff',
						padding: '0.4rem 1rem',
						borderRadius: '0.5rem',
						fontSize: '0.85rem',
					} }
				>
					{ attributes.ctaText }
				</span>
				<p style={ { fontSize: '0.7rem', color: '#737373', margin: '0.75rem 0 0' } }>
					✏️ Use the sidebar panels to edit content.
				</p>
			</div>
		</>
	);
}
