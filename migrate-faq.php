<?php
/**
 * Migration script: converts old wp:group.jetpack-faq + wp:details sections
 * to the new jetpack-theme/faq block.
 *
 * Usage:
 *   Dry run:  studio wp eval 'define("JETPACK_FAQ_DRY_RUN",true); require get_template_directory()."/migrate-faq.php";'
 *   Real run: studio wp eval 'require get_template_directory()."/migrate-faq.php";'
 */

$dry_run = defined( 'JETPACK_FAQ_DRY_RUN' ) && JETPACK_FAQ_DRY_RUN;

/**
 * Extract the full wp:group block containing "jetpack-faq" by tracking
 * nested open/close tags (regex can't handle balanced nesting).
 */
function jetpack_faq_extract_old_block( string $content ): ?array {
	$marker_pos = strpos( $content, 'jetpack-faq' );
	if ( $marker_pos === false ) {
		return null;
	}

	$block_start = strrpos( substr( $content, 0, $marker_pos ), '<!-- wp:group' );
	if ( $block_start === false ) {
		return null;
	}

	$open_tag  = '<!-- wp:group';
	$close_tag = '<!-- /wp:group -->';
	$depth     = 0;
	$pos       = $block_start;

	while ( true ) {
		$next_open  = strpos( $content, $open_tag, $pos + 1 );
		$next_close = strpos( $content, $close_tag, $pos + 1 );

		if ( $next_close === false ) {
			return null;
		}

		if ( $next_open !== false && $next_open < $next_close ) {
			$depth++;
			$pos = $next_open;
		} else {
			if ( $depth === 0 ) {
				$block_end = $next_close + strlen( $close_tag );
				return [
					'start' => $block_start,
					'end'   => $block_end,
					'block' => substr( $content, $block_start, $block_end - $block_start ),
				];
			}
			$depth--;
			$pos = $next_close;
		}
	}
}

/**
 * Parse Q&A pairs from <details><summary>Q</summary>...answer...</details> blocks.
 */
function jetpack_faq_extract_items( string $block_html ): array {
	$items   = [];
	$pattern = '/<details[^>]*><summary>(.*?)<\/summary>(.*?)<\/details>/s';

	if ( ! preg_match_all( $pattern, $block_html, $matches, PREG_SET_ORDER ) ) {
		return $items;
	}

	foreach ( $matches as $m ) {
		$question = trim( wp_strip_all_tags( html_entity_decode( $m[1], ENT_QUOTES, 'UTF-8' ) ) );
		$question = preg_replace( '/\x{00A0}/u', ' ', $question );

		$answer_parts = [];
		if ( preg_match_all( '/<(?:p|li)[^>]*>(.*?)<\/(?:p|li)>/s', $m[2], $p ) ) {
			foreach ( $p[1] as $part ) {
				$text = trim( wp_strip_all_tags( html_entity_decode( $part, ENT_QUOTES, 'UTF-8' ) ) );
				$text = preg_replace( '/\x{00A0}/u', ' ', $text );
				if ( $text !== '' ) {
					$answer_parts[] = $text;
				}
			}
		}
		$answer = implode( ' ', $answer_parts );

		if ( $question !== '' && $answer !== '' ) {
			$items[] = [ 'question' => $question, 'answer' => $answer ];
		}
	}

	return $items;
}

// ── Main ──────────────────────────────────────────────────────────────────────

$pages = get_posts( [
	'post_type'      => 'page',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'fields'         => 'ids',
] );

$migrated = 0;
$skipped  = 0;

foreach ( $pages as $page_id ) {
	$content = get_post_field( 'post_content', $page_id, 'raw' );

	if ( strpos( $content, 'jetpack-faq' ) === false || strpos( $content, 'wp:details' ) === false ) {
		continue;
	}

	$extracted = jetpack_faq_extract_old_block( $content );
	if ( ! $extracted ) {
		WP_CLI::warning( "Page $page_id (" . get_the_title( $page_id ) . "): couldn't isolate FAQ group block." );
		$skipped++;
		continue;
	}

	$items = jetpack_faq_extract_items( $extracted['block'] );
	if ( empty( $items ) ) {
		WP_CLI::warning( "Page $page_id (" . get_the_title( $page_id ) . "): no Q&A pairs extracted." );
		$skipped++;
		continue;
	}

	$attrs = [
		'sectionTitle'       => 'Questions? We\'ve got you covered.',
		'sectionDescription' => 'Can\'t find the answer you\'re looking for? Reach out!',
		'items'              => $items,
	];

	$json      = wp_json_encode( $attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
	$new_block = "<!-- wp:jetpack-theme/faq $json /-->";

	$new_content = substr_replace(
		$content,
		$new_block,
		$extracted['start'],
		$extracted['end'] - $extracted['start']
	);

	$title = get_the_title( $page_id );

	if ( $dry_run ) {
		WP_CLI::log( "[DRY RUN] Page $page_id ($title): " . count( $items ) . " Q&As → ready to migrate." );
	} else {
		wp_update_post( [
			'ID'           => $page_id,
			'post_content' => $new_content,
		] );
		WP_CLI::success( "Page $page_id ($title): migrated " . count( $items ) . " Q&As." );
	}

	$migrated++;
}

$mode = $dry_run ? ' (dry run)' : '';
WP_CLI::log( "\nDone$mode. Migrated: $migrated, Skipped: $skipped." );
