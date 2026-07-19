# CMS-007 — Industries Module: Rollback

## Rolling back Step 1 (ACF field group)
Custom Fields → Field Groups → "Industry Sector Details" → Move to Trash. Content already entered is preserved as post meta on the `cspt-industry-sector` posts even after the field group is deleted.

## Rolling back Step 2 (Code Snippet)
Snippets → find "CMS-007 — Industry Sector CPT + Shortcodes" → Deactivate (or delete). **Unlike CMS-002/CMS-006, this immediately makes the CPT itself disappear** (it was registered fresh by this snippet, not retrofitted onto an existing type) — the 8 posts and their content remain in the database (WordPress doesn't delete data when a CPT is unregistered) but become inaccessible via wp-admin or the front end until the snippet is reactivated.

## Rolling back Step 3 (CPT registration)
Covered by deactivating the Code Snippet above.

## Rolling back Step 4 (content)
No platform-level rollback needed — this is data entered into fields. WordPress's normal post-revision history applies to `cspt-industry-sector` posts the same as any other post type.

## Rolling back Step 6 (if the live page was swapped)
If page 971's hardcoded cards were replaced with `[iep_industry_grid]`: Elementor keeps its own revision history (Edit with Elementor → History icon) — restore the pre-swap revision.

## Rolling back the icon fixes applied directly this session (not part of this package)
Page 971's `_elementor_data` had 3 icon values changed live (`fa-droplet`→`fa-tint`, `fa-magnifying-glass`→`fa-search`, `fa-chart-simple`→`fa-chart-line`). Elementor's own revision history on page 971 covers this the same way as any other direct edit — restore a pre-fix revision if needed, though there's no reason to want the broken icons back.
