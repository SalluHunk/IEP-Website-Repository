<?php
/**
 * CMS-010 — Technical Relationships Module: Code Snippet
 * Install as a new snippet in Code Snippets (Snippets → Add New), "Run snippet everywhere",
 * Activate. No ACF JSON import needed — all 6 relationship fields are registered in PHP below
 * (same pattern CMS-005A used for "Service Icon": additive fields on an existing CPT, registered
 * via acf_add_local_field_group() rather than a JSON import, so nothing here can collide with or
 * overwrite CMS-002/005/006/007/008/009's own field groups).
 *
 * PREREQUISITE FIX BUNDLED IN: `cspt-service` has never been REST-visible on this site — every
 * other module (Leadership, Case Studies, Industries, Testimonials, Resources) got the standard
 * retrofit; Services didn't, because CMS-005/CMS-005A only ever wrote to it via direct
 * get_posts()/update_field() calls inside a Code Snippet, never through REST. Part 1 below closes
 * that gap the same proven way as every other module, so this package's own relationship
 * endpoints (and any future module) can read/write cspt-service normally.
 *
 * THREE RELATIONSHIP PAIRS BUILT (Mission Control's explicit scope choice — see DECISIONS.md):
 *   A. Case Study  <-> Industry Sector   (cspt-portfolio.related_industries <-> cspt-industry-sector.related_case_studies)
 *   B. Case Study  <-> Service           (cspt-portfolio.related_services  <-> cspt-service.related_case_studies)
 *   C. Industry Sector <-> Service       (cspt-industry-sector.related_services <-> cspt-service.related_industries)
 *
 * Testimonials are deliberately NOT part of any relationship pair — Mission Control's explicit
 * decision this session, since Case Studies were anonymised at the client's request and even an
 * unlabelled UI link from a named testimonial to a specific case study risks undoing that
 * anonymisation. See DECISIONS.md.
 *
 * Every relationship field is genuinely bidirectional: writing to one side via the /relate/...
 * endpoints below also updates the other side's reverse field, additions and removals both,
 * computed as a diff against the previous value — not just appended, so removing a relationship
 * on one side is reflected on the other side too, not left stale.
 *
 * SECURITY NOTE: the /iep-cms/v1/... endpoints below require a shared-secret header
 * (X-IEP-CMS-Key) — same pattern as every prior module, a distinct secret generated with
 * Python's `secrets.token_hex(32)`, not chosen or typed by hand, and not reused across modules.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// --- Part 1: close the cspt-service REST gap (same adaptive pattern as every other module) ---
add_action( 'init', function () {
	global $wp_post_types;
	if ( post_type_exists( 'cspt-service' ) ) {
		$wp_post_types['cspt-service']->show_in_rest          = true;
		$wp_post_types['cspt-service']->rest_base             = 'services-cpt';
		$wp_post_types['cspt-service']->rest_controller_class = 'WP_REST_Posts_Controller';
	}
	// No "register fresh" branch: cspt-service is already known to exist and be populated with 9
	// real services (CMS-005/CMS-005A), unlike the CPTs CMS-007/008/009 had genuine doubt about.
}, 20 );

// --- Part 2: register the 6 relationship fields, 2 per CPT, each its own small field group ---
add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'         => 'group_iep_cs_relationships_v1',
		'title'       => 'Case Study Relationships (CMS-010)',
		'fields'      => array(
			array(
				'key'           => 'field_iep_cs_related_industries',
				'label'         => 'Related Industry Sectors',
				'name'          => 'related_industries',
				'type'          => 'relationship',
				'post_type'     => array( 'cspt-industry-sector' ),
				'filters'       => array( 'search' ),
				'return_format' => 'id',
				'instructions'  => 'Kept in sync automatically with each linked Industry Sector\'s own "Related Case Studies" field — edit via the /iep-cms/v1/relate/case-study-industry endpoint, not directly, to preserve that sync.',
			),
			array(
				'key'           => 'field_iep_cs_related_services',
				'label'         => 'Related Services',
				'name'          => 'related_services',
				'type'          => 'relationship',
				'post_type'     => array( 'cspt-service' ),
				'filters'       => array( 'search' ),
				'return_format' => 'id',
				'instructions'  => 'Kept in sync automatically with each linked Service\'s own "Related Case Studies" field — edit via the /iep-cms/v1/relate/case-study-service endpoint, not directly, to preserve that sync.',
			),
		),
		'location'    => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'cspt-portfolio' ) ) ),
		'menu_order'  => 2,
		'position'    => 'normal',
		'active'      => true,
		'description' => 'CMS-010 addition — kept as its own field group so it cannot collide with CMS-006\'s "Case Study Details" group.',
	) );

	acf_add_local_field_group( array(
		'key'         => 'group_iep_industry_relationships_v1',
		'title'       => 'Industry Sector Relationships (CMS-010)',
		'fields'      => array(
			array(
				'key'           => 'field_iep_ind_related_case_studies',
				'label'         => 'Related Case Studies',
				'name'          => 'related_case_studies',
				'type'          => 'relationship',
				'post_type'     => array( 'cspt-portfolio' ),
				'filters'       => array( 'search' ),
				'return_format' => 'id',
				'instructions'  => 'Kept in sync automatically with each linked Case Study\'s own "Related Industry Sectors" field — edit via the /iep-cms/v1/relate/case-study-industry endpoint, not directly.',
			),
			array(
				'key'           => 'field_iep_ind_related_services',
				'label'         => 'Related Services',
				'name'          => 'related_services',
				'type'          => 'relationship',
				'post_type'     => array( 'cspt-service' ),
				'filters'       => array( 'search' ),
				'return_format' => 'id',
				'instructions'  => 'Kept in sync automatically with each linked Service\'s own "Related Industry Sectors" field — edit via the /iep-cms/v1/relate/industry-service endpoint, not directly.',
			),
		),
		'location'    => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'cspt-industry-sector' ) ) ),
		'menu_order'  => 2,
		'position'    => 'normal',
		'active'      => true,
		'description' => 'CMS-010 addition — kept as its own field group so it cannot collide with CMS-007\'s "Industry Sector Details" group.',
	) );

	acf_add_local_field_group( array(
		'key'         => 'group_iep_service_relationships_v1',
		'title'       => 'Service Relationships (CMS-010)',
		'fields'      => array(
			array(
				'key'           => 'field_iep_svc_related_case_studies',
				'label'         => 'Related Case Studies',
				'name'          => 'related_case_studies',
				'type'          => 'relationship',
				'post_type'     => array( 'cspt-portfolio' ),
				'filters'       => array( 'search' ),
				'return_format' => 'id',
				'instructions'  => 'Kept in sync automatically with each linked Case Study\'s own "Related Services" field — edit via the /iep-cms/v1/relate/case-study-service endpoint, not directly.',
			),
			array(
				'key'           => 'field_iep_svc_related_industries',
				'label'         => 'Related Industry Sectors',
				'name'          => 'related_industries',
				'type'          => 'relationship',
				'post_type'     => array( 'cspt-industry-sector' ),
				'filters'       => array( 'search' ),
				'return_format' => 'id',
				'instructions'  => 'Editorial synthesis, not sourced from client content — see DECISIONS.md. Kept in sync automatically with each linked Industry Sector\'s own "Related Services" field — edit via the /iep-cms/v1/relate/industry-service endpoint, not directly.',
			),
		),
		'location'    => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'cspt-service' ) ) ),
		'menu_order'  => 2,
		'position'    => 'normal',
		'active'      => true,
		'description' => 'CMS-010 addition — kept as its own field group so it cannot collide with CMS-005\'s "Service Details" group or CMS-005A\'s "Service Icon" group.',
	) );
}, 20 );

// --- Part 3: authenticated bidirectional-sync endpoints + a minimal Service read/write endpoint ---
define( 'IEP_CMS_REL_KEY', '343abb87ab6a8d1885a161fccb2dba68e41cdc9fbe28d63e74ffcb877cec8f2f' );

/**
 * Sets $from_field on $from_id to $new_to_ids, and syncs the reverse $to_field on every
 * affected post: adds $from_id where a relationship was newly added, removes it where a
 * relationship was dropped. Both sides ACF `relationship` fields with return_format 'id'.
 */
/**
 * Normalizes any get_field() return value for a `relationship` field (return_format 'id') into a
 * clean array of positive-integer post IDs. get_field() on a never-before-saved relationship
 * field returns `false` on this site (confirmed empirically, not assumed) — a naive `(array) $val`
 * cast turns that into `array(false)`, which `intval()`-maps to `array(0)`, silently corrupting
 * every field's first-ever write with a phantom `0` entry. v1.1 fix: treat anything that isn't
 * already a real array as empty, and drop any non-positive value from real arrays too, so this
 * can't recur even if get_field()'s empty-state representation ever changes again.
 */
if ( ! function_exists( 'iep_normalize_ids' ) ) {
	function iep_normalize_ids( $val ) {
		if ( ! is_array( $val ) ) {
			return array();
		}
		$out = array();
		foreach ( $val as $v ) {
			$iv = (int) $v;
			if ( $iv > 0 ) {
				$out[] = $iv;
			}
		}
		return array_values( array_unique( $out ) );
	}
}

if ( ! function_exists( 'iep_sync_relationship' ) ) {
	function iep_sync_relationship( $from_id, $from_field, $to_field, $new_to_ids ) {
		$old_to_ids = iep_normalize_ids( get_field( $from_field, $from_id ) );
		$new_to_ids = iep_normalize_ids( $new_to_ids );

		update_field( $from_field, $new_to_ids, $from_id );

		$added   = array_diff( $new_to_ids, $old_to_ids );
		$removed = array_diff( $old_to_ids, $new_to_ids );

		foreach ( $added as $to_id ) {
			$reverse = iep_normalize_ids( get_field( $to_field, $to_id ) );
			if ( ! in_array( (int) $from_id, $reverse, true ) ) {
				$reverse[] = (int) $from_id;
				update_field( $to_field, $reverse, $to_id );
			}
		}
		foreach ( $removed as $to_id ) {
			$reverse = iep_normalize_ids( get_field( $to_field, $to_id ) );
			$reverse = array_values( array_diff( $reverse, array( (int) $from_id ) ) );
			update_field( $to_field, $reverse, $to_id );
		}

		return array(
			'from'    => array_values( $new_to_ids ),
			'added'   => array_values( $added ),
			'removed' => array_values( $removed ),
		);
	}
}

add_action( 'rest_api_init', function () {
	$auth_check = function ( WP_REST_Request $req ) {
		$sent = $req->get_header( 'x_iep_cms_key' );
		return is_string( $sent ) && hash_equals( IEP_CMS_REL_KEY, $sent );
	};

	// A. Case Study <-> Industry Sector
	register_rest_route( 'iep-cms/v1', '/relate/case-study-industry', array(
		'methods'             => 'POST',
		'permission_callback' => $auth_check,
		'callback'            => function ( WP_REST_Request $req ) {
			$case_study_id = (int) $req->get_param( 'case_study_id' );
			$industry_ids  = (array) $req->get_param( 'industry_ids' );
			if ( get_post_type( $case_study_id ) !== 'cspt-portfolio' ) {
				return new WP_Error( 'not_found', 'Not a cspt-portfolio post', array( 'status' => 404 ) );
			}
			$result = iep_sync_relationship( $case_study_id, 'related_industries', 'related_case_studies', $industry_ids );
			return array( 'case_study_id' => $case_study_id, 'result' => $result );
		},
	) );

	// B. Case Study <-> Service
	register_rest_route( 'iep-cms/v1', '/relate/case-study-service', array(
		'methods'             => 'POST',
		'permission_callback' => $auth_check,
		'callback'            => function ( WP_REST_Request $req ) {
			$case_study_id = (int) $req->get_param( 'case_study_id' );
			$service_ids   = (array) $req->get_param( 'service_ids' );
			if ( get_post_type( $case_study_id ) !== 'cspt-portfolio' ) {
				return new WP_Error( 'not_found', 'Not a cspt-portfolio post', array( 'status' => 404 ) );
			}
			$result = iep_sync_relationship( $case_study_id, 'related_services', 'related_case_studies', $service_ids );
			return array( 'case_study_id' => $case_study_id, 'result' => $result );
		},
	) );

	// C. Industry Sector <-> Service
	register_rest_route( 'iep-cms/v1', '/relate/industry-service', array(
		'methods'             => 'POST',
		'permission_callback' => $auth_check,
		'callback'            => function ( WP_REST_Request $req ) {
			$industry_id = (int) $req->get_param( 'industry_id' );
			$service_ids = (array) $req->get_param( 'service_ids' );
			if ( get_post_type( $industry_id ) !== 'cspt-industry-sector' ) {
				return new WP_Error( 'not_found', 'Not a cspt-industry-sector post', array( 'status' => 404 ) );
			}
			$result = iep_sync_relationship( $industry_id, 'related_services', 'related_industries', $service_ids );
			return array( 'industry_id' => $industry_id, 'result' => $result );
		},
	) );

	// Read the full relationship state for any one post (any of the 3 CPTs) — used for
	// verification, not population.
	register_rest_route( 'iep-cms/v1', '/relate/(?P<id>\d+)', array(
		'methods'             => 'GET',
		'permission_callback' => $auth_check,
		'callback'            => function ( WP_REST_Request $req ) {
			$id   = (int) $req->get_param( 'id' );
			$type = get_post_type( $id );
			$out  = array( 'id' => $id, 'post_type' => $type );
			if ( $type === 'cspt-portfolio' ) {
				$out['related_industries'] = get_field( 'related_industries', $id );
				$out['related_services']   = get_field( 'related_services', $id );
			} elseif ( $type === 'cspt-industry-sector' ) {
				$out['related_case_studies'] = get_field( 'related_case_studies', $id );
				$out['related_services']     = get_field( 'related_services', $id );
			} elseif ( $type === 'cspt-service' ) {
				$out['related_case_studies'] = get_field( 'related_case_studies', $id );
				$out['related_industries']   = get_field( 'related_industries', $id );
			} else {
				return new WP_Error( 'not_found', 'Not a relationship-bearing post type', array( 'status' => 404 ) );
			}
			return $out;
		},
	) );

	// Minimal Service read/write endpoint — closes the same gap every other module already had.
	// Only covers what's needed for this module (title/slug lookups + the two relationship
	// fields above are already handled by /relate/...); does not attempt to cover CMS-005's own
	// "Service Details" fields (executive_summary, display_order) or CMS-005A's service_icon,
	// since nothing in this module needs to write those and duplicating that surface here would
	// risk drifting out of sync with CMS-005/005A's own logic.
	register_rest_route( 'iep-cms/v1', '/service/(?P<id>\d+)', array(
		'methods'             => 'GET',
		'permission_callback' => $auth_check,
		'callback'            => function ( WP_REST_Request $req ) {
			$id = (int) $req->get_param( 'id' );
			if ( get_post_type( $id ) !== 'cspt-service' ) {
				return new WP_Error( 'not_found', 'Not a cspt-service post', array( 'status' => 404 ) );
			}
			return array(
				'id'    => $id,
				'title' => get_the_title( $id ),
				'slug'  => get_post_field( 'post_name', $id ),
			);
		},
	) );

	// One-time cleanup route (v1.1) — strips any non-positive-int entries (the phantom `0` bug,
	// see iep_normalize_ids()) already persisted by v1.0's population pass, across all 3 CPTs'
	// relationship fields. Safe to call more than once — idempotent, only rewrites fields that
	// actually contain a bad entry.
	register_rest_route( 'iep-cms/v1', '/relate/cleanup', array(
		'methods'             => 'POST',
		'permission_callback' => $auth_check,
		'callback'            => function () {
			$field_map = array(
				'cspt-portfolio'       => array( 'related_industries', 'related_services' ),
				'cspt-industry-sector' => array( 'related_case_studies', 'related_services' ),
				'cspt-service'         => array( 'related_case_studies', 'related_industries' ),
			);
			$cleaned = array();
			foreach ( $field_map as $post_type => $fields ) {
				$posts = get_posts( array( 'post_type' => $post_type, 'post_status' => 'any', 'posts_per_page' => -1 ) );
				foreach ( $posts as $p ) {
					foreach ( $fields as $f ) {
						$raw   = get_field( $f, $p->ID );
						$clean = iep_normalize_ids( $raw );
						$raw_arr = is_array( $raw ) ? array_map( 'intval', $raw ) : array();
						if ( $raw_arr !== $clean ) {
							update_field( $f, $clean, $p->ID );
							$cleaned[] = array( 'id' => $p->ID, 'field' => $f, 'before' => $raw_arr, 'after' => $clean );
						}
					}
				}
			}
			return array( 'cleaned_count' => count( $cleaned ), 'cleaned' => $cleaned );
		},
	) );

	register_rest_route( 'iep-cms/v1', '/services', array(
		'methods'             => 'GET',
		'permission_callback' => $auth_check,
		'callback'            => function () {
			$posts = get_posts( array(
				'post_type'      => 'cspt-service',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			) );
			return array_map( function ( $p ) {
				return array( 'id' => $p->ID, 'title' => $p->post_title, 'slug' => $p->post_name );
			}, $posts );
		},
	) );
} );

// --- Part 4: [iep_related] shortcode ---
// Usage: [iep_related type="industries|services|case_studies"] inside a single-post loop (Case
// Study, Industry Sector, or Service detail page) — auto-detects the current post and its type.
// Optionally pass post_id="123" to render for a specific post outside the loop.
add_shortcode( 'iep_related', function ( $atts ) {
	$atts = shortcode_atts( array( 'type' => '', 'post_id' => 0 ), $atts );
	$post_id = $atts['post_id'] ? (int) $atts['post_id'] : get_the_ID();
	if ( ! $post_id || ! $atts['type'] ) {
		return '';
	}

	$field_map = array(
		'case_studies' => array( 'field' => 'related_case_studies', 'post_type' => 'cspt-portfolio', 'label' => 'Related Case Studies' ),
		'industries'   => array( 'field' => 'related_industries', 'post_type' => 'cspt-industry-sector', 'label' => 'Related Industry Sectors' ),
		'services'     => array( 'field' => 'related_services', 'post_type' => 'cspt-service', 'label' => 'Related Services' ),
	);
	if ( ! isset( $field_map[ $atts['type'] ] ) ) {
		return '';
	}
	$cfg = $field_map[ $atts['type'] ];

	$ids = array_map( 'intval', (array) get_field( $cfg['field'], $post_id ) ?: array() );
	if ( empty( $ids ) ) {
		return '';
	}

	ob_start();
	?>
	<style>
	.iep-rel-wrap{max-width:1200px;margin:0 auto;padding:24px 0;}
	.iep-rel-label{font-weight:600;color:#1E3D34;font-size:14px;text-transform:uppercase;letter-spacing:1px;margin-bottom:14px;}
	.iep-rel-items{display:flex;flex-wrap:wrap;gap:12px;}
	.iep-rel-chip{display:inline-block;padding:10px 18px;background:#F3F6F7;border:1px solid #E1E7E8;border-radius:24px;color:#1E3D34;font-size:14px;font-weight:600;text-decoration:none;transition:background .2s,border-color .2s;}
	.iep-rel-chip:hover{background:#E7F0E9;border-color:#CFE0D4;color:#1E3D34;}
	</style>
	<div class="iep-rel-wrap">
		<div class="iep-rel-label"><?php echo esc_html( $cfg['label'] ); ?></div>
		<div class="iep-rel-items">
			<?php foreach ( $ids as $rid ) :
				if ( get_post_type( $rid ) !== $cfg['post_type'] || get_post_status( $rid ) !== 'publish' ) {
					continue;
				}
				?>
				<a class="iep-rel-chip" href="<?php echo esc_url( get_permalink( $rid ) ); ?>"><?php echo esc_html( get_the_title( $rid ) ); ?></a>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
} );
