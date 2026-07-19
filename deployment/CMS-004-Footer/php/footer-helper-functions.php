<?php
/**
 * CMS-004 — Footer Helper Functions
 *
 * Deploy via Code Snippets, set to run Everywhere. Requires CMS-003's
 * helper-functions.php snippet (iep_get_global_setting /
 * iep_get_global_image_url) to already be active — this file does not
 * redefine them, it only adds what CMS-004 needs on top.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the three footer navigation locations footer.php renders.
 * Existing menus "Our Services" (ID 29) and "Company" (ID 30) were
 * checked during CMS-004 planning and hold unrelated demo content
 * (Solar/renewable placeholder services, dead "#" links) — do not
 * assign them here. Create three new menus with real content instead;
 * see IMPLEMENTATION-GUIDE.md.
 */
add_action( 'after_setup_theme', function () {
	register_nav_menus( array(
		'iep-footer-services'   => __( 'Footer — Services' ),
		'iep-footer-industries' => __( 'Footer — Industries' ),
		'iep-footer-legal'      => __( 'Footer — Legal Links' ),
	) );
} );

if ( ! class_exists( 'IEP_Footer_Link_Walker' ) ) {
	/**
	 * Outputs footer nav items as bare <a class="iep-foot"> tags with no
	 * <ul>/<li> wrapper, matching the original hand-authored footer
	 * markup exactly (see php/footer.php's header comment).
	 */
	class IEP_Footer_Link_Walker extends Walker_Nav_Menu {
		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$output .= sprintf(
				'<a class="iep-foot" href="%s">%s</a>',
				esc_url( $item->url ),
				esc_html( $item->title )
			);
		}

		public function end_el( &$output, $item, $depth = 0, $args = null ) {
			// Intentionally empty — no closing tag needed per item.
		}
	}
}
