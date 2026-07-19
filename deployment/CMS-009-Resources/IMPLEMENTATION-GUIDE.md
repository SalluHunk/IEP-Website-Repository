# CMS-009 — Resources Module: Implementation Guide

All steps below are wp-admin actions. None require SFTP, SSH, or file-system access.

**There is no content migration table in this guide** — unlike CMS-002/006/007/008, no real resource content exists to migrate. This guide gets the platform ready to receive content; populating it with real guides/tools/funding material is a future step once the client provides that material.

## Step 1 — Import the ACF field group

1. wp-admin → **Custom Fields → Tools**
2. Under "Import Field Groups", choose `acf-json/group_resource_fields.json`
3. Click **Import** — creates a field group called "Resource Details" attached to `cspt-resource`
4. Confirm it appears under **Custom Fields → Field Groups**

## Step 2 — Install the Code Snippet

1. wp-admin → **Snippets → Add New**
2. Title: `CMS-009 — Resource CPT + Grid Shortcode`
3. Paste the full contents of `php/resource-helper-functions.php`
4. Leave "Only run on specific pages" unset — **must run everywhere**, including wp-admin (CMS-007's lesson — a prior module's admin menu item didn't appear until this was corrected)
5. **Activate**

## Step 3 — Verify the CPT is REST-visible

Ask whoever has MCP/tooling access to check: `wp_get_post_types` should list `cspt-resource` with `rest_base: "resources-cpt"`. Also check `wp_list_cpt_items` with that `rest_base` — if any pre-existing items appear (a legacy type this session's REST-only check couldn't see), note them before proceeding; this package's field model assumes a clean slate.

## Step 4 — Smoke-test with one throwaway record, then delete it

Since there's no real content to populate, create **one clearly-marked test record** to confirm the whole chain works end-to-end before calling this "deployed":
1. Create a `cspt-resource` post, title `TEST — delete me`.
2. Set Category to any of the 3 options, Summary to any short string, upload any small file as a smoke test, leave Gated off.
3. Add a Shortcode widget somewhere out of the way with `[iep_resource_grid]` and confirm the test card renders correctly under the right category heading, with a working download link.
4. **Delete the test record** (Trash, not draft — it's not real content, no reason to keep it around).
5. Re-render `[iep_resource_grid]` and confirm it returns the empty-state HTML comment (`<!-- iep_resource_grid: no cspt-resource records found -->`), not a broken/empty visible block.

## Step 5 — Stop here until real content exists

There is no Step 5 content-population step, unlike every prior CMS module in this program. When the client provides real guides, whitepapers, calculators, or funding-briefing material:
1. Upload each file to the Media Library.
2. Create one `cspt-resource` post per resource, set Category/Summary/File/Display Order (and Gated, once the MC4WP gating decision is actually made — see `DECISIONS.md`).
3. Re-run the verification checklist in `VERIFICATION.md`.
4. Only then consider swapping page 984's "Coming soon" cards for `[iep_resource_grid]` (still optional, still your call) — until real content exists, leave the current honest "Coming soon" cards in place.

## A note on the Grants page (648) and main navigation

Two adjacent items were found but deliberately **not** acted on by this package — see `DECISIONS.md` for the full reasoning:
- The "Grants" page (648) has real grant-funding content but is dated 2025-03 with a stale application deadline, and isn't linked from the main nav. It's a plausible future seed for the "Funding briefings" category, but the figures need the client to confirm they're still current before anything is published from it.
- The Resources page (984) itself isn't in the main navigation menu — possibly intentional (soft-launched ahead of content), possibly an oversight. Not changed by this package.
