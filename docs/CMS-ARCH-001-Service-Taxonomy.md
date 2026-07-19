---
id: CMS-ARCH-001
title: Service Taxonomy Architecture
purpose: Specifies the Service Category taxonomy that governs how the 9 approved services are organised, queried, and presented
status: Materialized — pending deployment (CMS-005A)
lifecycle: Materialized
owner: TBD
last_updated: 2026-07-13
---

# CMS-ARCH-001 — Service Taxonomy Architecture

## Purpose

Introduces a reusable, repository-driven organisational layer between the 9 approved services (`CONTENT-001`–`CONTENT-003`) and how they're presented on the site. Before this, the only ordering mechanism was `display_order` — a single flat sequence with no grouping. This architecture adds a `service_category` taxonomy so services can be grouped, queried, and displayed by category, without any of that grouping logic being hardcoded into a template or shortcode.

This does not change which 9 services exist, their titles, their content, or their capability-assignment rules (`CONTENT-002A`) — it adds a presentation-organising layer on top of an unchanged foundation.

## Architecture

```
Repository (CONTENT-001–003, CONTENT-002A capability rules)
        ↓
Service Category Taxonomy (this document)
        ↓
Display Order (reused from CMS-005, not duplicated)
        ↓
Dynamic Template ([iep_services_by_category] shortcode)
        ↓
Website (Services page, page 970)
```

Each layer only depends on the layer above it. The shortcode at the bottom has no knowledge of which services exist or what order they're in — it asks the taxonomy and the `display_order` field, and renders whatever they say. Adding, removing, or re-categorising a service is a content change (wp-admin), never a code change.

## Taxonomy Structure

**Taxonomy:** `service_category`
- Slug: `service_category`
- Attached to: `cspt-service`
- Public: yes
- Hierarchical: yes
- REST-enabled: yes (`show_in_rest: true`)
- Admin column + UI: yes

**Terms** (3, non-hierarchical in practice — no parent/child terms currently defined, though the taxonomy itself supports them for future use):

| Term | Slug | Description |
|---|---|---|
| Engineering Systems | `engineering-systems` | Integrated engineering solutions improving industrial performance, resource efficiency and sustainable infrastructure. |
| Project Development & Delivery | `project-development-delivery` | Engineering support throughout the project lifecycle from opportunity assessment through design, funding and delivery. |
| Advanced Engineering & Innovation | `advanced-engineering-innovation` | Specialist engineering capability supporting optimisation, technology development and continuous operational improvement. |

## Relationships

Each of the 9 services belongs to exactly one category — a straightforward one-to-many relationship (`wp_set_object_terms(..., false)`, not appending), not a many-to-many. This mirrors `CONTENT-002A`'s own Stage × Domain model reasonably closely, though the two are not identical mappings — worth stating plainly since a reader familiar with `CONTENT-002A` might otherwise assume they're the same grouping:

| CMS-ARCH-001 Category | Services | Nearest CONTENT-002A concept |
|---|---|---|
| Engineering Systems | Energy/Utilities/Process Efficiency, Water/Wastewater, Low-carbon Energy | The 3 **Domain** services |
| Project Development & Delivery | Opportunity Screening, Engineering Design/Feasibility, Funding/Procurement/Delivery | The 3 **Stage** services (excluding Monitoring, not yet content-ready) |
| Advanced Engineering & Innovation | Product Design & Optimisation, AI-enabled Monitoring, Technology Innovation & R&D | A mix of `CONTENT-002A`'s Supporting Capability (Product Design), Stage-but-Pending (AI Monitoring), and Adjacent Offering (Technology Innovation & R&D) |

The third category groups three services `CONTENT-002A` had classified as three *different* kinds of thing (a supporting capability, a pending/unready service, and a parallel-track offering) under one presentation label, "Advanced Engineering & Innovation." This is a **presentation-layer grouping**, not a claim that `CONTENT-002A`'s classification was wrong — the taxonomy is free to group services for display purposes in ways that don't mirror the underlying constitutional classification. Worth flagging for whoever next touches this: **Service 8 (AI-enabled Monitoring, Assurance & Continuous Improvement) is still Pending per `CONTENT-002A`/`CONTENT-003`** — it appears in this taxonomy's Advanced Engineering & Innovation category with a real display card, meaning its (currently blank) `executive_summary` will render as a card with a title and no summary text once this taxonomy's shortcode is live. That's a known, accepted state (the shortcode's `if ($summary)` guard means the card doesn't look broken, just sparse) — not a defect in this taxonomy, but a downstream consequence of Service 8's content status that this document flags rather than silently carries forward.

## Rendering Flow

1. `[iep_services_by_category]` calls `get_terms()` for `service_category`, ordered by `term_id` (insertion order — Engineering Systems, then Project Development & Delivery, then Advanced Engineering & Innovation, matching this mission's specified category order).
2. For each term, a `WP_Query` fetches its `cspt-service` posts via `tax_query`, ordered by `display_order` (reused CMS-005 field).
3. Each term renders as: category heading → category description → a flex-wrap grid of cards (title + `executive_summary`, same card markup as `[iep_services_grid]`).
4. A category with zero assigned services (shouldn't occur given the 9/3 assignment, but handled defensively) is skipped, not rendered as an empty heading.

## Future Extensions

The mission's stated future-compatibility goals are addressed by the taxonomy's own registration, not by additional code:

- **Related services** — any two services sharing a category are trivially queryable via the taxonomy relationship; no new field or logic needed.
- **Industry landing pages** — a future `industry` taxonomy could cross-reference `service_category` the same way, once industry content exists.
- **Search filters** — `show_in_rest: true` makes `service_category` filterable via `/wp/v2/service_category` and (once/if `cspt-service` itself gains a REST route) via the standard `tax_relation` query parameter pattern.
- **REST API** — the taxonomy endpoint itself is REST-accessible today, independent of `cspt-service`'s own REST status (see Repository Dependencies below for what that status currently blocks).
- **Navigation generation, sitemap generation, knowledge graph relationships** — all standard WordPress taxonomy capabilities, inherited for free from `register_taxonomy()`'s `public`/`show_in_rest` flags — no bespoke code required, consistent with the mission's "no additional code changes should be required" goal.

## Repository Dependencies

- **Depends on `CMS-005`:** the `display_order` and `executive_summary` ACF fields, and the 9 populated `cspt-service` titles this taxonomy's seeding step matches against.
- **Depends on `CONTENT-001`–`CONTENT-003`:** the 9 approved service titles and their content status (specifically, why Service 8's card will render sparse — see Relationships above).
- **Informed by, but not identical to, `CONTENT-002A`'s Stage × Domain model** — see Relationships above for the explicit divergence.
- **Does not depend on, or modify, `PDC-001` or `PDC-A001`** — this is a Specification-layer document (per `KNOWLEDGE-SOURCES-001`'s Repository Knowledge Model), not a constitutional one; it implements existing Constitution, it doesn't amend it.
- **Blocked from full REST exposure by the same wall documented since `CMS-002`:** `cspt-service` itself still has no REST route. This taxonomy's own REST accessibility (`show_in_rest: true`) is real and immediate, but a future integration wanting "get all services in category X via one REST call" still can't use `cspt-service`'s own endpoint — it doesn't exist. That's an existing, unrelated limitation this taxonomy doesn't fix and wasn't asked to fix.
