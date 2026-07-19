<?php
/**
 * CMS-006 — Case Studies Module: Code Snippet
 * Install as a new snippet in Code Snippets (Snippets → Add New), "Run snippet everywhere",
 * Activate. Requires the "Case Study Details" ACF field group (acf-json/group_case_study_fields.json)
 * already imported.
 *
 * Repurposes the existing cspt-portfolio CPT (Greenly theme's built-in Portfolio type — currently
 * live at /portfolio/ with 12 unrelated Envato demo entries: solar panels, wind projects, stock
 * Lorem Ipsum) as Case Studies, rather than registering a new cspt-case-study CPT. This follows a
 * real, in-content finding: the live Case Studies page (978) itself contains a developer note —
 * "Individual case-study detail pages to be built as Greenly portfolio (cspt-portfolio) entries" —
 * so the target CPT was already decided before this session, just not yet acted on. See DECISIONS.md.
 *
 * Five parts, same structure as CMS-002's team-helper-functions.php:
 *   1. Retrofits show_in_rest onto cspt-portfolio (closes the original REST blocker, same
 *      technique as CMS-002 Part 1).
 *   2. Retrofits show_in_rest onto the portfolio-category taxonomy (same technique as CMS-005A's
 *      service_category registration, but retrofitting an existing theme-registered taxonomy
 *      rather than registering a new one).
 *   3. Authenticated ACF read/write endpoint — same meta-vs-acf REST key mismatch documented in
 *      CMS-002 applies to every ACF-backed CPT on this site, not just cspt-team-member; reusing
 *      the proven fix rather than re-discovering it.
 *   4. [iep_case_study_grid] shortcode — optional dynamic replacement for the 6 hardcoded
 *      icon-box cards on page 978 (that swap stays the user's call, same as [iep_team_grid]).
 *   5. [iep_case_study_single] shortcode — individual /portfolio/{slug}/ page layout, replacing
 *      the demo template's irrelevant Date/Client/Address fields (see DECISIONS.md) with
 *      Challenge/Solution/Results/Commercial Impact.
 *
 * SECURITY NOTE: the /iep-cms/v1/case-study endpoints require a shared-secret header
 * (X-IEP-CMS-Key) — same pattern as CMS-002, a distinct secret generated with Python's
 * `secrets.token_hex(32)` (equivalent entropy to CMS-002's `openssl rand -hex 32`), not chosen
 * or typed by hand, and not reused across modules.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// --- Part 1: retrofit REST support onto the existing cspt-portfolio CPT ---
add_action( 'init', function () {
	global $wp_post_types;
	if ( isset( $wp_post_types['cspt-portfolio'] ) ) {
		$wp_post_types['cspt-portfolio']->show_in_rest          = true;
		$wp_post_types['cspt-portfolio']->rest_base             = 'case-studies';
		$wp_post_types['cspt-portfolio']->rest_controller_class = 'WP_REST_Posts_Controller';
	}
}, 20 );

// --- Part 2: retrofit REST support onto cspt-portfolio's real category taxonomy ---
// The front-end URL (/portfolio-category/{term}/) is only the taxonomy's rewrite slug, not
// guaranteed to match its actual registered key -- confirmed live: hardcoding "portfolio-category"
// as the key produced "Invalid taxonomy" from get_object_taxonomies(). Discovered dynamically
// instead: any taxonomy registered against cspt-portfolio whose key contains "portfolio" is
// treated as the real one, and its actual key is recorded in an option so the endpoint below can
// use it without hardcoding a guess.
add_action( 'init', function () {
	global $wp_taxonomies;
	foreach ( get_object_taxonomies( 'cspt-portfolio' ) as $tax_slug ) {
		if ( strpos( $tax_slug, 'portfolio' ) !== false && isset( $wp_taxonomies[ $tax_slug ] ) ) {
			$wp_taxonomies[ $tax_slug ]->show_in_rest          = true;
			$wp_taxonomies[ $tax_slug ]->rest_base             = 'case-study-sectors';
			$wp_taxonomies[ $tax_slug ]->rest_controller_class = 'WP_REST_Terms_Controller';
			update_option( 'iep_cs_sector_taxonomy_key', $tax_slug );
		}
	}
}, 20 );

// --- Part 3: authenticated ACF read/write endpoint ---
define( 'IEP_CMS_CS_KEY', 'ec19b4ce8ba00feaac05f740daf5e5d17a03cd9c2d7dd3eec31ee18390cdf382' );

add_action( 'rest_api_init', function () {
	$auth_check = function ( WP_REST_Request $req ) {
		$sent = $req->get_header( 'x_iep_cms_key' );
		return is_string( $sent ) && hash_equals( IEP_CMS_CS_KEY, $sent );
	};

	$fields = array(
		'icon'               => 'array',
		'summary_snapshot'   => 'string',
		'challenge'          => 'string',
		'solution'           => 'string',
		'results'            => 'string',
		'commercial_impact'  => 'string',
		'display_order'      => 'integer',
	);

	register_rest_route( 'iep-cms/v1', '/case-study/(?P<id>\d+)', array(
		array(
			'methods'             => 'GET',
			'permission_callback' => $auth_check,
			'callback'            => function ( WP_REST_Request $req ) use ( $fields ) {
				$id = (int) $req->get_param( 'id' );
				if ( get_post_type( $id ) !== 'cspt-portfolio' ) {
					return new WP_Error( 'not_found', 'Not a cspt-portfolio post', array( 'status' => 404 ) );
				}
				$tax_key = get_option( 'iep_cs_sector_taxonomy_key' );
				$out     = array(
					'id'      => $id,
					'title'   => get_the_title( $id ),
					'slug'    => get_post_field( 'post_name', $id ),
					'sectors' => $tax_key ? wp_get_post_terms( $id, $tax_key, array( 'fields' => 'names' ) ) : array(),
				);
				foreach ( array_keys( $fields ) as $f ) {
					$out[ $f ] = get_field( $f, $id );
				}
				return $out;
			},
		),
		array(
			'methods'             => 'POST',
			'permission_callback' => $auth_check,
			'callback'            => function ( WP_REST_Request $req ) use ( $fields ) {
				$id = (int) $req->get_param( 'id' );
				if ( get_post_type( $id ) !== 'cspt-portfolio' ) {
					return new WP_Error( 'not_found', 'Not a cspt-portfolio post', array( 'status' => 404 ) );
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
				// Title, slug, sector and featured image are native WP fields, not ACF — handled
				// separately from the ACF fields loop above, same separation CMS-002 used.
				if ( $req->has_param( 'title' ) ) {
					wp_update_post( array( 'ID' => $id, 'post_title' => sanitize_text_field( $req->get_param( 'title' ) ) ) );
					$result['title'] = true;
				}
				if ( $req->has_param( 'slug' ) ) {
					wp_update_post( array( 'ID' => $id, 'post_name' => sanitize_title( $req->get_param( 'slug' ) ) ) );
					$result['slug'] = true;
				}
				if ( $req->has_param( 'sector' ) ) {
					$tax_key = get_option( 'iep_cs_sector_taxonomy_key' );
					if ( $tax_key ) {
						// Must be a real PHP int, not a numeric string -- wp_set_object_terms()
						// only treats is_int() values as term IDs; a numeric string like "39"
						// fails is_int() and is treated as a term NAME/SLUG search instead,
						// silently creating a bogus new term named "39" if none exists.
						// Confirmed live: this created 3 junk terms (named "38"/"39"/"40") on
						// first deployment before this cast was added.
						$result['sector'] = wp_set_object_terms( $id, (int) $req->get_param( 'sector' ), $tax_key, false );
					} else {
						$result['sector'] = new WP_Error( 'no_taxonomy', 'Sector taxonomy key not yet discovered — has Part 2 run at least once since this snippet was activated?' );
					}
				}
				// Demo posts carry mismatched Envato stock photos (solar panels) irrelevant to
				// real case studies — cleared here rather than kept, same reasoning as CMS-002's
				// featured_media handling (see DECISIONS.md).
				if ( $req->has_param( 'featured_media' ) ) {
					$fm = (int) $req->get_param( 'featured_media' );
					$result['featured_media'] = $fm ? set_post_thumbnail( $id, $fm ) : delete_post_thumbnail( $id );
				}
				return array( 'id' => $id, 'updated' => $result );
			},
		),
	) );

	// Points a case-study post's single-page rendering at [iep_case_study_single] instead of
	// whatever demo layout it currently carries (WPBakery shortcode markup in post_content, per
	// this CPT's live template — confirmed not to be Elementor-authored, so no _elementor_data
	// override was found for this CPT; see IMPLEMENTATION-GUIDE.md's verification step, which
	// re-checks this per-post rather than assuming it, per the reusable lesson from CMS-002 v1.4).
	register_rest_route( 'iep-cms/v1', '/case-study/(?P<id>\d+)/use-single-shortcode', array(
		'methods'             => 'POST',
		'permission_callback' => $auth_check,
		'callback'            => function ( WP_REST_Request $req ) {
			$id = (int) $req->get_param( 'id' );
			if ( get_post_type( $id ) !== 'cspt-portfolio' ) {
				return new WP_Error( 'not_found', 'Not a cspt-portfolio post', array( 'status' => 404 ) );
			}
			wp_update_post( array( 'ID' => $id, 'post_content' => '[iep_case_study_single]' ) );
			delete_post_meta( $id, '_elementor_edit_mode' );
			return array( 'id' => $id, 'done' => true );
		},
	) );

	// Temporary diagnostic — the front-end URL /portfolio-category/{term}/ is the taxonomy's
	// rewrite slug, which is not guaranteed to match its actual registered taxonomy key. Part 2
	// above guessed "portfolio-category" and get_object_taxonomies() came back "Invalid
	// taxonomy" when tested, confirming the guess was wrong. This route reports every taxonomy
	// actually registered against cspt-portfolio so Part 2 can be corrected with the real key.
	// Safe to leave in place after diagnosis (read-only, behind the same auth check).
	register_rest_route( 'iep-cms/v1', '/debug/portfolio-taxonomies', array(
		'methods'             => 'GET',
		'permission_callback' => $auth_check,
		'callback'            => function () {
			return array( 'taxonomies' => get_object_taxonomies( 'cspt-portfolio', 'names' ) );
		},
	) );

	// Temporary diagnostic — the [iep_case_study_single] shortcode's sector display is printing
	// the raw term ID ("39") instead of the term name ("Manufacturing") despite requesting
	// 'fields' => 'names', even though wp_get_term() independently confirms term 39's name is
	// correct. This isolates whether wp_get_post_terms() itself is misbehaving for this
	// dynamically-retrofitted taxonomy, or whether the bug is in the shortcode's own code.
	register_rest_route( 'iep-cms/v1', '/debug/sector-terms/(?P<id>\d+)', array(
		'methods'             => 'GET',
		'permission_callback' => $auth_check,
		'callback'            => function ( WP_REST_Request $req ) {
			$id      = (int) $req->get_param( 'id' );
			$tax_key = get_option( 'iep_cs_sector_taxonomy_key' );
			$names   = wp_get_post_terms( $id, $tax_key, array( 'fields' => 'names' ) );
			$all     = wp_get_post_terms( $id, $tax_key, array( 'fields' => 'all' ) );
			return array(
				'tax_key'    => $tax_key,
				'names_call' => $names,
				'all_call'   => array_map( function ( $t ) {
					return array( 'term_id' => $t->term_id, 'name' => $t->name, 'slug' => $t->slug );
				}, is_array( $all ) ? $all : array() ),
			);
		},
	) );

	// Bulk unpublish helper for the 6 surplus demo posts not being migrated to real content
	// (12 demo posts exist, only 6 real case studies exist to replace them — see DECISIONS.md).
	// Moves to draft, not trash/delete, so it stays reversible without a separate rollback step.
	register_rest_route( 'iep-cms/v1', '/case-study/(?P<id>\d+)/unpublish', array(
		'methods'             => 'POST',
		'permission_callback' => $auth_check,
		'callback'            => function ( WP_REST_Request $req ) {
			$id = (int) $req->get_param( 'id' );
			if ( get_post_type( $id ) !== 'cspt-portfolio' ) {
				return new WP_Error( 'not_found', 'Not a cspt-portfolio post', array( 'status' => 404 ) );
			}
			wp_update_post( array( 'ID' => $id, 'post_status' => 'draft' ) );
			return array( 'id' => $id, 'status' => 'draft' );
		},
	) );
} );

// --- Part 3b: bypass the theme's hardcoded single-cspt-portfolio.php template ---
// New finding, different from CMS-002's Elementor-override issue: this CPT's single-post
// template renders a hardcoded "About the project" Date/Client/Category/Address box (plus a
// broken raw-term-ID "Category" display) directly in PHP, unconditionally, before the_content()
// -- confirmed live: it persisted even after post_content was fully replaced with
// [iep_case_study_single], proving it isn't coming from post_content/Elementor at all. Setting
// post_content alone (Part 3's use-single-shortcode route) cannot remove it. Short-circuiting
// template selection for this CPT's singular view is the fix -- keeps the theme's normal
// header/footer chrome, but replaces the template's own hardcoded body markup with the post's
// real content (the shortcode already in post_content). Applies to the whole CPT, not just the
// 6 migrated posts -- harmless for the 6 draft surplus posts, which aren't publicly reachable.
add_action( 'template_redirect', function () {
	if ( ! is_singular( 'cspt-portfolio' ) ) {
		return;
	}
	get_header();
	while ( have_posts() ) {
		the_post();
		echo apply_filters( 'the_content', get_the_content() );
	}
	get_footer();
	exit;
}, 5 );

// --- Part 4: [iep_case_study_grid] shortcode ---
add_shortcode( 'iep_case_study_grid', function ( $atts ) {
	$atts = shortcode_atts( array(
		'sector' => '', // '' = all sectors
	), $atts, 'iep_case_study_grid' );

	$query_args = array(
		'post_type'      => 'cspt-portfolio',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'meta_key'       => 'display_order',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
	);
	$tax_key = get_option( 'iep_cs_sector_taxonomy_key' );
	if ( $atts['sector'] !== '' && $tax_key ) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => $tax_key,
				'field'    => 'slug',
				'terms'    => $atts['sector'],
			),
		);
	}

	$q = new WP_Query( $query_args );
	if ( ! $q->have_posts() ) {
		return '<!-- iep_case_study_grid: no cspt-portfolio records found -->';
	}

	ob_start();
	?>
	<style>
	.iep-cs-grid-wrap{max-width:1200px;margin:0 auto;display:flex;flex-wrap:wrap;gap:24px;}
	.iep-cs-card{flex:1 1 30%;min-width:260px;background:#fff;border:1px solid #E1E7E8;border-radius:6px;padding:32px 26px;transition:transform .22s,box-shadow .22s,border-color .22s;}
	.iep-cs-card:hover{transform:translateY(-6px);box-shadow:0 20px 44px rgba(16,24,26,.10);border-color:#CFE0D4;}
	.iep-cs-icon{color:#4C8B5A;font-size:44px;line-height:1;margin-bottom:18px;}
	.iep-cs-title{color:#1E3D34;font-weight:700;font-size:18px;margin:0 0 10px;}
	.iep-cs-summary{color:#5C6B6E;font-size:15px;line-height:1.6;margin:0;}
	.iep-cs-link{display:inline-block;margin-top:14px;font-size:13px;color:#4C8B5A;font-weight:600;text-decoration:none;}
	.iep-cs-link:hover{text-decoration:underline;}
	</style>
	<div class="iep-cs-grid-wrap">
		<?php while ( $q->have_posts() ) : $q->the_post();
			$id      = get_the_ID();
			$icon    = get_field( 'icon', $id );
			$summary = get_field( 'summary_snapshot', $id );
			?>
			<div class="iep-cs-card">
				<?php if ( ! empty( $icon['value'] ) ) : ?>
					<div class="iep-cs-icon"><i class="<?php echo esc_attr( $icon['value'] ); ?>" aria-hidden="true"></i></div>
				<?php endif; ?>
				<div class="iep-cs-title"><?php the_title(); ?></div>
				<?php if ( $summary ) : ?>
					<p class="iep-cs-summary"><?php echo esc_html( $summary ); ?></p>
				<?php endif; ?>
				<a class="iep-cs-link" href="<?php the_permalink(); ?>">Read more &rarr;</a>
			</div>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
	<?php
	return ob_get_clean();
} );

// --- Part 5: [iep_case_study_single] shortcode — individual case-study page layout ---
add_shortcode( 'iep_case_study_single', function () {
	$id = get_the_ID();
	if ( get_post_type( $id ) !== 'cspt-portfolio' ) {
		return '';
	}
	$title    = get_the_title( $id );
	$icon     = get_field( 'icon', $id );
	$tax_key  = get_option( 'iep_cs_sector_taxonomy_key' );
	$sectors  = $tax_key ? wp_get_post_terms( $id, $tax_key, array( 'fields' => 'names' ) ) : array();
	$summary  = get_field( 'summary_snapshot', $id );
	$challenge = get_field( 'challenge', $id );
	$solution  = get_field( 'solution', $id );
	$results   = get_field( 'results', $id );
	$impact    = get_field( 'commercial_impact', $id );

	$result_lines = $results ? array_filter( array_map( 'trim', explode( "\n", $results ) ) ) : array();

	ob_start();
	?>
	<style>
	.iep-css-wrap{max-width:820px;margin:0 auto;padding:56px 24px;}
	.iep-css-back{display:inline-flex;align-items:center;gap:6px;font-size:14px;color:#4C8B5A;text-decoration:none;margin-bottom:36px;font-weight:600;}
	.iep-css-back:hover{text-decoration:underline;}
	.iep-css-icon{color:#4C8B5A;font-size:48px;line-height:1;margin-bottom:18px;}
	.iep-css-title{font-family:'Archivo',Poppins,sans-serif;font-weight:700;font-size:32px;color:#1E3D34;margin:0 0 10px;}
	.iep-css-sectors{color:#4C8B5A;font-weight:600;font-size:14px;margin-bottom:24px;text-transform:uppercase;letter-spacing:1px;}
	.iep-css-summary{color:#2D3436;font-size:19px;line-height:1.6;margin-bottom:40px;padding-bottom:40px;border-bottom:1px solid #E1E7E8;}
	.iep-css-section{margin-bottom:32px;}
	.iep-css-section h3{color:#1E3D34;font-family:Poppins,sans-serif;font-size:20px;margin:0 0 10px;}
	.iep-css-section p{color:#5C6B6E;font-size:16px;line-height:1.7;margin:0;}
	.iep-css-section ul{margin:0;padding-left:20px;color:#5C6B6E;font-size:16px;line-height:1.8;}
	.iep-css-impact{background:#101A18;color:#FFFFFF;border-radius:6px;padding:26px 30px;font-size:18px;font-weight:600;margin-top:40px;}
	</style>
	<div class="iep-css-wrap">
		<a class="iep-css-back" href="<?php echo esc_url( home_url( '/case-studies/' ) ); ?>">&larr; Back to Case Studies</a>
		<?php if ( ! empty( $icon['value'] ) ) : ?>
			<div class="iep-css-icon"><i class="<?php echo esc_attr( $icon['value'] ); ?>" aria-hidden="true"></i></div>
		<?php endif; ?>
		<div class="iep-css-title"><?php echo esc_html( $title ); ?></div>
		<?php if ( $sectors ) : ?>
			<div class="iep-css-sectors"><?php echo esc_html( implode( ' · ', $sectors ) ); ?></div>
		<?php endif; ?>
		<?php if ( $summary ) : ?>
			<div class="iep-css-summary"><?php echo esc_html( $summary ); ?></div>
		<?php endif; ?>
		<?php if ( $challenge ) : ?>
			<div class="iep-css-section"><h3>Challenge</h3><p><?php echo esc_html( $challenge ); ?></p></div>
		<?php endif; ?>
		<?php if ( $solution ) : ?>
			<div class="iep-css-section"><h3>Solution</h3><p><?php echo esc_html( $solution ); ?></p></div>
		<?php endif; ?>
		<?php if ( $result_lines ) : ?>
			<div class="iep-css-section"><h3>Results</h3><ul>
				<?php foreach ( $result_lines as $line ) : ?>
					<li><?php echo esc_html( $line ); ?></li>
				<?php endforeach; ?>
			</ul></div>
		<?php endif; ?>
		<?php if ( $impact ) : ?>
			<div class="iep-css-impact">Commercial Impact: <?php echo esc_html( $impact ); ?></div>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
} );
