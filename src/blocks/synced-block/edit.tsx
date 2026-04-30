import { useBlockProps } from '@wordpress/block-editor';
import { __, sprintf } from '@wordpress/i18n';

interface Attrs {
	slug: string;
}

interface Props {
	attributes: Attrs;
}

/**
 * Synced Block edit UI — minimal placeholder.
 *
 * This block is `inserter: false` and only appears inside template files
 * (templates/*.html and patterns/*.php), so editors rarely see it directly.
 * The placeholder just confirms which synced pattern this slot will render
 * at the front end. To edit the actual content, editors go to
 * Site Editor → Patterns → "<title>" and edit the wp_block post.
 */
export function SyncedBlockEdit( { attributes }: Props ) {
	const { slug } = attributes;

	return (
		<div
			{ ...useBlockProps( {
				style: {
					background:   '#f5f5f5',
					padding:      '1rem 1.25rem',
					borderRadius: '0.5rem',
					fontFamily:   'sans-serif',
					border:       '1px dashed #c4c4c4',
				},
			} ) }
		>
			<p style={ { fontSize: '0.7rem', color: '#737373', margin: '0 0 0.25rem', fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em' } }>
				{ __( 'Synced Pattern', 'jetpack-theme' ) }
			</p>
			<p style={ { fontSize: '0.85rem', color: '#0a0a0a', margin: 0, fontFamily: 'monospace' } }>
				{ slug
					? sprintf(
						/* translators: %s: synced pattern slug */
						__( 'slug: %s', 'jetpack-theme' ),
						slug
					)
					: __( 'No slug set — this block needs a slug attribute.', 'jetpack-theme' )
				}
			</p>
			<p style={ { fontSize: '0.75rem', color: '#737373', margin: '0.5rem 0 0' } }>
				{ __( 'Edit this content in Site Editor → Patterns.', 'jetpack-theme' ) }
			</p>
		</div>
	);
}
