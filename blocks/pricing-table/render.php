<?php
/**
 * Pricing Table block — server render.
 *
 * Renders paid plan cards (Basic / Pro / Agency) with a single flat yearly
 * price per card. No billing-cycle toggle. Reusable on any page via
 * `visiblePlans` and `variant` attributes.
 *
 * Plan content comes from inc/pricing-data.php (loaded at boot in functions.php).
 * Icons come from inc/icons.php.
 *
 * @var array $attributes Block attributes (see block.json for defaults + schema).
 */

$visible_plans         = isset( $attributes['visiblePlans'] ) && is_array( $attributes['visiblePlans'] ) ? $attributes['visiblePlans'] : [ 'basic', 'pro', 'agency' ];
$variant               = ( $attributes['variant'] ?? 'full' ) === 'compact' ? 'compact' : 'full';
$highlighted_slug      = (string) ( $attributes['highlightedPlan'] ?? 'pro' );
$show_eyebrow          = ! empty( $attributes['showEyebrow'] );
// Compact mode shows only the top N features per plan to fit narrower placements
// (homepage teaser, sidebars, mid-article CTAs). Full mode always renders the
// complete feature list from inc/pricing-data.php.
$compact_feature_count = max( 1, min( 12, (int) ( $attributes['compactFeatureCount'] ?? 4 ) ) );
$is_compact            = 'compact' === $variant;

$data  = jetpack_theme_pricing_data();
$plans = array_values( array_filter(
	$data['plans'],
	static fn ( array $p ): bool => in_array( $p['slug'], $visible_plans, true )
) );

if ( empty( $plans ) ) {
	return;
}

// Layout knobs per variant. Compact drops padding and type size so the cards
// can live inside narrower columns (e.g. a mid-article CTA or a sidebar).
$padding       = 'compact' === $variant ? 'p-5 sm:p-6' : 'p-6 sm:p-8';
$price_size    = 'compact' === $variant ? 'text-3xl sm:text-4xl' : 'text-4xl sm:text-5xl';
$tagline_size  = 'compact' === $variant ? 'text-xs' : 'text-sm';
$grid_gap      = 'compact' === $variant ? 'gap-4' : 'gap-6 lg:gap-8';
$col_class     = count( $plans ) === 1
	? 'grid-cols-1'
	: ( count( $plans ) === 2 ? 'grid-cols-1 sm:grid-cols-2' : 'grid-cols-1 lg:grid-cols-3' );
$section_pad   = 'compact' === $variant ? 'py-12 sm:py-16' : 'py-16 sm:py-20';
?>
<section
	id="pricing"
	class="jetpack-pricing-table w-full bg-background px-6 scroll-mt-24 <?php echo esc_attr( $section_pad ); ?>"
	data-variant="<?php echo esc_attr( $variant ); ?>"
>
	<div class="mx-auto max-w-6xl">

		<?php if ( $show_eyebrow ) : ?>
		<div class="mb-10 text-center jetpack-reveal opacity-0 translate-y-5">
			<span class="inline-block rounded-full bg-jetpack-green-50/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-jetpack-green-60">
				<?php esc_html_e( 'Plans', 'jetpack-theme' ); ?>
			</span>
		</div>
		<?php endif; ?>

		<div class="grid items-stretch <?php echo esc_attr( $col_class ); ?> <?php echo esc_attr( $grid_gap ); ?>">
			<?php foreach ( $plans as $i => $plan ) :
				$is_popular = $plan['slug'] === $highlighted_slug;
				// `.jetpack-pricing-card` (not `.jetpack-reveal`) is the scroll-animations target
				// for these cards \u2014 scroll-animations.ts animates the class with a staggered
				// `delay: i * 0.1`. Having both classes would cause the generic reveal and the
				// staggered reveal to race on the same element.
				$card_wrap  = 'jetpack-pricing-card relative opacity-0 translate-y-5 ' . ( $is_popular ? 'lg:-my-4 z-10' : '' );
			?>
			<div class="<?php echo esc_attr( $card_wrap ); ?>">
				<?php if ( $is_popular ) : ?>
				<div class="absolute inset-0 rounded-3xl bg-gradient-to-t from-jetpack-green-50/25 to-transparent -z-10" aria-hidden="true"></div>
				<?php endif; ?>

				<div class="relative flex h-full flex-col overflow-hidden rounded-2xl bg-frame <?php echo esc_attr( $padding ); ?> <?php echo $is_popular ? 'shadow-xl ring-1 ring-jetpack-green-50/20' : 'border border-border shadow-sm'; ?>">

					<?php /* Plan name + SR-only "most popular" announcement */ ?>
					<div class="flex justify-between items-center mb-4">
						<h3 class="text-xl font-medium <?php echo $is_popular ? 'text-jetpack-green-50' : 'text-muted-foreground'; ?>">
							<?php echo esc_html( $plan['name'] ); ?>
							<?php if ( $is_popular ) : ?>
							<span class="sr-only"><?php esc_html_e( '(most popular plan)', 'jetpack-theme' ); ?></span>
							<?php endif; ?>
						</h3>
						<?php if ( $is_popular ) : ?>
						<span class="inline-block rounded-full bg-jetpack-green-50/15 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-jetpack-green-50" aria-hidden="true">
							<?php esc_html_e( 'Most popular', 'jetpack-theme' ); ?>
						</span>
						<?php endif; ?>
					</div>

					<?php /* Single price block */ ?>
					<div class="flex items-baseline gap-2">
						<span class="<?php echo esc_attr( $price_size ); ?> font-semibold tracking-tight text-foreground">
							<?php echo esc_html( $plan['price']['per_month'] ); ?>
						</span>
						<?php if ( 'agency' !== $plan['slug'] ) : ?>
						<span class="text-sm text-muted-foreground">/<?php esc_html_e( 'mo', 'jetpack-theme' ); ?></span>
						<?php endif; ?>
					</div>
					<?php if ( ! $is_compact ) : ?>
					<p class="mt-2 text-sm text-muted-foreground">
						<?php echo esc_html( $plan['price']['per_year_label'] ); ?>
					</p>
					<?php endif; ?>
					<?php if ( ! $is_compact && ! empty( $plan['price']['savings_label'] ) ) : ?>
					<p class="mt-1 text-xs font-semibold text-jetpack-green-50">
						<?php echo esc_html( $plan['price']['savings_label'] ); ?>
					</p>
					<?php endif; ?>

					<?php /* Tagline */ ?>
					<p class="mt-4 <?php echo esc_attr( $tagline_size ); ?> leading-relaxed text-muted-foreground">
						<?php echo esc_html( $plan['tagline'] ); ?>
					</p>

					<?php /* CTA */ ?>
					<a
						href="<?php echo esc_url( $plan['cta']['url'] ); ?>"
						class="mt-6 inline-flex w-full items-center justify-center rounded-xl px-4 py-3 text-sm font-semibold no-underline transition-all duration-200 <?php echo $is_popular ? 'bg-jetpack-green-50 text-white hover:bg-jetpack-green-60 hover:scale-[1.02]' : 'bg-foreground text-background hover:bg-foreground/90'; ?>"
					>
						<?php echo esc_html( $plan['cta']['text'] ); ?>
					</a>

					<?php
					/* Features — compact mode caps the list at $compact_feature_count
					 * (default 4) so cards fit narrower contexts. Full mode renders
					 * everything in $plan['features']. */
					$features = $is_compact
						? array_slice( $plan['features'], 0, $compact_feature_count )
						: $plan['features'];
					?>
					<div class="mt-8">
						<p class="text-sm font-semibold text-foreground">
							<?php esc_html_e( "What's included:", 'jetpack-theme' ); ?>
						</p>
						<ul class="mt-4 space-y-3" role="list">
							<?php foreach ( $features as $feature ) : ?>
							<li class="flex items-start gap-3">
								<span class="mt-1 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full <?php echo $is_popular ? 'bg-jetpack-green-50 text-white' : 'bg-foreground text-background'; ?>">
									<?php jetpack_theme_icon( 'check', 'h-3 w-3' ); ?>
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
