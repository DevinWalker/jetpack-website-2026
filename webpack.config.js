const defaultConfig    = require( '@wordpress/scripts/config/webpack.config' );
const path             = require( 'path' );
const BrowserSyncPlugin = require( 'browser-sync-webpack-plugin' );

// Only start BrowserSync during `npm run start` (watch mode), not `npm run build`.
const isWatchMode = process.argv.some( ( arg ) => arg.includes( 'start' ) );

module.exports = {
	...defaultConfig,

	entry: {
		// Block editor UIs — loaded only inside Gutenberg.
		'editor':            './src/editor.tsx',

		// Global CSS — extracts to build/style-frontend.css.
		'frontend':          './src/frontend.js',

		// Per-block view scripts — loaded only when the block is on the page.
		'hero-view':         './src/blocks/hero-view.tsx',
		'hero-card-swap':    './src/blocks/hero-card-swap.tsx',
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

	plugins: [
		...defaultConfig.plugins,
		new BrowserSyncPlugin(
			{
				proxy:  'http://localhost:8882/',
				// Reload whenever webpack emits new JS/CSS, or PHP/HTML templates change.
				files:  [
					'build/**/*.{js,css}',
					'blocks/**/*.php',
					'templates/**/*.html',
					'parts/**/*.html',
				],
				notify: false,
				open:   false,
			},
			{
				// Let webpack's `done` hook trigger the reload — don't double-watch.
				reload:  true,
				disable: ! isWatchMode,
			}
		),
	],
};
