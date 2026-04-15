import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

interface BentoAttrs {
	stepByStep:  { title: string; subtitle: string };
	dashboard:   { title: string; subtitle: string };
	trustedBy:   { count: string; rating: string; reviewCount: string };
	builtToScale:{ title: string; subtitle: string };
}
interface Props { attributes: BentoAttrs; setAttributes: ( a: Partial< BentoAttrs > ) => void }

export function FeaturesBentoEdit( { attributes, setAttributes }: Props ) {
	return (
		<>
			<InspectorControls>
				<PanelBody title="Guided Onboarding Card" initialOpen>
					<TextControl label="Title"    value={ attributes.stepByStep.title }    onChange={ ( v ) => setAttributes( { stepByStep: { ...attributes.stepByStep, title: v } } ) } />
					<TextControl label="Subtitle" value={ attributes.stepByStep.subtitle } onChange={ ( v ) => setAttributes( { stepByStep: { ...attributes.stepByStep, subtitle: v } } ) } />
				</PanelBody>
				<PanelBody title="Real-time Data Card" initialOpen={ false }>
					<TextControl label="Title"    value={ attributes.dashboard.title }    onChange={ ( v ) => setAttributes( { dashboard: { ...attributes.dashboard, title: v } } ) } />
					<TextControl label="Subtitle" value={ attributes.dashboard.subtitle } onChange={ ( v ) => setAttributes( { dashboard: { ...attributes.dashboard, subtitle: v } } ) } />
				</PanelBody>
				<PanelBody title="Trusted By Card" initialOpen={ false }>
					<TextControl label="Count (e.g. 27 million)" value={ attributes.trustedBy.count }       onChange={ ( v ) => setAttributes( { trustedBy: { ...attributes.trustedBy, count: v } } ) } />
					<TextControl label="Star rating"             value={ attributes.trustedBy.rating }      onChange={ ( v ) => setAttributes( { trustedBy: { ...attributes.trustedBy, rating: v } } ) } />
					<TextControl label="Review count (e.g. 48k+)" value={ attributes.trustedBy.reviewCount } onChange={ ( v ) => setAttributes( { trustedBy: { ...attributes.trustedBy, reviewCount: v } } ) } />
				</PanelBody>
				<PanelBody title="Built to Scale Card" initialOpen={ false }>
					<TextControl label="Title"    value={ attributes.builtToScale.title }    onChange={ ( v ) => setAttributes( { builtToScale: { ...attributes.builtToScale, title: v } } ) } />
					<TextControl label="Subtitle" value={ attributes.builtToScale.subtitle } onChange={ ( v ) => setAttributes( { builtToScale: { ...attributes.builtToScale, subtitle: v } } ) } />
				</PanelBody>
			</InspectorControls>
			<div
				{ ...useBlockProps( {
					style: { background: '#e8f5c8', padding: '1.5rem', borderRadius: '0.5rem', fontFamily: 'sans-serif' },
				} ) }
			>
				<p style={ { fontSize: '0.7rem', color: '#737373', margin: '0 0 0.5rem' } }>FEATURES BENTO GRID</p>
				<div style={ { display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '0.5rem' } }>
					{ [
						attributes.stepByStep.title,
						attributes.dashboard.title,
						`Trusted By ${ attributes.trustedBy.count }`,
						attributes.builtToScale.title,
					].map( ( t, i ) => (
						<div key={ i } style={ { background: '#fff', padding: '0.75rem', borderRadius: '0.5rem', fontSize: '0.8rem', fontWeight: 600 } }>
							{ t }
						</div>
					) ) }
				</div>
			</div>
		</>
	);
}
