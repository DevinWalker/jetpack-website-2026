<?php
/**
 * Pricing data — single source of truth for the pricing-hero, pricing-table,
 * and pricing-comparison blocks.
 *
 * Pricing model: flat recurring (no first-year discount). Each paid plan has
 * one yearly price that stays the same every renewal. Volume discounts exist
 * only on the Agency tier (via Automattic for Agencies).
 *
 * @package Jetpack_Theme
 */

declare( strict_types=1 );

// ── Signup / checkout URLs (canonical, centrally overrideable) ──────────────
if ( ! defined( 'JETPACK_CHECKOUT_BASIC' ) ) {
	define( 'JETPACK_CHECKOUT_BASIC', 'https://jetpack.com/redirect/?source=plans-basic-checkout' );
}
if ( ! defined( 'JETPACK_CHECKOUT_PRO' ) ) {
	define( 'JETPACK_CHECKOUT_PRO', 'https://jetpack.com/redirect/?source=plans-pro-checkout' );
}
if ( ! defined( 'JETPACK_CHECKOUT_AGENCY' ) ) {
	define( 'JETPACK_CHECKOUT_AGENCY', 'https://agencies.automattic.com/' );
}
if ( ! defined( 'JETPACK_FREE_DOWNLOAD_URL' ) ) {
	define( 'JETPACK_FREE_DOWNLOAD_URL', 'https://wordpress.org/plugins/jetpack/' );
}

if ( ! function_exists( 'jetpack_theme_pricing_data' ) ) {
	/**
	 * Returns the full pricing dataset consumed by all pricing blocks.
	 *
	 * Plan shape:
	 *   slug, name, tagline, popular (bool), cta {text, url},
	 *   price { per_month, per_year_label, savings_label (optional) },
	 *   features [string]
	 *
	 * @return array<string,mixed>
	 */
	function jetpack_theme_pricing_data(): array {
		static $data = null;
		if ( null !== $data ) {
			return $data;
		}

		$data = [
			// ── Paid plans ───────────────────────────────────────────────
			'plans' => [
				[
					'slug'    => 'basic',
					'name'    => __( 'Basic', 'jetpack-theme' ),
					'tagline' => __( 'Essential protection for a single WordPress site. Set it once, sleep easier.', 'jetpack-theme' ),
					'popular' => false,
					'cta'     => [
						'text' => __( 'Protect my site', 'jetpack-theme' ),
						'url'  => JETPACK_CHECKOUT_BASIC,
					],
					'price'   => [
						'per_month'      => '$4.95',
						'per_year_label' => __( '$59.40 per year for 1 site', 'jetpack-theme' ),
						'savings_label'  => '',
					],
					'features' => [
						__( 'Daily automated backups (1-click restore)', 'jetpack-theme' ),
						__( 'Akismet anti-spam (10k API calls / month)', 'jetpack-theme' ),
						__( 'Downtime monitoring & uptime alerts', 'jetpack-theme' ),
						__( 'Site Stats dashboard', 'jetpack-theme' ),
						__( 'Jetpack mobile app', 'jetpack-theme' ),
						__( '1 WordPress site', 'jetpack-theme' ),
					],
				],
				[
					'slug'    => 'pro',
					'name'    => __( 'Pro', 'jetpack-theme' ),
					'tagline' => __( 'The full Jetpack toolkit for a single site — security, speed, growth, and content.', 'jetpack-theme' ),
					'popular' => true,
					'cta'     => [
						'text' => __( 'Upgrade to Pro', 'jetpack-theme' ),
						'url'  => JETPACK_CHECKOUT_PRO,
					],
					'price'   => [
						'per_month'      => '$14.95',
						'per_year_label' => __( '$179.40 per year for 1 site', 'jetpack-theme' ),
						// Rough sum of standalone plugin prices (Backup + Scan + Boost + VideoPress + Social + Search).
						'savings_label'  => __( 'Saves ~$350 / yr vs. buying plugins separately', 'jetpack-theme' ),
					],
					'features' => [
						__( 'Real-time backups with 1-year archive', 'jetpack-theme' ),
						__( 'Malware scanning + 1-click fixes & WAF', 'jetpack-theme' ),
						__( 'Akismet anti-spam (unlimited)', 'jetpack-theme' ),
						__( 'Jetpack Boost — Core Web Vitals + CDN', 'jetpack-theme' ),
						__( 'VideoPress — ad-free, 4K, 1 TB storage', 'jetpack-theme' ),
						__( 'Jetpack Social auto-share + AI assist', 'jetpack-theme' ),
						__( 'Advanced Stats & Site Search', 'jetpack-theme' ),
						__( 'Priority support', 'jetpack-theme' ),
					],
				],
				[
					'slug'    => 'agency',
					'name'    => __( 'Agency', 'jetpack-theme' ),
					'tagline' => __( 'Pro features for every client site you manage, plus referral revenue and daily-billing flexibility.', 'jetpack-theme' ),
					'popular' => false,
					'cta'     => [
						'text' => __( 'Become a partner', 'jetpack-theme' ),
						'url'  => JETPACK_CHECKOUT_AGENCY,
					],
					'price'   => [
						'per_month'      => __( 'Volume', 'jetpack-theme' ),
						'per_year_label' => __( 'Starts at 5 sites · volume discount below', 'jetpack-theme' ),
						'savings_label'  => __( 'Up to 50% off at 100+ licenses', 'jetpack-theme' ),
					],
					'features' => [
						__( 'Everything in Pro, per site', 'jetpack-theme' ),
						__( 'Multi-site bundles: 5 / 10 / 20 / 50 / 100 licenses', 'jetpack-theme' ),
						__( 'Centralized Jetpack Manage dashboard', 'jetpack-theme' ),
						__( 'Daily-billing option via A4A', 'jetpack-theme' ),
						__( 'Earn referral revenue on every client plan', 'jetpack-theme' ),
						__( 'Dedicated agency support', 'jetpack-theme' ),
					],
				],
			],

			// ── Free plan (used by comparison block and Free strip) ─────
			'free' => [
				'slug'    => 'free',
				'name'    => __( 'Jetpack Free', 'jetpack-theme' ),
				'tagline' => __( 'The open-source Jetpack plugin on WordPress.org. Always free, always useful.', 'jetpack-theme' ),
				'url'     => JETPACK_FREE_DOWNLOAD_URL,
			],

			// ── Free vs Pro comparison matrix (all categories visible) ──
			'comparison' => [
				'security' => [
					'label' => __( 'Security', 'jetpack-theme' ),
					'icon'  => 'shield',
					'rows'  => [
						[
							'title'       => __( 'Brute-force attack protection', 'jetpack-theme' ),
							'description' => __( 'Automatic protection against password-guessing bots.', 'jetpack-theme' ),
							'free'        => true,
							'pro'         => true,
						],
						[
							'title'       => __( 'Automated backups', 'jetpack-theme' ),
							'description' => __( 'Scheduled backups to the Automattic cloud.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => __( 'Real-time, 1-year archive', 'jetpack-theme' ),
						],
						[
							'title'       => __( '1-click restore', 'jetpack-theme' ),
							'description' => __( 'Roll back to any prior backup point from the activity log.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => true,
						],
						[
							'title'       => __( 'Malware scanning', 'jetpack-theme' ),
							'description' => __( 'Automated daily scans with 1-click threat remediation.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => true,
						],
						[
							'title'       => __( 'Web Application Firewall (WAF)', 'jetpack-theme' ),
							'description' => __( 'Blocks known attack patterns before they hit your site.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => true,
						],
						[
							'title'       => __( 'Spam protection (Akismet)', 'jetpack-theme' ),
							'description' => __( 'Filters spam comments, form entries, and pingbacks.', 'jetpack-theme' ),
							'free'        => __( 'Basic', 'jetpack-theme' ),
							'pro'         => __( 'Unlimited', 'jetpack-theme' ),
						],
					],
				],
				'performance' => [
					'label' => __( 'Performance', 'jetpack-theme' ),
					'icon'  => 'zap',
					'rows'  => [
						[
							'title'       => __( 'Image CDN', 'jetpack-theme' ),
							'description' => __( 'Serves optimized, resized images from a global network.', 'jetpack-theme' ),
							'free'        => true,
							'pro'         => true,
						],
						[
							'title'       => __( 'Lazy-loading images', 'jetpack-theme' ),
							'description' => __( 'Defers off-screen images to speed up first paint.', 'jetpack-theme' ),
							'free'        => true,
							'pro'         => true,
						],
						[
							'title'       => __( 'Critical CSS & Core Web Vitals', 'jetpack-theme' ),
							'description' => __( 'Per-page critical CSS and LCP / CLS / INP improvements.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => true,
						],
						[
							'title'       => __( 'Video hosting (VideoPress)', 'jetpack-theme' ),
							'description' => __( 'Ad-free, 4K video with adaptive streaming.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => __( '1 TB storage', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Advanced site search', 'jetpack-theme' ),
							'description' => __( 'Fast, typo-tolerant search with filters and analytics.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => true,
						],
					],
				],
				'growth' => [
					'label' => __( 'Growth', 'jetpack-theme' ),
					'icon'  => 'trending-up',
					'rows'  => [
						[
							'title'       => __( 'Basic site stats', 'jetpack-theme' ),
							'description' => __( 'Views, referrers, top posts, and search terms.', 'jetpack-theme' ),
							'free'        => true,
							'pro'         => true,
						],
						[
							'title'       => __( 'Advanced stats & segmentation', 'jetpack-theme' ),
							'description' => __( 'UTM tracking, devices, locations, and trend reports.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => true,
						],
						[
							'title'       => __( 'Auto-share to social networks', 'jetpack-theme' ),
							'description' => __( 'Publish new posts to Facebook, LinkedIn, Mastodon, and more.', 'jetpack-theme' ),
							'free'        => __( 'Basic', 'jetpack-theme' ),
							'pro'         => __( 'With AI assist', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Subscriptions & newsletters', 'jetpack-theme' ),
							'description' => __( 'Let readers subscribe and send newsletters from the editor.', 'jetpack-theme' ),
							'free'        => true,
							'pro'         => __( 'Paid tiers & import', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Related posts & content recirculation', 'jetpack-theme' ),
							'description' => __( 'Keep visitors on the site with AI-powered related content.', 'jetpack-theme' ),
							'free'        => true,
							'pro'         => true,
						],
					],
				],
				'management' => [
					'label' => __( 'Management', 'jetpack-theme' ),
					'icon'  => 'settings',
					'rows'  => [
						[
							'title'       => __( 'Activity log', 'jetpack-theme' ),
							'description' => __( 'Audit trail of every change on your site.', 'jetpack-theme' ),
							'free'        => __( '20 events', 'jetpack-theme' ),
							'pro'         => __( '1-year retention', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Mobile app', 'jetpack-theme' ),
							'description' => __( 'iOS / Android app for publishing, stats, and moderation.', 'jetpack-theme' ),
							'free'        => true,
							'pro'         => true,
						],
						[
							'title'       => __( 'Downtime monitoring', 'jetpack-theme' ),
							'description' => __( 'Alerts you the moment your site goes down.', 'jetpack-theme' ),
							'free'        => true,
							'pro'         => true,
						],
						[
							'title'       => __( 'Priority support', 'jetpack-theme' ),
							'description' => __( 'Direct access to a Happiness Engineer.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => true,
						],
						[
							'title'       => __( 'Multi-site management', 'jetpack-theme' ),
							'description' => __( 'Centralized dashboard for updates, backups, and monitoring.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => __( 'Agency plan', 'jetpack-theme' ),
						],
					],
				],
			],

			// ── Agency (A4A) volume tiers ────────────────────────────────
			'a4a_tiers' => [
				[ 'licenses' => 5,   'discount_pct' => 10 ],
				[ 'licenses' => 10,  'discount_pct' => 15 ],
				[ 'licenses' => 20,  'discount_pct' => 20 ],
				[ 'licenses' => 50,  'discount_pct' => 40 ],
				[ 'licenses' => 100, 'discount_pct' => 50 ],
			],
		];

		return $data;
	}
}

if ( ! function_exists( 'jetpack_theme_get_plan' ) ) {
	/**
	 * Look up a plan by slug.
	 *
	 * @param string $slug Plan slug: basic, pro, agency.
	 * @return array<string,mixed>|null
	 */
	function jetpack_theme_get_plan( string $slug ): ?array {
		foreach ( jetpack_theme_pricing_data()['plans'] as $plan ) {
			if ( $plan['slug'] === $slug ) {
				return $plan;
			}
		}
		return null;
	}
}
