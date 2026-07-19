# CMS-004 — Rollback Procedure

Unlike `CMS-003`, this package **does modify existing page content** (removing the per-page hide-footer CSS and duplicate footer section from all 14 pages). Confirm a current backup exists (per standing project policy, `BACKUP-001`) before deploying, and treat that as your true safety net — the steps below undo the mechanism, but the cleanest restore for the 14 pages' content is a database/content restore from backup if anything goes wrong mid-cleanup.

## If something breaks mid-cleanup (Step 6 of IMPLEMENTATION-GUIDE.md)

Because the cleanup script processes one page at a time and requires an explicit `live` flag, a failure affects at most one page. For that page:
1. Restore its `_elementor_data` from the pre-CMS-004 backup (the safest path — a partial JSON edit is not something to hand-repair).
2. Do not proceed to the next page ID until the affected one is confirmed restored and rendering exactly as before.

## Full rollback (undo the whole module)

### Remove footer.php
1. Restore whatever `footer.php` existed at `greenly-child/footer.php` before Step 4 (you backed it up before overwriting, per that step's instruction). If none existed, simply delete the file — the parent theme's `footer.php` (if any) or WordPress's default footer handling takes over.
2. Requires file/SFTP access, same as deployment did.

### Restore the 14 pages
1. For each of the 14 pages, restore its `_elementor_data` from the pre-CMS-004 backup — this brings back both the original hide-footer CSS and the original duplicated footer section, exactly as it was.
2. Verify each page renders identically to how it did before this module was ever deployed.

### Remove the menus
1. Appearance → Menus → delete "Footer — Services," "Footer — Industries," and "Footer — Legal Links."
2. This is safe regardless of whether footer.php is still active — a missing menu location just renders nothing for that `wp_nav_menu()` call, it doesn't error.

### Remove the Code Snippets
1. Delete the `CMS-004 — Footer Helper Functions` snippet.
2. Confirm the one-time cleanup snippet was already deleted per Step 7 of `IMPLEMENTATION-GUIDE.md` — if it's somehow still active, delete it now too.

## Partial rollback: keep footer.php, revert one page only

If 13 pages are fine and only one needs to go back to its old duplicated footer for some reason, restore just that page's `_elementor_data` from backup and leave everything else deployed — `footer.php` and the menus don't need to change for a single-page revert; that page's old hide-footer CSS will simply hide the new footer on that page again, same mechanism as before.
