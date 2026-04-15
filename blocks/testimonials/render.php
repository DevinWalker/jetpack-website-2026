<?php
/**
 * Testimonials block — server render.
 * The Interactivity API store handles auto-advance and avatar clicks.
 *
 * @var array $attributes Block attributes.
 */

$title = $attributes['sectionTitle'] ?? 'Trusted by 27 million WordPress sites';
$items = $attributes['items'] ?? [];
$theme_uri = get_template_directory_uri();
$accent = '#a8d946';

if ( empty( $items ) ) {
	return;
}

// Circumference for the SVG progress ring (r=48).
$circumference = 2 * M_PI * 48;
?>
<section
	class="jetpack-testimonials w-full bg-frame border-t border-b border-accent/15 px-6 py-32"
	data-wp-interactive="jetpack-theme/testimonials"
	<?php echo wp_kses_data( wp_interactivity_data_wp_context( [ 'activeIndex' => 0, 'count' => count( $items ) ] ) ); ?>
>
	<div class="mx-auto max-w-5xl">

		<h2 class="mb-16 text-4xl leading-tight font-medium text-neutral-900 sm:text-5xl lg:mb-20 lg:text-6xl opacity-0" data-wp-class--jetpack-visible="true">
			<?php echo esc_html( $title ); ?>
		</h2>

		<div class="mb-16 grid gap-8 lg:mb-20 lg:grid-cols-2 lg:gap-12">

			<?php /* ── Avatar tabs ──────────────────────────────────── */ ?>
			<div class="flex items-center justify-start gap-4 lg:gap-6" role="tablist" aria-label="<?php esc_attr_e( 'Testimonials', 'jetpack-theme' ); ?>">
				<?php foreach ( $items as $i => $t ) :
					$is_active_expr = "state.activeIndex === context.index";
				?>
				<div
					class="jetpack-testimonial-avatar relative cursor-pointer"
					role="tab"
					tabindex="<?php echo $i === 0 ? '0' : '-1'; ?>"
					data-wp-on--click="actions.setActive"
					data-wp-bind--aria-selected="state.activeIndex === context.index"
					<?php echo wp_kses_data( wp_interactivity_data_wp_context( [ 'index' => $i ] ) ); ?>
					style="transition:transform 0.5s ease-in-out,opacity 0.5s ease-in-out;<?php echo $i === 0 ? 'transform:scale(1.1);opacity:1' : 'transform:scale(0.9);opacity:0.6'; ?>"
				>
					<div
						class="relative flex h-12 w-12 items-center justify-center overflow-hidden rounded-full transition-colors duration-500 sm:h-16 sm:w-16 lg:h-20 lg:w-20"
						style="<?php echo $i === 0 ? 'background-color:' . esc_attr( $accent ) : ''; ?>"
						data-wp-style--background-color="state.activeIndex === context.index ? '<?php echo esc_attr( $accent ); ?>' : ''"
					>
						<img
							src="<?php echo esc_url( $t['avatar'] ); ?>"
							alt="<?php echo esc_attr( $t['name'] ); ?>"
							width="64"
							height="64"
							class="h-8 w-8 rounded-full object-cover grayscale sm:h-12 sm:w-12 lg:h-16 lg:w-16"
							loading="lazy"
						/>
					</div>

					<?php /* Progress ring — shown only on active avatar */ ?>
					<svg
						class="absolute -inset-2 h-[calc(100%+16px)] w-[calc(100%+16px)] -rotate-90"
						viewBox="0 0 100 100"
						aria-hidden="true"
						data-wp-class--opacity-0="state.activeIndex !== context.index"
					>
						<circle cx="50" cy="50" r="48" fill="none" stroke="<?php echo esc_attr( $accent ); ?>" stroke-width="1.5" opacity="0.2" />
						<circle
							class="jetpack-progress-ring"
							cx="50" cy="50" r="48"
							fill="none"
							stroke="<?php echo esc_attr( $accent ); ?>"
							stroke-width="1.5"
							stroke-dasharray="<?php echo esc_attr( $circumference ); ?>"
							stroke-dashoffset="<?php echo esc_attr( $circumference ); ?>"
							stroke-linecap="round"
						/>
					</svg>

				</div>
				<?php endforeach; ?>
			</div>

			<?php /* ── Quote panel ────────────────────────────────── */ ?>
			<div class="flex flex-col justify-center" role="tabpanel" aria-live="polite">
				<?php foreach ( $items as $i => $t ) : ?>
				<div
					class="jetpack-quote"
					data-testimonial-index="<?php echo esc_attr( $i ); ?>"
					style="<?php echo $i === 0 ? 'display:block' : 'display:none'; ?>"
				>
					<blockquote class="mb-6 text-xl leading-relaxed text-neutral-700">
						&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;
					</blockquote>
					<div class="text-base font-medium text-neutral-900 sm:text-lg">
						<?php echo esc_html( $t['name'] ); ?>,
						<span class="text-neutral-600"><?php echo esc_html( $t['title'] ); ?></span>
					</div>
				</div>
				<?php endforeach; ?>
			</div>

		</div>

		<?php /* ── Company logos ──────────────────────────────────── */ ?>
		<div class="flex items-center justify-between gap-6 lg:gap-8">
			<?php foreach ( $items as $i => $t ) : ?>
			<div
				class="flex items-center"
				data-testimonial-logo="<?php echo esc_attr( $i ); ?>"
			>
				<img
					src="<?php echo esc_url( $theme_uri . '/assets/' . $t['logo'] ); ?>"
					alt="<?php echo esc_attr( $t['company'] . ' logo' ); ?>"
					width="120"
					height="40"
					class="h-8 w-auto object-contain brightness-0 transition-all duration-300 sm:h-10 <?php echo $i === 0 ? 'opacity-100' : 'opacity-30'; ?>"
					loading="lazy"
				/>
			</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
