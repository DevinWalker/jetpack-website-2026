<?php
/**
 * Synced Patterns — theme-seeded wp_block (Reusable Block) posts.
 *
 * Defines a small registry of Synced Patterns the theme expects to exist
 * (currently the homepage compact pricing section and the pricing-page full
 * pricing section), and seeds them as `wp_block` CPT posts on first run.
 *
 * The seeder is idempotent: if a post with the same `post_name` (slug)
 * already exists, it is left untouched. This means editor changes via
 * Site Editor → Patterns are never overwritten, even on theme reactivation.
 *
 * Pages embed these patterns via the `jetpack-theme/synced-block` micro-block,
 * which resolves slug → `wp_block` post at render time. That keeps templates
 * portable across DB exports — no hard-coded post IDs.
 *
 * @package Jetpack_Theme
 */

declare( strict_types=1 );

if ( ! function_exists( 'jetpack_theme_synced_pattern_definitions' ) ) {
	/**
	 * Returns the canonical list of theme-managed Synced Patterns.
	 *
	 * Each entry maps a stable slug (used as the `post_name` of the wp_block
	 * post and the `slug` attribute on `jetpack-theme/synced-block` calls)
	 * to its title and serialized block content.
	 *
	 * @return array<string,array{title:string,content:string}>
	 */
	function jetpack_theme_synced_pattern_definitions(): array {
		$compact_content = <<<'HTML'
<!-- wp:group {"tagName":"section","className":"jetpack-pricing-home-section","style":{"spacing":{"padding":{"top":"clamp(3rem,5vw,5rem)","bottom":"clamp(3rem,5vw,5rem)","left":"1.5rem","right":"1.5rem"}}},"layout":{"type":"constrained","contentSize":"72rem"}} -->
<section class="wp-block-group jetpack-pricing-home-section" style="padding-top:clamp(3rem,5vw,5rem);padding-right:1.5rem;padding-bottom:clamp(3rem,5vw,5rem);padding-left:1.5rem">

	<!-- wp:paragraph {"align":"center","className":"jetpack-pricing-eyebrow","fontSize":"x-small","style":{"typography":{"fontWeight":"600","letterSpacing":"0.08em","textTransform":"uppercase"}},"textColor":"jetpack-green-60"} -->
	<p class="has-text-align-center jetpack-pricing-eyebrow has-jetpack-green-60-color has-text-color has-x-small-font-size" style="font-weight:600;letter-spacing:0.08em;text-transform:uppercase">Plans</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"500","letterSpacing":"-0.02em","lineHeight":"1.1"}},"fontSize":"xx-large"} -->
	<h2 class="wp-block-heading has-text-align-center has-xx-large-font-size" style="font-weight:500;letter-spacing:-0.02em;line-height:1.1">Simple, transparent pricing.</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","textColor":"muted-foreground","fontSize":"medium","style":{"typography":{"lineHeight":"1.6"},"spacing":{"margin":{"bottom":"clamp(2rem,3vw,3rem)"}}}} -->
	<p class="has-text-align-center has-muted-foreground-color has-text-color has-medium-font-size" style="margin-bottom:clamp(2rem,3vw,3rem);line-height:1.6">Flat-recurring pricing with no first-year tricks. <a href="/pricing/">See the full comparison →</a></p>
	<!-- /wp:paragraph -->

	<!-- wp:jetpack-theme/pricing-table {"variant":"compact","compactFeatureCount":4,"highlightedPlan":"pro","showEyebrow":false} /-->

</section>
<!-- /wp:group -->
HTML;

		$full_content = '<!-- wp:jetpack-theme/pricing-table {"variant":"full","showEyebrow":false,"highlightedPlan":"pro"} /-->';

		return [
			'jetpack-pricing-section-full'    => [
				'title'   => __( 'Jetpack Pricing — Full', 'jetpack-theme' ),
				'content' => $full_content,
			],
			'jetpack-pricing-section-compact' => [
				'title'   => __( 'Jetpack Pricing — Compact', 'jetpack-theme' ),
				'content' => $compact_content,
			],
		];
	}
}

if ( ! function_exists( 'jetpack_theme_seed_synced_patterns' ) ) {
	/**
	 * Seed (or re-seed missing) theme-managed Synced Patterns.
	 *
	 * Idempotent: existing wp_block posts (matched by post_name/slug) are
	 * left alone. Only missing posts are inserted. This protects editor
	 * changes from being clobbered on theme reactivation.
	 *
	 * Hooked to `after_switch_theme` (initial install) and `admin_init`
	 * (idempotent fallback for installs that skipped the activation event,
	 * e.g. theme files copied in directly).
	 */
	function jetpack_theme_seed_synced_patterns(): void {
		// Cheap one-call-per-request guard: the admin_init fallback would
		// otherwise re-run get_page_by_path() on every admin page load.
		static $ran_this_request = false;
		if ( $ran_this_request ) {
			return;
		}
		$ran_this_request = true;

		foreach ( jetpack_theme_synced_pattern_definitions() as $slug => $def ) {
			$existing = get_page_by_path( $slug, OBJECT, 'wp_block' );
			if ( $existing instanceof WP_Post ) {
				continue;
			}

			wp_insert_post( [
				'post_type'    => 'wp_block',
				'post_status'  => 'publish',
				'post_title'   => $def['title'],
				'post_name'    => $slug,
				'post_content' => $def['content'],
			] );
		}
	}
}

add_action( 'after_switch_theme', 'jetpack_theme_seed_synced_patterns' );
add_action( 'admin_init',         'jetpack_theme_seed_synced_patterns' );
