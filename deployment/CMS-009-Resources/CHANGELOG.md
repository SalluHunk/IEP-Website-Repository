# CMS-009 — Resources Module: Changelog

## v1.0 (2026-07-19)
- Initial deployment package. Builds a `cspt-resource` CPT, ACF field model, authenticated write endpoint, and `[iep_resource_grid]` shortcode — **infrastructure only, zero real resources populated**, since none exist anywhere in the repository's reviewed sources (checked exhaustively — live page 984, live page 648, every governance document — see `DECISIONS.md`).
- Presented the "no real content exists" finding directly to Mission Control as a fork (build infrastructure only / defer the Work Package / investigate Grants first / hand over real content) rather than guessing at a path forward. Mission Control chose **build infrastructure only**.
- Grid/wall display only, no individual detail pages — decided directly (not asked, unlike WP-05/06) since a downloadable resource has no narrative content to carry a dedicated page.
- ACF field group: Category (select, 3 fixed options matching page 984's existing "Coming soon" card copy verbatim), File, Summary, Gated (flag only, no enforcement), Display Order (5 fields).
- PHP Code Snippet: adaptive CPT handling (same proven pattern as CMS-008), authenticated `/iep-cms/v1/resource/{id}` endpoint + `/unpublish`, `[iep_resource_grid]` shortcode that renders gated resources without a working download link (enforcement is out of scope — see `DECISIONS.md`).
- Two real findings flagged, not acted on: the "Grants" page (648) as a possible future seed for "Funding briefings," and the Resources page's own absence from the main navigation.
- **Also fixed live this session, not part of the package**: two broken Font Awesome icon classes on page 984 (`fa-file-lines`, `fa-hand-holding-dollar` — both FA6-only names, 4th instance of this exact bug on this site), replaced with verified FA5-valid equivalents (`fa-file-alt`, `fa-hand-holding-usd`). DB write independently re-verified; live-visual confirmation pending the usual host cache purge.
- Not yet applied to WordPress — package phase only.
