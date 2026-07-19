# CMS-004 — Changelog

## 2026-07-12 — Package generated (not yet deployed)

**Added (package contents, not yet applied to WordPress):**
- `php/footer.php` — canonical dynamic footer template, replicates the live footer's markup/styling exactly, reads content from `CMS-003`'s Global Settings.
- `php/footer-helper-functions.php` — registers three footer nav menu locations (`iep-footer-services`, `iep-footer-industries`, `iep-footer-legal`) and a custom nav walker matching the original bare-link markup.
- `php/one-time-remove-duplicate-footers.php` — temporary, dry-run-by-default script to strip the per-page hide-footer CSS and duplicate footer section from the 14 known 2026-redesign pages (IDs 959, 965, 970, 971, 972, 973, 978, 979, 980, 981, 982, 983, 984, 1062).
- `README.md`, `IMPLEMENTATION-GUIDE.md`, `VERIFICATION.md`, `ROLLBACK.md`, `repository-update.md`.

**Decided:**
- Footer navigation uses WordPress Menus, not an ACF Repeater — see `IMPLEMENTATION-GUIDE.md`'s Architecture section for the full reasoning.
- Existing menus "Our Services" (29) and "Company" (30) checked and rejected as reuse candidates — both hold unrelated demo/placeholder content, confirmed by inspection during this mission.
- Three new menus will be created with content matching today's live footer exactly (same labels, same shared-URL-per-column behavior) — no new deep-linking behavior introduced, to guarantee zero visual/functional regression.

**Not done (by design — this mission produces a package only):**
- `footer.php` has not been placed in the theme.
- The three menus have not been created.
- The 14 pages have not been cleaned up.
- The live footer is unchanged.

*(Add a new dated entry below this line each time the package is actually deployed, or if anything in it is revised before deployment.)*

## 2026-07-12 — footer.php, menus, and helper functions deployed and verified on a legacy page

**Deployment notes:**
- `footer.php` placed at `greenly-child/footer.php` (WP Engine hosting, confirmed via file manager at `zmm.c7d.myftpupload.com`).
- Initial verification was blocked by WP Engine's server-level EverCache — separate from the "Clear Cache For Me" plugin already on the site, which can't purge it. Fixed via the WP Engine "Flush Cache" option under the Hosting menu in wp-admin. **Note for next deployment step (the per-page cleanup script):** re-purge this cache after each page is cleaned up, or changes may appear not to have taken effect.
- `footer-helper-functions.php` deployed as a Code Snippet ("CMS-004 — Footer Helper Functions"), Everywhere.
- Three menus created: Footer — Services (4/4 items correct), Footer — Industries (4/4 items correct), Footer — Legal Links (initially missing Cookie Policy, added afterward — all 5 present, though in a slightly different order than the original live footer: Privacy Policy, Terms & Conditions, Careers, Resources, Cookie Policy instead of Privacy Policy, Terms & Conditions, Cookie Policy, Careers, Resources — cosmetic, not yet reordered).

**Verified via direct server fetch (bypassing both WP Engine's cache and this session's own browser-tool cache, which briefly gave a false negative) on the Our Team legacy page:** logo, tagline, LinkedIn URL, address, email, phone, copyright, and both Services/Industries nav columns all render correctly and pull from live Global Settings/menu data — not from `footer.php`'s hardcoded fallbacks. This is the strongest possible confirmation the dynamic pipeline (ACF Options Page → CMS-003 helper functions → footer.php) works end-to-end.

**Not yet done:** Step 6 (per-page cleanup script) hasn't run on any of the 14 real 2026-redesign pages yet — they still show their old duplicated footers. `footer.php` itself is proven safe to proceed with.

## 2026-07-12 — Two bugs found and fixed while cleaning up page 973 (Contact) — first real page

**Bug 1 — cleanup script's hide-CSS regex too rigid.** Page 973's injected CSS repeated `body.page-id-973` before every selector in the list, instead of once at the start like the three pages (970/972/978) the original regex was written against. The regex silently failed to match, but the script's dry-run/live messaging reported success anyway (it logs based on a substring check, not on whether the replacement actually happened) — a real gap in the script's own verification, not just an edge case in the CSS. Fixed in `php/one-time-remove-duplicate-footers.php`: the regex now anchors on the unique `.cspt-page-header{...}` tail and allows any selector-list formatting in between (`body\.page-id-\d+[^{}]*\.cspt-page-header\s*\{[^}]*\}`), confirmed against both known formats.

**Bug 2 — footer.php's CSS lost a specificity fight with the theme.** Once the hide-CSS was actually removed, the new footer rendered with a transparent background instead of dark (`#101A18`) — confirmed via computed styles, not guesswork: `color` applied correctly but `background` came back `rgba(0,0,0,0)`. Root cause: `footer.php` deliberately reuses the theme's own `#colophon`/`.site-footer`/`.footer-wrap` classes/ID for continuity with legacy pages, and the theme's own CSS for those exact selectors wins on specificity (an ID selector beats a plain class selector regardless of load order). Fixed by adding `!important` to the properties that were losing — consistent with how every other custom CSS override already on this site is written (the original per-page hide rules, the page-scoped style blocks all use `!important` throughout for the same underlying reason).

**Process note:** both bugs were caught specifically *because* we verified with direct evidence (server fetch, computed styles) after each step instead of trusting the script's own success messages or a single screenshot. Same discipline applies to the remaining 13 pages — verify each one properly, don't assume success carries over from page to page.

## 2026-07-12 — Three more bugs found and fixed getting page 973 fully working

All three traced back to the same root decision: `footer.php` deliberately reuses Greenly's own `id="colophon"`/`.site-footer`/`.footer-wrap` names for continuity with legacy pages and the per-page hide-CSS. That decision is still correct, but it means the theme's *own* CSS for those exact selectors also applies to this new footer, which caused all three issues below. None of these were visible from raw server HTML — all three needed direct browser inspection (computed styles, `elementsFromPoint`) to actually find.

**Bug 3 — footer nested inside the page content wrapper instead of after it.** The very first version of `footer.php` only output the `<footer>` tag itself. Greenly's real `footer.php` (parent theme — `greenly-child` never had its own) closes `#content`/`.row` *before* outputting `<footer>`, and closes `.site-content-contain`/`#page` (plus the back-to-top button and `wp_footer()`) *after* it. Without those, the new footer rendered as the 38th child inside the page's own content grid instead of as a proper site-wide footer. Fixed by copying the parent theme's wrapper/structural code verbatim (confirmed against the real parent `footer.php`, pasted in full during this session) and only replacing the *inside* of the `<footer>` tag.

**Bug 4 — ~754px of empty black space.** `footer.php` called the theme's `cspt_footer_classes()` to stay "compatible," which pulled in a class tied to Greenly's own footer-style options (a "big text area" feature, multiple layout variants) sized for a much larger footer than this one renders. Fixed by removing that call and adding a defensive `min-height:0 !important;height:auto !important` to `.iep-footer`.

**Bug 5 — Contact column wrapped onto its own row.** The four footer columns used percentage `flex-basis` values that already summed to 100% (34/22/22/22), without accounting for the `24px` `gap` between them — the real required width slightly exceeded the container, so the last column silently wrapped. Fixed by switching to `flex-basis` in pixels (each column's own min-width) with `flex-grow` ratios instead of percentages, which composes correctly with `gap` regardless of container width.

**Bug 6 — footer visually fine but completely unclickable.** Confirmed directly via `getComputedStyle(footer, '::before')`: Greenly's theme CSS defines a decorative `#colophon::before` pseudo-element — `position:absolute`, sized to the full footer, `pointer-events:auto` — presumably for some visual effect on the theme's *original* footer design. Reusing the theme's exact ID/class pulled this in too, and it sat on top of all real content, silently swallowing every click. This is why `elementsFromPoint` kept showing what looked like "two footers" — a pseudo-element hit gets attributed to its host element, not a genuine duplicate DOM node (confirmed: `document.querySelectorAll('#colophon').length` was always 1). Fixed with a single targeted override: `.iep-footer::before{pointer-events:none !important;}`.

**Status after these fixes:** page 973 (Contact) visually confirmed correct by the user (screenshot: proper 4-column layout, no black gap, no wrap) — click-through and the other 13 pages not yet re-confirmed as of this entry.

**User independently verified the fallback chain by removing `footer.php` entirely:** with it removed, Contact (973, already cleaned up) fell through to the **parent** theme's own never-configured original footer (Envato "Greenly Solar Energy" demo content — Lorem ipsum, fake NY address, blog/newsletter widgets), while untouched pages still showed their old pre-existing per-page duplicate (unrelated to any of this work). Useful confirmation of the fallback behavior and of what the theme's own footer CSS was originally designed for — explains the `::before` overlay and height rules found above.

## 2026-07-12 — Bug 7: footer content not width-aligned with the rest of the page

Click-through confirmed working (user tested directly). But the footer's content sat wider than every other section on the page — the rest of the page's Elementor sections are constrained to a `max-width: 1200px` centered container (confirmed via `getComputedStyle` on the page's own Elementor container widgets), while `.iep-footer-grid` had no width constraint at all, so on wide viewports it extended much closer to the screen edges than the CTA section above it, creating a visible left/right misalignment. Fixed by adding the same `max-width:1200px` with `margin:auto` centering to both `.iep-footer-grid` and `.iep-footer-legal`.

## 2026-07-12 — Full comprehensive pass: bug 8 + one latent bug fixed proactively

User asked for a complete re-check rather than another one-off fix. Full file re-read line by line; found one more real bug and one latent (not-yet-triggered) bug:

**Bug 8 — footer legal links (Privacy Policy, Terms & Conditions, etc.) stacked vertically instead of forming one row.** Root cause: the nav-column links (Services/Industries — meant to stack, one per line inside their column) and the legal-links row (meant to sit inline, side by side) both get the same `iep-foot` class from the shared `IEP_Footer_Link_Walker`, and `.iep-footer .iep-foot{display:block}` was styled for the column links only — it applied to the legal row too, since there was no more-specific override. Fixed with `.iep-footer-legal .iep-foot{display:inline !important}`, plus an `inline-block` variant on mobile so the links can still wrap onto multiple lines gracefully on narrow screens.

**Latent bug (proactive fix, not yet visibly triggered) — hardcoded logo fallback filename was wrong.** `footer.php`'s fallback URL for `white_logo` (used only if the Global Settings field is ever empty) referenced `iep-logo-white-nobg.png`, but the actual uploaded file confirmed live in production is `IEP-Logo_white_nobg.png` (different capitalisation). Since the real ACF field is populated, this fallback was never actually exercised — but it would have 404'd if it ever were. Corrected to match the real filename.

**Also consolidated** the two separate `.iep-footer-legal` CSS rule blocks (split across earlier edits) into one, and added a matching `max-width:1200px` + centering to it alongside `.iep-footer-grid`, so both the column grid and the legal bar align to the same edges.

**Not yet re-verified live as of this entry** — awaiting re-upload, cache purge, and visual + click confirmation on Contact before treating page 973 as fully done.

## 2026-07-12 — Bug 9: outer footer background still full-bleed

User confirmed bugs 1–8 all fixed via screenshot (correct 4-column layout, correct logo, legal links in one row) — one remaining issue: the footer's dark background spans the full viewport edge to edge, while the CTA section immediately above it is boxed (background included) and centered with white margins either side. Root cause: the `max-width:1200px` centering added for bug 7 was only applied to the *inner* `.iep-footer-grid`/`.iep-footer-legal`, not the outer `.iep-footer` background element itself — so the content aligned correctly but the background didn't. Fixed by moving `max-width:1200px` + centering onto `.iep-footer` itself, matching how the CTA section's own background behaves.

**User confirmed all 9 bugs fixed via final screenshot — page 973 (Contact) is DONE.** Correct 4-column layout, correct boxed/centered background matching the rest of the page, correct logo, all links clickable and correct (including the updated LinkedIn URL), legal links in one row. This is the reference-correct version of `footer.php` — the same file (no further changes) should now be used for the remaining 13 pages' cleanup runs.

**Pages remaining (13 of 14):** 959 (Home), 965 (About IEP), 970 (Services), 971 (Industries), 972 (Leadership), 978 (Case Studies), 979 (Privacy Policy), 980 (Terms & Conditions), 981 (Cookie Policy), 982 (Careers), 983 (Insights), 984 (Resources), 1062 (Testimonials). Since `footer.php` itself is now proven correct, these should just need the cleanup script (dry run → live → purge cache → verify) with no further code changes expected — but verify each one before moving to the next regardless, per the process discipline established on page 973.

## 2026-07-12 — Page 970 (Services): clean pass, DONE

Dry run and live cleanup both ran as expected (removed 1 `hide_footer_style`, 1 `footer_section`). Full verification: no PHP errors, footer-hiding CSS rule genuinely gone (confirmed via a precise regex check, not just a loose substring match — two earlier flags on this page turned out to be false positives from an overly-simple heuristic: "Energy studies" legitimately appears twice, once in the page's own unrelated "From audit to verified savings" content and once in the new footer's Services column; a `display:none !important` match was `.cspt-title-bar-wrapper`, an unrelated rule the cleanup script correctly left alone). Live checks: click-through works, background correctly boxed at exactly 1200px, all 5 legal links in one row, LinkedIn URL correct. No code changes needed — `footer.php` is holding up as-is.

**12 pages remaining:** 959, 965, 971, 972, 978, 979, 980, 981, 982, 983, 984, 1062.

## 2026-07-13 — Added a batch cleanup script for the remaining 12 pages

User asked to speed up the remaining rollout rather than continuing strictly one page at a time. Added `php/batch-remove-duplicate-footers.php`, which runs the same removal logic across all 12 remaining page IDs in one pass, dry-run first, live second — same two-step gate as the per-page script, just batched. One extra safety rule the per-page script didn't have: a page is only saved live if **both** the hide-CSS rule and the duplicate footer section are found; a partial match (exactly the failure mode that almost slipped through silently on page 973) is skipped and flagged for manual review instead of being force-applied. The original per-page script (`one-time-remove-duplicate-footers.php`) is kept as-is for point fixes on flagged pages.

## 2026-07-13 — Batch live run: all 12 remaining pages, then full verification — CMS-004 COMPLETE

Batch dry run and live run both executed cleanly: all 12 pages reported "LIVE — removed hide_footer_style and footer_section," zero partial matches, zero skips.

**Full automated verification, all 12 pages (959, 965, 971, 972, 978, 979, 980, 981, 982, 983, 984, 1062), via direct uncached server fetch:** no PHP errors, exactly one `<footer>` tag, the specific footer-hiding CSS rule genuinely gone (precise regex check, not a loose substring match), new dynamic footer markup present, correct LinkedIn URL present, old placeholder LinkedIn URL absent — on every single page, no exceptions.

**Interactive/visual spot-check, 2 pages (Home, Leadership)** — full DOM-level check matching the rigor used on Contact and Services: click-through works, background correctly boxed at exactly 1200px, all 5 legal links sit in one row. Both pass cleanly, no anomalies, consistent with Contact and Services.

**All 14 of 14 pages now confirmed done:** 959, 965, 970, 971, 972, 973, 978, 979, 980, 981, 982, 983, 984, 1062. `footer.php` required no further changes after page 970 (Services) — the 9 bugs found and fixed on page 973 were the complete set; every subsequent page (13 more) applied cleanly against the same file with zero new issues.

**CMS-004 (Footer Consolidation) is complete.** The single-source dynamic footer, sourced from `CMS-003`'s Global Settings, is now live across the entire site — the central finding from `CMS-BOOT-002` (footer duplicated across every 2026-redesign page) is resolved.
