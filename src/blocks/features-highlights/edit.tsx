import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

interface Benefit {
	text: string;
	linkText: string;
	linkUrl: string;
}

interface Section {
	eyebrow: string;
	heading: string;
	headingHighlight: string;
	description: string;
	benefits: Benefit[];
	ctaLabel: string;
	ctaUrl: string;
	imageUrl: string;
	imageAlt: string;
	mediaPosition: string;
}

interface Attrs {
	sections: Section[];
}

interface Props {
	attributes: Attrs;
	setAttributes: ( a: Partial< Attrs > ) => void;
}

function updateSection( sections: Section[], index: number, patch: Partial< Section > ): Section[] {
	return sections.map( ( s, i ) => ( i === index ? { ...s, ...patch } : s ) );
}

function updateBenefit( sections: Section[], sIdx: number, bIdx: number, patch: Partial< Benefit > ): Section[] {
	return sections.map( ( s, i ) => {
		if ( i !== sIdx ) return s;
		const benefits = s.benefits.map( ( b, j ) => ( j === bIdx ? { ...b, ...patch } : b ) );
		return { ...s, benefits };
	} );
}

const SECTION_LABELS = [ 'Growth', 'Performance', 'Security' ];

export function FeaturesHighlightsEdit( { attributes, setAttributes }: Props ) {
	const { sections } = attributes;

	return (
		<>
			<InspectorControls>
				{ sections.map( ( section, sIdx ) => (
					<PanelBody key={ sIdx } title={ `${ SECTION_LABELS[ sIdx ] ?? `Section ${ sIdx + 1 }` }` } initialOpen={ sIdx === 0 }>
						<TextControl
							label="Eyebrow"
							value={ section.eyebrow }
							onChange={ ( v ) => setAttributes( { sections: updateSection( sections, sIdx, { eyebrow: v } ) } ) }
						/>
						<TextControl
							label="Heading"
							value={ section.heading }
							onChange={ ( v ) => setAttributes( { sections: updateSection( sections, sIdx, { heading: v } ) } ) }
						/>
						<TextControl
							label="Highlight phrase"
							value={ section.headingHighlight }
							onChange={ ( v ) => setAttributes( { sections: updateSection( sections, sIdx, { headingHighlight: v } ) } ) }
						/>
						<TextControl
							label="Description"
							value={ section.description }
							onChange={ ( v ) => setAttributes( { sections: updateSection( sections, sIdx, { description: v } ) } ) }
						/>
						<TextControl
							label="CTA label"
							value={ section.ctaLabel }
							onChange={ ( v ) => setAttributes( { sections: updateSection( sections, sIdx, { ctaLabel: v } ) } ) }
						/>
						<TextControl
							label="CTA URL"
							value={ section.ctaUrl }
							onChange={ ( v ) => setAttributes( { sections: updateSection( sections, sIdx, { ctaUrl: v } ) } ) }
						/>
						<TextControl
							label="Image URL"
							value={ section.imageUrl }
							onChange={ ( v ) => setAttributes( { sections: updateSection( sections, sIdx, { imageUrl: v } ) } ) }
						/>

						{ section.benefits.map( ( b, bIdx ) => (
							<PanelBody key={ bIdx } title={ `Benefit ${ bIdx + 1 }` } initialOpen={ false }>
								<TextControl
									label="Text"
									value={ b.text }
									onChange={ ( v ) => setAttributes( { sections: updateBenefit( sections, sIdx, bIdx, { text: v } ) } ) }
								/>
								<TextControl
									label="Link text"
									value={ b.linkText }
									onChange={ ( v ) => setAttributes( { sections: updateBenefit( sections, sIdx, bIdx, { linkText: v } ) } ) }
								/>
								<TextControl
									label="Link URL"
									value={ b.linkUrl }
									onChange={ ( v ) => setAttributes( { sections: updateBenefit( sections, sIdx, bIdx, { linkUrl: v } ) } ) }
								/>
							</PanelBody>
						) ) }
					</PanelBody>
				) ) }
			</InspectorControls>

			<div
				{ ...useBlockProps( {
					style: { background: '#f0f2eb', padding: '1.5rem', borderRadius: '0.5rem', fontFamily: 'sans-serif' },
				} ) }
			>
				<p style={ { fontSize: '0.7rem', color: '#737373', margin: '0 0 0.5rem' } }>FEATURES HIGHLIGHTS</p>
				<div style={ { display: 'flex', flexDirection: 'column', gap: '0.75rem' } }>
					{ sections.map( ( s, i ) => (
						<div key={ i } style={ { display: 'flex', gap: '0.75rem', background: '#fff', padding: '0.75rem', borderRadius: '0.5rem' } }>
							<div style={ { flex: 1 } }>
								<span style={ { fontSize: '0.65rem', color: '#008710', fontWeight: 600 } }>{ s.eyebrow }</span>
								<p style={ { fontSize: '0.85rem', fontWeight: 600, margin: '0.25rem 0' } }>{ s.heading }</p>
								<p style={ { fontSize: '0.7rem', color: '#666', margin: 0 } }>{ s.description }</p>
							</div>
							<div style={ { width: 80, height: 60, background: '#e5e7eb', borderRadius: '0.25rem', fontSize: '0.55rem', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#999' } }>
								{ s.mediaPosition === 'left' ? '← IMG' : 'IMG →' }
							</div>
						</div>
					) ) }
				</div>
			</div>
		</>
	);
}
