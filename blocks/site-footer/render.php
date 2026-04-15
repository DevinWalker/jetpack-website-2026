<?php
/**
 * Site Footer block — server render.
 * Footer menus driven by WordPress nav menu locations.
 *
 * @var array $attributes Block attributes.
 */

$cta_headline    = $attributes['ctaHeadline']    ?? 'Start building something truly amazing today';
$cta_placeholder = $attributes['ctaPlaceholder'] ?? 'Enter your email';
$cta_button      = $attributes['ctaButtonText']  ?? 'Join Waitlist';
$copyright       = $attributes['copyright'] ?: sprintf( '© %d Automattic Inc. All rights reserved.', gmdate( 'Y' ) );
$theme_uri       = get_template_directory_uri();

$footer_sections = [
	[ 'title' => __( 'Company',   'jetpack-theme' ), 'items' => jetpack_get_menu( 'footer-company' ) ],
	[ 'title' => __( 'Resources', 'jetpack-theme' ), 'items' => jetpack_get_menu( 'footer-resources' ) ],
	[ 'title' => __( 'Social',    'jetpack-theme' ), 'items' => jetpack_get_menu( 'footer-social' ) ],
];
$footer_sections = array_filter( $footer_sections, fn( $s ) => ! empty( $s['items'] ) );

// Fallback if no menus assigned.
if ( empty( $footer_sections ) ) {
	$footer_sections = [
		[ 'title' => __( 'Company', 'jetpack-theme' ), 'items' => [
			[ 'label' => 'About',    'url' => 'https://jetpack.com/about/' ],
			[ 'label' => 'Blog',     'url' => 'https://jetpack.com/blog/' ],
			[ 'label' => 'Careers',  'url' => 'https://automattic.com/work-with-us/' ],
		]],
		[ 'title' => __( 'Support', 'jetpack-theme' ), 'items' => [
			[ 'label' => 'Help',     'url' => 'https://jetpack.com/support/' ],
			[ 'label' => 'Terms',    'url' => 'https://jetpack.com/tos/' ],
			[ 'label' => 'Security', 'url' => 'https://jetpack.com/security/' ],
		]],
	];
}
?>
<footer class="jetpack-footer relative pt-[9.5rem] mt-24 mx-2.5 max-[850px]:mx-0">

	<?php /* ── CTA card ─────────────────────────────────────────── */ ?>
	<div class="absolute left-1/2 -translate-x-1/2 top-0 w-full max-w-5xl">
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

	<?php /* ── Footer body ──────────────────────────────────────── */ ?>
	<div class="bg-accent rounded-tr-[3rem] rounded-tl-[3rem] pt-96 pb-16 max-[850px]:pt-72">
		<div class="max-w-5xl mx-auto px-6">
			<div class="flex items-start justify-between gap-12 max-[850px]:flex-col max-[850px]:gap-10">

				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2" aria-label="<?php esc_attr_e( 'Jetpack home', 'jetpack-theme' ); ?>">
					<img
						src="<?php echo esc_url( $theme_uri . '/assets/jetpack-logo-classic.svg' ); ?>"
						alt="Jetpack"
						width="120"
						height="32"
						class="brightness-0"
					/>
				</a>

				<nav class="flex gap-16 max-[850px]:gap-10 max-[850px]:flex-wrap" aria-label="<?php esc_attr_e( 'Footer navigation', 'jetpack-theme' ); ?>">
					<?php foreach ( $footer_sections as $section ) : ?>
					<div>
						<h3 class="text-xs font-medium text-neutral-900/50 uppercase tracking-wider mb-4">
							<?php echo esc_html( $section['title'] ); ?>
						</h3>
						<ul class="space-y-2">
							<?php foreach ( $section['items'] as $item ) : ?>
							<li>
								<a href="<?php echo esc_url( $item['url'] ); ?>" class="text-sm text-neutral-900 hover:text-neutral-900/70 transition-colors">
									<?php echo esc_html( $item['label'] ); ?>
								</a>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php endforeach; ?>
				</nav>

			</div>

			<div class="mt-16 pt-6">
				<p class="text-sm text-neutral-900/50 text-center"><?php echo esc_html( $copyright ); ?></p>
			</div>
		</div>
	</div>

</footer>
