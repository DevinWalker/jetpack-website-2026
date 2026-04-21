<?php $image_dir = get_template_directory_uri() . '/assets/legacy-hero-visual/'; ?>
<div class="product-hero-visual" aria-hidden="true">
	<img
		width="475"
		srcset="<?php echo esc_url( $image_dir . 'forms/hero-forms-2x.png' ); ?> 2x"
		src="<?php echo esc_url( $image_dir . 'forms/hero-forms.png' ); ?>"
		alt=""
		loading="lazy"
	/>
</div>
