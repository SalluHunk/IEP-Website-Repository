<?php
/**
 * CMS-002 — Leadership Module: Code Snippet
 * Install as a new snippet in Code Snippets (Snippets → Add New), "Only run on site front-end"
 * unset (run everywhere), Activate.
 *
 * Three independent parts:
 *   1. Retroactively enables show_in_rest on cspt-team-member (already registered elsewhere,
 *      by the Greenly Addons plugin) so it becomes REST-visible — this is what closes the
 *      original "no REST route" blocker for good, for this CPT.
 *   2. A small authenticated CMS write/read endpoint that writes ACF field values via ACF's
 *      own update_field()/get_field() functions. Added 2026-07-18 after confirming (via a
 *      temporary diagnostic, now removed) that ACF Pro exposes its fields under a dedicated
 *      "acf" key in its REST response — completely separate from WordPress core's generic
 *      "meta" REST field. Neither register_post_meta() nor the standard `meta` write
 *      parameter can touch ACF field data; only ACF's own save functions (or its own "acf"
 *      REST key, which no available MCP tool can send) can. This endpoint is the fix.
 *   3. [iep_team_grid] shortcode — server-side WP_Query, no REST involved, renders from the
 *      same ACF fields via get_field().
 *   4. [iep_team_member_single] shortcode — single-person bio layout, for the individual
 *      /team-member/{slug}/ pages (Part 2's endpoint also gained a way to point those pages
 *      at it — see /disable-elementor below). Added 2026-07-18: those pages still rendered
 *      old Envato demo content (Lorem Ipsum "Personal Experience", a stray contact form)
 *      because Elementor stores its own layout in _elementor_data, which overrides
 *      post_content entirely whenever a post is in Elementor's "builder" edit mode —
 *      clearing post_content alone (tried first) had no visible effect.
 *
 * SECURITY NOTE: the /iep-cms/v1/team-member endpoints require a shared-secret header
 * (X-IEP-CMS-Key) — intentionally NOT public like the site's other REST routes, since they
 * can write content. The secret below was generated with `openssl rand -hex 32`, not chosen
 * or typed by hand.
 */

// --- Part 1: retrofit REST support onto the existing cspt-team-member CPT ---
add_action( 'init', function () {
	global $wp_post_types;
	if ( isset( $wp_post_types['cspt-team-member'] ) ) {
		$wp_post_types['cspt-team-member']->show_in_rest          = true;
		$wp_post_types['cspt-team-member']->rest_base             = 'team-members';
		$wp_post_types['cspt-team-member']->rest_controller_class = 'WP_REST_Posts_Controller';
	}
}, 20 );

// --- Part 2: authenticated ACF read/write endpoint ---
define( 'IEP_CMS_KEY', '08e080b95bd2b26861a71191db3e37abad64c1331e043884d36cf5a5cf79ae30' );

add_action( 'rest_api_init', function () {
	$auth_check = function ( WP_REST_Request $req ) {
		$sent = $req->get_header( 'x_iep_cms_key' );
		return is_string( $sent ) && hash_equals( IEP_CMS_KEY, $sent );
	};

	$fields = array(
		'job_title'      => 'string',
		'qualifications' => 'string',
		'biography'      => 'string',
		'team_group'     => 'string',
		'profile_image'  => 'integer',
		'display_order'  => 'integer',
		'linkedin_url'   => 'string',
	);

	register_rest_route( 'iep-cms/v1', '/team-member/(?P<id>\d+)', array(
		array(
			'methods'             => 'GET',
			'permission_callback' => $auth_check,
			'callback'            => function ( WP_REST_Request $req ) use ( $fields ) {
				$id = (int) $req->get_param( 'id' );
				if ( get_post_type( $id ) !== 'cspt-team-member' ) {
					return new WP_Error( 'not_found', 'Not a cspt-team-member post', array( 'status' => 404 ) );
				}
				$out = array( 'id' => $id, 'title' => get_the_title( $id ) );
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
				if ( get_post_type( $id ) !== 'cspt-team-member' ) {
					return new WP_Error( 'not_found', 'Not a cspt-team-member post', array( 'status' => 404 ) );
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
				// Native WP featured image — separate from ACF's profile_image field.
				// Some other template/widget on this site (e.g. the "FD Team Box Pro"
				// widget referenced in the pre-existing "Team Box Fix" snippet) may read
				// the native thumbnail rather than the ACF field, so both are kept in sync.
				if ( $req->has_param( 'featured_media' ) ) {
					$fm = (int) $req->get_param( 'featured_media' );
					$result['featured_media'] = $fm ? set_post_thumbnail( $id, $fm ) : delete_post_thumbnail( $id );
				}
				return array( 'id' => $id, 'updated' => $result );
			},
		),
	) );

	// Points a team-member post's single-page rendering at [iep_team_member_single]
	// instead of Elementor's old stored demo layout. Sets post_content directly (native
	// WP function, not the REST meta path) and removes Elementor's edit-mode flag so the
	// theme falls back to normal the_content() rendering — which runs shortcodes — instead
	// of Elementor's override. _elementor_data itself is left in place, untouched, in case
	// anyone wants to re-open the old layout in Elementor later; it just stops being used.
	register_rest_route( 'iep-cms/v1', '/team-member/(?P<id>\d+)/use-single-shortcode', array(
		'methods'             => 'POST',
		'permission_callback' => $auth_check,
		'callback'            => function ( WP_REST_Request $req ) {
			$id = (int) $req->get_param( 'id' );
			if ( get_post_type( $id ) !== 'cspt-team-member' ) {
				return new WP_Error( 'not_found', 'Not a cspt-team-member post', array( 'status' => 404 ) );
			}
			wp_update_post( array( 'ID' => $id, 'post_content' => '[iep_team_member_single]' ) );
			delete_post_meta( $id, '_elementor_edit_mode' );
			return array( 'id' => $id, 'done' => true );
		},
	) );
} );

// --- Part 3: [iep_team_grid] shortcode ---
add_shortcode( 'iep_team_grid', function ( $atts ) {
	$atts = shortcode_atts( array(
		'group' => '', // '' = both groups, 'director' = directors only, 'team' = team only
	), $atts, 'iep_team_grid' );

	$query_args = array(
		'post_type'      => 'cspt-team-member',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'meta_key'       => 'display_order',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
	);
	if ( $atts['group'] === 'director' || $atts['group'] === 'team' ) {
		$query_args['meta_query'] = array(
			array(
				'key'   => 'team_group',
				'value' => $atts['group'],
			),
		);
	}

	$q = new WP_Query( $query_args );
	if ( ! $q->have_posts() ) {
		return '<!-- iep_team_grid: no cspt-team-member records found -->';
	}

	$directors = array();
	$team      = array();
	while ( $q->have_posts() ) {
		$q->the_post();
		$id    = get_the_ID();
		$group = get_field( 'team_group', $id ) ?: 'team';
		$row   = array(
			'name'     => get_the_title(),
			'job'      => get_field( 'job_title', $id ),
			'quals'    => get_field( 'qualifications', $id ),
			'bio'      => get_field( 'biography', $id ),
			'image_id' => get_field( 'profile_image', $id ),
			'linkedin' => get_field( 'linkedin_url', $id ),
		);
		if ( $group === 'director' ) {
			$directors[] = $row;
		} else {
			$team[] = $row;
		}
	}
	wp_reset_postdata();

	ob_start();
	?>
	<style>
	.iep-team-grid-wrap{max-width:1100px;margin:0 auto;}
	.iep-team-section{margin-bottom:56px;}
	.iep-team-section:last-child{margin-bottom:0;}
	.iep-team-row{display:flex;flex-wrap:wrap;gap:32px;justify-content:center;}
	.iep-team-card{flex:1 1 280px;max-width:340px;text-align:center;}
	.iep-team-photo{width:140px;height:140px;border-radius:50%;object-fit:cover;margin:0 auto 18px;display:block;filter:grayscale(1);}
	.iep-team-name{font-family:'Archivo',Poppins,sans-serif;font-weight:700;font-size:20px;color:#1E3D34;margin-bottom:6px;}
	.iep-team-job{color:#4C8B5A;font-weight:600;font-size:14px;margin-bottom:10px;}
	.iep-team-bio{color:#5C6B6E;font-size:14px;line-height:1.6;}
	.iep-team-linkedin{display:inline-block;margin-top:10px;font-size:13px;color:#4C8B5A;text-decoration:underline;}
	</style>
	<div class="iep-team-grid-wrap">
		<?php if ( $directors ) : ?>
		<div class="iep-team-section">
			<div class="iep-team-row">
				<?php foreach ( $directors as $p ) : ?>
					<div class="iep-team-card">
						<?php if ( $p['image_id'] ) : ?>
							<?php echo wp_get_attachment_image( $p['image_id'], 'medium', false, array( 'class' => 'iep-team-photo' ) ); ?>
						<?php endif; ?>
						<div class="iep-team-name"><?php echo esc_html( $p['name'] ); ?></div>
						<?php if ( $p['job'] || $p['quals'] ) : ?>
							<div class="iep-team-job"><?php echo esc_html( trim( $p['job'] . ( $p['quals'] ? ' — ' . $p['quals'] : '' ) ) ); ?></div>
						<?php endif; ?>
						<?php if ( $p['bio'] ) : ?>
							<div class="iep-team-bio"><?php echo wp_kses_post( $p['bio'] ); ?></div>
						<?php endif; ?>
						<?php if ( $p['linkedin'] ) : ?>
							<a class="iep-team-linkedin" href="<?php echo esc_url( $p['linkedin'] ); ?>" rel="noopener" target="_blank">LinkedIn</a>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

		<?php if ( $team ) : ?>
		<div class="iep-team-section">
			<div class="iep-team-row">
				<?php foreach ( $team as $p ) : ?>
					<div class="iep-team-card">
						<?php if ( $p['image_id'] ) : ?>
							<?php echo wp_get_attachment_image( $p['image_id'], 'medium', false, array( 'class' => 'iep-team-photo' ) ); ?>
						<?php endif; ?>
						<div class="iep-team-name"><?php echo esc_html( $p['name'] ); ?></div>
						<?php if ( $p['job'] ) : ?>
							<div class="iep-team-job"><?php echo esc_html( $p['job'] ); ?></div>
						<?php endif; ?>
						<?php if ( $p['bio'] ) : ?>
							<div class="iep-team-bio"><?php echo wp_kses_post( $p['bio'] ); ?></div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
} );

// --- Part 4: [iep_team_member_single] shortcode — individual bio page layout ---
add_shortcode( 'iep_team_member_single', function () {
	$id = get_the_ID();
	if ( get_post_type( $id ) !== 'cspt-team-member' ) {
		return '';
	}
	$name     = get_the_title( $id );
	$job      = get_field( 'job_title', $id );
	$quals    = get_field( 'qualifications', $id );
	$bio      = get_field( 'biography', $id );
	$image_id = get_field( 'profile_image', $id );
	$linkedin = get_field( 'linkedin_url', $id );

	ob_start();
	?>
	<style>
	.iep-tms-wrap{max-width:760px;margin:0 auto;padding:56px 24px;text-align:center;}
	.iep-tms-back{display:inline-flex;align-items:center;gap:6px;font-size:14px;color:#4C8B5A;text-decoration:none;margin-bottom:36px;font-weight:600;}
	.iep-tms-back:hover{text-decoration:underline;}
	.iep-tms-photo{width:180px;height:180px;border-radius:50%;object-fit:cover;margin:0 auto 26px;display:block;filter:grayscale(1);}
	.iep-tms-name{font-family:'Archivo',Poppins,sans-serif;font-weight:700;font-size:32px;color:#1E3D34;margin-bottom:8px;}
	.iep-tms-job{color:#4C8B5A;font-weight:600;font-size:16px;margin-bottom:28px;}
	.iep-tms-bio{color:#5C6B6E;font-size:16px;line-height:1.75;text-align:left;}
	.iep-tms-bio p{margin:0 0 1em;}
	.iep-tms-bio p:last-child{margin-bottom:0;}
	.iep-tms-linkedin{display:inline-block;margin-top:26px;font-size:14px;color:#4C8B5A;text-decoration:underline;}
	</style>
	<div class="iep-tms-wrap">
		<a class="iep-tms-back" href="<?php echo esc_url( home_url( '/leadership/' ) ); ?>">&larr; Back to Leadership</a>
		<?php if ( $image_id ) : ?>
			<?php echo wp_get_attachment_image( $image_id, 'medium', false, array( 'class' => 'iep-tms-photo' ) ); ?>
		<?php endif; ?>
		<div class="iep-tms-name"><?php echo esc_html( $name ); ?></div>
		<?php if ( $job || $quals ) : ?>
			<div class="iep-tms-job"><?php echo esc_html( trim( $job . ( $quals ? ' — ' . $quals : '' ) ) ); ?></div>
		<?php endif; ?>
		<?php if ( $bio ) : ?>
			<div class="iep-tms-bio"><?php echo wp_kses_post( $bio ); ?></div>
		<?php endif; ?>
		<?php if ( $linkedin ) : ?>
			<a class="iep-tms-linkedin" href="<?php echo esc_url( $linkedin ); ?>" rel="noopener" target="_blank">LinkedIn</a>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
} );
