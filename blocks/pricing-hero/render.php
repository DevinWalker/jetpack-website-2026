<?php
/**
 * Pricing Hero block — server render.
 *
 * The unified hero for the /pricing/ page: eyebrow + H1 + subhead + two CTAs
 * with a WebGL Aurora Blur mount point behind the text. The view script
 * (pricing-hero-view) instantiates AuroraBlur into [data-aurora-mount] on
 * first intersection, gated by prefers-reduced-motion.
 *
 * The shader outputs transparent pixels wherever the aurora isn't glowing,
 * so the hero's own `bg-background` shows through without any dark sky
 * gradient fighting the light theme.
 *
 * @var array $attributes Block attributes (see block.json for defaults).
 */

$eyebrow            = (string) ( $attributes['eyebrow']          ?? '' );
$title              = (string) ( $attributes['title']            ?? '' );
$subtitle           = (string) ( $attributes['subtitle']         ?? '' );
$primary_cta_text   = (string) ( $attributes['primaryCtaText']   ?? '' );
$primary_cta_url    = (string) ( $attributes['primaryCtaUrl']    ?? '' );
$secondary_cta_text = (string) ( $attributes['secondaryCtaText'] ?? '' );
$secondary_cta_url  = (string) ( $attributes['secondaryCtaUrl']  ?? '' );
?>
<section class="jetpack-pricing-hero relative isolate overflow-hidden bg-background">

	<?php /* Aurora mount — transparent canvas, greens only, faded in on first intersection */ ?>
	<div
		data-aurora-mount
		class="jetpack-pricing-hero__aurora pointer-events-none absolute inset-0 -z-10 opacity-0 transition-opacity duration-700"
		aria-hidden="true"
	></div>

	<div class="relative mx-auto max-w-4xl px-6 pt-24 pb-20 text-center sm:pt-28 sm:pb-24">
		<?php if ( ! empty( $eyebrow ) ) : ?>
		<p class="jetpack-reveal opacity-0 translate-y-5 inline-flex items-center gap-2 rounded-full bg-jetpack-green-50/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-jetpack-green-60">
			<span class="inline-block h-2 w-2 rounded-full bg-jetpack-green-50" aria-hidden="true"></span>
			<?php echo esc_html( $eyebrow ); ?>
		</p>
		<?php endif; ?>

		<?php if ( ! empty( $title ) ) : ?>
		<h1 class="jetpack-reveal opacity-0 translate-y-5 mt-5 text-4xl font-medium tracking-tight text-foreground sm:text-5xl lg:text-6xl">
			<?php echo esc_html( $title ); ?>
		</h1>
		<?php endif; ?>

		<?php if ( ! empty( $subtitle ) ) : ?>
		<p class="jetpack-reveal opacity-0 translate-y-5 mx-auto mt-5 max-w-2xl text-base leading-relaxed text-muted-foreground sm:text-lg">
			<?php echo esc_html( $subtitle ); ?>
		</p>
		<?php endif; ?>

		<div class="jetpack-reveal opacity-0 translate-y-5 mt-8 flex flex-wrap items-center justify-center gap-3">
			<?php if ( ! empty( $primary_cta_text ) && ! empty( $primary_cta_url ) ) : ?>
			<a
				href="<?php echo esc_url( $primary_cta_url ); ?>"
				class="inline-flex items-center justify-center rounded-xl bg-jetpack-green-50 px-6 py-3 text-sm font-semibold text-white no-underline transition-colors hover:bg-jetpack-green-60"
			>
				<?php echo esc_html( $primary_cta_text ); ?>
			</a>
			<?php endif; ?>

			<?php if ( ! empty( $secondary_cta_text ) && ! empty( $secondary_cta_url ) ) : ?>
			<a
				href="<?php echo esc_url( $secondary_cta_url ); ?>"
				class="inline-flex items-center justify-center rounded-xl border border-border bg-frame px-6 py-3 text-sm font-semibold text-foreground no-underline transition-colors hover:bg-muted"
			>
				<?php echo esc_html( $secondary_cta_text ); ?>
			</a>
			<?php endif; ?>
		</div>
	</div>

</section>
