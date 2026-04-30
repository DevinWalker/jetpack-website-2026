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
		// CSS imported within each view script is extracted to style-{entry}.css
		// and registered via block.json viewStyle/style fields.
		'hero-view':                './src/blocks/hero/view.tsx',
		'hero-card-swap':           './src/blocks/hero/card-swap.tsx',
		'blur-view':                './src/blocks/blur-headline/view.tsx',
		'scroll-animations':        './src/blocks/scroll-animations.ts',
		'features-highlights-view': './src/blocks/features-highlights/view.tsx',

		// FAQ view script — accordion behavior + block styles.
		'faq-view':          './src/blocks/faq/store.ts',

		// Testimonials view script — slider with auto-advance and block styles.
		'testimonials-view': './src/blocks/testimonials/view.ts',

		// Pricing hero view style — CSS-only radial-fade background (no JS).
		'pricing-hero-style': './src/blocks/pricing-hero/style.css',

		// Global interactions (header) — no framework dependencies.
		'interactions':      './src/blocks/site-header/interactions.ts',
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
