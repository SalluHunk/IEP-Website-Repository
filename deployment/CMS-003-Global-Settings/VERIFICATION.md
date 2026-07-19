# CMS-003 — Verification Checklist

Run after completing `IMPLEMENTATION-GUIDE.md`. Check every box before treating this module as done — none of this can be verified from within this repository/session; it requires a human with wp-admin access.

## Options Page visible
- [ ] "Global Settings" appears in the wp-admin left sidebar.
- [ ] Clicking it loads without a white screen / fatal error.
- [ ] The five tabs render: Company Information, Contact Information, Branding Assets, Calls to Action, Footer Content.

## Fields imported
- [ ] Custom Fields → Field Groups shows "Global Settings" with 24 fields (4 tab dividers + 20 data fields) — matches `acf-json/group_global_settings.json`.
- [ ] Location rule reads: `Options Page equals global-settings`.
- [ ] No duplicate "Global Settings" field group exists (re-importing without checking first can create a second copy under a different key).

## Values saved
- [ ] Company Name, Tagline, Office Address, Contact Email, Contact Telephone, Primary/Secondary CTA text+URL, and Footer Copyright all show the real values from `README.md`'s table after Step 6.
- [ ] Company Registration Number, Default Social Image, Global CTA Text, Newsletter Text, and Footer Legal Text are either still blank (acceptable) or have been deliberately filled by the client/editor (also acceptable) — flag if any of these were filled with guessed/invented content instead of real client-supplied values.
- [ ] Primary Logo / White Logo / Favicon reference the existing media library items (211 / 1066 / 1030), not fresh re-uploads.
- [ ] LinkedIn URL has either been confirmed as the placeholder intentionally, or updated to the real company page.

## Frontend retrieval working
- [ ] The Step 7 shortcode test in `IMPLEMENTATION-GUIDE.md` returned the real saved value, not the fallback default.
- [ ] `iep_get_global_image_url()` returns a real URL when tested against `primary_logo` (test the same way, temporarily, if needed).
- [ ] Test shortcode/snippet from Step 7 has been removed after confirming.

## No PHP errors
- [ ] No fatal errors, warnings, or notices appear in `wp-admin` after activating both Code Snippets (or after saving `functions.php`, if that path was used).
- [ ] Site's front end loads normally on at least one page (e.g. the homepage) with no visible PHP error output.
- [ ] If `WP_DEBUG_LOG` is available to check, confirm no new entries appeared during this deployment.

## No Elementor conflicts
- [ ] Elementor editor still opens normally on Services, Leadership, and Case Studies pages (the three pages inspected during `CMS-BOOT-002`).
- [ ] No new admin notices from Elementor referencing a "Global Settings" or ACF conflict.
- [ ] Nothing on the live front end visually changed — this package only adds new, unused-so-far data; it does not yet rewire any page's footer to consume it (that rewiring is separate, out of scope for this package, tracked in `repository-update.md`).

## Sign-off
- [ ] All boxes above checked.
- [ ] Any unchecked box has a written note explaining why, attached to this file or the repository changelog.
