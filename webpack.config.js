const defaultConfig    = require( '@wordpress/scripts/config/webpack.config' );
const path             = require( 'path' );
const fs               = require( 'fs' );
const { execFileSync } = require( 'child_process' );
const BrowserSyncPlugin = require( 'browser-sync-webpack-plugin' );

// Only start BrowserSync during watch/dev mode, not one-shot production builds.
// `wp-scripts start` spawns `webpack watch …` (not `webpack start`), and also
// supports `--hot` which prepends `serve` instead — handle both.
const isWatchMode = process.argv.some( ( arg ) => arg === 'watch' || arg === 'serve' );

/**
 * Resolve the Studio port that BrowserSync should proxy.
 *
 * Each Studio site this theme is checked out into runs on its own port (e.g.
 * jetpack2026 on 8882, jetpack2026-copy on 8881). Hardcoding the port in this
 * file silently breaks any other worktree the moment a second agent / dev
 * clones the repo and runs `bun run start` — BrowserSync ends up proxying
 * the wrong Studio site and edits made here appear to do nothing.
 *
 * Resolution order:
 *   1. $STUDIO_PORT — explicit override (CI, non-Studio environments).
 *   2. `studio site status --format json` — the blessed source of truth per
 *      STUDIO.md ("Always retrieve the current URL with `studio site status`
 *      rather than hardcoding it"). Walks up from this file to find the WP
 *      root (the dir containing wp-config.php) and queries Studio for it.
 *   3. Throw — better to fail loud than silently proxy the wrong site.
 *
 * Only invoked in watch mode; production builds skip it entirely.
 */
function resolveStudioPort() {
	if ( process.env.STUDIO_PORT ) {
		return process.env.STUDIO_PORT;
	}

	// Walk up from this file looking for wp-config.php — that's the Studio
	// site root. From wp-content/themes/<theme>/webpack.config.js we expect
	// to find it three levels up, but we walk just in case the layout shifts.
	let dir = __dirname;
	while ( dir !== path.dirname( dir ) ) {
		if ( fs.existsSync( path.join( dir, 'wp-config.php' ) ) ) {
			break;
		}
		dir = path.dirname( dir );
	}

	if ( ! fs.existsSync( path.join( dir, 'wp-config.php' ) ) ) {
		throw new Error(
			'[webpack] Could not locate the Studio site root (no wp-config.php found above this theme). ' +
			'Set STUDIO_PORT=<port> in your environment.'
		);
	}

	let raw;
	try {
		raw = execFileSync(
			'studio',
			[ 'site', 'status', '--format', 'json', '--path', dir ],
			{ encoding: 'utf8', stdio: [ 'ignore', 'pipe', 'ignore' ] }
		);
	} catch ( err ) {
		throw new Error(
			'[webpack] Failed to run `studio site status` (is the Studio CLI installed and the site running?). ' +
			'Either start the site in Studio, or set STUDIO_PORT=<port> to override. ' +
			`Underlying error: ${ err.message }`
		);
	}

	// Studio prints spinner/ANSI noise to stdout before the JSON payload, so
	// extract the first {...} block rather than calling JSON.parse on raw output.
	const match = raw.match( /\{[\s\S]*\}/ );
	if ( ! match ) {
		throw new Error( '[webpack] `studio site status` returned no JSON payload.' );
	}

	const status = JSON.parse( match[ 0 ] );
	const url    = new URL( status.siteUrl );
	const port   = url.port || ( url.protocol === 'https:' ? '443' : '80' );

	// eslint-disable-next-line no-console
	console.log( `[webpack] Detected Studio site at ${ status.siteUrl } — BrowserSync will proxy port ${ port }.` );
	return port;
}

const studioPort = isWatchMode ? resolveStudioPort() : null;

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
				proxy:  `http://localhost:${ studioPort }/`,
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
