# CMS-008 — Testimonials Module: Deployment Package

**Status:** v1.0 — Ready for manual deployment. Nothing in this package has been applied to WordPress yet. Prepared under WCP-001 (Website Completion Program), Work Package 06.
**Generated:** 2026-07-18.
**Sources used:** the live Testimonials page (post 1062, read directly this session — 4 real, fully-written testimonials, already-approved copy), the Media Library (logos and one real headshot already uploaded), `CMS-002/006/007` (package format and technical pattern precedent).

## What this is

Migrates the 4 real, already-live testimonials (Ultra Tough Ltd, York Handmade, Harsco Environmental, Naylor Industries Plc) into a CMS-editable `cspt-testimonial` CPT, rendered as a card grid/wall via `[iep_testimonial_grid]`.

## Grid only — no individual detail pages

Unlike Case Studies and Industries, Mission Control chose **grid/wall display only** for this module — testimonials are quotes meant to be seen together, not standalone reading pages, and nothing in any source implies visitors need to read one in isolation.

## Adaptive CPT handling — a new pattern this package introduces

This site's wp-admin sidebar already shows a "Testimonials" menu item, strongly suggesting `cspt-testimonial` already exists (matching the `cspt-team-member` / `cspt-service` / `cspt-portfolio` precedent) — but CMS-006 already learned once that a guessed CPT slug for Case Studies turned out wrong (`cspt-case-study` doesn't exist; the real one was `cspt-portfolio`). Rather than repeat that guess, this package's Code Snippet checks `post_type_exists('cspt-testimonial')` **at runtime** and retrofits REST support if it exists, or registers it fresh if it doesn't — either way works correctly without needing to know in advance which branch applies. See `DECISIONS.md`.

## Package contents

```
CMS-008-Testimonials/
├── README.md
├── IMPLEMENTATION-GUIDE.md      — deployment steps + full 4-testimonial content migration table
├── VERIFICATION.md
├── ROLLBACK.md
├── CHANGELOG.md
├── DECISIONS.md
├── repository-update.md
├── acf-json/
│   └── group_testimonial_fields.json
└── php/
    └── testimonial-helper-functions.php
```

## Read `DECISIONS.md` before deploying

Two things worth knowing: (1) **Person Photo is genuinely optional and mostly blank** — only 1 of the 4 real testimonials (Kim Beighton) has a real photo live today; the other 3 show a 2-letter initials avatar, and the shortcode preserves that exact fallback behaviour rather than inventing photos; (2) two of these four clients (Ultra Tough, York Handmade) have **actual signed recommendation letter PDFs** already in the Media Library, corroborating the testimonials as genuine, not just copy someone wrote — noted for context, not wired into the CMS as a field (out of scope, flagged if wanted later).

## What's being replaced

The live Testimonials page (1062) is not touched by this package's core migration — its 4 hardcoded Elementor testimonial cards keep their current (already-approved) copy. This package builds the CMS layer underneath. Swapping the cards for `[iep_testimonial_grid]` is optional — see `IMPLEMENTATION-GUIDE.md`.
