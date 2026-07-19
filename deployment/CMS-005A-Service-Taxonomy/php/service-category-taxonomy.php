<?php
/**
 * CMS-005A — Service Category Taxonomy + category-grouped rendering
 *
 * Deploy via Code Snippets, run Everywhere. Requires CMS-005's
 * "Service Details" field group (specifically `display_order` and
 * `executive_summary`) already imported and populated.
 *
 * v1.1 (2026-07-14) — added a Service Icon field + icon-box card styling,
 * matching the visual pattern of the original hardcoded service cards
 * this taxonomy replaced. See CHANGELOG in the deployment package README.
 *
 * This file does five things, each idempotent (safe to run on every page
 * load; seeding steps guarded by an option flag so they only run once):
 *   1. Registers the `service_category` taxonomy on `cspt-service`.
 *   2. Seeds the 3 approved category terms and assigns each of the 9
 *      services to its category, by exact title match.
 *   3. Registers a small, separate ACF field group adding "Service Icon"
 *      to `cspt-service` — kept deliberately separate from CMS-005's own
 *      "Service Details" field group (imported via JSON) rather than
 *      modifying it, so nothing here can collide with or overwrite that
 *      group's existing configuration.
 *   4. Seeds a sensible default icon (Font Awesome, FA5-classic names,
 *      matching this site's existing icon convention) for each of the 9
 *      services by exact title match — editable afterwards in wp-admin
 *      like any other field.
 *   5. Provides [iep_services_by_category], rendering each category's
 *      services as icon-box cards (icon, bold title, description),
 *      matching the visual pattern of the original hardcoded cards.
 *
 * Deliberately does NOT touch [iep_services_grid] itself
 * (service-helper-functions.php, from CMS-005) — that shortcode stays
 * exactly as it was, per this mission's Repository Rule preserving
 * "Existing shortcode architecture."
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Step 1 — Register the taxonomy.
 * Priority 20: runs after cspt-service's own registration (theme-registered
 * at default priority), so the taxonomy always has a real post type to attach to.
 */
add_action( 'init', function () {
	register_taxonomy(
		'service_category',
		'cspt-service',
		array(
			'label'             => 'Service Category',
			'labels'            => array(
				'name'          => 'Service Categories',
				'singular_name' => 'Service Category',
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'show_ui'           => true,
			'rewrite'           => array( 'slug' => 'service-category' ),
		)
	);
}, 20 );

/**
 * Step 2 — Seed the 3 categories and assign the 9 services.
 * Priority 30: runs after the taxonomy is registered (Step 1, priority 20).
 * Guarded by an option so this only ever runs once, not on every page load.
 *
 * Service titles below are the exact, live, client-approved titles
 * confirmed on the site 2026-07-13 — note the CFD/FEA service's title here
 * intentionally differs slightly from this mission's own brief text
 * ("Product Design & Optimisation (CFD, FEA & Experimental Analysis)"),
 * which paraphrases the real title. Matching must use the real title,
 * since this mission's own Repository Rules state service titles shall
 * not change — using the brief's paraphrase here would silently fail to
 * categorise that service.
 */
add_action( 'init', function () {
	if ( get_option( 'iep_service_category_seeded' ) ) {
		return;
	}

	$categories = array(
		'engineering-systems'             => array(
			'name'        => 'Engineering Systems',
			'description' => 'Integrated engineering solutions improving industrial performance, resource efficiency and sustainable infrastructure.',
			'services'    => array(
				'Energy, Utilities & Process Efficiency',
				'Water, Wastewater & Circular Resource Management',
				'Low-carbon & Resilient Energy Systems',
			),
		),
		'project-development-delivery'    => array(
			'name'        => 'Project Development & Delivery',
			'description' => 'Engineering support throughout the project lifecycle from opportunity assessment through design, funding and delivery.',
			'services'    => array(
				'Opportunity Screening & Diagnostic Review',
				'Engineering Design, Feasibility & Investment Case',
				'Funding, Procurement & Project Delivery',
			),
		),
		'advanced-engineering-innovation' => array(
			'name'        => 'Advanced Engineering & Innovation',
			'description' => 'Specialist engineering capability supporting optimisation, technology development and continuous operational improvement.',
			'services'    => array(
				'Product Design & Optimisation (incl. CFD, FEA and experimental analysis)',
				'AI-enabled Monitoring, Assurance & Continuous Improvement',
				'Technology Innovation & R&D Support',
			),
		),
	);

	// One query for all 9 services, matched by exact title — avoids the
	// deprecated get_page_by_title() and 9 separate queries.
	$all_services = get_posts( array(
		'post_type'      => 'cspt-service',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	) );
	$by_title = array();
	foreach ( $all_services as $service_post ) {
		$by_title[ trim( $service_post->post_title ) ] = $service_post->ID;
	}

	$unmatched = array();

	foreach ( $categories as $slug => $cat ) {
		$term = term_exists( $slug, 'service_category' );
		if ( ! $term ) {
			$term = wp_insert_term(
				$cat['name'],
				'service_category',
				array(
					'slug'        => $slug,
					'description' => $cat['description'],
				)
			);
		}
		if ( is_wp_error( $term ) ) {
			continue;
		}
		$term_id = is_array( $term ) ? (int) $term['term_id'] : (int) $term;

		foreach ( $cat['services'] as $title ) {
			if ( isset( $by_title[ $title ] ) ) {
				wp_set_object_terms( $by_title[ $title ], $term_id, 'service_category', false );
			} else {
				$unmatched[] = $title;
			}
		}
	}

	// Record any titles that didn't match a real service, rather than
	// failing silently — check this option in wp-admin (or ask a
	// developer to check it) if fewer than 9 services end up categorised.
	if ( ! empty( $unmatched ) ) {
		update_option( 'iep_service_category_unmatched', $unmatched );
	}

	update_option( 'iep_service_category_seeded', 1 );
}, 30 );

/**
 * Step 3 — Register the "Service Icon" field, as its own small field
 * group rather than editing CMS-005's JSON-imported "Service Details"
 * group. Registered in PHP via ACF's own documented `acf/init` hook
 * (not the plain `init` hook) so it's added the moment ACF itself is
 * ready, with no dependency on WP's own action-priority ordering.
 */
add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'                   => 'group_iep_service_icon_v1',
		'title'                 => 'Service Icon (CMS-005A)',
		'fields'                => array(
			array(
				'key'           => 'field_iep_service_icon_v1',
				'label'         => 'Service Icon',
				'name'          => 'service_icon',
				'type'          => 'icon_picker',
				'instructions'  => 'Icon shown on the service card grid. Auto-populated with a sensible default for the 9 approved services on first load — change here to override.',
				'return_format' => 'array',
				'tabs'          => 'font_awesome',
				'library'       => 'all',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'cspt-service',
				),
			),
		),
		'menu_order'            => 1,
		'position'              => 'normal',
		'style'                 => 'default',
		'active'                => true,
		'description'           => 'CMS-005A addition — kept as a separate field group from CMS-005\'s own "Service Details" group so it cannot collide with or overwrite that group\'s configuration.',
	) );
}, 20 );

/**
 * Step 4 — Seed a default icon per service, by exact title match.
 * Priority 35: after taxonomy (20), category seeding (30), and after
 * ACF's own `acf/init` (which fires during `init`) has registered the
 * field from Step 3. Guarded by its own option flag — runs once.
 *
 * Icons are Font Awesome 5 Free Solid ("fas"), matching the FA5-classic
 * convention already used site-wide for every other icon-box card on
 * this page (confirmed against the existing hardcoded cards' own
 * `selected_icon` values before this file was written) — not FA6-only
 * renamed icons, which are confirmed not to render on this theme.
 */
add_action( 'init', function () {
	if ( get_option( 'iep_service_icon_seeded' ) ) {
		return;
	}
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$icons = array(
		'Opportunity Screening & Diagnostic Review'                                => 'fa-search-dollar',
		'Energy, Utilities & Process Efficiency'                                   => 'fa-bolt',
		'Product Design & Optimisation (incl. CFD, FEA and experimental analysis)' => 'fa-drafting-compass',
		'Water, Wastewater & Circular Resource Management'                         => 'fa-tint',
		'Low-carbon & Resilient Energy Systems'                                    => 'fa-leaf',
		'Engineering Design, Feasibility & Investment Case'                        => 'fa-chart-line',
		'Funding, Procurement & Project Delivery'                                  => 'fa-hand-holding-usd',
		'AI-enabled Monitoring, Assurance & Continuous Improvement'                => 'fa-microchip',
		'Technology Innovation & R&D Support'                                      => 'fa-flask',
	);

	$all_services = get_posts( array(
		'post_type'      => 'cspt-service',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	) );
	$by_title = array();
	foreach ( $all_services as $service_post ) {
		$by_title[ trim( $service_post->post_title ) ] = $service_post->ID;
	}

	foreach ( $icons as $title => $icon_class ) {
		if ( isset( $by_title[ $title ] ) ) {
			update_field(
				'service_icon',
				array(
					'value'   => 'fas ' . $icon_class,
					'library' => 'fa-solid',
				),
				$by_title[ $title ]
			);
		}
	}

	update_option( 'iep_service_icon_seeded', 1 );
}, 35 );

/**
 * Step 5 — [iep_services_by_category] shortcode.
 * Renders Category Heading -> Category Description -> Service Grid,
 * repeated for each of the 3 terms, each grid ordered by the existing
 * `display_order` ACF field from CMS-005 (reused, not duplicated — see
 * IMPLEMENTATION-GUIDE.md's note on why no new "Display Order" field
 * was created for this mission).
 *
 * v1.1: card markup now mirrors Elementor's own icon-box widget output
 * (`elementor-icon-box-wrapper` / `elementor-icon-box-icon` classes),
 * so it inherits this page's own existing CSS for those selectors
 * (background, border, hover lift, icon spacing) with no new CSS
 * required — the same pattern the original hardcoded cards used.
 */
if ( ! function_exists( 'iep_services_by_category_shortcode' ) ) {
	function iep_services_by_category_shortcode( $atts ) {
		$terms = get_terms( array(
			'taxonomy'   => 'service_category',
			'hide_empty' => false,
			'orderby'    => 'term_id',
			'order'      => 'ASC',
		) );

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return '';
		}

		ob_start();
		$index = 0;
		foreach ( $terms as $term ) {
			$query = new WP_Query( array(
				'post_type'      => 'cspt-service',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'meta_key'       => 'display_order',
				'orderby'        => 'meta_value_num',
				'order'          => 'ASC',
				'tax_query'      => array(
					array(
						'taxonomy' => 'service_category',
						'field'    => 'term_id',
						'terms'    => $term->term_id,
					),
				),
			) );

			if ( ! $query->have_posts() ) {
				continue;
			}

			// Every other category (currently just the middle one, index 1
			// of 3) gets a full-bleed white band so the 3 categories read
			// as visually separate rows, matching the alternating-background
			// pattern the original hardcoded sections used — those were
			// separate top-level Elementor sections with their own
			// background; this shortcode renders all categories inside one
			// section, so the alternation is reproduced here with a
			// full-bleed wrapper instead (position:relative + left/right:50%
			// + negative vw margins is the standard robust break-out-of-
			// container technique, used instead of 100vw+overflow tricks to
			// avoid any risk of introducing horizontal scroll).
			$is_banded = ( 1 === $index % 2 );
			$index++;
			?>
			<?php if ( $is_banded ) : ?>
				<div style="background:#FFFFFF;position:relative;left:50%;right:50%;margin-left:-50vw;margin-right:-50vw;width:100vw;padding:64px 0;box-sizing:border-box;">
					<div style="max-width:1200px;margin:0 auto;padding:0 40px;box-sizing:border-box;">
			<?php endif; ?>
			<div class="iep-service-category" style="<?php echo $is_banded ? 'margin-bottom:0;' : 'margin-bottom:72px;'; ?>">
				<div style="text-align:center;">
					<h3 style="color:#1E3D34;font-family:Poppins,Arial,sans-serif;font-weight:700;font-size:36px;margin:0 0 14px;"><?php echo esc_html( $term->name ); ?></h3>
					<?php if ( $term->description ) : ?>
						<p style="color:#5C6B6E;max-width:640px;margin:0 auto 40px;font-size:17px;line-height:1.6;"><?php echo esc_html( $term->description ); ?></p>
					<?php endif; ?>
				</div>
				<div class="iep-services-grid" style="display:flex;flex-wrap:wrap;gap:24px;">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						$summary    = get_field( 'executive_summary' );
						$icon_field = get_field( 'service_icon' );
						$icon_class = ! empty( $icon_field['value'] ) ? $icon_field['value'] : '';
						?>
						<div class="iep-card" style="flex:1 1 30%;min-width:260px;">
							<div class="elementor-icon-box-wrapper" style="background:#fff;border:1px solid #E1E7E8;border-radius:6px;padding:32px 26px;height:100%;">
								<?php if ( $icon_class ) : ?>
									<div class="elementor-icon-box-icon" style="margin-bottom:18px;text-align:center;">
										<span class="elementor-icon" style="color:#4C8B5A;font-size:44px;line-height:1;display:inline-block;">
											<i class="<?php echo esc_attr( $icon_class ); ?>" aria-hidden="true"></i>
										</span>
									</div>
								<?php endif; ?>
								<h4 style="color:#1E3D34;margin:0 0 12px;font-weight:700;"><?php the_title(); ?></h4>
								<?php if ( $summary ) : ?>
									<p style="color:#5C6B6E;margin:0;"><?php echo esc_html( $summary ); ?></p>
								<?php endif; ?>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
			<?php if ( $is_banded ) : ?>
					</div>
				</div>
			<?php endif; ?>
			<?php
		}
		return ob_get_clean();
	}
	add_shortcode( 'iep_services_by_category', 'iep_services_by_category_shortcode' );
}
