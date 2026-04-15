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
?>
<section class="jetpack-features-highlights w-full px-6 bg-background">
	<div class="max-w-6xl mx-auto flex flex-col gap-24 md:gap-32">
		<?php foreach ( $sections as $i => $section ) :
			$section = wp_parse_args( $section, [
				'eyebrow'          => '',
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
		?>
		<div class="jetpack-fh-section grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center opacity-0 translate-y-10">

			<?php /* ── Image column ─────────────────────────────────── */ ?>
			<div class="<?php echo $image_left ? 'md:order-1' : 'md:order-2'; ?>">
				<img
					src="<?php echo esc_url( $section['imageUrl'] ); ?>"
					alt="<?php echo esc_attr( $section['imageAlt'] ); ?>"
					class="w-full h-auto rounded-2xl"
					loading="lazy"
					decoding="async"
				/>
			</div>

			<?php /* ── Content column ───────────────────────────────── */ ?>
			<div class="<?php echo $image_left ? 'md:order-2' : 'md:order-1'; ?> flex flex-col">

				<?php /* Eyebrow */ ?>
				<span class="text-accent font-semibold text-base mb-4 tracking-wide">
					<?php echo esc_html( $section['eyebrow'] ); ?>
				</span>

				<?php /* Heading — BlurHighlight mounts here */ ?>
				<h2
					class="text-3xl md:text-[2.75rem] font-semibold leading-tight text-foreground mb-4"
					data-fh-heading="<?php echo esc_attr( $section['heading'] ); ?>"
					data-fh-highlight="<?php echo esc_attr( $section['headingHighlight'] ); ?>"
				>
					<?php echo esc_html( $section['heading'] ); ?>
				</h2>

				<?php /* Description */ ?>
				<p class="text-muted text-base md:text-lg leading-relaxed mb-6">
					<?php echo esc_html( $section['description'] ); ?>
				</p>

				<?php /* Benefits — AnimatedList mounts here */ ?>
				<ul
					class="flex flex-col gap-3 mb-8"
					data-fh-benefits="<?php echo esc_attr( wp_json_encode( $section['benefits'] ) ); ?>"
				>
					<?php foreach ( $section['benefits'] as $benefit ) :
						$benefit = wp_parse_args( $benefit, [ 'text' => '', 'linkText' => '', 'linkUrl' => '#' ] );
					?>
					<li class="flex items-start gap-3 text-foreground">
						<svg class="w-5 h-5 mt-0.5 shrink-0 text-accent" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
						</svg>
						<span>
							<?php echo esc_html( $benefit['text'] ); ?>
							<a
								href="<?php echo esc_url( $benefit['linkUrl'] ); ?>"
								class="font-semibold text-accent hover:underline"
							><?php echo esc_html( $benefit['linkText'] ); ?></a>
						</span>
					</li>
					<?php endforeach; ?>
				</ul>

				<?php /* CTA button */ ?>
				<div>
					<a
						href="<?php echo esc_url( $section['ctaUrl'] ); ?>"
						class="inline-flex items-center gap-2 px-6 py-3 bg-accent text-white font-medium rounded-lg hover:bg-accent/90 transition-colors"
					>
						<?php echo esc_html( $section['ctaLabel'] ); ?>
						<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
							<path d="M5 12h14M12 5l7 7-7 7"/>
						</svg>
					</a>
				</div>

			</div>
		</div>
		<?php endforeach; ?>
	</div>
</section>
