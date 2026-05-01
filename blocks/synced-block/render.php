<?php
/**
 * Synced Block — slug → wp_block resolver.
 *
 * Synced Patterns (the wp_block CPT) are normally referenced by post ID
 * (`<!-- wp:block {"ref":N} /-->`). Hard-coding IDs in template files makes
 * the theme non-portable across DB exports, so this micro-block resolves a
 * stable `slug` (post_name) to the `wp_block` post at render time and
 * delegates rendering to `do_blocks()`.
 *
 * Inserter is disabled in block.json — this is a template primitive, not a
 * user-facing block. Editors use the Site Editor → Patterns UI to edit the
 * underlying synced patterns.
 *
 * @var array $attributes Block attributes (see block.json).
 */

declare( strict_types=1 );

$slug = isset( $attributes['slug'] ) ? sanitize_title( (string) $attributes['slug'] ) : '';

if ( '' === $slug ) {
	return;
}

$synced = get_page_by_path( $slug, OBJECT, 'wp_block' );

if ( ! $synced instanceof WP_Post || 'publish' !== $synced->post_status ) {
	// Bail silently — the seeder (inc/synced-patterns.php) creates missing
	// posts on admin_init, so a brief gap here is normal on fresh installs.
	return;
}

echo do_blocks( $synced->post_content );
