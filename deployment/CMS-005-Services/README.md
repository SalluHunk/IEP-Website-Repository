# CMS-005 — Services Module: Deployment Package

**Status:** v1.1 — Ready for manual deployment. Nothing in this package has been applied to WordPress (confirmed live 2026-07-13: `cspt-service` still holds 9 published demo items, unchanged since v1.0).
**Generated:** 2026-07-12. **Revised:** 2026-07-13 (v1.1, mission CMS-005A / OPERATION PHOENIX — service catalogue replaced, see below).
**Sources used:** `PDC-001`, `CMS-001-Production-Migration-Strategy.md`, `CMS-003-Global-Settings/`, `CMS-004-Footer/`, `CRN-001-Client-Review-Notes.md`, `KNOWLEDGE-SOURCES-001.md`, and the current live Services page (970), read directly during v1.0 package preparation; the client's approved 9-service catalogue (CMS-005A mission brief) for v1.1.

## v1.1 — what changed

The client's approved service catalogue was replaced (7 services → 9). This is a **content/mapping revision, not an architecture change** — the CPT, field model, shortcode, and PHP templates from v1.0 are unchanged and remain correct for 9 services with zero code edits. See `MIGRATION-REPORT-v1.1.md` for the full old→new mapping and `DECISIONS.md`'s v1.1 addendum for what was and wasn't changed and why.

## What this is

Converts the existing `cspt-service` CPT — currently 9 published items, all unrelated Envato demo content (confirmed in `CMS-BOOT-002`, reconfirmed live 2026-07-13) — into the CMS-driven Services module, `CMS-001` sequenced third. Reuses the existing CPT; no new post type is created, per the mission's Repository Rules.

## Package contents

```
CMS-005-Services/
├── README.md
├── IMPLEMENTATION-GUIDE.md      — deployment steps + v1.1 migration table
├── MIGRATION-REPORT-v1.1.md     — old→new service catalogue mapping (merged/renamed/new/removed)
├── VERIFICATION.md
├── ROLLBACK.md
├── CHANGELOG.md
├── DECISIONS.md                 — every judgment call, with reasoning (v1.0 + v1.1 addendum)
├── repository-update.md
├── acf-json/
│   └── group_service_fields.json
└── php/
    ├── service-helper-functions.php     — CTA fallback logic + [iep_services_grid] shortcode (Code Snippet)
    └── recommended-templates/
        ├── archive-cspt-service.php     — future recommendation, needs SFTP
        └── single-cspt-service.php      — future recommendation, needs SFTP
```

## Read `DECISIONS.md` before deploying

This package deliberately ships a **9-field group**, not the 15 fields the mission's brief listed as candidates. Six were excluded or deferred with specific reasoning (native feature duplication, no target CPT/taxonomy yet, no verified content to justify them) — `DECISIONS.md` explains each one. This isn't a partial implementation; it's the field model the verified evidence actually supports today. A "Service Phase" field was evaluated for v1.1 and not added — reasoning in `DECISIONS.md`'s v1.1 addendum.

## The practical path to real value, without SFTP

Like `CMS-004`, this module has one piece that needs file/SFTP access (the recommended `single`/`archive` PHP templates) and one piece that doesn't: the **`[iep_services_grid]` shortcode**, deployable via Code Snippets, droppable into the *existing* live Services page through Elementor free's native Shortcode widget. That's the deployment path this package actually recommends first — see `IMPLEMENTATION-GUIDE.md`.

## What's being replaced

All 9 `cspt-service` items currently hold demo content unrelated to IEP (e.g. "Solar As A Service," "Wind Generators" — confirmed via live inspection in `CMS-BOOT-002` and reconfirmed live 2026-07-13). Under v1.1, all 9 demo slots map 1:1 to the client's 9 approved service titles — no items need to be set to Draft (v1.0's 7-into-9 mismatch, which needed 2 Draft slots, no longer applies). See `MIGRATION-REPORT-v1.1.md` and `IMPLEMENTATION-GUIDE.md`.
