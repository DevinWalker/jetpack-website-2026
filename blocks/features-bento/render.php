<?php
/**
 * Features Bento block — server render.
 * GSAP scroll-animations.js handles entrance animations.
 *
 * @var array $attributes Block attributes.
 */

$sbs   = wp_parse_args( $attributes['stepByStep']   ?? [], [ 'title' => 'Guided Onboarding For Every Team', 'subtitle' => 'Get your team up and running in minutes.' ] );
$dash  = wp_parse_args( $attributes['dashboard']    ?? [], [ 'title' => 'Real-time Data', 'subtitle' => 'Monitor metrics, analytics, and team activity instantly.' ] );
$trust = wp_parse_args( $attributes['trustedBy']    ?? [], [ 'count' => '27 million', 'rating' => '4.9', 'reviewCount' => '48k+' ] );
$bts   = wp_parse_args( $attributes['builtToScale'] ?? [], [ 'title' => 'Built to Scale', 'subtitle' => 'Enterprise-ready infrastructure that grows with you.' ] );
$stats = $attributes['stats'] ?? [
	[ 'icon' => '🚀', 'label' => '2,598 Deploys', 'change' => '+24%' ],
	[ 'icon' => '⚡', 'label' => '99.9% Uptime',  'change' => '+0.2%' ],
];

$theme_uri = get_template_directory_uri();
$avatar_urls = [
	'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face',
	'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop&crop=face',
	'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face',
	'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face',
];
?>
<section class="jetpack-features-bento w-full px-6 mb-32 bg-background">
	<div class="max-w-5xl mx-auto">
		<div class="grid grid-cols-1 md:grid-cols-[1fr_1.5fr] gap-4">

			<?php /* ── Step-by-step card ───────────────────────────── */ ?>
			<div class="jetpack-bento-card group bg-card-primary rounded-4xl p-8 pb-0 overflow-hidden min-h-[35rem] md:row-span-2 flex flex-col opacity-0 translate-y-10">
				<div class="relative z-10 text-center mb-6 transition-transform duration-500 ease-out group-hover:scale-105">
					<h3 class="text-2xl md:text-4xl font-medium text-neutral-900 leading-tight mb-3">
						<?php echo esc_html( $sbs['title'] ); ?>
					</h3>
					<p class="text-neutral-700 text-sm"><?php echo esc_html( $sbs['subtitle'] ); ?></p>
				</div>

				<div class="flex-1 flex justify-center items-end transition-transform duration-500 ease-out group-hover:scale-[1.02]">
					<div class="relative bg-background shadow-2xl border-neutral-800 overflow-hidden z-10 w-56 md:w-64 h-96 md:h-[28.75rem] rounded-t-[2rem] border-[6px] border-b-0">
						<div class="absolute left-1/2 -translate-x-1/2 top-2 w-20 h-5 bg-neutral-800 rounded-full z-10" aria-hidden="true"></div>
						<div class="absolute inset-0 bg-phone-screen pt-14 px-5">
							<h4 class="text-3xl font-medium text-neutral-900 leading-none tracking-tight mt-4">Your workspace</h4>
							<h4 class="text-3xl font-medium text-neutral-900 leading-none tracking-tight mb-4">is ready!</h4>
							<p class="text-sm text-neutral-500 leading-snug mb-8">Invite your team and start collaborating instantly.</p>
							<div class="relative bg-gradient-to-br from-accent via-accent/80 to-accent/50 rounded-2xl p-4 h-52 shadow-xl overflow-hidden">
								<div class="relative z-10 flex items-start justify-between gap-3 h-full">
									<div>
										<p class="text-base font-semibold text-neutral-900">Project</p>
										<p class="text-base font-semibold text-neutral-900">Alpha</p>
									</div>
									<svg class="w-5 h-5 opacity-25 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M9 12l2 2 4-4"/></svg>
								</div>
								<div class="absolute bottom-3 left-5 flex items-center gap-2 text-neutral-700 text-xs tracking-widest" aria-hidden="true">
									<span>PRJ</span><span>•</span><span>2024</span><span>•</span><span>LIVE</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php /* ── Dashboard card ─────────────────────────────── */ ?>
			<div class="jetpack-bento-card group bg-card-secondary rounded-4xl p-8 overflow-hidden min-h-80 relative flex flex-col md:block opacity-0 translate-y-10">
				<div class="relative z-10 max-w-48 transition-transform duration-500 ease-out group-hover:scale-105">
					<h3 class="text-xl md:text-2xl whitespace-nowrap font-medium text-card-foreground leading-tight mb-3"><?php echo esc_html( $dash['title'] ); ?></h3>
					<p class="text-card-foreground-muted text-sm"><?php echo esc_html( $dash['subtitle'] ); ?></p>
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
							<p class="text-xs text-neutral-500 mb-0.5">Active projects</p>
							<p class="text-xl font-medium text-neutral-900 mb-3">24 running</p>
							<div class="flex gap-1.5 mb-4">
								<span class="bg-accent text-black text-xs px-2.5 py-1 rounded-full">Deploy</span>
								<span class="text-neutral-400 text-xs px-2 py-1">Build</span>
								<span class="text-neutral-400 text-xs px-2 py-1">Test</span>
							</div>
						</div>
					</div>
					<div class="absolute bottom-0 left-1/2 -translate-x-1/2 bg-neutral-900 rounded-2xl px-5 py-3 shadow-xl z-20 whitespace-nowrap">
						<p class="text-neutral-400 text-xs mb-0.5">Build status</p>
						<div class="flex items-center gap-3">
							<span class="text-lg font-medium text-white">All passing</span>
							<span class="text-xs font-medium text-accent bg-accent/20 px-2 py-0.5 rounded">✓ 100%</span>
						</div>
					</div>
				</div>
			</div>

			<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
				<?php /* ── Trusted By card ─────────────────────── */ ?>
				<div class="jetpack-bento-card group bg-card-secondary rounded-4xl p-6 md:p-8 flex flex-col items-center justify-center text-center min-h-64 opacity-0 translate-y-10">
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

				<?php /* ── Built to Scale card ───────────────────── */ ?>
				<div class="jetpack-bento-card group bg-card-primary rounded-4xl p-6 md:p-8 flex flex-col min-h-64 opacity-0 translate-y-10">
					<div class="mb-auto transition-transform duration-500 ease-out group-hover:scale-105">
						<h3 class="text-xl md:text-2xl font-medium text-neutral-900 leading-tight mb-2"><?php echo esc_html( $bts['title'] ); ?></h3>
						<p class="text-neutral-700 text-sm"><?php echo esc_html( $bts['subtitle'] ); ?></p>
					</div>
					<div class="flex flex-col gap-2 mt-6 transition-transform duration-500 ease-out group-hover:scale-[1.02]">
						<?php foreach ( $stats as $stat ) : ?>
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
