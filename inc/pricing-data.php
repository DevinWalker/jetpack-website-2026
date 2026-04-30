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
			// Feature lists are written as quantitative differentiators wherever
			// possible (storage tiers, API-call limits, view caps) so visitors
			// can see exactly what Pro unlocks over Basic. Items that are free
			// on every Jetpack install (the mobile app, brute-force protection,
			// the image CDN, basic site stats) live in the comparison matrix
			// below — not in the paid cards.
			'plans' => [
				[
					'slug'    => 'basic',
					'name'    => __( 'Basic', 'jetpack-theme' ),
					'tagline' => __( 'Security essentials for a single WordPress site — backups, spam, and uptime at a budget-friendly price.', 'jetpack-theme' ),
					'popular' => false,
					'cta'     => [
						'text' => __( 'Get Basic', 'jetpack-theme' ),
						'url'  => JETPACK_CHECKOUT_BASIC,
					],
					'price'   => [
						'per_month'      => '$4.95',
						'per_year_label' => __( '$59.40 per year for 1 site', 'jetpack-theme' ),
						'savings_label'  => '',
					],
					'features' => [
						__( 'VaultPress Backup — 10 GB storage, 30-day archive', 'jetpack-theme' ),
						__( '1-click restore to any point in the last 30 days', 'jetpack-theme' ),
						__( 'Akismet anti-spam — 10,000 API calls / month', 'jetpack-theme' ),
						__( 'Manual malware scan with threat alerts', 'jetpack-theme' ),
						__( 'Downtime monitoring — 5-minute checks, instant alerts', 'jetpack-theme' ),
						__( 'Site Stats — up to 10,000 views / month', 'jetpack-theme' ),
						__( 'Activity log — 30-day retention', 'jetpack-theme' ),
						__( 'Jetpack Social — basic auto-share to social networks', 'jetpack-theme' ),
						__( 'Priority email support (replies within 24 hours)', 'jetpack-theme' ),
						__( '1 WordPress site', 'jetpack-theme' ),
					],
				],
				[
					'slug'    => 'pro',
					'name'    => __( 'Pro', 'jetpack-theme' ),
					'tagline' => __( 'The complete Jetpack toolkit for a single site — security, performance, growth, and content, all unlocked.', 'jetpack-theme' ),
					'popular' => true,
					'cta'     => [
						'text' => __( 'Upgrade to Pro', 'jetpack-theme' ),
						'url'  => JETPACK_CHECKOUT_PRO,
					],
					'price'   => [
						'per_month'      => '$14.95',
						'per_year_label' => __( '$179.40 per year for 1 site', 'jetpack-theme' ),
						// Rough sum of standalone plugin prices (Backup T2 + Scan + Boost + VideoPress + Social + Search + Stats).
						'savings_label'  => __( 'Saves ~$600 / yr vs. buying plugins separately', 'jetpack-theme' ),
					],
					'features' => [
						__( 'VaultPress Backup — 1 TB storage, 1-year archive', 'jetpack-theme' ),
						__( 'Real-time backups (every change saved instantly)', 'jetpack-theme' ),
						__( '1-click restore to any point in the last year', 'jetpack-theme' ),
						__( 'Daily malware scan + 1-click threat fixes', 'jetpack-theme' ),
						__( 'Web Application Firewall (WAF) — blocks attacks on arrival', 'jetpack-theme' ),
						__( 'Akismet anti-spam — unlimited API calls', 'jetpack-theme' ),
						__( 'Jetpack Boost — per-page Critical CSS, dedicated image CDN, Core Web Vitals tracking', 'jetpack-theme' ),
						__( 'VideoPress — unlimited videos, 1 TB storage, 4K adaptive streaming', 'jetpack-theme' ),
						__( 'Jetpack Stats — up to 100,000 views / month with UTM tracking & segmentation', 'jetpack-theme' ),
						__( 'Jetpack Search — 100,000 records, 100,000 queries / month', 'jetpack-theme' ),
						__( 'Jetpack Social — unlimited auto-shares + AI-assisted social copy', 'jetpack-theme' ),
						__( 'Jetpack AI Assistant — unlimited prompts in the editor', 'jetpack-theme' ),
						__( 'Activity log — 1-year retention', 'jetpack-theme' ),
						__( 'Priority chat + email support (under 24 hours)', 'jetpack-theme' ),
					],
				],
				[
					'slug'    => 'agency',
					'name'    => __( 'Agency', 'jetpack-theme' ),
					'tagline' => __( 'Everything in Pro for every client site, plus multi-site bundles, referral revenue, and centralized management.', 'jetpack-theme' ),
					'popular' => false,
					'cta'     => [
						'text' => __( 'Become a partner', 'jetpack-theme' ),
						'url'  => JETPACK_CHECKOUT_AGENCY,
					],
					'price'   => [
						'per_month'      => __( 'Volume', 'jetpack-theme' ),
						'per_year_label' => __( 'Starts at 5 sites • volume discount below', 'jetpack-theme' ),
						'savings_label'  => __( 'Up to 50% off at 100+ licenses', 'jetpack-theme' ),
					],
					'features' => [
						__( 'Everything in Pro, on every client site you manage', 'jetpack-theme' ),
						__( 'Multi-site bundles — 5 / 10 / 20 / 50 / 100 licenses', 'jetpack-theme' ),
						__( 'Volume discounts — 10% → 50% off as you scale', 'jetpack-theme' ),
						__( 'Jetpack Manage — all client sites in one dashboard (backups, scans, updates)', 'jetpack-theme' ),
						__( 'Daily-billing flexibility via Automattic for Agencies', 'jetpack-theme' ),
						__( 'Earn referral revenue on every client plan you sell', 'jetpack-theme' ),
						__( 'White-label client reports + branded email summaries', 'jetpack-theme' ),
						__( 'Dedicated agency support channel (Slack + direct email)', 'jetpack-theme' ),
						__( 'Early access to new Jetpack features', 'jetpack-theme' ),
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
			// Values are QUANTITATIVE wherever possible (storage tiers, API
			// limits, view caps) so visitors can price the upgrade concretely.
			// Items that are identical on Free and Pro (brute-force protection,
			// CDN basics, mobile app, downtime monitor, related posts) intentionally
			// appear with `true / true` so the "free for everyone" baseline is
			// visible — they establish what Jetpack Free already covers, so Pro
			// upgraders can see exactly what's added on top.
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
							'pro'         => __( 'Real-time, every change saved', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Backup storage', 'jetpack-theme' ),
							'description' => __( 'How far back you can roll the site if something goes wrong.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => __( '1 TB • 1-year archive', 'jetpack-theme' ),
						],
						[
							'title'       => __( '1-click restore', 'jetpack-theme' ),
							'description' => __( 'Roll back to any prior backup point from the activity log.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => true,
						],
						[
							'title'       => __( 'Malware scanning', 'jetpack-theme' ),
							'description' => __( 'Automated scans of core, themes, and plugins.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => __( 'Daily + 1-click fixes', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Web Application Firewall (WAF)', 'jetpack-theme' ),
							'description' => __( 'Blocks known attack patterns before they reach your site.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => true,
						],
						[
							'title'       => __( 'Spam protection (Akismet)', 'jetpack-theme' ),
							'description' => __( 'Filters spam comments, form entries, and pingbacks.', 'jetpack-theme' ),
							'free'        => __( 'Limited', 'jetpack-theme' ),
							'pro'         => __( 'Unlimited API calls', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Activity log retention', 'jetpack-theme' ),
							'description' => __( 'Audit trail of every change on your site.', 'jetpack-theme' ),
							'free'        => __( '20 events', 'jetpack-theme' ),
							'pro'         => __( '1 year', 'jetpack-theme' ),
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
							'title'       => __( 'Critical CSS (Jetpack Boost)', 'jetpack-theme' ),
							'description' => __( 'Per-page critical CSS for faster LCP / CLS / INP scores.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => true,
						],
						[
							'title'       => __( 'Core Web Vitals tracking', 'jetpack-theme' ),
							'description' => __( 'Real-user monitoring for Google’s page-experience metrics.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => true,
						],
						[
							'title'       => __( 'VideoPress hosting', 'jetpack-theme' ),
							'description' => __( 'Ad-free, 4K adaptive video with player customization.', 'jetpack-theme' ),
							'free'        => __( '1 video • 1 GB', 'jetpack-theme' ),
							'pro'         => __( 'Unlimited videos • 1 TB', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Jetpack Search', 'jetpack-theme' ),
							'description' => __( 'Instant, typo-tolerant site search with filters and analytics.', 'jetpack-theme' ),
							'free'        => __( '10k records • 500 queries/mo', 'jetpack-theme' ),
							'pro'         => __( '100k records • 100k queries/mo', 'jetpack-theme' ),
						],
					],
				],
				'growth' => [
					'label' => __( 'Growth', 'jetpack-theme' ),
					'icon'  => 'trending-up',
					'rows'  => [
						[
							'title'       => __( 'Jetpack Stats', 'jetpack-theme' ),
							'description' => __( 'Monthly page-view cap for commercial-use sites.', 'jetpack-theme' ),
							'free'        => __( 'Up to 10k views/mo', 'jetpack-theme' ),
							'pro'         => __( 'Up to 100k views/mo', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Advanced stats & segmentation', 'jetpack-theme' ),
							'description' => __( 'UTM tracking, devices, locations, trend reports, and custom dashboards.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => true,
						],
						[
							'title'       => __( 'Jetpack Social auto-share', 'jetpack-theme' ),
							'description' => __( 'Publish posts to Facebook, LinkedIn, Mastodon, Tumblr, and more.', 'jetpack-theme' ),
							'free'        => __( '30 shares / month', 'jetpack-theme' ),
							'pro'         => __( 'Unlimited + AI copy', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Jetpack AI Assistant', 'jetpack-theme' ),
							'description' => __( 'Generate post drafts, titles, translations, and summaries in the editor.', 'jetpack-theme' ),
							'free'        => __( '20 prompts (one-time)', 'jetpack-theme' ),
							'pro'         => __( 'Unlimited prompts', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Subscriptions & newsletters', 'jetpack-theme' ),
							'description' => __( 'Let readers subscribe and send newsletters from the editor.', 'jetpack-theme' ),
							'free'        => true,
							'pro'         => __( 'Paid tiers + import', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Related posts & recirculation', 'jetpack-theme' ),
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
							'title'       => __( 'Downtime monitoring', 'jetpack-theme' ),
							'description' => __( 'Alerts you the moment your site goes down.', 'jetpack-theme' ),
							'free'        => __( '5-minute checks', 'jetpack-theme' ),
							'pro'         => __( '1-minute checks + SMS', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Priority support', 'jetpack-theme' ),
							'description' => __( 'Direct access to a Happiness Engineer.', 'jetpack-theme' ),
							'free'        => __( 'Community forums', 'jetpack-theme' ),
							'pro'         => __( 'Priority chat + email', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Multi-site management', 'jetpack-theme' ),
							'description' => __( 'Manage backups, scans, and updates across every site from one dashboard.', 'jetpack-theme' ),
							'free'        => false,
							'pro'         => __( 'Jetpack Manage (Agency plan)', 'jetpack-theme' ),
						],
						[
							'title'       => __( 'Client reporting', 'jetpack-theme' ),
							'description' => __( 'White-label PDF / email reports for the sites you manage.', 'jetpack-theme' ),
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
