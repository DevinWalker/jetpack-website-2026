<?php
/**
 * Testimonials block — two-column slider matching jetpack.com live design.
 * Left: blockquote + author. Right: author photo.
 * JS view script handles auto-advance, dot nav, and slide transitions.
 *
 * @var array $attributes Block attributes.
 */

$title = $attributes['sectionTitle'] ?? 'Trusted by 27 million WordPress sites';
$items = $attributes['items'] ?? [];

if ( empty( $items ) ) {
	return;
}

$count = count( $items );
?>
<section
	class="jetpack-testimonials w-full bg-frame px-6 py-24 sm:py-32"
	data-wp-interactive="jetpack-theme/testimonials"
	data-testimonial-count="<?php echo esc_attr( $count ); ?>"
>
	<div class="mx-auto max-w-6xl">

		<h2 class="mb-16 text-4xl leading-tight font-medium tracking-tight text-foreground sm:text-5xl lg:mb-20 lg:text-6xl jetpack-reveal opacity-0 translate-y-5">
			<?php echo esc_html( $title ); ?>
		</h2>

		<div class="jetpack-slider" role="region" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Testimonials', 'jetpack-theme' ); ?>">

			<div class="jetpack-slider__track">
				<?php foreach ( $items as $i => $t ) : ?>
				<div
					class="jetpack-slide <?php echo $i === 0 ? 'jetpack-slide--active' : ''; ?>"
					role="group"
					aria-roledescription="slide"
					aria-label="<?php echo esc_attr( sprintf( '%d of %d', $i + 1, $count ) ); ?>"
					data-slide-index="<?php echo esc_attr( $i ); ?>"
				>
					<div class="jetpack-slide__inner">
						<div class="jetpack-slide__content">
							<blockquote class="jetpack-slide__quote">
								<?php echo esc_html( $t['quote'] ); ?>
							</blockquote>
							<div class="jetpack-slide__author">
								<span class="jetpack-slide__name"><?php echo esc_html( $t['name'] ); ?></span>
								<?php if ( ! empty( $t['url'] ) ) : ?>
								<a href="<?php echo esc_url( $t['url'] ); ?>" class="jetpack-slide__title" target="_blank" rel="noopener noreferrer">
									<?php echo esc_html( $t['title'] ); ?>
								</a>
								<?php else : ?>
								<span class="jetpack-slide__title"><?php echo esc_html( $t['title'] ); ?></span>
								<?php endif; ?>
							</div>
						</div>
						<div class="jetpack-slide__photo">
							<img
								src="<?php echo esc_url( $t['avatar'] ); ?>"
								alt="<?php echo esc_attr( $t['name'] ); ?>"
								width="480"
								height="480"
								loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>"
							/>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>

			<?php if ( $count > 1 ) : ?>
			<div class="jetpack-slider__dots" role="tablist" aria-label="<?php esc_attr_e( 'Slide navigation', 'jetpack-theme' ); ?>">
				<?php for ( $i = 0; $i < $count; $i++ ) : ?>
				<button
					class="jetpack-slider__dot <?php echo $i === 0 ? 'jetpack-slider__dot--active' : ''; ?>"
					role="tab"
					aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
					aria-label="<?php echo esc_attr( sprintf( __( 'Slide %d', 'jetpack-theme' ), $i + 1 ) ); ?>"
					data-dot-index="<?php echo esc_attr( $i ); ?>"
				></button>
				<?php endfor; ?>
			</div>
			<?php endif; ?>

		</div>

	</div>
</section>
