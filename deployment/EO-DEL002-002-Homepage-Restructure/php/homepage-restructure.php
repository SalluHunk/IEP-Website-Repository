<?php
/**
 * EO-DEL002-002 — Homepage Restructure (M1: Services CMS-migration, M2: section
 * reorder, M4: CTA relocation)
 *
 * Deploy via Code Snippets, run Everywhere. One-time, idempotent, dry-run by
 * default. Visit /?iep_homepage_restructure=1 as an administrator to preview;
 * add &live=1 to actually write. Guarded by an option flag so a second run
 * after a live run is a safe no-op, not a double-application.
 *
 * What it does, server-side, to page 959's _elementor_data:
 *   1. Locates the "Core services" section and replaces its two hardcoded
 *      8-item icon-box grid rows with a single [iep_services_by_category]
 *      shortcode widget — the same CMS-driven taxonomy already live on
 *      /services/. Deliberately reuses the existing shortcode rather than
 *      writing new query/render logic (no duplicated business logic).
 *   2. Moves the "Book Opportunity Screening" CTA (text + button) from the
 *      end of the Methodology section to the end of the Services section,
 *      per EO-DEL002-001 finding D-09 / CONTENT-004's own recommendation —
 *      the CTA should follow the capability claim it references, not
 *      precede it.
 *   3. Reorders the 15 top-level sections to match PDC-A001's governing
 *      12-stage model: swaps Who-We-Help/Commercial-Challenge (restoring
 *      Article VIII's stated order) and swaps Case-Studies/Services and
 *      Leadership/Technical-Capability (resolving EO-DEL002-001 findings
 *      D-02, D-03, D-04).
 *
 * Safety: located by heading TEXT, not hardcoded array index — if the live
 * page's structure has changed since the audit (e.g. a different number of
 * top-level sections, or the expected headings aren't found), the script
 * aborts with a diagnostic message and writes nothing.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	if ( ! isset( $_GET['iep_homepage_restructure'] ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Insufficient permissions.' );
	}

	$page_id = 959;
	$live    = isset( $_GET['live'] ) && $_GET['live'] === '1';

	if ( $live && get_option( 'iep_homepage_restructure_done' ) ) {
		echo 'Already applied live — this is a one-time, idempotent operation. No changes made. (To re-run intentionally, delete the iep_homepage_restructure_done option first.)';
		exit;
	}

	$raw = get_post_meta( $page_id, '_elementor_data', true );
	$data = json_decode( $raw, true );

	if ( ! is_array( $data ) ) {
		wp_die( 'Could not decode _elementor_data as JSON. Aborting — no changes made.' );
	}
	if ( count( $data ) !== 15 ) {
		wp_die( 'Expected 15 top-level sections, found ' . count( $data ) . '. The page structure has changed since this script was written. Aborting — no changes made.' );
	}

	// --- Helper: find first heading widget's title text under an element tree ---
	$find_heading = function ( $el ) use ( &$find_heading ) {
		if ( isset( $el['widgetType'] ) && $el['widgetType'] === 'heading' && isset( $el['settings']['title'] ) ) {
			return $el['settings']['title'];
		}
		if ( ! empty( $el['elements'] ) ) {
			foreach ( $el['elements'] as $child ) {
				$t = $find_heading( $child );
				if ( $t !== null ) {
					return $t;
				}
			}
		}
		return null;
	};

	// --- Helper: find element by id anywhere under a tree ---
	$find_by_id = function ( $el, $id ) use ( &$find_by_id ) {
		if ( isset( $el['id'] ) && $el['id'] === $id ) {
			return $el;
		}
		if ( ! empty( $el['elements'] ) ) {
			foreach ( $el['elements'] as $child ) {
				$found = $find_by_id( $child, $id );
				if ( $found !== null ) {
					return $found;
				}
			}
		}
		return null;
	};

	// --- Locate sections by heading text (safer than hardcoded index) ---
	$services_idx    = null;
	$methodology_idx = null;
	$case_studies_idx = null;
	$who_we_help_idx = null;
	$commercial_challenge_idx = null;
	$leadership_idx = null;
	$technical_capability_idx = null;

	foreach ( $data as $i => $section ) {
		$h = $find_heading( $section );
		if ( $h === 'Core services' ) {
			$services_idx = $i;
		} elseif ( $h === 'A six-step roadmap from data to delivery' ) {
			$methodology_idx = $i;
		} elseif ( $h === 'Featured case studies' ) {
			$case_studies_idx = $i;
		} elseif ( $h === 'Built for energy-intensive industry' ) {
			$who_we_help_idx = $i;
		} elseif ( $h === 'Waste is a margin leak' ) {
			$commercial_challenge_idx = $i;
		} elseif ( $h === 'A specialist team built for delivery' ) {
			$leadership_idx = $i;
		} elseif ( $h === 'Technical depth and rigorous modelling' ) {
			$technical_capability_idx = $i;
		}
	}

	$required = compact( 'services_idx', 'methodology_idx', 'case_studies_idx', 'who_we_help_idx', 'commercial_challenge_idx', 'leadership_idx', 'technical_capability_idx' );
	foreach ( $required as $name => $val ) {
		if ( $val === null ) {
			wp_die( 'Could not locate required section: ' . esc_html( $name ) . '. Aborting — no changes made.' );
		}
	}

	// --- M1: Replace hardcoded services grid with CMS-driven shortcode ---
	$services_col = &$data[ $services_idx ]['elements'][0];

	if ( count( $services_col['elements'] ) !== 4 ) {
		wp_die( 'Services column has ' . count( $services_col['elements'] ) . ' children, expected 4. Aborting — no changes made.' );
	}
	$eyebrow = $services_col['elements'][0];
	$heading = $services_col['elements'][1];
	if ( $heading['settings']['title'] !== 'Core services' ) {
		wp_die( 'Services heading sanity check failed. Aborting — no changes made.' );
	}

	$rand_id = function () {
		return substr( bin2hex( random_bytes( 4 ) ), 0, 7 );
	};

	$shortcode_widget = array(
		'id'         => $rand_id(),
		'elType'     => 'widget',
		'widgetType' => 'shortcode',
		'settings'   => array( 'shortcode' => '[iep_services_by_category]' ),
		'elements'   => array(),
	);
	$shortcode_column = array(
		'id'       => $rand_id(),
		'elType'   => 'column',
		'settings' => array(
			'_column_size' => 100,
			'_inline_size' => null,
		),
		'elements' => array( $shortcode_widget ),
	);
	$shortcode_section = array(
		'id'       => $rand_id(),
		'elType'   => 'section',
		'settings' => array(),
		'elements' => array( $shortcode_column ),
	);

	// --- M4: Move the CTA (text + button) from Methodology to end of Services ---
	$methodology_col = &$data[ $methodology_idx ]['elements'][0];
	$cta_text_el = $find_by_id( $data[ $methodology_idx ], '725d510' );
	$cta_btn_el  = $find_by_id( $data[ $methodology_idx ], '1e308d0' );

	if ( $cta_text_el === null || $cta_btn_el === null ) {
		wp_die( 'Could not locate CTA elements (725d510 / 1e308d0) in Methodology section. Aborting — no changes made.' );
	}

	$methodology_col['elements'] = array_values( array_filter(
		$methodology_col['elements'],
		function ( $el ) {
			return $el['id'] !== '725d510' && $el['id'] !== '1e308d0';
		}
	) );

	$services_col['elements'] = array( $eyebrow, $heading, $shortcode_section, $cta_text_el, $cta_btn_el );

	// --- M2: Reorder top-level sections to match PDC-A001's governing model ---
	// Build the new order by located index (robust to the exact array position
	// even though, in practice, it matches the audit's own validated
	// [0,1,2,3,5,4,6,7,8,10,9,12,11,13,14] permutation).
	// Everything before the who-we-help/commercial-challenge pair (whichever comes first) is "hero".
	$first_named  = min( $who_we_help_idx, $commercial_challenge_idx );
	$hero_indices = range( 0, $first_named - 1 );

	$new_order = array_merge(
		$hero_indices,
		array( $commercial_challenge_idx, $who_we_help_idx )
	);

	// Everything between the who-we-help/commercial-challenge pair and methodology, in original order (Why IEP, Funding)
	$between_start = max( $who_we_help_idx, $commercial_challenge_idx ) + 1;
	for ( $i = $between_start; $i < $methodology_idx; $i++ ) {
		$new_order[] = $i;
	}
	$new_order[] = $methodology_idx;
	$new_order[] = $services_idx;
	$new_order[] = $case_studies_idx;
	$new_order[] = $technical_capability_idx;
	$new_order[] = $leadership_idx;

	// Everything after leadership/technical-capability (whichever is later), in original order (Testimonials, CTA)
	$after_start = max( $leadership_idx, $technical_capability_idx ) + 1;
	for ( $i = $after_start; $i < 15; $i++ ) {
		$new_order[] = $i;
	}

	if ( count( array_unique( $new_order ) ) !== 15 || count( $new_order ) !== 15 ) {
		wp_die( 'Reorder produced an invalid permutation (' . count( array_unique( $new_order ) ) . ' unique of ' . count( $new_order ) . '). Aborting — no changes made. Order was: ' . esc_html( implode( ',', $new_order ) ) );
	}

	$new_data = array();
	foreach ( $new_order as $idx ) {
		$new_data[] = $data[ $idx ];
	}

	// --- Output / apply ---
	if ( ! $live ) {
		echo '<h2>DRY RUN — nothing written</h2>';
		echo '<p>Original order (by index): ' . esc_html( implode( ', ', range( 0, 14 ) ) ) . '</p>';
		echo '<p>New order (original indices, in new sequence): ' . esc_html( implode( ', ', $new_order ) ) . '</p>';
		echo '<p>New section headings, in order:</p><ol>';
		foreach ( $new_data as $section ) {
			$h = $find_heading( $section );
			echo '<li>' . esc_html( $h ? $h : '(hero / no heading)' ) . '</li>';
		}
		echo '</ol>';
		echo '<p>Services column child count: ' . count( $services_col['elements'] ) . ' (expect 5)</p>';
		echo '<p>Methodology column child count: ' . count( $methodology_col['elements'] ) . ' (expect original minus 2)</p>';
		echo '<p>New payload size: ' . strlen( wp_json_encode( $new_data ) ) . ' bytes</p>';
		echo '<p>Add &live=1 to the URL to apply for real.</p>';
		exit;
	}

	// Backup, since WordPress's own revision system does not cover this post
	// (confirmed: no revision captured since 2026-07-04, direct meta writes
	// bypass the normal save flow that would otherwise create one).
	update_post_meta( $page_id, '_iep_homepage_restructure_backup', $raw );

	update_post_meta( $page_id, '_elementor_data', wp_slash( wp_json_encode( $new_data ) ) );
	update_post_meta( $page_id, '_elementor_edit_mode', 'builder' );
	update_option( 'iep_homepage_restructure_done', 1 );

	// Clear Elementor's own internal page cache for this page, if the API is available —
	// this site's own established lesson (CMS-005A) is that direct-DB _elementor_data
	// writes are NOT picked up by Elementor's parsed-content cache without this.
	if ( class_exists( '\Elementor\Plugin' ) ) {
		try {
			\Elementor\Plugin::$instance->files_manager->clear_cache();
		} catch ( \Throwable $e ) {
			// Non-fatal — host-level cache purge (WP Engine "Flush Cache") is still required regardless.
		}
	}

	echo 'Done. New payload size: ' . strlen( wp_json_encode( $new_data ) ) . ' bytes. ';
	echo 'Now purge the WP Engine host cache (Hosting → Flush Cache) and your browser cache, then verify /.';
	exit;
}, 5 );
