# CMS-003 — Repository Update

## What this package introduces

A deployable ACF Pro Options Page ("Global Settings") holding Company Information, Contact Information, Branding Assets, Calls to Action, and Footer Content — the `CMS-001` Global Settings module, generated as a ready-to-deploy package rather than executed directly (this package makes no WordPress changes itself; a human deploys it via `IMPLEMENTATION-GUIDE.md`).

This is the first CMS-001 module delivered as a **deployment package** rather than attempted as a live MCP-session execution. `CMS-002` (Leadership) attempted live execution and was fully blocked because `cspt-team-member` has no REST route (`CMS-002-Leadership-Module-Report.md`). This package sidesteps that specific blocker for Global Settings only, because ACF Options Pages don't need a custom post type's REST route at all, and because Code Snippets — already active on the site — can register the required PHP without SFTP access. It does not unblock CMS-002 or any other "extend existing CPT" module; those remain wp-admin/SFTP-only, as recorded in `CMS-002-Leadership-Module-Report.md`.

## Dependencies

- **ACF Pro active** — confirmed by `CMS-BOOT-001`. This package will not function on free ACF (Options Pages are Pro-only).
- **Code Snippets plugin active** — confirmed in the site's plugin list (`CMS-BOOT-001`, `BACKUP-001`). Recommended deployment path for both PHP files.
- **`BACKUP-001` verified** — per standing project policy, no structural WordPress change (and registering an Options Page + importing a field group counts as one) should proceed without a confirmed backup. `BACKUP-001` was user-confirmed complete on 2026-07-12.
- **Client input still needed on:** Company Registration Number, real LinkedIn company page, Default Social Share Image, Global CTA Text, Newsletter Text — all deliberately left unpopulated in this package rather than guessed (see `README.md`).

## What this package does NOT do

- It does not rewire any existing page's footer to actually *use* these new fields — Services, Leadership, and Case Studies still render their own hardcoded footer copy after this package is deployed. Wiring pages to consume Global Settings (replacing the duplicated footer sections `CMS-BOOT-002` found) is separate follow-up work, not included here.
- It does not touch the Leadership module — that remains blocked per `CMS-002-Leadership-Module-Report.md`, independent of this package.
- It does not create any CPT, per the mission's Repository Rules.

## Next recommended module

Per `CMS-001`'s sequencing (Leadership → Global Settings → Services → Downloads → Testimonials → Case Studies), Global Settings was module 2 of 6. With Leadership blocked (`CMS-002`) and Global Settings now packaged (`CMS-003`), the two live options are:

1. **Wire the footer to Global Settings** — the natural completion of this module: update the Services/Leadership/Case Studies footer sections to call `iep_get_global_setting()`/`iep_get_global_image_url()` instead of their hardcoded content. This is achievable via Elementor page-JSON edits (no SFTP needed, since these are Page post type items and ARE REST-exposed) plus the helper functions this package already ships — worth scoping as CMS-004 rather than assuming it's automatic.
2. **Services module as a deployment package**, following this same pattern (package-and-hand-off rather than live execution) — since `cspt-service` has the same no-REST-route blocker Leadership hit, a packaged approach only helps for the parts that don't require writing to that CPT (e.g. a Services *page* template update could still be packaged; populating the CPT itself still needs a human in wp-admin, same as Leadership).

Recommend option 1 first — it's the only next step with no open platform blocker, and it's the piece that actually delivers this module's real value (a single-sourced footer) rather than leaving Global Settings deployed-but-unused.
