<?php
/**
 * Features Highlights block — server render.
 *
 * Renders alternating image + benefits sections for Growth, Performance, Security.
 * React view script mounts BlurHighlight on headings and AnimatedList on benefits.
 *
 * @var array $attributes Block attributes.
 */

$sections = $attributes['sections'] ?? [];

if ( empty( $sections ) ) {
	return;
}

$lucide_icons = [
	'trending-up' => '<polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>',
	'zap'         => '<path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/>',
	'shield'      => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/>',
];
?>
<section class="jetpack-features-highlights w-full py-20 md:py-32 px-6 bg-background">
	<div class="max-w-5xl mx-auto flex flex-col gap-28 md:gap-36">

		<?php foreach ( $sections as $i => $section ) :
		$section = wp_parse_args( $section, [
			'eyebrow'          => '',
			'eyebrowIcon'      => '',
			'heading'          => '',
			'headingHighlight' => '',
			'description'      => '',
			'benefits'         => [],
			'ctaLabel'         => '',
			'ctaUrl'           => '#',
			'imageUrl'         => '',
			'imageAlt'         => '',
			'mediaPosition'    => 'left',
		] );

		$image_left = 'left' === $section['mediaPosition'];
		$icon_slug  = $section['eyebrowIcon'];
		$icon_svg   = isset( $lucide_icons[ $icon_slug ] ) ? $lucide_icons[ $icon_slug ] : '';
		?>
		<div class="jetpack-fh-section grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-20 items-center opacity-0 translate-y-10">

			<?php /* ── Image column ─────────────────────────────────── */ ?>
			<div class="<?php echo $image_left ? 'md:order-1' : 'md:order-2'; ?>">
				<img
					src="<?php echo esc_url( $section['imageUrl'] ); ?>"
					alt="<?php echo esc_attr( $section['imageAlt'] ); ?>"
					class="w-full h-auto"
					loading="lazy"
					decoding="async"
				/>
			</div>

			<?php /* ── Content column ───────────────────────────────── */ ?>
			<div class="<?php echo $image_left ? 'md:order-2' : 'md:order-1'; ?> flex flex-col gap-0">

			<?php /* Eyebrow */ ?>
			<span class="text-accent font-bold text-sm uppercase tracking-[0.15em] mb-5 inline-flex items-center gap-1.5" data-fh-icon="<?php echo esc_attr( $icon_slug ); ?>">
				<?php if ( $icon_svg ) : ?>
				<svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<?php echo $icon_svg; ?>
				</svg>
				<?php endif; ?>
				<?php echo esc_html( $section['eyebrow'] ); ?>
			</span>

				<?php /* Heading — BlurHighlight mounts here */ ?>
				<h2
					class="text-3xl md:text-[2.75rem] font-semibold leading-[1.15] tracking-tight text-foreground mb-5"
					data-fh-heading="<?php echo esc_attr( $section['heading'] ); ?>"
					data-fh-highlight="<?php echo esc_attr( $section['headingHighlight'] ); ?>"
				>
					<?php echo esc_html( $section['heading'] ); ?>
				</h2>

				<?php /* Description */ ?>
				<p class="text-neutral-500 text-base md:text-[1.125rem] leading-relaxed mb-5">
					<?php echo esc_html( $section['description'] ); ?>
				</p>

				<?php /* Benefits — AnimatedList mounts here */ ?>
				<ul
					class="flex flex-col gap-1.5 mb-6"
					data-fh-benefits="<?php echo esc_attr( wp_json_encode( $section['benefits'] ) ); ?>"
				>
					<?php foreach ( $section['benefits'] as $benefit ) :
						$benefit = wp_parse_args( $benefit, [ 'text' => '', 'linkText' => '', 'linkUrl' => '#' ] );
					?>
					<li class="flex items-start gap-3">
						<span class="mt-1.5 shrink-0 w-5 h-5 rounded-full bg-neutral-200 flex items-center justify-center">
							<svg class="w-3 h-3 text-neutral-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<polyline points="20 6 9 17 4 12"/>
							</svg>
						</span>
						<span class="text-base md:text-lg leading-normal text-neutral-600">
							<?php echo esc_html( $benefit['text'] ); ?>
							<a
								href="<?php echo esc_url( $benefit['linkUrl'] ); ?>"
								class="inline-flex items-center ml-1 px-2.5 py-0.5 rounded-full bg-accent/15 text-accent font-semibold text-sm md:text-[0.9375rem] hover:bg-accent/25 transition-colors"
							><?php echo esc_html( $benefit['linkText'] ); ?></a>
						</span>
					</li>
					<?php endforeach; ?>
				</ul>

				<?php /* CTA button */ ?>
				<div>
					<a
						href="<?php echo esc_url( $section['ctaUrl'] ); ?>"
						class="inline-flex items-center gap-2.5 px-7 py-3.5 bg-foreground text-background font-semibold text-[0.9375rem] rounded-xl hover:bg-foreground/85 transition-colors"
					>
						<?php echo esc_html( $section['ctaLabel'] ); ?>
						<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
							<path d="M5 12h14M12 5l7 7-7 7"/>
						</svg>
					</a>
				</div>

			</div>
		</div>
		<?php endforeach; ?>
	</div>
</section>
