# CMS-009 — Resources Module: Deployment Package

**Status:** v1.0 — Ready for manual deployment. Nothing in this package has been applied to WordPress yet. Prepared under WCP-001 (Website Completion Program), Work Package 07.
**Generated:** 2026-07-19.
**Sources checked:** the live Resources page (post 984), the live Grants page (post 648), the Media Library, `KNOWLEDGE-SOURCES-001`/`CRN-001`/`PDC-001` and every `content/CONTENT-001-Services/` document, `CMS-002/006/007/008` (package format and technical pattern precedent).

## What this is — and what it is not

This package builds the **technical infrastructure** for a Resources/Downloads library: a `cspt-resource` CPT, an ACF field model, an authenticated write endpoint, and a `[iep_resource_grid]` shortcode. **It does not populate any real resources**, because none exist. Checked exhaustively before building this package (see `DECISIONS.md`): no guide, whitepaper, calculator, or funding-briefing content has been provided by the client anywhere in the repository's reviewed sources. The live Resources page (984) itself says as much — every one of its 3 categories reads "🔴 Coming soon," and its own footer copy says gated downloads are "to be wired to Mailchimp (MC4WP) when assets are ready." This is a genuine missing-client-content situation, not a gap in research.

Mission Control confirmed the "build infrastructure only" path directly rather than this being assumed — see the session record in `missions/WCP-001-Progress-Register.md`.

## Grid only — no individual detail pages

Same reasoning as Testimonials (WP-06): a downloadable resource has no narrative content of its own to carry a dedicated reading page — a visitor either downloads the file or doesn't. `[iep_resource_grid]` groups items under the 3 category headings already live on page 984, matching that page's existing visual language exactly (card layout, colours, `iep-card`-style hover treatment).

## The `gated` field is a flag, not a working gate

Every resource carries a `gated` true/false field, but this package deliberately does **not** implement email-capture enforcement. CRN-001 lists newsletter/email-capture implementation as an explicitly open decision — building real MC4WP gating now would mean guessing at a decision that isn't this package's to make. When `gated` is true, the shortcode renders the card without a working download link ("Registration required — coming soon") rather than either leaking the file publicly or fabricating a fake gate. See `DECISIONS.md`.

## Adaptive CPT handling (same proven pattern as CMS-008)

`wp_get_post_types` confirmed no `cspt-resource`/`cspt-download`-style type is currently REST-visible, but that only rules out REST-visible types. The Code Snippet checks `post_type_exists('cspt-resource')` at runtime and retrofits or registers fresh accordingly, same discipline as Testimonials.

## Package contents

```
CMS-009-Resources/
├── README.md
├── IMPLEMENTATION-GUIDE.md      — deployment steps (no content migration table — none exists yet)
├── VERIFICATION.md
├── ROLLBACK.md
├── CHANGELOG.md
├── DECISIONS.md
├── repository-update.md
├── acf-json/
│   └── group_resource_fields.json
└── php/
    └── resource-helper-functions.php
```

## Read `DECISIONS.md` before deploying

Covers: why no content is populated, the CPT-vs-native-Media architecture call, the `gated`-flag-without-enforcement decision, and two adjacent findings flagged but *not* acted on — the separate "Grants" page (648, real content but stale/orphaned from nav) as a possible future seed, and the Resources page itself not being in the main navigation.

## Also fixed this session, unrelated to this package

Two broken icon classes on the live Resources page (984) — `fa-file-lines` and `fa-hand-holding-dollar`, both FA6-only names invalid on this site's bundled Font Awesome 5.15.3 — were found (4th instance of this exact recurring bug on this site) and fixed directly in the database, independently re-verified. Replaced with `fa-file-alt` and `fa-hand-holding-usd`. Not part of this package; noted here for completeness.

## What's being replaced

Nothing, yet. Page 984's existing "Coming soon" cards are left untouched — swapping in `[iep_resource_grid]` before any real resource exists would make the page *worse* (an empty grid) rather than better. See `IMPLEMENTATION-GUIDE.md`.
