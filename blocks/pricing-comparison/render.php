<?php
/**
 * Pricing Comparison block — server render.
 *
 * Ports the visual structure of ReactBits Pro "comparison-2" with Free vs Pro
 * columns. Category tabs (Security / Performance / Growth / Management) swap
 * the feature rows via pricing-interactions.js.
 *
 * Data (features per category, boolean/string per column) comes from
 * inc/pricing-data.php.
 *
 * @var array $attributes Block attributes.
 */

require_once get_template_directory() . '/inc/pricing-data.php';

$title            = $attributes['sectionTitle']       ?? '';
$description      = $attributes['sectionDescription'] ?? '';
$default_category = in_array( $attributes['defaultCategory'] ?? 'security', [ 'security', 'performance', 'growth', 'management' ], true ) ? $attributes['defaultCategory'] : 'security';

$data       = jetpack_theme_pricing_data();
$comparison = $data['comparison'];

$categories = [
	'security'    => [ 'label' => __( 'Security',    'jetpack-theme' ), 'icon' => 'shield' ],
	'performance' => [ 'label' => __( 'Performance', 'jetpack-theme' ), 'icon' => 'zap' ],
	'growth'      => [ 'label' => __( 'Growth',      'jetpack-theme' ), 'icon' => 'trending-up' ],
	'management'  => [ 'label' => __( 'Management',  'jetpack-theme' ), 'icon' => 'settings' ],
];

/**
 * Render a single cell value (boolean → check/x, string → literal).
 *
 * @param bool|string $value      The feature value.
 * @param bool        $is_popular Whether this column is the highlighted (Pro) column.
 */
function jetpack_theme_comparison_cell( $value, bool $is_popular = false ): void {
	if ( is_bool( $value ) ) {
		if ( $value ) {
			?>
			<div class="inline-flex h-8 w-8 items-center justify-center rounded-full <?php echo $is_popular ? 'bg-jetpack-green-50 text-white' : 'bg-foreground text-background'; ?>">
				<?php $icon = 'check'; $classes = 'h-5 w-5'; include __DIR__ . '/parts/_icons.php'; ?>
			</div>
			<?php
		} else {
			?>
			<div class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-muted text-muted-foreground">
				<?php $icon = 'x'; $classes = 'h-5 w-5'; include __DIR__ . '/parts/_icons.php'; ?>
			</div>
			<?php
		}
	} else {
		$text_class = $is_popular ? 'text-jetpack-green-60' : 'text-foreground';
		echo '<span class="text-center text-sm font-semibold ' . esc_attr( $text_class ) . '">' . esc_html( (string) $value ) . '</span>';
	}
}
?>
<section
	class="jetpack-pricing-comparison w-full bg-background px-6 py-20 sm:py-28"
	data-wp-interactive="jetpack-theme/pricing-comparison"
	data-default-category="<?php echo esc_attr( $default_category ); ?>"
	<?php echo wp_kses_data( wp_interactivity_data_wp_context( [ 'category' => $default_category ] ) ); ?>
>
	<div class="mx-auto w-full max-w-5xl">

		<?php /* ── Header ──────────────────────────────────────────────── */ ?>
		<div class="mb-12 text-center sm:mb-16 jetpack-reveal opacity-0 translate-y-5">
			<span class="inline-block rounded-full bg-accent/15 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-accent">
				<?php esc_html_e( 'Compare plans', 'jetpack-theme' ); ?>
			</span>
			<h2 class="mt-3 text-3xl font-semibold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
				<?php echo esc_html( $title ); ?>
			</h2>
			<p class="mx-auto mt-4 max-w-2xl text-base text-muted-foreground sm:text-lg">
				<?php echo esc_html( $description ); ?>
			</p>
		</div>

		<?php /* ── Category tabs (shared by mobile + desktop) ─────────── */ ?>
		<div class="jetpack-category-tabs mb-8 flex flex-wrap items-center justify-center gap-2 jetpack-reveal opacity-0 translate-y-5" role="tablist" aria-label="<?php esc_attr_e( 'Feature category', 'jetpack-theme' ); ?>">
			<?php foreach ( $categories as $cat_slug => $cat ) :
				$is_active = $cat_slug === $default_category;
			?>
			<button
				type="button"
				role="tab"
				data-category="<?php echo esc_attr( $cat_slug ); ?>"
				aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
				class="jetpack-category-tabs__btn cursor-pointer inline-flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-medium transition-colors duration-200 <?php echo $is_active ? 'border-jetpack-green-50 bg-jetpack-green-50 text-white' : 'border-border bg-frame text-foreground hover:bg-muted'; ?>"
			>
				<?php $icon = $cat['icon']; $classes = 'h-4 w-4'; include __DIR__ . '/parts/_icons.php'; ?>
				<?php echo esc_html( $cat['label'] ); ?>
			</button>
			<?php endforeach; ?>
		</div>

		<div class="relative overflow-hidden rounded-3xl bg-muted p-1">

			<?php foreach ( $categories as $cat_slug => $cat ) :
				$rows      = $comparison[ $cat_slug ] ?? [];
				$is_active = $cat_slug === $default_category;
			?>
			<div
				class="jetpack-category-panel <?php echo $is_active ? '' : 'hidden'; ?>"
				data-category="<?php echo esc_attr( $cat_slug ); ?>"
				role="tabpanel"
				<?php if ( ! $is_active ) : ?>hidden<?php endif; ?>
			>

				<?php /* ── Desktop table ─────────────────────────────── */ ?>
				<div class="hidden lg:block">

					<?php /* Column headers */ ?>
					<div class="grid grid-cols-[2fr_1fr_1fr] gap-1 border-b-4 border-muted">
						<div class="rounded-tl-3xl bg-frame px-8 py-6">
							<h3 class="text-base font-semibold text-foreground">
								<?php echo esc_html( $cat['label'] ); ?>
							</h3>
							<p class="mt-1 text-sm text-muted-foreground">
								<?php esc_html_e( 'Compare what you get on each plan', 'jetpack-theme' ); ?>
							</p>
						</div>

						<?php /* Free column header */ ?>
						<div class="bg-frame px-8 py-6 text-center">
							<div class="text-lg font-semibold text-foreground">
								<?php esc_html_e( 'Free', 'jetpack-theme' ); ?>
							</div>
							<div class="mt-1 text-xs font-medium uppercase tracking-wide text-muted-foreground">
								<?php esc_html_e( 'Current plan', 'jetpack-theme' ); ?>
							</div>
						</div>

						<?php /* Pro column header — radial gradient highlight using Jetpack green token */ ?>
						<div class="relative overflow-hidden rounded-tr-3xl px-8 py-6">
							<div
								class="absolute inset-0 -z-0"
								style="background: radial-gradient(165% 165% at 50% 90%, var(--wp--preset--color--frame, #fff) 40%, var(--wp--preset--color--jetpack-green-50, #069e08) 100%);"
								aria-hidden="true"
							></div>
							<div class="relative z-10 text-center">
								<div class="text-lg font-semibold text-foreground">
									<?php esc_html_e( 'Pro', 'jetpack-theme' ); ?>
								</div>
								<div class="mt-1 inline-flex items-center gap-1 text-xs font-medium uppercase tracking-wide text-jetpack-green-60">
									<?php esc_html_e( 'Most popular', 'jetpack-theme' ); ?>
									<span aria-hidden="true">↗</span>
								</div>
							</div>
						</div>
					</div>

					<?php /* Feature rows */ ?>
					<?php foreach ( $rows as $row_i => $row ) :
						$is_last = $row_i === count( $rows ) - 1;
					?>
					<div class="grid grid-cols-[2fr_1fr_1fr] gap-1">
						<div class="bg-frame px-8 py-6 <?php echo $is_last ? 'rounded-bl-3xl' : ''; ?>">
							<div class="text-sm font-semibold text-foreground">
								<?php echo esc_html( $row['title'] ); ?>
							</div>
							<div class="mt-1 max-w-md text-sm text-muted-foreground">
								<?php echo esc_html( $row['description'] ); ?>
							</div>
						</div>
						<div class="flex items-center justify-center bg-frame px-6 py-6">
							<?php jetpack_theme_comparison_cell( $row['free'], false ); ?>
						</div>
						<div class="flex items-center justify-center bg-frame px-6 py-6 <?php echo $is_last ? 'rounded-br-3xl' : ''; ?>">
							<?php jetpack_theme_comparison_cell( $row['pro'], true ); ?>
						</div>
					</div>
					<?php endforeach; ?>
				</div>

				<?php /* ── Mobile stacked cards ──────────────────────── */ ?>
				<div class="flex flex-col gap-3 lg:hidden">
					<?php foreach ( $rows as $row ) : ?>
					<div class="overflow-hidden rounded-2xl bg-frame">
						<div class="border-b border-border px-5 py-4">
							<div class="text-base font-semibold text-foreground">
								<?php echo esc_html( $row['title'] ); ?>
							</div>
							<div class="mt-1 text-xs text-muted-foreground">
								<?php echo esc_html( $row['description'] ); ?>
							</div>
						</div>
						<div class="grid grid-cols-2 gap-px bg-border">
							<div class="bg-frame p-5">
								<div class="mb-2 text-xs font-semibold uppercase tracking-wide text-muted-foreground">
									<?php esc_html_e( 'Free', 'jetpack-theme' ); ?>
								</div>
								<div class="flex items-center">
									<?php jetpack_theme_comparison_cell( $row['free'], false ); ?>
								</div>
							</div>
							<div class="bg-frame p-5">
								<div class="mb-2 text-xs font-semibold uppercase tracking-wide text-jetpack-green-60">
									<?php esc_html_e( 'Pro', 'jetpack-theme' ); ?>
								</div>
								<div class="flex items-center">
									<?php jetpack_theme_comparison_cell( $row['pro'], true ); ?>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>

			</div>
			<?php endforeach; ?>

		</div>

	</div>
</section>
