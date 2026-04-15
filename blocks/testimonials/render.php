<?php
/**
 * Testimonials block — two-column slider.
 * Nav arrows live inside the content column so they never push the photo away from the card edge.
 *
 * @var array $attributes Block attributes.
 */

$items = $attributes['items'] ?? [];
if ( empty( $items ) ) {
	return;
}

$count   = count( $items );
$has_nav = $count > 1;
?>
<section
	class="jetpack-testimonials w-full px-6 py-24 sm:py-32"
	data-testimonial-count="<?php echo esc_attr( $count ); ?>"
>
	<div class="mx-auto max-w-6xl">
		<div class="jetpack-slider__card">
			<div class="jetpack-slider__track">
				<?php foreach ( $items as $i => $t ) : ?>
				<div class="jetpack-slide <?php echo $i === 0 ? 'jetpack-slide--active' : ''; ?>" data-slide-index="<?php echo esc_attr( $i ); ?>">

					<div class="jetpack-slide__content">
						<div>
						<span class="jetpack-slide__quote-icon" aria-hidden="true"></span>
							<blockquote class="jetpack-slide__quote"><?php echo esc_html( $t['quote'] ); ?></blockquote>
							<div class="jetpack-slide__author">
								<span class="jetpack-slide__name"><?php echo esc_html( $t['name'] ); ?></span>
								<?php if ( ! empty( $t['url'] ) ) : ?>
								<a href="<?php echo esc_url( $t['url'] ); ?>" class="jetpack-slide__title" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $t['title'] ); ?></a>
								<?php else : ?>
								<span class="jetpack-slide__title"><?php echo esc_html( $t['title'] ); ?></span>
								<?php endif; ?>
							</div>
						</div>
						<?php if ( $has_nav ) : ?>
						<div class="jetpack-slider__nav">
							<button class="jetpack-slider__arrow" aria-label="<?php esc_attr_e( 'Previous', 'jetpack-theme' ); ?>" data-dir="prev">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
							</button>
							<span class="jetpack-slider__counter"><span class="jetpack-slider__current">1</span> / <?php echo esc_html( $count ); ?></span>
							<button class="jetpack-slider__arrow" aria-label="<?php esc_attr_e( 'Next', 'jetpack-theme' ); ?>" data-dir="next">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
							</button>
						</div>
						<?php endif; ?>
					</div>

					<div class="jetpack-slide__photo">
						<img src="<?php echo esc_url( $t['avatar'] ); ?>" alt="<?php echo esc_attr( $t['name'] ); ?>" loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>" />
					</div>

				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
