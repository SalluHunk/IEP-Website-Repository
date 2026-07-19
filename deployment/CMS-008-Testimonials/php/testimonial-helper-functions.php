<?php
/**
 * CMS-008 — Testimonials Module: Code Snippet
 * Install as a new snippet in Code Snippets (Snippets → Add New), "Run snippet everywhere",
 * Activate. Requires the "Testimonial Details" ACF field group
 * (acf-json/group_testimonial_fields.json) already imported.
 *
 * Grid/wall display only — no individual detail pages. Mission Control's explicit choice this
 * round (unlike Case Studies and Industries): testimonials are a wall of quotes, not standalone
 * reading pages, and nothing in any source implies visitors need one per testimonial.
 *
 * ADAPTIVE CPT HANDLING (new pattern, worth reusing for any future module): this site's own
 * wp-admin sidebar already shows a "Testimonials" menu item, strongly suggesting a
 * `cspt-testimonial` CPT is already registered by the theme (matching the cspt-team-member /
 * cspt-service / cspt-portfolio precedent) — but this was never independently confirmed via
 * REST before writing this file (CMS-006 already learned once that a guessed CPT slug for
 * "Case Studies" was wrong). Rather than guess and risk a second wrong assumption, Part 1 below
 * checks post_type_exists() at runtime and does the right thing either way: retrofits REST
 * support onto the type if it already exists, or registers it fresh if it doesn't. No assumption
 * baked into the deployment itself.
 *
 * Three parts:
 *   1. Adaptive CPT handling (retrofit or fresh-register), REST-visible either way.
 *   2. Authenticated ACF read/write endpoint — same meta-vs-acf pattern as every prior module.
 *   3. [iep_testimonial_grid] shortcode — preserves the exact initials-avatar fallback behaviour
 *      already live (2-letter initials shown when no real photo exists, not a placeholder image).
 *
 * SECURITY NOTE: the /iep-cms/v1/testimonial endpoints require a shared-secret header
 * (X-IEP-CMS-Key) — same pattern as every prior module, a distinct secret generated with
 * Python's `secrets.token_hex(32)`, not chosen or typed by hand, and not reused across modules.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// --- Part 1: adaptive CPT handling — retrofit if it exists, register fresh if it doesn't ---
add_action( 'init', function () {
	global $wp_post_types;
	if ( post_type_exists( 'cspt-testimonial' ) ) {
		$wp_post_types['cspt-testimonial']->show_in_rest          = true;
		$wp_post_types['cspt-testimonial']->rest_base             = 'testimonials-cpt';
		$wp_post_types['cspt-testimonial']->rest_controller_class = 'WP_REST_Posts_Controller';
	} else {
		register_post_type( 'cspt-testimonial', array(
			'label'        => 'Testimonials',
			'labels'       => array(
				'name'          => 'Testimonials',
				'singular_name' => 'Testimonial',
			),
			'public'       => true,
			'has_archive'  => 'testimonial',
			'rewrite'      => array( 'slug' => 'testimonial' ),
			'show_in_rest' => true,
			'rest_base'    => 'testimonials-cpt',
			'supports'     => array( 'title', 'thumbnail' ),
			'menu_icon'    => 'dashicons-format-quote',
		) );
	}

	// Same rewrite-rule-cache lesson from CMS-007: flush once, guarded, whichever branch above ran
	// (retrofitting an existing type doesn't need this, but it's harmless and keeps this file
	// correct without needing to know in advance which branch will fire on this site).
	if ( ! get_option( 'iep_cspt_testimonial_flushed' ) ) {
		flush_rewrite_rules();
		update_option( 'iep_cspt_testimonial_flushed', 1 );
	}
}, 20 );

// --- Part 2: authenticated ACF read/write endpoint ---
define( 'IEP_CMS_TS_KEY', 'aad854e4ace848a6771d93f22338d46c79184f3e3976da5d4d1e1d98f44a0e49' );

add_action( 'rest_api_init', function () {
	$auth_check = function ( WP_REST_Request $req ) {
		$sent = $req->get_header( 'x_iep_cms_key' );
		return is_string( $sent ) && hash_equals( IEP_CMS_TS_KEY, $sent );
	};

	$fields = array(
		'quote'         => 'string',
		'person_name'   => 'string',
		'person_role'   => 'string',
		'display_order' => 'integer',
	);

	register_rest_route( 'iep-cms/v1', '/testimonial/(?P<id>\d+)', array(
		array(
			'methods'             => 'GET',
			'permission_callback' => $auth_check,
			'callback'            => function ( WP_REST_Request $req ) use ( $fields ) {
				$id = (int) $req->get_param( 'id' );
				if ( get_post_type( $id ) !== 'cspt-testimonial' ) {
					return new WP_Error( 'not_found', 'Not a cspt-testimonial post', array( 'status' => 404 ) );
				}
				$out = array(
					'id'    => $id,
					'title' => get_the_title( $id ),
					'slug'  => get_post_field( 'post_name', $id ),
				);
				foreach ( array_keys( $fields ) as $f ) {
					$out[ $f ] = get_field( $f, $id );
				}
				$out['company_logo']  = get_field( 'company_logo', $id );
				$out['person_photo']  = get_field( 'person_photo', $id );
				return $out;
			},
		),
		array(
			'methods'             => 'POST',
			'permission_callback' => $auth_check,
			'callback'            => function ( WP_REST_Request $req ) use ( $fields ) {
				$id = (int) $req->get_param( 'id' );
				if ( get_post_type( $id ) !== 'cspt-testimonial' ) {
					return new WP_Error( 'not_found', 'Not a cspt-testimonial post', array( 'status' => 404 ) );
				}
				$result = array();
				foreach ( $fields as $f => $type ) {
					if ( $req->has_param( $f ) ) {
						$val = $req->get_param( $f );
						if ( $type === 'integer' && $val !== '' && $val !== null ) {
							$val = (int) $val;
						}
						$result[ $f ] = update_field( $f, $val, $id );
					}
				}
				if ( $req->has_param( 'company_logo' ) ) {
					$result['company_logo'] = update_field( 'company_logo', (int) $req->get_param( 'company_logo' ), $id );
				}
				if ( $req->has_param( 'person_photo' ) ) {
					$result['person_photo'] = update_field( 'person_photo', (int) $req->get_param( 'person_photo' ), $id );
				}
				if ( $req->has_param( 'title' ) ) {
					wp_update_post( array( 'ID' => $id, 'post_title' => sanitize_text_field( $req->get_param( 'title' ) ) ) );
					$result['title'] = true;
				}
				if ( $req->has_param( 'slug' ) ) {
					wp_update_post( array( 'ID' => $id, 'post_name' => sanitize_title( $req->get_param( 'slug' ) ) ) );
					$result['slug'] = true;
				}
				// This CPT belongs to the Ultimate Addons for Elementor plugin, which has its own
				// native wp-admin edit screen (title + block editor content + featured image),
				// entirely separate from the ACF fields above. [iep_testimonial_grid] only reads
				// the ACF fields, so the front end was already correct -- but the plugin's own
				// demo content (dummy post_content, dummy stock-photo featured image) was left
				// untouched, making the edit screen itself confusing/misleading. Synced here so
				// both layers agree, not just the one the shortcode actually uses.
				if ( $req->has_param( 'content' ) ) {
					wp_update_post( array( 'ID' => $id, 'post_content' => wp_kses_post( $req->get_param( 'content' ) ) ) );
					$result['content'] = true;
				}
				if ( $req->has_param( 'featured_media' ) ) {
					$fm = (int) $req->get_param( 'featured_media' );
					$result['featured_media'] = $fm ? set_post_thumbnail( $id, $fm ) : delete_post_thumbnail( $id );
				}
				return array( 'id' => $id, 'updated' => $result );
			},
		),
	) );

	// Temporary diagnostic — the ACF "Testimonial Details" field group isn't appearing as a
	// meta box on the post edit screen at all, even though get_field()/update_field() work
	// correctly (proven by the population step succeeding). Those two facts aren't the same
	// thing: ACF's data functions can work by field name independent of whether a field group's
	// *location rule* actually matches for admin-UI purposes. This checks ACF's own field-group
	// matching directly rather than guessing why the box is missing.
	register_rest_route( 'iep-cms/v1', '/debug/acf-field-groups/(?P<id>\d+)', array(
		'methods'             => 'GET',
		'permission_callback' => $auth_check,
		'callback'            => function ( WP_REST_Request $req ) {
			$id = (int) $req->get_param( 'id' );
			$out = array(
				'post_type'       => get_post_type( $id ),
				'acf_pro_active'  => function_exists( 'acf_get_field_groups' ),
			);
			if ( function_exists( 'acf_get_field_groups' ) ) {
				$groups = acf_get_field_groups( array( 'post_id' => $id ) );
				$out['matched_field_groups'] = array();
				foreach ( $groups as $group ) {
					$fields = function_exists( 'acf_get_fields' ) ? acf_get_fields( $group ) : array();
					$out['matched_field_groups'][] = array(
						'key'    => $group['key'],
						'title'  => $group['title'],
						'local'  => isset( $group['local'] ) ? $group['local'] : null,
						'active' => $group['active'],
						'fields' => array_map( function ( $f ) {
							return array( 'name' => $f['name'], 'label' => $f['label'], 'type' => $f['type'] );
						}, $fields ),
					);
				}
			}
			return $out;
		},
	) );

	// Bulk unpublish helper for surplus demo posts not being migrated to real content (5 demo
	// slots exist, only 4 real testimonials to replace them — see DECISIONS.md). Moves to draft,
	// not trash/delete, so it stays reversible without a separate rollback step.
	register_rest_route( 'iep-cms/v1', '/testimonial/(?P<id>\d+)/unpublish', array(
		'methods'             => 'POST',
		'permission_callback' => $auth_check,
		'callback'            => function ( WP_REST_Request $req ) {
			$id = (int) $req->get_param( 'id' );
			if ( get_post_type( $id ) !== 'cspt-testimonial' ) {
				return new WP_Error( 'not_found', 'Not a cspt-testimonial post', array( 'status' => 404 ) );
			}
			wp_update_post( array( 'ID' => $id, 'post_status' => 'draft' ) );
			return array( 'id' => $id, 'status' => 'draft' );
		},
	) );
} );

// --- Part 3: [iep_testimonial_grid] shortcode ---
add_shortcode( 'iep_testimonial_grid', function ( $atts ) {
	$q = new WP_Query( array(
		'post_type'      => 'cspt-testimonial',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'meta_key'       => 'display_order',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
	) );
	if ( ! $q->have_posts() ) {
		return '<!-- iep_testimonial_grid: no cspt-testimonial records found -->';
	}

	ob_start();
	?>
	<style>
	.iep-tg-wrap{max-width:1200px;margin:0 auto;display:flex;flex-wrap:wrap;gap:32px;}
	.iep-tg-card{flex:1 1 45%;min-width:280px;background:#fff;border:1px solid #E1E7E8;border-radius:6px;padding:40px 36px;display:flex;flex-direction:column;transition:transform .22s,box-shadow .22s,border-color .22s;}
	.iep-tg-card:hover{transform:translateY(-6px);box-shadow:0 20px 44px rgba(16,24,26,.10);border-color:#CFE0D4;}
	.iep-tg-logo{max-height:34px;max-width:160px;width:auto;object-fit:contain;margin-bottom:26px;}
	.iep-tg-quote{font-family:Georgia,serif;font-style:italic;font-size:17px;line-height:1.65;color:#2D3436;flex:1;margin-bottom:26px;}
	.iep-tg-quote p{margin:0 0 14px;}
	.iep-tg-quote p:last-child{margin-bottom:0;}
	.iep-tg-person{display:flex;align-items:center;gap:14px;border-top:1px solid #E1E7E8;padding-top:20px;}
	.iep-tg-avatar{width:48px;height:48px;border-radius:50%;object-fit:cover;flex-shrink:0;}
	.iep-tg-avatar.iep-tg-initial{display:flex;align-items:center;justify-content:center;background:#4C8B5A;color:#fff;font-weight:700;font-family:Poppins,sans-serif;font-size:17px;}
	.iep-tg-name{font-weight:600;color:#1E3D34;font-size:16px;}
	.iep-tg-role{color:#5C6B6E;font-size:14px;margin-top:2px;}
	</style>
	<div class="iep-tg-wrap">
		<?php while ( $q->have_posts() ) : $q->the_post();
			$id           = get_the_ID();
			$company      = get_the_title( $id );
			$logo_id      = get_field( 'company_logo', $id );
			$quote        = get_field( 'quote', $id );
			$person_name  = get_field( 'person_name', $id );
			$person_role  = get_field( 'person_role', $id );
			$photo_id     = get_field( 'person_photo', $id );

			$initials = '';
			if ( $person_name ) {
				$parts = preg_split( '/\s+/', trim( $person_name ) );
				foreach ( array_slice( $parts, 0, 2 ) as $p ) {
					$initials .= mb_substr( $p, 0, 1 );
				}
				$initials = mb_strtoupper( $initials );
			}
			?>
			<div class="iep-tg-card">
				<?php if ( $logo_id ) : ?>
					<?php echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'class' => 'iep-tg-logo', 'alt' => esc_attr( $company . ' logo' ) ) ); ?>
				<?php endif; ?>
				<?php if ( $quote ) : ?>
					<div class="iep-tg-quote"><?php echo wp_kses_post( $quote ); ?></div>
				<?php endif; ?>
				<div class="iep-tg-person">
					<?php if ( $photo_id ) : ?>
						<?php echo wp_get_attachment_image( $photo_id, 'thumbnail', false, array( 'class' => 'iep-tg-avatar', 'alt' => esc_attr( $person_name ) ) ); ?>
					<?php else : ?>
						<div class="iep-tg-avatar iep-tg-initial"><?php echo esc_html( $initials ); ?></div>
					<?php endif; ?>
					<?php
					$role_line = trim( (string) $person_role );
					if ( $company !== '' ) {
						$role_line = $role_line !== '' ? $role_line . ' · ' . $company : $company;
					}
					?>
					<div>
						<div class="iep-tg-name"><?php echo esc_html( $person_name ); ?></div>
						<div class="iep-tg-role"><?php echo esc_html( $role_line ); ?></div>
					</div>
				</div>
			</div>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
	<?php
	return ob_get_clean();
} );
