<?php
/**
 * Footer CTA block — server render.
 * Just the centered email-capture card. The footer link grid lives in
 * parts/footer.html as core blocks.
 *
 * @var array $attributes Block attributes.
 */

$cta_headline    = $attributes['ctaHeadline']    ?? 'Start building something truly amazing today';
$cta_placeholder = $attributes['ctaPlaceholder'] ?? 'Enter your email';
$cta_button      = $attributes['ctaButtonText']  ?? 'Join Waitlist';
$theme_uri       = get_template_directory_uri();
?>
<div class="jetpack-footer-cta absolute left-1/2 -translate-x-1/2 top-0 w-full max-w-5xl z-20">
	<div class="relative w-full rounded-3xl overflow-hidden shadow-[0_0_60px_rgba(0,0,0,0.10)]">
		<div
			class="absolute inset-0 bg-center bg-no-repeat scale-125 brightness-110"
			style="background-image:url(<?php echo esc_url( $theme_uri . '/assets/BG.jpg' ); ?>);background-size:150%"
			aria-hidden="true"
		></div>
		<div class="relative z-10 flex flex-col items-center text-center px-12 py-24 max-[850px]:px-6 max-[850px]:py-6 max-[850px]:pt-12">
			<h2 class="text-6xl max-[850px]:text-3xl text-black font-medium tracking-tight max-w-2xl mb-14 max-[850px]:mb-8">
				<?php echo esc_html( $cta_headline ); ?>
			</h2>
			<form
				class="flex items-center w-full max-w-md bg-background rounded-xl p-1.5 shadow-lg max-[850px]:flex-col max-[850px]:p-3 max-[850px]:gap-3 max-[850px]:max-w-none"
				onsubmit="return false"
			>
				<div class="flex items-center flex-1 w-full">
					<svg class="w-5 h-5 text-muted-foreground ml-3 flex-none max-[850px]:ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
					<input
						type="email"
						placeholder="<?php echo esc_attr( $cta_placeholder ); ?>"
						aria-label="<?php esc_attr_e( 'Email address', 'jetpack-theme' ); ?>"
						class="flex-1 px-3 py-2.5 text-sm bg-transparent text-foreground placeholder:text-muted-foreground focus:outline-none"
					/>
				</div>
				<button
					type="submit"
					class="flex items-center justify-center gap-2 px-5 py-2.5 bg-foreground hover:bg-foreground/90 text-background rounded-lg text-sm font-medium transition-colors whitespace-nowrap max-[850px]:w-full max-[850px]:py-3"
				>
					<?php echo esc_html( $cta_button ); ?>
					<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
				</button>
			</form>
		</div>
	</div>
</div>
