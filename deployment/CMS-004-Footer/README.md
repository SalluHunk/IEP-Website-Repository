# CMS-004 — Footer Consolidation: Deployment Package

**Status:** Ready for manual deployment. Nothing in this package has been applied to WordPress and the live footer has not been changed.
**Generated:** 2026-07-12
**Sources used:** `PDC-001`, `CMS-001-Production-Migration-Strategy.md`, `CMS-003-Global-Settings/` (this package's hard dependency), `CRN-001-Client-Review-Notes.md`, `KNOWLEDGE-SOURCES-001.md`, and the current live footer as captured directly from Services (970), Leadership (972), and Case Studies (978) during `CMS-BOOT-002`.

## What this is

`CMS-BOOT-002` found that the footer is duplicated: every one of the 14 2026-redesign pages hides the theme's real footer with injected CSS and hand-rebuilds an entire separate footer inside its own Elementor content. `CMS-001` sequenced fixing this as module 2. `CMS-003` built the data source (Global Settings). This package is the other half — a single canonical `footer.php` that reads from that data source, plus everything needed to retire the 14 duplicates.

## Package contents

```
CMS-004-Footer/
├── README.md                   — this file
├── IMPLEMENTATION-GUIDE.md      — step-by-step deployment, in the required order
├── VERIFICATION.md              — post-deployment checklist
├── ROLLBACK.md                  — how to undo this package
├── CHANGELOG.md                 — dated log of what this package changes and why
├── repository-update.md         — what this introduces, dependencies, next module
└── php/
    ├── footer.php                          — the canonical footer (theme file — needs SFTP)
    ├── footer-helper-functions.php         — nav-menu registration + link walker (Code Snippet)
    └── one-time-remove-duplicate-footers.php — temporary cleanup tool, delete after use
```

## The one thing you must understand before deploying

**Deploying `footer.php` alone changes nothing visible.** Its wrapper intentionally reuses the exact CSS classes (`.site-footer`, `#colophon`, `.footer-wrap`) that the per-page injected CSS already hides on all 14 redesigned pages. That's deliberate — it means the new footer is inert-by-default until the old per-page hide-CSS and duplicate footer section are removed, which is what `php/one-time-remove-duplicate-footers.php` does, one page at a time. Deploy in the order `IMPLEMENTATION-GUIDE.md` specifies, not in file-list order.

## Hard dependency

This package **requires `CMS-003` to be deployed and its Global Settings values reviewed and saved first.** `footer.php` calls `iep_get_global_setting()`/`iep_get_global_image_url()` from CMS-003's helper functions — if those aren't active, `footer.php` will hit undefined-function fatals. Fallback values are hardcoded in `footer.php` for every field it uses, matching today's real live values, so even an unreviewed/default CMS-003 deployment won't visibly break anything — but the functions themselves must exist.

## What's reused vs. newly created for footer navigation

Two existing menus were checked before deciding to build new ones: **"Our Services" (ID 29)** holds 5 links to `cspt-service` Envato demo items ("Solar As A Service," "Solar PV Systems"...) — unrelated leftover content, not reusable. **"Company" (ID 30)** holds 5 dead `#` placeholder links ("About Us," "Press & Blog"...) — also not reusable. Per `IMPLEMENTATION-GUIDE.md`, three **new** menus are created instead, populated with the real content already live in today's footer — this is "extend before rebuild" applied honestly: there was nothing usable to extend.
