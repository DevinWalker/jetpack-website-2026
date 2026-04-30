import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, CheckboxControl, SelectControl, RadioControl, ToggleControl, RangeControl } from '@wordpress/components';
import { __, sprintf } from '@wordpress/i18n';

type PlanSlug = 'basic' | 'pro' | 'agency';

interface Attrs {
	visiblePlans:        PlanSlug[];
	variant:             'full' | 'compact';
	highlightedPlan:     PlanSlug;
	showEyebrow:         boolean;
	compactFeatureCount: number;
}

interface Props {
	attributes:    Attrs;
	setAttributes: ( a: Partial< Attrs > ) => void;
}

const ALL_SLUGS: PlanSlug[] = [ 'basic', 'pro', 'agency' ];

const PLAN_LABELS: Record< PlanSlug, string > = {
	basic:  'Basic',
	pro:    'Pro',
	agency: 'Agency',
};

/**
 * Pricing Table edit UI — static preview + inspector controls.
 * Plan data itself lives in inc/pricing-data.php; editors only pick which
 * plans are shown, the layout variant, and which plan is highlighted.
 */
export function PricingTableEdit( { attributes, setAttributes }: Props ) {
	const { visiblePlans, variant, highlightedPlan, showEyebrow, compactFeatureCount } = attributes;
	const isCompact = variant === 'compact';

	const togglePlan = ( slug: PlanSlug, checked: boolean ) => {
		const next = checked
			? Array.from( new Set( [ ...visiblePlans, slug ] ) )
			: visiblePlans.filter( ( s ) => s !== slug );
		// Always keep at least one plan visible.
		setAttributes( { visiblePlans: ( next.length > 0 ? next : [ slug ] ) as PlanSlug[] } );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Visible plans', 'jetpack-theme' ) } initialOpen>
					{ ALL_SLUGS.map( ( slug ) => (
						<CheckboxControl
							key={ slug }
							label={ PLAN_LABELS[ slug ] }
							checked={ visiblePlans.includes( slug ) }
							onChange={ ( checked ) => togglePlan( slug, checked ) }
						/>
					) ) }
				</PanelBody>

				<PanelBody title={ __( 'Layout', 'jetpack-theme' ) } initialOpen={ false }>
					<SelectControl
						label={ __( 'Variant', 'jetpack-theme' ) }
						value={ variant }
						options={ [
							{ value: 'full',    label: __( 'Full (spacious)', 'jetpack-theme' ) },
							{ value: 'compact', label: __( 'Compact (tighter spacing)', 'jetpack-theme' ) },
						] }
						onChange={ ( v ) => setAttributes( { variant: v as Attrs['variant'] } ) }
					/>
					{ isCompact && (
						<RangeControl
							label={ __( 'Compact features per plan', 'jetpack-theme' ) }
							help={ __( 'Number of feature bullets to show per card in the compact variant. Full variant always shows the complete list.', 'jetpack-theme' ) }
							value={ compactFeatureCount }
							min={ 1 }
							max={ 12 }
							onChange={ ( v ) => setAttributes( { compactFeatureCount: typeof v === 'number' ? v : 4 } ) }
						/>
					) }
					<RadioControl
						label={ __( 'Highlighted plan', 'jetpack-theme' ) }
						selected={ highlightedPlan }
						options={ ALL_SLUGS.map( ( slug ) => ( { label: PLAN_LABELS[ slug ], value: slug } ) ) }
						onChange={ ( v ) => setAttributes( { highlightedPlan: v as PlanSlug } ) }
					/>
					<ToggleControl
						label={ __( 'Show "Plans" eyebrow', 'jetpack-theme' ) }
						help={ __( 'Turn on when the block is used outside the main pricing page and needs its own section label.', 'jetpack-theme' ) }
						checked={ showEyebrow }
						onChange={ ( v ) => setAttributes( { showEyebrow: v } ) }
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
				<p style={ { fontSize: '0.7rem', color: '#737373', margin: '0 0 0.5rem', fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em' } }>
					{ __( 'Pricing Table', 'jetpack-theme' ) } — { variant }
					{ isCompact && (
						<>
							{ ' ' }
							{ sprintf(
								/* translators: %d: number of features shown per plan in the compact variant */
								__( '(top %d features)', 'jetpack-theme' ),
								compactFeatureCount
							) }
						</>
					) }
				</p>
				<div style={ { display: 'flex', gap: '0.5rem', flexWrap: 'wrap' } }>
					{ visiblePlans.map( ( slug ) => {
						const popular = slug === highlightedPlan;
						return (
							<div
								key={ slug }
								style={ {
									background:   popular ? '#069e08' : '#ffffff',
									color:        popular ? '#ffffff' : '#0a0a0a',
									padding:      '0.5rem 0.75rem',
									borderRadius: '0.5rem',
									fontSize:     '0.85rem',
									fontWeight:   600,
									border:       popular ? 'none' : '1px solid #e5e5e5',
								} }
							>
								{ PLAN_LABELS[ slug ] }{ popular ? ' ★' : '' }
							</div>
						);
					} ) }
				</div>
				{ visiblePlans.length === 0 && (
					<p style={ { color: '#b91c1c', fontSize: '0.8rem', marginTop: '0.5rem' } }>
						{ __( 'Select at least one plan above.', 'jetpack-theme' ) }
					</p>
				) }
			</div>
		</>
	);
}
