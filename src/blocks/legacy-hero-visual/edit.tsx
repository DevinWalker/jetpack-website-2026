/**
 * Legacy hero-visual block editor UI.
 *
 * Temporary compat block — provides a SelectControl for the `product`
 * attribute and a live preview via ServerSideRender. The live preview pulls
 * the same render.php used on the frontend, so the editor shows the final
 * SVG/image instead of a placeholder.
 *
 * Remove alongside blocks/legacy-hero-visual/ once the hero redesign ships.
 */
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';

interface Attrs {
	product: string;
}

interface Props {
	attributes: Attrs;
	setAttributes: ( a: Partial< Attrs > ) => void;
}

// Keep in sync with blocks/legacy-hero-visual/block.json `attributes.product.enum`
// and the files in blocks/legacy-hero-visual/parts/.
const PRODUCT_OPTIONS: { value: string; label: string }[] = [
	{ value: 'agencies',    label: 'Agencies' },
	{ value: 'ai',          label: 'AI' },
	{ value: 'anti-spam',   label: 'Anti-spam' },
	{ value: 'app',         label: 'App' },
	{ value: 'backup',      label: 'Backup' },
	{ value: 'blaze',       label: 'Blaze' },
	{ value: 'boost',       label: 'Boost' },
	{ value: 'complete',    label: 'Complete' },
	{ value: 'creator',     label: 'Creator' },
	{ value: 'forms',       label: 'Forms' },
	{ value: 'gdpr',        label: 'GDPR' },
	{ value: 'growth',      label: 'Growth' },
	{ value: 'newsletter',  label: 'Newsletter' },
	{ value: 'performance', label: 'Performance' },
	{ value: 'scan',        label: 'Scan' },
	{ value: 'search',      label: 'Search' },
	{ value: 'security',    label: 'Security' },
	{ value: 'social',      label: 'Social' },
	{ value: 'stats',       label: 'Stats' },
];

export function LegacyHeroVisualEdit( { attributes, setAttributes }: Props ) {
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Hero Visual (legacy)', 'jetpack-theme' ) } initialOpen>
					<SelectControl
						label={ __( 'Product', 'jetpack-theme' ) }
						value={ attributes.product }
						options={ PRODUCT_OPTIONS }
						onChange={ ( product ) => setAttributes( { product } ) }
						help={ __( 'Temporary compat block. Will be removed after the hero redesign.', 'jetpack-theme' ) }
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }>
				<ServerSideRender
					block="jetpack-theme/legacy-hero-visual"
					attributes={ attributes }
				/>
			</div>
		</>
	);
}
