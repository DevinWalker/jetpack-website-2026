<?php
/**
 * Title: Pricing Page
 * Slug: jetpack-theme/pricing-page
 * Description: Full pricing page composition — hero, paid-tier table, Agency/A4A band, Free vs Pro comparison, outcomes trust band, FAQ, final CTA.
 * Categories: jetpack-theme
 * Keywords: pricing, plans, agency, compare, jetpack
 * Block Types: core/post-content
 * Inserter: true
 */

require_once get_template_directory() . '/inc/pricing-data.php';

$data      = jetpack_theme_pricing_data();
$a4a_tiers = $data['a4a_tiers'];
?>

<!-- wp:group {"tagName":"section","className":"jetpack-pricing-hero","style":{"spacing":{"padding":{"top":"clamp(6rem,10vw,8rem)","bottom":"clamp(3rem,5vw,4rem)","left":"1.5rem","right":"1.5rem"}}},"backgroundColor":"background","layout":{"type":"constrained","contentSize":"64rem"}} -->
<section class="wp-block-group jetpack-pricing-hero has-background-background-color has-background" style="padding-top:clamp(6rem,10vw,8rem);padding-right:1.5rem;padding-bottom:clamp(3rem,5vw,4rem);padding-left:1.5rem">

	<!-- wp:group {"className":"jetpack-reveal opacity-0 translate-y-5","style":{"spacing":{"blockGap":"1rem"}},"layout":{"type":"constrained","contentSize":"48rem"}} -->
	<div class="wp-block-group jetpack-reveal opacity-0 translate-y-5">

		<!-- wp:paragraph {"align":"center","className":"jetpack-pricing-eyebrow","fontSize":"x-small","style":{"typography":{"fontWeight":"600","letterSpacing":"0.08em","textTransform":"uppercase"}},"textColor":"jetpack-green-50"} -->
		<p class="has-text-align-center jetpack-pricing-eyebrow has-jetpack-green-50-color has-text-color has-x-small-font-size" style="font-weight:600;letter-spacing:0.08em;text-transform:uppercase">Pricing built for the long run</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"textAlign":"center","level":1,"style":{"typography":{"fontWeight":"500","letterSpacing":"-0.02em","lineHeight":"1.05"}},"fontSize":"xxx-large"} -->
		<h1 class="wp-block-heading has-text-align-center has-xxx-large-font-size" style="font-weight:500;letter-spacing:-0.02em;line-height:1.05">One price every year. No tricks, no renewal shock.</h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","textColor":"muted-foreground","fontSize":"large","style":{"typography":{"lineHeight":"1.55"}}} -->
		<p class="has-text-align-center has-muted-foreground-color has-text-color has-large-font-size" style="line-height:1.55">We scrapped the 50%-off-first-year gimmick. Pick Basic, Pro, or Agency — your price stays the same every year, and longer terms save you more. Simple.</p>
		<!-- /wp:paragraph -->

		<!-- wp:html -->
		<div class="mt-6 flex flex-wrap items-center justify-center gap-3">
			<a href="#pricing" class="inline-flex items-center justify-center rounded-xl bg-jetpack-green-50 px-6 py-3 text-sm font-semibold text-white no-underline transition-colors hover:bg-jetpack-green-60">See plans</a>
			<a href="#compare-free-pro" class="inline-flex items-center justify-center rounded-xl border border-border bg-frame px-6 py-3 text-sm font-semibold text-foreground no-underline transition-colors hover:bg-muted">Compare Free vs Pro</a>
		</div>
		<!-- /wp:html -->

	</div>
	<!-- /wp:group -->

</section>
<!-- /wp:group -->

<!-- wp:jetpack-theme/pricing-table /-->

<!-- wp:group {"tagName":"section","className":"jetpack-agency-band","style":{"spacing":{"padding":{"top":"clamp(3rem,5vw,5rem)","bottom":"clamp(3rem,5vw,5rem)","left":"1.5rem","right":"1.5rem"}}},"backgroundColor":"green-0","layout":{"type":"constrained","contentSize":"64rem"}} -->
<section class="wp-block-group jetpack-agency-band has-green-0-background-color has-background" style="padding-top:clamp(3rem,5vw,5rem);padding-right:1.5rem;padding-bottom:clamp(3rem,5vw,5rem);padding-left:1.5rem">

	<!-- wp:group {"className":"jetpack-reveal opacity-0 translate-y-5","style":{"spacing":{"blockGap":"2rem"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group jetpack-reveal opacity-0 translate-y-5">

		<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"2rem","left":"3rem"}}}} -->
		<div class="wp-block-columns alignwide are-vertically-aligned-center">

			<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%">

				<!-- wp:paragraph {"className":"jetpack-pricing-eyebrow","fontSize":"x-small","style":{"typography":{"fontWeight":"600","letterSpacing":"0.08em","textTransform":"uppercase"}},"textColor":"jetpack-green-60"} -->
				<p class="jetpack-pricing-eyebrow has-jetpack-green-60-color has-text-color has-x-small-font-size" style="font-weight:600;letter-spacing:0.08em;text-transform:uppercase">Managing 5+ sites?</p>
				<!-- /wp:paragraph -->

				<!-- wp:heading {"level":2,"style":{"typography":{"fontWeight":"500","letterSpacing":"-0.02em","lineHeight":"1.1"}},"fontSize":"xx-large"} -->
				<h2 class="wp-block-heading has-xx-large-font-size" style="font-weight:500;letter-spacing:-0.02em;line-height:1.1">Agency pricing, fully surfaced.</h2>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"textColor":"muted-foreground","fontSize":"medium","style":{"typography":{"lineHeight":"1.6"}}} -->
				<p class="has-muted-foreground-color has-text-color has-medium-font-size" style="line-height:1.6">The Agency plan routes through <a href="https://agencies.automattic.com/">Automattic for Agencies</a>. One dashboard to manage every client site, centralized billing, referral revenue, and volume discounts that scale with you. No more digging through Jetpack Manage to find the right rate.</p>
				<!-- /wp:paragraph -->

				<!-- wp:html -->
				<div class="mt-6 flex flex-wrap items-center gap-3">
					<a href="https://agencies.automattic.com/" class="inline-flex items-center justify-center rounded-xl bg-foreground px-6 py-3 text-sm font-semibold text-background no-underline transition-colors hover:bg-foreground/90">Join Automattic for Agencies</a>
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

<!-- wp:group {"tagName":"div","anchor":"compare-free-pro","layout":{"type":"default"}} -->
<div id="compare-free-pro" class="wp-block-group">
	<!-- wp:jetpack-theme/pricing-comparison /-->
</div>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"jetpack-pricing-trust","style":{"spacing":{"padding":{"top":"clamp(3rem,5vw,5rem)","bottom":"clamp(3rem,5vw,5rem)","left":"1.5rem","right":"1.5rem"}}},"backgroundColor":"frame","layout":{"type":"constrained","contentSize":"64rem"}} -->
<section class="wp-block-group jetpack-pricing-trust has-frame-background-color has-background" style="padding-top:clamp(3rem,5vw,5rem);padding-right:1.5rem;padding-bottom:clamp(3rem,5vw,5rem);padding-left:1.5rem">

	<!-- wp:group {"className":"jetpack-reveal opacity-0 translate-y-5","style":{"spacing":{"blockGap":"3rem"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group jetpack-reveal opacity-0 translate-y-5">

		<!-- wp:group {"layout":{"type":"constrained","contentSize":"42rem"}} -->
		<div class="wp-block-group">
			<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"500","letterSpacing":"-0.02em","lineHeight":"1.1"}},"fontSize":"xx-large"} -->
			<h2 class="wp-block-heading has-text-align-center has-xx-large-font-size" style="font-weight:500;letter-spacing:-0.02em;line-height:1.1">Trusted on 27&nbsp;million+ WordPress sites.</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"align":"center","textColor":"muted-foreground","fontSize":"medium","style":{"typography":{"lineHeight":"1.6"}}} -->
			<p class="has-text-align-center has-muted-foreground-color has-text-color has-medium-font-size" style="line-height:1.6">Jetpack is built by Automattic, the team behind WordPress.com. Real-time backups run on the same cloud that protects millions of sites, and every plan is covered by a 14-day money-back guarantee.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"1rem","left":"1rem"}}}} -->
		<div class="wp-block-columns">

			<!-- wp:column -->
			<div class="wp-block-column">
				<!-- wp:group {"style":{"border":{"radius":"1rem"},"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"1.5rem","right":"1.5rem"}}},"backgroundColor":"green-0","layout":{"type":"default"}} -->
				<div class="wp-block-group has-green-0-background-color has-background" style="border-radius:1rem;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem">
					<!-- wp:heading {"level":3,"fontSize":"xx-large","style":{"typography":{"fontWeight":"600","lineHeight":"1"},"spacing":{"margin":{"bottom":"0.25rem"}}},"textColor":"jetpack-green-60"} -->
					<h3 class="wp-block-heading has-jetpack-green-60-color has-text-color has-xx-large-font-size" style="margin-bottom:0.25rem;font-weight:600;line-height:1">99.9%</h3>
					<!-- /wp:heading -->
					<!-- wp:paragraph {"textColor":"muted-foreground","fontSize":"small"} -->
					<p class="has-muted-foreground-color has-text-color has-small-font-size">Backup success rate across millions of sites.</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column">
				<!-- wp:group {"style":{"border":{"radius":"1rem"},"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"1.5rem","right":"1.5rem"}}},"backgroundColor":"green-0","layout":{"type":"default"}} -->
				<div class="wp-block-group has-green-0-background-color has-background" style="border-radius:1rem;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem">
					<!-- wp:heading {"level":3,"fontSize":"xx-large","style":{"typography":{"fontWeight":"600","lineHeight":"1"},"spacing":{"margin":{"bottom":"0.25rem"}}},"textColor":"jetpack-green-60"} -->
					<h3 class="wp-block-heading has-jetpack-green-60-color has-text-color has-xx-large-font-size" style="margin-bottom:0.25rem;font-weight:600;line-height:1">+43&nbsp;pts</h3>
					<!-- /wp:heading -->
					<!-- wp:paragraph {"textColor":"muted-foreground","fontSize":"small"} -->
					<p class="has-muted-foreground-color has-text-color has-small-font-size">Average Page Speed score lift after enabling Boost.</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column">
				<!-- wp:group {"style":{"border":{"radius":"1rem"},"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"1.5rem","right":"1.5rem"}}},"backgroundColor":"green-0","layout":{"type":"default"}} -->
				<div class="wp-block-group has-green-0-background-color has-background" style="border-radius:1rem;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem">
					<!-- wp:heading {"level":3,"fontSize":"xx-large","style":{"typography":{"fontWeight":"600","lineHeight":"1"},"spacing":{"margin":{"bottom":"0.25rem"}}},"textColor":"jetpack-green-60"} -->
					<h3 class="wp-block-heading has-jetpack-green-60-color has-text-color has-xx-large-font-size" style="margin-bottom:0.25rem;font-weight:600;line-height:1">14-day</h3>
					<!-- /wp:heading -->
					<!-- wp:paragraph {"textColor":"muted-foreground","fontSize":"small"} -->
					<p class="has-muted-foreground-color has-text-color has-small-font-size">Money-back guarantee on every paid plan.</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->

		</div>
		<!-- /wp:columns -->

	</div>
	<!-- /wp:group -->

</section>
<!-- /wp:group -->

<!-- wp:jetpack-theme/faq {"sectionTitle":"Pricing questions, answered","sectionDescription":"Straight answers on renewals, refunds, switching plans, and running Jetpack on multiple sites.","items":[{"question":"Does my price go up at renewal?","answer":"No. There's no first-year discount, so what you pay at signup is what you pay at renewal. The only reason your bill could change is if you switch plans or add sites."},{"question":"Can I switch between monthly, yearly, and 2-year billing later?","answer":"Yes. Upgrade a monthly plan to yearly or 2-year at any time and we'll prorate the difference. Downgrades take effect at the end of your current term."},{"question":"What's the refund policy?","answer":"Every paid Jetpack plan includes a 14-day money-back guarantee. If Jetpack isn't a fit, contact support within 14 days of purchase for a full refund — no questions asked."},{"question":"How do multi-site plans work?","answer":"The Agency plan starts at 5 sites and is managed through Automattic for Agencies. You get bundle discounts starting at 10% off (5 licenses) up to 50% off (100+ licenses), a centralized Jetpack Manage dashboard, and daily billing instead of fixed terms."},{"question":"Can I still buy individual Jetpack products?","answer":"Yes. Security, Backup, Boost, Social, Search, Stats, CRM, and AI all remain available as individual plugins with their own pricing. The Basic and Pro plans above bundle them for a simpler total cost."},{"question":"Will Jetpack slow down my site?","answer":"No. Jetpack is modular — only the features you enable are active. Backups and scans run on Automattic's cloud, and Jetpack Boost actively speeds up your site with critical CSS, image CDN, and lazy-loading."}]} /-->

<!-- wp:group {"tagName":"section","className":"jetpack-pricing-final-cta","style":{"spacing":{"padding":{"top":"clamp(4rem,7vw,6rem)","bottom":"clamp(4rem,7vw,6rem)","left":"1.5rem","right":"1.5rem"}}},"backgroundColor":"background","layout":{"type":"constrained","contentSize":"48rem"}} -->
<section class="wp-block-group jetpack-pricing-final-cta has-background-background-color has-background" style="padding-top:clamp(4rem,7vw,6rem);padding-right:1.5rem;padding-bottom:clamp(4rem,7vw,6rem);padding-left:1.5rem">

	<!-- wp:group {"className":"jetpack-reveal opacity-0 translate-y-5","layout":{"type":"default"}} -->
	<div class="wp-block-group jetpack-reveal opacity-0 translate-y-5">

		<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"500","letterSpacing":"-0.02em","lineHeight":"1.1"}},"fontSize":"xx-large"} -->
		<h2 class="wp-block-heading has-text-align-center has-xx-large-font-size" style="font-weight:500;letter-spacing:-0.02em;line-height:1.1">Pick the plan. Keep the price.</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","textColor":"muted-foreground","fontSize":"medium","style":{"typography":{"lineHeight":"1.6"}}} -->
		<p class="has-text-align-center has-muted-foreground-color has-text-color has-medium-font-size" style="line-height:1.6">Start with Pro for a single site, or join Automattic for Agencies if you run multiple. Both come with a 14-day money-back guarantee.</p>
		<!-- /wp:paragraph -->

		<!-- wp:html -->
		<div class="mt-6 flex flex-wrap items-center justify-center gap-3">
			<a href="#pricing" class="inline-flex items-center justify-center rounded-xl bg-jetpack-green-50 px-6 py-3 text-sm font-semibold text-white no-underline transition-colors hover:bg-jetpack-green-60">Start with Pro</a>
			<a href="https://agencies.automattic.com/" class="inline-flex items-center justify-center rounded-xl border border-border bg-frame px-6 py-3 text-sm font-semibold text-foreground no-underline transition-colors hover:bg-muted">Talk to Agencies</a>
		</div>
		<!-- /wp:html -->

	</div>
	<!-- /wp:group -->

</section>
<!-- /wp:group -->
