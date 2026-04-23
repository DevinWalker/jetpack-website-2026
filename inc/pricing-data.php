<?php
/**
 * Pricing data — single source of truth for the pricing-table and
 * pricing-comparison blocks.
 *
 * Pricing model is flat recurring (no first-year discount); savings come from
 * committing to a longer term (yearly / 2-year) rather than from an intro
 * discount that renews at a higher price. Background: see the P2 posts
 * referenced in /pricing/ page plan (Subscription Length Analysis, Akismet
 * first-year-discount removal result, 14 user interviews).
 *
 * Prices below are illustrative placeholders grounded in the numbers from
 * https://jetpackp2.wordpress.com/2025/05/12/recommendations-for-jetpacks-pricing-and-packaging-updates/
 * and can be revised without touching block templates.
 *
 * @package Jetpack_Theme
 */

declare( strict_types=1 );

if ( ! function_exists( 'jetpack_theme_pricing_data' ) ) {
	/**
	 * Returns the full pricing dataset consumed by the pricing-table and
	 * pricing-comparison blocks.
	 *
	 * @return array{
	 *     plans: array<int, array{slug:string,name:string,tagline:string,cta:array{text:string,url:string},popular:bool,features:array<int,string>,prices:array<string,array{per_month:string,total:string,savings_label:string}>}>,
	 *     free: array{slug:string,name:string,tagline:string},
	 *     comparison: array<string,array<int,array{title:string,description:string,free:string|bool,pro:string|bool}>>,
	 *     a4a_tiers: array<int,array{licenses:int,discount_pct:int,note?:string}>,
	 * }
	 */
	function jetpack_theme_pricing_data(): array {
		static $data = null;
		if ( null !== $data ) {
			return $data;
		}

		$agencies_url = 'https://agencies.automattic.com/';
		$signup_url   = home_url( '/pricing/' );

		$data = [
			// ── Paid plans (cards on the pricing table) ──────────────────────
			'plans' => [
				[
					'slug'    => 'basic',
					'name'    => __( 'Basic', 'jetpack-theme' ),
					'tagline' => __( 'The essentials for a single WordPress site — backups, spam protection, and downtime monitoring.', 'jetpack-theme' ),
					'cta'     => [ 'text' => __( 'Start with Basic', 'jetpack-theme' ), 'url' => $signup_url ],
					'popular' => false,
					'features' => [
						__( 'Daily automated backups (1-click restore)', 'jetpack-theme' ),
						__( 'Akismet anti-spam (10k API calls / month)', 'jetpack-theme' ),
						__( 'Downtime monitoring & uptime alerts', 'jetpack-theme' ),
						__( 'Site Stats dashboard', 'jetpack-theme' ),
						__( 'Jetpack mobile app', 'jetpack-theme' ),
						__( '1 WordPress site', 'jetpack-theme' ),
					],
					'prices' => [
						'monthly'  => [
							'per_month'     => '$7.95',
							'total'         => __( 'Billed $7.95 monthly', 'jetpack-theme' ),
							'savings_label' => '',
						],
						'yearly'   => [
							'per_month'     => '$4.95',
							'total'         => __( 'Billed $59.40 yearly', 'jetpack-theme' ),
							'savings_label' => __( 'Save 38% every year vs monthly', 'jetpack-theme' ),
						],
						'biyearly' => [
							'per_month'     => '$3.95',
							'total'         => __( 'Billed $94.80 every 2 years', 'jetpack-theme' ),
							'savings_label' => __( 'Save 50% every term vs monthly', 'jetpack-theme' ),
						],
					],
				],
				[
					'slug'    => 'pro',
					'name'    => __( 'Pro', 'jetpack-theme' ),
					'tagline' => __( 'The complete Jetpack package for a single site — everything from security to growth and performance.', 'jetpack-theme' ),
					'cta'     => [ 'text' => __( 'Start with Pro', 'jetpack-theme' ), 'url' => $signup_url ],
					'popular' => true,
					'features' => [
						__( 'Real-time backups with 1-year archive', 'jetpack-theme' ),
						__( 'Malware scanning + 1-click fixes & WAF', 'jetpack-theme' ),
						__( 'Akismet anti-spam (unlimited)', 'jetpack-theme' ),
						__( 'Jetpack Boost — site speed & Core Web Vitals', 'jetpack-theme' ),
						__( 'VideoPress (ad-free, 4K, 1TB storage)', 'jetpack-theme' ),
						__( 'Jetpack Social auto-share + AI assist', 'jetpack-theme' ),
						__( 'Advanced Stats & Search', 'jetpack-theme' ),
						__( 'Priority support', 'jetpack-theme' ),
					],
					'prices' => [
						'monthly'  => [
							'per_month'     => '$24.95',
							'total'         => __( 'Billed $24.95 monthly', 'jetpack-theme' ),
							'savings_label' => '',
						],
						'yearly'   => [
							'per_month'     => '$14.95',
							'total'         => __( 'Billed $179.40 yearly', 'jetpack-theme' ),
							'savings_label' => __( 'Save 40% every year vs monthly', 'jetpack-theme' ),
						],
						'biyearly' => [
							'per_month'     => '$11.95',
							'total'         => __( 'Billed $286.80 every 2 years', 'jetpack-theme' ),
							'savings_label' => __( 'Save 52% every term vs monthly', 'jetpack-theme' ),
						],
					],
				],
				[
					'slug'    => 'agency',
					'name'    => __( 'Agency', 'jetpack-theme' ),
					'tagline' => __( 'Pro features for 5+ client sites, plus the Automattic for Agencies dashboard, daily-billing, and referral revenue.', 'jetpack-theme' ),
					'cta'     => [ 'text' => __( 'Join Automattic for Agencies', 'jetpack-theme' ), 'url' => $agencies_url ],
					'popular' => false,
					'features' => [
						__( 'Everything in Pro, per site', 'jetpack-theme' ),
						__( 'Multi-site license bundles (5 / 10 / 20 / 50 / 100)', 'jetpack-theme' ),
						__( 'Centralized Jetpack Manage dashboard', 'jetpack-theme' ),
						__( 'Daily-billing option via A4A', 'jetpack-theme' ),
						__( 'Referral revenue & partner perks', 'jetpack-theme' ),
						__( 'Dedicated agency support', 'jetpack-theme' ),
					],
					'prices' => [
						'monthly'  => [
							'per_month'     => '$39.95',
							'total'         => __( 'Starts at 5 sites · billed monthly', 'jetpack-theme' ),
							'savings_label' => '',
						],
						'yearly'   => [
							'per_month'     => '$24.95',
							'total'         => __( 'Starts at 5 sites · billed yearly', 'jetpack-theme' ),
							'savings_label' => __( 'Save 38% every year vs monthly', 'jetpack-theme' ),
						],
						'biyearly' => [
							'per_month'     => '$19.95',
							'total'         => __( 'Starts at 5 sites · billed every 2 years', 'jetpack-theme' ),
							'savings_label' => __( 'Save 50% every term vs monthly', 'jetpack-theme' ),
						],
					],
				],
			],

			// ── Free plan (only surfaced in the comparison table) ────────────
			'free' => [
				'slug'    => 'free',
				'name'    => __( 'Jetpack Free', 'jetpack-theme' ),
				'tagline' => __( 'Core Jetpack plugin — basic protection and stats, no credit card required.', 'jetpack-theme' ),
			],

			// ── Free vs Pro comparison (tabs = category) ─────────────────────
			// `free` / `pro` values are either `bool` (rendered as check/x) or
			// `string` (rendered as literal text, e.g. "10k / month").
			'comparison' => [
				'security' => [
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
				'performance' => [
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
						'description' => __( 'Generates per-page critical CSS and improves LCP / CLS / INP.', 'jetpack-theme' ),
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
				'growth' => [
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
						'description' => __( 'Auto-publish new posts to Facebook, LinkedIn, Mastodon, and more.', 'jetpack-theme' ),
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
				'management' => [
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
						'description' => __( 'Centralized dashboard for updates, backups, and monitoring across sites.', 'jetpack-theme' ),
						'free'        => false,
						'pro'         => __( 'Agency plan', 'jetpack-theme' ),
					],
				],
			],

			// ── Agency (A4A) volume tiers ────────────────────────────────────
			// Bundle discounts as documented in:
			// https://a4auniversity.wordpress.com/products/a4a-product-details-jetpack/
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
