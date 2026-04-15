<?php
/**
 * Hero block — server render.
 * PHP outputs real content HTML. The hero-view.js view script applies StaggeredText.
 *
 * @var array    $attributes Block attributes.
 * @var WP_Block $block      Block instance.
 */

$a = wp_parse_args( $attributes, [
	'badgeText'     => 'Now Available',
	'changelogText' => 'Jetpack Social in 15.7',
	'changelogUrl'  => 'https://jetpack.com/changelog',
	'headlineLine1' => 'Your WordPress,',
	'headlineAccent'=> 'Supercharged.',
	'subheadline'   => 'Right now, your site could be losing visitors to slow load times, poor search rankings, or content no one can find—while your competitors capture the customers you\'re missing.',
	'ctaText'       => 'Get Started',
	'ctaUrl'        => 'https://jetpack.com/pricing/',
] );
?>
<section
	class="jetpack-hero flex flex-col relative overflow-hidden"
	style="color-scheme:light"
	<?php echo wp_kses_data( wp_interactivity_data_wp_context( [ 'parallaxX' => 0, 'parallaxY' => 0 ] ) ); ?>
	data-wp-interactive="jetpack-theme/hero"
>
	<div
		class="jetpack-hero__bg absolute inset-0 min-[850px]:inset-2.5 -z-10 rounded-br-[2rem] rounded-bl-[2rem] scale-125 overflow-hidden brightness-120 blur"
		aria-hidden="true"
	>
		<img
			src="<?php echo esc_url( get_template_directory_uri() . '/assets/BG.jpg' ); ?>"
			alt=""
			class="w-full h-full object-cover"
			aria-hidden="true"
		/>
	</div>

	<?php /* Content */ ?>
	<div class="flex items-start justify-center px-6 pt-32 max-[850px]:pt-16 relative z-10">
		<div class="flex flex-col items-center max-[850px]:items-start text-center max-[850px]:text-left max-w-4xl max-[850px]:w-full">

			<?php /* Changelog badge */ ?>
			<a
				href="<?php echo esc_url( $a['changelogUrl'] ); ?>"
				target="_blank"
				rel="noopener noreferrer"
				class="jetpack-hero__badge inline-flex items-center gap-2 pl-3 pr-3 py-1.5 rounded-xl border border-black/10 bg-white text-black text-sm font-medium mb-6 hover:bg-neutral-50 hover:border-black/20 transition-colors group opacity-0 translate-y-5"
			>
				<span class="bg-accent text-white text-xs font-semibold px-1.5 py-0.5 rounded-md leading-none">
					<?php echo esc_html( $a['badgeText'] ); ?>
				</span>
				<span><?php echo esc_html( $a['changelogText'] ); ?></span>
				<svg class="w-3.5 h-3.5 text-neutral-400 group-hover:text-neutral-600 group-hover:translate-x-0.5 transition-all duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
			</a>

			<?php /* Headline — each line animates independently via hero-view.js */ ?>
			<h1 class="jetpack-hero__headline text-8xl max-[850px]:text-5xl font-bold tracking-tight leading-[1.1] mb-6 text-black">
				<span class="jetpack-hero__headline-line block opacity-0 translate-y-5">
					<?php echo esc_html( $a['headlineLine1'] ); ?>
				</span>
				<span class="jetpack-hero__accent block text-accent opacity-0 translate-y-5">
					<?php echo esc_html( $a['headlineAccent'] ); ?>
				</span>
			</h1>

			<p class="jetpack-hero__body text-lg text-neutral-600 mb-12 max-w-2xl opacity-0 translate-y-5">
				<?php echo esc_html( $a['subheadline'] ); ?>
			</p>

			<a
				href="<?php echo esc_url( $a['ctaUrl'] ); ?>"
				class="jetpack-hero__cta group relative inline-flex items-center max-[850px]:w-full opacity-0 scale-95"
			>
				<span class="absolute right-0 inset-y-0 w-[calc(100%-2rem)] max-[850px]:w-full rounded-xl bg-accent"></span>
				<span class="relative z-10 px-6 py-3 rounded-xl bg-black text-white font-medium max-[850px]:flex-1">
					<?php echo esc_html( $a['ctaText'] ); ?>
				</span>
				<span class="relative -left-px z-10 w-11 h-11 rounded-xl flex items-center justify-center text-black">
					<svg class="w-5 h-5 transition-transform duration-300 rotate-90 group-hover:rotate-45" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M7 17L17 7M7 7h10v10"/></svg>
				</span>
			</a>

		</div>
	</div>

	<?php /* Card swap — React mounts here via hero-card-swap.js */ ?>
	<div class="jetpack-hero__dashboard relative px-4 max-[768px]:px-2 max-[480px]:px-0 mt-0 max-[850px]:mt-4 z-10 opacity-0 translate-y-10">
		<div class="relative max-w-5xl mx-auto aspect-[4/3] max-h-[720px] rounded-2xl max-[480px]:rounded-lg">
			<div
				id="jetpack-card-swap-mount"
				class="relative w-full h-full"
				data-theme-uri="<?php echo esc_url( get_template_directory_uri() ); ?>"
			></div>
		</div>
	</div>

	<?php /* Logo loop — rAF velocity animation driven by hero-view.js */ ?>
	<div class="jetpack-hero__logos pt-20 pb-12 z-10 opacity-0">
		<div
			class="relative overflow-hidden w-full"
			style="mask-image:linear-gradient(to right,transparent,black 20%,black 80%,transparent);-webkit-mask-image:linear-gradient(to right,transparent,black 20%,black 80%,transparent)"
		>
			<div class="jetpack-logo-track flex w-max will-change-transform select-none">
				<?php
				$logos = [
					[ 'src' => 'social-proof-logos/wp.com.png',                 'alt' => 'WordPress.com' ],
					[ 'src' => 'social-proof-logos/pressable-logo-v8-dark.svg', 'alt' => 'Pressable' ],
					[ 'src' => 'social-proof-logos/bluehost.webp',               'alt' => 'Bluehost' ],
					[ 'src' => 'social-proof-logos/dreamhost-1.png',             'alt' => 'DreamHost' ],
					[ 'src' => 'social-proof-logos/hostgator.webp',              'alt' => 'HostGator' ],
				];
				// Render 4 copies — first has data-logo-seq for width measurement.
				for ( $copy = 0; $copy < 4; $copy++ ) :
					$copy_aria = $copy > 0 ? ' aria-hidden="true"' : '';
					$copy_ref  = $copy === 0 ? ' data-logo-seq' : '';
				?>
				<ul class="flex items-center"<?php echo $copy_aria . $copy_ref; ?>>
					<?php foreach ( $logos as $logo ) : ?>
					<li class="flex-none mr-[7.75rem]">
						<span class="inline-flex items-center h-[2.625rem] brightness-0 invert">
							<img
								src="<?php echo esc_url( get_template_directory_uri() . '/assets/' . $logo['src'] ); ?>"
								alt="<?php echo esc_attr( $logo['alt'] ); ?>"
								class="h-full w-auto object-contain"
								loading="lazy"
							/>
						</span>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php endfor; ?>
			</div>
		</div>
	</div>

</section>
