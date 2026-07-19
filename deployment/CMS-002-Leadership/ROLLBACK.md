# CMS-002 — Leadership Module: Rollback

Each step is independently reversible. None of them touch the live Leadership page's existing design unless Step 6 of `IMPLEMENTATION-GUIDE.md` was explicitly done.

## Rolling back Step 1 (ACF field group)
Custom Fields → Field Groups → "Team Member Details" → Move to Trash. Any content entered into those fields is preserved on the `cspt-team-member` posts as post meta even after the field group is deleted (ACF fields are just post meta under the hood) — re-importing the same JSON later will re-expose the same data.

## Rolling back Step 2 (Code Snippet)
Snippets → find "CMS-002 — Team Member REST + Shortcode" → Deactivate (or delete). This immediately removes both the REST retrofit and the `[iep_team_grid]` shortcode. Any page using `[iep_team_grid]` will show the raw shortcode text instead of rendered content until either re-activated or the shortcode is removed from that page.

## Rolling back Step 3 (REST exposure)
Covered by deactivating the Code Snippet above — REST exposure was added by that snippet's `init` hook, so deactivating it reverts `cspt-team-member` to its original non-REST state.

## Rolling back Step 4 (content)
No rollback needed at the platform level — this is just data entered into fields. If specific field values need reverting, WordPress's normal post-revision history applies to `cspt-team-member` posts the same as any other post type.

## Rolling back Step 6 (if the live page was swapped)
If the Leadership page's hand-coded Directors/Team sections were replaced with `[iep_team_grid]`: Elementor keeps its own revision history (Edit with Elementor → History icon) — restore the pre-swap revision to bring back the original hand-coded layout exactly as it was.
