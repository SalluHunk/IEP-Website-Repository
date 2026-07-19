# CMS-004 — Verification Checklist

## Footer renders correctly
- [ ] On a legacy page (Step 5): logo, tagline, LinkedIn link, three nav columns, contact block, and copyright bar all appear.
- [ ] On each of the 14 cleaned-up pages (Step 6): same, and it visually matches what that page showed before cleanup (compare against a screenshot taken before Step 6 if possible).
- [ ] Column proportions, spacing, and colours match the original (dark `#101A18` background, green `#7FC98A` LinkedIn/hover accent, `#C9D2CF` body text).
- [ ] Mobile width (under ~767px): columns stack vertically, nothing overlaps or overflows.

## Global Settings populate correctly
- [ ] Logo shown is the white/reversed logo (media ID 1066 or whatever was set in `CMS-003`), not the primary logo.
- [ ] Tagline, address, email, phone, and copyright text match what's saved in Global Settings.
- [ ] If a Global Settings field was left at its default (unreviewed), the footer still shows sensible real content, not a blank or "Array" or PHP notice — `footer.php`'s hardcoded fallbacks should prevent this; flag it if not.

## No duplicate footer remains
- [ ] Each of the 14 pages shows the footer exactly once — not the old static version AND the new dynamic one stacked together.
- [ ] View source on at least 2 of the 14 pages: confirm only one `<footer class="site-footer iep-footer" id="colophon">` element exists.
- [ ] The old per-page hide-footer `<style>` block is gone from each cleaned page's Elementor content (check in the Elementor editor, not just the front end).

## No PHP warnings
- [ ] No fatal errors or warnings on any page after `footer.php` deployment (Step 4).
- [ ] No fatal errors after each cleanup run (Step 6) — the script's own dry-run/live messaging should surface any JSON decode failures per-page; treat any "did not decode" or "nothing matched" message as a page needing manual review, not a page to force through.
- [ ] `WP_DEBUG_LOG`, if available, shows no new entries introduced by this deployment.

## No layout regression
- [ ] Spacing above/below the footer on every page matches pre-deployment (no extra gap, no missing gap).
- [ ] No content from the page above the footer got deleted or altered by the cleanup script (Step 6 only removes the two specific footer-related elements — confirm nothing else moved).
- [ ] Typography (font sizes, weights) in the footer matches the original.

## No Elementor conflicts
- [ ] Elementor editor still opens normally on all 14 previously-affected pages after cleanup.
- [ ] Elementor's own page-load performance/cache isn't showing stale content — if the footer looks wrong immediately after a cleanup run, clear Elementor's CSS cache (Elementor → Tools → Regenerate CSS) before assuming something's broken.
- [ ] No new Elementor admin notices referencing broken/missing elements on the cleaned pages.

## Sign-off
- [ ] All 14 pages individually confirmed (list them off as each passes — don't batch-assume).
- [ ] Cleanup snippet (Step 7) deleted.
- [ ] Any unchecked box has a written note explaining why, attached to `CHANGELOG.md`.
