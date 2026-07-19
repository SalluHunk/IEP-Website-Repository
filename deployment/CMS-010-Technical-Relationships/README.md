# CMS-010 — Technical Relationships Module: Deployment Package

**Status:** v1.0 — Ready for manual deployment. Nothing in this package has been applied to WordPress yet. Prepared under WCP-001 (Website Completion Program), Work Package 08.
**Generated:** 2026-07-19.
**Sources used:** live Case Study content (all 6, full Challenge/Solution/Results/Commercial Impact text + existing `cspt-portfolio-category` assignment), the live Industry Sector list (all 8), the 9 real Service titles (from `CMS-005A-Service-Taxonomy-Deployment-Report.md` — `cspt-service` itself isn't readable via REST yet, see below), `CMS-002/006/007/008/009` (package format and technical pattern precedent).

## What this is

Wires three relationship pairs across the site's real content:
- **Case Study ↔ Industry Sector** — which real sectors each of the 6 case studies belongs to, beyond the existing flat 3-term category.
- **Case Study ↔ Service** — which of the 9 real services were actually used on each project, traced from each case study's own Challenge/Solution/Results text.
- **Industry Sector ↔ Service** — which services are typically relevant per industry.

All three are genuinely bidirectional: relating A to B also updates B's own relationship field, and un-relating removes it from both sides — see `php/relationship-helper-functions.php`'s `iep_sync_relationship()`.

## Testimonials are NOT part of this package — a deliberate exclusion, not an oversight

Presented directly to Mission Control before building anything: should Testimonials link to Case Studies? Case Studies were anonymised at the client's explicit request (no Client/Address fields exist anywhere in that module — see WP-04's `DECISIONS.md`). Even a bare UI relationship (no visible label claiming "this is the same project") between a named testimonial (Ultra Tough Ltd, York Handmade, Harsco Environmental, Naylor Industries Plc) and a specific anonymised case study risks a visitor inferring the real company behind the anonymisation — which would defeat the point of anonymising it. Mission Control confirmed: **keep them separate.** See `DECISIONS.md`.

## Prerequisite fix bundled in: Services has never had a REST/MCP path

Checked before scoping anything: `wp_get_post_types` doesn't list `cspt-service` at all — unlike Leadership/Case Studies/Industries/Testimonials/Resources, Services never got the standard REST retrofit, because `CMS-005`/`CMS-005A` only ever wrote to it via direct `get_posts()`/`update_field()` calls inside a Code Snippet, never through REST. This package closes that gap the same proven way as every other module (Part 1 of the PHP file), which is a prerequisite for the two relationship pairs that touch Services.

## Not all relationship data is populated in this session — a real, disclosed limitation

Because `cspt-service` has no REST/MCP path *yet*, this package's migration tables were built by reading the 9 real service titles from `CMS-005A`'s own deployment report (verified content, not guessed) rather than a live query — but **populating** the two Services-touching relationship pairs (Case Study↔Service, Industry↔Service) requires the Code Snippet to actually be installed first, so the endpoint can look up real Service post IDs. Case Study↔Industry Sector has no such dependency and can be populated the same session the snippet goes live. See `IMPLEMENTATION-GUIDE.md`.

## Two mapping tables are evidence-grounded; one is editorial synthesis — read `DECISIONS.md`

- **Case Study ↔ Industry Sector** and **Case Study ↔ Service**: every link traces to either the case study's existing sector-taxonomy assignment or explicit language in its own Challenge/Solution/Results text (e.g. "government funding secured" → Funding, Procurement & Project Delivery). Not invented.
- **Industry Sector ↔ Service**: no source document maps this anywhere in the repository. Mission Control explicitly authorized building it anyway as reasoned domain judgment (standard engineering-consultancy service-to-sector relevance), clearly flagged as such rather than presented as sourced fact. Recommend a review pass once real content exists to check it against.

## Package contents

```
CMS-010-Technical-Relationships/
├── README.md
├── IMPLEMENTATION-GUIDE.md      — deployment steps + all 3 relationship migration tables
├── VERIFICATION.md
├── ROLLBACK.md
├── CHANGELOG.md
├── DECISIONS.md
├── repository-update.md
└── php/
    └── relationship-helper-functions.php
```

No `acf-json/` directory this time — all 6 relationship fields are registered in PHP via `acf_add_local_field_group()` (same pattern CMS-005A used for "Service Icon"), so there's no separate ACF import step.

## What's being displayed

A new `[iep_related type="industries|services|case_studies"]` shortcode, droppable into any Case Study, Industry Sector, or Service detail page to show a chip-row of linked items. Not swapped into any live page by this package — same "optional, your call" pattern as every prior module's shortcode.
