<?php
/**
 * Site Header block — server render.
 * Uses WordPress Navigation menus and the Interactivity API for
 * animated dropdowns and mobile menu. CSS transitions replace React Motion.
 *
 * @var array $attributes Block attributes.
 */

$cta_text  = $attributes['ctaText'] ?? 'Try for free';
$cta_url   = $attributes['ctaUrl']  ?? 'https://jetpack.com/pricing/';
$theme_uri = get_template_directory_uri();

// Build primary nav tree from registered menu location.
$primary_items = jetpack_get_menu( 'primary' );
$nav_tree      = jetpack_build_nav_tree( $primary_items );
?>
<header
	class="jetpack-header fixed shadow-[0_0_40px_rgba(0,0,0,0.08)] rounded-b-[2rem] top-2.5 left-1/2 -translate-x-1/2 w-full max-w-5xl max-[1200px]:max-w-2xl bg-frame z-[9998] max-[850px]:top-0 max-[850px]:left-0 max-[850px]:right-0 max-[850px]:translate-x-0 max-[850px]:w-full max-[850px]:max-w-none max-[850px]:rounded-none max-[850px]:rounded-b-[2rem] max-[850px]:overflow-hidden"
	data-wp-interactive="jetpack-theme/header"
	<?php echo wp_kses_data( wp_interactivity_data_wp_context( [ 'openMenu' => null, 'mobileOpen' => false ] ) ); ?>
>
	<div class="h-20 max-[850px]:h-18 flex items-center justify-between px-4 max-[850px]:px-6">

		<?php /* Logo */ ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center ml-4 max-[850px]:ml-0" aria-label="<?php esc_attr_e( 'Jetpack home', 'jetpack-theme' ); ?>">
			<img
				src="<?php echo esc_url( $theme_uri . '/assets/jetpack-logo-classic.svg' ); ?>"
				alt="Jetpack"
				width="120"
				height="32"
			/>
		</a>

		<?php /* Desktop nav */ ?>
		<?php if ( ! empty( $nav_tree ) ) : ?>
		<nav class="flex items-center gap-1 max-[1200px]:gap-0 max-[850px]:hidden" aria-label="<?php esc_attr_e( 'Primary navigation', 'jetpack-theme' ); ?>">
			<?php foreach ( $nav_tree as $item ) : ?>

				<?php if ( ! empty( $item['children'] ) ) : ?>
				<?php /* Dropdown item */ ?>
				<div
					class="relative"
					data-wp-on--mouseenter="actions.openMenu"
					data-wp-on--mouseleave="actions.closeMenu"
					<?php echo wp_kses_data( wp_interactivity_data_wp_context( [ 'menuId' => (string) $item['id'] ] ) ); ?>
				>
					<button
						class="flex items-center gap-1 px-4 py-2 max-[1200px]:px-3 text-sm font-medium text-foreground/80 hover:text-foreground transition-colors rounded-full hover:bg-foreground/5"
						data-wp-bind--aria-expanded="state.openMenu === context.menuId"
						aria-haspopup="true"
					>
						<?php echo esc_html( $item['label'] ); ?>
						<svg class="w-4 h-4 transition-transform duration-200" data-wp-class--rotate-180="state.openMenu === context.menuId" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
					</button>

					<div
						class="absolute top-full left-0 pt-2 w-72"
						style="opacity:0;transform:translateY(8px) scale(0.96);pointer-events:none;transition:opacity 0.2s,transform 0.2s"
						data-wp-class--jetpack-dropdown-open="state.openMenu === context.menuId"
					>
						<div class="bg-frame border border-border rounded-2xl shadow-lg overflow-hidden p-2">
							<?php foreach ( $item['children'] as $child ) : ?>
							<a href="<?php echo esc_url( $child['url'] ); ?>" class="block px-4 py-3 rounded-xl hover:bg-muted transition-colors">
								<div class="text-sm font-medium text-foreground"><?php echo esc_html( $child['label'] ); ?></div>
							</a>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<?php else : ?>
				<?php /* Simple nav link */ ?>
				<a
					href="<?php echo esc_url( $item['url'] ); ?>"
					class="px-4 py-2 max-[1200px]:px-3 text-sm font-medium text-foreground/80 hover:text-foreground transition-colors rounded-full hover:bg-foreground/5"
				>
					<?php echo esc_html( $item['label'] ); ?>
				</a>
				<?php endif; ?>

			<?php endforeach; ?>
		</nav>
		<?php endif; ?>

		<?php /* Desktop CTAs */ ?>
		<div class="flex items-center gap-4 max-[850px]:hidden">
			<a href="<?php echo esc_url( wp_login_url() ); ?>" class="text-sm font-medium text-foreground/80 hover:text-foreground transition-colors">
				<?php esc_html_e( 'Sign in', 'jetpack-theme' ); ?>
			</a>
			<a href="<?php echo esc_url( $cta_url ); ?>" class="group relative inline-flex items-center">
				<span class="absolute right-0 inset-y-0 w-[calc(100%-1.5rem)] rounded-xl bg-accent" aria-hidden="true"></span>
				<span class="relative z-10 px-5 py-3 rounded-xl bg-foreground text-background text-sm font-medium"><?php echo esc_html( $cta_text ); ?></span>
				<span class="relative -left-px z-10 w-10 h-10 rounded-xl flex items-center justify-center text-black" aria-hidden="true">
					<svg class="w-4 h-4 transition-transform duration-300 rotate-90 group-hover:rotate-45" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 17L17 7M7 7h10v10"/></svg>
				</span>
			</a>
		</div>

		<?php /* Mobile hamburger */ ?>
		<button
			class="hidden max-[850px]:flex items-center justify-center w-10 h-10 flex-col gap-1.5"
			data-wp-on--click="actions.toggleMobile"
			data-wp-bind--aria-expanded="state.mobileOpen"
			aria-label="<?php esc_attr_e( 'Toggle menu', 'jetpack-theme' ); ?>"
		>
			<span class="block h-0.5 w-8 bg-foreground rounded-full transition-all duration-250 origin-center" data-wp-class--jetpack-ham-top="state.mobileOpen"></span>
			<span class="block h-0.5 w-8 bg-foreground rounded-full transition-all duration-250 origin-center" data-wp-class--jetpack-ham-bottom="state.mobileOpen"></span>
		</button>

	</div>

	<?php /* Mobile nav panel */ ?>
	<div
		class="jetpack-mobile-nav hidden max-[850px]:block overflow-hidden"
		style="max-height:0;transition:max-height 0.3s ease"
		data-wp-class--jetpack-mobile-open="state.mobileOpen"
	>
		<div class="px-6 pb-4">
			<nav class="space-y-0">
				<?php foreach ( $nav_tree as $item ) : ?>

					<?php if ( ! empty( $item['children'] ) ) : ?>
					<div
						class="border-b border-foreground/10"
						data-wp-interactive="jetpack-theme/header"
						<?php echo wp_kses_data( wp_interactivity_data_wp_context( [ 'subMenuId' => (string) $item['id'] ] ) ); ?>
					>
						<button
							class="flex items-center justify-between py-4 w-full text-base font-medium text-foreground"
							data-wp-on--click="actions.toggleSubMenu"
							data-wp-bind--aria-expanded="state.openSubMenu === context.subMenuId"
						>
							<?php echo esc_html( $item['label'] ); ?>
							<svg class="w-5 h-5 text-muted-foreground transition-transform duration-200" data-wp-class--rotate-180="state.openSubMenu === context.subMenuId" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
						</button>
						<div
							class="overflow-hidden transition-all duration-200"
							style="max-height:0"
							data-wp-class--jetpack-submenu-open="state.openSubMenu === context.subMenuId"
						>
							<div class="pb-2 space-y-1">
								<?php foreach ( $item['children'] as $child ) : ?>
								<a
									href="<?php echo esc_url( $child['url'] ); ?>"
									class="block py-2 text-sm text-foreground/80 hover:text-foreground"
									data-wp-on--click="actions.closeMobile"
								>
									<?php echo esc_html( $child['label'] ); ?>
								</a>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<?php else : ?>
					<a
						href="<?php echo esc_url( $item['url'] ); ?>"
						class="flex items-center justify-between py-4 text-base font-medium text-foreground border-b border-foreground/10"
						data-wp-on--click="actions.closeMobile"
					>
						<?php echo esc_html( $item['label'] ); ?>
					</a>
					<?php endif; ?>

				<?php endforeach; ?>
			</nav>

			<div class="flex items-center justify-between pt-8 pb-2">
				<a href="<?php echo esc_url( wp_login_url() ); ?>" class="text-base font-medium text-foreground" data-wp-on--click="actions.closeMobile">
					<?php esc_html_e( 'Sign in', 'jetpack-theme' ); ?>
				</a>
				<a href="<?php echo esc_url( $cta_url ); ?>" class="group relative inline-flex items-center" data-wp-on--click="actions.closeMobile">
					<span class="absolute right-0 inset-y-0 w-[calc(100%-1.5rem)] rounded-2xl bg-accent" aria-hidden="true"></span>
					<span class="relative z-10 px-5 py-3 rounded-2xl bg-foreground text-background text-sm font-medium"><?php echo esc_html( $cta_text ); ?></span>
					<span class="relative -left-px z-10 w-10 h-10 rounded-2xl flex items-center justify-center text-foreground" aria-hidden="true">
						<svg class="w-4 h-4 transition-transform duration-300 rotate-90 group-hover:rotate-45" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 17L17 7M7 7h10v10"/></svg>
					</span>
				</a>
			</div>
		</div>
	</div>

	<?php /* Corner decorations (CSS only, no React) */ ?>
	<svg class="absolute top-0 -left-[3.0625rem] rotate-180 text-frame pointer-events-none max-[850px]:hidden" width="50" height="50" viewBox="0 0 50 50" fill="none" aria-hidden="true"><path d="M5.50871e-06 0C-0.00788227 37.3001 8.99616 50.0116 50 50H5.50871e-06V0Z" fill="currentColor"/></svg>
	<svg class="absolute top-0 -right-[3.0625rem] rotate-90 text-frame pointer-events-none max-[850px]:hidden" width="50" height="50" viewBox="0 0 50 50" fill="none" aria-hidden="true"><path d="M5.50871e-06 0C-0.00788227 37.3001 8.99616 50.0116 50 50H5.50871e-06V0Z" fill="currentColor"/></svg>

</header>
