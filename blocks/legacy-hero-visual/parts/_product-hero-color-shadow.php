<?php
/**
 * Blurred three-circle backdrop SVG used behind the Category B image card.
 *
 * Ported verbatim from jetpackme-new/parts/shared/product-hero-color-shadow.php
 * to keep the visual identical. Inlined as an <svg> so no network round-trip is
 * required for the above-the-fold hero.
 */
?>
<svg class="product-hero-visual__shadow" width="720" height="720" viewBox="0 0 720 720" filter="url(#legacy-hero-visual-blur)" aria-hidden="true">
	<filter id="legacy-hero-visual-blur">
		<feGaussianBlur stdDeviation="75" />
	</filter>
	<g>
		<g class="green">
			<circle cx="525" cy="350" r="100" fill="#9dd977" />
		</g>
		<g class="blue">
			<circle cx="225" cy="500" r="65" fill="#abc1f5" />
		</g>
		<g class="yellow">
			<circle cx="375" cy="250" r="75" fill="#f2d76b" />
		</g>
	</g>
</svg>
