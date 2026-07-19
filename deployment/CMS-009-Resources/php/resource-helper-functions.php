<?php
/**
 * CMS-009 — Resources Module: Code Snippet
 * Install as a new snippet in Code Snippets (Snippets → Add New), "Run snippet everywhere",
 * Activate. Requires the "Resource Details" ACF field group
 * (acf-json/group_resource_fields.json) already imported.
 *
 * INFRASTRUCTURE-ONLY PACKAGE: unlike CMS-002/006/007/008, this package ships with ZERO real
 * content. No client-provided guides, whitepapers, calculators, or funding-briefing material
 * exists anywhere in the repository's reviewed sources (checked before building this package —
 * see DECISIONS.md). The live Resources page (984) itself says every category is "Coming soon."
 * This snippet's job is to make the platform ready to receive real content the moment it exists,
 * not to populate anything now.
 *
 * ADAPTIVE CPT HANDLING (pattern proven in CMS-008): checks post_type_exists() at runtime rather
 * than assuming from scratch is safe. wp_get_post_types confirmed no cspt-resource/cspt-download
 * type is currently REST-visible, but that only rules out REST-visible types — a non-REST legacy
 * type could still exist unregistered from this tool's view, same blind spot CMS-006 hit once
 * for Case Studies. Retrofits if found, registers fresh otherwise, either way REST-visible after.
 *
 * Three parts:
 *   1. Adaptive CPT handling (retrofit or fresh-register), REST-visible either way, with the
 *      guarded flush_rewrite_rules() call (CMS-007's lesson) so pretty permalinks work immediately
 *      if this branch does end up registering fresh.
 *   2. Authenticated ACF read/write endpoint — same meta-vs-acf pattern as every prior module.
 *   3. [iep_resource_grid] shortcode — groups published resources under the 3 fixed categories
 *      already live on page 984. Deliberately does NOT implement email-gating enforcement (see
 *      Part 3 note) — the `gated` field is a flag for future wiring, not a working gate.
 *
 * SECURITY NOTE: the /iep-cms/v1/resource endpoints require a shared-secret header
 * (X-IEP-CMS-Key) — same pattern as every prior module, a distinct secret generated with
 * Python's `secrets.token_hex(32)`, not chosen or typed by hand, and not reused across modules.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// --- Part 1: adaptive CPT handling — retrofit if it exists, register fresh if it doesn't ---
add_action( 'init', function () {
	global $wp_post_types;
	if ( post_type_exists( 'cspt-resource' ) ) {
		$wp_post_types['cspt-resource']->show_in_rest          = true;
		$wp_post_types['cspt-resource']->rest_base             = 'resources-cpt';
		$wp_post_types['cspt-resource']->rest_controller_class = 'WP_REST_Posts_Controller';
	} else {
		register_post_type( 'cspt-resource', array(
			'label'        => 'Resources',
			'labels'       => array(
				'name'          => 'Resources',
				'singular_name' => 'Resource',
			),
			'public'       => true,
			'has_archive'  => 'resources',
			'rewrite'      => array( 'slug' => 'resource' ),
			'show_in_rest' => true,
			'rest_base'    => 'resources-cpt',
			'supports'     => array( 'title' ),
			'menu_icon'    => 'dashicons-media-document',
		) );
	}

	// Same rewrite-rule-cache lesson from CMS-007/008: flush once, guarded, whichever branch
	// above ran (retrofitting an existing type doesn't need this, but it's harmless).
	if ( ! get_option( 'iep_cspt_resource_flushed' ) ) {
		flush_rewrite_rules();
		update_option( 'iep_cspt_resource_flushed', 1 );
	}
}, 20 );

// --- Part 2: authenticated ACF read/write endpoint ---
define( 'IEP_CMS_RES_KEY', 'e378b908eb083033b828860fb3d0a860daa6d24afceacc6822b8e94a02088b5a' );

add_action( 'rest_api_init', function () {
	$auth_check = function ( WP_REST_Request $req ) {
		$sent = $req->get_header( 'x_iep_cms_key' );
		return is_string( $sent ) && hash_equals( IEP_CMS_RES_KEY, $sent );
	};

	$fields = array(
		'resource_category' => 'string',
		'summary'           => 'string',
		'gated'             => 'boolean',
		'display_order'     => 'integer',
	);

	register_rest_route( 'iep-cms/v1', '/resource/(?P<id>\d+)', array(
		array(
			'methods'             => 'GET',
			'permission_callback' => $auth_check,
			'callback'            => function ( WP_REST_Request $req ) use ( $fields ) {
				$id = (int) $req->get_param( 'id' );
				if ( get_post_type( $id ) !== 'cspt-resource' ) {
					return new WP_Error( 'not_found', 'Not a cspt-resource post', array( 'status' => 404 ) );
				}
				$out = array(
					'id'    => $id,
					'title' => get_the_title( $id ),
					'slug'  => get_post_field( 'post_name', $id ),
				);
				foreach ( array_keys( $fields ) as $f ) {
					$out[ $f ] = get_field( $f, $id );
				}
				$out['resource_file'] = get_field( 'resource_file', $id );
				return $out;
			},
		),
		array(
			'methods'             => 'POST',
			'permission_callback' => $auth_check,
			'callback'            => function ( WP_REST_Request $req ) use ( $fields ) {
				$id = (int) $req->get_param( 'id' );
				if ( get_post_type( $id ) !== 'cspt-resource' ) {
					return new WP_Error( 'not_found', 'Not a cspt-resource post', array( 'status' => 404 ) );
				}
				$result = array();
				foreach ( $fields as $f => $type ) {
					if ( $req->has_param( $f ) ) {
						$val = $req->get_param( $f );
						if ( $type === 'integer' && $val !== '' && $val !== null ) {
							$val = (int) $val;
						}
						if ( $type === 'boolean' ) {
							$val = (bool) $val;
						}
						$result[ $f ] = update_field( $f, $val, $id );
					}
				}
				if ( $req->has_param( 'resource_file' ) ) {
					$result['resource_file'] = update_field( 'resource_file', (int) $req->get_param( 'resource_file' ), $id );
				}
				if ( $req->has_param( 'title' ) ) {
					wp_update_post( array( 'ID' => $id, 'post_title' => sanitize_text_field( $req->get_param( 'title' ) ) ) );
					$result['title'] = true;
				}
				if ( $req->has_param( 'slug' ) ) {
					wp_update_post( array( 'ID' => $id, 'post_name' => sanitize_title( $req->get_param( 'slug' ) ) ) );
					$result['slug'] = true;
				}
				return array( 'id' => $id, 'updated' => $result );
			},
		),
	) );

	// Standard unpublish route, same surface as every prior module — not needed for any current
	// migration (this CPT starts with zero pre-existing posts to clean up), but kept for
	// consistency in case future population creates a duplicate/test record that needs removing.
	register_rest_route( 'iep-cms/v1', '/resource/(?P<id>\d+)/unpublish', array(
		'methods'             => 'POST',
		'permission_callback' => $auth_check,
		'callback'            => function ( WP_REST_Request $req ) {
			$id = (int) $req->get_param( 'id' );
			if ( get_post_type( $id ) !== 'cspt-resource' ) {
				return new WP_Error( 'not_found', 'Not a cspt-resource post', array( 'status' => 404 ) );
			}
			wp_update_post( array( 'ID' => $id, 'post_status' => 'draft' ) );
			return array( 'id' => $id, 'status' => 'draft' );
		},
	) );
} );

// --- Part 3: [iep_resource_grid] shortcode ---
// Groups published resources under the 3 fixed categories, matching page 984's existing card
// copy exactly. A resource with `gated` = true renders WITHOUT a working download link — this
// package does not implement email-gate enforcement (MC4WP wiring is an explicitly open decision
// per CRN-001), so exposing a raw file URL for a resource flagged "gated" would silently defeat
// the point of the flag. Ungated resources link directly to the file. This asymmetry is
// intentional, not a bug — see DECISIONS.md.
add_shortcode( 'iep_resource_grid', function ( $atts ) {
	$categories = array(
		'guides-whitepapers' => 'Guides & whitepapers',
		'tools-calculators'  => 'Tools & calculators',
		'funding-briefings'  => 'Funding briefings',
	);

	$q = new WP_Query( array(
		'post_type'      => 'cspt-resource',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'meta_key'       => 'display_order',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
	) );

	if ( ! $q->have_posts() ) {
		wp_reset_postdata();
		return '<!-- iep_resource_grid: no cspt-resource records found -->';
	}

	$grouped = array();
	foreach ( array_keys( $categories ) as $cat_key ) {
		$grouped[ $cat_key ] = array();
	}
	while ( $q->have_posts() ) {
		$q->the_post();
		$id  = get_the_ID();
		$cat = get_field( 'resource_category', $id );
		if ( isset( $grouped[ $cat ] ) ) {
			$grouped[ $cat ][] = $id;
		}
	}
	wp_reset_postdata();

	ob_start();
	?>
	<style>
	.iep-rg-wrap{max-width:1200px;margin:0 auto;}
	.iep-rg-cat{margin-bottom:56px;}
	.iep-rg-cat:last-child{margin-bottom:0;}
	.iep-rg-cat-title{font-family:Poppins,sans-serif;font-weight:700;color:#1E3D34;font-size:24px;margin:0 0 24px;}
	.iep-rg-items{display:flex;flex-wrap:wrap;gap:24px;}
	.iep-rg-card{flex:1 1 30%;min-width:260px;background:#fff;border:1px solid #E1E7E8;border-radius:6px;padding:28px 24px;display:flex;flex-direction:column;transition:transform .22s,box-shadow .22s,border-color .22s;}
	.iep-rg-card:hover{transform:translateY(-6px);box-shadow:0 20px 44px rgba(16,24,26,.10);border-color:#CFE0D4;}
	.iep-rg-title{font-weight:600;color:#1E3D34;font-size:17px;margin:0 0 8px;}
	.iep-rg-summary{color:#5C6B6E;font-size:15px;line-height:1.6;flex:1;margin-bottom:18px;}
	.iep-rg-link{align-self:flex-start;font-weight:600;color:#4C8B5A;text-decoration:none;font-size:14px;}
	.iep-rg-link:hover{color:#3D7049;}
	.iep-rg-gated-note{align-self:flex-start;font-size:13px;color:#8A9497;font-style:italic;}
	</style>
	<div class="iep-rg-wrap">
		<?php foreach ( $categories as $cat_key => $cat_label ) :
			$items = $grouped[ $cat_key ];
			if ( empty( $items ) ) {
				continue;
			}
			?>
			<div class="iep-rg-cat">
				<h3 class="iep-rg-cat-title"><?php echo esc_html( $cat_label ); ?></h3>
				<div class="iep-rg-items">
					<?php foreach ( $items as $id ) :
						$title   = get_the_title( $id );
						$summary = get_field( 'summary', $id );
						$gated   = (bool) get_field( 'gated', $id );
						$file    = get_field( 'resource_file', $id );
						?>
						<div class="iep-rg-card">
							<div class="iep-rg-title"><?php echo esc_html( $title ); ?></div>
							<?php if ( $summary ) : ?>
								<div class="iep-rg-summary"><?php echo esc_html( $summary ); ?></div>
							<?php endif; ?>
							<?php if ( $gated ) : ?>
								<span class="iep-rg-gated-note">Registration required — coming soon</span>
							<?php elseif ( $file && ! empty( $file['url'] ) ) : ?>
								<a class="iep-rg-link" href="<?php echo esc_url( $file['url'] ); ?>" target="_blank" rel="noopener">Download &rarr;</a>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
	return ob_get_clean();
} );
