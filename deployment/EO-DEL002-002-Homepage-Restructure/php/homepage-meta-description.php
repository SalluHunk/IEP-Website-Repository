<?php
/**
 * EO-DEL002-002 M6 — Homepage meta description.
 *
 * Deploy via Code Snippets, run Everywhere. No SEO plugin (Yoast/RankMath/AIOSEO)
 * is installed on this site — confirmed via wp_list_plugins during EO-DEL002-001 —
 * so there is no existing meta-description mechanism to hook into. This adds one
 * directly, scoped to the front page only (page ID 959), via wp_head.
 *
 * Copy sourced directly from PDC-001 Article I's Constitutional Statement — not
 * invented — to guarantee traceability back to the repository rather than
 * drafting new marketing copy inside a Code Snippet.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_head', function () {
	if ( ! is_front_page() ) {
		return;
	}
	$description = 'Industrial Energy Pioneers: engineering-led consultancy helping energy-intensive businesses cut costs and fund viable efficiency and decarbonisation projects.';
	echo '<meta name="description" content="' . esc_attr( $description ) . '" />' . "\n";
}, 1 );
