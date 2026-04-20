<?php
/**
 * Jetpack Theme — functions.php
 *
 * Handles: theme setup, navigation menus, script/style enqueueing,
 * block registration, and passing WordPress data to the React app.
 */

declare( strict_types = 1 );

// ─── Taxonomies ──────────────────────────────────────────────────────────────
// Registers the 'topics' taxonomy used by blog posts and the resources-posts block.

require_once get_template_directory() . '/inc/taxonomies.php';

// ─── Development: proxy media from production ─────────────────────────────────
// On local and staging environments, uploaded media won't exist locally.
// These filters rewrite attachment image URLs to jetpack.com so every image
// renders without needing a full media sync.
//
// Override the production host via wp-config.php if needed:
//   define( 'JETPACK_PRODUCTION_URL', 'https://staging.jetpack.com' );

if ( ! defined( 'JETPACK_PRODUCTION_URL' ) ) {
	define( 'JETPACK_PRODUCTION_URL', 'https://jetpack.com' );
}

/**
 * Returns true only when running on the real production site.
 */
function jetpack_is_production(): bool {
	$host = (string) wp_parse_url( home_url(), PHP_URL_HOST );
	return in_array( $host, [ 'jetpack.com', 'www.jetpack.com' ], true );
}

if ( ! jetpack_is_production() ) {

/**
 * Rewrite a single URL from the local domain to the production domain.
 * Only rewrites URLs that already start with the local origin; external hosts are left alone.
 */
function jetpack_proxy_to_production( string $url ): string {
	static $local, $prod;
	$local ??= untrailingslashit( home_url() );
	$prod  ??= untrailingslashit( JETPACK_PRODUCTION_URL );

	if ( str_starts_with( $url, $local ) ) {
		$url = $prod . substr( $url, strlen( $local ) );
	}

	return $url;
}

/**
 * Rewrite a single URL from the production domain to the local domain.
 * Inverse of jetpack_proxy_to_production(). Only rewrites URLs that start
 * with the production origin; external hosts are left alone.
 */
function jetpack_localize_url( string $url ): string {
	static $local, $prod;
	$local ??= untrailingslashit( home_url() );
	$prod  ??= untrailingslashit( JETPACK_PRODUCTION_URL );

	if ( str_starts_with( $url, $prod ) ) {
		$url = $local . substr( $url, strlen( $prod ) );
	}

	return $url;
}

	// Single attachment URL (used by wp_get_attachment_image, post-featured-image block, etc.).
	add_filter( 'wp_get_attachment_url', 'jetpack_proxy_to_production' );

	// srcset candidates so responsive images also resolve on production.
	add_filter( 'wp_calculate_image_srcset', function ( array $sources ): array {
		foreach ( $sources as $width => $source ) {
			$sources[ $width ]['url'] = jetpack_proxy_to_production( $source['url'] );
		}
		return $sources;
	} );

	// Inline src/srcset within rendered post content (covers hard-coded block markup).
	// Scoped to image attributes only so that href navigation links stay on the local origin.
	add_filter( 'the_content', function ( string $content ): string {
		return preg_replace_callback(
			'/\b(src|srcset)="([^"]*)"/i',
			fn( array $m ): string => $m[1] . '="' . jetpack_proxy_to_production( $m[2] ) . '"',
			$content
		);
	} );

	// Rewrite canonical href links in block-template HTML (e.g. archive-jetpack_support.html)
	// from the production origin to the local origin. Keeps template files free of hardcoded
	// local URLs while still making navigation work locally.
	add_filter( 'render_block', function ( string $block_content ): string {
		$prod_origin = preg_quote( untrailingslashit( JETPACK_PRODUCTION_URL ), '/' );
		return preg_replace_callback(
			'/\bhref="(' . $prod_origin . '[^"]*)"/i',
			fn( array $m ): string => 'href="' . esc_url( jetpack_localize_url( $m[1] ) ) . '"',
			$block_content
		);
	} );
}

// ─── Local dev: author name fallback ─────────────────────────────────────────
// Production posts reference WordPress.com user IDs that don't exist in the
// local Studio DB. Filter the_author so cards show a placeholder instead of
// rendering empty. This filter only runs outside production.

if ( ! jetpack_is_production() ) {
	add_filter( 'the_author', function ( ?string $name ): string {
		if ( ! empty( $name ) ) {
			return $name;
		}
		// Attempt to get the name from wp_usermeta cached during import,
		// then fall back to a readable placeholder.
		global $post;
		if ( ! empty( $post->post_author ) ) {
			$cached = get_user_meta( (int) $post->post_author, 'display_name', true );
			if ( ! empty( $cached ) ) {
				return $cached;
			}
		}
		return 'Jetpack Team';
	} );
}

// ─── Gravatar / Avatar ───────────────────────────────────────────────────────
// WordPress 6.9 calls https://secure.gravatar.com/avatar/{sha256_hash} with a
// 2× srcset automatically. The pre_get_avatar_data filter lets us guarantee
// sensible defaults across all environments.

add_filter( 'pre_get_avatar_data', function ( array $args ): array {
	// Request rating-safe images (G-rated only).
	$args['rating'] = 'g';

	// When no Gravatar photo exists, show the user's initials (WP 6.9+).
	// Falls back to mystery-person silhouette on older installs.
	if ( empty( $args['default'] ) || 'mystery' === $args['default'] ) {
		$args['default'] = 'initials';
	}

	// Force HTTPS — secure.gravatar.com is always used, but be explicit.
	$args['scheme'] = 'https';

	return $args;
} );

// ─── Theme Setup ─────────────────────────────────────────────────────────────

add_action( 'after_setup_theme', function (): void {
	// Opt into WP's default block CSS. Not auto-enabled — all others below are.
	add_theme_support( 'wp-block-styles' );

	// Navigation menu locations.
	register_nav_menus( [
		'primary'          => __( 'Primary Navigation', 'jetpack-theme' ),
		'footer-company'   => __( 'Footer – Company', 'jetpack-theme' ),
		'footer-resources' => __( 'Footer – Resources', 'jetpack-theme' ),
		'footer-social'    => __( 'Footer – Social', 'jetpack-theme' ),
	] );
} );

// ─── Helpers: convert WP menus to structured arrays ──────────────────────────

/**
 * Build a tree structure from flat menu items.
 */
function jetpack_build_nav_tree( array $items ): array {
	$map   = [];
	$roots = [];

	foreach ( $items as $item ) {
		$map[ $item['id'] ] = array_merge( $item, [ 'children' => [] ] );
	}
	foreach ( $map as $id => $item ) {
		if ( $item['parent'] && isset( $map[ $item['parent'] ] ) ) {
			$map[ $item['parent'] ]['children'][] = &$map[ $id ];
		} else {
			$roots[] = &$map[ $id ];
		}
	}

	return $roots;
}

function jetpack_get_menu( string $location ): array {
	$locations = get_nav_menu_locations();

	if ( empty( $locations[ $location ] ) ) {
		return [];
	}

	$items = wp_get_nav_menu_items( $locations[ $location ] );

	if ( ! $items ) {
		return [];
	}

	return array_values( array_map( static fn( \WP_Post $item ): array => [
		'id'     => (int) $item->ID,
		'label'  => (string) $item->title,
		'url'    => (string) $item->url,
		'parent' => (int) $item->menu_item_parent,
	], $items ) );
}

// ─── Enqueue Global Styles ────────────────────────────────────────────────────
// Individual view scripts are enqueued by block.json viewScript / viewScriptModule.
// Only global CSS and the Geist font are registered here.

add_action( 'wp_enqueue_scripts', function (): void {
	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	// Geist font.
	wp_enqueue_style(
		'jetpack-theme-geist',
		'https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Geist+Mono:wght@100..900&display=swap',
		[],
		null
	);

	// Global Tailwind stylesheet — extracted from the 'frontend' webpack entry.
	$css_file = $theme_dir . '/build/style-frontend.css';
	wp_enqueue_style(
		'jetpack-theme-style',
		$theme_uri . '/build/style-frontend.css',
		[ 'jetpack-theme-geist' ],
		file_exists( $css_file ) ? filemtime( $css_file ) : '1.0.0'
	);

	// Global interactions script (header, testimonials).
	$int_asset = $theme_dir . '/build/interactions.asset.php';
	$int_data  = file_exists( $int_asset ) ? require $int_asset : [ 'dependencies' => [], 'version' => '1.0.0' ];
	wp_enqueue_script(
		'jetpack-theme-interactions',
		$theme_uri . '/build/interactions.js',
		$int_data['dependencies'],
		$int_data['version'],
		true
	);

	// Scroll animations — loaded globally so production media-text sections
	// on product pages get entrance animations even without bento/pricing blocks.
	$sa_asset = $theme_dir . '/build/scroll-animations.asset.php';
	$sa_data  = file_exists( $sa_asset ) ? require $sa_asset : [ 'dependencies' => [], 'version' => '1.0.0' ];
	wp_enqueue_script(
		'jetpack-theme-scroll-animations',
		$theme_uri . '/build/scroll-animations.js',
		$sa_data['dependencies'],
		$sa_data['version'],
		true
	);
} );

// ─── Enqueue Block Editor Assets ─────────────────────────────────────────────

add_action( 'enqueue_block_editor_assets', function (): void {
	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	$asset_file = $theme_dir . '/build/editor.asset.php';
	$asset      = file_exists( $asset_file )
		? require $asset_file
		: [ 'dependencies' => [ 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components' ], 'version' => '1.0.0' ];

	wp_enqueue_script(
		'jetpack-editor',
		$theme_uri . '/build/editor.js',
		$asset['dependencies'],
		$asset['version'],
		true
	);

	wp_add_inline_script(
		'jetpack-editor',
		'window.jetpackThemeData=' . wp_json_encode( [ 'homeUrl' => untrailingslashit( home_url() ) ] ) . ';',
		'before'
	);
} );

// ─── Register Custom Blocks ───────────────────────────────────────────────────

add_action( 'init', function (): void {
	$blocks_dir = get_template_directory() . '/blocks';

	$block_slugs = [
		'hero',
		'blur-headline',
		'features-highlights',
		'features-bento',
		'testimonials',
		'pricing',
		'faq',
		'site-header',
		'site-footer',
	];

	foreach ( $block_slugs as $slug ) {
		$block_path = $blocks_dir . '/' . $slug;
		if ( is_dir( $block_path ) ) {
			register_block_type( $block_path );
		}
	}
} );

// ─── Register Block Styles for Production Compatibility ──────────────────────
// Production Jetpack.com uses these custom block styles on core blocks.
// Registering them ensures content authored on production renders correctly.

add_action( 'init', function (): void {
	$paragraph_icon_styles = [
		'growth', 'performance', 'key', 'stats', 'social', 'newsletter',
		'blaze', 'cloud', 'shield', 'videopress', 'search', 'antispam',
	];
	foreach ( $paragraph_icon_styles as $variant ) {
		register_block_style( 'core/paragraph', [
			'name'  => 'jetpack-with-' . $variant . '-icon',
			'label' => ucfirst( $variant ) . ' Icon',
		] );
	}

	register_block_style( 'core/paragraph', [
		'name'  => 'jetpack-paid-feature-label',
		'label' => 'Paid Feature Label',
	] );

	register_block_style( 'core/paragraph', [
		'name'  => 'jetpack-partners-intro',
		'label' => 'Partners Intro',
	] );

	register_block_style( 'core/paragraph', [
		'name'  => 'jetpack-quote',
		'label' => 'Jetpack Quote',
	] );

	register_block_style( 'core/list', [
		'name'  => 'jetpack-checklist',
		'label' => 'Jetpack Checklist',
	] );

	register_block_style( 'core/button', [
		'name'  => 'jetpack-button',
		'label' => 'Jetpack Button',
	] );

	// ── Blog layout styles ───────────────────────────────────────────────────
	// Opt-in styles for the modernized blog-4 single-post and blog-1 archive
	// layouts. Applied automatically by the single.html / index.html templates
	// via className attributes; also available in the block editor UI.

	register_block_style( 'core/post-content', [
		'name'  => 'jetpack-article',
		'label' => 'Jetpack Article',
	] );

	register_block_style( 'core/group', [
		'name'  => 'jetpack-post-header',
		'label' => 'Jetpack Post Header',
	] );

	register_block_style( 'core/post-featured-image', [
		'name'  => 'jetpack-hero',
		'label' => 'Jetpack Hero',
	] );

	register_block_style( 'core/query', [
		'name'  => 'jetpack-card-grid',
		'label' => 'Jetpack Card Grid',
	] );
} );

// ─── Viewport Frame & Corner Decorations ─────────────────────────────────────
// Mirrors the fixed border frame from the Next.js layout.tsx.

add_action( 'wp_body_open', function (): void {
	?>
	<?php /* Decorative color-blob corner used on .hero-with-icon product pages. */ ?>
	<div class="jetpack-corner-blobs" aria-hidden="true">
		<div class="blob-green"></div>
		<div class="blob-blue"></div>
		<div class="blob-yellow"></div>
	</div>

	<?php /* Decorative line-art corner used on .partner-hero pages. */ ?>
	<div class="jetpack-corner-lineart" aria-hidden="true">
		<picture>
			<source media="(min-width: 783px)" srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/landing-pages/a8c-lineart-desktop.svg' ); ?>">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/landing-pages/a8c-lineart-mobile.svg' ); ?>" alt="">
		</picture>
	</div>

	<div class="site-frame site-frame--top" aria-hidden="true"></div>
	<div class="site-frame site-frame--bottom" aria-hidden="true"></div>
	<div class="site-frame site-frame--left" aria-hidden="true"></div>
	<div class="site-frame site-frame--right" aria-hidden="true"></div>

	<svg class="site-corner site-corner--top-left" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
		<path d="M5.50871e-06 0C-0.00788227 37.3001 8.99616 50.0116 50 50H5.50871e-06V0Z" fill="currentColor"/>
	</svg>
	<svg class="site-corner site-corner--top-right" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
		<path d="M5.50871e-06 0C-0.00788227 37.3001 8.99616 50.0116 50 50H5.50871e-06V0Z" fill="currentColor"/>
	</svg>
	<svg class="site-corner site-corner--bottom-left" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
		<path d="M5.50871e-06 0C-0.00788227 37.3001 8.99616 50.0116 50 50H5.50871e-06V0Z" fill="currentColor"/>
	</svg>
	<svg class="site-corner site-corner--bottom-right" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
		<path d="M5.50871e-06 0C-0.00788227 37.3001 8.99616 50.0116 50 50H5.50871e-06V0Z" fill="currentColor"/>
	</svg>
	<?php
} );

// ─── Register jetpack_support CPT ────────────────────────────────────────────
// Production jetpack.com serves /support/ as the archive of this CPT.
// Registering it locally stops WordPress redirect_canonical from fuzzy-matching
// the slug to unrelated blog posts.

add_action( 'init', function (): void {
	register_post_type( 'jetpack_support', [
		'public'       => true,
		'has_archive'  => 'support',
		'rewrite'      => [ 'slug' => 'support', 'with_front' => false ],
		'show_ui'      => false,
		'show_in_rest' => true,
		'labels'       => [
			'name'          => 'Support',
			'singular_name' => 'Support Article',
		],
	] );
} );

// ─── Register Block Pattern Category ─────────────────────────────────────────

add_action( 'init', function (): void {
	register_block_pattern_category( 'jetpack-theme', [
		'label' => __( 'Jetpack Theme', 'jetpack-theme' ),
	] );
} );

// ─── Register Custom Block Category ──────────────────────────────────────────

add_filter( 'block_categories_all', function ( array $categories ): array {
	array_unshift( $categories, [
		'slug'  => 'jetpack-theme',
		'title' => __( 'Jetpack Theme', 'jetpack-theme' ),
		'icon'  => null,
	] );
	return $categories;
} );
