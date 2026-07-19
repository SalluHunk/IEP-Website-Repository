<?php
/**
 * CMS-005 — Recommended Services archive template
 *
 * NOT required to deliver this module's value (see
 * php/service-helper-functions.php's [iep_services_grid] shortcode for
 * the near-term, no-SFTP path). This is the longer-term recommendation
 * for when a dedicated /services/ archive (distinct from today's
 * Elementor-built Services page) is wanted, and file/SFTP access
 * exists to place it at greenly-child/archive-cspt-service.php.
 *
 * Deliberately minimal — reuses iep_services_grid_shortcode()'s query
 * shape rather than duplicating it, and get_header()/get_footer() so
 * it inherits the now-canonical CMS-004 footer automatically.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="iep-service-archive" style="padding:80px 40px;max-width:1200px;margin:0 auto;">
	<h1 style="text-align:center;color:#1E3D34;margin-bottom:40px;">Services</h1>

	<?php echo do_shortcode( '[iep_services_grid]' ); ?>
</main>

<?php
get_footer();
