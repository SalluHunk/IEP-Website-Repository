# CMS-005A — Implementation Guide

## Prerequisite

CMS-005 Steps 1–4 must already be live: the "Service Details" ACF field group imported, and all 9 `cspt-service` items retitled with `display_order` set (1–9). This package reads both of those to build the category assignments and the grid — if they're not in place, the seeding step will run but find nothing to categorise, and the shortcode will render nothing.

## Step 1 — Deploy the taxonomy + seeding + shortcode

Code Snippets → Add New → `CMS-005A — Service Category Taxonomy` → paste `php/service-category-taxonomy.php` → run **Everywhere** → Activate.

This single snippet does three things automatically on activation, no further action needed:
1. Registers the `service_category` taxonomy.
2. Creates the 3 category terms and assigns each of the 9 services to one, by exact title match.
3. Registers the `[iep_services_by_category]` shortcode.

## Step 2 — Verify the taxonomy and assignments

1. In wp-admin, open any `cspt-service` item's edit screen — you should now see a "Service Categories" panel (from `show_ui: true`), with one category checked.
2. Check all 9 items — each should have exactly one category checked, matching the assignment table below.
3. **If any service shows no category checked:** the title match failed for that item — check the site option `iep_service_category_unmatched` (via a debug plugin, or ask a developer to check `get_option('iep_service_category_unmatched')`) — the snippet records any title it couldn't match rather than failing silently. The most likely cause is the item's title not exactly matching the approved title (extra whitespace, a typo, or the CFD/FEA service's title differing from what's expected — see README.md's note on this).

| Category | Services |
|---|---|
| Engineering Systems | Energy, Utilities & Process Efficiency · Water, Wastewater & Circular Resource Management · Low-carbon & Resilient Energy Systems |
| Project Development & Delivery | Opportunity Screening & Diagnostic Review · Engineering Design, Feasibility & Investment Case · Funding, Procurement & Project Delivery |
| Advanced Engineering & Innovation | Product Design & Optimisation (incl. CFD, FEA and experimental analysis) · AI-enabled Monitoring, Assurance & Continuous Improvement · Technology Innovation & R&D Support |

## Step 3 — Preview the new rendering (staging, same pattern as CMS-005 Step 5)

In the Elementor editor on page 970 (Services), add a **Shortcode** widget containing `[iep_services_by_category]` — place it near, but not replacing, the existing content, same "add alongside, verify, then remove" approach used for CMS-005. Compare visually against the current flat 9-card section:

- 3 category headings, each with its description paragraph, each followed by exactly 3 service cards.
- Cards within each category ordered by `display_order` (so within "Engineering Systems," Energy/Utilities should come before Water/Wastewater, which comes before Low-carbon).
- No service appears twice, and no service is missing.

## Step 4 — Replace the flat layout

Once Step 3 is confirmed correct, remove the flat `[iep_services_grid]` staging section (added during CMS-005 Step 5) and the three original hardcoded rows ("Five core service areas," "From audit to verified savings," "Beyond the core") — leaving only the new `[iep_services_by_category]` section as the page's service content. Do this only after visual confirmation, not before — same discipline as every prior module in this project.

## Rollback

1. Remove the `[iep_services_by_category]` shortcode from page 970's Elementor content (or revert to the pre-CMS-005A page content, if a backup was taken before Step 4).
2. Delete the `CMS-005A — Service Category Taxonomy` Code Snippet. This immediately breaks the `[iep_services_by_category]` shortcode — revert the page content **before** deleting the snippet, not after, to avoid a visibly broken section in between.
3. The taxonomy registration and term assignments themselves are otherwise inert once the snippet is removed — `service_category` simply stops being registered, and the term data remains in the database (orphaned, harmless) unless separately cleaned up. No data loss to the 9 `cspt-service` items' own content (title, `display_order`, `executive_summary`, etc.) — only the category relationship is affected.
4. If full cleanup of the orphaned taxonomy data is wanted later, that requires a one-time PHP snippet to delete the `service_category` terms and their relationships — not included in this package since it's a "someday, if ever" action, not part of normal rollback.

## Verification checklist

- [ ] `service_category` taxonomy registered (visible in wp-admin on `cspt-service` edit screens).
- [ ] 3 terms exist: Engineering Systems, Project Development & Delivery, Advanced Engineering & Innovation.
- [ ] All 9 services have exactly one category assigned, matching the table above.
- [ ] `iep_service_category_unmatched` option is empty/unset (confirms all 9 titles matched).
- [ ] `[iep_services_by_category]` renders 3 sections, each with heading + description + 3 cards, no duplicates, no omissions.
- [ ] Cards within each category are ordered by `display_order`.
- [ ] Responsive check: 3-column grid collapses sensibly on tablet/mobile (reuses `.iep-card`/`.iep-services-grid` flex-wrap behaviour already proven on `[iep_services_grid]` — no new responsive logic introduced).
- [ ] Existing `/services/` URL unchanged; no new URLs introduced (the `rewrite: 'service-category'` slug in the taxonomy registration doesn't create a public archive page interaction the client needs to worry about — it's a REST/query-var convenience, not a new navigable URL in current scope).
- [ ] `[iep_services_grid]` (CMS-005's original shortcode) still works unmodified, for as long as it remains on the page.
