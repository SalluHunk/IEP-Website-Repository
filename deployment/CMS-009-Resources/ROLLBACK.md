# CMS-009 — Resources Module: Rollback

## Rolling back Step 1 (ACF field group)
Custom Fields → Field Groups → "Resource Details" → Move to Trash. Since no real content is expected on any `cspt-resource` post at deployment time, there's nothing meaningful to lose — unlike prior modules, this rollback has no real-data-preservation concern.

## Rolling back Step 2 (Code Snippet)
Snippets → find "CMS-009 — Resource CPT + Grid Shortcode" → Deactivate (or delete). `wp_get_post_types` should have recorded which branch of the adaptive CPT handling fired (see `VERIFICATION.md`) — if it registered `cspt-resource` fresh (the expected case, since no legacy type was found), deactivating the snippet makes the CPT and any posts on it inaccessible via wp-admin/REST until reactivated, same caveat as CMS-007/008's fresh-register branch. If it turned out to retrofit an existing type instead, deactivating only removes the REST exposure and shortcode, leaving the underlying type/posts untouched.

## Rolling back Step 3 (REST exposure)
Covered by deactivating the Code Snippet above.

## Rolling back Step 4 (smoke test)
The test record should already be deleted per Step 4's own instructions. If it wasn't, delete it now (Trash) — it was never real content.

## Rolling back the icon fix (984)
Page 984's Elementor edit history (Edit with Elementor → History icon) has a revision immediately before the icon-class edit — restore that revision if the fix needs undoing, though there's no reason to: the prior state was two invisible icons, not a working alternative.

## If content is populated later and needs rolling back
Standard WordPress post-revision history applies to `cspt-resource` posts the same as any other post type — no CMS-009-specific rollback mechanism is needed for content-level changes.
