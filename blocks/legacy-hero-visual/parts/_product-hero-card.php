<?php
/**
 * Shared .product-hero-visual "card" wrapper — shadow + placeholder + picture.
 *
 * Used by products that follow the legacy shared/product-hero-visual.php
 * pattern (anti-spam, backup, boost, scan, search, stats). Expects the
 * including part to set:
 *   $legacy_hero_path_1x   — path suffix under assets/legacy-hero-visual/
 *   $legacy_hero_path_2x   — 2x path suffix
 *   $legacy_hero_fallback  — optional <img src> fallback for <picture>
 *
 * Mirrors jetpackme-new/parts/shared/product-hero-visual.php markup so the
 * existing CSS in src/compat/legacy-hero-visual.css applies unchanged.
 */

$image_dir = get_template_directory_uri() . '/assets/legacy-hero-visual/';
$extension = pathinfo( $legacy_hero_path_1x, PATHINFO_EXTENSION );
$fallback  = ! empty( $legacy_hero_fallback ) ? $legacy_hero_fallback : $legacy_hero_path_1x;
?>
<div class="product-hero-visual" aria-hidden="true">
	<div class="product-hero-visual__content">
		<?php include __DIR__ . '/_product-hero-color-shadow.php'; ?>
		<div class="product-hero-visual__placeholder"></div>
		<picture>
			<source
				type="<?php echo esc_attr( 'image/' . $extension ); ?>"
				srcset="<?php echo esc_url( $image_dir . $legacy_hero_path_2x ); ?> 2x"
				src="<?php echo esc_url( $image_dir . $legacy_hero_path_1x ); ?>"
			/>
			<img
				class="product-hero-visual__img"
				src="<?php echo esc_url( $image_dir . $fallback ); ?>"
				alt=""
				loading="lazy"
			/>
		</picture>
	</div>
</div>
