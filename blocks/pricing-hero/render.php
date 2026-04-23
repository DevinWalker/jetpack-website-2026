<?php
/**
 * Pricing Hero block — server render.
 *
 * The unified hero for the /pricing/ page: eyebrow + H1 + subhead + two CTAs
 * with a soft radial-faded brand background image behind the text.
 *
 * No JS, no WebGL — the background is the same `assets/BG.jpg` the homepage
 * hero uses, layered under a radial mask so the image blends out to white at
 * the edges. The mask is pure CSS (`mask-image: radial-gradient(...)`) plus a
 * gentle blur / brightness adjustment to keep the hero text readable over it.
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

$bg_url = get_template_directory_uri() . '/assets/BG.jpg';
?>
<section class="jetpack-pricing-hero relative isolate overflow-hidden bg-frame">

	<?php /* Brand background image, radially faded to white at the edges (pure CSS, no JS) */ ?>
	<div
		class="jetpack-pricing-hero__bg pointer-events-none absolute inset-0 -z-10"
		aria-hidden="true"
	>
		<img
			src="<?php echo esc_url( $bg_url ); ?>"
			alt=""
			class="jetpack-pricing-hero__bg-img h-full w-full object-cover opacity-55"
			loading="eager"
			decoding="async"
			aria-hidden="true"
		/>
		<?php /* Top-down white fade so the header pill and pricing section below blend into it */ ?>
		<div class="absolute inset-0 bg-gradient-to-b from-white/30 via-white/5 to-white" aria-hidden="true"></div>
	</div>

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
