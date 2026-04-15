<?php
/**
 * Blur-Headline block — server render.
 * PHP outputs the paragraph with each word wrapped in a <span>.
 * The blur-view.js view script / BlurHighlight enhances the reveal animation.
 *
 * @var array $attributes Block attributes.
 */

$text = $attributes['text'] ?? 'Grow your audience without the grind, speed up every page without the hassle, and secure your content without losing sleep—Jetpack handles all three so you can focus on what you love most: creating.';
$words = explode( ' ', $text );
?>
<section
	class="jetpack-blur-headline w-full bg-background px-6 py-24"
	data-wp-interactive="jetpack-theme/blur-headline"
	<?php echo wp_kses_data( wp_interactivity_data_wp_context( [ 'progress' => 0 ] ) ); ?>
>
	<div class="mx-auto max-w-5xl">
		<p class="text-3xl font-medium text-left leading-snug tracking-tight text-foreground sm:text-4xl lg:text-5xl lg:leading-snug" aria-label="<?php echo esc_attr( $text ); ?>">
			<?php foreach ( $words as $word ) : ?>
			<span
				class="jetpack-blur-word mr-2 inline-block lg:mr-3"
				style="opacity:0.15;filter:blur(8px);transition:opacity 75ms,filter 75ms"
				aria-hidden="true"
			><?php echo esc_html( $word ); ?></span>
			<?php endforeach; ?>
		</p>
	</div>
</section>
