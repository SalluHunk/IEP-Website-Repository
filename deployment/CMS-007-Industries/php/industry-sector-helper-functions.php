<?php
/**
 * CMS-007 — Industries Module: Code Snippet
 * Install as a new snippet in Code Snippets (Snippets → Add New), "Run snippet everywhere",
 * Activate. Requires the "Industry Sector Details" ACF field group
 * (acf-json/group_industry_sector_fields.json) already imported.
 *
 * Registers a brand-new cspt-industry-sector CPT — unlike CMS-002 (Leadership) and CMS-006
 * (Case Studies), no pre-existing Greenly demo CPT covers Industries; confirmed by testing
 * /industry/, /sector/, /sectors/ (all 404) before writing this file. show_in_rest is set true
 * from registration (no retrofit needed, unlike the other modules).
 *
 * Four parts:
 *   1. Registers cspt-industry-sector, REST-visible from the start.
 *   2. Authenticated ACF read/write endpoint — same meta-vs-acf pattern as CMS-002/CMS-006.
 *   3. [iep_industry_grid] shortcode — optional dynamic replacement for the 8 hardcoded
 *      icon-box cards on page 971 (swap stays the user's call, same as other modules).
 *   4. [iep_industry_single] shortcode + a template_redirect bypass — applied preemptively
 *      this time (CMS-006 discovered mid-deployment that a fresh CPT gets no default single
 *      template worth using; safer to bypass to the shortcode from the start than assume the
 *      theme's generic single.php is adequate).
 *
 * SECURITY NOTE: the /iep-cms/v1/industry-sector endpoints require a shared-secret header
 * (X-IEP-CMS-Key) — same pattern as CMS-002/CMS-006, a distinct secret generated with Python's
 * `secrets.token_hex(32)`, not chosen or typed by hand, and not reused across modules.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// --- Part 1: register the new CPT, REST-visible from the start ---
add_action( 'init', function () {
	register_post_type( 'cspt-industry-sector', array(
		'label'        => 'Industry Sectors',
		'labels'       => array(
			'name'          => 'Industry Sectors',
			'singular_name' => 'Industry Sector',
		),
		'public'       => true,
		'has_archive'  => 'industry-sector',
		'rewrite'      => array( 'slug' => 'industry-sector' ),
		'show_in_rest' => true,
		'rest_base'    => 'industries',
		'supports'     => array( 'title', 'thumbnail' ),
		'menu_icon'    => 'dashicons-building',
	) );

	// A newly registered CPT's rewrite rules don't take effect until WordPress's rewrite rule
	// cache is flushed -- without this, the REST API and wp-admin work immediately but every
	// pretty-permalink URL (e.g. /industry-sector/fmcg-manufacturing/) 404s until someone visits
	// Settings -> Permalinks and clicks Save, or this runs once. Guarded by an option so it only
	// fires the one time it's actually needed, not on every page load (flush_rewrite_rules() is
	// expensive and is a well-known anti-pattern to call unconditionally on 'init').
	if ( ! get_option( 'iep_cspt_industry_sector_flushed' ) ) {
		flush_rewrite_rules();
		update_option( 'iep_cspt_industry_sector_flushed', 1 );
	}
}, 20 );

// --- Part 2: authenticated ACF read/write endpoint ---
define( 'IEP_CMS_IS_KEY', '4d40550fec27d52991417a860d3ae953b6ee776350b05f74bb3f1e9746db815d' );

add_action( 'rest_api_init', function () {
	$auth_check = function ( WP_REST_Request $req ) {
		$sent = $req->get_header( 'x_iep_cms_key' );
		return is_string( $sent ) && hash_equals( IEP_CMS_IS_KEY, $sent );
	};

	$fields = array(
		'icon'          => 'array',
		'summary'       => 'string',
		'overview'      => 'string',
		'display_order' => 'integer',
	);

	register_rest_route( 'iep-cms/v1', '/industry-sector/(?P<id>\d+)', array(
		array(
			'methods'             => 'GET',
			'permission_callback' => $auth_check,
			'callback'            => function ( WP_REST_Request $req ) use ( $fields ) {
				$id = (int) $req->get_param( 'id' );
				if ( get_post_type( $id ) !== 'cspt-industry-sector' ) {
					return new WP_Error( 'not_found', 'Not a cspt-industry-sector post', array( 'status' => 404 ) );
				}
				$out = array(
					'id'   => $id,
					'title' => get_the_title( $id ),
					'slug'  => get_post_field( 'post_name', $id ),
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
				if ( get_post_type( $id ) !== 'cspt-industry-sector' ) {
					return new WP_Error( 'not_found', 'Not a cspt-industry-sector post', array( 'status' => 404 ) );
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
				return array( 'id' => $id, 'updated' => $result );
			},
		),
	) );
} );

// --- Part 3: [iep_industry_grid] shortcode ---
add_shortcode( 'iep_industry_grid', function ( $atts ) {
	$q = new WP_Query( array(
		'post_type'      => 'cspt-industry-sector',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'meta_key'       => 'display_order',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
	) );
	if ( ! $q->have_posts() ) {
		return '<!-- iep_industry_grid: no cspt-industry-sector records found -->';
	}

	ob_start();
	?>
	<style>
	.iep-is-grid-wrap{max-width:1200px;margin:0 auto;display:flex;flex-wrap:wrap;gap:24px;}
	.iep-is-card{flex:1 1 21%;min-width:220px;background:#fff;border:1px solid #E1E7E8;border-radius:6px;padding:32px 26px;transition:transform .22s,box-shadow .22s,border-color .22s;}
	.iep-is-card:hover{transform:translateY(-6px);box-shadow:0 20px 44px rgba(16,24,26,.10);border-color:#CFE0D4;}
	.iep-is-icon{color:#4C8B5A;font-size:44px;line-height:1;margin-bottom:18px;}
	.iep-is-title{color:#1E3D34;font-weight:700;font-size:18px;margin:0 0 10px;}
	.iep-is-summary{color:#5C6B6E;font-size:15px;line-height:1.6;margin:0;}
	</style>
	<div class="iep-is-grid-wrap">
		<?php while ( $q->have_posts() ) : $q->the_post();
			$id      = get_the_ID();
			$icon    = get_field( 'icon', $id );
			$summary = get_field( 'summary', $id );
			?>
			<a class="iep-is-card" href="<?php the_permalink(); ?>" style="text-decoration:none;display:block;">
				<?php if ( ! empty( $icon['value'] ) ) : ?>
					<div class="iep-is-icon"><i class="<?php echo esc_attr( $icon['value'] ); ?>" aria-hidden="true"></i></div>
				<?php endif; ?>
				<div class="iep-is-title"><?php the_title(); ?></div>
				<?php if ( $summary ) : ?>
					<p class="iep-is-summary"><?php echo esc_html( $summary ); ?></p>
				<?php endif; ?>
			</a>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
	<?php
	return ob_get_clean();
} );

// --- Part 4: [iep_industry_single] shortcode + template bypass ---
add_shortcode( 'iep_industry_single', function () {
	$id = get_the_ID();
	if ( get_post_type( $id ) !== 'cspt-industry-sector' ) {
		return '';
	}
	$title    = get_the_title( $id );
	$icon     = get_field( 'icon', $id );
	$summary  = get_field( 'summary', $id );
	$overview = get_field( 'overview', $id );

	ob_start();
	?>
	<style>
	.iep-iss-wrap{max-width:760px;margin:0 auto;padding:56px 24px;}
	.iep-iss-back{display:inline-flex;align-items:center;gap:6px;font-size:14px;color:#4C8B5A;text-decoration:none;margin-bottom:36px;font-weight:600;}
	.iep-iss-back:hover{text-decoration:underline;}
	.iep-iss-icon{color:#4C8B5A;font-size:48px;line-height:1;margin-bottom:18px;}
	.iep-iss-title{font-family:'Archivo',Poppins,sans-serif;font-weight:700;font-size:32px;color:#1E3D34;margin:0 0 18px;}
	.iep-iss-summary{color:#2D3436;font-size:19px;line-height:1.6;margin-bottom:24px;}
	.iep-iss-overview{color:#5C6B6E;font-size:16px;line-height:1.75;}
	.iep-iss-overview p{margin:0 0 1em;}
	</style>
	<div class="iep-iss-wrap">
		<a class="iep-iss-back" href="<?php echo esc_url( home_url( '/industries/' ) ); ?>">&larr; Back to Industries</a>
		<?php if ( ! empty( $icon['value'] ) ) : ?>
			<div class="iep-iss-icon"><i class="<?php echo esc_attr( $icon['value'] ); ?>" aria-hidden="true"></i></div>
		<?php endif; ?>
		<div class="iep-iss-title"><?php echo esc_html( $title ); ?></div>
		<?php if ( $summary ) : ?>
			<div class="iep-iss-summary"><?php echo esc_html( $summary ); ?></div>
		<?php endif; ?>
		<?php if ( $overview ) : ?>
			<div class="iep-iss-overview"><?php echo wp_kses_post( $overview ); ?></div>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
} );

// New posts default post_content to the shortcode, so single pages render correctly the moment
// they're created — applied preemptively (CMS-006's lesson: don't assume a fresh CPT's default
// single template is presentable; here there's no legacy demo content to override in the first
// place, but the theme's generic single.php fallback is still unknown/untested, so bypass it).
add_action( 'template_redirect', function () {
	if ( ! is_singular( 'cspt-industry-sector' ) ) {
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

add_action( 'save_post_cspt-industry-sector', function ( $post_id ) {
	if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
		return;
	}
	$post = get_post( $post_id );
	if ( empty( $post->post_content ) ) {
		remove_action( 'save_post_cspt-industry-sector', __FUNCTION__ );
		wp_update_post( array( 'ID' => $post_id, 'post_content' => '[iep_industry_single]' ) );
		add_action( 'save_post_cspt-industry-sector', __FUNCTION__ );
	}
} );
