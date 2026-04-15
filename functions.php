<?php
/**
 * Jetpack Theme — functions.php
 *
 * Handles: theme setup, navigation menus, script/style enqueueing,
 * block registration, and passing WordPress data to the React app.
 */

declare( strict_types = 1 );

// ─── Theme Setup ─────────────────────────────────────────────────────────────

add_action( 'after_setup_theme', function (): void {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

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

	// Global interactions script (header, FAQ, testimonials).
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
} );

// ─── Viewport Frame & Corner Decorations ─────────────────────────────────────
// Mirrors the fixed border frame from the Next.js layout.tsx.

add_action( 'wp_body_open', function (): void {
	?>
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

// ─── Register Custom Block Category ──────────────────────────────────────────

add_filter( 'block_categories_all', function ( array $categories ): array {
	array_unshift( $categories, [
		'slug'  => 'jetpack-theme',
		'title' => __( 'Jetpack Theme', 'jetpack-theme' ),
		'icon'  => null,
	] );
	return $categories;
} );
