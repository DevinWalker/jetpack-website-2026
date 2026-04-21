<?php
/**
 * Title: Style Guide — Typography
 * Slug: jetpack-theme/style-guide-typography
 * Description: Live reference for headings, paragraphs, lists, quotes, code and inline text styles produced by theme.json + components/prose.css.
 * Categories: jetpack-theme
 * Keywords: typography, style guide, prose, headings, design system
 * Block Types: core/post-content
 * Inserter: true
 */
?>
<!-- wp:heading {"level":1,"className":"wp-block-heading"} -->
<h1 class="wp-block-heading">Typography</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size">A live reference for the typographic system — scale, rhythm, and inline treatments — exposed by <code>theme.json</code> presets and the shared <code>.jetpack-prose</code> partial.</p>
<!-- /wp:paragraph -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Heading levels</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Sizes are fluid: they interpolate between a minimum at 640px viewport width and a maximum at 1280px. Weights, letter-spacing, and line-heights are set per element in <code>theme.json</code> so every block inherits them consistently.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Heading 1 — Hero</h1>
<!-- /wp:heading -->

<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Heading 2 — Section</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Heading 3 — Subsection</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Heading 4 — Group label</h4>
<!-- /wp:heading -->

<!-- wp:heading {"level":5} -->
<h5 class="wp-block-heading">Heading 5 — Small group</h5>
<!-- /wp:heading -->

<!-- wp:heading {"level":6} -->
<h6 class="wp-block-heading">Heading 6 — Eyebrow</h6>
<!-- /wp:heading -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Paragraphs</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size">Lead paragraph — sized <code>large</code> (clamp 1.125rem → 1.25rem). Use at the top of articles and pages to establish context, set tone, and preview what follows.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Body paragraph — default <code>medium</code> (clamp 1rem → 1.0625rem) at <code>line-height: 1.7</code>. Paragraphs should breathe: around 50–75 characters per line is most legible, which is why the reading column is capped at <code>contentSize: 40rem</code>. <a href="#">Inline links</a> are underlined and take the Jetpack green 60 color from <code>theme.json</code>'s <code>styles.elements.link</code>. <strong>Bold</strong>, <em>italic</em>, and <del>strikethrough</del> carry native HTML semantics; <code>inline code</code> picks up the monospace preset and a subtle muted background.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">Small paragraph — sized <code>small</code>. Useful for footnotes, captions, legal copy, and dense UI explanations where body-size would dominate.</p>
<!-- /wp:paragraph -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Lists</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Unordered</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Bullets are rendered as outlined accent-colored circles via <code>.jetpack-prose ul.wp-block-list</code>. Nesting is preserved to two levels.</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list">
<!-- wp:list-item -->
<li>Protect — automated backups, one-click restores, and malware scanning.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Perform — site acceleration, lazy loading, and CDN delivery.
<!-- wp:list -->
<ul class="wp-block-list">
<!-- wp:list-item -->
<li>Images served from a global edge network.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Critical CSS inlined to reduce render blocking.</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Grow — newsletter, subscriptions, and social publishing.</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Ordered</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Numbered lists receive an accent-tinted badge marker generated from a CSS counter, giving procedures a clear step rhythm without leaning on the default browser numerals.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list">
<!-- wp:list-item -->
<li>Install Jetpack from the WordPress.org plugin directory.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Connect your site to a WordPress.com account.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Pick the modules or plan that fits your workflow.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Ship with confidence.</li>
<!-- /wp:list-item -->
</ol>
<!-- /wp:list -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Quote &amp; pullquote</h2>
<!-- /wp:heading -->

<!-- wp:quote -->
<blockquote class="wp-block-quote">
<!-- wp:paragraph -->
<p>Good typography is invisible. It gets out of the way so readers can focus on the ideas, not the letterforms.</p>
<!-- /wp:paragraph -->
<cite>Jetpack Design Principles</cite>
</blockquote>
<!-- /wp:quote -->

<!-- wp:pullquote -->
<figure class="wp-block-pullquote">
<blockquote>
<p>A hierarchical system is a contract between author and reader — every level earns its weight.</p>
<cite>Typography handbook</cite>
</blockquote>
</figure>
<!-- /wp:pullquote -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Code &amp; preformatted</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Inline code like <code>wp_enqueue_style()</code> uses the <code>Geist Mono</code> preset on a tinted background. Block-level code uses a dark chrome for contrast:</p>
<!-- /wp:paragraph -->

<!-- wp:code -->
<pre class="wp-block-code"><code>add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'jetpack-theme-style',
        get_template_directory_uri() . '/build/style-frontend.css'
    );
} );</code></pre>
<!-- /wp:code -->

<!-- wp:paragraph -->
<p>Preformatted text preserves whitespace on a lighter background — useful for file trees, diffs, or ASCII diagrams:</p>
<!-- /wp:paragraph -->

<!-- wp:preformatted -->
<pre class="wp-block-preformatted">wp-content/themes/jetpack-theme/
├── src/
│   ├── components/prose.css
│   └── templates/single-post.css
├── templates/
│   ├── single.html
│   └── page.html
└── theme.json</pre>
<!-- /wp:preformatted -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Separators</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Three separator styles share the same rhythm. Default:</p>
<!-- /wp:paragraph -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:paragraph -->
<p>Wide:</p>
<!-- /wp:paragraph -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:paragraph -->
<p>Dots:</p>
<!-- /wp:paragraph -->

<!-- wp:separator {"className":"is-style-dots"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-dots"/>
<!-- /wp:separator -->
