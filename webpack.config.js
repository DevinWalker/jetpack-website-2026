const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path          = require( 'path' );

module.exports = {
	...defaultConfig,

	entry: {
		// Block editor UIs — loaded only inside Gutenberg.
		'editor':            './src/editor.tsx',

		// Global CSS — extracts to build/style-frontend.css.
		'frontend':          './src/frontend.js',

		// Per-block view scripts — loaded only when the block is on the page.
		'hero-view':         './src/blocks/hero-view.tsx',
		'blur-view':         './src/blocks/blur-view.tsx',
		'scroll-animations': './src/blocks/scroll-animations.ts',

		// Global interactions (header, FAQ, testimonials) — no framework dependencies.
		'interactions':      './src/blocks/interactions.ts',
	},

	resolve: {
		...defaultConfig.resolve,
		alias: {
			...( defaultConfig.resolve?.alias ?? {} ),
			// Allows `import Foo from '@/components/...'` throughout the theme.
			'@': path.resolve( __dirname, 'src' ),
		},
	},
};
