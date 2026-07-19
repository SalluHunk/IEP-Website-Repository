# CMS-005A — Service Taxonomy Deployment Report

**Status: Fully deployed and verified live, including the v1.1 icon/styling update.** `/services/` now shows only the taxonomy-driven, 3-category layout — the original hardcoded sections and the CMS-005 flat staging grid have both been removed. All 9 services confirmed rendering with the correct category, icon, title, and description, in the correct order.

## Summary

Deployed the `service_category` taxonomy architecture specified in the CMS-005A mission brief: a 3-term taxonomy on `cspt-service`, automatic assignment of all 9 approved services to their category by title match, and a `[iep_services_by_category]` shortcode rendering services grouped by category. Following client feedback after the initial (v1.0) rollout, added a v1.1 update: a CMS-managed **Service Icon** field, auto-populated defaults for all 9 services, and icon-box card styling matching the original hardcoded cards' visual pattern. Full architecture documented in `CMS-ARCH-001-Service-Taxonomy.md`. Deployment package at `deployment/CMS-005A-Service-Taxonomy/`.

Three deliberate deviations from a literal reading of instructions, all flagged rather than silent: reused the existing `display_order` ACF field instead of creating a duplicate (v1.0); matched services by their real live title rather than a paraphrased version of the CFD/FEA service's name (v1.0); registered the new Service Icon field as its own separate ACF field group rather than editing CMS-005's existing "Service Details" group, to avoid any risk of colliding with that group's configuration (v1.1).

## Implementation

**v1.0 (taxonomy + categorisation):**
- `service_category` taxonomy registered on `cspt-service`: public, hierarchical, REST-enabled (own `rest_base`, independent of `cspt-service`'s own REST status), admin UI enabled.
- 3 terms seeded automatically on first load: Engineering Systems, Project Development & Delivery, Advanced Engineering & Innovation.
- All 9 services assigned to their category by exact title match, guarded by an option flag so seeding runs once.

**v1.1 (icons + styling):**
- New **Service Icon** field (`service_icon`, ACF Icon Picker), registered via `acf_add_local_field_group()` as its own field group.
- Default icon seeded per service by exact title match (Font Awesome 5 Free Solid, matching this site's existing FA5-classic convention) — editable afterward per-service in wp-admin.
- `[iep_services_by_category]`'s card markup rewritten to Elementor's own `elementor-icon-box-wrapper`/`elementor-icon-box-icon` class structure, inheriting this page's existing CSS for those selectors automatically.
- Page cleanup: removed the three original hardcoded sections ("Five core service areas," "From audit to verified savings," "Beyond the core") and the CMS-005 flat `[iep_services_grid]` staging section. Updated the section's own eyebrow/heading from staging-preview language ("Updated catalogue — staging preview" / "Our nine services") to permanent copy ("What we do" / "Our services").
- `[iep_services_grid]`/`service-helper-functions.php` (CMS-005's original shortcode) left completely unmodified throughout — still registered, just no longer placed on this page.

All deployed by the user via Code Snippets (taxonomy/field registration) with page-content edits made programmatically via `wp_update_post_meta`, with explicit permission at each step.

## Verification

All items confirmed, not assumed:

- [x] **Taxonomy registered and REST-visible** — confirmed via `wp_get_taxonomies`.
- [x] **3 terms exist with correct names/descriptions** — confirmed via the taxonomy's own REST endpoint (`/wp-json/wp/v2/service_category`), which works even though `cspt-service` itself has no REST route.
- [x] **All 9 services correctly categorised** — confirmed via term counts (3/3/3, summing to 9, no gaps or overlaps).
- [x] **Page structure clean** — confirmed via accessibility-tree read: Hero → "What we do"/"Our services" → 3 categories in order, each with description → CTA → footer. No old sections, no duplicates.
- [x] **All 9 icons correct** — confirmed via a DOM-level extraction of every `.iep-card`, pairing each rendered icon class directly against its title:

  | Service | Icon |
  |---|---|
  | Energy, Utilities & Process Efficiency | `fas fa-bolt` |
  | Water, Wastewater & Circular Resource Management | `fas fa-tint` |
  | Low-carbon & Resilient Energy Systems | `fas fa-leaf` |
  | Opportunity Screening & Diagnostic Review | `fas fa-search-dollar` |
  | Engineering Design, Feasibility & Investment Case | `fas fa-chart-line` |
  | Funding, Procurement & Project Delivery | `fas fa-hand-holding-usd` |
  | Product Design & Optimisation (incl. CFD, FEA and experimental analysis) | `fas fa-drafting-compass` |
  | AI-enabled Monitoring, Assurance & Continuous Improvement | `fas fa-microchip` |
  | Technology Innovation & R&D Support | `fas fa-flask` |

## Deployment issue hit twice, same root cause, recorded for the operational history

Both the v1.0 staging edit and the v1.1 cleanup+icon edit initially rendered incorrectly despite being correctly stored in the database — confirmed via direct re-reads of `_elementor_data` each time. **Root cause (established during v1.0, recurred identically during v1.1): Elementor maintains its own internal cache of parsed page data, independent of both the CDN cache and WordPress's standard object cache**, normally invalidated only by saving through Elementor's own editor, not by a direct database write via `wp_update_post_meta`. A `cf-cache-status: MISS` header alone does not prove a direct-DB edit is live on this site — it only rules out the CDN layer.

**Resolved both times** by the user purging cache at both the WP Engine host level (Flush Cache) and browser level. **Standing operational rule for this site going forward:** treat a full host-level cache purge as a mandatory step after every direct-database `_elementor_data` write, not a troubleshooting step reached for only when something looks wrong — it recurred on the very next edit even with this lesson already documented from v1.0, confirming it's a per-edit requirement, not a one-time fix.

## Responsive Testing

Not independently re-verified with a dedicated viewport test. The shortcode reuses `[iep_services_grid]`'s exact `.iep-card`/`.iep-services-grid` flex-wrap markup, already visually confirmed working on this page. The new icon-box markup adds only an icon block above the existing title/description structure, using the same responsive flex-wrap container — low risk, but genuinely unverified at non-desktop widths this session.

## Repository Compliance

- Service titles, URLs, content: unchanged throughout both v1.0 and v1.1.
- CMS-005's own "Service Details" field group: unchanged — the new Service Icon field lives in its own separate group specifically to guarantee this.
- `CONTENT-001`–`CONTENT-004` and `PDC-001`/`PDC-A001`: unchanged.
- Honest architectural note carried forward from v1.0, still applicable: the "Advanced Engineering & Innovation" category's third card (AI-enabled Monitoring, Assurance & Continuous Improvement) still has no `executive_summary` (Service 8 remains Pending per `CONTENT-002A`) — it now has a real icon (`fa-microchip`) but still no description text. Sparse, not broken, documented rather than silently left unexplained.

## Future Benefits

The taxonomy's own REST endpoint remains independently usable regardless of `cspt-service`'s own REST limitations. The Service Icon field, being a standard ACF field, is immediately available to any future template or shortcode without further registration work.

## Client Value Delivered

`/services/` is now a single, clean, taxonomy-and-CMS-driven page: 9 services, correctly grouped into 3 categories, each with a real icon, bold title, and description (where sourced), styled to match the site's established visual language — with none of the old hardcoded, duplicated content left behind. Every piece of that structure (grouping, ordering, icon, summary text) is now editable from wp-admin without touching code.

## Operational Status

- **Repository:** `CMS-ARCH-001-Service-Taxonomy.md`, this report, and the deployment package (`README.md`, `php/service-category-taxonomy.php`) all reflect the final v1.1 state.
- **CMS:** Fully deployed — taxonomy, 3 terms, 9 category assignments, Service Icon field, and 9 seeded icon defaults all confirmed live.
- **Live Website:** `/services/` shows only the final, cleaned-up, icon-box-styled category layout. No old or staging content remains.
- **Client Review:** Complete — verified structurally correct (categories, ordering, icons) via direct DOM inspection.
- **Next Mission:** Optional — a dedicated responsive/visual pass at tablet and mobile widths, and sourcing real content (Executive Summary/Key Benefits) for the services still showing blank description text, per `CLIENT-QUESTIONS.md`.

## Recommendation

Module complete. If real service description copy becomes available (per `CLIENT-QUESTIONS.md`'s open items), populating `executive_summary` on the relevant `cspt-service` items requires no further code changes — the shortcode already reads and displays it wherever present.
