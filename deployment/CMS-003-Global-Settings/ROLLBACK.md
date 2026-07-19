# CMS-003 — Rollback Procedure

This module is additive and low-risk by design — deploying it does not modify any existing page, template, or content (see `VERIFICATION.md`'s "No Elementor conflicts" section). Rolling it back is correspondingly simple. Confirm `BACKUP-001`'s baseline is still current before starting, per standing project policy.

## Remove the Options Page

1. wp-admin → **Custom Fields → Field Groups**.
2. Open "Global Settings", note its field group key (for reference), then **Move to Trash**.
3. If Code Snippets (Option A) was used for `php/options-page.php`: wp-admin → **Snippets**, find the `CMS-003 — Global Settings Options Page` snippet, and **Deactivate** it (deactivate, don't delete yet — see "Restore previous state" below for why).
4. If `functions.php` (Option B) was used: remove the `acf_add_options_page()` block added in Step 1 of `IMPLEMENTATION-GUIDE.md`.

Once the snippet is deactivated or the `functions.php` block removed, the "Global Settings" admin menu item disappears on next page load.

## Restore previous state

Because this package never modified any existing page, template, or footer content, "restoring previous state" only means confirming nothing else changed:

1. Confirm the live front end still renders identically to how it did before deployment (nothing in this package rewired any page to consume these fields — that's a separate, not-yet-scoped follow-up).
2. If the Step 7 test shortcode/snippet from `IMPLEMENTATION-GUIDE.md` was somehow left active, remove it now.
3. No database content outside the new Options Page's own option rows (`wp_options`, keyed by the field group's field names) and the new field group post itself was touched — there is nothing else to restore.

## Remove JSON

1. Delete the imported field group via **Custom Fields → Field Groups → Global Settings → Move to Trash → Delete Permanently** (Trash alone leaves it recoverable, which is fine if rollback might be temporary).
2. If the JSON was ever synced into `greenly-child/acf-json/` (per the alternative note in `IMPLEMENTATION-GUIDE.md` Step 4), delete `group_global_settings.json` from that folder too — otherwise ACF will silently re-sync the field group back in on next admin load.

## Remove PHP

1. Fully **delete** (not just deactivate) the Code Snippets created in Steps 1–2 of `IMPLEMENTATION-GUIDE.md`, once you're confident rollback is final rather than temporary.
2. If `functions.php` was used instead, remove both the Options Page registration block and the two helper functions (`iep_get_global_setting`, `iep_get_global_image_url`) — check nothing else in the theme has started calling them first (unlikely immediately after deployment, but worth a quick search before deleting if time has passed).

## When rollback is NOT the right move

If only one or two field values are wrong (e.g. a mistyped phone number), just correct the value on the **Global Settings** page directly — that's a content edit, not a rollback. Full rollback is for when the module itself needs to come out, not when its data needs correcting.
