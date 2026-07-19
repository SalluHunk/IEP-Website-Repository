# CMS-005A — Service Category Taxonomy: Deployment Package

**Status:** v1.0 deployed and verified live 2026-07-13 (taxonomy, 3 terms, all 9 categorised). **v1.1 update ready, not yet deployed** — adds a Service Icon field and icon-box card styling; requires re-pasting the updated `php/service-category-taxonomy.php` into the same Code Snippet.
**Generated:** 2026-07-13. **Depends on:** CMS-005 (Steps 1–4 must be live — the `display_order`/`executive_summary` ACF fields and the 9 populated `cspt-service` titles this taxonomy assigns categories to).

## v1.1 update (2026-07-14)

Following client feedback after v1.0 went live, added:
- **Service Icon** — a new ACF field (`service_icon`, Icon Picker), registered as its own small field group via `acf_add_local_field_group()` rather than editing CMS-005's JSON-imported "Service Details" group, so it can't collide with or overwrite that group's existing configuration.
- **Automatic default icons** for all 9 services, seeded by exact title match (same pattern as category assignment) — Font Awesome 5 Free Solid icons, matching this site's existing FA5-classic icon convention. Editable afterwards per-service in wp-admin like any other field.
- **Icon-box card markup** — `[iep_services_by_category]`'s cards now use Elementor's own `elementor-icon-box-wrapper`/`elementor-icon-box-icon` class names, so they inherit this page's existing CSS for those selectors (background, border, hover lift) automatically — the same visual pattern the original hardcoded cards used, with no new CSS required.

**To deploy v1.1:** open the existing `CMS-005A — Service Category Taxonomy` Code Snippet in wp-admin and replace its contents with the updated `php/service-category-taxonomy.php`, then save/activate again. The taxonomy and category assignments (already seeded) are untouched — only the new field registration, icon seeding, and shortcode rendering are added.

## What this is

Introduces a `service_category` taxonomy on `cspt-service`, seeds 3 approved category terms, assigns each of the 9 approved services to one category by title match, and ships a new shortcode — `[iep_services_by_category]` — that renders the services grouped by category instead of as one flat 9-card list.

Per this mission's own Architectural Principle ("Presentation shall never determine structure. Repository metadata shall determine presentation."), the grouping lives entirely in the taxonomy + `display_order` field, not in the shortcode's PHP — the shortcode only reads and renders what the taxonomy says. Adding a 10th service to a category later, or reordering categories, is a wp-admin content change, not a code change.

## Two implementation decisions made while building this, flagged rather than silent

1. **No new "Display Order" field was created.** The mission brief describes introducing one, but `display_order` already exists on CMS-005's "Service Details" field group, already populated on all 9 services, and already used by `[iep_services_grid]`. Creating a second field with the same purpose would duplicate data and risk the two falling out of sync. `[iep_services_by_category]` reuses the existing field.
2. **Service title matching uses the real, live, client-approved title for the CFD/FEA service** — `"Product Design & Optimisation (incl. CFD, FEA and experimental analysis)"` — not the mission brief's own shortened paraphrase (`"...CFD, FEA & Experimental Analysis)"`). Since the mission's Repository Rules state service titles shall not change, matching must use the actual title; using the brief's paraphrase would have silently failed to categorise that one service.

## Package contents

```
CMS-005A-Service-Taxonomy/
├── README.md                    — this file
├── IMPLEMENTATION-GUIDE.md       — deployment steps, verification, rollback
└── php/
    └── service-category-taxonomy.php   — taxonomy + seeding + shortcode (Code Snippet)
```

## What this does NOT touch

- `[iep_services_grid]` and `service-helper-functions.php` (CMS-005) are unmodified — this ships a new shortcode alongside the old one, per the mission's Repository Rule preserving "Existing shortcode architecture."
- No service titles, URLs, content, or ACF field structure changed.
- No constitutional documents (`PDC-001`, `PDC-A001`, `CONTENT-001` through `CONTENT-004`) changed.

## Companion documents

- `docs/CMS-ARCH-001-Service-Taxonomy.md` — the architecture specification (purpose, structure, rendering flow, future extensions).
- `docs/CMS-005A-Service-Taxonomy-Deployment-Report.md` — status report, updated once deployed and verified.
