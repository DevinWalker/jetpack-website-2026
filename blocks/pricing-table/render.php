<?php
/**
 * Pricing Table block — server render.
 *
 * Ports the visual structure of ReactBits Pro "pricing-6" (purple → Jetpack
 * greens). Three paid cards (Basic / Pro / Agency); Pro is lifted/highlighted.
 * Billing-cycle toggle (Monthly / Yearly / 2-Year) updates each card's price
 * block via pricing-interactions.js.
 *
 * Content comes from inc/pricing-data.php — this template is presentation only.
 *
 * @var array $attributes Block attributes.
 */

require_once get_template_directory() . '/inc/pricing-data.php';

$title           = $attributes['sectionTitle']       ?? '';
$description     = $attributes['sectionDescription'] ?? '';
$default_cycle   = in_array( $attributes['defaultCycle'] ?? 'yearly', [ 'monthly', 'yearly', 'biyearly' ], true ) ? $attributes['defaultCycle'] : 'yearly';
$highlighted     = $attributes['highlightedPlan'] ?? 'pro';

$data   = jetpack_theme_pricing_data();
$plans  = $data['plans'];

$cycles = [
	'monthly'  => __( 'Monthly',  'jetpack-theme' ),
	'yearly'   => __( 'Yearly',   'jetpack-theme' ),
	'biyearly' => __( '2-Year',   'jetpack-theme' ),
];
?>
<section
	class="jetpack-pricing-table w-full bg-background px-6 py-20 sm:py-28 scroll-mt-24"
	id="pricing"
	data-wp-interactive="jetpack-theme/pricing-table"
	data-default-cycle="<?php echo esc_attr( $default_cycle ); ?>"
	<?php echo wp_kses_data( wp_interactivity_data_wp_context( [ 'cycle' => $default_cycle ] ) ); ?>
>
	<div class="mx-auto max-w-6xl">

		<?php /* ── Header ──────────────────────────────────────────────── */ ?>
		<div class="mb-12 text-center sm:mb-16 jetpack-reveal opacity-0 translate-y-5">
			<span class="inline-block rounded-full bg-accent/15 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-accent">
				<?php esc_html_e( 'Pricing', 'jetpack-theme' ); ?>
			</span>
			<h2 class="mt-3 text-3xl font-semibold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
				<?php echo esc_html( $title ); ?>
			</h2>
			<p class="mx-auto mt-4 max-w-2xl text-base text-muted-foreground sm:text-lg">
				<?php echo esc_html( $description ); ?>
			</p>
		</div>

		<?php /* ── Billing cycle toggle ────────────────────────────────── */ ?>
		<div class="flex items-center justify-center mb-12 jetpack-reveal opacity-0 translate-y-5">
			<div class="jetpack-cycle-toggle inline-flex items-center gap-1 rounded-full border border-border bg-frame p-1 shadow-sm" role="tablist" aria-label="<?php esc_attr_e( 'Billing cycle', 'jetpack-theme' ); ?>">
				<?php foreach ( $cycles as $cycle_slug => $cycle_label ) :
					$is_active = $cycle_slug === $default_cycle;
				?>
				<button
					type="button"
					role="tab"
					data-cycle="<?php echo esc_attr( $cycle_slug ); ?>"
					aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
					class="jetpack-cycle-toggle__btn cursor-pointer relative z-10 inline-flex items-center gap-2 rounded-full px-5 py-2 text-sm font-medium transition-colors duration-200 <?php echo $is_active ? 'bg-jetpack-green-50 text-white shadow-sm' : 'text-muted-foreground hover:text-foreground'; ?>"
				>
					<?php echo esc_html( $cycle_label ); ?>
					<?php if ( 'biyearly' === $cycle_slug ) : ?>
					<span class="inline-flex items-center rounded-full bg-accent/80 px-1.5 py-0.5 text-[0.625rem] font-bold uppercase tracking-wide text-black/70">
						<?php esc_html_e( 'Best value', 'jetpack-theme' ); ?>
					</span>
					<?php endif; ?>
				</button>
				<?php endforeach; ?>
			</div>
		</div>

		<?php /* ── Plan cards ──────────────────────────────────────────── */ ?>
		<div class="grid grid-cols-1 gap-6 items-stretch lg:grid-cols-3 lg:gap-8">
			<?php foreach ( $plans as $i => $plan ) :
				$is_popular = ! empty( $plan['popular'] ) && ( $plan['slug'] === $highlighted );
			?>
			<div class="jetpack-pricing-card relative <?php echo $is_popular ? 'lg:-my-4 z-10' : ''; ?> jetpack-reveal opacity-0 translate-y-5" style="transition-delay:<?php echo esc_attr( ( $i * 0.1 ) . 's' ); ?>">
				<?php if ( $is_popular ) : ?>
					<?php /* Soft radial gradient behind popular card — Jetpack green */ ?>
					<div class="absolute inset-0 rounded-3xl bg-gradient-to-t from-jetpack-green-50/25 to-transparent -z-10" aria-hidden="true"></div>
				<?php endif; ?>

				<div class="relative flex h-full flex-col overflow-hidden rounded-2xl bg-frame p-6 sm:p-8 <?php echo $is_popular ? 'shadow-xl ring-1 ring-jetpack-green-50/20' : 'border border-border shadow-sm'; ?>">

					<?php /* Plan name + popular badge */ ?>
					<div class="flex justify-between items-center mb-4">
						<h3 class="text-xl font-medium <?php echo $is_popular ? 'text-jetpack-green-50' : 'text-muted-foreground'; ?>">
							<?php echo esc_html( $plan['name'] ); ?>
						</h3>
						<?php if ( $is_popular ) : ?>
						<span class="inline-block rounded-full bg-jetpack-green-50/15 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-jetpack-green-50">
							<?php esc_html_e( 'Most popular', 'jetpack-theme' ); ?>
						</span>
						<?php endif; ?>
					</div>

					<?php /* Price block — one per cycle, cycle toggle shows/hides via JS */ ?>
					<div class="jetpack-pricing-card__prices">
						<?php foreach ( $plan['prices'] as $cycle_slug => $price ) :
							$is_active_cycle = $cycle_slug === $default_cycle;
						?>
						<div
							class="jetpack-price-cell <?php echo $is_active_cycle ? '' : 'hidden'; ?>"
							data-cycle="<?php echo esc_attr( $cycle_slug ); ?>"
							<?php if ( ! $is_active_cycle ) : ?>hidden<?php endif; ?>
						>
							<div class="flex items-baseline gap-2">
								<span class="text-4xl font-semibold tracking-tight text-foreground sm:text-5xl">
									<?php echo esc_html( $price['per_month'] ); ?>
								</span>
								<span class="text-sm text-muted-foreground">/<?php esc_html_e( 'mo', 'jetpack-theme' ); ?></span>
							</div>
							<p class="mt-2 text-sm text-muted-foreground">
								<?php echo esc_html( $price['total'] ); ?>
							</p>
							<?php if ( ! empty( $price['savings_label'] ) ) : ?>
							<p class="mt-1 text-xs font-semibold text-jetpack-green-50">
								<?php echo esc_html( $price['savings_label'] ); ?>
							</p>
							<?php else : ?>
							<p class="mt-1 text-xs text-transparent select-none" aria-hidden="true">&nbsp;</p>
							<?php endif; ?>
						</div>
						<?php endforeach; ?>
					</div>

					<?php /* Tagline */ ?>
					<p class="mt-4 text-sm leading-relaxed text-muted-foreground">
						<?php echo esc_html( $plan['tagline'] ); ?>
					</p>

					<?php /* CTA */ ?>
					<a
						href="<?php echo esc_url( $plan['cta']['url'] ); ?>"
						class="mt-6 inline-flex w-full items-center justify-center rounded-xl px-4 py-3 text-sm font-semibold no-underline transition-all duration-200 <?php echo $is_popular ? 'bg-jetpack-green-50 text-white hover:bg-jetpack-green-60 hover:scale-[1.02]' : 'bg-foreground text-background hover:bg-foreground/90'; ?>"
					>
						<?php echo esc_html( $plan['cta']['text'] ); ?>
					</a>

					<?php /* Features */ ?>
					<div class="mt-8">
						<p class="text-sm font-semibold text-foreground">
							<?php esc_html_e( "What's included:", 'jetpack-theme' ); ?>
						</p>
						<ul class="mt-4 space-y-3">
							<?php foreach ( $plan['features'] as $feature ) : ?>
							<li class="flex items-start gap-3">
								<span class="mt-1 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full <?php echo $is_popular ? 'bg-jetpack-green-50 text-white' : 'bg-foreground text-background'; ?>">
									<?php $classes = 'h-3 w-3'; include __DIR__ . '/parts/_check-icon.php'; ?>
								</span>
								<span class="text-sm leading-relaxed text-foreground">
									<?php echo esc_html( $feature ); ?>
								</span>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
