# CMS-005 — Implementation Guide

## Migration table — v1.1 (2026-07-13, supersedes the v1.0 seven-service table)

**Superseded by the client's approved 9-service catalogue.** See `MIGRATION-REPORT-v1.1.md` for the full old→new mapping (merges, renames, removals, new services) and reasoning. The table below is what actually gets typed into wp-admin at migration time.

`display_order` is taken directly from the client's own numbered catalogue — not invented. `executive_summary`, `key_benefits`, `full_description`, `related_case_studies`, `cta_text`, `cta_link`, and `seo_summary` have **no approved source copy yet for any of the 9** (see `DECISIONS.md`'s v1.1 addendum for why v1.0's old sourced text isn't being reused) — leave every one of these blank at migration time. Do not author placeholder copy. `featured_service` is left at its default (FALSE) for all 9 — the new catalogue states no primary/secondary distinction.

| # | Service Title | Executive Summary | Key Benefits | Featured Service | Display Order |
|---|---|---|---|---|---|
| 1 | Opportunity Screening & Diagnostic Review | *not yet sourced* | *not yet sourced* | FALSE | 1 |
| 2 | Energy, Utilities & Process Efficiency | *not yet sourced* | *not yet sourced* | FALSE | 2 |
| 3 | Product Design & Optimisation (incl. CFD, FEA and experimental analysis) | *not yet sourced* | *not yet sourced* | FALSE | 3 |
| 4 | Water, Wastewater & Circular Resource Management | *not yet sourced* | *not yet sourced* | FALSE | 4 |
| 5 | Low-carbon & Resilient Energy Systems | *not yet sourced* | *not yet sourced* | FALSE | 5 |
| 6 | Engineering Design, Feasibility & Investment Case | *not yet sourced* | *not yet sourced* | FALSE | 6 |
| 7 | Funding, Procurement & Project Delivery | *not yet sourced* | *not yet sourced* | FALSE | 7 |
| 8 | AI-enabled Monitoring, Assurance & Continuous Improvement | *not yet sourced* | *not yet sourced* | FALSE | 8 |
| 9 | Technology Innovation & R&D Support | *not yet sourced* | *not yet sourced* | FALSE | 9 |

The v1.0 seven-service table (with real sourced Executive Summary/Key Benefits text) is preserved for reference in `CHANGELOG.md`'s 2026-07-12 entry and `MIGRATION-REPORT-v1.1.md` — it is no longer the migration target.

## Demo content disposition

`cspt-service` currently holds 9 published items, all demo content (confirmed titles include "Solar As A Service," "Solar PV Systems," "Wind Generators," and others — see `CMS-BOOT-002-Readiness-Report.md`; item count reconfirmed live 2026-07-13, still 9 published, nothing deployed yet). **Under v1.1, all 9 map 1:1 to the 9 approved service titles above** — unlike v1.0 (7 real services against 9 demo slots, 2 recommended as Draft), no items need to be set to Draft. Each of the 9 existing items gets its title replaced and `display_order` set; all other fields stay blank pending sourced copy.

## Deployment order

### Step 1 — Confirm dependencies
`CMS-003` (Global Settings) should be deployed for the CTA fallback to have something to fall back to (it degrades gracefully if not, per `service-helper-functions.php`, but deploy in order regardless). `CMS-004` is not a hard dependency for this module but should be deployed first if you're doing all of these in sequence, per `CMS-001`.

### Step 2 — Import the field group
Custom Fields → Tools → Import Field Groups → `acf-json/group_service_fields.json`. Confirm "Service Details" appears with location rule `Post Type equals cspt-service`.

### Step 3 — Deploy the helper functions + shortcode
Code Snippets → Add New → `CMS-005 — Services Helper Functions` → paste `php/service-helper-functions.php` → run **Everywhere** → Activate.

### Step 4 — Migrate the 9 approved services
For each row in the v1.1 migration table: open one of the 9 existing `cspt-service` items in wp-admin, set the title and Display Order exactly as tabled. Leave Executive Summary, Key Benefits, Featured Service (default FALSE), and every other field blank — no sourced copy exists yet (see `MIGRATION-REPORT-v1.1.md`). No items need to be set to Draft; all 9 existing slots are used.

**Also clear the native content editor body and Featured Image on each item** (both are leftover demo copy/photos unrelated to the new titles — e.g. solar-panel sales copy and stock photography). Neither is rendered by `[iep_services_grid]` today, but both would surface later via search-engine snippets or the future single-service template if left in place. Don't type replacement text — leave the body genuinely empty, same discipline as the ACF fields.

**Also update the permalink/slug on each item to match its new title**, not just the visible title field — WordPress does not regenerate the slug of an already-published post when you edit its title. Edit the Permalink field (shown just under the title in the editor) to a kebab-case slug derived from the new title (e.g. `energy-utilities-process-efficiency`). None of these 9 permalinks are linked from anywhere live yet, so there's no broken-link risk in changing them now — this is the right point in the process to fix it, not something to revisit later.

**Known field-group bug, fixed 2026-07-13:** `Executive Summary` was originally marked required in the shipped field group, which blocks saving with it left blank as this step calls for. Fixed in `acf-json/group_service_fields.json` (`required` changed from `1` to `0`) — see `CHANGELOG.md`'s 2026-07-13 entry. If a field group imported before this fix still shows Executive Summary as required, either re-import the corrected JSON or toggle Required off manually under Custom Fields → Field Groups → Service Details → Executive Summary.

### Step 5 — Update the live Services page (the actual visible change)
In the Elementor editor on page 970: replace the existing hardcoded service rows with Elementor's **Shortcode** widget containing `[iep_services_grid]` (no `featured` attribute — v1.1 has no primary/secondary split to filter on; the `featured="1"` example from v1.0 no longer applies until the client specifies one, see `DECISIONS.md`'s v1.1 addendum). Compare the rendered result (9 cards, in `display_order`) against the original rows before removing them — don't delete the original content until the shortcode version is confirmed to match.

### Step 6 — (Optional, later) Deploy the recommended templates
`php/recommended-templates/archive-cspt-service.php` and `single-cspt-service.php` are ready to place at `greenly-child/` whenever file/SFTP access exists and dedicated single-service pages are wanted. Not required for Step 5's value.

### Step 7 — Full verification
Run `VERIFICATION.md` before considering this module done.
