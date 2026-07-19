# CMS-003 — Changelog

*(Not part of the original CMS-003 deliverable list — added once real deployment/verification history existed to track.)*

## 2026-07-12 — Deployed and verified (Company Information, Contact Information, Branding Assets, Calls to Action, Footer Content)

**Deployment method:** Code Snippets (Option A from `IMPLEMENTATION-GUIDE.md`) — both `php/options-page.php` and `php/helper-functions.php` deployed as active Code Snippets ("CMS-003 — Global Settings Options Page" and "CMS 003 - Global Settings Helper Functions"), not `functions.php`.

**Verified via wp-admin screenshots, all 5 tabs, field by field:**
- Company Name, Company Tagline, Footer Copyright Text, and all 4 CTA fields (Primary/Secondary Text/URL) match the package's shipped values exactly.
- Office Address, Contact Email, Contact Telephone match the package's shipped values exactly.
- Every field marked `NOT YET SOURCED` in the field group (Company Registration Number, Global CTA Text, Footer Legal Text, Newsletter Text) was correctly left blank — no invented/placeholder content was entered, consistent with the package's "no marketing copy" instruction.
- Primary Logo, White/Reversed Logo, and Favicon all show real images matching the expected existing media IDs (211, 1066, 1030).

**One deliberate discrepancy from the shipped default, and it's a good one:** LinkedIn URL was changed from the package's flagged placeholder (`https://www.linkedin.com/`) to `https://uk.linkedin.com/company/iepltd` — exactly the review `README.md` asked for on that specific field. Not independently verified as IEP's actual page, but structurally this is the deployment working as designed, not drift from it.

**Minor cosmetic note:** the two Code Snippets are named inconsistently (`CMS-003` vs `CMS 003`) — no functional impact.

**Not yet verified:** frontend retrieval — whether `iep_get_global_setting()` / `iep_get_global_image_url()` actually return these saved values when called from a template (`IMPLEMENTATION-GUIDE.md` Step 7's throwaway shortcode test). The admin-side data is confirmed correct; the read path hasn't been proven yet. Confirm this before treating `CMS-004`'s `footer.php` (which depends on these functions) as safe to deploy.

**Verification method:** review conducted via wp-admin screenshots shared directly, cross-checked field-by-field against `acf-json/group_global_settings.json`'s default values and instructions text — not independently accessible to the reviewing session (ACF Options Page data has no REST/API surface; confirmed no `acf/v3` namespace exists on the site).
