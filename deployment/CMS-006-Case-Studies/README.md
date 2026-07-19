# CMS-006 — Case Studies Module: Deployment Package

**Status:** v1.0 — Ready for manual deployment. Nothing in this package has been applied to WordPress yet. Prepared under WCP-001 (Website Completion Program), Work Package 04.
**Generated:** 2026-07-18.
**Sources used:** `missions/WCP-001-Progress-Register.md` (WP-04 brief and Blocker A precedent), the live Case Studies page (post 978, read directly this session — contains both the 6 approved summary cards *and* its own developer note naming the target CPT), the live `/portfolio/` archive and one single post (read via browser, not REST — the CPT has no REST route yet), `New Website Proposed Content AH ver2 2026 06 09.docx` §2 "ANONYMISED CASE STUDIES" (Primary Source, Verified — Challenge/Solution/Results/Commercial Impact narrative for all 6 real projects), `CMS-002-Leadership/` (package format and REST-retrofit/authenticated-endpoint precedent).

## What this is

Converts the existing `cspt-portfolio` CPT — Greenly theme's built-in Portfolio type, currently live at `/portfolio/` with 12 Envato demo entries (solar panels, wind projects, Lorem Ipsum) totally unrelated to IEP's work — into the CMS-driven Case Studies module. **No new CPT is registered.** This isn't a judgment call made fresh this session: the live Case Studies page (978) already contains its own embedded developer note — *"Individual case-study detail pages to be built as Greenly portfolio (cspt-portfolio) entries"* — so the target CPT was decided before this package existed; this package just acts on it.

## Why this exists: same Blocker A pattern as CMS-002

`cspt-portfolio` has no REST route (confirmed this session — `wp_get_post_types` doesn't list it), same original blocker as `cspt-team-member` before CMS-002. No SFTP path exists for this engagement (see `missions/WCP-001-Progress-Register.md`, Blocker A — GoDaddy Managed WordPress, single FTP account, password unrecoverable, no SSH). This package uses the exact same proven workaround: a Code Snippet (wp-admin, no file access) retrofits `show_in_rest`, plus an authenticated ACF read/write endpoint (same `meta`-vs-`acf` REST key mismatch CMS-002 diagnosed applies here too — reused, not re-discovered).

## Package contents

```
CMS-006-Case-Studies/
├── README.md
├── IMPLEMENTATION-GUIDE.md      — deployment steps + full 6-case-study content migration table
├── VERIFICATION.md
├── ROLLBACK.md
├── CHANGELOG.md
├── DECISIONS.md                 — every judgment call, with reasoning
├── repository-update.md
├── acf-json/
│   └── group_case_study_fields.json
└── php/
    └── case-study-helper-functions.php   — REST retrofit (CPT + taxonomy) + authenticated endpoint + 2 shortcodes
```

## Read `DECISIONS.md` before deploying

Three decisions worth knowing before you start: (1) **no Client or Address fields** — the content source document explicitly labels these "ANONYMISED CASE STUDIES," by design, not an unresolved gap; (2) **icon, not photo** — the live Case Studies page already represents each project with a Font Awesome icon rather than a photo, and no real project photography exists (imagery is an open CRN-001 decision), so this package keeps the icon pattern rather than reusing the demo posts' mismatched stock solar-panel images; (3) **12 demo posts exist, only 6 real case studies exist** — 6 get migrated to real content, 6 get moved to draft (not deleted) as surplus.

## The practical path to real value, without SFTP

Same pattern as `CMS-002`, `CMS-004`, `CMS-005`: one Code Snippet (REST retrofit + authenticated endpoint + shortcodes) installable through wp-admin, plus one ACF field group JSON importable through **Custom Fields → Tools → Import Field Groups**. No file access needed for either step.

## What's being replaced

The live Case Studies page (978) is not touched by this package — its 6 hardcoded Elementor icon-box cards already carry the correct, approved summary copy and stay exactly as they are. This package builds the CMS layer *underneath* — real ACF-backed case-study posts with full Challenge/Solution/Results detail, reachable at their own `/portfolio/{slug}/` URLs — so future edits don't require another direct-database Elementor dive, and so the "Read more" style detail pages the demo template already implies can go live with real content instead of Lorem Ipsum. Swapping page 978's cards for `[iep_case_study_grid]` is optional, same as `[iep_team_grid]` was for Leadership — see `IMPLEMENTATION-GUIDE.md` Step 6.
