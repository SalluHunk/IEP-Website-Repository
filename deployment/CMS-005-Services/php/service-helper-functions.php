<?php
/**
 * CMS-005 — Services Helper Functions + Shortcode
 *
 * Deploy via Code Snippets, run Everywhere. Requires CMS-003's helper
 * functions (iep_get_global_setting) to be active for CTA fallback.
 *
 * This is the practical, deployable-without-SFTP path for this module:
 * the [iep_services_grid] shortcode can be dropped into the EXISTING
 * live Services page (970) via Elementor's native Shortcode widget,
 * replacing the current hardcoded icon-box row with real cspt-service
 * data — without needing archive-cspt-service.php or
 * single-cspt-service.php (see php/recommended-templates/, which do
 * need file/SFTP access and are a further-out recommendation, not
 * required for this module to deliver real value).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'iep_get_service_cta' ) ) {
	/**
	 * A service's own CTA text/link if set, else CMS-003's Global
	 * Settings Primary CTA, else a hardcoded last-resort fallback.
	 *
	 * @param int $post_id
	 * @return array{text:string,url:string}
	 */
	function iep_get_service_cta( $post_id ) {
		$text = get_field( 'cta_text', $post_id );
		$url  = get_field( 'cta_link', $post_id );

		if ( empty( $text ) && function_exists( 'iep_get_global_setting' ) ) {
			$text = iep_get_global_setting( 'primary_cta_text', 'Book Opportunity Screening' );
		}
		if ( empty( $url ) && function_exists( 'iep_get_global_setting' ) ) {
			$url = iep_get_global_setting( 'primary_cta_url', 'https://iep.technology/contact/' );
		}

		return array(
			'text' => $text ?: 'Book Opportunity Screening',
			'url'  => $url ?: 'https://iep.technology/contact/',
		);
	}
}

if ( ! function_exists( 'iep_services_grid_shortcode' ) ) {
	/**
	 * [iep_services_grid] — renders published cspt-service items.
	 * Attributes:
	 *   featured="1"   only Featured Service items (defaults to all)
	 *   limit="5"      max items (defaults to all matching)
	 *
	 * Deliberately reproduces the existing icon-box card structure's
	 * spirit (title + short summary) without introducing new CSS —
	 * relies on the theme's existing card/column styling class
	 * (iep-card, already present site-wide per CMS-BOOT-002's reading
	 * of the live Services page) rather than shipping a parallel style.
	 */
	function iep_services_grid_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'featured' => '',
			'limit'    => -1,
		), $atts, 'iep_services_grid' );

		$args = array(
			'post_type'      => 'cspt-service',
			'post_status'    => 'publish',
			'posts_per_page' => intval( $atts['limit'] ),
			'meta_key'       => 'display_order',
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
		);

		if ( $atts['featured'] === '1' ) {
			$args['meta_query'] = array(
				array(
					'key'   => 'featured_service',
					'value' => '1',
				),
			);
		}

		$query = new WP_Query( $args );

		if ( ! $query->have_posts() ) {
			return '';
		}

		ob_start();
		echo '<div class="iep-services-grid" style="display:flex;flex-wrap:wrap;gap:24px;">';
		while ( $query->have_posts() ) {
			$query->the_post();
			$summary = get_field( 'executive_summary' );
			?>
			<div class="iep-card" style="flex:1 1 30%;min-width:260px;">
				<div class="elementor-icon-box-wrapper" style="background:#fff;border:1px solid #E1E7E8;border-radius:6px;padding:32px 26px;height:100%;">
					<h4 style="color:#1E3D34;margin:0 0 12px;"><?php the_title(); ?></h4>
					<?php if ( $summary ) : ?>
						<p style="color:#5C6B6E;margin:0;"><?php echo esc_html( $summary ); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<?php
		}
		echo '</div>';
		wp_reset_postdata();

		return ob_get_clean();
	}
	add_shortcode( 'iep_services_grid', 'iep_services_grid_shortcode' );
}
