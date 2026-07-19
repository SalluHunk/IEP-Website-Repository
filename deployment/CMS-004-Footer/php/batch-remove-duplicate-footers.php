<?php
/**
 * CMS-004 — Batch duplicate footer removal
 *
 * TEMPORARY snippet. Deploy via Code Snippets ("Only run in administration
 * area"), run once, then DELETE this snippet entirely.
 *
 * Runs the same removal logic as one-time-remove-duplicate-footers.php
 * across all remaining pages in a single pass, with one extra safety gate
 * that script didn't have: a page only gets saved LIVE if BOTH the
 * hide-footer CSS rule AND the duplicate footer section are found. A
 * partial match (which is exactly what almost silently slipped through on
 * page 973, before the regex was corrected) is skipped and flagged for
 * manual review instead of being applied.
 *
 * Dry run (default, changes nothing):
 *   /wp-admin/?iep_footer_cleanup_batch=1
 * Live (after reviewing the dry run report):
 *   /wp-admin/?iep_footer_cleanup_batch=1&iep_footer_cleanup_live=1
 *
 * Only processes the page IDs listed below — edit the list if the set of
 * remaining pages changes. 970 and 973 are excluded since they're already
 * confirmed done; re-running against them is harmless (would report
 * "nothing matched") but adds noise to the report.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_init', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( empty( $_GET['iep_footer_cleanup_batch'] ) ) {
		return;
	}

	$page_ids = array( 959, 965, 971, 972, 978, 979, 980, 981, 982, 983, 984, 1062 );
	$is_live  = ! empty( $_GET['iep_footer_cleanup_live'] );
	$report   = array();

	foreach ( $page_ids as $page_id ) {
		$data = get_post_meta( $page_id, '_elementor_data', true );

		if ( empty( $data ) ) {
			$report[] = "Page {$page_id}: NO DATA FOUND — skipped, check manually.";
			continue;
		}

		$elements = json_decode( $data, true );

		if ( ! is_array( $elements ) ) {
			$report[] = "Page {$page_id}: JSON DECODE FAILED — skipped, check manually.";
			continue;
		}

		$removed  = array();
		$elements = iep_strip_hide_footer_style( $elements, $removed );

		$has_footer_section = false;
		$last_index         = count( $elements ) - 1;
		if ( $last_index >= 0 && iep_looks_like_footer_section( $elements[ $last_index ] ) ) {
			$has_footer_section = true;
		}

		$has_hide_style = ! empty( $removed );

		if ( ! $has_hide_style && ! $has_footer_section ) {
			$report[] = "Page {$page_id}: nothing matched — already clean, or needs manual check.";
			continue;
		}

		if ( ! $has_hide_style || ! $has_footer_section ) {
			$report[] = "Page {$page_id}: PARTIAL MATCH ONLY (hide_style=" . ( $has_hide_style ? 'yes' : 'no' ) . ', footer_section=' . ( $has_footer_section ? 'yes' : 'no' ) . ') — SKIPPED, not applied. Needs manual check, same as page 973 originally did.';
			continue;
		}

		// Both matched — safe to remove the footer section now.
		array_splice( $elements, $last_index, 1 );

		if ( $is_live ) {
			update_post_meta( $page_id, '_elementor_data', wp_slash( wp_json_encode( $elements ) ) );
			$report[] = "Page {$page_id}: LIVE — removed hide_footer_style and footer_section.";
		} else {
			$report[] = "Page {$page_id}: DRY RUN OK — would remove hide_footer_style and footer_section.";
		}
	}

	if ( $is_live && class_exists( '\Elementor\Plugin' ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}

	wp_die( '<pre>' . esc_html( implode( "\n", $report ) ) . "\n\n" . ( $is_live ? 'LIVE RUN COMPLETE.' : 'DRY RUN — add &iep_footer_cleanup_live=1 to apply.' ) . '</pre>' );
} );

// Reuse the exact same helper functions as the per-page script, so behavior
// is identical — only define them if that script isn't also active
// (avoids a fatal "cannot redeclare function" if both snippets are on).
if ( ! function_exists( 'iep_strip_hide_footer_style' ) ) {
	function iep_strip_hide_footer_style( $elements, &$removed ) {
		foreach ( $elements as $i => &$el ) {
			if (
				isset( $el['widgetType'] ) && $el['widgetType'] === 'html'
				&& isset( $el['settings']['html'] )
				&& strpos( $el['settings']['html'], 'site-footer' ) !== false
				&& strpos( $el['settings']['html'], 'display:none' ) !== false
			) {
				$removed[] = 'hide_footer_style:' . ( $el['id'] ?? $i );
				$el['settings']['html'] = preg_replace(
					'/body\.page-id-\d+[^{}]*\.cspt-page-header\s*\{[^}]*\}/',
					'',
					$el['settings']['html']
				);
				continue;
			}
			if ( isset( $el['elements'] ) && is_array( $el['elements'] ) ) {
				$el['elements'] = iep_strip_hide_footer_style( $el['elements'], $removed );
			}
		}
		return $elements;
	}
}

if ( ! function_exists( 'iep_looks_like_footer_section' ) ) {
	function iep_looks_like_footer_section( $el ) {
		if ( ! isset( $el['elType'] ) || $el['elType'] !== 'section' ) {
			return false;
		}
		$bg = $el['settings']['background_color'] ?? '';
		if ( strtoupper( $bg ) !== '#101A18' ) {
			return false;
		}
		$json = wp_json_encode( $el );
		return strpos( $json, 'iep-foot' ) !== false && strpos( $json, 'iep-logo-white' ) !== false;
	}
}
