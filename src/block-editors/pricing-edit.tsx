import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, ToggleControl } from '@wordpress/components';

interface Plan {
	name: string; price: number; monthlyPrice: number;
	description: string; features: string[]; popular: boolean;
}
interface Attrs { sectionTitle: string; sectionDescription: string; plans: Plan[] }
interface Props { attributes: Attrs; setAttributes: ( a: Partial< Attrs > ) => void }

export function PricingEdit( { attributes, setAttributes }: Props ) {
	const updatePlan = ( i: number, patch: Partial< Plan > ) => {
		setAttributes( { plans: attributes.plans.map( ( p, idx ) => idx === i ? { ...p, ...patch } : p ) } );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title="Section" initialOpen>
					<TextControl label="Title"       value={ attributes.sectionTitle }       onChange={ ( v ) => setAttributes( { sectionTitle: v } ) } />
					<TextareaControl label="Description" value={ attributes.sectionDescription } onChange={ ( v ) => setAttributes( { sectionDescription: v } ) } />
				</PanelBody>
				{ attributes.plans.map( ( plan, i ) => (
					<PanelBody key={ i } title={ `Plan: ${ plan.name }` } initialOpen={ false }>
						<TextControl label="Name"             value={ plan.name }                   onChange={ ( v ) => updatePlan( i, { name: v } ) } />
						<TextControl label="Annual price ($)" value={ String( plan.price ) }        onChange={ ( v ) => updatePlan( i, { price: Number( v ) } ) } type="number" />
						<TextControl label="Monthly price ($)"value={ String( plan.monthlyPrice ) } onChange={ ( v ) => updatePlan( i, { monthlyPrice: Number( v ) } ) } type="number" />
						<TextareaControl label="Description"  value={ plan.description }            onChange={ ( v ) => updatePlan( i, { description: v } ) } />
						<TextareaControl
							label="Features (one per line)"
							value={ plan.features.join( '\n' ) }
							onChange={ ( v ) => updatePlan( i, { features: v.split( '\n' ).filter( Boolean ) } ) }
							rows={ 4 }
						/>
						<ToggleControl label="Most popular" checked={ plan.popular } onChange={ ( v ) => updatePlan( i, { popular: v } ) } />
					</PanelBody>
				) ) }
			</InspectorControls>
			<div { ...useBlockProps( { style: { background: '#f5f5f5', padding: '1.5rem', borderRadius: '0.5rem', fontFamily: 'sans-serif' } } ) }>
				<p style={ { fontSize: '0.7rem', color: '#737373', margin: '0 0 0.25rem' } }>PRICING</p>
				<p style={ { fontWeight: 600, margin: '0 0 0.5rem' } }>{ attributes.sectionTitle }</p>
				<div style={ { display: 'flex', gap: '0.5rem' } }>
					{ attributes.plans.map( ( p ) => (
						<div key={ p.name } style={ { background: p.popular ? '#a8d946' : '#fff', padding: '0.5rem 0.75rem', borderRadius: '0.5rem', fontSize: '0.8rem', fontWeight: 600 } }>
							{ p.name } — ${ p.price }/mo
						</div>
					) ) }
				</div>
			</div>
		</>
	);
}
