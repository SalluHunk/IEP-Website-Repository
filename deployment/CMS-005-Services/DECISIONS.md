# CMS-005 — Decisions Log

Judgment calls made while producing this package, recorded so they aren't mistaken for oversights or silently re-litigated later.

## 1. What counts as "a service" on the live Services page

The live Services page (970) actually contains three different lists, not one:
1. **"Five core service areas"** — Energy Management, Sustainability & Net Zero, Industrial Engineering, Consultancy & Advisory, Training & Development. Each has its own title + short description, presented as the primary service catalogue.
2. **"Innovation & technology services"**, explicitly introduced as **"Beyond the core"** — Research & Development support, Technology validation. Same title+description pattern as #1, just editorially flagged as secondary.
3. **"From audit to verified savings"** — Energy studies, Efficiency assessments, Grant funding, Procurement support, Project delivery, Performance verification.

**Decision: #1 and #2 (7 items total) are migrated as real `cspt-service` entries. #3 is treated as page-level process/methodology narrative, not separate services**, and is not migrated into the CPT. Reasoning: #3's six items parallel the six-step methodology already shown on the homepage ("Data collection → Opportunity identification → Financial assessment → Engineering design → Funding support → Implementation") in service-specific language — it reads as "how we deliver," not "what we offer," and doesn't share #1/#2's title+description-as-a-distinct-offering structure. If this reading is wrong, treating #3 as services too is a small addition to the migration table, not a rework of the field model.

## 2. Fields excluded from the field group, and why

Per the mission's own "only include fields that genuinely improve editor usability" / "do not invent fields without justification":

| Field (mission's suggestion) | Decision | Reason |
|---|---|---|
| Featured Image | **Excluded — not a new field** | `cspt-service` already natively supports a Featured Image (`thumbnail` in its registration, confirmed via the `wp://site/post-types` resource). Adding an ACF field would duplicate existing WordPress functionality. |
| Industry Applications (Relationship) | **Deferred, not included** | ACF Relationship fields must target an existing post type. No `industry` CPT/taxonomy exists yet (confirmed in `CMS-BOOT-001`: "no custom taxonomies exist yet"). Shipping an unrestricted or mistargeted relationship field now would be worse than adding it correctly once the Industries module exists. |
| Technology Stack | **Deferred, not included** | Same reasoning — the CMS Spec's own Technology taxonomy is correctly designed as a genuine taxonomy, but it isn't registered yet. Add this field via a small field-group update once it is. |
| Core Capabilities (Repeater) | **Excluded** | No verified live content distinguishes "core capabilities" from the "Key Benefits" content already captured — every service's real description is a single short phrase list, not two parallel lists. Shipping both would be inventing a second field for the same underlying data. |
| Deliverables | **Excluded** | No verified live content exists for this at all, for any service. Speculative — matches the mission's "no speculative content" rule directly. |
| Gallery | **Excluded** | The mission itself qualified this as "if justified." No service on the live site uses more than a single icon; no multi-image content exists anywhere in the verified inventory to justify a Gallery field. |

**Included and why:** Executive Summary, Full Description, Key Benefits (Repeater), Related Case Studies (Relationship — `cspt-portfolio` already exists as a real, configurable target), CTA Text/Link, Display Order, Featured Service, SEO Summary. Full reasoning for each is in the field group's own `instructions` text (`acf-json/group_service_fields.json`) — not duplicated here.

## 3. Featured Service default values aren't a new editorial call

Migrating "Five core service areas" as `featured_service = true` and "Beyond the core" as `false` isn't a judgment this package is making — it's reading the live page's own stated framing directly. If the client's intent differs from how the current copy frames it, that's a content conversation, not a package-design issue.

## 4. Migration mapping vs. migration execution

This package documents exactly where every existing service's content should go (`IMPLEMENTATION-GUIDE.md`'s migration table). **It cannot execute that migration.** `cspt-service` has no REST route (confirmed live during `CMS-002`'s attempt on the sibling `cspt-team-member` CPT, and reconfirmed for `cspt-service` specifically during this package's preparation) — populating the actual field values still requires a human in wp-admin, the same limitation `CMS-002-Leadership-Module-Report.md` already documented. This package reduces that work to "copy these exact values into these exact fields," not "figure out what the values should be."

## 5. Why the shortcode, not the templates, is the real deliverable

`archive-cspt-service.php` and `single-cspt-service.php` are included as documented recommendations because the mission asked for them, but they need file/SFTP access this project doesn't currently have. The `[iep_services_grid]` shortcode (Code-Snippets-deployable, no file access needed) is what actually lets the *existing* live Services page start rendering from `cspt-service` data — via Elementor free's native Shortcode widget — which is the part of this module worth deploying first.

## v1.1 addendum (2026-07-13, CMS-005A / OPERATION PHOENIX) — catalogue revision

A newer client-approved 9-service catalogue supersedes the 7-service model §1–§3 above were written against. §1–§3 are left unedited above (they were the correct read of the evidence available on 2026-07-12) — this addendum records what changes and what doesn't.

**§1 is superseded, not wrong.** The live page's third list ("From audit to verified savings," including "Grant funding / Procurement support / Project delivery") was correctly excluded at the time as page-level process narrative, not a service. The new catalogue's own service #7, "Funding, Procurement & Project Delivery," now promotes that exact content into a named service — see `MIGRATION-REPORT-v1.1.md`. This isn't evidence §1's original reasoning was flawed; the client's own catalogue is what changed.

**§3's featured/non-featured distinction does not carry forward.** §3 read the old live page's "Five core service areas" vs. "Beyond the core" framing directly off the page copy — a real distinction that existed in that content. The new 9-service catalogue is a flat numbered list with no such distinction stated anywhere. **Decision: do not invent a primary/secondary split.** `featured_service` stays in the field group (still a legitimate general-purpose field) but is left at its default (`false`) for all 9 services in the v1.1 migration table, pending explicit client input. The field group's own `instructions` text on `featured_service` has been updated to remove the now-stale "core five" reference (see `acf-json/group_service_fields.json`).

**No new field added for "Service Phase."** The mission explicitly asked this to be evaluated: would a field grouping services by delivery phase (e.g. screening → design → delivery → assurance) add measurable value? Assessment: the client's numbered list (1–9) already gives an explicit, unambiguous order, which the existing `display_order` field already captures losslessly. A "Phase" field would require inventing a categorization scheme (which numbers belong to which phase) that isn't stated anywhere in the approved catalogue — that's exactly the kind of inference the mission's Repository Rules prohibit. **Recommendation: revisit only if/when the client explicitly groups the 9 services into phases themselves; don't pre-empt that grouping.** Not added in v1.1.

**No content fields populated for the new titles.** See `MIGRATION-REPORT-v1.1.md`'s "Content status" section — old sourced copy is not reused for renamed/merged titles, and no copy exists yet for the 5 new titles. `executive_summary`, `full_description`, and `key_benefits` are left blank for all 9 services in the v1.1 migration table; only `display_order` (taken directly from the client's own numbered list) is populated.

**Shortcode and templates reviewed, not changed.** `iep_services_grid_shortcode()` in `service-helper-functions.php` queries `cspt-service` by `display_order`/`featured_service` with no hardcoded count or title assumptions — it is already correct for 9 services with zero code changes. Same for `archive-cspt-service.php` and `single-cspt-service.php`, which delegate to the same shortcode/query shape. None of the three PHP files were modified for v1.1.

**Demo-content disposition changes favourably.** v1.0 had 7 real services against 9 demo `cspt-service` slots, recommending 2 be set to Draft. v1.1's 9 services against the same 9 (still-unmigrated, still-demo, reconfirmed live 2026-07-13) slots is a clean 1:1 replacement — no Draft handling needed. See `IMPLEMENTATION-GUIDE.md`.
