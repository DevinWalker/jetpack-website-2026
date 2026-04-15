<?php
/**
 * Pricing block — server render.
 *
 * @var array $attributes Block attributes.
 */

$title       = $attributes['sectionTitle']       ?? 'Simple, transparent pricing';
$description = $attributes['sectionDescription'] ?? 'Choose the plan that works best for your team. All plans include a 14-day free trial.';
$plans       = $attributes['plans'] ?? [];
?>
<section id="pricing" class="jetpack-pricing w-full bg-background px-6 py-20 sm:py-28 scroll-mt-24">
	<div class="mx-auto max-w-5xl">

		<div class="mb-12 text-center sm:mb-16 jetpack-reveal opacity-0 translate-y-5">
			<span class="text-sm font-medium text-muted-foreground"><?php esc_html_e( 'Pricing', 'jetpack-theme' ); ?></span>
			<h2 class="mt-3 text-3xl font-semibold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
				<?php echo esc_html( $title ); ?>
			</h2>
			<p class="mx-auto mt-4 max-w-2xl text-base text-muted-foreground sm:text-lg">
				<?php echo esc_html( $description ); ?>
			</p>
		</div>

		<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">
			<?php foreach ( $plans as $plan ) :
				$is_popular = ! empty( $plan['popular'] );
			?>
			<div class="jetpack-pricing-card jetpack-reveal relative opacity-0 translate-y-5" style="transition-delay:<?php echo esc_attr( ( array_search( $plan, $plans ) * 0.1 ) . 's' ); ?>">
				<?php if ( $is_popular ) : ?>
				<div class="absolute -inset-1 rounded-[1.2em] bg-accent" aria-hidden="true"></div>
				<?php endif; ?>

				<div class="relative flex h-full flex-col rounded-2xl bg-frame p-6 sm:p-8 <?php echo $is_popular ? '' : 'border border-border'; ?>">
					<?php if ( $is_popular ) : ?>
					<div class="absolute -top-4 left-1/2 -translate-x-1/2">
						<span class="inline-block rounded-full bg-accent px-4 py-1.5 text-xs font-semibold uppercase tracking-wide text-black/50">
							<?php esc_html_e( 'Most Popular', 'jetpack-theme' ); ?>
						</span>
					</div>
					<?php endif; ?>

					<h3 class="text-xl font-semibold text-foreground"><?php echo esc_html( $plan['name'] ); ?></h3>

					<div class="mt-4">
						<div class="flex items-end gap-3">
							<span class="text-5xl font-bold tracking-tight text-foreground">$<?php echo esc_html( $plan['price'] ); ?></span>
							<span class="mb-1 text-sm text-muted-foreground">/<?php esc_html_e( 'month', 'jetpack-theme' ); ?></span>
						</div>
						<p class="mt-2 text-sm text-muted-foreground">
							<?php
							printf(
								/* translators: %d: monthly price */
								esc_html__( 'Billed annually, or $%d/mo billed monthly', 'jetpack-theme' ),
								(int) $plan['monthlyPrice']
							);
							?>
						</p>
					</div>

				<a
					href="https://jetpack.com/pricing/"
					class="mt-6 w-full rounded-xl py-3 text-sm font-semibold transition-colors text-center block no-underline hover:opacity-90 <?php echo $is_popular ? 'bg-foreground text-background' : 'bg-muted text-foreground'; ?>"
				>
						<?php esc_html_e( 'Get Started', 'jetpack-theme' ); ?>
					</a>

					<div class="mt-8">
						<p class="text-sm font-medium text-muted-foreground"><?php esc_html_e( 'Includes:', 'jetpack-theme' ); ?></p>
						<ul class="mt-4 space-y-3">
							<?php foreach ( $plan['features'] as $feature ) : ?>
							<li class="flex items-center gap-3">
								<svg class="h-4 w-4 shrink-0 text-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
								<span class="text-sm text-foreground"><?php echo esc_html( $feature ); ?></span>
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
