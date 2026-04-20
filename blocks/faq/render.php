<?php
/**
 * FAQ block — server render with Interactivity API accordion.
 *
 * @var array $attributes Block attributes.
 */

$title        = $attributes['sectionTitle']       ?? 'Everything you need to know';
$description  = $attributes['sectionDescription'] ?? "Can't find the answer you're looking for? Reach out!";
$cta_primary  = [ 'text' => $attributes['ctaPrimaryText']   ?? 'Get Started',      'url' => $attributes['ctaPrimaryUrl']   ?? home_url( '/pricing/' ) ];
$cta_secondary= [ 'text' => $attributes['ctaSecondaryText'] ?? 'Contact Support',   'url' => $attributes['ctaSecondaryUrl'] ?? home_url( '/support/' ) ];
$items        = $attributes['items'] ?? [];
?>
<section
	class="jetpack-faq w-full px-6 py-20 sm:py-28"
	data-wp-interactive="jetpack-theme/faq"
	<?php echo wp_kses_data( wp_interactivity_data_wp_context( [ 'openIndex' => 0 ] ) ); ?>
>
	<div class="mx-auto max-w-3xl">

		<div class="mb-12 text-center sm:mb-16 jetpack-reveal opacity-0 translate-y-5">
			<span class="text-sm font-medium text-muted-foreground"><?php esc_html_e( 'Frequently Asked Questions', 'jetpack-theme' ); ?></span>
			<h2 class="mt-3 text-3xl font-semibold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
				<?php echo esc_html( $title ); ?>
			</h2>
			<p class="mx-auto mt-4 max-w-xl text-base text-muted-foreground sm:text-lg">
				<?php echo esc_html( $description ); ?>
			</p>
			<div class="mt-8 flex flex-wrap items-center justify-center gap-3">
				<a href="<?php echo esc_url( $cta_primary['url'] ); ?>" class="inline-flex items-center rounded-xl bg-foreground px-6 py-2.5 text-sm font-semibold text-background no-underline transition-colors hover:bg-foreground/90">
					<?php echo esc_html( $cta_primary['text'] ); ?>
				</a>
				<a href="<?php echo esc_url( $cta_secondary['url'] ); ?>" class="inline-flex items-center rounded-xl border border-border bg-frame px-6 py-2.5 text-sm font-semibold text-foreground no-underline transition-colors">
					<?php echo esc_html( $cta_secondary['text'] ); ?>
				</a>
			</div>
		</div>

		<div class="flex flex-col gap-3" role="list">
			<?php foreach ( $items as $i => $faq ) : ?>
			<div
				class="jetpack-faq-item cursor-pointer rounded-2xl bg-frame p-5 shadow-sm sm:p-6 transition-shadow hover:shadow-md jetpack-reveal opacity-0 translate-y-5"
				role="listitem"
				data-wp-on--click="actions.toggle"
				data-wp-on--keydown="actions.keydown"
				tabindex="0"
				<?php echo wp_kses_data( wp_interactivity_data_wp_context( [ 'index' => $i ] ) ); ?>
				data-wp-bind--aria-expanded="state.openIndex === context.index"
				style="transition-delay:<?php echo esc_attr( ( $i * 0.05 ) . 's' ); ?>"
			>
				<div class="flex w-full items-center justify-between gap-4 text-left">
					<span class="text-base font-medium text-foreground sm:text-lg">
						<?php echo esc_html( $faq['question'] ); ?>
					</span>
					<span
						class="shrink-0 transition-transform duration-300"
						data-wp-class--rotate-180="state.openIndex === context.index"
						aria-hidden="true"
					>
						<svg class="h-5 w-5 text-muted-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
					</span>
				</div>
				<div
					class="jetpack-faq-answer overflow-hidden transition-all duration-300"
					style="max-height:0"
					data-wp-class--jetpack-faq-open="state.openIndex === context.index"
				>
					<p class="pt-4 text-sm leading-relaxed text-muted-foreground sm:text-base">
						<?php echo esc_html( $faq['answer'] ); ?>
					</p>
				</div>
			</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
