<?php
/**
 * Features Bento block — server render.
 * GSAP scroll-animations.js handles entrance animations.
 *
 * @var array $attributes Block attributes.
 */

$backup  = wp_parse_args( $attributes['backup']      ?? [], [ 'title' => 'Real-time Backups', 'subtitle' => 'Every change saved automatically. Restore your site with one click.' ] );
$stats_d = wp_parse_args( $attributes['siteStats']   ?? [], [ 'title' => 'Understand Your Audience', 'subtitle' => 'Real-time stats that show who\'s reading, sharing, and coming back.' ] );
$trust   = wp_parse_args( $attributes['trustedBy']   ?? [], [ 'count' => '27 million', 'rating' => '4.9', 'reviewCount' => '48k+' ] );
$perf    = wp_parse_args( $attributes['performance'] ?? [], [ 'title' => 'Speed & SEO', 'subtitle' => 'One-click performance boost for faster pages and better search rankings.' ] );
$perf_stats = $attributes['perfStats'] ?? [
	[ 'icon' => '⚡', 'label' => 'Page Speed Score', 'change' => '+43pts' ],
	[ 'icon' => '🛡️', 'label' => 'Malware Scans',   'change' => 'Daily' ],
];

$theme_uri = get_template_directory_uri();
$avatar_urls = [
	'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face',
	'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop&crop=face',
	'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face',
	'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face',
];
?>

<?php /* ── Mobile App intro ─────────────────────────────────────────── */ ?>
<section class="jetpack-mobile-app w-full pt-20 md:pt-28 px-6 bg-white">
	<div class="max-w-5xl mx-auto text-center">
		<span class="text-accent font-bold text-sm uppercase tracking-[0.15em] mb-4 inline-flex items-center justify-center gap-1.5">
			<svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
				<rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/>
			</svg>
			Mobile App
		</span>
		<h2 class="text-4xl md:text-[3.25rem] font-semibold leading-[1.1] tracking-tight text-foreground mb-5 max-w-2xl mx-auto">
			Manage your WordPress site from anywhere
		</h2>
		<p class="text-neutral-500 text-base md:text-lg leading-relaxed mb-10 max-w-xl mx-auto">
			The free Jetpack app puts your full site in your pocket. Publish posts, check stats, moderate comments, and respond to security threats — all from iOS or Android.
		</p>
		<div class="flex flex-wrap items-center justify-center gap-4">
			<a
				href="https://apps.apple.com/app/jetpack-website-builder/id1565481562"
				class="inline-flex items-center gap-3 px-5 py-3 bg-foreground text-background rounded-xl hover:bg-foreground/85 transition-colors"
				target="_blank"
				rel="noopener noreferrer"
			>
				<svg class="w-6 h-6 shrink-0 fill-current" viewBox="0 0 24 24" aria-hidden="true">
					<path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11"/>
				</svg>
				<span class="text-left leading-tight">
					<span class="block text-xs opacity-75">Download on the</span>
					<span class="block text-base font-semibold">App Store</span>
				</span>
			</a>
			<a
				href="https://play.google.com/store/apps/details?id=com.jetpack.android"
				class="inline-flex items-center gap-3 px-5 py-3 bg-foreground text-background rounded-xl hover:bg-foreground/85 transition-colors"
				target="_blank"
				rel="noopener noreferrer"
			>
				<svg class="w-6 h-6 shrink-0 fill-current" viewBox="0 0 24 24" aria-hidden="true">
					<path d="M3.18 23.76c.37.2.8.2 1.19-.02l11.55-6.57-2.54-2.54-10.2 9.13zm-1.1-20.5C2.03 3.55 2 3.87 2 4.22v15.56c0 .35.03.67.09.97l10.44-10.44-10.45-7.05zM20.49 10.1l-2.76-1.57-2.84 2.84 2.84 2.84 2.78-1.58c.79-.45.79-1.08-.02-1.53zM4.38.28C3.99.06 3.56.06 3.19.28L13.6 7.34l-2.54 2.54L4.38.28z"/>
				</svg>
				<span class="text-left leading-tight">
					<span class="block text-xs opacity-75">Get it on</span>
					<span class="block text-base font-semibold">Google Play</span>
				</span>
			</a>
		</div>
	</div>
</section>

<section class="jetpack-features-bento w-full pt-20 md:pt-28 pb-20 md:pb-28 px-6 bg-white">
	<div class="max-w-5xl mx-auto">
		<div class="grid grid-cols-1 md:grid-cols-[1fr_1.5fr] gap-4">

			<?php /* ── Real-time Backups card ──────────────────────────── */ ?>
			<div class="jetpack-bento-card group bg-accent/20 rounded-4xl p-8 pb-0 overflow-hidden min-h-[35rem] md:row-span-2 flex flex-col opacity-0 translate-y-10">
				<div class="relative z-10 text-center mb-6 transition-transform duration-500 ease-out group-hover:scale-105">
					<h3 class="text-2xl md:text-4xl font-medium text-neutral-900 leading-tight mb-3">
						<?php echo esc_html( $backup['title'] ); ?>
					</h3>
					<p class="text-neutral-700 text-sm"><?php echo esc_html( $backup['subtitle'] ); ?></p>
				</div>

				<div class="flex-1 flex justify-center items-end transition-transform duration-500 ease-out group-hover:scale-[1.02]">
					<div class="relative bg-background shadow-2xl border-neutral-800 overflow-hidden z-10 w-56 md:w-64 h-96 md:h-[28.75rem] rounded-t-[2rem] border-[6px] border-b-0">
						<div class="absolute left-1/2 -translate-x-1/2 top-2 w-20 h-5 bg-neutral-800 rounded-full z-10" aria-hidden="true"></div>
						<div class="absolute inset-0 bg-phone-screen pt-14 px-5">
							<h4 class="text-3xl font-medium text-neutral-900 leading-none tracking-tight mt-4">Backup</h4>
							<h4 class="text-3xl font-medium text-neutral-900 leading-none tracking-tight mb-2">complete!</h4>
							<p class="text-sm text-neutral-500 leading-snug mb-5">Your site is safe. 30-day activity log included.</p>
							<div class="flex flex-col gap-2.5">
								<div class="flex items-center justify-between bg-accent/20 rounded-xl px-4 py-3">
									<div class="flex items-center gap-2.5">
										<span class="text-base" aria-hidden="true">☁️</span>
										<div>
											<p class="text-xs font-semibold text-neutral-900">Cloud backup</p>
											<p class="text-xs text-neutral-500">Just now</p>
										</div>
									</div>
									<span class="text-xs font-medium text-accent bg-accent/30 px-2 py-0.5 rounded-full">✓ Saved</span>
								</div>
								<div class="flex items-center justify-between bg-neutral-100 rounded-xl px-4 py-3">
									<div class="flex items-center gap-2.5">
										<span class="text-base" aria-hidden="true">🔒</span>
										<div>
											<p class="text-xs font-semibold text-neutral-900">Malware scan</p>
											<p class="text-xs text-neutral-500">No threats found</p>
										</div>
									</div>
									<span class="text-xs font-medium text-green-700 bg-green-100 px-2 py-0.5 rounded-full">Clean</span>
								</div>
								<div class="bg-gradient-to-br from-accent via-accent/80 to-accent/50 rounded-2xl p-4 shadow-xl">
									<p class="text-xs font-semibold text-neutral-900 mb-1">One-click restore</p>
									<p class="text-xs text-neutral-700">Choose any restore point from your 30-day archive.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php /* ── Site Stats card ──────────────────────────────── */ ?>
			<div class="jetpack-bento-card group bg-accent/8 rounded-4xl p-8 overflow-hidden min-h-80 relative flex flex-col md:block opacity-0 translate-y-10">
				<div class="relative z-10 max-w-48 transition-transform duration-500 ease-out group-hover:scale-105">
					<h3 class="text-xl md:text-2xl whitespace-nowrap font-medium text-card-foreground leading-tight mb-3"><?php echo esc_html( $stats_d['title'] ); ?></h3>
					<p class="text-card-foreground-muted text-sm"><?php echo esc_html( $stats_d['subtitle'] ); ?></p>
				</div>
				<div class="relative md:absolute mt-8 md:mt-0 md:right-12 md:top-1/2 md:-translate-y-1/2 flex items-center justify-center transition-transform duration-500 ease-out group-hover:scale-105 self-center md:self-auto">
					<div class="absolute inset-0 flex items-center justify-center" aria-hidden="true">
						<div class="absolute size-56 border border-accent/80 rounded-full"></div>
						<div class="absolute size-72 border border-accent/60 rounded-full"></div>
						<div class="absolute size-88 border border-accent/40 rounded-full"></div>
					</div>
					<div class="relative bg-background shadow-2xl border-neutral-800 overflow-hidden z-10 w-44 md:w-48 h-64 md:h-72 rounded-3xl border-4">
						<div class="absolute left-1/2 -translate-x-1/2 top-2 w-16 h-4 bg-neutral-800 rounded-full z-10" aria-hidden="true"></div>
						<div class="absolute inset-0 bg-phone-screen pt-9 px-3">
							<p class="text-xs text-neutral-500 mb-0.5">Visitors today</p>
							<p class="text-xl font-medium text-neutral-900 mb-3">12,480</p>
							<div class="flex gap-1.5 mb-4">
								<span class="bg-accent text-black text-xs px-2.5 py-1 rounded-full">Views</span>
								<span class="text-neutral-400 text-xs px-2 py-1">Clicks</span>
								<span class="text-neutral-400 text-xs px-2 py-1">Shares</span>
							</div>
							<div class="flex items-end gap-1 h-12">
								<?php
								$bar_heights = [ '30%', '55%', '40%', '70%', '50%', '85%', '65%' ];
								foreach ( $bar_heights as $h ) :
								?>
								<div class="flex-1 bg-accent/40 rounded-sm" style="height:<?php echo esc_attr( $h ); ?>"></div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<div class="absolute bottom-0 left-1/2 -translate-x-1/2 bg-neutral-900 rounded-2xl px-5 py-3 shadow-xl z-20 whitespace-nowrap">
						<p class="text-neutral-400 text-xs mb-0.5">This week</p>
						<div class="flex items-center gap-3">
							<span class="text-lg font-medium text-white">+18% growth</span>
							<span class="text-xs font-medium text-accent bg-accent/20 px-2 py-0.5 rounded">↑ Up</span>
						</div>
					</div>
				</div>
			</div>

			<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
				<?php /* ── Trusted By card ─────────────────────── */ ?>
				<div class="jetpack-bento-card group bg-accent/8 rounded-4xl p-6 md:p-8 flex flex-col items-center justify-center text-center min-h-64 opacity-0 translate-y-10">
					<div class="transition-transform duration-500 ease-out group-hover:scale-110">
						<h3 class="text-2xl md:text-3xl font-medium text-card-foreground leading-tight mb-1">Trusted By</h3>
						<h3 class="text-2xl md:text-3xl font-medium text-card-foreground leading-tight mb-5"><?php echo esc_html( $trust['count'] ); ?> WordPress sites</h3>
					</div>
					<div class="flex items-center transition-transform duration-500 ease-out group-hover:scale-105">
						<?php foreach ( $avatar_urls as $i => $src ) : ?>
						<div class="size-12 rounded-full border-2 border-white/25 overflow-hidden <?php echo $i > 0 ? '-ml-4' : ''; ?>">
							<img src="<?php echo esc_url( $src ); ?>" alt="" width="48" height="48" class="size-full object-cover" loading="lazy" />
						</div>
						<?php endforeach; ?>
						<div class="size-12 rounded-full border-2 border-white/25 bg-accent text-black flex items-center justify-center text-sm font-semibold -ml-4" aria-hidden="true">5+</div>
					</div>
					<div class="flex items-center gap-2 mt-5 text-card-foreground-muted transition-transform duration-500 ease-out group-hover:scale-105">
						<svg class="size-4 fill-current" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
						<span class="text-xs font-medium"><?php echo esc_html( $trust['rating'] ); ?> from <?php echo esc_html( $trust['reviewCount'] ); ?> reviews</span>
					</div>
				</div>

				<?php /* ── Performance card ──────────────────────── */ ?>
				<div class="jetpack-bento-card group bg-accent/20 rounded-4xl p-6 md:p-8 flex flex-col min-h-64 opacity-0 translate-y-10">
					<div class="mb-auto transition-transform duration-500 ease-out group-hover:scale-105">
						<h3 class="text-xl md:text-2xl font-medium text-neutral-900 leading-tight mb-2"><?php echo esc_html( $perf['title'] ); ?></h3>
						<p class="text-neutral-700 text-sm"><?php echo esc_html( $perf['subtitle'] ); ?></p>
					</div>
					<div class="flex flex-col gap-2 mt-6 transition-transform duration-500 ease-out group-hover:scale-[1.02]">
						<?php foreach ( $perf_stats as $stat ) : ?>
						<div class="flex items-center justify-between bg-background rounded-xl p-3">
							<div class="flex items-center gap-2">
								<span class="text-lg" aria-hidden="true"><?php echo esc_html( $stat['icon'] ); ?></span>
								<span class="text-foreground font-medium"><?php echo esc_html( $stat['label'] ); ?></span>
							</div>
							<span class="text-black text-sm font-medium"><?php echo esc_html( $stat['change'] ); ?></span>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>
