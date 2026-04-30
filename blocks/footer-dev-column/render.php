<?php
/**
 * Footer Dev Strip — server render.
 *
 * Surfaces the theme's style-guide pages from the footer so designers and
 * engineers can jump to them from any page. Renders as a low-emphasis
 * horizontal strip beneath the main nav row. Returns an empty string on
 * production (jetpack.com) so nothing leaks there.
 */

if ( function_exists( 'jetpack_is_production' ) && jetpack_is_production() ) {
	return;
}

$dev_links = [
	[ 'label' => __( 'Style Guide',    'jetpack-theme' ), 'url' => home_url( '/style-guide/' ) ],
	[ 'label' => __( 'Typography',     'jetpack-theme' ), 'url' => home_url( '/style-guide/typography/' ) ],
	[ 'label' => __( 'Default Blocks', 'jetpack-theme' ), 'url' => home_url( '/style-guide/blocks/' ) ],
];
?>
<div class="jetpack-footer__dev-strip" role="navigation" aria-label="<?php esc_attr_e( 'Theme style guide', 'jetpack-theme' ); ?>">
	<span class="jetpack-footer__dev-label" aria-hidden="true"><?php esc_html_e( 'Dev', 'jetpack-theme' ); ?></span>
	<ul class="jetpack-footer__dev-links">
		<?php foreach ( $dev_links as $link ) : ?>
			<li><a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>
