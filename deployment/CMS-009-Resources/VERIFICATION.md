# CMS-009 — Resources Module: Verification Checklist

## After Step 1 (ACF field group import)
- [ ] "Resource Details" field group appears under Custom Fields → Field Groups
- [ ] All 5 fields present: Category, File, Summary, Gated (requires email), Display Order
- [ ] Location rule shows it only applies to `cspt-resource` posts
- [ ] Category field's 3 choices match page 984's existing card copy exactly: "Guides & whitepapers", "Tools & calculators", "Funding briefings"

## After Step 2 (Code Snippet)
- [ ] Snippet shows as Active in Snippets list
- [ ] Confirm scope is "Run everywhere," not front-end-only (CMS-007 lesson — check this explicitly, don't assume)
- [ ] No PHP errors/warnings surfaced on any front-end page load

## After Step 3 (CPT REST check)
- [ ] `wp_get_post_types` lists `cspt-resource` with `rest_base: "resources-cpt"`
- [ ] Record which branch of the adaptive handling fired — fresh-register (expected) or retrofit (would mean a legacy type existed that the earlier REST-only check couldn't see)
- [ ] If retrofit fired, check for pre-existing published items before assuming a clean slate

## After Step 4 (smoke test)
- [ ] Test record renders correctly under its assigned category heading via `[iep_resource_grid]`
- [ ] Download link on the test record works and points at the uploaded test file
- [ ] Test record deleted afterward — confirm `wp_list_cpt_items` for `resources-cpt` shows zero items
- [ ] `[iep_resource_grid]` with zero records returns the empty-state HTML comment, not a broken visible block

## Icon fix (unrelated to the package, fixed live this session)
- [ ] `fa-file-alt` renders on the "Guides & whitepapers" card (was `fa-file-lines`, invisible)
- [ ] `fa-hand-holding-usd` renders on the "Funding briefings" card (was `fa-hand-holding-dollar`, invisible)
- [ ] `fa-calculator` on "Tools & calculators" unchanged (was already valid)
- [ ] Pending host cache purge before this is visible live — DB write already independently re-verified

## Frontend/Admin sanity
- [ ] Live Resources page (984) is unchanged — still shows "Coming soon" for all 3 categories, no `[iep_resource_grid]` swap has happened
- [ ] Editing a resource's fields in wp-admin works and saves correctly
- [ ] No other CPT, page, or module was touched by this package
