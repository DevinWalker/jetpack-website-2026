import { useBlockProps } from '@wordpress/block-editor';

export function FooterDevColumnEdit() {
	return (
		<div { ...useBlockProps( { style: { background: '#a8d946', padding: '1rem', borderRadius: '0.5rem', fontFamily: 'sans-serif' } } ) }>
			<p style={ { fontSize: '0.7rem', color: 'rgba(0,0,0,0.5)', margin: '0 0 0.25rem' } }>FOOTER DEV COLUMN</p>
			<p style={ { fontSize: '0.85rem', margin: 0 } }>Server-rendered. Shows Style Guide / Typography / Default Blocks links on non-production environments only.</p>
		</div>
	);
}
