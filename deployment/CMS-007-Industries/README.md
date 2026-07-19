# CMS-007 — Industries Module: Deployment Package

**Status:** v1.0 — Ready for manual deployment. Nothing in this package has been applied to WordPress yet. Prepared under WCP-001 (Website Completion Program), Work Package 05.
**Generated:** 2026-07-18.
**Sources used:** the live Industries page (post 971, read directly this session — 8 hardcoded sector cards, already-approved copy), `missions/WCP-001-Progress-Register.md` (WP-05 brief), `CMS-002-Leadership/` and `CMS-006-Case-Studies/` (package format and technical pattern precedent).

## What this is

Registers a **brand-new** `cspt-industry-sector` CPT and migrates the 8 real industry sectors already live on page 971 into it, with individual detail pages at `/industry-sector/{slug}/`.

## Why a new CPT, not a repurposed one

Unlike Leadership (`cspt-team-member`) and Case Studies (`cspt-portfolio`), there is no pre-existing Greenly demo CPT for Industries — tested `/industry/`, `/sector/`, `/sectors/` live before writing this package; all returned 404. Registering a new CPT here does not violate the repository's standing rule against parallel/duplicate post types, since nothing existing is being duplicated.

## Individual detail pages: user's explicit choice

The live page's 8 cards have no "read more" links or embedded note implying sub-pages (unlike Case Studies' page, which had one). Presented to Mission Control as a real architecture decision rather than assumed: build a grid-only CMS (matching Services' shape), a CPT with detail pages now, or a lighter repeater field with no CPT at all. **Mission Control chose CPT + individual detail pages**, for future expansion — this package implements that.

## Package contents

```
CMS-007-Industries/
├── README.md
├── IMPLEMENTATION-GUIDE.md      — deployment steps + full 8-sector content migration table
├── VERIFICATION.md
├── ROLLBACK.md
├── CHANGELOG.md
├── DECISIONS.md
├── repository-update.md
├── acf-json/
│   └── group_industry_sector_fields.json
└── php/
    └── industry-sector-helper-functions.php
```

## Read `DECISIONS.md` before deploying

Two things worth knowing: (1) the **Overview** field ships blank for all 8 sectors — no richer per-sector narrative exists in any reviewed source beyond the card-length summary already live, and nothing here fabricates filler content to fill it; (2) **icon values were empirically verified**, not guessed — this site's actual Font Awesome version (5.15.3) was confirmed live, and every icon in the migration table was tested via `getComputedStyle(el, '::before').content` before being used, after two prior modules (Case Studies, and this same Industries page) shipped invalid FA6-only icon names that rendered blank.

## No relationship wiring yet

This package does not link industry sectors to Services or Case Studies (e.g. "which case studies serve this sector"). That cross-linking is explicitly WP-08's scope per `missions/WCP-001-Progress-Register.md`, once WP-04–07 content all exists — not decided or partially wired here.

## What's being replaced

The live Industries page (971) is not touched by this package's core migration — its 8 hardcoded Elementor cards keep their current (already-approved) copy. This package builds the CMS layer underneath, same pattern as Case Studies. Swapping the cards for `[iep_industry_grid]` is optional — see `IMPLEMENTATION-GUIDE.md`.

## Related fix already applied this session (not part of this package)

While auditing this page's icons for the migration table, 3 pre-existing broken icons on the live page (971) were found and fixed directly (`fa-droplet`→`fa-tint`, `fa-magnifying-glass`→`fa-search`, `fa-chart-simple`→`fa-chart-line`) — same Font Awesome 5-vs-6 issue documented in `CMS-006-Case-Studies/CHANGELOG.md` v1.3. This was a direct live fix, not part of this deployment package, and is recorded in `missions/WCP-001-Progress-Register.md`'s WP-05 entry.
