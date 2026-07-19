# CMS-008 — Testimonials Module: Rollback

## Rolling back Step 1 (ACF field group)
Custom Fields → Field Groups → "Testimonial Details" → Move to Trash. Content already entered is preserved as post meta on the `cspt-testimonial` posts even after the field group is deleted.

## Rolling back Step 2 (Code Snippet)
Snippets → find "CMS-008 — Testimonial CPT + Grid Shortcode" → Deactivate (or delete). If `cspt-testimonial` already existed before this package (the likely case, per `DECISIONS.md`), deactivating only removes the REST retrofit and the shortcode — the CPT itself and its posts remain exactly as they were before this package touched them. If it turned out the CPT didn't already exist and this snippet registered it fresh, deactivating makes it (and its posts) inaccessible via wp-admin/front-end until reactivated, same caveat as CMS-007.

## Rolling back Step 3 (REST exposure)
Covered by deactivating the Code Snippet above.

## Rolling back Step 4 (content)
No platform-level rollback needed — this is data entered into fields. WordPress's normal post-revision history applies to `cspt-testimonial` posts the same as any other post type.

## Rolling back Step 6 (if the live page was swapped)
If page 1062's hardcoded cards were replaced with `[iep_testimonial_grid]`: Elementor keeps its own revision history (Edit with Elementor → History icon) — restore the pre-swap revision.
