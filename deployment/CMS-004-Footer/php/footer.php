<?php
/**
 * CMS-004 — Canonical Site Footer
 *
 * Replaces the per-page duplicated Elementor footer with one dynamic
 * template part, sourced from CMS-003's Global Settings Options Page.
 *
 * Deploy to: greenly-child/footer.php (requires file/SFTP access — this
 * is a real theme template file, it cannot be deployed via Code Snippets).
 * See IMPLEMENTATION-GUIDE.md before placing this file.
 *
 * Markup, inline styles, spacing and copy below are reproduced 1:1 from
 * the live footer as it exists today on the Services/Leadership/Case
 * Studies pages (captured in CMS-BOOT-002), so this file replaces the
 * duplicated per-page footers with zero intended visual change. Wrapper
 * classes intentionally match the theme's original .site-footer/#colophon
 * markup, because every 2026-redesign page currently hides those exact
 * classes with injected CSS — removing that per-page CSS (see
 * php/one-time-remove-duplicate-footers.php) is what makes this footer
 * visible again. Deploying this file alone, without that cleanup step,
 * will not change anything visible yet — see IMPLEMENTATION-GUIDE.md's
 * step order.
 *
 * IMPORTANT — structural wrapper code below (the #content/.row closing
 * divs before <footer>, and the .site-content-contain/#page closing divs,
 * back-to-top button, and wp_footer() after </footer>) is copied verbatim
 * from Greenly parent theme's own original footer.php. greenly-child had
 * no footer.php of its own before this file, so the parent's was what
 * WordPress was actually using — and it's responsible for closing markup
 * that header.php opens. The first version of this file omitted all of
 * that and only output the <footer> tag itself, which left the footer
 * nested inside the page's #content/.row wrapper instead of after it —
 * confirmed live (CMS-004-Footer/CHANGELOG.md, 2026-07-12 entry) via a
 * `.row.multi-columns-row` wrapper with 37 unrelated child elements
 * around the footer. Do not remove or reorder the wrapper code below;
 * only the *inside* of <footer>...</footer> is CMS-004's replacement.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$iep_white_logo = iep_get_global_image_url( 'white_logo' );
if ( ! $iep_white_logo ) {
	// Fallback: the real, currently-uploaded white logo (media ID 1066),
	// used so this footer never renders broken before Global Settings
	// has been reviewed and saved. Filename confirmed live in production
	// (2026-07-12) — note the actual uploaded filename's capitalisation
	// differs from what was assumed when this package was first built.
	$iep_white_logo = 'https://iep.technology/wp-content/uploads/2026/07/IEP-Logo_white_nobg.png';
}

$iep_tagline   = iep_get_global_setting( 'company_tagline', 'Cut Waste. Improve Profit. Fund the future' );
$iep_linkedin  = iep_get_global_setting( 'linkedin_url', 'https://www.linkedin.com/' );
$iep_address   = iep_get_global_setting( 'office_address', "Suite 21 Sutherland House,\nLondon SE18 4PS" );
$iep_email     = iep_get_global_setting( 'contact_email', 'tim.griffiths@iep.technology' );
$iep_phone     = iep_get_global_setting( 'contact_telephone', '07900 537219' );
$iep_copyright = iep_get_global_setting(
	'footer_copyright_text',
	'&copy; Industrial Energy Pioneers Limited. All rights reserved. &middot; Registered in England &middot; iep.technology'
);
?>
<?php if ( function_exists( 'cspt_check_sidebar' ) && cspt_check_sidebar() == true ) { ?>
	</div><!-- .row -->
<?php } ?>
</div><!-- #content -->

<style>
/* !important throughout: this reuses the theme's own .site-footer/#colophon/
   .footer-wrap classes for continuity with legacy pages, and the theme's
   own CSS for those exact selectors otherwise wins on specificity (e.g. a
   #colophon ID rule beats a plain .iep-footer class rule regardless of load
   order) — confirmed live: background was being silently dropped without
   this. Every other custom override already on this site (the per-page hide
   rules, the page-scoped style blocks) uses !important for the same reason,
   so this matches established site convention rather than introducing one. */
/* max-width here (not just on the inner grid) matches how the CTA section
   above the footer actually behaves: its entire dark box, background
   included, is width-constrained and centered — the page's own white
   background shows on both sides — not full-bleed with boxed content
   inside. Confirmed live: the footer's dark background was spanning edge
   to edge while every other dark section on the page was boxed like this. */
.iep-footer{background:#101A18 !important;color:#C9D2CF !important;min-height:0 !important;height:auto !important;max-width:1200px;margin-left:auto !important;margin-right:auto !important;}
/* Greenly's own theme CSS puts a decorative #colophon::before pseudo-element
   (position:absolute, full footer size) on this exact ID/class — reused here
   for continuity with legacy pages. Confirmed live via getComputedStyle:
   that pseudo-element has pointer-events:auto and sits on top of all real
   content, silently swallowing every click across the whole footer. This
   neutralizes that specific side effect without touching whatever visual
   purpose it originally had. */
#colophon.iep-footer::before,.iep-footer::before{pointer-events:none !important;}
/* .iep-foot is shared by both the nav-column links (Services/Industries —
   meant to stack one per line) and the legal-links row (meant to sit
   inline, side by side) via the same Walker class. This block-level default
   is for the column links; .iep-footer-legal .iep-foot below overrides it
   back to inline specifically for the legal row. Confirmed live: without
   that override, the legal links were stacking vertically instead of
   forming one row. */
.iep-footer .iep-foot{color:#C9D2CF !important;text-decoration:none;display:block;padding:6px 0;font-size:15px;}
.iep-footer .iep-foot:hover{color:#7FC98A !important;}
/* max-width:1200px matches Elementor's own container width, confirmed live
   (getComputedStyle on the page's Elementor container widgets) — without
   this the footer's content spans much wider than every other section on
   the page instead of aligning to the same left/right edges. */
.iep-footer-grid{display:flex !important;flex-wrap:wrap;gap:0 24px;padding:80px 40px 40px 40px;max-width:1200px;margin-left:auto !important;margin-right:auto !important;box-sizing:border-box;}
/* flex-basis set to each column's min-width directly (not a percentage) —
   percentages that summed to 100% previously didn't leave room for the
   24px gaps between columns, so the last column silently wrapped onto its
   own row. flex-grow ratios (not percentages) now handle distributing any
   extra space, which composes correctly with gap regardless of container
   width. Confirmed live: this was producing a broken 3-column-then-wrap
   layout on the Contact page. */
.iep-footer-col-brand{flex:1.6 1 260px;min-width:260px;}
.iep-footer-col{flex:1 1 180px;min-width:180px;}
.iep-footer-col h4{color:#fff !important;font-weight:600;font-size:16px;margin:0 0 14px;}
.iep-footer-legal{border-top:1px solid rgba(255,255,255,.12);padding:24px 40px 40px;color:#8A9A96 !important;font-size:13px;text-align:center;max-width:1200px;margin-left:auto !important;margin-right:auto !important;box-sizing:border-box;}
.iep-footer-legal .iep-foot{display:inline !important;padding:0 !important;color:#8A9A96 !important;margin:0 10px;font-size:13px;}
.iep-footer-legal .iep-foot:hover{color:#fff !important;}
@media(max-width:767px){
	.iep-footer-grid{padding:56px 20px 20px 20px;flex-direction:column;}
	.iep-footer-legal{padding:20px 20px 30px;}
	.iep-footer-legal .iep-foot{display:inline-block !important;margin:4px 8px;}
}
</style>

<footer id="colophon" class="site-footer iep-footer">
	<?php /* Deliberately NOT calling cspt_footer_classes() here — it ties into
	the theme's own footer-style options (big text area, multiple layout
	variants) designed for a much larger, more elaborate footer than this one.
	Confirmed live: including it produced a ~754px tall footer with mostly
	empty space, because the CSS tied to that class reserves room for theme
	features (cspt_footer_big_text_area(), widget columns) this file doesn't
	render. This footer intentionally only uses its own iep-footer styling. */ ?>
	<div class="footer-wrap iep-footer-grid">
		<div class="iep-footer-col-brand">
			<img src="<?php echo esc_url( $iep_white_logo ); ?>" alt="Industrial Energy Pioneers" style="width:170px;height:auto;display:block;margin-bottom:14px;" />
			<div style="font-size:15px;line-height:1.7;max-width:320px;margin-bottom:14px;">
				<?php echo esc_html( $iep_tagline ); ?>
			</div>
			<a class="iep-foot" href="<?php echo esc_url( $iep_linkedin ); ?>" style="color:#7FC98A;font-weight:600;">LinkedIn &rarr;</a>
		</div>

		<div class="iep-footer-col">
			<h4>Services</h4>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'iep-footer-services',
				'container'      => false,
				'menu_class'     => 'iep-foot-list',
				'items_wrap'     => '%3$s',
				'link_before'    => '',
				'walker'         => new IEP_Footer_Link_Walker(),
				'fallback_cb'    => false,
			) );
			?>
		</div>

		<div class="iep-footer-col">
			<h4>Industries</h4>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'iep-footer-industries',
				'container'      => false,
				'menu_class'     => 'iep-foot-list',
				'items_wrap'     => '%3$s',
				'link_before'    => '',
				'walker'         => new IEP_Footer_Link_Walker(),
				'fallback_cb'    => false,
			) );
			?>
		</div>

		<div class="iep-footer-col">
			<h4>Contact</h4>
			<div style="font-size:15px;line-height:1.9;">
				<?php echo nl2br( esc_html( $iep_address ) ); ?><br>
				<a class="iep-foot" href="mailto:<?php echo esc_attr( $iep_email ); ?>" style="display:inline;"><?php echo esc_html( $iep_email ); ?></a><br>
				<?php echo esc_html( $iep_phone ); ?>
			</div>
		</div>
	</div>

	<div class="iep-footer-legal">
		<?php echo wp_kses_post( $iep_copyright ); ?>
		<div style="margin-top:10px;">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'iep-footer-legal',
				'container'      => false,
				'menu_class'     => 'iep-foot-legal-list',
				'items_wrap'     => '%3$s',
				'walker'         => new IEP_Footer_Link_Walker(),
				'fallback_cb'    => false,
			) );
			?>
		</div>
	</div>
</footer><!-- #colophon -->
</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php
$iep_hide_totop_button = function_exists( 'cspt_get_base_option' ) ? cspt_get_base_option( 'hide_totop_button' ) : 1;
if ( $iep_hide_totop_button != 1 ) {
	?>
<a href="#" class="scroll-to-top" title="<?php esc_html_e( 'Back to Top', 'greenly' ); ?>"><i class="cspt-base-icon-up-open-big"></i></a>
	<?php
}
?>
<?php wp_footer(); ?>
</body>
</html>
