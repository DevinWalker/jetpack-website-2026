<?php
/**
 * Legacy hero visual block — server render.
 *
 * Temporary compat layer for production content that was authored with the
 * [hero_visual product="…"] shortcode in the jetpackme-new theme. The block
 * includes a product-specific template part under parts/{product}.php which
 * emits either a Category A inline SVG (.product-category-hero-visual) or a
 * Category B <picture> image card (.product-hero-visual).
 *
 * Remove this entire directory once the hero redesign ships.
 *
 * @var array $attributes Block attributes.
 */

declare( strict_types = 1 );

$allowed_products = [
	'agencies', 'ai', 'anti-spam', 'app', 'backup', 'blaze', 'boost',
	'complete', 'creator', 'forms', 'gdpr', 'growth', 'newsletter',
	'performance', 'scan', 'search', 'security', 'social', 'stats',
];

$product = isset( $attributes['product'] ) && in_array( $attributes['product'], $allowed_products, true )
	? $attributes['product']
	: 'security';

$part_path = __DIR__ . '/parts/' . $product . '.php';

if ( ! is_readable( $part_path ) ) {
	return;
}
?>
<div <?php echo wp_kses_data( get_block_wrapper_attributes( [ 'class' => 'jetpack-legacy-hero-visual' ] ) ); ?>>
	<?php include $part_path; ?>
</div>
