<?php
/**
 * Pricing Comparison block — server render.
 *
 * Full Free-vs-Pro feature comparison. Every category is rendered in sequence
 * (no tabs, no JS). Desktop uses a semantic <table> for screen-reader parity;
 * mobile falls back to stacked cards with <dl> semantics.
 *
 * Data comes from inc/pricing-data.php; icons from inc/icons.php.
 *
 * @var array $attributes Block attributes (see block.json).
 */

$title       = (string) ( $attributes['sectionTitle']       ?? '' );
$description = (string) ( $attributes['sectionDescription'] ?? '' );

$data       = jetpack_theme_pricing_data();
$comparison = $data['comparison'];

/**
 * Render a single value cell (bool → check/x, string → literal).
 *
 * @param bool|string $value      The feature value.
 * @param bool        $is_pro_col Whether this is the highlighted (Pro) column.
 */
$render_value = static function ( $value, bool $is_pro_col = false ): void {
	if ( is_bool( $value ) ) {
		if ( $value ) {
			echo '<span class="inline-flex h-8 w-8 items-center justify-center rounded-full ' . ( $is_pro_col ? 'bg-jetpack-green-50 text-white' : 'bg-foreground text-background' ) . '">';
			jetpack_theme_icon( 'check', 'h-5 w-5' );
			echo '</span>';
			echo '<span class="sr-only">' . esc_html__( 'Included', 'jetpack-theme' ) . '</span>';
		} else {
			echo '<span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-muted text-muted-foreground">';
			jetpack_theme_icon( 'x', 'h-5 w-5' );
			echo '</span>';
			echo '<span class="sr-only">' . esc_html__( 'Not included', 'jetpack-theme' ) . '</span>';
		}
	} else {
		$color = $is_pro_col ? 'text-jetpack-green-60' : 'text-foreground';
		echo '<span class="text-center text-sm font-semibold ' . esc_attr( $color ) . '">' . esc_html( (string) $value ) . '</span>';
	}
};
?>
<section id="compare-free-pro" class="jetpack-pricing-comparison w-full bg-background px-6 py-20 sm:py-28 scroll-mt-24">
	<div class="mx-auto w-full max-w-5xl">

		<?php /* Header */ ?>
		<div class="mb-10 text-center sm:mb-14 jetpack-reveal opacity-0 translate-y-5">
			<span class="inline-block rounded-full bg-accent/15 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-accent">
				<?php esc_html_e( 'Compare plans', 'jetpack-theme' ); ?>
			</span>
			<h2 class="mt-3 text-3xl font-semibold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
				<?php echo esc_html( $title ); ?>
			</h2>
			<?php if ( ! empty( $description ) ) : ?>
			<p class="mx-auto mt-4 max-w-2xl text-base text-muted-foreground sm:text-lg">
				<?php echo esc_html( $description ); ?>
			</p>
			<?php endif; ?>
		</div>

		<?php /* TL;DR callout — the three things most Pro customers upgrade for. */ ?>
		<div class="mx-auto mb-10 max-w-3xl rounded-2xl border border-border bg-frame p-5 sm:p-6 jetpack-reveal opacity-0 translate-y-5">
			<p class="text-xs font-semibold uppercase tracking-wide text-jetpack-green-60">
				<?php esc_html_e( 'The three things most Pro customers upgrade for', 'jetpack-theme' ); ?>
			</p>
			<ul class="mt-3 flex flex-col gap-2 text-sm text-foreground sm:flex-row sm:flex-wrap sm:gap-x-6">
				<li class="flex items-center gap-2">
					<span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-jetpack-green-50 text-white">
						<?php jetpack_theme_icon( 'check', 'h-3 w-3' ); ?>
					</span>
					<?php esc_html_e( 'Real-time backups', 'jetpack-theme' ); ?>
				</li>
				<li class="flex items-center gap-2">
					<span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-jetpack-green-50 text-white">
						<?php jetpack_theme_icon( 'check', 'h-3 w-3' ); ?>
					</span>
					<?php esc_html_e( 'Malware removal', 'jetpack-theme' ); ?>
				</li>
				<li class="flex items-center gap-2">
					<span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-jetpack-green-50 text-white">
						<?php jetpack_theme_icon( 'check', 'h-3 w-3' ); ?>
					</span>
					<?php esc_html_e( 'Boost performance', 'jetpack-theme' ); ?>
				</li>
			</ul>
		</div>

		<?php /* ── Desktop: semantic <table>, categories as <tbody> groups with <th scope="rowgroup"> ── */ ?>
		<div class="hidden lg:block jetpack-reveal opacity-0 translate-y-5">
			<table class="w-full border-separate border-spacing-0 rounded-3xl bg-muted p-1 text-left">
				<caption class="sr-only">
					<?php esc_html_e( 'Jetpack Free versus Jetpack Pro feature comparison', 'jetpack-theme' ); ?>
				</caption>
				<thead>
					<tr>
						<th scope="col" class="rounded-tl-3xl bg-frame px-8 py-6 align-bottom">
							<span class="text-sm font-semibold text-foreground"><?php esc_html_e( 'Feature', 'jetpack-theme' ); ?></span>
						</th>
						<th scope="col" class="bg-frame px-8 py-6 text-center align-bottom">
							<div class="text-lg font-semibold text-foreground">
								<?php esc_html_e( 'Free', 'jetpack-theme' ); ?>
							</div>
							<div class="mt-1 text-xs font-medium uppercase tracking-wide text-muted-foreground">
								<?php esc_html_e( 'Current plan', 'jetpack-theme' ); ?>
							</div>
						</th>
						<th scope="col" class="relative overflow-hidden rounded-tr-3xl px-8 py-6 text-center align-bottom">
							<span
								class="absolute inset-0 -z-0"
								style="background: radial-gradient(165% 165% at 50% 90%, var(--wp--preset--color--frame, #fff) 40%, var(--wp--preset--color--jetpack-green-50, #069e08) 100%);"
								aria-hidden="true"
							></span>
							<span class="relative z-10 block">
								<span class="block text-lg font-semibold text-foreground">
									<?php esc_html_e( 'Pro', 'jetpack-theme' ); ?>
								</span>
								<span class="mt-1 inline-flex items-center gap-1 text-xs font-medium uppercase tracking-wide text-jetpack-green-60">
									<?php esc_html_e( 'Most popular', 'jetpack-theme' ); ?>
									<span aria-hidden="true">↗</span>
								</span>
							</span>
						</th>
					</tr>
				</thead>

				<?php foreach ( $comparison as $cat_slug => $cat ) :
					$rows = $cat['rows'] ?? [];
					if ( empty( $rows ) ) continue;
				?>
				<tbody class="border-t-4 border-muted">
					<tr>
						<th scope="colgroup" colspan="3" class="bg-frame px-8 pt-6 pb-3 text-left">
							<span class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-jetpack-green-60">
								<?php jetpack_theme_icon( $cat['icon'], 'h-4 w-4' ); ?>
								<?php echo esc_html( $cat['label'] ); ?>
							</span>
						</th>
					</tr>
					<?php foreach ( $rows as $row_i => $row ) :
						$is_last_in_last = ( $row_i === count( $rows ) - 1 ) && ( $cat_slug === array_key_last( $comparison ) );
					?>
					<tr>
						<th scope="row" class="bg-frame px-8 py-5 align-top <?php echo $is_last_in_last ? 'rounded-bl-3xl' : ''; ?>">
							<span class="block text-sm font-semibold text-foreground">
								<?php echo esc_html( $row['title'] ); ?>
							</span>
							<span class="mt-1 block max-w-md text-sm font-normal text-muted-foreground">
								<?php echo esc_html( $row['description'] ); ?>
							</span>
						</th>
						<td class="bg-frame px-6 py-5 text-center align-middle">
							<?php $render_value( $row['free'], false ); ?>
						</td>
						<td class="bg-frame px-6 py-5 text-center align-middle <?php echo $is_last_in_last ? 'rounded-br-3xl' : ''; ?>">
							<?php $render_value( $row['pro'], true ); ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				<?php endforeach; ?>
			</table>
		</div>

		<?php /* ── Mobile: stacked cards per category ───────────────────────── */ ?>
		<div class="flex flex-col gap-8 lg:hidden jetpack-reveal opacity-0 translate-y-5">
			<?php foreach ( $comparison as $cat ) :
				$rows = $cat['rows'] ?? [];
				if ( empty( $rows ) ) continue;
			?>
			<div>
				<h3 class="mb-3 flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-jetpack-green-60">
					<?php jetpack_theme_icon( $cat['icon'], 'h-4 w-4' ); ?>
					<?php echo esc_html( $cat['label'] ); ?>
				</h3>
				<div class="flex flex-col gap-3">
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
									<?php $render_value( $row['free'], false ); ?>
								</div>
							</div>
							<div class="bg-frame p-5">
								<div class="mb-2 text-xs font-semibold uppercase tracking-wide text-jetpack-green-60">
									<?php esc_html_e( 'Pro', 'jetpack-theme' ); ?>
								</div>
								<div class="flex items-center">
									<?php $render_value( $row['pro'], true ); ?>
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
