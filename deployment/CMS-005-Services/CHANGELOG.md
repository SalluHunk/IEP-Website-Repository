# CMS-005 — Changelog

## 2026-07-12 — Package generated (not yet deployed)

**Added (package contents, not yet applied to WordPress):**
- `acf-json/group_service_fields.json` — 9-field group for `cspt-service` (Executive Summary, Full Description, Key Benefits repeater, Related Case Studies relationship, CTA Text/Link, Display Order, Featured Service, SEO Summary).
- `php/service-helper-functions.php` — `iep_get_service_cta()` (falls back to CMS-003 Global Settings), `[iep_services_grid]` shortcode.
- `php/recommended-templates/archive-cspt-service.php`, `single-cspt-service.php` — future-facing, need SFTP, not required for this module's initial value.
- `README.md`, `IMPLEMENTATION-GUIDE.md`, `VERIFICATION.md`, `ROLLBACK.md`, `DECISIONS.md`, `repository-update.md`.

**Decided (full reasoning in `DECISIONS.md`):**
- 7 real IEP services identified (5 "core," 2 "beyond the core," per the live page's own framing) — the live page's separate "From audit to verified savings" list treated as process narrative, not additional services.
- 6 of the mission's 15 candidate fields excluded or deferred: Featured Image (native support already exists), Industry Applications and Technology Stack (target CPT/taxonomy don't exist yet), Core Capabilities and Deliverables (no verified content), Gallery (no verified need).
- `[iep_services_grid]` shortcode identified as the practical no-SFTP path to real value; archive/single templates positioned as later, file-access-dependent recommendations.

**Not done (by design — this mission produces a package only):**
- No field group imported.
- No `cspt-service` item's content changed.
- No change to the live Services page.

## 2026-07-13 — v1.1 revision (mission CMS-005A / OPERATION PHOENIX, still not deployed)

**Trigger:** a newer client-approved 9-service catalogue supersedes the 7-service model above. Full text of the approved catalogue and old→new mapping in `MIGRATION-REPORT-v1.1.md`.

**Changed:**
- `IMPLEMENTATION-GUIDE.md` — migration table replaced (7 rows → 9 rows). `display_order` taken from the client's own numbering; `executive_summary`/`key_benefits` left as "not yet sourced" for all 9 (old sourced copy deliberately not reused — see `DECISIONS.md`'s v1.1 addendum). "Demo content disposition" and Steps 4–5 updated: 9 demo items now map 1:1 to 9 approved titles, no Draft handling needed, no `featured="1"` shortcode filter recommended.
- `VERIFICATION.md` — checklist counts updated 7→9; featured-filter checks marked N/A pending client input.
- `ROLLBACK.md` — "7 migrated items" → "9"; removed the now-inapplicable un-draft step.
- `DECISIONS.md` — v1.1 addendum added (§1/§3 marked superseded, not wrong; Service Phase field evaluated and not added; content-field non-reuse policy explained).
- `README.md` — status/sources/package-contents updated for v1.1; "what's being replaced" updated to 1:1 disposition.
- `repository-update.md` — "New capability" note updated to reference v1.1.
- `acf-json/group_service_fields.json` — `featured_service` field's `instructions` text updated to remove the stale "core five" reference (no structural/field-count change); `executive_summary` field's `instructions` text lightly updated for accuracy.

**Added:**
- `MIGRATION-REPORT-v1.1.md` — full old→new catalogue mapping (2 merges, 2 renames, 1 removal flagged for client confirmation, 5 new services) with reasoning per row.

**Explicitly NOT changed (reviewed, found still correct):**
- `php/service-helper-functions.php` — `iep_services_grid_shortcode()` has no hardcoded count/title assumptions; already correct for 9 services.
- `php/recommended-templates/archive-cspt-service.php`, `single-cspt-service.php` — same reasoning, unchanged.
- ACF field group architecture (9 fields, types, `cspt-service` location rule) — unchanged, only instruction text touched on 2 fields.
- Shortcode strategy, PHP architecture, deployment methodology, repository structure — all preserved per the mission's explicit constraint.

**Still not done:** no field group imported, no `cspt-service` item's content changed, no change to the live Services page. This remains a package-only revision.

## 2026-07-13 — Field bug fix, discovered during live deployment (v1.1 field group)

**Trigger:** the user began deploying CMS-005 v1.1 manually in wp-admin (Steps 1–4 of `IMPLEMENTATION-GUIDE.md`) and found `Executive Summary` was marked required, blocking saving any of the 9 `cspt-service` items with the field left blank — which the v1.1 migration table explicitly calls for, since no sourced copy exists yet for any of the 9 titles.

**Root cause:** `acf-json/group_service_fields.json`'s `executive_summary` field had `"required": 1`, left over from the original v1.0 package design (written when the plan was to migrate real sourced copy immediately, before the v1.1 catalogue revision changed that plan to "titles and order now, content later"). The field-required setting was never revisited when v1.1 changed the migration approach.

**Fixed:** `executive_summary`'s `"required"` value changed from `1` to `0` in `acf-json/group_service_fields.json`. User applied the equivalent fix live via Custom Fields → Field Groups → Service Details → Executive Summary → toggled Required off, directly in wp-admin (the JSON file update here brings the repository package in line with what's now live, not the other way around).

**How to apply:** if this field group is ever re-imported from the repository JSON (e.g. onto a staging environment), the corrected file now matches the live, working configuration. No other field's required setting was found to have the same problem — `Key Benefits`' sub-field (`benefit_text`) is required only when a row exists, which doesn't block saving a repeater with zero rows, so no fix was needed there.

*(Add a new dated entry below this line each time the package is actually deployed, or if anything in it is revised before deployment.)*
