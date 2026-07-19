# CMS-003 — Implementation Guide

This deploys entirely through wp-admin. **No SFTP/file access is required** — both the PHP registration and the ACF field group can go in through the browser, using plugins already active on the site (Code Snippets, ACF Pro's own import screen). This sidesteps the SFTP blocker that's stopped every prior CMS module (`CMS-BOOT-001`, `CMS-002`).

## Step 1 — Register the Options Page

Two options, pick one:

**Option A (recommended): Code Snippets**
1. wp-admin → **Snippets → Add New**.
2. Title it `CMS-003 — Global Settings Options Page`.
3. Paste the contents of `php/options-page.php` (everything after the `<?php` line is fine to paste as-is — Code Snippets handles the opening tag).
4. Set it to run **Everywhere** (not admin-only — templates on the front end need `get_field(..., 'option')` to resolve).
5. Save and **Activate**.

**Option B: functions.php**
Append the contents of `php/options-page.php` (minus the opening `<?php`, since `functions.php` already has one) to `greenly-child/functions.php`. Requires file access.

## Step 2 — Register the helper functions

Same choice as Step 1 — a second Code Snippet (or append to the same one/`functions.php`) using `php/helper-functions.php`. Recommend a **separate** snippet from Step 1 so either can be deactivated independently if something needs isolating later.

## Step 3 — Confirm the Options Page appears

wp-admin left sidebar should now show a **Global Settings** menu item (gear icon), below Settings. If it doesn't appear, check the Code Snippet is Active and re-check Step 1 — nothing further in this guide will work until this shows up.

## Step 4 — Import the field group

1. wp-admin → **Custom Fields → Tools**.
2. Under **Import Field Groups**, choose `acf-json/group_global_settings.json` from this package.
3. Click **Import**.
4. Confirm a new field group **"Global Settings"** now appears in **Custom Fields → Field Groups**, with its location rule set to the `global-settings` options page.

*(Alternative: if this site's `acf-json/` local-JSON sync folder is ever wired up per `CMS-BOOT-001`'s recommendation, this file can instead be copied straight into `greenly-child/acf-json/` and ACF will pick it up automatically on next admin load — no manual import needed. Not required today; the Tools → Import path above works regardless.)*

## Step 5 — Open Global Settings and review the pre-filled values

Go to the new **Global Settings** menu item. Every field marked "Verified" in `README.md` should already show its real current value — this is intentional (the JSON ships with the live site's own content as its default). Fields marked "Not sourced"/"Placeholder" will be empty or hold the known-placeholder value from `README.md`.

**Do not blindly Save yet.** Review each field against `README.md`'s table first, especially:
- Contact Email / Contact Telephone — confirm whether the director's personal details should stay or be replaced with general company contact info.
- LinkedIn URL — confirm the real company page before replacing the placeholder.
- Primary/White Logo, Favicon — select the existing media library items called out in the field instructions (IDs 211, 1066, 1030) rather than uploading new ones.

## Step 6 — Save

Click **Save Global Settings** (or **Update**, depending on ACF Pro's rendered button label). This is the first write — everything before this step is inert.

## Step 7 — Confirm frontend retrieval

Add a temporary test anywhere a template can echo PHP (a Code Snippet shortcode is the safest no-file-access way):

```php
add_shortcode( 'iep_test_global_settings', function () {
	return iep_get_global_setting( 'company_name', 'NOT SET' );
} );
```

Drop `[iep_test_global_settings]` into a draft page and confirm it renders "Industrial Energy Pioneers Limited" (or whatever was saved in Step 6), not "NOT SET". Remove the shortcode and the test snippet once confirmed — this was only for verification, not part of the deployed package.

## Step 8 — Hand off to `VERIFICATION.md`

Run through the full checklist there before considering this module live.
