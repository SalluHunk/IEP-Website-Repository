# CMS-006 — Case Studies Module: Rollback

Each step is independently reversible. None of them touch the live Case Studies page's existing design unless Step 9 of `IMPLEMENTATION-GUIDE.md` was explicitly done.

## Rolling back Step 1 (ACF field group)
Custom Fields → Field Groups → "Case Study Details" → Move to Trash. Any content entered into those fields is preserved on the `cspt-portfolio` posts as post meta even after the field group is deleted (ACF fields are just post meta under the hood) — re-importing the same JSON later will re-expose the same data.

## Rolling back Step 2 (Code Snippet)
Snippets → find "CMS-006 — Case Study REST + Shortcodes" → Deactivate (or delete). This immediately removes the REST retrofit (both CPT and taxonomy), the authenticated endpoint, and both shortcodes. Any page using `[iep_case_study_grid]` or post using `[iep_case_study_single]` will show the raw shortcode text instead of rendered content until either re-activated or the shortcode is removed.

## Rolling back Step 3 (REST exposure)
Covered by deactivating the Code Snippet above — REST exposure was added by that snippet's `init` hooks, so deactivating it reverts `cspt-portfolio` and `portfolio-category` to their original non-REST state.

## Rolling back Steps 4–6 (content, slugs, single-page redirect)
No platform-level rollback needed — this is just data entered into fields, plus a slug rename and a `post_content` change. WordPress's normal post-revision history applies to `cspt-portfolio` posts the same as any other post type; a slug can be renamed back to its original demo value directly in the post editor if needed.

## Rolling back Step 7 (surplus unpublish)
The 6 surplus demo posts were moved to `draft`, not deleted — re-publish them from wp-admin's Posts list (filtered to Case Studies / Portfolio, status: Draft) to restore them exactly as they were, Lorem Ipsum and all.

## Rolling back Step 9 (if the live page was swapped or links were added)
If page 978's hardcoded cards were replaced with `[iep_case_study_grid]`, or had "Read more" links added to the existing icon-box widgets: Elementor keeps its own revision history (Edit with Elementor → History icon) — restore the pre-change revision to bring back the original layout exactly as it was.
