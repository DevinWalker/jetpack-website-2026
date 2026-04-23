<?php
/**
 * Title: Pricing Page
 * Slug: jetpack-theme/pricing-page
 * Description: Full pricing page composition \u2014 hero (Aurora Blur), paid tiers, 14-day money-back, Jetpack Free strip, Free vs Pro comparison, testimonials, Agency/A4A band, FAQ, final CTA.
 * Categories: jetpack-theme
 * Keywords: pricing, plans, agency, compare, jetpack
 * Block Types: core/post-content
 * Inserter: true
 */

$data      = jetpack_theme_pricing_data();
$a4a_tiers = $data['a4a_tiers'];
?>

<!-- 1. Hero with Aurora Blur WebGL background (single source of truth for the hero headline + CTAs) -->
<!-- wp:jetpack-theme/pricing-hero /-->

<!-- 2. Pricing table (3 paid cards, no toggle, Pro highlighted) -->
<!-- wp:jetpack-theme/pricing-table /-->

<!-- 3. 14-day money-back guarantee (moved up per CRO \u2014 anti-anxiety at the decision point) -->
<!-- wp:template-part {"slug":"pricing-money-back"} /-->

<!-- 4. Jetpack Free strip (WP.org download) -->
<!-- wp:template-part {"slug":"pricing-free-strip"} /-->

<!-- 5. Free vs Pro comparison (all categories visible, semantic table) -->
<!-- wp:jetpack-theme/pricing-comparison /-->

<!-- 6. Testimonials (social proof between comparison and Agency upsell) -->
<!-- wp:template-part {"slug":"pricing-testimonials"} /-->

<!-- 7. Agency / A4A band -->
<!-- wp:group {"tagName":"section","className":"jetpack-agency-band","style":{"spacing":{"padding":{"top":"clamp(3rem,5vw,5rem)","bottom":"clamp(3rem,5vw,5rem)","left":"1.5rem","right":"1.5rem"}}},"backgroundColor":"green-0","layout":{"type":"constrained","contentSize":"64rem"}} -->
<section class="wp-block-group jetpack-agency-band has-green-0-background-color has-background" style="padding-top:clamp(3rem,5vw,5rem);padding-right:1.5rem;padding-bottom:clamp(3rem,5vw,5rem);padding-left:1.5rem">

	<!-- wp:group {"className":"jetpack-reveal opacity-0 translate-y-5","layout":{"type":"default"}} -->
	<div class="wp-block-group jetpack-reveal opacity-0 translate-y-5">

		<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"2rem","left":"3rem"}}}} -->
		<div class="wp-block-columns alignwide are-vertically-aligned-center">

			<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%">

				<!-- wp:paragraph {"className":"jetpack-pricing-eyebrow","fontSize":"x-small","style":{"typography":{"fontWeight":"600","letterSpacing":"0.08em","textTransform":"uppercase"}},"textColor":"jetpack-green-60"} -->
				<p class="jetpack-pricing-eyebrow has-jetpack-green-60-color has-text-color has-x-small-font-size" style="font-weight:600;letter-spacing:0.08em;text-transform:uppercase">Managing 5+ sites?</p>
				<!-- /wp:paragraph -->

				<!-- wp:heading {"level":2,"style":{"typography":{"fontWeight":"500","letterSpacing":"-0.02em","lineHeight":"1.1"}},"fontSize":"xx-large"} -->
				<h2 class="wp-block-heading has-xx-large-font-size" style="font-weight:500;letter-spacing:-0.02em;line-height:1.1">Built for agencies and freelancers.</h2>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"textColor":"muted-foreground","fontSize":"medium","style":{"typography":{"lineHeight":"1.6"}}} -->
				<p class="has-muted-foreground-color has-text-color has-medium-font-size" style="line-height:1.6">Join <a href="https://agencies.automattic.com/">Automattic for Agencies</a> to manage every client site from one dashboard, unlock volume discounts on Jetpack Pro, and earn referral revenue on every plan you sell.</p>
				<!-- /wp:paragraph -->

				<!-- wp:html -->
				<div class="mt-6 flex flex-wrap items-center gap-3">
					<a href="https://agencies.automattic.com/" class="inline-flex items-center justify-center rounded-xl bg-foreground px-6 py-3 text-sm font-semibold text-background no-underline transition-colors hover:bg-foreground/90">Become a partner</a>
				</div>
				<!-- /wp:html -->

			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">

				<!-- wp:html -->
				<div class="jetpack-a4a-tiers rounded-2xl bg-frame p-6 shadow-sm border border-border">
					<div class="mb-4 flex items-center justify-between">
						<h3 class="text-sm font-semibold text-foreground">Volume discount</h3>
						<span class="text-xs text-muted-foreground">Applies on every renewal</span>
					</div>
					<ul class="divide-y divide-border">
						<?php foreach ( $a4a_tiers as $tier ) : ?>
						<li class="flex items-center justify-between py-2.5">
							<span class="text-sm font-medium text-foreground"><?php echo esc_html( $tier['licenses'] ); ?>+ licenses</span>
							<span class="inline-flex items-center rounded-full bg-jetpack-green-50/15 px-2.5 py-1 text-xs font-semibold text-jetpack-green-60"><?php echo esc_html( $tier['discount_pct'] ); ?>% off</span>
						</li>
						<?php endforeach; ?>
					</ul>
					<p class="mt-4 text-xs text-muted-foreground">Bundle rates from the Automattic for Agencies marketplace.</p>
				</div>
				<!-- /wp:html -->

			</div>
			<!-- /wp:column -->

		</div>
		<!-- /wp:columns -->

	</div>
	<!-- /wp:group -->

</section>
<!-- /wp:group -->

<!-- 8. FAQ (updated items — no first-year-discount references, added cancellation / compatibility / competitor / data-portability entries) -->
<!-- wp:jetpack-theme/faq {"sectionTitle":"Pricing questions, answered","sectionDescription":"Straight answers on renewals, cancellation, compatibility, and running Jetpack on multiple sites.","items":[{"question":"Does my price go up at renewal?","answer":"No. Your renewal price equals your signup price. The only reason your bill could change is if you switch plans or add sites."},{"question":"Can I cancel anytime?","answer":"Yes. Cancel from your WordPress.com account at any time. Your plan stays active until the end of the billing period you've already paid for."},{"question":"What's the refund policy?","answer":"Every paid Jetpack plan includes a 14-day money-back guarantee. Contact support within 14 days of purchase for a full refund, no questions asked \u2014 typically handled in under 24 hours."},{"question":"Does Jetpack work with WooCommerce, Elementor, and page builders?","answer":"Yes. Jetpack is built to coexist with other plugins. It runs on more than 27 million WordPress sites, including stores powered by WooCommerce and sites built with Elementor, Divi, Beaver Builder, and Bricks."},{"question":"How is this different from WP Rocket, Sucuri, or UpdraftPlus?","answer":"Jetpack bundles security, performance, and growth tools from the team behind WordPress.com in a single plugin \u2014 so you don't stitch together separate vendors for backups, scanning, caching, and stats. Pro replaces what you'd otherwise buy across three or four plugins."},{"question":"Will I keep my backup data if I cancel?","answer":"Yes. Backup archives stay available for download during your active term, and you can export everything before you cancel. Your content and data are always yours."},{"question":"How do multi-site plans work?","answer":"The Agency plan runs through Automattic for Agencies. Bundle discounts start at 10% off (5 licenses) and scale to 50% off (100+ licenses), with a centralized Jetpack Manage dashboard and daily-billing flexibility."},{"question":"Can I still buy individual Jetpack products?","answer":"Yes. Security, Backup, Boost, Social, Search, Stats, CRM, and AI remain available as individual plugins. The Basic and Pro plans bundle them for a lower total cost."}]} /-->

<!-- 9. Final CTA -->
<!-- wp:group {"tagName":"section","className":"jetpack-pricing-final-cta","style":{"spacing":{"padding":{"top":"clamp(4rem,7vw,6rem)","bottom":"clamp(4rem,7vw,6rem)","left":"1.5rem","right":"1.5rem"}}},"backgroundColor":"background","layout":{"type":"constrained","contentSize":"48rem"}} -->
<section class="wp-block-group jetpack-pricing-final-cta has-background-background-color has-background" style="padding-top:clamp(4rem,7vw,6rem);padding-right:1.5rem;padding-bottom:clamp(4rem,7vw,6rem);padding-left:1.5rem">

	<!-- wp:group {"className":"jetpack-reveal opacity-0 translate-y-5","layout":{"type":"default"}} -->
	<div class="wp-block-group jetpack-reveal opacity-0 translate-y-5">

		<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"500","letterSpacing":"-0.02em","lineHeight":"1.1"}},"fontSize":"xx-large"} -->
		<h2 class="wp-block-heading has-text-align-center has-xx-large-font-size" style="font-weight:500;letter-spacing:-0.02em;line-height:1.1">Protect, accelerate, and grow your site today.</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","textColor":"muted-foreground","fontSize":"medium","style":{"typography":{"lineHeight":"1.6"}}} -->
		<p class="has-text-align-center has-muted-foreground-color has-text-color has-medium-font-size" style="line-height:1.6">Start with Pro for a single site or become a partner if you manage clients. Every paid plan includes the 14-day money-back guarantee.</p>
		<!-- /wp:paragraph -->

		<!-- wp:html -->
		<div class="mt-6 flex flex-wrap items-center justify-center gap-3">
			<a href="https://jetpack.com/redirect/?source=plans-pro-checkout" class="inline-flex items-center justify-center rounded-xl bg-jetpack-green-50 px-6 py-3 text-sm font-semibold text-white no-underline transition-colors hover:bg-jetpack-green-60">Upgrade to Pro</a>
			<a href="https://agencies.automattic.com/" class="inline-flex items-center justify-center rounded-xl border border-border bg-frame px-6 py-3 text-sm font-semibold text-foreground no-underline transition-colors hover:bg-muted">Talk to Agencies</a>
		</div>
		<!-- /wp:html -->

	</div>
	<!-- /wp:group -->

</section>
<!-- /wp:group -->
