<?php
/**
 * CMS-004 — One-time duplicate footer removal
 *
 * TEMPORARY snippet. Deploy via Code Snippets, run once per page (NOT
 * "Everywhere" — this is admin-triggered, see below), then DELETE this
 * snippet entirely once all 14 pages are confirmed clean. Do not leave
 * this active long-term.
 *
 * What it does, per page: removes the page-scoped <style> HTML widget
 * that hides .site-footer/#colophon/.footer-wrap, and removes the
 * duplicated footer Elementor section (the dark #101A18, 4-column
 * block containing the logo, Services/Industries links, and contact
 * info). Everything else on the page is left untouched.
 *
 * SAFETY: defaults to dry-run (logs what it would remove, changes
 * nothing). Only flips to live once you add ?iep_footer_cleanup_live=1
 * to the URL, AND only for the specific page ID passed in
 * ?iep_footer_cleanup_page=<id>. Run one page at a time. Check the
 * page in the browser after each one before moving to the next.
 *
 * Known page IDs to run this against, one at a time (per CMS-BOOT-002 /
 * BACKUP-001): 959, 965, 970, 971, 972, 973, 978, 979, 980, 981, 982,
 * 983, 984, 1062.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_init', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( empty( $_GET['iep_footer_cleanup_page'] ) ) {
		return;
	}

	$page_id = absint( $_GET['iep_footer_cleanup_page'] );
	$is_live = ! empty( $_GET['iep_footer_cleanup_live'] );

	$data = get_post_meta( $page_id, '_elementor_data', true );
	if ( empty( $data ) ) {
		wp_die( "Page {$page_id}: no _elementor_data found. Nothing to do." );
	}

	$elements = json_decode( $data, true );
	if ( ! is_array( $elements ) ) {
		wp_die( "Page {$page_id}: _elementor_data did not decode to an array. Aborting — check manually." );
	}

	$original_count = count( $elements );
	$removed        = array();

	// 1. Remove the hide-footer <style> HTML widget, wherever it sits.
	$elements = iep_strip_hide_footer_style( $elements, $removed );

	// 2. Remove the duplicated footer section — expected to be the
	//    last top-level section, matching the dark-background /
	//    4-column signature. Confirmed this pattern on Services (970),
	//    Leadership (972), and Case Studies (978) during CMS-BOOT-002 —
	//    verify visually on every other page before trusting it there too.
	$last_index = count( $elements ) - 1;
	if ( $last_index >= 0 && iep_looks_like_footer_section( $elements[ $last_index ] ) ) {
		$removed[] = 'footer_section:' . ( $elements[ $last_index ]['id'] ?? 'unknown' );
		array_splice( $elements, $last_index, 1 );
	}

	$new_count = count( $elements );

	if ( ! $is_live ) {
		wp_die(
			"DRY RUN — page {$page_id}. Would remove " . count( $removed ) . " item(s): " . implode( ', ', $removed ) .
			". Top-level element count would go from {$original_count} to {$new_count}. " .
			"Add &iep_footer_cleanup_live=1 to actually save this change."
		);
	}

	if ( empty( $removed ) ) {
		wp_die( "Page {$page_id}: nothing matched the known patterns. No changes made — check this page manually instead." );
	}

	update_post_meta( $page_id, '_elementor_data', wp_slash( wp_json_encode( $elements ) ) );

	// Clear Elementor's cached CSS for this page so the change shows immediately.
	if ( class_exists( '\Elementor\Plugin' ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}

	wp_die( "Page {$page_id}: removed " . implode( ', ', $removed ) . ". Reload the front-end page now to verify." );
} );

function iep_strip_hide_footer_style( $elements, &$removed ) {
	foreach ( $elements as $i => &$el ) {
		if (
			isset( $el['widgetType'] ) && $el['widgetType'] === 'html'
			&& isset( $el['settings']['html'] )
			&& strpos( $el['settings']['html'], 'site-footer' ) !== false
			&& strpos( $el['settings']['html'], 'display:none' ) !== false
		) {
			$removed[] = 'hide_footer_style:' . ( $el['id'] ?? $i );
			// Matches both observed formats: a single "body.page-id-N" prefix shared
			// across the whole comma-separated selector list (pages 970/972/978),
			// and the prefix repeated before every individual selector (page 973).
			// [^{}]* can't cross a brace boundary, so this can't accidentally eat
			// past an unrelated adjacent rule.
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
