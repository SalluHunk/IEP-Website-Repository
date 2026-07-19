# CMS-005 — Rollback Procedure

This module edits existing `cspt-service` items' field content and the live Services page's Elementor content. Confirm `BACKUP-001` is current before deploying, same standing policy as every prior module.

## If Step 5 (Services page edit) needs undoing

The safest path: before removing the original icon-box row in Step 5, keep a copy of its Elementor JSON (or simply don't delete it — disable/hide it and add the shortcode alongside, confirm the shortcode first, only then remove the original). If it's already been removed and needs restoring, revert page 970's `_elementor_data` from the pre-CMS-005 backup.

## Remove the field data

1. For each of the 9 migrated `cspt-service` items (v1.1 — all 9 slots used, none drafted), the field values can simply be cleared via the normal edit screen — this doesn't require "rollback" tooling, it's a normal content edit.
2. If full reversion to demo content is genuinely wanted (unlikely, but documented for completeness): restore the 9 items' content from the pre-CMS-005 backup.

## Remove the field group

1. Custom Fields → Field Groups → "Service Details" → Move to Trash → Delete Permanently.
2. If the JSON was ever synced into `greenly-child/acf-json/`, delete `group_service_fields.json` from there too, or ACF will re-sync it back in.

## Remove the PHP

1. Delete the `CMS-005 — Services Helper Functions` Code Snippet. This immediately breaks the `[iep_services_grid]` shortcode — if Step 5 is still using it on the live page, the page will show nothing where the shortcode was until either the snippet is restored or the page content is reverted first. **Revert the page content before deleting this snippet, not after.**
2. If `recommended-templates/` files were ever placed in the theme (Step 6), remove `archive-cspt-service.php` and `single-cspt-service.php` from `greenly-child/`.

## Order matters

Unlike `CMS-003` (fully additive, any removal order is safe) and largely like `CMS-004`, this module has a live-page dependency on its own PHP snippet. Always revert the Services page content (Step 5) **before** deleting the helper-functions snippet, to avoid a visibly broken page in between.
