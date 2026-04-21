<?php
/**
 * Title: Style Guide — Default Blocks
 * Slug: jetpack-theme/style-guide-blocks
 * Description: Live reference for how default WordPress core blocks render with the Jetpack theme — buttons, columns, groups, images, galleries, media/text, tables, cover, details, spacers.
 * Categories: jetpack-theme
 * Keywords: blocks, style guide, core blocks, buttons, columns, table, design system
 * Block Types: core/post-content
 * Inserter: true
 */

// Local theme assets used for image/gallery/media-text/cover demos. Shipped in
// the repo so the style guide renders reliably in dev without depending on
// production media that may 404.
$jp_assets = esc_url( get_template_directory_uri() . '/assets' );
?>
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Default Blocks</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size">A live reference for how WordPress core blocks render inside a page using <code>templates/page.html</code>. Each section showcases a core block with its typical variants so designers and authors know what to expect out of the box.</p>
<!-- /wp:paragraph -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Buttons</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Three variants of the core button block — all share the <code>rounded-xl</code> corner radius and type scale of the site's primary CTA pattern (see the nav's "Get Started" button). Styling is scoped to <code>.jetpack-prose .wp-block-button</code> in <code>src/components/prose.css</code>.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Get Jetpack</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">Learn more</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-jetpack-button"} -->
<div class="wp-block-button is-style-jetpack-button"><a class="wp-block-button__link wp-element-button">Jetpack style</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Columns</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Two-column layout — collapses to a single column under 782px:</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Protect</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Automated backups run every time you make a change. One-click restores return your site to any point in time.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Perform</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Images served from a global CDN. Critical CSS inlined automatically. Your site loads faster without you lifting a finger.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:paragraph -->
<p>Three-column layout:</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Backups</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">Real-time, off-site, and one-click restorable.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Scan</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">Daily malware scanning with automated fixes.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Anti-spam</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">Akismet-powered comment and form spam filtering.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Group with background</h2>
<!-- /wp:heading -->

<!-- wp:group {"backgroundColor":"sand","style":{"spacing":{"padding":{"top":"2rem","right":"2rem","bottom":"2rem","left":"2rem"}},"border":{"radius":"0.75rem"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-sand-background-color has-background" style="border-radius:0.75rem;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Grouped callout</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Group blocks carry background, padding, and border-radius to create card-like callouts. The sand palette token provides a warm neutral that pairs with the accent green.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Primary action</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Image</h2>
<!-- /wp:heading -->

<!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img src="<?php echo $jp_assets; ?>/jetpack-paid-traffic.png" alt="Jetpack paid traffic dashboard mock"/><figcaption class="wp-element-caption">Default treatment — rounded corners and a subtle shadow suit photographic content like UI screenshots.</figcaption></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>For transparent PNG logos, SVG icons, and flat illustrations, apply the <strong>"Plain (no shadow)"</strong> block style from the Image block's Styles panel. Both shadow and border-radius are removed so artwork sits cleanly on the page background:</p>
<!-- /wp:paragraph -->

<!-- wp:image {"sizeSlug":"large","className":"is-style-plain"} -->
<figure class="wp-block-image size-large is-style-plain"><img src="<?php echo $jp_assets; ?>/jetpack-futuristic.svg" alt="Jetpack logo mark"/><figcaption class="wp-element-caption">Same image block with the <code>is-style-plain</code> variant — no rounded corners, no shadow.</figcaption></figure>
<!-- /wp:image -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Gallery</h2>
<!-- /wp:heading -->

<!-- wp:gallery {"columns":3,"linkTo":"none"} -->
<figure class="wp-block-gallery has-nested-images columns-3 is-cropped">
<!-- wp:image {"sizeSlug":"medium"} -->
<figure class="wp-block-image size-medium"><img src="<?php echo $jp_assets; ?>/BG.jpg" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"medium"} -->
<figure class="wp-block-image size-medium"><img src="<?php echo $jp_assets; ?>/jetpack-paid-traffic.png" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"medium"} -->
<figure class="wp-block-image size-medium"><img src="<?php echo $jp_assets; ?>/jetpack-futuristic.svg" alt=""/></figure>
<!-- /wp:image -->
</figure>
<!-- /wp:gallery -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Media &amp; Text</h2>
<!-- /wp:heading -->

<!-- wp:media-text {"mediaPosition":"left","mediaType":"image"} -->
<div class="wp-block-media-text alignwide is-stacked-on-mobile">
<figure class="wp-block-media-text__media"><img src="<?php echo $jp_assets; ?>/jetpack-paid-traffic.png" alt=""/></figure>
<div class="wp-block-media-text__content">
<!-- wp:heading {"level":3,"placeholder":"Content…"} -->
<h3 class="wp-block-heading">Media on the left</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>The media-text block pairs visuals with a block of copy side-by-side, collapsing to stacked on narrow viewports. It's a good fit for feature explainers and product callouts.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">Read the guide</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
</div>
<!-- /wp:media-text -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Table</h2>
<!-- /wp:heading -->

<!-- wp:table {"hasFixedLayout":true} -->
<figure class="wp-block-table"><table class="has-fixed-layout"><thead><tr><th>Plan</th><th>Monthly</th><th>Yearly</th></tr></thead><tbody><tr><td>Free</td><td>$0</td><td>$0</td></tr><tr><td>Personal</td><td>$4</td><td>$39</td></tr><tr><td>Premium</td><td>$8</td><td>$79</td></tr></tbody><tfoot><tr><td>Price shown in USD.</td><td></td><td></td></tr></tfoot></table><figcaption class="wp-element-caption">Example pricing table — header, body, and footer rows styled by <code>.jetpack-prose .wp-block-table</code>.</figcaption></figure>
<!-- /wp:table -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Cover</h2>
<!-- /wp:heading -->

<!-- wp:cover {"overlayColor":"foreground","dimRatio":60,"minHeight":320,"minHeightUnit":"px","isDark":true,"align":"wide"} -->
<div class="wp-block-cover alignwide is-dark" style="min-height:320px"><span aria-hidden="true" class="wp-block-cover__background has-foreground-background-color has-background-dim-60 has-background-dim"></span>
<div class="wp-block-cover__inner-container">
<!-- wp:heading {"textAlign":"center","level":2,"textColor":"white"} -->
<h2 class="wp-block-heading has-text-align-center has-white-color has-text-color">Cover block</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color">Full-width, centered content over a dim overlay. Ideal for feature callouts and section breaks.</p>
<!-- /wp:paragraph -->
</div></div>
<!-- /wp:cover -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Details &amp; summary</h2>
<!-- /wp:heading -->

<!-- wp:details -->
<details class="wp-block-details"><summary>How does Jetpack Backup work?</summary>
<!-- wp:paragraph -->
<p>Jetpack captures incremental backups in real time, storing them off-site on our secure infrastructure. You can restore to any point with a single click.</p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Can I use Jetpack on multiple sites?</summary>
<!-- wp:paragraph -->
<p>Yes. Each Jetpack subscription is tied to a single site, but you can manage many sites from one WordPress.com account.</p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Spacer</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>A 64px spacer lives below this paragraph. Spacers are useful when you need vertical room between sections that the default block-gap rhythm doesn't cover.</p>
<!-- /wp:paragraph -->

<!-- wp:spacer {"height":"64px"} -->
<div style="height:64px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:paragraph -->
<p>This paragraph follows the spacer.</p>
<!-- /wp:paragraph -->
